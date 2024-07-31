<?php include("../../includes/config.php"); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stock</title>
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://code.jquery.com/ui/1.13.3/jquery-ui.js"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.3/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="../../js/jquery-3.7.1.slim.min.js"></script>
    <script src="../../js/dataTables.js"></script>
    <link rel="stylesheet" href="../../lib/dataTables.dataTables.css">

    <style>
        body {
            background-color: grey !important;
        }
    </style>

</head>

<body>
    <?php include("../../includes/header.php"); ?>

    <div class="container mt-5 pt-5 mb-5 pb-5">
        <div class="row mt-5 pt-3" style="margin-bottom: 110px;">

            <div id="content">
            </div>
            <div id="piechart" style="width: 900px; height: 500px;"></div>
            <?php include("../../includes/footer.php"); ?>
</body>

</html>

<script>
    show();

    function show() {
        $.ajax({
            url: 'stock_ajax.php',
            method: 'POST',
            data: {
                op_code: 1
            },
            success: function(data) {
                $("#content").html(data);
            },
            error: function(xhr, status, error) {

                console.error(status + ': ' + error);
            }
        });
    }

    function transaction() {
        $.ajax({
            url: 'stock_ajax.php',
            method: 'POST',
            data: {
                op_code: 2
            },
            success: function(data) {
                $("#content").html(data);
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
        var transaction_type = document.getElementById("transaction_type").value;

        $.ajax({
            url: 'stock_ajax.php',
            method: 'POST',
            data: {
                op_code: 2,
                from_date: from_Date,
                to_date: To_Date,
                book_id: book_id,
                transaction_type: transaction_type
            },
            success: function(data) {
                $("#content").html(data);
            },
            error: function(xhr, status, error) {

                console.error(status + ': ' + error);
            }
        });
    }

    function stock_summary() {
        show();
    }


    function graph() {
        var from_Date = document.getElementById("datepicker").value;
        var To_Date = document.getElementById("datepicker1").value;
        var book_id = document.getElementById("book_id").value;
        var transaction_type = document.getElementById("transaction_type").value;

        $.ajax({
            url: 'stock_ajax.php',
            method: 'POST',
            data: {
                op_code: 3,
            },
            success: function(data) {
                var graph_input = JSON.parse(data);
                alert(graph_input);
                graph_show(graph_input);
            },
            error: function(xhr, status, error) {

                console.error(status + ': ' + error);
            }
        });


        function graph_show(graph_input) {

            google.charts.load('current', {
                packages: ['corechart', 'bar']
            });
            google.charts.setOnLoadCallback(drawBasic);

            function drawBasic() {

                var data = google.visualization.arrayToDataTable(graph_input);

                var options = {
                    title: '<?php echo $_SESSION['type']; ?> transaction Details ',
                    chartArea: {
                        width: '50%'
                    },
                    hAxis: {
                        title: 'Quantity',
                        minValue: 0
                    },
                    vAxis: {
                        title: 'Book Name'
                    }
                };

                var chart = new google.visualization.BarChart(document.getElementById('content'));

                chart.draw(data, options);
            }

        }
    }
</script>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js">


</script>