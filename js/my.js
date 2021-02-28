$(function(){
    var responce, params, input_data;

    function HistoryRequest(input_data) {    //запрос на сохранение/отображение истории поиска
        $.ajax({
            url : 'HistoryRequest.php',
            method : 'post',
            data : input_data
        }).done(function(data) {
            responce = JSON.parse(data);
            if (responce.success) {
                if (typeof(responce.data) !== 'undefined') {
                    DisplayStatusHistory(responce.data)
                }
            } else {
                alert(responce.errormsg);
            }
        });
    }

    function DisplayTrackingParameters (params) {  //отображение параметров, найденных при трекинге

        $('#Number').html(params.Number);

        if (params.SenderAddress == '') {
            if (params.WarehouseSenderAddress == '') {
                $('#SenderAddress').html(params.CitySender);
            } else {
                $('#SenderAddress').html(params.WarehouseSenderAddress);
            };
        } else {
            $('#SenderAddress').html(params.SenderAddress);
        };

        if (params.RecipientAddress == '') {
            if (params.WarehouseRecipientAddress == '') {
                $('#RecipientAddress').html(params.CityRecipient);
            } else {
                $('#RecipientAddress').html(params.WarehouseRecipientAddress);
            }
        } else {
            $('#RecipientAddress').html(params.RecipientAddress);
        };

        $('#DocumentWeight').html(params.DocumentWeight + 'кг');
        $('#DocumentCost').html(params.DocumentCost + 'грн');

        if (params.ScheduledDeliveryDate == '') {
            $('#ScheduledDeliveryDate').html('Не вiдома');
        } else {
            $('#ScheduledDeliveryDate').html(params.ScheduledDeliveryDate);
        };

        $('#Status').html(params.Status);
        $('#responce').show();
    }


    function DisplayStatusHistory (params) {            // отображение истории запросов
        var status_html ='';
        for (var i = 0; i < params.length; i++) {
            status_html += '<div class="status_block"><p>Дата операции: ' + 
                params[i].request_date +
                '</br> статус: </p><h2 class="status_header">' +
                params[i].request_status +
                '</h2></div>'; 
        }
        // params.forEach(parameter => {
        //     status_html += '<div class="status_block"><p>Дата операции: ' + 
        //         parameter.request_date +
        //         '</br> статус: </p><h2 class="status_header">' +
        //         parameter.request_status +
        //         '</h2></div>';
        // });
        $('#status_history').append(status_html).show();
    }

    $("#display_history").on('click',function(){
        $('#responce').hide();
        $('#status_history').html('<p>Номер: ' + $('#number').val() + '</p>');
        $('#history').val('0');
        HistoryRequest($('form').serialize());
        $('#history').val('1');
    });

    $('form').submit(function(ev){
        ev.preventDefault();
        $('#responce').hide();
        $('#status_history').hide();
        $('.wait').show();
        input_data = $(this).serialize();
        $.ajax({
            url : $(this).attr("action"),
            method : $(this).attr("method"),
            data : input_data
        }).done(function(data) {
            responce = JSON.parse(data); 
            $('.wait').hide();                     
            if (responce.success) { 
                params = responce.data['0'];
                if ((params.StatusCode != 3) && (params.StatusCode != 2)) {  // статусы удаленной и не найденой накладной

                    DisplayTrackingParameters(params);

                    input_data += '&ttn_status=' + encodeURI(params.Status);

                    HistoryRequest(input_data);

                } else {
                    alert(params.Status);
                }
            } else {
                alert(responce.errors);
            }
        });
    });
});