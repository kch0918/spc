<?php
if ( ! defined( 'AVIA_FW' ) ) {  exit;  }    // Exit if accessed directly

/**
 * Provides support for responsive images.
 * 
 * As WP already offers support for this feature this class mainly provides wrappers to be used 
 * to prepare html code for WP to be able to add needed attributes.
 * 
 * @since 4.7.5.1
 * @added_by Günter
 */

if( ! class_exists( 'avia_responsive_images' ) )
{
	
	class av_responsive_images 
	{
		/**
		 * Holds the instance of this class
		 * 
		 * @since 4.7.5.1
		 * @var av_responsive_images 
		 */
		static private $_instance = null;
		
		/**
		 *
		 * @since 4.7.5.1
		 * @var array 
		 */
		protected $config;
		
		/**
		 * Default WP thumbnails, can be changed with filter
		 * 
		 * @since 4.7.5.1
		 * @var array  
		 */
		protected $wp_default_names;

		/**
		 * Stores all WP default image sizes (original sizes, no responsive scaled down)
		 * 
		 * @since 4.7.5.1
		 * @var array 
		 */
		protected $wp_default_images;
		
		/**
		 * Stores all theme image sizes (original sizes, no responsive scaled down)
		 * 
		 * @since 4.7.5.1
		 * @var array 
		 */
		protected $theme_images;
		
		/**
		 * Stores all image sizes defined by plugins (original sizes, no responsive scaled down)
		 * 
		 * @since 4.7.5.1
		 * @var array 
		 */
		protected $plugin_images;
		
		/**
		 * For performance this are the merged basic image sized (WP, theme, plugin)
		 * 
		 * @since 4.5.7.2
		 * @var array  
		 */
		protected $base_images;

		/**
		 * Array of image sizes and their human readable string
		 * 
		 * @since 4.5.7.2
		 * @var array 
		 */
		protected $readable_img_sizes;

		/**
		 * Array of image sizes grouped by aspect ratio
		 * 
		 * @since 4.5.7.2
		 * @var array 
		 */
		protected $size_groups;
		
		/**
		 * Return the instance of this class
		 * 
		 * @since 4.7.5.1
		 * @param array|null $config 
		 * @return av_responsive_images
		 */
		static public function instance( $config = array() )
		{
			if( is_null( av_responsive_images::$_instance ) )
			{
				av_responsive_images::$_instance = new av_responsive_images( $config );
			}
			
			return av_responsive_images::$_instance;
		}
		
		/**
		 * @since 4.7.5.1
		 * @param array|null $config
		 */
		protected function __construct( $config = array() ) 
		{
			$defaults = apply_filters( 'avf_responsive_images_defaults', array(
						'default_jpeg_quality'	=> 100,			//	used by WP filter
						'theme_images'			=> array(),
						'readableImgSizes'		=> array()
					) );
			
			$this->config = array_merge_recursive( $defaults, $config );
			
			/**
			 * @since 4.7.5.1
			 * @param array
			 * @return array
			 */
			$this->wp_default_names = apply_filters( 'avf_wp_default_thumbnail_names', array( 'thumb', 'thumbnail', 'medium', 'medium_large', 'large', 'post-thumbnail' ) );
			
			$this->wp_default_images = array();
			$this->theme_images = array();
			$this->plugin_images = array();
			$this->base_images = array();
			$this->readable_img_sizes = array();
			$this->size_groups = array();
			
			add_filter( 'avf_modify_thumb_size',  array( $this, 'handler_avf_modify_thumb_size'), 10, 1 );
			add_filter( 'avf_modify_readable_image_sizes',  array( $this, 'handler_avf_modify_readable_image_sizes'), 10, 2 );
			
			add_action( 'init', array( $this, 'handler_wp_init'), 999999 );
			
			add_filter( 'jpeg_quality', array( $this, 'handler_wp_jpeg_quality' ), 99, 2 );
			add_filter( 'wp_editor_set_quality', array( $this, 'handler_wp_editor_set_quality'), 99, 2 );
			
			add_filter( 'post_thumbnail_html', array( $this, 'handler_wp_post_thumbnail_html' ), 10, 5 );
		}
		
		/**
		 * @since 4.7.5.1
		 */
		public function __destruct() 
		{
			unset( $this->config );
			unset( $this->wp_default_names );
			unset( $this->wp_default_images );
			unset( $this->theme_images );
			unset( $this->plugin_images );
			unset( $this->base_images );
			unset( $this->readable_img_sizes );
			unset( $this->size_groups );
		}
		
		/**
		 * Allows a reinitialisation of config array
		 * 
		 * @since 4.7.5.1
		 * @param array $config
		 */
		public function reinit( array $config ) 
		{
			$this->config = array_merge_recursive( $this->config, $config );
		}
		
		
		/**
		 * Add additional image sizes (prepared in case we allow to add custom image sizes by theme)
		 * 
		 * @since 4.7.5.1
		 * @param array $imgSizes
		 * @return array
		 */
		public function handler_avf_modify_thumb_size( array $imgSizes ) 
		{
			return $imgSizes;
		}
		
		/**
		 * Add additional human readable image sizes (prepared in case we allow to add custom image sizes by theme)
		 * 
		 * @since 4.7.5.1
		 * @param array $readableImgSizes
		 * @param array $imgSizes
		 * @return array
		 */
		public function handler_avf_modify_readable_image_sizes( array $readableImgSizes, array $imgSizes ) 
		{
			return $readableImgSizes;
		}

		/**
		 * Loads all defined image sizes and inits local variables
		 * All plugins must have registered their images before
		 * 
		 * @since 4.7.5.1
		 */
		public function handler_wp_init()
		{
			global $_wp_additional_image_sizes;
			
			if( ! is_admin() )
			{
				return;
			}
			
			$this->theme_images = $this->config['theme_images'];
			
			foreach( get_intermediate_image_sizes() as $_size ) 
			{
				$img_size = array();
				
				if( in_array( $_size, $this->wp_default_names ) ) 
				{
					$img_size['width'] = get_option( "{$_size}_size_w", 0 );
					$img_size['height'] = get_option( "{$_size}_size_h", 0 );
					$img_size['crop'] = (bool) get_option( "{$_size}_crop", false );
					$this->wp_default_images[ $_size ] = $img_size;
				} 
				else if( array_key_exists( $_size, $this->theme_images ) )
				{
					$this->theme_images[ $_size ]['width'] = is_numeric( $this->theme_images[ $_size ]['width'] ) ? (int) $this->theme_images[ $_size ]['width'] : 0;
					$this->theme_images[ $_size ]['height'] = is_numeric( $this->theme_images[ $_size ]['height'] ) ? (int) $this->theme_images[ $_size ]['height'] : 0;
					$this->theme_images[ $_size ]['crop'] = empty( $this->theme_images[ $_size ]['crop'] ) ? false : true;
				}
				else if ( isset( $_wp_additional_image_sizes[ $_size ] ) ) 
				{
					$img_size['width'] = $_wp_additional_image_sizes[ $_size ]['width'];
					$img_size['height'] = $_wp_additional_image_sizes[ $_size ]['height'];
					$img_size['crop'] = (bool) $_wp_additional_image_sizes[ $_size ]['crop'];
					$this->plugin_images[ $_size ] = $img_size;
				}
			}
			
			$this->base_images = array_merge( $this->wp_default_images, $this->theme_images, $this->plugin_images );
			
			/**
			 * Allows to translate WP and plugin thumbnail names to human readable
			 * 
			 * @since 4.7.5.1
			 * @param array $this->config['readableImgSizes']
			 * @param array $this->base_images
			 * @param av_responsive_images $this
			 * @return array
			 */
			$this->readable_img_sizes = apply_filters( 'avf_resp_images_readable_sizes', $this->config['readableImgSizes'], $this->base_images, $this );
			
			$this->group_image_sizes();
			
			/**
			 * 
			 * @since 4.7.5.1
			 * @param array $this->size_groups
			 * @param av_responsive_images $this
			 */
			do_action( 'ava_responsive_image_sizes_grouped', $this->size_groups, $this );
		}
		
		/**
		 * Prepare image for WP to recognise
		 * 
		 * @since 4.7.5.1
		 * @param string $html
		 * @param int $post_id
		 * @param int $post_thumbnail_id
		 * @param string|array $size
		 * @param string $attr
		 * @return string
		 */
		public function handler_wp_post_thumbnail_html( $html, $post_id, $post_thumbnail_id, $size, $attr ) 
		{
			if( ! $this->responsive_images_active() )
			{
				return $html;
			}
			
			return $this->add_attachment_id( $html, $post_thumbnail_id );
		}
		
		/**
		 * Sets the default image to our default quality (100%) for more beautiful images when used in conjunction with img optimization plugins
		 *
		 * @since 4.7.5.1
		 * @since 4.3 in functions-enfold added_by Kriesi
		 * @param int $quality
		 * @param string $mime_type
		 * @return int
		 */
		public function handler_wp_editor_set_quality( $quality, $mime_type )
		{
			return apply_filters( 'avf_wp_editor_set_quality', $this->config['default_jpeg_quality'], $quality, $mime_type );
		}
		
		
		/**
		 * Sets the default image to our default quality (100%) for more beautiful images when used in conjunction with img optimization plugins
		 *
		 * @since 4.7.5.1
		 * @since 4.3 in functions-enfold added_by Kriesi
		 * @param int $quality
		 * @param string $context				edit_image | image_resize
		 * @return int
		 */
		public function handler_wp_jpeg_quality( $quality, $context )
		{
			return apply_filters( 'avf_jpeg_quality', $this->config['default_jpeg_quality'], $quality, $context );
		}
		
		/**
		 * Return true, if option is selected
		 * 
		 * @since 4.7.5.1
		 * @return boolean
		 */
		public function responsive_images_active() 
		{
			return 'responsive_images' == avia_get_option( 'responsive_images', '' );
		}

		/**
		 * Adds the class "wp-image-{$attachment_ID}" to <img ...> tag.
		 * Needed by WP to add scrset and sizes attributes.
		 * Class will be added to all img tags in content
		 * 
		 * @since 4.7.5.1
		 * @param string $html
		 * @return string
		 */
		public function add_attachment_id( $html, $attachment_id ) 
		{
			if( ! $this->responsive_images_active() )
			{
				return $html;
			}
			
			if( ! is_numeric( $attachment_id ) || 0 == $attachment_id )
			{
				return $html;
			}
			
			$attachment_id = (int) $attachment_id;
			
			$matches = array();
			if ( ! preg_match_all( '/<img [^>]+>/', $html, $matches ) ) 
			{
				return $html;
			}
			
			foreach ( $matches[0] as $image ) 
			{
				$new_img = $this->add_id_to_img( $image, $attachment_id );
				
				$pos = strpos( $html, $image );
				if( false !== $pos )
				{
					$html = substr_replace( $html, $new_img, $pos, strlen( $image ) );
				}
			}
			
			return $html;
		}
		
		/**
		 * Gets an image HTML and returns HTML with scrset and sizes added if exists
		 * 
		 * @since 4.7.5.1
		 * @param string $html
		 * @param int $attachment_id
		 * @return string
		 */
		public function make_image_responsive( $html, $attachment_id ) 
		{
			if( ! $this->responsive_images_active() )
			{
				return $html;
			}
			
			$img = $this->add_attachment_id( $html, $attachment_id );
			return $this->make_content_images_responsive( $img );
		}

		/**
		 * Wrapper function to prepare content that standard WP function wp_make_content_images_responsive can handle
		 * images properly
		 * 
		 * @since 4.7.5.1
		 * @param string $content
		 * @return string
		 */
		public function make_content_images_responsive( $content ) 
		{
			if( ! $this->responsive_images_active() )
			{
				return $content;
			}
			
			$matches = array();
			if ( ! preg_match_all( '/<img [^>]+>/', $content, $matches ) ) 
			{
				return $content;
			}
			
			foreach ( $matches[0] as $image ) 
			{
				$new_image = $this->ensure_scr_attr_enclosure( $image );
				if( $new_image != $image )
				{
					$pos = strpos( $content, $image );
					
					if( false !== $pos )
					{
						$content = substr_replace( $content, $new_image, $pos, strlen( $image ) );
					}
				}
			}
			
			$return = wp_make_content_images_responsive( $content );
			
			return $return;
		}
		
		/**
		 * Adds the WP class "wp-image-{$attachment_ID}" to <img> tag
		 * 
		 * @since 4.7.5.1 
		 * @param string $image
		 * @param int $attachment_id
		 * @return string
		 */
		protected function add_id_to_img( $image, $attachment_id ) 
		{
			$prefix = 'wp-image-';
			
			if( false !== strpos( $image, $prefix ) )
			{
				return $image;
			}
					
			$class = $prefix . $attachment_id;
			
			if( false === strpos( $image, 'class=' ) )
			{
				$image = str_replace( '<img', '<img class="' . $class . '" ', $image );
			}
			else if( false !== strpos( $image, 'class="' ) )
			{
				$image = str_replace( 'class="', 'class="' . $class . ' ', $image );
			}
			else if( false !== strpos( $image, "class='" ) )
			{
				$image = str_replace( "class='", "class='" . $class . ' ', $image );
			}
			
			return $image;
		}
		
		/**
		 * Make sure that HTML is src="...." and mot src='.....' which is not recognized by WP
		 * 
		 * @since 4.7.5.1
		 * @param string $image
		 * @return string
		 */
		protected function ensure_scr_attr_enclosure( $image ) 
		{
			$match_src = array();
			
			if( preg_match( "/src='([^']+)'/", $image, $match_src ) )
			{
				$new_src = 'src="' . $match_src[1] . '"';
				
				$pos = strpos( $image, $match_src[0] );
					
				if( false !== $pos )
				{
					$image = substr_replace( $image, $new_src, $pos, strlen( $match_src[0] ) );
				}
			}
			
			return $image;
		}
		
		/**
		 * Build internal responsive groups
		 * Needed to display in backend only for user information
		 * 
		 * @since 4.7.5.1
		 */
		protected function group_image_sizes() 
		{
			$widths = array();
			$all = $this->base_images;
			
			foreach( $all as $sizes ) 
			{
				if( ! in_array( $sizes['width'], $widths ) )
				{
					$widths[] = $sizes['width'];
				}
			}
			
			sort( $widths );
			
			$groups = array();
			
			while( count( $widths ) > 0 )
			{
				$current_width = array_shift( $widths );
				
				do
				{
					$found = false;
					$height_key = '';
					
					foreach( $all as $name => $sizes ) 
					{
						if( $sizes['width'] == $current_width )
						{
							$height_key = $sizes['height'];
							$group_key = $current_width . '*' . $height_key;
							$groups[ $group_key ][ $name ] = $sizes;
							
							unset( $all[ $name ] );
							$found = true;
							break;
						}
					}
					
					if( ! $found )
					{
						break;
					}
					
					/**
					 * Check remaining for same aspect ratio
					 */
					foreach( $all as $name => $sizes ) 
					{
						if( wp_image_matches_ratio( $current_width, $height_key, $sizes['width'], $sizes['height'] ) )
						{
							$groups[ $group_key ][ $name ] = $sizes;
							unset( $all[ $name ] );
						}
					}
								
				} while ( $found );
			}
			
			$this->size_groups = array();
			
			foreach( $groups as $group => $images ) 
			{
				$widths = array();
				
				foreach( $images as $image ) 
				{
					if( ! in_array( $image['width'], $widths ) )
					{
						$widths[] = $image['width'];
					}
				}
				
				sort( $widths );
				
				while( count( $widths ) > 0 )
				{
					$current_width = array_shift( $widths );
					
					foreach( $images as $name => $sizes ) 
					{
						if( $sizes['width'] == $current_width )
						{
							$this->size_groups[ $group ][ $name ] = $sizes;
							unset( $images[ $name ] );
						}
					}
				}
				
			}
			
		}
		
		/**
		 * Prepare overview of used image sizes for theme options page
		 * 
		 * @since 4.7.5.1
		 * @return string
		 */
		public function options_page_overview() 
		{
			$html = '';
			
			foreach( $this->size_groups as $size_group => $sizes ) 
			{
				$html .= '<h3>' . $this->get_group_headline( $size_group ) . '</h3>';
				
				$html .= '<ul>';
				
				foreach( $sizes as $key => $image ) 
				{
					$info = $image['width'] . '*' . $image['height'];
					if( isset( $image['crop'] ) && true === $image['crop'] )
					{
						$info .= '  ' . __( '(cropped)', 'avia_framework' );
					}
					
					$info .= ' - ' . $this->get_image_key_info( $key );
					
					$html .= '<li>' . $info . '</li>';
				}
				
				$html .= '</ul>';
			}
			
			return $html;
		}
		
		/**
		 * Returns the string for the group headline.
		 * Calculates the aspect ratio or only width/height if one value is 0
		 * 
		 * @since 4.7.5.1
		 * @param string $group
		 * @return string
		 */
		protected function get_group_headline( $group )
		{
			$headline = '';
			
			$sizes = explode( '*', $group );
			
			$w = isset( $sizes[0] ) ? (int) $sizes[0] : 0;
			$h = isset( $sizes[1] ) ? (int) $sizes[1] : 0;
			
			if( 0 == $h )
			{
				$headline .= __( 'Images keeping original aspect ratio', 'avia_framework' );
			}
			else if ( 0 == $w )
			{
				$headline .= __( 'Images keeping original aspect ratio', 'avia_framework' );
			}
			else
			{
				$gcd = $this->greatest_common_divisor( $w, $h );
				$w = (int) ( $w / $gcd );
				$h = (int) ( $h / $gcd );
				
				$headline .= sprintf( __( 'Images aspect ratio: %d : %d', 'avia_framework' ), $w, $h );
			}
			
			/**
			 * 
			 * @since 4.7.5.1
			 * @param string $headline
			 * @param string $group
			 * @return string
			 */
			return apply_filters( 'avf_admin_image_group_headline', $headline, $group );
		}
		
		/**
		 * Return readable info for an image size key for options page
		 * 
		 * @since 4.7.5.1
		 * @param string $image_key
		 * @return string
		 */
		protected function get_image_key_info( $image_key ) 
		{
			$info = '';
			
			$info .= ( array_key_exists( $image_key, $this->readable_img_sizes ) ) ? $this->readable_img_sizes[ $image_key ] : $image_key;
			
			$info .= '  (';
			
			if( array_key_exists( $image_key, $this->theme_images ) )
			{
				$info .= __( 'added by theme', 'avia_framework' );
			}
			else if( array_key_exists( $image_key, $this->plugin_images ) )
			{
				$info .= __( 'added by a plugin', 'avia_framework' );
			}
			else if( array_key_exists( $image_key, $this->wp_default_images ) )
			{
				$info .= __( 'WP default size', 'avia_framework' );
			}
			else
			{
				$info .= __( 'unknown', 'avia_framework' );
			}
			
			$info .= ')'; 
			
			/**
			 * 
			 * @since 4.7.5.1
			 * @param string $info
			 * @param string $image_key
			 * @return string
			 */
			return apply_filters( 'avf_admin_image_key_info', $info, $image_key );
			
		}


		/**
		 * Calculates the value based on https://en.wikipedia.org/wiki/Greatest_common_divisor - euclid's algorithm
		 * 
		 * @since 4.7.5.1
		 * @param int $a
		 * @param int $b
		 * @return int
		 */
		protected function greatest_common_divisor( $a, $b )
		{
			if( 0 == $a ) 
			{
				return abs( $b );
			}
			
			if( 0 == $b ) 
			{
				return abs( $a );
			}
			
			if( $a < $b )
			{
				$h = $a;
				$a = $b;
				$b = $h;
			}

			do 
			{
				$h = $a % $b;
				$a = $b;
				$b = $h;
			} while ( $b != 0 );

			return abs( $a );
		}
	}

	/**
	 * Returns the main instance of av_responsive_images to prevent the need to use globals
	 * 
	 * @since 4.7.5.1
	 * @param array|null $config
	 * @return av_responsive_images
	 */
	function Av_Responsive_Images( $config = array() ) 
	{
		return av_responsive_images::instance( $config );
	}
	
}