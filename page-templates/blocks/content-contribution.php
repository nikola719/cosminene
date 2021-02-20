<?php

/**
 * Block Name: Contribution
 *
 * This is the template that displays the contribution block.
 */

// Create id attribute allowing for custom "anchor" value.
$id = 'contribution-' . $block['id'];
if( !empty($block['anchor']) ) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'learn-more';
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
        <div class="section-image wow fadeInLeft" data-wow-delay="0.2s">
            <img src="<?php echo get_field('featured_image')['url']; ?>" alt="<?php echo get_field('featured_image')['title']; ?>" />
        </div>
        <div class="section-text-wrapper">
            <h2 class="section-title wow fadeInUp" data-wow-delay="0.4s">
                <?php the_field('title'); ?>
            </h2>
            <a href="<?php the_field('link'); ?>" data-wow-delay="0.4s" target="blank">
                <p class="size-ordinary section-desc">Learn more</p>
            </a>
        </div>
    </div>
</section>
<!-- End Learn More Section -->
