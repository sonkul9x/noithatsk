<!DOCTYPE html>
<html lang="lang=" vi " prefix="og: http://ogp.me/ns# "">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php wp_title(''); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="<?php bloginfo('description'); ?>">
    <link href="https://fonts.googleapis.com/css?family=Lobster|Roboto+Condensed:300,400,700" rel="stylesheet"> 
    <?php wp_head(); ?> 
</head>

<body class="home blog">
    <div class="container-fluid">
        <header id="header">
            <div class="row top-header">
                <div class="container">
                    <a href="#" class="logo col-xs-12 col-sm-6 wow fadeInLeftBig"><img src="<?php echo THEME_IMG_URI; ?>/logo.png" alt=""></a>
                    <?php get_search_form(); ?>
                </div>

            </div>
            <div class="row menu-header wow fadeInUp">
                <nav class="navbar navbar-default" role="navigation">
                    <div class="container">
                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                                <span class="sr-only">MENU</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                        </div>
                        <div id="navbar" class="navbar-collapse collapse" aria-expanded="false" style="height: 1px;">
                            <?php /* Primary navigation */
                                 wp_nav_menu( array(
                                   'theme_location' => 'main-menu', //Menu location của bạn
                                   'depth' => 2, //Số cấp menu đa cấp
                                   'container' => 'div', //Thẻ bao quanh cặp thẻ ul
                                   'container_class'=>'collapse navbar-collapse navbar-ex1-collapse', //class của thẻ bao quanh cặp thẻ ul
                                   'menu_class' => 'nav navbar-nav', //class của thẻ ul
                                   'walker' => new wp_bootstrap_navwalker()) //Cái này để nguyên, không thay đổi
                            );
                            ?>
                            <p class="hotline pull-right">
                                Hotline : <a href="#"> 0988.258.392</a> - <a href="#">0988.258.392</a>
                            </p>
                        </div>
                        <!--/.nav-collapse -->
                    </div>
                </nav>
            </div>
        </header>