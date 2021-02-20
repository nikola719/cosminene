<?php

/**
 * Block Name: Introduction
 *
 * This is the template that displays the Introduction block.
 */

// Create id attribute allowing for custom "anchor" value.
$id = 'introduction-' . $block['id'];
if( !empty($block['anchor']) ) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'introduction';
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
        <h1 class="section-title wow fadeInUp" data-wow-delay="0.2s">
        <?php the_field('title'); ?>
        </h1>
    </div>
</section>