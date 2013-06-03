<!-- bottom section start -->
 <div class="bottom">
 	<div class="bottom_in clear">
 	<?php if(templ_is_footer_widgets_2colright()) {?>
          
           		 
           	 
           	 <div class="max_width left">
            	 <?php if (function_exists('dynamic_sidebar')){ dynamic_sidebar('footer1'); }?>
            </div> <!-- three_column #end -->
      
             <div class="min_width right">
            	<?php if (function_exists('dynamic_sidebar')){ dynamic_sidebar('footer2'); }?>
            </div> <!-- three_column #end -->
           
        <?php
 		}else if(templ_is_footer_widgets_2colleft())
		{?>
   	 
        	<div class="min_width left">
            	 <?php if (function_exists('dynamic_sidebar')){ dynamic_sidebar('footer1'); }?>
            </div> <!-- three_column #end -->
            
    	 <div class="max_width right">
            	 <?php if (function_exists('dynamic_sidebar')){ dynamic_sidebar('footer2'); }?>
            </div> <!-- three_column #end -->
          
 		<?php 
		}
		else if(templ_is_footer_widgets_eqlcol())
		{?> 
        
         		<div class="equal_column left">
            	<?php if (function_exists('dynamic_sidebar')){ dynamic_sidebar('footer1'); }?>
                </div> <!-- three_column #end -->
                  
                <div class="equal_column right">
                    <?php if (function_exists('dynamic_sidebar')){ dynamic_sidebar('footer2'); }?>
                </div> <!-- three_column #end -->
            
        <?php 			
		}else if(templ_is_footer_widgets_3col())
		{?> 
              	<div class="three_column left">
            	<?php if (function_exists('dynamic_sidebar')){ dynamic_sidebar('footer1'); }?>
                </div> <!-- three_column #end -->
                 
                <div class="three_column spacer_3col left">
                    <?php if (function_exists('dynamic_sidebar')){ dynamic_sidebar('footer2'); }?>
                </div> <!-- three_column #end -->
                
                <div class="three_column right">
                    <?php if (function_exists('dynamic_sidebar')){ dynamic_sidebar('footer3'); }?>
                </div> <!-- three_column #end -->
         	 
		<?php
  		}else if(templ_is_footer_widgets_4col())
		{?> 
    	  
            <div class="fourth_column left">
            	<?php if (function_exists('dynamic_sidebar')){ dynamic_sidebar('footer1'); }?>
            </div> <!-- three_column #end -->
            
            
            <div class="fourth_column spacer_4col left">
            	<?php if (function_exists('dynamic_sidebar')){ dynamic_sidebar('footer2'); }?>
            </div> <!-- three_column #end -->
            
            <div class="fourth_column spacer_4col left">
            	<?php if (function_exists('dynamic_sidebar')){ dynamic_sidebar('footer3'); }?>
            </div> <!-- three_column #end -->
           
             <div class="fourth_column right">
            	<?php if (function_exists('dynamic_sidebar')){ dynamic_sidebar('footer4'); }?>
            </div> <!-- three_column #end -->
           </div>
        <?php	
 		}else if(templ_is_footer_widgets_fullwidth())
		{?> 
      
            	<?php if (function_exists('dynamic_sidebar')){ dynamic_sidebar('footer1'); }?>
         	
        <?php }?>
        
        
         </div> <!-- bottom in #end -->
         
         <?php templ_before_footer(); // content end hooks?>
 <div class="footer">
  <div class="footer_in">
  
  		<?php if (function_exists('dynamic_sidebar') && dynamic_sidebar('footer_nav')){?><?php } else {?>  <?php }?> 
  			
    <p class="copyright">&copy; <?php the_time('Y'); ?> <a href="<?php get_bloginfo('url'); ?>">
      <?php get_bloginfo('name'); ?>
      </a>. <?php echo RIGHTS_TEXT;?> </p>
    <p class="credits"><?php echo DESIGNED_TEXT;?> <a class="footer-logo" href="http://templatic.com" title="Premium wordpress themes"><?php echo TEMPLATIC_TEXT;?></a></p>
  </div>
</div> <!-- footer #end -->
<?php templ_after_footer(); // content end hooks?>
         
          </div> <!-- bottom #end -->
 <!-- bottom section #end  -->