<?php
/**
 * The template for displaying all pages
 *
 * @package Aura_Skincare
 */

$page_slug = get_post_field( 'post_name', get_post() );

if ( 'shop' === $page_slug || is_page( 'shop' ) || ( function_exists( 'is_shop' ) && is_shop() ) || is_post_type_archive( 'product' ) ) {
	require get_template_directory() . '/page-templates/template-shop.php';
	return;
}

if ( 'about-us' === $page_slug || 'about' === $page_slug || is_page( 'about-us' ) || is_page( 'about' ) ) {
	require get_template_directory() . '/page-templates/template-about.php';
	return;
}

if ( 'checkout' === $page_slug || is_page( 'checkout' ) ) {
	require get_template_directory() . '/page-templates/template-checkout.php';
	return;
}

if ( 'faq' === $page_slug || is_page( 'faq' ) ) {
	require get_template_directory() . '/page-templates/template-faq.php';
	return;
}

if ( 'shipping-returns' === $page_slug || is_page( 'shipping-returns' ) ) {
	require get_template_directory() . '/page-templates/template-shipping.php';
	return;
}

if ( 'track-order' === $page_slug || is_page( 'track-order' ) || 'track' === $page_slug ) {
	require get_template_directory() . '/page-templates/template-track.php';
	return;
}

if ( 'privacy-policy' === $page_slug || is_page( 'privacy-policy' ) ) {
	require get_template_directory() . '/page-templates/template-privacy.php';
	return;
}

if ( 'terms' === $page_slug || is_page( 'terms' ) ) {
	require get_template_directory() . '/page-templates/template-terms.php';
	return;
}

if ( 'careers' === $page_slug || is_page( 'careers' ) ) {
	require get_template_directory() . '/page-templates/template-careers.php';
	return;
}

if ( 'gift-cards' === $page_slug || is_page( 'gift-cards' ) ) {
	require get_template_directory() . '/page-templates/template-giftcards.php';
	return;
}

if ( 'login' === $page_slug || 'signin' === $page_slug || 'sign-in' === $page_slug || 'register' === $page_slug || is_page( 'login' ) || is_page( 'signin' ) || is_page( 'sign-in' ) || is_page( 'register' ) ) {
	require get_template_directory() . '/page-templates/template-login.php';
	return;
}

if ( 'my-account' === $page_slug || 'account' === $page_slug || is_page( 'my-account' ) || is_page( 'account' ) || ( function_exists( 'is_account_page' ) && is_account_page() ) ) {
	if ( ! is_user_logged_in() && ! isset( $_GET['preview_dashboard'] ) ) {
		require get_template_directory() . '/page-templates/template-login.php';
	} else {
		require get_template_directory() . '/page-templates/template-account.php';
	}
	return;
}

get_header();
?>
<main id="main-content" class="site-main" style="padding: clamp(4rem, 7vw, 7rem) 1.5rem; max-width: 1200px; margin: 0 auto; min-height: 60vh;">
	<?php
	while ( have_posts() ) :
		the_post();
		?>
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<h1 class="section-title" style="margin-bottom: 2rem;"><?php the_title(); ?></h1>
			<div class="entry-content" style="line-height: 1.8; color: var(--color-text-main); font-size: 1rem;">
				<?php the_content(); ?>
			</div>
		</article>
		<?php
	endwhile;
	?>
</main>
<?php
get_footer();
