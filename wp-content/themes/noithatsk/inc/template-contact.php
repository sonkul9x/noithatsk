<?php /* Template Name: Contact Page */ ?>
<?php get_header(); ?>
        <main id="main-content">
            <div class="container">
                <div class="contact-page">
               
                    <h1 class="title-h1">Liên hệ</h1>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 contact-info">
                         <?php if ( have_posts() ) : ?>
                    <?php  while ( have_posts() ) : the_post(); ?>
						<?php the_content(); ?>
                        <?php             	
			    endwhile; // end while
			endif; // end if
			wp_reset_query(); ?>
                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 form-contact">
                    <?php echo do_shortcode('[contact-form-7 id="23" title="Liên hệ"]'); ?>                       
                    </div>
                    <div class="clear"></div>
                </div>
            </div><!--end container-->
        </main>
<?php get_footer(); ?>