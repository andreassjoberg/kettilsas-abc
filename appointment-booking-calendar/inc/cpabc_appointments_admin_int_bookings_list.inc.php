<?php

if ( !is_admin() )
{
    echo 'Direct access not allowed.';
    exit;
}

if (!defined('CP_CALENDAR_ID'))
    define ('CP_CALENDAR_ID', 1);

global $wpdb;

$message = "";

$records_per_page = 50;                                                                                  

function cpabc_bklist_verify_nonce() {
    if (isset($_GET['rsave']) && $_GET['rsave'] != '')
        $nonce = sanitize_text_field($_GET['rsave']);
    else
        $nonce = sanitize_text_field($_POST['rsave']);
    $verify_nonce = wp_verify_nonce( $nonce, 'uname_abc_bklist');
    if (!$verify_nonce)
    {
        echo 'Error: Form cannot be authenticated (nonce failed). Please contact our <a href="https://abc.dwbooster.com/contact-us">support service</a> for verification and solution. Thank you.';
        exit;
    } 
}

if (isset($_GET['delmark']) && $_GET['delmark'] != '')
{
    cpabc_bklist_verify_nonce();
    for ($i=0; $i<=$records_per_page; $i++)
    if (isset($_GET['c'.$i]) && $_GET['c'.$i] != '')   
        $wpdb->query( $wpdb->prepare('DELETE FROM `'.CPABC_APPOINTMENTS_CALENDARS_TABLE_NAME.'` WHERE id=%d', $_GET['c'.$i])  );       
    $message = "Marked items deleted";
}
else if (isset($_GET['ld']) && $_GET['ld'] != '')
{
    cpabc_bklist_verify_nonce();
    $wpdb->query( $wpdb->prepare('DELETE FROM `'.CPABC_APPOINTMENTS_CALENDARS_TABLE_NAME.'` WHERE id=%d', $_GET['ld']) );       
    $message = "Item deleted";
} 
else if (isset($_GET['del']) && $_GET['del'] == 'all')
{        
    cpabc_bklist_verify_nonce();
    $wpdb->query( $wpdb->prepare( 'DELETE FROM `'.CPABC_APPOINTMENTS_CALENDARS_TABLE_NAME.'` WHERE appointment_calendar_id=%d', CP_CALENDAR_ID ) );           
    $message = "All items deleted";
}


$mycalendarrows = $wpdb->get_results( 'SELECT * FROM '.CPABC_APPOINTMENTS_CONFIG_TABLE_NAME .' WHERE `'.CPABC_TDEAPP_CONFIG_ID.'`='.CP_CALENDAR_ID);

if ( 'POST' == $_SERVER['REQUEST_METHOD'] && isset( $_POST['cpabc_appointments_post_options'] ) )
    echo "<div id='setting-error-settings_updated' class='updated settings-error'> <p><strong>Settings saved.</strong></p></div>";

$current_user = wp_get_current_user();

if (cpabc_appointment_is_administrator() || $mycalendarrows[0]->conwer == $current_user->ID) {

$current_page = intval(cpabc_get_get_param("p"));
if (!$current_page) $current_page = 1;

$cond = '';
if (cpabc_get_get_param("search") != '') 
{
    $search_text = sanitize_text_field($_GET["search"]);
    $cond .= " AND (title like '%".esc_sql($search_text)."%' OR description LIKE '%".esc_sql($search_text)."%')";
}
if (cpabc_get_get_param("dfrom") != '') $cond .= " AND (datatime >= '".esc_sql(sanitize_text_field($_GET["dfrom"]))."')";
if (cpabc_get_get_param("dto") != '') $cond .= " AND (datatime <= '".esc_sql(sanitize_text_field($_GET["dto"]))." 23:59:59')";


$events = $wpdb->get_results( "SELECT * FROM ".CPABC_APPOINTMENTS_CALENDARS_TABLE_NAME." WHERE appointment_calendar_id=".CP_CALENDAR_ID.$cond." ORDER BY datatime DESC" );
$total_pages = ceil(count($events) / $records_per_page);

if ($message) echo "<div id='setting-error-settings_updated' class='updated settings-error'><p><strong>".$message."</strong></p></div>";

$nonce_un = wp_create_nonce( 'uname_abc_bklist' );

?>
<script type="text/javascript">
 function cp_deleteMessageItem(id)
 {
    if (confirm('Are you sure that you want to delete this item?'))
    {        
        document.location = 'admin.php?page=cpabc_appointments.php&rsave=<?php echo $nonce_un; ?>&cal=<?php echo intval($_GET["cal"]); ?>&list=1&ld='+id+'&r='+Math.random();
    }
 }
 function do_dexapp_deleteall()
 {
    if (confirm('Are you sure that you want to delete ALL bookings for this calendar? Note: This action cannot be undone.'))
    {        
        document.location = 'admin.php?page=cpabc_appointments.php&rsave=<?php echo $nonce_un; ?>&cal=<?php echo intval($_GET["cal"]); ?>&list=1&del=all&r='+Math.random();
    }    
 }
</script>
<div class="wrap">
<h1>Appointment Booking Calendar - Bookings List</h1>

<input type="button" name="backbtn" value="Back to items list..." onclick="document.location='admin.php?page=cpabc_appointments.php';">


<div id="normal-sortables" class="meta-box-sortables">
 <hr />
 <h3>This booking list applies only to: <?php echo $mycalendarrows[0]->uname; ?></h3>
</div>


<form action="admin.php" method="get">
 <input type="hidden" name="page" value="cpabc_appointments.php" />
 <input type="hidden" name="cal" value="<?php echo CP_CALENDAR_ID; ?>" />
 <input type="hidden" name="list" value="1" />
 Search for: <input type="text" name="search" value="<?php echo esc_attr(cpabc_get_get_param("search")); ?>" /> &nbsp; &nbsp; &nbsp; 
 From: <input autocomplete="off" type="text" id="dfrom" name="dfrom" value="<?php echo esc_attr(cpabc_get_get_param("dfrom")); ?>" /> &nbsp; &nbsp; &nbsp; 
 To: <input autocomplete="off" type="text" id="dto" name="dto" value="<?php echo esc_attr(cpabc_get_get_param("dto")); ?>" /> &nbsp; &nbsp; &nbsp;  
<nobr><span class="submit"><input type="submit" name="ds" value="Filter" /></span> &nbsp; &nbsp; &nbsp; 
 <span class="submit"><input type="submit" name="cpabc_appointments_csv" value="Export to CSV" /></span></nobr>
  
</form>

<br />
                             
<?php


echo paginate_links(  array(
    'base'         => 'admin.php?page=cpabc_appointments.php&cal='.CP_CALENDAR_ID.'&list=1%_%&dfrom='.urlencode(sanitize_text_field(cpabc_get_get_param("dfrom"))).'&dto='.urlencode(sanitize_text_field(cpabc_get_get_param("dto"))).'&search='.urlencode(sanitize_text_field(cpabc_get_get_param("search"))),
    'format'       => '&p=%#%',
    'total'        => $total_pages,
    'current'      => $current_page,
    'show_all'     => False,
    'end_size'     => 1,
    'mid_size'     => 2,
    'prev_next'    => True,
    'prev_text'    => '&laquo; '.__('Previous','appointment-booking-calendar'),
    'next_text'    => __('Next','appointment-booking-calendar').' &raquo;',
    'type'         => 'plain',
    'add_args'     => False
    ) );

?>

<div id="cpabc_printable_contents">
<form name="dex_table_form" id="dex_table_form" action="admin.php" method="get">
 <input type="hidden" name="page" value="cpabc_appointments.php" />
 <input type="hidden" name="cal" value="<?php echo intval($_GET["cal"]); ?>" />
 <input type="hidden" name="list" value="1" />
 <input type="hidden" name="rsave" value="<?php echo $nonce_un; ?>" />
 <input type="hidden" name="delmark" value="1" />
<table class="wp-list-table widefat fixed pages" cellspacing="0" width="100%"> 
	<thead>
	<tr>
	  <th width="30"  class="cpnopr"></th>
	  <th style="padding-left:7px;font-weight:bold;">Date</th>
	  <th style="padding-left:7px;font-weight:bold;">Title</th>
	  <th style="padding-left:7px;font-weight:bold;">Description</th>
	  <th style="padding-left:7px;font-weight:bold;">Quantity</th>
	  <th class="cpnopr" style="padding-left:7px;font-weight:bold;">Options</th>
	</tr>
	</thead>
	<tbody id="the-list">
	 <?php for ($i=($current_page-1)*$records_per_page; $i<$current_page*$records_per_page; $i++) if (isset($events[$i])) { ?>
	  <tr class='<?php if (!($i%2)) { ?>alternate <?php } ?>author-self status-draft format-default iedit' valign="top">
	    <td width="1%"  class="cpnopr"><input type="checkbox" name="c<?php echo $i-($current_page-1)*$records_per_page; ?>" value="<?php echo $events[$i]->id; ?>" /></td>
		<td><?php echo substr($events[$i]->datatime,0,16); ?></td>
		<td><?php echo str_replace('<','&lt;',$events[$i]->title); ?></td>
		<td><?php echo str_replace('--br />','<br />',str_replace('<','&lt;',str_replace('<br />','--br />',$events[$i]->description))); ?></td>
		<td><?php echo $events[$i]->quantity; ?></td>
		<td class="cpnopr">
		  <input type="button" name="caldelete_<?php echo $events[$i]->id; ?>" value="Delete" onclick="cp_deleteMessageItem(<?php echo $events[$i]->id; ?>);" />                             
		</td>		
      </tr>
     <?php } ?>
	</tbody>
</table>
</form>
</div>

<br /><input type="button" name="pbutton" value="Print" onclick="do_dexapp_print();" />
<div style="clear:both"></div>
<p class="submit" style="float:left;"><input type="button" name="pbutton" value="Delete marked items" onclick="do_dexapp_deletemarked();" /> &nbsp; &nbsp; &nbsp; </p>

<p class="submit" style="float:left;"><input type="button" name="pbutton" value="Delete All Bookings" onclick="do_dexapp_deleteall();" /></p>


</div>


<script type="text/javascript">
 function do_dexapp_print()
 {
      w=window.open();
      w.document.write("<style>.cpnopr{display:none;};table{border:2px solid black;width:100%;}th{border-bottom:2px solid black;text-align:left}td{padding-left:10px;border-bottom:1px solid black;}</style>"+document.getElementById('cpabc_printable_contents').innerHTML);
      w.print();     
 }
 function do_dexapp_deletemarked()
 {
    document.dex_table_form.submit();
 }  
 var $j = jQuery.noConflict();
 $j(function() {
 	$j("#dfrom").datepicker({     	                
                    dateFormat: 'yy-mm-dd'
                 });
 	$j("#dto").datepicker({     	                
                    dateFormat: 'yy-mm-dd'
                 });
 });
 
</script>




<?php } else { ?>
  <br />
  The current user logged in doesn't have enough permissions to edit this calendar. This user can edit only his/her own calendars. Please log in as administrator to get access to all calendars.

<?php } ?>











