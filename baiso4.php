<?php
    session_start(); // luon o tren cung
    if(!isset($_SESSION["user"])) {
      header("location:login.php");
    }
    include_once('model/user.php');
    $current_user = unserialize($_SESSION["user"]); 
    include_once('header.php');
    include_once('nav.php');
    include_once('model/book.php');
  

	if(isset($_POST['create'])) {
    //Book::create($_REQUEST["title"], $_REQUEST["price"], $_REQUEST["author"], $_REQUEST["year"]);
    Book::createToDB($_REQUEST["title"], $_REQUEST["price"], $_REQUEST["author"], $_REQUEST["year"]);
	}
	else {

    }
    
    if(isset($_POST['edit'])) {
      //Book::edit($_REQUEST["title"], $_REQUEST["price"], $_REQUEST["author"], $_REQUEST["year"]);
      Book::editToDB($_REQUEST["id"], $_REQUEST["title"], $_REQUEST["price"], $_REQUEST["author"], $_REQUEST["year"]);
	}
	else {

	}

	if(isset($_REQUEST['delete'])) {
    //Book::delete($_REQUEST['delete']);
    Book::deleteToDB($_REQUEST['delete']);
	}
	else {
		
	}

  //$countBooks = Book::count_book();
  $countBooks = Book::countBookFromDB();
  $book_each_page = Book::get_book_each_page();
  $total_page = 0;
  if($countBooks %  $book_each_page == 0) {
    $total_page = $countBooks /  $book_each_page;
  }
  else {
    $total_page = $countBooks /  $book_each_page + 1;
  }
  $page = 1;
  if(isset($_REQUEST['page'])) {
    $page = $_REQUEST['page'];
  }

	if(strpos($_SERVER['REQUEST_URI'], "search"))
    //$books = Book::getList($_REQUEST['search'], $page);
    $lsFromDB = Book::getListFromDB($_REQUEST['search'], $page);
	else {
    //$books = Book::getList(null,  $page);
    $lsFromDB = Book::getListFromDB(null,  $page);
  }
?>
<div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
	<form action="" method="post">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">New</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
		
			<div class="form-group">
			<label for="class">Title</label>
			<input name="title" type="text" class="form-control" id="class" placeholder="Ten sach">
			</div>
			<div class="form-group">
			<label for="place">Price</label>
			<input name="price" type="number" class="form-control" id="place" placeholder="Gia sach">
			</div>
			<div class="form-group">
			<label for="class">Author</label>
			<input name="author" type="text" class="form-control" id="class" placeholder="Tac gia">
			</div>
			<div class="form-group">
			<label for="class">Year</label>
			<input name="year" type="number" class="form-control" id="class" placeholder="Nam xuat ban">
			</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button name="create" id="btn-create" type="submit" class="btn btn-primary">Create</button>
      </div>
	</form>
    </div>
  </div>
</div>

<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
	<form action="" method="post">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">New</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <input name="id" type="hidden" class="form-control" id="hidden-id" value="">
			<div class="form-group">
			<label for="class">Title</label>
			<input name="title" type="text" class="form-control" id="e-title" placeholder="Ten sach">
			</div>
			<div class="form-group">
			<label for="place">Price</label>
			<input name="price" type="number" class="form-control" id="e-price" placeholder="Gia sach">
			</div>
			<div class="form-group">
			<label for="class">Author</label>
			<input name="author" type="text" class="form-control" id="e-author" placeholder="Tac gia">
			</div>
			<div class="form-group">
			<label for="class">Year</label>
			<input name="year" type="number" class="form-control" id="e-year" placeholder="Nam xuat ban">
			</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button name="edit" id="btn-edit" type="submit" class="btn btn-primary" value="true">Update</button>
      </div>
	</form>
    </div>
  </div>
</div>

<div class="container pt-5">
    <div class="alert alert-info alert-dismissible fade show" role="alert">
      Chào bạn: <strong><?php echo $current_user->fullName; ?></strong> 
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <button data-toggle="modal" data-target="#createModal" class="btn btn-outline-info float-right"><i class="fas fa-plus-circle"></i> Thêm</button>
    <form action="" method="GET">
        <div class="form-group">
            <input class="form-control" name="search"  style="max-width: 200px; display:inline-block;" placeholder="Search">
            <button type="submit" class="btn btn-default" style="margin-left:-50px"><i class="fas fa-search"></i></button>
        </div>
    </form>
    <table class="table mt-5">
        <thead class="thead-dark">
            <tr>
                <th>STT</th>
                <th>Title</th>
                <th>Price</th>
                <th>Author</th>
                <th>Year</th>
                <th>Thao tác</th>
            </tr>
        </thead>
        <tbody>
            <?php 
                foreach($lsFromDB as $key => $value){
            ?>
            <tr data-id="<?php echo $value->id ?>">
                <td><?php echo $value->id ?></td>
                <td class="book-title"><?php echo $value->title?></td>
                <td class="book-price"><?php echo $value->price?></td>
                <td class="book-author"><?php echo $value->author?></td>
                <td class="book-year"><?php echo $value->year?></td>
                <td>
                    <button data-toggle="modal" data-target="#editModal" class="btn-edit btn btn-outline-warning"><i class="fas fa-pencil-alt"></i> Edit</button>
                    <button class="btn-delete btn btn-outline-danger"><i class="fas fa-trash-alt"></i> Delete</button>
                    <form id="delete-form" action="" method="POST" hidden>
                        <input type="text" id="d-id" name="delete" value="">
                    </form>
                </td>
            </tr>    
            <?php 
                }
            ?>
        </tbody>
    </table>

    <nav aria-label="...">
      <ul class="pagination justify-content-center">
        <li class="page-item <?php echo ($page == 1 ? "disabled" : "") ?>"  >
          <a id="pre-page" href="baiso4?page=<?php echo $page - 1 ?>" class="page-link">Previous </a>
        </li>
        <?php 
          for($i = 1; $i <= $total_page; $i++) {
            if($i == $page) {
              echo '<li class="page-item active"><a class="page-link" href="baiso4?page=' . $i . '">' .$i . '</a> </li>';
            }
            else {
              echo '<li class="page-item"><a class="page-link" href="baiso4?page=' . $i . '">' .$i . '</a> </li>';
            }
          }?>
        <li class="page-item <?php echo ($page == $total_page ? "disabled" : "") ?>">
          <a id="next-page" href="baiso4?page=<?php echo $page + 1 ?>" class="page-link">Next</a>
        </li>
      </ul>
    </nav>
</div>
<?php 
    include_once('footer.php');
?>

<script>
    $(document).ready(function(){
		$(document).on("click", ".btn-delete", function(){
            var instance = this;
			$.confirm({
			title: 'Confirm!',
			content: 'Are you sure to delete this item?',
			buttons: {
				YES: function () {
					$("#d-id").val($(instance).parents("tr").attr("data-id"));
                    $("#delete-form").submit();
				},
				NO: function () {
					
				}
			},
			theme: "supervan"
			});
		})
		
	});

  $(".btn-edit").on("click", function() {
      $("#hidden-id").val($(this).parents("tr").attr("data-id"));
      $("#e-title").val($(this).parents("tr").find(".book-title").text());
      $("#e-price").val($(this).parents("tr").find(".book-price").text());
      $("#e-author").val($(this).parents("tr").find(".book-author").text());
      $("#e-year").val(parseInt($(this).parents("tr").find(".book-year").text()));
  })
</script>