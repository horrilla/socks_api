<?php

require_once 'Db.php';

class Api
{

    public function getAllSocks() {
        $db = Db::getConnection();
        $sql = 'SELECT * FROM socks';
        $query = $db->prepare($sql);
        $query->execute();
        $res = $query->fetchAll();
        file_put_contents('php://output', json_encode($res));
    }

    public function incomeSocks($data) {
        $color = trim(htmlspecialchars($data['color']));
        $cotton = trim(htmlspecialchars($data['cotton']));
        $quantity = trim(htmlspecialchars($data['quantity']));
        $barCode = trim(htmlspecialchars($data['barCode']));

        $db = Db::getConnection();
        $sql = 'SELECT barCode FROM socks WHERE barCode = :barCode';
        $query = $db->prepare($sql);
        $params = ['barCode' => $barCode];
        $query->execute($params);
        $res = $query->rowCount();
        if ($res > 0) {
            $sql_update = 'UPDATE socks SET quantity = quantity + :quantity WHERE barCode IN (:barCode)';
            $query = $db->prepare($sql_update);
            $params = ['quantity' => $quantity, 'barCode' => $barCode];
            $query->execute($params);
            $res = $query->rowCount();

            if ($res > 0) {
                http_response_code(200);
                $res = [
                    'status' => true,
                    'message' => 'Приход успешно добавлен'
                ];
                file_put_contents('php://output', json_encode($res));
            } else {
                http_response_code(500);
                $res = [
                    'status' => false,
                    'message' => 'Произошла ошибка'
                ];
                file_put_contents('php://output', json_encode($res));
            }
        } else {
            $sql_insert = 'INSERT INTO socks (barCode, color, cotton_part, quantity) VALUES (:barCode, :color, :cotton_part, :quantity)';
            $query = $db->prepare($sql_insert);
            $params = ['barCode' => $barCode, 'color' => $color, 'cotton_part' => $cotton, 'quantity' => $quantity];
            $query->execute($params);
            $res = $query->rowCount();

            if ($res > 0) {

                http_response_code(200);
                $res = [
                    'status' => true,
                    'message' => 'Приход успешно добавлен'
                ];

                file_put_contents('php://output', json_encode($res));
            } else {
                http_response_code(500);
                $res = [
                    'status' => false,
                    'message' => 'Произошла ошибка'
                ];
                file_put_contents('php://output', json_encode($res));
            }
        }
    }

    public function outcomeSocks($data) {
        $color = trim(htmlspecialchars($data['color']));
        $cotton = trim(htmlspecialchars($data['cotton']));
        $quantity = trim(htmlspecialchars($data['quantity']));
        $barCode = trim(htmlspecialchars($data['barCode']));

        $db = Db::getConnection();
        $sql = 'SELECT barCode FROM socks WHERE barCode = :barCode';
        $query = $db->prepare($sql);
        $params = ['barCode' => $barCode];
        $query->execute($params);
        $res = $query->rowCount();
        if ($res > 0) {
            $sql_update = 'UPDATE socks SET quantity = quantity - :quantity WHERE barCode IN (:barCode)';
            $query = $db->prepare($sql_update);
            $params = ['quantity' => $quantity, 'barCode' => $barCode];
            $query->execute($params);
            $res = $query->rowCount();

            if ($res > 0) {
                http_response_code(200);
                $res = [
                    'status' => true,
                    'message' => 'Отпуск успешно произведен'
                ];

                file_put_contents('php://output', json_encode($res));

            } else {
                http_response_code(500);
                $res = [
                    'status' => false,
                    'message' => 'Произошла ошибка'
                ];

                file_put_contents('php://output', json_encode($res));

            }
        } else {

            http_response_code(400);
            $res = [
                'status' => false,
                'message' => 'Данный товар не найден в базе'
            ];
            file_put_contents('php://output', json_encode($res));
        }
    }

    public function getSocksMoreThan($params) {
        $cottonPart = trim(htmlspecialchars($params['cottonPart']));
        $color = trim(htmlspecialchars($params['color']));

        $db = Db::getConnection();
        $sql = 'SELECT SUM(quantity) AS quantity FROM socks WHERE cotton_part >= :cottonPart AND color IN (:color)';
        $query = $db->prepare($sql);
        $params = ['cottonPart' => $cottonPart, 'color' => $color];
        $query->execute($params);
        $res = $query->fetchAll();

        if (!empty($res[0]['quantity'])) {
            $res = [
                'status' => true,
                'quantity' => $res[0]['quantity']
            ];
            http_response_code(200);
            file_put_contents('php://output', json_encode($res));
        } else {
            $res = [
                'status' => false,
                'message' => 'Непредвиденная ошибка, проверьте корректность указанных параметров'
            ];
            http_response_code(500);
            file_put_contents('php://output', json_encode($res));

        }
    }

    public function getSocksLessThan($params) {
        $cottonPart = trim(htmlspecialchars($params['cottonPart']));
        $color = trim(htmlspecialchars($params['color']));

        $db = Db::getConnection();
        $sql = 'SELECT SUM(quantity) AS quantity FROM socks WHERE cotton_part <= :cottonPart AND color IN (:color)';
        $query = $db->prepare($sql);
        $params = ['cottonPart' => $cottonPart, 'color' => $color];
        $query->execute($params);
        $res = $query->fetchAll();

        if (!empty($res[0]['quantity'])) {
            $res = [
                'status' => true,
                'quantity' => $res[0]['quantity']
            ];
            http_response_code(200);
            file_put_contents('php://output', json_encode($res));
        } else {
            $res = [
                'status' => false,
                'message'=> 'Нет носков, соответствующих заданным параметрам'
            ];
            http_response_code(500);
            file_put_contents('php://output', json_encode($res));

        }
    }

}























