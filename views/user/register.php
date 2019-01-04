<div id="content">

         <div class="col-lg-12">
    <h1>Account Registration</h1>
    <p>Use the forms below to create or update the information we have on file for your account    </p>
</div>
<form action="<?php echo site_url('user_controller/create');?>" method="post" class="form-horizontal">
  <input type="hidden" name="__CSRFToken__" value="714b5a27a9f6648ae37c3e3805458924f8c51d20">  <input type="hidden" name="do" value="create">
    <div class="col-lg-12" style="overflow:auto;">
    <hr>
    <div class="form-header" style="margin-bottom:0.5em;">
    <h3>Contact Information</h3>
    <div></div>
    </div>
            
            
            <div class="form-group">
                <label for="56690b6e57d97f25" class="col-sm-3 control-label">
                    <span class="required">Email Address<span class="error">*</span></span>     
                </label>
                <div class="col-sm-9">
                    <input type="email" class="form-control" id="_56690b6e57d97f25" size="40" maxlength="64" placeholder="" name="email" value="" required>
                </div>            
            </div>
            
        
                
            
            <div class="form-group">
                <label for="450fc361286915b9" class="col-sm-3 control-label">
                    <span class="required">Full Name<span class="error">*</span></span>        
                </label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="_450fc361286915b9" size="40" maxlength="64" placeholder="" name="fullname" value="" required input pattern=".{5,}"   required title="5 characters minimum">
                </div>           
            </div>
            
        
                
            
            <div class="form-group">
                <label for="304374eaeea4c808" class="col-sm-3 control-label">
                    <span class="">Phone Numbers</span></label>
                <div class="col-sm-9">
                    <input id="_304374eaeea4c808" type="tel" name="phone" value=""> 
                    Ext:<input type="text" name="phoneext" value="" size="5">
                </div>            
            </div>
            
        
        </div>
<div class="col-lg-12">
    <div class="form-header" style="padding-bottom:10px;"><hr><h3>Access Credentials</h3></div>
        <div class="form-group" style="margin-bottom:0px;">
        <label for="inputEmail3" class="col-sm-3 control-label">
            Create a Password<span class="error">*</span></label>
        <div class="col-sm-9">
            <input id="password" type="password" size="18" class="form-control" name="passwd1" value="" required input pattern=".{5,}"   required title="5 characters minimum">
        &nbsp;<span class="error">&nbsp;</span>
        </div>
    </div>
    <div class="form-group" style="margin-bottom:0px;">
        <label for="inputEmail3" class="col-sm-3 control-label">
            Confirm New Password<span class="error">*</span></label>
        <div class="col-sm-9">
            <input id="confirm_password" type="password" size="18" name="passwd2" class="form-control" value="" required input pattern=".{5,}"   required title="5 characters minimum">
            &nbsp;<span class="error">&nbsp;</span>
        </div>
    </div>
    </div>
    <p style="text-align: center;padding-bottom:10px;">
    <input type="submit" value="Register">
</p>
<h3></h3></form></div>
<hr>


<!-- Auto detect client's timezone where possible -->
<script type="text/javascript" src="/helpdesk/js/jstz.min.js?9ae093d"></script>
<script type="text/javascript">
$(function() {
    var zone = jstz.determine();
    $('#timezone-dropdown').val(zone.name()).trigger('change');
});
</script>
        </div>
    
    <div id="footer">
        <p>Copyright © 2018 Panda Ticketing System - All rights reserved.</p>
        <a id="poweredBy" href="http://osticket.com" target="_blank">Helpdesk software - powered by osTicket</a>
    </div>
<div id="overlay" style="opacity: 0.3; top: 0px; left: 0px;"></div>
<div id="loading" style="top: 219px; left: 514.5px;">
    <h4>Please Wait!</h4>
    <p>Please wait... it will take a second!</p>
</div>
<script type="text/javascript">
    getConfig().resolve({"html_thread":true,"lang":"en_US","short_lang":"en","has_rtl":false,"primary_language":"en-US","secondary_languages":[]});
</script>

<script type="text/javascript">
  
var password = document.getElementById("password")
  , confirm_password = document.getElementById("confirm_password");

function validatePassword(){
  if(password.value != confirm_password.value) {
    confirm_password.setCustomValidity("Passwords Don't Match");
  } else {
    confirm_password.setCustomValidity('');
  }
}

password.onchange = validatePassword;
confirm_password.onkeyup = validatePassword;
  
</script>
</body></html>