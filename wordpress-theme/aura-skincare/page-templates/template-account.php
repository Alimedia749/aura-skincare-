<?php
/**
 * Template Name: My Account Portal (Stitch Design)
 * Template Post Type: page
 *
 * @package Aura_Skincare
 */

$is_logged_in   = is_user_logged_in();
$current_user   = wp_get_current_user();
$user_id        = $is_logged_in ? $current_user->ID : 0;
$active_tab     = isset( $_GET['tab'] ) ? sanitize_key( $_GET['tab'] ) : 'dashboard';
$notice_success = '';
$notice_error   = '';

// -------------------------------------------------------------------------
// POST HANDLERS FOR LOGGED-IN USERS
// -------------------------------------------------------------------------
if ( $is_logged_in && 'POST' === $_SERVER['REQUEST_METHOD'] ) {
	$account_action = isset( $_POST['aura_account_action'] ) ? sanitize_text_field( $_POST['aura_account_action'] ) : '';

	// 1. Save Account Details
	if ( 'save_account_details' === $account_action ) {
		$active_tab = 'details';
		if ( ! isset( $_POST['aura_details_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['aura_details_nonce'] ) ), 'aura_save_details' ) ) {
			$notice_error = esc_html__( 'Security validation failed. Please refresh and try again.', 'aura-skincare' );
		} else {
			$first_name   = isset( $_POST['first_name'] ) ? sanitize_text_field( wp_unslash( $_POST['first_name'] ) ) : '';
			$last_name    = isset( $_POST['last_name'] ) ? sanitize_text_field( wp_unslash( $_POST['last_name'] ) ) : '';
			$display_name = isset( $_POST['display_name'] ) ? sanitize_text_field( wp_unslash( $_POST['display_name'] ) ) : '';
			$user_email   = isset( $_POST['user_email'] ) ? sanitize_email( wp_unslash( $_POST['user_email'] ) ) : '';

			$cur_pass  = isset( $_POST['password_current'] ) ? $_POST['password_current'] : '';
			$new_pass  = isset( $_POST['password_1'] ) ? $_POST['password_1'] : '';
			$conf_pass = isset( $_POST['password_2'] ) ? $_POST['password_2'] : '';

			// Validate Email
			if ( empty( $user_email ) || ! is_email( $user_email ) ) {
				$notice_error = esc_html__( 'Please enter a valid email address.', 'aura-skincare' );
			} elseif ( email_exists( $user_email ) && intval( email_exists( $user_email ) ) !== intval( $user_id ) ) {
				$notice_error = esc_html__( 'This email address is already in use by another account.', 'aura-skincare' );
			} else {
				$userdata = array(
					'ID'           => $user_id,
					'first_name'   => $first_name,
					'last_name'    => $last_name,
					'display_name' => ! empty( $display_name ) ? $display_name : trim( $first_name . ' ' . $last_name ),
					'user_email'   => $user_email,
				);

				// Handle Password Change if requested
				$password_error = false;
				if ( ! empty( $cur_pass ) || ! empty( $new_pass ) || ! empty( $conf_pass ) ) {
					if ( empty( $cur_pass ) || ! wp_check_password( $cur_pass, $current_user->user_pass, $user_id ) ) {
						$notice_error   = esc_html__( 'Your current password was entered incorrectly.', 'aura-skincare' );
						$password_error = true;
					} elseif ( empty( $new_pass ) || strlen( $new_pass ) < 6 ) {
						$notice_error   = esc_html__( 'New password must be at least 6 characters.', 'aura-skincare' );
						$password_error = true;
					} elseif ( $new_pass !== $conf_pass ) {
						$notice_error   = esc_html__( 'New password and confirmation do not match.', 'aura-skincare' );
						$password_error = true;
					} else {
						$userdata['user_pass'] = $new_pass;
					}
				}

				if ( ! $password_error ) {
					$updated = wp_update_user( $userdata );
					if ( is_wp_error( $updated ) ) {
						$notice_error = $updated->get_error_message();
					} else {
						// Update WooCommerce billing/shipping meta if active
						if ( function_exists( 'update_user_meta' ) ) {
							update_user_meta( $user_id, 'billing_first_name', $first_name );
							update_user_meta( $user_id, 'billing_last_name', $last_name );
							update_user_meta( $user_id, 'billing_email', $user_email );
							update_user_meta( $user_id, 'shipping_first_name', $first_name );
							update_user_meta( $user_id, 'shipping_last_name', $last_name );
						}
						// Refresh auth cookie if password changed
						if ( ! empty( $userdata['user_pass'] ) ) {
							wp_set_current_user( $user_id );
							wp_set_auth_cookie( $user_id, true );
						}
						$notice_success = esc_html__( 'Your account details have been updated successfully.', 'aura-skincare' );
						$current_user   = wp_get_current_user();
					}
				}
			}
		}
	}

	// 2. Save Address Book (Shipping / Billing)
	if ( 'save_address' === $account_action ) {
		$active_tab = 'addresses';
		if ( ! isset( $_POST['aura_address_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['aura_address_nonce'] ) ), 'aura_save_address' ) ) {
			$notice_error = esc_html__( 'Security validation failed. Please refresh and try again.', 'aura-skincare' );
		} else {
			$addr_type = isset( $_POST['address_type'] ) && 'billing' === $_POST['address_type'] ? 'billing' : 'shipping';
			$prefix    = $addr_type . '_';

			$fields = array( 'first_name', 'last_name', 'company', 'address_1', 'address_2', 'city', 'state', 'postcode', 'country', 'phone', 'email' );
			foreach ( $fields as $field ) {
				if ( isset( $_POST[ $prefix . $field ] ) ) {
					$val = ( 'email' === $field ) ? sanitize_email( wp_unslash( $_POST[ $prefix . $field ] ) ) : sanitize_text_field( wp_unslash( $_POST[ $prefix . $field ] ) );
					update_user_meta( $user_id, $prefix . $field, $val );
				}
			}

			$type_label     = ( 'billing' === $addr_type ) ? esc_html__( 'Billing', 'aura-skincare' ) : esc_html__( 'Shipping', 'aura-skincare' );
			$notice_success = sprintf( esc_html__( '%s address updated successfully.', 'aura-skincare' ), $type_label );
		}
	}
}

// -------------------------------------------------------------------------
// POST HANDLERS FOR LOGGED-OUT USERS (Inline Auth Fallback)
// -------------------------------------------------------------------------
if ( ! $is_logged_in && 'POST' === $_SERVER['REQUEST_METHOD'] ) {
	$auth_action = isset( $_POST['aura_auth_action'] ) ? sanitize_text_field( $_POST['aura_auth_action'] ) : '';

	// Process Login
	if ( 'login' === $auth_action ) {
		if ( ! isset( $_POST['aura_login_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['aura_login_nonce'] ) ), 'aura_login_action' ) ) {
			$notice_error = esc_html__( 'Security check failed. Please refresh and try again.', 'aura-skincare' );
		} else {
			$user_login = isset( $_POST['log'] ) ? sanitize_text_field( wp_unslash( $_POST['log'] ) ) : '';
			$user_pass  = isset( $_POST['pwd'] ) ? $_POST['pwd'] : '';
			$remember   = ! empty( $_POST['rememberme'] );

			$user = wp_signon( array( 'user_login' => $user_login, 'user_password' => $user_pass, 'remember' => $remember ), is_ssl() );

			if ( is_wp_error( $user ) ) {
				$notice_error = $user->get_error_message();
			} else {
				wp_safe_redirect( home_url( '/my-account/' ) );
				exit;
			}
		}
	}

	// Process Registration
	if ( 'register' === $auth_action ) {
		if ( ! isset( $_POST['aura_register_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['aura_register_nonce'] ) ), 'aura_register_action' ) ) {
			$notice_error = esc_html__( 'Security check failed. Please refresh and try again.', 'aura-skincare' );
		} else {
			$full_name = isset( $_POST['full_name'] ) ? sanitize_text_field( wp_unslash( $_POST['full_name'] ) ) : '';
			$email     = isset( $_POST['user_email'] ) ? sanitize_email( wp_unslash( $_POST['user_email'] ) ) : '';
			$password  = isset( $_POST['user_password'] ) ? $_POST['user_password'] : '';

			if ( empty( $email ) || ! is_email( $email ) ) {
				$notice_error = esc_html__( 'Please provide a valid email address.', 'aura-skincare' );
			} elseif ( email_exists( $email ) ) {
				$notice_error = esc_html__( 'An account with this email address already exists. Please sign in.', 'aura-skincare' );
			} elseif ( empty( $password ) || strlen( $password ) < 6 ) {
				$notice_error = esc_html__( 'Password must be at least 6 characters long.', 'aura-skincare' );
			} else {
				$username = sanitize_user( current( explode( '@', $email ) ), true );
				if ( empty( $username ) || username_exists( $username ) ) {
					$username = 'aura_user_' . wp_rand( 1000, 99999 );
				}

				$name_parts = explode( ' ', trim( $full_name ) );
				$first_name = array_shift( $name_parts );
				$last_name  = implode( ' ', $name_parts );

				$new_user_id = wp_insert_user( array(
					'user_login'   => $username,
					'user_email'   => $email,
					'user_pass'    => $password,
					'first_name'   => $first_name,
					'last_name'    => $last_name,
					'display_name' => ! empty( $full_name ) ? $full_name : $first_name,
					'role'         => 'customer',
				) );

				if ( is_wp_error( $new_user_id ) ) {
					$notice_error = $new_user_id->get_error_message();
				} else {
					update_user_meta( $new_user_id, 'billing_first_name', $first_name );
					update_user_meta( $new_user_id, 'billing_last_name', $last_name );
					update_user_meta( $new_user_id, 'billing_email', $email );
					update_user_meta( $new_user_id, 'shipping_first_name', $first_name );
					update_user_meta( $new_user_id, 'shipping_last_name', $last_name );

					wp_set_current_user( $new_user_id );
					wp_set_auth_cookie( $new_user_id, true );
					wp_safe_redirect( home_url( '/my-account/' ) );
					exit;
				}
			}
		}
	}
}

// -------------------------------------------------------------------------
// FETCH REAL-TIME CUSTOMER DATA & METRICS
// -------------------------------------------------------------------------
$user_display_name = $current_user && $current_user->exists() ? ( $current_user->first_name ?: $current_user->display_name ) : '';
$user_full_name    = $current_user && $current_user->exists() ? ( trim( $current_user->first_name . ' ' . $current_user->last_name ) ?: $current_user->display_name ) : '';
$user_email_addr   = $current_user && $current_user->exists() ? $current_user->user_email : '';

// 1. Total Orders Metric
$customer_order_count = 0;
if ( $is_logged_in && function_exists( 'wc_get_customer_order_count' ) ) {
	$customer_order_count = wc_get_customer_order_count( $user_id );
}

// 2. Aura Rewards & Tier Metric (Lifetime spend based)
$customer_total_spent = 0;
if ( $is_logged_in && function_exists( 'wc_get_customer_total_spent' ) ) {
	$customer_total_spent = floatval( wc_get_customer_total_spent( $user_id ) );
}
$saved_points   = $is_logged_in ? get_user_meta( $user_id, 'aura_rewards_points', true ) : '';
$rewards_points = ( '' !== $saved_points && is_numeric( $saved_points ) ) ? intval( $saved_points ) : intval( floor( $customer_total_spent * 10 ) );

if ( $customer_total_spent >= 1000 ) {
	$tier_label = __( 'TIER: OPULENCE', 'aura-skincare' );
} elseif ( $customer_total_spent >= 500 ) {
	$tier_label = __( 'TIER: RADIANCE', 'aura-skincare' );
} elseif ( $customer_total_spent >= 200 ) {
	$tier_label = __( 'TIER: LUMINOUS', 'aura-skincare' );
} elseif ( $customer_total_spent > 0 ) {
	$tier_label = __( 'TIER: BOTANICAL', 'aura-skincare' );
} else {
	$tier_label = __( 'TIER: ESSENCE MEMBER', 'aura-skincare' );
}

// 3. Primary Address Data
$ship_first   = $is_logged_in ? get_user_meta( $user_id, 'shipping_first_name', true ) : '';
$ship_last    = $is_logged_in ? get_user_meta( $user_id, 'shipping_last_name', true ) : '';
$ship_company = $is_logged_in ? get_user_meta( $user_id, 'shipping_company', true ) : '';
$ship_addr1   = $is_logged_in ? get_user_meta( $user_id, 'shipping_address_1', true ) : '';
$ship_addr2   = $is_logged_in ? get_user_meta( $user_id, 'shipping_address_2', true ) : '';
$ship_city    = $is_logged_in ? get_user_meta( $user_id, 'shipping_city', true ) : '';
$ship_state   = $is_logged_in ? get_user_meta( $user_id, 'shipping_state', true ) : '';
$ship_post    = $is_logged_in ? get_user_meta( $user_id, 'shipping_postcode', true ) : '';
$ship_country = $is_logged_in ? get_user_meta( $user_id, 'shipping_country', true ) : '';

$bill_first   = $is_logged_in ? get_user_meta( $user_id, 'billing_first_name', true ) : '';
$bill_last    = $is_logged_in ? get_user_meta( $user_id, 'billing_last_name', true ) : '';
$bill_company = $is_logged_in ? get_user_meta( $user_id, 'billing_company', true ) : '';
$bill_addr1   = $is_logged_in ? get_user_meta( $user_id, 'billing_address_1', true ) : '';
$bill_addr2   = $is_logged_in ? get_user_meta( $user_id, 'billing_address_2', true ) : '';
$bill_city    = $is_logged_in ? get_user_meta( $user_id, 'billing_city', true ) : '';
$bill_state   = $is_logged_in ? get_user_meta( $user_id, 'billing_state', true ) : '';
$bill_post    = $is_logged_in ? get_user_meta( $user_id, 'billing_postcode', true ) : '';
$bill_country = $is_logged_in ? get_user_meta( $user_id, 'billing_country', true ) : '';
$bill_phone   = $is_logged_in ? get_user_meta( $user_id, 'billing_phone', true ) : '';
$bill_email   = $is_logged_in ? get_user_meta( $user_id, 'billing_email', true ) : '';

$has_shipping_address = ! empty( $ship_addr1 );
$has_billing_address  = ! empty( $bill_addr1 );

// 4. Real-Time Customer Orders
$customer_orders = array();
if ( $is_logged_in && function_exists( 'wc_get_orders' ) ) {
	$customer_orders = wc_get_orders( array(
		'customer' => $user_id,
		'limit'    => 20,
		'orderby'  => 'date',
		'order'    => 'DESC',
	) );
}

get_header();
?>

<?php if ( ! $is_logged_in ) : ?>
	<!-- ====================================================================
	     LOGGED OUT STATE: LUXURY AUTH PORTAL
	     ==================================================================== -->
	<main id="main-content" class="account-auth-container">
		
		<!-- 1. Login Card -->
		<div class="account-auth-card" id="auth-login-card">
			<h1 class="auth-card-title"><?php esc_html_e( 'Welcome Back', 'aura-skincare' ); ?></h1>
			<p class="auth-card-subtitle"><?php esc_html_e( 'Sign in to access your exclusive rituals and history.', 'aura-skincare' ); ?></p>

			<?php if ( ! empty( $notice_error ) ) : ?>
				<div class="account-notice notice-error" style="text-align: left;">
					<svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
					<span><?php echo wp_kses_post( $notice_error ); ?></span>
				</div>
			<?php endif; ?>

			<form class="auth-form" method="post" action="<?php echo esc_url( remove_query_arg( array( 'preview_dashboard' ) ) ); ?>">
				
				<input type="hidden" name="aura_auth_action" value="login">
				<?php wp_nonce_field( 'aura_login_action', 'aura_login_nonce' ); ?>

				<!-- Email Address -->
				<div class="auth-field-group">
					<label class="auth-label" for="login-email"><?php esc_html_e( 'EMAIL OR USERNAME', 'aura-skincare' ); ?></label>
					<input 
						type="text" 
						id="login-email" 
						name="log" 
						class="auth-input" 
						placeholder="<?php esc_attr_e( 'Enter your email or username', 'aura-skincare' ); ?>" 
						required
						autocomplete="username"
					>
				</div>

				<!-- Password -->
				<div class="auth-field-group">
					<div class="auth-field-header">
						<label class="auth-label" for="login-password"><?php esc_html_e( 'PASSWORD', 'aura-skincare' ); ?></label>
						<a href="<?php echo esc_url( wp_lostpassword_url() ); ?>" class="auth-forgot-link"><?php esc_html_e( 'LOST YOUR PASSWORD?', 'aura-skincare' ); ?></a>
					</div>
					<div class="auth-input-wrapper">
						<input 
							type="password" 
							id="login-password" 
							name="pwd" 
							class="auth-input" 
							placeholder="<?php esc_attr_e( 'Enter your password', 'aura-skincare' ); ?>" 
							required
							autocomplete="current-password"
						>
						<button type="button" class="auth-password-toggle" aria-label="<?php esc_attr_e( 'Toggle password visibility', 'aura-skincare' ); ?>" onclick="togglePasswordVisibility('login-password', this);">
							<svg class="eye-icon" viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
								<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
								<circle cx="12" cy="12" r="3"></circle>
							</svg>
						</button>
					</div>
				</div>

				<!-- Remember Me -->
				<div class="auth-remember-row">
					<input type="checkbox" id="rememberme" name="rememberme" value="forever" class="auth-checkbox" checked>
					<label for="rememberme" class="auth-checkbox-label"><?php esc_html_e( 'Remember me', 'aura-skincare' ); ?></label>
				</div>

				<!-- Sign In Button -->
				<button type="submit" class="auth-submit-btn">
					<?php esc_html_e( 'SIGN IN', 'aura-skincare' ); ?>
				</button>

			</form>

			<div class="auth-card-footer">
				<span><?php esc_html_e( 'Don\'t have an account?', 'aura-skincare' ); ?></span>
				<a href="javascript:void(0)" class="auth-switch-link" id="switch-to-register"><?php esc_html_e( 'Create one', 'aura-skincare' ); ?></a>
			</div>
		</div>

		<!-- 2. Register Card -->
		<div class="account-auth-card" id="auth-register-card" style="display: none;">
			<h1 class="auth-card-title"><?php esc_html_e( 'Create Account', 'aura-skincare' ); ?></h1>
			<p class="auth-card-subtitle"><?php esc_html_e( 'Join the Aura Society for exclusive rituals and rewards.', 'aura-skincare' ); ?></p>

			<form class="auth-form" method="post" action="<?php echo esc_url( remove_query_arg( array( 'preview_dashboard' ) ) ); ?>">
				
				<input type="hidden" name="aura_auth_action" value="register">
				<?php wp_nonce_field( 'aura_register_action', 'aura_register_nonce' ); ?>

				<!-- Full Name -->
				<div class="auth-field-group">
					<label class="auth-label" for="reg-name"><?php esc_html_e( 'FULL NAME', 'aura-skincare' ); ?></label>
					<input 
						type="text" 
						id="reg-name" 
						name="full_name" 
						class="auth-input" 
						placeholder="<?php esc_attr_e( 'Enter your full name', 'aura-skincare' ); ?>" 
						required
					>
				</div>

				<!-- Email Address -->
				<div class="auth-field-group">
					<label class="auth-label" for="reg-email"><?php esc_html_e( 'EMAIL ADDRESS', 'aura-skincare' ); ?></label>
					<input 
						type="email" 
						id="reg-email" 
						name="user_email" 
						class="auth-input" 
						placeholder="<?php esc_attr_e( 'Enter your email', 'aura-skincare' ); ?>" 
						required
					>
				</div>

				<!-- Password -->
				<div class="auth-field-group">
					<label class="auth-label" for="reg-password"><?php esc_html_e( 'PASSWORD', 'aura-skincare' ); ?></label>
					<div class="auth-input-wrapper">
						<input 
							type="password" 
							id="reg-password" 
							name="user_password" 
							class="auth-input" 
							placeholder="<?php esc_attr_e( 'Create a password (min 6 characters)', 'aura-skincare' ); ?>" 
							required
							minlength="6"
						>
						<button type="button" class="auth-password-toggle" aria-label="<?php esc_attr_e( 'Toggle password visibility', 'aura-skincare' ); ?>" onclick="togglePasswordVisibility('reg-password', this);">
							<svg class="eye-icon" viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
								<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
								<circle cx="12" cy="12" r="3"></circle>
							</svg>
						</button>
					</div>
				</div>

				<!-- Create Account Button -->
				<button type="submit" class="auth-submit-btn">
					<?php esc_html_e( 'CREATE ACCOUNT', 'aura-skincare' ); ?>
				</button>

			</form>

			<div class="auth-card-footer">
				<span><?php esc_html_e( 'Already have an account?', 'aura-skincare' ); ?></span>
				<a href="javascript:void(0)" class="auth-switch-link" id="switch-to-login"><?php esc_html_e( 'Sign in', 'aura-skincare' ); ?></a>
			</div>
		</div>

	</main>

<?php else : ?>
	<!-- ====================================================================
	     LOGGED IN STATE: REAL-TIME DYNAMIC ACCOUNT DASHBOARD
	     ==================================================================== -->
	<main id="main-content" class="account-portal-page">
		<div class="aura-container-wide">

			<?php if ( ! empty( $notice_success ) ) : ?>
				<div class="account-notice notice-success">
					<svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
					<span><?php echo esc_html( $notice_success ); ?></span>
				</div>
			<?php endif; ?>

			<?php if ( ! empty( $notice_error ) ) : ?>
				<div class="account-notice notice-error">
					<svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
					<span><?php echo wp_kses_post( $notice_error ); ?></span>
				</div>
			<?php endif; ?>

			<div class="account-portal-layout">
				
				<!-- Left Vertical Navigation Sidebar -->
				<aside class="account-sidebar">
					<h1 class="account-sidebar-title"><?php esc_html_e( 'My Account', 'aura-skincare' ); ?></h1>
					
					<ul class="account-nav-list" role="tablist">
						
						<!-- 1. Dashboard -->
						<li class="account-nav-item">
							<button type="button" class="account-nav-btn <?php echo ( 'dashboard' === $active_tab ) ? 'active' : ''; ?>" data-tab="dashboard" role="tab" aria-selected="<?php echo ( 'dashboard' === $active_tab ) ? 'true' : 'false'; ?>">
								<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
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
							<button type="button" class="account-nav-btn <?php echo ( 'orders' === $active_tab ) ? 'active' : ''; ?>" data-tab="orders" role="tab" aria-selected="<?php echo ( 'orders' === $active_tab ) ? 'true' : 'false'; ?>">
								<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
									<path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path>
									<line x1="3" y1="6" x2="21" y2="6"></line>
									<path d="M16 10a4 4 0 0 1-8 0"></path>
								</svg>
								<span><?php esc_html_e( 'Orders', 'aura-skincare' ); ?></span>
							</button>
						</li>

						<!-- 3. Addresses -->
						<li class="account-nav-item">
							<button type="button" class="account-nav-btn <?php echo ( 'addresses' === $active_tab ) ? 'active' : ''; ?>" data-tab="addresses" role="tab" aria-selected="<?php echo ( 'addresses' === $active_tab ) ? 'true' : 'false'; ?>">
								<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
									<path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
									<circle cx="12" cy="10" r="3"></circle>
								</svg>
								<span><?php esc_html_e( 'Addresses', 'aura-skincare' ); ?></span>
							</button>
						</li>

						<!-- 4. Account Details -->
						<li class="account-nav-item">
							<button type="button" class="account-nav-btn <?php echo ( 'details' === $active_tab ) ? 'active' : ''; ?>" data-tab="details" role="tab" aria-selected="<?php echo ( 'details' === $active_tab ) ? 'true' : 'false'; ?>">
								<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
									<circle cx="12" cy="12" r="3"></circle>
									<path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path>
								</svg>
								<span><?php esc_html_e( 'Account Details', 'aura-skincare' ); ?></span>
							</button>
						</li>

						<!-- 5. Logout -->
						<li class="account-nav-item">
							<a href="<?php echo esc_url( wp_logout_url( home_url( '/my-account/' ) ) ); ?>" class="account-nav-btn logout-btn">
								<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
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
					
					<!-- PANE 1: DASHBOARD -->
					<div class="account-pane <?php echo ( 'dashboard' === $active_tab ) ? 'active' : ''; ?>" id="pane-dashboard">
						
						<!-- Welcome Hero Header -->
						<div class="account-welcome-header">
							<h2 class="account-welcome-title"><?php printf( esc_html__( 'Welcome back, %s', 'aura-skincare' ), esc_html( $user_display_name ) ); ?></h2>
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
								<div class="metric-card-value"><?php echo esc_html( $customer_order_count ); ?></div>
								<a href="javascript:void(0)" class="metric-card-action" onclick="document.querySelector('[data-tab=\'orders\']').click();"><?php esc_html_e( 'VIEW ALL', 'aura-skincare' ); ?></a>
							</div>

							<!-- Card 2: Aura Rewards -->
							<div class="account-metric-card">
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
								<div class="metric-card-value"><?php echo esc_html( number_format( $rewards_points ) ); ?></div>
								<div class="metric-card-subtext"><?php echo esc_html( $tier_label ); ?></div>
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
									<?php if ( $has_shipping_address ) : ?>
										<strong><?php echo esc_html( trim( $ship_first . ' ' . $ship_last ) ?: $user_full_name ); ?></strong><br>
										<?php echo esc_html( $ship_addr1 ); ?><?php echo ! empty( $ship_addr2 ) ? ', ' . esc_html( $ship_addr2 ) : ''; ?><br>
										<?php echo esc_html( trim( $ship_city . ( $ship_state ? ', ' . $ship_state : '' ) . ( $ship_post ? ' ' . $ship_post : '' ) ) ); ?>
									<?php elseif ( $has_billing_address ) : ?>
										<strong><?php echo esc_html( trim( $bill_first . ' ' . $bill_last ) ?: $user_full_name ); ?></strong><br>
										<?php echo esc_html( $bill_addr1 ); ?><?php echo ! empty( $bill_addr2 ) ? ', ' . esc_html( $bill_addr2 ) : ''; ?><br>
										<?php echo esc_html( trim( $bill_city . ( $bill_state ? ', ' . $bill_state : '' ) . ( $bill_post ? ' ' . $bill_post : '' ) ) ); ?>
									<?php else : ?>
										<span style="color: var(--color-text-muted); font-style: italic;"><?php esc_html_e( 'No primary address configured yet.', 'aura-skincare' ); ?></span>
									<?php endif; ?>
								</div>
								<a href="javascript:void(0)" class="metric-card-action" onclick="document.querySelector('[data-tab=\'addresses\']').click();">
									<?php echo ( $has_shipping_address || $has_billing_address ) ? esc_html__( 'EDIT', 'aura-skincare' ) : esc_html__( 'ADD ADDRESS', 'aura-skincare' ); ?>
								</a>
							</div>

						</div>

						<!-- Recent Orders Section -->
						<h3 class="account-section-heading"><?php esc_html_e( 'Recent Orders', 'aura-skincare' ); ?></h3>
						
						<?php if ( ! empty( $customer_orders ) ) : ?>
							<div class="orders-table-wrapper">
								<table class="account-orders-table">
									<thead>
										<tr>
											<th><?php esc_html_e( 'ORDER #', 'aura-skincare' ); ?></th>
											<th><?php esc_html_e( 'DATE', 'aura-skincare' ); ?></th>
											<th><?php esc_html_e( 'STATUS', 'aura-skincare' ); ?></th>
											<th style="text-align: right;"><?php esc_html_e( 'TOTAL', 'aura-skincare' ); ?></th>
											<th style="text-align: right;"><?php esc_html_e( 'ACTION', 'aura-skincare' ); ?></th>
										</tr>
									</thead>
									<tbody>
										<?php
										$recent_slice = array_slice( $customer_orders, 0, 5 );
										foreach ( $recent_slice as $order ) :
											$status      = $order->get_status();
											$status_name = function_exists( 'wc_get_order_status_name' ) ? wc_get_order_status_name( $status ) : ucfirst( $status );
											$order_date  = $order->get_date_created() ? $order->get_date_created()->date_i18n( get_option( 'date_format', 'M d, Y' ) ) : '';
											?>
											<tr>
												<td class="order-number">#<?php echo esc_html( $order->get_order_number() ); ?></td>
												<td class="order-date"><?php echo esc_html( $order_date ); ?></td>
												<td><span class="order-status-badge status-<?php echo esc_attr( sanitize_html_class( $status ) ); ?>"><?php echo esc_html( $status_name ); ?></span></td>
												<td class="order-total" style="text-align: right;"><?php echo wp_kses_post( $order->get_formatted_order_total() ); ?></td>
												<td style="text-align: right;"><a href="<?php echo esc_url( $order->get_view_order_url() ); ?>" class="order-action-link"><?php esc_html_e( 'View', 'aura-skincare' ); ?></a></td>
											</tr>
										<?php endforeach; ?>
									</tbody>
								</table>
							</div>
						<?php else : ?>
							<div class="account-empty-state">
								<svg class="account-empty-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
									<path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path>
									<line x1="3" y1="6" x2="21" y2="6"></line>
									<path d="M16 10a4 4 0 0 1-8 0"></path>
								</svg>
								<h4 class="account-empty-title"><?php esc_html_e( 'No Orders Found', 'aura-skincare' ); ?></h4>
								<p class="account-empty-text"><?php esc_html_e( 'You haven\'t placed any ritual orders yet. Explore our botanical formulas to begin.', 'aura-skincare' ); ?></p>
								<a href="<?php echo esc_url( home_url( '/shop/' ) ); ?>" class="aura-btn aura-btn-primary">
									<span><?php esc_html_e( 'Explore Collection', 'aura-skincare' ); ?></span>
								</a>
							</div>
						<?php endif; ?>

					</div>

					<!-- PANE 2: ORDERS -->
					<div class="account-pane <?php echo ( 'orders' === $active_tab ) ? 'active' : ''; ?>" id="pane-orders">
						<div class="account-welcome-header">
							<h2 class="account-welcome-title"><?php esc_html_e( 'Order History', 'aura-skincare' ); ?></h2>
							<p class="account-welcome-subtitle"><?php esc_html_e( 'Track active shipments and view past botanical rituals orders.', 'aura-skincare' ); ?></p>
						</div>

						<?php if ( ! empty( $customer_orders ) ) : ?>
							<div class="orders-table-wrapper">
								<table class="account-orders-table">
									<thead>
										<tr>
											<th><?php esc_html_e( 'ORDER #', 'aura-skincare' ); ?></th>
											<th><?php esc_html_e( 'DATE', 'aura-skincare' ); ?></th>
											<th><?php esc_html_e( 'ITEMS', 'aura-skincare' ); ?></th>
											<th><?php esc_html_e( 'STATUS', 'aura-skincare' ); ?></th>
											<th style="text-align: right;"><?php esc_html_e( 'TOTAL', 'aura-skincare' ); ?></th>
											<th style="text-align: right;"><?php esc_html_e( 'ACTION', 'aura-skincare' ); ?></th>
										</tr>
									</thead>
									<tbody>
										<?php
										foreach ( $customer_orders as $order ) :
											$status      = $order->get_status();
											$status_name = function_exists( 'wc_get_order_status_name' ) ? wc_get_order_status_name( $status ) : ucfirst( $status );
											$order_date  = $order->get_date_created() ? $order->get_date_created()->date_i18n( get_option( 'date_format', 'M d, Y' ) ) : '';
											
											$items_summary = array();
											foreach ( $order->get_items() as $item ) {
												$items_summary[] = $item->get_name() . ' (&times;' . $item->get_quantity() . ')';
											}
											$items_text = ! empty( $items_summary ) ? implode( ', ', $items_summary ) : esc_html__( 'Items', 'aura-skincare' );
											?>
											<tr>
												<td class="order-number">#<?php echo esc_html( $order->get_order_number() ); ?></td>
												<td class="order-date"><?php echo esc_html( $order_date ); ?></td>
												<td style="max-width: 260px; font-size: 0.85rem; color: var(--color-text-muted); line-height: 1.4;"><?php echo esc_html( $items_text ); ?></td>
												<td><span class="order-status-badge status-<?php echo esc_attr( sanitize_html_class( $status ) ); ?>"><?php echo esc_html( $status_name ); ?></span></td>
												<td class="order-total" style="text-align: right;"><?php echo wp_kses_post( $order->get_formatted_order_total() ); ?></td>
												<td style="text-align: right;"><a href="<?php echo esc_url( $order->get_view_order_url() ); ?>" class="order-action-link"><?php esc_html_e( 'View Details', 'aura-skincare' ); ?></a></td>
											</tr>
										<?php endforeach; ?>
									</tbody>
								</table>
							</div>
						<?php else : ?>
							<div class="account-empty-state">
								<svg class="account-empty-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
									<path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path>
									<line x1="3" y1="6" x2="21" y2="6"></line>
									<path d="M16 10a4 4 0 0 1-8 0"></path>
								</svg>
								<h4 class="account-empty-title"><?php esc_html_e( 'No Order History Yet', 'aura-skincare' ); ?></h4>
								<p class="account-empty-text"><?php esc_html_e( 'Your personal ritual history will appear here once you make your first purchase.', 'aura-skincare' ); ?></p>
								<a href="<?php echo esc_url( home_url( '/shop/' ) ); ?>" class="aura-btn aura-btn-primary">
									<span><?php esc_html_e( 'Shop Botanical Formulations', 'aura-skincare' ); ?></span>
								</a>
							</div>
						<?php endif; ?>
					</div>

					<!-- PANE 3: ADDRESSES -->
					<div class="account-pane <?php echo ( 'addresses' === $active_tab ) ? 'active' : ''; ?>" id="pane-addresses">
						<div class="account-welcome-header">
							<h2 class="account-welcome-title"><?php esc_html_e( 'Address Book', 'aura-skincare' ); ?></h2>
							<p class="account-welcome-subtitle"><?php esc_html_e( 'Manage your primary shipping and billing addresses for seamless checkout.', 'aura-skincare' ); ?></p>
						</div>

						<div class="address-card-container">
							
							<!-- 1. Shipping Address Card -->
							<div class="address-box">
								<div class="address-box-header">
									<h3 class="address-box-title"><?php esc_html_e( 'Shipping Address', 'aura-skincare' ); ?></h3>
									<?php if ( $has_shipping_address ) : ?>
										<span class="address-badge-default"><?php esc_html_e( 'DEFAULT', 'aura-skincare' ); ?></span>
									<?php endif; ?>
								</div>

								<div class="address-box-content">
									<?php if ( $has_shipping_address ) : ?>
										<strong><?php echo esc_html( trim( $ship_first . ' ' . $ship_last ) ?: $user_full_name ); ?></strong><br>
										<?php if ( ! empty( $ship_company ) ) : ?><?php echo esc_html( $ship_company ); ?><br><?php endif; ?>
										<?php echo esc_html( $ship_addr1 ); ?><?php echo ! empty( $ship_addr2 ) ? ', ' . esc_html( $ship_addr2 ) : ''; ?><br>
										<?php echo esc_html( trim( $ship_city . ( $ship_state ? ', ' . $ship_state : '' ) . ( $ship_post ? ' ' . $ship_post : '' ) ) ); ?><br>
										<?php echo esc_html( $ship_country ); ?>
									<?php else : ?>
										<span style="color: var(--color-text-muted); font-style: italic;"><?php esc_html_e( 'You have not set up a shipping address yet.', 'aura-skincare' ); ?></span>
									<?php endif; ?>
								</div>

								<button type="button" class="aura-btn aura-btn-secondary" style="padding: 0.6rem 1.2rem; font-size: 0.8rem; margin-top: auto;" onclick="toggleAddressPanel('shipping-edit-panel');">
									<?php echo ( $has_shipping_address ) ? esc_html__( 'Edit Shipping Address', 'aura-skincare' ) : esc_html__( 'Add Shipping Address', 'aura-skincare' ); ?>
								</button>
							</div>

							<!-- 2. Billing Address Card -->
							<div class="address-box">
								<div class="address-box-header">
									<h3 class="address-box-title"><?php esc_html_e( 'Billing Address', 'aura-skincare' ); ?></h3>
									<?php if ( $has_billing_address ) : ?>
										<span class="address-badge-default"><?php esc_html_e( 'DEFAULT', 'aura-skincare' ); ?></span>
									<?php endif; ?>
								</div>

								<div class="address-box-content">
									<?php if ( $has_billing_address ) : ?>
										<strong><?php echo esc_html( trim( $bill_first . ' ' . $bill_last ) ?: $user_full_name ); ?></strong><br>
										<?php if ( ! empty( $bill_company ) ) : ?><?php echo esc_html( $bill_company ); ?><br><?php endif; ?>
										<?php echo esc_html( $bill_addr1 ); ?><?php echo ! empty( $bill_addr2 ) ? ', ' . esc_html( $bill_addr2 ) : ''; ?><br>
										<?php echo esc_html( trim( $bill_city . ( $bill_state ? ', ' . $bill_state : '' ) . ( $bill_post ? ' ' . $bill_post : '' ) ) ); ?><br>
										<?php echo esc_html( $bill_country ); ?>
										<?php if ( ! empty( $bill_phone ) ) : ?><br><?php echo esc_html__( 'Phone:', 'aura-skincare' ) . ' ' . esc_html( $bill_phone ); ?><?php endif; ?>
									<?php else : ?>
										<span style="color: var(--color-text-muted); font-style: italic;"><?php esc_html_e( 'You have not set up a billing address yet.', 'aura-skincare' ); ?></span>
									<?php endif; ?>
								</div>

								<button type="button" class="aura-btn aura-btn-secondary" style="padding: 0.6rem 1.2rem; font-size: 0.8rem; margin-top: auto;" onclick="toggleAddressPanel('billing-edit-panel');">
									<?php echo ( $has_billing_address ) ? esc_html__( 'Edit Billing Address', 'aura-skincare' ) : esc_html__( 'Add Billing Address', 'aura-skincare' ); ?>
								</button>
							</div>

						</div>

						<!-- Shipping Address Edit Form Panel -->
						<div class="address-edit-panel" id="shipping-edit-panel">
							<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
								<h3 style="font-family: var(--font-heading); font-size: 1.35rem; margin: 0;"><?php esc_html_e( 'Edit Shipping Address', 'aura-skincare' ); ?></h3>
								<button type="button" onclick="toggleAddressPanel('shipping-edit-panel');" style="background: none; border: none; font-size: 1.2rem; cursor: pointer; color: var(--color-text-muted);">&times;</button>
							</div>

							<form method="post" action="<?php echo esc_url( remove_query_arg( array( 'preview_dashboard' ) ) ); ?>">
								<input type="hidden" name="aura_account_action" value="save_address">
								<input type="hidden" name="address_type" value="shipping">
								<?php wp_nonce_field( 'aura_save_address', 'aura_address_nonce' ); ?>

								<div class="account-form-grid">
									<div class="account-form-group">
										<label class="account-form-label"><?php esc_html_e( 'First Name', 'aura-skincare' ); ?></label>
										<input type="text" name="shipping_first_name" class="account-form-input" value="<?php echo esc_attr( $ship_first ?: $current_user->first_name ); ?>" required>
									</div>
									<div class="account-form-group">
										<label class="account-form-label"><?php esc_html_e( 'Last Name', 'aura-skincare' ); ?></label>
										<input type="text" name="shipping_last_name" class="account-form-input" value="<?php echo esc_attr( $ship_last ?: $current_user->last_name ); ?>" required>
									</div>
									<div class="account-form-group full-width">
										<label class="account-form-label"><?php esc_html_e( 'Company Name (Optional)', 'aura-skincare' ); ?></label>
										<input type="text" name="shipping_company" class="account-form-input" value="<?php echo esc_attr( $ship_company ); ?>">
									</div>
									<div class="account-form-group full-width">
										<label class="account-form-label"><?php esc_html_e( 'Street Address', 'aura-skincare' ); ?></label>
										<input type="text" name="shipping_address_1" class="account-form-input" placeholder="<?php esc_attr_e( 'House number and street name', 'aura-skincare' ); ?>" value="<?php echo esc_attr( $ship_addr1 ); ?>" required>
									</div>
									<div class="account-form-group full-width">
										<label class="account-form-label"><?php esc_html_e( 'Apartment, suite, unit, etc. (Optional)', 'aura-skincare' ); ?></label>
										<input type="text" name="shipping_address_2" class="account-form-input" value="<?php echo esc_attr( $ship_addr2 ); ?>">
									</div>
									<div class="account-form-group">
										<label class="account-form-label"><?php esc_html_e( 'Town / City', 'aura-skincare' ); ?></label>
										<input type="text" name="shipping_city" class="account-form-input" value="<?php echo esc_attr( $ship_city ); ?>" required>
									</div>
									<div class="account-form-group">
										<label class="account-form-label"><?php esc_html_e( 'State / Province / Region', 'aura-skincare' ); ?></label>
										<input type="text" name="shipping_state" class="account-form-input" value="<?php echo esc_attr( $ship_state ); ?>">
									</div>
									<div class="account-form-group">
										<label class="account-form-label"><?php esc_html_e( 'Postcode / ZIP', 'aura-skincare' ); ?></label>
										<input type="text" name="shipping_postcode" class="account-form-input" value="<?php echo esc_attr( $ship_post ); ?>" required>
									</div>
									<div class="account-form-group">
										<label class="account-form-label"><?php esc_html_e( 'Country', 'aura-skincare' ); ?></label>
										<input type="text" name="shipping_country" class="account-form-input" value="<?php echo esc_attr( $ship_country ?: 'United States' ); ?>" required>
									</div>
								</div>

								<button type="submit" class="aura-btn aura-btn-primary" style="padding: 0.85rem 2rem;">
									<span><?php esc_html_e( 'Save Shipping Address', 'aura-skincare' ); ?></span>
								</button>
							</form>
						</div>

						<!-- Billing Address Edit Form Panel -->
						<div class="address-edit-panel" id="billing-edit-panel">
							<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
								<h3 style="font-family: var(--font-heading); font-size: 1.35rem; margin: 0;"><?php esc_html_e( 'Edit Billing Address', 'aura-skincare' ); ?></h3>
								<button type="button" onclick="toggleAddressPanel('billing-edit-panel');" style="background: none; border: border: none; font-size: 1.2rem; cursor: pointer; color: var(--color-text-muted);">&times;</button>
							</div>

							<form method="post" action="<?php echo esc_url( remove_query_arg( array( 'preview_dashboard' ) ) ); ?>">
								<input type="hidden" name="aura_account_action" value="save_address">
								<input type="hidden" name="address_type" value="billing">
								<?php wp_nonce_field( 'aura_save_address', 'aura_address_nonce' ); ?>

								<div class="account-form-grid">
									<div class="account-form-group">
										<label class="account-form-label"><?php esc_html_e( 'First Name', 'aura-skincare' ); ?></label>
										<input type="text" name="billing_first_name" class="account-form-input" value="<?php echo esc_attr( $bill_first ?: $current_user->first_name ); ?>" required>
									</div>
									<div class="account-form-group">
										<label class="account-form-label"><?php esc_html_e( 'Last Name', 'aura-skincare' ); ?></label>
										<input type="text" name="billing_last_name" class="account-form-input" value="<?php echo esc_attr( $bill_last ?: $current_user->last_name ); ?>" required>
									</div>
									<div class="account-form-group full-width">
										<label class="account-form-label"><?php esc_html_e( 'Company Name (Optional)', 'aura-skincare' ); ?></label>
										<input type="text" name="billing_company" class="account-form-input" value="<?php echo esc_attr( $bill_company ); ?>">
									</div>
									<div class="account-form-group full-width">
										<label class="account-form-label"><?php esc_html_e( 'Street Address', 'aura-skincare' ); ?></label>
										<input type="text" name="billing_address_1" class="account-form-input" placeholder="<?php esc_attr_e( 'House number and street name', 'aura-skincare' ); ?>" value="<?php echo esc_attr( $bill_addr1 ); ?>" required>
									</div>
									<div class="account-form-group full-width">
										<label class="account-form-label"><?php esc_html_e( 'Apartment, suite, unit, etc. (Optional)', 'aura-skincare' ); ?></label>
										<input type="text" name="billing_address_2" class="account-form-input" value="<?php echo esc_attr( $bill_addr2 ); ?>">
									</div>
									<div class="account-form-group">
										<label class="account-form-label"><?php esc_html_e( 'Town / City', 'aura-skincare' ); ?></label>
										<input type="text" name="billing_city" class="account-form-input" value="<?php echo esc_attr( $bill_city ); ?>" required>
									</div>
									<div class="account-form-group">
										<label class="account-form-label"><?php esc_html_e( 'State / Province / Region', 'aura-skincare' ); ?></label>
										<input type="text" name="billing_state" class="account-form-input" value="<?php echo esc_attr( $bill_state ); ?>">
									</div>
									<div class="account-form-group">
										<label class="account-form-label"><?php esc_html_e( 'Postcode / ZIP', 'aura-skincare' ); ?></label>
										<input type="text" name="billing_postcode" class="account-form-input" value="<?php echo esc_attr( $bill_post ); ?>" required>
									</div>
									<div class="account-form-group">
										<label class="account-form-label"><?php esc_html_e( 'Country', 'aura-skincare' ); ?></label>
										<input type="text" name="billing_country" class="account-form-input" value="<?php echo esc_attr( $bill_country ?: 'United States' ); ?>" required>
									</div>
									<div class="account-form-group">
										<label class="account-form-label"><?php esc_html_e( 'Phone (Optional)', 'aura-skincare' ); ?></label>
										<input type="tel" name="billing_phone" class="account-form-input" value="<?php echo esc_attr( $bill_phone ); ?>">
									</div>
									<div class="account-form-group">
										<label class="account-form-label"><?php esc_html_e( 'Email Address', 'aura-skincare' ); ?></label>
										<input type="email" name="billing_email" class="account-form-input" value="<?php echo esc_attr( $bill_email ?: $user_email_addr ); ?>" required>
									</div>
								</div>

								<button type="submit" class="aura-btn aura-btn-primary" style="padding: 0.85rem 2rem;">
									<span><?php esc_html_e( 'Save Billing Address', 'aura-skincare' ); ?></span>
								</button>
							</form>
						</div>

					</div>

					<!-- PANE 4: ACCOUNT DETAILS -->
					<div class="account-pane <?php echo ( 'details' === $active_tab ) ? 'active' : ''; ?>" id="pane-details">
						<div class="account-welcome-header">
							<h2 class="account-welcome-title"><?php esc_html_e( 'Account Details', 'aura-skincare' ); ?></h2>
							<p class="account-welcome-subtitle"><?php esc_html_e( 'Update your personal profile, email, and security credentials.', 'aura-skincare' ); ?></p>
						</div>

						<form method="post" action="<?php echo esc_url( remove_query_arg( array( 'preview_dashboard' ) ) ); ?>" style="max-width: 680px;">
							<input type="hidden" name="aura_account_action" value="save_account_details">
							<?php wp_nonce_field( 'aura_save_details', 'aura_details_nonce' ); ?>

							<div class="account-form-grid">
								<div class="account-form-group">
									<label class="account-form-label" for="account_first_name"><?php esc_html_e( 'First Name', 'aura-skincare' ); ?></label>
									<input type="text" id="account_first_name" name="first_name" class="account-form-input" value="<?php echo esc_attr( $current_user->first_name ); ?>" required>
								</div>
								<div class="account-form-group">
									<label class="account-form-label" for="account_last_name"><?php esc_html_e( 'Last Name', 'aura-skincare' ); ?></label>
									<input type="text" id="account_last_name" name="last_name" class="account-form-input" value="<?php echo esc_attr( $current_user->last_name ); ?>">
								</div>
								<div class="account-form-group full-width">
									<label class="account-form-label" for="account_display_name"><?php esc_html_e( 'Display Name', 'aura-skincare' ); ?></label>
									<input type="text" id="account_display_name" name="display_name" class="account-form-input" value="<?php echo esc_attr( $current_user->display_name ); ?>" required>
									<small style="color: var(--color-text-muted); font-size: 0.78rem; margin-top: 0.2rem;"><?php esc_html_e( 'This name will be displayed in your account portal and reviews.', 'aura-skincare' ); ?></small>
								</div>
								<div class="account-form-group full-width">
									<label class="account-form-label" for="account_email"><?php esc_html_e( 'Email Address', 'aura-skincare' ); ?></label>
									<input type="email" id="account_email" name="user_email" class="account-form-input" value="<?php echo esc_attr( $user_email_addr ); ?>" required>
								</div>
							</div>

							<h3 style="font-family: var(--font-heading); font-size: 1.35rem; color: var(--color-heading); margin: 2.2rem 0 1rem 0;"><?php esc_html_e( 'Password Change', 'aura-skincare' ); ?></h3>

							<div class="account-form-grid">
								<div class="account-form-group full-width">
									<label class="account-form-label" for="password_current"><?php esc_html_e( 'Current Password (leave blank to leave unchanged)', 'aura-skincare' ); ?></label>
									<input type="password" id="password_current" name="password_current" class="account-form-input" autocomplete="off">
								</div>
								<div class="account-form-group">
									<label class="account-form-label" for="password_1"><?php esc_html_e( 'New Password (leave blank to leave unchanged)', 'aura-skincare' ); ?></label>
									<input type="password" id="password_1" name="password_1" class="account-form-input" autocomplete="off">
								</div>
								<div class="account-form-group">
									<label class="account-form-label" for="password_2"><?php esc_html_e( 'Confirm New Password', 'aura-skincare' ); ?></label>
									<input type="password" id="password_2" name="password_2" class="account-form-input" autocomplete="off">
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
<?php endif; ?>

<script>
function togglePasswordVisibility(inputId, btn) {
	var input = document.getElementById(inputId);
	if (!input) return;
	if (input.type === 'password') {
		input.type = 'text';
		btn.style.color = 'var(--color-gold)';
	} else {
		input.type = 'password';
		btn.style.color = 'var(--color-text-muted)';
	}
}

function toggleAddressPanel(panelId) {
	var panel = document.getElementById(panelId);
	if (!panel) return;
	if (panel.classList.contains('active')) {
		panel.classList.remove('active');
	} else {
		document.querySelectorAll('.address-edit-panel').forEach(function(p) { p.classList.remove('active'); });
		panel.classList.add('active');
		panel.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
	}
}

document.addEventListener('DOMContentLoaded', function() {
	// Auth Switcher
	var loginCard = document.getElementById('auth-login-card');
	var registerCard = document.getElementById('auth-register-card');
	var switchToRegister = document.getElementById('switch-to-register');
	var switchToLogin = document.getElementById('switch-to-login');

	if (switchToRegister && switchToLogin) {
		switchToRegister.addEventListener('click', function(e) {
			e.preventDefault();
			loginCard.style.display = 'none';
			registerCard.style.display = 'block';
		});

		switchToLogin.addEventListener('click', function(e) {
			e.preventDefault();
			registerCard.style.display = 'none';
			loginCard.style.display = 'block';
		});
	}

	// Dashboard Tabs
	var navBtns = document.querySelectorAll('.account-nav-btn[data-tab]');
	var panes = document.querySelectorAll('.account-pane');

	function activateTab(targetTab) {
		if (!targetTab) return;
		navBtns.forEach(function(b) {
			if (b.getAttribute('data-tab') === targetTab) {
				b.classList.add('active');
				b.setAttribute('aria-selected', 'true');
			} else {
				b.classList.remove('active');
				b.setAttribute('aria-selected', 'false');
			}
		});

		panes.forEach(function(p) {
			if (p.id === 'pane-' + targetTab) {
				p.classList.add('active');
			} else {
				p.classList.remove('active');
			}
		});
	}

	navBtns.forEach(function(btn) {
		btn.addEventListener('click', function(e) {
			e.preventDefault();
			var targetTab = this.getAttribute('data-tab');
			activateTab(targetTab);
			if (history.pushState) {
				var newUrl = window.location.pathname + '?tab=' + targetTab;
				history.pushState(null, null, newUrl);
			}
		});
	});

	// Check URL hash on load
	if (window.location.hash) {
		var hashTab = window.location.hash.replace('#', '');
		if (document.getElementById('pane-' + hashTab)) {
			activateTab(hashTab);
		}
	}
});
</script>

<?php
get_footer();
