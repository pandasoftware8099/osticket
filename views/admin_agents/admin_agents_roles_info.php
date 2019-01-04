<div id="content">
        <form class="form-horizontal" action="<?php echo site_url('admin_agents_controller/agents_roles_info_process')?>?id=<?php echo $_REQUEST['id']?>" method="post">

    <h2>Update Role    <small>
    — <?php echo $role->name ?></small>
            </h2>
    <div class="tab">
        <ul class="clean tabs">
            <li class="active"><a href="#definition"><i class="icon-file"></i> Definition</a></li>
            <li class=""><a href="#permissions"><i class="icon-lock"></i> Permissions</a></li>
        </ul>
    </div>
    <div id="definition" class="tab_content" style="display: block;">
        <div class="section-break" style="margin-bottom:10px;">
              <em><i class="help-tip icon-question-sign" href="#roles"></i> Roles are used to define agents' permissions</em>
        </div>
        <div class="form-group">
            <label class="col-lg-2 control-label">Name <span class="error">*</span> :</label>
            <div class="col-lg-10">
                <input required="true" size="50" class="form-control" type="text" name="name" value="<?php echo $role->name ?>" data-translate-tag="2dffe63368c42a5e" autofocus="">
                <span class="error"></span>
            </div>
        </div>
        <div class="section-break" style="margin-bottom:10px;">
              <em><strong>Internal Notes</strong> </em>
        </div>
        <div class="col-lg-12">
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
                          style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"><?php echo $role->notes ?></textarea>
            
              
            </div>
          </div>
        </div>
    </div>
    <div id="permissions" class="hiddens tab_content" style="overflow: auto; display: none;">
                <div class="tab_1">
            <ul class="alt tabs_1" style="height:auto;">
                                        <li class="active">
                            <a href="#tickets">Tickets</a>
                        </li>
                                        <li>
                            <a href="#tasks">Tasks</a>
                        </li>
                                        <li>
                            <a href="#knowledgebase">Knowledgebase</a>
                        </li>
                            </ul>
        </div>
                <div class="tab_content_1 " id="tickets">
            <table class="table">
                                <tbody><tr>
                    <td>
                        <label>
                            <input type="checkbox" name="perms[]" value="ticket.create" <?php echo ($addticketallow != 0)?"checked":""; ?>>                            &nbsp;
                            Create                            —
                            <em>Ability to open tickets on behalf of users</em>
                        </label>
                    </td>
                </tr>
                                <tr>
                    <td>
                        <label>
                            <input type="checkbox" name="perms[]" value="ticket.edit" <?php echo ($editticketallow != 0)?"checked":""; ?>>                            &nbsp;
                            Edit                            —
                            <em>Ability to edit tickets</em>
                        </label>
                    </td>
                </tr>
                                <tr>
                    <td>
                        <label>
                            <input type="checkbox" name="perms[]" value="ticket.assign" <?php echo ($asgticketallow != 0)?"checked":""; ?>>                            &nbsp;
                            Assign                            —
                            <em>Ability to assign tickets to agents or teams</em>
                        </label>
                    </td>
                </tr>
                                <tr>
                    <td>
                        <label>
                            <input type="checkbox" name="perms[]" value="ticket.transfer" <?php echo ($transticketallow != 0)?"checked":""; ?>>                            &nbsp;
                            Transfer                            —
                            <em>Ability to transfer tickets between departments</em>
                        </label>
                    </td>
                </tr>
                                <tr>
                    <td>
                        <label>
                            <input type="checkbox" name="perms[]" value="ticket.reply" <?php echo ($replyticketallow != 0)?"checked":""; ?>>                            &nbsp;
                            Post Reply                            —
                            <em>Ability to post a ticket reply</em>
                        </label>
                    </td>
                </tr>
                                <tr>
                    <td>
                        <label>
                            <input type="checkbox" name="perms[]" value="ticket.close" <?php echo ($closeticketallow != 0)?"checked":""; ?>>                            &nbsp;
                            Close                            —
                            <em>Ability to close tickets</em>
                        </label>
                    </td>
                </tr>
                                <tr>
                    <td>
                        <label>
                            <input type="checkbox" name="perms[]" value="ticket.delete" <?php echo ($deleteticketallow != 0)?"checked":""; ?>>                            &nbsp;
                            Delete                            —
                            <em>Ability to delete tickets</em>
                        </label>
                    </td>
                </tr>
                                <tr>
                    <td>
                        <label>
                            <input type="checkbox" name="perms[]" value="thread.edit" <?php echo ($editthreadallow != 0)?"checked":""; ?>>                            &nbsp;
                            Edit Thread                            —
                            <em>Ability to edit thread items of other agents</em>
                        </label>
                    </td>
                </tr>
                            </tbody></table>
        </div>
                <div class="tab_content_1 hiddens" id="tasks">
            <table class="table">
                                <tbody><tr>
                    <td>
                        <label>
                            <input type="checkbox" name="perms[]" value="task.create" <?php echo ($addtaskallow != 0)?"checked":""; ?>>                            &nbsp;
                            Create                            —
                            <em>Ability to create tasks</em>
                        </label>
                    </td>
                </tr>
                                <tr>
                    <td>
                        <label>
                            <input type="checkbox" name="perms[]" value="task.edit" <?php echo ($edittaskallow != 0)?"checked":""; ?>>                            &nbsp;
                            Edit                            —
                            <em>Ability to edit tasks</em>
                        </label>
                    </td>
                </tr>
                                <tr>
                    <td>
                        <label>
                            <input type="checkbox" name="perms[]" value="task.assign" <?php echo ($asgtaskallow != 0)?"checked":""; ?>>                            &nbsp;
                            Assign                            —
                            <em>Ability to assign tasks to agents or teams</em>
                        </label>
                    </td>
                </tr>
                                <tr>
                    <td>
                        <label>
                            <input type="checkbox" name="perms[]" value="task.transfer" <?php echo ($transtaskallow != 0)?"checked":""; ?>>                            &nbsp;
                            Transfer                            —
                            <em>Ability to transfer tasks between departments</em>
                        </label>
                    </td>
                </tr>
                                <tr>
                    <td>
                        <label>
                            <input type="checkbox" name="perms[]" value="task.reply" <?php echo ($replytaskallow != 0)?"checked":""; ?>>                            &nbsp;
                            Post Reply                            —
                            <em>Ability to post task update</em>
                        </label>
                    </td>
                </tr>
                                <tr>
                    <td>
                        <label>
                            <input type="checkbox" name="perms[]" value="task.close" <?php echo ($closetaskallow != 0)?"checked":""; ?>>                            &nbsp;
                            Close                            —
                            <em>Ability to close tasks</em>
                        </label>
                    </td>
                </tr>
                                <tr>
                    <td>
                        <label>
                            <input type="checkbox" name="perms[]" value="task.delete" <?php echo ($deletetaskallow != 0)?"checked":""; ?>>                            &nbsp;
                            Delete                            —
                            <em>Ability to delete tasks</em>
                        </label>
                    </td>
                </tr>
                            </tbody></table>
        </div>
                <div class="tab_content_1 hiddens" id="knowledgebase">
            <table class="table">
                                <tbody><tr>
                    <td>
                        <label>
                            <input type="checkbox" name="perms[]" value="canned.manage" <?php echo ($managecannedallow != 0)?"checked":""; ?>>                            &nbsp;
                            Premade                            —
                            <em>Ability to add/update/disable/delete canned responses</em>
                        </label>
                    </td>
                </tr>
                            </tbody></table>
        </div>
            </div>
    <p class="centered">
        <input type="submit" name="submit" value="Save Changes">
        <input type="reset" name="reset" value="Reset">
        <input type="button" name="cancel" value="Cancel" onclick="window.location.href=&quot;?&quot;">
    </p>
</form>
</div>

</div>