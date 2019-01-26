<div id="content">
        <h2>About this osTicket Installation</h2>
<div style="overflow:auto;">
<table class="list" width="100%" ;="">
<thead>
    <tr><th colspan="2">Server Information</th></tr>
</thead>
<tbody>

    <tr><td>Web Server Software</td>
        <td><span class="ltr"><?php echo $_SESSION['webserver']?></span></td></tr>
    <tr><td>MySQL Version</td>
        <td><span class="ltr"><?php echo $_SESSION['mysql']?></span></td></tr>
    <tr><td>PHP Version</td>
        <td><span class="ltr"><?php echo $_SESSION['phpversion']?></span></td></tr>
</tbody>
<thead>
    <tr><th colspan="2">PHP Extensions</th></tr>
</thead>
<tbody>
  
        <tr><td>gdlib</td>
        <td>
        <?php if(in_array("gd",$extension)){ ?>
            
        	<i class="icon icon-check"></i>
             <?php } else { ?>

                <i class="icon icon-warning-sign"></i>
            <?php } ?>Used for image manipulation and PDF printing        </td>
    </tr>
        <tr><td>imap</td>
        <td><?php if(in_array("imap",$extension)){ ?>
            
            <i class="icon icon-check"></i>
             <?php } else { ?>

                <i class="icon icon-warning-sign"></i>
            <?php } ?> Used for email fetching        </td>
    </tr>
        <tr><td>xml</td>
        <td><?php if(in_array("xml",$extension)){ ?>
            
            <i class="icon icon-check"></i>
             <?php } else { ?>

                <i class="icon icon-warning-sign"></i>
            <?php } ?> XML API        </td>
    </tr>
        <tr><td>xml-dom</td>
        <td><?php if(in_array("dom",$extension)){ ?>
            
            <i class="icon icon-check"></i>
             <?php } else { ?>

                <i class="icon icon-warning-sign"></i>
            <?php } ?> Used for HTML email processing        </td>
    </tr>
        <tr><td>json</td>
        <td><?php if(in_array("json",$extension)){ ?>
            
            <i class="icon icon-check"></i>
             <?php } else { ?>

                <i class="icon icon-warning-sign"></i>
            <?php } ?> Improves performance creating and processing JSON        </td>
    </tr>
        <tr><td>mbstring</td>
        <td><?php if(in_array("mbstring",$extension)){ ?>
            
            <i class="icon icon-check"></i>
             <?php } else { ?>

                <i class="icon icon-warning-sign"></i>
            <?php } ?> Highly recommended for non western european language content        </td>
    </tr>
        <tr><td>Phar</td>
        <td><?php if(in_array("Phar",$extension)){ ?>
            
            <i class="icon icon-check"></i>
             <?php } else { ?>

                <i class="icon icon-warning-sign"></i>
            <?php } ?> Highly recommended for plugins and language packs        </td>
    </tr>
        <tr><td>intl</td>
        <td><?php if(in_array("intl",$extension)){ ?>
            
            <i class="icon icon-check"></i>
             <?php } else { ?>

                <i class="icon icon-warning-sign"></i>
            <?php } ?> Highly recommended for non western european language content        </td>
    </tr>
        <tr><td>fileinfo</td>
        <td><?php if(in_array("fileinfo",$extension)){ ?>
            
            <i class="icon icon-check"></i>
             <?php } else { ?>

                <i class="icon icon-warning-sign"></i>
            <?php } ?> Used to detect file types for uploads        </td>
    </tr>
        <tr><td>APCu</td>
        <td><?php if(in_array("APCu",$extension)){ ?>
            
            <i class="icon icon-check"></i>
             <?php } else { ?>

                <i class="icon icon-warning-sign"></i>
            <?php } ?> Improves overall performance        </td>
    </tr>
        <tr><td>Zend Opcache</td>
        <td><?php if(in_array("Zend Opcache",$extension)){ ?>
            
            <i class="icon icon-check"></i>
             <?php } else { ?>

                <i class="icon icon-warning-sign"></i>
            <?php } ?> Improves overall performance        </td>
    </tr>
    </tbody>
<thead>
    <tr><th colspan="2">Database Information and Usage</th></tr>
</thead>
<tbody>
    <tr><td>Schema</td>
        <td><span class="ltr"><?php echo $_SESSION['schema'] ?></span> </td></tr>
    
    <tr><td>Schema Signature</td>
        <td>98ad7d550c26ac44340350912296e673 </td>
    </tr>
    <tr><td>Space Used</td>
        <td><?php echo $spaceused ?> MiB</td>
    </tr><tr><td>Space for Attachments</td>
        <td>9.88 MiB</td></tr>
    <tr><td>Timezone</td>
        <td><?php echo $_SESSION['timezone']?>
                  </td></tr>
</tbody>
</table>
</div>
<br>
<h2>Installed Language Packs</h2>
<div style="margin: 0 20px">
    <h3><strong>English - US (English)</strong>
        —         </h3>
        <div><code>en_US</code> — include/i18n/en_US        </div>
</div>
</div>

</div>