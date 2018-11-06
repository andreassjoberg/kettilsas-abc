<?php if ( !defined('CPABC_AUTH_INCLUDE') ) { echo 'Direct access not allowed.'; exit; } ?>
<?php 
  $custom_styles = base64_decode(get_option('CP_ABC_CSS', '')); 
  if ($custom_styles != '')
      echo '<style type="text/css">'.$custom_styles.'</style>';
  $custom_scripts = base64_decode(get_option('CP_ABC_JS', '')); 
  if ($custom_scripts != '')
      echo '<script type="text/javascript">'.$custom_scripts.'</script>';  
?>
<form class="cpp_form" name="FormEdit" action="<?php get_site_url(); ?>" method="post" onsubmit="return doValidate(this);">
<input name="cpabc_appointments_post" type="hidden" value="1" /><input name="cpabc_appointments_utime" type="hidden"  value="" />
<?php 
   echo $quant_buffer; 
   if (isset($_GET["fl_builder"])) echo '<div style="border:1px dotted black;background-color:#ffffbb;padding:7px;">NOTE: Calendar is disabled while the Beaver Page Builder is in use. Will appear again after closing the Beaver edition option.</div>';
?>
<div <?php if (count($myrows) < 2) echo 'style="display:none"'; ?>>
  <?php _e("Calendar",'cpabc').":"; ?><br />
  <select name="cpabc_item" id="cpabc_item" onchange="cpabc_updateItem()"><?php echo $calendar_items; ?></select><br /><br />
</div>
<?php
  echo "<div class=\"abc_selectdate fields\"><label>".__("Select date and time",'cpabc').":</label></div>";
  foreach ($myrows as $item)
  {
      $atlang = cpabc_auto_language($item->calendar_language);
      echo '<div id="calarea_'.$item->id.'" style="display:none'.(is_rtl()?';float:right;':'').'"><input name="selDaycal'.$item->id.'" type="hidden" id="selDaycal'.$item->id.'" /><input name="selMonthcal'.$item->id.'" type="hidden" id="selMonthcal'.$item->id.'" /><input name="selYearcal'.$item->id.'" type="hidden" id="selYearcal'.$item->id.'" /><input name="selHourcal'.$item->id.'" type="hidden" id="selHourcal'.$item->id.'" /><input name="selMinutecal'.$item->id.'" type="hidden" id="selMinutecal'.$item->id.'" /><div class="appContainer"><div style="z-index:1000;" class="appContainer2"><div id="cal'.$item->id.'Container"></div></div></div> <div style="clear:both;"></div><div id="listcal'.$item->id.'"></div></div>';
  }
?>
<div style="clear:both;"></div>
<?php _e('Your phone number','cpabc'); ?>:<br />
<input type="text" name="phone" value=""><br />
<?php _e('Your name','cpabc'); ?>:<br />
<input type="text" name="name" value="<?php /** if (isset($current_user->user_firstname)) echo $current_user->user_firstname." ".$current_user->user_lastname; */ ?>"><br />
<?php _e('Your email','cpabc'); ?>:<br />
<input type="email" name="email" value="<?php /** if (isset($current_user->user_email)) echo $current_user->user_email; */ ?>"><br />
<?php _e('Comments/Questions','cpabc'); ?>:<br />
<textarea name="question" style="width:100%"></textarea><br />
<?php if (cpabc_get_option('dexcv_enable_captcha', CPABC_TDEAPP_DEFAULT_dexcv_enable_captcha) != 'false') { ?>
  <?php _e('Please enter the security code:','cpabc'); ?><br />
  <img src="<?php echo cpabc_appointment_get_site_url().'/?cpabc_app=captcha'.cpabc_get_captcha_params(); ?>"  id="captchaimg" alt="security code" border="0"  />
  <br />
  <?php _e('Security Code:','cpabc'); ?><br />
  <div class="dfield">
  <input type="text" size="20" name="hdcaptcha" id="hdcaptcha" value="" />
  <div class="error message" id="hdcaptcha_error" generated="true" style="display:none;position: absolute; left: 0px; top: 25px;"></div>
  </div>
  <br />
<?php } ?>
<input type="submit" name="subbtn" class="cp_subbtn" value="<?php _e($button_label,'cpabc'); ?>">
</form>


