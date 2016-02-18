<?php 
$is_headright_content = is_string( get_theme_mod('tesseract_header_right_content') );
$headright_content = ( $is_headright_content ) ? get_theme_mod('tesseract_header_right_content') : 'no-right-content';
$headright_content_default_button = get_theme_mod('tesseract_header_content_if_button');
$wc_headercart = ( get_theme_mod('tesseract_woocommerce_headercart') == 1 ) ? true : false;

?>



<?php if ( $is_headright_content ) : ?>            

	                  
			
<?php elseif ( !$is_headright_content && $headright_content_default_button ) : ?>            

 
		
<?php else : ?>
	  
    
		
<?php endif; ?>   

	<?php if ( is_plugin_active('woocommerce/woocommerce.php') && $wc_headercart ) tesseract_wc_output_cart(); ?> 

</div>