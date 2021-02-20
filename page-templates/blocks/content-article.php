<?php

/**
 * Block Name: Article
 *
 * This is the template that displays the article block.
 */

// Create id attribute allowing for custom "anchor" value.
$id = 'article-' . $block['id'];
if( !empty($block['anchor']) ) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'article';
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
        <div class="article-meta">
            <?php if ( have_rows('meta_flexible_content') ): while( have_rows('meta_flexible_content') ): the_row(); ?>
            <!-- Case: Portrait layout -->
            <?php if ( get_row_layout() == 'portrait'): ?>
            <div class="about-img__wrapper wow fadeInLeft">
                <img src="<?php echo get_sub_field('image')['url']; ?>" alt="<?php echo get_sub_field('image')['title']; ?>" />
            </div>
            <?php endif; ?>
            <!-- Case: Audio layout -->
            <?php if ( get_row_layout() == 'audio'): ?>
            <div class="article-meta__player">
                <img
                    src="<?php echo get_sub_field('audio_image')['url']; ?>"
                    alt="<?php echo get_sub_field('audio_image')['title']; ?>"
                />
                <div class="progress-container">
                    <div class="progress-wrapper">
                        <div class="progress"></div>
                        <div class="cursor"></div>
                    </div>
                    <div class="button-wrapper">
                        <img class="meta-play" src="<?php echo get_template_directory_uri(); ?>/assets/images/play.svg" alt="play"/>
                        <img class="meta-stop" src="<?php echo get_template_directory_uri(); ?>/assets/images/stop.png" alt="stop"/>
                    </div>
              </div>
            </div>
            <audio>
                <source src="<?php the_sub_field('audio_url'); ?>" type="audio/mpeg" />
            </audio>
            <?php endif; ?>
            <?php endwhile; endif; ?>
        </div>
        <div class="article-content">
            <?php if( have_rows('infra_flexible_content') ): while( have_rows('infra_flexible_content') ): the_row(); ?>
            <!-- Case: Heading layout -->
            <?php if ( get_row_layout() == 'heading' ): ?>
                <h5 class="wow fadeInDown" data-wow-delay="0.2s"><?php the_sub_field('title'); ?></h5>
            <?php endif; ?>
            <!-- Case: Paragraph layout -->
            <?php if ( get_row_layout() =='paragraph' ): ?>
            <div class="article-content__paragraph">
                <?php if ( have_rows('paragraph_items') ): while ( have_rows('paragraph_items') ): the_row(); ?>
                <p class="wow fadeInDown"><?php the_sub_field('item'); ?></p>
                <?php endwhile; endif; ?>
            </div>
            <?php endif; ?>
            <!-- Case: Image Text layout -->
            <?php if ( get_row_layout() == 'image_text'): ?>
            <div class="article-content__reasons">
                <?php if ( have_rows('image_text_wrapper') ): while ( have_rows('image_text_wrapper') ): the_row(); ?>
                <div class="article-content__reasons-item wow fadeInUp" data-wow-delay="0.2s">
                    <img src="<?php echo get_sub_field('image')['url']; ?>" alt="<?php echo get_sub_field('image')['title']; ?>" />
                    <p><?php the_sub_field('text'); ?></p>
                </div>
                <?php endwhile; endif; ?>
            </div>
            <?php endif; ?>
            <!-- Case: Contact layout -->
            <?php if ( get_row_layout() == 'contact'): ?>
            <div class="article-content__contact">
                <a class='wow fadeInDown' href="<?php the_sub_field('contact_url'); ?>" data-wow-delay="0.2s">
                    <h5 class="size-medium" ><?php the_sub_field('contact_label'); ?></h5>
                </a>
            </div>
            <?php endif; ?>
            <!-- Case: social platform layout -->
            <?php if ( get_row_layout() == 'social_platform'): ?>
            <ul class="article-content__media">
            <?php if( have_rows('social_items') ): while( have_rows('social_items') ): the_row(); ?>
              <li class="media-item"><a href="<?php the_sub_field('link'); ?>"><?php the_sub_field('name'); ?></a></li>
            <?php endwhile; endif; ?>
            </ul>
            <?php endif; ?>
            <?php endwhile;  endif; ?>
        </div>
    </div>
</section>