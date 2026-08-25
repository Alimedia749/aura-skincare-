<?php
/**
 * Template Name: Login & Sign In (Stitch Design)
 * Template Post Type: page
 *
 * @package Aura_Skincare
 */

// If already logged in, redirect to My Account portal
if ( is_user_logged_in() ) {
	wp_safe_redirect( home_url( '/my-account/' ) );
	exit;
}

$redirect_to  = isset( $_REQUEST['redirect_to'] ) ? esc_url_raw( $_REQUEST['redirect_to'] ) : home_url( '/my-account/' );
$initial_view = isset( $_GET['action'] ) && $_GET['action'] === 'register' ? 'register' : 'login';
$auth_error   = '';
$auth_success = '';

// Handle POST Authentication Requests
if ( 'POST' === $_SERVER['REQUEST_METHOD'] ) {
	$auth_action = isset( $_POST['aura_auth_action'] ) ? sanitize_text_field( $_POST['aura_auth_action'] ) : '';

	// 1. Process Login
	if ( 'login' === $auth_action ) {
		if ( ! isset( $_POST['aura_login_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['aura_login_nonce'] ) ), 'aura_login_action' ) ) {
			$auth_error = esc_html__( 'Security check failed. Please refresh and try again.', 'aura-skincare' );
		} else {
			$user_login = isset( $_POST['log'] ) ? sanitize_text_field( wp_unslash( $_POST['log'] ) ) : '';
			$user_pass  = isset( $_POST['pwd'] ) ? $_POST['pwd'] : '';
			$remember   = ! empty( $_POST['rememberme'] );

			$creds = array(
				'user_login'    => $user_login,
				'user_password' => $user_pass,
				'remember'      => $remember,
			);

			$user = wp_signon( $creds, is_ssl() );

			if ( is_wp_error( $user ) ) {
				$auth_error = $user->get_error_message();
			} else {
				wp_safe_redirect( $redirect_to );
				exit;
			}
		}
	}

	// 2. Process Registration
	if ( 'register' === $auth_action ) {
		$initial_view = 'register';
		if ( ! isset( $_POST['aura_register_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['aura_register_nonce'] ) ), 'aura_register_action' ) ) {
			$auth_error = esc_html__( 'Security check failed. Please refresh and try again.', 'aura-skincare' );
		} else {
			$full_name = isset( $_POST['full_name'] ) ? sanitize_text_field( wp_unslash( $_POST['full_name'] ) ) : '';
			$email     = isset( $_POST['user_email'] ) ? sanitize_email( wp_unslash( $_POST['user_email'] ) ) : '';
			$password  = isset( $_POST['user_password'] ) ? $_POST['user_password'] : '';

			if ( empty( $email ) || ! is_email( $email ) ) {
				$auth_error = esc_html__( 'Please provide a valid email address.', 'aura-skincare' );
			} elseif ( email_exists( $email ) ) {
				$auth_error = esc_html__( 'An account with this email address already exists. Please sign in.', 'aura-skincare' );
			} elseif ( empty( $password ) || strlen( $password ) < 6 ) {
				$auth_error = esc_html__( 'Password must be at least 6 characters long.', 'aura-skincare' );
			} else {
				$username = sanitize_user( current( explode( '@', $email ) ), true );
				if ( empty( $username ) || username_exists( $username ) ) {
					$username = 'aura_user_' . wp_rand( 1000, 99999 );
				}

				// Split full name into first and last name
				$name_parts = explode( ' ', trim( $full_name ) );
				$first_name = array_shift( $name_parts );
				$last_name  = implode( ' ', $name_parts );

				$userdata = array(
					'user_login'   => $username,
					'user_email'   => $email,
					'user_pass'    => $password,
					'first_name'   => $first_name,
					'last_name'    => $last_name,
					'display_name' => ! empty( $full_name ) ? $full_name : $first_name,
					'role'         => 'customer',
				);

				$new_user_id = wp_insert_user( $userdata );

				if ( is_wp_error( $new_user_id ) ) {
					$auth_error = $new_user_id->get_error_message();
				} else {
					// Save customer meta if WooCommerce is active
					if ( function_exists( 'update_user_meta' ) ) {
						update_user_meta( $new_user_id, 'billing_first_name', $first_name );
						update_user_meta( $new_user_id, 'billing_last_name', $last_name );
						update_user_meta( $new_user_id, 'billing_email', $email );
						update_user_meta( $new_user_id, 'shipping_first_name', $first_name );
						update_user_meta( $new_user_id, 'shipping_last_name', $last_name );
					}

					// Automatically log in the user
					wp_set_current_user( $new_user_id );
					wp_set_auth_cookie( $new_user_id, true );
					wp_safe_redirect( $redirect_to );
					exit;
				}
			}
		}
	}
}

get_header();
?>

<main id="main-content" class="account-auth-container">
	
	<!-- ====================================================================
	     1. LOGIN CARD (Default View)
	     ==================================================================== -->
	<div class="account-auth-card" id="auth-login-card" style="<?php echo ( $initial_view === 'register' ) ? 'display: none;' : ''; ?>">
		
		<h1 class="auth-card-title"><?php esc_html_e( 'Welcome Back', 'aura-skincare' ); ?></h1>
		<p class="auth-card-subtitle"><?php esc_html_e( 'Sign in to access your exclusive rituals and history.', 'aura-skincare' ); ?></p>

		<?php if ( ! empty( $auth_error ) && $initial_view !== 'register' ) : ?>
			<div class="account-notice notice-error" style="text-align: left;">
				<svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
				<span><?php echo wp_kses_post( $auth_error ); ?></span>
			</div>
		<?php endif; ?>

		<form class="auth-form" method="post" action="<?php echo esc_url( remove_query_arg( array( 'preview_dashboard' ) ) ); ?>">
			
			<input type="hidden" name="aura_auth_action" value="login">
			<?php wp_nonce_field( 'aura_login_action', 'aura_login_nonce' ); ?>
			<input type="hidden" name="redirect_to" value="<?php echo esc_attr( $redirect_to ); ?>">

			<!-- Email / Username Address -->
			<div class="auth-field-group">
				<label class="auth-label" for="login-email"><?php esc_html_e( 'EMAIL OR USERNAME', 'aura-skincare' ); ?></label>
				<input 
					type="text" 
					id="login-email" 
					name="log" 
					class="auth-input" 
					placeholder="<?php esc_attr_e( 'Enter your email or username', 'aura-skincare' ); ?>" 
					value="<?php echo isset( $_POST['log'] ) ? esc_attr( wp_unslash( $_POST['log'] ) ) : ''; ?>"
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

	<!-- ====================================================================
	     2. REGISTER / CREATE ACCOUNT CARD
	     ==================================================================== -->
	<div class="account-auth-card" id="auth-register-card" style="<?php echo ( $initial_view === 'register' ) ? '' : 'display: none;'; ?>">
		
		<h1 class="auth-card-title"><?php esc_html_e( 'Create Account', 'aura-skincare' ); ?></h1>
		<p class="auth-card-subtitle"><?php esc_html_e( 'Join the Aura Society for exclusive rituals and rewards.', 'aura-skincare' ); ?></p>

		<?php if ( ! empty( $auth_error ) && $initial_view === 'register' ) : ?>
			<div class="account-notice notice-error" style="text-align: left;">
				<svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
				<span><?php echo wp_kses_post( $auth_error ); ?></span>
			</div>
		<?php endif; ?>

		<form class="auth-form" method="post" action="<?php echo esc_url( remove_query_arg( array( 'preview_dashboard' ) ) ); ?>">
			
			<input type="hidden" name="aura_auth_action" value="register">
			<?php wp_nonce_field( 'aura_register_action', 'aura_register_nonce' ); ?>
			<input type="hidden" name="redirect_to" value="<?php echo esc_attr( $redirect_to ); ?>">

			<!-- Full Name -->
			<div class="auth-field-group">
				<label class="auth-label" for="reg-name"><?php esc_html_e( 'FULL NAME', 'aura-skincare' ); ?></label>
				<input 
					type="text" 
					id="reg-name" 
					name="full_name" 
					class="auth-input" 
					placeholder="<?php esc_attr_e( 'Enter your full name', 'aura-skincare' ); ?>" 
					value="<?php echo isset( $_POST['full_name'] ) ? esc_attr( wp_unslash( $_POST['full_name'] ) ) : ''; ?>"
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
					value="<?php echo isset( $_POST['user_email'] ) ? esc_attr( wp_unslash( $_POST['user_email'] ) ) : ''; ?>"
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

document.addEventListener('DOMContentLoaded', function() {
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
});
</script>

<?php
get_footer();

