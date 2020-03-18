<?php
/*
Plugin Name: Appointment Booking Calendar
Plugin URI: https://abc.dwbooster.com
Description: This plugin allows you to easily insert appointments forms into your WP website.
Version: 1.3.36
Author URI: https://abc.dwbooster.com
License: GPL
Text Domain: appointment-booking-calendar
*/

/* initialization / install / uninstall functions */


define('CPABC_APPOINTMENTS_DEFAULT_ON_CANCEL_REDIRECT_TO', '/'); 
define('CPABC_APPOINTMENTS_AUTO_FILL_LOGGED_USER_DATA', true); 
define('CPABC_APPOINTMENTS_ENABLE_QUANTITY_FIELD', 0);  
define('CPABC_APPOINTMENTS_IDENTIFY_PRICES', false); 

define('CPABC_APPOINTMENTS_DEFAULT_DEFER_SCRIPTS_LOADING', (get_option('CPABC_APPOINTMENTS_LOAD_SCRIPTS',"1") == "1"?true:false));

define('CPABC_APPOINTMENTS_DEFAULT_CURRENCY_SYMBOL','$');
define('CPABC_APPOINTMENTS_GBP_CURRENCY_SYMBOL',chr(163));
define('CPABC_APPOINTMENTS_EUR_CURRENCY_SYMBOL_A','EUR ');
define('CPABC_APPOINTMENTS_EUR_CURRENCY_SYMBOL_B',chr(128));

define('CPABC_APPOINTMENTS_DEFAULT_form_structure', '[[{"name":"email","index":0,"title":"Email","ftype":"femail","userhelp":"","csslayout":"","required":true,"predefined":"","size":"medium"},{"name":"subject","index":1,"title":"Subject","required":true,"ftype":"ftext","userhelp":"","csslayout":"","predefined":"","size":"medium"},{"name":"message","index":2,"size":"large","required":true,"title":"Message","ftype":"ftextarea","userhelp":"","csslayout":"","predefined":""}],[{"title":"","description":"","formlayout":"top_aligned"}]]');

define('CPABC_APPOINTMENTS_DEFAULT_CALENDAR_LANGUAGE', '-');
define('CPABC_APPOINTMENTS_DEFAULT_CALENDAR_DATEFORMAT', '0');
define('CPABC_APPOINTMENTS_DEFAULT_CALENDAR_MILITARYTIME', '1');
define('CPABC_APPOINTMENTS_DEFAULT_CALENDAR_WEEKDAY', '0');
define('CPABC_APPOINTMENTS_DEFAULT_CALENDAR_MINDATE', 'today');
define('CPABC_APPOINTMENTS_DEFAULT_CALENDAR_MAXDATE', '');
define('CPABC_APPOINTMENTS_DEFAULT_CALENDAR_PAGES', 1);

define('CPABC_APPOINTMENTS_DEFAULT_cu_user_email_field', 'email');
define('CPABC_APPOINTMENTS_DEFAULT_email_format', 'text');
define('CPABC_APPOINTMENTS_DEFAULT_ENABLE_PAYPAL', 1);
define('CPABC_APPOINTMENTS_DEFAULT_PAYPAL_EMAIL','sample@email.com');
define('CPABC_APPOINTMENTS_DEFAULT_PRODUCT_NAME','Appointment');
define('CPABC_APPOINTMENTS_DEFAULT_COST','25');
define('CPABC_APPOINTMENTS_DEFAULT_OK_URL',get_site_url());
define('CPABC_APPOINTMENTS_DEFAULT_CANCEL_URL',get_site_url());
define('CPABC_APPOINTMENTS_DEFAULT_CURRENCY','USD');
define('CPABC_APPOINTMENTS_DEFAULT_PAYPAL_LANGUAGE','EN');

define('CPABC_APPOINTMENTS_DEFAULT_ENABLE_REMINDER', 0);
define('CPABC_APPOINTMENTS_DEFAULT_REMINDER_HOURS', 48);
define('CPABC_APPOINTMENTS_DEFAULT_REMINDER_SUBJECT', 'Appointment reminder...');
define('CPABC_APPOINTMENTS_DEFAULT_REMINDER_CONTENT', "This is a reminder for your appointment with the following information:\n\n%INFORMATION%\n\nThank you.\n\nBest regards.");

define('CPABC_APPOINTMENTS_DEFAULT_SUBJECT_CONFIRMATION_EMAIL', 'Thank you for your request...');
define('CPABC_APPOINTMENTS_DEFAULT_CONFIRMATION_EMAIL', "We have received your request with the following information:\n\n%INFORMATION%\n\nThank you.\n\nBest regards.");
define('CPABC_APPOINTMENTS_DEFAULT_SUBJECT_NOTIFICATION_EMAIL','New appointment requested...');
define('CPABC_APPOINTMENTS_DEFAULT_NOTIFICATION_EMAIL', "New appointment made with the following information:\n\n%INFORMATION%\n\nBest regards.");

define('CPABC_APPOINTMENTS_DEFAULT_CP_CAL_CHECKBOXES',"");
define('CPABC_APPOINTMENTS_DEFAULT_EXPLAIN_CP_CAL_CHECKBOXES',"1.00 | Service 1 for us$1.00\n5.00 | Service 2 for us$5.00\n10.00 | Service 3 for us$10.00");


// tables

define('CPABC_APPOINTMENTS_TABLE_NAME_NO_PREFIX', "cpabc_appointments");
define('CPABC_APPOINTMENTS_TABLE_NAME', @$wpdb->prefix . CPABC_APPOINTMENTS_TABLE_NAME_NO_PREFIX);

define('CPABC_APPOINTMENTS_CALENDARS_TABLE_NAME_NO_PREFIX', "cpabc_appointment_calendars_data");
define('CPABC_APPOINTMENTS_CALENDARS_TABLE_NAME', @$wpdb->prefix ."cpabc_appointment_calendars_data");

define('CPABC_APPOINTMENTS_CONFIG_TABLE_NAME_NO_PREFIX', "cpabc_appointment_calendars");
define('CPABC_APPOINTMENTS_CONFIG_TABLE_NAME', @$wpdb->prefix ."cpabc_appointment_calendars");

define('CPABC_APPOINTMENTS_DISCOUNT_CODES_TABLE_NAME_NO_PREFIX', "cpabc_appointments_discount_codes");
define('CPABC_APPOINTMENTS_DISCOUNT_CODES_TABLE_NAME', @$wpdb->prefix ."cpabc_appointments_discount_codes");

// calendar constants

define("CPABC_TDEAPP_DEFAULT_CALENDAR_ID","1");
define("CPABC_TDEAPP_DEFAULT_CALENDAR_LANGUAGE","EN");

define("CPABC_TDEAPP_CAL_PREFIX", "cal");
define("CPABC_TDEAPP_CONFIG",CPABC_APPOINTMENTS_CONFIG_TABLE_NAME);
define("CPABC_TDEAPP_CONFIG_ID","id");
define("CPABC_TDEAPP_CONFIG_TITLE","title");
define("CPABC_TDEAPP_CONFIG_USER","uname");
define("CPABC_TDEAPP_CONFIG_PASS","passwd");
define("CPABC_TDEAPP_CONFIG_LANG","lang");
define("CPABC_TDEAPP_CONFIG_CPAGES","cpages");
define("CPABC_TDEAPP_CONFIG_TYPE","ctype");
define("CPABC_TDEAPP_CONFIG_MSG","msg");
define("CPABC_TDEAPP_CONFIG_WORKINGDATES","workingDates");
define("CPABC_TDEAPP_CONFIG_RESTRICTEDDATES","restrictedDates");
define("CPABC_TDEAPP_CONFIG_TIMEWORKINGDATES0","timeWorkingDates0");
define("CPABC_TDEAPP_CONFIG_TIMEWORKINGDATES1","timeWorkingDates1");
define("CPABC_TDEAPP_CONFIG_TIMEWORKINGDATES2","timeWorkingDates2");
define("CPABC_TDEAPP_CONFIG_TIMEWORKINGDATES3","timeWorkingDates3");
define("CPABC_TDEAPP_CONFIG_TIMEWORKINGDATES4","timeWorkingDates4");
define("CPABC_TDEAPP_CONFIG_TIMEWORKINGDATES5","timeWorkingDates5");
define("CPABC_TDEAPP_CONFIG_TIMEWORKINGDATES6","timeWorkingDates6");
define("CPABC_TDEAPP_CALDELETED_FIELD","caldeleted");

define('CPABC_TDEAPP_CALENDAR_STEP2_VRFY', false);

define("CPABC_TDEAPP_CALENDAR_DATA_TABLE",CPABC_APPOINTMENTS_CALENDARS_TABLE_NAME);
define("CPABC_TDEAPP_DATA_ID","id");
define("CPABC_TDEAPP_DATA_IDCALENDAR","appointment_calendar_id");
define("CPABC_TDEAPP_DATA_DATETIME","datatime");
define("CPABC_TDEAPP_DATA_TITLE","title");
define("CPABC_TDEAPP_DATA_DESCRIPTION","description");
// end calendar constants

define('CPABC_TDEAPP_DEFAULT_dexcv_enable_captcha', 'true');
define('CPABC_TDEAPP_DEFAULT_dexcv_width', '180');
define('CPABC_TDEAPP_DEFAULT_dexcv_height', '60');
define('CPABC_TDEAPP_DEFAULT_dexcv_chars', '5');
define('CPABC_TDEAPP_DEFAULT_dexcv_font', 'font-1.ttf');
define('CPABC_TDEAPP_DEFAULT_dexcv_min_font_size', '25');
define('CPABC_TDEAPP_DEFAULT_dexcv_max_font_size', '35');
define('CPABC_TDEAPP_DEFAULT_dexcv_noise', '200');
define('CPABC_TDEAPP_DEFAULT_dexcv_noise_length', '4');
define('CPABC_TDEAPP_DEFAULT_dexcv_background', 'ffffff');
define('CPABC_TDEAPP_DEFAULT_dexcv_border', '000000');
define('CPABC_TDEAPP_DEFAULT_dexcv_text_enter_valid_captcha', 'Please enter a valid captcha code.');

define('CPABC_APPOINTMENTS_DEFAULT_vs_text_is_required', 'This field is required.');
define('CPABC_APPOINTMENTS_DEFAULT_vs_text_is_email', 'Please enter a valid email address.');

define('CPABC_APPOINTMENTS_DEFAULT_vs_text_datemmddyyyy', 'Please enter a valid date with this format(mm/dd/yyyy)');
define('CPABC_APPOINTMENTS_DEFAULT_vs_text_dateddmmyyyy', 'Please enter a valid date with this format(dd/mm/yyyy)');
define('CPABC_APPOINTMENTS_DEFAULT_vs_text_number', 'Please enter a valid number.');
define('CPABC_APPOINTMENTS_DEFAULT_vs_text_digits', 'Please enter only digits.');
define('CPABC_APPOINTMENTS_DEFAULT_vs_text_max', 'Please enter a value less than or equal to {0}.');
define('CPABC_APPOINTMENTS_DEFAULT_vs_text_min', 'Please enter a value greater than or equal to {0}.');

include_once dirname( __FILE__ ) . '/inc/cpabc_apps_on.inc.php';

register_activation_hook(__FILE__,'cpabc_appointments_install');

add_action( 'plugins_loaded', 'cpabc_plugin_init');
add_action( 'init', 'cpabc_appointments_main_initialization', 11 );
add_action( 'plugins_loaded', 'cpabc_appointments_calendar_load', 11 );
add_action( 'plugins_loaded', 'cpabc_appointments_calendar_load2', 11 );
add_action( 'plugins_loaded', 'cpabc_appointments_calendar_update', 11 );
add_action( 'plugins_loaded', 'cpabc_appointments_calendar_update2', 11 );

//START: activation redirection 
function cpabc_activation_redirect( $plugin ) {
    if(
        $plugin == plugin_basename( __FILE__ ) &&
        (!isset($_POST["action"]) || $_POST["action"] != 'activate-selected') &&
        (!isset($_POST["action2"]) || $_POST["action2"] != 'activate-selected') 
      )
    {
        exit( wp_redirect( admin_url( 'admin.php?page=cpabc_appointments.php' ) ) );
    }
}
add_action( 'activated_plugin', 'cpabc_activation_redirect' );
//END: activation redirection 

if ( is_admin() ) {
    add_action('media_buttons', 'set_cpabc_apps_insert_button', 100);
    add_action('admin_enqueue_scripts', 'set_cpabc_apps_insert_adminScripts', 1);
    add_action('admin_menu', 'cpabc_appointments_admin_menu');
    add_action('enqueue_block_editor_assets', 'cpabc_appointments_gutenberg_block' );
    add_action('wp_loaded', 'cpabc_data_management_loaded' );

    $plugin = plugin_basename(__FILE__);
    add_filter("plugin_action_links_".$plugin, 'cpabc_customAdjustmentsLink');
    add_filter("plugin_action_links_".$plugin, 'cpabc_settingsLink');
    add_filter("plugin_action_links_".$plugin, 'cpabc_helpLink');

    function cpabc_appointments_admin_menu() {
        add_options_page('Appointment Booking Calendar Options', 'Appointment Booking Calendar', 'manage_options', 'cpabc_appointments.php', 'cpabc_appointments_html_post_page' );
        add_menu_page( 'Appointment Booking Calendar Options', 'Appointment Booking Calendar', 'read', 'cpabc_appointments.php', 'cpabc_appointments_html_post_page' );

        add_submenu_page( 'cpabc_appointments.php', 'Manage Calendars', 'Manage Calendars', 'read', "cpabc_appointments",  'cpabc_appointments_html_post_page' );
        add_submenu_page( 'cpabc_appointments.php', 'Help: Online demo', 'Help: Online demo', 'read', "cpabc_appointments_demo", 'cpabc_appointments_html_post_page' );
        add_submenu_page( 'cpabc_appointments.php', 'Upgrade', 'Upgrade', 'read', "cpabc_appointments_upgrade", 'cpabc_appointments_html_post_page' );

    }
}
else
{
    add_shortcode( 'CPABC_APPOINTMENT_CALENDAR', 'cpabc_appointments_filter_content' );
    add_shortcode( 'CPABC_EDIT_CALENDAR', 'cpabc_appointments_filter_edit' );
    add_shortcode( 'CPABC_APPOINTMENT_LIST', 'cpabc_appointments_filter_list' );
}


function cpabc_appointments_gutenberg_block() {
    wp_enqueue_script( 'cpabc_gutenberg_editor', plugins_url('/js/block.js', __FILE__));
}


function cpabc_plugin_init() {
   load_plugin_textdomain( 'appointment-booking-calendar', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
}


function cpabc_appointments_install($networkwide)  {
	global $wpdb;

	if (function_exists('is_multisite') && is_multisite()) {
		// check if it is a network activation - if so, run the activation function for each blog id
		if ($networkwide) {
	                $old_blog = $wpdb->blogid;
			// Get all blog ids
			$blogids = $wpdb->get_col( "SELECT blog_id FROM $wpdb->blogs" );
			foreach ($blogids as $blog_id) {
				switch_to_blog($blog_id);
				_cpabc_appointments_install();
			}
			switch_to_blog($old_blog);
			return;
		}
	}
	_cpabc_appointments_install();
}   

// this filter has been applied to avoid problems with WP Rocket Optimizations
add_filter( 'rocket_exclude_js', 'cpabc_wprockert_exclude_js_minify' );
function cpabc_wprockert_exclude_js_minify( $js_files ) {
	$js_files[] = plugins_url('/TDE_AppCalendar/all-scripts.js', __FILE__);
	$js_files[] = plugins_url('/js/(.*).js', __FILE__);    
	return $js_files;
}

// optional opt-in deactivation feedback
require_once 'inc/cp-feedback.php';

// elementor integration
include_once dirname( __FILE__ ) . '/controllers/elementor/cp-elementor-widget.inc.php';


?>