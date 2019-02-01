<div id="content">
         <h1>Reset Your Password</h1>
</p><form action="<?php echo site_url('user_controller/user_resetforgotpassword')?>" method="post" id="clientLogin">
    <div style="width:50%;display:inline-block">
    <strong>Enter your old/temporary password to reset your password.</strong>
    <br>
    <div>
        <input type="hidden" name="id" value="<?php if(isset($id))
            {  
                echo $id;
            }
            ?>">
       <input type="password" name="old_pw"  placeholder="Old/Temporary Password" autofocus="" autocorrect="off" autocapitalize="off" required><br>
        <input type="password" name="new_pw" placeholder="New Password" autofocus="" autocorrect="off" autocapitalize="off" required><br>
        <input type="password" name="confirm" placeholder="Confirm New Password" autocorrect="off" autocapitalize="off" required>
    </div>
    <p>
        <input class="button" type="submit" value="Confirm">
    </p>
    </div>
</form>
        </div>
    </div>