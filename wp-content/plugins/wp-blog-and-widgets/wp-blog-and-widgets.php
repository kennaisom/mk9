<?php
/*
Plugin Name: WP Blog and Widget
Plugin URL: http://www.wponlinesupport.com/
Text Domain: wp-blog-and-widgets
Description: Display Blog on your website.
Version: 1.2.2
Author: WP Online Support
Author URI: http://www.wponlinesupport.com/
Contributors: WP Online Support
*/

register_activation_hook( __FILE__, 'freeBlog_install_premium_version' );
function freeBlog_install_premium_version(){
if( is_plugin_active('wp-blog-and-widgets-pro/wp-blog-and-widgets.php') ){
     add_action('update_option_active_plugins', 'freeBlog_deactivate_premium_version');
    }
}
function freeBlog_deactivate_premium_version(){
   deactivate_plugins('wp-blog-and-widgets-pro/wp-blog-and-widgets.php',true);
}
add_action( 'admin_notices', 'freeBlog_rpfs_admin_notice');
function freeBlog_rpfs_admin_notice() {
    $dir = ABSPATH . 'wp-content/plugins/wp-blog-and-widgets-pro/wp-blog-and-widgets.php';
    if( is_plugin_active( 'wp-blog-and-widgets/wp-blog-and-widgets.php' ) && file_exists($dir)) {
        global $pagenow;
        if( $pagenow == 'plugins.php' ){
            deactivate_plugins ( 'wp-blog-and-widgets-pro/wp-blog-and-widgets.php',true);
            if ( current_user_can( 'install_plugins' ) ) {
                echo '<div id="message" class="updated notice is-dismissible"><p><strong>Thank you for activating  WP Blog and Widget</strong>.<br /> It looks like you had PRO version <strong>(<em> WP Blog and Widget Pro</em>)</strong> of this plugin activated. To avoid conflicts the extra version has been deactivated and we recommend you delete it. </p></div>';
            }
        }
    }
} 


// Initialization function
add_action('init', 'wpbaw_blog_init');
function wpbaw_blog_init() {
  // Create new News custom post type
    $wpbaw_blog_labels = array(
    'name'                 => _x('Blog', 'post type general name'),
    'singular_name'        => _x('Blog', 'post type singular name'),
    'add_new'              => _x('Add Blog', 'blog_post'),
    'add_new_item'         => __('Add New Blog'),
    'edit_item'            => __('Edit Blog'),
    'new_item'             => __('New Blog'),
    'view_item'            => __('View Blog'),
    'search_items'         => __('Search Blog'),
    'not_found'            =>  __('No Blog Items found'),
    'not_found_in_trash'   => __('No Blog Items found in Trash'), 
    '_builtin'             =>  false, 
    'parent_item_colon'    => '',
    'menu_name'            => 'Blog'
  );
  $wpbaw_blog_args = array(
    'labels'              => $wpbaw_blog_labels,
    'public'              => true,
    'publicly_queryable'  => true,
    'exclude_from_search' => false,
    'show_ui'             => true,
    'show_in_menu'        => true, 
    'query_var'           => true,
    'rewrite'             => array( 
							'slug' => 'blog_post',
							'with_front' => false
							),
    'capability_type'     => 'post',
    'has_archive'         => true,
    'hierarchical'        => false,
    'menu_position'       => 5,
	'menu_icon'   => 'dashicons-feedback',
    'supports'            => array('title','editor','thumbnail','excerpt','comments'),
    'taxonomies'          => array('post_tag')
  );
  register_post_type('blog_post',$wpbaw_blog_args);
}
/* Register Taxonomy */
add_action( 'init', 'wpbaw_blog_taxonomies');
function wpbaw_blog_taxonomies() {
    $labels = array(
        'name'              => _x( 'Category', 'taxonomy general name' ),
        'singular_name'     => _x( 'Category', 'taxonomy singular name' ),
        'search_items'      => __( 'Search Category' ),
        'all_items'         => __( 'All Category' ),
        'parent_item'       => __( 'Parent Category' ),
        'parent_item_colon' => __( 'Parent Category:' ),
        'edit_item'         => __( 'Edit Category' ),
        'update_item'       => __( 'Update Category' ),
        'add_new_item'      => __( 'Add New Category' ),
        'new_item_name'     => __( 'New Category Name' ),
        'menu_name'         => __( 'Blog Category' ),
    );

    $args = array(
        'hierarchical'      => true,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array( 'slug' => 'blog-category' ),
    );

    register_taxonomy( 'blog-category', array( 'blog_post' ), $args );
}

function wpbaw_blog_rewrite_flush() {  
		wpbaw_blog_init();  
    flush_rewrite_rules();
}
register_activation_hook( __FILE__, 'wpbaw_blog_rewrite_flush' );
add_action( 'wp_enqueue_scripts','wpbaw_blog_css_script' );
    function wpbaw_blog_css_script() {
        wp_enqueue_style( 'cssblog',  plugin_dir_url( __FILE__ ). 'css/styleblog.css' );        
    }

/* Added Widgets */	
require_once( 'blog-widgets.php' );	
require_once( 'blog_menu_function.php' );

/* Page short code [blog limit="10"] */

function get_wpbaw_blog( $atts, $content = null ){
            // setup the query
            extract(shortcode_atts(array(
		"limit" => '',	
		"category" => '',
		"grid" => '',
        "show_date" => '',
        "show_category_name" => '',
		"show_author" => '',
        "show_content" => '',
		"show_full_content" => '',
        "content_words_limit" => '',
	), $atts));
	// Define limit
	if( $limit ) { 
		$posts_per_page = $limit; 
	} else {
		$posts_per_page = '-1';
	}
	if( $category ) { 
		$cat = $category; 
	} else {
		$cat = '';
	}
	 if( $show_date ) { 
        $showDate = $show_date; 
    } else {
        $showDate = 'true';
    }
	if( $grid ) { 
		$gridcol = $grid; 
	} else {
		$gridcol = '0';
	}
	if( $show_category_name ) { 
        $showCategory = $show_category_name; 
    } else {
        $showCategory = 'true';
    }
    if( $show_author ) { 
        $showAuthor = $show_author; 
    } else {
        $showAuthor = 'true';
    }
	 if( $show_content ) { 
        $showContent = $show_content; 
    } else {
        $showContent = 'true';
    }
	
	
	 if( $show_full_content ) { 
        $showFullContent = $show_full_content; 
    } else {
        $showFullContent = 'false';
    }
	 if( $content_words_limit ) { 
        $words_limit = $content_words_limit; 
    } else {
        $words_limit = '20';
    }
	ob_start();
	
	global $paged;
		if(is_home() || is_front_page()) {
			  $paged = get_query_var('page');
		} else {
			 $paged = get_query_var('paged');
		}
	
	$post_type 		= 'blog_post';
	$orderby 		= 'post_date';
	$order 			= 'DESC';
				 
        $args = array ( 
            'post_type'      => $post_type, 
            'orderby'        => $orderby, 
            'order'          => $order,
            'posts_per_page' => $posts_per_page,   
            'paged'          => $paged,
            );
            if($cat != ""){
                $args['tax_query'] = array( array( 'taxonomy' => 'blog-category', 'field' => 'id', 'terms' => $cat) );
            }        
        $query = new WP_Query($args);
		global $post;
      $post_count = $query->post_count;
          $count = 0;
             if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post();
             $count++;
               $terms = get_the_terms( $post->ID, 'blog-category' );
                    $news_links = array();
                    if($terms){

                    foreach ( $terms as $term ) {
                        $term_link = get_term_link( $term );
                        $news_links[] = '<a href="' . esc_url( $term_link ) . '">'.$term->name.'</a>';
                    }
                }
                    $cate_name = join( ", ", $news_links );
                $css_class="team";
                if ( ( is_numeric( $grid ) && ( $grid > 0 ) && ( 0 == ($count - 1) % $grid ) ) || 1 == $count ) { $css_class .= ' first'; }
                if ( ( is_numeric( $grid ) && ( $grid > 0 ) && ( 0 == $count % $grid ) ) || $post_count == $count ) { $css_class .= ' last'; }
                if($showDate == 'true'){ $date_class = "has-date";}else{$date_class = "has-no-date";}
                ?>
			
            	<div id="post-<?php the_ID(); ?>" class="blog type-blog <?php echo (has_post_thumbnail()) ? "has-thumb" : "no-thumb";?> blog-col-<?php echo $gridcol.' '.$css_class.' '.$date_class; ?>">
					
					<?php
						// Post thumbnail.
						if ( has_post_thumbnail())  { ?>
                        <div class="blog-thumb">
                        <?php
                            if($gridcol == '1'){?>
							<div class="grid-blog-thumb">
						 <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('url'); ?></a>
						 </div>
						<?php } else if($gridcol > '2') { ?>
							<div class="grid-blog-thumb">	
						 <a href="<?php the_permalink(); ?>">	<?php the_post_thumbnail('large'); ?></a>
							</div>
					<?php } else if($gridcol == '0') { ?>
					<div class="grid-blog-thumb">							
						 <a href="<?php the_permalink(); ?>">	<?php the_post_thumbnail('large'); ?></a>
							</div>
					<?php	} else { ?>
					<div class="grid-blog-thumb">	
							 <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('large'); ?></a>
							</div>
					<?php } ?>
                    </div>
                    <?php }?>
					
					<div class="blog-content">
					<?php if($gridcol == '1') { 
                        if($showDate == 'true'){?>
						<div class="date-post">					
						<h2><span><?php echo get_the_date('j'); ?></span></h2>
						<p><?php echo get_the_date('M y'); ?></p>
						</div>
                         <?php }?>
					<?php } else { ?>
						<div class="grid-category-post">                       
                        <?php echo ($showCategory == 'true' && $cate_name != '') ? $cate_name : ""?>
						</div>
					
					<?php if($showAuthor == 'true' || $showDate == 'true'){ ?>
					 <div class="blog-author">
					 <?php if($showAuthor == 'true') {?>
					 <span><?php esc_html_e( 'By ', 'wp-blog-and-widgets' ) .the_author(); ?>
					 </span>
					 <?php }?>
					<?php echo ($showAuthor == 'true' && $showDate == 'true') ? '/' : '' ?>
					<?php echo ($showDate == "true")? get_the_date() : "" ;?></div> 
					<?php } }?>
					<div class="post-content-text">
					<?php if($gridcol == '1'){ ?>
					<div class="grid-1-date">
						<?php echo ($showDate == "true")? get_the_date() : "" ;?>
						</div>
					<?php } ?>
						<?php the_title( sprintf( '<h3 class="blog-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h3>' );	?>
					    
						<?php if($gridcol == '1'){ ?>
						<div class="blog-cat">
                          <?php if($showAuthor == 'true') { ?> <span class="grid-1-author"><?php esc_html_e( 'By', 'wp-blog-and-widgets' ); ?> <?php the_author(); ?></span>  <?php } echo ($showAuthor == 'true' && $showCategory == 'true') ? '/' : '' ?> <?php if($showCategory == 'true') { echo $cate_name; } ?>
							</div>
                       <?php }?>
                     <?php if($showContent == 'true'){?>   
					<div class="blog-content-excerpt">
					<?php  if($showFullContent == "false" ) { 
					$excerpt = get_the_content();?>
                    <p class="blog-short-content"><?php echo blog_limit_words($excerpt,$words_limit); ?>...</p>
                   
                        <a href="<?php the_permalink(); ?>" class="more-link"> <?php esc_html_e( 'Read More', 'wp-blog-and-widgets' ); ?></a>	
						<?php } else { 
							the_content();
						 } ?>
					</div><!-- .entry-content -->
                    <?php }?>
					</div>
				</div>
</div><!-- #post-## -->			  
          <?php  endwhile;
            endif; ?>
			<div class="blog_pagination">				 	
<div class="button-blog-p"><?php next_posts_link( ' Next >>', $query->max_num_pages ); ?></div>
<div class="button-blog-n"><?php previous_posts_link( '<< Previous' ); ?> </div>
</div>	
			<?php
             wp_reset_query(); 
				
		return ob_get_clean();			             
	}
add_shortcode('blog','get_wpbaw_blog');	

/* Home short code [recent_blog_post limit="10"] */

function get_wpbaw_homeblog( $atts, $content = null ){
            // setup the query
            extract(shortcode_atts(array(
		"limit" => '',	
		"category" => '',
		"grid" => '',
        "show_date" => '',
		"show_author" => '',
        "show_category_name" => '',
        "show_content" => '',
        "content_words_limit" => '',
	), $atts));
	// Define limit
	if( $limit ) { 
		$posts_per_page = $limit; 
	} else {
		$posts_per_page = '-1';
	}
	if( $category ) { 
		$cat = $category; 
	} else {
		$cat = '';
	}
	if( $grid ) { 
		$gridcol = $grid; 
	} else {
		$gridcol = '0';
	}
    if( $show_date ) { 
        $showDate = $show_date; 
    } else {
        $showDate = 'true';
    }
	
	 if( $show_author ) { 
        $showAuthor = $show_author; 
    } else {
        $showAuthor = 'true';
    }
	if( $show_category_name ) { 
        $showCategory = $show_category_name; 
    } else {
        $showCategory = 'true';
    }
    if( $show_content ) { 
        $showContent = $show_content; 
    } else {
        $showContent = 'true';
    }
	 if( $content_words_limit ) { 
        $words_limit = $content_words_limit; 
    } else {
        $words_limit = '20';
    }
	ob_start();
	
	$post_type 		= 'blog_post';
	$orderby 		= 'post_date';
	$order 			= 'DESC';
				 
		
        $args = array ( 
            'post_type'      => $post_type, 
            'orderby'        => $orderby, 
            'order'          => $order,
            'posts_per_page' => $posts_per_page,               
            ); 
            if($cat != ""){
                $args['tax_query'] = array( array( 'taxonomy' => 'blog-category', 'field' => 'id', 'terms' => $cat) );
            }      
        $query = new WP_Query($args);
		global $post;
      $post_count = $query->post_count;
          $count = 0;
             if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post();
             $count++;
               $terms = get_the_terms( $post->ID, 'blog-category' );
                    $news_links = array();
                    if($terms){

                    foreach ( $terms as $term ) {
                        $term_link = get_term_link( $term );
                        $news_links[] = '<a href="' . esc_url( $term_link ) . '">'.$term->name.'</a>';
                    }
                }
                    $cate_name = join( ", ", $news_links );
                $css_class="team";
                if ( ( is_numeric( $grid ) && ( $grid > 0 ) && ( 0 == ($count - 1) % $grid ) ) || 1 == $count ) { $css_class .= ' first'; }
                if ( ( is_numeric( $grid ) && ( $grid > 0 ) && ( 0 == $count % $grid ) ) || $post_count == $count ) { $css_class .= ' last'; }
                if($showDate == 'true'){ $date_class = "has-date";}else{$date_class = "has-no-date";}
                ?>
			
            	<div id="post-<?php the_ID(); ?>" class="blog type-blog <?php echo (has_post_thumbnail()) ? "has-thumb" : "no-thumb";?> blog-col-<?php echo $gridcol.' '.$css_class.' '.$date_class; ?>">
					
					<?php
						// Post thumbnail.
						if ( has_post_thumbnail())  {?>
                        <div class="blog-thumb">
                        <?php 
                            if($gridcol == '1'){?>
						<div class="grid-blog-thumb">	
						 <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('url'); ?></a>
						 </div>
						<?php } else if($gridcol > '2') { ?>
							<div class="grid-blog-thumb">	
						 <a href="<?php the_permalink(); ?>">	<?php the_post_thumbnail('large'); ?></a>
							</div>
					<?php } else if($gridcol == '0') { ?>
					<div class="grid-blog-thumb">							
						 <a href="<?php the_permalink(); ?>">	<?php the_post_thumbnail('large'); ?></a>
							</div>
					<?php	} else { ?>
					<div class="grid-blog-thumb">	
							 <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('large'); ?></a>
							</div>
					<?php } ?>
                    </div>
                    <?php }?>
					
					<div class="blog-content">
					<?php if($gridcol == '1') { 
                        if($showDate == 'true'){?>
						<div class="date-post">					
						<h2><span><?php echo get_the_date('j'); ?></span></h2>
						<p><?php echo get_the_date('M y'); ?></p>
						</div>
                         <?php }?>
					<?php } else { ?>
						<div class="grid-category-post">                       
                        <?php echo ($showCategory == 'true' && $cate_name != '') ? $cate_name : ""?>
						</div>
					
					<?php if($showAuthor == 'true' || $showDate == 'true'){ ?>
					 <div class="blog-author">
					 <?php if($showAuthor == 'true') {?>
					 <span><?php esc_html_e( 'By ', 'wp-blog-and-widgets' ) .the_author(); ?>
					 </span>
					 <?php }?>
					<?php echo ($showAuthor == 'true' && $showDate == 'true') ? '/' : '' ?>
					<?php echo ($showDate == "true")? get_the_date() : "" ;?></div> 
					<?php } }?>
					<div class="post-content-text">
					<?php if($gridcol == '1'){ ?>
					<div class="grid-1-date">
						<?php echo ($showDate == "true")? get_the_date() : "" ;?>
						</div>
					<?php } ?>
						<?php the_title( sprintf( '<h3 class="blog-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h3>' );	?>
					    
						<?php if($gridcol == '1'){ ?>
						<div class="blog-cat">
                            <?php if($showAuthor == 'true') { ?> <span class="grid-1-author"><?php esc_html_e( 'By', 'wp-blog-and-widgets' ); ?> <?php the_author(); ?></span>  <?php } echo ($showAuthor == 'true' && $showCategory == 'true') ? '/' : '' ?> <?php if($showCategory == 'true') { echo $cate_name; } ?>
							</div>
                       <?php }?>
					
                     <?php if($showContent == 'true'){?>   
					<div class="blog-content-excerpt">
					<?php $excerpt = get_the_excerpt();?>
                    <p class="blog-short-content"><?php echo blog_limit_words($excerpt,$words_limit); ?>...</p>
                   
                         <a href="<?php the_permalink(); ?>" class="more-link"> <?php esc_html_e( 'Read More', 'wp-blog-and-widgets' ); ?></a>	
					</div><!-- .entry-content -->
                    <?php }?>
					</div>
				</div>
</div><!-- #post-## -->			  
          <?php  endwhile;
            endif; ?>
			
			<?php
             wp_reset_query(); 
				
		return ob_get_clean();			             
	}
add_shortcode('recent_blog_post','get_wpbaw_homeblog');


function blog_limit_words($string, $word_limit)
{
  $words = explode(' ', $string, ($word_limit + 1));
  if(count($words) > $word_limit)
  array_pop($words);
  return implode(' ', $words);
}	

function spblog_display_tags( $query ) {
    if( is_tag() && $query->is_main_query() ) {       
       $post_types = array( 'post', 'blog_post' );
        $query->set( 'post_type', $post_types );
    }
}
add_filter( 'pre_get_posts', 'spblog_display_tags' );	


// Manage Category Shortcode Columns

add_filter("manage_blog-category_custom_column", 'blog_category_columns', 10, 3);
add_filter("manage_edit-blog-category_columns", 'blog_category_manage_columns'); 
function blog_category_manage_columns($theme_columns) {
    $new_columns = array(
            'cb' => '<input type="checkbox" />',
            'name' => __('Name'),
            'blog_shortcode' => __( 'Blog Category Shortcode', 'blog' ),
            'slug' => __('Slug'),
            'posts' => __('Posts')
			);
    return $new_columns;
}

function blog_category_columns($out, $column_name, $theme_id) {
    $theme = get_term($theme_id, 'blog-category');
    switch ($column_name) {      

        case 'title':
            echo get_the_title();
        break;
        case 'blog_shortcode':        

             echo '[blog category="' . $theme_id. '"]';
			  echo '[recent_blog_post category="' . $theme_id. '"]';
        break;

        default:
            break;
    }
    return $out;   

}