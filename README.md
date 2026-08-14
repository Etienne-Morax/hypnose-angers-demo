# Maxime Hypnose — thème WordPress

## Les deux démos en ligne

| Démo | URL | Ce qu'elle prouve |
|---|---|---|
| **Vitrine premium** (statique) | https://etienne-morax.github.io/hypnose-angers-demo/ | La direction artistique réelle : Lora + Raleway, orbe animée, palette complète. C'est ce que donne le thème sur mesure. |
| **WordPress live** | https://hypnoseangers3.wordpress.com/ | Le pipeline éditorial : articles publiés par API, grille de blog, SEO et JSON-LD automatiques. C'est la démo PostPilot. |

Les deux ne se remplacent pas. Le WordPress tourne sur un plan gratuit : ni thème custom,
ni CSS personnalisée, ni polices web — la charte y est approchée avec les styles portés
par les blocs. La version GitHub Pages montre le rendu sans ces contraintes.


Refonte du site vitrine [hypnose-angers-blanchard.com](https://hypnose-angers-blanchard.com/) sous forme de thème WordPress classique, installable sur n'importe quel WordPress auto-hébergé (ou WordPress.com plan Business/Commerce).

## Ce que contient le dépôt

```
maxime-hypnose/          Le thème (à installer)
apercu.html              Aperçu statique de la page d'accueil (ouvrir dans un navigateur)
.claude/launch.json      Serveur local pour l'aperçu (python3 -m http.server 4321)
```

## Installation

1. Zipper le dossier `maxime-hypnose/` (ou utiliser `maxime-hypnose.zip` s'il est présent).
2. WordPress → Apparence → Thèmes → Ajouter → Téléverser un thème → Activer.
3. À l'activation, le thème crée automatiquement :
   - les pages Accueil, L'hypnose, Domaines, Tarifs, Qui suis-je, Contact, Blog ;
   - le menu principal et le menu de pied de page ;
   - le réglage « page d'accueil statique » + la page d'articles.

   L'opération est idempotente : réactiver le thème ne duplique rien.
4. Apparence → Personnaliser → **Cabinet — coordonnées** : téléphone, email, adresse, horaires, lien de réservation. Ces champs alimentent l'en-tête, le pied de page, la page contact et les données structurées Schema.org.

## Direction artistique

| Élément | Choix |
|---|---|
| Palette | Pin profond `oklch(.26 .028 168)` / sable `oklch(.985 .008 92)` / terracotta `oklch(.62 .115 48)` / sauge |
| Typographie | Lora (titres, italique éditoriale) + Raleway (texte) |
| Composition | Héros asymétrique, grille bento pour les domaines, étapes numérotées sur fond sombre, cartes tarifaires avec une offre mise en avant |
| Visuels | 100 % vectoriels (SVG inline + grain `feTurbulence`) — aucun bitmap, aucun décalage de mise en page |
| Motion | `transform`/`opacity` uniquement, `prefers-reduced-motion` respecté |

Tous les tokens vivent dans `assets/css/tokens.css`. Changer la palette ou le rythme se fait à cet endroit uniquement.

## Blog & publication automatisée (PostPilot)

Le thème a été construit pour que des articles créés par API restent dans la charte sans retouche :

- `index.php` / `archive.php` / `single.php` couvrent toute la chaîne éditoriale, y compris pagination, catégories, étiquettes, article précédent/suivant.
- `blog.css` style tout le contenu Gutenberg standard : titres, listes, citations, tableaux, code, images `alignwide` / `alignfull`, légendes.
- La palette et les tailles de police sont déclarées côté éditeur (`add_theme_support('editor-color-palette')`), donc un article généré utilise les slugs `ink`, `sand`, `clay`, `sage` plutôt que des hex arbitraires.
- `inc/seo.php` ajoute automatiquement le JSON-LD `BlogPosting` + `LocalBusiness` et les balises Open Graph sur chaque article publié.
- Un article sans image à la une reste correct : la carte affiche un dégradé de la charte.

Rien de spécifique à PostPilot n'est codé en dur : la publication passe par l'API REST WordPress standard (`/wp-json/wp/v2/posts`).

## Formulaire de contact

`inc/contact-form.php` — traitement côté serveur, sans plugin :
nonce WordPress, pot de miel, limitation à un envoi par minute et par IP, validation serveur avec messages d'erreur au niveau du champ, envoi via `wp_mail()` avec `Reply-To` sur l'expéditeur.

En production, prévoir un SMTP authentifié (WP Mail SMTP ou équivalent) : `wp_mail()` seul finit souvent en spam.

## Vérifications effectuées

- `php -l` (PHP 8.5) sur les 34 fichiers PHP : aucune erreur de syntaxe.
- Aucun débordement horizontal à 375, 768 et 1280 px.
- Menu mobile, barre d'action fixe et bascule du header vérifiés au DOM.
- Ordre de titres séquentiel, `skip-link`, focus visible, cibles tactiles ≥ 44 px, `aria-live` sur les retours de formulaire.

## À faire avant mise en ligne

1. **Remplacer les témoignages.** `template-parts/section-temoignages.php` contient trois exemples explicitement marqués comme tels. Ils doivent être remplacés par de vrais avis (Google, Doctolib, ou courriel avec accord écrit) — publier des témoignages fabriqués serait trompeur et juridiquement risqué.
2. **Photo du praticien.** Le thème n'en utilise aucune aujourd'hui. Une photo de Maxime et une du cabinet renforceraient nettement la page « Qui suis-je ».
3. **Mentions légales et politique de confidentialité.** Créer les pages et les rattacher à l'emplacement de menu « Mentions légales ».
4. **Auto-hébergement des polices.** Lora et Raleway sont chargées depuis Google Fonts. Les héberger localement supprime une requête tierce et le sujet RGPD associé.
5. **Vérifier les tarifs et horaires** auprès du client : ils proviennent du site actuel et peuvent avoir changé.

## Aperçu local

```bash
python3 -m http.server 4321
```

Puis ouvrir `http://localhost:4321/apercu.html`. L'aperçu utilise exactement les mêmes feuilles de style que le thème.
