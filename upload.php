<?php
include_once ("config.php");


    if ( 0 < $_FILES['file']['error'] ) {
        echo 'Error: ' . $_FILES['file']['error'] . '<br>';
    }
    elseif($_FILES['file']['size'] < 5242880) {
        move_uploaded_file($_FILES['file']['tmp_name'], 'upload/' . $_FILES['file']['name']);
		$result = mysql_query("insert into `table1` (`id`, `id_quest`, `order`, `filename`, `filebody`) values (null,'".$_POST['DbNumberID']."',null,'". $_FILES['file']['name']."','".$_FILES['file']['type']."') ");
		if (!$result) {
    die('Неверный запрос: ' . mysql_error());
}
    }
	else{
		
	echo	'<script type="text/javascript">
		alert("Файл не должен превышать 5mb!");
		</script>';
	}
	
?>