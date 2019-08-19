<?php if ( !defined('CPABC_AUTH_INCLUDE') ) { echo 'Direct access not allowed.'; exit; } ?>
<?php 
  $custom_styles = sanitize_textarea_field(base64_decode(get_option('CP_ABC_CSS', ''))); 
  if ($custom_styles != '')
      echo '<style type="text/css">'.$custom_styles.'</style>';  
?>
<form class="cpp_form" id="cp_abcform_pform" name="FormEdit" action="<?php get_site_url(); ?>" method="post" onsubmit="return doValidate(this);">
<input name="cpabc_appointments_post" type="hidden" value="1" /><input name="cpabc_appointments_utime" type="hidden"  value="" />
<?php 
   echo $quant_buffer; 
?>
<div <?php if (count($myrows) < 2) echo 'style="display:none"'; ?>>
  <?php _e("Calendar",'appointment-booking-calendar').":"; ?><br />
  <select name="cpabc_item" id="cpabc_item" onchange="cpabc_updateItem()"><?php echo $calendar_items; ?></select><br /><br />
</div>
<?php
  echo "<div class=\"abc_selectdate fields\"><label>".__("Select date and time",'appointment-booking-calendar').":</label></div>";
  if (isset($_GET["fl_builder"]) ) echo '<div style="border:1px dotted black;background-color:#ffffbb;padding:7px;">NOTE: <strong>The Appointment Calendar will be rendered here</strong>. Calendar is disabled while this visual editor is in use. Will appear again after closing edition.</div>';  
  foreach ($myrows as $item)
  {
      $atlang = cpabc_auto_language($item->calendar_language);
      echo '<div id="calarea_'.$item->id.'" style="display:none'.(is_rtl()?';float:right;':'').'"><input name="selDaycal'.$item->id.'" type="hidden" id="selDaycal'.$item->id.'" /><input name="selMonthcal'.$item->id.'" type="hidden" id="selMonthcal'.$item->id.'" /><input name="selYearcal'.$item->id.'" type="hidden" id="selYearcal'.$item->id.'" /><input name="selHourcal'.$item->id.'" type="hidden" id="selHourcal'.$item->id.'" /><input name="selMinutecal'.$item->id.'" type="hidden" id="selMinutecal'.$item->id.'" /><div class="appContainer"><div style="z-index:1000;" class="appContainer2"><div id="cal'.$item->id.'Container"></div></div></div> <div style="clear:both;"></div><div id="listcal'.$item->id.'"></div></div>';
  }
?>
<?php if (is_admin() && !defined('ABC_ELEMENTOR_EDIT_MODE') && @$_GET["action"] != 'edit') { ?>
  <fieldset style="border: 1px solid black; -webkit-border-radius: 8px; -moz-border-radius: 8px; border-radius: 8px; padding:15px;">
   <legend>Administrator options</legend>
    <input type="checkbox" name="sendemails_admin" value="1" vt="1" checked /> Send notification emails for this booking<br /><br />
    <style type="text/css">
      #repeat div { padding-top: 2px;  }
      #repeatList div { padding-top: 2px; padding-bottom: 2px; } 
    </style>
    <div id="repeat" style="display:none">
        <div>
            <label id="rl1">Repeats:</label>
            <select id="freq" name="freq">
                <option id="opt0" value="10">No</option>
                <option id="opt0" value="0">Daily</option>
                <option id="opt1" value="1">Every weekday (Monday to Friday)</option>
                <option id="opt2" value="2">Every Monday, Wednesday, and Friday</option>
                <option id="opt3" value="3">Every Tuesday, and Thursday</option>
                <option id="opt4" value="4">Weekly</option>
                <option id="opt5" value="5">Monthly</option>
                <option id="opt6" value="6">Yearly</option>
            </select>
        </div>
        <div id="repeatOptions" style="display:none">
            <div id="intervaldiv">
                <label id="rl2">Repeat every:</label>
                <select id="interval"></select> <span id="interval_label">weeks</span>
            </div>
            <div id="bydayweek">
                <label id="rl3">Repeat on:</label>
                <input id="bydaySU" class="bydayw" name="SU" type="checkbox"><span id="chk0">SU</span>
                <input id="bydayMO" class="bydayw" name="MO" type="checkbox"><span id="chk1">MO</span>
                <input id="bydayTU" class="bydayw" name="TU" type="checkbox"><span id="chk2">TU</span>
                <input id="bydayWE" class="bydayw" name="WE" type="checkbox"><span id="chk3">WE</span>
                <input id="bydayTH" class="bydayw" name="TH" type="checkbox"><span id="chk4">TH</span>
                <input id="bydayFR" class="bydayw" name="FR" type="checkbox"><span id="chk5">FR</span>
                <input id="bydaySA" class="bydayw" name="SA" type="checkbox"><span id="chk6">SA</span>
            </div>
            <div id="bydaymonth">
                <label id="rl4">Repeat by:</label>
                <input id="byday_m" class="bydaym" name="bydaym" type="radio" value="1" checked="checked"> <span id="bydaymonth1">day of the month</span>
                <input id="byday_w" class="bydaym" name="bydaym" type="radio" value="2"> <span id="bydaymonth2">day of the week</span>
            </div>
            <div class="clear"></div>
            <div>                
                <div class="fl">                    
                    <!--<div><input id="end_never" name="end" checked="" title="Ends never" type="radio"> <span id="end1">Never</span></div>-->
                    <div>Ends <input style="display:none" id="end_count" name="end" checked=""  title="Ends after a number of occurrences" type="radio"> <span id="end21">after</span> <select id="end_after" onchange="document.getElementById('end_count').checked=true;"></select> <span id="end22">occurrences</span> or <input style="display:none" id="end_until" name="end" title="Ends on a specified date" type="radio"> <span id="end3">on</span> <input size="10" id="end_until_input" value="" onchange="document.getElementById('end_until').checked=true;"></div>
                </div>
            </div>
            <div class="clear"></div>
            <div style="display:none">
                <label id="rl7">Summary:</label>
                <span id="summary"></span>
            </div>
            <div>
                <label id="rl5">Starts on</label>
                <label id="starts" style="font-weight:bold;"></label>
                <label id="rl5"> and repeated on:</label>
            </div>
        </div>
        <input type="hidden" id="format" value="FREQ=DAILY" size=55 />
        <div id="repeatList" style="margin-left:10px;"></div>
    </div>
    <br />
    * Note: Repeat / recurrent options are displayed after selecting a time-slot in the calendar.
  </fieldset> 
<?php } ?>
<div style="clear:both;"></div>
<?php _e('Your phone number','appointment-booking-calendar'); ?>:<br />
<input type="text" name="phone" value=""><br />
<?php _e('Your name','appointment-booking-calendar'); ?>:<br />
<input type="text" name="name" value="<?php /** if (isset($current_user->user_firstname)) echo $current_user->user_firstname." ".$current_user->user_lastname; */ ?>"><br />
<?php _e('Your email','appointment-booking-calendar'); ?>:<br />
<input type="email" name="email" value="<?php /** if (isset($current_user->user_email)) echo $current_user->user_email; */ ?>"><br />
<?php _e('Comments/Questions','appointment-booking-calendar'); ?>:<br />
<textarea name="question" style="width:100%"></textarea><br />
<?php if (!is_admin() && cpabc_get_option('dexcv_enable_captcha', CPABC_TDEAPP_DEFAULT_dexcv_enable_captcha) != 'false') { ?>
  <?php _e('Please enter the security code:','appointment-booking-calendar'); ?><br />
  <img src="<?php echo cpabc_appointment_get_site_url().'/?cpabc_app=captcha'.cpabc_get_captcha_params(); ?>"  id="captchaimg" alt="security code" border="0" class="skip-lazy"  />
  <br />
  <?php _e('Security Code:','appointment-booking-calendar'); ?><br />
  <div class="dfield">
  <input type="text" size="20" name="hdcaptcha" id="hdcaptcha" value="" />
  <div class="error message" id="hdcaptcha_error" generated="true" style="display:none;position: absolute; left: 0px; top: 25px;"></div>
  </div>
  <br />
<?php } ?>
<input type="submit" name="subbtn" class="cp_subbtn" value="<?php _e($button_label,'appointment-booking-calendar'); ?>">
</form>


