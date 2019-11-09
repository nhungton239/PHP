<?php
class Book {
    var $id;
    var $title;
    var $price;
    var $author;
    var $year;
    

    public function __construct($id, $title, $price, $author, $year)
    {
        $this->id = $id;
        $this->title = $title;
        $this->price = $price;
        $this->author = $author;
        $this->year = $year;
    }

    static function get_data() {
        // use for file
        return $data = file("data/book.txt");
    }

    static function get_max_id() {
        // use for file
        $data = Book::get_data();
        $max_id = 1;
        foreach($data as $key => $value){
            $row = explode("#",$value);
            $id = (int)$row[0];
            if($id > $max_id) $max_id = $id;
        }
        return $max_id;
    }

    static function get_book_each_page() {
        return 25;
    }

    static function count_book() {
        // use for file
        $data = Book::get_data();
        $count = 0;;
        foreach($data as $key => $value){
            if (strlen($value) > 1) {
                $count += 1;
            }
        }
        return $count;
    }

    static function countBookFromDB() {
        $con = Book::connectToDB();
        $sql = "SELECT * FROM Book";
        $result = $con->query($sql);
        return $result->num_rows;
    }

    static function connectToDB() {
        $con = new mysqli("localhost:3308", "root", "", "BookManager");
        $con->set_charset("utf8");
        if($con->connect_error)
            die("Ket noi that bai khi tao moi. Chi tiet: " . $con->connect_error);
        return $con;
    }

    static function create($title, $price, $author, $year) {
        // use for file
        $id = Book::get_max_id() + 1;
        $data = file_get_contents("data/book.txt");
		$data .= "\n". $id. "#". $title . "#" . $price . "#" . $author . '#' . $year;
		file_put_contents("data/book.txt", $data);
    }

    static function createToDB($title, $price, $author, $year) {
        $con = Book::connectToDB();

        $sql = "INSERT INTO Book (Title, Price, Author, Year) VALUES ('$title', $price, '$author', $year)";
        $result = $con->query($sql);

        $con->close();
    }

    static function edit($id, $title, $price, $author, $year) {
        $id = (int)$id;
        $data = Book::get_data();
        $str_data = "";
        foreach($data as $key => $value){
            $row = explode("#",$value);
            $data_id = (int)$row[0]; 
            if( $id == $data_id) {
                if($key == sizeof($data) - 1)
                    $str_data .= $data_id. "#". $title . "#" . $price . "#" . $author . '#' . $year;
                else
                    $str_data .= $data_id. "#". $title . "#" . $price . "#" . $author . '#' . $year . "\n";
            }
            else {
                $str_data .= $value;
            }
        }
        file_put_contents("data/book.txt", $str_data);
    }

    static function editToDB($id, $title, $price, $author, $year) {
        $con = Book::connectToDB();
        
        $sql = "UPDATE Book SET Title = '$title', Price = $price, Author = '$author', Year = $year WHERE Book.ID = $id";
        $result = $con->query($sql);

        $con->close();
    }

    static function delete($id) {
        // use for file
        $id = (int)$id;
        $data = Book::get_data();
        $str_data = "";
        foreach($data as $key => $value){
            $row = explode("#",$value);
            $data_id = (int)$row[0]; 
            if( $id != $data_id) {
                $str_data .= $value;
            }
        }
        file_put_contents("data/book.txt", $str_data);
    }

    static function deleteToDB($id) {
        $con = Book::connectToDB();
        
        $sql = "DELETE FROM Book WHERE Book.ID = $id";
        $result = $con->query($sql);

        $con->close();
    }

    static function getList($search = null, $page = 1){
        // use for file
        $data = file("data/book.txt");
        $arrBook = [];
        foreach($data as $key => $value){
            if (strlen($value) > 1) {
                $row = explode("#",$value);
                if(
                    strlen(strstr($row[0],$search)) || strlen(strstr($row[3],$search)) ||
                    strlen(strstr($row[1],$search)) || strlen(strstr($row[4],$search)) ||
                    strlen(strstr($row[2],$search)) || $search == null
                )
                $arrBook[] = new Book($row[0], $row[1],$row[2],$row[3],$row[4]);
            }
        }
        $offset = Book::get_book_each_page() * ($page-1);
        return array_splice($arrBook, $offset, Book::get_book_each_page());
    }

    static function getListFromDB($search = null, $page = 1) {
        $con = Book::connectToDB();
        $sql = "";
        if($search != null) {
            $sql = "SELECT * FROM Book WHERE Title LIKE '%$search%' OR Author LIKE '%$search%' OR Price = '$search' OR Year = '$search'";
        }
        else {
            $sql = "SELECT * FROM Book";
        }
        
        $result = $con->query($sql);
        $arrBook = [];
        if($result->num_rows > 0) {
            while($row = $result->fetch_assoc()){
                $book = new Book($row["ID"], $row["Title"],$row["Price"],$row["Author"],$row["Year"]);
                array_push($arrBook, $book);
            }
        }

        $con->close();

        $offset = Book::get_book_each_page() * ($page-1);
        return array_splice($arrBook, $offset, Book::get_book_each_page());
    }
}