<?php
global $wpdb;
$textdomain = 'custom-registration-form-builder-with-submission-manager';
$crf_submissions =$wpdb->prefix."crf_submissions";
$crf_fields =$wpdb->prefix."crf_fields";
$crf_forms =$wpdb->prefix."crf_forms";
$crf_stats =$wpdb->prefix."crf_stats";
$path =  plugin_dir_url(__FILE__); 
?>
<style>
.media-container{ min-height:400px; border:none !important;}
</style>
<div class="wrap about-wrap">
		<h1>What's New</h1>

		<div class="about-text">In our quest to make Custom User Registration Form Builder the most full featured registration plugin for WordPress, we are bringing a long list of features to you. While we have taken care that most of this things you are used to and already love remain untouched, improvements required few changes here and there. Here’s a quick low down on new stuff (there are other additions as well, but we will leave that to you to discover!). 
</div>
		<div class="wp-badge" style="background: none !important;padding-top: 0px;box-shadow: none;"><img src="<?php echo $path; ?>images/whatsnew-icon.png"> </div>




		<hr>

		<div class="feature-section two-col">
						<div class="col">
				<div class="media-container">
										<img src="<?php echo $path; ?>images/whatsnew1.png">
									</div>
				<h3>Changed left menu main link title to "Registrations".</h3>
				<p></p>
			</div>
						<div class="col">
                        <div class="media-container">
										<img src="<?php echo $path; ?>images/whatsnew2.png">
									</div>
				
				<h3>Added add form button in WP Editor to make it easier to insert short-codes into posts and pages.</h3>
				<p>You can now just click on the “Add Form” button to insert forms into your content. Of course, you can use the good old method of copying and pasting short codes too. 
Global Settings is now divided into sections. This will make easier to access important options quickly and and will avoid the chaos when we add more options in future updates.  
</p>
			</div>
						<div class="col">
				<div class="media-container">
										<img src="<?php echo $path; ?>images/whatsnew3.png">
									</div>
				<h3>Added add form button in WP Editor to make it easier to insert shortcodes into posts and pages.</h3>
				<p>You can now just click on the “Add Form” button to insert forms into your content. Of course, you can use the good old method of copying and pasting short codes too. 
Global Settings is now divided into sections. This will make easier to access important options quickly and and will avoid the chaos when we add more options in future updates.</p>
			</div>
						<div class="col">
				<div class="media-container">
										<img src="<?php echo $path; ?>images/whatsnew4.png">
									</div>
				<h3>WYSIWYG/ HTML Editors</h3>
				<p>Added WYSIWYG/ HTML Editors for Form header content, Success Message and Auto-Responder. Mail Merge is also supported now in Autoresponder if you want to insert field values in mail. You can also compose HTML.</p>
			</div>
            
            <div class="col">
				<div class="media-container">
										<img src="<?php echo $path; ?>images/whatsnew5.png">
									</div>
				<h3>Added ability to chose submit button background and text color.</h3>
				<p></p>
			</div>
            
            <div class="col">
				<div class="media-container">
										<img src="<?php echo $path; ?>images/whatsnew6.png">
									</div>
				<h3>Added form analytics to show important statistical data about your form and submissions.</h3>
				<p></p>
			</div>
            
					</div>

		

		<div class="changelog">
			<h3>Other features include:</h3>

			<div class="feature-section under-the-hood three-col">
            			<div class="col"><h4>General structural improvements and bug fixes.</h4></div>			<div class="col">
					<h4>
Added an option to add multiple emails for admin notifications.</h4></div>			<div class="col">
					<h4>
Added MailChimp integration and default field mapping.</h4></div>			<div class="col">
					<h4>
Improved search and filtering for submissions.</h4></div><div class="col"><h4>
Replaced datepicker with one that allows easier changing of years.</h4></div><div class="col"><h4>
Made it easier to turn on WP registrations to forms.</h4></div><div class="col"><h4>
Removed reset button in classic theme.</h4></div><div class="col"><h4>
Added shortcode for adding login box.</h4></div><div class="col"><h4>
Added option to define default WordPress registration page.</h4></div><div class="col"><h4>
GUI Improvements..</h4></div><div class="col"><h4>
Added ability to define redirection page after successful login.</h4></div>


							
							</div>

			<div class="return-to-dashboard">
								<a href="admin.php?page=crf_manage_forms">Go to Plugin</a>
			</div>

		</div>
	</div>