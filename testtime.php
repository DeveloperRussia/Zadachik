<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
<?php
require_once("config.php");
$data = array(); 

$ta = mysql_query("select * from `leadertusk`");
$x = 0;


while($row = mysql_fetch_assoc($ta)){ 
     $data[$x][id] =	$row['id'];                        
  $data[$x][remind] = $row['remind'];
  $data[$x][quest] = $row['quest'];

	$x++;
}
$x--;
?>
<script>
var quest = '{ \
	"number": [	\
	{"id": "<?php echo $data[0][id] ?>", "remind": "<?php echo $data[0][remind] ?>","quest": "<?php echo $data[0][quest] ?>"}, \
{"id": "<?php echo $data[1][id] ?>", "remind": "<?php echo $data[1][remind]?>","quest": "<?php echo $data[1][quest] ?>"}, \
{"id": "<?php echo $data[2][id] ?>", "remind": "<?php echo $data[2][remind]?>","quest": "<?php echo $data[2][quest] ?>"}, \
{"id": "<?php echo $data[3][id] ?>", "remind": "<?php echo $data[3][remind]?>","quest": "<?php echo $data[3][quest] ?>"} \
	]\
	}';

quest = JSON.parse (quest, function (key, value){
	if(key == 'remind') return new Date(value);
	return value;
});

function ValidTime (){
	now = new Date();
	console.log(now);
}
setInterval('ValidTime()',5000);

function sendNotification(title, options) {
// Проверим, поддерживает ли браузер HTML5 Notifications
if (!("Notification" in window)) {
alert('Ваш браузер не поддерживает HTML Notifications, его необходимо обновить.');
}

// Проверим, есть ли права на отправку уведомлений
else if (Notification.permission === "granted") {
// Если права есть, отправим уведомление
var notification = new Notification(title, options);

function clickFunc() { alert('Пользователь кликнул на уведомление'); }

notification.onclick = clickFunc;
}

// Если прав нет, пытаемся их получить
else if (Notification.permission !== 'denied') {
Notification.requestPermission(function (permission) {
// Если права успешно получены, отправляем уведомление
if (permission === "granted") {
var notification = new Notification(title, options);

} else {
alert('Вы запретили показывать уведомления'); // Юзер отклонил наш запрос на показ уведомлений
}
});
} else {
// Пользователь ранее отклонил наш запрос на показ уведомлений
// В этом месте мы можем, но не будем его беспокоить. Уважайте решения своих пользователей.
}};
//уведомление

function notification(){

for (var i=0; i<quest.number.length; i++){
	if((quest.number[i].remind.getFullYear() +":"+quest.number[i].remind.getMonth()+":"+quest.number[i].remind.getDate()+":"+quest.number[i].remind.getHours()+":"+quest.number[i].remind.getMinutes()) == (now.getFullYear() +":"+now.getMonth()+":"+now.getDate()+":"+now.getHours()+":"+now.getMinutes())){
	


	sendNotification('Напоминание про задачу', {
body: 'Задача под номером '+i+' c задачей "'+quest.number[i].quest+'" проявила себя',

dir: 'auto'
});
}
}

}


$(document).ready(function() {

setInterval('notification()',10000); 
});</script>