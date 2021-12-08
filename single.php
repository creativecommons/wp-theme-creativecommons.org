<?php
	get_header();
	the_post();
?>
<section class="main-content">
	<header class="single-header">
		<div class="container">
			<div class="columns is-centered">
				<div class="column">
				<?php
					if ( function_exists( 'yoast_breadcrumb' ) ) {
						yoast_breadcrumb( '<p id="breadcrumbs">', '</p>' );
					}
				?>
				<div class="is-mobile cc-post-parent">

					<div class="cc-post-heading is-vcentered column">
						<h2><?php the_title(); ?></h2>
						<div class="cc-category">
							<?php the_category(','); ?>
						</div>
						<div class="is-flex is-flex-direction-row is-justify-content-space-between pt-3">
							<div>
								<?php
									$show_authors_is_enabled = get_theme_mod( 'cc_base_show_authors' );
									get_template_part( 'inc/partials/entry/entry', 'author' );
								?>
							</div>
							<div>
								<div class="column is-2">
									<div class="share-entry margin-vertical-normal is-flex is-3">
										<a href="<?php echo CC_Site::social_share( 'facebook', get_the_ID() ); ?>" class="share facebook column"><i class="icon facebook has-black-color"></i></a>
										<a href="<?php echo CC_Site::social_share( 'twitter', get_the_ID() ); ?>" class="share twitter column"><i class="icon twitter has-black-color"></i></a>
										<a href="<?php echo CC_Site::social_share( 'whatsapp', get_the_ID() ); ?>" class="share whatsapp column"><i class="icon whatsapp has-black-color"></i></a>
										<a href="<?php echo CC_Site::social_share( 'linkedin', get_the_ID() ); ?>" class="share linkedin column"><i class="icon linkedin has-black-color"></i></a>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="cc-post-image">
						<img src="<?php the_post_thumbnail(); ?>
					</div>
				</div>
				</div>
			</div>
		</div>
	</header>
	<div class="container">
		<div class="columns is-centered">
			<div class="column is-8">
				<section class="entry-page-content">
					<div class="text-format body-big">
						<?php the_content(); ?>
					</div>
					<footer class="entry-footer">
						<?php get_template_part( 'inc/partials/entry/entry', 'footer' ); ?>
					</footer>
				</section>
			</div>
		</div>
	</div>
</section>
<?php get_footer(); ?>