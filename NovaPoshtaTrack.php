<?php
if (isset($_GET['ttn']) and ($_GET['ttn']) != '') {
    $ttn = preg_replace('/[^0-9]/', '', $_GET['ttn']);
    $data = '';
    $wait_time = 1;
    $curl_options = '{
        "modelName": "TrackingDocument",
        "calledMethod": "getStatusDocuments",
        "methodProperties": {
            "Documents": [
                {
                    "DocumentNumber": "'.$ttn.'"
                }
            ]
        }    
    }';
    // создание нового ресурса cURL
    $ch = curl_init();

    // установка URL и других необходимых параметров
    curl_setopt($ch, CURLOPT_URL, "http://testapi.novaposhta.ua/v2.0/en/documentsTracking/json/");
    curl_setopt($ch, CURLOPT_POST, TRUE);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    curl_setopt($ch, CURLOPT_POSTFIELDS, $curl_options);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

    // выполнение запроса c повторным вызовом через 1с при статусе превышения количества запросов
    do {
        $responce = curl_exec($ch);

        if ($responce === FALSE) {
            $e = curl_error($ch);
            $data = '{"success" : false, "errors" : "'.$e.'" }';
        } else {
            if (strripos($responce,'"statusCode": 429') === FALSE) {                        //статус 'Попробуйте позже'
                $data = preg_replace_callback('/\\\\u([0-9a-fA-F]{4})/', function ($match) {
                    return mb_convert_encoding(pack('H*', $match[1]), 'UTF-8', 'UCS-2BE');
                }, $responce);
            } else {
                sleep($wait_time);
            }
        }
    } while ($data === '');
} else {
    $data = '{"success" : false, "errors" : "номер накладной не задан"}';
}

echo $data;

// завершение сеанса и освобождение ресурсов
curl_close($ch);
?>