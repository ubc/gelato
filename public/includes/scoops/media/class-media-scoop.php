<?php


class Media_Scoop extends Gelato_Scoop {
	
	function __construct() {
		parent::__construct( array(
			'name'      => "Media",
			'slug'	    => 'media',
			'priority'  => "high",
			'order'     => 1,
			'has_admin' => true,
			'has_css' 	=> true,
		) );
		
    	wp_register_script( 'gelato-view-media', GELATO_DIR_URL.'/public/includes/scoops/media/view-media.js',  array( 'gelato-scoop' ), '1.0', true );
	}
	
	public function admin( $post, $box ) {
		
		$media = $this->data( $post->ID );

		?>
		
			<select name="<?php $this->field_name( "type" ); ?>">
				<option value="youtube" <?php selected( $media['type'] == "youtube" ); ?>>YouTube</option>
				<option value="vimeo" <?php selected( $media['type'] == "vimeo" ); ?>>Vimeo</option>
				<option value="soundcloud" <?php selected( $media['type'] == "soundcloud" ); ?>>SoundCloud</option>
			</select>
		
		<label for="<?php $this->field_name( "url" ); ?>">
			<input type="url" name="<?php $this->field_name( "url" ); ?>" class="regular-text" value="<?php echo $media['url']; ?>" />
		</label>
		<?php

	}
	
	public function content() { 
		// make sure that the js is loaded
		wp_enqueue_script( 'gelato-view-media' );
		$media = $this->data();
		?>
		<div id="gelato-media" class="iframe-wrapper flex-video <?php echo $media['type']; ?>"></div>
		<?php
	}

	public function sidebar(){
		echo "the media sidebar";
	}
}

$gelato_scoops['media'] = new Media_Scoop();