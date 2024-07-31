<?php include("../../../includes/config.php"); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../../lib/category.css">
    <title>Category</title>
    <script src="../../../js/jquery-3.7.1.slim.min.js"></script>
    <script src="../../../js/dataTables.js"></script>
    <link rel="stylesheet" href="../../../lib/dataTables.dataTables.css">
</head>

<body>
    <?php include("../../../includes/header.php"); ?>

    <div class="container mt-5 pt-5 mb-5 pb-5">

        <div class="row mt-4 pt-5">
            <div class="col">
                <div id="content"></div>
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
                new DataTable('#table1', {
                    paging: false,
                    scrollCollapse: true,
                    scrollY: '400px'
                });
            }
        };
        var url = "category_ajax.php";
        url += "?op_code=" + 1 + "&op_code_add=" + 1;
        xhttp.open("GET", url, true);
        xhttp.send();
    }

        function Import() {
        const xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("content").innerHTML = this.responseText;
                new DataTable('#table', {
                    paging: false,
                    scrollCollapse: true,
                    scrollY: '400px'
                });
            }
        };
        var url = "category_ajax.php";
        url += "?op_code=" + 7;
        xhttp.open("GET", url, true);
        xhttp.send();
    }

    function excel_import() {
        var excel = document.getElementById('excel').files[0];
        if (!excel) {
            alert("Please Upload the Excel File");
            return
        }

        var xhr = new XMLHttpRequest();
        var url = "category_ajax.php";

        xhr.open('POST', url, true);

        var formData = new FormData();
        formData.append('op_code', 7);
        formData.append('excel', excel);
        formData.append('show_table', 1);

        xhr.onload = function() {
            if (xhr.status == 200) {
                document.getElementById("content").innerHTML = xhr.responseText;
                new DataTable('#table', {
                    paging: false,
                    scrollCollapse: true,
                    scrollY: '400px'
                });
            } else {
                alert('Error occurred while adding Excel. Please try again.');
            }
        };
        xhr.send(formData);
    }

    function submit_excel_to_sql(targetDirectory) {
        const xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                alert(this.responseText);
                show();
            }
        };
        var url = "category_ajax.php";
        url += "?op_code=" + 8 + "&targetDirectory=" + targetDirectory;
        xhttp.open("GET", url, true);
        xhttp.send();
    }



    function addcategory() {

        category_name = document.getElementById("add_text").value

        var alphaRegex = /^[a-zA-Z\s]*$/;

        if (category_name === "") {
            alert("Please enter category name");
            return
        }
        if (!alphaRegex.test(category_name)) {
            alert("Category name must be alphabetic")
            return
        }

        const xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                alert(xhttp.responseText);
                show();
            }
        };
        var url = "category_ajax.php";
        url += "?op_code=" + 2 + "&category_name=" + category_name;
        xhttp.open("GET", url, true);
        xhttp.send();
    }


    function edit_category(id) {
        const xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("content").innerHTML = this.responseText;
                new DataTable('#table1', {
                    paging: false,
                    scrollCollapse: true,
                    scrollY: '400px'
                });
            }
        };
        var url = "category_ajax.php";
        url += "?op_code=" + 1 + "&op_code_update" + "&update_id=" + id;
        xhttp.open("GET", url, true);
        xhttp.send();
    }


    function update_category(id) {

        category_name = document.getElementById("update_text").value

        var alphaRegex = /^[a-zA-Z\s]*$/;

        if (category_name === "") {
            alert("Please enter category name");
            return
        }
        if (!alphaRegex.test(category_name)) {
            alert("Category name must be alphabetic")
            return
        }

        const xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                alert(xhttp.responseText);
                show();
            }
        };
        var url = "category_ajax.php";
        url += "?op_code=" + 3 + "&category_name=" + category_name + "&category_id=" + id;
        xhttp.open("GET", url, true);
        xhttp.send();
    }


    function cancel() {
        show();
    }


    function delete_category(id) {

        if (confirm("Are you sure to delete this category")) {
            const xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("content").innerHTML = this.responseText;
                    show();
                }
            };
            var url = "category_ajax.php";
            url += "?op_code=" + 4 + "&category_id=" + id;
            xhttp.open("GET", url, true);
            xhttp.send();
        }
    }
</script>