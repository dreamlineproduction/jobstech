<?php 

  function escape($value){
    return htmlentities($value, ENT_QUOTES, 'UTF-8');
  }

  $c_video = escape($row_edit->video);
  $reminder_emails = escape($row_edit->reminder_emails);
  $missed_session_emails = escape($row_edit->missed_session_emails);
  $warning_message = escape($row_edit->warning_message);

?>
<div class="form-group row"><!--- form-group row Starts --->
  <label class="col-md-4 control-label"> Enable Video Tutorials For This Category: </label>
  <div class="col-md-6">
    <input type="checkbox" name="video" id="video" value="1" <?php if($c_video==1){echo "checked";} ?>> <label> Yes </label>
  </div>
</div><!--- form-group row Ends --->
<div id="videoSettings" class="<?= ($c_video==0)?"d-none":""; ?>">
  <h3>Video Settings</h3>
  <hr>
  <div class="form-group row"><!--- form-group row Starts --->
    <label class="col-md-4 control-label"> Send Reminder Emails: </label>
    <div class="col-md-6">
      <input type="number" list="reminder_emails" name="reminder_emails" class="form-control" value="<?= $reminder_emails; ?>" placeholder="Select Minutes" <?= ($c_video==1)?"min='1' required":""; ?>>
      <datalist id="reminder_emails">
        <option value="10">10 minutes</option>
        <option value="20">20 minutes</option>
        <option value="30">30 minutes</option>
      </datalist>
      <small class="text-muted">Send Reminder Email Before * Minutes of Its Actual Time.</small>
    </div>
  </div>
  <div class="form-group row"><!--- form-group row Starts --->
    <label class="col-md-4 control-label"> Send Missed Video Session Emails: </label>
    <div class="col-md-6">
      <input type="number" list="missed_session_emails" name="missed_session_emails" class="form-control" value="<?= $missed_session_emails; ?>" placeholder="Select Minutes" <?= ($c_video==1)?"min='1' required":""; ?>>
      <datalist id="missed_session_emails">
        <option value="15">15 minutes</option>
        <option value="30">30 minutes</option>
        <option value="60">60 minutes</option>
      </datalist>
      <small class="text-muted">Send Missed Video Session Email After * Minutes of Its Actual Time.</small>
    </div>
  </div>
  <div class="form-group row"><!--- form-group row Starts --->
    <label class="col-md-4 control-label"> Send Warning Message When Video Session is Coming to an End: </label>
    <div class="col-md-6">
      <input type="number" list="warning_message" name="warning_message" class="form-control" value="<?= $warning_message; ?>" placeholder="Select Minutes" <?= ($c_video==1)?"min='1' required":""; ?>>
      <datalist id="warning_message">
        <option value="1">1 minute</option>
        <option value="2">2 minutes</option>
        <option value="3">3 minutes</option>
      </datalist>
      <small class="text-muted">Send Warning Message When Video Session is Coming to an End. Mean * Minutes Before End.</small>
    </div>
  </div>
</div>
<script type="text/javascript" src="../plugins/videoPlugin/admin/js/categories.js"></script>