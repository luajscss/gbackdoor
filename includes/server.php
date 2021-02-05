<div id="server" class="tab-pane fade">
    <table id="server_list" cellspacing="0" width="100%" class="table table-striped table-bordered">
        <thead> 
            <tr>
                <th>Server name</th>
                <th>IP</th>
                <th>Port</th>
                <th>User logged in</th>
                <th>Date of the last ping</th>
                <th style="min-width: 140px!important;">Action</th>
            </tr>
        </thead>

        <tbody>
        </tbody>
    </table>
</div>
<div class="modal fade" id="serverpayload-modal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Load a Payload</h4>
      </div>
      <div class="modal-body" id="serverpayload-body">
          <div class="form-group">
            <label>Payload</label>
            <select class="form-control" id="server-payload">
            </select>
          </div>
      </div>
      <div class="modal-footer" id="serverpayload-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
        <button type="button" onclick="callPayload()" class="btn btn-primary">Create the Payload</button>
      </div>
    </div>
  </div>
</div> 