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
?>
<div class="container pt-5">
    <h1>Bai so 5</h1>
    <button class="btn btn-primary" onclick="testAjax();" type="button">Test JS</button>
    <div id="contentAjax"></div>
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
        <tbody id="data-book">
            
        </tbody>
    </table>
</div>

<?php include_once('footer.php') ?>
<script>
    function testAjax() {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function(){
            if(this.readyState == 4 && this.status == 200) {
                var books = JSON.parse(this.responseText)
                console.log(books);
                books.forEach(function(item, index){
                    var title = item.title;
                    var price = item.price;
                    var author = item.author;
                    var year = item.year;
                    var action = "<button data-toggle='modal' data-target='#editModal' class='btn-edit btn btn-outline-warning'><i class='fas fa-pencil-alt'></i> Edit</button><button class='btn-delete btn btn-outline-danger'><i class='fas fa-trash-alt'></i> Delete</button><form id='delete-form' action='' method='POST' hidden><input type='text' id='d-id' name='delete' value=''></form>";
                    var str = "<tr>";

                    str += "<td>"
                    str += index + 1
                    str += "</td>"

                    str += "<td>"
                    str += title
                    str += "</td>"

                    str += "<td>"
                    str += price
                    str += "</td>"

                    str += "<td>"
                    str += author
                    str += "</td>"

                    str += "<td>"
                    str += year
                    str += "</td>"

                    str += "<td>"
                    str += action
                    str += "</td>"


                    str += "</tr>";
                    document.getElementById("data-book").innerHTML = document.getElementById("data-book").innerHTML += str;
                })
                
            }
        }
        xhttp.open("GET", "testajax.php?username=abc", true);
        xhttp.send();
    }
    $(document).ready(function(){
		
	});
</script>