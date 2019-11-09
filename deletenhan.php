<?php
    include_once("model/nhan.php");
    //var_dump($_GET);
    $id = $_REQUEST["id"];
    $idlable = $_REQUEST["idlable"];
    Nhan::deletenhan($id,$idlable);
?>