<div id="content">
        
<h2>
    <i class="help-tip icon-question-sign" href="#help_topic_information"></i> 
    Add New Help Topic    </h2>

<div class="tab">
    <ul class="clean tabs" id="topic-tabs">
        <li class="active"><a href="#info"><i class="icon-info-sign"></i> Help Topic Information</a></li>
        
</div>

<form class="form-horizontal" action="<?php echo site_url('admin_manage_controller/manage_helptopics_add_process')?>" method="post">


<div id="topic-tabs_container">
<div class="tab_content" id="info" style="display: block;">
    <div class="form-group" style="margin-bottom:0px;">
        <label class="col-lg-2 control-label"><i class="help-tip icon-question-sign" href="#topic"></i> Topic <span class="error">*</span>:</label>
        <div class="col-lg-10">
            <input type="text" size="30" name="topic" class="form-control" value="" autofocus="" data-translate-tag="">
                &nbsp;<span class="error"></span>
        </div>
    </div>
    <div class="form-group">
        <label class="col-lg-2 control-label"><i class="help-tip icon-question-sign" href="#status"></i> Status <span class="error">*</span> :</label>
        <div class="col-lg-10">
            <input type="radio" name="isactive" value="1" checked="checked"> Active            <input type="radio" name="isactive" value="0"> Disabled        </div>
    </div>
    <div class="form-group">
        <label class="col-lg-2 control-label"><i class="help-tip icon-question-sign" href="#type"></i> Type <span class="error">*</span> :</label>
        <div class="col-lg-10">
            <input type="radio" name="ispublic" value="1" checked="checked"> Public            <input type="radio" name="ispublic" value="0"> Private/Internal        </div>
    </div>
    
    <div class="col-lg-12">
        <div class="section-break" style="margin-bottom:10px;">
            <strong>Internal Notes:</strong>
                Be liberal, they're internal        </div>

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
</div>



</div>

<p style="text-align:center;">
    <input type="submit" name="submit" value="Add Topic">
    <input type="reset" name="reset" value="Reset">
    <input type="button" name="cancel" value="Cancel" onclick="window.location.href=&quot;helptopics.php&quot;">
</p>
</form>
<script type="text/javascript">
$(function() {
    var request = null,
      update_example = function() {
      request && request.abort();
      request = $.get('ajax.php/sequence/'
        + $('[name=sequence_id] :selected').val(),
        {'format': $('[name=number_format]').val()},
        function(data) { $('#format-example').text(data); }
      );
    };
    $('[name=sequence_id]').on('change', update_example);
    $('[name=number_format]').on('keyup', update_example);

    $('form select#newform').change(function() {
        var $this = $(this),
            val = $this.val();
        if (!val) return;
        $.ajax({
            url: 'ajax.php/form/' + val + '/fields/view',
            dataType: 'json',
            success: function(json) {
                if (json.success) {
                    $(json.html).appendTo('#topic-forms').effect('highlight');
                    $this.find(':selected').prop('disabled', true);
                }
            }
        });
    });
    $('table#topic-forms').sortable({
      items: 'tbody',
      handle: 'td.handle',
      tolerance: 'pointer',
      forcePlaceholderSize: true,
      helper: function(e, ui) {
        ui.children().each(function() {
          $(this).children().each(function() {
            $(this).width($(this).width());
          });
        });
        ui=ui.clone().css({'background-color':'white', 'opacity':0.8});
        return ui;
      }
    }).disableSelection();
});
</script>
</div>

</div>
