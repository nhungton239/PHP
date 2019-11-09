<?php
class Nhan
{
    var $id;
    var $idlable;
    function __construct($id, $idlable)
    {
        $this->id = $id;
        $this->idlable = $idlable;
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
        $sql = "SELECT * FROM `danhba_lable`";

        $result =  $con->query($sql);
        $ds = array();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) { //biên nó thành 1 mảng kết hợp
                $thongtin = new Lable($row["ID"], $row["IDLable"]);
                array_push($ds, $thongtin);
            }
        }
        //b3 : đóng kết nối
        $con->close();
        //echo "<h4>kết nối thành công<h4>".count($ds);
        return $ds;
    }
    static function addToDB($id,$content)
    {
        //$con = Lable::connect();
        //$n= count($content);

        foreach($content as $value)
        {
            $con = Lable::connect();
            //echo $key."-------------------------";
            $sql = "INSERT INTO `DanhBa_Lable`(`ID`,`IDLable`) VALUES ('$id','$value')";
            //$result =  $con->query($sql);
            if (mysqli_query($con, $sql)) {
                //echo "ok";
            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($con);
            }
            $con->close();
        }
        
    }
    static function deletenhan($id,$idlable)
    {
        $con = Nhan::connect();
        echo "-------".$id.":".$idlable;
        //$n= count($content);
        $sql="DELETE FROM `DanhBa_Lable` WHERE ID = $id and IDLable = $idlable";
        if (mysqli_query($con, $sql)) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($con);
        }
        //b3 : đóng kết nối
        $con->close();
        
        
    }
    static function getListLableDanhBaDB($idLable)
    {

        $con = Nhan::connect();
        //b2: thao tác với csdl : CRUD
        //$sql = "SELECT * FROM DanhBa_Lable WHERE IDLable = $idLable";
        $sql = "SELECT * FROM `danhba` INNER JOIN`danhba_lable` ON danhba.ID =danhba_lable.ID INNER JOIN `lable` ON danhba_lable.IDLable=lable.ID WHERE IDLable = $idLable";
        $result =  $con->query($sql);
        $ds = array();

        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) { //biên nó thành 1 mảng kết hợp
                $thongtin = new info($row["ID"],$row["Name"],$row["Email"],$row["Phone"],$row["IDLable"]);
                array_push($ds, $thongtin);
            }
        }
        //else  echo "<h4>deo ra<h4>";
        //b3 : đóng kết nối
        $con->close();
       // $size = count($ds);
        //echo "<h4>kết nối thành công<h4>".$size;
        return $ds;
    }
}
class info{
    var $id;
    var $name;
    var $email;
    var $phone;
    var $idlable;
    function __construct($id,$name,$email, $phone, $idlable)
    {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->phone = $phone;
        $this->idlable = $idlable;
    }
}
