<?php include("../../../includes/config.php"); 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../../lib/book.css">
    <title>List Books</title>
    <script src="../../../js/jquery-3.7.1.slim.min.js"></script>
    <script src="../../../js/dataTables.js"></script>
    <link rel="stylesheet" href="../../../lib/dataTables.dataTables.css">
</head>

<body>
    <?php include("../../../includes/header.php"); ?>

    <div class="container-fluid mt-5 pt-4 mb-5 pb-5">

        <div class="row ms-5 ps-5 me-4 mt-5 pt-3" style="margin-bottom: 110px;">
            <div id="content">

            </div>
        </div>

    </div>

    <?php include("../../../includes/footer.php"); ?>
</body>

</html>

<script>
    show();

    function show() {
        const xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("content").innerHTML = this.responseText;
                new DataTable('#example', {
                    paging: false,
                    scrollCollapse: true,
                    scrollY: '400px'
                });
            }
        };
        var url = "book_ajax.php";
        url += "?op_code=" + 1;
        xhttp.open("GET", url, true);
        xhttp.send();
    }

    function cancel() {
        show();
    }



    function addbook() {
        const xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("content").innerHTML = this.responseText;
            }
        };
        var url = "book_ajax.php";
        url += "?op_code=" + 2;
        xhttp.open("GET", url, true);
        xhttp.send();
    }

    function add_book() {
        var category = document.getElementById('category').value;
        var name = document.getElementById('bname').value;
        var image = document.getElementById('book_img').files[0];
        var nameRegex = /^[a-zA-Z0-9\s]+$/;

        if (!name) {
            alert("Please Enter the Book name");
            return
        } else if (!nameRegex.test(name)) {
            alert("Book Name must be alphanumeric");
            return;
        }

        if (!image) {
            alert("Please Upload the Book Image");
            return
        }

        if (!category) {
            alert("Please Select the category");
            return
        }

        var xhr = new XMLHttpRequest();
        var url = "book_ajax.php";

        xhr.open('POST', url, true);

        var formData = new FormData();
        formData.append('op_code', 3);
        formData.append('add_newbook', 1);
        formData.append('category', category);
        formData.append('bname', name);
        formData.append('book_img', image);


        xhr.onload = function() {
            if (xhr.status == 200) {
                alert(xhr.responseText);
                show();
            } else {
                alert('Error occurred while adding book. Please try again.');
            }
        };
        xhr.send(formData);
    }

    function deletebook(id) {
        if (confirm("Are you sure to delete this Book")) {
            const xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("content").innerHTML = this.responseText;
                    show();
                }
            };
            var url = "book_ajax.php";
            url += "?op_code=" + 4 + "&book_id=" + id;
            xhttp.open("GET", url, true);
            xhttp.send();
        }
    }

    function update(id) {
        const xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("content").innerHTML = this.responseText;
            }
        };
        var url = "book_ajax.php";
        url += "?op_code=" + 5 + "&book_id=" + id;
        xhttp.open("GET", url, true);
        xhttp.send();
    }

    function update_book(id) {
        var category = document.getElementById('category').value;
        var name = document.getElementById('bname').value;
        var image = document.getElementById('book_img').files[0];
        var nameRegex = /^[a-zA-Z0-9\s]+$/;

        if (!name) {
            alert("Please Enter the Book name");
            return
        } else if (!nameRegex.test(name)) {
            alert("Book Name must be alphanumeric");
            return;
        }

        if (!category) {
            alert("Please Select the category");
            return
        }

        var xhr = new XMLHttpRequest();
        var url = "book_ajax.php";

        xhr.open('POST', url, true);

        var formData = new FormData();
        formData.append('op_code', 6);
        formData.append('update_newbook', 1);
        formData.append('category', category);
        formData.append('bname', name);
        formData.append('book_img', image);
        formData.append('book_id', id);



        xhr.onload = function() {
            if (xhr.status == 200) {
                alert(xhr.responseText);
                show();
            } else {
                alert('Error occurred while update book. Please try again.');
            }
        };
        xhr.send(formData);
    }
</script>


<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
    function graph() {
        google.charts.load('current', {
            'packages': ['corechart']
        });
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {

            var data = google.visualization.arrayToDataTable([
                ['Category', 'Count'],
                <?php
                $sql = "SELECT COUNT(b.book_name) AS count, c.category_name 
                        FROM book AS b 
                        JOIN category AS c ON b.category_id = c.category_id 
                        GROUP BY b.category_id";
   
                $result = mysqli_query($conn, $sql);

                $first = true;
                while ($row = mysqli_fetch_assoc($result)) {
                    if (!$first) {
                        echo ",\n";
                    }
                    echo "['" . ($row['category_name']) . "', " . $row['count'] . "]";
                    $first = false;
                }
                ?>
            ]);

            var options = {
                title: 'List of Books'
            };

            var chart = new google.visualization.PieChart(document.getElementById('content'));
            chart.draw(data, options);

            var button = document.createElement('button');

            button.textContent = 'Back';
            button.className = 'btn btn-primary m-4';
            button.onclick = function()
            {
                show();
            }
            document.getElementById('content').prepend(button);
        }
    }
</script>