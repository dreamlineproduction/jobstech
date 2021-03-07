<div class="form-group row"><!--- form-group row Starts --->
  <label class="col-md-4 control-label"> Enable Video Tutorials For This Category : </label>
  <div class="col-md-6">
    <input type="checkbox" name="video" id="video" value="1"> <label> Yes </label>
  </div>
</div><!--- form-group row Ends --->

<div id="videoSettings" class="d-none">
  <h3>Video Settings</h3>
  <hr>
  <div class="form-group row"><!--- form-group row Starts --->
    <label class="col-md-4 control-label"> Send Reminder Emails : </label>
    <div class="col-md-6">
      <input type="number" list="reminder_emails" min="1" name="reminder_emails" class="form-control" placeholder="Select Minutes">
      <datalist id="reminder_emails">
        <option value="10">10 minutes</option>
        <option value="20">20 minutes</option>
        <option value="30">30 minutes</option>
      </datalist>
    </div>
  </div>
  <div class="form-group row"><!--- form-group row Starts --->
    <label class="col-md-4 control-label"> Send Missed Video Session Emails : </label>
    <div class="col-md-6">
      <input type="number" list="missed_session_emails" min="1" name="missed_session_emails" class="form-control" placeholder="Select Minutes">
      <datalist id="missed_session_emails">
        <option value="15">15 minutes</option>
        <option value="30">30 minutes</option>
        <option value="60">60 minutes</option>
      </datalist>
    </div>
  </div>
  <div class="form-group row"><!--- form-group row Starts --->
    <label class="col-md-4 control-label"> Send Warning Message When Video Session is Coming to an End : </label>
    <div class="col-md-6">
      <input type="number" list="warning_message" min="1" name="warning_message" class="form-control" placeholder="Select Minutes">
      <datalist id="warning_message">
        <option value="1">1 minute</option>
        <option value="2">2 minutes</option>
        <option value="3">3 minutes</option>
      </datalist>
    </div>
  </div>
</div>
<script type="text/javascript" src="../plugins/videoPlugin/admin/js/categories.js"></script>