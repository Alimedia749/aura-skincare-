<?php
/**
 * Template Name: Luxury About Us & Brand Story
 * Template Post Type: page
 *
 * @package Aura_Skincare
 */

get_header();

$theme_uri = get_template_directory_uri();
?>

<div class="about-page-wrapper">

	<!-- About Hero Section -->
	<section class="about-hero-section">
		<div class="aura-container-wide">
			<div class="about-hero-grid">
				
				<!-- Left Text -->
				<div>
					<div class="about-hero-badge">
						<span class="badge-dot" style="width:6px; height:6px; background:var(--color-gold); border-radius:50%; display:inline-block;"></span>
						<span><?php esc_html_e( 'OUR ORIGIN & PHILOSOPHY', 'aura-skincare' ); ?></span>
					</div>
					<h1 class="about-hero-title">
						<?php esc_html_e( 'Formulated by Nature.', 'aura-skincare' ); ?> <br>
						<span style="font-style: italic; color: var(--color-gold);"><?php esc_html_e( 'Perfected by Clinical Science.', 'aura-skincare' ); ?></span>
					</h1>
					<p class="about-hero-lead">
						<?php esc_html_e( 'Aura was born from a fundamental belief: skincare should never force you to choose between biocompatible purity and high-performance clinical results.', 'aura-skincare' ); ?>
					</p>
					<p class="about-hero-body">
						<?php esc_html_e( 'We formulate with cold-fermented botanical actives, wildcrafted flower hydrosols, and multi-molecular hydration complexes designed to sync harmoniously with your skin’s natural cellular cadence.', 'aura-skincare' ); ?>
					</p>
					<a href="<?php echo esc_url( home_url( '/shop/' ) ); ?>" class="aura-btn aura-btn-primary" style="margin-top: 0.5rem;">
						<span><?php esc_html_e( 'Explore The Collection', 'aura-skincare' ); ?></span>
						<svg viewBox="0 0 20 20" width="16" height="16" fill="currentColor"><path fill-rule="evenodd" d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd"/></svg>
					</a>
				</div>

				<!-- Right Media Frame -->
				<div class="about-hero-media">
					<img 
						src="<?php echo esc_url( $theme_uri . '/assets/images/promise-model.webp' ); ?>" 
						alt="<?php esc_attr_e( 'Aura Botanical Skincare philosophy', 'aura-skincare' ); ?>"
						loading="eager"
					>
					<div class="about-floating-quote">
						<p><?php esc_html_e( '“Your daily skincare ritual is a sacred dialogue with your skin.”', 'aura-skincare' ); ?></p>
					</div>
				</div>

			</div>
		</div>
	</section>

	<!-- The Sacred Ritual 3 Steps -->
	<section class="about-pillars-section">
		<div class="aura-container-wide">
			<div class="section-header">
				<span class="section-eyebrow"><?php esc_html_e( 'THE SACRED CADENCE', 'aura-skincare' ); ?></span>
				<h2 class="section-title"><?php esc_html_e( 'How Aura Restores Balance', 'aura-skincare' ); ?></h2>
				<p class="section-subtitle">
					<?php esc_html_e( 'A minimalist three-step cadence scientifically formulated to nourish the moisture barrier and reveal true lit-from-within radiance.', 'aura-skincare' ); ?>
				</p>
			</div>

			<div class="about-pillars-grid">
				
				<!-- Step 1 -->
				<div class="about-pillar-card">
					<div class="about-pillar-num">01</div>
					<h3 class="about-pillar-title"><?php esc_html_e( 'Purify & Reset', 'aura-skincare' ); ?></h3>
					<p class="about-pillar-text">
						<?php esc_html_e( 'Gentle surfactant-free botanical balms that melt away stubborn impurities, sunscreen, and daily pollutants while preserving your delicate acid mantle.', 'aura-skincare' ); ?>
					</p>
				</div>

				<!-- Step 2 -->
				<div class="about-pillar-card">
					<div class="about-pillar-num">02</div>
					<h3 class="about-pillar-title"><?php esc_html_e( 'Infuse & Activate', 'aura-skincare' ); ?></h3>
					<p class="about-pillar-text">
						<?php esc_html_e( 'Multi-weight hyaluronic acid, snow mushroom, and antioxidant bio-ferments penetrate the dermal layers for deep, 24-hour cellular plumping.', 'aura-skincare' ); ?>
					</p>
				</div>

				<!-- Step 3 -->
				<div class="about-pillar-card">
					<div class="about-pillar-num">03</div>
					<h3 class="about-pillar-title"><?php esc_html_e( 'Seal & Shield', 'aura-skincare' ); ?></h3>
					<p class="about-pillar-text">
						<?php esc_html_e( 'Bio-identical ceramide lipid complexes and cold-pressed botanical seed oils lock in active moisture and defend against free radical stress.', 'aura-skincare' ); ?>
					</p>
				</div>

			</div>
		</div>
	</section>

	<!-- The 4 Clean Standards -->
	<section class="about-standards-section">
		<div class="aura-container-wide">
			<div class="section-header">
				<span class="section-eyebrow"><?php esc_html_e( 'ZERO COMPROMISE', 'aura-skincare' ); ?></span>
				<h2 class="section-title"><?php esc_html_e( 'Our 4 Clean Standards', 'aura-skincare' ); ?></h2>
				<p class="section-subtitle">
					<?php esc_html_e( 'Every formula is held to the highest standard of conscious luxury and clinical purity.', 'aura-skincare' ); ?>
				</p>
			</div>

			<div class="standards-grid">
				
				<div class="standard-item-box">
					<div class="standard-icon-wrap" style="background: var(--color-sage-light); color: var(--color-sage);">
						<svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg>
					</div>
					<div class="standard-title"><?php esc_html_e( '100% Toxin Free', 'aura-skincare' ); ?></div>
					<div class="standard-desc"><?php esc_html_e( 'Formulated without parabens, sulfates, phthalates, synthetic fragrance, or 2,700+ questionable ingredients.', 'aura-skincare' ); ?></div>
				</div>

				<div class="standard-item-box">
					<div class="standard-icon-wrap" style="background: var(--color-gold-light); color: var(--color-gold);">
						<svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20"/><path d="M2 12h20"/></svg>
					</div>
					<div class="standard-title"><?php esc_html_e( 'Sustainable Packaging', 'aura-skincare' ); ?></div>
					<div class="standard-desc"><?php esc_html_e( 'Bottled in 100% recyclable infinity glass with FSC-certified bamboo caps and soy-based inks.', 'aura-skincare' ); ?></div>
				</div>

				<div class="standard-item-box">
					<div class="standard-icon-wrap" style="background: var(--color-rose-light); color: var(--color-rose);">
						<svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
					</div>
					<div class="standard-title"><?php esc_html_e( 'Leaping Bunny Certified', 'aura-skincare' ); ?></div>
					<div class="standard-desc"><?php esc_html_e( 'Cruelty-free and 100% vegan. Never tested on animals at any phase of ingredient development.', 'aura-skincare' ); ?></div>
				</div>

				<div class="standard-item-box">
					<div class="standard-icon-wrap" style="background: var(--color-gold-light); color: var(--color-primary);">
						<svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
					</div>
					<div class="standard-title"><?php esc_html_e( 'Clinical Bio-Ferments', 'aura-skincare' ); ?></div>
					<div class="standard-desc"><?php esc_html_e( 'Enhanced bioavailability through slow micro-fermentation that increases active nutrient absorption by 300%.', 'aura-skincare' ); ?></div>
				</div>

			</div>
		</div>
	</section>

	<!-- Founder’s Philosophy Note -->
	<section class="about-founder-section">
		<div class="aura-container-wide">
			<div class="founder-box">
				<p class="founder-quote">
					<?php esc_html_e( '“True skin vitality is not about hiding or fighting your natural texture — it is about nourishing your skin with biocompatible reverence and celebrating your authentic, luminous glow.”', 'aura-skincare' ); ?>
				</p>
				<div class="founder-sign">
					<?php esc_html_e( '— The AURA Botanical Collective & Formulation Lab', 'aura-skincare' ); ?>
				</div>
				<div style="margin-top: 2rem;">
					<a href="<?php echo esc_url( home_url( '/shop/' ) ); ?>" class="aura-btn aura-btn-gold">
						<span><?php esc_html_e( 'Discover The Full Collection', 'aura-skincare' ); ?></span>
					</a>
				</div>
			</div>
		</div>
	</section>

</div>

<?php
get_footer();
