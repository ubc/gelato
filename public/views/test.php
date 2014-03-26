<?php Gelato_Scoop::the_head(); ?>
		<div class="page-wrap">
			<div class="off-canvas-wrap"> 
				<div class="inner-wrap"> 
					<nav class="tab-bar">
						<section class="left-small"> <a class="left-off-canvas-toggle " ><span class="genericon genericon-menu"></span></a></section> 
						<section class="middle tab-bar-section"> <h1 class="title"><?php the_title(); ?></h1> </section> 
						<section class="right-small"> <a class="right-off-canvas-toggle" ><span class="genericon genericon-chat"></span></a> </section> 
					</nav> 
					<aside class="left-off-canvas-menu"> 
						<ul class="off-canvas-list"> 
							<li>hello</li>
						</ul> z`
						
					<?php Gelato_Scoop::the_navigation( ); ?>
					</aside> 

					<aside class="right-off-canvas-menu right-sidebar"> 
						
						<?php Gelato_Scoop::the_sidebar( ); ?>

						this is the sidebar
						
					</aside> 
					<section class="main-section"> 
						
						<?php Gelato_Scoop::the_content(); ?>
						<div id="main">
						more content goes here!
						</div>
					</section> 
					<a class="exit-off-canvas"></a> 
				</div> 
			</div>
		</div>