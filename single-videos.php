<!-- Video post type template -->
<?php get_header(); ?>
<main>
<!-- Begin Hero Section -->
<section class="hero">
	<div class="container">
		<h1 class="section-title">
		<?php the_field('video_title'); ?>
		</h1>
	</div>
</section>
<!-- End Hero Section -->
<?php the_content(); ?>
<?php $prev_post = get_previous_post();?>
<?php $next_post = get_next_post();?>
<!-- start Transfer Section -->
<section class="transfer">
	<div class="container">
		<div class="transfer-left"></div>
		<div class="transfer-right">
		<div class="transfer-direction">
			<div class="transfer-direction__prev">
			<?php if ( $prev_post ): ?>
			<a href="<?php echo get_permalink( $prev_post->ID ); ?>"><h5 class="size-medium">Previous</h5></a>
			<p class="size-small"><?php echo apply_filters( 'the_title', $prev_post->post_title ); ?></p>
			<?php endif; ?>
			</div>
			<div class="transfer-direction__next">
			<?php if ( $next_post ): ?>
			<a href="<?php echo get_permalink($next_post->ID); ?>"><h5 class="size-medium">Next</h5></a>
			<p class="size-small"><?php echo apply_filters( 'the_title', $next_post->post_title ); ?></p>
			<?php endif; ?>
			</div>
		</div>
		</div>
	</div>
</section>
<!-- End Transfer Section -->
</main>
<?php get_footer(); ?>
