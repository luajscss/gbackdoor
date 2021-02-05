<?php
class Params
{
	public function GetValue($name)
	{
		return $GLOBALS['DB']->GetContent("params", ["name" => $name])[0]["value"];
	}

	public function SetValue($name, $value)
	{
		$GLOBALS['DB']->Update("params", ["name" => $name], ["value" => $value]);
	}

	public function GetAllParams()
	{
		return $GLOBALS['DB']->GetContent("params");
	}
}
?>