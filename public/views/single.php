<?php
/**
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
		<?php do_action( 'gelato_wp_head' ); ?>
		
	</head>
	<body <?php body_class(); ?>>
		<div class="page-wrap">
		<?php if ( have_posts() ) : while ( have_posts() ) : the_post();  ?>
		<?php Gelato_Scoop::the_head(); ?>
		<div class="off-canvas-wrap"> 
		<div class="inner-wrap"> 
			<nav class="tab-bar"> 
				<section class="left-small"> 
					<a class="left-off-canvas-toggle menu-icon" ><span></span></a>
				</section> 
				<section class="middle tab-bar-section">
					<h1 class="title"><?php the_title( ); ?></h1> 
				</section>
				<section class="right-small"> 
					<a class="right-off-canvas-toggle " ><span class="genericon genericon-chat"></span></a> 
				</section> 
			</nav>
			<aside class="left-off-canvas-menu gelato-navigation"> 
				<div class="gelato-pad">
				<?php Gelato_Scoop::the_navigation(); ?>
				</div>
			</aside>
			<aside class="right-off-canvas-menu gelato-sidebar">
				<div class="gelato-pad">
				<?php Gelato_Scoop::the_sidebar(); ?>
				</div>
			</aside>
			<section class="main-section gelato-content">
				<div id="gelato-shell-pad" class="gelato-pad <?php Gelato_Scoop::the_content_class(); ?>">
				<?php Gelato_Scoop::the_content(); ?>
				</div>
			</section>
			<a class="exit-off-canvas"></a>
		</div>
		</div>
		
		
		<?php 
			endwhile; ?>
		<?php endif; ?>

		</div>
	<?php wp_footer(); ?>
	</body>
</html>
<!-- This file is used to markup the public facing aspect of the plugin. -->
