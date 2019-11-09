<?php 
class User {
    var $id;
    var $userName;
    var $passWord;
    var $fullName;

    function User($id, $userName, $passWord, $fullName) {
        $this->userName = $userName;
        $this->passWord = $passWord;
        $this->fullName = $fullName;
        $this->id = $id;
    }

    static function connectToDB() {
        $con = new mysqli("localhost", "root", "", "Contact");
        $con->set_charset("utf8");
        if($con->connect_error)
            die("Ket noi that bai khi tao moi. Chi tiet: " . $con->connect_error);
        return $con;
    }


    /**
     * Xac thuc nguoi su dung
     * @param $userName string Ten dang nhap
     * @param $passWord string Mat khau
     * @return User hoac null 
     */
    static function authentication($userName, $passWord) {
        $con = User::connectToDB();

        $sql = "SELECT * FROM User WHERE User.UserName = '$userName' AND User.PassWord = '$passWord'";
        $result = $con->query($sql);
        if($result->num_rows > 0) {
            while($row = $result->fetch_assoc()){
                $user = new User($row["ID"], $row["UserName"],$row["PassWord"],$row["FullName"]);
                return $user;
            }
        }
        $con->close();
    }
}
?>