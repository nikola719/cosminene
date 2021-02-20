<?php

/**
 * Block Name: Media Carousel
 *
 * This is the template that displays the Media Carousel block.
 */

// Create id attribute allowing for custom "anchor" value.
$id = 'podcast-' . $block['id'];
if( !empty($block['anchor']) ) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'podcast';
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}
if( !empty($block['align']) ) {
    $className .= ' align' . $block['align'];
}

// Load values and assign defaults.

?>
<section id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($className); ?>">
    <div class="container">
        <div class="podcast-carousel">
            <div class="podcast-carousel__container">
                <?php $media_type = get_field('media_type');
                $index = 1; 
                if ( $media_type == 'video' ): 
                if ( have_rows('video') ): while( have_rows('video') ) : the_row();
                ?>
                <div
                class="podcast-carousel__single wow fadeInDown"
                data-wow-delay="<?php echo $index * 0.1; ?>s"
                >
                    <div class="podcast-carousel__wrapper">
                        <div class="image-wrapper">
                            <img src="<?php echo get_sub_field('image')['url']; ?>" alt="<?php echo get_sub_field('image')['title']; ?>" />
                            <!-- <img class="stop" src="<?php echo get_template_directory_uri(); ?>/assets/images/stop.png" alt="" /> -->
                        </div>
                        <?php
                            $chapter = get_sub_field('chapter') ;
                            $title = get_sub_field('title'); 
                        ?>
                        <div class="podcast-carousel__details">
                            <div class="abstraction">
                                <span class="abstraction-number">Ch. <?php echo $chapter; ?></span>
                                <span class="abstraction-title"><?php echo $title; ?></span>
                            </div>
                            <div class="start" timestamp="<?php the_sub_field('time'); ?>">
                                <img
                                class="start-play"
                                src="<?php echo get_template_directory_uri(); ?>/assets/images/play.svg"
                                alt=""
                                />
                                <img class="start-stop" src="<?php echo get_template_directory_uri(); ?>/assets/images/stop.png" alt="" />
                            </div>
                        </div>
                    </div>
                </div>
                <?php $index++; endwhile; endif; ?>
                <?php elseif ( $media_type == 'podcast' ): 
                if ( have_rows('podcast') ): while( have_rows('podcast') ) : the_row();?>
                <div
                class="podcast-carousel__single wow fadeInDown"
                data-wow-delay="0.1s"
              >
                    <div class="podcast-carousel__wrapper">
                        <div class="image-wrapper">
                            <img src="<?php echo get_sub_field('image')['url']; ?>" alt="<?php echo get_sub_field('image')['title']; ?>" />
                            <img class="stop" src="<?php echo get_template_directory_uri(); ?>/assets/images/stop.png" alt="" />
                            <audio>
                            <source src="<?php the_sub_field('audio'); ?>" type="audio/mpeg" />
                            </audio>
                        </div>
                        <div class="podcast-carousel__details">
                            <div class="abstraction">
                                <span class="abstraction-number"><?php the_sub_field('episode_order'); ?></span>
                                <span class="abstraction-title"
                                    ><?php the_sub_field('episode_title'); ?></span
                                >
                            </div>
                            <div class="start">
                                <img
                                    class="start-play"
                                    src="<?php echo get_template_directory_uri(); ?>/assets/images/play.png"
                                    alt=""
                                />
                            </div>
                        </div>
                    </div>
                </div>
                <?php endwhile; endif; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>