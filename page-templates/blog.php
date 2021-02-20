<?php
/*
Template Name: Blog
Template Post Type: page
*/

get_header(); ?>
<main>
<!-- Begin Hero Section -->
<section class="hero">
	<div class="container">
		<h1 class="section-title wow fadeInUp" data-wow-delay="0.2s">
		<span><?php the_field('page_title'); ?></span>
		</h1>
	</div>
</section>
<!-- Begin Hero Section -->
<!-- Begin Introduction Section -->
<section class="introduction art-int">
	<div class="container">
		<?php 
		if ( have_rows('type') ): while ( have_rows('type') ): the_row(); 
		if ( get_row_layout() == 'article' ):
		?>
		<h1 class="section-title wow fadeInUp" data-wow-delay="0.2s"><?php the_sub_field('title'); ?></h1>
		<?php endif; endwhile; endif; ?>
	</div>
</section>
<!-- End Introduction Section -->
<!-- Begin Article and Interview Section -->
<section class="artint">
	<div class="container">
		<div class="artint-filter">
			<p class="artint-filter__title size-large wow fadeInDown">Filter</p>
			<ul class="artint-filter__items">
			<?php $terms = get_field('filter_items');
					$index = 1;
				foreach ( $terms as $term ) { ?>
					<li class="artint-filter__item wow fadeInDown" data-wow-delay="<?php echo 0.1 * $index; ?>s">
						<span class="filter-text"><?php echo esc_html( $term->name ); ?></span>
					</li>
				<?php $index++; } ?>
			</ul>
		</div>
		<?php if( have_rows('featured_post' ) ): while( have_rows('featured_post') ): the_row(); ?>
		<?php if( get_row_layout() == 'article_post'): ?>
		<?php 
		$featuredArticle = get_sub_field('featured_article_post');
		$feature_title = get_the_title( $featuredArticle[0]->ID );
		$feature_permalink = get_permalink( $featuredArticle[0]->ID );
		$feature_type = get_post_type( $featuredArticle[0]->ID );
		$feature_categories = get_the_category( $featuredArticle[0]->ID );
		$length = count ($feature_categories);
		$feature_img = get_the_post_thumbnail_url($featuredArticle[0]->ID, 'full');
		$temp_category = '';
		if ( $length > 1 ) {
			foreach($feature_categories as $category){
				$key = array_search($category, $feature_categories) + 1;
				if ( $key < $length) 
					$temp_category = $temp_category . $category->cat_name . '/';
				else 
					$temp_category = $temp_category . $category->cat_name;
			}
			$feature_categories = $temp_category;
		} 
		else {
			$feature_categories =  $feature_categories[0]->cat_name;
		}
		?>
		<?php endif; endwhile; endif; ?>
		<div class="artint-read" post-id="<?php echo $featuredArticle[0]->ID; ?>">
			<div class="artint-read__container">
				<div class="artint-read__desc">
					<h2 class="artint-read__title wow fadeInDown" data-wow-delay="0.2s">
						<?php echo $feature_title; ?>
					</h2>
					<a class="artint-read__link wow fadeInDown" data-wow-delay="0.2s" href="<?php echo $feature_permalink; ?>">
					<p class="size-ordinary">Read the article</p></a>
				</div>
				<div class="artint-read__meta">
					<p class="wow fadeInDown" data-wow-delay="0.2s"><?php echo $feature_type === "post" ? "Article" : "" ; ?></p>
					<p class="wow fadeInDown" data-wow-delay="0.2s"><?php echo $feature_categories; ?></p>
				</div>
			</div>
			<div class="artint-read__img">
				<img class="wow fadeInDown" src="<?php echo $feature_img; ?>" alt="artint-1a" data-wow-delay="0.2s"/>
			</div>
		</div>
		<?php
		query_posts( array(
			'post_type' => 'post',
			'post__not_in' => array($featuredArticle[0]->ID),
			'posts_per_page' => 3, )
		);
		$postNotIn = array($featuredArticle[0]->ID);
		if ( have_posts() ) : while ( have_posts() ) : the_post(); ?> 
		<?php 
		$postCategories = get_the_category();
		$length = count ($postCategories);
		$temp_category = '';
		if ( $length > 1 ) {
			foreach($postCategories as $category){
				$key = array_search($category, $postCategories) + 1;
				if ( $key < $length) 
					$temp_category = $temp_category . $category->cat_name . '/';
				else 
					$temp_category = $temp_category . $category->cat_name;
			}
			$postCategories = $temp_category;
		} 
		else {
			$postCategories =  $postCategories[0]->cat_name;
		}
		?>
		<div class="artint-read">
			<div class="artint-read__container">
				<div class="artint-read__desc">
					<h2 class="artint-read__title wow fadeInDown" data-wow-delay="0.2s">
						<?php the_title(); ?>
					</h2>
					<a class="artint-read__link wow fadeInDown" data-wow-delay="0.2s" href="<?php the_permalink(); ?>">
					<p class="size-ordinary">Read the article</p></a>
				</div>
				<div class="artint-read__meta">
					<p class="wow fadeInDown" data-wow-delay="0.2s">Article</p>
					<p class="wow fadeInDown" data-wow-delay="0.2s"><?php echo $postCategories; ?></p>
				</div>
			</div>
			<div class="artint-read__img">
				<?php $thumbnail_url = get_the_post_thumbnail_url(get_the_ID(),'full');?>
				<img class="wow fadeInDown" src="<?php echo $thumbnail_url; ?>" alt="artint-1a" data-wow-delay="0.2s"/>
			</div>
		</div>
		<?php array_push($postNotIn, get_the_ID()); ?>
		<?php endwhile; endif; ?>
		<div class="artint-more">
			<div class="artint-more__link wow fadeInDown" data-wow-delay="0.2s" post-type="<?php echo get_post_type(); ?>" post-not-in="<?php echo implode(",", $postNotIn); ?>">
				<span class="artint-more__text">Load more</span>
				<span class="artint-more__text"><svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path
				d="M20 8.35165H12.5275C12.048 8.35165 11.6484 7.95205 11.6484 7.47253V0H8.35165V7.47253C8.35165 7.95205 7.95205 8.35165 7.47253 8.35165H0V11.6484H7.47253C7.95205 11.6484 8.35165 12.048 8.35165 12.5275V20H11.6484V12.5275C11.6484 12.048 12.048 11.6484 12.5275 11.6484H20V8.35165Z"
				fill="#302D2B"
				/>
			</svg></span>
		</div>
		<?php wp_reset_query(); ?>
	</div>
</div>
</section>
<!-- End Article and Interview Section -->
</main>
<?php get_footer(); ?>