<?php
/**
 * Footer template part.
 *
 * @author    eyorsogood.com, Rouie Ilustrisimo
 * @package Eyorsogood_Design
 * @version   1.0.0
 */

$is_back_to_top = qed_get_option( 'back-to-top', 'option' );

if ( qed_get_option( 'is_testimonial_enabled', 'option' ) && qed_is_display_testimonials() ) :?>
<div class="qed-testimonials__wrap">
	<div class="qed-testimonials__inner-wrap">
		<?php
		$testimonial_title = ( qed_get_option( 'testimonial_section_title', 'option' ) ) ? ' title="' . qed_get_option( 'testimonial_section_title', 'option' ) . '"': '';
		$testimonial_words_limit = ( qed_get_option( 'is_testimonial_excerpt', 'option' ) ) ? ' words_limit="' . qed_get_option( 'testimonial_excerpt_length', 'option' ) . '"':'';
		$testimonial_order = ( qed_get_option( 'testimonial_order', 'option' ) ) ? ' order="' . qed_get_option( 'testimonial_order', 'option' ) . '"':'';
		$testimonial_orderby = ( qed_get_option( 'testimonial_orderby', 'option' ) ) ? ' orderby="' . qed_get_option( 'testimonial_orderby', 'option' ) . '"':'';
		$testimonial_shortcode = sprintf('[testimonials%s%s%s]',
			$testimonial_words_limit,
			$testimonial_order,
			$testimonial_orderby
		);
		echo do_shortcode( $testimonial_shortcode );
		?>
	</div>
</div>
<?php endif; ?>
<footer class="footer">
	<?php //get_template_part( 'templates/footer/widget-areas' ); ?>
	<div class="footer__top">
		<div class="container footer-content">
			<div class="row">
				<div class="col-md-4 about">
					<div class="footer-content__title">About Us</div>
					<div class="footer-content__text"><?php echo qed_get_option( 'about_us', 'option'); ?></div>
				</div>
				<?php $pages = qed_get_option( 'our_pages', 'option'); ?>
				<div class="col-md-2">
					<div class="footer-content__title">Our Pages</div>
					<ul>
						<?php foreach($pages as $p): ?>
							<li><a href="<?php echo $p['menu_link']; ?>"><?php echo $p['menu_title']; ?></a></li>
						<?php endforeach; ?>
					</ul>
				</div>
				<?php $services = qed_get_option( 'our_services', 'option'); ?>
				<div class="col-md-3">
					<div class="footer-content__title">Services</div>
					<ul>
						<?php foreach($services as $p): ?>
							<li><a href="<?php echo $p['menu_link']; ?>"><?php echo $p['menu_title']; ?></a></li>
						<?php endforeach; ?>
					</ul>
				</div>
				<div class="col-md-3"><div class="footer-content__title">Newsletter</div><?php echo do_shortcode('[contact-form-7 id="99" title="Footer Newsletter"]'); ?></div>
			</div>
		</div>
	</div>
	<div class="footer__bottom">
		<?php
		if ( $is_back_to_top ) {
			echo '<div class="footer__arrow-top"><a href="#"><i class="fa fa-chevron-up"></i></a></div>';
		}
		?>
		<div class="container footer-content">
			<div class="row">
			<div class="col-md-6">

				<div class="footer__logo"><?php get_template_part( 'templates/header/logo' ); ?></div>
				</div>
				<div class="col-md-6">

					<div class="footer__copyright"><?php echo qed_esc_text( qed_get_option( 'footer_text_note', 'option', '© 2020 - Eyorsogood | Development and Design by Rouie Ilustrisimo' ), 'option_input', true ); ?></div>
				</div>
			</div>
		</div>
	</div>
</footer>

<?php
get_template_part( 'templates/footer/footer', 'clean' );
