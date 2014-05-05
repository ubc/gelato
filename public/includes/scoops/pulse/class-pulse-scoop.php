<?php


class Pulse_Scoop extends Gelato_Scoop {
	
	function __construct() {
		parent::__construct( array(
			'name'      => "Pulse",
			'slug'	    => 'pulse',
			'priority'  => "high",
			'order'     => 1,
			'has_admin' => false,
			'has_css' 	=> true,
		) );

		wp_register_script( 'popcorn-pulse',   GELATO_DIR_URL.'/public/includes/scoops/pulse/popcorn.pulse.js', array( 'jquery' ), '1.0', true );
    	wp_register_script( 'gelato-view-pulse', GELATO_DIR_URL.'/public/includes/scoops/pulse/view-pulse.js',  array( 'gelato-scoop', 'gelato-view-media', 'popcorn-pulse' ), '1.0', true );

    	add_action( 'publish_pulse-cpt', array( __CLASS__, 'modify_pulse' ) );
		add_filter( 'the_pulse_data', array( $this, 'the_pulse_data' ) );
	}
	
	public function admin( $post, $box ) {
		
		

	}
	

	public function sidebar(){
		if( !class_exists( 'Pulse_CPT' ) )
			return;
		$pulse = $this->data();

		wp_enqueue_script( 'popcornjs-pulse' );
		wp_enqueue_script( 'gelato-view-pulse' );
		
		?>
		<div class="widget">
			<div id="scct-pulse-list" class="pulse-widget">
				<?php
				
					if ( true || is_array($pulse) && $pulse['meta']['mode'] != 'locked' ) {
						Pulse_CPT_Form_Widget::pulse_form( $pulse );
					}
				?>
				<div id="pulse-list" class="pulse-list minimal">
					<!-- To be populated by PopcornJS -->
				</div>
				<?php $it = Pulse_CPT::the_pulse_array_js( $pulse ); ?>
				<script id="pulse-cpt-single" type="text/x-dot-template">
					<?php Pulse_CPT::the_pulse( $it, false, true ); ?>
				</script>
			</div>
		</div>
		<?php
	}


	function localize_data( $data ) {

		$pulse_list = array();
		$args = Pulse_CPT_Form_Widget::query_arguments();
		$args['posts_per_page'] = -1;
		$args['orderby'] = "meta_value_num";
		$args['meta_key'] = "synctime";
		$args['order'] = "DESC";

		$pulse_query = new WP_Query( $args );
		while ( $pulse_query->have_posts() ) {
			$pulse_query->the_post();
			$pulse_list[] = Pulse_CPT::the_pulse_array();
		}
		
		// Reset Post Data
		wp_reset_postdata();
		
		$data['pulse'] = $pulse_list;
		return $data;
	}
	
	public function save( $post_id ) {
		$post_data = ( isset( $_POST[$this->atts['slug']]) ? $_POST[$this->atts['slug']] : array() ); 
		$_POST[$this->atts['slug']] = array_merge( array(
			'title'                  => '',
			'display_title'          => false,
			'view'                   => '',
			'placeholder'            => "",
			'enable_character_count' => true,
			'num_char'               => 140,
			'enable_url_shortener'   => false,
			'bitly_user'             => get_option( 'pulse_bitly_username' ),
			'bitly_api_key'          => get_option( 'pulse_bitly_key' ),
			'rating_metric'          => false,
			'display_content_rating' => false,
			'enable_replies'         => false,
			'tabs'                   => array(
				'tagging'      => false,
				'co_authoring' => false,
				'file_upload'  => false,
			),
		), $post_data );
		
		parent::save( $post_id );
	}
	
	public static function modify_pulse( $pulse_id ) {
		if ( isset( $_POST['ss_synctime'] ) ) {
			update_post_meta( $pulse_id, "synctime", $_POST['ss_synctime'] );
		}
	}
	
	public function the_pulse_data( $data ) {
		$synctime = (int) get_post_meta( $data['ID'], "synctime", true );
		
		if ( $synctime > 0 ) {
			$data['date'] = $this->seconds_to_string( $synctime, 3 );
		} else {
			$data['date'] = "";
		}
		
		$data['synctime'] = $synctime;
		$data['reply_to'] = "";
		
		return $data;
	}
}

$gelato_scoops['pulse'] = new Pulse_Scoop();