<?php

if ( ! defined( 'ABSPATH' ) ) 
{
    echo 'Direct access not allowed.';
    exit;
}


function cpabc_appointments_main_initialization()
{
    global $wpdb;
    
	if ( isset( $_GET['cpabc_ipncheck'] ) && $_GET['cpabc_ipncheck'] != '' )
    {
        cpabc_appointments_check_IPN_verification();
		return;
    }    

    if(isset($_GET) && array_key_exists('cpabc_app',$_GET)) {
        if ( $_GET["cpabc_app"] == 'calfeed' )
        {
            if ($_GET["id"] != '' && substr(md5($_GET["id"].get_option('ABC_RCODE',$_SERVER["DOCUMENT_ROOT"])),0,10) == $_GET["verify"])
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

    if (isset( $_GET['cpabc_appointments_csv'] ) && is_admin() && current_user_can('edit_posts') )
    {
        cpabc_appointments_export_csv();
        return;
    }

    if (isset( $_GET['cpabc_app'] ) &&  $_GET['cpabc_app'] == 'cpabc_loadmindate' && is_admin() && current_user_can('edit_posts') )
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
    
    if (isset( $_GET['cpabc_app'] ) &&  $_GET['cpabc_app'] == 'cpabc_loadmaxdate' && is_admin() && current_user_can('edit_posts') )
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
       
    // if this isn't the expected post and isn't the captcha verification then nothing to do
	if ( 'POST' != $_SERVER['REQUEST_METHOD'] || ! isset( $_POST['cpabc_appointments_post'] ) )
		if ( 'GET' != $_SERVER['REQUEST_METHOD'] || !isset( $_GET['hdcaptcha'] ) )
		    return;


    if (function_exists('session_start')) @session_start();

    $hdcaptcha = '';
    if (isset($_GET["hdcaptcha"]) && $_GET['hdcaptcha'] != '') 
        $hdcaptcha = sanitize_text_field($_GET["hdcaptcha"]);        
    else if (isset($_POST["hdcaptcha"]) && $_POST['hdcaptcha']!= '') 
        $hdcaptcha = sanitize_text_field($_POST['hdcaptcha']);
    if (
           (!is_admin() && cpabc_get_option('dexcv_enable_captcha', CPABC_TDEAPP_DEFAULT_dexcv_enable_captcha) != 'false') &&
           ( (strtolower($hdcaptcha) != strtolower($_SESSION['rand_code'])) ||
             ($_SESSION['rand_code'] == '')
           )
           &&
           ( (md5(strtolower($hdcaptcha)) != ($_COOKIE['rand_code'])) ||
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

    $selectedCalendar = sanitize_key($_POST["cpabc_item"]);

    $selDaycal = sanitize_text_field($_POST["selDaycal".$selectedCalendar]);
    if (is_admin() && $_POST["selMonthcal".$selectedCalendar] != '' && $_POST["freq"] != '10')
        $selDaycal .= sanitize_text_field($_POST["selMonthcal".$selectedCalendar]);
    $pdateAndTime =   explode(";",str_replace(",","-", $selDaycal));    
    array_shift($pdateAndTime);

    $military_time = cpabc_get_option('calendar_militarytime', CPABC_APPOINTMENTS_DEFAULT_CALENDAR_MILITARYTIME);
    if (cpabc_get_option('calendar_militarytime', CPABC_APPOINTMENTS_DEFAULT_CALENDAR_MILITARYTIME) == '0') $format = "g:i A"; else $format = "H:i";

    $calendar_dformat = cpabc_get_option('calendar_dateformat', CPABC_APPOINTMENTS_DEFAULT_CALENDAR_DATEFORMAT);
    if ($calendar_dformat == '2')
        $format = "d.m.Y ".$format;
    else if ($calendar_dformat == '1')
        $format = "d/m/Y ".$format;
    else
        $format = "m/d/Y ".$format;

    $pdate = array();
    for($n=0;$n<count($pdateAndTime); $n++)
    {
        $pdateAndTime[$n] = date("Y-m-d H:i:s",strtotime($pdateAndTime[$n]));
        $pdate[$n] = date($format,strtotime($pdateAndTime[$n]));
    }

    $services_formatted = array();


    $price = explode(";",cpabc_get_option('request_cost', CPABC_APPOINTMENTS_DEFAULT_COST));
    foreach ($price as $item => $value)
       $price[$item] = trim(str_replace(',','', str_replace(CPABC_APPOINTMENTS_DEFAULT_CURRENCY_SYMBOL,'',
                                                 str_replace(CPABC_APPOINTMENTS_GBP_CURRENCY_SYMBOL,'',
                                                 str_replace(CPABC_APPOINTMENTS_EUR_CURRENCY_SYMBOL_A, '',
                                                 str_replace(CPABC_APPOINTMENTS_EUR_CURRENCY_SYMBOL_B,'', $value )))) ));

    if (isset($price[count($pdateAndTime)-1]))
        $price = $price[count($pdateAndTime)-1];
    else
        $price = $price[0] * count($pdateAndTime);


    // check discount codes
    //-------------------------------------------------
    $discount_note = "";
    $coupon = false;

    $params = array();
    $params["UTIMEZONE"] = sanitize_text_field(@$_POST["cpabc_appointments_utime"]);
    $params["PRICE"] = number_format ($price, 2);
    $params["COUPONCODE"] = ($coupon?"\nCoupon code:".$coupon->code.$discount_note."\n":"");
    $params["QUANTITY"] = sanitize_text_field(@$_POST["abc_capacity"]);

    // get form info
    //---------------------------
    $params["NAME"] = sanitize_text_field($_POST["name"]);
    $params["EMAIL"] = sanitize_email($_POST["email"]);
    $params["PHONE"] = sanitize_text_field($_POST["phone"]);
    $params["COMMENTS"] = sanitize_textarea_field($_POST["question"]);

    $buffer_A = sanitize_textarea_field($_POST["question"]);
    $to = "email";

    $_SESSION['rand_code'] = '';
    setCookie('rand_code', '', time()+36000,"/");

	/**
	 * Action called before insert the data into database.
	 * To the function is passed an array with submitted data.
	 */
	do_action_ref_array( 'cpabc_process_data_before_insert', array(&$params) );

    // insert into database
    //---------------------------

    if (date("Y",strtotime($pdateAndTime[0])) == "1970") // if this is spam, skip
        return;

    for ($n=0; $n<count($pdateAndTime); $n++)
    {
        $params["DATE"] = trim( substr($pdate[$n], 0, strpos($pdate[$n],' ') ) );
        $params["TIME"] = trim( substr($pdate[$n], strpos($pdate[$n],' ') ) );
        $rows_affected = $wpdb->insert( CPABC_APPOINTMENTS_TABLE_NAME, array( 'calendar' => $selectedCalendar,
                                                                        'time' => current_time('mysql'),
                                                                        'booked_time' => sanitize_text_field($pdate[$n]),
                                                                        'booked_time_unformatted' => $pdateAndTime[$n],
                                                                        'name' => "".sanitize_text_field(@$_POST["name"]),
                                                                        'email' => "".sanitize_email(@$_POST[$to]),
                                                                        'phone' => "".sanitize_text_field(@$_POST["phone"]),
                                                                        'question' => $buffer_A,
                                                                        'quantity' => (isset($_POST["abc_capacity"])?sanitize_text_field($_POST["abc_capacity"]):1),
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
    
	// Call action for data processing
	//---------------------------------
	$params[ 'itemnumber' ] = $item_number[0];
	$params[ 'itemnumbers' ] = $item_number;
	$params[ 'useremail' ] = "".sanitize_email(@$_POST[$to]);
	$params[ 'formid' ] = $selectedCalendar;    
	/**
	 * Action called after inserted the data into database.
	 * To the function is passed an array with submitted data.
	 */
     
	do_action( 'cpabc_process_data', $params );
    
    $item_number = implode(";", $item_number);
    
    if ( is_admin() && current_user_can('edit_posts') )
    {
        cpabc_process_ready_to_go_appointment($item_number, '');
        return;
    }

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
<input type="hidden" name="business" value="<?php echo sanitize_email(cpabc_get_option('paypal_email', _cpabc_appointments_get_default_paypal_email() )); ?>" />
<input type="hidden" name="item_name" value="<?php echo sanitize_text_field(cpabc_get_option('paypal_product_name', CPABC_APPOINTMENTS_DEFAULT_PRODUCT_NAME)); ?>" />
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

    $itemparam = sanitize_text_field($_GET["cpabc_ipncheck"]);
    
    $payment_status = sanitize_text_field($_POST['payment_status']);   
    $payer_email = sanitize_email($_POST['payer_email']);
    $payment_type = sanitize_text_field($_POST['payment_type']);
    $txnid = sanitize_text_field($_POST['txn_id']);

    if (CPABC_TDEAPP_CALENDAR_STEP2_VRFY)
    {
	    if ($payment_status != 'Completed' && $payment_type != 'echeck')
	        return;

	    if ($payment_type == 'echeck' && $payment_status == 'Completed')
    	    return;
    }
    
    $itemnumber = explode(";",$itemparam);
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
      
    
    cpabc_process_ready_to_go_appointment( $itemparam, $payer_email);

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
   $mycalendarrows = $wpdb->get_results( 'SELECT * FROM '.CPABC_APPOINTMENTS_CONFIG_TABLE_NAME .' WHERE `'.CPABC_TDEAPP_CONFIG_ID.'`='.intval($myrows[0]->calendar));
   $reminder_timeline = date( "Y-m-d H:i:s", strtotime (date("Y-m-d H:i:s")." +".$mycalendarrows[0]->reminder_hours." hours") );
   if (!defined('CP_CALENDAR_ID'))
        define ('CP_CALENDAR_ID',$myrows[0]->calendar);

   $SYSTEM_EMAIL = cpabc_get_option('notification_from_email', _cpabc_appointments_get_default_from_email() );
   $SYSTEM_RCPT_EMAIL = cpabc_get_option('notification_destination_email', _cpabc_appointments_get_default_paypal_email() );

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
           
           if (!is_admin() || isset($_POST["sendemails_admin"]))
           {
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
                            ($replyto!=''?"Reply-To: ".$replyto."\r\n":'').
                            $content_type.
                            "X-Mailer: PHP/" . phpversion(), $attachments);
                    }
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
    if ($_POST["cpabc_appointments_control_field"] == '\\"')    
        foreach ($_POST as $item => $value)
            if (!is_array($value))
                $_POST[$item] = stripcslashes($value);    


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


    $request_cost = '';
    for ($k=1;$k <= intval($_POST["max_slots"]); $k++)
        $request_cost .= ($k!=1?";":"").cpabc_clean_price($_POST["request_cost_".$k]);

    $data = array(
         'calendar_language' => sanitize_text_field($_POST["calendar_language"]),
         'calendar_dateformat' => sanitize_text_field($_POST["calendar_dateformat"]),
         'calendar_pages' => sanitize_text_field($_POST["calendar_pages"]),
         'calendar_militarytime' => sanitize_text_field($_POST["calendar_militarytime"]),
         'calendar_weekday' => sanitize_text_field($_POST["calendar_weekday"]),
         'calendar_mindate' => sanitize_text_field($_POST["calendar_mindate"]),
         'calendar_maxdate' => sanitize_text_field($_POST["calendar_maxdate"]),
         'min_slots' => sanitize_text_field($_POST["min_slots"]),
         'max_slots' => sanitize_text_field($_POST["max_slots"]),
         'close_fpanel' => sanitize_text_field($_POST["close_fpanel"]),
         'quantity_field' => sanitize_text_field($_POST["quantity_field"]),
         'paypal_mode' => sanitize_text_field($_POST["paypal_mode"]),

         'calendar_startyear' => sanitize_text_field($_POST["calendar_startyear"]),
         'calendar_startmonth' => sanitize_text_field($_POST["calendar_startmonth"]),
         'calendar_theme' => sanitize_text_field($_POST["calendar_theme"]),

         'paypal_email' => sanitize_email($_POST["paypal_email"]),
         'request_cost' => sanitize_text_field($request_cost),
         'paypal_product_name' => sanitize_text_field($_POST["paypal_product_name"]),
         'currency' => sanitize_text_field($_POST["currency"]),
         'url_ok' => sanitize_text_field($_POST["url_ok"]),
         'url_cancel' => sanitize_text_field($_POST["url_cancel"]),
         'paypal_language' => sanitize_text_field($_POST["paypal_language"]),

         'nuser_emailformat' => sanitize_text_field(@$_POST["nuser_emailformat"]),
         'nadmin_emailformat' => sanitize_text_field($_POST["nadmin_emailformat"]),
         'nremind_emailformat' => sanitize_text_field($_POST["nremind_emailformat"]),

         'vs_text_is_required' => sanitize_text_field($_POST['vs_text_is_required']),
         'vs_text_is_email' => sanitize_text_field($_POST['vs_text_is_email']),
         'vs_text_datemmddyyyy' => sanitize_text_field($_POST['vs_text_datemmddyyyy']),
         'vs_text_dateddmmyyyy' => sanitize_text_field($_POST['vs_text_dateddmmyyyy']),
         'vs_text_number' => sanitize_text_field($_POST['vs_text_number']),
         'vs_text_digits' => sanitize_text_field($_POST['vs_text_digits']),
         'vs_text_max' => sanitize_text_field($_POST['vs_text_max']),
         'vs_text_min' => sanitize_text_field($_POST['vs_text_min']),
         'vs_text_submitbtn' => sanitize_text_field($_POST['vs_text_submitbtn']),

         'cu_user_email_field' => sanitize_text_field(@$_POST["cu_user_email_field"]),

         'notification_from_email' => sanitize_text_field($_POST["notification_from_email"]),
         'notification_destination_email' => sanitize_text_field($_POST["notification_destination_email"]),
         'email_subject_confirmation_to_user' => sanitize_text_field($_POST["email_subject_confirmation_to_user"]),
         'email_confirmation_to_user' => cpabc_clean_and_sanitize($_POST["email_confirmation_to_user"]),
         'email_subject_notification_to_admin' => sanitize_text_field($_POST["email_subject_notification_to_admin"]),
         'email_notification_to_admin' => cpabc_clean_and_sanitize($_POST["email_notification_to_admin"]),

         'enable_reminder' => sanitize_text_field(@$_POST["enable_reminder"]),
         'reminder_hours' => sanitize_text_field(@$_POST["reminder_hours"]),
         'reminder_subject' => sanitize_text_field(@$_POST["reminder_subject"]),
         'reminder_content' => cpabc_clean_and_sanitize(@$_POST["reminder_content"]),

         'dexcv_enable_captcha' => sanitize_text_field($_POST["dexcv_enable_captcha"]),
         'dexcv_width' => sanitize_text_field($_POST["dexcv_width"]),
         'dexcv_height' => sanitize_text_field($_POST["dexcv_height"]),
         'dexcv_chars' => sanitize_text_field($_POST["dexcv_chars"]),
         'dexcv_min_font_size' => sanitize_text_field($_POST["dexcv_min_font_size"]),
         'dexcv_max_font_size' => sanitize_text_field($_POST["dexcv_max_font_size"]),
         'dexcv_noise' => sanitize_text_field($_POST["dexcv_noise"]),
         'dexcv_noise_length' => sanitize_text_field($_POST["dexcv_noise_length"]),
         'dexcv_background' => sanitize_text_field(str_replace('#','',$_POST['dexcv_background'])),
         'dexcv_border' => sanitize_text_field(str_replace('#','',$_POST['dexcv_border'])),
         'dexcv_font' => sanitize_text_field($_POST["dexcv_font"]),
         'cv_text_enter_valid_captcha' => sanitize_text_field($_POST['cv_text_enter_valid_captcha']),
         'cp_cal_checkboxes' => sanitize_text_field(@$_POST["cp_cal_checkboxes"])
	);
    $wpdb->update ( CPABC_APPOINTMENTS_CONFIG_TABLE_NAME, $data, array( 'id' => CP_CALENDAR_ID ));
}


function cpabc_clean_price($price)
{
    return preg_replace('/[^0-9.]+/', '', str_replace(',','.',$price));
}


function cpabc_clean_and_sanitize ($str)
{
    if ( is_object( $str ) || is_array( $str ) ) {
        return '';
    }
    $str = (string) $str; 
    $filtered = wp_check_invalid_utf8( $str );    
    while ( preg_match( '/%[a-f0-9]{2}/i', $filtered, $match ) ) 
        $filtered = str_replace( $match[0], '', $filtered );
    return trim($filtered);
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
    
    $cond = '';
    
    if ($_GET["search"] != '') $cond .= " AND (buffered_date like '%".esc_sql(sanitize_text_field($_GET["search"]))."%')";
    if ($_GET["dfrom"] != '') $cond .= " AND (`booked_time_unformatted` >= '".esc_sql(sanitize_text_field($_GET["dfrom"]))."')";
    if ($_GET["dto"] != '') $cond .= " AND (`booked_time_unformatted` <= '".esc_sql(sanitize_text_field($_GET["dto"]))." 23:59:59')";

    if (CP_CALENDAR_ID != 0) $cond .= " AND appointment_calendar_id=".intval(CP_CALENDAR_ID);

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
    {
        $hlabel = cpabc_appointments_iconv("utf-8", "ISO-8859-1//TRANSLIT//IGNORE", cpabc_appointments_get_field_name($fields[$i],@$form_data[0]));
        echo '"'.str_replace('"','""', $hlabel).'",';
    }
    echo "\n";
    foreach ($values as $item)
    {
        for ($i=0; $i<$end; $i++)
        {
            if (!isset($item[$i]))
                $item[$i] = '';
            if (is_array($item[$i]))
                $item[$i] = implode($item[$i],',');
            $item[$i] = cpabc_appointments_iconv("utf-8", "ISO-8859-1//TRANSLIT//IGNORE", $item[$i]);
            echo '"'.str_replace('"','""', $item[$i]).'",';
        }
        echo "\n";
    }

    exit;
}


function cpabc_appointments_iconv($from, $to, $text)
{
    $text = trim($text);
    if ( strlen($text) > 1 && (in_array(substr($text,0,1), array('=','@','+','-'))) )
    {
        if (substr($text,0,1) != '-' || floatval($text)."" != $text)
            $text = chr(9).$text;
    }
    if (function_exists('iconv'))
        return iconv($from, $to, $text);
    else
        return $text;
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
    $query = "SELECT * FROM ".CPABC_TDEAPP_CALENDAR_DATA_TABLE." where ".CPABC_TDEAPP_DATA_IDCALENDAR."='".esc_sql($calid)."' ORDER BY ".CPABC_TDEAPP_DATA_DATETIME." ASC";
    $row_array = $wpdb->get_results($query,ARRAY_A);
    
    if (isset($_GET["cpabc_action"]) && $_GET["cpabc_action"] == 'mvparse' && is_admin() && current_user_can('edit_posts'))
    {
        $ret = array();
        $ret['events'] = array();
        $ret["issort"] = true;
        $ret['error'] = null;
        $d1 = cpabc_js2PhpTime($_POST["startdate"]);
        $d2 = cpabc_js2PhpTime($_POST["enddate"]);
        $d1 = mktime(0, 0, 0,  date("m", $d1), date("d", $d1), date("Y", $d1));
        $d2 = mktime(0, 0, 0, date("m", $d2), date("d", $d2), date("Y", $d2))+24*60*60-1;
        $ret["start"] = cpabc_php2JsTime($d1);
        $ret["end"] = cpabc_php2JsTime($d2);
        
        define('CPABC_CAL_TIME_SLOT_SIZE'," +".get_option('CPABC_CAL_TIME_SLOT_SIZE_SET',"30")." minutes");
        
        foreach ($row_array as $row)
        {
            //if ($ret["start"] == '' || $ret["start"] > strtotime($row[CPABC_TDEAPP_DATA_DATETIME]))
            //    $ret["start"] = strtotime($row[CPABC_TDEAPP_DATA_DATETIME]);
            //if ($ret["end"] == '' || $ret["end"] < strtotime($row[CPABC_TDEAPP_DATA_DATETIME]))
            //    $ret["end"] = strtotime($row[CPABC_TDEAPP_DATA_DATETIME]);
            $ev = array(
                $row["id"],
                $row[CPABC_TDEAPP_DATA_TITLE],
                cpabc_php2JsTime(cpabc_mySql2PhpTime($row[CPABC_TDEAPP_DATA_DATETIME])),
                cpabc_php2JsTime(cpabc_mySql2PhpTime( date("Y-m-d H:i",strtotime($row[CPABC_TDEAPP_DATA_DATETIME].CPABC_CAL_TIME_SLOT_SIZE)))),
                0, // is  all day event?
                0, // more than one day event
                '',//Recurring event rule,
                '#3CF',
                0,//editable
                '',
                '',//$attends
                $row[CPABC_TDEAPP_DATA_DESCRIPTION],
                '',
                1
            );
            $ret['events'][] = $ev;
        }
        echo json_encode($ret);
        exit;
    }
    
    
    foreach ($row_array as $row)
    {
        echo $row[CPABC_TDEAPP_DATA_ID]."\n";
        $dn =  explode(" ", $row[CPABC_TDEAPP_DATA_DATETIME]);
        $d1 =  explode("-", $dn[0]);
        $d2 =  explode(":", $dn[1]);

        echo intval($d1[0]).",".intval($d1[1]).",".intval($d1[2])."\n";
        echo intval($d2[0]).":".($d2[1])."\n";
        echo ($row["quantity"]?$row["quantity"]:'1')."\n";
        if (is_admin() && current_user_can('edit_posts'))
        {
            echo $row[CPABC_TDEAPP_DATA_TITLE]."\n";
            echo $row[CPABC_TDEAPP_DATA_DESCRIPTION]."\n*-*\n";
        }
        else
        {
            echo "Booked\n";
            echo "OK\n*-*\n";
        }
    }

    exit();
}


function cpabc_js2PhpTime($jsdate){
  if(preg_match('@(\d+)/(\d+)/(\d+)\s+(\d+):(\d+)((am|pm)*)@', $jsdate, $matches)==1){
    if ($matches[6]=="pm")
        if ($matches[4]<12)
            $matches[4] += 12;
    $ret = mktime($matches[4], $matches[5], 0, $matches[1], $matches[2], $matches[3]);
  }else if(preg_match('@(\d+)/(\d+)/(\d+)@', $jsdate, $matches)==1){
    $ret = mktime(0, 0, 0, $matches[1], $matches[2], $matches[3]);
  }
  return $ret;
}


function cpabc_php2MySqlTime($phpDate){
    return date("Y-m-d H:i:s", $phpDate);
}


function cpabc_php2JsTime($phpDate){
    return @date("m/d/Y H:i", $phpDate);
}


function cpabc_mySql2PhpTime($sqlDate){
    $a1 = explode (" ",$sqlDate);
    $a2 = explode ("-",$a1[0]);
    $a3 = explode (":",$a1[1]);
    $t = mktime($a3[0],$a3[1],$a3[2],$a2[1],$a2[2],$a2[0]);
    return $t;
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
        $wpdb->query("update  ".CPABC_TDEAPP_CONFIG." set specialDates='".esc_sql(sanitize_text_field($_POST["specialDates"]))."',".CPABC_TDEAPP_CONFIG_WORKINGDATES."='".esc_sql(sanitize_text_field($_POST["workingDates"]))."',".CPABC_TDEAPP_CONFIG_RESTRICTEDDATES."='".esc_sql(sanitize_text_field($_POST["restrictedDates"]))."',".CPABC_TDEAPP_CONFIG_TIMEWORKINGDATES0."='".esc_sql(sanitize_text_field($_POST["timeWorkingDates0"]))."',".CPABC_TDEAPP_CONFIG_TIMEWORKINGDATES1."='".esc_sql(sanitize_text_field($_POST["timeWorkingDates1"]))."',".CPABC_TDEAPP_CONFIG_TIMEWORKINGDATES2."='".esc_sql(sanitize_text_field($_POST["timeWorkingDates2"]))."',".CPABC_TDEAPP_CONFIG_TIMEWORKINGDATES3."='".esc_sql(sanitize_text_field($_POST["timeWorkingDates3"]))."',".CPABC_TDEAPP_CONFIG_TIMEWORKINGDATES4."='".esc_sql(sanitize_text_field($_POST["timeWorkingDates4"]))."',".CPABC_TDEAPP_CONFIG_TIMEWORKINGDATES5."='".esc_sql(sanitize_text_field($_POST["timeWorkingDates5"]))."',".CPABC_TDEAPP_CONFIG_TIMEWORKINGDATES6."='".esc_sql(sanitize_text_field($_POST["timeWorkingDates6"]))."'  where ".CPABC_TDEAPP_CONFIG_ID."=".$calid);

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
            $wpdb->query("delete from ".CPABC_TDEAPP_CALENDAR_DATA_TABLE." where ".CPABC_TDEAPP_DATA_IDCALENDAR."=".intval($calid)." and ".CPABC_TDEAPP_DATA_ID."=".intval($_POST["sqlId"]));
        else if ($_GET["act"]=='edit')
        {
            $data = explode("\n", $_POST["appoiments"]);
            $d1 =  explode(",", $data[0]);
            $d2 =  explode(":", $data[1]);
	        $datetime = sanitize_text_field($d1[0])."-".sanitize_text_field($d1[1])."-".sanitize_text_field($d1[2])." ".sanitize_text_field($d2[0]).":".sanitize_text_field($d2[1]);
	        $capacity = sanitize_text_field($data[2]);
	        $title = sanitize_text_field($data[3]);  
            $description = "";
            for ($j=4;$j<count($data);$j++)
            {
                $description .= cpabc_clean_and_sanitize($data[$j]);
                if ($j!=count($data)-1)
                    $description .= "\n";
            }
            $wpdb->query("update  ".CPABC_TDEAPP_CALENDAR_DATA_TABLE." set ".CPABC_TDEAPP_DATA_DATETIME."='".esc_sql($datetime)."',quantity='".esc_sql($capacity)."',".CPABC_TDEAPP_DATA_TITLE."='".esc_sql($title)."',".CPABC_TDEAPP_DATA_DESCRIPTION."='".esc_sql($description)."'  where ".CPABC_TDEAPP_DATA_IDCALENDAR."=".intval($calid)." and ".CPABC_TDEAPP_DATA_ID."=".intval($_POST["sqlId"]));
        }
        else if ($_GET["act"]=='add')
        {
            $data = explode("\n", $_POST["appoiments"]); 
            $d1 =  explode(",", $data[0]);
            $d2 =  explode(":", $data[1]);
	        $datetime = sanitize_text_field($d1[0])."-".sanitize_text_field($d1[1])."-".sanitize_text_field($d1[2])." ".sanitize_text_field($d2[0]).":".sanitize_text_field($d2[1]);
	        $capacity = sanitize_text_field($data[2]);
	        $title = sanitize_text_field($data[3]);
            $description = "";
            for ($j=4;$j<count($data);$j++)
            {
                $description .= cpabc_clean_and_sanitize($data[$j]);
                if ($j!=count($data)-1)
                    $description .= "\n";
            }
            $wpdb->query("insert into ".CPABC_TDEAPP_CALENDAR_DATA_TABLE."(".CPABC_TDEAPP_DATA_IDCALENDAR.",".CPABC_TDEAPP_DATA_DATETIME.",".CPABC_TDEAPP_DATA_TITLE.",".CPABC_TDEAPP_DATA_DESCRIPTION.",quantity) values(".intval($calid).",'".esc_sql($datetime)."','".esc_sql($title)."','".esc_sql($description)."','".esc_sql($capacity)."') ");
            echo  $wpdb->insert_id;

        }
    }

    exit();
}

function cpabc_get_captcha_params()
{
    $str = '&inAdmin=1';
    $tmp = cpabc_get_option('dexcv_width', CPABC_TDEAPP_DEFAULT_dexcv_width);
    if ($tmp != CPABC_TDEAPP_DEFAULT_dexcv_width)  $str .='&width='.$tmp;
    
    $tmp = cpabc_get_option('dexcv_height', CPABC_TDEAPP_DEFAULT_dexcv_height);
    if ($tmp != CPABC_TDEAPP_DEFAULT_dexcv_height) $str .='&height='.$tmp;
    
    $tmp = cpabc_get_option('dexcv_chars', CPABC_TDEAPP_DEFAULT_dexcv_chars);
    if ($tmp != CPABC_TDEAPP_DEFAULT_dexcv_chars) $str .='&letter_count='.$tmp;
    
    $tmp = cpabc_get_option('dexcv_min_font_size', CPABC_TDEAPP_DEFAULT_dexcv_min_font_size);
    if ($tmp != CPABC_TDEAPP_DEFAULT_dexcv_min_font_size) $str .='&min_size='.$tmp;
    
    $tmp = cpabc_get_option('dexcv_max_font_size', CPABC_TDEAPP_DEFAULT_dexcv_max_font_size);
    if ($tmp != CPABC_TDEAPP_DEFAULT_dexcv_max_font_size) $str .='&max_size='.$tmp;
    
    $tmp = cpabc_get_option('dexcv_noise', CPABC_TDEAPP_DEFAULT_dexcv_noise);
    if ($tmp != CPABC_TDEAPP_DEFAULT_dexcv_noise) $str .='&noise='.$tmp;
    
    $tmp = cpabc_get_option('dexcv_noise_length', CPABC_TDEAPP_DEFAULT_dexcv_noise_length);
    if ($tmp != CPABC_TDEAPP_DEFAULT_dexcv_noise_length) $str .='&noiselength='.$tmp;
    
    $tmp = cpabc_get_option('dexcv_background', CPABC_TDEAPP_DEFAULT_dexcv_background);
    if ($tmp != CPABC_TDEAPP_DEFAULT_dexcv_background) $str .='&bcolor='.$tmp;
    
    $tmp = cpabc_get_option('dexcv_border', CPABC_TDEAPP_DEFAULT_dexcv_border);
    if ($tmp != CPABC_TDEAPP_DEFAULT_dexcv_border) $str .='&border='.$tmp;
    
    $tmp = cpabc_get_option('dexcv_font', CPABC_TDEAPP_DEFAULT_dexcv_font);
    if ($tmp != CPABC_TDEAPP_DEFAULT_dexcv_font) $str .='&font='.$tmp;
    
    return $str;    
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

function cpabc_data_management_loaded() 
{
    global $wpdb, $cpabc_postURL;

    $action = sanitize_text_field(@$_POST['cpabc_do_action_loaded']);
	if (!$action) return; // go out if the call isn't for this one

    if ($_POST['cpabc_publish_id']) $item = intval($_POST['cpabc_publish_id']);

    if ($action == "wizard" && wp_verify_nonce( $_POST['nonce'], 'abc_update_actions_pwizard' ) && current_user_can('manage_options'))
    {
        $shortcode = '[CPABC_APPOINTMENT_CALENDAR calendar="'.$item .'"]';
        $cpabc_postURL = cpabc_publish_on(    sanitize_text_field(@$_POST["whereto"]), 
                                              sanitize_text_field(@$_POST["publishpage"]), 
                                              sanitize_text_field(@$_POST["publishpost"]), 
                                              @$shortcode, 
                                              sanitize_text_field(@$_POST["posttitle"]));            
        return;
    }

    // ...
    echo 'Some unexpected error happened. If you see this error contact the support service at https://bccf.dwbooster.com/contact-us';

    exit();
}    


function cpabc_publish_on($whereto, $publishpage = '', $publishpost = '', $content = '', $posttitle = 'Booking Form')
{
    global $wpdb;
    $id = '';
    if ($whereto == '0' || $whereto =='1') // new page
    {
        $my_post = array(
          'post_title'    => $posttitle,
          'post_type' => ($whereto == '0'?'page':'post'),
          'post_content'  => 'This is a <b>preview</b> page, remember to publish it if needed. You can edit the full form settings into the admin settings page.<br /><br /> '.$content,
          'post_status'   => 'draft'
        );
        
        // Insert the post into the database
        $id = wp_insert_post( $my_post );
    }
    else 
    {
        $id = ($whereto == '2'?$publishpage:$publishpost);
        $post = get_post( $id );
        $pos = strpos($post->post_content,$content);
        if ($pos === false)
        {
            $my_post = array(
                  'ID'           => $id,
                  'post_content' => $content.$post->post_content,
              );
            // Update the post into the database
            wp_update_post( $my_post );
        }
    }
    return get_permalink($id);
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
    if (is_ssl())
        $url = str_replace('http://', 'https://', $url);
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
    if (is_ssl())
        $url = str_replace('http://', 'https://', $url);    
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
                      'plugin_url'  => 'https://wordpress.org/support/plugin/appointment-booking-calendar/reviews/?filter=5#new-post'
);
require_once 'banner.php';

?>