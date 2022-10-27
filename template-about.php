<?php
/**
 * Template Name: About Us
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

$fields = get_fields(get_the_ID());

if ( have_posts() ) : ?>
	<?php while ( have_posts() ) { the_post(); ?>
		<div class="page-single">
			<main class="page-single__content" role="main">
				<div class="container">
                    <div class="row">
                        <div class="col-md-5 about-image">
                            <img src="<?php echo $fields['image']['url']; ?>">
                        </div>
                        <div class="col-md-7">
                            <?php echo the_content(); ?>
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
