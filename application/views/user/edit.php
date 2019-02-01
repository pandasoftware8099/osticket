<div id="content">

         <div class="col-lg-12">
<h1>Manage Your Profile Information</h1>
<p>Use the forms below to update the information we have on file for your account</p>
</div>
<form action="<?php echo site_url('user_controller/editconfirm')?>" method="post" class="form-horizontal">
  <input type="hidden" name="__CSRFToken__" value="346f2392a015eb1212681d62c9a8565ffcacc5b8">    <div class="col-lg-12" style="overflow:auto;">
    <hr>
    <div class="form-header" style="margin-bottom:0.5em;">
    <h3>Contact Information</h3>
    <div></div>
    </div>
            
            
            <div class="form-group">
                            <label for="c455f173549a7fe7" class="col-sm-3 control-label"><span class="required">
                Email Address                            <span class="error">*</span>
            </span>                </label>
                <div class="col-sm-9">
                    <input type="email" class="form-control" id="_c455f173549a7fe7" size="40" maxlength="64" placeholder="" name="cemail" value="<?php echo $_SESSION["useremail"] ?>">
        </div>            </div>
            
        
                
            
            <div class="form-group">
                            <label for="e428814096bc396f" class="col-sm-3 control-label"><span class="required">
                Full Name                            <span class="error">*</span>
            </span>                </label>
                <div class="col-sm-9">
                    <input input pattern=".{5,}"   required title="5 characters minimum" type="text" class="form-control" id="_e428814096bc396f" size="40" maxlength="64" placeholder="" name="cname" value="<?php echo $_SESSION["username"] ?>">
        </div>            </div>
            
        
                
            
            <div class="form-group">
                            <label for="973d065d18e88abe" class="col-sm-3 control-label"><span class="">
                Phone Numbers            </span>                </label>
                <div class="col-sm-9">
                    <input id="_973d065d18e88abe" type="tel" name="cphone" value="<?php echo $_SESSION["userphone"] ?>"> Ext:
            <input type="text" name="cphoneext" value="<?php echo $_SESSION["userphoneext"] ?>" size="5">
        </div>            </div>
            
        
        </div>
<!-- <div class="col-lg-12">
    <div><hr><h3>Preferences</h3></div>
    <div class="form-group">
      <label for="inputEmail3" class="col-sm-3 control-label">
        Time Zone      </label>
    </div>
    </div> -->
<div class="col-xs-12">
    <div style="margin-bottom:10px;"><hr><h3>Access Credentials</h3></div>
        <div class="form-group">
          <label for="inputEmail3" class="col-sm-3 control-label">
            Current Password<span class="error">*</span></label>
          <div class="col-sm-9">
            <input type="password" class="form-control" size="18" name="cpasswd" value="" input pattern=".{5,}"   required title="5 characters minimum"> &nbsp;<span class="error">&nbsp;</span>
          </div>
        </div>

        <?php if ($disallow_change_password == '1') { ?>

        <div class="form-group">
          <label for="inputEmail3" class="col-sm-3 control-label">
            New Password          </label>
          <div class="col-sm-9">
            <input type="password" size="18" class="form-control" name="passwd1" value="" input pattern=".{5,}" title="5 characters minimum">
            &nbsp;<span class="error">&nbsp;</span>
          </div>
        </div>
        <div class="form-group">
          <label for="inputEmail3" class="col-sm-3 control-label">
            Confirm New Password          </label>
          <div class="col-sm-9">
            <input type="password" size="18" name="passwd2" value="" class="form-control" input pattern=".{5,}" title="5 characters minimum">
        &nbsp;<span class="error">&nbsp;</span>
          </div>
        </div>

        <?php } ?>


</div>
<hr>
<p style="text-align: center;">
    <input type="submit" value="Update">
    <input type="reset" value="Reset">
</p>
</form>
        </div>
    </div>
