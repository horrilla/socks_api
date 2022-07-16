<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: *");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json;");
header('Accept: application/json');

require_once 'classes/Db.php';
require_once 'classes/Api.php';


$method = $_SERVER['REQUEST_METHOD'];
$http_query = $_GET['query'];

if ($method == 'GET' and $http_query == 'api/socks') {
    if (!empty($_GET['color']) and !empty($_GET['operation']) and !empty($_GET['cottonPart'])) {
        if ($_GET['operation'] == 'moreThan') {
            $api = new Api();
            $api->getSocksMoreThan($_GET);
        } elseif ($_GET['operation'] == 'lessThan') {
            $api = new Api();
            $api->getSocksLessThan($_GET);
        }
    } else {
        $api = new Api();
        $api->getAllSocks();
    }

} elseif ($method == 'POST' and $http_query == 'api/socks/income') {
    if (!empty($_POST)) {
        $api = new Api();
        $api->incomeSocks($_POST);
    } else {
        http_response_code(400);
        $res = [
            'status' => false,
            'message' => 'Параметры запроса отсутствуют или имеют некорректный формат'
        ];
        file_put_contents('php://output', json_encode($res));
    }

} elseif ($method == 'POST' and $http_query == 'api/socks/outcome') {
    if (!empty($_POST)) {
        $api = new Api();
        $api->outcomeSocks($_POST);
    } else {
        http_response_code(400);
        $res = [
            'status' => false,
            'message' => 'Параметры запроса отсутствуют или имеют некорректный формат'
        ];
        file_put_contents('php://output', json_encode($res));
    }
}
