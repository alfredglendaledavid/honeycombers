<?php

if( !defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/*
	Template Name: Subscription
*/

$blog_id = get_current_blog_id();

if ($blog_id == 2) {
	add_action( 'genesis_loop', 'signup_sg' );
} else if ($blog_id == 3) {
	add_action( 'genesis_loop', 'signup_jakarta' );
} else if ($blog_id == 4) {
	add_action( 'genesis_loop', 'signup_bali' );
} else if ($blog_id == 6) {
	add_action( 'genesis_loop', 'signup_hk' );
} 

function signup_sg() { ?>

<!-- Begin MailChimp Signup Form -->
<link href="//cdn-images.mailchimp.com/embedcode/classic-10_7.css" rel="stylesheet" type="text/css">

<style type="text/css">
	#mc_embed_signup{background:#fff; clear:left; font:14px Helvetica,Arial,sans-serif; }
	#mc_embed_signup form {padding: 0;}
	#mc_embed_signup .button { background-color: #f68b1f; opacity: 0.9; }
	#mc_embed_signup .button:hover { background-color: #f68b1f; opacity: 1; }
	/* Add your own MailChimp form style overrides in your site stylesheet or in this style block.
	   We recommend moving this block and the preceding CSS link to the HEAD of your HTML file. */
</style>

<div id="mc_embed_signup">
    <form action="//thehoneycombers.us11.list-manage.com/subscribe/post?u=ae5fe5a4c4e3449cba31ebd2f&amp;id=b362270636&SOURCE=HC-SG-Website" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
        
        <div id="mc_embed_signup_scroll">
        
        <h2>Subscribe to our mailing list</h2>
        
        <div class="indicates-required"><span class="asterisk">*</span> indicates required</div>
        <div class="mc-field-group">
            <label for="mce-FNAME">First Name </label>
            <input type="text" value="" name="FNAME" class="" id="mce-FNAME">
        
        </div>
        
        <div class="mc-field-group">
            <label for="mce-LNAME">Last Name </label>
            <input type="text" value="" name="LNAME" class="" id="mce-LNAME">
        </div>
        
        <div class="mc-field-group">
            <label for="mce-EMAIL">Email Address  <span class="asterisk">*</span></label>
            <input type="email" value="" name="EMAIL" class="required email" id="mce-EMAIL">
        </div>
    
        <div class="mc-field-group input-group">
            <strong>Newsletter </strong>
            <ul>
                <li><label for="mce-group[5169]-5169-0" class="checkbox"><input type="checkbox" value="1" name="group[5169][1]" id="mce-group[5169]-5169-0">All Newsletters</label></li>
                <li><label for="mce-group[5169]-5169-1" class="checkbox"><input type="checkbox" value="2147483648" name="group[5169][2147483648]" id="mce-group[5169]-5169-1">Your week starts here (Monday)</label></li>
                <li><label for="mce-group[5169]-5169-2" class="checkbox"><input type="checkbox" value="4294967296" name="group[5169][4294967296]" id="mce-group[5169]-5169-2">Spend it like this (Wednesday)</label></li>
                <li><label for="mce-group[5169]-5169-3" class="checkbox"><input type="checkbox" value="8589934592" name="group[5169][8589934592]" id="mce-group[5169]-5169-3">In the Loop</label></li>
                <li><label for="mce-group[5169]-5169-4" class="checkbox"><input type="checkbox" value="17179869184" name="group[5169][17179869184]" id="mce-group[5169]-5169-4">Weekend Inspo (Fri)</label></li>
            </ul>
        </div>
    
        <div id="mce-responses" class="clear">
            <div class="response" id="mce-error-response" style="display:none"></div>
            <div class="response" id="mce-success-response" style="display:none"></div>
        </div>    <!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
        
        <div style="position: absolute; left: -5000px;" aria-hidden="true"><input type="text" name="b_ae5fe5a4c4e3449cba31ebd2f_b362270636" tabindex="-1" value=""></div>
            <div class="clear"><input type="submit" value="Subscribe" name="subscribe" id="mc-embedded-subscribe" class="button"></div>
        </div>
        
    </form>

</div>

<script type='text/javascript' src='//s3.amazonaws.com/downloads.mailchimp.com/js/mc-validate.js'></script><script type='text/javascript'>(function($) {window.fnames = new Array(); window.ftypes = new Array();fnames[1]='FNAME';ftypes[1]='text';fnames[2]='LNAME';ftypes[2]='text';fnames[0]='EMAIL';ftypes[0]='email';fnames[11]='SOURCE';ftypes[11]='text';fnames[3]='MMERGE3';ftypes[3]='birthday';fnames[4]='MMERGE4';ftypes[4]='text';fnames[5]='MMERGE5';ftypes[5]='text';fnames[6]='MMERGE6';ftypes[6]='text';fnames[7]='MMERGE7';ftypes[7]='text';fnames[8]='MMERGE8';ftypes[8]='text';fnames[9]='MMERGE9';ftypes[9]='text';}(jQuery));var $mcj = jQuery.noConflict(true);</script>

<!--End mc_embed_signup-->

<?php }



function signup_jakarta() { ?>

<!-- Begin MailChimp Signup Form -->
<link href="//cdn-images.mailchimp.com/embedcode/classic-10_7.css" rel="stylesheet" type="text/css">

<style type="text/css">
	#mc_embed_signup{background:#fff; clear:left; font:14px Helvetica,Arial,sans-serif; }
	#mc_embed_signup form {padding: 0;}
	#mc_embed_signup .button { background-color: #f68b1f; opacity: 0.9; }
	#mc_embed_signup .button:hover { background-color: #f68b1f; opacity: 1; }
	/* Add your own MailChimp form style overrides in your site stylesheet or in this style block.
	   We recommend moving this block and the preceding CSS link to the HEAD of your HTML file. */
</style>

<div id="mc_embed_signup">
    <form action="//thehoneycombers.us11.list-manage.com/subscribe/post?u=ae5fe5a4c4e3449cba31ebd2f&amp;id=d228c3b862&SOURCE=HC-Jakarta-Website" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
        
        <div id="mc_embed_signup_scroll">
        
        <h2>Subscribe to our mailing list</h2>
        
        <div class="indicates-required"><span class="asterisk">*</span> indicates required</div>
        
        <div class="mc-field-group">
            <label for="mce-EMAIL">Email Address  <span class="asterisk">*</span></label>
            <input type="email" value="" name="EMAIL" class="required email" id="mce-EMAIL">
        </div>
        
        <div class="mc-field-group">
            <label for="mce-FNAME">First Name </label>
            <input type="text" value="" name="FNAME" class="" id="mce-FNAME">
        </div>
        
        <div class="mc-field-group">
            <label for="mce-LNAME">Last Name </label>
            <input type="text" value="" name="LNAME" class="" id="mce-LNAME">
        </div>
        
        <div class="mc-field-group input-group">
            <strong>Newsletter </strong>
            <ul>
            	<li><label for="mce-group[5425]-5425-0" class="checkbox"><input type="checkbox" value="1" name="group[5425][1]" id="mce-group[5425]-5425-0">Bali</label></li>
                <li><label for="mce-group[5425]-5425-1" class="checkbox"><input type="checkbox" value="2" name="group[5425][2]" id="mce-group[5425]-5425-1">Jakarta</label></li>
            </ul>
        </div>
        
        <div id="mce-responses" class="clear">
                <div class="response" id="mce-error-response" style="display:none"></div>
                <div class="response" id="mce-success-response" style="display:none"></div>
        </div>    <!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
        
        <div style="position: absolute; left: -5000px;" aria-hidden="true"><input type="text" name="b_ae5fe5a4c4e3449cba31ebd2f_d228c3b862" tabindex="-1" value=""></div>
            <div class="clear"><input type="submit" value="Subscribe" name="subscribe" id="mc-embedded-subscribe" class="button"></div>
        </div>
        
    </form>

</div>

<script type='text/javascript' src='//s3.amazonaws.com/downloads.mailchimp.com/js/mc-validate.js'></script><script type='text/javascript'>(function($) {window.fnames = new Array(); window.ftypes = new Array();fnames[0]='EMAIL';ftypes[0]='email';fnames[1]='FNAME';ftypes[1]='text';fnames[2]='LNAME';ftypes[2]='text';fnames[3]='SOURCE';ftypes[3]='text';}(jQuery));var $mcj = jQuery.noConflict(true);</script>
<!--End mc_embed_signup-->

<?php }


function signup_bali() { ?>

<!-- Begin MailChimp Signup Form -->
<link href="//cdn-images.mailchimp.com/embedcode/classic-10_7.css" rel="stylesheet" type="text/css">

<style type="text/css">
	#mc_embed_signup{background:#fff; clear:left; font:14px Helvetica,Arial,sans-serif; }
	#mc_embed_signup form {padding: 0;}
	#mc_embed_signup .button { background-color: #f68b1f; opacity: 0.9; }
	#mc_embed_signup .button:hover { background-color: #f68b1f; opacity: 1; }
	/* Add your own MailChimp form style overrides in your site stylesheet or in this style block.
	   We recommend moving this block and the preceding CSS link to the HEAD of your HTML file. */
</style>

<div id="mc_embed_signup">
    <form action="//thehoneycombers.us11.list-manage.com/subscribe/post?u=ae5fe5a4c4e3449cba31ebd2f&amp;id=d228c3b862&SOURCE=HC-Bali-Website" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
        
        <div id="mc_embed_signup_scroll">
        
        <h2>Subscribe to our mailing list</h2>
        
        <div class="indicates-required"><span class="asterisk">*</span> indicates required</div>
        
        <div class="mc-field-group">
            <label for="mce-EMAIL">Email Address  <span class="asterisk">*</span></label>
            <input type="email" value="" name="EMAIL" class="required email" id="mce-EMAIL">
        </div>
        
        <div class="mc-field-group">
            <label for="mce-FNAME">First Name </label>
            <input type="text" value="" name="FNAME" class="" id="mce-FNAME">
        </div>
        
        <div class="mc-field-group">
            <label for="mce-LNAME">Last Name </label>
            <input type="text" value="" name="LNAME" class="" id="mce-LNAME">
        </div>
        
        <div class="mc-field-group input-group">
            <strong>Newsletter </strong>
            <ul>
                <li><label for="mce-group[5425]-5425-0" class="checkbox"><input type="checkbox" value="1" name="group[5425][1]" id="mce-group[5425]-5425-0">Bali</label></li>
                <li><label for="mce-group[5425]-5425-1" class="checkbox"><input type="checkbox" value="2" name="group[5425][2]" id="mce-group[5425]-5425-1">Jakarta</label></li>
            </ul>
        </div>
        
        <div id="mce-responses" class="clear">
                <div class="response" id="mce-error-response" style="display:none"></div>
                <div class="response" id="mce-success-response" style="display:none"></div>
        </div>    <!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
        
        <div style="position: absolute; left: -5000px;" aria-hidden="true"><input type="text" name="b_ae5fe5a4c4e3449cba31ebd2f_d228c3b862" tabindex="-1" value=""></div>
            <div class="clear"><input type="submit" value="Subscribe" name="subscribe" id="mc-embedded-subscribe" class="button"></div>
        </div>
        
    </form>

</div>

<script type='text/javascript' src='//s3.amazonaws.com/downloads.mailchimp.com/js/mc-validate.js'></script><script type='text/javascript'>(function($) {window.fnames = new Array(); window.ftypes = new Array();fnames[0]='EMAIL';ftypes[0]='email';fnames[1]='FNAME';ftypes[1]='text';fnames[2]='LNAME';ftypes[2]='text';fnames[3]='SOURCE';ftypes[3]='text';}(jQuery));var $mcj = jQuery.noConflict(true);</script>
<!--End mc_embed_signup-->

<?php }


function signup_hk() { ?>

<!-- Begin MailChimp Signup Form -->
<link href="//cdn-images.mailchimp.com/embedcode/classic-10_7.css" rel="stylesheet" type="text/css">

<style type="text/css">
	#mc_embed_signup{background:#fff; clear:left; font:14px Helvetica,Arial,sans-serif; }
	#mc_embed_signup form {padding: 0;}
	#mc_embed_signup .button { background-color: #f68b1f; opacity: 0.9; }
	#mc_embed_signup .button:hover { background-color: #f68b1f; opacity: 1; }
	/* Add your own MailChimp form style overrides in your site stylesheet or in this style block.
	   We recommend moving this block and the preceding CSS link to the HEAD of your HTML file. */
</style>

<div id="mc_embed_signup">

    <form action="//thehoneycombers.us11.list-manage.com/subscribe/post?u=ae5fe5a4c4e3449cba31ebd2f&amp;id=204e287b22&SOURCE=HC-HongKong-Website" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
        
        <div id="mc_embed_signup_scroll">
        
        <h2>Subscribe to our mailing list</h2>
    	
        <div class="indicates-required"><span class="asterisk">*</span> indicates required</div>
    	
        <div class="mc-field-group">
            <label for="mce-EMAIL">Email Address  <span class="asterisk">*</span></label>
            <input type="email" value="" name="EMAIL" class="required email" id="mce-EMAIL">
        </div>
    
        <div class="mc-field-group">
            <label for="mce-FNAME">First Name </label>
            <input type="text" value="" name="FNAME" class="" id="mce-FNAME">
        </div>
    
        <div class="mc-field-group">
            <label for="mce-LNAME">Last Name </label>
            <input type="text" value="" name="LNAME" class="" id="mce-LNAME">
        </div>
   
        <div id="mce-responses" class="clear">
            <div class="response" id="mce-error-response" style="display:none"></div>
            <div class="response" id="mce-success-response" style="display:none"></div>
        </div>    <!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
        
        <div style="position: absolute; left: -5000px;" aria-hidden="true"><input type="text" name="b_ae5fe5a4c4e3449cba31ebd2f_204e287b22" tabindex="-1" value=""></div>
        	<div class="clear"><input type="submit" value="Subscribe" name="subscribe" id="mc-embedded-subscribe" class="button"></div>
        </div>
        
    </form>

</div>

<script type='text/javascript' src='//s3.amazonaws.com/downloads.mailchimp.com/js/mc-validate.js'></script><script type='text/javascript'>(function($) {window.fnames = new Array(); window.ftypes = new Array();fnames[0]='EMAIL';ftypes[0]='email';fnames[1]='FNAME';ftypes[1]='text';fnames[2]='LNAME';ftypes[2]='text';}(jQuery));var $mcj = jQuery.noConflict(true);</script>
<!--End mc_embed_signup-->

<?php }


genesis();
