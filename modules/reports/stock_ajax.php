<?php include("../../includes/config.php");
extract($_REQUEST) ?>
<?php if ($op_code == 1) { ?>
    <h1 class="mb-3 text-dark">Stock Summary <button type="submit" onclick="transaction()" title="Click me to Show Transaction Details." class="btn btn-dark ms-2">Transactions List </button> </h1>

    <div class="tbl p-5" style="background-color: #373A40; color :aliceblue">
        <table id="example" class="display" style="width:100%">
            <thead>
                <tr>
                    <th>Serial No</th>
                    <th>Book Name</th>
                    <th>Available Quantity</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $serial_no = 0;
                $total_quantity = 0;
                $query = "SELECT b.book_name AS book_name, SUM(COALESCE(i.quantity, 0)) - SUM(COALESCE(o.quantity, 0)) AS available_quantity 
                FROM book AS b LEFT JOIN (SELECT book_id, SUM(quantity) AS quantity FROM inward WHERE status = 'active' GROUP BY book_id) AS i
                ON b.book_id = i.book_id LEFT JOIN (SELECT book_id, SUM(quantity) AS quantity FROM outward WHERE status = 'active' GROUP BY book_id) AS o ON b.book_id = o.book_id GROUP BY b.book_id";

                if ($sql = mysqli_query($conn, $query)) {
                    while ($row = mysqli_fetch_assoc($sql)) {
                        echo "<tr>";
                        echo "<td>" . ++$serial_no . "</td>";
                        echo "<td>" . $row['book_name'] . "</td>";
                        $total_quantity += $row['available_quantity'];
                        echo "<td>" . $row['available_quantity'] . "</td>";
                        echo "</tr>";
                    }
                }
                ?>
            </tbody>
        </table>
        <?php echo "Total Available Book Quantity is : $total_quantity"; ?>
    </div>

    <script>
        new DataTable('#example', {
            paging: false,
            scrollCollapse: true,
            scrollY: '400px'
        });
    </script>
<?php } ?>
<?php if ($op_code == 2) { ?>
    <?php
    $from_date = isset($_REQUEST["from_date"]) ? $_REQUEST["from_date"] : "";
    $to_date = isset($_REQUEST["to_date"]) ? $_REQUEST["to_date"] : "";
    $book_id = isset($_REQUEST["book_id"]) ? $_REQUEST["book_id"] : 0;
    $transaction_type = isset($_REQUEST["transaction_type"]) ? $_REQUEST["transaction_type"] : 0;
    $bk_name = isset($_REQUEST["bk_name"]) ? $_REQUEST["bk_name"] : "ALL";
    $where = "";
    ?>

    <h1 class="mb-3 text-dark">List Transactions <button type="submit" onclick="stock_summary()" title="Click me to Show stock summary." class="btn btn-dark ms-2">Stock Summary </button>

        <?php if ($transaction_type == 1 || $transaction_type == 2) { ?>
            <button type="submit" onclick="graph()" title="Click me to Show graph." class="btn btn-dark ms-2">Graph</button>
        <?php } ?>

        <?php
        if (($transaction_type == 'Inward') && ($transaction_type == 'Outward')) {
        } elseif ($transaction_type == 'Inward') { ?>
            <button type="submit" onclick="graph()" title="Click me to Show graph." class="btn btn-dark ms-2">Graph</button>
        <?php } elseif ($transaction_type == 'Outward') { ?>
            <button type="submit" onclick="graph()" title="Click me to Show graph." class="btn btn-dark ms-2">Graph</button>
        <?php }
        ?>
    </h1>

    <div class="tbl p-5" style="background-color: #373A40; color :aliceblue; width: auto;">
        <table>
            <thead>
                <tr style="height : 70px;">
                    <th colspan="2" class="py-3">
                        From Date : <input style="width: 150px; height: 35px; display :inline; margin-left :5px;" type="text" id="datepicker" class="form-control" placeholder="Select The Date" value="<?php echo $value = isset($_REQUEST["from_date"]) ? $_REQUEST["from_date"] : ""; ?>" name="from_date">
                    </th>
                    <th class="py-3 ps-2">
                        To Date : <input style="width: 150px; height: 35px; display :inline; margin-left :5px;" type="text" id="datepicker1" class="form-control" placeholder="Select The Date" value="<?php echo $value = isset($_REQUEST["to_date"]) ? $_REQUEST["to_date"] : ""; ?>" name="to_date">
                    </th>


                    <th class="py-3 ps-2">
                        Book Name :
                        <select style="width: 200px; height: 35px; display :inline; margin-left :5px;" class="form-select form-select-xs" aria-label=".form-select-lg example" id="book_id" name="book_id">
                            <option value="0">ALL</option>
                            <?php
                            $query = "SELECT * FROM book WHERE status = 'active'";
                            $result = mysqli_query($conn, $query);

                            while ($row = mysqli_fetch_assoc($result)) {
                                $selected = $book_id == $row['book_id'] ? "selected" : "";
                                if ($book_id == $row['book_id']) {
                                    $bk_name = $row['book_name'];
                                }
                                echo "<option value='" . $row['book_id'] . "' $selected>" . $row['book_name'] . "</option>";
                            }
                            ?>
                        </select>
                    </th>


                    <th class="py-3 ps-2">
                        Transaction Type :
                        <select style="width: 200px; height: 35px; display: inline; margin-left: 5px;" class="form-select form-select-xs" aria-label=".form-select-lg example" id="transaction_type" name="transaction_type">
                            <option value="ALL" <?php echo $transaction_type == 0 ? "selected" : "" ?>>ALL</option>
                            <option value="Inward" <?php echo $transaction_type == 1 ? "selected" : "" ?>>Inward</option>
                            <option value="Outward" <?php echo $transaction_type == 2 ? "selected" : "" ?>>Outward</option>
                        </select>
                    </th>

                    <th class=" py-3">
                        <button class='btn btn-success ms-3' onclick="filter()" id="filter" title="Click me to Filter inward List." type='submit' name='delete'>Filter <i class="bi bi-funnel-fill"></i> </button>
                    </th>
                </tr>
            </thead>
        </table>

        <table id="table" class="display">
            <thead>
                <tr>
                    <th>Serial No</th>
                    <th>Book Name</th>
                    <th>Quantity</th>
                    <th>Transaction Type</th>
                    <th>Transaction Date</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($transaction_type == 'Inward') {
                    $_SESSION['type'] = $transaction_type;
                    $condition1 = "";
                    $condition2 = "";

                    if ($book_id) {
                        $condition1 = " AND i.book_id = '$book_id'";
                    }

                    if ($from_date != "" && $to_date != "") {
                        $from_date = date("Y-m-d", strtotime($_REQUEST["from_date"]));
                        $to_date = date("Y-m-d", strtotime($_REQUEST["to_date"]));
                        $condition2 = " AND date BETWEEN '$from_date' AND '$to_date'";
                    }
                    $query = "SELECT b.book_name , i.book_id, i.quantity, i.date , 'inward' as transaction_type , i.date  
                            FROM book b JOIN ( SELECT i.inward_id, i.book_id, i.quantity, i.date , i.status FROM inward i ) AS i 
                            ON b.book_id = i.book_id WHERE i.status = 'active' $condition1 $condition2 ";
                } elseif ($transaction_type == 'Outward') {
                    $_SESSION['type'] = $transaction_type;
                    $condition1 = "";
                    $condition2 = "";

                    if ($book_id) {
                        $condition1 = " AND o.book_id = '$book_id'";
                    }

                    if ($from_date != "" && $to_date != "") {
                        $from_date = date("Y-m-d", strtotime($_REQUEST["from_date"]));
                        $to_date = date("Y-m-d", strtotime($_REQUEST["to_date"]));
                        $condition2 = " AND date BETWEEN '$from_date' AND '$to_date'";
                    }
                    $query = "SELECT b.book_name ,  o.book_id, o.quantity, o.date ,'outward' as transaction_type , o.date 
                            FROM book b JOIN ( SELECT o.outward_id, o.book_id, o.quantity, o.date , o.status FROM outward o  ) AS o 
                            ON b.book_id = o.book_id WHERE o.status = 'active' $condition1 $condition2";
                } else {

                    $condition1 = "";
                    $condition2 = "";
                    $condition3 = "";

                    if ($book_id) {
                        $condition1 = " AND i.book_id = '$book_id'";
                        $condition2 = " AND o.book_id = '$book_id'";
                    }

                    if ($from_date != "" && $to_date != "") {
                        $from_date = date("Y-m-d", strtotime($_REQUEST["from_date"]));
                        $to_date = date("Y-m-d", strtotime($_REQUEST["to_date"]));
                        $condition3 = " AND date BETWEEN '$from_date' AND '$to_date'";
                    }
                    $query = "SELECT b.book_name , i.book_id, i.quantity, i.date , 'inward' as transaction_type , i.date  
                            FROM book b JOIN ( SELECT i.inward_id, i.book_id, i.quantity, i.date , i.status FROM inward i ) AS i 
                            ON b.book_id = i.book_id WHERE i.status = 'active' $condition1 $condition3
                            UNION
                            SELECT b.book_name ,  o.book_id, o.quantity, o.date ,'outward' as transaction_type , o.date 
                            FROM book b JOIN ( SELECT o.outward_id, o.book_id, o.quantity, o.date , o.status FROM outward o  ) AS o 
                            ON b.book_id = o.book_id WHERE o.status = 'active' $condition2 $condition3";
                }

                ?>

                <?php
                $serial_no = 0;
                $total_quantity = 0;
                $_SESSION['query'] = $query;
                if ($sql = mysqli_query($conn, $query)) {
                    while ($row = mysqli_fetch_assoc($sql)) {
                        echo "<tr>";
                        echo "<td>" . ++$serial_no . "</td>";
                        echo "<td>" . $row['book_name'] . "</td>";
                        $total_quantity += $row['quantity'];
                        echo "<td>"  . $row['quantity']  . "</td>";
                        echo "<td>" . $row['transaction_type'] . "</td>";
                        echo "<td>" . date("d-m-Y", strtotime($row['date'])) . "</td>";
                    }
                }
                ?>
            </tbody>
        </table>
        <?php
        if (($transaction_type == 'Inward') && ($transaction_type == 'Outward')) {
        } elseif ($transaction_type == 'Inward') {
            echo  "Total Inward Quantity is : $total_quantity";
        } elseif ($transaction_type == 'Outward') {
            echo "Total Outward Quantity is : $total_quantity";
        }
        ?>
    </div>

    <script>
        new DataTable('#table', {
            paging: false,
            scrollCollapse: true,
            scrollY: '350px'
        });
    </script>

    <script>
        $(function() {
            $("#datepicker").datepicker({
                maxDate: 0
            });
            $("#datepicker1").datepicker({
                maxDate: 0
            });
        });
    </script>
<?php } ?>
<?php
if ($op_code == 3) {
    $query = $_SESSION['query'];
    $result = mysqli_query($conn, $query);
    $graph_input = array();
    $graph_input[] = array("Book Name", "Quantity");
    while ($row = mysqli_fetch_assoc($result)) {
        $graph_input[] = array($row['book_name'], (int)$row['quantity']);
    }
    echo json_encode($graph_input);
}
?>