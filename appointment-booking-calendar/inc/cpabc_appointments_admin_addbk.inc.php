<?php

if ( !is_admin() && !defined('CPABC_CALENDAR_ON_PUBLIC_WEBSITE')) 
{
    echo 'Direct access not allowed.';
    exit;
}

$plugslug = 'cpabc_appointments.php';

if (!defined('CP_CALENDAR_ID'))
    define ('CP_CALENDAR_ID',1);

global $wpdb; 

$message = '';

if ( 'POST' == $_SERVER['REQUEST_METHOD'] && isset( $_POST['cpabc_appointments_post'] ) )
    $message = 'Booking added. It appears now in the <a href="?page='.$plugslug.'&cal='.CP_CALENDAR_ID.'&list=1">bookings list</a>.';

if ($message) echo "<div id='setting-error-settings_updated' class='updated settings-error'><p><strong>".$message."</strong></p></div>";


?>
<style>
	.clear{clear:both;}
	.ahb-first-button{margin-right:10px !important;}
    .ahb-buttons-container{margin:1em 1em 1em 0;}
    .ahb-return-link{float:right;}
</style>
<div class="wrap">

<h1>Add Booking</h1>  

<div class="ahb-buttons-container">
	<a href="<?php print esc_attr(admin_url('admin.php?page='.$plugslug));?>" class="ahb-return-link">&larr;Return to the calendars list</a>
    <div class="clear"></div>
</div>

<p>This page is for adding bookings from the administration area. The captcha and payment process are disabled in order to allow the website manager easily adding bookings.</p> 

<?php echo cpabc_appointments_filter_content(array('calendar' => CP_CALENDAR_ID)); ?>

</div>
