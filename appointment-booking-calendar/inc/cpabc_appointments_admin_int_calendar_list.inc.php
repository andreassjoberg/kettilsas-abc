<?php

if ( !is_admin() ) 
{
    echo 'Direct access not allowed.';
    exit;
}

$current_user = wp_get_current_user();

global $wpdb;
$message = "";
if (isset($_GET['u']) && $_GET['u'] != '')
{
    if (!wp_verify_nonce( $_REQUEST['_wpnonce'], 'uname_abc' ))    
        $message = "Access verification error. Cannot update settings.";
    else
    {
        $wpdb->query( $wpdb->prepare( 'UPDATE `'.CPABC_APPOINTMENTS_CONFIG_TABLE_NAME.'` SET conwer=%d,`'.CPABC_TDEAPP_CONFIG_USER.'`=%s WHERE `'.CPABC_TDEAPP_CONFIG_ID.'`=%d', intval($_GET["owner"]), sanitize_text_field($_GET["name"]), intval($_GET['u']) ) );           
        $message = __("Item updated",'appointment-booking-calendar');        
    }    
}
else if (isset($_GET['ac']) && $_GET['ac'] == 'st')
{   
    if (!wp_verify_nonce( $_REQUEST['_wpnonce'], 'uname_abc' ))    
        $message = __("Access verification error. Cannot update settings.",'appointment-booking-calendar');
    else
    {
        update_option( 'CPABC_CAL_TIME_ZONE_MODIFY_SET', sanitize_text_field($_GET["ict"]) );
        update_option( 'CPABC_CAL_TIME_SLOT_SIZE_SET', sanitize_text_field($_GET["ics"]) );
        update_option( 'CPABC_EXCLUDED_COLUMNS', sanitize_text_field($_GET["col"]) );
        
        update_option( 'CPABC_APPOINTMENTS_LOAD_SCRIPTS', (intval($_GET["scr"])==1?"1":"2") );   
        update_option( 'CPABC_APPOINTMENTS_DEFAULT_USE_EDITOR', "1" );
        if ($_GET["chs"] != '')
        {
            $target_charset = str_replace('`','``', sanitize_text_field($_GET["chs"]));
            $tables = array( $wpdb->prefix.CPABC_APPOINTMENTS_TABLE_NAME_NO_PREFIX, $wpdb->prefix.CPABC_APPOINTMENTS_CALENDARS_TABLE_NAME_NO_PREFIX
                             , $wpdb->prefix.CPABC_APPOINTMENTS_CONFIG_TABLE_NAME_NO_PREFIX, $wpdb->prefix.CPABC_APPOINTMENTS_DISCOUNT_CODES_TABLE_NAME_NO_PREFIX );                
            foreach ($tables as $tab)
            {  
                $myrows = $wpdb->get_results( "DESCRIBE {$tab}" );                                                                                 
                foreach ($myrows as $item)
	            {
	                $name = $item->Field;
	    	        $type = $item->Type;
	    	        if (preg_match("/^varchar\((\d+)\)$/i", $type, $mat) || !strcasecmp($type, "CHAR") || !strcasecmp($type, "TEXT") || !strcasecmp($type, "MEDIUMTEXT"))
	    	        {
	                    $wpdb->query("ALTER TABLE {$tab} CHANGE {$name} {$name} {$type} COLLATE `{$target_charset}`");	            
	                }
	            }
            }
        }
        $message = __("Troubleshoot settings updated",'appointment-booking-calendar');
    }   
    
}

$nonce_un = wp_create_nonce( 'uname_abc' );

if ($message) echo "<div id='setting-error-settings_updated' class='updated settings-error'><p><strong>".$message."</strong></p></div>";

?>
<div class="wrap">
<h1>Appointment Booking Calendar</h1>

<script type="text/javascript">
 
 function cp_updateItem(id)
 {
    var calname = document.getElementById("calname_"+id).value;
    var owner = document.getElementById("calowner_"+id).options[document.getElementById("calowner_"+id).options.selectedIndex].value;    
    if (owner == '')
        owner = 0;
    document.location = 'admin.php?page=cpabc_appointments.php&_wpnonce=<?php echo $nonce_un; ?>&u='+id+'&r='+Math.random()+'&owner='+owner+'&name='+encodeURIComponent(calname);    
 }
 
 function cp_manageSettings(id)
 {
    document.location = 'admin.php?page=cpabc_appointments.php&cal='+id+'&r='+Math.random();
 }
 
 function cp_BookingsList(id)
 {
    document.location = 'admin.php?page=cpabc_appointments.php&cal='+id+'&list=1&r='+Math.random();
 }
 
 function cp_calendarschedule(id)
 {
    document.location = 'admin.php?page=cpabc_appointments.php&cal='+id+'&calschedule=1&r='+Math.random();
 }

 function cp_publish(id)
 {
     document.location = 'admin.php?page=cpabc_appointments.php&pwizard=1&cal='+id+'&r='+Math.random();
 } 
 
 function cp_addbk(id)
 {
    document.location = 'admin.php?page=cpabc_appointments.php&cal='+id+'&addbk=1&r='+Math.random();
 }
 
 function cp_updateConfig()
 {
    if (confirm('Are you sure that you want to update these settings?'))
    {        
        var scr = document.getElementById("ccscriptload").value;    
        var chs = document.getElementById("cccharsets").value;    
        var ccf = document.getElementById("ccformrender").value; 
        var ict = document.getElementById("icaltimediff").value; 
        var ics = document.getElementById("icaltimeslotsize").value; 
        var col = document.getElementById("excludecolumns").value; 
        document.location = 'admin.php?page=cpabc_appointments.php&_wpnonce=<?php echo $nonce_un; ?>&ac=st&scr='+scr+'&chs='+chs+'&ccf='+ccf+'&ict='+ict+'&ics='+ics+'&col='+encodeURIComponent(col)+'&r='+Math.random();
    }    
 } 
 
</script>


<div id="normal-sortables" class="meta-box-sortables">


 <div id="metabox_basic_settings" class="postbox" >
  <h3 class='hndle' style="padding:5px;"><span><?php _e('Calendar List','appointment-booking-calendar') ?> / <?php _e('Items List','appointment-booking-calendar') ?></span></h3>
  <div class="inside">
  
  
  <table cellspacing="2"> 
   <tr>
    <th align="left"><?php _e('ID','appointment-booking-calendar') ?></th><th align="left"><?php _e('Calendar Name','appointment-booking-calendar') ?></th><th align="left"><?php _e('Owner','appointment-booking-calendar') ?></th><th align="left"><?php _e('iCal Link','appointment-booking-calendar') ?></th><th align="left">&nbsp; &nbsp; <?php _e('Options','appointment-booking-calendar') ?></th><th align="left"><?php _e('Shortcode','appointment-booking-calendar') ?></th>    
   </tr> 
<?php  

  $users = $wpdb->get_results( "SELECT user_login,ID FROM ".$wpdb->users." ORDER BY ID DESC" );                                                                     

  $myrows = $wpdb->get_results( "SELECT * FROM ".CPABC_APPOINTMENTS_CONFIG_TABLE_NAME );                                                                     
  foreach ($myrows as $item)   
      if (cpabc_appointment_is_administrator() || ($current_user->ID == $item->conwer))
      {
?>
   <tr> 
    <td nowrap><?php echo $item->id; ?></td>
    <td nowrap><input type="text" <?php if (!cpabc_appointment_is_administrator()) echo ' readonly '; ?>name="calname_<?php echo $item->id; ?>" id="calname_<?php echo $item->id; ?>" value="<?php echo esc_attr($item->uname); ?>" /></td>
    
    <?php if (cpabc_appointment_is_administrator()) { ?>
    <td nowrap>
      <select name="calowner_<?php echo $item->id; ?>" id="calowner_<?php echo $item->id; ?>">
       <option value="0"<?php if (!$item->conwer) echo ' selected'; ?>></option>
       <?php foreach ($users as $user) { 
       ?>
          <option value="<?php echo $user->ID; ?>"<?php if ($user->ID."" == $item->conwer) echo ' selected'; ?>><?php echo $user->user_login; ?></option>
       <?php  } ?>
      </select>
    </td>    
    <?php } else { ?>
        <td nowrap>
        <?php echo $current_user->user_login; ?>
        </td>
    <?php }  ?>
       
    <td nowrap><a href="<?php echo get_site_url(false); ?>?cpabc_app=calfeed&id=<?php echo $item->id; ?>&verify=<?php echo substr(md5($item->id.get_option('ABC_RCODE',$_SERVER["DOCUMENT_ROOT"])),0,10); ?>"><?php _e('iCal Feed','appointment-booking-calendar') ?></a></td>
    <td style="padding-left:15px;"> 
                             <?php if (cpabc_appointment_is_administrator()) { ?> 
                               <input style="margin-bottom:3px" class="button"  type="button" name="calupdate_<?php echo $item->id; ?>" value="<?php _e('Update','appointment-booking-calendar') ?>" onclick="cp_updateItem(<?php echo $item->id; ?>);" /> 
                             <?php } ?>    
                             <input style="margin-bottom:3px;" class="button-primary button" type="button" name="calmanage_<?php echo $item->id; ?>" value="<?php _e('Manage Settings','appointment-booking-calendar') ?>" onclick="cp_manageSettings(<?php echo $item->id; ?>);" /> 
                             <?php if (current_user_can('manage_options')) { ?>
                             <input style="margin-bottom:3px" class="button-primary button" type="button" name="calpublish_<?php echo $item->id; ?>" value="<?php _e('Publish','appointment-booking-calendar'); ?>" onclick="cp_publish(<?php echo $item->id; ?>);" />   
                             <?php } ?>
                             <input style="margin-bottom:3px;" class="button" type="button" name="calbookings_<?php echo $item->id; ?>" value="<?php _e('Bookings List','appointment-booking-calendar') ?>" onclick="cp_BookingsList(<?php echo $item->id; ?>);" /> 
                             <input style="margin-bottom:3px;" class="button" type="button" name="calschedule_<?php echo $item->id; ?>" value="<?php _e('Calendar Schedule','appointment-booking-calendar') ?>" onclick="cp_calendarschedule(<?php echo $item->id; ?>);" /> 
                             <input style="margin-bottom:3px;" class="button" type="button" name="caladdbk_<?php echo $item->id; ?>" value="<?php _e('Add Booking','appointment-booking-calendar') ?>" onclick="cp_addbk(<?php echo $item->id; ?>);" /> 
    </td>
     <td style="font-size:10px;">[CPABC_APPOINTMENT_CALENDAR calendar="<?php echo $item->id; ?>"]</td>
   </tr>
<?php  
      } 
?>   
     
  </table> 
    
    
   
  </div>    
 </div> 
 
<?php if (cpabc_appointment_is_administrator()) { ?> 
 
 <div id="metabox_basic_settings" class="postbox" >
  <h3 class='hndle' style="padding:5px;"><span><?php _e('New Calendar','appointment-booking-calendar') ?> / <?php _e('Item','appointment-booking-calendar') ?></span></h3>
  <div class="inside"> 
   
       <?php _e('This version supports one calendar','appointment-booking-calendar') ?>. <a href="https://abc.dwbooster.com/download"><?php _e('Check the upgrade option','appointment-booking-calendar') ?>s</a>.

  </div>    
 </div>



 <div id="metabox_basic_settings" class="postbox" >
  <h3 class='hndle' style="padding:5px;"><span><?php _e('Form Builder Settings & Troubleshoot Area','appointment-booking-calendar') ?></span></h3>
  <div class="inside"> 
    <p><strong><?php _e('Important!','appointment-booking-calendar') ?></strong>: <?php _e('Use this area <strong>only</strong> if you want to activate the form builder or if you are experiencing conflicts with third party plugins, with the theme scripts or with the character encoding.','appointment-booking-calendar') ?> </p>
    <form name="updatesettings">
    
      <?php _e('Form rendering','appointment-booking-calendar') ?>:<br />
       <select id="ccformrender" name="ccformrender">
        <option value="1" selected><?php _e('Use classic predefined form','appointment-booking-calendar') ?></option>        
       </select><br />
       <em>* <?php _e('The <strong>Visual Form Builder</strong> is available in the','appointment-booking-calendar') ?> <a href="https://abc.dwbooster.com/download"><?php _e('commercial versions','appointment-booking-calendar') ?></a>. <?php _e('To edit the form in this basic version you should manually edit the file','appointment-booking-calendar') ?> 'cpabc_scheduler.inc.php'.</em>
      
      <br /><br />
          
    
      <?php _e('Script load method','appointment-booking-calendar') ?>:<br />
       <select id="ccscriptload" name="ccscriptload">
        <option value="1" <?php if (get_option('CPABC_APPOINTMENTS_LOAD_SCRIPTS',(CPABC_APPOINTMENTS_DEFAULT_DEFER_SCRIPTS_LOADING?"1":"0")) == "1") echo 'selected'; ?>><?php _e('Classic (Recommended)','appointment-booking-calendar') ?></option>
        <option value="2" <?php if (get_option('CPABC_APPOINTMENTS_LOAD_SCRIPTS',(CPABC_APPOINTMENTS_DEFAULT_DEFER_SCRIPTS_LOADING?"1":"0")) != "1") echo 'selected'; ?>><?php _e('Direct','appointment-booking-calendar') ?></option>
       </select><br />
       <em>* <?php _e('Change the script load method if the form doesn\'t appear in the public website','appointment-booking-calendar') ?>.</em>
      
      <br /><br />
      <?php _e('Character encoding','appointment-booking-calendar') ?>:<br />
       <select id="cccharsets" name="cccharsets">
        <option value=""><?php _e('Keep current charset (Recommended)','appointment-booking-calendar') ?></option>
        <option value="utf8_general_ci">UTF-8 (try this first)</option>
        <option value="latin1_swedish_ci">latin1_swedish_ci</option>
       </select><br />
       <em>* <?php _e('Update the charset if you are getting problems displaying special/non-latin characters. After updated you need to edit the special characters again','appointment-booking-calendar') ?>.</em>
             
       <br /><br />
       <?php echo "".get_option('CPABC_CAL_TIME_ZONE_MODIFY_SET'," +2 hours")."*"; _e('iCal timezone difference vs server time','appointment-booking-calendar') ?>:<br />
       <select id="icaltimediff" name="icaltimediff">
        <?php for ($i=-23;$i<24; $i++) { ?>        
        <option value="<?php $text = " ".($i<0?"":"+").$i." hours"; echo urlencode($text); ?>" <?php if (trim(get_option('CPABC_CAL_TIME_ZONE_MODIFY_SET'," +2 hours")) == trim($text)) echo ' selected'; ?>><?php echo $text; ?></option>
        <?php } ?>
       </select><br />
       <em>* <?php _e('Update this, if needed, to match the desired timezone. The difference is calculated referred to the server time. Current server time is','appointment-booking-calendar') ?> <?php echo date("Y-m-d H:i"); ?></em>
       
       <br /><br />
       <?php _e('iCal timeslot size in minutes','appointment-booking-calendar') ?>:<br />
        <input type="text" size="2" name="icaltimeslotsize" id="icaltimeslotsize" value="<?php echo get_option('CPABC_CAL_TIME_SLOT_SIZE_SET',"30"); ?>" /> <?php _e('minutes','appointment-booking-calendar') ?>
        <br />
       <em>* <?php _e('Update this, if needed, to have a specific slot time in the exported iCal file','appointment-booking-calendar') ?>.</em>
      
       <br /><br />
       <?php _e('Exclude columns from CSV exported files','appointment-booking-calendar') ?>:<br />
        <input type="text" size="50" name="excludecolumns" id="excludecolumns" value="<?php echo get_option('CPABC_EXCLUDED_COLUMNS',""); ?>" /> 
        <br />
       <em>* <?php _e('Names of the columns to be excluded, comma separated','appointment-booking-calendar') ?>.</em>
      
      
        <br /><br />         
       <input type="button" onclick="cp_updateConfig();" name="gobtn" value="UPDATE" />
      <br /><br />      
    </form>

  </div>    
 </div> 

 
   <script type="text/javascript">
   function cp_editArea(id)
   {       
          document.location = 'admin.php?page=cpabc_appointments.php&edit=1&cal=1&item='+id+'&r='+Math.random();
   }
  </script>
  <div id="metabox_basic_settings_custom" class="postbox" >
  <h3 class='hndle' style="padding:5px;"><span><?php _e('Customization Area','appointment-booking-calendar') ?></span></h3>
  <div class="inside"> 
      <p><?php _e('Use this area to add custom CSS styles or custom scripts. These styles and scripts will be keep safe even after updating the plugin','appointment-booking-calendar') ?>.</p>
      <input type="button" onclick="cp_editArea('css');" name="gobtn3" value="Add Custom Styles" />
  </div>    
 </div> 
  
<?php } ?>  
  
</div> 


[<a href="https://wordpress.org/support/plugin/appointment-booking-calendar#new-post" target="_blank"><?php _e('Support','appointment-booking-calendar') ?></a>] | [<a href="https://abc.dwbooster.com/support?ref=callist" target="_blank"><?php _e('Documentation','appointment-booking-calendar') ?></a>]
</form>
</div>