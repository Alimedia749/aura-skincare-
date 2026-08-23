<?php
/**
 * Template Name: My Account Portal (Stitch Design)
 * Template Post Type: page
 *
 * @package Aura_Skincare
 */

get_header();

$current_user = wp_get_current_user();
$user_name = $current_user->exists() ? ( $current_user->first_name ? $current_user->first_name : $current_user->display_name ) : 'Eleanor';
$user_full_name = $current_user->exists() ? $current_user->display_name : 'Eleanor Vance';
$user_email = $current_user->exists() ? $current_user->user_email : 'eleanor.vance@example.com';
?>

<main id="main-content" class="account-portal-page">
	<div class="aura-container-wide">
		<div class="account-portal-layout">
			
			<!-- Left Vertical Navigation Sidebar -->
			<aside class="account-sidebar">
				<h1 class="account-sidebar-title"><?php esc_html_e( 'My Account', 'aura-skincare' ); ?></h1>
				
				<ul class="account-nav-list" role="tablist">
					
					<!-- 1. Dashboard -->
					<li class="account-nav-item">
						<button type="button" class="account-nav-btn active" data-tab="dashboard" role="tab" aria-selected="true">
							<svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
								<rect x="3" y="3" width="7" height="7"></rect>
								<rect x="14" y="3" width="7" height="7"></rect>
								<rect x="14" y="14" width="7" height="7"></rect>
								<rect x="3" y="14" width="7" height="7"></rect>
							</svg>
							<span><?php esc_html_e( 'Dashboard', 'aura-skincare' ); ?></span>
						</button>
					</li>

					<!-- 2. Orders -->
					<li class="account-nav-item">
						<button type="button" class="account-nav-btn" data-tab="orders" role="tab" aria-selected="false">
							<svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
								<path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path>
								<line x1="3" y1="6" x2="21" y2="6"></line>
								<path d="M16 10a4 4 0 0 1-8 0"></path>
							</svg>
							<span><?php esc_html_e( 'Orders', 'aura-skincare' ); ?></span>
						</button>
					</li>

					<!-- 3. Addresses -->
					<li class="account-nav-item">
						<button type="button" class="account-nav-btn" data-tab="addresses" role="tab" aria-selected="false">
							<svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
								<path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
								<circle cx="12" cy="10" r="3"></circle>
							</svg>
							<span><?php esc_html_e( 'Addresses', 'aura-skincare' ); ?></span>
						</button>
					</li>

					<!-- 4. Account Details -->
					<li class="account-nav-item">
						<button type="button" class="account-nav-btn" data-tab="details" role="tab" aria-selected="false">
							<svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
								<circle cx="12" cy="12" r="3"></circle>
								<path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path>
							</svg>
							<span><?php esc_html_e( 'Account Details', 'aura-skincare' ); ?></span>
						</button>
					</li>

					<!-- 5. Logout -->
					<li class="account-nav-item">
						<a href="<?php echo esc_url( wp_logout_url( home_url( '/' ) ) ); ?>" class="account-nav-btn logout-btn">
							<svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
								<path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
								<polyline points="16 17 21 12 16 7"></polyline>
								<line x1="21" y1="12" x2="9" y2="12"></line>
							</svg>
							<span><?php esc_html_e( 'Logout', 'aura-skincare' ); ?></span>
						</a>
					</li>

				</ul>
			</aside>

			<!-- Right Main Content Area -->
			<section class="account-main-content">
				
				<!-- ========================================================
				     PANE 1: DASHBOARD (Active Default)
				     ======================================================== -->
				<div class="account-pane active" id="pane-dashboard">
					
					<!-- Welcome Hero Header -->
					<div class="account-welcome-header">
						<h2 class="account-welcome-title"><?php printf( esc_html__( 'Welcome back, %s', 'aura-skincare' ), esc_html( $user_name ) ); ?></h2>
						<p class="account-welcome-subtitle"><?php esc_html_e( 'Manage your orders, addresses, and loyalty rewards.', 'aura-skincare' ); ?></p>
					</div>

					<!-- 3-Column Metrics Grid -->
					<div class="account-metrics-grid">
						
						<!-- Card 1: Total Orders -->
						<div class="account-metric-card">
							<div class="metric-card-top">
								<span class="metric-card-label"><?php esc_html_e( 'Total Orders', 'aura-skincare' ); ?></span>
								<svg class="metric-card-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
									<rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
									<line x1="16" y1="2" x2="16" y2="6"></line>
									<line x1="8" y1="2" x2="8" y2="6"></line>
									<line x1="3" y1="10" x2="21" y2="10"></line>
								</svg>
							</div>
							<div class="metric-card-value">12</div>
							<a href="javascript:void(0)" class="metric-card-action" onclick="document.querySelector('[data-tab=\'orders\']').click();"><?php esc_html_e( 'VIEW ALL', 'aura-skincare' ); ?></a>
						</div>

						<!-- Card 2: Lumina / Aura Rewards -->
						<div class="account-metric-card">
							<!-- Star Watermark -->
							<svg class="metric-watermark-star" viewBox="0 0 24 24" fill="currentColor">
								<polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
							</svg>

							<div class="metric-card-top">
								<span class="metric-card-label"><?php esc_html_e( 'Aura Rewards', 'aura-skincare' ); ?></span>
								<svg class="metric-card-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
									<circle cx="12" cy="12" r="10"></circle>
									<polygon points="12 6 13.8 9.6 17.8 10.2 14.9 13 15.6 17 12 15.1 8.4 17 9.1 13 6.2 10.2 10.2 9.6 12 6"></polygon>
								</svg>
							</div>
							<div class="metric-card-value">2,450</div>
							<div class="metric-card-subtext"><?php esc_html_e( 'TIER: RADIANCE', 'aura-skincare' ); ?></div>
						</div>

						<!-- Card 3: Primary Address -->
						<div class="account-metric-card">
							<div class="metric-card-top">
								<span class="metric-card-label"><?php esc_html_e( 'Primary Address', 'aura-skincare' ); ?></span>
								<svg class="metric-card-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
									<path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
									<polyline points="9 22 9 12 15 12 15 22"></polyline>
								</svg>
							</div>
							<div class="metric-card-address">
								<strong><?php echo esc_html( $user_full_name ); ?></strong><br>
								1284 Luxe Avenue, Apt 4B<br>
								New York, NY 10012
							</div>
							<a href="javascript:void(0)" class="metric-card-action" onclick="document.querySelector('[data-tab=\'addresses\']').click();"><?php esc_html_e( 'EDIT', 'aura-skincare' ); ?></a>
						</div>

					</div>

					<!-- Recent Orders Section -->
					<h3 class="account-section-heading"><?php esc_html_e( 'Recent Orders', 'aura-skincare' ); ?></h3>
					
					<div class="orders-table-wrapper">
						<table class="account-orders-table">
							<thead>
								<tr>
									<th><?php esc_html_e( 'ORDER #', 'aura-skincare' ); ?></th>
									<th><?php esc_html_e( 'DATE', 'aura-skincare' ); ?></th>
									<th><?php esc_html_e( 'STATUS', 'aura-skincare' ); ?></th>
									<th style="text-align: right;"><?php esc_html_e( 'TOTAL', 'aura-skincare' ); ?></th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td class="order-number">#AURA-8492</td>
									<td class="order-date">Oct 24, 2026</td>
									<td><span class="order-status-badge status-processing"><?php esc_html_e( 'PROCESSING', 'aura-skincare' ); ?></span></td>
									<td class="order-total" style="text-align: right;">$245.00</td>
								</tr>
								<tr>
									<td class="order-number">#AURA-8310</td>
									<td class="order-date">Sep 12, 2026</td>
									<td><span class="order-status-badge status-delivered"><?php esc_html_e( 'DELIVERED', 'aura-skincare' ); ?></span></td>
									<td class="order-total" style="text-align: right;">$180.00</td>
								</tr>
								<tr>
									<td class="order-number">#AURA-8104</td>
									<td class="order-date">Aug 04, 2026</td>
									<td><span class="order-status-badge status-delivered"><?php esc_html_e( 'DELIVERED', 'aura-skincare' ); ?></span></td>
									<td class="order-total" style="text-align: right;">$120.00</td>
								</tr>
							</tbody>
						</table>
					</div>

				</div>

				<!-- ========================================================
				     PANE 2: ORDERS
				     ======================================================== -->
				<div class="account-pane" id="pane-orders">
					<div class="account-welcome-header">
						<h2 class="account-welcome-title"><?php esc_html_e( 'Order History', 'aura-skincare' ); ?></h2>
						<p class="account-welcome-subtitle"><?php esc_html_e( 'Track active shipments and view past botanical rituals orders.', 'aura-skincare' ); ?></p>
					</div>

					<div class="orders-table-wrapper">
						<table class="account-orders-table">
							<thead>
								<tr>
									<th><?php esc_html_e( 'ORDER #', 'aura-skincare' ); ?></th>
									<th><?php esc_html_e( 'DATE', 'aura-skincare' ); ?></th>
									<th><?php esc_html_e( 'ITEMS', 'aura-skincare' ); ?></th>
									<th><?php esc_html_e( 'STATUS', 'aura-skincare' ); ?></th>
									<th style="text-align: right;"><?php esc_html_e( 'TOTAL', 'aura-skincare' ); ?></th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td class="order-number">#AURA-8492</td>
									<td class="order-date">Oct 24, 2026</td>
									<td>Aurum Hydrating Serum (x2), Ceramide Cream (x1)</td>
									<td><span class="order-status-badge status-processing"><?php esc_html_e( 'PROCESSING', 'aura-skincare' ); ?></span></td>
									<td class="order-total" style="text-align: right;">$245.00</td>
								</tr>
								<tr>
									<td class="order-number">#AURA-8310</td>
									<td class="order-date">Sep 12, 2026</td>
									<td>Cellular Shield Botanical Elixir (x1), Velvet Balm (x1)</td>
									<td><span class="order-status-badge status-delivered"><?php esc_html_e( 'DELIVERED', 'aura-skincare' ); ?></span></td>
									<td class="order-total" style="text-align: right;">$180.00</td>
								</tr>
								<tr>
									<td class="order-number">#AURA-8104</td>
									<td class="order-date">Aug 04, 2026</td>
									<td>Silk Petal Brightening Essence (x1), Calming Mist (x1)</td>
									<td><span class="order-status-badge status-delivered"><?php esc_html_e( 'DELIVERED', 'aura-skincare' ); ?></span></td>
									<td class="order-total" style="text-align: right;">$120.00</td>
								</tr>
								<tr>
									<td class="order-number">#AURA-7920</td>
									<td class="order-date">Jun 19, 2026</td>
									<td>The Ultimate Luminous Ritual Set (x1)</td>
									<td><span class="order-status-badge status-delivered"><?php esc_html_e( 'DELIVERED', 'aura-skincare' ); ?></span></td>
									<td class="order-total" style="text-align: right;">$195.00</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>

				<!-- ========================================================
				     PANE 3: ADDRESSES
				     ======================================================== -->
				<div class="account-pane" id="pane-addresses">
					<div class="account-welcome-header">
						<h2 class="account-welcome-title"><?php esc_html_e( 'Address Book', 'aura-skincare' ); ?></h2>
						<p class="account-welcome-subtitle"><?php esc_html_e( 'The following addresses will be used on the checkout page by default.', 'aura-skincare' ); ?></p>
					</div>

					<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.5rem; margin-bottom: 2.5rem;">
						
						<!-- Shipping Address Card -->
						<div style="background: #FAF7F2; border: 1px solid #EBE7DF; border-radius: 12px; padding: 1.8rem;">
							<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
								<h3 style="font-family: var(--font-heading); font-size: 1.25rem; color: var(--color-heading); margin: 0;"><?php esc_html_e( 'Shipping Address', 'aura-skincare' ); ?></h3>
								<span style="background: #EBF7EE; color: #2B7A4B; font-size: 0.7rem; font-weight: 700; padding: 0.2rem 0.5rem; border-radius: 4px;"><?php esc_html_e( 'DEFAULT', 'aura-skincare' ); ?></span>
							</div>
							<div style="font-size: 0.9rem; line-height: 1.6; color: var(--color-text); margin-bottom: 1.2rem;">
								<strong><?php echo esc_html( $user_full_name ); ?></strong><br>
								1284 Luxe Avenue, Apt 4B<br>
								New York, NY 10012<br>
								United States<br>
								Phone: +1 (555) 234-5678
							</div>
							<button type="button" class="aura-btn aura-btn-secondary" style="padding: 0.5rem 1rem; font-size: 0.8rem;" onclick="alert('Address edit form enabled.');"><?php esc_html_e( 'Edit Address', 'aura-skincare' ); ?></button>
						</div>

						<!-- Billing Address Card -->
						<div style="background: #FAF7F2; border: 1px solid #EBE7DF; border-radius: 12px; padding: 1.8rem;">
							<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
								<h3 style="font-family: var(--font-heading); font-size: 1.25rem; color: var(--color-heading); margin: 0;"><?php esc_html_e( 'Billing Address', 'aura-skincare' ); ?></h3>
							</div>
							<div style="font-size: 0.9rem; line-height: 1.6; color: var(--color-text); margin-bottom: 1.2rem;">
								<strong><?php echo esc_html( $user_full_name ); ?></strong><br>
								1284 Luxe Avenue, Apt 4B<br>
								New York, NY 10012<br>
								United States
							</div>
							<button type="button" class="aura-btn aura-btn-secondary" style="padding: 0.5rem 1rem; font-size: 0.8rem;" onclick="alert('Address edit form enabled.');"><?php esc_html_e( 'Edit Address', 'aura-skincare' ); ?></button>
						</div>

					</div>
				</div>

				<!-- ========================================================
				     PANE 4: ACCOUNT DETAILS
				     ======================================================== -->
				<div class="account-pane" id="pane-details">
					<div class="account-welcome-header">
						<h2 class="account-welcome-title"><?php esc_html_e( 'Account Details', 'aura-skincare' ); ?></h2>
						<p class="account-welcome-subtitle"><?php esc_html_e( 'Update your personal profile, email, and security credentials.', 'aura-skincare' ); ?></p>
					</div>

					<form onsubmit="event.preventDefault(); alert('Account details updated successfully!');" style="max-width: 680px;">
						<div class="account-form-grid">
							<div class="account-form-group">
								<label class="account-form-label"><?php esc_html_e( 'First Name', 'aura-skincare' ); ?></label>
								<input type="text" class="account-form-input" value="Eleanor" required>
							</div>
							<div class="account-form-group">
								<label class="account-form-label"><?php esc_html_e( 'Last Name', 'aura-skincare' ); ?></label>
								<input type="text" class="account-form-input" value="Vance" required>
							</div>
							<div class="account-form-group full-width">
								<label class="account-form-label"><?php esc_html_e( 'Display Name', 'aura-skincare' ); ?></label>
								<input type="text" class="account-form-input" value="Eleanor Vance" required>
								<small style="color: var(--color-text-muted); font-size: 0.78rem;"><?php esc_html_e( 'This will be how your name will be displayed in the account section and in reviews.', 'aura-skincare' ); ?></small>
							</div>
							<div class="account-form-group full-width">
								<label class="account-form-label"><?php esc_html_e( 'Email Address', 'aura-skincare' ); ?></label>
								<input type="email" class="account-form-input" value="<?php echo esc_attr( $user_email ); ?>" required>
							</div>
						</div>

						<h3 style="font-family: var(--font-heading); font-size: 1.35rem; color: var(--color-heading); margin: 2rem 0 1rem 0;"><?php esc_html_e( 'Password Change', 'aura-skincare' ); ?></h3>

						<div class="account-form-grid">
							<div class="account-form-group full-width">
								<label class="account-form-label"><?php esc_html_e( 'Current Password (leave blank to leave unchanged)', 'aura-skincare' ); ?></label>
								<input type="password" class="account-form-input">
							</div>
							<div class="account-form-group">
								<label class="account-form-label"><?php esc_html_e( 'New Password', 'aura-skincare' ); ?></label>
								<input type="password" class="account-form-input">
							</div>
							<div class="account-form-group">
								<label class="account-form-label"><?php esc_html_e( 'Confirm New Password', 'aura-skincare' ); ?></label>
								<input type="password" class="account-form-input">
							</div>
						</div>

						<button type="submit" class="aura-btn aura-btn-primary" style="padding: 0.9rem 2.2rem; font-size: 0.9rem; margin-top: 1rem;">
							<span><?php esc_html_e( 'Save Changes', 'aura-skincare' ); ?></span>
						</button>
					</form>
				</div>

			</section>

		</div>
	</div>
</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
	var navBtns = document.querySelectorAll('.account-nav-btn[data-tab]');
	var panes = document.querySelectorAll('.account-pane');

	navBtns.forEach(function(btn) {
		btn.addEventListener('click', function(e) {
			e.preventDefault();
			var targetTab = this.getAttribute('data-tab');
			if (!targetTab) return;

			// Update Nav buttons
			navBtns.forEach(function(b) {
				b.classList.remove('active');
				b.setAttribute('aria-selected', 'false');
			});
			this.classList.add('active');
			this.setAttribute('aria-selected', 'true');

			// Update Panes
			panes.forEach(function(p) {
				p.classList.remove('active');
			});

			var targetPane = document.getElementById('pane-' + targetTab);
			if (targetPane) {
				targetPane.classList.add('active');
			}
		});
	});
});
</script>

<?php
get_footer();
