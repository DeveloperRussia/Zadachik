<html><head>
<link rel="stylesheet" href="style/style.css">
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css" >
<link rel="stylesheet" href="bootstrap/css/bootstrap-datetimepicker.min.css" >
<script src="bootstrap/js/bootstrap.min.js"></script>
<script src="bootstrap/js/moment-with-locales.min.js"></script>



<script src="scripts/notification.js"></script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
 <script type="text/javascript" src="scripts/modal.js"></script>    
</head>
<p id="tag"> Задачник</p>  <img id="img1" src="img/task.png">
<script src="http://code.jquery.com/jquery.min.js" type="text/javascript"></script>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script src="//ajax.aspnetcdn.com/ajax/jquery.ui/1.10.3/jquery-ui.min.js"></script>


<script type="text/javascript">


$(document).ready(function() {

    // Добавляем новую запись, когда произошел клик по кнопке
    $("#FormSubmit").click(function (e) {

        e.preventDefault();
		

        if($("#contentText").val()==="") //simple validation
        {
            alert("Введите текст!");
            return false;
        }

        var myData = "content_txt="+ $("#contentText").val(); //post variables

        jQuery.ajax({
            type: "POST", // HTTP метод  POST или GET
            url: "response.php", //url-адрес, по которому будет отправлен запрос
            dataType:"text", // Тип данных,  которые пришлет сервер в ответ на запрос ,например, HTML, json
            data:myData, //данные, которые будут отправлены на сервер (post переменные)
            success:function(response){
            $("#responds").append(response);
            $("#contentText").val(''); //очищаем текстовое поле после успешной вставки
            },
            error:function (xhr, ajaxOptions, thrownError){
                alert(thrownError); //выводим ошибку
            }
        });
    });

    //Удаляем запись при клике по крестику
    $("body").on("click", ".del_button", function(e) {
        e.preventDefault();
        var clickedID = this.id.split("-"); //Разбиваем строку (Split работает аналогично PHP explode)
        var DbNumberID = clickedID[1]; //и получаем номер из массива
        var myData = 'recordToDelete='+ DbNumberID; //выстраиваем  данные для POST

        jQuery.ajax({
            type: "POST", // HTTP метод  POST или GET
            url: "response.php", //url-адрес, по которому будет отправлен запрос
            dataType:"text", // Тип данных
            data:myData, //post переменные
            success:function(response){
            // в случае успеха, скрываем, выбранный пользователем для удаления, элемент
            $('#item-'+DbNumberID).fadeOut("slow");
            },
            error:function (xhr, ajaxOptions, thrownError){
                //выводим ошибку
                alert(thrownError);
            }
        });
    });
	  $("body").on("click", "#responds .del_file_button", function(e) {
        e.preventDefault();
        var clickedID = this.id.split("-"); //Разбиваем строку (Split работает аналогично PHP explode)
        var DbNumberID = clickedID[1]; //и получаем номер из массива
        var myData = 'recordToDeleteFile='+ DbNumberID; //выстраиваем  данные для POST

        jQuery.ajax({
            type: "POST", // HTTP метод  POST или GET
            url: "response.php", //url-адрес, по которому будет отправлен запрос
            dataType:"text", // Тип данных
            data:myData, //post переменные
            success:function(response){
            // в случае успеха, скрываем, выбранный пользователем для удаления, элемент
            $('#file_src-'+DbNumberID).fadeOut("slow");
            },
            error:function (xhr, ajaxOptions, thrownError){
                //выводим ошибку
                alert(thrownError);
            }
        });
    });
$("a.cor_button").click(function (e) {
        var clickedID = this.id.split("-"); //Разбиваем строку (Split работает аналогично PHP explode)
        var DbNumberID = clickedID[1]; //и получаем номер из массива
        
        $("#jack_"+DbNumberID).hide()//Строка с текстом прячется при нажатии на карандаш
		$("#edit_"+DbNumberID).show();//спрятанная (display: none) строка input "text" появляется
		$("#edit_"+DbNumberID).focus();
		
    });
$('.editbox').on('change',function(e)
{
var clickedID = this.id.split("_"); //Разбиваем строку (Split работает аналогично PHP explode)
var DbNumberID = clickedID[1];

var news=$("#edit_"+DbNumberID).val(); //берем из появившегося input text`a значение
 
if(news ==="") //simple validation
{
            alert("Введите текст!");
            return false;
}else{
	jQuery.ajax({
            type: "POST", // HTTP метод  POST или GET
            url: "response.php", //url-адрес, по которому будет отправлен запрос
            dataType:"text", // Тип данных,  которые пришлет сервер в ответ на запрос ,например, HTML, json
            data: { "news": news,"id": DbNumberID}, //данные, которые будут отправлены на сервер (post переменные)
            success:function(response){
            $("#jack_"+DbNumberID).html(news);//если все успешно строка становится как input text
            e.stopImmediatePropagation();
            },
            error:function (xhr, ajaxOptions, thrownError){
                alert(thrownError); //выводим ошибку
            }
        });
		}
});
	$(".editbox").on("mouseup",function(e)
{
e.stopImmediatePropagation();
});

// Outside click action
$(document).mouseup(function()// если кликнуть по документу строка редактирования скрывается
{

$(".editbox").hide();
$(".jack").show();
});

$('.upload').on('click', function() {
var clickedID = this.id.split("-"); //Разбиваем строку (Split работает аналогично PHP explode)
var DbNumberID = clickedID[1];
    var file_data = $('#sortpicture-'+DbNumberID).prop('files')[0];
    var form_data = new FormData();
    form_data.append('file', file_data);
	form_data.append('DbNumberID', DbNumberID);
	var fileName =  $('input#sortpicture-'+DbNumberID)[0].files[0].name;
    var filesize = $('input#sortpicture-'+DbNumberID)[0].files[0].size;
	if(filesize < 5242880){
    $.ajax({
                url: 'upload.php',
                dataType: 'text',
                cache: false,
                contentType: false,
                processData: false,
	            data: form_data,
                type: 'post',
                        success: function(php_script_response){
						
                   $('div#file-'+DbNumberID).append("<a href='upload/"+fileName+"' download>"+fileName+"<a href='#' class='del_file_button' title='Удалить файл' id='delfile-'"+DbNumberID+"'> ×</a></a>");

                }
     });

	}
	else{
		alert("Ваш файл весит: "+filesize+" байт, а должен не превышать 5242880 байт!");
	}

});
$("a.addTag").click(function (e) {
        var clickedID = this.id.split("-"); //Разбиваем строку (Split работает аналогично PHP explode)
        var DbNumberID = clickedID[1]; //и получаем номер из массива
        var css = $("#tag_item-"+DbNumberID).css("background-color"); 
$("#tagsucces").show("slow");
		$(".radioTag").show("slow");
		
		$("button#tagsucces").click(function (e){
    var tag =  $("input[name=nameOfTag]:checked").val();
		
		jQuery.ajax({
            type: "POST", // HTTP метод  POST или GET
            url: "tag.php", //url-адрес, по которому будет отправлен запрос
            dataType:"text", // Тип данных,  которые пришлет сервер в ответ на запрос ,например, HTML, json
            data: { "tag": tag,"id_tag": DbNumberID}, //данные, которые будут отправлены на сервер (post переменные)
            success:function(tag){
			
            $(tag).append("#edit_"+DbNumberID);
            e.stopImmediatePropagation();
			console.log(tag);
			$("#tagsucces").hide("slow");
		$(".radioTag").hide("slow");
            },
            error:function (xhr, ajaxOptions, thrownError){
                alert(thrownError); //выводим ошибку
            }
 

   


});
});
});
$("#closeAddTable").click(function (e) {
	$("#tagsucces").hide("slow");
		$(".radioTag").hide("slow");
        
});

$(".time").click(function (e){
    var clickedID = this.id.split("-"); //Разбиваем строку (Split работает аналогично PHP explode)
        var DbNumberID = clickedID[1]; //и получаем номер из массива
        var remind = $("#setTime-"+DbNumberID).val();

        jQuery.ajax({
            type: "POST", // HTTP метод  POST или GET
            url: "response.php", //url-адрес, по которому будет отправлен запрос
            dataType:"text", // Тип данных,  которые пришлет сервер в ответ на запрос ,например, HTML, json
            data: { "remind": remind,"id-time": DbNumberID}, //данные, которые будут отправлены на сервер (post переменные)
            success: function(time){
			
          if(remind){
          location.reload();
}
		
            },
            error:function (xhr, ajaxOptions, thrownError){
                alert(thrownError); //выводим ошибку
            }
 

   


});
})

});

</script>
<div class="container">
<div class="alert alert-success" id="respons" role="alert">Отсортируйте и нажмите на элемент, чтобы сохранить изменения :)</div>


<ul class="list-group sortable ui-sortable" id="responds">

<?php

//подключаем конфигурационный файл
include_once("config.php");

//MySQL запрос
$Result = mysql_query("SELECT `id`,`quest` FROM `leadertusk` ORDER BY `order`");
$order = 0;
// получаем все записи из таблицы add_delete_record


while($row = mysql_fetch_array($Result))
{

echo '<li id="item-'.$row["id"].'" class="list-group-item" ><strong><span class="jack" id="jack_'.$row["id"].'">'.$row["quest"].'</span></strong>';
echo '<input type="text" class="editbox" value="'.$row["quest"].'"id="edit_'.$row["id"].'">';
$Re = mysql_query("SELECT * FROM `tag` where `id_quest` = '".$row["id"]."' ");
while($rows = mysql_fetch_array($Re)){
	echo '<div class="tag_cloud" id="tagDivDel-'.$row["id"].'">
	<table>
	
	<td  style="background-color: '.$rows["color"].'; font-size: 13;">
	<p><strong> '.$rows["name"].'</strong><a href="#" class="del_tag_from_quest" id="tag_del-'.$row["id"].'" title="Удалить метку" style="font-size: 15; color: black;" > ×</a></p></td></table></div>';
}
echo '<div class="del_wrapper"><a href="#" title="Удалить задачу" class="del_button" id="del-'.$row["id"].'">';
echo '<img src="img/1.png" border="0" /></a>';
echo '<a href="#" class="cor_button" title="Редактировать задачу" id="cor-'.$row["id"].'">';
echo '<img src="img/pencil.png" id="img" border="0" alt="Редактировать задачу"/></a>';
echo '
<a href="#" class="addTag" title="Добавить тэг" id="cor-'.$row["id"].'">';
echo '<img src="tag.png" id="img" border="0"  data-toggle="modal"  data-target="#myModal" alt="Редактировать задачу"/></a>';
echo '<a href="#" class="download" title="Прикрепить файл" id="download-'.$row["id"].'"><img src="img/download.png"  border="0" id="img" data-toggle="modal" data-target="#myModal-'.$row["id"].'">'; 
echo '<a href="#" class="time" title="Установить напоминание" id="time-'.$row["id"].'"><img src="img/time.png"   border="0" id="img" data-toggle="modal" data-target="#myModalTime-'.$row["id"].'"></a>'; 
echo ' <div class="modal fade" id="myModalTime-'.$row["id"].'" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title" id="myModalLabel">Установить напоминание</h4>
      </div>
      <div class="modal-body">
        <div class="form-group">
		
  <label for="usr">Выберите дату напоминания:</label>
  <input type="datetime-local" id="setTime-'.$row["id"].'">

</div>
<button type="button" id="setTime-'.$row["id"].'" class="time">Добавить</button></br>
</div>
</div>
</div>
</div>';
echo '<div id="myModal-'.$row["id"].'" class="modal fade">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header"><button class="close" type="button" data-dismiss="modal">×</button>
<h4 class="modal-title">Загрузить файл </h4>
</div>
<div class="modal-body"><input id="sortpicture-'.$row["id"].'" type="file" name="sortpic" />
<br> Размер файла должен не превышать 5Мб!
<br>

<button  class="upload" id="upload-'.$row["id"].'">Загрузить</button>
<div class="ajax-respond"></div></div>
<div class="modal-footer"><button class="btn btn-default" type="button" data-dismiss="modal">Закрыть</button></div>
</div>
</div>
</div>
</a></div><hr>';
$res =mysql_query("SELECT count(*) FROM `table1` where id_quest = '".$row["id"]."'");
if ($res !=0){
	

echo '<br>Приложение: <div id="file-'.$row["id"].'">';
$low = mysql_query("SELECT * FROM `table1` where id_quest = '".$row["id"]."'");

while($row = mysql_fetch_array($low)){

echo '<div id="file_src-'.$row["id"].'"><a href="upload/'.$row["filename"].'" id="url-'.$row["id"].'" download>'.$row["filename"].'<a href="#" class="del_file_button" title="Удалить файл" id="tagdelfile-'.$row["id"].'"> ×</a>
</a></<br></div>';	

}
}




}



?>
<script type="text/javascript">

    var ul_sortable = $('.sortable');
    ul_sortable.sortable({
		axis: "y",
        revert: 100,
        placeholder: 'placeholder'
    });
    ul_sortable.disableSelection();
    var btn_save = $('li'),
        div_respons = $('#respons');
    btn_save.on('mousedown', function(e) {
        e.preventDefault();
        var sortable_data = ul_sortable.sortable('serialize');
        div_respons.text('Сохраняем');
        $.ajax({
            data: sortable_data,
            type: 'POST',
            url: 'sortable.php',
            success:function(result) {
                div_respons.text(result);
            }
        });
    });
	   
        
   

    </script> 
</ul>

<div class="form_style">
<textarea wrap="off" placeholder="Напишите задачу" name="content_txt" id="contentText"></textarea>
<button class = "btn btn-primary" id="FormSubmit">Добавить</button>
<button type="button" class="btn btn-primary" data-toggle="modal" id="addTag" data-target="#myModal">
 Добавить метку
</button>

<!-- Модальное окно -->  
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title" id="myModalLabel">Метки</h4>
      </div>
      <div class="modal-body">
        <div class="form-group">
		
  <label for="usr">Имя метки:</label>
  <input type="text" placeholder="Дом" id="textTag" class="form-control" id="usr">
</div>
	
		<div class="form-group">
    <label for="exampleFormControlSelect1">Выберите цвет метки:</label>
    <select class="form-control" id="exampleFormControlSelect1">
    <option id="green" value="#5ebc5e">Зеленый</option>
    <option id="yellow" value="#fff750e6">Желтый</option>
    <option id="red" value="#da4b4b">Красный</option>
     <option id="blue" value="#4190dc">Синий</option> 
    </select>
  </div>
  
 <button type="button" id="addTag1" class="btn btn-primary">Добавить</button></br>
 </br>
  <label for="exampleFormControlSelect1">Метки</label>



<?php




//MySQL запрос
$Result = mysql_query("select * from `tag`");



echo'<div id="moreTag">';
while($row = mysql_fetch_array($Result))
{


echo '<li id="tag_item-'.$row["id_tag"].'" class="list-group-item" style="background-color:'.$row["color"].' ;" ><span class="tag_jack" id="tag_jack_'.$row["id_tag"].'" >'.$row["name"].'</span>';
echo '<input type="text" class="tag_editbox" value="'.$row["name"].'" id="tag_edit_'.$row["id_tag"].'">';
echo '<div class="tag_del_wrapper"><a href="#" class="tag_del_button" id="tag_del-'.$row["id_tag"].'">';
echo '<img src="img/1.png" border="0" /></a>';
echo '<a href="#" class="tag_cor_button" id="tag_cor-'.$row["id_tag"].'">';
echo '<img src="pencil.png" id="img" border="0" /></a><input type="radio" name="nameOfTag" class="radioTag" value="'.$row["name"].'"></li>';
}

?>
      </div>
      <div class="modal-footer">
	   <button type="button"  id="tagsucces" class="btn btn-primary">Добавить</button>
        <button type="button" id="closeAddTable"  class="btn btn-secondary" data-dismiss="modal">Close</button>

      </div>
    </div>
  </div>
</div>

</div>
</div>
</div>
</div>


<?php
require_once("config.php");
$data = array(); 

$ta = mysql_query("select * from `leadertusk` ORDER BY `order`");
$x = 0;


while($row = mysql_fetch_assoc($ta)){ 
     $data[$x][id] =	$row['id'];                        
  $data[$x][remind] = $row['remind'];
  $data[$x][quest] = $row['quest'];

	$x++;
}

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
    console.log((quest.number[i].remind.getFullYear() +":"+quest.number[i].remind.getMonth()+":"+quest.number[i].remind.getDate()+":"+quest.number[i].remind.getHours()+":"+quest.number[i].remind.getMinutes()) == (now.getFullYear() +":"+now.getMonth()+":"+now.getDate()+":"+now.getHours()+":"+now.getMinutes()));
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
});
</script>
</html>


