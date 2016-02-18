// JavaScript Document
function redirectform(id,page) 
{
        window.location = 'admin.php?page='+page+'&form_id=' + id;
}

function add_field_autoresponder(a)
{
	var text = '{{'+a+'}}';
	tinyMCE.activeEditor.execCommand( 'mceInsertContent', false, text);
}

function insert_form_shortcode(a)
{
	tinyMCE.activeEditor.execCommand( 'mceInsertContent', false, a);
	tb_remove(); return false;	
}

function validationform()
{
	a = jQuery('.crf_number_message').html();
	b = jQuery('.crf_date_message').html();
	c = jQuery('#user-result').html();
	if(a=="" && b=="" && c=="")
	{
		return true;	
	}
	else
	{
		return false;	
	}
}

function check_number() {
	var number = jQuery('.crf_number').val();
	var isnumber = jQuery.isNumeric(number);
	if (isnumber == false && number != "") {
		jQuery('.crf_number_message').html('Please enter a valid number.');
		jQuery('.crf_number_message').show();
	}
	else
	{
		jQuery('.crf_number_message').html('');
		jQuery('.crf_number_message').hide();
	}
}

function check_date() {
	var date = jQuery('.crf_date').val();
	var datepattern = /^\d{4}-\d{2}-\d{2}$/;
	 is_date = date.match(datepattern);
	if (is_date == null && date !="") {
		jQuery('.crf_date_message').html('Please enter a valid date(yyyy-mm-dd).');
		jQuery('.crf_date_message').show();
	}
	else
	{
		jQuery('.crf_date_message').html('');
		jQuery('.crf_date_message').hide();
	}

}


function popup() 
{
	a = confirm("Are you sure you want to remove?");
	if (a == true) {
		return true;
	} else {
		return false;
	}
}

function showhideredirect(a) 
{
	if (a == 'page') {
		jQuery('#page_html').show(500);
		jQuery('#url_html').hide(500);
	} else if (a == 'url') {
		jQuery('#page_html').hide(500);
		jQuery('#url_html').show(500);
	} else {
		jQuery('#page_html').hide(500);
		jQuery('#url_html').hide(500);
	}
}

function showhideuserrole(a)
{
	if (a == 'reg_form') {
		jQuery('#userrolegroup').show(500);
		jQuery('#letuserdecidehtml').show(500);
	} else {
		jQuery('#userrolegroup').hide(500);
		jQuery('#letuserdecidehtml').hide(500);
	}
}

function showhideletuserdecide(a)
{
	jQuery('#userrolelabelhtml').toggle(500);
	jQuery('#userroleoptionhtml').toggle(500);
	if(jQuery(a).is(':checked')==true)
	{
		jQuery('#userrolehtml').hide(500);
	}
	else
	{
		jQuery('#userrolehtml').show(500);
	}
}

function showhidelimitation(a) 
{
	if (a == 'submission') {
		jQuery('#limitation_submission_html').show(500);
		jQuery('#limitation_date_html').hide(500);
	} else if (a == 'date') {
		jQuery('#limitation_submission_html').hide(500);
		jQuery('#limitation_date_html').show(500);
	} else {
		jQuery('#limitation_submission_html').show(500);
		jQuery('#limitation_date_html').show(500);
	}
}

function addoption() {
var b = '<li class="optioninputfield" id="newfield"><span class="handle"></span><input type="text" name="optionvalue[]" id="optionvalue[]" value=""><span class="removefield" onClick="removefield(this)">Delete</span></li>';
jQuery('.optionsfieldwrapper').append(b);
jQuery('#newfield input').focus();
}

function addother()
{
var a = '<div class="optioninputfield" style=" margin-top:12px;"><input type="text" name="optionvalue[]" id="optionvalue[]" value="Their answer" disabled><span class="removefield" onClick="removeother(this)">Delete</span><input type="hidden" name="optionvalue[]" id="optionvalue[]" value="chl_other" /></div>';
jQuery('.optionsfieldwrapper').parent('div').append(a);
jQuery('.addother').hide();	
}

function removefield(a)
{
	jQuery(a).parent('.optioninputfield').remove();
}

function removeother(a)
{
	jQuery(a).parent('.optioninputfield').remove();
	jQuery('.addother').show();	
}

jQuery(function () 
{
	jQuery('#sortablefield').sortable();
});

jQuery(function () 
{
	jQuery('.crf-color-field').wpColorPicker();
});

jQuery("#auto_expires").click(function () {
	a = jQuery(this).is(':checked');
	if (a == true) {
		jQuery(".auto_expires_html").show(500);
	} else {
		jQuery(".auto_expires_html").hide(500);
	}
});

jQuery("#form_type").click(function () {
	a = jQuery(this).is(':checked');
	if (a == true) {
		jQuery('#userrolegroup').show(500);
		jQuery('#letuserdecidehtml').show(500);
	} else {
		jQuery('#userrolegroup').hide(500);
		jQuery('#letuserdecidehtml').hide(500);
	}
});


jQuery("#optin_box").click(function () {
	a = jQuery(this).is(':checked');
	if (a == true) {
		jQuery(".optin_box_html").show(500);
	} else {
		jQuery(".optin_box_html").hide(500);
	}
});
	
jQuery("#send_email").click(function () {
	a = jQuery(this).is(':checked');
	if (a == true) {
		jQuery(".autoresponder").show(500);
	} else {
		jQuery(".autoresponder").hide(500);
	}
});


jQuery('input[name="selected[]"]').click(function () {
        var atLeastOneIsChecked = jQuery('input[name="selected[]"]:checked').length > 0;
        if (atLeastOneIsChecked == true) {
			jQuery('.crf-remove-field').removeClass('grayout_buttons');
            jQuery('.crf-remove-field input').removeAttr('disabled');
			
			jQuery('.crf-new-buttons').removeClass('grayout_buttons');
            jQuery('.crf-duplicate-button input').removeAttr('disabled');
            jQuery('.crf-remove-button input').removeAttr('disabled');
			
        } else {
			jQuery('.crf-remove-field').addClass('grayout_buttons');
            jQuery('.crf-remove-field input').attr('disabled','disabled');
			
			jQuery('.crf-new-buttons').addClass('grayout_buttons');
            jQuery('.crf-duplicate-button input').attr('disabled','disabled');
            jQuery('.crf-remove-button input').attr('disabled','disabled');
        }
    });	

jQuery( "#enable_captcha" ).click(function() {
 a = jQuery(this).is(':checked'); 
 if(a==true)
 {
	jQuery("#captcha_fun").show(500); 
 }
 else
 {
	jQuery("#captcha_fun").hide(500); 
 }
});

jQuery( "#admin_notification" ).click(function() {
 a = jQuery(this).is(':checked'); 
 if(a==true)
 {
	jQuery("#notification_fun").show(500); 
 }
 else
 {
	jQuery("#notification_fun").hide(500); 
 }
});

jQuery('#add_field_form').submit(function () {
	jQuery('.upb_number').each(function (index, element) { //Validation for number type custom field
		var number = jQuery(this).children('input').val();
		var isnumber = jQuery.isNumeric(number);
		if (isnumber == false && number != "") {
			jQuery(this).children('.custom_error').html('Please enter a valid number');
			jQuery(this).children('.custom_error').show();
		} else {
			jQuery(this).children('.custom_error').html('');
			jQuery(this).children('.custom_error').hide();
		}
	});
	var b = '';
	b = jQuery('.custom_error').each(function () {
		var a = jQuery(this).html();
		b = a + b;
		jQuery('.customupberror').html(b);
	});
	var error = jQuery('.customupberror').html();
	if (error == '') {
		return true;
	} else {
		return false;
	}
});

function getfields(a) 
{
  jQuery('#user_groupsfield').show();
  if (a == '') {
	  jQuery('#namefield').hide();
	  jQuery('#classfield').hide();
	  jQuery('#desfield').hide();
	  jQuery('#maxlenghtfield').hide();
	  jQuery('#requirefield').hide();
	  jQuery('#visibilityfield').hide();
	  jQuery('#rulesfield').hide();
	  jQuery('#readonlyfield').hide();
	  jQuery('#registrationformfield').hide();
	  jQuery('#colsfield').hide();
	  jQuery('#rowsfield').hide();
	  jQuery('#optionsfield').hide();
	  jQuery('#valuefield').hide();
	  jQuery('#submit_field').hide();
	  jQuery('#orderingfield').hide();
	  jQuery('#user_groupsfield').hide();
  }
  if (a == 'text' || a == 'password') {
	  jQuery('#namefield').show();
	  jQuery('#classfield').show();
	  jQuery('#desfield').hide();
	  jQuery('#maxlenghtfield').show();
	  jQuery('#requirefield').show();
	  jQuery('#visibilityfield').hide();
	  jQuery('#rulesfield').show();
	  jQuery('#readonlyfield').hide();
	  jQuery('#registrationformfield').show();
	  jQuery('#colsfield').hide();
	  jQuery('#rowsfield').hide();
	  jQuery('#optionsfield').hide();
	  jQuery('#valuefield').hide();
	  jQuery('#submit_field').show();
	  jQuery('#orderingfield').show();
  }
  if (a == 'submit' || a == 'reset' || a == 'hidden') {
	  jQuery('#namefield').show();
	  jQuery('#classfield').show();
	  jQuery('#valuefield').show();
	  jQuery('#submit_field').show();
	  jQuery('#orderingfield').show();
	  jQuery('#desfield').hide();
	  jQuery('#maxlenghtfield').hide();
	  jQuery('#requirefield').hide();
	  jQuery('#visibilityfield').hide();
	  jQuery('#rulesfield').hide();
	  jQuery('#readonlyfield').hide();
	  jQuery('#colsfield').hide();
	  jQuery('#rowsfield').hide();
	  jQuery('#optionsfield').hide();
	  jQuery('#registrationformfield').hide();
  }
  if (a == 'select' || a == 'radio' || a == 'checkbox') {
	  jQuery('#namefield').show();
	  jQuery('#classfield').show();
	  jQuery('#optionsfield').show();
	  jQuery('#desfield').hide();
	  jQuery('#valuefield').show();
	  jQuery('#requirefield').show();
	  jQuery('#visibilityfield').hide();
	  jQuery('#rulesfield').show();
	  jQuery('#readonlyfield').hide();
	  jQuery('#registrationformfield').show();
	  jQuery('#submit_field').show();
	  jQuery('#orderingfield').show();
	  jQuery('#maxlenghtfield').hide();
	  jQuery('#colsfield').hide();
	  jQuery('#rowsfield').hide();
  }
  if (a == 'select') {
	  jQuery('#requirefield').show();
  }
  if (a == 'textarea') {
	  jQuery('#namefield').show();
	  jQuery('#classfield').show();
	  jQuery('#desfield').hide();
	  jQuery('#requirefield').show();
	  jQuery('#visibilityfield').hide();
	  jQuery('#rulesfield').show();
	  jQuery('#readonlyfield').show();
	  jQuery('#registrationformfield').show();
	  jQuery('#colsfield').show();
	  jQuery('#rowsfield').show();
	  jQuery('#submit_field').show();
	  jQuery('#orderingfield').show();
	  jQuery('#maxlenghtfield').show();
	  jQuery('#optionsfield').hide();
	  jQuery('#valuefield').hide();
  }
  if (a == 'file') {
	  jQuery('#namefield').show();
	  jQuery('#classfield').show();
	  jQuery('#desfield').hide();
	  jQuery('#requirefield').hide();
	  jQuery('#visibilityfield').hide();
	  jQuery('#rulesfield').hide();
	  jQuery('#readonlyfield').hide();
	  jQuery('#registrationformfield').show();
	  jQuery('#submit_field').show();
	  jQuery('#orderingfield').show();
	  jQuery('#maxlenghtfield').hide();
	  jQuery('#colsfield').hide();
	  jQuery('#rowsfield').hide();
	  jQuery('#optionsfield').hide();
	  jQuery('#valuefield').hide();
  }
  if (a == 'heading' || a == 'paragraph') {
	  jQuery('#namefield').show();
	  jQuery('#classfield').show();
	  jQuery('#desfield').hide();
	  jQuery('#requirefield').hide();
	  jQuery('#visibilityfield').hide();
	  jQuery('#rulesfield').hide();
	  jQuery('#readonlyfield').hide();
	  jQuery('#registrationformfield').show();
	  jQuery('#submit_field').show();
	  jQuery('#orderingfield').show();
	  jQuery('#maxlenghtfield').hide();
	  jQuery('#colsfield').hide();
	  jQuery('#rowsfield').hide();
	  jQuery('#optionsfield').hide();
	  jQuery('#valuefield').show();
  }
  if (a == 'DatePicker' || a == 'term_checkbox') {
	  jQuery('#namefield').show();
	  jQuery('#classfield').hide();
	  jQuery('#desfield').hide();
	  jQuery('#requirefield').show();
	  jQuery('#visibilityfield').hide();
	  jQuery('#rulesfield').show();
	  jQuery('#readonlyfield').hide();
	  jQuery('#registrationformfield').show();
	  jQuery('#submit_field').show();
	  jQuery('#orderingfield').show();
	  jQuery('#maxlenghtfield').hide();
	  jQuery('#colsfield').hide();
	  jQuery('#rowsfield').hide();
	  jQuery('#optionsfield').hide();
	  jQuery('#valuefield').hide();
  }
  /*file addon start */
  if(a=='file')
  {
	  jQuery('#optionsfield .crf-label').html('Define allowed file types (file extensions). <small style="float:left;">(Separate multiple values by “|”. For example PDF|JPEG|XLS)</small>');
	  jQuery('#optionsfield').show();
	  
  }
  
  if(a != 'file')
  {
	  jQuery('#optionsfield .crf-label').html('Options: <small style="float:left;">(value seprated by comma ",")</small>');	
  }
  /*file addon end */
  if (a != 'term_checkbox') {
	  jQuery('#desfield label').html('Description');
	  jQuery('#namefield label').html('Label');
	  jQuery('.info').hide();
  }
  
  if (a == 'term_checkbox') {
	  jQuery('#desfield .crf-label').html('Terms & Conditions');
	  jQuery('#namefield .crf-label').html('Name');
	  jQuery('#visibilityfield').hide();
	  jQuery('#rulesfield').hide();
	  jQuery('#readonlyfield').hide();
	  jQuery('#registrationformfield').hide();
	  jQuery('.info').html('Use this checkbox field for adding Terms & Conditions to the registration form.');
	  jQuery('.info').show();
	  jQuery('#desfield').show();
  }
  if (a == 'heading') {
	  jQuery('.info').html('This Heading field is working only for "Registration" and "Edit Profile" page.');
	  jQuery('.info').show();
  }
  if (a == 'paragraph') {
	  jQuery('.info').html('This Paragraph field is working only for "Registration" and "Edit Profile" page.');
	  jQuery('#optionsfield .crf-label').html('Paragraph Text');
	  jQuery('#valuefield').hide();
	  jQuery('#optionsfield').show();
	  jQuery('.info').show();
  }
  if (a == 'email' || a == 'number') {
	  jQuery('#namefield').show();
	  jQuery('#classfield').show();
	  jQuery('#desfield').hide();
	  jQuery('#requirefield').show();
	  jQuery('#visibilityfield').hide();
	  jQuery('#rulesfield').show();
	  jQuery('#readonlyfield').hide();
	  jQuery('#registrationformfield').show();
	  jQuery('#submit_field').show();
	  jQuery('#orderingfield').show();
	  jQuery('#maxlenghtfield').hide();
	  jQuery('#colsfield').hide();
	  jQuery('#rowsfield').hide();
	  jQuery('#optionsfield').hide();
	  jQuery('#valuefield').hide();
  }
  if (a == 'country' || a=='timezone') {
	  jQuery('#namefield').show();
	  jQuery('#classfield').show();
	  jQuery('#desfield').hide();
	  jQuery('#requirefield').show();
	  jQuery('#visibilityfield').hide();
	  jQuery('#rulesfield').show();
	  jQuery('#readonlyfield').hide();
	  jQuery('#registrationformfield').show();
	  jQuery('#submit_field').show();
	  jQuery('#orderingfield').show();
	  jQuery('#maxlenghtfield').hide();
	  jQuery('#colsfield').hide();
	  jQuery('#rowsfield').hide();
	  jQuery('#optionsfield').hide();
	  jQuery('#valuefield').hide();
  }
  
  if (a == 'text' || a=='textarea') {
	  jQuery('#valuefield .crf-label').html('Placeholder text');
	  jQuery('#valuefield').show();
  }
  
  if (a != 'text' && a !='textarea') {
	  jQuery('#valuefield .crf-label').html('Default Value');
  }
  
  if ( a != 'radio' || a != 'checkbox') {
	  jQuery('#optionsfield2').hide();
  }
  
  if ( a == 'radio' || a == 'checkbox') {
	  jQuery('#optionsfield').hide();
	  jQuery('#optionsfield2').show();
  }
  
  if ( a == 'radio') {
	  jQuery('.addother').hide();
  }
  
  if ( a == 'checkbox') {
	  jQuery('.addother').show();
  }
}
		
		
jQuery(document).ready(function () {
        jQuery(".slidingDiv").hide();
        jQuery(".show_hide").show();
        jQuery('.show_hide').toggle(function () {
            jQuery("#plus").animate( {backgroundPositionY: "+=20px"}, 500);
            jQuery(".slidingDiv").slideDown();
        }, function () {
            jQuery("#plus").animate( {backgroundPositionY: "-=20px"}, 500);
            jQuery(".slidingDiv").slideUp();
        });
    });
	
jQuery( "#enable_mailchimp" ).click(function() {
 a = jQuery(this).is(':checked'); 
 if(a==true)
 {
	jQuery("#mailchimp_fun").show(500); 
 }
 else
 {
	jQuery("#mailchimp_fun").hide(500); 
 }
});

jQuery( "#enable_facebook" ).click(function() {
 a = jQuery(this).is(':checked'); 
 if(a==true)
 {
	jQuery("#facebook_fun").show(500); 
 }
 else
 {
	jQuery("#facebook_fun").hide(500); 
 }
});

jQuery( "#enable_twitter" ).click(function() {
 a = jQuery(this).is(':checked'); 
 if(a==true)
 {
	jQuery("#twitter_fun").show(500); 
 }
 else
 {
	jQuery("#twitter_fun").hide(500); 
 }
});	