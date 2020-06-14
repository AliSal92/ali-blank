<?php
function ali_blank_setup()
{
    load_theme_textdomain('ali-blank', get_template_directory() . '/languages');
    add_theme_support('title-tag');
    add_theme_support('automatic-feed-links');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', array('search-form'));
    global $content_width;
    if (!isset($content_width)) {
        $content_width = 1920;
    }
    register_nav_menus(array('main-menu' => esc_html__('Main Menu', 'ali-blank')));
}
add_action('after_setup_theme', 'ali_blank_setup');

function replace_core_jquery_version() {
    wp_deregister_script( 'jquery' );
    // Change the URL if you want to load a local copy of jQuery from your own server.
    wp_register_script( 'jquery', "https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js", array(), '3.5.1', true );
}
add_action( 'wp_enqueue_scripts', 'replace_core_jquery_version' );

function ali_blank_load_scripts()
{
    // css
    wp_register_style( 'fancybox', 'https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css');
    wp_enqueue_style( 'fancybox' );
    wp_register_style( 'bootstrap', 'https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/css/bootstrap.min.css');
    wp_enqueue_style( 'bootstrap' );
    wp_register_style( 'slicknav', 'https://cdnjs.cloudflare.com/ajax/libs/SlickNav/1.0.10/slicknav.min.css');
    wp_enqueue_style( 'slicknav' );
    wp_register_style( 'ali-blank-style', get_stylesheet_uri() );
    wp_enqueue_style( 'ali-blank-style' );

    // js
    wp_enqueue_script( 'bootstrap', 'https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/js/bootstrap.min.js', false, '4.5.0', true );
    wp_enqueue_script( 'fancybox', 'https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js', ['jquery'], '3.5.7', true );
    wp_enqueue_script( 'slicknav', 'https://cdnjs.cloudflare.com/ajax/libs/SlickNav/1.0.10/jquery.slicknav.min.js', ['jquery'], '1.0.10', true );
    wp_enqueue_script( 'ali-blank-scripts', get_theme_file_uri() . '/scripts.js', ['jquery'], '1.0', true );
}
add_action('wp_enqueue_scripts', 'ali_blank_load_scripts');

function ali_blank_document_title_separator($sep)
{
    $sep = '|';
    return $sep;
}
add_filter('document_title_separator', 'ali_blank_document_title_separator');

function ali_blank_title($title)
{
    if ($title == '') {
        return '...';
    } else {
        return $title;
    }
}
add_filter('the_title', 'ali_blank_title');

function ali_blank_read_more_link()
{
    if (!is_admin()) {
        return ' <a href="' . esc_url(get_permalink()) . '" class="more-link">...</a>';
    }
}
add_filter('the_content_more_link', 'ali_blank_read_more_link');

function ali_blank_excerpt_read_more_link($more)
{
    if (!is_admin()) {
        global $post;
        return ' <a href="' . esc_url(get_permalink($post->ID)) . '" class="more-link">...</a>';
    }
}
add_filter('excerpt_more', 'ali_blank_excerpt_read_more_link');

function ali_blank_image_insert_override($sizes)
{
    unset($sizes['medium_large']);
    return $sizes;
}
add_filter('intermediate_image_sizes_advanced', 'ali_blank_image_insert_override');

function ali_blank_widgets_init()
{
    register_sidebar(array(
        'name' => esc_html__('Sidebar Widget Area', 'ali-blank'),
        'id' => 'primary-widget-area',
        'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
        'after_widget' => '</li>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));
}
add_action('widgets_init', 'ali_blank_widgets_init');

function ali_blank_pingback_header()
{
    if (is_singular() && pings_open()) {
        printf('<link rel="pingback" href="%s" />' . "\n", esc_url(get_bloginfo('pingback_url')));
    }
}
add_action('wp_head', 'ali_blank_pingback_header');

function ali_blank_enqueue_comment_reply_script()
{
    if (get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}
add_action('comment_form_before', 'ali_blank_enqueue_comment_reply_script');


function ali_blank_comment_count($count)
{
    if (!is_admin()) {
        global $id;
        $get_comments = get_comments('status=approve&post_id=' . $id);
        $comments_by_type = separate_comments($get_comments);
        return count($comments_by_type['comment']);
    } else {
        return $count;
    }
}
add_filter('get_comments_number', 'ali_blank_comment_count', 0);

function ali_blank_custom_pings($comment)
{
    ?>
    <li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>"><?php echo comment_author_link(); ?></li>
    <?php
}