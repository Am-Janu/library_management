<?php include("../../../includes/config.php"); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="../../../js/gen_validatorv4.js" type="text/javascript"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://code.jquery.com/ui/1.13.3/jquery-ui.js"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.3/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../../../lib/outward.css">
    <script src="../../../js/jquery-3.7.1.slim.min.js"></script>
    <script src="../../../js/dataTables.js"></script>
    <link rel="stylesheet" href="../../../lib/dataTables.dataTables.css">

    <title>outwards</title>
</head>

<body>
    <?php include("../../../includes/header.php"); ?>
    <div class="container mt-5 pt-4 mb-5 pb-5">

        <div class="row mt-5 pt-3" style="margin-bottom: 110px;">
            <div id="content"></div>
        </div>

    </div>

    <?php include("../../../includes/footer.php"); ?>
</body>

</html>

<script>
    show();

    function show() {
        $.ajax({
            url: 'outward_ajax.php',
            method: 'POST',
            data: {
                op_code: 1
            },
            success: function(data) {
                $("#content").html(data);
                new DataTable('#table', {
                    paging: false,
                    scrollCollapse: true,
                    scrollY: '350px'
                });
            },
            error: function(xhr, status, error) {

                console.error(status + ': ' + error);
            }
        });
    }


    function filter() {
        var from_Date = document.getElementById("datepicker").value;
        var To_Date = document.getElementById("datepicker1").value;
        var book_id = document.getElementById("book_id").value;
        var student_id = document.getElementById("student_id").value;

        $.ajax({
            url: 'outward_ajax.php',
            method: 'POST',
            data: {
                op_code: 1,
                from_date: from_Date,
                to_date: To_Date,
                book_id: book_id,
                student_id: student_id

            },
            success: function(data) {
                $("#content").html(data);
                new DataTable('#table', {
                    paging: false,
                    scrollCollapse: true,
                    scrollY: '350px'
                });
            },
            error: function(xhr, status, error) {

                console.error(status + ': ' + error);
            }
        });
    }
</script>


<script>
    function addoutward() {
        $.ajax({
            url: 'outward_ajax.php',
            method: 'POST',
            data: {
                op_code: 2,
            },
            success: function(data) {
                $("#content").html(data);
            },
            error: function(xhr, status, error) {

                console.error(status + ': ' + error);
            }
        });

    }


    function add_outward() {
        var bookId = document.getElementById('book_id').value;
        var quantity = document.getElementById('quantity').value;
        var studentId = document.getElementById('student_id').value;
        var datepicker = document.getElementById('datepicker').value;


        var bookIdRegex = /.+/;
        var quantityRegex = /^[0-9]+$/;
        var studentIdRegex = /.+/;
        var dateRegex = /.+/;


        if (!bookId.match(bookIdRegex)) {
            alert('Please select the book name.');
            return false;
        }
        if (!quantity.match(quantityRegex)) {
            alert('Please enter a valid number for book quantity.');
            return false;
        }
        if (quantity.length > 5) {
            alert('The book quantity cannot exceed 99999.');
            return false;
        }
        if (!studentId.match(studentIdRegex)) {
            alert('Please select the student.');
            return false;
        }
        if (!datepicker.match(dateRegex)) {
            alert('Please select the date.');
            return false;
        }

        $.ajax({
            url: 'outward_ajax.php',
            method: 'POST',
            data: {
                op_code: 3,
                book_id: bookId,
                quantity: quantity,
                student_id: studentId,
                date: datepicker
            },
            success: function(data) {
                alert(data);
                show();
            },
            error: function(xhr, status, error) {

                console.error(status + ': ' + error);
            }
        });
    }

    function cancel() {
        show();
    }

    function deleteoutward(id) {

        $.ajax({
            url: 'outward_ajax.php',
            method: 'POST',
            data: {
                op_code: 4,
                outward_id: id
            },
            success: function(data) {
                alert(data);
                show();
            },
            error: function(xhr, status, error) {

                console.error(status + ': ' + error);
            }
        });
    }


    function edit(id) {

        $.ajax({
            url: 'outward_ajax.php',
            method: 'POST',
            data: {
                op_code: 5,
                outward_id: id
            },
            success: function(data) {
                $("#content").html(data);
            },
            error: function(xhr, status, error) {

                console.error(status + ': ' + error);
            }
        });
    }

    function update_outward(id) {
        var bookId = document.getElementById('book_id').value;
        var quantity = document.getElementById('quantity').value;
        var studentId = document.getElementById('student_id').value;
        var datepicker = document.getElementById('datepicker').value;


        var bookIdRegex = /.+/;
        var quantityRegex = /^[0-9]+$/;
        var studentIdRegex = /.+/;
        var dateRegex = /.+/;


        if (!bookId.match(bookIdRegex)) {
            alert('Please select the book name.');
            return false;
        }
        if (!quantity.match(quantityRegex)) {
            alert('Please enter a valid number for book quantity.');
            return false;
        }
        if (quantity.length > 5) {
            alert('The book quantity cannot exceed 99999.');
            return false;
        }
        if (!studentId.match(studentIdRegex)) {
            alert('Please select the student.');
            return false;
        }
        if (!datepicker.match(dateRegex)) {
            alert('Please select the date.');
            return false;
        }

        $.ajax({
            url: 'outward_ajax.php',
            method: 'POST',
            data: {
                op_code: 6,
                book_id: bookId,
                quantity: quantity,
                student_id: studentId,
                date: datepicker,
                outward_id: id
            },
            success: function(data) {
                alert(data);
                show();
            },
            error: function(xhr, status, error) {

                console.error(status + ': ' + error);
            }
        });
    }
</script>