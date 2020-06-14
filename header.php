<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>"/>
    <meta name="viewport" content="width=device-width"/>
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<div id="wrapper" class="hfeed">
    <header id="header">
        <div id="branding">
            <div class="container">
                <div class="row">
                    <div class="col-md-4 align-self-center">
                        <div id="site-title">
                            <a href="<?php echo get_home_url(); ?>" title="Logo">
                                <img src="https://via.placeholder.com/350x120" style="width: 100%;" alt="Website Logo"/>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-8 align-self-center">
                        <div class="text text-right">
                            <div id="search"><?php get_search_form(); ?></div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="site-description"><?php bloginfo('description'); ?></div>
        </div>
        <div class="main-menu-con">
            <div class="container">
                <nav id="menu">
                    <?php wp_nav_menu(array('theme_location' => 'main-menu')); ?>
                </nav>
                <div class="responsive-menu"></div>
            </div>
        </div>
    </header>
    <div class="container">