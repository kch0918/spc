
		<?php
		
		if ( ! defined( 'ABSPATH' ) ) {  exit;  }    // Exit if accessed directly
			
 		require_once($_SERVER['DOCUMENT_ROOT']."/aDmin/include/init.php");
		do_action( 'ava_before_footer' );	
			
		global $avia_config;
		$blank = isset( $avia_config['template'] ) ? $avia_config['template'] : '';

		//reset wordpress query in case we modified it
		wp_reset_query();


		//get footer display settings
		$the_id = avia_get_the_id(); //use avia get the id instead of default get id. prevents notice on 404 pages
		$footer = get_post_meta( $the_id, 'footer', true );
		$footer_options = avia_get_option( 'display_widgets_socket', 'all' );
		
		//get link to previous and next post/portfolio entry
		$avia_post_nav = avia_post_nav();

		/**
		 * Reset individual page override to defaults if widget or page settings are different (user might have changed theme options)
		 * (if user wants a page as footer he must select this in main options - on individual page it's only possible to hide the page)
		 */
		if( false !== strpos( $footer_options, 'page' ) )
		{
			/**
			 * User selected a page as footer in main options
			 */
			if( ! in_array( $footer, array( 'page_in_footer_socket', 'page_in_footer', 'nofooterarea' ) ) ) 
			{
				$footer = '';
			}
		}
		else
		{
			/**
			 * User selected a widget based footer in main options
			 */
			if( in_array( $footer, array( 'page_in_footer_socket', 'page_in_footer' ) ) ) 
			{
				$footer = '';
			}
		}
		
		$footer_widget_setting 	= ! empty( $footer ) ? $footer : $footer_options;

		/*
		 * Check if we should display a page content as footer
		 */
		if( ! $blank && in_array( $footer_widget_setting, array( 'page_in_footer_socket', 'page_in_footer' ) ) )
		{
			/**
			 * Allows 3rd parties to change page id's, e.g. translation plugins
			 */
			$post = AviaCustomPages()->get_custom_page_object( 'footer_page', '' );
			
			if( ( $post instanceof WP_Post ) && ( $post->ID != $the_id ) )
			{
				/**
				 * Make sure that footerpage is set to fullwidth
				 */
				$old_avia_config = $avia_config;
				
				$avia_config['layout']['current'] = array(
											'content'	=> 'av-content-full alpha', 
											'sidebar'	=> 'hidden', 
											'meta'		=> '', 
											'entry'		=> '',
											'main'		=> 'fullsize'
										);    
				
				$builder_stat = ( 'active' == Avia_Builder()->get_alb_builder_status( $post->ID ) );
				$avia_config['conditionals']['is_builder'] = $builder_stat;
				$avia_config['conditionals']['is_builder_template'] = $builder_stat;
				
				/**
				 * @used_by			config-bbpress\config.php
				 * @since 4.5.6.1
				 * @param WP_Post $post
				 * @param int $the_id
				 */
				do_action( 'ava_before_page_in_footer_compile', $post, $the_id );
				
				$content = Avia_Builder()->compile_post_content( $post );
				
				$avia_config = $old_avia_config;
				
				/**
				 * @since 4.7.4.1
				 * @param string 
				 * @param WP_Post $post
				 * @param int $the_id
				 */
				$extra_class = apply_filters( 'avf_page_as_footer_extra_classes', 'container_wrap footer-page-content footer_color', $post, $the_id );
				
				/**
				 * Wrap footer page in case we need extra CSS changes 
				 * 
				 * @since 4.7.4.1
				 */
				echo '<div class="' . $extra_class . '" id="footer-page">';
				echo	$content;
				echo '</div>';
			}
		}
		
		/**
		 * Check if we should display a footer
		 */
		if( ! $blank && $footer_widget_setting != 'nofooterarea' )
		{
			if( in_array( $footer_widget_setting, array( 'all', 'nosocket' ) ) )
			{
				//get columns
				$columns = avia_get_option('footer_columns');
		?>
				<div class='container_wrap footer_color' id='footer'>
					<div class='container'>

						<?php
						do_action('avia_before_footer_columns');

						//create the footer columns by iterating
				        switch( $columns )
				        {
				        	case 1: 
								$class = ''; 
								break;
				        	case 2: 
								$class = 'av_one_half'; 
								break;
				        	case 3: 
								$class = 'av_one_third'; 
								break;
				        	case 4: 
								$class = 'av_one_fourth'; 
								break;
				        	case 5: 
								$class = 'av_one_fifth'; 
								break;
				        	case 6: 
								$class = 'av_one_sixth'; 
								break;
							default: 
								$class = ''; 
								break;
				        }
				        
				        $firstCol = "first el_before_{$class}";

						//display the footer widget that was defined at appearenace->widgets in the wordpress backend
						//if no widget is defined display a dummy widget, located at the bottom of includes/register-widget-area.php
						for( $i = 1; $i <= $columns; $i++ )
						{
							$class2 = ''; // initialized to avoid php notices
							if( $i != 1 ) 
							{
								$class2 = " el_after_{$class}  el_before_{$class}";
							}
							
							echo "<div class='flex_column {$class} {$class2} {$firstCol}'>";
							
							if( function_exists( 'dynamic_sidebar' ) && dynamic_sidebar( 'Footer - column' . $i ) ) : else : avia_dummy_widget( $i ); endif;
							
							echo '</div>';
							
							$firstCol = '';
						}

						do_action( 'avia_after_footer_columns' );

	?>

					</div>

				<!-- ####### END FOOTER CONTAINER ####### -->
				</div>

	<?php   } //endif   array( 'all', 'nosocket' ) ?>


	<?php

			//copyright
			$copyright = do_shortcode( avia_get_option( 'copyright', '&copy; ' . __( 'Copyright', 'avia_framework' ) . "  - <a href='" . home_url( '/' ) . "'>" . get_bloginfo('name') . '</a>' ) );

			// you can filter and remove the backlink with an add_filter function
			// from your themes (or child themes) functions.php file if you dont want to edit this file
			// you can also remove the kriesi.at backlink by adding [nolink] to your custom copyright field in the admin area
			// you can also just keep that link. I really do appreciate it ;)
			$kriesi_at_backlink = kriesi_backlink( get_option( THEMENAMECLEAN . "_initial_version" ), 'Enfold' );


			if( $copyright && strpos( $copyright, '[nolink]' ) !== false )
			{
				$kriesi_at_backlink = '';
				$copyright = str_replace( '[nolink]', '', $copyright );
			}
			
			/**
			 * @since 4.5.7.2
			 * @param string $copyright
			 * @param string $copyright_option
			 * @return string
			 */
			$copyright_option = avia_get_option( 'copyright' );
			$copyright = apply_filters( 'avf_copyright_info', $copyright, $copyright_option );

			if( in_array( $footer_widget_setting, array( 'all', 'nofooterwidgets', 'page_in_footer_socket' ) ) )
			{

			?>

				<footer class='container_wrap socket_color' id='socket' <?php avia_markup_helper( array( 'context' => 'footer' ) ); ?>>
                    <div class='container'>

                        <span class='copyright'><?php echo $copyright . $kriesi_at_backlink; ?></span>

                        <?php
                        	if( avia_get_option( 'footer_social', 'disabled' ) != 'disabled' )
                            {
                            	$social_args = array( 'outside'=>'ul', 'inside'=>'li', 'append' => '' );
								echo avia_social_media_icons( $social_args, false );
                            }

							$avia_theme_location = 'avia3';
							$avia_menu_class = $avia_theme_location . '-menu';

							$args = array(
										'theme_location'	=> $avia_theme_location,
										'menu_id'			=> $avia_menu_class,
										'container_class'	=> $avia_menu_class,
										'fallback_cb'		=> '',
										'depth'				=> 1,
										'echo'				=> false,
										'walker'			=> new avia_responsive_mega_menu( array( 'megamenu' => 'disabled' ) )
									);

                            $menu = wp_nav_menu( $args );
                            
                            if( $menu )
							{ 
								echo "<nav class='sub_menu_socket' " . avia_markup_helper( array( 'context' => 'nav', 'echo' => false ) ) . '>';
								echo	$menu;
								echo '</nav>';
							}
                        ?>

                    </div>

	            <!-- ####### END SOCKET CONTAINER ####### -->
				</footer>


			<?php
			} //end nosocket check - array( 'all', 'nofooterwidgets', 'page_in_footer_socket' )


		
		
		} //end blank & nofooterarea check
		?>
		<!-- end main -->
		</div>
		
		<?php
		
		
		//display link to previous and next portfolio entry
		echo	$avia_post_nav;
		
		echo "<!-- end wrap_all --></div>";


		if( isset( $avia_config['fullscreen_image'] ) )
		{ ?>
			<!--[if lte IE 8]>
			<style type="text/css">
			.bg_container {
			-ms-filter:"progid:DXImageTransform.Microsoft.AlphaImageLoader(src='<?php echo $avia_config['fullscreen_image']; ?>', sizingMethod='scale')";
			filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(src='<?php echo $avia_config['fullscreen_image']; ?>', sizingMethod='scale');
			}
			</style>
			<![endif]-->
		<?php
			echo "<div class='bg_container' style='background-image:url(" . $avia_config['fullscreen_image'] . ");'></div>";
		}
	?>


<a href='#top' title='<?php _e( 'Scroll to top', 'avia_framework' ); ?>' id='scroll-top-link' <?php echo av_icon_string( 'scrolltop' ); ?>><span class="avia_hidden_link_text"><?php _e( 'Scroll to top', 'avia_framework' ); ?></span></a>

<div id="fb-root"></div>

<?php

	/* Always have wp_footer() just before the closing </body>
	 * tag of your theme, or you will break many plugins, which
	 * generally use this hook to reference JavaScript files.
	 */
	wp_footer();
	
?>

<?php ##### 여기부터 #####
$query = "select * from mu_popup where 1";
$result = sql_query($query);
$popup_cnt = sql_count($result);
?>
<!-- <script src="//code.jquery.com/jquery-1.12.4.js"></script> -->
<link rel="stylesheet" media="all" href="/aDmin/mu_popup/css/output.css">
<script src="//code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<script src="/aDmin/js/function.js"></script>
<a href='#top' title='<?php _e('Scroll to top','avia_framework'); ?>' id='scroll-top-link' <?php echo av_icon_string( 'scrolltop' ); ?>><span class="avia_hidden_link_text"><?php _e('Scroll to top','avia_framework'); ?></span></a>

<div id="fb-root"></div>
<?php 
$n = 1;
$tz = 'Asia/Seoul';
$timestamp = time();
$dt = new DateTime("now", new DateTimeZone($tz));
$dt->setTimestamp($timestamp);
$dt_ymd = $dt->format('Ymd');
$dt_ymdhi = $dt->format('YmdHi');
$str = array(" ", "/", ":");
$url = $_SERVER['REQUEST_URI'];
//echo "<script>console.log('".$url."')</script>";
?>
<!-- <div id="main_popup_bg"> -->
<?php 
if($url == "/" || $url == "/?lang=en" || $url == "/?lang=zh-hans"){
for($i = 0; $i < $popup_cnt; $i++){
    $row = sql_fetch($result);
    if(strlen($row['show_date']) == 10){
        $dt = $dt_ymd;
    }else{
        $dt = $dt_ymdhi;
    }
    $show_date = str_replace($str, '', $row['show_date']);
    $end_date = str_replace($str, '', $row['end_date']);
    if($dt >= $show_date && $dt <= $end_date && $row['enum_show'] == "O"){
?>
	<div id="main_popup<?php echo $n;?>" class="main_mu_popup main_mu_popup<?php echo $n;?>" style="position:fixed; z-index:999; top:<?php echo $row['loca_top'].$row['loca_top_unit']?>; left:<?php echo $row['loca_left'].$row['loca_left_unit']?>;">
		<div class="mu_popup_img"><?php echo $row['conts'];?></div>
		<div class="mu_popup_bottom">
		<?php 
		if($row['not_today'] == 'Y') {
        ?>		
			<span class="close_mu_popup_day" onclick="pop_todayclose('<?php echo $n;?>')">오늘하루 열지않기</span>
			<span class="close_mu_popup"  onclick="popClose('<?php echo $n;?>')">닫기</span>
		<?php 
		} else {
		?>
			<span class="close_mu_popup_day"></span>
			<span class="close_mu_popup"  onclick="popClose('<?php echo $n;?>')">닫기</span>
		<?php 
		}
		?>
		</div>
	</div>
<?php
        $n++;
    }
}
}
?>
<input type="hidden" class="pop_cnt" value="<?php echo $n-1?>">

<?php ##### 여기까지 ##### ?>
<!-- </div> -->
</body>
<script>
//console.log(document.cookie);

  $(document).ready(function(){
		var main_popup = $(".main_mu_popup");
// 		console.log("쿠키 : " + getCookie("#main_popup1"));
		for(var i=0; i < main_popup.length; i++){
// 			console.log("dd" + getCookie(main_popup[i].id));
			if(getCookie(main_popup[i].id)){
				main_popup[i].remove();
			}
		}
  	})
 
function pop_todayclose(idx){
	setCookie("main_popup"+idx,'Y', 1);
	$("#main_popup"+idx).hide();
}

function popClose(idx){
	$("#main_popup"+idx).hide();
}
</script>
</html>
