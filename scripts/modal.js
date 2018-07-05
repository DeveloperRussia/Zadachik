$(document).ready(function() { 
 $("#addTag1").click(function (e) {

        e.preventDefault();
		

        if($("input#textTag").val()==="") //simple validation
        {
            alert("Введите текст!");
            return false;
        }

        var myData = $("input#textTag").val(); //post variables
		var color = $("select#exampleFormControlSelect1").val();

        jQuery.ajax({
            type: "POST", // HTTP метод  POST или GET
            url: "tag.php", //url-адрес, по которому будет отправлен запрос
            dataType:"text", // Тип данных,  которые пришлет сервер в ответ на запрос ,например, HTML, json
            data:{"tag_text":myData ,"color":color }, //данные, которые будут отправлены на сервер (post переменные)
            success:function(tag){
            $("div#moreTag").append(tag);
            $("#textTag").val(''); //очищаем текстовое поле после успешной вставки
            },
            error:function (xhr, ajaxOptions, thrownError){
                alert(thrownError); //выводим ошибку
            }
        });
    });
	$("body").on("click", ".tag_del_button", function(e) {
        e.preventDefault();
        var clickedID = this.id.split("-"); //Разбиваем строку (Split работает аналогично PHP explode)
        var DbNumberID = clickedID[1]; //и получаем номер из массива
        var myData = 'tagRecordToDelete='+ DbNumberID; //выстраиваем  данные для POST

        jQuery.ajax({
            type: "POST", // HTTP метод  POST или GET
            url: "tag.php", //url-адрес, по которому будет отправлен запрос
            dataType:"text", // Тип данных
            data:myData, //post переменные
            success:function(response){
            // в случае успеха, скрываем, выбранный пользователем для удаления, элемент
            $('#tag_item-'+DbNumberID).fadeOut("slow");
            },
            error:function (xhr, ajaxOptions, thrownError){
                //выводим ошибку
                alert(thrownError);
            }
        });
    });
	$("a.tag_cor_button").click(function (e) {
        var clickedID = this.id.split("-"); //Разбиваем строку (Split работает аналогично PHP explode)
        var DbNumberID = clickedID[1]; //и получаем номер из массива
        
        $("#tag_jack_"+DbNumberID).hide()//Строка с текстом прячется при нажатии на карандаш
		$("#tag_edit_"+DbNumberID).show();//спрятанная (display: none) строка input "text" появляется
		$("#tag_edit_"+DbNumberID).focus();
		
    
$(".tag_editbox").on("change",function(e)
{


var news=$("#tag_edit_"+DbNumberID).val(); 
 
if(news ==="") //simple validation
{
            alert("Введите текст!");
            return false;
}else{
	jQuery.ajax({
            type: "POST", // HTTP метод  POST или GET
            url: "tag.php", //url-адрес, по которому будет отправлен запрос
            dataType:"text", // Тип данных,  которые пришлет сервер в ответ на запрос ,например, HTML, json
            data: { "news": news,"id": DbNumberID}, //данные, которые будут отправлены на сервер (post переменные)
            success:function(response){
            $("#tag_jack_"+DbNumberID).html(news);
            e.stopImmediatePropagation();
            },
            error:function (xhr, ajaxOptions, thrownError){
                alert(thrownError); //выводим ошибку
            }
        });
		}
});});
	$(".tag_editbox").on("mouseup",function(e)
{
e.stopImmediatePropagation();
});

// Outside click action
$(document).mouseup(function()// если кликнуть по документу строка редактирования скрывается
{

$(".tag_editbox").hide();
$(".tag_jack").show();
});

	$("body").on("click", ".del_tag_from_quest", function(e) {
        e.preventDefault();
        var clickedID = this.id.split("-"); //Разбиваем строку (Split работает аналогично PHP explode)
        var DbNumberID = clickedID[1]; //и получаем номер из массива
        var myData = 'QuestTagRecordToDelete='+ DbNumberID; //выстраиваем  данные для POST

        jQuery.ajax({
            type: "POST", // HTTP метод  POST или GET
            url: "tag.php", //url-адрес, по которому будет отправлен запрос
            dataType:"text", // Тип данных
            data:myData, //post переменные
            success:function(tag){
       
            $("#tagDivDel-"+DbNumberID).fadeOut("slow");
		
            },
            error:function (xhr, ajaxOptions, thrownError){
                //выводим ошибку
                alert(thrownError);
            }
        });
    });
	});