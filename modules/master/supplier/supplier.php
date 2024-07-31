<?php include("../../../includes/config.php"); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List Supplier</title>
    <link rel="stylesheet" href="../../../lib/supplier.css">
    <script src="../../../js/jquery-3.7.1.slim.min.js"></script>
    <script src="../../../js/dataTables.js"></script>
    <link rel="stylesheet" href="../../../lib/dataTables.dataTables.css">
</head>

<body>
    <?php include("../../../includes/header.php"); ?>

    <div class="container-fluid ps-5 pe-5  mt-5 pt-5 mb-5 pb-5">

        <div class="row mt-5 pt-3" style="margin-bottom: 110px;">
            <div id="content">
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
                new DataTable('#table', {
                    paging: false,
                    scrollCollapse: true,
                    scrollY: '400px'
                });
            }
        };
        var url = "supplier_ajax.php";
        url += "?op_code=" + 1;
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
        var url = "supplier_ajax.php";
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
        var url = "supplier_ajax.php";

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
        var url = "supplier_ajax.php";
        url += "?op_code=" + 8 + "&targetDirectory=" + targetDirectory;
        xhttp.open("GET", url, true);
        xhttp.send();
    }

    function addsupplier() {
        const xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("content").innerHTML = this.responseText;
            }
        };
        var url = "supplier_ajax.php";
        url += "?op_code=" + 2;
        xhttp.open("GET", url, true);
        xhttp.send();
    }

    function submitsupplier() {

        var sname = document.getElementById("sname").value.trim();
        var mobileno = document.getElementById("mobileno").value.trim();
        var gstno = document.getElementById("gstno").value.trim();
        var address = document.getElementById("address").value.trim();

        var alphaRegex = /^[a-zA-Z\s]+$/;
        var numericRegex = /^[0-9]+$/;
        var alphanumericRegex = /^[0-9a-zA-Z]+$/;

        if (sname === "") {
            alert("Please enter your Name");
            return;
        }
        if (!alphaRegex.test(sname)) {
            alert("Name must be alphabetic");
            return;
        }
        if (sname.length < 3 || sname.length > 25) {
            alert("Name must be between 3 and 25 characters");
            return;
        }

        if (mobileno === "") {
            alert("Please enter your Mobile No");
            return;
        }
        if (!numericRegex.test(mobileno)) {
            alert("Mobile Number must contain only numeric digits");
            return;
        }
        if (mobileno.length !== 10) {
            alert("Mobile No must be exactly 10 digits");
            return;
        }

        if (gstno === "") {
            alert("Please enter your GST No");
            return;
        }
        if (!alphanumericRegex.test(gstno)) {
            alert("GST Number must be alphanumeric");
            return;
        }
        if (gstno.length !== 15) {
            alert("GST Number must be exactly 15 characters");
            return;
        }

        if (address === "") {
            alert("Please enter your Address");
            return;
        }
        if (address.length < 10 || address.length > 100) {
            alert("Address must be between 10 and 100 characters");
            return;
        }

        const xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                alert(this.responseText);
                show();
            }
        };
        var url = "supplier_ajax.php";
        url += "?op_code=" + 3 + "&name=" + sname + "&mobileno=" + mobileno + "&gst_no=" + gstno + "&address=" + address;
        xhttp.open("GET", url, true);
        xhttp.send();
    }

    function clearsupplier() {

        var sname = document.getElementById("sname").value = '';
        var mobileno = document.getElementById("mobileno").value = '';
        var gstno = document.getElementById("gstno").value = '';
        var address = document.getElementById("address").value = '';
    }

    function deletesupplier(id) {
        if (confirm("Are you sure to delete this supplier")) {
            const xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("content").innerHTML = this.responseText;
                    show();
                }
            };
            var url = "supplier_ajax.php";
            url += "?op_code=" + 4 + "&supplier_id=" + id;
            xhttp.open("GET", url, true);
            xhttp.send();
        }
    }

    function Edit(id) {
        const xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("content").innerHTML = this.responseText;
            }
        };
        var url = "supplier_ajax.php";
        url += "?op_code=" + 5 + "&supplier_id=" + id;
        xhttp.open("GET", url, true);
        xhttp.send();
    }


    function update(id) {

        var sname = document.getElementById("sname").value.trim();
        var mobileno = document.getElementById("mobileno").value.trim();
        var gstno = document.getElementById("gstno").value.trim();
        var address = document.getElementById("address").value.trim();

        var alphaRegex = /^[a-zA-Z\s]+$/;
        var numericRegex = /^[0-9]+$/;
        var alphanumericRegex = /^[0-9a-zA-Z]+$/;

        if (sname === "") {
            alert("Please enter your Name");
            return;
        }
        if (!alphaRegex.test(sname)) {
            alert("Name must be alphabetic");
            return;
        }
        if (sname.length < 3 || sname.length > 25) {
            alert("Name must be between 3 and 25 characters");
            return;
        }

        if (mobileno === "") {
            alert("Please enter your Mobile No");
            return;
        }
        if (!numericRegex.test(mobileno)) {
            alert("Mobile Number must contain only numeric digits");
            return;
        }
        if (mobileno.length !== 10) {
            alert("Mobile No must be exactly 10 digits");
            return;
        }

        if (gstno === "") {
            alert("Please enter your GST No");
            return;
        }
        if (!alphanumericRegex.test(gstno)) {
            alert("GST Number must be alphanumeric");
            return;
        }
        if (gstno.length !== 15) {
            alert("GST Number must be exactly 15 characters");
            return;
        }

        if (address === "") {
            alert("Please enter your Address");
            return;
        }
        if (address.length < 10 || address.length > 100) {
            alert("Address must be between 10 and 100 characters");
            return;
        }
        const xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                alert(this.responseText);
                show();
            }
        };
        var url = "supplier_ajax.php";
        url += "?op_code=" + 6 + "&name=" + sname + "&mobileno=" + mobileno + "&gst_no=" + gstno + "&address=" + address + "&supplier_id=" + id;
        xhttp.open("GET", url, true);
        xhttp.send();
    }
</script>