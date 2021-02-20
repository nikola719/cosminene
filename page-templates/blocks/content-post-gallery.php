<?php

/**
 * Block Name: Post Gallery
 *
 * This is the template that displays the post gallery block.
 */

// Create id attribute allowing for custom "anchor" value.
$id = 'postgallery-' . $block['id'];
if( !empty($block['anchor']) ) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'category';
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}
if( !empty($block['align']) ) {
    $className .= ' align' . $block['align'];
}

// Load values and assign defaults.

?>
<!-- Begin Learn More Section -->
<section id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($className); ?>">
    <div class="container">
        <?php 
        $allposts = get_field('all_posts');
        $index = 1;
        if ( $allposts )
            foreach ( $allposts as $singlepost ) {
                $title = get_the_title( $singlepost->ID );
                $permalink = get_permalink( $singlepost->ID );
                $posttype = get_post_type( $singlepost->ID );
                $featured = get_the_post_thumbnail_url($singlepost->ID, 'full');
                $categories = get_the_category( $singlepost->ID );
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
                switch( $posttype ) {
                    case "post" : { ?>
                    <div class="category-card wow fadeInDown" data-wow-delay="0.2" data-id="<?php echo $index; ?>">
                        <a href="<?php echo $permalink; ?>" class="category-link">
                            <p class="category-name"><?php echo $categories; ?></p>
                            <h4 class="category-title"><?php echo $title; ?></h4>
                        </a>
                    </div>
                    <?php
                    break; }
                    case "podcasts" : { 
                        $podcast_series = get_field('podcast_series', $singlepost->ID);
                        $podcast_series = explode(" ",$podcast_series );
                        $number = $podcast_series[count($podcast_series) - 1];
                    ?>
                    <div class="category-card wow fadeInDown media" data-wow-delay="0.2" data-id="<?php echo $index; ?>">
                        <a href="<?php echo $permalink; ?>" class="category-link">
                            <div class="media-desc">
                                <p class="category-name"><?php echo $categories; ?></p>
                                <h4 class="category-title orange">
                                    Podcast<span class="category-title__order"><?php echo $number; ?></span>
                                </h4>
                                <h4 class="category-title"><?php echo $title; ?></h4>
                            </div>
                            <div class="media-img-container">
                                <img class="media-img" src="<?php echo $featured; ?>" alt=""/>
                            </div>
                        </a>
                    </div>
                    <?php 
                    break; }
                    case "videos" : { ?>
                    <div class="category-card wow fadeInDown media media-video" data-wow-delay="0.2" data-id="<?php echo $index; ?>">
                        <a href="<?php echo $permalink; ?>" class="category-link">
                            <div class="media-desc">
                                <p class="category-name"><?php echo $categories; ?></p>
                                <h4 class="category-title white">Video</h4>
                                <h4 class="category-title"><?php echo $title; ?></h4>
                            </div>
                            <div class="media-img-container">
                                <img
                                    class="media-img"
                                    src="<?php echo $featured; ?>"
                                    alt=""
                                />
                                <div class="start-icon-container">
                                    <img
                                    class="start-icon"
                                    src="<?php echo get_template_directory_uri(); ?>/assets/images/playstart.svg"
                                    alt="start"
                                    />
                                    <img
                                    class="start-icon-hover"
                                    src="<?php echo get_template_directory_uri(); ?>/assets/images/playstart-hover.svg"
                                    alt="start-hover"
                                    />
                                </div>
                            </div>
                        </a>
                    </div>
                    <?php
                    break; }
                }
                $index++ ;
            }
        ?>
    </div>
    <div class="category-explore">
        <p class="size-large category-explore__title wow fadeInDown"
        data-wow-delay="0.2s">Explore</p>
        <div class="category-explore__items">
            <a class="category-explore__item" href="<?php echo esc_url( get_permalink( get_page_by_title( 'Articles & Interviews' ) ) ); ?>">
                <p class="size-large wow fadeInUp" data-wow-delay="0.4s">
                Articles & Interviews</p>
            </a>
            <a class="category-explore__item" href="<?php echo esc_url( get_permalink( get_page_by_title( 'Videos & Podcasts' ) ) ); ?>">
                <p class="size-large wow fadeInUp" data-wow-delay="0.4s">Podcasts & Videos</p>
            </a>
        </div>
    </div>
</section>
<!-- End Learn More Section -->
