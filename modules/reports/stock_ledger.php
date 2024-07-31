<?php include("../../includes/config.php"); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stock Ledger</title>
    <script src="../../js/jquery-3.7.1.slim.min.js"></script>
    <script src="../../js/dataTables.js"></script>
    <link rel="stylesheet" href="../../lib/dataTables.dataTables.css">
    <script src="https://code.jquery.com/ui/1.13.3/jquery-ui.js"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.3/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">


    <style>
        body {
            background-color: grey !important;
        }
    </style>

</head>

<body>
    <?php include("../../includes/header.php"); ?>

    <div class="container mt-5 pt-5 mb-5 pb-5">

        <div class="row mt-2 pt-2" style="margin-bottom: 110px;">
            <h1 class="mb-3 text-dark">Stock Ledger</h1>

            <div id="content"></div>

        </div>
    </div>
    <?php include("../../includes/footer.php"); ?>
</body>

</html>



<script>
    show();

    function show() {

        $.ajax({
            url: 'stock_ledger_ajax.php',
            method: 'POST',
            data: {
                op_code: 1,
            },
            success: function(data) {
                $("#content").html(data);
                new DataTable('#example', {
                    paging: false,
                    scrollCollapse: true,
                    scrollY: '200px'
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

        $.ajax({
            url: 'stock_ledger_ajax.php',
            method: 'POST',
            data: {
                op_code: 1,
                from_date: from_Date,
                to_date: To_Date,
                book_id: book_id
            },
            success: function(data) {
                $("#content").html(data);
                new DataTable('#example', {
                    paging: false,
                    scrollCollapse: true,
                    scrollY: '200px'
                });
            },
            error: function(xhr, status, error) {

                console.error(status + ': ' + error);
            }
        });
    }
</script>

