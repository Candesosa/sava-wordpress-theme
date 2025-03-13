<!--?php
/**
 * SAVA Theme functions and definitions
 *
 * @package SAVA
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Define constants
define('SAVA_VERSION', '1.0.0');
define('SAVA_DIR', get_template_directory());
define('SAVA_URI', get_template_directory_uri());

// Setup theme
function sava_setup() {
    // Add default posts and comments RSS feed links to head
    add_theme_support('automatic-feed-links');

    // Let WordPress manage the document title
    add_theme_support('title-tag');

    // Enable support for Post Thumbnails
    add_theme_support('post-thumbnails');

    // WooCommerce support
    add_theme_support('woocommerce');
    add_theme_support('wc-product-gallery-zoom');
    add_theme_support('wc-product-gallery-lightbox');
    add_theme_support('wc-product-gallery-slider');

    // Register nav menus
    register_nav_menus(array(
        'primary' =--> esc_html__('Primary Menu', 'sava'),
        'footer' =&gt; esc_html__('Footer Menu', 'sava'),
    ));

    // Add theme support for selective refresh for widgets
    add_theme_support('customize-selective-refresh-widgets');

    // Add support for responsive embedded content
    add_theme_support('responsive-embeds');
}
add_action('after_setup_theme', 'sava_setup');

// Enqueue scripts and styles
function sava_scripts() {
    // Enqueue styles
    wp_enqueue_style('sava-style', get_stylesheet_uri(), array(), SAVA_VERSION);
    
    // Enqueue custom scripts
    wp_enqueue_script('sava-navigation', SAVA_URI . '/assets/js/navigation.js', array(), SAVA_VERSION, true);
    
    if (is_singular() &amp;&amp; comments_open() &amp;&amp; get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}
add_action('wp_enqueue_scripts', 'sava_scripts');

// Include required files
require SAVA_DIR . '/inc/custom-post-types.php';
require SAVA_DIR . '/inc/elementor-widgets.php';
require SAVA_DIR . '/inc/woocommerce-functions.php';

// Elementor Pro support
function sava_register_elementor_locations($elementor_theme_manager) {
    $elementor_theme_manager-&gt;register_location('header');
    $elementor_theme_manager-&gt;register_location('footer');
}
add_action('elementor/theme/register_locations', 'sava_register_elementor_locations');

// Custom Elementor controls
function sava_add_elementor_widget_categories($elements_manager) {
    $elements_manager-&gt;add_category(
        'sava',
        [
            'title' =&gt; esc_html__('SAVA Elements', 'sava'),
            'icon' =&gt; 'fa fa-coffee',
        ]
    );
}
add_action('elementor/elements/categories_registered', 'sava_add_elementor_widget_categories');

// WooCommerce customizations
function sava_woocommerce_setup() {
    add_theme_support('woocommerce', array(
        'thumbnail_image_width' =&gt; 400,
        'single_image_width'    =&gt; 800,
        'product_grid'          =&gt; array(
            'default_rows'    =&gt; 3,
            'min_rows'        =&gt; 1,
            'max_rows'        =&gt; 8,
            'default_columns' =&gt; 3,
            'min_columns'     =&gt; 1,
            'max_columns'     =&gt; 4,
        ),
    ));
}
add_action('after_setup_theme', 'sava_woocommerce_setup');

// Custom image sizes
function sava_add_image_sizes() {
    add_image_size('sava-hero', 1920, 1080, true);
    add_image_size('sava-product', 600, 600, true);
    add_image_size('sava-thumbnail', 400, 400, true);
}
add_action('after_setup_theme', 'sava_add_image_sizes');

// Add body classes
function sava_body_classes($classes) {
    if (!is_singular()) {
        $classes[] = 'hfeed';
    }
    return $classes;
}
add_filter('body_class', 'sava_body_classes');

// Register widget areas
function sava_widgets_init() {
    register_sidebar(array(
        'name'          =&gt; esc_html__('Sidebar', 'sava'),
        'id'            =&gt; 'sidebar-1',
        'description'   =&gt; esc_html__('Add widgets here.', 'sava'),
        'before_widget' =&gt; '<section id="%1$s" class="widget %2$s">',
        'after_widget'  =&gt; '</section>',
        'before_title'  =&gt; '<h2 class="widget-title">',
        'after_title'   =&gt; '</h2>',
    ));
}
add_action('widgets_init', 'sava_widgets_init');

// Custom login page
function sava_custom_login_logo() {
    ?&gt;
    <style type="text/css">
        #login h1 a, .login h1 a {
            background-image: url(<?php echo get_stylesheet_directory_uri(); ?>/assets/images/logo.png);
            background-size: contain;
            width: 320px;
            height: 80px;
        }
    </style>
    <!--?php
}
add_action('login_enqueue_scripts', 'sava_custom_login_logo');

// Disable Gutenberg editor for specific templates
function sava_disable_gutenberg($is_enabled, $post_type) {
    if (isset($_GET['elementor-preview'])) {
        return false;
    }
    return $is_enabled;
}
add_filter('use_block_editor_for_post_type', 'sava_disable_gutenberg', 10, 2);</div--><i class="copy-button__icon pi pi-copy"></i>
