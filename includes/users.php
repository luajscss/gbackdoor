<div id="users" class="tab-pane fade">
    <div class="row">
        <div class="col-md-12" style="margin-bottom: 10px;">
            <button data-toggle="modal" data-target="#createusers-modal" type="button" class="btn btn-success"><i class="fa fa-plus"></i>&nbsp;Add a user</button>
        </div>
        <div class="col-md-12">
            <table id="users_list" cellspacing="0" width="100%" class="table table-striped table-bordered">
                <thead> 
                    <tr>
                        <th>Name the user</th>
                        <th style="min-width: 70px!important">Action</th>
                    </tr>
                </thead>

                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="modal fade" id="createusers-modal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Create a user</h4>
      </div>
      <div class="modal-body" id="createusers-body">
          <div class="form-group">
            <label>Username</label>
            <input type="text" class="form-control" id="users-username" placeholder="Username">
          </div>
          <div class="form-group">
            <label>Password</label>
            <input type="password" class="form-control" id="users-password" placeholder="Password">
          </div>
          <div class="form-group">
            <label>Confirm password</label>
            <input type="password" class="form-control" id="users-cpassword" placeholder="Confirm Password">
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
        <button type="button" onclick="createUser()" class="btn btn-primary">Create user</button>
      </div>
    </div>
  </div>
</div> 