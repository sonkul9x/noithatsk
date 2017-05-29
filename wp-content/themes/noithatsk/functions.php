<?php
define('THEME_VERSION',     '1.0');
define('THEME_NAME',        'PVN ');
define('THEME_AUTHOR',      'sontv');
define('THEME_AUTHOR_LINK', 'http://tranvanson.xyz/');
define('THEME_CREATED',      THEME_VERSION);
define('THEME_BASE_DIR',   get_template_directory());
define('THEME_BASE_URI',   get_template_directory_uri());
define('THEME_CSS_URI',     THEME_BASE_URI . '/css');
define('THEME_JS_URI',     THEME_BASE_URI . '/js');
define('THEME_IMG_URI',    THEME_BASE_URI . '/images');
/*------------------------------------*\
    External Modules/Files
\*------------------------------------*/

if (function_exists('add_theme_support'))
{
    // Add Menu Support
    add_theme_support('menus'); 
    // Add Thumbnail Theme Support
    add_theme_support('post-thumbnails');
    add_image_size('img-sm', 202 , 160 , true); // Large Thumbnail   
    add_image_size('img-sml', 9999 , 300 , true); 

    //Add Support for Custom Backgrounds - Uncomment below if you're going to use
    add_theme_support('custom-background', array(
    'default-color' => 'dcddde',
   // 'default-image' => get_template_directory_uri() . '/img/bg.jpg'
    ));

    // Add Support for Custom Header - Uncomment below if you're going to use
    /*add_theme_support('custom-header', array(
    'default-image'         => get_template_directory_uri() . '/img/headers/default.jpg',
    'header-text'           => false,
    'default-text-color'        => '000',
    'width'             => 1000,
    'height'            => 198,
    'random-default'        => false,
    'wp-head-callback'      => $wphead_cb,
    'admin-head-callback'       => $adminhead_cb,
    'admin-preview-callback'    => $adminpreview_cb
    ));*/

    // Enables post and comment RSS feed links to head
    add_theme_support('automatic-feed-links');
    add_theme_support( 'post-formats', array( 'video','image' ) );
    // Localisation Support
    load_theme_textdomain('html5blank', get_template_directory() . '/languages');
}

/*------------------------------------*\
    Functions
\*------------------------------------*/

// HTML5 Blank navigation
function html5blank_nav($idmenu,$class='')
{
    wp_nav_menu(
    array(
        'theme_location'  => $idmenu,
        'menu'            => '',
        'container'       => '',
        'container_class' => '',
        'container_id'    => '',
        'menu_class'      => $class,
        'menu_id'         => $idmenu,
        'echo'            => true,
        'fallback_cb'     => 'wp_page_menu',
        'before'          => '',
        'after'           => '',
        'link_before'     => '',
        'link_after'      => '',
        'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
        'depth'           => 0,
        'walker'          => ''
        )
    );
}

// Load HTML5 Blank scripts (header.php)
function html5blank_header_scripts()
{
    if ($GLOBALS['pagenow'] != 'wp-login.php' && !is_admin()) {               
        wp_register_script('html5blankscripts', THEME_JS_URI . '/app.bundle.js', array(), '1.0.0'); // Custom scripts
        wp_enqueue_script('html5blankscripts'); // Enqueue it!
         
   }

}

add_action( 'wp_print_styles', 'gdx_add_styles' );
function gdx_add_styles() {   
    wp_enqueue_style( 'bootstrap',THEME_CSS_URI . '/app.bundle.min.css', array(), '1.0', 'all');    
}

// Register HTML5 Blank Navigation
function register_html5_menu()
{
    register_nav_menus(array( // Using array to specify more menus if needed
        'main-menu' => __('Menu chinh', 'html5blank'), // Main Navigation      
        'menu-footer' => __('Menu footer', 'html5blank'), // Main Navigation   
       
    ));
}

// Remove the <div> surrounding the dynamic navigation to cleanup markup
function my_wp_nav_menu_args($args = '')
{
    $args['container'] = false;
    return $args;
}

// Remove Injected classes, ID's and Page ID's from Navigation <li> items
function my_css_attributes_filter($var)
{
    return is_array($var) ? array() : '';
}

// Remove invalid rel attribute values in the categorylist
function remove_category_rel_from_category_list($thelist)
{
    return str_replace('rel="category tag"', 'rel="tag"', $thelist);
}

// Add page slug to body class, love this - Credit: Starkers Wordpress Theme
function add_slug_to_body_class($classes)
{
    global $post;
    if (is_home()) {
        $key = array_search('blog', $classes);
        if ($key > -1) {
            unset($classes[$key]);
        }
    } elseif (is_page()) {
        $classes[] = sanitize_html_class($post->post_name);
    } elseif (is_singular()) {
        $classes[] = sanitize_html_class($post->post_name);
    }

    return $classes;
}


// Remove wp_head() injected Recent Comment styles
function my_remove_recent_comments_style()
{
    global $wp_widget_factory;
    remove_action('wp_head', array(
        $wp_widget_factory->widgets['WP_Widget_Recent_Comments'],
        'recent_comments_style'
    ));
}

// Pagination for paged posts, Page 1, Page 2, Page 3, with Next and Previous Links, No plugin


if(! function_exists('wt_amaza_pagination')) :
function wt_amaza_pagination() {
 global $wp_query;

 $big = 999999999; // need an unlikely integer
 
 echo paginate_links(array(
  'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
  'format' => '?paged=%#%',
  'current' => max(1, get_query_var('paged')),
  'total' => $wp_query->max_num_pages,
  'prev_text'    => wp_kses(__('«', 'wt-amaza'), array('i' => array())),
  'next_text'    => wp_kses(__('»', 'wt-amaza'), array('i' => array())),
 ));
}
endif;

// Custom Excerpts
function html5wp_index($length) // Create 20 Word Callback for Index page Excerpts, call using html5wp_excerpt('html5wp_index');
{
    return 20;
}

// Create 40 Word Callback for Custom Post Excerpts, call using html5wp_excerpt('html5wp_custom_post');
function html5wp_custom_post($length)
{
    return 40;
}

// Create the Custom Excerpts callback
function html5wp_excerpt($length_callback = '', $more_callback = '')
{
    global $post;
    if (function_exists($length_callback)) {
        add_filter('excerpt_length', $length_callback);
    }
    if (function_exists($more_callback)) {
        add_filter('excerpt_more', $more_callback);
    }
    $output = get_the_excerpt();
    $output = apply_filters('wptexturize', $output);
    $output = apply_filters('convert_chars', $output);
    $output = '<p>' . $output . '</p>';
    echo $output;
}

// Custom View Article link to Post
function html5_blank_view_article($more)
{
    global $post;
    return '... <a class="view-article" href="' . get_permalink($post->ID) . '">' . __('Xem tiếp', 'html5blank') . '</a>';
}

// Remove Admin bar
function remove_admin_bar()
{
    return is_super_admin() ? true : false;
}

// Remove 'text/css' from our enqueued stylesheet
function html5_style_remove($tag)
{
    return preg_replace('~\s+type=["\'][^"\']++["\']~', '', $tag);
}

// Remove thumbnail width and height dimensions that prevent fluid images in the_thumbnail
function remove_thumbnail_dimensions( $html )
{
    $html = preg_replace('/(width|height)=\"\d*\"\s/', "", $html);
    return $html;
}

// Custom Gravatar in Settings > Discussion
function html5blankgravatar ($avatar_defaults)
{
    $myavatar = get_template_directory_uri() . '/img/gravatar.jpg';
    $avatar_defaults[$myavatar] = "Custom Gravatar";
    return $avatar_defaults;
}

// Threaded Comments
function enable_threaded_comments()
{
    if (!is_admin()) {
        if (is_singular() AND comments_open() AND (get_option('thread_comments') == 1)) {
            wp_enqueue_script('comment-reply');
        }
    }
}

// Custom Comments Callback
function html5blankcomments($comment, $args, $depth)
{
    $GLOBALS['comment'] = $comment;
    extract($args, EXTR_SKIP);

    if ( 'div' == $args['style'] ) {
        $tag = 'div';
        $add_below = 'comment';
    } else {
        $tag = 'li';
        $add_below = 'div-comment';
    }
?>
    <!-- heads up: starting < for the html tag (li or div) in the next line: -->
    <<?php echo $tag ?> <?php comment_class(empty( $args['has_children'] ) ? '' : 'parent') ?> id="comment-<?php comment_ID() ?>">
    <?php if ( 'div' != $args['style'] ) : ?>
    <div id="div-comment-<?php comment_ID() ?>" class="comment-body">
    <?php endif; ?>
    <div class="comment-author vcard">
    <?php if ($args['avatar_size'] != 0) echo get_avatar( $comment, $args['180'] ); ?>
    <?php printf(__('<cite class="fn">%s</cite> <span class="says">says:</span>'), get_comment_author_link()) ?>
    </div>
<?php if ($comment->comment_approved == '0') : ?>
    <em class="comment-awaiting-moderation"><?php _e('Your comment is awaiting moderation.') ?></em>
    <br />
<?php endif; ?>

    <div class="comment-meta commentmetadata"><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>">
        <?php
            printf( __('%1$s at %2$s'), get_comment_date(),  get_comment_time()) ?></a><?php edit_comment_link(__('(Edit)'),'  ','' );
        ?>
    </div>

    <?php comment_text() ?>

    <div class="reply">
    <?php comment_reply_link(array_merge( $args, array('add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
    </div>
    <?php if ( 'div' != $args['style'] ) : ?>
    </div>
    <?php endif; ?>
<?php }
add_filter( 'wp_title', 'baw_hack_wp_title_for_home' );
function baw_hack_wp_title_for_home( $title )
{
  if( empty( $title ) && ( is_home() || is_front_page() ) ) {
    return __( 'Trang chủ', 'theme_domain' ) . ' | ' . get_bloginfo( 'description' );
  }
  return $title;
}

/*------------------------------------*\
    Actions + Filters + ShortCodes
\*------------------------------------*/

// Add Actions
add_action('wp_footer', 'html5blank_header_scripts'); // Add Custom Scripts to wp_head
add_action('get_header', 'enable_threaded_comments'); // Enable Threaded Comments
//add_action('wp_enqueue_scripts', 'html5blank_styles'); // Add Theme Stylesheet
add_action('init', 'register_html5_menu'); // Add HTML5 Blank Menu
add_action('widgets_init', 'my_remove_recent_comments_style'); // Remove inline Recent Comment Styles from wp_head()


// Remove Actions
remove_action('wp_head', 'feed_links_extra', 3); // Display the links to the extra feeds such as category feeds
remove_action('wp_head', 'feed_links', 2); // Display the links to the general feeds: Post and Comment Feed
remove_action('wp_head', 'rsd_link'); // Display the link to the Really Simple Discovery service endpoint, EditURI link
remove_action('wp_head', 'wlwmanifest_link'); // Display the link to the Windows Live Writer manifest file.
remove_action('wp_head', 'index_rel_link'); // Index link
remove_action('wp_head', 'parent_post_rel_link', 10, 0); // Prev link
remove_action('wp_head', 'start_post_rel_link', 10, 0); // Start link
remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0); // Display relational links for the posts adjacent to the current post.
remove_action('wp_head', 'wp_generator'); // Display the XHTML generator that is generated on the wp_head hook, WP version
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
remove_action('wp_head', 'rel_canonical');
remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);

// Add Filters
add_filter('avatar_defaults', 'html5blankgravatar'); // Custom Gravatar in Settings > Discussion
add_filter('body_class', 'add_slug_to_body_class'); // Add slug to body class (Starkers build)
add_filter('widget_text', 'do_shortcode'); // Allow shortcodes in Dynamic Sidebar
add_filter('widget_text', 'shortcode_unautop'); // Remove <p> tags in Dynamic Sidebars (better!)
add_filter('wp_nav_menu_args', 'my_wp_nav_menu_args'); // Remove surrounding <div> from WP Navigation
// add_filter('nav_menu_css_class', 'my_css_attributes_filter', 100, 1); // Remove Navigation <li> injected classes (Commented out by default)
// add_filter('nav_menu_item_id', 'my_css_attributes_filter', 100, 1); // Remove Navigation <li> injected ID (Commented out by default)
// add_filter('page_css_class', 'my_css_attributes_filter', 100, 1); // Remove Navigation <li> Page ID's (Commented out by default)
add_filter('the_category', 'remove_category_rel_from_category_list'); // Remove invalid rel attribute
add_filter('the_excerpt', 'shortcode_unautop'); // Remove auto <p> tags in Excerpt (Manual Excerpts only)
add_filter('the_excerpt', 'do_shortcode'); // Allows Shortcodes to be executed in Excerpt (Manual Excerpts only)
add_filter('excerpt_more', 'html5_blank_view_article'); // Add 'View Article' button instead of [...] for Excerpts
// add_filter('show_admin_bar', 'remove_admin_bar'); // Remove Admin bar
add_filter('style_loader_tag', 'html5_style_remove'); // Remove 'text/css' from enqueued stylesheet
add_filter('post_thumbnail_html', 'remove_thumbnail_dimensions', 10); // Remove width and height dynamic attributes to thumbnails
add_filter('image_send_to_editor', 'remove_thumbnail_dimensions', 10); // Remove width and height dynamic attributes to post images

// Remove Filters
remove_filter('the_excerpt', 'wpautop'); // Remove <p> tags from Excerpt altogether



// function to display number of posts.
function getPostViews($postID){
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
        return "0 Lượt xem";
    }
    return $count.' Lượt xem';
}
 
// function to count views.
function setPostViews($postID) {
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        $count = 0;
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
    }else{
        $count++;
        update_post_meta($postID, $count_key, $count);
    }
}
 
 
// Add it to a column in WP-Admin
add_filter('manage_posts_columns', 'posts_column_views');
add_action('manage_posts_custom_column', 'posts_custom_column_views',5,2);
function posts_column_views($defaults){
    $defaults['post_views'] = __('Views');
    return $defaults;
}
function posts_custom_column_views($column_name, $id){
    if($column_name === 'post_views'){
        echo getPostViews(get_the_ID());
    }
}


// If Dynamic Sidebar Exists
if (function_exists('register_sidebar'))
{
    // Define Sidebar Widget Area 1
    register_sidebar(array(
        'name' => __('Vị trí Sidebar Trái', 'html5blank'),
        'description' => __('Description for this widget-area...', 'html5blank'),
        'id' => 'sidebar-left',
        'before_widget' => '<div class="sidebar-box wow fadeInLeft">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="title-big"><i class="glyphicon glyphicon-bed"></i> ',
        'after_title' => '</h3>'
    ));

   
}


class Random_Post extends WP_Widget {
 
    function __construct() {
        parent::__construct(
            'random_post',
            'Bài mới nhất',
            array( 'description'  =>  'Widget hiển thị bài viết mới nhất' )
        );
    }
 
    function form( $instance ) { 
        $default = array(
            'title' => 'Tin tức mới nhất',
            'post_number' => 10,
          //  'cat' => 1
        );
        $instance = wp_parse_args( (array) $instance, $default );
        $title = esc_attr($instance['title']);
        $post_number = esc_attr($instance['post_number']);
        $cat = esc_attr($instance['cat']);
 
        echo '<p>Nhập tiêu đề <input type="text" class="widefat" name="'.$this->get_field_name('title').'" value="'.$title.'"/></p>';
        echo '<p>Số lượng bài viết hiển thị <input type="number" class="widefat" name="'.$this->get_field_name('post_number').'" value="'.$post_number.'" placeholder="'.$post_number.'" max="30" /></p>';
         $categories = get_terms( 'category', array(
            'orderby'    => 'name',
            'hide_empty' => 0
        ) );
        echo '<select name="'.$this->get_field_name('cat').'" >';
             echo '<option selected  value="null">Tất cả</option>'; 
            foreach ($categories as $vcategory) {                      
            if($vcategory->term_id == $cat){
              echo '<option selected  value="'.$vcategory->term_id.'">'.$vcategory->name.'</option>';  
          }else{
            echo '<option  value="'.$vcategory->term_id.'">'.$vcategory->name.'</option>';
        }
            }
        echo '</select>';      
    }
 
    function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['post_number'] = strip_tags($new_instance['post_number']);
        $instance['cat'] = strip_tags($new_instance['cat']);
        return $instance;
    }
 
    function widget( $args, $instance ) {
        extract($args);
        $title = apply_filters( 'widget_title', $instance['title'] );
        $post_number = $instance['post_number'];
        $cat = $instance['cat']; 

        echo $before_widget;
        echo $before_title.$title.$after_title;        
         if($cat !='null'){
           $random_query = new WP_Query('post_type=post&posts_per_page='.$post_number.'&cat='.$cat.'&order=DESC'); 
        }else{
           $random_query = new WP_Query('post_type=post&posts_per_page='.$post_number.'&order=DESC');  
        }
        if ($random_query->have_posts()):
            echo '<ul class="sidebar-list">';
            while( $random_query->have_posts() ) :
                $random_query->the_post(); ?> 
                <li>               
                <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php echo wp_trim_words(get_the_title(), 10); ?></a>               
               </li>
 
            <?php endwhile;
            echo "</ul>";
        endif;
        echo $after_widget; 
    } 
}


function my_pre_get_posts($query) {
    if( is_admin() ) 
        return;
    if( is_search() && $query->is_main_query() ) {
        $query->set('post_type', 'post');
    } 
}
add_action( 'pre_get_posts', 'my_pre_get_posts' );

add_action( 'widgets_init', 'create_randompost_widget' );
function create_randompost_widget() {
    register_widget('Random_Post');
}
if (!is_admin()) {
 add_action("wp_enqueue_scripts", "my_jquery_enqueue", 11);
}
function my_jquery_enqueue() {
   //wp_deregister_script('jquery');
   wp_deregister_script( 'wp-embed' );
   remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');
}

// Register Custom Post Type
function custom_post_type() {

    $labels = array(
        'name'                  => _x( 'Sản Phẩm', 'Post Type General Name', 'text_domain' ),
        'singular_name'         => _x( 'Sản phẩm', 'Post Type Singular Name', 'text_domain' ),
        'menu_name'             => __( 'Sản Phẩm', 'text_domain' ),
        'name_admin_bar'        => __( 'Sản Phẩm', 'text_domain' ),
        'archives'              => __( 'Item Archives', 'text_domain' ),
        'attributes'            => __( 'Item Attributes', 'text_domain' ),
        'parent_item_colon'     => __( 'Parent Item:', 'text_domain' ),
        'all_items'             => __( 'Tất cả sản phẩm', 'text_domain' ),
        'add_new_item'          => __( 'Thêm sản phẩm mới', 'text_domain' ),
        'add_new'               => __( 'Thêm Sản Phẩm', 'text_domain' ),
        'new_item'              => __( 'Sản phẩm mới', 'text_domain' ),
        'edit_item'             => __( 'Chỉnh sửa sản phẩm', 'text_domain' ),
        'update_item'           => __( 'Cập nhập sản phẩm', 'text_domain' ),
        'view_item'             => __( 'Xem sản phẩm', 'text_domain' ),
        'view_items'            => __( 'Xem sản phẩm', 'text_domain' ),
        'search_items'          => __( 'Tìm sản phẩm', 'text_domain' ),
        'not_found'             => __( 'Not found', 'text_domain' ),
        'not_found_in_trash'    => __( 'Not found in Trash', 'text_domain' ),
        'featured_image'        => __( 'Ảnh đại diện', 'text_domain' ),
        'set_featured_image'    => __( 'Cài đặt ảnh đại diện sản phẩm', 'text_domain' ),
        'remove_featured_image' => __( 'Xóa ảnh đại diện sản phẩm', 'text_domain' ),
        'use_featured_image'    => __( 'Use as featured image', 'text_domain' ),
        'insert_into_item'      => __( 'Insert into item', 'text_domain' ),
        'uploaded_to_this_item' => __( 'Uploaded to this item', 'text_domain' ),
        'items_list'            => __( 'Items list', 'text_domain' ),
        'items_list_navigation' => __( 'Items list navigation', 'text_domain' ),
        'filter_items_list'     => __( 'Filter items list', 'text_domain' ),
    );
    $args = array(
        'label'                 => __( 'Sản phẩm', 'text_domain' ),
        'description'           => __( 'Post type đăng sản phẩm', 'text_domain' ),
        'labels'                => $labels,
         'supports' => array(
            'title',
            'editor',
            'excerpt',
            'author',
            'thumbnail',
            'comments',
            'trackbacks',
            'revisions',
            'custom-fields'
        ),
        'taxonomies'            => array( 'danh-muc-san-pham' ),
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 5,
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => true,        
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'capability_type'       => 'post',
    );
    register_post_type( 'san-pham', $args );

}
add_action( 'init', 'custom_post_type', 0 );

function tao_taxonomy() {
 
        /* Biến $label chứa các tham số thiết lập tên hiển thị của Taxonomy
         */
        $labels = array(
                'name' => 'Các loại sản phẩm',
                'singular' => 'Loại sản phẩm',
                'menu_name' => 'Loại sản phẩm'
        );
 
        /* Biến $args khai báo các tham số trong custom taxonomy cần tạo
         */
        $args = array(
                'labels'                     => $labels,
                'hierarchical'               => true,
                'public'                     => true,
                'show_ui'                    => true,
                'show_admin_column'          => true,
                'show_in_nav_menus'          => true,
                'show_tagcloud'              => true,
        );
 
        /* Hàm register_taxonomy để khởi tạo taxonomy
         */
        register_taxonomy('danh-muc-san-pham', 'san-pham', $args);
 
}
 
// Hook into the 'init' action
add_action( 'init', 'tao_taxonomy', 0 );

function formatvnd($vnd)
{
    $newvnd = number_format($vnd, 0, '', '.').' VNĐ';
    return $newvnd;
}


function sk_querys($posttype,$cat=null,$show='',$showpost=-1) {

    global $post,$wp_query;
    
    if($posttype=='post'){

    }elseif($posttype=='san-pham'){        
        $args = array(
            'showposts'    =>  $showpost,
            'post_type'         =>  $posttype,
           
         );
        if(isset($cat) && $cat != null){
            $args['cat'] = $cat;
        };
        if($show == 'news'){
            $args['orderby']  =  'date';
            $args['order']    =  'DESC';
        }elseif($show == 'hot'){
            $args['meta_query'] = array(array("key" => "sk_hotproduct","compare" => true));           
            $args['orderby']  =  'date';
            $args['order']    =  'DESC';
        };
    $query = new WP_Query( $args );
    $return = '';    
    if($query->have_posts()):
    while ( $query->have_posts() ) : $query->the_post();
        $check   = get_field('sk_checkprice');
        if($check == false){
        $price   = get_field('sk_price');
        if(is_numeric($price)){
            $price = formatvnd($price);
        }

         }else{
            $price  = get_field('sk_pricekm');
            $price  = formatvnd($price);
         }

        $return .= '<div class="product-box col-md-3 col-sm-6 col-xs-6 wow fadeInUp">';
        $return .=   '<div>';
        $return .=      '<a class="pro-img" title="'.get_the_title().'" href="'.get_the_permalink().'">'.get_the_post_thumbnail(get_the_ID(),'img-sm').'</a>';      
        $return .=      '<h4><a href="'.get_the_permalink().'" title="'.get_the_title().'">'.get_the_title().'</a></h4>';
        $return .=      '<div class="price">'.$price.'</div>';
        $return .=      '<span class="icon '.$show.'"></span>';
        $return .=      '<div class="coltrol">';
        $return .=          '<a href="'.get_permalink().'" title="'.get_the_title().'">Mua hàng</a>';
        $return .=      '</div>';
        $return .=  '</div>';
        $return .= '</div>';
    endwhile;
    endif;
    wp_reset_query();
    }

 return $return;

}
















//add redux theme option
if( !class_exists( 'ReduxFramewrk' ) ) {
require_once( dirname( __FILE__ ) . '/ReduxCore/framework.php' );
}
if( !isset( $redux_demo ) ) {
require_once( dirname( __FILE__ ) . '/inc/sample-config.php');
}
require_once('inc/wp-bootstrap-navwalker.php');