# WebSocket сервер

> Реализация тестового задания от SKU GRID.  
Илья Шашилов <kvush@mail.ru>  
дата 28.04.2018
 
### Установка
* через composer подтянуть пару зависимостей в папку vendor
* настроить вэбсервер на папку web
* убедится что порты указанные в js/webSocketClient.js, в common/common.php и в 
ext/WebSocketServer.php открыты для подключений и не заняты. В случае необходимости поменять.
* принять миграции, в консоле  ```yii migrate/up```
  
### Использование
##### в начале надо запустить webSocket сервер
 * Через консоль ```php server.php start```


##### html клиенты
 * отдельные файлы-близнецы client*.html, в них различаются только js переменные 
 определяющие условные параметры клиента (clientId и taskId)
 * для проведения тестов можно менять эти значения.
 * запускать их можно по ссылкам через стартовую страницу, для удобства ни открываются в отдельных окнах 
  
##### консольный серверный клиент  
 * Запускать через консоль ```yii admin/<command> <params>```
 * ```yii admin/get-all-users```  выводит на экран 
  всех зарегистрированных на WebSocket сервере пользователей.
 * ```yii admin/get-all-user-task -u <int>``` выводит на эран все задачи для одного пользователя.
 * ```yii admin/send-message -u all -m <text>``` отправляет сообщение всем зарегистрированным на WebSocket сервере пользователям, 
 во все задачи.
 * ```yii admin/send-message -u <int> -m <text>``` отправляет сообщение одному пользователю, во все задачи.
 * ```yii admin/send-message -u <int> -t <int> -m <text>``` отправляет сообщение одному пользователю, во одну задачу.