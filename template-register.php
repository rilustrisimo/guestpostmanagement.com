<?php
/**
 * Template Name: Register
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

get_header();

if ( have_posts() ) : ?>
	<?php while ( have_posts() ) { the_post(); ?>
		<div class="page-single">
			<main class="page-single__content" role="main">
				<div class="container">
                    <div class="row">
                        <div class="col-md-12 regform">
                            <?php echo do_shortcode('[user_registration_form id="100"]'); ?>
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
