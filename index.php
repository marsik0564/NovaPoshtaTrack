<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, user-scalable=no" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Отслеживание посылки</title> 
    <link rel="stylesheet" href="css/my.css" />       
    <script src="js/jquery-3.5.1.js"></script> 
    <script src="js/my.js"></script>
</head>
<body>
    <form enctype="multipart/form-data" action="NovaPoshtaTrack.php" method="get">
        <label  for="number">
            Товаро-транспортная накладная Новой Почты:
        </label>
        <input id="number" type="text" name="ttn" size="14" maxlength="14" title="Введите номер накладной"/>
        <input id="track" type="submit" name="ttn_track" value="Track" />  
        <button id="display_history" type="button">TrackHistory</button>
        <input id="history" type="hidden" name="ttn_history_saveload" value="1" /> 
    </form>  
    <p class ="wait">Подождите, пожалуйста</p>
    <div id="responce">
        <p><b>Номер отслеживаемой посылки (ттн):</b> <span id="Number"></span><p>
        <p><b>Адрес отправителя:</b> <span id="SenderAddress"></span><p>
        <p><b>Адрес получателя:</b> <span id="RecipientAddress"></span><p>
        <p><b>Вес:</b> <span id="DocumentWeight"></span><p>
        <p><b>Стоимость доставки:</b> <span id="DocumentCost"></span><p>
        <p><b>Ожидаемая дата доставки:</b> <span id="ScheduledDeliveryDate"></span><p>
        <p><b>Статус:</b> <span id="Status"></span><p>
    </div>
    <div id="status_history">
    </div>
</body>
</html>