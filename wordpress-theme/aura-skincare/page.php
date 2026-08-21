<?php
/**
 * The template for displaying all pages
 *
 * @package Aura_Skincare
 */

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
