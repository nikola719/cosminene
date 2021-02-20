<?php
/*
Template Name: Home
Template Post Type: page
*/

get_header(); ?>

	<div id="content" class="col_fullwidth">
	
		<?php breadcrumb_trail('echo=1&separator=/'); ?>

		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
			<?php get_template_part( 'templates/content', 'page' ); ?>
		<?php endwhile; endif; ?>

	</div><!-- /content -->

<?php get_footer(); ?>