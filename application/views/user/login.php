<div id="content">
<?php $company_name = $this->db->query("SELECT * FROM ost_company_test")->row('name_template');
$user_banner = $this->db->query("SELECT REPLACE(name, '%company_name%', '$company_name') AS subject, body FROM ost_content_test WHERE type = 'banner-client'");?>
<h1><?php echo $user_banner->row('subject');?></h1>
<p><?php echo $user_banner->row('body');?></p>
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
    <?php if(isset($_SESSION['loginsecond2'])){?>
            <a id="forgotpw" href="<?php echo site_url('user_controller/user_forgot_pw') ?>" >Forgot Your Password?</a>
            <?php } ?>
    </div>
    <div class="col-lg-6" style="padding: 15px;vertical-align:top">
    <div style="margin-bottom: 5px">
    <?php $client_registration=$this->db->query("SELECT value FROM osticket.ost_config_test WHERE id='76'");
        if($client_registration->row('value') == '1'){?>
            <h5>Not yet registered? <a href="<?php echo site_url('user_controller/register')?>">Create an account</a> </h5>
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
        </div>
    </div>
