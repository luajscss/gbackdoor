<?php
header('Content-Type: application/json');
include('../class/include.php');
if (!Account::isAuthentified() || !CSRF::isAjaxRequest())
{
    die("Bad request");
}

$all_users_predata = Account::GetAllAccount();
$list = [];

foreach ($all_users_predata as $data)
{    
    $button = '<button onclick="deleteUser('.$data['id'].')" type="button" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i>&nbsp;Delete</button>';

    array_push($list, ["DT_RowId" => "user-".$data['id'], $data['username'], $button]);
}

echo json_encode(['data' => $list]);
?>