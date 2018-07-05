<?php
include_once("config.php");
if (isset($_POST['item'])) {


    $arrayItems = $_POST['item'];
    $order = 0;


        foreach ($arrayItems as $item) {
            mysql_query ("UPDATE `leadertusk` SET `order`='".$order."' WHERE `id` = '".$item."'");
           
            $order++;
        }

    echo 'Сохранено!';

}
?>