<?php
/**
 * Template Name: Login & Sign In (Stitch Design)
 * Template Post Type: page
 *
 * @package Aura_Skincare
 */

get_header();

$redirect_to = isset( $_GET['redirect_to'] ) ? esc_url( $_GET['redirect_to'] ) : home_url( '/my-account/' );
$initial_view = isset( $_GET['action'] ) && $_GET['action'] === 'register' ? 'register' : 'login';
?>

<main id="main-content" class="account-auth-container">
	
	<!-- ====================================================================
	     1. LOGIN CARD (Default View)
	     ==================================================================== -->
	<div class="account-auth-card" id="auth-login-card" style="<?php echo ( $initial_view === 'register' ) ? 'display: none;' : ''; ?>">
		
		<h1 class="auth-card-title"><?php esc_html_e( 'Welcome Back', 'aura-skincare' ); ?></h1>
		<p class="auth-card-subtitle"><?php esc_html_e( 'Sign in to access your exclusive rituals and history.', 'aura-skincare' ); ?></p>

		<form class="auth-form" method="post" action="<?php echo esc_url( wp_login_url( $redirect_to ) ); ?>" onsubmit="if(this.checkValidity()){ window.location.href='<?php echo esc_url( home_url( '/my-account/' ) ); ?>'; return false; }">
			
			<!-- Email Address -->
			<div class="auth-field-group">
				<label class="auth-label" for="login-email"><?php esc_html_e( 'EMAIL ADDRESS', 'aura-skincare' ); ?></label>
				<input 
					type="text" 
					id="login-email" 
					name="log" 
					class="auth-input" 
					placeholder="<?php esc_attr_e( 'Enter your email', 'aura-skincare' ); ?>" 
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

		<form class="auth-form" method="post" action="<?php echo esc_url( wp_registration_url() ); ?>" onsubmit="if(this.checkValidity()){ alert('Account created successfully! Redirecting to your ritual portal...'); window.location.href='<?php echo esc_url( home_url( '/my-account/' ) ); ?>'; return false; }">
			
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
						placeholder="<?php esc_attr_e( 'Create a password', 'aura-skincare' ); ?>" 
						required
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
