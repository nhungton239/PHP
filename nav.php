<?php
    session_start();
    include_once("model/user.php");
    include_once("model/lable.php");
    include_once("model/nhan.php");
    if (!isset($_SESSION["user"]))
        header("location:login.php");
    $user = unserialize($_SESSION["user"]);

    include_once("model/danhba.php");
    //edit danh bạ
    if (isset($_REQUEST["editdanhba"])) {
        $id    = $_REQUEST["id"];
        $name = $_REQUEST["name"];
        $email = $_REQUEST["email"];
        $phone = $_REQUEST["phone"];

        $content =  array();
        array_push($content, $id);
        array_push($content, $name);
        array_push($content, $email);
        array_push($content, $phone);

        DanhBa::editDB($content);
    }
    ///add danh ba
    if (isset($_REQUEST["adddanhba"])) {

        $name = $_REQUEST["name"];
        $email = $_REQUEST["email"];
        $phone = $_REQUEST["phone"];

        $content =  array();
        array_push($content, $name);
        array_push($content, $email);
        array_push($content, $phone);

        DanhBa::addToDB($content);
    }
    //add sdt vào nhãn
    if (isset($_REQUEST["adddanhba-nhan"])) {
        //if($_SERVER['$_REQUEST_'])
        $id = $_REQUEST["ide"];
        $idlable = $_POST["idlable"];
        //print_r($_POST);
        //echo $idlable."<br/>";
        $content =  array();
        foreach($idlable as $value) {
            //Xử lý các phần tử được chọn
           //echo $value."<br/>";
           array_push($content,$value);
        }
        //array_push($content, $name);

        Nhan::addToDB($id,$content);
    }
    
    //add nhãn
    if (isset($_REQUEST["addNhan"])) {
        $name = $_REQUEST["name2"];
        Lable::addToDB($name);
    }
    
    //nhãn
    if (isset($_REQUEST["Nhan"])) {
        $a = $_REQUEST["Nhan"];
    }
    //tìm kiếm
    $keyWord = null;
    if (isset($_REQUEST["search"])) {
        $keyWord = $_REQUEST["search"];
    }
    include_once("model/danhba.php");
    $lsFromFile = DanhBa::getSearch($keyWord);
    if ($keyWord != "") {
        if ($lsFromFile != null) {
            $lsFromDB = DanhBa::getSearch($keyWord);
        } else {
            $lsFromDB = DanhBa::getSearch($keyWord);
        }
    } else {
        $lsFromDB = DanhBa::getListFromDB();
    }
    $lslable = Lable::getListLableDB();
    //xem ds nhan
    if(isset($_REQUEST["action"])){
        if(strcmp($_REQUEST["action"],"ds")==0){
            $a =$_REQUEST["id"];
            $lsFromDB= Nhan::getListLableDanhBaDB($a);
        }
    } 
    ?>
 <nav class="navbar navbar-expand navbar-dark bg-dark static-top">
     <button class="btn btn-link btn-sm text-white order-1 order-sm-0" id="sidebarToggle" href="#">
         <i class="fas fa-bars"></i>
     </button>
     <div class="col-md-3">
         <img src="uploads/contact.png" alt="1" style="width: 40px;height: 40px;">
         <span style="color: white;"><a href="indextt.php" style="color: white;">danh bạ</a></span>
     </div>
     <!-- Navbar Search -->
     <form class="d-md-inline-block form-inline" style="width: 700px;">
         <div class="input-group">
             <input type="text" name="search" id="search" value="<?php echo $keyWord; ?>" class="form-control" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
             <div class="input-group-append">
                 <button class="btn btn-primary" type="submit">
                     <i class="fas fa-search"></i>
                 </button>
             </div>
         </div>
     </form>
     <!-- <a href="" style="margin-left: 55px;" class="nav-link text-white px-md-4"><?php echo "Xin chào! " . $user->fullName ?></a> -->
     <!-- Navbar -->
     <ul class="navbar-nav ml-auto" style="float: right;">
         <li class="nav-item dropdown no-arrow">
             <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                 <i class="fas fa-user-circle fa-fw"></i>
             </a>
             <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                 <a class="dropdown-item" href="#"><?php echo "Xin chào! " . $user->fullName ?></a>
                 <div class="dropdown-divider"></div>
                 <a class="dropdown-item" href="logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a>
             </div>
         </li>
     </ul>

 </nav>
 <div id="wrapper">

     <!-- Sidebar -->
     <ul class="sidebar  list-group nav nav-pills">
         <li class="nav-item active">
             <button class="nav-link btn btn-default" data-toggle="modal" data-target="#addModal">
                 <!-- <img src="img/add2.png" alt=""> -->
                 <i class="fas fa-plus-circle"></i>
                 <span>Thêm Liên hệ</span>
             </button>
         </li>
         <li class="nav nav-item">
             <a class="nav-link" href="indextt.php">
                 <i class="fas fa-user-circle fa-fw"></i>
                 Danh bạ<span class="badge" style="float: right; background: blue;color: white"><?php echo count(DanhBa::getListFromDB()) ?></span>
             </a>
         </li>
         <!-- <li class="nav-item">
             <a class="nav-link" href="">
                 <i class="fas fa-fw fa-chart-area"></i>
                 <span>Thường xuyên liên hệ<span class="badge" style="float: right; background: blue;color: white;ra">3</span></span></a>
         </li>
         <li class="nav-item">
             <a class="nav-link" href="">
                 <i class="fas fa-fw fa-chart-area"></i>
                 <span>Liên hệ trùng lặp<span class="badge" style="float: right; background: blue;color: white;ra">3</span></span></a>
         </li> -->
         <div class="dropdown-divider"></div>
         <li class="nav nav-item">
             <a class="nav-link "  href="#">Nhãn&nbsp&nbsp<i class="fa fa-angle-down rotate-icon"></i></a>
             <div class="" style="width: 230px;border: none;background-color: #212529;">
                 <ul class="nav nav-item">
                     <?php
                        foreach ($lslable as $key => $value) {
                            $size = Nhan::getListLableDanhBaDB($value->id);
                            //echo count($size) ."------".$value->id;
                            ?>
                         <li>
                             <a class="nav-link text-white" href="indextt.php?action=ds&&id=<?php echo $value->id?>"><i class="fas fa-tag"></i>
                                 <span>&nbsp&nbsp<?php echo $value->name ?></span>
                                 <!-- <i class="fas fa-pen"></i>&nbsp&nbsp&nbsp<i class="fas fa-trash"></i> -->
                                 <span class="badge" style="float: right; background: blue;color: white;"><?php echo count($size); ?></span></a>
                        </li>
                     <?php } ?>
                 </ul>
             </div>
         </li>
         <li class="nav-item">
             <a class="nav-link" href="" id="addNhan" data-toggle="modal" data-target="#addModalNhan">
                 <i class="fas fa-plus-circle"></i>
                 <span>Tạo nhãn</span></a>
         </li>
     </ul>
     <!-- modal tạo nhãn -->
     <form action="indextt.php" method="post">
         <div class="modal fade" id="addModalNhan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
             <div class="modal-dialog" role="document">
                 <div class="modal-content">
                     <div class="modal-header">
                         <h5 class="modal-title" id="exampleModalLabel">Tạo Nhãn</h5>
                         <button type="submit" class="close" data-dismiss="modal" aria-label="Close">
                             <span aria-hidden="true">&times;</span>
                         </button>
                     </div>
                     <div class="modal-body">
                         <fieldset>
                             <div class="form-group d-flex">
                                 <label class="pt-1 col-md-3 control-label" for="name">Tên Nhãn:</label>
                                 <div class="col-md-9">
                                     <input id="name2" name="name2" type="text" placeholder="Name" class="form-control input-md">
                                 </div>
                             </div>
                         </fieldset>
                     </div>
                     <div class="modal-footer">
                         <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                         <button type="submit" name="addNhan" class="btn btn-primary">Save changes</button>
                     </div>
                 </div>
             </div>
         </div>
     </form>
     <!-- modal thêm-->
     <form action="indextt.php" method="post">
         <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
             <div class="modal-dialog" role="document">
                 <div class="modal-content">
                     <div class="modal-header">
                         <h5 class="modal-title" id="exampleModalLabel">Thêm</h5>
                         <button type="submit" class="close" data-dismiss="modal" aria-label="Close">
                             <span aria-hidden="true">&times;</span>
                         </button>
                     </div>
                     <div class="modal-body">
                         <fieldset>
                             <div class="form-group d-flex">
                                 <label class="pt-1 col-md-2 control-label" for="Title">Tên</label>
                                 <div class="col-md-10">
                                     <input id="name" name="name" type="text" placeholder="Name" class="form-control input-md">
                                 </div>
                             </div>
                             <div class="form-group d-flex">
                                 <label class="pt-1 col-md-2 control-label" for="Title">Email</label>
                                 <div class="col-md-10">
                                     <input id="email" name="email" type="text" placeholder="Email" class="form-control input-md">
                                 </div>
                             </div>
                             <div class="form-group d-flex">
                                 <label class="pt-1 col-md-2 control-label" for="Year">Phone</label>
                                 <div class="col-md-10">
                                     <input type="text" id="phone" name="phone" placeholder="Phone" class="form-control input-md">
                                 </div>
                             </div>
                         </fieldset>
                     </div>
                     <div class="modal-footer">
                         <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                         <button type="submit" name="adddanhba" class="btn btn-primary">Save changes</button>
                     </div>
                 </div>
             </div>
         </div>
     </form>
     <div id="content-wrapper" style="background-color: #f8f9fa;">

         <div class="container-fluid">