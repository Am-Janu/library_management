<?php include("../../../includes/config.php");
extract($_REQUEST); ?>
<?php
if ($op_code == 1) { ?>
    <h1 class="mb-3 ms-5 ps-5">List Suppliers <button type="button" onclick="addsupplier()" class="btn btn-success ms-2">Add Supplier <i class="bi bi-person-plus"></i> </button>
        <button type="button" onclick="Import()" class="btn btn-success ms-2">Import <i class="bi bi-box-arrow-in-down"></i></button>
    </h1>
    <div class="p-3 bg-dark" style="width: 90%; margin: auto;">
        <table id="table">
            <thead>
                <tr>
                    <th>Serial No</th>
                    <th>Name</th>
                    <th>Mobile No</th>
                    <th>GST No</th>
                    <th>Address</th>
                    <th>Created Date And Time</th>
                    <th>Updated Date And Time</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $serial_no = 0;
                if ($sql = mysqli_query($conn, "Select * from supplier where status = 'active'")) {
                    while ($row = mysqli_fetch_assoc($sql)) {
                        $serial_no++;
                ?>
                        <tr>
                            <td><?php echo $serial_no; ?></td>
                            <td><?php echo ($row['supplier_name']); ?></td>
                            <td><?php echo ($row['mobile_no']); ?></td>
                            <td><?php echo ($row['gst_no']); ?></td>
                            <td><?php echo ($row['address']); ?></td>
                            <td><?php echo date("d-m-Y h:i:s A", strtotime($row['create_date_time'])) ?></td>
                            <td><?php echo date("d-m-Y h:i:s A", strtotime($row['update_date_time'])) ?></td>
                            <td>
                                <button class="btn btn-primary" onclick="Edit(<?php echo $row['supplier_id']; ?>)">Edit <i class="bi bi-arrow-repeat"></i></button>
                                <button class="btn btn-danger ms-1" onclick="deletesupplier(<?php echo $row['supplier_id']; ?>)">Delete <i class="bi bi-trash3-fill"></i></button>
                            </td>
                        </tr>
                <?php }
                } ?>
            </tbody>
        </table>
    </div>
<?php } ?>
<?php if ($op_code == 2) { ?>
    <div class="bg-dark p-5" style="margin: auto; width: 600px;">
        <h1 class="mb-3">Add Supplier</h1>
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Supplier Name</label>
            <input type="text" class="form-control bg-muted p-3" autocomplete="off" id="sname" placeholder="Enter Supplier Name" name="sname">
        </div>
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Supplier Mobile No</label>
            <input type="text" class="form-control bg-muted p-3" autocomplete="off" id="mobileno" placeholder="Enter Supplier Mobile No" name="mobileno">
        </div>
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Supplier GST No</label>
            <input type="text" class="form-control bg-muted p-3" autocomplete="off" id="gstno" placeholder="Enter Supplier GST No" name="gstno">
        </div>
        <div class="mb-3">
            <label for="exampleFormControlTextarea1" class="form-label">Supplier Address</label>
            <textarea class="form-control" id="address" autocomplete="off" placeholder="Enter Supplier Address" rows="3" name="address"></textarea>
        </div>
        <div>
            <button class="btn btn-success mt-3" onclick="submitsupplier()" type="button" name="submit">Save</button>
            <button class="btn btn-danger mt-3 ms-2" onclick="clearsupplier()" type="button" name="clear">clear</button>
        </div>
    </div>
<?php } ?>
<?php
if ($op_code == 3) {
    $sql_check = "SELECT * FROM supplier WHERE gst_no = '$gst_no' AND status = 'active'";
    $result_check = mysqli_query($conn, $sql_check);
    if (mysqli_num_rows($result_check) > 0) {
        echo "The GST Number already exists";
    } else {
        $sql_insert = "INSERT INTO supplier (supplier_name,mobile_no,gst_no,address) VALUES ('$name','$mobileno','$gst_no','$address')";
        if (mysqli_query($conn, $sql_insert)) {
            echo "Added successfully";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }
} ?>
<?php
if ($op_code == 4) {
    $sql = "UPDATE supplier SET status = 'inactive' WHERE supplier_id = '$supplier_id'";

    if (!mysqli_query($conn, $sql)) {
        echo mysqli_error($conn);
    } else {
        echo "Deleted Successfully";
    }
} ?>
<?php
if ($op_code == 5) {
    $supplier_id = $_REQUEST['supplier_id'];
    $sql = "SELECT * FROM supplier WHERE supplier_id = $supplier_id";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        if ($row = mysqli_fetch_assoc($result)) {
            $supplier_name = $row['supplier_name'];
            $mobile_no = $row['mobile_no'];
            $gst_no = $row['gst_no'];
            $address = $row['address'];
        }
    } ?>
    <div class="bg-dark p-5" style="margin: auto; width: 600px;">
        <h1 class="mb-3">Update Supplier Details</h1>
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Supplier Name</label>
            <input type="text" class="form-control bg-muted p-3" autocomplete="off" id="sname" placeholder="Enter Supplier Name" name="sname" value="<?php echo $supplier_name ?>">
        </div>
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Supplier Mobile No</label>
            <input type="text" class="form-control bg-muted p-3" autocomplete="off" id="mobileno" placeholder="Enter Supplier Mobile No" name="mobileno" value="<?php echo $mobile_no ?>">
        </div>
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Supplier GST No</label>
            <input type="text" class="form-control bg-muted p-3" autocomplete="off" id="gstno" placeholder="Enter Supplier GST No" name="gstno" value="<?php echo $gst_no ?>">
        </div>
        <div class="mb-3">
            <label for="exampleFormControlTextarea1" class="form-label">Supplier Address</label>
            <textarea class="form-control" id="address" autocomplete="off" placeholder="Enter Supplier Address" rows="3" name="address"><?php echo $address ?></textarea>
        </div>
        <div>
            <button class="btn btn-success mt-3" onclick="update(<?php echo $supplier_id; ?>)" type="button" name="submit">Update</button>
            <button class="btn btn-danger mt-3 ms-2" onclick="clearsupplier()" type="button" name="clear">clear</button>
        </div>
    </div>
<?php } ?>
<?php
if ($op_code == 6) {

    $sql = "UPDATE supplier SET supplier_name = '$name' , address = '$address', mobile_no = $mobileno, gst_no = '$gst_no' WHERE supplier_id = $supplier_id";

    if (!mysqli_query($conn, $sql)) {
        echo mysqli_error($conn);
    } else {
        echo "Update successfully";
    }
}
?>
<?php
if ($op_code == 7) { ?>

    <?php include("../../../includes/config.php");
    require('../../../includes/excelReader/excel_reader2.php');
    require('../../../includes/excelReader/SpreadsheetReader.php'); ?>

    <h1 style="width: 70%; margin:auto;" class="mb-4">Excel Import</h1>

    <?php if (!isset($show_table)) { ?>
        <div style="width: 70%; margin:auto;">
            <input style="display: inline; width: auto;" ; type="file" class="form-control" id="excel" name="excel" required>
            <button class="btn btn-primary" type="button" onclick="excel_import()" name="import">Import <i class="bi bi-box-arrow-in-down"></i></button>
        </div>
    <?php } ?>

    <?php if (!isset($show_table)) { ?>
        <div class="bg-dark mt-4 p-5" style="margin:auto; width: 70%; ">
            <p class="h1">preview table</p>
            <table id="table" border="1">

                <thead>
                    <tr style="text-align:center;">
                        <th>S.NO</th>
                        <th>SUPPLIER NAME</th>
                        <th>ADDRESS</th>
                        <th>MOBILE NO</th>
                        <th>GST NO</th>
                    </tr>
                </thead>
        </div>
    <?php } else { ?>
        <div class="container mt-4">
            <div class="bg-dark p-5">
                <table id="table" border="1">
                    <thead>
                        <tr style="text-align:center;">
                            <th>S.NO</th>
                            <th>SUPPLIER NAME</th>
                            <th>ADDRESS</th>
                            <th>MOBILE NO</th>
                            <th>GST NO</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $fileName = $_FILES["excel"]["name"];
                        $fileExtension = explode('.', $fileName);
                        $fileExtension = strtolower(end($fileExtension));
                        $newFileName = date("Y.m.d") . " - " . date("h.i.sa") . "." . $fileExtension;

                        $targetDirectory = "../../../includes/upload/" . $newFileName;
                        move_uploaded_file($_FILES['excel']['tmp_name'], $targetDirectory);

                        $reader = new SpreadsheetReader($targetDirectory);
                        $sno = 0;
                        foreach ($reader as $key => $row) {
                            $name = $row[0];
                            $address = $row[1];
                            $mobile = $row[2];
                            $gst = $row[3];

                            $sno += 1;
                            echo "<tr style='text-align:center;'>";
                            echo "<td>" . $sno . "</td>";
                            echo "<td>" . $name . "</td>";
                            echo "<td>" . $address . "</td>";
                            echo "<td>" . $mobile . "</td>";
                            echo "<td>" . $gst . "</td>";
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
                <button class="btn btn-success" onclick="submit_excel_to_sql('<?php echo htmlspecialchars($targetDirectory, ENT_QUOTES, 'UTF-8'); ?>')" style="float: right; margin-right: 10px; margin-bottom: 10px;">Submit <i class="bi bi-box-arrow-in-down"></i></button>
            </div>
    <?php }
} ?>
    <?php if ($op_code == 8) {
        require('../../../includes/excelReader/excel_reader2.php');
        require('../../../includes/excelReader/SpreadsheetReader.php');
        $reader = new SpreadsheetReader($targetDirectory);
        foreach ($reader as $key => $row) {
            $name = $row[0];
            $address = $row[1];
            $mobile = $row[2];
            $gst = $row[3];
            mysqli_query($conn, "INSERT INTO supplier (`supplier_name`,`address`,`mobile_no`,`gst_no` ) VALUES('$name', '$address', '$mobile', '$gst')");
        }
        echo ("Added Successfully");
    } ?>