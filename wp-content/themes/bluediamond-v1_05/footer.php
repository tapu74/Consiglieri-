		</div> <!-- content wrapper -->
		<div class="footer-top-bar boxed-style"></div>

		<?php 
			$gdl_show_twitter = (get_option(THEME_SHORT_NAME.'_show_twitter_bar','enable') == 'enable')? true: false; 
			$gdl_homepage_twitter = (get_option(THEME_SHORT_NAME.'_show_twitter_only_homepage','disable') == 'enable')? true: false; 
			
			if( $gdl_show_twitter && ( ($gdl_homepage_twitter && is_front_page()) || !$gdl_homepage_twitter )){
				$twitter_id = get_option(THEME_SHORT_NAME.'_twitter_bar_id'); 
				$num_fetch = get_option(THEME_SHORT_NAME.'_twitter_num_fetch'); 
		?>
		<div class="footer-twitter-wrapper boxed-style">
			<div class="container twitter-container">
				<div class="gdl-twitter-wrapper">
					<div class="gdl-twitter-navigation">
						<a class="prev"></a>
						<a class="next"></a>
					</div>					
					<ul id="gdl-twitter" ></ul>	
					<script type="text/javascript">
						function gdl_twitter_callback(twitters){			
							var statusHTML = '';
							for (var i=0; i<twitters.length; i++){
								var username = twitters[i].user.screen_name;
								var status = twitters[i].text.replace(/((https?|s?ftp|ssh)\:\/\/[^"\s\<\>]*[^.,;'">\:\s\<\>\)\]\!])/g, function(url) {
									return '<a href="'+url+'">'+url+'</a>';
								}).replace(/\B@([_a-z0-9]+)/ig, function(reply) {
									return  reply.charAt(0)+'<a href="http://twitter.com/'+reply.substring(1)+'">'+reply.substring(1)+'</a>';
								});
								statusHTML = statusHTML + '<li><span>'+status+' by <a href="http://twitter.com/'+username+'">'+username+'</a></span></li>';
							}
							
							jQuery(window).load(function(){
								var twitter_wrapper = jQuery('ul#gdl-twitter');
								twitter_wrapper.each(function(){
									jQuery(this).html(statusHTML);
									
									var fetch_num = jQuery(this).children().length;
									var twitter_nav = jQuery(this).siblings('div.gdl-twitter-navigation');

									if( fetch_num > 0 ){ 
										gdl_cycle_resize(twitter_wrapper);
										twitter_wrapper.cycle({ fx: 'fade', slideResize: 1, fit: true, width: '100%', timeout: 4000, speed: 1000,
											next: twitter_nav.children('.next'),  prev: twitter_nav.children('.prev') });
									}
								});	

								jQuery(window).resize(function(){ 
									if( twitter_wrapper ){ gdl_cycle_resize(twitter_wrapper); }
								});								
							});				
						}
					</script>
					<script type="text/javascript" src="http://api.twitter.com/1/statuses/user_timeline/<?php echo $twitter_id;?>.json?callback=gdl_twitter_callback&amp;count=<?php echo $num_fetch;?>"></script>				
				</div>
			</div>
		</div>
		<?php 
				wp_deregister_script('jquery-cycle');
				wp_register_script('jquery-cycle', GOODLAYERS_PATH.'/javascript/jquery.cycle.js', false, '1.0', true);
				wp_enqueue_script('jquery-cycle');	
			} // $gdl-show-twitter 
		?>
		
		<div class="footer-wrapper boxed-style">

		<!-- Get Footer Widget -->
		<?php $gdl_show_footer = get_option(THEME_SHORT_NAME.'_show_footer','enable'); ?>
		<?php if( $gdl_show_footer == 'enable' ){ ?>
			<div class="container footer-container">
				<div class="footer-widget-wrapper">
					<div class="row">
						<?php
							$gdl_footer_class = array(
								'footer-style1'=>array('1'=>'three columns', '2'=>'three columns', '3'=>'three columns', '4'=>'three columns'),
								'footer-style2'=>array('1'=>'six columns', '2'=>'three columns', '3'=>'three columns', '4'=>''),
								'footer-style3'=>array('1'=>'three columns', '2'=>'three columns', '3'=>'six columns', '4'=>''),
								'footer-style4'=>array('1'=>'four columns', '2'=>'four columns', '3'=>'four columns', '4'=>''),
								'footer-style5'=>array('1'=>'eight columns', '2'=>'four columns', '3'=>'', '4'=>''),
								'footer-style6'=>array('1'=>'four columns', '2'=>'eight columns', '3'=>'', '4'=>''),
								);
							$gdl_footer_style = get_option(THEME_SHORT_NAME.'_footer_style', 'footer-style1');
						 
							for( $i=1 ; $i<=4; $i++ ){
								$footer_class = $gdl_footer_class[$gdl_footer_style][$i];
									if( !empty($footer_class) ){
									echo '<div class="' . $footer_class . ' gdl-footer-' . $i . ' mb0">';
									dynamic_sidebar('Footer ' . $i);
									echo '</div>';
								}
							}
						?>
						<div class="clear"></div>
					</div> <!-- close row -->
				</div>
			</div> 
		<?php } ?>

		<!-- Get Copyright Text -->
		<?php $gdl_show_copyright = get_option(THEME_SHORT_NAME.'_show_copyright','enable'); ?>
		<?php if( $gdl_show_copyright == 'enable' ){ ?>
			<div class="copyright-outer-wrapper boxed-style">
				<div class="container copyright-container">
					<div class="copyright-wrapper">
						<div class="copyright-left">
							<?php echo do_shortcode( __(get_option(THEME_SHORT_NAME.'_copyright_left_area'), 'gdl_front_end') ); ?>
						</div> 
						<div class="copyright-right">
							<?php echo do_shortcode( __(get_option(THEME_SHORT_NAME.'_copyright_right_area'), 'gdl_front_end') ); ?>
						</div> 
						<div class="clear"></div>
					</div>
				</div>
			</div>
		<?php } ?>
		</div><!-- footer wrapper -->
	</div> <!-- body wrapper -->
</div> <!-- body outer wrapper -->
	
<?php wp_footer(); ?>

</body>
</html>