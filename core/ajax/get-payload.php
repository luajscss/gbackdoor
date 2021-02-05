<?php
header('Content-Type: application/json');
include('../class/include.php');
if (!Account::isAuthentified() || !CSRF::isAjaxRequest())
{
    die("Bad request");
}

$all_payload_predata = Payload::GetAllPayload();
$list = [];

foreach ($all_payload_predata as $data)
{
    $button_delete = '<button onclick="deletePayload('.$data['id'].')" type="button" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i>&nbsp;Remove</button>';

    $button_view = '<button onclick="viewPayload('.$data['id'].')" type="button" class="btn btn-warning btn-sm"><i class="fa fa-pencil-square-o"></i>&nbsp;Edit</button>';

    array_push($list, ["DT_RowId" => "payload-".$data['id'], $data['payload_name'], $data['payload_comment'], $button_delete."&nbsp;".$button_view]);
}

echo json_encode(['data' => $list]);
?>