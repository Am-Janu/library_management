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
    <link rel="stylesheet" href="../../../lib/inward.css">
    <script src="../../../js/jquery-3.7.1.slim.min.js"></script>
    <script src="../../../js/dataTables.js"></script>
    <link rel="stylesheet" href="../../../lib/dataTables.dataTables.css">
    <title>Inwards</title>
</head>

<body>
    <?php include("../../../includes/header.php"); ?>
    <div class="container mt-5 pt-4 mb-5 pb-5">

        <div class="row mt-5 pt-3" style="margin-bottom: 110px;">
            <div id="content1"></div>
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
            url: 'inward_ajax.php',
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
                graph();
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
        var supplier_id = document.getElementById("supplier_id").value;

        $.ajax({
            url: 'inward_ajax.php',
            method: 'POST',
            data: {
                op_code: 1,
                from_date: from_Date,
                to_date: To_Date,
                book_id: book_id,
                supplier_id: supplier_id

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
    function addinward() {
        $.ajax({
            url: 'inward_ajax.php',
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

    function add_inward() {
        var bookId = document.getElementById('book_id').value;
        var quantity = document.getElementById('quantity').value;
        var supplierId = document.getElementById('supplier_id').value;
        var datepicker = document.getElementById('datepicker').value;


        var bookIdRegex = /.+/;
        var quantityRegex = /^[0-9]+$/;
        var supplierIdRegex = /.+/;
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
        if (!supplierId.match(supplierIdRegex)) {
            alert('Please select the supplier.');
            return false;
        }
        if (!datepicker.match(dateRegex)) {
            alert('Please select the date.');
            return false;
        }

        $.ajax({
            url: 'inward_ajax.php',
            method: 'POST',
            data: {
                op_code: 3,
                book_id: bookId,
                quantity: quantity,
                supplier_id: supplierId,
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

    function deleteinward(id) {

        $.ajax({
            url: 'inward_ajax.php',
            method: 'POST',
            data: {
                op_code: 4,
                inward_id: id
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
            url: 'inward_ajax.php',
            method: 'POST',
            data: {
                op_code: 5,
                inward_id: id
            },
            success: function(data) {
                $("#content").html(data);
            },
            error: function(xhr, status, error) {

                console.error(status + ': ' + error);
            }
        });
    }

    function update_inward(id) {
        var bookId = document.getElementById('book_id').value;
        var quantity = document.getElementById('quantity').value;
        var supplierId = document.getElementById('supplier_id').value;
        var datepicker = document.getElementById('datepicker').value;


        var bookIdRegex = /.+/;
        var quantityRegex = /^[0-9]+$/;
        var supplierIdRegex = /.+/;
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
        if (!supplierId.match(supplierIdRegex)) {
            alert('Please select the supplier.');
            return false;
        }
        if (!datepicker.match(dateRegex)) {
            alert('Please select the date.');
            return false;
        }

        $.ajax({
            url: 'inward_ajax.php',
            method: 'POST',
            data: {
                op_code: 6,
                book_id: bookId,
                quantity: quantity,
                supplier_id: supplierId,
                date: datepicker,
                inward_id: id
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


    function graph() {
        $.ajax({
            url: 'inward_ajax.php',
            method: 'POST',
            data: {
                op_code: 7,
            },
            success: function(data) {
                const graph_data = JSON.parse(data);
                console.log(graph_data);
                draw(graph_data);

            },
            error: function(xhr, status, error) {

                console.error(status + ': ' + error);
            }
        });


        function draw(graph_data) {
            google.charts.load('current', {
                'packages': ['gauge']
            });
            google.charts.setOnLoadCallback(drawChart);

            function drawChart() {

                var data = google.visualization.arrayToDataTable(graph_data);

                var options = {
                    width: 1300,
                    height: 400,
                    min: 0,
                    max: 200,
                    redFrom: 160,
                    redTo: 200,
                    yellowFrom: 120, 
                    yellowTo: 160, 
                    minorTicks: 5
                };

                var chart = new google.visualization.Gauge(document.getElementById('content1'));

                chart.draw(data, options);
            }
        }
    }

    setInterval(graph, 5000);
</script>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>