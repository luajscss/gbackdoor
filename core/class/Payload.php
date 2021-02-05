<?php
class Payload
{
	// Get all payloads
	public function GetAllPayload()
	{
		return $GLOBALS['DB']->GetContent("payload");
	}

	// Delete a payload
	public function DeletePayload($id)
	{
		$name = Payload::GetPayload($id)['payload_name'];
		return $GLOBALS['DB']->Delete("payload", ["id" => $id]);
        Logs::AddLogs("<p class='text-danger'>[".date('d/m/Y at H:i:s', time())."]&nbsp;<i class='fa fa-close'></i>&nbsp;The payload ".$name." has been deleted</p>");
	}

	// Create a payload
	public function CreatePayload($name, $comment, $content)
	{
		$GLOBALS['DB']->Insert("payload", ["payload_name" => $name, "payload_comment" => $comment, "payload_content" => $content]);
        Logs::AddLogs("<p class='text-primary'>[".date('d/m/Y at H:i:s', time())."]&nbsp;<i class='fa fa-plus'></i>&nbsp;A new payload has been created : ".$name."</p>");
	}

	// Edit a payload
	public function EditPayload($id, $name, $comment, $content)
	{
		$GLOBALS['DB']->Update("payload", ["id" => $id], ["payload_name" => $name, "payload_comment" => $comment, "payload_content" => $content]);
	}

	// Recover a payload
	public function GetPayload($id)
	{
		return $GLOBALS['DB']->GetContent("payload", ["id" => $id])[0];
	}
}
?>