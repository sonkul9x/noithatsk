<?php get_header(); ?>
        <main id="main-content">
            <div class="container">
                <?php get_sidebar(); ?>
                <div id="content" class="col-xs-12 col-sm-12 col-md-9 wow fadeInRightBig">
                    <?php get_template_part('section/home','slider'); ?>
                    <?php get_template_part('section/home','producthot'); ?>
                    <!--end product-hot-->
                    <?php get_template_part('section/home','listpro'); ?>
                     <img src="<?php echo THEME_IMG_URI; ?>/banner-content.jpg" alt="" class="row banner-ct wow fadeInUp">
                </div>
            </div>
            <!--end container-->
        </main>
<?php get_footer(); ?>