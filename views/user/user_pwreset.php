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
    <div id="footer">
        <p>Copyright © 2019 Panda Ticketing System - All rights reserved.</p>
    </div>
<div id="overlay" style="opacity: 0.3; top: 0px; left: 0px;"></div>
<div id="loading" style="top: 251.333px; left: 599.5px;">
    <h4>Please Wait!</h4>
    <p>Please wait... it will take a second!</p>
</div>
</body>