<?php
/*Controls custom field creation in the dashboard area*/
global $wpdb;
$textdomain = 'custom-registration-form-builder-with-submission-manager';
$crf_option=$wpdb->prefix."crf_option";
$path =  plugin_dir_url(__FILE__); 
$anti_spam_options = new crf_basic_options;

if(isset($_REQUEST['saveoption']))
{
	$retrieved_nonce = $_REQUEST['_wpnonce'];
	if (!wp_verify_nonce($retrieved_nonce, 'save_crf_antispam_setting' ) ) die( 'Failed security check' );
	if(!isset($_REQUEST['enable_captcha'])) $_REQUEST['enable_captcha']='no';
	$anti_spam_options->crf_add_option( 'enable_captcha', $_REQUEST['enable_captcha']);
	$anti_spam_options->crf_add_option( 'public_key', $_REQUEST['publickey']);
	$anti_spam_options->crf_add_option( 'private_key', $_REQUEST['privatekey']);
	update_option( 'ucf_enable_captcha_login',$_POST['enable_captcha_login']);	
	wp_redirect('admin.php?page=crf_settings');exit;
}
$public_key = $anti_spam_options->crf_get_global_option_value('public_key');
$private_key = $anti_spam_options->crf_get_global_option_value('private_key');
?>
<div class="crf-main-form">
  <div class="crf-form-heading">
    <h1><?php _e( 'Anti Spam', $textdomain ); ?></h1>
  </div>
  <form method="post">
    
    <div class="option-main crf-form-setting">
      <div class="user-group crf-form-left-area">
        <div class="crf-label">
          <?php _e( 'Enable reCAPTCHA:', $textdomain ); ?>
        </div>
      </div>
      <div class="user-group-option crf-form-right-area">
        <input name="enable_captcha" id="enable_captcha" type="checkbox" class="upb_toggle" value="yes" <?php if ($anti_spam_options->checkfieldname("enable_captcha","yes")==true){ echo "checked";}?> style="display:none;"/>
        <label for="enable_captcha"></label>
      </div>
    </div>
    <div class="option-main ">
      <div id="captcha_fun" <?php if ($anti_spam_options->checkfieldname("enable_captcha","yes")==true){ echo 'style="display:block"';}else{echo 'style="display:none"';}?>>
      
      <div class="option-main crf-form-setting">
      <div class="user-group crf-form-left-area">
        <div class="crf-label">
          <?php _e( 'reCAPTCHA under User Login:', $textdomain ); ?>
        </div>
      </div>
      <div class="user-group-option crf-form-right-area">
        <input name="enable_captcha_login" id="enable_captcha_login" type="checkbox" class="upb_toggle" value="yes" <?php if (get_option('ucf_enable_captcha_login','no')=='yes'){ echo "checked";}?> style="display:none;"/>
        <label for="enable_captcha_login"></label>
      </div>
    </div>
      
        <div class="option-main crf-form-setting">
          <div class="user-group crf-form-left-area">
            <div class="crf-label">
              <?php _e( 'Site Key:', $textdomain ); ?>
            </div>
          </div>
          <div class="user-group-option crf-form-right-area">
            <input type="text" name="publickey" id="publickey" value="<?php if(isset($public_key)) echo $public_key; ?>" />
          </div>
        </div>
        <div class="option-main crf-form-setting">
          <div class="user-group crf-form-left-area">
            <div class="crf-label">
              <?php _e( 'Secret Key:', $textdomain ); ?>
            </div>
          </div>
          <div class="user-group-option crf-form-right-area">
            <input type="text" name="privatekey" id="privatekey" value="<?php if(isset($private_key)) echo $private_key; ?>" />
          </div>
        </div>
      </div>
    </div>
 
    
    
    <br>
    <br>
    <div class="crf-form-footer">
      <div class="crf-form-button">
      <?php wp_nonce_field('save_crf_antispam_setting'); ?>
        <input type="submit"  class="button-primary" value="<?php _e('Save',$textdomain);?>" name="saveoption" id="saveoption" />
        <a href="admin.php?page=crf_settings" class="cancel_button"><?php _e('Cancel',$textdomain);?></a>
      </div>
    </div>
  </form>
</div>