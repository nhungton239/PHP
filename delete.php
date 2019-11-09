<?php
    include_once("model/danhba.php");
    $id = $_REQUEST["id"];
    DanhBa::deleteDB($id);
?>