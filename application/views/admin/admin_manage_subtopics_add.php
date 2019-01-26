<div id="content">
        <form class="form-horizontal" action="<?php echo site_url('admin_manage_controller/manage_subtopics_add_process')?>" method="post">
    <h2>Add New Sub topics            </h2>
    <div class="tab">
        <ul class="clean tabs" id="list-tabs">
            <li class="active"><a href="#definition">
                <i class="icon-plus"></i> Definition</a></li>
        </ul>
    </div>
<div id="list-tabs_container">
<div id="definition" class="tab_content ">
    <div class="section-break" style="margin-bottom:10px;">
        <em><i class="help-tip icon-question-sign" href="#custom_lists"></i> Sub topics are child of Help topics.</em>
    </div>
    <div class="form-group" style="overflow:auto;">
        <label class="col-lg-2 control-label">Name <span class="error">*</span> :</label>
        <div class="col-lg-10">
            <input size="50" class="form-control" type="text" name="name" data-translate-tag="" autofocus="" value=""> <span class="error"></span>        </div>
    </div>
    <div class="form-group" style="overflow:auto;">
        <label class="col-lg-3 control-label">Parents help topics <span class="error">*</span> :</label>
        <div class="col-lg-9">
            <select required="true" id="type" name="topicId" class="form-control">
              <option>— Select Help Topic —</option>
              <?php foreach ($topic->result() as $reason) { ?>   
              <option value="<?php echo $reason->topic_guid?>"><?php echo $reason->topic?></option>
              <?php }?>
            </select></div>
    </div>
    
    <div class="section-break" style="margin-bottom:10px;">
        <em><strong>Internal Notes:</strong>
                Be liberal, they're internal</em>
    </div>
    
    <div class="box">
            <div class="box-header">

              <!-- tools box -->
              <div class="pull-right box-tools">

              </div>
              <!-- /. tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body pad">
                
                <textarea name="notes" class="textarea" placeholder="Place some text here"
                          style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
                
              
            </div>
          </div>

</div>


<p class="centered">
    <input type="submit" name="submit" value="Add Subtopic">
    <input type="reset" name="reset" value="Reset">

</p>


</div></form>
</div>
</div>
    