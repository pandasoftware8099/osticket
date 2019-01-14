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
       <input type="password" name="old_pw"  placeholder="Old/Temporary Password" autofocus="" autocorrect="off" autocapitalize="off" required>
        <input type="password" name="new_pw" placeholder="New Password" autofocus="" autocorrect="off" autocapitalize="off" required>
        <input type="password" name="confirm" placeholder="Confirm New Password" autocorrect="off" autocapitalize="off" required>
    </div>
    <p>
        <input class="button" type="submit" value="Confirm">
    </p>
    </div>
</form>
        </div>
    </div>
    <div id="footer">
        <p>Copyright © 2019 Panda Ticketing System - All rights reserved.</p>
    </div>
<div id="overlay" style="opacity: 0.3; top: 0px; left: 0px;"></div>
<div id="loading" style="top: 251.333px; left: 599.5px;">
    <h4>Please Wait!</h4>
    <p>Please wait... it will take a second!</p>
</div>
</body>