<?php
/**
 * Template Name: Configure Order
 *
 * @author    eyorsogood.com, Rouie Ilustrisimo
 * @version   1.0.0
 */

/**
 * No direct access to this file.
 *
 * @since 1.0.0
 */
defined( 'ABSPATH' ) || die();


if (!is_user_logged_in()) { 
    echo '<script>window.location.href = "'.get_permalink(27).'";</script>';
}


$theme = new Theme();
$fields = get_fields(get_the_ID());

if(isset($_GET['success'])):
    $oid = $_SESSION['oid'];
    $pacid = get_field('package_id', $oid);

    echo '<script>window.location.href = "'.wc_get_checkout_url().'?add-to-cart='.$pacid.'";</script>';
else:
    if(isset($_SESSION['oid'])):
        unset($_SESSION['oid']);
    endif;
endif;

get_header();

if ( have_posts() ) : ?>
	<?php while ( have_posts() ) { the_post(); ?>
		<div class="page-single">
			<main class="page-single__content" role="main">
				<div class="container">
                    <div class="row">
                        <div class="col-md-12 configure">
                            <?php $packages = $fields['packages']; ?>
                            <div class="order-packages">
                                <ul class="nav nav-tabs" id="package-tabs" role="tablist">
                                    <?php foreach($packages as $k => $p): ?>
                                        <?php
                                            $product = wc_get_product($p['package_product_id']->ID);
                                        ?>
                                        <li><a data-toggle="tab" product-price="<?php echo $product->get_price(); ?>" product-id="<?php echo $p['package_product_id']->ID; ?>" class="<?php echo (!$k)?'active':''; ?>" href="#tab-<?php echo $k; ?>"><?php echo $p['package_title']; ?></a></li>
                                    <?php endforeach; ?>
                                </ul>
                                    <!-- Tabs navs -->

                                    <!-- Tabs content -->
                                <div class="tab-content" id="package-tabs_content">
                                    <?php foreach($packages as $k => $p): ?>
                                        <div id="tab-<?php echo $k; ?>" class="tab-pane <?php echo (!$k)?'active':''; ?>">
                                            <?php echo $p['package_description']; ?>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 calc-price">
                            <div class="calc-price_container">Calculated Price: <span class="price">$99.99</span></div>
                        </div>
                        <div class="col-md-12 gen-settings">
                            <?php $theme->createAcfForm(155, 'orderfields', 'Add to Cart', 'configure-order/?success=1'); ?>
                        </div>
                    </div>
                </div>
			</main>
		</div>

		<?php do_action('eyor_after_main_content'); ?>
	<?php } ?>
<?php else :
	get_template_part( 'templates/content', 'none' );
endif;

get_footer();
