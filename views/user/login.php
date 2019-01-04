<div id="content">

         <h1>Sign in to Panda Ticketing System</h1>
<p>To better serve you, we encourage our Clients to register for an account.</p>
<form action="<?php echo site_url('user_controller/login_form')?>" method="post"  id="clientlogin"  role="form">
    <div class="login-box col-lg-6">
    <strong><?php if (isset($_SESSION['blocked2']))
        { ?>
            <h5>Access Denied for <?php echo $block_period?> minutes after several wrong login attempts.</h5>
    <?php }; ?></strong>
    <div>
        <input id="username" placeholder="Email or Username" type="text" name="luser" size="30" value="" class="nowarn form-control">
    </div>
    <div>
        <input id="passwd" placeholder="Password" type="password" name="lpasswd" size="30" value="" class="nowarn form-control" input pattern=".{5,}"   required title="5 characters minimum">
    </div>
    <p>
        <input class="btn" type="submit" value="Sign In">
    </p>
    </div>
    <div class="col-lg-6" style="padding: 15px;vertical-align:top">
    <div style="margin-bottom: 5px">
    <?php $client_registration=$this->db->query("SELECT value FROM osticket.ost_config_test WHERE id='76'");
        if($client_registration->row('value') == '1'){?>
    <h5>Not yet registered?<a href="<?php echo site_url('user_controller/register')?>">Create an account</a> </h5>
    <?php } else { ?>
        <h5>Not yet registered? Please Contact An Agent To Create An Account.</h5>
    <?php };?>
    </div>
    <div>
    <b>I'm an agent</b> —
    <a href="<?php echo site_url('user_controller/superlogin')?>">sign in here</a>
    </div>
    </div>
</div>
</form>
<br>
<p>
If this is your first time contacting us or you've lost the ticket number, please <a href="open.php"> open a new ticket </a></p>
        </div>
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


</body></html>