<?php include("../../../includes/config.php");
extract($_REQUEST); ?>

<?php if ($op_code == 1) {
    $from_date = isset($_REQUEST["from_date"]) ? $_REQUEST["from_date"] : "";
    $to_date = isset($_REQUEST["to_date"]) ? $_REQUEST["to_date"] : "";
    $book_id = isset($_REQUEST["book_id"]) ? $_REQUEST["book_id"] : 0;
    $supplier_id = isset($_REQUEST["supplier_id"]) ? $_REQUEST["supplier_id"] : 0;
    $where = "";
?>

    <h1 class="mb-3 text-dark">List Inward <button type="submit" onclick="addinward()" title="Click me to Add more Inward." class="btn btn-success ms-2">Add Inward <i class="bi bi-person-plus"></i> </button>
    </h1>
    <div class="tdiv p-5" style="background-color: #393E46;">
        <table style="width:100%">
            <thead>

                <tr style="height : 70px;">
                    <th colspan="2" class="py-3">
                        From Date : <input style="width: 150px; height: 35px; display :inline; margin-left :5px;" autocomplete="off" type="text" id="datepicker" class="form-control" placeholder="Select The Date" value="<?php echo $value = isset($_REQUEST["from_date"]) ? $_REQUEST["from_date"] : ""; ?>" name="from_date">
                    </th>
                    <th colspan="2" class="py-3">
                        To Date : <input style="width: 150px; height: 35px; display :inline; margin-left :5px;" autocomplete="off" type="text" id="datepicker1" class="form-control" placeholder="Select The Date" value="<?php echo $value = isset($_REQUEST["to_date"]) ? $_REQUEST["to_date"] : ""; ?>" name="to_date">
                    </th>


                    <th colspan="2" class="py-3">
                        Book Name :
                        <select style="width: 200px; height: 35px; display :inline; margin-left :5px;" class="form-select form-select-xs" aria-label=".form-select-lg example" id="book_id" name="book_id">
                            <option value="0">ALL</option>
                            <?php
                            $query = "SELECT * FROM book WHERE status = 'active'";
                            $result = mysqli_query($conn, $query);

                            while ($row = mysqli_fetch_assoc($result)) {
                                $selected = $book_id == $row['book_id'] ? "selected" : "";
                                echo "<option value='" . $row['book_id'] . "' $selected>" . $row['book_name'] . "</option>";
                            }
                            ?>
                        </select>
                    </th>


                    <th colspan="2" class="py-3">
                        Supplier Name :
                        <select style="width: 200px; height: 35px; display :inline; margin-left :5px;" class="form-select form-select-xs" aria-label=".form-select-lg example" id="supplier_id" name="supplier_id">
                            <option value="0">ALL</option>
                            <?php
                            $query = "SELECT * FROM supplier WHERE status = 'active'";
                            $result = mysqli_query($conn, $query);

                            while ($row = mysqli_fetch_assoc($result)) {
                                $selected = $supplier_id == $row['supplier_id'] ? "selected" : "";
                                echo "<option value='" . $row['supplier_id'] . "'$selected>" . $row['supplier_name'] . "</option>";
                            }
                            ?>
                        </select>
                    </th>


                    <th class="py-3">
                        <button class='btn btn-success' onclick="filter()" id="filter" title="Click me to Filter inward List." type='submit' name='delete'>Filter <i class="bi bi-funnel-fill"></i> </button>
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
                    <th>Supplier Name</th>
                    <th>Inward Date</th>
                    <th>Created Date And Time</th>
                    <th>Updated Date And Time</th>
                    <th>Update</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>


                <?php
                if ($book_id) {
                    $where .= " AND b.book_id = '$book_id'";
                }

                if ($supplier_id) {
                    $where .= " AND supplier_id = '$supplier_id'";
                }

                if ($from_date != "" && $to_date != "") {
                    $from_date = date("Y-m-d", strtotime($_REQUEST["from_date"]));
                    $to_date = date("Y-m-d", strtotime($_REQUEST["to_date"]));
                    $where .= " AND date BETWEEN '$from_date' AND '$to_date'";
                }
                ?>


                <?php
                $serial_no = 0;
                $total_quantity = 0;
                $query1 = "SELECT * FROM inward JOIN book b ON inward.book_id = b.book_id WHERE inward.status = 'active' $where ORDER BY date";
                if ($sql = mysqli_query($conn, $query1)) {
                    while ($row = mysqli_fetch_assoc($sql)) { ?>
                        <tr>
                            <td><?php echo ++$serial_no; ?></td>

                            <?php
                            $sql1 = "SELECT book_name FROM book WHERE book_id =" . $row['book_id'];
                            $result = mysqli_query($conn, $sql1);
                            if (mysqli_num_rows($result) > 0) {
                                if ($row1 = mysqli_fetch_assoc($result)) {
                                    echo "<td>" . $row1['book_name'] . "</td>";
                                }
                            }
                            ?>

                            <td><?php echo $row['quantity']; ?></td>
                            <?php $total_quantity += $row['quantity']; ?>

                            <?php
                            $sql2 = "SELECT supplier_name FROM supplier WHERE supplier_id =" . $row['supplier_id'];
                            $result = mysqli_query($conn, $sql2);
                            if (mysqli_num_rows($result) > 0) {
                                if ($row2 = mysqli_fetch_assoc($result)) {
                                    echo "<td>" . $row2['supplier_name'] . "</td>";
                                }
                            }
                            ?>

                            <td><?php echo date("d-m-Y", strtotime($row['date'])); ?></td>
                            <td><?php echo date("d-m-Y h:i:s A", strtotime($row['create_date_time'])); ?></td>
                            <td><?php echo date("d-m-Y h:i:s A", strtotime($row['update_date_time'])); ?></td>

                            <td><button class='btn btn-success' title='Click me to update this Inward.' onclick="edit(<?php echo $row['inward_id']; ?>)" type='submit' name='update'>Update <i class='bi bi-arrow-repeat'></i></button></td>

                            <td><button class='btn btn-danger' title='Click me to delete this Inward.' onclick="deleteinward(<?php echo $row['inward_id']; ?>)" type='submit' name='delete'>Delete <i class='bi bi-trash3-fill'></i></button></td>
                        </tr>
                <?php }
                }
                ?>

            </tbody>
        </table>
        <?php echo " Total Inward Quantity is : $total_quantity"; ?>
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
<?php if ($op_code == 2) { ?>

    <h1 class="mb-2 text-dark">Add Inward</h1>

    <div class="bg-dark p-5" style="margin: auto; width: 90%;">
        <div class="mb-3 mt-4">
            <select class="form-select form-select-lg mb-3 py-2" aria-label=".form-select-lg example" id="book_id" name="book_id">
                <option value="">Select a Book</option>
                <?php
                $query = "SELECT * FROM book WHERE status = 'active'";
                $result = mysqli_query($conn, $query);

                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<option value='" . $row['book_id'] . "'>" . $row['book_name'] . "</option>";
                }
                ?>
            </select>
        </div>

        <input type="text" class="form-control py-3" autocomplete="off" id="quantity" placeholder="Enter Book Quantity" name="quantity">

        <div class="mb-3 mt-4">
            <select class="form-select form-select-lg mb-2 py-2" aria-label=".form-select-lg example" id="supplier_id" name="supplier_id">
                <option value="">Select a Supplier</option>
                <?php
                $query = "SELECT * FROM supplier WHERE status = 'active'";
                $result = mysqli_query($conn, $query);

                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<option value='" . $row['supplier_id'] . "'>" . $row['supplier_name'] . "</option>";
                }
                ?>
            </select>
        </div>

        <input type="text" id="datepicker" autocomplete="off" class="form-control py-3" placeholder="Select The Date" name="date">

        <div>
            <button class="btn btn-success mt-3" type="button" onclick="add_inward()" name="submit">Save</button>
            <button class="btn btn-danger mt-3 ms-2" type="button" onclick="cancel()" name="cancel">cancel</button>
        </div>
    </div>

    <script>
        $(function() {
            $("#datepicker").datepicker({
                maxDate: 0
            });
        });
    </script>

<?php } ?>
<?php if ($op_code == 3) {

    $book_id = $_REQUEST['book_id'];
    $quantity = $_REQUEST['quantity'];
    $supplier_id = $_REQUEST['supplier_id'];
    $date = $_REQUEST['date'];
    $sql_date = date('Y-m-d', strtotime($date));

    $sql = "INSERT INTO inward (book_id, quantity, supplier_id , date) VALUES ('$book_id', '$quantity', '$supplier_id' , '$sql_date')";
    if (mysqli_query($conn, $sql)) {
        $inward_id = mysqli_insert_id($conn);

        $sql2 = "INSERT INTO stock_ledger (date, book_id, referance_no, transaction_type, credit) VALUES ('$sql_date', '$book_id', '$inward_id', 'inward', '$quantity')";
        if (!mysqli_query($conn, $sql2)) {
            echo mysqli_error($conn);
        } else {
            echo "Added Successfully";
        }
    } else {
        echo mysqli_error($conn);
    }
}
?>
<?php if ($op_code == 4) {
    $inward_id = $_REQUEST['inward_id'];

    $sql2 = "UPDATE inward SET status = 'inactive' WHERE inward_id = '$inward_id'";

    if (!mysqli_query($conn, $sql2)) {
        echo mysqli_error($conn);
    } else {
        $sql3 = "UPDATE stock_ledger SET status = 'inactive' WHERE referance_no = '$inward_id' and transaction_type = 'inward'";
        if (!mysqli_query($conn, $sql3)) {
            echo mysqli_error($conn);
        }
        echo "Deleted Successfully";
    }
} ?>
<?php if ($op_code == 5) { ?>

    <?php
    if (isset($_REQUEST['inward_id'])) {
        $inward_id = $_REQUEST['inward_id'];
        $sql = "SELECT * FROM inward WHERE inward_id = $inward_id";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            if ($row = mysqli_fetch_assoc($result)) {
                $book_id = $row['book_id'];
                $quantity = $row['quantity'];
                $supplier_id = $row['supplier_id'];
                $date = $row['date'];
                $sql_date = date('Y-m-d', strtotime($date));
            }
        }
    }
    ?>


    <h1 class="mb-2 text-dark">Update Inward</h1>

    <div class="bg-dark p-5" style="margin: auto; width: 90%;">
        <div class="mb-3 mt-4">
            <select class="form-select form-select-lg mb-3 py-2" aria-label=".form-select-lg example" id="book_id" name="book_id">
                <option value="">Select a Book</option>
                <?php
                $query = "SELECT * FROM book WHERE status = 'active'";
                $result = mysqli_query($conn, $query);

                while ($row = mysqli_fetch_assoc($result)) {
                    $selected = ($row['book_id'] == $book_id) ? "selected" : "";
                    echo "<option value='" . $row['book_id'] . "' $selected>" . $row['book_name'] . "</option>";
                }
                ?>
            </select>
        </div>

        <input type="text" class="form-control" autocomplete="off" id="quantity" placeholder="Enter Book Quantity" name="quantity" value="<?php echo $quantity ?>">

        <div class="mb-3 mt-4">
            <select class="form-select form-select-lg mb-3 py-2" aria-label=".form-select-lg example" id="supplier_id" name="supplier_id">
                <option value="">Select a Supplier</option>
                <?php
                $query = "SELECT * FROM supplier WHERE status = 'active'";
                $result = mysqli_query($conn, $query);

                while ($row = mysqli_fetch_assoc($result)) {
                    $selected = ($row['supplier_id'] == $supplier_id) ? "selected" : "";
                    echo "<option value='" . $row['supplier_id'] . "' $selected>" . $row['supplier_name'] . "</option>";
                }
                ?>
            </select>
        </div>

        <input type="text" id="datepicker" class="form-control" autocomplete="off" placeholder="Select The Date" name="date" value="<?php echo $sql_date ?>">

        <div>
            <button class="btn btn-success mt-3" type="button" onclick="update_inward(<?php echo $inward_id ?>)" name="submit">Save</button>
            <button class="btn btn-danger mt-3 ms-2" type="button" onclick="cancel()" name="cancel">cancel</button>
        </div>
    </div>

    <script>
        $(function() {
            $("#datepicker").datepicker({
                maxDate: 0
            });
        });
    </script>
<?php } ?>
<?php if ($op_code == 6) {

    $inward_id = $_REQUEST['inward_id'];
    $book_id = $_REQUEST['book_id'];
    $quantity = $_REQUEST['quantity'];
    $supplier_id = $_REQUEST['supplier_id'];
    $date = $_REQUEST['date'];
    $sql_date = date('Y-m-d', strtotime($date));

    $sql = "UPDATE inward SET book_id = '$book_id' , quantity = '$quantity', supplier_id = '$supplier_id' , date = '$sql_date' WHERE inward_id = '$inward_id'";
    $sql2 = "UPDATE stock_ledger SET book_id = '$book_id' , credit = '$quantity' , date = '$sql_date' WHERE referance_no = '$inward_id' AND transaction_type = 'inward'";

    if (mysqli_query($conn, $sql)) {
        if (!mysqli_query($conn, $sql2)) {
            echo mysqli_error($conn);
        } else {
            echo "Update Successfully";
        }
    } else {
        echo mysqli_error($conn);
    }
} ?>
<?php if ($op_code == 7) {
    $query = "SELECT b.book_name, COALESCE(SUM(i.quantity), 0) AS inward_quantity FROM book AS b LEFT JOIN inward AS i ON i.book_id = b.book_id AND i.status = 'active' GROUP BY b.book_id";
    $result = mysqli_query($conn, $query);

    if ($result) {
        $data = [["Book_name", "Quantity"]];

        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = array($row['book_name'], (int)$row['inward_quantity']);
        }
        echo json_encode($data);
    }
}
?>