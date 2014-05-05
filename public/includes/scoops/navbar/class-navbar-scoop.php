<?php


class Navbar_Scoop extends Gelato_Scoop {
	
	function __construct() {
		parent::__construct( array(
			'name'      => "Navbar",
			'slug'	    => 'navbar',
			'priority'  => "high",
			'order'     => 1,
			'has_admin' => true,
		) );
		
		wp_register_script( 'gelato-view-navbar', GELATO_DIR_URL.'/public/includes/scoops/navbar/view-navbar.js',  array( 'gelato-scoop' ), '1.0', true );
    	
	}
	
	public function admin( $post, $box ) {
		
		if( !class_exists('PresenPress') ) {
			return;
		}

		$data = $this->data( $post->ID );

		?>
		<select name="<?php $this->field_name( "navbar_default" );?>">
			<option >Select Defalt View</option>
			<option value="presentation-in-video" <?php selected( $data['navbar_default'] , "presentation-in-video" ); ?> >Presentation in Video</option>
			<option value="video-in-presentation" <?php selected( $data['navbar_default'], "video-in-presentation" ); ?> >Video in Presentation</option>
			<option value="stacked" <?php selected( $data['navbar_default'] , "stacked"	); ?> >Video above Presentation</option>
		</select>
		<?php
	}
	
	public function content_class(){

		if( !class_exists('PresenPress') ) {
			return;
		}

		$data = $this->data( $post->ID );
		echo $data['navbar_default'];

	}

	public function content(){
		if( !class_exists('PresenPress') ) {
			return;
		}
		wp_enqueue_script( 'gelato-view-navbar' );
		$data = $this->data( $post->ID );
		?>
		<ul id="navbar-choose"  class="sub-nav">
			<li <?php $this->is_active( $data['navbar_default'], 'presentation-in-video' ); ?> ><a href="#presentation-in-video"  >Presentation in Video</a></li>
			<li <?php $this->is_active( $data['navbar_default'], 'video-in-presentation' ); ?>><a href="#video-in-presentation"  >Video in Presentation</a></li>
			<li <?php $this->is_active( $data['navbar_default'], 'stacked' ); ?>><a href="#stacked"  >Stacked</a></li>
		</ul>	
		<?php 
	}

	public function is_active( $comapre1, $compare2 ) {
		if( $comapre1 == $compare2 )
			echo "class='active'";
	}
}

$gelato_scoops['navbar'] = new Navbar_Scoop();
