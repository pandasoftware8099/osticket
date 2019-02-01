<div id="content">
         <h1>Forgot My Password</h1>
<p>Enter your username or email address in the form below and press the <strong>Send Email</strong> button to have a password reset link sent to your email account on file.
</p><form action="<?php echo site_url('user_controller/user_forgot_pw')?>" method="post" id="clientLogin">
    <div style="width:50%;display:inline-block">
    <strong>Enter your username or email address below</strong>
    <br>
    <div>
        <label for="username">Username/Email:</label>
        <input id="username" type="text" name="useremail" size="30" required>
    </div>
    <p>
        <input class="button" type="submit" value="Send Email">
    </p>
    </div>
</form>
        </div>
    </div>
