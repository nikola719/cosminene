<!-- Begin Footer -->
<footer class="footer" id="footer">
      <div class="container">
        <a href="<?php echo esc_url(home_url( '/' )); ?>" class="footer-title"><h3><?php the_field('footer_title', 'option'); ?></h3></a>
        <div class="footer-wrapper">
          <div class="footer-wrapper__left">
		  <?php
				wp_nav_menu( array(
					'menu'	=>	'Footer-menu',
					'theme_location' => 'Footer Navigation',
					'menu_id' =>	'',
					'container'	=> false,
					'depth'	=> 2,
					'menu_class'	=>	'footer-menu__items',
				)) ;
			?>
            <span class="copy-right"><?php the_field('copyright', 'option'); ?><?php echo date('Y'); ?></span>
          </div>
          <div class="footer-wrapper__right">
            <span class="footer-email"
              ><a href="mailto:<?php the_field('email_address', 'option') ?>"><?php the_field('email_name', 'option') ?></a></span
            >
            <ul class="footer-social__items">
              <?php if( have_rows('social_icons', 'option') ) : while( have_rows('social_icons', 'option') ): the_row(); ?>
              <li class="menu-item">
                <a href="<?php echo get_sub_field('icon_url', 'option'); ?>" target="blank">
                  <img src="<?php echo get_sub_field('icon_image', 'option')['url']; ?>" alt="<?php echo get_sub_field('icon_image', 'option')['title'] ?>" />
                </a>
              </li>
              <?php endwhile; endif; ?>
            </ul>
          </div>
        </div>
      </div>
    </footer>
    <!-- End Footer -->