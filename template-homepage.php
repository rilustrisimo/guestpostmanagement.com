<?php
/**
 * Template Name: Homepage
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
				<div class="section-offers container">
					<div class="row">
						<div class="col-md-12">
							<h1>What We Offer</h1>
						</div>
					</div>
					<div class="row custom-tab">
						<?php 
							$wwo = get_field('what_we_offer', get_the_ID()); 
							$navs = array();
						?>
						<?php foreach($wwo as $k => $item):?>
						<div class="col-md-12 custom-tab__item <?php echo ($k == 0)?'active':''; ?>" tab-id="<?php echo $k; ?>">
							<div class="row">
								<div class="col-12 col-sm-12 col-md-6">
									<div class="custom-tab__image" style="background-image: url(<?php echo $item['image']['url']; ?>)"></div>
								</div>
								<div class="col-12 col-sm-12 col-md-6">
									<div class="custom-tab__content">
										<?php echo $item['content']; ?>
									</div>
									<div class="custom-tab__button">
										<a class="btn button" href="<?php echo $item['button_details']['button_link']; ?>"><?php echo $item['button_details']['button_name']; ?></a>
									</div>
								</div>
							</div>
						</div>
						<?php $navs[$k] = $item['navigation']; ?>
						<?php endforeach;?>
						<div class="col-md-12 custom-tab__navs">
							<?php foreach($navs as $k => $item):?>
								<div class="custom-tab__navs-item container <?php echo ($k == 0)?'active':''; ?>" nav-id="<?php echo $k; ?>">
									<div class="row">
										<div class="col-md-1">&nbsp;</div>
										<div class="col-md-2 icon"><?php echo $item['icon']; ?></div>
										<div class="col-md-9 content">
											<div class="title"><?php echo $item['title']; ?></div>
											<div class="subtitle"><?php echo $item['sub_title']; ?></div>
										</div>
									</div>
								</div>
							<?php endforeach;?>
						</div>
					</div>
				</div>
				<?php $about = get_field('about_us', get_the_ID());  ?>
				<div class="section-about container">
					<div class="row">
						<div class="col-md-6"><div class="section-about__image" style="background-image:url(<?php echo $about['image']['url']; ?>);"></div><div class="section-about__years"><div class="number"><?php echo $about['years']; ?></div><div class="text">Years Experience</div></div></div>
						<div class="col-md-6">
							<div class="section-about__content">
								<?php echo $about['content']; ?>
							</div>
							<div class="section-about__button">
								<a class="btn button" href="<?php echo $about['button_link']; ?>"><?php echo $about['button']; ?></a>
							</div>
						</div>
					</div>
				</div>

				<?php $features = get_field('features', get_the_ID());  ?>
				<div class="section-features container">
					<div class="row">
						<?php foreach($features as $f): ?>
							<div class="col-md-3 item">
								<a href="<?php echo $f['link']; ?>">
									<div class="item__container">
										<div class="icon"><?php echo $f['icon']; ?></div>
										<div class="title"><?php echo $f['title']; ?></div>
										<div class="link"><i class="fa-solid fa-arrow-right"></i></div>
									</div>
								</a>
							</div>
						<?php endforeach; ?>
					</div>
				</div>
			</main>
		</div>

		<?php do_action('eyor_after_main_content'); ?>

		<?php $reach = get_field('reach_out', get_the_ID());  ?>
		<div class="page-single__content">
			<div class="section-reach container-fluid" style="background-image: url(<?php echo $reach['background_image']['url']; ?>);">
				<div class="row">
					<div class="col-md-12"><?php echo $reach['content']; ?></div>
					<div class="col-md-12 buttons">
						<a href="<?php echo $reach['first_button_link']; ?>" class="first"><?php echo $reach['first_button_text']; ?></a>
						<a href="<?php echo $reach['second_button_link']; ?>" class="second"><?php echo $reach['second_button_text']; ?></a>
					</div>
				</div>
			</div>
		</div>
	<?php } ?>
<?php else :
	get_template_part( 'templates/content', 'none' );
endif;

get_footer();
