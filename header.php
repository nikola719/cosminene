<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no">
	<meta name="format-detection" content="telephone=no">
	<?php if ( is_singular() && pings_open( get_queried_object() ) ) : ?>
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<?php endif; ?>
	<?php /*<link rel="shortcut icon" type="image/png" href="<?php echo get_template_directory_uri(); ?>/images/favicon.png">*/ ?>
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<!-- Begin Header -->
<header class="header">
	<div class="container">
		<nav class="header-nav">
			<div class="header-nav__wrapper">
				<a class="header-nav__logo" href="<?php echo esc_url(home_url( '/' )); ?>">
					<div class="pic-svg">
						<!-- <svg
							width="20"
							height="29"
							viewBox="0 0 20 29"
							fill="none"
							xmlns="http://www.w3.org/2000/svg"
						>
							<path
							d="M8.05031 10.6842V8.39474C8.05031 8.33114 8.11321 8.26754 8.1761 8.26754H14.3396V0.317982C14.3396 0.127193 14.2138 0 14.0252 0C6.22641 0.190789 0 6.61404 0 14.5C0 22.386 6.22641 28.8092 14.0252 29C14.2138 29 14.3396 28.8728 14.3396 28.682V20.9868H8.1761C8.11321 20.9868 8.05031 20.9232 8.05031 20.8596V18.5702C8.05031 18.5066 8.11321 18.443 8.1761 18.443H14.3396V15.8991H8.1761C8.11321 15.8991 8.05031 15.8355 8.05031 15.7719V13.4825C8.05031 13.4189 8.11321 13.3553 8.1761 13.3553H14.3396V10.8114H8.1761C8.11321 10.8114 8.05031 10.7478 8.05031 10.6842Z"
							fill="#302D2B"
							/>
							<path
							d="M20.0002 10.6842V8.39477C20.0002 8.33117 19.9373 8.26758 19.8744 8.26758H14.3398V10.8114H19.8744C19.9373 10.8114 20.0002 10.7478 20.0002 10.6842Z"
							fill="#302D2B"
							/>
							<path
							d="M20.0002 15.7719V13.4824C20.0002 13.4188 19.9373 13.3552 19.8744 13.3552H14.3398V15.8991H19.8744C19.9373 15.8991 20.0002 15.8355 20.0002 15.7719Z"
							fill="#302D2B"
							/>
							<path
							d="M20.0002 20.8597V18.5702C20.0002 18.5066 19.9373 18.443 19.8744 18.443H14.3398V20.9869H19.8744C19.9373 20.9869 20.0002 20.9233 20.0002 20.8597Z"
							fill="#302D2B"
							/>
						</svg> -->
						<?php the_field('logo', 'option'); ?>
					</div>
					<span><?php the_field('header_title', 'option'); ?></span>
				</a>
				<div class="hamburger">
					<span></span>
					<span></span>
				</div>
			</div>
			<div class="header-nav__container">
				<?php
					wp_nav_menu( array(
						'menu'	=>	'Header-menu',
						'theme_location' => 'Main Navigation',
						'menu_id' =>	'',
						'container'	=> false,
						'depth'	=> 2,
						'menu_class'	=>	'header-nav__items',
					)) ;
				?>
				<ul class="header-nav-social__items">
					<?php if( have_rows('social_icons', 'option') ) : while( have_rows('social_icons', 'option') ): the_row(); ?>
					<li class="header-nav-social__item">
						<a href="<?php echo get_sub_field('icon_url', 'option'); ?>" target="blank">
						<img src="<?php echo get_sub_field('icon_image', 'option')['url']; ?>" alt="<?php echo get_sub_field('icon_image', 'option')['title'] ?>" />
						</a>
					</li>
					<?php endwhile; endif; ?>
				</ul>
			</div>
		</nav>
	</div>
</header>
<!-- End Header -->