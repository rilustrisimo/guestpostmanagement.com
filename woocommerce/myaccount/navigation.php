<?php
/**
 * My Account navigation
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/navigation.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 2.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

do_action( 'woocommerce_before_account_navigation' );
?>

<nav class="woocommerce-MyAccount-navigation">
	<?php 
	$navs = wc_get_account_menu_items(); 
	$tempnavs = array();
	
	$cnt = 1;
	
	foreach($navs as $k => $v):
		$tempnavs[$k] = $v;
		if($cnt == 3) $tempnavs['configure'] = 'Configure';
		$cnt++;
	endforeach;

	unset($tempnavs['downloads']);
	
	?>
	<ul>
		<?php foreach ( $tempnavs as $endpoint => $label ) : ?>
			<li class="<?php echo wc_get_account_menu_item_classes( $endpoint ); ?>">
				<?php if($endpoint != 'configure'): ?>
					<a href="<?php echo esc_url( wc_get_account_endpoint_url( $endpoint ) ); ?>"><?php echo esc_html( $label ); ?></a>
				<?php else: ?>
					<a href="<?php echo get_permalink(147); ?>"><?php echo esc_html( $label ); ?></a>
				<?php endif; ?>	
			</li>
		<?php endforeach; ?>
	</ul>
</nav>

<?php do_action( 'woocommerce_after_account_navigation' ); ?>
