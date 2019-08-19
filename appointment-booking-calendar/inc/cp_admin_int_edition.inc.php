<?php

if ( !is_admin() ) 
{
    echo 'Direct access not allowed.';
    exit;
}

global $wpdb;

$cpid = 'CP_ABC';
$plugslug = 'cpabc_appointments.php';

if ( 'POST' == $_SERVER['REQUEST_METHOD'] && isset( $_POST[$cpid.'_post_edition'] ) )
    echo "<div id='setting-error-settings_updated' class='updated settings-error'> <p><strong>Settings saved.</strong></p></div>";

if ($_GET["item"] == 'js')
    $saved_contents = base64_decode(get_option($cpid.'_JS', ''));
else if ($_GET["item"] == 'css')
    $saved_contents = base64_decode(get_option($cpid.'_CSS', ''));

?>
<script>
// Move to an external file
jQuery(function(){
	var $ = jQuery;
    <?php 
            if(function_exists('wp_enqueue_code_editor'))
			{
				$settings_js = wp_enqueue_code_editor(array('type' => 'application/javascript'));
				$settings_css = wp_enqueue_code_editor(array('type' => 'text/css'));

				// Bail if user disabled CodeMirror.
				if(!(false === $settings_js && false === $settings_css))
				{
                    if ($_GET["item"] == 'js')
                        print sprintf('{wp.codeEditor.initialize( "editionarea", %s );}',wp_json_encode( $settings_js ));
                    else
					    print sprintf('{wp.codeEditor.initialize( "editionarea", %s );}',wp_json_encode( $settings_css ));;
				}
			}      
              
    ?>    
});
</script>
<style>
.ahb-tab{display:none;}
.ahb-tab label{font-weight:600;}
.tab-active{display:block;}
.ahb-code-editor-container{border:1px solid #DDDDDD;margin-bottom:20px;}
  
.ahb-csssample { margin-top: 15px; margin-left:20px;  margin-right:20px;}
.ahb-csssampleheader { 
  font-weight: bold; 
  background: #dddddd;
	padding:10px 20px;-webkit-box-shadow: 0px 2px 2px 0px rgba(100, 100, 100, 0.1);-moz-box-shadow:    0px 2px 2px 0px rgba(100, 100, 100, 0.1);box-shadow:         0px 2px 2px 0px rgba(100, 100, 100, 0.1);
}
.ahb-csssamplecode {     background: #f4f4f4;
    border: 1px solid #ddd;
    border-left: 3px solid #f36d33;
    color: #666;
    page-break-inside: avoid;
    font-family: monospace;
    font-size: 15px;
    line-height: 1.6;
    margin-bottom: 1.6em;
    max-width: 100%;
    overflow: auto;
    padding: 1em 1.5em;
    display: block;
    word-wrap: break-word; 
}   
</style>
<div class="wrap">
<h1>Customization / Edit Page</h1>  



<input type="button" name="backbtn" value="Back to items list..." onclick="document.location='admin.php?page=<?php echo $plugslug; ?>';">
<br /><br />


Note: This section has been modified to improve security. Please edit the custom CSS in the theme. You can <a href="https://abc.dwbooster.com/contact-us">contact us for support and assistance</a>.
  


</form>


<?php if ($_GET["item"] == 'css') { ?>
<hr />
   
   <div class="ahb-statssection-container" style="background:#f6f6f6;">
	<div class="ahb-statssection-header" style="background:white;
	padding:10px 20px;-webkit-box-shadow: 0px 2px 2px 0px rgba(100, 100, 100, 0.1);-moz-box-shadow:    0px 2px 2px 0px rgba(100, 100, 100, 0.1);box-shadow:         0px 2px 2px 0px rgba(100, 100, 100, 0.1);">
    <h3>Sample Styles:</h3>
	</div>
	<div class="ahb-statssection">
      
        <div class="ahb-csssample">
         <div class="ahb-csssampleheader">
           Center the calendar in the page:
         </div>
         <div class="ahb-csssamplecode">
           .appContainer{text-align:center;}<br />
           .appContainer2{margin-left:auto;margin-right:auto;width:200px}     
         </div>
        </div> 
        
        <div class="ahb-csssample">
         <div class="ahb-csssampleheader">
           Change the calendar's width and height:
         </div>
         <div class="ahb-csssamplecode">
           .yui-calendar td.calcell, #cp_abcform_pform .yui-calendar td.calcell {<br />
               padding-top:10px;<br />
               padding-bottom:10px;<br />
               border:1px solid #E0E0E0;<br />
               text-align:center;<br />
               vertical-align: top;<br />
           }   <br />
         </div>
        </div> 

        <div class="ahb-csssample">
         <div class="ahb-csssampleheader">
           Change the background color of the selected date:
         </div>
         <div class="ahb-csssamplecode">
           .yui-calendar td.calcell.reserveddate { background-color:#B6EA59; }     
         </div>
        </div> 
        
        <div class="ahb-csssample">
         <div class="ahb-csssampleheader">
           Make the calendar 100% width:
         </div>
         <div class="ahb-csssamplecode">
           .yui-calendar td.calcell, #cp_abcform_pform .yui-calendar td.calcell {<br />
               border:1px solid #E0E0E0;<br />
               text-align:center;<br />
               vertical-align: top;<br />
           }<br />
           .yui-calendar .calheader, #cp_abcform_pform .yui-calendar .calheader {<br />
               width:100%;<br />
           }<br />
           .yui-calendar, #cp_abcform_pform .yui-calendar {<br />
               width:100%;<br />
               table-layout: fixed;<br />
           }
         </div>
        </div>         
        
        <div class="ahb-csssample">
         <div class="ahb-csssampleheader">
           Other styles:
         </div>
         <div class="ahb-csssamplecode">
           For other styles check the design section in the FAQ: <a href="https://abc.dwbooster.com/faq?page=faq#design">https://abc.dwbooster.com/faq?page=faq#design</a>     
         </div>
        </div>         
       
    </div>
   </div>
   
<?php } ?>

</div>













