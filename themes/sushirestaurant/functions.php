<?php
// the navigation bar
function sushi_setup_theme() {
    // register navigation
    register_nav_menus( array (
        'header' => 'Header menu',
        'footer' => 'Footer menu'
    ));
}

// need to add the action
add_action( 'after_setup_theme', 'sushi_setup_theme' );
// any mistakes here in this file will break the entire website. they need to be fixed before the site will load
// add our featured image support for our posts
add_theme_support( 'post-thumbnails' );

// set up our own custom footer widgets
// function names can be named anything we want.
// register_sidebar is a php hook and the name is already determined for wordpress

function footerWidgets() {
    register_sidebar(array(
        'name' =>__( 'Footer Widget Area One', 'footer' ),
        'id' => 'footer-widget-area-one',
        'description' => __( 'First Widget Area', 'Footer' ),
        'before_widget' => '<div class="logo-widget">',
        'after_widget' => '</div>',
    ));
    register_sidebar(array(
        'name' =>__( 'Footer Widget Area Two', 'footer' ),
        'id' => 'footer-widget-area-two',
        'description' => __( 'Second Widget Area', 'Footer' ),
        'before_widget' => '<div class="logo-widget">',
        'after_widget' => '</div>',
    ));
    register_sidebar(array(
        'name' =>__( 'Footer Widget Area Three', 'footer' ),
        'id' => 'footer-widget-area-three',
        'description' => __( 'Third Widget Area', 'Footer' ),
        'before_widget' => '<div class="logo-widget">',
        'after_widget' => '</div>',
    ));
}
// widgets init to enable the footer widgets in the wordpress dashboard
add_action( 'widgets_init', 'footerWidgets' );

// custom plugin
function restaurant_sushi() {
    // the args variable can be named anything you want
    $args = array(
        'label' => 'Food',
        'public' => true,
        'show_ui' => true,
        // you determine whether it makes a post or a page
        'capability_type' => 'post',
        // taxonomies can either be categories or tags
        'taxonomies' => array( 'category' ),
        // if capability type is page, set hieratchical to true
        'hierarchical' => 'false',
        'query_var' => true,
        // allows cusdtom icons
        'menu_icon' => 'dashicons-food',
        'supports' => array(
            'title',
            'editor',
            'excerpts',
            'trackbacks',
            'comments',
            'thumbnail',
            'author',
            'post-formats',
            'page-attributes',
        )
    );
    register_post_type('food', $args);
}
add_action('init', 'restaurant_sushi');

// plugin shortcode for custom post type
function sushi_shortcode() {
    // query variable that holds post type, order, and how many. asc = ascending
    $query = new WP_Query(array('post_type' => 'food', 'post_per_page' => 8, 'order' => 'asc'));
    while ($query -> have_posts()) : $query -> the_post();
    ?>
    <div class="col-sm-12 col-md-6 col-lg-4">
        <div class="food-container">
            <a href="<?php the_permalink(); ?>">
                <?php the_post_thumbnail(); ?>
            </a>
        </div>
        <div class="content">
            <h4><?php the_title(); ?></h4>
            <?php the_content(); ?>
            <p><a href="<?php the_permalink(); ?>">Learn More</a></p>
        </div>
    </div>
    <!-- WordPress equilavent of closing our database connection -->
    <?php wp_reset_postdata(); ?>
    <?php
    endwhile;
    wp_reset_postdata();
}
// don't need action or register function for shortcode. it's a php hook for wordPress. first value is the name of the shortcode, the second is the name of our function - the food in squarebrackets
add_shortcode('food', 'sushi_shortcode');

// changing my excerpt length
add_filter( 'excerpt_length', function($length) {
    return 25;
  }, PHP_INT_MAX );
  // adding woocommerce support to our theme | makes the products appear correctly in their respective pages
  function customtheme_add_woocommerce_support() {
    add_theme_support( 'woocommerce' );
    add_theme_support( 'wc-product-gallery-zoom' );
    add_theme_support( 'wc-product-gallery-lightbox' );
    add_theme_support( 'wc-product-gallery-slider' );
  }
  add_action( 'after_setup_theme', 'customtheme_add_woocommerce_support' );
  function enqueue_wc_cart_fragments() { wp_enqueue_script( 'wc-cart-fragments' ); }
  add_action( 'wp_enqueue_scripts', 'enqueue_wc_cart_fragments' );
?>

