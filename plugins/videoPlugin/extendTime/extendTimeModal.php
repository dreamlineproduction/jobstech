<div id="extendTime" class="modal fade" style="z-index:2051;"><!--- extendTime Starts --->
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"> Extend Time </h5>
        <button class="close" data-dismiss="modal"><span> &times; </span></button>
      </div>
      <div class="modal-body">
        <form action="" method="post" id="extendTimeForm">
          <div class="form-group">
            <label for="">How many more minutes do you wish to extend?</label>
            <input type="number" name="extended_minutes" class="form-control mb-3" placeholder="5 Minutes" required="">
          </div>
          <div class="form-group" id="customAmount"><!--- form-group row Starts --->
            <label class="">Custom Amount:</label>
            <input type="text" name="customAmount" class="form-control" placeholder="5" required="">
          </div>
          <button type="submit" name="extendTime" class="btn btn-success">Extend Time</button>
        </form>
      </div>
    </div>
  </div>
</div><!--- extendTime Ends --->