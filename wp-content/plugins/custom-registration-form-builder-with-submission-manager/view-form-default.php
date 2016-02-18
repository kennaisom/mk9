<?php
/*Controls registration form behavior on the front end*/
global $wpdb;
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
include_once('crf_functions.php');
$form_fields = new crf_basic_fields;
$crf_theme = $form_fields->crf_get_global_option_value('crf_theme');

//date_default_timezone_set(get_option('timezone_string')); 
wp_enqueue_style( 'crf-style-default', plugin_dir_url(__FILE__) . 'css/crf-style-'.$crf_theme.'.css');
$textdomain = 'custom-registration-form-builder-with-submission-manager';
$crf_forms =$wpdb->prefix."crf_forms";
$crf_fields =$wpdb->prefix."crf_fields";
$crf_stats =$wpdb->prefix."crf_stats";
$path =  plugin_dir_url(__FILE__);
$crf_option=$wpdb->prefix."crf_option";
$crf_entries =$wpdb->prefix."crf_entries";
$enable_captcha = $form_fields->crf_get_global_option_value('enable_captcha');
$custom_text = $form_fields->crf_get_form_option_value('custom_text',$content['id']);
$form_type = $form_fields->crf_get_form_option_value('form_type',$content['id']);
$form_name = $form_fields->crf_get_form_option_value('form_name',$content['id']);
$form_options = $form_fields->crf_get_form_option_value('form_option',$content['id']);
$form_option = maybe_unserialize($form_options);
if(isset($form_option['submit_button_label']))
$submit_button_label = $form_option['submit_button_label'];

if(isset($form_option['submit_button_color']))
$submit_button_color = $form_option['submit_button_color'];
if(isset($form_option['submit_button_bgcolor']))
$submit_button_bgcolor = $form_option['submit_button_bgcolor'];

$expire = $form_fields->check_crf_form_expiration($form_option,$content['id']);
if($expire!="")
{
 echo $expire; return false;
}

if(isset($form_option['user_role_label']))
$user_role_label = $form_option['user_role_label'];
if(isset($form_option['user_role_options']))
$user_role_options = $form_option['user_role_options'];
if(isset($form_option['let_user_decide']))
$let_user_decide = $form_option['let_user_decide'];

$role = $form_fields->set_crf_user_role($content['id'],$_POST,$form_option);

$userip = $form_fields->crf_get_global_option_value('userip');
$publickey = $form_fields->crf_get_global_option_value('public_key');
$privatekey = $form_fields->crf_get_global_option_value('private_key');

if($form_type=='reg_form')
{
	wp_enqueue_script( 'mocha.js',  plugin_dir_url(__FILE__) . 'js/mocha.js');	
}
$pwd_show = $form_fields->crf_get_global_option_value('autogeneratedepass');
$autoapproval = $form_fields->crf_get_global_option_value('userautoapproval');
if($enable_captcha=='yes')
{
	if(isset($_POST['g-recaptcha-response']))
	{
		require_once('autoload.php');
		$recaptcha = new \ReCaptcha\ReCaptcha($privatekey,new \ReCaptcha\RequestMethod\CurlPost());
		$resp = $recaptcha->verify($_POST['g-recaptcha-response'], $_SERVER['REMOTE_ADDR']);
		if ($resp->isSuccess()) 
		{
			$submit = 1;
		} 
		else 
		{
			$errors = $resp->getErrorCodes();
			$form_fields->crf_field_captcha_error($errors);
			$submit = 0;
		}
	}
	
}
else
{
	$submit=1;
}

if(isset($_POST['submit']) && $submit==1 ) // Checks if the submit button is pressed or not
{
	$retrieved_nonce = $_REQUEST['_wpnonce'];
	if (!wp_verify_nonce($retrieved_nonce, 'view_crf_form' ) ) die( 'Failed security check' );
	$form_fields->crf_update_stats($_POST,$content['id']);
	
	$entry_id = $form_fields->crf_insert_form_entry($_POST,$content['id'],$_FILES,$_SERVER);
	$userid = 0;
	if($form_type=='reg_form' && $autoapproval=='yes')
	{
		$userid = $form_fields->crf_create_user($_POST,$role);
		$form_fields->crf_insert_user_data($content['id'],$_POST,$userid);
	}
	//Fetches Auto Responder enable or disalbe.
	  $send_email = $form_fields->crf_get_form_option_value('send_email',$content['id']);
	  if($send_email==1)
	  {
		  $form_fields->crf_send_user_email($content['id'],$_POST,$userid,$entry_id);
	  }
	  
	  $enable_mailchimp = $form_fields->crf_get_global_option_value('enable_mailchimp');
	  if($enable_mailchimp=='yes')
	  {
		  /*mailchimp start */
		  $subscriber_email = $form_fields->crf_get_subscriber_email($content['id'],$_POST);
		  $firstname = $form_fields->crf_get_subscriber_other_field($content['id'],$_POST,'mailchimp_firstfield');
		  $lastname = $form_fields->crf_get_subscriber_other_field($content['id'],$_POST,'mailchimp_lastfield');
		  $form_options = $form_fields->crf_get_form_option_value('form_option',$content['id']);
		   $form_option = maybe_unserialize($form_options);
		   $optin_box = $form_option['optin_box'];
		  // echo $optin_box;die;
		   if($optin_box==1)
		   {
			   if(isset($_POST['crf_optin_box']) && $_POST['crf_optin_box']=='yes')
			   {
				 $result = $form_fields->crf_insert_mailchimp($content['id'],$subscriber_email,$firstname,$lastname);
				 //print_r($result);
			   }
		   }
		   else
		   {
			   
			    $result = $form_fields->crf_insert_mailchimp($content['id'],$subscriber_email,$firstname,$lastname);
				//print_r( $result);
		   }
	  }
		//print_r($result);die;
	  
	  /*mailchip end */
	   /*admin notification start */
	   
	   
	  $admin_notification = $form_fields->crf_get_global_option_value('adminnotification');
	  if($admin_notification=='yes')
	  {
		$form_fields->crf_send_admin_notification($entry_id,$content['id']);
	   }
	  /*admin notification end */
	  
	 $form_fields->crf_get_success_message($content['id']);

	$redirect_option = $form_fields->crf_get_form_option_value('redirect_option',$content['id']);
	$url = $form_fields->crf_get_redirect_url($content['id'],$redirect_option);
	
	if($redirect_option!='none')
	{	
		header('refresh: 5; url='.$url);
	}
	
	
	
	  
	 
}
else
{
$detail = array();
$detail['User_IP'] = $_SERVER['REMOTE_ADDR'];
//$detail['country'] = $form_fields->crf_get_country_name($_SERVER['REMOTE_ADDR']);
$detail['Browser'] = $_SERVER['HTTP_USER_AGENT'];
$detail['timestamp'] = time();
$detail['key'] = time().$content['id'];
$details = maybe_serialize($detail);
$insert="INSERT INTO $crf_stats VALUES('','".$content['id']."','".$detail['key']."','".$details."')";
$wpdb->query($insert);
?>
<!--HTML for displaying registration form-->

<div id="crf-form">
  <form enctype="multipart/form-data" method="post" action="" id="crf_contact_form" name="crf_contact_form">
  <?php wp_nonce_field('view_crf_form'); ?>
  <?php $form_fields->crf_get_custom_form_field_analytics($detail['key']); ?>
    <div class="info-text"><?php echo $custom_text;?></div>
    
   <div class="crf_contact_form">
      <?php 
	  
	  $form_fields->crf_field_creation($content['id'],$form_type);
	  
       ?>
      <br class="clear">
    </div>
    
    <div class="customcrferror crf_error_text" style="display:none"></div>
    
    <div class="UltimatePB-Button-area crf_input crf_input_submit form-submit" >
    <input type="hidden" value="<?php echo $form_type;?>" name="form_type" id="form_type" class="crf_form_type"/>
      <input type="submit" value="<?php if($submit_button_label!="")echo $submit_button_label;else echo 'Submit'?>" class="crf_contact_submit primary" id="submit" name="submit">
     
    </div>
    <?php
	if($form_type=='reg_form'):
		crf_integrate_facebook_login();
	endif;
	?>
    
  </form>
</div>
<?php
	}	
?>
<?php if($form_type=='reg_form'): ?>
<script language="javascript" type="text/javascript">
    //AJAX username validation
    var name = false;
    var email = false;

    function validete_userName() {
        jQuery.ajax({
            type: "POST",
            url: '<?php echo get_option('siteurl').'/wp-admin/admin-ajax.php';?>?action=crf_ajaxcalls&cookie=encodeURIComponent(document.cookie)&function=validateUser&name=' + jQuery("#user_name").val(),
            success: function (serverResponse) {
                if (serverResponse.trim() == "true") {
                    jQuery("#nameErr").html("<?php _e('Sorry, username already exist',$textdomain);?>");
                    jQuery("#nameErr").css('display','block');
                    jQuery("#submit").attr('disabled', true);
                } else {
                    jQuery("#nameErr").html('');
                    jQuery("#nameErr").css('display','none');
                    jQuery("#submit").attr('disabled', false);
                }
            }
        })
    }

    function validete_email() //AJAX email validation
        {
            jQuery.ajax({
                type: "POST",
                url: '<?php echo get_option('siteurl').'/wp-admin/admin-ajax.php';?>?action=crf_ajaxcalls&cookie=encodeURIComponent(document.cookie)&function=validateEmail&email=' + jQuery("#user_email").val(),
                success: function (serverResponse) {
                    if (serverResponse.trim() == "true") {
                        email = false;
                        jQuery("#emailErr").html("<?php _e('Sorry, email already exist',$textdomain);?>");
                        jQuery("#emailErr").css('display','block');
                        jQuery("#submit").attr('disabled', true);
                    } else {
                        jQuery("#emailErr").html('');
                        jQuery("#submit").attr('disabled', false);
                        jQuery("#emailErr").css('display','none');
                    }
                }
            })
        }
</script>
<?php endif; 
include 'frontendjs.php';
if(isset($submit_button_bgcolor) && $submit_button_bgcolor!="" && $crf_theme=='default')
{
	?>
    <style>
	.crf_contact_submit{ background-color:<?php echo $submit_button_bgcolor;?> !important;}
	</style>
    <?php	
}

if(isset($submit_button_color) && $submit_button_color!="" && $crf_theme=='default')
{
	?>
    <style>
	.crf_contact_submit{ color:<?php echo $submit_button_color;?> !important;}
	</style>
    <?php	
}

?>
