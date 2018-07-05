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
						
                   $('div#file-'+DbNumberID).append("<a href='upload/"+fileName+"' download>"+fileName+"</a>");

                }
     });

	}
	else{
		alert("Ваш файл весит: "+filesize+" байт, а должен не превышать 5242880 байт!");
	}

});
});

</script>
<?php

//подключаем конфигурационный файл бд
include_once("config.php");

//провер¤ем $_POST["content_txt"] на пустое значение
if(isset($_POST["content_txt"]) && strlen($_POST["content_txt"])>0)
{


    $contentToSave = filter_var($_POST["content_txt"]);


    // Insert sanitize string in record
    if(mysql_query("INSERT INTO `leadertusk`(`id`,`quest`,`order`) VALUES(NULL,'".$contentToSave."',NULL)"))
    { 
     
        //Record is successfully inserted, respond to ajax re`quest`
$my_id = mysql_insert_id(); //Get ID of last inserted record from MySQL
echo '<li id="item-'.$my_id.'" class="list-group-item" ><strong><span class="jack" id="jack_'.$my_id.'">'.$contentToSave.'</span></strong>';
echo '<input type="text" class="editbox" value="'.$contentToSave.'"id="edit_'.$my_id.'">';
echo '<div class="del_wrapper"><a href="#" class="del_button" id="del-'.$my_id.'">';
echo '<img src="1.png" border="0" /></a>';
echo '<a href="#" class="cor_button" id="cor-'.$my_id.'">';
echo '<img src="pencil.png" id="img" border="0" /></a>';
echo '<a href="#" class="download" id="download-'.$my_id.'"><img src="download.png"  border="0" id="img" data-toggle="modal" data-target="#myModal-'.$my_id.'"> 
<div id="myModal-'.$my_id.'" class="modal fade">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header"><button class="close" type="button" data-dismiss="modal">×</button>
<h4 class="modal-title">Загрузить файл </h4>
</div>
<div class="modal-body"><input id="sortpicture-'.$my_id.'" type="file" name="sortpic" />
<br>
<button  class="upload" id="upload-'.$my_id.'">Загрузить</button>
<div class="ajax-respond"></div></div>
<div class="modal-footer"><button class="btn btn-default" type="button" data-dismiss="modal">Закрыть</button></div>
</div>
</div>
</div>
</a></div><hr>';
$res =mysql_query("SELECT count(*) FROM `table1` where id_quest = '".$my_id."'");
if ($res !=0){
	

echo '<br>Приложение: <div id="file-'.$my_id.'">';
$low = mysql_query("SELECT * FROM `table1` where id_quest = '".$my_id."'");

while($row = mysql_fetch_array($low)){

echo '<div id="file_src-'.$row["id"].'"><a href="upload/'.$row["filename"].'" id="url-'.$row["id"].'" download>'.$row["filename"].'<a href="#" class="del_file_button" id="delfile-'.$row["id"].'"> ×</a>
</a></<br></div>';	

}
echo '
</div></li>';
}
elseif($res==0){
	echo '</li>';
}




		mysql_query("UPDATE `leadertusk` SET `order` = '".$my_id."' WHERE `quest` = '".$contentToSave."'");//Ордер приравниваем к id 
        mysql_close($connecDB);

    }else{
        //вывод ошибки

        //header('HTTP/1.1 500 '.mysql_error());
        header('HTTP/1.1 500 Looks like mysql error, could not insert record!');
        exit();
    }

}
elseif(isset($_POST["recordToDelete"]) && strlen($_POST["recordToDelete"])>0 && is_numeric($_POST["recordToDelete"]))
{//do we have a delete re`quest`? $_POST["recordToDelete"]

    // очищаем значение переменной, PHP фильтр FILTER_SANITIZE_NUMBER_INT
    // ”дал¤ет все символы, кроме цифр и знаков плюса и минуса

    $idToDelete = filter_var($_POST["recordToDelete"],FILTER_SANITIZE_NUMBER_INT);

    //try deleting record using the record ID we received from POST
    if(!mysql_query("DELETE FROM `leadertusk` WHERE `id`=".$idToDelete))
    {
        //If mysql delete record was unsuccessful, output error
        header('HTTP/1.1 500 Could not delete record!');
        exit();
    }
    mysql_close($connecDB);

}

if(isset($_POST["news"])&& isset($_POST["id"])){
	$news=$_POST["news"];
    $id= $_POST["id"];
	mysql_query("UPDATE `leadertusk` SET `quest` ='".$news."'  where `id`='".$id."'");
}

elseif(isset($_POST["recordToDeleteFile"]) && strlen($_POST["recordToDeleteFile"])>0 && is_numeric($_POST["recordToDeleteFile"])){
	$idToDeleteFile = filter_var($_POST["recordToDeleteFile"],FILTER_SANITIZE_NUMBER_INT);

    //try deleting record using the record ID we received from POST
    if(!mysql_query("DELETE FROM `table1` WHERE `id`=".$idToDeleteFile))
    {
        //If mysql delete record was unsuccessful, output error
        header('HTTP/1.1 500 Could not delete record!');
        exit();
    }
    mysql_close($connecDB);

}
elseif(isset($_POST["remind"]) && (isset($_POST["id-time"]))){

    mysql_query("UPDATE `leadertusk` set `remind` = '".$_POST["remind"]."' WHERE `id` ='".$_POST["id-time"]."' ");
}
	


?>
