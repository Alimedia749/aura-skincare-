<?php
/**
 * Live Search Modal Overlay
 *
 * @package Aura_Skincare
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$products = function_exists( 'aura_get_mock_products' ) ? aura_get_mock_products() : array();
$products_json = wp_json_encode( $products );
?>

<div id="aura-search-modal" class="aura-search-modal-overlay" role="dialog" aria-modal="true" aria-label="<?php esc_attr_e( 'Search formulas', 'aura-skincare' ); ?>">
	<div class="aura-search-modal-backdrop" id="aura-search-backdrop"></div>
	
	<div class="aura-search-modal-container">
		
		<!-- Modal Header with Input & Close -->
		<div class="aura-search-header">
			<div class="aura-search-input-wrapper">
				<svg class="aura-search-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
					<circle cx="11" cy="11" r="8"></circle>
					<line x1="21" y1="21" x2="16.65" y2="16.65"></line>
				</svg>
				<input 
					type="search" 
					id="aura-search-input" 
					class="aura-search-input" 
					placeholder="<?php esc_attr_e( 'Search formulas, bio-ferments, ingredients...', 'aura-skincare' ); ?>" 
					autocomplete="off" 
					spellcheck="false"
				/>
				<button type="button" id="aura-search-clear-btn" class="aura-search-clear-btn" aria-label="<?php esc_attr_e( 'Clear search', 'aura-skincare' ); ?>" style="display: none;">
					<svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
				</button>
			</div>
			
			<button type="button" id="aura-search-close-btn" class="aura-search-close-btn" aria-label="<?php esc_attr_e( 'Close search', 'aura-skincare' ); ?>">
				<span class="esc-badge">ESC</span>
				<svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
					<line x1="18" y1="6" x2="6" y2="18"></line>
					<line x1="6" y1="6" x2="18" y2="18"></line>
				</svg>
			</button>
		</div>

		<!-- Quick Filter Tags -->
		<div class="aura-search-tags-row">
			<span class="aura-search-tags-label"><?php esc_html_e( 'POPULAR SEARCHES:', 'aura-skincare' ); ?></span>
			<div class="aura-search-tags-list">
				<button type="button" class="aura-search-tag" data-query="Serum">Serum</button>
				<button type="button" class="aura-search-tag" data-query="Ceramide">Ceramide</button>
				<button type="button" class="aura-search-tag" data-query="Cleanser">Cleanser</button>
				<button type="button" class="aura-search-tag" data-query="Bakuchiol">Bakuchiol</button>
				<button type="button" class="aura-search-tag" data-query="Moisturizer">Moisturizer</button>
				<button type="button" class="aura-search-tag" data-query="Oil">Botanical Oil</button>
			</div>
		</div>

		<!-- Live Search Results & State -->
		<div class="aura-search-body">
			<div class="aura-search-section-title" id="aura-search-heading">
				<?php esc_html_e( 'FEATURED BOTANICAL RITUALS', 'aura-skincare' ); ?>
			</div>
			
			<div id="aura-search-results-grid" class="aura-search-results-grid" data-products="<?php echo esc_attr( $products_json ); ?>">
				<!-- Dynamically Rendered Results via JS -->
			</div>

			<div id="aura-search-empty-state" class="aura-search-empty-state" style="display: none;">
				<div style="font-size: 2rem; margin-bottom: 0.5rem;">🌿</div>
				<h4 style="font-family: var(--font-heading); font-size: 1.25rem; color: var(--color-heading); margin-bottom: 0.5rem; font-weight: 500;"><?php esc_html_e( 'No botanical rituals found', 'aura-skincare' ); ?></h4>
				<p style="font-size: 0.9rem; color: var(--color-text-light); max-width: 380px; margin: 0 auto;"><?php esc_html_e( 'Try searching with different keywords such as "serum", "cleanser", "oil", or "hydration".', 'aura-skincare' ); ?></p>
			</div>
		</div>

		<!-- Footer Link to full shop catalog -->
		<div class="aura-search-footer">
			<a href="<?php echo esc_url( home_url( '/shop/' ) ); ?>" class="aura-search-all-link">
				<span><?php esc_html_e( 'Explore All Botanical Formulas in Shop', 'aura-skincare' ); ?></span>
				<svg viewBox="0 0 20 20" width="14" height="14" fill="currentColor"><path fill-rule="evenodd" d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd"/></svg>
			</a>
		</div>

	</div>
</div>

<style>
/* Live Search Overlay Styles */
.aura-search-modal-overlay {
	position: fixed;
	top: 0;
	left: 0;
	width: 100vw;
	height: 100vh;
	z-index: 99999;
	display: flex;
	align-items: flex-start;
	justify-content: center;
	padding-top: clamp(2rem, 8vh, 6rem);
	padding-left: 1rem;
	padding-right: 1rem;
	opacity: 0;
	visibility: hidden;
	pointer-events: none;
	transition: opacity 0.3s cubic-bezier(0.16, 1, 0.3, 1), visibility 0.3s;
}

.aura-search-modal-overlay.is-open {
	opacity: 1;
	visibility: visible;
	pointer-events: auto;
}

.aura-search-modal-backdrop {
	position: absolute;
	top: 0;
	left: 0;
	width: 100%;
	height: 100%;
	background: rgba(20, 19, 17, 0.72);
	backdrop-filter: blur(12px);
	-webkit-backdrop-filter: blur(12px);
}

.aura-search-modal-container {
	position: relative;
	width: 100%;
	max-width: 760px;
	background: #ffffff;
	border-radius: 18px;
	border: 1px solid rgba(197, 168, 128, 0.25);
	box-shadow: 0 25px 60px rgba(0, 0, 0, 0.25), 0 0 1px rgba(0,0,0,0.1);
	overflow: hidden;
	transform: translateY(-20px) scale(0.98);
	transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1);
	z-index: 2;
	max-height: 85vh;
	display: flex;
	flex-direction: column;
}

.aura-search-modal-overlay.is-open .aura-search-modal-container {
	transform: translateY(0) scale(1);
}

.aura-search-header {
	display: flex;
	align-items: center;
	gap: 1rem;
	padding: 1.25rem 1.5rem;
	border-bottom: 1px solid var(--color-border);
	background: #FAF7F2;
}

.aura-search-input-wrapper {
	position: relative;
	flex: 1;
	display: flex;
	align-items: center;
}

.aura-search-icon {
	width: 22px;
	height: 22px;
	color: var(--color-gold);
	flex-shrink: 0;
	margin-right: 0.85rem;
}

.aura-search-input {
	width: 100%;
	border: none;
	background: transparent;
	font-family: inherit;
	font-size: clamp(1rem, 2vw, 1.2rem);
	color: var(--color-heading);
	outline: none;
	padding-right: 2rem;
}

.aura-search-input::placeholder {
	color: rgba(20, 19, 17, 0.4);
	font-weight: 400;
}

.aura-search-clear-btn {
	position: absolute;
	right: 0;
	background: none;
	border: none;
	color: var(--color-text-light);
	cursor: pointer;
	padding: 4px;
	display: flex;
	align-items: center;
}

.aura-search-close-btn {
	display: flex;
	align-items: center;
	gap: 0.5rem;
	background: none;
	border: none;
	color: var(--color-text-main);
	cursor: pointer;
	padding: 0.5rem;
	border-radius: 8px;
	transition: background-color 0.2s;
}

.aura-search-close-btn:hover {
	background: rgba(0,0,0,0.05);
	color: var(--color-gold);
}

.esc-badge {
	font-size: 0.72rem;
	font-weight: 700;
	letter-spacing: 0.05em;
	padding: 2px 6px;
	border-radius: 4px;
	background: rgba(0,0,0,0.06);
	color: var(--color-text-light);
}

.aura-search-tags-row {
	display: flex;
	align-items: center;
	gap: 0.75rem;
	padding: 0.85rem 1.5rem;
	background: #ffffff;
	border-bottom: 1px solid rgba(0,0,0,0.04);
	overflow-x: auto;
	scrollbar-width: none;
}

.aura-search-tags-row::-webkit-scrollbar {
	display: none;
}

.aura-search-tags-label {
	font-size: 0.72rem;
	font-weight: 700;
	letter-spacing: 0.1em;
	color: var(--color-text-light);
	white-space: nowrap;
}

.aura-search-tags-list {
	display: flex;
	gap: 0.5rem;
}

.aura-search-tag {
	border: 1px solid var(--color-border);
	background: #FAF7F2;
	color: var(--color-heading);
	font-size: 0.8rem;
	font-weight: 500;
	padding: 0.25rem 0.75rem;
	border-radius: 100px;
	cursor: pointer;
	white-space: nowrap;
	transition: all 0.2s;
}

.aura-search-tag:hover {
	background: var(--color-gold);
	border-color: var(--color-gold);
	color: #ffffff;
}

.aura-search-body {
	padding: 1.25rem 1.5rem;
	overflow-y: auto;
	flex: 1;
}

.aura-search-section-title {
	font-size: 0.75rem;
	font-weight: 700;
	letter-spacing: 0.12em;
	color: var(--color-gold);
	text-transform: uppercase;
	margin-bottom: 1rem;
}

.aura-search-results-grid {
	display: grid;
	gap: 0.75rem;
}

.aura-search-item {
	display: flex;
	align-items: center;
	gap: 1rem;
	padding: 0.75rem 1rem;
	border-radius: 10px;
	text-decoration: none;
	background: #ffffff;
	border: 1px solid transparent;
	transition: all 0.2s ease;
}

.aura-search-item:hover {
	background: #FAF7F2;
	border-color: rgba(197, 168, 128, 0.35);
	transform: translateX(4px);
}

.aura-search-item-img {
	width: 52px;
	height: 52px;
	border-radius: 8px;
	object-fit: cover;
	background: #FAF7F2;
	flex-shrink: 0;
}

.aura-search-item-info {
	flex: 1;
	min-width: 0;
}

.aura-search-item-cat {
	font-size: 0.72rem;
	color: var(--color-gold);
	font-weight: 600;
	text-transform: uppercase;
	letter-spacing: 0.06em;
	margin-bottom: 2px;
}

.aura-search-item-title {
	font-size: 0.95rem;
	font-weight: 600;
	color: var(--color-heading);
	white-space: nowrap;
	overflow: hidden;
	text-overflow: ellipsis;
}

.aura-search-item-price {
	font-size: 0.9rem;
	font-weight: 700;
	color: var(--color-heading);
	margin-left: auto;
	flex-shrink: 0;
}

.aura-search-empty-state {
	text-align: center;
	padding: 2.5rem 1rem;
}

.aura-search-footer {
	padding: 1rem 1.5rem;
	background: #FAF7F2;
	border-top: 1px solid var(--color-border);
	text-align: center;
}

.aura-search-all-link {
	display: inline-flex;
	align-items: center;
	gap: 0.5rem;
	color: var(--color-heading);
	font-size: 0.85rem;
	font-weight: 600;
	text-decoration: none;
	transition: color 0.2s;
}

.aura-search-all-link:hover {
	color: var(--color-gold);
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
	var modal = document.getElementById('aura-search-modal');
	var backdrop = document.getElementById('aura-search-backdrop');
	var input = document.getElementById('aura-search-input');
	var clearBtn = document.getElementById('aura-search-clear-btn');
	var closeBtn = document.getElementById('aura-search-close-btn');
	var resultsGrid = document.getElementById('aura-search-results-grid');
	var emptyState = document.getElementById('aura-search-empty-state');
	var heading = document.getElementById('aura-search-heading');
	var tags = document.querySelectorAll('.aura-search-tag');

	if (!modal || !resultsGrid) return;

	var productsData = [];
	try {
		productsData = JSON.parse(resultsGrid.getAttribute('data-products') || '[]');
	} catch(e) {
		console.error('Error parsing search products data', e);
	}

	function renderProducts(items, isSearchQuery) {
		resultsGrid.innerHTML = '';
		if (items.length === 0) {
			resultsGrid.style.display = 'none';
			emptyState.style.display = 'block';
			heading.textContent = 'NO MATCHES';
			return;
		}

		resultsGrid.style.display = 'grid';
		emptyState.style.display = 'none';
		heading.textContent = isSearchQuery ? 'SEARCH RESULTS (' + items.length + ')' : 'FEATURED BOTANICAL RITUALS';

		items.forEach(function(item) {
			var link = item.link || '/product-detail/?product=' + (item.slug || 'aurum-hydrating-serum');
			var price = '$' + (typeof item.price === 'number' ? item.price.toFixed(2) : item.price);
			var img = item.image || '/wp-content/themes/aura-skincare/assets/images/hero-slide-1.png';
			var cat = item.category || 'Botanical Formula';

			var a = document.createElement('a');
			a.href = link;
			a.className = 'aura-search-item';
			a.innerHTML = 
				'<img src="' + img + '" alt="' + item.title + '" class="aura-search-item-img" />' +
				'<div class="aura-search-item-info">' +
					'<div class="aura-search-item-cat">' + cat + '</div>' +
					'<div class="aura-search-item-title">' + item.title + '</div>' +
				'</div>' +
				'<div class="aura-search-item-price">' + price + '</div>';
			resultsGrid.appendChild(a);
		});
	}

	function openSearch() {
		modal.classList.add('is-open');
		document.body.style.overflow = 'hidden';
		if (input) {
			input.value = '';
			if (clearBtn) clearBtn.style.display = 'none';
			renderProducts(productsData.slice(0, 5), false);
			setTimeout(function() {
				input.focus();
			}, 100);
		}
	}

	function closeSearch() {
		modal.classList.remove('is-open');
		document.body.style.overflow = '';
	}

	function filterSearch(query) {
		var q = query.trim().toLowerCase();
		if (q === '') {
			if (clearBtn) clearBtn.style.display = 'none';
			renderProducts(productsData.slice(0, 5), false);
			return;
		}

		if (clearBtn) clearBtn.style.display = 'flex';

		var matched = productsData.filter(function(p) {
			var t = (p.title || '').toLowerCase();
			var c = (p.category || '').toLowerCase();
			var s = (p.subtitle || '').toLowerCase();
			var tagsArr = Array.isArray(p.tags) ? p.tags.join(' ').toLowerCase() : '';
			return t.includes(q) || c.includes(q) || s.includes(q) || tagsArr.includes(q);
		});

		renderProducts(matched, true);
	}

	// Attach click listener to search icons in header
	document.querySelectorAll('.nav-action-search, [data-search-toggle="true"]').forEach(function(btn) {
		btn.addEventListener('click', function(e) {
			e.preventDefault();
			openSearch();
		});
	});

	if (closeBtn) closeBtn.addEventListener('click', closeSearch);
	if (backdrop) backdrop.addEventListener('click', closeSearch);

	if (input) {
		input.addEventListener('input', function() {
			filterSearch(this.value);
		});
	}

	if (clearBtn) {
		clearBtn.addEventListener('click', function() {
			input.value = '';
			input.focus();
			filterSearch('');
		});
	}

	// Quick tag buttons
	tags.forEach(function(tag) {
		tag.addEventListener('click', function() {
			var query = this.getAttribute('data-query');
			if (input) {
				input.value = query;
				input.focus();
				filterSearch(query);
			}
		});
	});

	// ESC key closes search
	document.addEventListener('keydown', function(e) {
		if (e.key === 'Escape' && modal.classList.contains('is-open')) {
			closeSearch();
		}
	});
});
</script>
