<div id="content">

         <div class="col-lg-8">

<h1>Frequently Asked Questions</h1>
<div id="breadcrumbs">
    <a href="<?php echo site_url('guide_controller/main');?>">All Categories</a>
    » <a href="<?php echo site_url('guide_controller/category');?>?id=<?php echo $faqcate->category_guid;?>"><?php echo $faqcate->name;?></a>
    <span class="faded"></span>
</div>


<div class="faq-content">
<div class="article-title flush-left">

<?php echo $faqrow->question;?></div>
<div class="faded">Last Updated <?php echo $faqrow->updated;?></div>

<br>
<div class="thread-body bleed">

<?php foreach ($faq->result() as $value1) { ?>

<?php echo $value1->answer;?>

<?php } ?>
</div>
</div>
</div>


<div class="col-lg-4 sidebar faq-meta" 
style=" background-color: rgb(235, 234, 234);    
        border: 1px solid #ccc!important;
        border-radius: 5px;
        padding: 5px;">
<section>
<div>
    <strong>Extra</strong>
</div>

<?php foreach ($faqinfo->result() as $value1) { ?>
    <?php 
        $file = $this->db->query("SELECT * FROM ost_file_test AS b
            INNER JOIN ost_faq_test AS a
            ON a.faq_guid = b.faq_guid
            WHERE b.faq_guid = '".$value1->faq_guid."'");
    ?>

    <?php 
        if ($file->num_rows() > 0)
        { ?>
            <div class="attachments">

            <?php foreach ($file->result() as $val) {
                $name = $val->name;
            ?>    

                <i class="icon-paperclip icon-flip-horizontal"></i>
                <a href="<?php echo base_url('uploads/').$name;?>" download="<?php echo $name;?>" ><?php echo $name;?></a>

            <?php } ?>
            </div>
    <?php } ?>
<?php } ?>



</section>

</div>     
</div>

    </div>
