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
  // 4. Category Pills Interactive Filtering
  // ==========================================================================
  var categoryPills = document.querySelectorAll('.category-pill-item');
  var productCards = document.querySelectorAll('.aura-product-card');

  categoryPills.forEach(function(pill) {
    pill.addEventListener('click', function(e) {
      var targetCat = this.getAttribute('data-category');
      if (!targetCat || targetCat === '#') return;

      e.preventDefault();

      categoryPills.forEach(function(p) { p.classList.remove('active'); });
      this.classList.add('active');

      productCards.forEach(function(card) {
        var cardCat = card.querySelector('.product-card-category');
        var catText = cardCat ? cardCat.textContent.trim().toLowerCase() : '';
        if (targetCat === 'all' || catText.indexOf(targetCat.toLowerCase()) !== -1) {
          card.style.display = 'flex';
          if (window.gsap) {
            window.gsap.from(card, { opacity: 0, y: 15, duration: 0.35 });
          }
        } else {
          card.style.display = 'none';
        }
      });

      var catName = this.querySelector('.category-pill-name');
      if (catName) {
        showAuraToast('Displaying ' + catName.textContent);
      }
    });
  });

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
