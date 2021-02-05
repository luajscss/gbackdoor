<?php
class Logs
{
	public function GetLastLogs($nbr = 20)
	{
		return $GLOBALS['DB']->GetContent("logs", [], 'ORDER BY id DESC LIMIT '.$nbr);
	}

	public function AddLogs($content)
	{
		$GLOBALS['DB']->Insert("logs", ["content" => $content], false);
	}
}
?>