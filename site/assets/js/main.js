/**
 * Interactions du thème : menu mobile, ombre de l'en-tête, révélation au scroll.
 * Aucune dépendance externe, exécution différée.
 */
(function () {
  'use strict';

  var REVEAL_THRESHOLD = 0.12;
  var SCROLLED_OFFSET = 8;

  /** Menu mobile : ouverture, fermeture au clic sur un lien et à la touche Échap. */
  function initNav() {
    var toggle = document.querySelector('.nav-toggle');
    var nav = document.getElementById('site-nav');

    if (!toggle || !nav) {
      return;
    }

    function setOpen(isOpen) {
      toggle.setAttribute('aria-expanded', String(isOpen));
      nav.classList.toggle('is-open', isOpen);
      document.body.style.overflow = isOpen ? 'hidden' : '';
    }

    toggle.addEventListener('click', function () {
      setOpen(toggle.getAttribute('aria-expanded') !== 'true');
    });

    nav.addEventListener('click', function (event) {
      if (event.target.closest('a')) {
        setOpen(false);
      }
    });

    document.addEventListener('keydown', function (event) {
      if (event.key === 'Escape' && toggle.getAttribute('aria-expanded') === 'true') {
        setOpen(false);
        toggle.focus();
      }
    });

    window.addEventListener('resize', function () {
      if (window.innerWidth >= 1024) {
        setOpen(false);
      }
    });
  }

  /** Ombre de l'en-tête une fois la page défilée. */
  function initHeader() {
    var header = document.getElementById('site-header');

    if (!header) {
      return;
    }

    var ticking = false;

    function update() {
      header.classList.toggle('is-scrolled', window.scrollY > SCROLLED_OFFSET);
      ticking = false;
    }

    window.addEventListener(
      'scroll',
      function () {
        if (!ticking) {
          window.requestAnimationFrame(update);
          ticking = true;
        }
      },
      { passive: true }
    );

    update();
  }

  /** Apparition progressive des blocs, désactivée si l'utilisateur réduit les animations. */
  function initReveal() {
    var items = document.querySelectorAll('.reveal');

    if (!items.length) {
      return;
    }

    var prefersReduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    if (prefersReduced || !('IntersectionObserver' in window)) {
      items.forEach(function (item) {
        item.classList.add('is-visible');
      });
      return;
    }

    var observer = new IntersectionObserver(
      function (entries) {
        entries.forEach(function (entry, index) {
          if (!entry.isIntersecting) {
            return;
          }

          // Décalage court entre éléments voisins : lecture séquentielle, sans attente.
          entry.target.style.transitionDelay = Math.min(index * 45, 180) + 'ms';
          entry.target.classList.add('is-visible');
          observer.unobserve(entry.target);
        });
      },
      { threshold: REVEAL_THRESHOLD, rootMargin: '0px 0px -6% 0px' }
    );

    items.forEach(function (item) {
      observer.observe(item);
    });
  }

  /** Un seul panneau FAQ ouvert à la fois. */
  function initFaq() {
    var groups = document.querySelectorAll('.faq');

    groups.forEach(function (group) {
      var panels = group.querySelectorAll('details');

      panels.forEach(function (panel) {
        panel.addEventListener('toggle', function () {
          if (!panel.open) {
            return;
          }

          panels.forEach(function (other) {
            if (other !== panel) {
              other.open = false;
            }
          });
        });
      });
    });
  }

  function init() {
    initNav();
    initHeader();
    initReveal();
    initFaq();
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }
})();
