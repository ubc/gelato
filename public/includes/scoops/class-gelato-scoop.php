<?php

class Gelato_Scoop {
	
	private static $modules;

	public  function init() {
		
		add_action( 'load-post.php',     array( __CLASS__, 'meta_box_setup' ) );
		add_action( 'load-post-new.php', array( __CLASS__, 'meta_box_setup' ) );
		add_action( 'save_post',         array( __CLASS__, 'save_post_meta' ), 10, 2 );
		add_action( 'gelato_wp_head',    array( __CLASS__, 'public_style' ) );

		add_filter( 'gelato-localize-view', array( __CLASS__, 'localize_view' ) );
		/* Register Scripts */
		wp_register_script( 'popcorn',      GELATO_DIR_URL.'/public/assets/js/popcorn-complete.js',  array(  ), '1.0', true );
		wp_register_script( 'foundation',   GELATO_DIR_URL.'/public/assets/foundation/js/foundation.min.js',  array( 'jquery' ), '1.0', true );
		wp_register_script( 'gelato-scoop', GELATO_DIR_URL.'/public/assets/js/public.js',  array( 'jquery', 'popcorn',  'foundation' ), '1.0', true );

	}
	


	function get_modules() {
		return self::$modules;
	}

	function the_head(){
		global $post;
		
		
		$data = apply_filters( "gelato-localize-view", array(
			'session_data' => array( 
				'session_id' 		=> $post->ID,
				'session_title' 	=> $post->post_title,
				'session_permalink' => get_permalink( $post->ID ) ),

			'meta' => array( 
				'ajaxurl' => admin_url( 'admin-ajax.php' ) )
		
			) );
		
		wp_localize_script( 'gelato-scoop', 'gelatoScoop', $data );
		wp_enqueue_script( 'gelato-scoop' );

	}

	function localize_view( $data ) {

		foreach ( self::$modules as $index => $module ) {
			$data[$module->atts['slug']] = $module->data();
		}
		
		return $data;
		
	}

	function the_navigation(){
		foreach ( self::$modules as $index => $module ) {
			if( method_exists ( $module , 'navigation' ))
				$module->navigation();
		}
	}
	
	function the_sidebar(){
		foreach ( self::$modules as $index => $module ) {
			if( method_exists ( $module , 'sidebar' ))
				$module->sidebar();
		}

	}

	function the_content() {
		foreach ( self::$modules as $index => $module ) {
			if( method_exists ( $module , 'content' ))
				$module->content();
		}
	}

	function public_style() { ?>
		<!-- this should be minid -->
		<link rel="stylesheet" href="<?php echo esc_url( GELATO_DIR_URL ); ?>/public/assets/foundation/css/normalize.css" />
		<link rel="stylesheet" href="<?php echo esc_url( GELATO_DIR_URL ); ?>/public/assets/foundation/css/foundation.min.css" />
		<link rel="stylesheet" href="<?php echo esc_url( GELATO_DIR_URL ); ?>/public/assets/icons/genericons.css" />
		<link rel="stylesheet" href="<?php echo esc_url( GELATO_DIR_URL ); ?>/public/assets/css/public.css" />
		<?php 
		foreach ( self::$modules as $index => $module ) {
			
			if ( $module->atts['has_css'] ) {

				echo '<link rel="stylesheet" href="' . GELATO_DIR_URL . '/public/includes/scoops/' . $module->atts['slug'] . '/view-' . $module->atts['slug'] . '.css" />';
			}
		}?>
		<script src="<?php echo esc_url( GELATO_DIR_URL ); ?>/public/assets/foundation/js/vendor/modernizr.js"></script>
		<?php
	}
	
	function admin_style() {

	}
	
	function meta_box_setup() {
		add_action( 'add_meta_boxes', array( __CLASS__, 'meta_box_add' ), 15 );

	}
	
	function meta_box_add() {
		
		foreach ( self::$modules as $index => $module ) {
			
			if ( $module->atts['has_admin'] ) {
				add_meta_box( 'gelato-'.$module->atts['slug'], $module->atts['name'], array( $module, 'admin' ), GELATO_CPT , $module->atts['context'], $module->atts['priority'] );
			}
		}
	}
	
	function save_post_meta( $post_id, $post_object ) {
		// Check autosave
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ):
			return;
		endif;
		
		// We're only interested in Session content.
		if ( $post_object->post_type != 'gelato' ):
			return;
		endif;
	  
		// Check user permissions
		if ( ! current_user_can( 'edit_post', $post_id ) ):
			return $post_id;
		endif;

		foreach ( self::$modules as $index => $module ) {
			if ( $module->atts['has_admin'] ) {
				$module->save( $post_id );
			}
		}
		
	}
	
	
	// ============================== INSTANCE ============================== //
	protected $atts;
	
	function __construct( $atts ) {
	
		$this->atts = wp_parse_args( $atts, array(
			'name'      => "Untitled",
			'slug'      => null,
			'icon'      => null,
			'context'   => "normal",
			'priority'  => "default",
			'order'     => 10,
			'has_admin' => true
		) );

		self::$modules[] = $this;


		
	}

	public function load_module_style(){}
	public function load_admin() {}
	public function load_view() {}
	
	public function admin() { ?>
		<strong>Warning!</strong> This module has not implemented an admin view.
		<?php
	}
	
	public function save( $post_id ) {
		
		update_post_meta( $post_id, 'session_cct_'.$this->atts['slug'], $_POST[$this->atts['slug']] );
	}
	
	public function data( $post_id = null ) {
		if ( $post_id == null ) {
			global $post;
			$post_id = $post->ID;
		}
		
		return get_post_meta( $post_id, 'session_cct_'.$this->atts['slug'], true );
	}
	
	public function field_name( $key ) {
		if ( is_array( $key ) ) {
			$key = implode( "][", $key );
		}
		
		echo $this->atts['slug']."[".$key."]";
	}
	
}

Gelato_Scoop::init();