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

$mycalendarrows = $wpdb->get_results( 'SELECT * FROM '.CPABC_APPOINTMENTS_CONFIG_TABLE_NAME .' WHERE `'.CPABC_TDEAPP_CONFIG_ID.'`='.CP_CALENDAR_ID);

$current_user = wp_get_current_user();

if (cpabc_appointment_is_administrator() || $mycalendarrows[0]->conwer == $current_user->ID) {


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

if ($message) echo "<div id='setting-error-settings_updated' class='updated settings-error'><p><strong>".$message."</strong></p></div>";

$nonce_un = wp_create_nonce( 'uname_abc_bklist' );

?>
<div class="wrap">
<h1>Appointment Booking Calendar - Calendar Schedule</h1>

<input type="button" name="backbtn" value="Back to items list..." onclick="document.location='admin.php?page=cpabc_appointments.php';">


<div id="normal-sortables" class="meta-box-sortables">
 <hr />
 <h3>Schedule for: <?php echo $mycalendarrows[0]->uname; ?></h3>
</div>
<p>The purpose of this page is to <strong>display the bookings/schedule in a calendar view</strong>. You can add bookings from the public booking form or <a href="?page=cpabc_appointments.php&cal=<?php echo CP_CALENDAR_ID; ?>&addbk=1">add bookings from the dashboard</a> and the bookings will appear in this calendar.</p>

<br />


<div id="cpabc_printable_contents">

            <link rel="stylesheet" href="<?php echo plugins_url('css/cupertino/calendar.css', __FILE__); ?>" type="text/css" />
            <link rel="stylesheet" href="<?php echo plugins_url('css/main.css', __FILE__); ?>" type="text/css" /> 
            
            <script type="text/javascript" src="<?php echo plugins_url('js/underscore.js', __FILE__); ?>"></script>
            <script type="text/javascript" src="<?php echo plugins_url('js/rrule.js', __FILE__); ?>"></script>
            <script type="text/javascript" src="<?php echo plugins_url('js/Common.js', __FILE__); ?>"></script>
            
<?php
        if (file_exists(dirname( __FILE__ ).'/language/multiview_lang_'.cpabc_mv_autodetect_language().'.js'))
            $langscript = plugins_url('/language/multiview_lang_'.cpabc_mv_autodetect_language().'.js', __FILE__);
        else
            $langscript = plugins_url('/language/multiview_lang_en_GB.js', __FILE__);
?>        
            <script type="text/javascript" src="<?php echo $langscript; ?>"></script>
            <script type="text/javascript" src="<?php echo plugins_url('js/jquery.calendar.js', __FILE__); ?>"></script>
            <script type="text/javascript" src="<?php echo plugins_url('js/jquery.alert.js', __FILE__); ?>"></script>
            <script type="text/javascript" src="<?php echo plugins_url('js/multiview.js', __FILE__); ?>"></script>
          
            <script type="text/javascript">
             var pathCalendar = "<?php echo cpabc_appointment_get_site_url(true); ?>/?cpabc_calendar_load2=1&id=<?php echo CP_CALENDAR_ID; ?>&cpabc_action=mvparse";
             var dc_subjects = "";var dc_locations = "";
             initMultiViewCal("cal<?php echo CP_CALENDAR_ID; ?>", <?php echo CP_CALENDAR_ID; ?>,
          {viewDay:true,
          viewWeek:true,
          viewMonth:true,
          viewNMonth:true,
          viewList:false,
          viewdefault:"week",
          numberOfMonths:12,
          showtooltip:false,
          tooltipon:0,
          shownavigate:false,
          url:"",
          target:0,
          start_weekday:0,
          language:"en-GB",
          cssStyle:"cupertino",
          edition:true,
          btoday:true,
          bnavigation:true,
          brefresh:true,
          bnew:false,
          path:pathCalendar,
          userAdd:false,
          userEdit:false,
          userDel:false,
          userEditOwner:true,
          userDelOwner:false,
          showtooltipdwm_mouseover:true,
          userOwner:0 ,cellheight:62 , palette:0, paletteDefault:"F00", paletteFull:["FFF","FCC","FC9","FF9","FFC","9F9","9FF","CFF","CCF","FCF","CCC","F66","F96","FF6","FF3","6F9","3FF","6FF","99F","F9F","BBB","F00","F90","FC6","FF0","3F3","6CC","3CF","66C","C6C","999","C00","F60","FC3","FC0","3C0","0CC","36F","63F","C3C","666","900","C60","C93","990","090","399","33F","60C","939","333","600","930","963","660","060","366","009","339","636","000","300","630","633","330","030","033","006","309","303"]});
            </script>
          
            <div id="multicalendar"><div id="cal<?php echo CP_CALENDAR_ID; ?>" class="multicalendar"></div></div>
            
             <div style="clear:both;height:20px" ></div>    

</div>

<!--<br /><input type="button" name="pbutton" value="Print" onclick="do_dexapp_print();" /> -->
<div style="clear:both"></div>


</div>


<script type="text/javascript">
 function do_dexapp_print()
 {
      w=window.open();
      w.document.write("<style>.cpnopr{display:none;};table{border:2px solid black;width:100%;}th{border-bottom:2px solid black;text-align:left}td{padding-left:10px;border-bottom:1px solid black;}</style>"+document.getElementById('cpabc_printable_contents').innerHTML);
      w.print();     
 }
</script>




<?php } else { ?>
  <br />
  The current user logged in doesn't have enough permissions to edit this calendar. This user can edit only his/her own calendars. Please log in as administrator to get access to all calendars.

<?php } ?>











