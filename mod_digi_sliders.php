<?php
//no direct access
defined('_JEXEC') or die('Direct Access to this location is not allowed.');

// Path assignments
$document =& JFactory::getDocument();
$modURL = JURI::base().'modules/mod_digi_sliders';

// get parameters from the module's configuration
$jQuery = $params->get('jQuery','1');
$text = $params->get('content','');
$ishidden = $params->get('ishidden','0');
$direction = $params->get('direction','1');
$direction == 1 ? $defimg = "packet.png" : $defimg = "packet_right.png";
$imagename = $params->get('imagename', $defimg);
$imagetext = $params->get('imagetext', '');
$width = $params->get('width','');
$height = $params->get('height','');
$fadeout = $params->get('fadeout','1500');
$fadein = $params->get('fadein','500');
$top = $params->get('top','0');
$module_class =  $params->get('moduleclass_sfx');

if($imagename == "packet.png" || $imagename== "packet_right.png"){
	$imgpath = $modURL.'/images/';
}else{
	$imgpath = '';
}

if ($jQuery == '1') { 
$document->addScript($modURL.'/js/jquery-1.11.1.min.js', 'text/javascript');
} 
//required for sliding effect
$ishidden == 1 ? $document->addScript($modURL.'/js/jquery-ui.min.js', 'text/javascript') : "";
$ishidden == 1 ? $css_box_image  = "display:none;" : $css_box_image  = "" ;

//script config
$direction == 1 ? $scriptdir = "left" : $scriptdir = "right"; 

if(isset( $module_class )){
	$css_holderclass = ".".htmlspecialchars($module_class)."";
}else{
	$css_holderclass = "";
}

//create the css
if($direction == 1){
$poswidth = $width + 1; // padding - margin - border
$csscode = ' 
	'.$css_holderclass.' .box_slide { left: -'.$poswidth.'px; width:'.$width.'px; height:'.$height.'px; top: '.$top.'px; }
	.box_slide .box_image { right: -34px; '.$css_box_image.'}
	.box_image div{ right:-34px; top:34px; transform:rotate(270deg); -ms-transform: rotate(270deg); -webkit-transform: rotate(270deg);-moz-transform: rotate(270deg);-o-transform: rotate(270deg); color:white;   }
';
}else{
$poswidth = $width + 1; // padding - margin - border
$csscode = ' 
	'.$css_holderclass.' .box_slide { right: -'.$poswidth.'px; width:'.$width.'px; height:'.$height.'px; top: '.$top.'px;  }
	.box_slide .box_image { left: -34px; '.$css_box_image.' }
	.box_image div{ left:-34px; top:34px;  transform:rotate(270deg); -ms-transform:rotate(270deg); -webkit-transform: rotate(270deg);-moz-transform: rotate(270deg);-o-transform: rotate(270deg); color:white;	}
';
}

//add sliders css
$document->addStyleSheet($modURL.'/css/sliders.css');
$document->addStyleDeclaration($csscode, 'text/css');
?>
<script type="text/javascript">
jQuery.noConflict();
<?php
if($ishidden == 1){
?>
jQuery(window).load(function($) {					
	setTimeout( 'jQuery("<?php echo $css_holderclass; ?> .box_slide .box_image").show("slide", { direction: "<?php echo $scriptdir; ?>" }, 1000)' , <?php echo $fadeout; ?>);

});
<?php
}
?>
jQuery(function (){

jQuery("<?php echo $css_holderclass; ?> .box_slide").hover(function(){ 

	jQuery(this).stop(true,false).animate({<?php echo $scriptdir; ?>:  -1},  <?php echo $fadeout; ?>); },function(){ 

		jQuery("<?php echo $css_holderclass; ?> .box_slide").stop(true,false).animate({<?php echo $scriptdir; ?>: -<?php echo $poswidth; ?>},  <?php echo $fadein; ?>);

	});
});
</script>
<div class="box_slide_holder <?php echo htmlspecialchars($module_class); ?>">
    <div class="box_slide border">
    	<div class="box_image">
        <img src="<?php echo $imgpath.$imagename; ?>" alt="<?php echo $imagetext; ?>" />
        	<div>
            	<span> <?php echo $imagetext; ?> </span>
            </div>
        </div>
        <div class="box_text"><?php echo $text; ?></div>
    </div>
</div>
