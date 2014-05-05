<?php


class PresentPress_Scoop extends Gelato_Scoop {
	
	function __construct() {
		parent::__construct( array(
			'name'      => "Present Press",
			'slug'	    => 'presentpress',
			'priority'  => "high",
			'order'     => 1,
			'has_admin' => true,
		) );
		
		wp_register_script( 'gelato-view-presentpress', GELATO_DIR_URL.'/public/includes/scoops/presentpress/view-presentpress.js',  array( 'gelato-scoop' ), '1.0', true );
    	
	}
	
	public function admin( $post, $box ) {
		
		if( !class_exists('PresenPress') ) {
			echo "Enabled the PresenPress Plugin";
			return;
		}

		$data = $this->data( $post->ID );

		
		$args = array(
			'post_type'  => PresenPress::post_type,
			'post_status'=>'publish'
		);

		// The Query
		$the_query = new WP_Query( $args );

		// The Loop
		if ( $the_query->have_posts() ) { ?>
		    <select name="<?php $this->field_name( "presentpress_id" );?>">
		        <option value=""> Select Presentation </option>
				<?php 
				while ( $the_query->have_posts() ) {
					$the_query->the_post();
					?> <option value="<?php the_ID(); ?>" <?php selected( $data['presentpress_id'], get_the_id() ); ?>><?php the_title(); ?></option><?php 
				}
		        ?>
		        </select>
		        <?php 
		} else {
			// no posts found
			echo "You don't have any Presentation Created yet";
		}
		/* Restore original Post Data */
		wp_reset_postdata();

	}

	public function content(){

		global $post;
		$data = $this->data( $post->ID );

		wp_enqueue_script( 'gelato-view-presentpress' );

		if( $data['presentpress_id'] ) :
			?>
			<script>
				var Reveal = {};
				function presentpressload(iframe){
					Reveal = 	iframe.Reveal;
				}
			</script>
			<div id="gelato-presentpress-shell"  ><div id="gelato-presentpress" class="flex-video"><iframe src="<?php echo get_permalink( $data['presentpress_id'] ); ?>?admin-bar=no&js=access" width="600" height="400" ></iframe></div></div>
			<?php
		endif;
	}

	public function sidebar(){

	}

}
//if( class_exists('PresenPress') ){
	$gelato_scoops['presentpress'] = new PresentPress_Scoop();
// }
