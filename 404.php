<?php get_header(); ?>
<main>
    <section class="Requesterror">
        <div class="container">
            <div class="Requesterror-wrapper">
            <h1 class="Requesterror-title">404</h1>
            <h2 class="Requesterror-subtitle">
                We couldn’t find the page you were looking for
            </h2>
            <a href="<?php echo esc_url(home_url( '/' )); ?>" class="Requesterror-redirect"
                ><p>Go to homepage</p></a
            >
            </div>
        </div>
    </section>
</main>

<?php get_footer(); ?>