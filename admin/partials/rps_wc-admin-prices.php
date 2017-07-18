<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       ibenic.com
 * @since      1.0.0
 *
 * @package    Rps_wc
 * @subpackage Rps_wc/admin/partials
 */
global $product_object;

if( ! $product_object ) {
	return;
}

$rps_prices = RPS_WC_Meta::get( $product_object->get_id() );
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<div class="wc-rps-metabox">
	<table id="rps_table" class="wc-rps-table" cellspacing="0" cellpadding="0">

		<thead>
			<?php do_action( 'rps_wc_table_th_start' ); ?>
			<th>
				<?php _e( 'Sales Needed', 'rps_wc' ); ?>
			</th>
			<th>
				<?php _e( 'Price Change', 'rps_wc' );?> <?php echo ' (' . get_woocommerce_currency_symbol() . ')'; ?>
			</th>
			<?php do_action( 'rps_wc_table_th_end' ); ?>
			<th class="rps-delete-column"></th>
		</thead>
		<tbody>
			<?php 
			if( $rps_prices ) {
				$count = 0;
				foreach ( $rps_prices as $sales => $prices ) {
					?>
					<tr>
						<?php do_action( 'rps_wc_table_td_start', $count ); ?>
						<td class="rps-sales-column">
							<input name="rps_wc[<?php echo $count; ?>][sales]" class="widefat" value="<?php echo $sales; ?>">
						</td>
						<td class="rps-price-column">
							<input name="rps_wc[<?php echo $count; ?>][price]" class="widefat" value="<?php echo $prices; ?>">
						</td>
						<?php do_action( 'rps_wc_table_td_end', $count ); ?>
						<td class="rps-delete-column" align="center">
							<button type="button" class="button button-default button-small rps-delete">X</buton>
						</td>
					</tr>
					<?php
					$count++;
				}
			} else {
			?>
			<tr>
				<?php do_action( 'rps_wc_table_td_start', 0 ); ?>
				<td class="rps-sales-column">
					<input name="rps_wc[0][sales]" class="widefat">
				</td>
				<td class="rps-price-column">
					<input name="rps_wc[0][price]" class="widefat">
				</td>
				<?php do_action( 'rps_wc_table_td_end', 0 ); ?>
				<td class="rps-delete-column" align="center">
					<button type="button" class="button button-default button-small rps-delete">X</buton>
				</td>
			</tr>
			<?php } ?>
		</tbod>
	</table>
	<?php 

		if( $count && $limit > 0 && $count >= $limit ) {
			$button_attr = 'disabled="disabled"';

		} else { 
			$error_class = 'hidden'; 
		} 

	?>
	<button type="button" id="rps_add_row" class="button button-default" <?php echo $button_attr; ?>><?php _e( 'Add Sale Point', 'rps_wc' ); ?></button>
	
	<span id="rps_buy_pro" class="<?php echo $error_class;?> notice notice-error rps-error"><em><?php _e( 'Free Version is Limited to 3 Sales Points.', 'rps_wc' ); ?></em></span>
	
	<script type="text/html" id="tmpl-rps_table_row_template">
		<tr>
			<?php do_action( 'rps_wc_table_td_template_start' ); ?>
			<td class="rps-sales-column">
				<input name="rps_wc[{{data.length}}][sales]" class="widefat">
			</td>
			<td class="rps-price-column">
				<input name="rps_wc[{{data.length}}][price]" class="widefat">
			</td>
			<?php do_action( 'rps_wc_table_td_template_end' ); ?>
			<td class="rps-delete-column" align="center">
				<button type="button" class="button button-default button-small rps-delete">X</buton>
			</td>
		</tr>
	</script>
</div>
