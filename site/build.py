#!/usr/bin/env python3
"""Génère les pages de blog du site statique.

Deux sources, un seul rendu :
  1. les articles publiés sur le WordPress PostPilot (API REST publique) ;
  2. les articles rédigés en markdown dans ../articles/.

Sortie : blog/index.html, blog/<slug>/index.html, et la grille d'articles
de la page d'accueil (entre les marqueurs <!-- posts:start|end -->).

    python3 site/build.py [--offline]
"""

from __future__ import annotations

import argparse
import html
import json
import re
import sys
import urllib.request
from dataclasses import dataclass, field
from datetime import datetime
from pathlib import Path

ROOT = Path(__file__).resolve().parent
ARTICLES_DIR = ROOT.parent / "articles"
CACHE = ROOT / ".posts-cache.json"

WP_ENDPOINT = (
    "https://public-api.wordpress.com/wp/v2/sites/hypnoseangers3.wordpress.com/posts"
    "?per_page=20&_fields=id,slug,date,title,excerpt,content,categories"
)
WP_CATEGORIES = (
    "https://public-api.wordpress.com/wp/v2/sites/hypnoseangers3.wordpress.com/categories"
    "?per_page=50&_fields=id,name"
)
SKIP_SLUGS = {"hello-world"}

# Rubrique affichée par article. Le WordPress de démonstration range tout
# dans « Uncategorized » ; la rubrique éditoriale est décidée ici.
CATEGORIES = {
    "tarif-seance-hypnose-angers": "Tarifs",
    "avis-hypnotherapeute-angers": "Avis",
    "mental-qui-semballe-au-coucher": "Sommeil",
    "arreter-de-fumer-sans-volonte": "Tabac",
    "hypersensible-regler-le-filtre": "Hypersensibilité",
}
DEFAULT_CATEGORY = "Le cabinet"

SITE_URL = "https://hypnose-angers-illustre.vercel.app"
WORDS_PER_MINUTE = 200

# Visuel à la une par slug : fichier dans assets/img/ + texte alternatif.
FEATURED = {
    "mental-qui-semballe-au-coucher": (
        "blog-sommeil",
        "Lit défait au petit matin, lumière filtrée par un rideau",
    ),
    "arreter-de-fumer-sans-volonte": (
        "blog-tabac",
        "Cendrier et verre d'eau sur une table, feuille verte posée en travers",
    ),
    "hypersensible-regler-le-filtre": (
        "blog-hypersensibilite",
        "Voile translucide effleurant le sable, teintes sable et sauge",
    ),
    "tarif-seance-hypnose-angers": (
        "blog-tarif",
        "Fauteuil de consultation près d'une fenêtre, lumière douce de fin de journée",
    ),
    "avis-hypnotherapeute-angers": (
        "blog-avis",
        "Carnet ouvert et stylo posés sur une nappe de lin, verre d'eau et vase en terre cuite",
    ),
}

MONTHS = (
    "janvier février mars avril mai juin juillet "
    "août septembre octobre novembre décembre"
).split()


@dataclass
class Post:
    slug: str
    title: str
    date: datetime
    excerpt: str
    body_html: str
    category: str = "Hypnose"
    source: str = "wordpress"
    meta_description: str = ""
    extra_head: str = ""
    keywords: list[str] = field(default_factory=list)

    @property
    def url(self) -> str:
        return f"/blog/{self.slug}/"

    @property
    def date_fr(self) -> str:
        return f"{self.date.day} {MONTHS[self.date.month - 1]} {self.date.year}"

    @property
    def reading_time(self) -> int:
        words = len(re.sub(r"<[^>]+>", " ", self.body_html).split())
        return max(1, round(words / WORDS_PER_MINUTE))


# --- Markdown -------------------------------------------------------------

INLINE_RULES = (
    (re.compile(r"`([^`]+)`"), r"<code>\1</code>"),
    (re.compile(r"\*\*([^*]+)\*\*"), r"<strong>\1</strong>"),
    (re.compile(r"\[([^\]]+)\]\(([^)]+)\)"), r'<a href="\2">\1</a>'),
)


def inline(text: str) -> str:
    out = html.escape(text, quote=False)
    for pattern, repl in INLINE_RULES:
        out = pattern.sub(repl, out)
    return out


def slugify(value: str) -> str:
    value = value.lower()
    for src, dst in (("àâä", "a"), ("éèêë", "e"), ("îï", "i"), ("ôö", "o"), ("ùûü", "u"), ("ç", "c")):
        for char in src:
            value = value.replace(char, dst)
    value = re.sub(r"[^a-z0-9]+", "-", value)
    return value.strip("-")


def split_row(line: str) -> list[str]:
    return [cell.strip() for cell in line.strip().strip("|").split("|")]


def markdown_to_html(lines: list[str]) -> str:
    """Sous-ensemble de markdown suffisant pour les articles du cabinet."""
    out: list[str] = []
    buffer: list[str] = []
    index = 0

    def flush() -> None:
        if buffer:
            out.append(f"<p>{inline(' '.join(buffer))}</p>")
            buffer.clear()

    while index < len(lines):
        line = lines[index].rstrip()

        if not line.strip():
            flush()
            index += 1
            continue

        heading = re.match(r"^(#{2,4})\s+(.*)$", line)
        if heading:
            flush()
            level = len(heading.group(1))
            text = heading.group(2)
            out.append(f'<h{level} id="{slugify(text)}">{inline(text)}</h{level}>')
            index += 1
            continue

        if line.startswith("> "):
            flush()
            quote = []
            while index < len(lines) and lines[index].startswith(">"):
                quote.append(lines[index].lstrip("> ").rstrip())
                index += 1
            out.append(f"<blockquote><p>{inline(' '.join(quote))}</p></blockquote>")
            continue

        if line.startswith("|"):
            flush()
            rows = []
            while index < len(lines) and lines[index].startswith("|"):
                rows.append(lines[index])
                index += 1
            head = split_row(rows[0])
            body = [split_row(r) for r in rows[2:]]
            thead = "".join(f"<th>{inline(c)}</th>" for c in head)
            tbody = "".join(
                "<tr>" + "".join(f"<td>{inline(c)}</td>" for c in row) + "</tr>" for row in body
            )
            out.append(f"<table><thead><tr>{thead}</tr></thead><tbody>{tbody}</tbody></table>")
            continue

        if re.match(r"^[-*]\s+", line):
            flush()
            items = []
            while index < len(lines) and re.match(r"^[-*]\s+", lines[index]):
                items.append(re.sub(r"^[-*]\s+", "", lines[index]).rstrip())
                index += 1
            out.append("<ul>" + "".join(f"<li>{inline(i)}</li>" for i in items) + "</ul>")
            continue

        if line.strip() == "---":
            flush()
            out.append("<hr>")
            index += 1
            continue

        buffer.append(line.strip())
        index += 1

    flush()
    return "\n".join(out)


# --- Sources --------------------------------------------------------------


def strip_tags(value: str) -> str:
    return html.unescape(re.sub(r"<[^>]+>", "", value)).strip()


def fetch_json(url: str):
    request = urllib.request.Request(url, headers={"User-Agent": "maxime-hypnose-build"})
    with urllib.request.urlopen(request, timeout=20) as response:
        return json.load(response)


def load_wordpress(offline: bool) -> list[Post]:
    if offline:
        if not CACHE.exists():
            print("cache absent, aucun article WordPress", file=sys.stderr)
            return []
        raw = json.loads(CACHE.read_text())
    else:
        raw = {
            "posts": fetch_json(WP_ENDPOINT),
            "categories": fetch_json(WP_CATEGORIES),
        }
        CACHE.write_text(json.dumps(raw, ensure_ascii=False))

    names = {c["id"]: c["name"] for c in raw["categories"]}
    posts = []

    for item in raw["posts"]:
        if item["slug"] in SKIP_SLUGS:
            continue
        category = names.get(item["categories"][0], "") if item["categories"] else ""
        if category.lower() in {"", "uncategorized", "non classé"}:
            category = CATEGORIES.get(item["slug"], DEFAULT_CATEGORY)
        excerpt = strip_tags(item["excerpt"]["rendered"])
        posts.append(
            Post(
                slug=item["slug"],
                title=strip_tags(item["title"]["rendered"]),
                date=datetime.fromisoformat(item["date"]),
                excerpt=excerpt,
                body_html=remap_links(item["content"]["rendered"]),
                category=category,
                source="wordpress",
                meta_description=excerpt[:158],
            )
        )
    return posts


# Notes de rédaction : présentes dans le markdown, jamais publiées.
EDITORIAL_MARK = re.compile(r"`?\[À (?:CONFIRMER|REMPLIR)[^\]]*\]`?", re.IGNORECASE)

# Les mêmes notes, une fois passées par le rendu markdown : un marqueur peut
# tenir sur plusieurs lignes et devenir un <code> au milieu d'un paragraphe.
RENDERED_MARK = re.compile(r"<code>\[À (?:CONFIRMER|REMPLIR).*?\]</code>", re.S | re.I)
EMPTY_SECTION = re.compile(r"<h([234])[^>]*>.*?</h\1>\s*(?=<h[234]|<hr>|$)", re.S)


# Les articles sont rédigés pour l'arborescence WordPress cible ; sur la
# maquette statique, ces URL pointent vers les sections de la page d'accueil.
LINK_MAP = {
    "/quest-ce-que-lhypnose/": "/#approche",
    "/contact/": "/#contact",
    "/tarifs-et-informations-cabinet-hypnose-angers/": "/#tarifs",
    "/arreter-de-fumer-avec-lhypnose/": "/blog/arreter-de-fumer-sans-volonte/",
    "/tarif-seance-hypnose-angers/": "/blog/tarif-seance-hypnose-angers/",
    "/avis-hypnotherapeute-angers/": "/blog/avis-hypnotherapeute-angers/",
}


def remap_links(body_html: str) -> str:
    for source, target in LINK_MAP.items():
        body_html = body_html.replace(f'href="{source}"', f'href="{target}"')
    return body_html


def strip_editorial(body_html: str) -> str:
    """Retire les notes de rédaction et les titres restés sans contenu."""
    body_html = RENDERED_MARK.sub("", body_html)
    body_html = re.sub(r"<p>\s*</p>", "", body_html)
    previous = None
    while previous != body_html:
        previous = body_html
        body_html = EMPTY_SECTION.sub("", body_html)
    return re.sub(r"\n{3,}", "\n\n", body_html).strip()


def load_markdown() -> list[Post]:
    posts = []

    for path in sorted(ARTICLES_DIR.glob("*.md")):
        raw = path.read_text().splitlines()

        title = next(l[2:].strip() for l in raw if l.startswith("# "))

        # Les métadonnées SEO tiennent parfois sur plusieurs lignes.
        meta: dict[str, str] = {}
        current = None
        for line in raw[:22]:
            found = re.match(r"^\*\*(.+?)\s*:\*\*\s*(.*)$", line)
            if found:
                current = found.group(1).lower()
                meta[current] = found.group(2).strip().strip("`")
            elif current and line.strip() and not line.startswith(("#", ">", "-")):
                meta[current] = f"{meta[current]} {line.strip()}".strip()
            else:
                current = None

        slug = meta.get("slug proposé", "/" + slugify(title) + "/").strip("/")
        description = next(
            (v for k, v in meta.items() if k.startswith("meta description")), ""
        )

        # Corps : on retire le titre, le bloc de validation interne,
        # les métadonnées SEO et tout ce qui suit « Bloc technique ».
        body: list[str] = []
        schema_json = ""
        skipping_quote = False
        index = 0

        while index < len(raw):
            line = raw[index]

            if line.startswith("# "):
                index += 1
                continue
            if line.startswith(">"):
                skipping_quote = True
                index += 1
                continue
            if skipping_quote and not line.strip():
                skipping_quote = False
                index += 1
                continue
            if re.match(r"^\*\*(Slug proposé|Mot-clé cible|Mots-clés secondaires|Meta description)", line):
                index += 1
                continue
            if line.startswith("## Bloc technique"):
                block = "\n".join(raw[index:])
                fenced = re.search(r"```json\n(.*?)\n```", block, re.S)
                if fenced:
                    schema_json = fenced.group(1)
                break

            body.append(line)
            index += 1

        # Retire les marqueurs éditoriaux, puis les paragraphes devenus vides.
        cleaned = [EDITORIAL_MARK.sub("", l).rstrip() for l in body]
        cleaned = [l for l in cleaned if l.strip() not in {".", ":"}]
        while cleaned and not cleaned[0].strip():
            cleaned.pop(0)

        body_html = remap_links(strip_editorial(markdown_to_html(cleaned)))

        extra_head = ""
        if schema_json:
            compact = json.dumps(json.loads(schema_json), ensure_ascii=False, separators=(",", ":"))
            extra_head = f'<script type="application/ld+json">{compact}</script>'

        posts.append(
            Post(
                slug=slug,
                title=title.split(" : ")[0] if len(title) > 70 else title,
                date=datetime.fromtimestamp(path.stat().st_mtime),
                excerpt=description,
                body_html=body_html,
                category=CATEGORIES.get(slug, DEFAULT_CATEGORY),
                source="markdown",
                meta_description=description,
                extra_head=extra_head,
                keywords=[k.strip() for k in meta.get("mots-clés secondaires", "").split(",") if k.strip()],
            )
        )

    return posts


# --- Rendu ----------------------------------------------------------------


def chrome(index_html: str) -> tuple[str, str]:
    """Récupère l'en-tête et le pied de page de la page d'accueil."""
    header = re.search(r'<header class="site-header".*?</header>', index_html, re.S).group(0)
    footer = re.search(r'<footer class="site-footer".*?</footer>', index_html, re.S).group(0)
    mobile = re.search(r'<div class="mobile-cta">.*?</div>', index_html, re.S).group(0)
    # Sur une sous-page, les ancres pointent vers la page d'accueil.
    header = header.replace('href="#', 'href="/#').replace('href="/#"', 'href="/"')
    # L'élément actif suit la page : sur le blog, ce n'est plus « Accueil ».
    header = header.replace('<li class="current-menu-item">', "<li>")
    header = header.replace(
        '<li><a href="/blog/">Blog</a></li>',
        '<li class="current-menu-item"><a href="/blog/">Blog</a></li>',
    )
    footer = footer.replace('href="#', 'href="/#')
    mobile = mobile.replace('href="#', 'href="/#')
    return header, footer + "\n" + mobile


def page(title: str, description: str, canonical: str, body: str, head: str = "") -> str:
    return f"""<!doctype html>
<html lang="fr">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>{html.escape(title)}</title>
<meta name="description" content="{html.escape(description)}">
<meta name="robots" content="noindex">
<link rel="canonical" href="{SITE_URL}{canonical}">
<meta property="og:type" content="article">
<meta property="og:title" content="{html.escape(title)}">
<meta property="og:description" content="{html.escape(description)}">
<meta property="og:url" content="{SITE_URL}{canonical}">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,400;0,500;0,600;1,400&family=Raleway:wght@400;500;600&display=swap">
<link rel="stylesheet" href="/assets/css/tokens.css">
<link rel="stylesheet" href="/assets/css/base.css">
<link rel="stylesheet" href="/assets/css/layout.css">
<link rel="stylesheet" href="/assets/css/components.css">
<link rel="stylesheet" href="/assets/css/blog.css">
<link rel="stylesheet" href="/assets/css/photo.css">
{head}
</head>
<body>
<a class="skip-link" href="#main">Aller au contenu principal</a>
{body}
<script src="/assets/js/main.js" defer></script>
</body>
</html>
"""


def media(post: Post, *, lead: bool, eager: bool = False) -> str:
    entry = FEATURED.get(post.slug)
    if not entry:
        return '<div class="post-card__media"></div>'
    name, alt = entry
    sizes = "(max-width: 767px) 92vw, 46vw" if lead else "(max-width: 767px) 92vw, 30vw"
    loading = 'fetchpriority="high"' if eager else 'loading="lazy"'
    return f"""<div class="post-card__media">
          <img src="/assets/img/{name}-800.webp"
               srcset="/assets/img/{name}-800.webp 800w, /assets/img/{name}.webp 1400w"
               sizes="{sizes}"
               width="1400" height="788" {loading} decoding="async"
               alt="{html.escape(alt)}">
        </div>"""


def card(post: Post, *, lead: bool = False) -> str:
    classes = "post-card post-card--lead reveal" if lead else "post-card reveal"
    return f"""<article class="{classes}">
        {media(post, lead=lead)}
        <div class="post-card__body">
          <div class="post-card__meta"><time datetime="{post.date:%Y-%m-%d}">{post.date_fr}</time><span>·</span><a href="{post.url}">{html.escape(post.category)}</a><span>·</span><span>{post.reading_time} min de lecture</span></div>
          <h3 class="post-card__title"><a href="{post.url}">{html.escape(post.title)}</a></h3>
          <p class="post-card__excerpt">{html.escape(post.excerpt)}</p>
          <p class="post-card__foot">Lire l'article →</p>
        </div>
      </article>"""


def render_index(posts: list[Post], header: str, footer: str) -> str:
    cards = "\n".join(card(p, lead=(i == 0)) for i, p in enumerate(posts))
    body = f"""{header}
<main id="main">
<section class="page-hero">
  <div class="wrap">
    <nav class="breadcrumbs" aria-label="Fil d'Ariane"><span><a href="/">Accueil</a></span><span>Blog</span></nav>
    <p class="eyebrow">Le blog</p>
    <h1>Comprendre avant de consulter</h1>
    <p class="lede">Des réponses écrites aux questions qui reviennent le plus souvent en cabinet — sans jargon et sans promesse excessive.</p>
  </div>
</section>

<section class="section">
  <div class="wrap">
    <div class="post-grid">
{cards}
    </div>
  </div>
</section>
</main>
{footer}"""
    return page(
        "Blog — Maxime Blanchard, hypnothérapeute à Angers",
        "Articles sur l'hypnose, le sommeil, l'arrêt du tabac, l'hypersensibilité et les tarifs. Cabinet de Maxime Blanchard à Avrillé, près d'Angers.",
        "/blog/",
        body,
    )


def render_post(post: Post, others: list[Post], header: str, footer: str) -> str:
    entry = FEATURED.get(post.slug)
    featured = ""
    if entry:
        name, alt = entry
        featured = f"""<div class="wrap article-featured">
        <img src="/assets/img/{name}.webp"
             srcset="/assets/img/{name}-800.webp 800w, /assets/img/{name}.webp 1400w"
             sizes="(max-width: 1200px) 94vw, 1200px"
             width="1400" height="788" fetchpriority="high" decoding="async"
             alt="{html.escape(alt)}">
      </div>"""

    suggestions = "".join(
        f'<a href="{p.url}"><span>{html.escape(p.category)}</span><strong>{html.escape(p.title)}</strong></a>'
        for p in others[:2]
    )

    schema = {
        "@context": "https://schema.org",
        "@type": "BlogPosting",
        "headline": post.title,
        "description": post.meta_description,
        "datePublished": post.date.isoformat(),
        "author": {"@type": "Person", "name": "Maxime Blanchard"},
        "publisher": {"@type": "Organization", "name": "Cabinet d'hypnose Maxime Blanchard"},
        "mainEntityOfPage": SITE_URL + post.url,
    }
    head = (
        f'<script type="application/ld+json">'
        f"{json.dumps(schema, ensure_ascii=False, separators=(',', ':'))}</script>"
        + post.extra_head
    )

    body = f"""{header}
<main id="main">
<article class="post">
  <header class="article-hero">
    <div class="wrap wrap--narrow">
      <nav class="breadcrumbs" aria-label="Fil d'Ariane"><span><a href="/">Accueil</a></span><span><a href="/blog/">Blog</a></span><span>{html.escape(post.category)}</span></nav>
      <h1>{html.escape(post.title)}</h1>
      <div class="article-hero__meta">
        <time datetime="{post.date:%Y-%m-%d}">{post.date_fr}</time>
        <span aria-hidden="true">·</span>
        <span>{post.reading_time} min de lecture</span>
        <span aria-hidden="true">·</span>
        <span>{html.escape(post.category)}</span>
      </div>
    </div>
    {featured}
  </header>

  <div class="entry-content">
{post.body_html}

    <div class="author-box">
      <svg width="68" height="68" viewBox="0 0 40 40" aria-hidden="true">
        <circle cx="20" cy="20" r="19" fill="#1f3830"/>
        <circle cx="20" cy="20" r="12.5" fill="none" stroke="#f7f4ec" stroke-opacity="0.4"/>
        <circle cx="20" cy="20" r="7" fill="none" stroke="#f7f4ec" stroke-opacity="0.6"/>
        <circle cx="20" cy="20" r="3" fill="#c2703f"/>
      </svg>
      <div>
        <strong>Maxime Blanchard</strong>
        <p>Hypnothérapeute à Avrillé, près d'Angers. Diplômé en 2013, formateur en hypnose.</p>
      </div>
    </div>

    <div class="post-cta">
      <h2>Une question sur votre situation&nbsp;?</h2>
      <p>Un appel de quelques minutes suffit souvent à savoir si l'hypnose est la bonne approche pour vous.</p>
      <a class="btn btn--light" href="tel:+33651092918">06 51 09 29 18</a>
    </div>

    <nav class="post-nav" aria-label="Autres articles">{suggestions}</nav>
  </div>
</article>
</main>
{footer}"""

    return page(post.title, post.meta_description, post.url, body, head)


def update_home(index_html: str, posts: list[Post]) -> str:
    cards = "\n".join(card(p, lead=(i == 0)) for i, p in enumerate(posts[:3]))
    block = f"<!-- posts:start -->\n{cards}\n      <!-- posts:end -->"
    return re.sub(
        r"<!-- posts:start -->.*?<!-- posts:end -->",
        lambda _: block,
        index_html,
        flags=re.S,
    )


def main() -> None:
    parser = argparse.ArgumentParser()
    parser.add_argument("--offline", action="store_true", help="utiliser le cache local")
    args = parser.parse_args()

    posts = load_wordpress(args.offline) + load_markdown()
    posts.sort(key=lambda p: p.date, reverse=True)
    if not posts:
        sys.exit("aucun article à publier")

    index_path = ROOT / "index.html"
    index_html = index_path.read_text()
    header, footer = chrome(index_html)

    blog_dir = ROOT / "blog"
    blog_dir.mkdir(exist_ok=True)
    (blog_dir / "index.html").write_text(render_index(posts, header, footer))

    for post in posts:
        others = [p for p in posts if p.slug != post.slug]
        target = blog_dir / post.slug
        target.mkdir(exist_ok=True)
        (target / "index.html").write_text(render_post(post, others, header, footer))

    index_path.write_text(update_home(index_html, posts))

    print(f"{len(posts)} articles générés :")
    for post in posts:
        print(f"  {post.url:<45} {post.source:<10} {post.reading_time} min")


if __name__ == "__main__":
    main()
