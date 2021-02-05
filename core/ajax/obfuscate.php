<?php
$random_string_len = 30;
$line_break = false;

include('../class/include.php');
if (!Account::isAuthentified() || !CSRF::isAjaxRequest())
{
    die("Bad request");
}

$code = str_replace("<NEWLINE>", "\n", $_POST['code']);

function DeleteComment($lua)
{
	$lua_line = explode("\n", $lua);
	foreach ($lua_line as $line) {
		$lua = str_replace(substr($line, strpos($line, '--') - 2, strlen($line)), '', $lua);
	}
	return $lua;
}

function search_block_structure($search, $content)
{
	$positions = [];
	$lastPos = 0;
	while (($lastPos = strpos($content, $search, $lastPos)) !== false) {
		if (!ctype_alnum(substr($content, $lastPos-1, 1)) && !ctype_alnum(substr($content, $lastPos+ strlen($search), 1)))
		{
			array_push($positions, ['pos' => $lastPos, 'name' => $search]);
		}
    	$lastPos = $lastPos + strlen($search);
	}
	return $positions;
}

function tri_array($name_column, $array)
{
	$tri = [];
	foreach ($array as $key => $row) {
	    $tri[$key]  = $row[$name_column];
	}

	array_multisort($tri, SORT_ASC, $array);
	return $array;
}

function tri_inverse_array($name_column, $array)
{
	$tri = [];
	foreach ($array as $key => $row) {
	    $tri[$key]  = $row[$name_column];
	}

	array_multisort($tri, SORT_DESC, $array);
	return $array;
}

function getBockStructure($lua)
{
	$structure_list = ['function', 'if', 'while', 'for', 'end'];

	$block_structure = [];
	foreach ($structure_list as $structure_find) {
		$all_find = search_block_structure($structure_find, $lua);
		$block_structure = array_merge($block_structure, $all_find);
	}

	$block_structure = tri_array('pos', $block_structure);

	return $block_structure;
}

function getBlockPairing($block_structure)
{
	$check_block_continuity = array_count_values(array_column($block_structure, 'name'));
	$block_pair = count($block_structure) / 2;
	if ($check_block_continuity['end'] != $block_pair)
	{
		return false;
	}

	$block_pairing = [];
	for ($i=0;$i<$block_pair;$i++)
	{
		$end_key = array_search('end', array_column($block_structure, 'name'));
		$start_key = $end_key - 1;
		array_push($block_pairing, ['name' => $block_structure[$start_key]['name'], 'start' => $block_structure[$start_key]['pos'], 'end' => $block_structure[$end_key]['pos'] + 3]);
		unset($block_structure[$end_key]);
		unset($block_structure[$start_key]);
		$block_structure = tri_array('pos', $block_structure);
	}

	return $block_pairing;
}

function cutCode($lua, $start, $end)
{
	return substr($lua, $start, $end - $start);
}

function GetFunctionArg($function_code)
{
	$pos_start = strpos($function_code, "(");
	$pos_end = strpos($function_code, ")");
	$args_brute = substr($function_code, $pos_start + 1, $pos_end - $pos_start - 1);
	$no_space = str_replace(" ", "", $args_brute);
	return explode(",", $no_space);
}

function GetFunctionContent($function_code)
{
	$start = strpos($function_code, "(");
	$content = substr($function_code, $start);
	return $content;
}

function GetCustomFunctionName($function_code)
{
	$pos = strpos($function_code, "(");
	$step1 = substr($function_code, 0, $pos);
	$step2 = str_replace("function", "", $step1);
	$step3 = str_replace(" ", "", $step2);
	return $step3;
}

function GetCustomFunction($lua)
{
	$block_function = [];
	$block_structure = getBockStructure($lua);
	if (count($block_structure) != 0)
	{
		$block_pairing = getBlockPairing($block_structure);
		foreach ($block_pairing as $block) {
			if ($block['name'] == 'function')
			{
				$code = cutCode($lua, $block['start'], $block['end']);
				array_push($block_function, ["class" => "", "name" => GetCustomFunctionName($code), "args" => GetFunctionArg($code), "source" => $code]);
			}
		}
	}
	return $block_function;
}

function GetClass($function_array)
{
	$class = [];
	foreach ($function_array as $function) {
		if (!in_array($function['class'], $class) && $function['class'] != "")
		{
			array_push($class, $function['class']);
		}
	}
	return $class;
}

function GetAllString($lua)
{
	$final = [];
	preg_match_all('/".*?"/', $lua, $result);
	foreach ($result as $data) {
		array_push($final, $data);
	}
	preg_match_all('/\'.*?\'/', $lua, $result);
	foreach ($result as $data) {
		array_push($final, $data);
	}
	return $final;
}

function GetVariable($lua)
{
	$variable_table = [];
	preg_match_all('/local(.*)=(.*)/', $lua, $result);
	foreach ($result[0] as $variable) {
		$step1 = explode("=", $variable);
		$restruct_value = "";
		for ($i=1; $i < count($step1); $i++) { 
			$restruct_value .= $step1[$i];
		}
		$name =  str_replace(" ", "", str_replace("local", "", $step1[0]));
		$value =  str_replace(" ", "", $restruct_value);

		if (strpos(',', $name) === false)
		{
			array_push($variable_table, ["name" => $name, "size" => strlen($name), "value" => $value, "source" => $variable]);
		}
	}
	return tri_inverse_array("size", $variable_table);
}

function generateRandomString($length = 10) {
    $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function AsciiDec($str)
{
	$dec_array = [];
	for ($i = 0, $j = strlen($str); $i < $j; $i++) {
	$dec_array[] = ord($str{$i});
	}
	$dec_str = "";
	foreach ($dec_array as $val) {
		$dec_str .= "\\".$val;
	}
	return $dec_str;
}

function GetCall($lua)
{
	$final = [];
	preg_match_all("/(.*)\((.*)/", $lua, $result);
	foreach ($result[0] as $call) {
		$call = substr($call, 0, strpos($call, "("));
		if (strpos($call, "=") !== false)
		{
			$call = substr($call, strpos($call, "=") + 1, strlen($call));
		}

		if (strpos($call, 'function') == false && strpos($call, 'pairs') == false && strpos($call, ':') == false)
		{
			$call = str_replace(" ", "", $call);
			$call = str_replace("\x09", "", $call);
			if (substr($call, 0, 2) == 'if')
			{
				$call = substr($call, 2, strlen($call));
			}
			else if (substr($call, 0, 6) == 'elseif')
			{
				$call = substr($call, 6, strlen($call));
			}

			if (substr($call, 0, 4) != 'Net.' && substr($call, 0, 7) != 'DarkRP.' && strpos($call, ":") === false && strpos($call, '-') === false && strpos($call, '+') === false && !in_array($call, $final) && $call != "")
			{
				array_push($final, ["name" => $call, "size" => strlen($call)]);
			}
		}
	}
	return tri_inverse_array("size", $final);
}

function FindInArray($text, $array)
{
	foreach ($array as $val) {
		if ($val != "")
		{
			if (strpos($text, $val) !== false)
			{
				return true;
			}
		}
	}
	return false;
}

$obfuscated = $code;

// Ont encrypte tous les texte (fonctionnel)
$all_string = GetAllString($obfuscated);
foreach ($all_string[0] as $string) {
	$string_text = str_replace('"' , '', $string);
	$string_text = str_replace('\'' , '', $string_text);
	$obfuscated = str_replace($string, '"'.AsciiDec($string_text).'"', $obfuscated); 
}

$custom_function_name = [];

// Ont récupére toute les fonction et ont les crypte
$all_obf_args = [];
$all_custom_function = GetCustomFunction($obfuscated);
foreach ($all_custom_function as $custom_function) {
	$function_code = $custom_function['source'];
	$function_code_content = GetFunctionContent($function_code);

	$function_args = $custom_function['args'];
	$function_variable = GetVariable($function_code);


	foreach ($function_args as $args) {
		if (strlen($args) > 4)
		{
			$arg_name = generateRandomString($random_string_len);
			$function_code_content = str_replace($args, $arg_name, $function_code_content);
			array_push($all_obf_args, $arg_name);
		}
		else
		{
			array_push($all_obf_args, $args);
		}
	}

	array_push($custom_function_name, $custom_function['name']);
	$obfuscated = str_replace(GetFunctionContent($function_code), $function_code_content, $obfuscated);
}

// Ont obfusque toute les variable
$all_variable = GetVariable($obfuscated);
$all_obf_variable = [];
foreach ($all_variable as $variable) {
	if ($variable['size'] > 3 && $variable['size'] < 40)
	{
		$name = generateRandomString($random_string_len);
		$obfuscated = str_replace($variable['name'], $name, $obfuscated);
		array_push($all_obf_variable, $name);
	}
	else
	{
		array_push($all_obf_variable, $variable['name']);
	}
}

$all_call = GetCall($obfuscated);

// Ont obfusque tout nom de fonction custom
foreach ($custom_function_name as $name) {
	if (strpos($name, "SWEP:") === false && strpos($name, "ENT:") === false)
	{
		$obfuscated = str_replace($name, generateRandomString($random_string_len), $obfuscated);
	}
}

// Ont obfusque toute les apelle vers des fonction
foreach($all_call as $call)
{
	$call = $call["name"];
	if (!FindInArray($call, $all_obf_args) && !FindInArray($call, $all_obf_variable))
	{
		$call_obf_name = " ".generateRandomString($random_string_len);
		$obfuscated = str_replace($call, $call_obf_name, $obfuscated);
		$obfuscated = "local ".$call_obf_name." = ".$call." ".$obfuscated;
	}
}

if ($line_break == true)
{
	$obfuscated = str_replace("\n", " ", $obfuscated);
}

echo $obfuscated;
?>