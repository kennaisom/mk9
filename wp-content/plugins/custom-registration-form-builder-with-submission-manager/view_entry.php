<?php
/*Controls registration form behavior on the front end*/
global $wpdb;
include_once 'crf_functions.php';

$form_fields = new crf_basic_fields;

$textdomain = 'custom-registration-form-builder-with-submission-manager';
$crf_forms =$wpdb->prefix."crf_forms";
$crf_fields =$wpdb->prefix."crf_fields";
$path =  plugin_dir_url(__FILE__);
$crf_option=$wpdb->prefix."crf_option";
$crf_submissions =$wpdb->prefix."crf_submissions";
$qry="select `value` from $crf_option where fieldname='from_email'";
$from_email_address = $wpdb->get_var($qry);
$qry = "select * from $crf_submissions where submission_id='".$_REQUEST['id']."'";
$entry =$wpdb->get_row($qry);
$form_type = crf_submision_field_value($_REQUEST['id'],'form_type');
//print_r($entry);die;
$user_approval = crf_submision_field_value($_REQUEST['id'],'user_approval');
$user_name = crf_submision_field_value($_REQUEST['id'],'user_name'); // receiving username
$user_email = crf_submision_field_value($_REQUEST['id'],'user_email'); // receiving email address
$inputPassword = crf_submision_field_value($_REQUEST['id'],'user_pass'); // receiving password
$role = crf_submision_field_value($_REQUEST['id'],'role');


if($from_email_address=="")
{
	$from_email_address = get_option('admin_email');	
}

if(isset($_REQUEST['delete_entry']) && isset($_REQUEST['id']))
{
	$retrieved_nonce = $_REQUEST['_wpnonce'];
	if (!wp_verify_nonce($retrieved_nonce, 'delete_crf_entry' ) ) die( 'Failed security check' );

	$qry = "delete from $crf_submissions where submission_id =".$_REQUEST['id'];
	$wpdb->query($qry);
	wp_redirect('admin.php?page=crf_entries&form_id='.$entry->form_id);exit;
}
$form_name = crf_get_form_option_value('form_name',$entry->form_id);

if(isset($_REQUEST['user_enable']) && isset($_REQUEST['id']))
{
		$retrieved_nonce = $_REQUEST['_wpnonce'];
		if (!wp_verify_nonce($retrieved_nonce, 'approve_crf_entry' ) ) die( 'Failed security check' );

	 $uservalue['user_name'] = $user_name = crf_submision_field_value($_REQUEST['id'],'user_name'); // receiving username
	 $uservalue['user_email'] = $user_email = crf_submision_field_value($_REQUEST['id'],'user_email'); // receiving email address
	 $uservalue['user_pass'] = $inputPassword = crf_submision_field_value($_REQUEST['id'],'user_pass'); // receiving password
	 $userid = username_exists( $user_name ); // Checks if username is already exists.
	 $role = crf_submision_field_value($_REQUEST['id'],'role');
	  if(!isset($role) || $role=="")
	  {
		  $role = 'subscriber';//Defines default role if there is not shortcode in registration form
	  }
	  
	  //echo $userid;die;
	  if ( !$userid and email_exists($user_email) == false )//Creates password if password auto-generation is turned on in the settings
	  {
	  	$userid = crf_create_user($uservalue);
		$userid = wp_update_user( array( 'ID' => $userid, 'role' => $role ) );
		
		 /*Insert custom field values if displayed in registration form*/
			  $qry1 = "select * from $crf_fields where Form_Id= '".$entry->form_id."' and Type not in('heading','paragraph') order by ordering asc";
			  $reg1 = $wpdb->get_results($qry1);
			  if(!empty($reg1))
			  {
			   foreach($reg1 as $row1)
			   {
				  if(!empty($row1))
				  {
					  $Customfield  = sanitize_key($row1->Name).'_'.$row1->Id;
					  $value = crf_submision_field_value($_REQUEST['id'],$Customfield);
					  if(!isset($prev_value)) $prev_value='';
					  add_user_meta( $userid, $Customfield, $value, true );
					  update_user_meta( $userid, $Customfield, $value, $prev_value );
				  }
			   }
			  }
			  
			  $form_fields->crf_send_user_email($entry->form_id,$uservalue,$userid,$_REQUEST['id']);
			  $qry = "UPDATE $crf_submissions SET `value` = 'yes' WHERE `submission_id` = '".$_REQUEST['id']."' and `field` = 'user_approval'";
			  $wpdb->query($qry);
			  wp_redirect('admin.php?page=crf_entries&form_id='.$entry->form_id);exit;
	  }
}
?>
<div class="crf-main-form">
  <div class="crf-main-form-top-area">
    <div class="crf-form-name-heading">
      <h1><?php echo $form_name; ?></h1>
    </div>
    <div class="crf-form-name-buttons">
      <div class="crf-setting"><a href="#"></a></div>
    </div>
  </div>
  <div class="crf-new-buttons"><span class="crf-back-button">
    <input name="Back" type="submit" autofocus id="Back" title="Back" value="Back" onClick="redirectform(<?php echo $entry->form_id;?>,'crf_entries')">
    </span> <span class="crf-duplicate-button">
    <form action="admin.php?page=crf_view_entry">
    <?php wp_nonce_field('delete_crf_entry'); ?>
      <input type="submit" value="Delete" name="delete_entry">
      <input type="hidden" value="<?php echo $entry->id;?>" name="id" />
      <input type="hidden" value="crf_view_entry" name="page" >
    </form>
    </span> <span class="crf-Approve-Registration-button">
    <?php

if($form_type=='reg_form' && $user_approval=='no')
{
?>
    <form action="admin.php?page=crf_view_entry">
    <?php wp_nonce_field('approve_crf_entry'); ?>
      <input type="submit" value="Approve WP Registration" name="user_enable">
      <input type="hidden" value="<?php echo $_REQUEST['id'];?>" name="id" />
      <input type="hidden" value="crf_view_entry" name="page" >
    </form>
    <?php
}
?>
    </span></div>
</div>
<div class="crf-signle-entry-form">
  <div class="crf-single-entry-content">
    <div>
      <p><span class="entry_heading"><?php _e('Entry Id :',$textdomain);?> </span><span class="entry_Value"><?php echo $_REQUEST['id'];?></span></p>
      <p><span class="entry_heading"><?php _e('Entry Type :',$textdomain);?> </span><span class="entry_Value">
        <?php if($form_type=='reg_form'){echo 'Registration Form';}else{echo 'Contact Form';}?>
        </span></p>
      <?php
	  if(isset($user_name)):
  		?>
      <p><span class="entry_heading">User Name : </span><span class="entry_Value" ><?php echo $user_name; ?></span></p>
      <?php
		endif;
		
		if(isset($user_email)):
  		?>
      <p><span class="entry_heading">User Email : </span><span class="entry_Value" ><?php echo $user_email; ?></span></p>
      <?php
		endif;
		
		if(isset($role)):
  		?>
      <p><span class="entry_heading">User Role : </span><span class="entry_Value" ><?php echo $role; ?></span></p>
      <?php
		endif;
		
	  $qry1 = "select * from $crf_fields where Form_Id= '".$entry->form_id."' and Type not in('heading','paragraph','file') order by ordering asc";
	  $reg1 = $wpdb->get_results($qry1);
	  if(!empty($reg1))
	  {
	   foreach($reg1 as $row1)
	   {
		  if(!empty($row1))
		  {
			  
			  $key = crf_get_field_key($row1);
			  $value = crf_submision_field_value($_REQUEST['id'],$key);
			  $Customfield = $row1->Name;
			  if(!empty($value)):
			  ?>
      <p><span class="entry_heading"><?php echo $Customfield; ?> : </span><span class="entry_Value"><?php echo $value; ?></span></p>
      <?php 
	  endif; 
		  }
	   }
	  }
	  $User_IP = crf_submision_field_value($_REQUEST['id'],'User_IP');
	  $user_ip = crf_submision_field_value($_REQUEST['id'],'user_ip');
	  if(isset($user_ip) || $user_ip!="")
	  {
			$ip = $user_ip;  
	  }
	  if(isset($User_IP) || $User_IP!="")
	  {
			$ip = $User_IP;  
	  }
	  
	  if(isset($ip)):
  		?>
      <p><span class="entry_heading">IP : </span><span class="entry_Value" ><?php echo $ip; ?></span><span class="entry_Value" style="padding-left:10px;"><a style="color:#ff6c6c;" target="_blank" href="http://www.geoiptool.com/?IP=<?php echo $ip; ?>">View Location</a></span></p>
      <?php
		endif;
		
		if(crf_submision_field_value($_REQUEST['id'],'Browser')!=""):
		$browser = crf_submision_field_value($_REQUEST['id'],'Browser');
		//echo $browser;die;
		$ExactBrowserNameBR = crf_get_browser_name($browser);
		?>
 <p><span class="entry_heading">Browser : </span><span class="entry_Value" ><?php echo $ExactBrowserNameBR; ?></span></p>
      <?php
		endif;
	  
/*file addon start */
	$attachment_html = crf_get_entry_attachment($entry->form_id,$_REQUEST['id']);
	if(isset($attachment_html))
	{
		echo $attachment_html;	
	}
	/*file addon end */
?>
    </div>
  </div>
</div>