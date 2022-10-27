<?php
/**
 * Template Name: Contact Page
 *
 * @author    eyorsogood.com, Rouie Ilustrisimo
 * @package   SwishDesign
 * @version   1.0.0
 */

/**
 * No direct access to this file.
 *
 * @since 1.0.0
 */
defined( 'ABSPATH' ) || die();

$contact_address = qed_get_option( 'contact_address', 'option' );
$contact_mail = qed_get_option( 'contact_mail', 'option' );
$contact_phone = qed_get_option( 'contact_phone', 'option' );
$contact_email = qed_get_option( 'contact_email', 'option' );
$contact_skype = qed_get_option( 'contact_skype', 'option' );

get_header();
?>

<?php qed_render_template_part( 'templates/header/title-block', '', array('title' => get_the_title()) ); ?>
<div class="container layout-container margin-top-large margin-bottom-large">
<?php
if ( have_posts() ) : ?>
	<?php while ( have_posts() ) { the_post(); ?>
		<div class="page-single page-contact">
			<main class="page-single__content contact-info" role="main">
				<div class="row">
					<div class="col-md-4">
						<div class="contact-info__wrap">
							<h3>CONTACT INFO</h3>
							<h1>CATCH US HERE</h1>
							<?php if ( null !== $contact_address ) : ?>
								<div class="contact-info__address">
									<span class="contact-info__title"></span><span class="contact-info__value"><?php echo esc_html( $contact_address ); ?></span>
									<div class="clearfix"></div>
								</div>
							<?php endif; ?>

							<?php if ( null !== $contact_mail ) : ?>
								<div class="contact-info__mail">
									<span class="contact-info__title"></span><span class="contact-info__value"><?php echo esc_html( $contact_mail ); ?></span>
									<div class="clearfix"></div>
								</div>
							<?php endif; ?>

							<?php if ( null !== $contact_phone ) : ?>
								<div class="contact-info__phone">
									<span class="contact-info__title"></span><span class="contact-info__value"><a href="tel:<?php echo esc_html( qed_get_formatted_mobile_number( $contact_phone ) ); ?>"><?php echo esc_html( $contact_phone ); ?></a></span>
									<div class="clearfix"></div>
								</div>
							<?php endif; ?>

							<?php if ( null !== $contact_email ) : ?>
								<div class="contact-info__email">
									<span class="contact-info__title"></span><span class="contact-info__value"><a href="mailto:<?php echo esc_html( $contact_email ); ?>?subject=Enquiry for TXM Chartered Accountants"><?php echo esc_html( $contact_email ); ?></a></span>
									<div class="clearfix"></div>
								</div>
							<?php endif; ?>

							<?php if ( null !== $contact_skype ) : ?>
								<div class="contact-info__skype">
									<span class="contact-info__title"></span><span class="contact-info__value"><?php echo esc_html( $contact_skype ); ?></span>
									<div class="clearfix"></div>
								</div>
							<?php endif; ?>
						</div>
					</div>
					<div class="col-md-8">
						<?php echo do_shortcode('[contact-form-7 id="96" title="Contact Form"]'); ?>
					</div>
				</div>
			</main>
		</div>
	<?php } ?>
<?php else :
	get_template_part( 'templates/content', 'none' );
endif;
do_action('eyor_after_main_content'); 
get_footer();
