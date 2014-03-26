<?php
/**
 * Represents the view for the public-facing component of the plugin.
 *
 * This typically includes any information, if any, that is rendered to the
 * frontend of the theme when the plugin is activated.
 *
 * @package   Gelato
 * @author    Enej Bajgoric <enej.bajgoric@ubc.ca>
 * @license   GPL-2.0+
 * @link      http://ctlt.ubc.ca
 * @copyright 2014 CTLT UBC
 */
?>
<!DOCTYPE html>
<!--[if IE 9]><html class="lt-ie10" lang="en" > <![endif]-->
<html class="no-js" <?php language_attributes(); ?> >

	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta charset="<?php bloginfo( 'charset' ); ?>">

		<title><?php wp_title( '|', true, 'right' ); ?></title>
		<?php do_action( 'scct_load_style' ); ?>
		

	<script src="<?php echo SESSION_CCT_DIR_URL;?>/assets/foundation/js/vendor/modernizr.js"></script>
	</head>
	<body <?php body_class(); ?>>

		<?php if ( have_posts() ) : while ( have_posts() ) : the_post();  ?>
		<?php Session_CCT_View::the_head(); ?>
		<div class="page-wrap">
			<div class="off-canvas-wrap"> 
				<div class="inner-wrap"> 
					<nav class="tab-bar">
						<section class="left-small"> <a class="left-off-canvas-toggle genericon genericon-menu" ><span></span></a></section> 
						<section class="middle tab-bar-section"> <h1 class="title"><?php the_title(); ?></h1> </section> 
						<section class="right-small"> <a class="right-off-canvas-toggle genericon genericon-chat" ><span></span><span class="comment-number	round alert label"><?php echo get_comments_number(); ?></span></a> </section> 
					</nav> 
					<aside class="left-off-canvas-menu"> 
					<ul class="off-canvas-list"> 
						<li><label>Foundation</label></li> 
						<li><a href="#">The Psychohistorians</a></li>
					</ul> 
					<?php // Session_CCT_View::the_navigation(); ?>
					</aside> 

					<aside class="right-off-canvas-menu right-sidebar"> 
						
						<?php // Session_CCT_View::the_sidebar(); ?>
						
					</aside> 
					<section class="main-section"> 
						<?php // Session_CCT_View::the_content( $post ); ?>
					</section> 
					<a class="exit-off-canvas"></a> 
				</div> 
			</div>
		</div>
		
		<?php 
			endwhile; ?>
		<?php endif; ?>


	<?php wp_footer(); ?>
	</body>
</html>
<!-- This file is used to markup the public facing aspect of the plugin. -->
