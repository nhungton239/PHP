<?php
class Lable
{
    var $id;
    var $name;
    function __construct($id, $name)
    {
        $this->id = $id;
        $this->name = $name;
    }
    static function connect()
    {
        $con = new  mysqli("localhost", "root", "", "danhba");
        $con->set_charset("utf8"); //hướng đối tượng
        if ($con->connect_error)
            die("kết nối thất bại. Chi tiết:" . $con->connect_error);
        return $con;
    }
    static function getListLableDB()
    {
        $con = Lable::connect();
        //b2: thao tác với csdl : CRUD
        $sql = "SELECT * FROM Lable";
        $result =  $con->query($sql);
        $ds = array();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) { //biên nó thành 1 mảng kết hợp
                $thongtin = new Lable($row["ID"], $row["Lable"]);
                array_push($ds, $thongtin);
            }
        }
        //b3 : đóng kết nối
        $con->close();
        //echo "<h4>kết nối thành công<h4>";
        return $ds;
    }
    static function addToDB($content)
    {
        $con = Lable::connect();
        $sql = "INSERT INTO `Lable`(`Lable`) VALUES ('$content')";
        
        if (mysqli_query($con, $sql)) {
            echo "<script type='text/javascript'>alert('Thêm Thành công');</script>";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($con);
        }
        //b3 : đóng kết nối
        $con->close();
    }
}
?>