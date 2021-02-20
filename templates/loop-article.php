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
<?php if ( get_post_type( get_the_ID() ) == 'post' ):  ?>
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
<?php endif; ?>
<?php if ( get_post_type( get_the_ID() ) == 'videos' ):  ?>
<div class="artint-read">
    <div class="artint-read__container">
        <div class="artint-read__desc">
            <h2 class="artint-read__title wow fadeInDown"><?php the_title(); ?></h2>
            <a class="artint-read__link wow fadeInDown" href="<?php the_permalink(); ?>"><p class="size-ordinary">Watch now</p></a>
        </div>
        <div class="artint-read__meta">
        <?php $author = get_field('name', get_the_ID());?>
            <p class="wow fadeInDown"><?php echo $author; ?></p>
            <p class="wow fadeInDown"><?php echo $postCategories; ?></p>
        </div>
    </div>
    <div class="artint-read__img wow fadeInDown">
    <?php $thumbnail_url = get_the_post_thumbnail_url(get_the_ID(),'full');?>
        <img src="<?php echo $thumbnail_url; ?>" alt="artint-1a" />
    </div>
</div>
<?php endif; ?>