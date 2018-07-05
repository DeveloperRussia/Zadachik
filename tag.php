 <script type="text/javascript" src="scripts/modal.js"></script>      
<?php
include_once("config.php");

if(isset($_POST["tag_text"])){
 $text = $_POST["tag_text"];
 $color = $_POST["color"];
 
 if(mysql_query("INSERT INTO `tag`(`id_tag`,`name`,`id_quest`, `color`) VALUES (NULL,'".$text."',NULL,'".$color."' )")){
	 $my_id = mysql_insert_id(); //Get ID of last inserted record from MySQL
echo '<li style="background-color:'.$color.';"  id="tag_item-'.$my_id.'" class="list-group-item" ><span class="tag_jack" id="tag_jack_'.$my_id.'" >'.$text.'</span>';
echo '<input type="tag_text" class="tag_editbox" value="'.$text.'"id="tag_edit_'.$my_id.'">';
echo '<div class="tag_del_wrapper"><a href="#" class="tag_del_button" id="tag_del-'.$my_id.'">';
echo '<img src="1.png" border="0" /></a>';
echo '<a href="#" class="tag_cor_button" id="tag_cor-'.$my_id.'">';
echo '<img src="pencil.png" id="img" border="0" /></a></li>';

 }
 else{
        //вывод ошибки

        //header('HTTP/1.1 500 '.mysql_error());
        header('HTTP/1.1 500 Looks like mysql error, could not insert record!');
        exit();
    }
 
}
elseif(isset($_POST["tagRecordToDelete"]) && strlen($_POST["tagRecordToDelete"])>0 && is_numeric($_POST["tagRecordToDelete"]))
{//do we have a delete re`quest`? $_POST["recordToDelete"]

    // очищаем значение переменной, PHP фильтр FILTER_SANITIZE_NUMBER_INT
    // ”дал¤ет все символы, кроме цифр и знаков плюса и минуса

    $idToDelete = filter_var($_POST["tagRecordToDelete"],FILTER_SANITIZE_NUMBER_INT);

    //try deleting record using the record ID we received from POST
    if(!mysql_query("DELETE FROM `tag` WHERE `id_tag`=".$idToDelete))
    {
        //If mysql delete record was unsuccessful, output error
        header('HTTP/1.1 500 Could not delete record!');
        exit();
    }


}
if(isset($_POST["news"])&& isset($_POST["id"])){
	$news=$_POST["news"];
    $id= $_POST["id"];
	mysql_query("UPDATE `tag` SET `name` ='".$news."'  where `id_tag`='".$id."'");
	if(!mysql_query("UPDATE `tag` SET `name` ='".$news."'  where `id_tag`='".$id."'")){
		 header('HTTP/1.1 500 Could not update !');
        exit();
		
	}
}
if(isset($_POST["tag"])&& isset($_POST["id_tag"])){
	
		mysql_query("UPDATE `tag` SET `id_quest`= '".$_POST["id_tag"]."'  where `name`='".$_POST["tag"]."'");
}
elseif(isset($_POST["QuestTagRecordToDelete"]) && strlen($_POST["QuestTagRecordToDelete"])>0 && is_numeric($_POST["QuestTagRecordToDelete"]))
{//do we have a delete re`quest`? $_POST["recordToDelete"]

    // очищаем значение переменной, PHP фильтр FILTER_SANITIZE_NUMBER_INT
    // ”дал¤ет все символы, кроме цифр и знаков плюса и минуса

    $idToDeleteTag = filter_var($_POST["QuestTagRecordToDelete"],FILTER_SANITIZE_NUMBER_INT);

    //try deleting record using the record ID we received from POST
    if(!mysql_query("UPDATE `tag` set `id_quest`= NULL where `id_quest` =  ".$idToDeleteTag))
    {
        //If mysql delete record was unsuccessful, output error
        header('HTTP/1.1 500 Could not delete record!');
        exit();
    }
}
?>