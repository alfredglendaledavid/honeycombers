<?php

if( !defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/*
 * Cleanup <head>
 *
 * @since 2.0.0
 */
remove_action( 'wp_head', 'rsd_link' );									// RSD link
remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 );				// Parent rel link
remove_action( 'wp_head', 'start_post_rel_link', 10, 0 );				// Start post rel link
remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );	// Adjacent post rel link
remove_action( 'wp_head', 'wp_generator' );								// WP Version
remove_action( 'wp_head', 'wlwmanifest_link');							// WLW Manifest
// remove_action( 'wp_head', 'feed_links', 2 ); 
remove_action( 'wp_head', 'feed_links_extra', 3 ); 						// Remove comment feed links

// Remove WP-API <head> material
// See: https://wordpress.stackexchange.com/questions/211467/remove-json-api-links-in-header-html
remove_action( 'wp_head', 'rest_output_link_wp_head' );
remove_action( 'template_redirect', 'rest_output_link_header', 11, 0 );

remove_action( 'genesis_doctype', 'genesis_do_doctype' );
add_action( 'genesis_doctype', 'hc_do_doctype' );
/**
 * Overrides the default Genesis doctype with IE and JS identifier classes.
 *
 * See: http://html5boilerplate.com/
 *
 * @since 2.2.4
 */
function hc_do_doctype() {

	if( genesis_html5() ) {
?>
<!DOCTYPE html>
<!--[if IE 8]> <html class="no-js lt-ie9" <?php language_attributes( 'html' ); ?>> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" <?php language_attributes( 'html' ); ?>> <!--<![endif]-->
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<?php
	} else {
		genesis_xhtml_doctype();
	}

}

add_action( 'wp_head', 'hc_fetch_dns', 1 );
/**
 * Prefetch the DNS for external resource domains. Better browser support than preconnect.
 *
 * See: https://www.igvita.com/2015/08/17/eliminating-roundtrips-with-preconnect/
 *
 * @since 2.3.19
 */
function hc_fetch_dns() {

	$hrefs = array(
		'//ajax.googleapis.com',
		'//fonts.googleapis.com',
	);

	foreach( $hrefs as $href )
		echo '<link rel="dns-prefetch" href="' . $href . '">' . "\n";

}

remove_action( 'genesis_meta', 'genesis_load_stylesheet' );
remove_action( 'wp_enqueue_scripts', 'genesis_register_scripts' );
add_action( 'wp_enqueue_scripts', 'hc_load_assets' );
/**
 * Overrides the default Genesis stylesheet with child theme specific CSS and JS.
 *
 * Only load these styles on the front-end.
 *
 * @since 2.0.0
 */
function hc_load_assets() {

	$use_production_assets = genesis_get_option('hc_production_on');
	$use_production_assets = !empty($use_production_assets);

	$assets_version = genesis_get_option('hc_assets_version');
	$assets_version = !empty($assets_version) ? absint($assets_version) : null;

	$stylesheet_dir = get_stylesheet_directory_uri();

	// Main theme stylesheet
	$src = $use_production_assets ? '/build/css/style.min.css' : '/build/css/style.css';
	wp_enqueue_style( 'hc', $stylesheet_dir . $src, array(), $assets_version );

	// Google Fonts
	// Consider async loading: https://github.com/typekit/webfontloader
	wp_enqueue_style(
		'google-fonts',
		'//fonts.googleapis.com/css?family=Montserrat%7COpen+Sans:400,400italic,600,700%7CNoto+Serif:400italic',
		array(),
		null
	);

 	// Dequeue comment-reply if no active comments on page
	wp_dequeue_script( 'comment-reply' );

	// Override WP default self-hosted jQuery with version from Google's CDN
	wp_deregister_script( 'jquery' );
	$src = $use_production_assets ? '//ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js' : '//ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.js';
	wp_register_script( 'jquery', $src, array(), null, true );
	add_filter( 'script_loader_src', 'hc_jquery_local_fallback', 10, 2 );

	// Main script file (in footer)
	$src = $use_production_assets ? '/build/js/scripts.min.js' : '/build/js/scripts.js';
	wp_enqueue_script( 'hc', $stylesheet_dir . $src, array('jquery'), $assets_version, true );
	wp_localize_script(
		'hc',
		'grunticon_paths',
		array(
			'svg'      => $stylesheet_dir . '/build/svgs/icons.data.svg.css',
			'png'      => $stylesheet_dir . '/build/svgs/icons.data.png.css',
			'fallback' => $stylesheet_dir . '/build/svgs/icons.fallback.css',
		)
	);

	wp_localize_script(
		'hc',
		'hc_settings',
		array(
			'facebook_app_id' => get_option( 'options__hc_facebook_app_id' ),
			'recaptcha_key'   => get_option( 'options__hc_recaptcha_api_key' ),
		)
	);

	$spinner = '<div class="spinner"><div class="bounce1"></div><div class="bounce2"></div><div class="bounce3"></div></div>';
	wp_localize_script(
		'hc',
		'hc_strings',
		array(
			'spinner'     => $spinner,
			'more_button' => '<button type="button" class="il-load-more"><span><i class="ico-arrow-down"></i><label>more cool stuff</label></span></button>',
			'loading'     => '<div class="il-loading">' . $spinner . '</div>',
			'prev_arrow'  => '<button type="button" class="slick-prev" title="Previous"><i class="ico-arrow-left"></i></button>',
			'next_arrow'  => '<button type="button" class="slick-next" title="Next"><i class="ico-arrow-right"></i></button>',
		)
	);
	wp_localize_script( 'hc', 'ajax_object', array('ajaxurl' => admin_url( 'admin-ajax.php' )) );

	$page_template_slug = get_page_template_slug();
	if( 'page_templates/page_calendar.php' === $page_template_slug ) {
		$src = $use_production_assets ? '/build/js/calendar.min.js' : '/build/js/calendar.js';
		wp_enqueue_script( 'hc-calendar', $stylesheet_dir . $src, array('jquery', 'hc'), $assets_version, true );
	}

	if( !is_singular('post') ) {
		wp_dequeue_style( 'sliderpro-plugin-style' );
		wp_dequeue_style( 'sliderpro-plugin-custom-style' );
	}

}

add_filter( 'script_loader_tag', 'hc_ie_script_conditionals', 10, 3 );
/**
 * Conditionally load jQuery v1 on old IE.
 *
 * @since 2.3.1
 */
function hc_ie_script_conditionals( $tag, $handle, $src ) {

	if( 'jquery' === $handle ) {
		$output = '<!--[if !IE]> -->' . "\n" . $tag . '<!-- <![endif]-->' . "\n";
		$output .= '<!--[if gt IE 8]>' . "\n" . $tag . '<![endif]-->' . "\n";

		$use_production_assets = genesis_get_option('hc_production_on');
		$use_production_assets = !empty($use_production_assets);
		$src                   = $use_production_assets ? '//ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js' : '//ajax.googleapis.com/ajax/libs/jquery/1/jquery.js';
		$fallback_script       = '<script type="text/javascript" src="' . $src . '"></script>';
		$output .= '<!--[if lte IE 8]>' . "\n" . $fallback_script . '<![endif]-->' . "\n";
	} elseif( 'hc-google-maps' === $handle ) {
		$output = str_replace( '<script ', '<script async defer ', $tag );
	}else {
		$output = $tag;
	}

	return $output;

}

/*
 * jQuery local fallback, if Google CDN is unreachable
 *
 * See: https://github.com/roots/roots/blob/aa59cede7fbe2b853af9cf04e52865902d2ff1a9/lib/scripts.php#L37-L52
 *
 * @since 2.0.20
 */
add_action( 'wp_head', 'hc_jquery_local_fallback' );
function hc_jquery_local_fallback( $src, $handle = null ) {

	static $add_jquery_fallback = false;

	if( $add_jquery_fallback ) {
		echo '<script>window.jQuery || document.write(\'<script src="' . includes_url() . 'js/jquery/jquery.js"><\/script>\')</script>' . "\n";
		$add_jquery_fallback = false;
	}

	if( $handle === 'jquery' ) {
		$add_jquery_fallback = true;
	}

	return $src;

}

// add_filter( 'genesis_pre_load_favicon', 'hc_pre_load_favicon' );
/**
 * Simple favicon override to specify your favicon's location.
 *
 * @since 2.0.0
 */
function hc_pre_load_favicon() {

	return get_stylesheet_directory_uri() . '/images/favicon.ico';

}

remove_action( 'wp_head', 'genesis_load_favicon' );
add_action( 'wp_head', 'hc_load_favicons' );
/**
 * Show the best favicon, within reason.
 *
 * See: http://www.jonathantneal.com/blog/understand-the-favicon/
 *
 * @since 2.0.4
 */
function hc_load_favicons() {

	$stylesheet_dir     = get_stylesheet_directory_uri();
	$favicon_path       = $stylesheet_dir . '/images/favicons';
	$favicon_build_path = $stylesheet_dir . '/build/images/favicons';

	// Set to false to disable, otherwise set to a hex color
	$color = '#fe862c';

	// Use a 192px X 192px PNG for the homescreen for Chrome on Android
	echo '<link rel="icon" type="image/png" href="' . $favicon_build_path . '/favicon-192.png" sizes="192x192">';

	// Use a 180px X 180px PNG for the latest iOS devices, also setup app styles
	echo '<link rel="apple-touch-icon" sizes="180x180" href="' . $favicon_build_path . '/favicon-180.png">';

	// Give IE <= 9 the old favicon.ico (16px X 16px)
	echo '<!--[if IE]><link rel="shortcut icon" href="' . $favicon_path . '/favicon.ico"><![endif]-->';

	// Use a 144px X 144px PNG for Windows tablets
	echo '<meta name="msapplication-TileImage" content="' . $favicon_build_path . '/favicon-144.png">';

	if( false !== $color ) {
		// Windows icon background color
		echo '<meta name="msapplication-TileColor" content="#ffffff">';

		// Chrome for Android taskbar color
		echo '<meta name="theme-color" content="#ffffff">';

		// Safari 9 pinned tab color
		echo '<link rel="mask-icon" href="' . $favicon_build_path . '/favicon.svg" color="' . $color . '">';
	}

}


/*
 * Remove the header
 *
 * @since 2.0.9
 */
// remove_action( 'genesis_header', 'genesis_do_header' );

/*
 * Remove the site title and/or description
 *
 * @since 2.0.9
 */
// remove_action( 'genesis_site_title', 'genesis_seo_site_title' );
// remove_action( 'genesis_site_description', 'genesis_seo_site_description' );
add_action( 'genesis_before_header', 'hc_custom_cursor' );
function hc_custom_cursor() { 
	if (function_exists('get_field')) {	
		$cursor = get_field('_hc_cursor','option');
			if (!empty($cursor)) {
?>
	<style>
		html {
			cursor: url('<?php echo $cursor; ?>'), default;
		}
	</style>
<?php
			}
 	} 
}

add_action( 'genesis_before_header', 'hc_custom_header' );
function hc_custom_header() { 
	if (function_exists('get_field')) {	
		$bg_color = get_field('_hc_headerbackground_color','option');
		$bg_img = get_field('_hc_header_background_image','option');
			if (!empty($bg_color) || !empty($bg_img)) {
?>
	<style>
		.site-header {
			background-color: <?php echo $bg_color; ?>;
			background-image: url(<?php echo $bg_img; ?>);
			background-position: top center;
		}
		@media (max-width: 776px) {
			.title-area {
				padding-left: 10px;
				padding-right: 0;
				padding-top: 0;
				padding-bottom: 0;
			}
			.site-logo .custom_mobile_logo { 
				display: block;
				width: 175px;
			}
			.site-header {
				background-color: none;
				background-image: none;
			}
		}
	</style>
<?php
			}
 	} 
}
?>

<?php

add_action( 'wp_head', 'hc_ga_content_grouping' );
function hc_ga_content_grouping() { 
	?>
	<?php
	$primary_cat = new WPSEO_Primary_Term('category', get_the_ID());
	$primary_cat_id = $primary_cat->get_primary_term();
	$primary_cat_name = get_cat_name( $primary_cat_id );
	
	function gtm_posttype() {
		global $wp_query;
		global $post;
		$term =	$wp_query->queried_object;
		$cat = '(not set)';
	 
		if ( is_page('singapore-event-calendar') ) {
			$cat = 'Calendar';
		} elseif ( is_home() || is_front_page() ) {
			$cat = 'Home Page';
		} elseif ( $wp_query->is_singular('post') ) {
			$primary_cat = new WPSEO_Primary_Term('category', $post->ID);
			$primary_cat_id = $primary_cat->get_primary_term();
			if (!empty($primary_cat_id)) {
				$cat = get_cat_name($primary_cat_id);
			} else {
				$cat = get_the_category($post->ID);
				$cat_parent = $cat[0]->category_parent;
				if($cat_parent) { $cat = get_category($cat_parent);
				$cat = $cat->name; }
				else { $cat = $cat[0]->name; }
			}			
		} elseif ( $wp_query->is_singular('event') ) {
			$cat = 'Calendar';
		} elseif ( $wp_query->is_singular('listing') ) {
			$cat = 'Directory Listings';
		} elseif ( is_page('advertising') ) {
			$cat = 'Advertising Page';
		} elseif ( is_page('about-us') ) {
			$cat = 'About Us Page';
		} elseif ( is_page('editorial-policy') ) {
			$cat = 'Editorial Policy Page';
		} elseif ( is_page('contact') ) {
			$cat = 'Contact Page';
		} elseif ( is_page('places-to-visit-in-singapore') ) {
			$cat = 'Directory Page';
		} elseif ( $wp_query->is_category ) {
			if ($term->parent > 0) {
				$cat = get_cat_name($term->parent);
				$subcat = $term->name;
			} else {
				$cat = $term->name;
			}
		} elseif ( $wp_query->is_tag ) {
			$cat = single_tag_title("", false);
		} elseif ( $wp_query->is_tax ) {
			$cat = $term->name;
		} elseif ( $wp_query->is_archive ) {
			$cat = 'Archive';
		} elseif ( $wp_query->is_search ) {
			$cat = 'Search';
		} elseif ( $wp_query->is_404 ) {
			$cat = '404 Page';
		}
		return '"Category": "'.$cat.'", "SubCategory": "'.$subcat.'"';
	}
	
	global $post;
	$article_type = get_field('_hc_post_is_sponsored',$post->ID);
	if (is_single()) {
		if( get_field('_hc_post_is_sponsored',$post->ID) )
			{
				$article = 'Advertorial';
			}
			else
			{
				$article = 'Editorial';
			}
	}
	
	?>
    
    <script>
	 (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
	
	  ga('create', 'UA-38721717-1', 'auto');
	  <?php if (is_single()) { ?>
	  	ga('set', 'contentGroup1', '<?php echo $article; ?>'); 
	  
	  <?php } else { ?>
	  	ga('set', 'contentGroup1', 'Others'); 
	  <?php } ?>
	  ga('require', 'linkid', 'linkid.js');
	  ga('require', 'displayfeatures');
	  
	  var p = document.location.pathname;
	  setTimeout("ga('send','event','reading','time on page more than 2 minutes',p)",120000);

	</script>
    
    <script>
		window.dataLayer = window.dataLayer || [];
    	dataLayer.push({<?php echo gtm_posttype(); ?>})
		<?php if (is_single()) { ?>
			dataLayer.push({<?php echo '"ArticleType": "'.$article.'"'; ?>})
		<?php } else { ?>
	  		dataLayer.push({<?php echo '"ArticleType": "Others"'; ?>})
	  <?php } ?>
	</script>
	
<?php } 
/*
add_action( 'wp_head', 'hc_boomtrain' );
function hc_boomtrain() { 
	?>
	<?php 
		$blog_id = get_current_blog_id();
	?>
	<?php if ($blog_id == 2) {
            echo '<meta property="bt:sitename" content="Honeycombers Singapore" />';
        } elseif ($blog_id == 4) {
            echo '<meta property="bt:sitename" content="Honeycombers Bali" />';
        } elseif ($blog_id == 3) {
            echo '<meta property="bt:sitename" content="Honeycombers Jakarta" />';
        }
    ?>
	<!-- Boomtrain Code -->
	<script src="https://d3r7h55ola878c.cloudfront.net/btn/1.0.3/btn.js"></script>
    <script>
            //setup BTN Library
            _btn.setDebugMode(true); BOOMTRAIN_API_KEY_1 = 'a86800cea7d25b2c2c5befab94925e33'; BOOMTRAIN_API_KEY_2 = 'fd0669de88391ecb4af6602b64f803a7';
            _btn.setAPIKeys(BOOMTRAIN_API_KEY_1,BOOMTRAIN_API_KEY_2);
            _btn.initialize();
            _btn.identify('<?php $current_user = get_currentuserinfo(); echo $current_user->user_email; ?>');
    </script>
    <!-- Boomtrain Code -->

<?php
	} 
*/	
add_action( 'genesis_before_header', 'hc_floodlight' );

function hc_floodlight() { 
if (is_single(111512)) {
	?>
	<!--
    Start of DoubleClick Floodlight Tag: Please do not remove
    Activity name of this tag: Honeycombers Landing Page_UNQ
    URL of the webpage where the tag is expected to be placed: http://honeycombers.com
    This tag must be placed between the <body> and </body> tags, as close as possible to the opening tag.
    Creation Date: 10/07/2016
    -->
    <script type="text/javascript">
    var axel = Math.random() + "";
    var a = axel * 10000000000000;
    document.write('<iframe src="https://1501466.fls.doubleclick.net/activityi;src=1501466;type=2016a0;cat=honey0;dc_lat=;dc_rdid=;tag_for_child_directed_treatment=;ord=1;num=' + a + '?" width="1" height="1" frameborder="0" style="display:none"></iframe>');
    </script>
    <noscript>
    <iframe src="https://1501466.fls.doubleclick.net/activityi;src=1501466;type=2016a0;cat=honey0;dc_lat=;dc_rdid=;tag_for_child_directed_treatment=;ord=1;num=1?" width="1" height="1" frameborder="0" style="display:none"></iframe>
    </noscript>
    <!-- End of DoubleClick Floodlight Tag: Please do not remove -->
				<?php
	}
} 

add_action( 'genesis_before_header', 'hc_site_takeover_top' );

function hc_site_takeover_top() {

if (function_exists('have_rows')) {	
		if( have_rows('_hc_site_takeover_top','option') ):
			while ( have_rows('_hc_site_takeover_top','option') ) : the_row();
			$bg_color = get_sub_field('background_color');
			$head = get_sub_field('head_code');
			$body = get_sub_field('body_code');
			$hide = get_sub_field('hide');
				?>
				<section class="top-takeover" >
					<div class="takeover" style="background-color: <?php echo $bg_color; ?>; display: <?php echo $hide; ?>;">
						<?php echo $head; ?>
						<?php echo $body; ?>
					</div>
				</section>
				<?php
			endwhile;
		else :
		endif;
	}
}

add_action( 'genesis_after', 'hc_site_takeover_bottom' );

function hc_site_takeover_bottom() {
	// Takeover Ad
	if ( !is_front_page() ) {
		if( have_rows('_hc_site_takeover_bottom','option') ):
			while ( have_rows('_hc_site_takeover_bottom','option') ) : the_row();
			$bg_color = get_sub_field('background_color');
			$head = get_sub_field('head_code');
			$body = get_sub_field('body_code');
			$hide = get_sub_field('hide');
				?>
				<section class="bottom-takeover">
					<div class="takeover" style="background-color: <?php echo $bg_color; ?>; display: <?php echo $hide; ?>;">
						<?php echo $head; ?>
						<?php echo $body; ?>
					</div>
				</section>
				<?php
			endwhile;
		else :
		endif;
	}
}

add_action( 'genesis_before_header', 'hc_site_top' );
function hc_site_top() {

	?>
<section class="site-top">
		<div class="wrap">
			<div class="left">
				<?php
				wp_nav_menu(
					array(
						'menu_class'     => 'sites-nav',
						'theme_location' => 'top',
						'depth'          => 1,
					)
				);
				?>
			</div>

			<div class="right">
				<?php hc_do_social(); ?>

				<div class="nav-or-popup-link">
					<?php
					if( !is_user_logged_in() ) {
						?>
						<button class="open-popup-link" data-mfp-src="#login-popup">Sign In <i class="ico-exit"></i></button>
						<?php
					} else {
						HC()->profiles->display_top_menu();
					}
					?>
				</div>
			</div>
		</div>
	</section>
	<?php

}

add_action( 'genesis_site_title', 'hc_site_logo' );
function hc_site_logo() {
	if (function_exists('get_field')) {	
		$custom_logo = get_field('_hc_header_custom_logo','option');
		$custom_logo_mobile = get_field('_hc_header_custom_logo_mobile','option');
	}
	if (!empty($custom_logo) && !empty($custom_logo_mobile)) {
		echo '<a href="' . trailingslashit( home_url() ) . '" title="' . get_bloginfo( 'name' ) . '" class="site-logo"><img src="' . $custom_logo . '" alt="' . get_bloginfo( 'name' ) . '" class="hide-phone"><img src="' . $custom_logo_mobile . '" alt="' . get_bloginfo( 'name' ) . '" class="custom_mobile_logo show-phone"></a>';
	} else {
	echo '<a href="' . trailingslashit( home_url() ) . '" title="' . get_bloginfo( 'name' ) . '" class="site-logo"><img src="' . get_stylesheet_directory_uri() . '/build/images/login-logo.svg" alt="' . get_bloginfo( 'name' ) . '" width="319" height="57"><i class="ico-favicon"></i></a>';
	}

}

add_action( 'genesis_header', 'hc_mobile_menu_toggle', 8 );
function hc_mobile_menu_toggle() {

	?>
	<div class="mobile-header-right">
		<?php
		if( !is_user_logged_in() ) {
			?>
			<button class="btn btn-bordered open-popup-link" data-mfp-src="#login-popup">Login</button>
			<?php
		} else {
			?>
			<a href="<?php echo HC()->profiles->get_url(); ?>" class="btn btn-bordered">Hello, <?php echo HC()->profiles->get_first_name( get_current_user_id() ); ?></a>
			<?php
		}
		?>
		<button type="button" class="btn toggle-nav" title="Toggle Menu">
			<i class="ico-menu"></i>
			<i class="ico-close"></i>
		</button>
	</div>
	<?php

}

add_action( 'genesis_header_right', 'hc_header_right' );
function hc_header_right() {

	echo get_search_form( false );

}

add_action( 'wp_footer', 'hc_sticky_header' );
function hc_sticky_header() {

	$use_sticky = 'page_templates/page_directory.php' !== get_page_template_slug();

	?>
	<section class="sticky-header <?php echo $use_sticky ? 'use-sticky' : ''; ?>">
		<div class="wrap">
			<div class="left">
				<a href="<?php echo get_bloginfo('url'); ?>" title="<?php echo get_bloginfo('name'); ?>">
					<i class="ico-favicon"></i>
				</a>
			</div>
			<div class="right">
				<div class="top">
					<?php
					echo get_search_form( false );
					?>

					<nav class="sites-nav">
						<button type="button" class="btn btn-icon"><span><?php echo get_bloginfo('name'); ?></span> <i class="ico-arrow-down"></i></button>
						<?php
						wp_nav_menu(
							array(
								'theme_location' => 'top',
								'depth'          => 1,
							)
						);
						?>
					</nav>

					<?php
					hc_do_social();
					?>

					<div class="user-menu">
						<?php
						if( !is_user_logged_in() ) {
							?>
							<button class="btn btn-icon open-popup-link" data-mfp-src="#login-popup"><span>Sign In</span> <i class="ico-exit"></i></button>
							<?php
						} else {
							?>
							<a href="<?php echo HC()->profiles->get_url(); ?>" class="btn btn-icon"><span>Hello, <?php echo HC()->profiles->get_first_name( get_current_user_id() ); ?></span></a>
							<?php
						}
						?>
					</div>

					<?php
					if( $use_sticky ) {
						?>
						<div class="scroll-to-top">
							<button type="button" class="btn btn-icon"><i class="ico-arrow-up"></i></button>
						</div>
						<?php
					}
					?>
				</div>
				<div class="bottom">
					<?php
					HC()->menu->display();
					?>
				</div>
			</div>
		</div>
	</section>
	<?php

}

add_action( 'genesis_header', 'hc_header_nav_wrap_open', 4 );
function hc_header_nav_wrap_open() {

	?>
	<div class="header-navigation-container">
	<?php

}

add_action( 'genesis_after_header', 'hc_header_nav_wrap_close', 14 );
function hc_header_nav_wrap_close() {

	?>
	</div>
	<?php

}
