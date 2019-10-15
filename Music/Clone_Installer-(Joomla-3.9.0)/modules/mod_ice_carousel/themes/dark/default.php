<?php
/**
 * IceAccordion Extension for Joomla 3.0 By IceTheme
 * 
 * 
 * @copyright	Copyright (C) 2008 - 2012 IceTheme.com. All rights reserved.
 * @license		GNU General Public License version 2
 * 
 * @Website 	http://www.icetheme.com/Joomla-Extensions/iceaccordion.html
 * @Support 	http://www.icetheme.com/Forums/IceCarousel/
 *
 */
 

/* no direct access*/
defined('_JEXEC') or die;
?>
<div id="icecarousel<?php echo $module->id;?>" class="icecarousel carousel slide <?php echo $effect ;?>">
        <div class="carousel-inner">
			<?php
				foreach($list as $key=>$item){
					$activeclass = "";
					if($key == 0){
						$activeclass = "active";
					}
					?>
					<div class="item <?php echo $activeclass; ?>">
						<a href="<?php echo $item->link; ?>">  	
						<?php if($item->mainImage): ?>
							<?php echo $item->mainImage; ?>
						<?php endif; ?>
						</a>
						<?php if($params->get("display_caption", 1)): ?>	
						
							<div class="carousel-caption">
							
							  <h4>
							  <?php if ($params->get('link_titles') == 1) : ?>
								<a class="mod-ice-carosuel-title" href="<?php echo $item->link; ?>">
								<?php echo $item->title; ?></a>
							  <?php
								else:
									echo $item->title;
								endif;
							  ?>
							  </h4>
							  
								  <div class="mod-ice-carousel-description">

										<p><?php echo $item->displayIntrotext; ?></p>

								  </div>
								
							  <?php if ($params->get('show_readmore')) :?>
								<p class="mod-articles-category-readmore">
									<a class="mod-articles-category-title" href="<?php echo $item->link; ?>">
									<?php 
											echo JText::_('MOD_CAROSUEL_READ_MORE');
									?>
								</a>
								</p>
								
							  <?php endif; ?>
							  
							</div>
							
						<?php	endif; ?>
						
					  </div>
					<?php
				}
			?>
        </div><!-- .carousel-inner -->
		<?php if($params->get("display_arrows", 1)): ?>
			<!--  next and previous controls here
				  href values must reference the id for this carousel -->
			  <a class="carousel-control left" href="#icecarousel<?php echo $module->id;?>" data-slide="prev">&lsaquo;</a>
			  <a class="carousel-control right" href="#icecarousel<?php echo $module->id;?>" data-slide="next">&rsaquo;</a>
		<?php endif; ?>
</div><!-- .carousel -->
<!-- end carousel -->
