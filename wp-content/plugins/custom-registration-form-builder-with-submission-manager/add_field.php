<?php
global $wpdb;
$textdomain = 'custom-registration-form-builder-with-submission-manager';
$crf_forms =$wpdb->prefix."crf_forms";
$crf_fields =$wpdb->prefix."crf_fields";
$path =  plugin_dir_url(__FILE__); 
$qrylastrow = "select count(*) from $crf_fields where Form_Id = '".$_REQUEST['formid']."'"; 
$lastrow = $wpdb->get_var($qrylastrow);
$ordering = $lastrow+1;
if(isset($_REQUEST['type'])) $str = $_REQUEST['type'];
if(isset($_REQUEST['action']) && $_REQUEST['action']=='delete')
{
	$retrieved_nonce = $_REQUEST['_wpnonce'];
	if (!wp_verify_nonce($retrieved_nonce, 'delete_crf_field' ) ) die( 'Failed security check' );

	$qry = "delete from $crf_fields where Id=".$_REQUEST['id'];	
	$reg = $wpdb->query($qry);	
	wp_redirect('admin.php?page=crf_manage_form_fields&form_id='.$_REQUEST['formid']);exit;
}

if(isset($_REQUEST['id']))
{
	$qry="select * from $crf_fields where Id=".$_REQUEST['id'];	
	$reg = $wpdb->get_row($qry);
	$str = $reg->Type;
}

if(isset($_POST['field_submit']) && empty($_POST['field_id']))/*Saves the field after clicking save button*/
{
	$retrieved_nonce = $_REQUEST['_wpnonce'];
	if (!wp_verify_nonce($retrieved_nonce, 'save_crf_add_field' ) ) die( 'Failed security check' );
	
	if($_POST['select_type']=='radio' || $_POST['select_type']=='checkbox')
	{
		$finaloptionvalues =  rtrim(implode(',',$_POST['optionvalue']),',');
	}
	else
	{
	    $finaloptionvalues = $_POST['field_Options'];
	}

$qry = "insert into $crf_fields values('','".$_POST['form_id']."','".$_POST['select_type']."','".$_POST['field_name']."','".$_POST['field_value']."','".$_POST['field_class']."','".$_POST['field_maxLenght']."','".$_POST['field_cols']."','".$_POST['field_rows']."','".$finaloptionvalues."','".$_POST['field_Des']."','".$_POST['field_require']."','".$_POST['field_readonly']."','".$_POST['field_visibility']."','".$ordering."')";
$row = $wpdb->query($qry);	
wp_redirect('admin.php?page=crf_manage_form_fields&form_id='.$_POST['form_id']);exit;
}

if(isset($_POST['field_submit']) && !empty($_POST['field_id']))
{
	$retrieved_nonce = $_REQUEST['_wpnonce'];
	if (!wp_verify_nonce($retrieved_nonce, 'save_crf_add_field' ) ) die( 'Failed security check' );
	
	if($_POST['select_type']=='radio' || $_POST['select_type']=='checkbox')
	{
		$finaloptionvalues =  implode(',',$_POST['optionvalue']);
	}
	else
	{
	    $finaloptionvalues = $_POST['field_Options'];
	}

	$qry = "update $crf_fields set Form_Id='".$_POST['form_id']."',Type ='".$_POST['select_type']."',Name ='".$_POST['field_name']."',`Value` ='".$_POST['field_value']."',Class='".$_POST['field_class']."',Max_Length='".$_POST['field_maxLenght']."',Cols='".$_POST['field_cols']."',Rows='".$_POST['field_rows']."',Option_Value='".$finaloptionvalues."',Description='".$_POST['field_Des']."',`Require`='".$_POST['field_require']."',Readonly='".$_POST['field_readonly']."',Visibility='".$_POST['field_visibility']."' where Id='".$_POST['field_id']."'";
$row = $wpdb->query($qry);	
wp_redirect('admin.php?page=crf_manage_form_fields&form_id='.$_POST['form_id']);exit;

}

?>
<script>
    jQuery(document).ready(function () {
        // Handler for .ready() called.
        getfields('<?php echo $str;?>');
    });
</script>
<style>
.form_field p {
	display: none;
}
#selectfieldtype {
	display: block;
}
</style>

<div class="crf-main-form">
  <div class="crf-form-heading">
  <?php if(isset($_REQUEST['id'])):?>
    <h1><?php _e( 'Edit Field:', $textdomain ); ?></h1>
    <?php else: ?>
    <h1><?php _e( 'New Field:', $textdomain ); ?></h1>
    <?php endif; ?>
  </div>
  
  <!--HTML for custom field creation-->
  
  <form method="post" action="" id="add_field_form">
    <div class="crf-form-setting" id="selectfieldtype">
      <div class="crf-form-left-area">
        <div class="crf-label">
          <?php _e( 'Select Type:', $textdomain ); ?>
        </div>
      </div>
      <div class="crf-form-right-area">
        <select name="select_type" id="select_type" onChange="getfields(this.value)">
          <option value=""><?php _e( 'Select A Field', $textdomain ); ?></option>
          <option value="heading" <?php if(isset($str) && $str=='heading') echo 'selected'; ?>><?php _e( 'Heading', $textdomain ); ?></option>
          <option value="paragraph" <?php if(isset($str) && $str=='paragraph') echo 'selected'; ?>><?php _e( 'Paragraph', $textdomain ); ?></option>
          <option value="text" <?php if(isset($str) && $str=='text') echo 'selected'; ?>><?php _e( 'Text', $textdomain ); ?></option>
          <option value="select" <?php if(isset($str) && $str=='select') echo 'selected'; ?>><?php _e( 'Drop Down', $textdomain ); ?></option>
          <option value="radio" <?php if(isset($str) && $str=='radio') echo 'selected'; ?>><?php _e( 'Radio Button', $textdomain ); ?></option>
          <option value="textarea" <?php if(isset($str) && $str=='textarea') echo 'selected'; ?>><?php _e( 'Text Area', $textdomain ); ?></option>
          <option value="checkbox" <?php if(isset($str) && $str=='checkbox') echo 'selected'; ?>><?php _e( 'Check Box', $textdomain ); ?></option>
          <option value="DatePicker" <?php if(isset($str) && $str=='DatePicker') echo 'selected'; ?>><?php _e( 'Date', $textdomain ); ?></option>
          <option value="email" <?php if(isset($str) && $str=='email') echo 'selected'; ?>><?php _e( 'Email', $textdomain ); ?></option>
          <option value="number" <?php if(isset($str) && $str=='number') echo 'selected'; ?>><?php _e( 'Number', $textdomain ); ?></option>
           <option value="country" <?php if(isset($str) && $str=='country') echo 'selected'; ?>><?php _e( 'Country', $textdomain ); ?></option>
           <option value="timezone" <?php if(isset($str) && $str=='timezone') echo 'selected'; ?>><?php _e( 'Timezone', $textdomain ); ?></option>
          <option value="term_checkbox" <?php if(isset($str) && $str=='term_checkbox') echo 'selected'; ?>><?php _e( 'T&C Checkbox', $textdomain ); ?></option>
        </select>
      </div>
    </div>
    <div class="crf-form-setting" id="namefield">
      <div class="crf-form-left-area">
        <div class="crf-label">
          <?php _e( 'Label:', $textdomain ); ?>
        </div>
      </div>
      <div class="crf-form-right-area">
        <input type="text" name="field_name" id="field_name" value="<?php if(!empty($reg)) echo $reg->Name; ?>" required onKeyUp="check('<?php if(!empty($reg)){echo $reg->Name;}else { echo 'new';} ?>','<?php if(isset($_REQUEST['formid'])) echo $_REQUEST['formid']?>')">
        <div id="user-result"></div>
      </div>
    </div>
    <div class="crf-form-setting" id="optionsfield">
      <div class="crf-form-left-area">
        <div class="crf-label">
          <?php _e( 'Options:', $textdomain ); ?>
          <small style="float:left;"><?php _e( '(value seprated by comma ",")', $textdomain ); ?></small> </div>
      </div>
      <div class="crf-form-right-area">
        <textarea type="text" name="field_Options" id="field_Options" cols="25" rows="5"><?php if(!empty($reg)) echo $reg->Option_Value; ?></textarea>
      </div>
    </div>
    
    
    <div class="crf-form-setting" id="optionsfield2">
      <div class="crf-form-left-area">
        <div class="crf-label"><?php _e( 'Options:', $textdomain ); ?></div>
      </div>
      <div class="crf-form-right-area">
      <ul id="sortablefield" class="optionsfieldwrapper">
      <?php
	  $optionvalues = @explode(',',$reg->Option_Value);
	  foreach($optionvalues as $optionvalue)
	  {
		  if($optionvalue=='chl_other') continue;
		  ?>
          <li class="optioninputfield">
          <span class="handle"></span>
          	<input type="text" name="optionvalue[]" value="<?php if(!empty($optionvalue)) echo esc_attr($optionvalue); ?>"><span class="removefield" onClick="removefield(this)">Delete</span>
            
            </li>
          <?php
	  }
	  ?>
      </ul>
      <input type="text" value="" placeholder="Click to add option" maxlength="0" onClick="addoption()" onKeyUp="addoption()">
      <?php if(!in_array('chl_other',$optionvalues)): ?> 
      <span class="addother" onClick="addother()"> or Add "Other"</span>
      <?php else: ?>
      <div class="optioninputfield" style=" margin-top:12px;"><input type="text" name="optionvalue[]" id="optionvalue[]" value="Their answer" disabled><span class="removefield" onClick="removeother(this)">Delete</span><input type="hidden" name="optionvalue[]" id="optionvalue[]" value="chl_other" /></div>
      <?php endif; ?>
      </div>
    </div>
    
    
    
    <div class="crf-form-setting" id="desfield">
      <div class="crf-form-left-area">
        <div class="crf-label">
          <?php _e( 'Description:', $textdomain ); ?>
        </div>
      </div>
      <div class="crf-form-right-area">
        <textarea type="text" name="field_Des" id="field_Des" cols="25" rows="5"><?php if(!empty($reg)) echo $reg->Description; ?></textarea>
      </div>
    </div>
    <div class="crf-form-setting">
      <div class="toggle_button crf-form-left-area">
        <div class="crf-label"><?php _e( 'Advance Options', $textdomain ); ?></div>
        <span class="show_hide" id="plus"></span></div>
    </div>
    <div class="slidingDiv">
      <div class="crf-form-setting" id="valuefield">
        <div class="crf-form-left-area">
          <div class="crf-label">
            <?php _e( 'Default Value:', $textdomain ); ?>
          </div>
        </div>
        <div class="crf-form-right-area">
          <input type="text" name="field_value" id="field_value" value="<?php if(!empty($reg)) echo $reg->Value; ?>">
        </div>
      </div>
      <div class="crf-form-setting" id="classfield">
        <div class="crf-form-left-area">
          <div class="crf-label">
            <?php _e( 'CSS Class Attribute:', $textdomain ); ?>
          </div>
        </div>
        <div class="crf-form-right-area">
          <input type="text" name="field_class" id="field_class" value="<?php if(!empty($reg)) echo $reg->Class; ?>">
        </div>
      </div>
      <div class="crf-form-setting" id="maxlenghtfield">
        <div class="crf-form-left-area">
          <div class="crf-label">
            <?php _e( 'Maximum Length:', $textdomain ); ?>
          </div>
        </div>
        <div class="crf-form-right-area upb_number">
          <input type="text" name="field_maxLenght" id="field_maxLenght" value="<?php if(!empty($reg)) echo $reg->Max_Length; ?>">
          <div class="custom_error"></div>
        </div>
      </div>
      <div class="crf-form-setting" id="colsfield">
        <div class="crf-form-left-area">
          <div class="crf-label">
            <?php _e( 'Columns:', $textdomain ); ?>
          </div>
        </div>
        <div class="crf-form-right-area upb_number">
          <input type="text" name="field_cols" id="field_cols" value="<?php if(!empty($reg)) echo $reg->Cols; ?>">
          <div class="custom_error"></div>
        </div>
      </div>
      <div class="crf-form-setting" id="rowsfield">
        <div class="crf-form-left-area">
          <div class="crf-label">
            <?php _e( 'Rows:', $textdomain ); ?>
          </div>
        </div>
        <div class="crf-form-right-area upb_number">
          <input type="text" name="field_rows" id="field_rows" value="<?php if(!empty($reg)) echo $reg->Rows; ?>">
          <div class="custom_error"></div>
        </div>
      </div>
      <div class="crf-form-setting">
        <p class="rules" id="rulesfield" style="width:100%;"><?php _e( 'Rules', $textdomain ); ?></p>
      </div>
      <div class="crf-form-setting" id="requirefield">
        <div class="crf-form-left-area">
          <div class="crf-label">
            <?php _e( 'Is Required:', $textdomain ); ?>
          </div>
        </div>
        <div class="crf-form-right-area">
          <input type="checkbox" name="field_require" id="field_require" value="1" style="width:auto;" <?php if(!empty($reg) && $reg->Require==1) echo 'checked'; ?>/>
        </div>
      </div>
      <div class="crf-form-setting" id="readonlyfield">
        <div class="crf-form-left-area">
          <div class="crf-label">
            <?php _e( 'Is Read Only:', $textdomain ); ?>
          </div>
        </div>
        <div class="crf-form-right-area">
          <input type="checkbox" name="field_readonly" id="field_readonly" value="1" style="width:auto;" <?php if(!empty($reg) && $reg->Readonly==1) echo 'checked'; ?> />
        </div>
      </div>
      <div class="crf-form-setting" id="visibilityfield">
        <div class="crf-form-left-area">
          <div class="crf-label">
            <?php _e( 'Visibility:', $textdomain ); ?>
          </div>
        </div>
        <div class="crf-form-right-area">
          <select type="checkbox" name="field_visibility" id="field_visibility">
            <option value="1" <?php if(!empty($reg) && $reg->Visibility==1) echo 'selected'; ?>>Public</option>
            <option value="2" <?php if(!empty($reg) && $reg->Visibility==2) echo 'selected'; ?>>Registered</option>
            <option value="3" <?php if(!empty($reg) && $reg->Visibility==3) echo 'selected'; ?>>Private</option>
          </select>
        </div>
      </div>
    </div>
    <div class="crf-form-footer">
      <div class="crf-form-button">
      	<?php wp_nonce_field('save_crf_add_field'); ?>
        <input type="hidden" name="form_id" id="form_id" value="<?php if(isset($_REQUEST['formid'])) echo $_REQUEST['formid']?>" />
        <input type="hidden" name="field_id" id="field_id" value="<?php if(isset($_REQUEST['id'])) echo $_REQUEST['id']?>" />
        <input type="submit" value="Save" name="field_submit" id="field_submit" />
        <input type="button" value="Cancel" class="crf-back-button cancel_button" name="field_back" id="field_back" onClick="redirectform(<?php if(isset($_REQUEST['formid'])) echo $_REQUEST['formid']?>,'crf_manage_form_fields')"  />
      </div>
      <div class="customupberror" style="display:none;"></div>
    </div>
  </form>
</div>
<script>
    
</script>
<script type="text/javascript">
    function check(prev, formid) {
        name = jQuery("#field_name").val();
        jQuery.post('<?php echo get_option('siteurl').'/wp-admin/admin-ajax.php';?>?action=check_crf_field_name&cookie=encodeURIComponent(document.cookie)', {
                'name': name,
                'prev': prev,
                'formid': formid
            },
            function (data) {
                //make ajax call to check_username.php
				//alert(data)
                if (jQuery.trim(data) == "") {
                    jQuery("#user-result").html('');
                    jQuery("#field_submit").show();
					return true;
                } else {
                    jQuery("#user-result").html(data);
                    jQuery("#field_submit").hide();
					return false;
                }
                //dump the data received from PHP page
            });
    }
</script>
