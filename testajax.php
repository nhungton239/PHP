<?php
include_once('model/user.php');
include_once('model/book.php');
// $userName = $_REQUEST["username"];
// $user = new User($userName, "123", "Duc Phuc");
// echo json_encode($user);
$books = Book::getList(null, 2);
echo json_encode($books);
?>