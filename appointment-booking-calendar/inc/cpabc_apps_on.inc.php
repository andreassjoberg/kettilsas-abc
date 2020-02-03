<?php


if ( ! defined( 'ABSPATH' ) ) 
{
    echo 'Direct access not allowed.';
    exit;
}


function _cpabc_appointments_install() {
    global $wpdb;

    update_option('CP_ABC_JS', ''); // clean this option
    
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
         id int(10) NOT NULL AUTO_INCREMENT,
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

    $sql = 'INSERT INTO `'.$wpdb->prefix.CPABC_APPOINTMENTS_CONFIG_TABLE_NAME.'` (conwer,calendar_theme,`form_structure`,`'.CPABC_TDEAPP_CONFIG_ID.'`,`'.CPABC_TDEAPP_CONFIG_TITLE.'`,`'.CPABC_TDEAPP_CONFIG_USER.'`,`'.CPABC_TDEAPP_CONFIG_PASS.'`,`'.CPABC_TDEAPP_CONFIG_LANG.'`,`'.CPABC_TDEAPP_CONFIG_CPAGES.'`,`'.CPABC_TDEAPP_CONFIG_TYPE.'`,`'.CPABC_TDEAPP_CONFIG_MSG.'`,`'.CPABC_TDEAPP_CONFIG_WORKINGDATES.'`,`'.CPABC_TDEAPP_CONFIG_RESTRICTEDDATES.'`,`'.CPABC_TDEAPP_CONFIG_TIMEWORKINGDATES0.'`,`'.CPABC_TDEAPP_CONFIG_TIMEWORKINGDATES1.'`,`'.CPABC_TDEAPP_CONFIG_TIMEWORKINGDATES2.'`,`'.CPABC_TDEAPP_CONFIG_TIMEWORKINGDATES3.'`,`'.CPABC_TDEAPP_CONFIG_TIMEWORKINGDATES4.'`,`'.CPABC_TDEAPP_CONFIG_TIMEWORKINGDATES5.'`,`'.CPABC_TDEAPP_CONFIG_TIMEWORKINGDATES6.'`,`'.CPABC_TDEAPP_CALDELETED_FIELD.'`) '.
                                                                                ' VALUES(0,"modern/","'.esc_sql(CPABC_APPOINTMENTS_DEFAULT_form_structure).'","1","cal1","Calendar Item 1","","-","1","3","Please, select your appointment.","1,2,3,4,5","","","9:0,10:0,11:0,12:0,13:0,14:0,15:0,16:0","9:0,10:0,11:0,12:0,13:0,14:0,15:0,16:0","9:0,10:0,11:0,12:0,13:0,14:0,15:0,16:0","9:0,10:0,11:0,12:0,13:0,14:0,15:0,16:0","9:0,10:0,11:0,12:0,13:0,14:0,15:0,16:0","","0");';
    $wpdb->query($sql);

    $rcode = get_option('ABC_RCODE','');
    if ($rcode == '')
    {
        $rcode = wp_generate_uuid4();
        update_option( 'ABC_RCODE', $rcode);
    }
    
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

}


function _cpabc_appointments_get_default_paypal_email() 
{
    return get_the_author_meta('user_email', get_current_user_id());
}


function _cpabc_appointments_get_default_from_email() 
{
    $default_from = strtolower(get_the_author_meta('user_email', get_current_user_id()));
    $domain = str_replace('www.','', strtolower($_SERVER["HTTP_HOST"]));                                  
    while (substr_count($domain,".") > 1)
        $domain = substr($domain, strpos($domain, ".")+1);            
    $pos = strpos($default_from, $domain);
    if (substr_count($domain,".") == 1 && $pos === false)
        return 'admin@'.$domain;
    else    
        return $default_from;
}


/* Filter for placing the maps into the contents */
function cpabc_appointments_filter_content($atts) {
    global $wpdb;
    extract( shortcode_atts( array(
		'calendar' => '',
		'user' => '',
	), $atts ) );
    $calendar = 1;
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
    echo '<link rel="stylesheet" type="text/css" href="'.plugins_url('../TDE_AppCalendar/'.cpabc_get_option('calendar_theme','modern/').'all-css.css', __FILE__).'" />';
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

    $previous_label = __("Previous",'appointment-booking-calendar');
    $next_label = __("Next",'appointment-booking-calendar');

    wp_enqueue_script( 'jquery' );
    if (!isset($_GET["fl_builder"]))  
        wp_enqueue_script( 'cpabc_calendarscript', plugins_url('../TDE_AppCalendar/all-scripts.js?nc=1', __FILE__));

    $calendar_items = '';
    foreach ($myrows as $item)
      $calendar_items .=  '<option value='.$item->id.'>'.$item->uname.'</option>';

    $cpabc_buffer = "";
    $services = array();


    $codes = $wpdb->get_results( 'SELECT * FROM '.CPABC_APPOINTMENTS_DISCOUNT_CODES_TABLE_NAME.' WHERE `cal_id`='.CP_CALENDAR_ID);

    $quant_buffer = '';
    if (CPABC_APPOINTMENTS_ENABLE_QUANTITY_FIELD)
    {
        $quant_buffer = __('Quantity','appointment-booking-calendar').':<br /><select id="abc_capacity" name="abc_capacity" onchange="apc_clear_date();">';
        for ($i=1; $i<=CPABC_APPOINTMENTS_ENABLE_QUANTITY_FIELD; $i++)
            $quant_buffer .= '<option'.($i==1?' selected="selected"':'').'>'.$i.'</option>';
        $quant_buffer .= '</select><br />';
    }

    ?>
</p> <!-- this p tag fixes a IE bug -->
<link rel="stylesheet" type="text/css" href="<?php echo plugins_url('../TDE_AppCalendar/'.(is_admin()?'':cpabc_get_option('calendar_theme','modern/')).'all-css.css', __FILE__); ?>" />
<script>
var pathCalendar = "<?php echo cpabc_appointment_get_site_url(); ?>";
var cpabc_global_date_format = '<?php echo cpabc_get_option('calendar_dateformat', CPABC_APPOINTMENTS_DEFAULT_CALENDAR_DATEFORMAT); ?>';
var cpabc_global_military_time = '<?php echo cpabc_get_option('calendar_militarytime', CPABC_APPOINTMENTS_DEFAULT_CALENDAR_MILITARYTIME); ?>';
var cpabc_global_start_weekday = '<?php echo cpabc_get_option('calendar_weekday', CPABC_APPOINTMENTS_DEFAULT_CALENDAR_WEEKDAY); ?>';
var cpabc_global_mindate = '<?php $value = cpabc_get_option('calendar_mindate', CPABC_APPOINTMENTS_DEFAULT_CALENDAR_MINDATE); if ($value != '') echo date("n/j/Y", strtotime($value)); ?>';
var cpabc_global_maxdate = '<?php $value = cpabc_get_option('calendar_maxdate', CPABC_APPOINTMENTS_DEFAULT_CALENDAR_MAXDATE); if ($value != '') echo date("n/j/Y",strtotime($value)); ?>';
var cpabc_global_close_on_select = <?php $value = cpabc_get_option('close_fpanel', 'yes'); if ($value == '' || $value == 'yes') echo 'true'; else echo 'false'; ?>;
var cpabc_global_cancel_text = '<?php _e("Cancel",'appointment-booking-calendar'); ?>';
var cpabc_global_pagedate = '<?php
    $sm = cpabc_get_option('calendar_startmonth', date("n"));
    $sy = cpabc_get_option('calendar_startyear', date("Y"));
    if ($sm=='0' || $sm=='') $sm = date("n");
    if ($sy=='0' || $sy=='') $sy = date("Y");
    echo $sm."/".$sy;
?>';
</script>
<script type="text/javascript">
 var cpabc_current_calendar_item;
 var cpabc_current_calendar_initialized = false;
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
    try {
        cpabc_current_calendar_item = id;
        document.getElementById("calarea_"+cpabc_current_calendar_item).style.display = "";
        <?php if (!isset($_GET["fl_builder"])) { ?>initAppCalendar("cal"+cpabc_current_calendar_item,<?php echo (is_admin()?'3':cpabc_get_option('calendar_pages', CPABC_APPOINTMENTS_DEFAULT_CALENDAR_PAGES)); ?>,2,"<?php echo cpabc_auto_language(cpabc_get_option('calendar_language', CPABC_APPOINTMENTS_DEFAULT_CALENDAR_LANGUAGE)); ?>",{m1:"<?php _e('Please select the appointment time.','appointment-booking-calendar'); ?>"});<?php } ?>
        cpabc_current_calendar_initialized = true;
    } catch (e) {}    
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
 var cpabc_max_slots = <?php $opt = cpabc_get_option('max_slots', '1'); if ($opt == '') $opt = '1'; echo $opt; ?>;
 var cpabc_max_slots_text = '<?php echo str_replace("'","\'",__('Please select a maximum of %1 time-slots. Currently selected: %2 time-slots.','appointment-booking-calendar')); ?>';
 cpabc_max_slots_text = cpabc_max_slots_text.replace('%1',cpabc_max_slots);
 cpabc_max_slots_text = cpabc_max_slots_text.replace('%2',cpabc_max_slots);
 cpabc_current_calendar_item = <?php echo $myrows[0]->id; ?>;
 cpabc_do_init(cpabc_current_calendar_item);
 setInterval('updatedate()',200);
 function doValidate(form)
 {
    if (!cpabc_click_enabled) return false;
    var visitortime = new Date();
    form.cpabc_appointments_utime.value = "GMT " + -visitortime.getTimezoneOffset()/60;
    if (form.phone.value == '')
    {
        alert('<?php echo str_replace("'","\'",__('Please enter a valid phone number','appointment-booking-calendar')); ?>.');
        return false;
    }
    if (form.email.value == '')
    {
        alert('<?php echo str_replace("'","\'",__('Please enter a valid email address','appointment-booking-calendar')); ?>.');
        return false;
    }
    if (form.name.value == '')
    {
        alert('<?php echo str_replace("'","\'",__('Please write your name','appointment-booking-calendar')); ?>.');
        return false;
    }
    var selst = ""+document.getElementById("selDaycal"+cpabc_current_calendar_item).value;    
    if (selst == '')
    {
        alert('<?php echo str_replace("'","\'",__('Please select date and time','appointment-booking-calendar')); ?>.');
        return false;
    }
    selst = selst.match(/;/g);selst = selst.length;
    if (selst < <?php $opt = cpabc_get_option('min_slots', '1'); if ($opt == '') $opt = '1'; echo $opt; ?>)
    {
        var almsg = '<?php echo str_replace("'","\'",__('Please select at least %1 time-slots. Currently selected: %2 time-slots.','appointment-booking-calendar')); ?>';
        almsg = almsg.replace('%1','<?php echo $opt; ?>');
        almsg = almsg.replace('%2',selst);
        alert(almsg);
        return false;
    }
    if (selst > <?php $opt = cpabc_get_option('max_slots', '1'); if ($opt == '') $opt = '1'; echo $opt; ?>)
    {
        var almsg = '<?php echo str_replace("'","\'",__('Please select a maximum of %1 time-slots. Currently selected: %2 time-slots.','appointment-booking-calendar')); ?>';
        almsg = almsg.replace('%1','<?php echo $opt; ?>');
        almsg = almsg.replace('%2',selst);
        alert(almsg);
        return false;
    } 
    <?php if (!is_admin() && cpabc_get_option('dexcv_enable_captcha', CPABC_TDEAPP_DEFAULT_dexcv_enable_captcha) != 'false') { ?> if (form.hdcaptcha.value == '')
    {
        alert('<?php echo str_replace("'","\'",__('Please enter the captcha verification code','appointment-booking-calendar')); ?>.');
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
        alert('<?php echo str_replace("'","\'",__('Incorrect captcha code. Please try again.','appointment-booking-calendar')); ?>');
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
    $settings_link = '<a href="admin.php?page=cpabc_appointments.php">'.__('Settings','appointment-booking-calendar').'</a>';
	array_unshift($links, $settings_link);
	return $links;
}


function cpabc_helpLink($links) {
    $help_link = '<a href="https://abc.dwbooster.com/support">'.__('Help','appointment-booking-calendar').'</a>';
	array_unshift($links, $help_link);
	return $links;
}

function cpabc_customAdjustmentsLink($links) {
    $customAdjustments_link = '<a href="https://abc.dwbooster.com/download">'.__('Upgrade To Premium','appointment-booking-calendar').'</a>';
	array_unshift($links, $customAdjustments_link);
	return $links;
}

function cpabc_appointments_html_post_page() {
    global $wpdb;
    if ((isset($_GET["cal"]) && $_GET["cal"] != '') || ( @$_GET["cal"] == '0' || @$_GET["pwizard"] == '1'))
    {
        $_GET["cal"] = intval(@$_GET["cal"]);
        if (isset($_GET["edit"]) && $_GET["edit"] == '1')
            @include_once dirname( __FILE__ ) . '/cp_admin_int_edition.inc.php';
        else if (isset($_GET["list"]) && $_GET["list"] == '1')
            @include_once dirname( __FILE__ ) . '/cpabc_appointments_admin_int_bookings_list.inc.php';
        else if (isset($_GET["calschedule"]) && $_GET["calschedule"] == '1')
            @include_once dirname( __FILE__ ) . '/../mv/calendar_schedule.inc.php';        
        else if (@$_GET["pwizard"] == '1')
            @include_once dirname( __FILE__ ) . '/cpabc_publish_wizzard.inc.php';
        else if (isset($_GET["addbk"]) && $_GET["addbk"] == '1')
            @include_once dirname( __FILE__ ) . '/cpabc_appointments_admin_addbk.inc.php';
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
    print '<a href="javascript:send_to_editor(\'[CPABC_APPOINTMENT_CALENDAR calendar=&quot;1&quot;]\');" title="'.__('Insert Appointment Booking Calendar').'"><img hspace="5" src="'.plugins_url('../images/cpabc_apps.gif', __FILE__).'" alt="'.__('Insert  Appointment Booking Calendar','appointment-booking-calendar').'" /></a>';
}


function set_cpabc_apps_insert_adminScripts($hook) {
    if (isset($_GET["cal"]) && $_GET["cal"] != '' && isset($_GET["page"]) && $_GET["page"] == 'cpabc_appointments.php')
    {
        wp_enqueue_script( 'jquery' );
        wp_enqueue_script( 'jquery-ui-core' );
        wp_enqueue_script( 'jquery-ui-datepicker' );
        wp_enqueue_script( 'tinymce_js', includes_url( 'js/tinymce/' ) . 'wp-tinymce.php', array( 'jquery' ), false, true );
        
        if (isset($_GET["calschedule"]) && $_GET["calschedule"] == '1')
        {
            wp_enqueue_script( 'jquery-ui-dialog' );

            wp_enqueue_script( 'cpabc_mvuscore', plugins_url('../mv/js/underscore.js', __FILE__), array( 'jquery', 'jquery-ui-core', 'jquery-ui-datepicker' ) );
            wp_enqueue_script( 'cpabc_mvrrule', plugins_url('../mv/js/rrule.js', __FILE__), array( 'jquery', 'jquery-ui-core', 'jquery-ui-datepicker' ) );
            wp_enqueue_script( 'cpabc_mvcommon', plugins_url('../mv/js/Common.js', __FILE__), array( 'jquery', 'jquery-ui-core', 'jquery-ui-datepicker' ) );                      
            
            if (file_exists(dirname( __FILE__ ).'../mv/language/multiview_lang_'.cpabc_mv_autodetect_language().'.js'))
                $langscript = plugins_url('../mv/language/multiview_lang_'.cpabc_mv_autodetect_language().'.js', __FILE__);
            else
                $langscript = plugins_url('../mv/language/multiview_lang_en_GB.js', __FILE__);
            wp_enqueue_script( 'cpabc_mvlanguage', $langscript, array( 'jquery', 'jquery-ui-core', 'jquery-ui-datepicker' ) );     

            wp_enqueue_script( 'cpabc_mvcalendar', plugins_url('../mv/js/jquery.calendar.js', __FILE__), array( 'jquery', 'jquery-ui-core', 'jquery-ui-datepicker' ) );
            wp_enqueue_script( 'cpabc_mvjalert', plugins_url('../mv/js/jquery.alert.js', __FILE__), array( 'jquery', 'jquery-ui-core', 'jquery-ui-datepicker' ) );
            wp_enqueue_script( 'cpabc_mvmsjs', plugins_url('../mv/js/multiview.js', __FILE__), array( 'jquery', 'jquery-ui-core', 'jquery-ui-datepicker' ) );         
            
            wp_enqueue_style('cpabc-schedulecalendar', plugins_url('../mv/css/cupertino/calendar.css', __FILE__));
            wp_enqueue_style('cpabc-schedulemain', plugins_url('../mv/css/main.css', __FILE__));
        }
        
        if (isset($_GET["addbk"]) && $_GET["addbk"] == '1')
        {
            wp_enqueue_script( 'cpabc_repeat', plugins_url('../js/repeat.js', __FILE__), array( 'jquery', 'jquery-ui-core', 'jquery-ui-datepicker' ));
            wp_enqueue_script( 'cpabc_rrule', plugins_url('../js/rrule.js', __FILE__), array( 'jquery', 'jquery-ui-core', 'jquery-ui-datepicker' ) );
        }
        wp_enqueue_style('jquery-ui-datepicker', plugins_url('../TDE_AppCalendar/cupertino/jquery-ui-1.8.20.custom.css', __FILE__));
        
        if (!isset($_GET["addbk"]))
        {
            wp_enqueue_style('cpabc-allstyle', plugins_url('../TDE_AppCalendar/all-css.css', __FILE__));
            wp_enqueue_script( 'cpabc_alljs', plugins_url('../TDE_AppCalendar/all-scripts.js', __FILE__));
            wp_enqueue_script( 'cpabc_tabview', plugins_url('../TDE_AppCalendar/tabview.js', __FILE__), array('cpabc_alljs'));
            wp_enqueue_script( 'cpabc_simpleeditor', plugins_url('../TDE_AppCalendar/simpleeditor-beta-min.js', __FILE__), array('cpabc_alljs'));
        }
        wp_enqueue_style('cpabc-sestyle', plugins_url('../TDE_AppCalendar/simpleeditor.css', __FILE__));
        wp_enqueue_style('cpabc-tbstyle', plugins_url('../TDE_AppCalendar/tabview.css', __FILE__));  
    }
    if( 'post.php' != $hook  && 'post-new.php' != $hook )
        return;
}


function cpabc_export_iCal() {
    global $wpdb;
    header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=events".date("Y-M-D_H.i.s").".ics");

    define('CPABC_CAL_TIME_ZONE_MODIFY',get_option('CPABC_CAL_TIME_ZONE_MODIFY_SET'," +0 hours"));
    define('CPABC_CAL_TIME_SLOT_SIZE'," +".get_option('CPABC_CAL_TIME_SLOT_SIZE_SET',"30")." minutes");

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

function cpabc_mv_autodetect_language()
{
        $basename = '/language/multiview_lang_';
        
        $binfo = str_replace('-','_',get_bloginfo('language'));
        
        $options = array ($binfo,
                          strtolower($binfo),
                          substr(strtolower($binfo),0,2)."_".substr(strtoupper($binfo),strlen(strtoupper($binfo))-2,2),
                          substr(strtolower($binfo),0,2),
                          substr(strtolower($binfo),strlen(strtolower($binfo))-2,2)                      
                          );
        foreach ($options as $option)
        {
            if (file_exists(dirname( __FILE__ ).$basename.$option.'.js'))
                return $option;
            $option = str_replace ("-","_", $option);    
            if (file_exists(dirname( __FILE__ ).$basename.$option.'.js'))
                return $option;
        }  
        return '';    
}

require_once 'cpabc_apps_go.inc.php';

?>