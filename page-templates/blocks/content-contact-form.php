<?php

/**
 * Block Name: Contact Form
 *
 * This is the template that displays the contact form block.
 */

// Create id attribute allowing for custom "anchor" value.
$id = 'contacts-' . $block['id'];
if( !empty($block['anchor']) ) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'article contacts';
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}
if( !empty($block['align']) ) {
    $className .= ' align' . $block['align'];
}

// Load values and assign defaults.

?>
<!-- Begin Contact Form Section -->
<section id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($className); ?>">
    <div class="container">
        <div class="article-meta">
        </div>
        <div class="article-content">
            <h5 class="wow fadeInDown">
                <?php the_field('title'); ?>
            </h5>
            <div class="contact-form wow fadeInUp" data-wow-delay="0.3s">
                <?php the_field('form_shortcode'); ?>
            <?php //echo do_shortcode(the_field('form_shortcode')); ?>
            </div>
        </div>
    </div>
</section>
<!-- End Contact Form Section -->