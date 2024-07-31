<?php
include("../../../includes/config.php");
extract($_REQUEST);
?>
<?php if ($op_code == 1) { ?>
    <h1 class="text-light mb-4">Category
        <button type="button" onclick="Import()" class="btn btn-success ms-2">Import <i class="bi bi-box-arrow-in-down"></i></button>
    </h1>
    <div class="p-2 bg-dark">
        <table id="table1" width="auto" height="auto">
            <thead>
                <tr>
                    <th>Serial No</th>
                    <th>Category Name</th>
                    <th>Created Date And Time</th>
                    <th>Updated Date And Time</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody id="table_bdy">
                <?php
                $query = "SELECT * FROM category WHERE status = 'active' ORDER BY category_id";
                $execute = mysqli_query($conn, $query);

                $serial_no = 0;

                if ($execute && mysqli_num_rows($execute) > 0) {
                    while ($result = mysqli_fetch_assoc($execute)) {
                        $serial_no++; ?>
                        <tr>
                            <td><?php echo $serial_no; ?></td>
                            <td>
                                <?php if (!((isset($op_code_update)) && ($update_id == $result['category_id']))) { ?>
                                    <span class='category_name'><?php echo ($result['category_name']); ?></span>
                                <?php } ?>
                                <?php if ((isset($op_code_update)) && ($update_id == $result['category_id'])) { ?>
                                    <input type="text" name="update_category_name" id="update_text" value="<?php echo $result['category_name']; ?>" placeholder="Update new category" autocomplete="off" class="form-control">
                                <?php } ?>
                            </td>
                            <td><?php echo $result['create_date_time']; ?></td>
                            <td><?php echo $result['update_date_time']; ?></td>
                            <td>
                                <?php if (!((isset($op_code_update)) && ($update_id == $result['category_id']))) { ?>
                                    <button id='edit_button' type="button" onclick="edit_category(<?php echo $result['category_id']; ?>)" class='btn edit_button btn-primary me-2 px-3'>Edit</button>
                                    <button onclick="delete_category(<?php echo $result['category_id']; ?>)" type="button" class='btn delete_button btn-danger px-3'>Delete</button>
                                <?php } ?>
                                <?php if ((isset($op_code_update)) && ($update_id == $result['category_id'])) { ?>
                                    <button id='update_button' type="button" onclick="update_category(<?php echo $result['category_id']; ?>)" class='btn update_button btn-success me-2 px-3'>Update</button>
                                    <button onclick="cancel()" type="button" class='btn cancel_button btn-secondary px-3'>Cancel</button>
                                <?php } ?>
                            </td>
                        </tr>
                <?php  }
                } ?>
                <?php if (isset($op_code_add)) { ?>
                    <tr>
                        <td><?php echo $serial_no + 1; ?></td>
                        <td>
                            <input type="text" name="add_category_name" id="add_text" placeholder="Add new category" autocomplete="off" class="form-control">
                        </td>
                        <td><button id='add_button' onclick="addcategory()" type="button" class='btn btn-success px-5'>Add</button></td>
                        <td></td>
                        <td></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
<?php } ?>
<?php
if ($op_code == 2) {
    $sql_query = "SELECT * FROM category WHERE category_name = '$category_name' AND status = 'active'";

    if ($result = mysqli_query($conn, $sql_query)) {
        if (mysqli_num_rows($result) > 0) {
            echo "Category name already exists";
        } else {
            $sql = "INSERT INTO category (category_name) VALUES ('$category_name')";
            if (mysqli_query($conn, $sql)) {
                echo "Added successfully";
            } else {
                echo mysqli_error($conn);
            }
        }
    } else {
        echo mysqli_error($conn);
    }
}
?>
<?php
if ($op_code == 3) {

    $sql_query = "SELECT * FROM category WHERE category_name = '$category_name' AND status = 'active'";

    if ($result = mysqli_query($conn, $sql_query)) {
        if (mysqli_num_rows($result) > 0) {
            echo "Category name already exists";
        } else {
            $sql = "UPDATE category SET category_name = '$category_name' WHERE category_id = '$category_id'";
            if (mysqli_query($conn, $sql)) {
                echo "Update successfully";
            } else {
                echo mysqli_error($conn);
            }
        }
    } else {
        echo mysqli_error($conn);
    }
} ?>
<?php
if ($op_code == 4) {
    $sql = "UPDATE category SET status = 'inactive' WHERE category_id = '$category_id'";
    if (mysqli_query($conn, $sql)) {
        echo "Deleted successfully";
    } else {
        echo mysqli_error($conn);
    }
} ?>
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
                        <th>CATEGORY NAME</th>
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
                            <th>CATEGORY NAME</th>
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
                            $sno += 1;
                            echo "<tr style='text-align:center;'>";
                            echo "<td>" . $sno . "</td>";
                            echo "<td>" . $name . "</td>";
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
            $rollno = $row[1];
            $class = $row[2];
            $section = $row[3];

            mysqli_query($conn, "INSERT INTO category (`category_name`) VALUES('$name')");
        }
        echo ("Added Successfully");
    } ?>