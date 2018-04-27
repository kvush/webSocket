<div class="site-about">

    <div class="body-content">

        <h1 id="websocket">WebSocket сервер</h1>

        <blockquote>
            <p>Реализация тестового задания от SKU GRID. <br />
                Илья Шашилов <a href="&#x6d;&#97;&#105;&#108;&#x74;&#x6f;:&#x6b;&#x76;&#117;&#115;&#104;&#x40;&#x6d;&#97;&#105;&#x6c;&#46;&#114;&#x75;">&#x6b;&#x76;&#117;&#115;&#104;&#x40;&#x6d;&#97;&#105;&#x6c;&#46;&#114;&#x75;</a> <br />
                дата 28.04.2018</p>
        </blockquote>

        <h3 id="">Установка</h3>

        <ul>
            <li>через composer подтянуть пару зависимостей в папку vendor</li>

            <li>настроить вэбсервер на папку web</li>

            <li>убедится что порты указанные в js/webSocketClient.js, в common/common.php и в
                ext/WebSocketServer.php открыты для подключений и не заняты. В случае необходимости поменять.</li>

            <li>принять миграции, в консоле  <code>yii migrate/up</code></li>
        </ul>

        <h3 id="-1">Использование</h3>

        <h5 id="websocket-1">в начале надо запустить webSocket сервер</h5>

        <ul>
            <li>Через консоль <code>php server.php start</code></li>
        </ul>

        <h5 id="html">html клиенты</h5>

        <ul>
            <li>отдельные файлы-близнецы client*.html, в них различаются только js переменные
                определяющие условные параметры клиента (clientId и taskId)</li>

            <li>для проведения тестов можно менять эти значения.</li>

            <li>запускать их можно по ссылкам через стартовую страницу, для удобства ни открываются в отдельных окнах </li>
        </ul>

        <h5 id="-2">консольный серверный клиент</h5>

        <ul>
            <li>Запускать через консоль <code>yii admin/&lt;command&gt; &lt;params&gt;</code></li>

            <li><code>yii admin/get-all-users</code>  выводит на экран
                всех зарегистрированных на WebSocket сервере пользователей.</li>

            <li><code>yii admin/get-all-user-task -u &lt;int&gt;</code> выводит на эран все задачи для одного пользователя.</li>

            <li><code>yii admin/send-message -u all -m &lt;text&gt;</code> отправляет сообщение всем зарегистрированным на WebSocket сервере пользователям,
                во все задачи.</li>

            <li><code>yii admin/send-message -u &lt;int&gt; -m &lt;text&gt;</code> отправляет сообщение одному пользователю, во все задачи.</li>

            <li><code>yii admin/send-message -u &lt;int&gt; -t &lt;int&gt; -m &lt;text&gt;</code> отправляет сообщение одному пользователю, во одну задачу.</li>
        </ul>
    </div>

</div>