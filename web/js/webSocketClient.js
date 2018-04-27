const host = "sku-grid";
const port = "8000";

function webSocketStart(client_id, task_id, status_p) {
    if ("WebSocket" in window) {

        var ws = new WebSocket("ws://" + host + ":" + port);

        ws.onopen = function() {
            var data = {};
            data.clientId = client_id;
            data.taskId = task_id;
            data = JSON.stringify(data);
            ws.send(data);
            status_p.innerHTML = "online";
            status_p.style.color = "#66cc00";
            console.log("Message is sent...");
        };

        ws.onmessage = function (evt) {
            var received_msg = evt.data;
            console.log("Incoming message:\n");
            console.log(received_msg);
        };

        ws.onclose = function(e) {
            console.log(e);
            status_p.innerHTML = "offline";
            status_p.style.color = "#ffffff";
            console.log("Connection is closed...");
        };

        ws.onerror = function (e) {
            console.log('error');
            console.log(e);
        };
    }
    else {
        alert("WebSocket NOT supported by your Browser!");
    }
}