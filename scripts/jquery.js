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
    $("body").on("click", "#responds .del_button", function(e) {
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
 
	
    $.ajax({
                url: 'upload.php',
                dataType: 'text',
                cache: false,
                contentType: false,
                processData: false,
	            data: form_data,
                type: 'post',
                        success: function(php_script_response){
					alert("Файл успешно загружен!");	
                    $('div#file-'+DbNumberID).append("<a href='upload/"+fileName+"' download>"+fileName+"</a>");

                }
     });



});
});
