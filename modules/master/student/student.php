<?php include("../../../includes/config.php"); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student</title>
    <link rel="stylesheet" href="../../../lib/common.css">
    <script src="../../../js/jquery-3.7.1.slim.min.js"></script>
    <link rel="stylesheet" href="http://cdn.datatables.net/2.1.0/css/dataTables.dataTables.min.css">
    <script src="../../../js/dataTables.js"></script>
    <link rel="stylesheet" href="../../../lib/dataTables.dataTables.css">
</head>

<body>
    <?php include("../../../includes/header.php"); ?>
    <div class="container mt-5 pt-5 mb-5 pb-5">

        <div class="row mt-5 pt-3" style="margin-bottom: 110px;">
            <div id="content"></div>
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
        var url = "student_ajax.php";
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
        var url = "student_ajax.php";
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
        var url = "student_ajax.php";

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
        var url = "student_ajax.php";
        url += "?op_code=" + 8 + "&targetDirectory=" + targetDirectory;
        xhttp.open("GET", url, true);
        xhttp.send();
    }



    function addstudent() {
        const xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("content").innerHTML = this.responseText;
            }
        };
        var url = "student_ajax.php";
        url += "?op_code=" + 2;
        xhttp.open("GET", url, true);
        xhttp.send();
    }

    function deletestudent(id) {
        if (confirm("Are you sure to delete this student")) {
            const xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("content").innerHTML = this.responseText;
                    show();
                }
            };
            var url = "student_ajax.php";
            url += "?op_code=" + 4 + "&student_id=" + id;
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
        var url = "student_ajax.php";
        url += "?op_code=" + 5 + "&student_id=" + id;
        xhttp.open("GET", url, true);
        xhttp.send();
    }
</script>


<script type="text/javascript">
    function validateAndSubmit() {
        var name = document.getElementById('name').value.trim();
        var rollno = document.getElementById('rollno').value.trim();
        var s_class = document.getElementById('s_class').value;
        var section = document.getElementById('section').value;

        var nameRegex = /^[a-zA-Z ]{3,25}$/;
        var rollnoRegex = /^\d{6}$/;


        if (name === '') {
            alert("Please enter your Name");
            return;
        } else if (!nameRegex.test(name)) {
            alert("Name must be alphabetic and between 3 to 25 characters");
            return;
        }

        if (rollno === '') {
            alert("Please enter the Roll number");
            return;
        } else if (!rollnoRegex.test(rollno)) {
            alert("Roll no must be exactly 6 digits");
            return;
        }

        if (s_class === '') {
            alert("Please select the class");
            return;
        }

        if (section === '') {
            alert("Please select the section");
            return;
        }

        const xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                alert(xhttp.responseText);
                show();
            }
        };
        var url = "student_ajax.php";
        url += "?op_code=" + 3 + "&student_name=" + name + "&rollno=" + rollno + "&s_class=" + s_class + "&section=" + section;
        xhttp.open("GET", url, true);
        xhttp.send();
    }

    function clearFields() {
        document.getElementById('name').value = '';
        document.getElementById('rollno').value = '';
        document.getElementById('s_class').value = '';
        document.getElementById('section').value = '';
    }
</script>


<script type="text/javascript">
    function validateAndSubmitupdate(id) {
        var name = document.getElementById('name').value.trim();
        var roll_no = document.getElementById('rollno').value.trim();
        var s_class = document.getElementById('s_class').value;
        var section = document.getElementById('section').value;

        var nameRegex = /^[a-zA-Z ]{3,25}$/;
        var rollnoRegex = /^\d{6}$/;


        if (name === '') {
            alert("Please enter your Name");
            return;
        } else if (!nameRegex.test(name)) {
            alert("Name must be alphabetic and between 3 to 25 characters");
            return;
        }

        if (roll_no === '') {
            alert("Please enter the Roll number");
            return;
        } else if (!rollnoRegex.test(roll_no)) {
            alert("Roll no must be exactly 6 digits");
            return;
        }

        if (s_class === '') {
            alert("Please select the class");
            return;
        }

        if (section === '') {
            alert("Please select the section");
            return;
        }

        const xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                alert(xhttp.responseText);
                show();
            }
        };
        var url = "student_ajax.php";
        url += "?op_code=" + 6 + "&name=" + name + "&roll_no=" + roll_no + "&s_class=" + s_class + "&section=" + section + "&student_id=" + id;
        xhttp.open("GET", url, true);
        xhttp.send();
    }
</script>


<script>
    function clearFieldsupdate(id) {
        document.getElementById('name').value = '';
        document.getElementById('rollno').value = '';
        document.getElementById('s_class').value = '';
        document.getElementById('section').value = '';
    }
</script>