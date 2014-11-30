function subscribe(userid) {
    var conn = new ab.Session(
        'ws://' + ApplicationOptions.constance.WEBSOCKET_URL + ':' + ApplicationOptions.constance.WEBSOCKET_PORT,
        function () {
            conn.subscribe(userid, function (topic, data) {
                // This is where you would add the new article to the DOM (beyond the scope of this tutorial)
                console.log('New Message published to user "' + topic + '" : ' + data.message);
                var messageData = data.message;
                debugObject = $.UIkit.notify({
                    message: "Order # = <span onclick='$(\"#tpSearch\").val(\""+messageData.tp+"\")' style='cursor: pointer;color: red'>"+messageData.refId+"</span> request to delay in <span style='color: #0000FF'>"+ messageData.delay_minutes+" minutes</span> from cro(ID): "+messageData.croId,
                    status: 'warning',
                    timeout: 0,
                    pos: 'top-center'
                });
            });
        },
        function () {
            console.warn('WebSocket connection closed');
        },
        {'skipSubprotocolCheck': true}
    );
}

subscribe('cro1');