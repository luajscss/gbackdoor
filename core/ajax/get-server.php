<?php
header('Content-Type: application/json');
include('../class/include.php');
if (!Account::isAuthentified() || !CSRF::isAjaxRequest())
{
    die("Bad request");
}

$all_server_predata = Server::GetAllServer();
$list = [];

foreach ($all_server_predata as $data)
{    
	if ($data['last_update'] + 60 > time())
	{
	    $button_delete = '<button onclick="deleteServer('.$data['id'].')" type="button" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i>&nbsp;Deleted</button>';

	    $button_payload = '<button onclick="showcallPayload('.$data['id'].')" type="button" class="btn btn-primary btn-sm"><i class="fa fa-file-code-o"></i>&nbsp;Load</button>';

	    $ip_data = explode(':', $data['server_ip']);
	        
	    array_push($list, ["DT_RowId" => "server-".$data['id'], $data['server_name'], $ip_data[0], $ip_data[1], $data['server_users'], date('d/m/Y at H:i:s', $data['last_update']), $button_delete."&nbsp;".$button_payload]);
	}
}

echo json_encode(['data' => $list]);
?>