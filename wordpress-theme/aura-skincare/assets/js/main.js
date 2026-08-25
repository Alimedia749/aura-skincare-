/**
 * Aura Skincare Main Script Controller
 * 
 * Sticky Navigation Blur, Infinite Smooth Hero Slider, Category Pills & Modals
 * @package Aura_Skincare
 */

document.addEventListener('DOMContentLoaded', function() {
  'use strict';

  // ==========================================================================
  // 1. Sticky Navigation Blur & Scroll Dynamics
  // ==========================================================================
  var header = document.querySelector('.site-header');
  
  function handleHeaderScroll() {
    if (!header) return;
    if (window.scrollY > 30) {
      header.classList.add('is-scrolled');
    } else {
      header.classList.remove('is-scrolled');
    }
  }

  window.addEventListener('scroll', handleHeaderScroll, { passive: true });
  handleHeaderScroll();

  // ==========================================================================
  // 2. Rotating Announcement Ticker
  // ==========================================================================
  var tickerItems = document.querySelectorAll('.announcement-ticker .ticker-item');
  if (tickerItems.length > 1) {
    var currentTickerIndex = 0;
    setInterval(function() {
      tickerItems[currentTickerIndex].classList.remove('active');
      currentTickerIndex = (currentTickerIndex + 1) % tickerItems.length;
      tickerItems[currentTickerIndex].classList.add('active');
    }, 4500);
  }

  // ==========================================================================
  // 3. Ultra-Smooth Infinite Hero Slider Controller
  // ==========================================================================
  var heroSliderWrap = document.getElementById('auraHeroSlider');
  var heroTrack = document.getElementById('auraHeroTrack');
  var prevBtn = document.getElementById('heroPrevBtn');
  var nextBtn = document.getElementById('heroNextBtn');
  var indicatorButtons = document.querySelectorAll('.aura-indicator-item');

  if (heroSliderWrap && heroTrack) {
    var originalSlides = heroTrack.querySelectorAll('.aura-hero-slide');
    var slideCount = originalSlides.length;

    if (slideCount > 0) {
      // Clone first and last slide for seamless infinite sliding
      var firstClone = originalSlides[0].cloneNode(true);
      var lastClone = originalSlides[slideCount - 1].cloneNode(true);
      firstClone.classList.add('is-clone');
      lastClone.classList.add('is-clone');

      heroTrack.appendChild(firstClone);
      heroTrack.insertBefore(lastClone, originalSlides[0]);

      var allSlides = heroTrack.querySelectorAll('.aura-hero-slide');
      var totalSlides = allSlides.length; // original + 2 clones
      var currentIndex = 1; // start at first real slide
      var isTransitioning = false;
      var slideDuration = 5500; // 5.5s per slide
      var timer = null;
      var progressAnim = null;

      // Position track without animation initially
      function setTrackPosition(index, animate) {
        if (animate) {
          heroTrack.style.transition = 'transform 0.95s cubic-bezier(0.16, 1, 0.3, 1)';
        } else {
          heroTrack.style.transition = 'none';
        }
        var offset = -index * 100;
        heroTrack.style.transform = 'translate3d(' + offset + '%, 0, 0)';
      }

      setTrackPosition(currentIndex, false);

      // Update active indicators and progress bars
      function updateIndicators(realIndex) {
        indicatorButtons.forEach(function(btn, i) {
          btn.classList.toggle('active', i === realIndex);
          var fill = btn.querySelector('.indicator-progress-fill');
          if (fill) {
            fill.style.transition = 'none';
            fill.style.width = (i === realIndex) ? '0%' : '0%';
          }
        });

        // Start progress bar for active slide
        var activeBtn = indicatorButtons[realIndex];
        if (activeBtn) {
          var activeFill = activeBtn.querySelector('.indicator-progress-fill');
          if (activeFill) {
            setTimeout(function() {
              activeFill.style.transition = 'width ' + (slideDuration / 1000) + 's linear';
              activeFill.style.width = '100%';
            }, 50);
          }
        }
      }

      function getRealIndex() {
        if (currentIndex === 0) return slideCount - 1;
        if (currentIndex === totalSlides - 1) return 0;
        return currentIndex - 1;
      }

      updateIndicators(0);

      // Go to next slide
      function nextSlide() {
        if (isTransitioning) return;
        isTransitioning = true;
        currentIndex++;
        setTrackPosition(currentIndex, true);
        updateIndicators(getRealIndex());
      }

      // Go to previous slide
      function prevSlide() {
        if (isTransitioning) return;
        isTransitioning = true;
        currentIndex--;
        setTrackPosition(currentIndex, true);
        updateIndicators(getRealIndex());
      }

      // Seamless Infinite Loop Boundary Reset
      heroTrack.addEventListener('transitionend', function() {
        isTransitioning = false;
        if (currentIndex === totalSlides - 1) {
          // Wrapped past last slide -> snap to real first slide
          currentIndex = 1;
          setTrackPosition(currentIndex, false);
        } else if (currentIndex === 0) {
          // Wrapped before first slide -> snap to real last slide
          currentIndex = totalSlides - 2;
          setTrackPosition(currentIndex, false);
        }
      });

      // Auto-play timer
      function startAutoPlay() {
        stopAutoPlay();
        updateIndicators(getRealIndex());
        timer = setInterval(function() {
          nextSlide();
        }, slideDuration);
      }

      function stopAutoPlay() {
        if (timer) {
          clearInterval(timer);
          timer = null;
        }
      }

      startAutoPlay();

      // Always keep auto-play running continuously (no pause on hover)
      // heroSliderWrap hover listeners intentionally omitted as requested

      // Buttons click handlers
      if (nextBtn) {
        nextBtn.addEventListener('click', function(e) {
          e.preventDefault();
          nextSlide();
          startAutoPlay();
        });
      }

      if (prevBtn) {
        prevBtn.addEventListener('click', function(e) {
          e.preventDefault();
          prevSlide();
          startAutoPlay();
        });
      }

      // Indicator clicks
      indicatorButtons.forEach(function(btn) {
        btn.addEventListener('click', function(e) {
          e.preventDefault();
          if (isTransitioning) return;
          var targetIndex = parseInt(this.getAttribute('data-goto-slide'), 10);
          if (!isNaN(targetIndex)) {
            currentIndex = targetIndex + 1; // map to real slide position
            isTransitioning = true;
            setTrackPosition(currentIndex, true);
            updateIndicators(targetIndex);
            startAutoPlay();
          }
        });
      });

      // Touch & Drag Support for Mobile / Desktop
      var startX = 0;
      var currentTranslate = 0;
      var isDragging = false;

      heroTrack.addEventListener('touchstart', function(e) {
        stopAutoPlay();
        startX = e.touches[0].clientX;
        isDragging = true;
      }, { passive: true });

      heroTrack.addEventListener('touchmove', function(e) {
        if (!isDragging) return;
        var diffX = e.touches[0].clientX - startX;
        var currentOffset = -currentIndex * heroSliderWrap.offsetWidth;
        heroTrack.style.transition = 'none';
        heroTrack.style.transform = 'translate3d(' + (currentOffset + diffX) + 'px, 0, 0)';
      }, { passive: true });

      heroTrack.addEventListener('touchend', function(e) {
        if (!isDragging) return;
        isDragging = false;
        var diffX = e.changedTouches[0].clientX - startX;
        if (diffX < -50) {
          nextSlide();
        } else if (diffX > 50) {
          prevSlide();
        } else {
          setTrackPosition(currentIndex, true);
        }
        startAutoPlay();
      });
    }
  }

  // ==========================================================================
  // 4. Category Pills & Home Tab Interactive Filtering
  // ==========================================================================
  var categoryPills = document.querySelectorAll('.category-pill-item');
  var homeTabs = document.querySelectorAll('.home-tab-btn');
  var productCards = document.querySelectorAll('#homeProductsGrid .aura-product-card, .bestsellers-grid .aura-product-card');
  var navCategoryLinks = document.querySelectorAll('[data-nav-category]');

  function applyProductFilter(targetFilter, activeLabel) {
    if (!targetFilter) return;

    var filterNormalized = targetFilter.toLowerCase().trim();

    productCards.forEach(function(card) {
      var cardCat = (card.getAttribute('data-category') || '').toLowerCase().trim();
      var cardCatName = (card.getAttribute('data-category-name') || '').toLowerCase().trim();
      var isBs = card.getAttribute('data-is-bestseller') === 'true';
      var isNew = card.getAttribute('data-is-new') === 'true';

      var shouldShow = false;

      if (filterNormalized === 'all') {
        shouldShow = true;
      } else if (filterNormalized === 'bestseller' || filterNormalized === 'bestsellers') {
        shouldShow = isBs;
      } else if (filterNormalized === 'new' || filterNormalized === 'new-arrivals') {
        shouldShow = isNew;
      } else if (filterNormalized === 'serums' || filterNormalized === 'serums-oils') {
        shouldShow = (cardCat.indexOf('serum') !== -1 || cardCat.indexOf('oil') !== -1 || cardCatName.indexOf('serum') !== -1 || cardCatName.indexOf('oil') !== -1);
      } else {
        shouldShow = (cardCat === filterNormalized || cardCat.indexOf(filterNormalized) !== -1 || cardCatName.indexOf(filterNormalized) !== -1);
      }

      if (shouldShow) {
        card.style.display = 'flex';
        if (window.gsap) {
          window.gsap.fromTo(card, { opacity: 0, y: 12 }, { opacity: 1, y: 0, duration: 0.35 });
        }
      } else {
        card.style.display = 'none';
      }
    });

    if (activeLabel) {
      showAuraToast('Displaying ' + activeLabel);
    }
  }

  // Home Tabs Listener
  homeTabs.forEach(function(tab) {
    tab.addEventListener('click', function(e) {
      e.preventDefault();
      homeTabs.forEach(function(t) { t.classList.remove('active'); });
      this.classList.add('active');

      var filter = this.getAttribute('data-filter');
      var label = this.textContent.trim();

      // Sync category pills state if matching
      categoryPills.forEach(function(p) {
        p.classList.toggle('active', p.getAttribute('data-category') === filter);
      });

      applyProductFilter(filter, label);
    });
  });

  // Category Pills Listener
  categoryPills.forEach(function(pill) {
    pill.addEventListener('click', function(e) {
      var targetCat = this.getAttribute('data-category');
      if (!targetCat || targetCat === '#') return;

      var anchorMap = {
        'cleansers': 'cleansers-section',
        'serums': 'serums-section',
        'moisturizers': 'moisturizers-section',
        'eye-care': 'eyecare-section',
        'toners-mists': 'toners-section',
        'sun-protection': 'sunprotection-section',
        'botanical-oils': 'botanicaloils-section'
      };

      var targetAnchorId = anchorMap[targetCat];
      var targetSectionEl = targetAnchorId ? document.getElementById(targetAnchorId) : null;

      if (targetSectionEl) {
        e.preventDefault();
        categoryPills.forEach(function(p) { p.classList.remove('active'); });
        this.classList.add('active');

        var catNameEl = this.querySelector('.category-pill-name');
        var label = catNameEl ? catNameEl.textContent.trim() : targetCat;
        
        targetSectionEl.scrollIntoView({ behavior: 'smooth', block: 'start' });
        showAuraToast('Viewing ' + label);
      } else {
        var targetEl = document.getElementById('all-products') || document.getElementById('bestsellers');
        if (targetEl) {
          e.preventDefault();
          targetEl.scrollIntoView({ behavior: 'smooth', block: 'start' });
          applyProductFilter(targetCat, targetCat);
        }
      }
    });
  });

  // Header Dropdown "Collections" Category Links Handler (If on homepage)
  navCategoryLinks.forEach(function(link) {
    link.addEventListener('click', function(e) {
      var targetCat = this.getAttribute('data-nav-category');
      var targetAnchor = this.getAttribute('data-target-anchor');

      var anchorMap = {
        'cleansers': 'cleansers-section',
        'serums': 'serums-section',
        'moisturizers': 'moisturizers-section',
        'eye-care': 'eyecare-section',
        'toners-mists': 'toners-section',
        'sun-protection': 'sunprotection-section',
        'botanical-oils': 'botanicaloils-section'
      };

      var targetId = targetAnchor || anchorMap[targetCat];
      var targetSection = targetId ? document.getElementById(targetId) : null;

      if (targetSection) {
        e.preventDefault();
        var catName = this.getAttribute('data-category-name') || this.textContent.trim();
        targetSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
        showAuraToast('Viewing ' + catName);
      }
    });
  });

  // Check URL category query param or hash on homepage load
  var homeUrlParams = new URLSearchParams(window.location.search);
  var initialCat = homeUrlParams.get('category') || homeUrlParams.get('cat');
  if (!initialCat && window.location.hash) {
    var rawHash = window.location.hash.replace('#', '').replace('category=', '').replace('categories?cat=', '');
    if (rawHash && rawHash !== 'categories' && rawHash !== 'bestsellers' && rawHash !== 'contact') {
      initialCat = rawHash;
    }
  }

  if (initialCat) {
    var anchorMap = {
      'cleansers': 'cleansers-section',
      'serums': 'serums-section',
      'moisturizers': 'moisturizers-section',
      'eye-care': 'eyecare-section',
      'toners-mists': 'toners-section',
      'sun-protection': 'sunprotection-section',
      'botanical-oils': 'botanicaloils-section'
    };
    var targetSecId = anchorMap[initialCat] || initialCat;
    var targetSec = document.getElementById(targetSecId);
    if (targetSec) {
      setTimeout(function() {
        targetSec.scrollIntoView({ behavior: 'smooth', block: 'start' });
      }, 350);
    }
  }

  // ==========================================================================
  // 5. Product Card Direct Click to Product Detail
  // ==========================================================================
  var allProductCards = document.querySelectorAll('.aura-product-card');
  allProductCards.forEach(function(card) {
    card.style.cursor = 'pointer';
    card.addEventListener('click', function(e) {
      // If user clicked quick add button, ignore
      if (e.target.closest('.quick-add-btn')) return;
      var link = card.querySelector('.product-card-title a, .product-card-img-link');
      if (link && link.href) {
        window.location.href = link.href;
      }
    });
  });

  // ==========================================================================
  // 6. Mobile Menu Toggle
  // ==========================================================================
  var mobileToggle = document.querySelector('.mobile-menu-toggle');
  var mobileMenu = document.querySelector('.primary-menu');

  if (mobileToggle && mobileMenu) {
    mobileToggle.addEventListener('click', function() {
      var isExpanded = this.getAttribute('aria-expanded') === 'true';
      this.setAttribute('aria-expanded', !isExpanded);
      mobileMenu.classList.toggle('is-active');
    });
  }

  // ==========================================================================
  // 7. Universal Smooth Scroll for Contact and Hash Links
  // ==========================================================================
  document.addEventListener('click', function(e) {
    var anchor = e.target.closest('a[href*="#contact"]');
    if (anchor) {
      var contactEl = document.getElementById('contact');
      if (contactEl) {
        e.preventDefault();
        contactEl.scrollIntoView({ behavior: 'smooth', block: 'start' });
      }
    }
  });

  // Check on initial page load if URL contains #contact
  if (window.location.hash === '#contact') {
    setTimeout(function() {
      var contactEl = document.getElementById('contact');
      if (contactEl) {
        contactEl.scrollIntoView({ behavior: 'smooth', block: 'start' });
      }
    }, 400);
  }
});

/**
 * Global Toast Notification Helper
 */
function showAuraToast(message) {
  var toast = document.getElementById('aura-toast');
  var msg = document.getElementById('aura-toast-msg');
  if (toast && msg) {
    msg.textContent = message;
    toast.style.opacity = '1';
    toast.style.transform = 'translateX(-50%) translateY(0)';
    setTimeout(function() {
      toast.style.opacity = '0';
      toast.style.transform = 'translateX(-50%) translateY(100px)';
    }, 3000);
  }
}
window.showAuraToast = showAuraToast;
