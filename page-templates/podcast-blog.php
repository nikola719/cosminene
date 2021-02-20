<?php
/*
Template Name: Podcast Blog
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
		if ( get_row_layout() == 'podcast' ):
		?>
		<h1 class="section-title wow fadeInUp" data-wow-delay="0.2s"><?php the_sub_field('title'); ?></h1>
		<?php endif; endwhile; endif; ?>
	</div>
</section>
<!-- End Introduction Section -->
<!-- Beign Episode Section -->
<?php 
if ( have_rows('featured_post') ): while( have_rows('featured_post') ): the_row(); 
if ( get_row_layout() == 'podcast_post' ):
    $featurePodcast = get_sub_field('featured_podcast_post');
    $podcast_title = get_the_title( $featurePodcast[0]->ID );
    $podcast_permalink = get_permalink( $featurePodcast[0]->ID );
    $podcast_img = get_the_post_thumbnail_url($featurePodcast[0]->ID, 'full');
    $podcast_episode = get_field('podcast_series', $featurePodcast[0]->ID);
    $podcast_year = get_field('year', $featurePodcast[0]->ID);
    $podcast_month = get_field('month', $featurePodcast[0]->ID);
    $podcast_post = get_post($featurePodcast[0]->ID);
    $podcast_blocks = parse_blocks($podcast_post->post_content);
    $audio_url = $podcast_blocks[0]['attrs']['data']['meta_flexible_content_0_audio_url'];  
?>
<section class="episode">
    <div class="container">
        <div class="episode-media__container">
            <div class="episode__desc">
                <div class="episode__title">
                    <h2 class="wow fadeInDown"><?php echo $podcast_episode; ?></h2>
                    <h2 class="wow fadeInDown"><?php echo $podcast_title; ?></h2>
                </div>
                <div class="episode__media">
                <a class="episode__link wow fadeInDown" data-wow-delay="0.2s" href="<?php the_field('spotify', 'option'); ?>">Spotify</a>
                <a class="episode__link wow fadeInDown" data-wow-delay="0.2s" href="<?php the_field('spotify', 'option'); ?>">Apple</a>
                </div>
            </div>
            <div class="episode__meta">
                <p class="wow fadeInDown" data-wow-delay="0.2s"><?php echo $podcast_month; ?></p>
                <p class="wow fadeInDown" data-wow-delay="0.2s"><?php echo $podcast_year; ?></p>
            </div>
        </div>
        <div class="episode-img__container wow fadeInDown">
            <img class="main-img" src="<?php echo $podcast_img; ?>" alt="episode"/>
            <div class="start-icon-container">
                <img class="start-icon" src="<?php echo get_template_directory_uri(); ?>/assets/images/playstart.svg" alt="start"/>
                <img class="start-icon-hover" src="<?php echo get_template_directory_uri(); ?>/assets/images/playstart-hover.svg" alt="start-hover"
                />
                <img class="stop-icon" src="<?php echo get_template_directory_uri(); ?>/assets/images/stop-4x.png" alt="stop" />
                <audio class="episode-featured__podcast">
                    <source src="<?php echo $audio_url; ?>" type="audio/mpeg" />
                </audio>
            </div>
        </div>
    </div>
</section>
<?php endif; endwhile; endif; ?>
<!-- End Episode Section -->
<!-- Begin Carousel Section -->
<?php
query_posts( array(
    'post_type' => 'podcasts',
    'post__not_in' => array($featurePodcast[0]->ID) )
); 
$index = 1;
?>
<section class="podcast">
    <div class="container">
        <div class="podcast-carousel">
            <div class="podcast-carousel__container">
            <?php 
            if ( have_posts() ) : while ( have_posts() ) : the_post(); 
            $single_title = get_the_title();
            $single_title = strlen($single_title) > 22 ? substr($single_title,0,22)."..." : $single_title;
            $single_series = get_field('podcast_series', get_the_ID());
            $single_series = explode(" ",$single_series );
            $number = $single_series[count($single_series) - 1];
            $single_blocks = parse_blocks(get_post()->post_content);
            $single_audio_url = $single_blocks[0]['attrs']['data']['meta_flexible_content_0_audio_url'];  
            ?>
                <div class="podcast-carousel__single wow fadeInDown" data-wow-delay="<?php echo 0.1*$index; ?>s">
                    <div class="podcast-carousel__wrapper">
                        <div class="image-wrapper">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/podcasts-1.png" alt="" />
                            <audio>
                                <source src="<?php echo $single_audio_url; ?>" type="audio/mpeg" />
                            </audio>
                        </div>
                        <div class="podcast-carousel__details">
                            <div class="abstraction">
                                <span class="abstraction-number">Ep. <?php echo $number; ?></span>
                                <span class="abstraction-title"><?php echo $single_title; ?></span>
                            </div>
                            <div class="start">
                                <img class="start-play" src="<?php echo get_template_directory_uri(); ?>/assets/images/play.svg" alt=""/>
                                <img class="start-stop" src="<?php echo get_template_directory_uri(); ?>/assets/images/stop.png" alt="" />
                            </div>
                        </div>
                    </div>
                </div>
            <?php $index++; endwhile; endif; ?>
		    <?php wp_reset_query(); ?>
            </div>
        <div class="podcast-media">
            <p class="podcast-media__title size-large wow fadeInDown" data-wow-delay="0.2s">
                Listen to all podcasts on
            </p>
            <div class="podcast-media__items">
                <a href="<?php the_field('spotify', 'option'); ?>" class="podcast-media__item wow fadeInDown" data-wow-delay="0.4s">Spotify</a>
                <a href="<?php the_field('apple', 'option'); ?>" class="podcast-media__item wow fadeInDown" data-wow-delay="0.4s">Apple</a>
            </div>
        </div>
    </div>
</section>
<!-- End Carousel Section -->
<!-- Begin Introduction Section -->
<section class="introduction art-int">
	<div class="container">
		<?php 
		if ( have_rows('type') ): while ( have_rows('type') ): the_row(); 
		if ( get_row_layout() == 'video' ):
		?>
		<h1 class="section-title wow fadeInDown" data-wow-delay="0.2s"><?php the_sub_field('title'); ?></h1>
		<?php endif; endwhile; endif; ?>
	</div>
</section>
<!-- End Introduction Section -->
<!-- Begin Action Section -->
<?php 
if ( have_rows('featured_post') ): while( have_rows('featured_post') ): the_row(); 
if ( get_row_layout() == 'video_post' ):
    $featurevideo = get_sub_field('featured_video_post');
    $video_title = get_the_title( $featurevideo[0]->ID );
    $video_permalink = get_permalink( $featurevideo[0]->ID );
    $video_img = get_the_post_thumbnail_url($featurevideo[0]->ID, 'full');
    $video_episode = get_field('video_series', $featurevideo[0]->ID);
    $video_year = get_field('year', $featurevideo[0]->ID);
    $video_month = get_field('month', $featurevideo[0]->ID);
    $categories = get_the_category( $featurevideo[0]->ID );
    $length = count ($categories);
    $temp_category = '';
    if ( $length > 1 ) {
        foreach($categories as $category){
            $key = array_search($category, $categories) + 1;
            if ( $key < $length) 
                $temp_category = $temp_category . $category->cat_name . '/';
            else 
                $temp_category = $temp_category . $category->cat_name;
        }
        $categories = $temp_category;
    } 
    else {
        $categories =  $categories[0]->cat_name;
    }
?>
<section class="action">
    <div class="container">
        <div class="action-call">
            <div class="action-call__container">
                <div class="action-call__desc">
                    <h2 class="action-call__title__series wow fadeInDown"><?php echo $video_episode; ?></h2>
                    <h2 class="action-call__title wow fadeInDown" data-wow-delay="0.2s"><?php echo $video_title; ?></h2>
                    <a class="action-call__link wow fadeInDown" href="<?php echo $video_permalink; ?>" data-wow-delay="0.2s">
                    <p class="size-ordinary">Watch now</p></a>
                </div>
                <div class="action-call__meta">
                    <p class="wow fadeInDown" data-wow-delay="0.2s"><?php echo $video_year; ?></p>
                    <p class="wow fadeInDown" data-wow-delay="0.2s"><?php echo $categories; ?></p>
                </div>
            </div>
            <div class="action-call__img">
                <img class="wow fadeInDown" src="<?php echo $video_img; ?>" alt="action-1a"  data-wow-delay="0.2s"/>
            </div>
        </div>
    </div>
</section>
<?php endif; endwhile; endif; ?>
<!-- End Action Section -->
</main>
<!-- Begin Video Watch Section -->
<section class="artint vi-watch">
    <div class="container">
        <div class="artint-filter">
            <p class="artint-filter__title size-large">Filter</p>
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
        <?php
        query_posts( array(
            'post_type' => 'videos',
            'post__not_in' => array($featurevideo[0]->ID),
            'posts_per_page' => 3, )
        );
		$postNotIn = array($featurevideo[0]->ID);
        if ( have_posts() ) : while ( have_posts() ) : the_post(); ?> 
        <div class="artint-read" post-id="<?php echo $featurevideo[0]->ID; ?>">
            <div class="artint-read__container">
                <div class="artint-read__desc">
                    <h2 class="artint-read__title wow fadeInDown"><?php the_title(); ?></h2>
                    <a class="artint-read__link wow fadeInDown" href="<?php the_permalink(); ?>"><p class="size-ordinary">Watch now</p></a>
                </div>
                <div class="artint-read__meta">
                <?php $author = get_field('name', get_the_ID());?>
                    <p class="wow fadeInDown"><?php echo $author; ?></p>
                    <p class="wow fadeInDown"><?php echo get_the_category()[0]->name; ?></p>
                </div>
            </div>
            <div class="artint-read__img wow fadeInDown">
            <?php $thumbnail_url = get_the_post_thumbnail_url(get_the_ID(),'full');?>
                <img src="<?php echo $thumbnail_url; ?>" alt="artint-1a" />
            </div>
        </div>
		<?php array_push($postNotIn, get_the_ID()); ?>
        <?php endwhile; endif; ?>
        <div class="artint-more">
            <div class="artint-more__link wow fadeInDown" data-wow-delay="0.2s" post-type="<?php echo get_post_type(); ?>" post-not-in="<?php echo implode(",", $postNotIn); ?>">
                <span class="artint-more__text">Load more</span>
                <span class="artint-more__text"><svg
                  width="20"
                  height="20"
                  viewBox="0 0 20 20"
                  fill="none"
                  xmlns="http://www.w3.org/2000/svg"
                >
                  <path
                    d="M20 8.35165H12.5275C12.048 8.35165 11.6484 7.95205 11.6484 7.47253V0H8.35165V7.47253C8.35165 7.95205 7.95205 8.35165 7.47253 8.35165H0V11.6484H7.47253C7.95205 11.6484 8.35165 12.048 8.35165 12.5275V20H11.6484V12.5275C11.6484 12.048 12.048 11.6484 12.5275 11.6484H20V8.35165Z"
                    fill="#302D2B"
                  />
                </svg></span>
            </div>
        </div>
		<?php wp_reset_query(); ?>
    </div>
</section>
<!-- End Video Watch Section -->
<?php get_footer(); ?>