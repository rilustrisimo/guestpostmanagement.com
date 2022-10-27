<?php
/**
 * Template Name: Services
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

get_header('services');

$fields = get_fields(get_the_ID());

if ( have_posts() ) : ?>
	<?php while ( have_posts() ) { the_post(); ?>
		<div class="page-single" style="background-image: url(<?php echo $fields['bg_image']['url']; ?>);">
			<main class="page-single__content" role="main">
				<div class="container">
                    <div class="row services-content">
                        <div class="col-md-12">
                            <h1>PRICE & PLANS</h1>
                            <h3 style="text-align: center;margin-bottom:25px;">We provide only the finest and to-quality contextual backlinks for your clients!</h3>
                        </div>
                        <div class="col-md-12 text-center">
                            <?php foreach($fields['services'] as $s): ?>
                                <div class="services__item <?php echo ($s['reccom'])?'reccom':''; ?>">
                                    <div class="title"><?php echo $s['title']; ?></div>
                                    <!--<div class="price"><span>$</span><?php echo $s['price']; ?></div>-->
                                    <div class="desc"><?php echo $s['description']; ?></div>
                                    <div class="divider"></div>
                                    <div class="details"><?php echo $s['details']; ?></div>
                                    <div class="button"><a href="<?php echo $s['link'];?>"><i class="fa-solid fa-tags"></i> Check Pricing</a></div>
                                </div>
                            <?php endforeach; ?>
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
