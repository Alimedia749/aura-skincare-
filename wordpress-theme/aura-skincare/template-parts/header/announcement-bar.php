<?php
/**
 * Announcement Ticker & Currency Bar Template Part
 *
 * @package Aura_Skincare
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! get_theme_mod( 'aura_show_announcement_bar', true ) ) {
	return;
}

$msg1 = get_theme_mod( 'aura_announcement_text_1', '✦ COMPLIMENTARY EXPEDITED SHIPPING ON ALL ORDERS OVER $75 ✦' );
$msg2 = get_theme_mod( 'aura_announcement_text_2', 'RECEIVE A DELUXE 3-PIECE RITUAL SET WITH ANY ORDER OVER $120' );
?>

<div class="announcement-bar" role="region" aria-label="<?php esc_attr_e( 'Announcements', 'aura-skincare' ); ?>">
	<div class="announcement-inner">
		<div class="announcement-ticker">
			<div class="ticker-item active"><?php echo esc_html( $msg1 ); ?></div>
			<?php if ( ! empty( $msg2 ) ) : ?>
				<div class="ticker-item"><?php echo esc_html( $msg2 ); ?></div>
			<?php endif; ?>
		</div>

		<div class="announcement-tools">
			<label for="aura-currency-picker" class="screen-reader-text"><?php esc_html_e( 'Select Currency', 'aura-skincare' ); ?></label>
			<select id="aura-currency-picker" class="currency-picker" aria-label="<?php esc_attr_e( 'Currency Selector', 'aura-skincare' ); ?>">
				<option value="USD">USD ($)</option>
				<option value="EUR">EUR (€)</option>
				<option value="GBP">GBP (£)</option>
				<option value="CAD">CAD ($)</option>
				<option value="AUD">AUD ($)</option>
			</select>
		</div>
	</div>
</div>
