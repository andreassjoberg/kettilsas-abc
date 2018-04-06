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
<?php echo $quant_buffer; ?>
<div <?php if (count($myrows) < 2) echo 'style="display:none"'; ?>>
  <?php _e("Calendar",'cpabc').":"; ?><br />
  <select name="cpabc_item" id="cpabc_item" onchange="cpabc_updateItem()"><?php echo $calendar_items; ?></select><br /><br />
</div>
<?php
  _e("Select date and time",'cpabc').":";
  foreach ($myrows as $item)
      echo '<div id="calarea_'.$item->id.'" style="display:none"><input name="selDaycal'.$item->id.'" type="hidden" id="selDaycal'.$item->id.'" /><input name="selMonthcal'.$item->id.'" type="hidden" id="selMonthcal'.$item->id.'" /><input name="selYearcal'.$item->id.'" type="hidden" id="selYearcal'.$item->id.'" /><input name="selHourcal'.$item->id.'" type="hidden" id="selHourcal'.$item->id.'" /><input name="selMinutecal'.$item->id.'" type="hidden" id="selMinutecal'.$item->id.'" /><div class="appContainer"><div style="z-index:1000;" class="appContainer2"><div id="cal'.$item->id.'Container"></div></div></div> <div style="clear:both;"></div><div id="listcal'.$item->id.'"></div></div>';
?>
<br />
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
  <img src="<?php echo cpabc_appointment_get_site_url().'/?cpabc_app=captcha&inAdmin=1&width='.cpabc_get_option('dexcv_width', CPABC_TDEAPP_DEFAULT_dexcv_width).'&height='.cpabc_get_option('dexcv_height', CPABC_TDEAPP_DEFAULT_dexcv_height).'&letter_count='.cpabc_get_option('dexcv_chars', CPABC_TDEAPP_DEFAULT_dexcv_chars).'&min_size='.cpabc_get_option('dexcv_min_font_size', CPABC_TDEAPP_DEFAULT_dexcv_min_font_size).'&max_size='.cpabc_get_option('dexcv_max_font_size', CPABC_TDEAPP_DEFAULT_dexcv_max_font_size).'&noise='.cpabc_get_option('dexcv_noise', CPABC_TDEAPP_DEFAULT_dexcv_noise).'&noiselength='.cpabc_get_option('dexcv_noise_length', CPABC_TDEAPP_DEFAULT_dexcv_noise_length).'&bcolor='.cpabc_get_option('dexcv_background', CPABC_TDEAPP_DEFAULT_dexcv_background).'&border='.cpabc_get_option('dexcv_border', CPABC_TDEAPP_DEFAULT_dexcv_border).'&font='.cpabc_get_option('dexcv_font', CPABC_TDEAPP_DEFAULT_dexcv_font); ?>"  id="captchaimg" alt="security code" border="0"  />
  <br />
  <?php _e('Security Code (lowercase letters):','cpabc'); ?><br />
  <div class="dfield">
  <input type="text" size="20" name="hdcaptcha" id="hdcaptcha" value="" />
  <div class="error message" id="hdcaptcha_error" generated="true" style="display:none;position: absolute; left: 0px; top: 25px;"></div>
  </div>
  <br />
<?php } ?>
<input type="submit" name="subbtn" class="cp_subbtn" value="<?php _e($button_label,'cpabc'); ?>">
</form>


