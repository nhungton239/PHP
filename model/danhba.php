<?php
    class DanhBa{
        var $id;
        var $name;
        var $email;
        var $phone;
        function __construct($id, $name , $email ,$phone)
        {
            $this->id = $id;
            $this->name = $name;
            $this->email = $email;
            $this->phone = $phone;
        }
        static function connect(){
            $con = new  mysqli("localhost","root","","danhba");
            $con->set_charset("utf8");//hướng đối tượng
            if($con->connect_error)
                die("kết nối thất bại. Chi tiết:".$con->connect_error);
            return $con;
        }
        static function getListFromDB(){
            
            $con = DanhBa::connect();
            //b2: thao tác với csdl : CRUD
            $sql = "SELECT * FROM DanhBa";
            
            $result =  $con->query($sql);
            $ds = array();
            
            if($result->num_rows > 0){
                while ($row = $result->fetch_assoc()) {//biên nó thành 1 mảng kết hợp
                    $thongtin = new DanhBa($row["ID"],$row["Name"],$row["Email"],$row["Phone"]);
                    array_push($ds,$thongtin);
                }
            }
            //b3 : đóng kết nối
            $con->close();
            //echo "<h4>kết nối thành công<h4>";
            return $ds;
        }
        static function addToDB($content)
        {
            $con = DanhBa::connect();
            $sql="INSERT INTO `DanhBa`( `Name`, `Email`, `Phone`) VALUES ('$content[0]','$content[1]','$content[2]')";
        // $result =  $con->query($sql);
            if (mysqli_query($con, $sql)) {
                echo "<script type='text/javascript'>alert('Thêm Thành công');</script>";
            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($con);
            }
            //b3 : đóng kết nối
            $con->close();
        }
        static function editDB($content){
            $con = DanhBa::connect();
            $sql="UPDATE `DanhBa` SET `Name`='$content[1]',`Email`='$content[2]',`Phone`='$content[3]'WHERE ID='$content[0]'";
            if (mysqli_query($con, $sql)) {
                //echo "New record created successfully";
            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($con);
            }
            $con->close();
        }
        static function deleteDB($id){
            $con = DanhBa::connect();
            $sql="DELETE FROM `DanhBa` WHERE ID = '$id'";
            if (mysqli_query($con, $sql)) {
                //echo "New record created successfully";
            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($con);
            }
            //b3 : đóng kết nối
            $con->close();
        }
        static function getSearch($search = null){
            $con = DanhBa::connect();
            
            $sql="SELECT * FROM Danhba where Name like N'%$search%' or Email like '%$search%' or Phone like '%$search%' ";
            $result =  $con->query($sql);
            $ds = array();
            
            if($result->num_rows > 0){
                while ($row = $result->fetch_assoc()) {//biên nó thành 1 mảng kết hợp
                    $thongtin = new DanhBa($row["ID"],$row["Name"],$row["Email"],$row["Phone"]);
                    array_push($ds,$thongtin);
                }
            }
            $con->close();
            return $ds;
        }
    }
?>
