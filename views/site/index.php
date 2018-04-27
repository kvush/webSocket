<div class="site-index">

    <div class="jumbotron">
        <h1>Добро пожаловать</h1>
        <h2>в WebSocket сервер</h2>
        <p>
            Реализация тестового задания от SKU GRID.<br>
            Ниже пердставленны ссылки на clint.html реализующие JavaScript клиентов
        </p>
    </div>

    <div class="body-content">

        <div class="row">
            <div class="col-lg-4">
                <h2>client1.html</h2>

                <a href="/client1.html" target="_blank">Нажмите чтобы открыть</a>
            </div>
            <div class="col-lg-4">
                <h2>client2.html</h2>

                <a href="/client2.html" target="_blank">Нажмите чтобы открыть</a>
            </div>
            <div class="col-lg-4">
                <h2>client3.html</h2>

                <a href="/client3.html" target="_blank">Нажмите чтобы открыть</a>
            </div>
        </div>
    </div>

</div>

<div class="well">
    <?php \yii\helpers\VarDumper::dump($clients, 10, true)?>
</div>