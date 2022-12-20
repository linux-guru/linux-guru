<?php
/**
* Widget Class : Recent Post Scroll Widget
*
* @package Blog Designer
* @since 3.0.6
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

function wp_blog_designer_post_scroll_widget() {
  register_widget( 'Blog_Designer_scroll_Widget' );
}

// Action to register widget
add_action( 'widgets_init', 'wp_blog_designer_post_scroll_widget' );

class Blog_Designer_scroll_Widget extends WP_Widget {

	function __construct() {
		$widget_ops = array('classname' => 'wp_blog_designer_scroll_widget', 'description' => __('Display Latest WP Post in a sidebar with vertical slider.', 'blog-designer') );
		parent::__construct( 'wp_blog_designer_scroll_widget', __('Blog Designer Post Scroll Widget', 'blog-designer'), $widget_ops);
	}

	/**
	 * Handles updating settings for the current widget instance.
	 *
	 * @package Blog Designer
	 * @since 1.0.0
	*/
	function update($new_instance, $old_instance) {

		$instance = $old_instance;

		$instance['title']			= sanitize_text_field($new_instance['title']);
		$instance['number_of_post']		= $new_instance['number_of_post'];
		$instance['show_post_date']			= !empty($new_instance['show_post_date']) ? 1 : 0;
		$instance['show_post_thumbnail']		= !empty($new_instance['show_post_thumbnail']) ? 1 : 0;
		$instance['category']		= $new_instance['category'];
		$instance['slider_speed']			= $new_instance['slider_speed'];
		$instance['link_target']	= !empty($new_instance['link_target']) ? 1 : 0;
		$instance['display_post_content']	= !empty($new_instance['display_post_content']) ? 1 : 0;
		$instance['content_words_limit'] = !empty($new_instance['content_words_limit']) ? $new_instance['content_words_limit'] : 20;

		return $instance;
	}

	/**
	* Outputs the settings form for the widget.
	*
	* @package Blog Designer
	* @since 1.0.0
	*/
	function form($instance) {
		$defaults = array(
				'number_of_post'				=> 5,
				'title'							=> esc_html__( 'Latest Posts Scrolling', 'blog-designer' ),
				'show_post_date'				=> 1, 
				'show_post_thumbnail'			=> 1,
				'category'						=> 0,
				'slider_speed'					=> 500,
				'link_target'					=> 0,
				'content_words_limit'			=> 20,
				'display_post_content'			=> 0,
			);

		$instance = wp_parse_args( (array) $instance, $defaults );
	?>
		<!-- Title -->
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php esc_html_e( 'Title', 'blog-designer' ); ?>:</label>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($instance['title']); ?>" />
		</p>

		<!-- Display Category -->
		<p>
			<label for="<?php echo $this->get_field_id( 'category' ); ?>"><?php _e( 'Category', 'blog-designer' ); ?>:</label>
			<?php
				$dropdown_args = array(
										'taxonomy'          => 'category',
										'class'             => 'widefat',
										'show_option_all'   => __( 'All', 'blog-designer' ),
										'id'                => $this->get_field_id( 'category' ),
										'name'              => $this->get_field_name( 'category' ),
										'selected'          => $instance['category'],
									);
				wp_dropdown_categories( $dropdown_args );
			?>
		</p>

		<!-- Number of Items -->
		<p>
			<label for="<?php echo $this->get_field_id('number_of_post'); ?>"><?php esc_html_e( 'Number of Items', 'blog-designer' ); ?>:</label>
			<input class="widefat" id="<?php echo $this->get_field_id('number_of_post'); ?>" name="<?php echo $this->get_field_name('number_of_post'); ?>" type="number" value="<?php echo $instance['number_of_post']; ?>" />
		</p>


		<!-- Display Date -->
		<p>
			<input id="<?php echo $this->get_field_id( 'show_post_date' ); ?>" name="<?php echo $this->get_field_name( 'show_post_date' ); ?>" type="checkbox" value="1" <?php checked( $instance['show_post_date'], 1 ); ?> />
			<label for="<?php echo $this->get_field_id( 'show_post_date' ); ?>"><?php _e( 'Display Date', 'blog-designer' ); ?></label>
		</p>

		 <!--  Display Short Content -->
		<p>
			<input type="checkbox" value="1" id="<?php echo $this->get_field_id( 'display_post_content' ); ?>" name="<?php echo $this->get_field_name( 'display_post_content' ); ?>" <?php checked( $instance['display_post_content'], 1 ); ?> />
			<label for="<?php echo $this->get_field_id( 'display_post_content' ); ?>"><?php _e( 'Display Short Content', 'blog-designer' ); ?></label>
		</p>
		
		<!-- Number of content_words_limit -->
		<p>
			<label for="<?php echo $this->get_field_id('content_words_limit'); ?>"><?php esc_html_e( 'Content words limit', 'blog-designer' ); ?>:</label>
			<input class="widefat" id="<?php echo $this->get_field_id('content_words_limit'); ?>" name="<?php echo $this->get_field_name('content_words_limit'); ?>" type="number" value="<?php echo $instance['content_words_limit']; ?>"  />
			 <span class="description"><em><?php _e('Content words limit will only work if Display Short Content checked', 'blog-designer'); ?></em></span>
	   </p>

		<!-- Show Thumb -->
		<p>
			<input id="<?php echo $this->get_field_id( 'show_post_thumbnail' ); ?>" name="<?php echo $this->get_field_name( 'show_post_thumbnail' ); ?>" type="checkbox" value="1" <?php checked( $instance['show_post_thumbnail'], 1 ); ?> />
			<label for="<?php echo $this->get_field_id( 'show_post_thumbnail' ); ?>"><?php _e( 'Display Thumbnail in left side', 'blog-designer' ); ?></label>
		</p>

		<!-- Open Link in a New Tab -->
		<p>
			<input id="<?php echo $this->get_field_id( 'link_target' ); ?>" name="<?php echo $this->get_field_name( 'link_target' ); ?>" type="checkbox"<?php checked( $instance['link_target'], 1 ); ?> />
			<label for="<?php echo $this->get_field_id( 'link_target' ); ?>"><?php _e( 'Open Link in a New Tab', 'blog-designer' ); ?></label>
		</p>
		<!-- slider_speed -->
		<p>
			<label for="<?php echo $this->get_field_id( 'slider_speed' ); ?>"><?php _e( 'Slider Speed', 'blog-designer' ); ?>:</label>
			<input type="number" name="<?php echo $this->get_field_name( 'slider_speed' ); ?>"  value="<?php echo $instance['slider_speed']; ?>" class="widefat" id="<?php echo $this->get_field_id( 'slider_speed' ); ?>" />
		</p>
	<?php
  }


	/**
	 * Outputs the content for the current widget instance.
	 *
	 * @package Blog Designer
	 * @since 1.0.0
	*/
	function widget($args, $instance) {
		$title          = apply_filters( 'widget_title', isset( $instance['title'] ) ? $instance['title'] : __( 'Latest Posts', 'blog-designer' ), $instance, $this->id_base );
		$number_of_post      = $instance['number_of_post'];
		$date           = ( isset($instance['show_post_date']) && ($instance['show_post_date'] == 1) ) ? "true" : "false";
		$show_post_thumbnail     = ( isset($instance['show_post_thumbnail']) && ($instance['show_post_thumbnail'] == 1) ) ? "true" : "false";
		$category       = $instance['category'];
		$slider_speed          = $instance['slider_speed'];
		$link_target    = (isset($instance['link_target']) && $instance['link_target'] == 1) ? '_blank' : '_self';
		$words_limit        = $instance['content_words_limit'];
		$display_post_content       = ( isset($instance['display_post_content']) && ($instance['display_post_content'] == 1) ) ? "true" : "false";

		// Start Widget Output
		echo $before_widget;

		if ( $title ) {
			echo $before_title . $title . $after_title;
		}
		global $post;

		// WP Query Parameter
		$post_args = array(
					'post_type'             => 'post',
					'post_status'           => array( 'publish' ),
					'posts_per_page'        => $number_of_post,
					'order'                 => 'DESC',
					'ignore_sticky_posts'   => true,
				);

		// Category Parameter
		if( !empty($category) ) {
			$post_args['tax_query'] = array(
				array(
					'taxonomy'  => 'category',
					'field'     => 'term_id',
					'terms'     => $category
				)
			);
		}

		// WP Query
		$bd_loop = new WP_Query($post_args);

		$bd_gallery_slider = dirname( __FILE__ ) . '/css/slick.css';
		if ( file_exists( $bd_gallery_slider ) ) {
			wp_enqueue_style( 'bdp-slick-stylesheets', plugins_url( 'css/slick.css', __FILE__ ), null, '1.0' );
		}
		wp_enqueue_script( 'bdp-slick-script', plugins_url( 'js/slick.min.js', __FILE__ ), null, '1.0', false );
		?>
		<style>.vertical-slider ul li p {margin:0}.vertical-slider ul { margin-left: 0; }</style>
		<script>
			jQuery(document).ready(function(e) {
				
				jQuery('.vertical-slider .slides').slick({
					dots: false,
					arrows: false,
					vertical: true,
					slidesToShow: 5,
					slidesToScroll: 1,
					// centerMode : true,
					autoplay: true,
  					autoplaySpeed: <?php echo esc_attr( $slider_speed ) ?>,
					verticalSwiping: true,
				});
			});
		</script>
		<?php if ($bd_loop->have_posts()) { ?>
		<div class="vertical-slider">
			<ul class="slides">
				<?php while ($bd_loop->have_posts()) : $bd_loop->the_post();
					$post_id = $post->ID;
					$image  = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), array(100,100 ) );
					$feat_image 	= isset($image[0]) ? $image[0] : '';
					$post_link      = get_permalink( $post->ID );
					if (has_excerpt($post_id)) {
						$content 		= get_the_excerpt();
					} else {
						$content = !empty($content) ? $content : get_the_content();
					}
					if( !empty($content) ) {
						$content = strip_shortcodes( $content ); // Strip shortcodes
						$content = wp_trim_words( $content, $words_limit, '..' );
					}

				?>
				<li class="wp-bdp-post-li wp-bdp-clearfix">
					<?php if($show_post_thumbnail == 'true') { ?>
						<div class="wp-bdp-list-content">
							 <?php if( !empty($feat_image) ) { ?>
								<div class="wp-bdp-left-img">
									<div class="wp-bdp-image-bg">
										<a  href="<?php echo esc_url( $post_link ); ?>" target="<?php echo $link_target; ?>">                                       
												<img src="<?php echo esc_url( $feat_image ); ?>" alt="<?php echo get_the_title(); ?>" />                                       
										</a>
									</div>
								</div>
							 <?php } ?>

							<div class="wp-bdp-right-content <?php if( empty($feat_image) ) { echo 'bdp-post-full-content'; } ?>">								
								<h4 class="wp-bdp-title">
									<a href="<?php echo esc_url( $post_link ); ?>" target="<?php echo $link_target; ?>"><?php the_title(); ?></a>
								</h4>

								<?php if($date == "true") { ?>
								<div class="wp-bdp-meta" <?php if($display_post_content != "true") { ?>  style="margin:0px;" <?php } ?>>
								   <span class="wp-bdp-meta-innr bdp-time"> <?php echo get_the_date(); ?></span>
								</div>
								<?php } 
								if($display_post_content == "true") { ?>
									<div class="wp-bdp-content">    
										<p><?php echo $content; ?></p>
									</div>
							<?php } ?>
							</div>
						</div>

					<?php } else { ?>
						 <div class="wp-bdp-list-content">							
							<h4 class="wp-bdp-title"> 
								<a href="<?php echo esc_url( $post_link ); ?>" target="<?php echo $link_target; ?>"><?php the_title(); ?></a>
							</h4>

							<?php if($date == "true") { ?>
							<div class="wp-bdp-meta" <?php if($display_post_content != "true") { ?>  style="margin:0px;" <?php } ?>>
								 <span class="wp-bdp-meta-innr bdp-time"><?php echo get_the_date(); ?></span>
							</div>
							<?php }

							if($display_post_content == "true") { ?>
							<div class="wp-bdp-content">
								<p><?php echo $content; ?></p>
							</div>
							<?php } ?>
						</div>
					<?php } ?>
					</li>
				<?php endwhile; ?>
			</ul>
		</div>
		<?php } 
		echo $after_widget;
	}
}