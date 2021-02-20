<?php

/**
 * Block Name: General Post
 *
 * This is the template that displays the general post block.
 */

// Create id attribute allowing for custom "anchor" value.
$id = 'generalpost-' . $block['id'];
if( !empty($block['anchor']) ) {
    $id = $block['anchor'];
}

$className = 'article-content';
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}
if( !empty($block['align']) ) {
    $className .= ' align' . $block['align'];
}

// Load values and assign defaults.

?>
<div id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($className); ?>">
<?php if( have_rows('post_content') ): while( have_rows('post_content') ): the_row(); ?>
<!-- Case: Heading layout -->
<?php if ( get_row_layout() == 'heading' ): ?>
    <h5 class="wow fadeInUp"><?php the_sub_field('title'); ?></h5>
<?php endif; ?>
<!-- Case: Paragraph layout -->
<?php if ( get_row_layout() =='paragraph' ): ?>
<div class="article-content__paragraph" >
<?php if ( have_rows('paragraph_items') ): while ( have_rows('paragraph_items') ): the_row(); ?>
<p class="wow fadeInDown"><?php the_sub_field('item'); ?></p>
<?php endwhile; endif; ?>
</div>
<?php endif; ?>
<!-- Case: Image layout -->
<?php if ( get_row_layout() == 'image'): ?>
<div class="article-content__img">
    <img class="wow fadeInRight" src="<?php echo get_sub_field('image')['url']; ?>" alt="<?php echo get_sub_field('image')['title']; ?>" />
</div>
<?php endif; ?>
<!-- Case: Result layout -->
<?php if ( get_row_layout() == 'result'): ?>
<div class="article-content__statistics">
    <span><?php the_sub_field('year'); ?></span>
    <span><?php the_sub_field('value');  ?></span>
</div>
<?php endif; ?>
<!-- Case: Quote layout -->
<?php if ( get_row_layout() == 'quote'): ?>
<q class="wow fadeInLeft"><?php the_sub_field('content'); ?></q>
<?php endif; ?>
<?php endwhile;  endif; ?>
</div>