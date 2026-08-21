/**
 * Aura Skincare Asynchronous AJAX Cart & Offcanvas Drawer Controller
 *
 * @package Aura_Skincare
 */

(function($) {
  'use strict';

  var AuraCart = {
    params: window.auraCartParams || {},
    drawer: null,
    overlay: null,
    panel: null,
    itemsContainer: null,
    subtotalElem: null,
    countBadges: null,
    shippingMeter: null,
    shippingBar: null,
    shippingMsg: null,

    // In-memory state for seamless sandbox / preview mode
    items: [],
    subtotalRaw: 0,

    init: function() {
      var self = this;
      self.cacheDom();
      self.bindEvents();
      self.initMockDataIfNeeded();
    },

    cacheDom: function() {
      this.drawer = document.querySelector('.aura-cart-drawer');
      this.overlay = document.querySelector('.aura-cart-overlay');
      this.panel = document.querySelector('.aura-cart-panel');
      this.itemsContainer = document.querySelector('.aura-cart-items-list');
      this.subtotalElem = document.querySelector('.subtotal-amount');
      this.countBadges = document.querySelectorAll('.aura-cart-count-badge, .aura-cart-count-pill');
      this.shippingMeter = document.querySelector('.aura-shipping-meter');
      this.shippingBar = document.querySelector('.shipping-progress-bar');
      this.shippingMsg = document.querySelector('.shipping-meter-message span');
    },

    bindEvents: function() {
      var self = this;

      // 1. Drawer open triggers
      $(document).on('click', '[data-cart-toggle], .nav-action-bag, .open-cart-drawer', function(e) {
        e.preventDefault();
        self.openDrawer();
      });

      // 2. Drawer close triggers
      $(document).on('click', '.aura-cart-close-btn, .aura-cart-overlay', function(e) {
        e.preventDefault();
        self.closeDrawer();
      });

      // Escape key to close
      $(document).on('keydown', function(e) {
        if (e.key === 'Escape' && self.isOpen()) {
          self.closeDrawer();
        }
      });

      // 3. Quick-Add (+) Button Clicks on Product Cards & Hero Slides
      $(document).on('click', '.quick-add-btn, .hero-add-to-bag-btn, .aura-quick-add, [data-add-to-cart]', function(e) {
        e.preventDefault();
        var $btn = $(this);
        var productId = $btn.data('add-to-cart') || $btn.data('product-id');
        var productTitle = $btn.data('product-title') || 'Ritual item';
        var productPrice = parseFloat($btn.data('product-price')) || 68.00;
        var productImg = $btn.data('product-img') || $btn.data('product-image') || '';
        var productVol = $btn.data('product-vol') || $btn.data('product-volume') || '50 ml';

        if (!productId) return;

        self.handleAddToCart($btn, {
          id: productId,
          title: productTitle,
          price: productPrice,
          image: productImg,
          volume: productVol,
          quantity: 1
        });
      });

      // 4. Quantity Adjustments (+ / -) in Drawer
      $(document).on('click', '.cart-quantity-control .qty-btn', function(e) {
        e.preventDefault();
        var $btn = $(this);
        var action = $btn.data('action');
        var cartKey = $btn.closest('.aura-cart-item').data('cart-key');
        var $qtyVal = $btn.siblings('.qty-val');
        var currentQty = parseInt($qtyVal.text(), 10) || 1;
        var newQty = action === 'plus' ? currentQty + 1 : currentQty - 1;

        self.updateItemQuantity(cartKey, newQty, $btn.closest('.aura-cart-item'));
      });

      // 5. Item Removal in Drawer
      $(document).on('click', '.cart-item-remove-btn', function(e) {
        e.preventDefault();
        var $item = $(this).closest('.aura-cart-item');
        var cartKey = $item.data('cart-key');
        self.removeItem(cartKey, $item);
      });

      // Listen for standard WooCommerce events
      $(document.body).on('added_to_cart', function(event, fragments, cart_hash, $button) {
        self.openDrawer();
      });
    },

    isOpen: function() {
      return this.drawer && this.drawer.classList.contains('is-open');
    },

    openDrawer: function() {
      if (!this.drawer) return;
      this.drawer.classList.add('is-open');
      document.body.style.overflow = 'hidden';
      this.updateShippingProgress();
    },

    closeDrawer: function() {
      if (!this.drawer) return;
      this.drawer.classList.remove('is-open');
      document.body.style.overflow = '';
    },

    handleAddToCart: function($btn, itemData) {
      var self = this;
      $btn.addClass('is-loading');

      // Check if WordPress admin-ajax is available
      if (self.params.ajaxUrl && self.params.nonce) {
        $.ajax({
          type: 'POST',
          url: self.params.ajaxUrl,
          data: {
            action: 'aura_add_to_cart',
            security: self.params.nonce,
            product_id: itemData.id,
            quantity: itemData.quantity
          },
          dataType: 'json',
          success: function(response) {
            $btn.removeClass('is-loading').addClass('is-added');
            setTimeout(function() { $btn.removeClass('is-added'); }, 1500);

            if (response.success) {
              self.addItemToLocalState(itemData);
              self.openDrawer();
              if (window.showAuraToast) {
                window.showAuraToast(response.data.message || 'Added to bag!');
              }
            }
          },
          error: function() {
            // Graceful fallback for local development without active backend session
            $btn.removeClass('is-loading').addClass('is-added');
            setTimeout(function() { $btn.removeClass('is-added'); }, 1500);
            self.addItemToLocalState(itemData);
            self.openDrawer();
            if (window.showAuraToast) {
              window.showAuraToast('Added ' + itemData.title + ' to bag!');
            }
          }
        });
      } else {
        // Fallback standalone preview
        setTimeout(function() {
          $btn.removeClass('is-loading').addClass('is-added');
          setTimeout(function() { $btn.removeClass('is-added'); }, 1500);
          self.addItemToLocalState(itemData);
          self.openDrawer();
          if (window.showAuraToast) {
            window.showAuraToast('Added ' + itemData.title + ' to bag!');
          }
        }, 300);
      }
    },

    addItemToLocalState: function(item) {
      var existing = this.items.find(function(i) { return i.id === item.id; });
      if (existing) {
        existing.quantity += item.quantity;
      } else {
        this.items.push({
          id: item.id,
          cartKey: 'cart_' + item.id + '_' + Date.now(),
          title: item.title,
          price: item.price,
          image: item.image,
          volume: item.volume,
          quantity: item.quantity
        });
      }
      this.renderDrawer();
    },

    updateItemQuantity: function(cartKey, newQty, $itemElem) {
      var self = this;
      var itemIndex = self.items.findIndex(function(i) { return i.cartKey === cartKey || i.id == cartKey; });

      if (itemIndex > -1) {
        if (newQty <= 0) {
          self.removeItem(cartKey, $itemElem);
          return;
        }
        self.items[itemIndex].quantity = newQty;
        self.renderDrawer();
      }
    },

    removeItem: function(cartKey, $itemElem) {
      var self = this;
      if ($itemElem && $itemElem.length) {
        $itemElem.addClass('is-removing');
        setTimeout(function() {
          self.items = self.items.filter(function(i) { return i.cartKey !== cartKey && i.id != cartKey; });
          self.renderDrawer();
          if (window.showAuraToast) {
            window.showAuraToast('Item removed from your bag.');
          }
        }, 280);
      }
    },

    renderDrawer: function() {
      var self = this;
      var container = document.querySelector('.aura-cart-body');
      if (!container) return;

      var totalCount = 0;
      var totalPrice = 0;

      self.items.forEach(function(item) {
        totalCount += item.quantity;
        totalPrice += (item.price * item.quantity);
      });

      // Update badge counts
      self.countBadges.forEach(function(badge) {
        badge.textContent = totalCount;
        if (totalCount > 0) {
          badge.classList.add('has-items');
        } else {
          badge.classList.remove('has-items');
        }
      });

      // Update subtotal
      if (self.subtotalElem) {
        var symbol = self.params.currencySymbol || '$';
        self.subtotalElem.textContent = symbol + totalPrice.toFixed(2);
      }
      self.subtotalRaw = totalPrice;

      // Render Empty state or Items list
      if (self.items.length === 0) {
        container.innerHTML = '\
          <div class="aura-cart-empty">\
            <svg class="empty-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.2">\
              <path d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" stroke-linecap="round" stroke-linejoin="round"/>\
            </svg>\
            <h4 class="empty-title">Your Ritual Bag is Empty</h4>\
            <p class="empty-text">Discover tailored botanicals and clinical concentrates designed for daily skin harmony.</p>\
            <button class="aura-btn aura-btn-primary aura-btn-sm" onclick="AuraCart.closeDrawer()">Explore Bestsellers</button>\
          </div>\
        ';
      } else {
        var html = '<div class="aura-cart-items-list">';
        self.items.forEach(function(item) {
          var symbol = self.params.currencySymbol || '$';
          var itemTotal = (item.price * item.quantity).toFixed(2);
          var siteUrl = (window.auraSiteData && window.auraSiteData.siteUrl) ? window.auraSiteData.siteUrl : '/';
          var prodUrl = siteUrl + 'product-detail/?product=aurum-hydrating-serum';
          html += '\
            <div class="aura-cart-item" data-cart-key="' + item.cartKey + '">\
              <a href="' + prodUrl + '" class="cart-item-thumb" style="display:block;">\
                <img src="' + item.image + '" alt="' + item.title + '">\
              </a>\
              <div class="cart-item-info">\
                <div class="cart-item-top">\
                  <h4 class="cart-item-title"><a href="' + prodUrl + '" style="color:inherit;text-decoration:none;">' + item.title + '</a></h4>\
                  <button class="cart-item-remove-btn" title="Remove item" aria-label="Remove item">\
                    <svg viewBox="0 0 20 20" fill="currentColor">\
                      <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>\
                    </svg>\
                  </button>\
                </div>\
                <div class="cart-item-meta">' + item.volume + '</div>\
                <div class="cart-item-bottom">\
                  <div class="cart-quantity-control">\
                    <button class="qty-btn" data-action="minus">−</button>\
                    <span class="qty-val">' + item.quantity + '</span>\
                    <button class="qty-btn" data-action="plus">+</button>\
                  </div>\
                  <div class="cart-item-price">' + symbol + itemTotal + '</div>\
                </div>\
              </div>\
            </div>\
          ';
        });
        html += '</div>';
        container.innerHTML = html;
      }

      self.updateShippingProgress();
    },

    updateShippingProgress: function() {
      var self = this;
      var threshold = self.params.freeShippingThreshold || 75;
      var current = self.subtotalRaw;
      var symbol = self.params.currencySymbol || '$';

      if (!self.shippingBar || !self.shippingMsg) return;

      if (current >= threshold) {
        self.shippingBar.style.width = '100%';
        if (self.shippingMeter) self.shippingMeter.classList.add('is-unlocked');
        self.shippingMsg.textContent = self.params.strings ? self.params.strings.freeShippingGoal : 'Free shipping unlocked!';
      } else {
        var remaining = (threshold - current).toFixed(2);
        var percent = Math.min(100, Math.max(0, (current / threshold) * 100));
        self.shippingBar.style.width = percent + '%';
        if (self.shippingMeter) self.shippingMeter.classList.remove('is-unlocked');
        self.shippingMsg.textContent = 'Add ' + symbol + remaining + ' ' + (self.params.strings ? self.params.strings.freeShippingAway : 'away from free express shipping');
      }
    },

    initMockDataIfNeeded: function() {
      // Seed with initial item if empty for aesthetic demonstration
      if (this.items.length === 0) {
        var themeUri = (window.auraSiteData && window.auraSiteData.themeUri) ? window.auraSiteData.themeUri : '';
        this.items = [{
          id: 101,
          cartKey: 'cart_initial_101',
          title: 'Celestial Hydration Barrier Serum',
          price: 68.00,
          image: themeUri + '/assets/images/hero-products.webp',
          volume: '50 ml / 1.7 fl. oz.',
          quantity: 1
        }];
        this.renderDrawer();
      }
    }
  };

  // Expose global controller
  window.AuraCart = AuraCart;

  $(document).ready(function() {
    AuraCart.init();
  });

})(jQuery);
