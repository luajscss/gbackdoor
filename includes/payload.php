<div id="payload" class="tab-pane fade">
    <div class="row">
        <div class="col-md-12" style="margin-bottom: 10px;">
            <button data-toggle="modal" data-target="#createpayload-modal" type="button" class="btn btn-success"><i class="fa fa-plus"></i>&nbsp;Add a payload</button>
        </div>
        <div class="col-md-12">
            <table id="payload_list" cellspacing="0" width="100%" class="table table-striped table-bordered">
                <thead> 
                    <tr>
                        <th>Payload Name</th>
                        <th>Comment</th>
                        <th style="min-width: 140px!important">Action</th>
                    </tr>
                </thead>

                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="modal fade" id="createpayload-modal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Create a Payload</h4>
      </div>
      <div class="modal-body">
          <div class="form-group">
            <label>Payload name</label>
            <input type="text" class="form-control" id="payload-name" placeholder="Payload Name">
          </div>
          <div class="form-group">
            <label>Comment</label>
            <input type="text" class="form-control" id="payload-comment" placeholder="Comment">
          </div>
          <div class="form-group">
            <label>Payload</label>
            <textarea class="form-control" rows="5" id="payload-text" placeholder="Your code should only contain quotation marks like this', others will cause an error"></textarea>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
        <button type="button" onclick="createPayload()" class="btn btn-primary">Create the Payload</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="viewpayload-modal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Edit the payload</h4>
      </div>
      <div class="modal-body">
          <div class="form-group">
            <label>Name the payload</label>
            <input type="text" class="form-control" id="edit-payload-name" placeholder="Name the payload">
          </div>
          <div class="form-group">
            <label>Comment</label>
            <input type="text" class="form-control" id="edit-payload-comment" placeholder="Comment">
          </div>
          <div class="form-group">
            <label>Payload</label>
            <textarea class="form-control" rows="5" id="edit-payload-text" placeholder="Your code should only contain quotation marks like this', others will cause an error"></textarea>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" onclick="editPayload()" class="btn btn-warning" data-dismiss="modal">Edit</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div> 