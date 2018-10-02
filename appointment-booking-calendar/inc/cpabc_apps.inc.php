<?php


if ( ! defined( 'ABSPATH' ) ) 
{
    echo 'Direct access not allowed.';
    exit;
}

function _cpabc_appointments_install() {
    global $wpdb;

    $charset_collate = $wpdb->get_charset_collate();
    
    $table_name = $wpdb->prefix . CPABC_APPOINTMENTS_TABLE_NAME_NO_PREFIX;

    $sql = "CREATE TABLE ".$wpdb->prefix.CPABC_APPOINTMENTS_DISCOUNT_CODES_TABLE_NAME_NO_PREFIX." (
         id mediumint(9) NOT NULL AUTO_INCREMENT,
         cal_id mediumint(9) NOT NULL DEFAULT 1,
         code VARCHAR(250) DEFAULT '' NOT NULL,
         discount VARCHAR(250) DEFAULT '' NOT NULL,
         expires datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
         availability int(10) unsigned NOT NULL DEFAULT 0,
         used int(10) unsigned NOT NULL DEFAULT 0,
         UNIQUE KEY id (id)
         ) ".$charset_collate.";";
    $wpdb->query($sql);

    $sql = "CREATE TABLE $table_name (
         id mediumint(9) NOT NULL AUTO_INCREMENT,
         time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
         booked_time VARCHAR(250) DEFAULT '' NOT NULL,
         booked_time_unformatted VARCHAR(250) DEFAULT '' NOT NULL,
         name VARCHAR(250) DEFAULT '' NOT NULL,
         email VARCHAR(250) DEFAULT '' NOT NULL,
         phone VARCHAR(250) DEFAULT '' NOT NULL,
         question mediumtext,
         quantity VARCHAR(30) DEFAULT '1' NOT NULL,
         buffered_date text,
         UNIQUE KEY id (id)
         ) ".$charset_collate.";";
    $wpdb->query($sql);
    $sql = "ALTER TABLE  $table_name ADD `calendar` INT NOT NULL AFTER  `id`;";
    $wpdb->query($sql);

    $sql = "CREATE TABLE `".$wpdb->prefix.CPABC_APPOINTMENTS_CONFIG_TABLE_NAME."` (`".CPABC_TDEAPP_CONFIG_ID."` int(10) unsigned NOT NULL auto_increment, `".CPABC_TDEAPP_CONFIG_TITLE."` varchar(255) NOT NULL default '',`".CPABC_TDEAPP_CONFIG_USER."` varchar(100) default NULL,`".CPABC_TDEAPP_CONFIG_PASS."` varchar(100) default NULL,`".CPABC_TDEAPP_CONFIG_LANG."` varchar(5) default NULL,`".CPABC_TDEAPP_CONFIG_CPAGES."` tinyint(3) unsigned default NULL,`".CPABC_TDEAPP_CONFIG_TYPE."` tinyint(3) unsigned default NULL,`".CPABC_TDEAPP_CONFIG_MSG."` varchar(255) NOT NULL default '',`".CPABC_TDEAPP_CONFIG_WORKINGDATES."` varchar(255) NOT NULL default '',`".CPABC_TDEAPP_CONFIG_RESTRICTEDDATES."` text,`".CPABC_TDEAPP_CONFIG_TIMEWORKINGDATES0."` text,`".CPABC_TDEAPP_CONFIG_TIMEWORKINGDATES1."` text,`".CPABC_TDEAPP_CONFIG_TIMEWORKINGDATES2."` text,`".CPABC_TDEAPP_CONFIG_TIMEWORKINGDATES3."` text,`".CPABC_TDEAPP_CONFIG_TIMEWORKINGDATES4."` text,`".CPABC_TDEAPP_CONFIG_TIMEWORKINGDATES5."` text,`".CPABC_TDEAPP_CONFIG_TIMEWORKINGDATES6."` text,`".CPABC_TDEAPP_CALDELETED_FIELD."` tinyint(3) unsigned default NULL,PRIMARY KEY (`".CPABC_TDEAPP_CONFIG_ID."`)) ".$charset_collate."; ";
    $wpdb->query($sql);
    $sql = "ALTER TABLE  `".$wpdb->prefix.CPABC_APPOINTMENTS_CONFIG_TABLE_NAME."` ADD (".
    "`conwer` INT NOT NULL, ".
    "`form_structure` mediumtext, ".
    "`specialDates` mediumtext, ".
    "`vs_use_validation` VARCHAR(20) DEFAULT '' NOT NULL, ".
    "`vs_text_is_required` VARCHAR(250) DEFAULT '' NOT NULL, ".
    "`vs_text_is_email` VARCHAR(250) DEFAULT '' NOT NULL, ".
    "`vs_text_datemmddyyyy` VARCHAR(250) DEFAULT '' NOT NULL, ".
    "`vs_text_dateddmmyyyy` VARCHAR(250) DEFAULT '' NOT NULL, ".
    "`vs_text_number` VARCHAR(250) DEFAULT '' NOT NULL, ".
    "`vs_text_digits` VARCHAR(250) DEFAULT '' NOT NULL, ".
    "`vs_text_max` VARCHAR(250) DEFAULT '' NOT NULL, ".
    "`vs_text_min` VARCHAR(250) DEFAULT '' NOT NULL, ".
    "`vs_text_submitbtn` VARCHAR(250) DEFAULT '' NOT NULL, ".    
    "`calendar_language` text, ".
    "`calendar_dateformat` text, ".
    "`calendar_pages` text, ".
    "`calendar_militarytime` text, ".
    "`calendar_weekday` text, ".
    "`calendar_mindate` text, ".
    "`calendar_maxdate` text, ".
    "`calendar_startmonth` VARCHAR(20) DEFAULT '' NOT NULL, ".
    "`calendar_startyear` VARCHAR(20) DEFAULT '' NOT NULL, ".
    "`calendar_theme` text, ".
    "`min_slots` VARCHAR(10) DEFAULT '' NOT NULL, ".
    "`max_slots` VARCHAR(10) DEFAULT '' NOT NULL, ".
    "`close_fpanel` VARCHAR(10) DEFAULT '' NOT NULL, ".
    "`quantity_field` VARCHAR(10) DEFAULT '' NOT NULL, ".
    "`paypal_mode` VARCHAR(20) DEFAULT '' NOT NULL, ".
    "`enable_paypal` text, ".
    "`paypal_email` text, ".
    "`request_cost` text, ".
    "`paypal_product_name` text, ".
    "`currency` text, ".
    "`url_ok` text, ".
    "`url_cancel` text, ".
    "`paypal_language` text, ".
    "`cu_user_email_field` VARCHAR(250) DEFAULT '' NOT NULL, ".
    "`notification_from_email` text, ".
    "`notification_destination_email` text, ".
    "`email_subject_confirmation_to_user` text, ".
    "`email_confirmation_to_user` text, ".
    "`email_subject_notification_to_admin` text, ".
    "`email_notification_to_admin` text, ".
    "`enable_reminder` text, ".
    "`reminder_hours` text, ".
    "`reminder_subject` text, ".
    "`reminder_content` text, ".
    "`dexcv_enable_captcha` text, ".
    "`dexcv_width` text, ".
    "`dexcv_height` text, ".
    "`dexcv_chars` text, ".
    "`dexcv_min_font_size` text, ".
    "`dexcv_max_font_size` text, ".
    "`dexcv_noise` text, ".
    "`dexcv_noise_length` text, ".
    "`dexcv_background` text, ".
    "`dexcv_border` text, ".
    "`dexcv_font` text, ".
    "`cv_text_enter_valid_captcha` VARCHAR(250) DEFAULT '' NOT NULL, ".
    "`cp_cal_checkboxes` text, ".
    "`nuser_emailformat` text, ".
    "`nadmin_emailformat` text, ".
    "`nremind_emailformat` text".
    ")";

    $wpdb->query($sql);

    $sql = "CREATE TABLE `".$wpdb->prefix.CPABC_APPOINTMENTS_CALENDARS_TABLE_NAME_NO_PREFIX."` (`".CPABC_TDEAPP_DATA_ID."` int(10) unsigned NOT NULL auto_increment,`".CPABC_TDEAPP_DATA_IDCALENDAR."` int(10) unsigned default NULL,`".CPABC_TDEAPP_DATA_DATETIME."`datetime NOT NULL default '0000-00-00 00:00:00',`".CPABC_TDEAPP_DATA_TITLE."` varchar(250) default NULL,`".CPABC_TDEAPP_DATA_DESCRIPTION."` mediumtext,PRIMARY KEY (`".CPABC_TDEAPP_DATA_ID."`)) ".$charset_collate.";";
    $wpdb->query($sql);

    // code for updates  
    $sql = "ALTER TABLE  `".$wpdb->prefix.CPABC_APPOINTMENTS_CALENDARS_TABLE_NAME_NO_PREFIX."` ADD `description_customer` text DEFAULT '' NOT NULL;"; $wpdb->query($sql);
    $sql = "ALTER TABLE  `".$wpdb->prefix.CPABC_APPOINTMENTS_CALENDARS_TABLE_NAME_NO_PREFIX."` ADD `reminder` VARCHAR(1) DEFAULT '' NOT NULL;"; $wpdb->query($sql);
    $sql = "ALTER TABLE  `".$wpdb->prefix.CPABC_APPOINTMENTS_CALENDARS_TABLE_NAME_NO_PREFIX."` ADD `reference` VARCHAR(20) DEFAULT '' NOT NULL;"; $wpdb->query($sql);
    $sql = "ALTER TABLE  `".$wpdb->prefix.CPABC_APPOINTMENTS_CALENDARS_TABLE_NAME_NO_PREFIX."` ADD `quantity` VARCHAR(25) DEFAULT '1' NOT NULL;"; $wpdb->query($sql);

    $sql = 'INSERT INTO `'.$wpdb->prefix.CPABC_APPOINTMENTS_CONFIG_TABLE_NAME.'` (conwer,`form_structure`,`'.CPABC_TDEAPP_CONFIG_ID.'`,`'.CPABC_TDEAPP_CONFIG_TITLE.'`,`'.CPABC_TDEAPP_CONFIG_USER.'`,`'.CPABC_TDEAPP_CONFIG_PASS.'`,`'.CPABC_TDEAPP_CONFIG_LANG.'`,`'.CPABC_TDEAPP_CONFIG_CPAGES.'`,`'.CPABC_TDEAPP_CONFIG_TYPE.'`,`'.CPABC_TDEAPP_CONFIG_MSG.'`,`'.CPABC_TDEAPP_CONFIG_WORKINGDATES.'`,`'.CPABC_TDEAPP_CONFIG_RESTRICTEDDATES.'`,`'.CPABC_TDEAPP_CONFIG_TIMEWORKINGDATES0.'`,`'.CPABC_TDEAPP_CONFIG_TIMEWORKINGDATES1.'`,`'.CPABC_TDEAPP_CONFIG_TIMEWORKINGDATES2.'`,`'.CPABC_TDEAPP_CONFIG_TIMEWORKINGDATES3.'`,`'.CPABC_TDEAPP_CONFIG_TIMEWORKINGDATES4.'`,`'.CPABC_TDEAPP_CONFIG_TIMEWORKINGDATES5.'`,`'.CPABC_TDEAPP_CONFIG_TIMEWORKINGDATES6.'`,`'.CPABC_TDEAPP_CALDELETED_FIELD.'`) '.
                                                                                ' VALUES(0,"'.esc_sql(CPABC_APPOINTMENTS_DEFAULT_form_structure).'","1","cal1","Calendar Item 1","","-","1","3","Please, select your appointment.","1,2,3,4,5","","","9:0,10:0,11:0,12:0,13:0,14:0,15:0,16:0","9:0,10:0,11:0,12:0,13:0,14:0,15:0,16:0","9:0,10:0,11:0,12:0,13:0,14:0,15:0,16:0","9:0,10:0,11:0,12:0,13:0,14:0,15:0,16:0","9:0,10:0,11:0,12:0,13:0,14:0,15:0,16:0","","0");';
    $wpdb->query($sql);

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

}



/* Filter for placing the maps into the contents */
function cpabc_appointments_filter_content($atts) {
    global $wpdb;
    extract( shortcode_atts( array(
		'calendar' => '',
		'user' => '',
	), $atts ) );
    if ($calendar != '')
        define ('CPABC_CALENDAR_FIXED_ID',intval($calendar));
    else if ($user != '')
    {
        $users = $wpdb->get_results( "SELECT user_login,ID FROM ".$wpdb->users." WHERE user_login='".esc_sql($user)."'" );
        if (isset($users[0]))
            define ('CPABC_CALENDAR_USER',$users[0]->ID);
        else
            define ('CPABC_CALENDAR_USER',0);
    }
    else
        define ('CPABC_CALENDAR_USER',0);
    ob_start();
    cpabc_appointments_get_public_form();
    $buffered_contents = ob_get_contents();
    ob_end_clean();
    return $buffered_contents;
}


function cpabc_appointments_filter_edit($atts) {
    global $wpdb;
    extract( shortcode_atts( array(
		'calendar' => '',
		'user' => '',
	), $atts ) );
	$buffered_contents = '';
	$current_user = wp_get_current_user();
	$myrows = $wpdb->get_results( "SELECT * FROM ".CPABC_APPOINTMENTS_CONFIG_TABLE_NAME." where conwer<>'' AND conwer='".esc_sql($current_user->ID )."'" );
    if (count($myrows))
    {
        if (!defined('CP_CALENDAR_ID'))
            define ('CP_CALENDAR_ID',$myrows[0]->id);
        define ('CPABC_CALENDAR_ON_PUBLIC_WEBSITE',true);
        ob_start();
        @include_once dirname( __FILE__ ) . '/cpabc_appointments_admin_int.inc.php';
        $buffered_contents = ob_get_contents();
        ob_end_clean();
    }
    return $buffered_contents;
}


function cpabc_appointments_filter_list($atts) {
    global $wpdb;
    extract( shortcode_atts( array(
		'calendar' => '',
		'user' => '',
		'group' => 'no',
		'fields' => 'DATE,TIME,NAME',
		'from' => "today",
		'to' => "today +90 days",
	), $atts ) );

	$from = date("Y-m-d 00:00:00", strtotime($from));
	$to = date("Y-m-d 23:59:59", strtotime($to));
	$group = strtolower($group);

    if ($calendar != '')
        define ('CPABC_CALENDAR_FIXED_ID', intval($calendar));
    else if ($user != '')
    {
        $users = $wpdb->get_results( "SELECT user_login,ID FROM ".$wpdb->users." WHERE user_login='".esc_sql($user)."'" );
        if (isset($users[0]))
            define ('CPABC_CALENDAR_USER',$users[0]->ID);
        else
            define ('CPABC_CALENDAR_USER',0);
    }
    else
        define ('CPABC_CALENDAR_USER',0);

    if (defined('CPABC_CALENDAR_USER') && CPABC_CALENDAR_USER != 0)
        $myrows = $wpdb->get_results( "SELECT * FROM ".CPABC_APPOINTMENTS_CONFIG_TABLE_NAME." WHERE conwer=".CPABC_CALENDAR_USER." AND caldeleted=0" );
    else if (defined('CPABC_CALENDAR_FIXED_ID'))
        $myrows = $wpdb->get_results( "SELECT * FROM ".CPABC_APPOINTMENTS_CONFIG_TABLE_NAME." WHERE id=".CPABC_CALENDAR_FIXED_ID." AND caldeleted=0" );
    else
        $myrows = $wpdb->get_results( "SELECT * FROM ".CPABC_APPOINTMENTS_CONFIG_TABLE_NAME." WHERE caldeleted=0" );

    if (!defined('CP_CALENDAR_ID')) define ('CP_CALENDAR_ID',$myrows[0]->id);

    ob_start();
    echo '<link rel="stylesheet" type="text/css" href="'.plugins_url('../TDE_AppCalendar/'.cpabc_get_option('calendar_theme','').'all-css.css', __FILE__).'" />';
    $fields = explode(",",$fields);
    $last_date = '';
    $mycalendarrows = $wpdb->get_results( "SELECT * FROM ".CPABC_TDEAPP_CALENDAR_DATA_TABLE ." INNER JOIN  ".CPABC_APPOINTMENTS_TABLE_NAME." on  ".CPABC_APPOINTMENTS_TABLE_NAME.".id=".CPABC_TDEAPP_CALENDAR_DATA_TABLE.".reference WHERE datatime>='".$from."' AND datatime<='".$to."' AND appointment_calendar_id=".CP_CALENDAR_ID." ORDER BY datatime ASC");
    for($f=0; $f<count($mycalendarrows); $f++) {
        $params = unserialize($mycalendarrows[$f]->buffered_date);
        $params["CALENDAR"] = $mycalendarrows[$f]->appointment_calendar_id;
        $newline = ($last_date != $mycalendarrows[$f]->booked_time_unformatted);
        if ($group != 'yes' || $newline)
        {
            echo '<div class="cpabc_field_clear"></div>';
        }
        for ($k=0; $k < count($fields); $k++)
        {
            $fieldname = trim($fields[$k]);
            if ($group == 'yes')
            {
                if ($newline || ($fieldname != "DATE" && $fieldname != "TIME"))
                {
                    echo '<div class="cpabc_field_'.$k.'">';
                    echo (@$params[$fieldname]);
                    if ($fieldname != "DATE" && $fieldname != "TIME")
                    {
                        while ($f<count($mycalendarrows) && @$mycalendarrows[$f+1]->booked_time_unformatted == @$mycalendarrows[$f]->booked_time_unformatted)
                        {
                            $f++;
                            $params = unserialize($mycalendarrows[$f]->buffered_date);
                            echo ", ".@$params[$fieldname];
                        }
                        $k = count($fields);
                    }
                    echo '</div>';
                }
            }
            else
                echo '<div class="cpabc_field_'.$k.'">'.(@$params[$fieldname]).'</div>';
        }
        $last_date = $mycalendarrows[$f]->booked_time_unformatted;
    }
    echo '<div class="cpabc_field_clear"></div>';
    $buffered_contents = ob_get_contents();
    ob_end_clean();
    return $buffered_contents;
}



function cpabc_appointments_get_public_form() {

    global $wpdb;

    $myrows = $wpdb->get_results( "SELECT * FROM ".CPABC_APPOINTMENTS_CONFIG_TABLE_NAME." WHERE id=1" );

    define ('CP_CALENDAR_ID',1);

    $button_label = cpabc_get_option('vs_text_submitbtn', 'Continue');
    $button_label = ($button_label==''?'Continue':$button_label);

    $previous_label = __("Previous",'cpabc');
    $next_label = __("Next",'cpabc');

    wp_enqueue_script( 'jquery' );

    $calendar_items = '';
    foreach ($myrows as $item)
      $calendar_items .=  '<option value='.$item->id.'>'.$item->uname.'</option>';

    $cpabc_buffer = "";
    $services = array();


    $codes = $wpdb->get_results( 'SELECT * FROM '.CPABC_APPOINTMENTS_DISCOUNT_CODES_TABLE_NAME.' WHERE `cal_id`='.CP_CALENDAR_ID);

    $quant_buffer = '';
    if (CPABC_APPOINTMENTS_ENABLE_QUANTITY_FIELD)
    {
        $quant_buffer = __('Quantity','cpabc').':<br /><select id="abc_capacity" name="abc_capacity" onchange="apc_clear_date();">';
        for ($i=1; $i<=CPABC_APPOINTMENTS_ENABLE_QUANTITY_FIELD; $i++)
            $quant_buffer .= '<option'.($i==1?' selected="selected"':'').'>'.$i.'</option>';
        $quant_buffer .= '</select><br />';
    }

    ?>
</p> <!-- this p tag fixes a IE bug -->
<link rel="stylesheet" type="text/css" href="<?php echo plugins_url('../TDE_AppCalendar/'.cpabc_get_option('calendar_theme','').'all-css.css', __FILE__); ?>" />
<script>
var pathCalendar = "<?php echo cpabc_appointment_get_site_url(); ?>";
var cpabc_global_date_format = '<?php echo cpabc_get_option('calendar_dateformat', CPABC_APPOINTMENTS_DEFAULT_CALENDAR_DATEFORMAT); ?>';
var cpabc_global_military_time = '<?php echo cpabc_get_option('calendar_militarytime', CPABC_APPOINTMENTS_DEFAULT_CALENDAR_MILITARYTIME); ?>';
var cpabc_global_start_weekday = '<?php echo cpabc_get_option('calendar_weekday', CPABC_APPOINTMENTS_DEFAULT_CALENDAR_WEEKDAY); ?>';
var cpabc_global_mindate = '<?php $value = cpabc_get_option('calendar_mindate', CPABC_APPOINTMENTS_DEFAULT_CALENDAR_MINDATE); if ($value != '') echo date("n/j/Y", strtotime($value)); ?>';
var cpabc_global_maxdate = '<?php $value = cpabc_get_option('calendar_maxdate', CPABC_APPOINTMENTS_DEFAULT_CALENDAR_MAXDATE); if ($value != '') echo date("n/j/Y",strtotime($value)); ?>';
var cpabc_global_close_on_select = <?php $value = cpabc_get_option('close_fpanel', 'yes'); if ($value == '' || $value == 'yes') echo 'true'; else echo 'false'; ?>;
var cpabc_global_cancel_text = '<?php _e("Cancel",'cpabc'); ?>';
var cpabc_global_pagedate = '<?php
    $sm = cpabc_get_option('calendar_startmonth', date("n"));
    $sy = cpabc_get_option('calendar_startyear', date("Y"));
    if ($sm=='0' || $sm=='') $sm = date("n");
    if ($sy=='0' || $sy=='') $sy = date("Y");
    echo $sm."/".$sy;
?>';
</script>
<?php if (!isset($_GET["fl_builder"])) { ?>
<!--noptimize--><script type="text/javascript" src="<?php echo plugins_url('../TDE_AppCalendar/all-scripts.js', __FILE__); ?>"></script><!--/noptimize-->
<?php } ?>
<script type="text/javascript">
 var cpabc_current_calendar_item;
 function apc_clear_date()
 {
    document.getElementById("selDaycal"+cpabc_current_calendar_item ).value = "";
    cpabc_updateItem();
 }
 function cpabc_updateItem()
 {
    document.getElementById("calarea_"+cpabc_current_calendar_item).style.display = "none";
    var i = document.FormEdit.cpabc_item.options.selectedIndex;
    var selecteditem = document.FormEdit.cpabc_item.options[i].value;
    cpabc_do_init(selecteditem);
 }
 function cpabc_do_init(id)
 {
    cpabc_current_calendar_item = id;
    document.getElementById("calarea_"+cpabc_current_calendar_item).style.display = "";
    <?php if (!isset($_GET["fl_builder"])) { ?>initAppCalendar("cal"+cpabc_current_calendar_item,<?php echo cpabc_get_option('calendar_pages', CPABC_APPOINTMENTS_DEFAULT_CALENDAR_PAGES); ?>,2,"<?php echo cpabc_auto_language(cpabc_get_option('calendar_language', CPABC_APPOINTMENTS_DEFAULT_CALENDAR_LANGUAGE)); ?>",{m1:"<?php _e('Please select the appointment time.','cpabc'); ?>"});<?php } ?>
 }
 function updatedate()
 {
    if (document.getElementById("selDaycal"+cpabc_current_calendar_item ).value != '')
    {
        var timead = "";
        var hour = document.getElementById("selHourcal"+cpabc_current_calendar_item ).value;
        if (cpabc_global_military_time == '0')
        {
            if (parseInt(hour) > 12)
            {
                timead = " pm";
                hour = parseInt(hour)-12;
            }
            else
                timead = " am";
        }
        var minute = document.getElementById("selMinutecal"+cpabc_current_calendar_item ).value;
        if (minute.length == 1)
            minute = "0"+minute;
        minute = hour + ":" + minute + timead;
    }
 }
 </script>
<?php
    $current_user = wp_get_current_user();
    define('CPABC_AUTH_INCLUDE', true);
    @include dirname( __FILE__ ) . '/cpabc_scheduler.inc.php';
?>
<script type="text/javascript">
 var cpabc_click_enabled = true;  
 cpabc_do_init(<?php echo $myrows[0]->id; ?>);
 setInterval('updatedate()',200);
 function doValidate(form)
 {
    if (!cpabc_click_enabled) return false;
    var visitortime = new Date();
    form.cpabc_appointments_utime.value = "GMT " + -visitortime.getTimezoneOffset()/60;
    if (form.phone.value == '')
    {
        alert('<?php echo str_replace("'","\'",__('Please enter a valid phone number','cpabc')); ?>.');
        return false;
    }
    if (form.email.value == '')
    {
        alert('<?php echo str_replace("'","\'",__('Please enter a valid email address','cpabc')); ?>.');
        return false;
    }
    if (form.name.value == '')
    {
        alert('<?php echo str_replace("'","\'",__('Please write your name','cpabc')); ?>.');
        return false;
    }
    var selst = ""+document.getElementById("selDaycal"+cpabc_current_calendar_item).value;    
    if (selst == '')
    {
        alert('<?php echo str_replace("'","\'",__('Please select date and time','cpabc')); ?>.');
        return false;
    }
    selst = selst.match(/;/g);selst = selst.length;
    if (selst < <?php $opt = cpabc_get_option('min_slots', '1'); if ($opt == '') $opt = '1'; echo $opt; ?>)
    {
        var almsg = '<?php echo str_replace("'","\'",__('Please select at least %1 time-slots. Currently selected: %2 time-slots.','cpabc')); ?>';
        almsg = almsg.replace('%1','<?php echo $opt; ?>');
        almsg = almsg.replace('%2',selst);
        alert(almsg);
        return false;
    }
    if (selst > <?php $opt = cpabc_get_option('max_slots', '1'); if ($opt == '') $opt = '1'; echo $opt; ?>)
    {
        var almsg = '<?php echo str_replace("'","\'",__('Please select a maximum of %1 time-slots. Currently selected: %2 time-slots.','cpabc')); ?>';
        almsg = almsg.replace('%1','<?php echo $opt; ?>');
        almsg = almsg.replace('%2',selst);
        alert(almsg);
        return false;
    } 
    <?php if (cpabc_get_option('dexcv_enable_captcha', CPABC_TDEAPP_DEFAULT_dexcv_enable_captcha) != 'false') { ?> if (form.hdcaptcha.value == '')
    {
        alert('<?php echo str_replace("'","\'",__('Please enter the captcha verification code','cpabc')); ?>.');
        return false;
    }
    $dexQuery = jQuery.noConflict();
    var result = $dexQuery.ajax({
        type: "GET",
        url: "<?php echo cpabc_appointment_get_site_url(); ?>?inAdmin=1"+String.fromCharCode(38)+"abcc=1"+String.fromCharCode(38)+"hdcaptcha="+form.hdcaptcha.value,
        async: false
    }).responseText;
    if (result.indexOf("captchafailed") != -1)
    {
        $dexQuery("#captchaimg").attr('src', $dexQuery("#captchaimg").attr('src')+String.fromCharCode(38)+Math.floor((Math.random() * 99999) + 1));
        alert('<?php echo str_replace("'","\'",__('Incorrect captcha code. Please try again.','cpabc')); ?>');
        return false;
    }
    else <?php } ?>
    {
        cpabc_click_enabled = false;
        cpabc_blink(".cp_subbtn");
        return true;
    }
 }
 function cpabc_blink(selector){
     try 
     {
         $dexQuery = jQuery.noConflict();
         $dexQuery(selector).fadeOut(1000, function(){
             $dexQuery(this).fadeIn(1000, function(){
                 if (!cpabc_click_enabled)
                     cpabc_blink(this); 
             });
         });
     } catch (e) {}
 }
</script>    
    <?php
}


function cpabc_appointments_show_booking_form($id = "")
{
    if ($id != '')
        define ('CPABC_CALENDAR_FIXED_ID',$id);
    define('CPABC_AUTH_INCLUDE', true);
    cpabc_appointments_get_public_form();
}

/* Code for the admin area */

function cpabc_settingsLink($links) {
    $settings_link = '<a href="admin.php?page=cpabc_appointments.php">'.__('Settings','cpabc').'</a>';
	array_unshift($links, $settings_link);
	return $links;
}


function cpabc_helpLink($links) {
    $help_link = '<a href="https://abc.dwbooster.com/support">'.__('Help','cpabc').'</a>';
	array_unshift($links, $help_link);
	return $links;
}

function cpabc_customAdjustmentsLink($links) {
    $customAdjustments_link = '<a href="https://abc.dwbooster.com/download">'.__('Upgrade To Premium','cpabc').'</a>';
	array_unshift($links, $customAdjustments_link);
	return $links;
}

function cpabc_appointments_html_post_page() {
    if (isset($_GET["cal"]) && $_GET["cal"] != '')
    {
        $_GET["cal"] = intval($_GET["cal"]);
        if (isset($_GET["edit"]) && $_GET["edit"] == '1')
            @include_once dirname( __FILE__ ) . '/cp_admin_int_edition.inc.php';
        else if (isset($_GET["list"]) && $_GET["list"] == '1')
            @include_once dirname( __FILE__ ) . '/cpabc_appointments_admin_int_bookings_list.inc.php';
        else
            @include_once dirname( __FILE__ ) . '/cpabc_appointments_admin_int.inc.php';
    }
    else
    {
        if (isset($_GET["page"]) &&$_GET["page"] == 'cpabc_appointments_upgrade')
        {
            echo("Redirecting to upgrade page...<script type='text/javascript'>document.location='https://abc.dwbooster.com/download';</script>");
            exit;
        }
        else if (isset($_GET["page"]) &&$_GET["page"] == 'cpabc_appointments_demo')
        {
            echo("Redirecting to demo page...<script type='text/javascript'>document.location='https://abc.dwbooster.com/home#demos';</script>");
            exit;
        }
        else
            @include_once dirname( __FILE__ ) . '/cpabc_appointments_admin_int_calendar_list.inc.php';
    }
}


function set_cpabc_apps_insert_button() {
    print '<a href="javascript:send_to_editor(\'[CPABC_APPOINTMENT_CALENDAR calendar=&quot;1&quot;]\');" title="'.__('Insert Appointment Booking Calendar').'"><img hspace="5" src="'.plugins_url('../images/cpabc_apps.gif', __FILE__).'" alt="'.__('Insert  Appointment Booking Calendar','cpabc').'" /></a>';
}


function set_cpabc_apps_insert_adminScripts($hook) {
    if (isset($_GET["cal"]) && $_GET["cal"] != '')
    {
        wp_enqueue_script( 'jquery' );
        wp_enqueue_script( 'jquery-ui-core' );
        wp_enqueue_script( 'jquery-ui-datepicker' );
        wp_enqueue_script( 'tinymce_js', includes_url( 'js/tinymce/' ) . 'wp-tinymce.php', array( 'jquery' ), false, true );

        wp_enqueue_style('jquery-ui-datepicker', plugins_url('../TDE_AppCalendar/cupertino/jquery-ui-1.8.20.custom.css', __FILE__));
        
        wp_enqueue_style('cpabc-allstyle', plugins_url('../TDE_AppCalendar/all-css.css', __FILE__));
        wp_enqueue_style('cpabc-sestyle', plugins_url('../TDE_AppCalendar/simpleeditor.css', __FILE__));
        wp_enqueue_style('cpabc-tbstyle', plugins_url('../TDE_AppCalendar/tabview.css', __FILE__));  
    }
    if( 'post.php' != $hook  && 'post-new.php' != $hook )
        return;
}


function cpabc_export_iCal() {
    global $wpdb;
   // header("Content-type: application/octet-stream");
   // header("Content-Disposition: attachment; filename=events".date("Y-M-D_H.i.s").".ics");

    define('CPABC_CAL_TIME_ZONE_MODIFY',get_option('CPABC_CAL_TIME_ZONE_MODIFY_SET'," +0 hours"));
    define('CPABC_CAL_TIME_SLOT_SIZE'," +".get_option('CPABC_CAL_TIME_SLOT_SIZE_SET',"15")." minutes");

    echo "BEGIN:VCALENDAR\n";
    echo "PRODID:-//Net-Factor CodePeople//Appointment Booking Calendar for WordPress//EN\n";
    echo "VERSION:2.0\n";
    echo "CALSCALE:GREGORIAN\n";
    echo "METHOD:PUBLISH\n";
    echo "X-WR-CALNAME:Bookings\n";
    echo "X-WR-TIMEZONE:Europe/London\n";
    echo "BEGIN:VTIMEZONE\n";
    echo "TZID:Europe/Stockholm\n";
    echo "X-LIC-LOCATION:Europe/London\n";
    echo "BEGIN:DAYLIGHT\n";
    echo "TZOFFSETFROM:+0000\n";
    echo "TZOFFSETTO:+0100\n";
    echo "TZNAME:CEST\n";
    echo "DTSTART:19700329T020000\n";
    echo "RRULE:FREQ=YEARLY;BYMONTH=3;BYDAY=-1SU\n";
    echo "END:DAYLIGHT\n";
    echo "BEGIN:STANDARD\n";
    echo "TZOFFSETFROM:+0100\n";
    echo "TZOFFSETTO:+0000\n";
    echo "TZNAME:CET\n";
    echo "DTSTART:19701025T030000\n";
    echo "RRULE:FREQ=YEARLY;BYMONTH=10;BYDAY=-1SU\n";
    echo "END:STANDARD\n";
    echo "END:VTIMEZONE\n";

    $events = $wpdb->get_results( "SELECT * FROM ".CPABC_APPOINTMENTS_CALENDARS_TABLE_NAME." WHERE appointment_calendar_id=".intval($_GET["id"])." ORDER BY datatime ASC" );
    foreach ($events as $event)
    {
        echo "BEGIN:VEVENT\n";
        echo "DTSTART:".date("Ymd",strtotime($event->datatime.CPABC_CAL_TIME_ZONE_MODIFY))."T".date("His",strtotime($event->datatime.CPABC_CAL_TIME_ZONE_MODIFY))."Z\n";
        echo "DTEND:".date("Ymd",strtotime($event->datatime.CPABC_CAL_TIME_ZONE_MODIFY))."T".date("His",strtotime($event->datatime.CPABC_CAL_TIME_ZONE_MODIFY.CPABC_CAL_TIME_SLOT_SIZE))."Z\n";
        echo "DTSTAMP:".date("Ymd",strtotime($event->datatime.CPABC_CAL_TIME_ZONE_MODIFY))."T".date("His",strtotime($event->datatime.CPABC_CAL_TIME_ZONE_MODIFY))."Z\n";
        echo "UID:uid".$event->id."@".$_SERVER["SERVER_NAME"]."\n";
        echo "CREATED:".date("Ymd",strtotime($event->datatime.CPABC_CAL_TIME_ZONE_MODIFY))."T".date("His",strtotime($event->datatime.CPABC_CAL_TIME_ZONE_MODIFY))."Z\n";
        echo "DESCRIPTION:".str_replace("<br>",'\n',str_replace("<br />",'\n',str_replace("\r",'',str_replace("\n",'\n',$event->description)) ))."\n";
        echo "LAST-MODIFIED:".date("Ymd",strtotime($event->datatime.CPABC_CAL_TIME_ZONE_MODIFY))."T".date("His",strtotime($event->datatime.CPABC_CAL_TIME_ZONE_MODIFY))."Z\n";
        echo "LOCATION:\n";
        echo "SEQUENCE:0\n";
        echo "STATUS:CONFIRMED\n";
        echo "SUMMARY:Booking from ".str_replace("\n",'\n',$event->title)."\n";
        echo "TRANSP:OPAQUE\n";
        echo "END:VEVENT\n";


    }
    echo 'END:VCALENDAR';
    exit;
}


function cpabc_appointments_check_posted_data()
{
    global $wpdb;

    if(isset($_GET) && array_key_exists('cpabc_app',$_GET)) {
        if ( $_GET["cpabc_app"] == 'calfeed' )
        {
            if ($_GET["id"] != '' && substr(md5($_GET["id"].$_SERVER["DOCUMENT_ROOT"]),0,10) == $_GET["verify"])
                cpabc_export_iCal();
            else
            {
                echo 'Access denied - verify value is not correct.';
                exit;
            }

        }

        if ($_GET["cpabc_app"] == 'captcha')
        {
            @include_once dirname( __FILE__ ) . '/../captcha/captcha.php';
            exit;
        }

    }

    if (isset( $_GET['cpabc_appointments_csv'] ) && is_admin() )
    {
        cpabc_appointments_export_csv();
        return;
    }

    if (isset( $_GET['cpabc_app'] ) &&  $_GET['cpabc_app'] == 'cpabc_loadmindate' && is_admin() )
    {
        if ($_GET["code"] == '')
            echo '';
        else
        {
            $date = date("Y-m-d H:i",strtotime($_GET["code"]));
            if (date("Y",strtotime($_GET["code"])) == '1970')
                echo '<span style="color:#DD0000;">Error! Invalid date format!. Calculated min date for today: '.$date.'</span>';
            else
                echo '<span style="color:#008800;">Calculated min date for today: '.$date.'</span>';
        }
        exit;
    }
    
    if (isset( $_GET['cpabc_app'] ) &&  $_GET['cpabc_app'] == 'cpabc_loadmaxdate' && is_admin() )
    {
        if ($_GET["code"] == '')
            echo '';
        else
        {
            $date = date("Y-m-d H:i",strtotime($_GET["code"]));
            if (date("Y",strtotime($_GET["code"])) == '1970')
                echo '<span style="color:#DD0000;">Error! Invalid date format!. Calculated max date for today: '.$date.'</span>';
            else
            {
                echo '<span style="color:#008800;">Calculated max date for today: '.$date.'</span>';                
                $date2 = date("Y-m-d H:i",strtotime($_GET["code2"]));
                if ($date2 >= $date)
                     echo '<br /><span style="color:#DD0000;">Error! Max date is smaller than min date, so no days will be available in the calendar.</span>';
            }
        }
        exit;
    }    
    
    if (isset($_GET["cpabc_c"]) && $_GET['cpabc_c'] == '1')
    {
        cpabc_process_cancel_go_appointment();
    }

    if (!defined('CP_CALENDAR_ID') && isset($_POST["cpabc_item"]))
        define ('CP_CALENDAR_ID', intval($_POST["cpabc_item"]));

    if ( 'POST' == $_SERVER['REQUEST_METHOD'] && isset( $_POST['cpabc_appointments_post_options'] ) && (is_admin() || cpabc_appointments_user_access_to(CP_CALENDAR_ID) ))
    {
        cpabc_appointments_save_options();
        return;
    }
    
    if ( 'POST' == $_SERVER['REQUEST_METHOD'] && isset( $_POST['CP_ABC_post_edition'] ) && is_admin() )
    {
        cpabc_appointments_save_edition();
        return;
    }  
    
    // if this isn't the expected post and isn't the captcha verification then nothing to do
	if ( 'POST' != $_SERVER['REQUEST_METHOD'] || ! isset( $_POST['cpabc_appointments_post'] ) )
		if ( 'GET' != $_SERVER['REQUEST_METHOD'] || !isset( $_GET['hdcaptcha'] ) )
		    return;


    if (function_exists('session_start')) @session_start();

    if (!isset($_GET["hdcaptcha"]) || $_GET['hdcaptcha'] == '') $_GET['hdcaptcha'] = @$_POST['hdcaptcha'];
    if (
           (cpabc_get_option('dexcv_enable_captcha', CPABC_TDEAPP_DEFAULT_dexcv_enable_captcha) != 'false') &&
           ( (strtolower($_GET['hdcaptcha']) != strtolower($_SESSION['rand_code'])) ||
             ($_SESSION['rand_code'] == '')
           )
           &&
           ( (md5(strtolower($_GET['hdcaptcha'])) != ($_COOKIE['rand_code'])) ||
             ($_COOKIE['rand_code'] == '')
           )
       )
    {
        $_SESSION['rand_code'] = '';
        setCookie('rand_code', '', time()+36000,"/");
        echo 'captchafailed';
        exit;
    }

	// if this isn't the real post (it was the captcha verification) then echo ok and exit
    if ( 'POST' != $_SERVER['REQUEST_METHOD'] || ! isset( $_POST['cpabc_appointments_post'] ) )
	{
	    if (!isset($_GET["abcc"]))
	        return;
	    echo 'ok';
        exit;
	}

    $_SESSION['rand_code'] = '';

    $selectedCalendar = $_POST["cpabc_item"];

    $_POST["dateAndTime"] =   explode(";",str_replace(",","-",$_POST["selDaycal".$selectedCalendar]));
    array_shift($_POST["dateAndTime"]);

    $military_time = cpabc_get_option('calendar_militarytime', CPABC_APPOINTMENTS_DEFAULT_CALENDAR_MILITARYTIME);
    if (cpabc_get_option('calendar_militarytime', CPABC_APPOINTMENTS_DEFAULT_CALENDAR_MILITARYTIME) == '0') $format = "g:i A"; else $format = "H:i";

    $calendar_dformat = cpabc_get_option('calendar_dateformat', CPABC_APPOINTMENTS_DEFAULT_CALENDAR_DATEFORMAT);
    if ($calendar_dformat == '2')
        $format = "d.m.Y ".$format;
    else if ($calendar_dformat == '1')
        $format = "d/m/Y ".$format;
    else
        $format = "m/d/Y ".$format;

    for($n=0;$n<count($_POST["dateAndTime"]); $n++)
    {
        $_POST["dateAndTime"][$n] = date("Y-m-d H:i:s",strtotime($_POST["dateAndTime"][$n]));
        $_POST["Date"][$n] = date($format,strtotime($_POST["dateAndTime"][$n]));
    }

    $services_formatted = array();


    $price = explode(";",cpabc_get_option('request_cost', CPABC_APPOINTMENTS_DEFAULT_COST));
    foreach ($price as $item => $value)
       $price[$item] = trim(str_replace(',','', str_replace(CPABC_APPOINTMENTS_DEFAULT_CURRENCY_SYMBOL,'',
                                                 str_replace(CPABC_APPOINTMENTS_GBP_CURRENCY_SYMBOL,'',
                                                 str_replace(CPABC_APPOINTMENTS_EUR_CURRENCY_SYMBOL_A, '',
                                                 str_replace(CPABC_APPOINTMENTS_EUR_CURRENCY_SYMBOL_B,'', $value )))) ));

    if (isset($price[count($_POST["dateAndTime"])-1]))
        $price = $price[count($_POST["dateAndTime"])-1];
    else
        $price = $price[0] * count($_POST["dateAndTime"]);


    // check discount codes
    //-------------------------------------------------
    $discount_note = "";
    $coupon = false;

    $params = array();
    $params["UTIMEZONE"] = @$_POST["cpabc_appointments_utime"];
    $params["PRICE"] = number_format ($price, 2);
    $params["COUPONCODE"] = ($coupon?"\nCoupon code:".$coupon->code.$discount_note."\n":"");
    $params["QUANTITY"] = @$_POST["abc_capacity"];

    // get form info
    //---------------------------
    $params["NAME"] = $_POST["name"];
    $params["EMAIL"] = $_POST["email"];
    $params["PHONE"] = $_POST["phone"];
    $params["COMMENTS"] = $_POST["question"];

    $buffer_A = $_POST["question"];
    $to = "email";

    $_SESSION['rand_code'] = '';
    setCookie('rand_code', '', time()+36000,"/");

    // insert into database
    //---------------------------

    if (date("Y",strtotime($_POST["dateAndTime"][0])) == "1970") // if this is spam, skip
        return;

    for ($n=0; $n<count($_POST["dateAndTime"]); $n++)
    {
        $params["DATE"] = trim( substr($_POST["Date"][$n], 0, strpos($_POST["Date"][$n],' ') ) );
        $params["TIME"] = trim( substr($_POST["Date"][$n], strpos($_POST["Date"][$n],' ') ) );
        $rows_affected = $wpdb->insert( CPABC_APPOINTMENTS_TABLE_NAME, array( 'calendar' => $selectedCalendar,
                                                                        'time' => current_time('mysql'),
                                                                        'booked_time' => $_POST["Date"][$n],
                                                                        'booked_time_unformatted' => $_POST["dateAndTime"][$n],
                                                                        'name' => "".@$_POST["name"],
                                                                        'email' => "".@$_POST[$to],
                                                                        'phone' => "".@$_POST["phone"],
                                                                        'question' => $buffer_A,
                                                                        'quantity' => (isset($_POST["abc_capacity"])?$_POST["abc_capacity"]:1),
                                                                        'buffered_date' => serialize($params)
                                                                         ) );
        if (!$rows_affected)
        {
            echo 'Error saving data! Please try again.';
            echo '<br /><br />If the error persists  please be sure you are using the latest version and in that case contact support service at https://abc.dwbooster.com/contact-us?debug=db';
            exit;
        }

 	    // save data here
        $item_number[] = $wpdb->insert_id;
    }
    $item_number = implode(";", $item_number);

    if (cpabc_get_option('paypal_mode','production') == "sandbox")
        $ppurl = 'https://www.sandbox.paypal.com/cgi-bin/webscr';
    else
        $ppurl = 'https://www.paypal.com/cgi-bin/webscr';

?>
<html>
<head><title>Redirecting to Paypal...</title></head>
<body>
<form action="<?php echo $ppurl; ?>" name="ppform3" method="post">
<input type="hidden" name="cmd" value="_xclick" />
<input type="hidden" name="business" value="<?php echo trim(cpabc_get_option('paypal_email', CPABC_APPOINTMENTS_DEFAULT_PAYPAL_EMAIL)); ?>" />
<input type="hidden" name="item_name" value="<?php echo cpabc_get_option('paypal_product_name', CPABC_APPOINTMENTS_DEFAULT_PRODUCT_NAME).(@$_POST["services"]?": ".trim($services_formatted[1]):""); ?>" />
<input type="hidden" name="custom" value="<?php echo $item_number; ?>" />
<input type="hidden" name="amount" value="<?php echo floatval($price); ?>" />
<input type="hidden" name="page_style" value="Primary" />
<input type="hidden" name="no_shipping" value="1" />
<input type="hidden" name="return" value="<?php echo esc_url(trim(cpabc_get_option('url_ok', CPABC_APPOINTMENTS_DEFAULT_OK_URL))); ?>">
<input type="hidden" name="cancel_return" value="<?php echo esc_url(cpabc_get_option('url_cancel', CPABC_APPOINTMENTS_DEFAULT_CANCEL_URL)); ?>" />
<input type="hidden" name="currency_code" value="<?php echo cpabc_appointments_clean_currency(cpabc_get_option('currency', CPABC_APPOINTMENTS_DEFAULT_CURRENCY)); ?>" />
<input type="hidden" name="lc" value="<?php echo cpabc_get_option('paypal_language', CPABC_APPOINTMENTS_DEFAULT_PAYPAL_LANGUAGE); ?>" />
<input type="hidden" name="bn" value="NetFactorSL_SI_Custom" />
<input type="hidden" name="notify_url" value="<?php echo cpabc_appointment_get_FULL_site_url(); ?>/?cpabc_ipncheck=<?php echo $item_number; ?>" />
</form>
<script type="text/javascript">
document.ppform3.submit();
</script>
</body>
</html>
<?php
        exit();
}


function cpabc_appointments_clean_currency($currency)
{
	$currency = trim(strtoupper($currency));
	if ($currency == 'GPB')
		return 'GBP';
	else if ($currency == 'CDN')
		return 'CAD';
	else if ($currency == '$')
		return 'USD';
    else if ($currency == 'DOLLAR')
		return 'USD';
    else if ($currency == 'EURO')
		return 'EUR';
    else if ($currency == '€')
		return 'EUR';
	else if ($currency == 'MXP')
		return 'MXN';
	else if ($currency == 'AUS')
		return 'AUD';    
	else
		return $currency;
}


function cpabc_appointments_user_access_to($calendar) {
    global $wpdb;
	$current_user = wp_get_current_user();
	$myrows = $wpdb->get_results( "SELECT * FROM ".CPABC_APPOINTMENTS_CONFIG_TABLE_NAME." where id='".intval($calendar)."' AND conwer<>'' AND conwer='".esc_sql($current_user->ID)."'" );
	return count($myrows);
}


function cpabc_appointments_check_IPN_verification() {

    global $wpdb;

	if ( ! isset( $_GET['cpabc_ipncheck'] ) || $_GET['cpabc_ipncheck'] == '' )
		return;
		
    $_GET["itemnumber"] = $_GET['cpabc_ipncheck'];

    $item_name = $_POST['item_name'];
    $payment_status = $_POST['payment_status'];
    $payment_amount = $_POST['mc_gross'];
    $payment_currency = $_POST['mc_currency'];
    $txn_id = $_POST['txn_id'];
    $receiver_email = $_POST['receiver_email'];
    $payer_email = $_POST['payer_email'];
    $payment_type = $_POST['payment_type'];
    $txnid = $_POST['txn_id'];

    if (CPABC_TDEAPP_CALENDAR_STEP2_VRFY)
    {
	    if ($payment_status != 'Completed' && $payment_type != 'echeck')
	        return;

	    if ($payment_type == 'echeck' && $payment_status == 'Completed')
    	    return;
    }
    
    $itemnumber = explode(";",$_GET["itemnumber"]);
    $myrows = $wpdb->get_results( "SELECT * FROM ".CPABC_TDEAPP_CALENDAR_DATA_TABLE." WHERE reference='".intval($itemnumber[0])."'" );
    if (count($myrows))
    {
        echo 'OK - Already processed';
        exit;
    }

    $myrows = $wpdb->get_results( "SELECT * FROM ".CPABC_APPOINTMENTS_TABLE_NAME." WHERE id=".intval($itemnumber[0]) );
    $params = unserialize($myrows[0]->buffered_date);
    $params["txnid"] = $txnid;
    $wpdb->query( "UPDATE ".CPABC_APPOINTMENTS_TABLE_NAME." SET buffered_date='".esc_sql(serialize($params))."' WHERE id=".intval($itemnumber[0]) );  
      
    
    cpabc_process_ready_to_go_appointment($_GET["itemnumber"], $payer_email);

    echo 'OK';

    exit();

}

function cpabc_process_cancel_go_appointment()
{
    global $wpdb;
    $itemnumber = base64_decode($_GET["i"]);
    if (is_numeric($itemnumber))
    {
        $wpdb->query( "DELETE FROM ".CPABC_TDEAPP_CALENDAR_DATA_TABLE." WHERE id=".$itemnumber );
        header("Location: ".CPABC_APPOINTMENTS_DEFAULT_ON_CANCEL_REDIRECT_TO);
        exit;
    }
}

function cpabc_process_ready_to_go_appointment($itemnumber, $payer_email = "")
{
   global $wpdb;

   cpabc_appointments_add_field_verify(CPABC_TDEAPP_CALENDAR_DATA_TABLE, 'quantity', "VARCHAR(25) DEFAULT '1' NOT NULL");
   cpabc_appointments_add_field_verify(CPABC_TDEAPP_CALENDAR_DATA_TABLE, 'reminder', "VARCHAR(1) DEFAULT '' NOT NULL");
   cpabc_appointments_add_field_verify(CPABC_TDEAPP_CALENDAR_DATA_TABLE, 'reference', "VARCHAR(30) DEFAULT '' NOT NULL");

   $itemnumber = explode(";",$itemnumber);
   $myrows = $wpdb->get_results( "SELECT * FROM ".CPABC_APPOINTMENTS_TABLE_NAME." WHERE id=".intval($itemnumber[0]) );
   $mycalendarrows = $wpdb->get_results( 'SELECT * FROM '.CPABC_APPOINTMENTS_CONFIG_TABLE_NAME .' WHERE `'.CPABC_TDEAPP_CONFIG_ID.'`='.$myrows[0]->calendar);
   $reminder_timeline = date( "Y-m-d H:i:s", strtotime (date("Y-m-d H:i:s")." +".$mycalendarrows[0]->reminder_hours." hours") );
   if (!defined('CP_CALENDAR_ID'))
        define ('CP_CALENDAR_ID',$myrows[0]->calendar);

   $SYSTEM_EMAIL = cpabc_get_option('notification_from_email', CPABC_APPOINTMENTS_DEFAULT_PAYPAL_EMAIL);
   $SYSTEM_RCPT_EMAIL = cpabc_get_option('notification_destination_email', CPABC_APPOINTMENTS_DEFAULT_PAYPAL_EMAIL);

   $email_subject1 = cpabc_get_option('email_subject_confirmation_to_user', CPABC_APPOINTMENTS_DEFAULT_SUBJECT_CONFIRMATION_EMAIL);
   $email_content1 = cpabc_get_option('email_confirmation_to_user', CPABC_APPOINTMENTS_DEFAULT_CONFIRMATION_EMAIL);
   $email_subject2 = cpabc_get_option('email_subject_notification_to_admin', CPABC_APPOINTMENTS_DEFAULT_SUBJECT_NOTIFICATION_EMAIL);
   $email_content2 = cpabc_get_option('email_notification_to_admin', CPABC_APPOINTMENTS_DEFAULT_NOTIFICATION_EMAIL);

   $email_content1 = str_replace("%CALENDAR%", $mycalendarrows[0]->uname, $email_content1);
   $email_content2 = str_replace("%CALENDAR%", $mycalendarrows[0]->uname, $email_content2);

   $params = unserialize($myrows[0]->buffered_date);
   $attachments = array();
   foreach ($params as $item => $value)
   {
       $email_content1 = str_replace('<%'.$item.'%>',(is_array($value)?(implode(", ",$value)):($value)),$email_content1);
       $email_content2 = str_replace('<%'.$item.'%>',(is_array($value)?(implode(", ",$value)):($value)),$email_content2);
       $email_content1 = str_replace('%'.$item.'%',(is_array($value)?(implode(", ",$value)):($value)),$email_content1);
       $email_content2 = str_replace('%'.$item.'%',(is_array($value)?(implode(", ",$value)):($value)),$email_content2);
       if (strpos($item,"_link"))
           $attachments[] = $value;
   }
   $buffered_dates = array();
   for ($n=0;$n<count($itemnumber);$n++)
   {
       $myrows = $wpdb->get_results( "SELECT * FROM ".CPABC_APPOINTMENTS_TABLE_NAME." WHERE id=".intval($itemnumber[$n]) );
       $buffered_dates[] = $myrows[0]->booked_time;
       $information = $mycalendarrows[0]->uname."\n".
                      $myrows[0]->booked_time."\n".
                      ($myrows[0]->name?$myrows[0]->name."\n":"").
                      $myrows[0]->email."\n".
                      ($myrows[0]->phone?$myrows[0]->phone."\n":"").
                      $myrows[0]->question."\n";

       if ($reminder_timeline > date("Y-m-d H:i:s", strtotime($myrows[0]->booked_time_unformatted)))
           $reminder = '1';
       else
           $reminder = '';

       $rows_affected = $wpdb->insert( CPABC_TDEAPP_CALENDAR_DATA_TABLE, array( 'appointment_calendar_id' => $myrows[0]->calendar,
                                                                            'datatime' => date("Y-m-d H:i:s", strtotime($myrows[0]->booked_time_unformatted)),
                                                                            'title' => $myrows[0]->email,
                                                                            'reminder' => $reminder,
                                                                            'quantity' =>  (isset($myrows[0]->quantity)?$myrows[0]->quantity:1),
                                                                            'description' => str_replace("\n","<br />", $information),
                                                                            'reference' => intval($itemnumber[$n])
                                                                             ) );
       // SEND EMAILS START
       if ($n == count($itemnumber)-1) // send emails only once
       {

           $params['itemnumber'] = $wpdb->insert_id;
       
           $information = $mycalendarrows[0]->uname."\n".
                  implode(" - ",$buffered_dates)."\n".
                  ($myrows[0]->name?$myrows[0]->name."\n":"").
                  $myrows[0]->email."\n".
                  ($myrows[0]->phone?$myrows[0]->phone."\n":"").
                  $myrows[0]->question."\n";

           $email_content1 = str_replace("%INFORMATION%", $information, $email_content1);
           $email_content2 = str_replace("%INFORMATION%", $information, $email_content2);

           $itemnumberdb = $wpdb->insert_id;
           $cancel_link = cpabc_appointment_get_FULL_site_url().'/?cpabc_c=1&i='.base64_encode($itemnumberdb).'&a=1';

           $email_content1 = str_replace("%CANCEL%", $cancel_link, $email_content1);
           $email_content2 = str_replace("%CANCEL%", $cancel_link, $email_content2);

           if (!strpos($SYSTEM_EMAIL,">"))
               $SYSTEM_EMAIL = '"'.$SYSTEM_EMAIL.'" <'.$SYSTEM_EMAIL.'>';
                
           // SEND EMAIL TO USER
           $replyto = $myrows[0]->email;
           if ('html' == cpabc_get_option('nuser_emailformat', CPABC_APPOINTMENTS_DEFAULT_email_format)) $content_type = "Content-Type: text/html; charset=utf-8\n"; else $content_type = "Content-Type: text/plain; charset=utf-8\n";
           wp_mail($myrows[0]->email, $email_subject1, $email_content1,
                    "From: ".$SYSTEM_EMAIL."\r\n".
                    $content_type.
                    "X-Mailer: PHP/" . phpversion());

           if ($payer_email && strtolower($payer_email) != strtolower($myrows[0]->email))
               wp_mail($payer_email , $email_subject1, $email_content1,
                        "From: ".$SYSTEM_EMAIL."\r\n".
                        $content_type.
                        "X-Mailer: PHP/" . phpversion());

           // SEND EMAIL TO ADMIN
           if ('html' == cpabc_get_option('nadmin_emailformat', CPABC_APPOINTMENTS_DEFAULT_email_format)) $content_type = "Content-Type: text/html; charset=utf-8\n"; else $content_type = "Content-Type: text/plain; charset=utf-8\n";
           $to = explode(",",$SYSTEM_RCPT_EMAIL);
           foreach ($to as $item)
                if (trim($item) != '')
                {
                    wp_mail(trim($item), $email_subject2, $email_content2,
                        "From: ".$SYSTEM_EMAIL."\r\n".
                        ($replyto!=''?"Reply-To: \"$replyto\" <".$replyto.">\r\n":'').
                        $content_type.
                        "X-Mailer: PHP/" . phpversion(), $attachments);
                }
       }
       // SEND EMAILS END
   }
}

function cpabc_appointments_add_field_verify ($table, $field, $type = "text")
{
    global $wpdb;
    $results = $wpdb->get_results("SHOW columns FROM `".$table."` where field='".$field."'");
    if (!count($results))
    {
        $sql = "ALTER TABLE  `".$table."` ADD `".$field."` ".$type;
        $wpdb->query($sql);
    }
}


function cpabc_appointments_save_edition()
{
    if (substr_count($_POST['editionarea'],"\\\""))
        $_POST["editionarea"] = stripcslashes($_POST["editionarea"]);
    if ($_POST["cfwpp_edit"] == 'js')   
        update_option('CP_ABC_JS', base64_encode($_POST["editionarea"]));  
    else if ($_POST["cfwpp_edit"] == 'css')  
        update_option('CP_ABC_CSS', base64_encode($_POST["editionarea"]));  
}


function cpabc_appointments_save_options()
{
    global $wpdb;
    if (!defined('CP_CALENDAR_ID'))
        define ('CP_CALENDAR_ID', intval($_POST["cpabc_item"]));

    if (!wp_verify_nonce( $_REQUEST['_wpnonce'], 'uname_abc' ))
    {
        echo "Access verification error. Cannot update settings.";
        return;
    }

    if ( ! current_user_can('edit_pages') && !cpabc_appointments_user_access_to(CP_CALENDAR_ID) ) // prevent loading coupons from outside admin area
    {
        echo 'No enough privilegies to load this content.';
        exit;
    }
/**
    if (get_magic_quotes_gpc())
        foreach ($_POST as $item => $value)
            if (!is_array($value))
                $_POST[$item] = stripcslashes($value);    
*/

    cpabc_appointments_add_field_verify(CPABC_APPOINTMENTS_CONFIG_TABLE_NAME, 'enable_reminder');
    cpabc_appointments_add_field_verify(CPABC_APPOINTMENTS_CONFIG_TABLE_NAME, 'reminder_hours');
    cpabc_appointments_add_field_verify(CPABC_APPOINTMENTS_CONFIG_TABLE_NAME, 'reminder_subject');
    cpabc_appointments_add_field_verify(CPABC_APPOINTMENTS_CONFIG_TABLE_NAME, 'reminder_content');
    cpabc_appointments_add_field_verify(CPABC_TDEAPP_CALENDAR_DATA_TABLE, 'reminder', "VARCHAR(1) DEFAULT '' NOT NULL");
    cpabc_appointments_add_field_verify(CPABC_TDEAPP_CALENDAR_DATA_TABLE, 'quantity', "VARCHAR(25) DEFAULT '1' NOT NULL");

    cpabc_appointments_add_field_verify(CPABC_APPOINTMENTS_CONFIG_TABLE_NAME, 'min_slots');
    cpabc_appointments_add_field_verify(CPABC_APPOINTMENTS_CONFIG_TABLE_NAME, 'max_slots');
    cpabc_appointments_add_field_verify(CPABC_APPOINTMENTS_CONFIG_TABLE_NAME, 'close_fpanel');
    cpabc_appointments_add_field_verify(CPABC_APPOINTMENTS_CONFIG_TABLE_NAME, 'quantity_field');

    cpabc_appointments_add_field_verify(CPABC_APPOINTMENTS_CONFIG_TABLE_NAME, 'calendar_startyear', "VARCHAR(20) DEFAULT '' NOT NULL");
    cpabc_appointments_add_field_verify(CPABC_APPOINTMENTS_CONFIG_TABLE_NAME, 'calendar_startmonth', "VARCHAR(20) DEFAULT '' NOT NULL");
    cpabc_appointments_add_field_verify(CPABC_APPOINTMENTS_CONFIG_TABLE_NAME, 'calendar_theme');

    cpabc_appointments_add_field_verify(CPABC_APPOINTMENTS_CONFIG_TABLE_NAME, 'paypal_mode');


    $_POST["request_cost"] = '';
    for ($k=1;$k <= intval($_POST["max_slots"]); $k++)
        $_POST["request_cost"] .= ($k!=1?";":"").cpabc_clean_price($_POST["request_cost_".$k]);

    $data = array(
         'calendar_language' => $_POST["calendar_language"],
         'calendar_dateformat' => $_POST["calendar_dateformat"],
         'calendar_pages' => $_POST["calendar_pages"],
         'calendar_militarytime' => $_POST["calendar_militarytime"],
         'calendar_weekday' => $_POST["calendar_weekday"],
         'calendar_mindate' => $_POST["calendar_mindate"],
         'calendar_maxdate' => $_POST["calendar_maxdate"],
         'min_slots' => $_POST["min_slots"],
         'max_slots' => $_POST["max_slots"],
         'close_fpanel' => $_POST["close_fpanel"],
         'quantity_field' => $_POST["quantity_field"],
         'paypal_mode' => $_POST["paypal_mode"],

         'calendar_startyear' => $_POST["calendar_startyear"],
         'calendar_startmonth' => $_POST["calendar_startmonth"],
         'calendar_theme' => $_POST["calendar_theme"],

         'paypal_email' => $_POST["paypal_email"],
         'request_cost' => $_POST["request_cost"],
         'paypal_product_name' => $_POST["paypal_product_name"],
         'currency' => $_POST["currency"],
         'url_ok' => $_POST["url_ok"],
         'url_cancel' => $_POST["url_cancel"],
         'paypal_language' => $_POST["paypal_language"],

         'nuser_emailformat' => @$_POST["nuser_emailformat"],
         'nadmin_emailformat' => $_POST["nadmin_emailformat"],
         'nremind_emailformat' => $_POST["nremind_emailformat"],

         'vs_text_is_required' => $_POST['vs_text_is_required'],
         'vs_text_is_email' => $_POST['vs_text_is_email'],
         'vs_text_datemmddyyyy' => $_POST['vs_text_datemmddyyyy'],
         'vs_text_dateddmmyyyy' => $_POST['vs_text_dateddmmyyyy'],
         'vs_text_number' => $_POST['vs_text_number'],
         'vs_text_digits' => $_POST['vs_text_digits'],
         'vs_text_max' => $_POST['vs_text_max'],
         'vs_text_min' => $_POST['vs_text_min'],
         'vs_text_submitbtn' => $_POST['vs_text_submitbtn'],

         'cu_user_email_field' => @$_POST["cu_user_email_field"],

         'notification_from_email' => $_POST["notification_from_email"],
         'notification_destination_email' => $_POST["notification_destination_email"],
         'email_subject_confirmation_to_user' => $_POST["email_subject_confirmation_to_user"],
         'email_confirmation_to_user' => $_POST["email_confirmation_to_user"],
         'email_subject_notification_to_admin' => $_POST["email_subject_notification_to_admin"],
         'email_notification_to_admin' => $_POST["email_notification_to_admin"],

         'enable_reminder' => @$_POST["enable_reminder"],
         'reminder_hours' => @$_POST["reminder_hours"],
         'reminder_subject' => @$_POST["reminder_subject"],
         'reminder_content' => @$_POST["reminder_content"],

         'dexcv_enable_captcha' => $_POST["dexcv_enable_captcha"],
         'dexcv_width' => $_POST["dexcv_width"],
         'dexcv_height' => $_POST["dexcv_height"],
         'dexcv_chars' => $_POST["dexcv_chars"],
         'dexcv_min_font_size' => $_POST["dexcv_min_font_size"],
         'dexcv_max_font_size' => $_POST["dexcv_max_font_size"],
         'dexcv_noise' => $_POST["dexcv_noise"],
         'dexcv_noise_length' => $_POST["dexcv_noise_length"],
         'dexcv_background' => str_replace('#','',$_POST['dexcv_background']),
         'dexcv_border' => str_replace('#','',$_POST['dexcv_border']),
         'dexcv_font' => $_POST["dexcv_font"],
         'cv_text_enter_valid_captcha' => $_POST['cv_text_enter_valid_captcha'],
         'cp_cal_checkboxes' => @$_POST["cp_cal_checkboxes"]
	);
    $wpdb->update ( CPABC_APPOINTMENTS_CONFIG_TABLE_NAME, $data, array( 'id' => CP_CALENDAR_ID ));
}


function cpabc_clean_price($price)
{
    return preg_replace('/[^0-9.]+/', '', str_replace(',','.',$price));
}


function cpabc_appointments_get_field_name ($fieldid, $form)
{
    if (is_array($form))
        foreach($form as $item)
            if ($item->name == $fieldid)
                return $item->title;
    return $fieldid;
}


function cpabc_appointments_export_csv ()
{
    if (!is_admin())
        return;
    global $wpdb;

    if (!defined('CP_CALENDAR_ID'))
        define ('CP_CALENDAR_ID',intval($_GET["cal"]));

    $form_data = json_decode(cpabc_appointment_cleanJSON(cpabc_get_option('form_structure', CPABC_APPOINTMENTS_DEFAULT_form_structure)));

    $excluded = explode(",",get_option('CPABC_EXCLUDED_COLUMNS',""));
    for ($i=0; $i<count($excluded); $i++)
        $excluded[$i] = trim($excluded[$i]);
    
    if (@$_GET["cancelled_by"] != '')
        $cond = '';
    else
        $cond = " AND ((is_cancelled<>'1') OR is_cancelled is null)";
    if ($_GET["search"] != '') $cond .= " AND (buffered_date like '%".esc_sql($_GET["search"])."%')";
    if ($_GET["dfrom"] != '') $cond .= " AND (`booked_time_unformatted` >= '".esc_sql($_GET["dfrom"])."')";
    if ($_GET["dto"] != '') $cond .= " AND (`booked_time_unformatted` <= '".esc_sql($_GET["dto"])." 23:59:59')";

    if (@$_GET["added_by"] != '') $cond .= " AND (who_added >= '".esc_sql($_GET["added_by"])."')";
    if (@$_GET["edited_by"] != '') $cond .= " AND (who_edited >= '".esc_sql($_GET["edited_by"])."')";
    if (@$_GET["cancelled_by"] != '') $cond .= " AND (is_cancelled='1' AND who_cancelled >= '".esc_sql($_GET["cancelled_by"])."')";

    if (CP_CALENDAR_ID != 0) $cond .= " AND appointment_calendar_id=".CP_CALENDAR_ID;

    $events = $wpdb->get_results( "SELECT * FROM ".CPABC_TDEAPP_CALENDAR_DATA_TABLE." INNER JOIN ".CPABC_APPOINTMENTS_CONFIG_TABLE_NAME." ON ".CPABC_TDEAPP_CALENDAR_DATA_TABLE.".appointment_calendar_id=".CPABC_APPOINTMENTS_CONFIG_TABLE_NAME.".id LEFT JOIN ".CPABC_APPOINTMENTS_TABLE_NAME." ON ".CPABC_TDEAPP_CALENDAR_DATA_TABLE.".reference=".CPABC_APPOINTMENTS_TABLE_NAME.".id  WHERE 1=1 ".$cond );

    $fields = array();
    if (!in_array("Calendar ID",$excluded)) $fields[] = "Calendar ID";
    if (!in_array("Calendar",$excluded)) $fields[] = "Calendar";
    if (!in_array("Time",$excluded)) $fields[] = "Time";
    $values = array();

    foreach ($events as $item)
    {
        $value = array();
        if (!in_array("Calendar ID",$excluded)) $value[] = $item->appointment_calendar_id;
        if (!in_array("Calendar",$excluded)) $value[] = $item->uname;
        if (!in_array("Time",$excluded)) $value[] = $item->datatime;

        $data = array();
        $data = unserialize($item->buffered_date);

        if (!is_array($data))
        {
            $data = array(
              'title' => $item->title,
              'description' => $item->description
            );
        }
        $end = count($fields);
        for ($i=3; $i<$end; $i++)
            if (isset($data[$fields[$i]]) ){
                $value[$i] = $data[$fields[$i]];
                unset($data[$fields[$i]]);
            }
            else $value[$i] = '';
        foreach ($data as $k => $d)
            if (!in_array($k,$excluded))
            {
               $fields[] = $k;
               $value[] = $d;
            }
        $values[] = $value;
    }

    header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=bookings.csv");

    $end = count($fields);
    for ($i=0; $i<$end; $i++)
        echo '"'.str_replace('"','""', cpabc_appointments_get_field_name($fields[$i],@$form_data[0])).'",';
    echo "\n";
    foreach ($values as $item)
    {
        for ($i=0; $i<$end; $i++)
        {
            if (!isset($item[$i]))
                $item[$i] = '';
            if (is_array($item[$i]))
                $item[$i] = implode($item[$i],',');
            echo '"'.str_replace('"','""', $item[$i]).'",';
        }
        echo "\n";
    }

    exit;
}


function cpabc_appointments_calendar_load() {
    global $wpdb;
	if ( ! isset( $_GET['cpabc_calendar_load'] ) || $_GET['cpabc_calendar_load'] != '1' )
		return;

    @header("Cache-Control: no-store, no-cache, must-revalidate");
    @header("Pragma: no-cache");
    $calid = str_replace  (CPABC_TDEAPP_CAL_PREFIX, "",$_GET["id"]);
    $query = "SELECT * FROM ".CPABC_TDEAPP_CONFIG." where ".CPABC_TDEAPP_CONFIG_ID."='".esc_sql($calid)."'";
    $row = $wpdb->get_results($query,ARRAY_A);
    if ($row[0])
    {
        // New header to mark init of calendar output
        echo '--***--***--***---!';
        // START:: new code to clean corrupted data
        $working_dates = explode(",",$row[0][CPABC_TDEAPP_CONFIG_WORKINGDATES]);
        for($i=0;$i<count($working_dates); $i++)
            if (is_numeric($working_dates[$i]))
                $working_dates[$i] = intval($working_dates[$i]);
            else
                $working_dates[$i] = '';
        if ($working_dates[0] === '')
            unset($working_dates[0]);
        $working_dates = array_unique($working_dates);
        $working_dates = implode(",",$working_dates);
        while (!(strpos($working_dates,",,") === false))
            $working_dates = str_replace(",,",",",$working_dates);
        if ($working_dates[strlen($working_dates)-1] == ',')
            $working_dates = substr($working_dates,0,strlen($working_dates)-1);
        echo $working_dates.";";
        // END:: new code to clean corrupted data
        echo $row[0][CPABC_TDEAPP_CONFIG_RESTRICTEDDATES].";";
        echo $row[0][CPABC_TDEAPP_CONFIG_TIMEWORKINGDATES0].";";
        echo $row[0][CPABC_TDEAPP_CONFIG_TIMEWORKINGDATES1].";";
        echo $row[0][CPABC_TDEAPP_CONFIG_TIMEWORKINGDATES2].";";
        echo $row[0][CPABC_TDEAPP_CONFIG_TIMEWORKINGDATES3].";";
        echo $row[0][CPABC_TDEAPP_CONFIG_TIMEWORKINGDATES4].";";
        echo $row[0][CPABC_TDEAPP_CONFIG_TIMEWORKINGDATES5].";";
        echo $row[0][CPABC_TDEAPP_CONFIG_TIMEWORKINGDATES6].";";
        echo $row[0]["specialDates"];
    }

    exit();
}


function cpabc_appointments_calendar_load2() {
    global $wpdb;
	if ( ! isset( $_GET['cpabc_calendar_load2'] ) || $_GET['cpabc_calendar_load2'] != '1' )
		return;
    header("Cache-Control: no-store, no-cache, must-revalidate");
    header("Pragma: no-cache");
    $calid = str_replace  (CPABC_TDEAPP_CAL_PREFIX, "",$_GET["id"]);
    $query = "SELECT * FROM ".CPABC_TDEAPP_CALENDAR_DATA_TABLE." where ".CPABC_TDEAPP_DATA_IDCALENDAR."='".esc_sql($calid)."'";
    $row_array = $wpdb->get_results($query,ARRAY_A);
    foreach ($row_array as $row)
    {
        echo $row[CPABC_TDEAPP_DATA_ID]."\n";
        $dn =  explode(" ", $row[CPABC_TDEAPP_DATA_DATETIME]);
        $d1 =  explode("-", $dn[0]);
        $d2 =  explode(":", $dn[1]);

        echo intval($d1[0]).",".intval($d1[1]).",".intval($d1[2])."\n";
        echo intval($d2[0]).":".($d2[1])."\n";
        echo ($row["quantity"]?$row["quantity"]:'1')."\n";
        echo $row[CPABC_TDEAPP_DATA_TITLE]."\n";
        echo $row[CPABC_TDEAPP_DATA_DESCRIPTION]."\n*-*\n";
    }

    exit();
}


function cpabc_appointments_calendar_update() {
    global $wpdb, $user_ID;

	if ( ! isset( $_GET['cpabc_calendar_update'] ) || $_GET['cpabc_calendar_update'] != '1' )
		return;

    $calid = intval(str_replace  (CPABC_TDEAPP_CAL_PREFIX, "",$_GET["id"]));
    if ( ! current_user_can('edit_pages') && !cpabc_appointments_user_access_to($calid) )
        return;

    cpabc_appointments_add_field_verify(CPABC_TDEAPP_CONFIG, 'specialDates');

    header("Cache-Control: no-store, no-cache, must-revalidate");
    header("Pragma: no-cache");
    if ( $user_ID )
        $wpdb->query("update  ".CPABC_TDEAPP_CONFIG." set specialDates='".esc_sql($_POST["specialDates"])."',".CPABC_TDEAPP_CONFIG_WORKINGDATES."='".esc_sql($_POST["workingDates"])."',".CPABC_TDEAPP_CONFIG_RESTRICTEDDATES."='".esc_sql($_POST["restrictedDates"])."',".CPABC_TDEAPP_CONFIG_TIMEWORKINGDATES0."='".esc_sql($_POST["timeWorkingDates0"])."',".CPABC_TDEAPP_CONFIG_TIMEWORKINGDATES1."='".esc_sql($_POST["timeWorkingDates1"])."',".CPABC_TDEAPP_CONFIG_TIMEWORKINGDATES2."='".esc_sql($_POST["timeWorkingDates2"])."',".CPABC_TDEAPP_CONFIG_TIMEWORKINGDATES3."='".esc_sql($_POST["timeWorkingDates3"])."',".CPABC_TDEAPP_CONFIG_TIMEWORKINGDATES4."='".esc_sql($_POST["timeWorkingDates4"])."',".CPABC_TDEAPP_CONFIG_TIMEWORKINGDATES5."='".esc_sql($_POST["timeWorkingDates5"])."',".CPABC_TDEAPP_CONFIG_TIMEWORKINGDATES6."='".esc_sql($_POST["timeWorkingDates6"])."'  where ".CPABC_TDEAPP_CONFIG_ID."=".$calid);

    exit();
}


function cpabc_appointments_calendar_update2() {
    global $wpdb, $user_ID;

	if ( ! isset( $_GET['cpabc_calendar_update2'] ) || $_GET['cpabc_calendar_update2'] != '1' )
		return;

    $calid = intval(str_replace  (CPABC_TDEAPP_CAL_PREFIX, "",$_GET["id"]));
    if ( ! current_user_can('edit_pages') && !cpabc_appointments_user_access_to($calid) )
        return;

    header("Cache-Control: no-store, no-cache, must-revalidate");
    header("Pragma: no-cache");
    if ( $user_ID )
    {
        if ($_GET["act"]=='del')
            $wpdb->query("delete from ".CPABC_TDEAPP_CALENDAR_DATA_TABLE." where ".CPABC_TDEAPP_DATA_IDCALENDAR."=".$calid." and ".CPABC_TDEAPP_DATA_ID."=".intval($_POST["sqlId"]));
        else if ($_GET["act"]=='edit')
        {
            $data = explode("\n", $_POST["appoiments"]);
            $d1 =  explode(",", $data[0]);
            $d2 =  explode(":", $data[1]);
	        $datetime = $d1[0]."-".$d1[1]."-".$d1[2]." ".$d2[0].":".$d2[1];
	        $capacity = $data[2];
	        $title = $data[3];
            $description = "";
            for ($j=4;$j<count($data);$j++)
            {
                $description .= $data[$j];
                if ($j!=count($data)-1)
                    $description .= "\n";
            }
            $wpdb->query("update  ".CPABC_TDEAPP_CALENDAR_DATA_TABLE." set ".CPABC_TDEAPP_DATA_DATETIME."='".$datetime."',quantity='".$capacity."',".CPABC_TDEAPP_DATA_TITLE."='".esc_sql($title)."',".CPABC_TDEAPP_DATA_DESCRIPTION."='".esc_sql($description)."'  where ".CPABC_TDEAPP_DATA_IDCALENDAR."=".$calid." and ".CPABC_TDEAPP_DATA_ID."=".intval($_POST["sqlId"]));
        }
        else if ($_GET["act"]=='add')
        {
            $data = explode("\n", $_POST["appoiments"]);
            $d1 =  explode(",", $data[0]);
            $d2 =  explode(":", $data[1]);
	        $datetime = $d1[0]."-".$d1[1]."-".$d1[2]." ".$d2[0].":".$d2[1];
	        $capacity = $data[2];
	        $title = $data[3];
            $description = "";
            for ($j=4;$j<count($data);$j++)
            {
                $description .= $data[$j];
                if ($j!=count($data)-1)
                    $description .= "\n";
            }
            $wpdb->query("insert into ".CPABC_TDEAPP_CALENDAR_DATA_TABLE."(".CPABC_TDEAPP_DATA_IDCALENDAR.",".CPABC_TDEAPP_DATA_DATETIME.",".CPABC_TDEAPP_DATA_TITLE.",".CPABC_TDEAPP_DATA_DESCRIPTION.",quantity) values(".$calid.",'".$datetime."','".esc_sql($title)."','".esc_sql($description)."','".$capacity."') ");
            echo  $wpdb->insert_id;

        }
    }

    exit();
}


function cpabc_appointment_cleanJSON($str)
{
    $str = str_replace('&qquot;','"',$str);
    $str = str_replace('	',' ',$str);
    $str = str_replace("\n",'\n',$str);
    $str = str_replace("\r",'',$str);
    return $str;
}

function cpabc_auto_language($calendar_language)
{
    if ($calendar_language == '-')
    {
        $calendar_language = substr(strtoupper(get_bloginfo('language')),0,2);
        $calendar_language = str_replace ( array('ES','CS','NL','JA','KO','NB','SV',''), 
                                           array('SP','CZ','DU','JP','KR','NW','SE',''), $calendar_language);
    }
    return $calendar_language;
}


function cpabc_appointment_get_site_url($admin = false)
{
    $blog = get_current_blog_id();
    if( $admin )
        $url = get_admin_url( $blog );
    else
        $url = get_home_url( $blog );

    $url = parse_url($url);
    $url = rtrim(@$url["path"],"/");
    return $url;
}


function cpabc_appointment_get_FULL_site_url($admin = false)
{
    $blog = get_current_blog_id();
    if( $admin )
        $url = get_admin_url( $blog );
    else
        $url = get_home_url( $blog );

    $url = parse_url($url);
    $url = rtrim(@$url["path"],"/");
    $pos = strpos($url, "://");
    if ($pos === false)
        $url = 'http://'.$_SERVER["HTTP_HOST"].$url;
    return $url;
}


// cpabc_cpabc_get_option:
$cpabc_option_buffered_item = false;
$cpabc_option_buffered_id = -1;

function cpabc_get_option ($field, $default_value = '')
{
    global $wpdb, $cpabc_option_buffered_item, $cpabc_option_buffered_id;
    if (!defined('CP_CALENDAR_ID'))
        $id = 0;
    else
        $id = CP_CALENDAR_ID;
    if ($cpabc_option_buffered_id == $id)
        $value = @$cpabc_option_buffered_item->$field;
    else
    {

       $myrows = $wpdb->get_results( "SELECT * FROM ".CPABC_APPOINTMENTS_CONFIG_TABLE_NAME." WHERE id=".intval($id) );
       $value = @$myrows[0]->$field;
       $cpabc_option_buffered_item = @$myrows[0];
       $cpabc_option_buffered_id  = $id;
    }
    if ($value == '' && @$cpabc_option_buffered_item->calendar_language == '')
        $value = $default_value;
    return $value;
}

function cpabc_appointment_is_administrator()
{
    return current_user_can('manage_options');
}


$codepeople_promote_banner_plugins[ 'appointment-booking-calendar' ] = array( 
                      'plugin_name' => 'Appointment Booking Calendar', 
                      'plugin_url'  => 'https://wordpress.org/support/plugin/appointment-booking-calendar/reviews/#new-post'
);
require_once 'banner.php';

?>