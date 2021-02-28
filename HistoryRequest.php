<?php
$request_date=date('Y-m-d H:i:s');
if (isset($_REQUEST['ttn_history_saveload'])) {                           // 1 = save; 0 = load
    try {
        require_once('DBConnect.php');
        if(isset($_REQUEST['ttn'])) {
            $ttn = preg_replace('/[^0-9]/', '', $_REQUEST['ttn']);
        } else {
            exit();
        }
        if ($_REQUEST['ttn_history_saveload'] == '1') {                   //записываем в историю запрос если статус изменился     
            if (isset($_REQUEST['ttn_status']) && ($_REQUEST['ttn_status'] != '') ) {
                $request_status = htmlspecialchars(addslashes($_REQUEST['ttn_status']));      
                $sql = "SELECT ttn_id
                    FROM ttn_number
                    WHERE ttn = :ttn";
                $stmt = $pdo->prepare($sql);
                $stmt->execute(array(
                    'ttn' => $ttn
                ));
                $ttn_id = $stmt->fetch();
                if ($ttn_id == FALSE) {                        //если номер накладной новый, то добавляем его и статус в бд
                    $sql = "INSERT INTO ttn_number (ttn) VALUES (?)";
                    $pdo->prepare($sql)->execute(array($ttn));
                    $last_id = $pdo->lastInsertId();
                    $sql = "INSERT INTO ttn_history (ttn_id, request_date, request_status) VALUES (?, ?, ?)";
                    $pdo->prepare($sql)->execute(array($last_id, $request_date, $request_status));
                }  else {
                
                    $sql = "SELECT status_id           
                        FROM ttn_history
                        WHERE ttn_id = :ttn_id 
                        AND request_status = :request_status";   //нахождение уже записанных данных с таким же номером и статусом
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute(array(
                        'ttn_id' => $ttn_id['0'],
                        'request_status' => $request_status
                    ));
                    $status_id = $stmt->fetch();
                    if ($status_id == FALSE) {
                        $sql = "INSERT INTO ttn_history (ttn_id, request_date, request_status) VALUES (?, ?, ?)";
                        $pdo->prepare($sql)->execute(array($ttn_id['0'], $request_date, $request_status));
                    }
                } 
            } else {
                $data = '{"success" : false, "errormsg" : "Не коректный статус"}';
            }
        } else {                                                 //считываем историю запросов для номера накладной
            $sql = "SELECT ttn_history.request_status, ttn_history.request_date           
                FROM ttn_history 
                LEFT JOIN ttn_number
                ON ttn_history.ttn_id = ttn_number.ttn_id
                WHERE ttn_number.ttn = :ttn";   
            $stmt = $pdo->prepare($sql);
            $stmt->execute(array(
                'ttn' => $ttn,
            ));
            $request_statuses = $stmt->fetchAll();
            if ($request_statuses == FALSE) {
                $data = '{"success" : false, "errormsg" : "У введенного номера нет истории поиска"}';
            } else {
                $data = array("success" => true, "data" => $request_statuses);
                $data = json_encode($data);
            }
        }
        if (empty($data)) {
            $data = '{"success" : true}';
        }
    } catch (PDOException $e) {

        $data = '{"success" : false, "errormsg" : "Ошибка БД: '. $e->getMessage().'"}';

    }
    echo $data;
}
?>