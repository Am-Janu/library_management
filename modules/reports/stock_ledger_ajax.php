<?php include("../../includes/config.php");
extract($_REQUEST); ?>

<?php if ($op_code == 1) { ?>
    <?php
    $from_date = isset($_REQUEST["from_date"]) ? $_REQUEST["from_date"] : "";
    $to_date = isset($_REQUEST["to_date"]) ? $_REQUEST["to_date"] : "";
    $book_id = isset($_REQUEST["book_id"]) ? $_REQUEST["book_id"] : "";
    $bk_name = isset($_REQUEST["bk_name"]) ? $_REQUEST["bk_name"] : "";
    $where = "";
    ?>
    <?php
    $serial_no = 0;
    $closing = "";
    $credit_total = "";
    $debit_total = "";
    $total_credit = 0;
    $total_debit = 0;
    $total_close = 0;
    $query_total = 0;

    if ($from_date != "" && $to_date != "") {
        $from_date = date("Y-m-d", strtotime($_REQUEST["from_date"]));
        $to_date = date("Y-m-d", strtotime($_REQUEST["to_date"]));
        $condition2 = " AND date BETWEEN '$from_date' AND '$to_date' ";
        $condition_total = " AND date < '$from_date' ";
        $query_total = "SELECT sum(credit) as total_credit , sum(debit) as total_debit , sum(credit) - sum(debit) as total_close FROM stock_ledger WHERE status = 'active' AND book_id = '$book_id' $condition_total ORDER BY date";
    } elseif ($from_date != "" && $to_date == "") {
        $from_date = date("Y-m-d", strtotime($_REQUEST["from_date"]));
        $condition2 = " AND date >= '$from_date' ";
        $condition_total = " AND date < '$from_date' ";
        $query_total = "SELECT sum(credit) as total_credit , sum(debit) as total_debit , sum(credit) - sum(debit) as total_close FROM stock_ledger WHERE status = 'active' AND book_id = '$book_id' $condition_total ORDER BY date";
    } elseif ($from_date == "" && $to_date != "") {
        $to_date = date("Y-m-d", strtotime($_REQUEST["to_date"]));
        $condition2 = " AND date <= '$to_date' ";
    } else {
        $condition2 = "";
    }

    if ($query_total = mysqli_query($conn, $query_total)) {
        $result_total = mysqli_fetch_assoc($query_total);
        $total_credit = $result_total['total_credit'];
        $total_debit = $result_total['total_debit'];
        $total_close = $result_total['total_close'];
        $closing = $total_close;
    }
    ?>

    <div class="tbl p-5" style="background-color: #373A40; color :aliceblue; width: auto;">
        <table>
            <thead>
                <tr style="height : 70px;">
                    <th colspan="2" class="py-3">
                        From Date : <input style="width: 150px; height: 35px; display :inline; margin-left :5px;" type="text" id="datepicker" class="form-control" placeholder="Select The Date" value="<?php echo $value = isset($_REQUEST["from_date"]) ? $_REQUEST["from_date"] : ""; ?>" name="from_date">
                    </th>
                    <th class="py-3 ps-5">
                        To Date : <input style="width: 150px; height: 35px; display :inline; margin-left :5px;" type="text" id="datepicker1" class="form-control" placeholder="Select The Date" value="<?php echo $value = isset($_REQUEST["to_date"]) ? $_REQUEST["to_date"] : ""; ?>" name="to_date">
                    </th>


                    <th class="py-3 ps-5">
                        Book Name :
                        <select style="width: 200px; height: 35px; display :inline; margin-left :5px;" class="form-select form-select-xs" aria-label=".form-select-lg example" id="book_id" name="book_id">
                            <option value="">Select Book</option>
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

                    <th class=" py-3 ps-3">
                        <button class='btn btn-success ms-3' onclick="filter()" id="filter" title="Click me to Filter inward List." type='submit' name='delete'>Filter <i class="bi bi-funnel-fill"></i> </button>
                    </th>
                </tr>
            </thead>
        </table>

        <table id="example">
            <thead>
                <tr>
                    <th>Serial No</th>
                    <th>Opening Date</th>
                    <th>Book Name</th>
                    <th>Credit <span><?php $total_close = $total_close == "" ? 0 : $total_close;
                                        echo "( $total_close )"; ?></span></th>
                    <th>Debit</th>
                    <th>Closing</th>
                </tr>
            </thead>
            <tbody>

                <?php
                $query1 = "SELECT * FROM stock_ledger WHERE status = 'active' AND book_id = '$book_id' $condition2 ORDER BY date";
                if ($query1 = mysqli_query($conn, $query1)) {
                    while ($result1 = mysqli_fetch_assoc($query1)) { ?>

                        <tr>
                            <td><?php echo ++$serial_no; ?></td>
                            <td><?php echo $result1['date'] ?></td>
                            <?php $query2 = "SELECT * FROM book WHERE status = 'active'";
                            if ($query2 = mysqli_query($conn, $query2)) {
                                while ($result2 = mysqli_fetch_assoc($query2)) {
                                    if ($result2['book_id'] == $result1['book_id']) {
                                        $book_name = $result2['book_name']; ?>
                                        <td><?php echo $book_name ?></td>
                            <?php
                                    }
                                }
                            } ?>
                            <td><?php $credit_total += $result1['credit'];
                                echo $result1['credit'] ?></td>
                            <td><?php $debit_total += $result1['debit'];
                                echo $result1['debit'] ?></td>
                            <td> <?php
                                    if ($closing) {
                                        $closing = $closing - $result1['credit'] - $result1['debit'];
                                    } else {
                                        $closing = $result1['credit'] - $result1['debit'];
                                    }
                                    echo $closing ?></td>
                        </tr>
                    <?php } ?>
                    <tr>
                        <td>Current Total</td>
                        <td></td>
                        <td></td>
                        <td><?php echo $total_close + $credit_total ?></td>
                        <td><?php echo $debit_total ?></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Closing Stock</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td><?php echo ($total_close + $credit_total) - $debit_total ?></td>
                    </tr>
                <?php }
                ?>
            </tbody>
        </table>
    </div>

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