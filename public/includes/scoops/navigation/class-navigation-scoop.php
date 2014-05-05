<?php


class Navigation_Scoop extends Gelato_Scoop {
	
	function __construct() {
		parent::__construct( array(
			'name'      => "Navigation",
			'slug'	    => 'navigation',
			'priority'  => "high",
			'order'     => 1,
			'has_admin' => false,
		) );
		
		wp_register_script( 'gelato-view-navbar', GELATO_DIR_URL.'/public/includes/scoops/navbar/view-navbar.js',  array( 'gelato-scoop' ), '1.0', true );
    	
	}
	
	public function navigation(){
		$current_id = get_the_id();
		$args = array(
			'post_type'  => GELATO_CPT,
			'post_status'=>'publish'
		);

		// The Query
		$the_query = new WP_Query( $args );

		// The Loop
		if ( $the_query->have_posts() ) { ?>
		    <ul class="side-nav">
				<?php 
				while ( $the_query->have_posts() ) {
					$the_query->the_post();
					if( $current_id  != get_the_id() ) {
						?> <li><a href="<?php the_permalink(); ?>"> <?php the_title( ); ?></a></li><?php 
					} else {
						?> <li> <?php the_title( ); ?> </li><?php 
					}
					
				}
		        ?>
		  		</ul>
		        <?php 
		} else {
			
		}
		/* Restore original Post Data */
		wp_reset_postdata();
		
	}
}

$gelato_scoops['navigation'] = new Navigation_Scoop();
