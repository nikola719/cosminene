<?php

/**
 * Block Name: Cosmin Video
 *
 * This is the template that displays the Cosmin Video block.
 */

// Create id attribute allowing for custom "anchor" value.
$id = 'movie-' . $block['id'];
if( !empty($block['anchor']) ) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'movie';
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}
if( !empty($block['align']) ) {
    $className .= ' align' . $block['align'];
}

// Load values and assign defaults.

?>
<!-- Begin Movie Section -->
<section id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($className); ?>">
    <div class="container">
        <div class="video-wrapper wow zoomIn">
            <iframe
                name="video-frame"
                class="movie-youtube"
                src="https://www.youtube.com/embed/<?php the_field('youtube_id'); ?>"
                frameborder="0"
                allowfullscreen
            ></iframe>
        </div>
    </div>
</section>
<!-- End Movie Section -->