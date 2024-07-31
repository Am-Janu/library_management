<?php include("../../../includes/config.php");
extract($_REQUEST); ?>
<?php
if ($op_code == 1) { ?>

    <h1 class="mb-3 pt-3 ps-3">List Students <button type="button" onclick="addstudent()" class="btn btn-success ms-2">Add Student <i class="bi bi-person-plus"></i> </button>
        <button type="button" onclick="Import()" class="btn btn-success ms-2">Import <i class="bi bi-box-arrow-in-down"></i></button>
    </h1>
    <div class="row mt-5 pt-3 bg-dark" style="margin-bottom: 110px; width: auto;">
        <table id="table1">
            <thead>
                <tr>
                    <th>Serial No</th>
                    <th>Name</th>
                    <th>Roll No</th>
                    <th>Class</th>
                    <th>Section</th>
                    <th>Created Date And Time</th>
                    <th>Updated Date And Time</th>
                    <th>Update</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $serial_no = 0;
                if ($sql = mysqli_query($conn, "SELECT * FROM student WHERE status = 'active'")) :
                    while ($row = mysqli_fetch_assoc($sql)) :
                        $serial_no++;
                ?>
                        <tr>
                            <td><?php echo $serial_no; ?></td>
                            <td><?php echo ($row['student_name']); ?></td>
                            <td><?php echo ($row['roll_no']); ?></td>
                            <td><?php echo ($row['class']); ?></td>
                            <td><?php echo ($row['section']); ?></td>
                            <td><?php echo date("d-m-Y h:i:s A", strtotime($row['create_date_time'])); ?></td>
                            <td><?php echo date("d-m-Y h:i:s A", strtotime($row['update_date_time'])); ?></td>
                            <td>
                                <button class="btn btn-success" title="Click me to update this Student." onclick="update(<?php echo $row['student_id']; ?>)">
                                    Update <i class="bi bi-arrow-repeat"></i>
                                </button>
                            </td>
                            <td>
                                <button class="btn btn-danger" title="Click me to delete this Student." onclick="deletestudent(<?php echo $row['student_id']; ?>)">
                                    Delete <i class="bi bi-trash3-fill"></i>
                                </button>
                            </td>
                        </tr>
                <?php
                    endwhile;
                endif;
                ?>
            </tbody>
        </table>
    </div>
<?php } ?>
<?php
if ($op_code == 2) { ?>
    <div style="margin:auto; width: 50%;">
        <h1 class="mb-3">Add Student</h1>
        <input type="text" class="form-control p-3 mb-3" autocomplete="off" id="name" placeholder="Enter Student Name" name="sname">
        <input type="text" class="form-control p-3" autocomplete="off" id="rollno" placeholder="Enter Student Roll No" name="rollno">
        <select class="form-select form-select-lg mt-3 p-2" aria-label="Large select example" id="s_class" name="s_class">
            <option value="">Select Class</option>
            <option value="1">One</option>
            <option value="2">Two</option>
            <option value="3">Three</option>
            <option value="4">Four</option>
            <option value="5">Five</option>
        </select>
        <select class="form-select form-select-lg mt-3 p-2" aria-label="Large select example" id="section" name="section">
            <option value="">Select Section</option>
            <option value="A">A</option>
            <option value="B">B</option>
            <option value="C">C</option>
            <option value="D">D</option>
            <option value="E">E</option>
        </select>
        <div>
            <button class="btn btn-success mt-3" type="button" onclick="validateAndSubmit()">Save</button>
            <button class="btn btn-danger mt-3 ms-2" type="button" onclick="clearFields()">Clear</button>
        </div>
    </div>
<?php } ?>
<?php
if ($op_code == 3) {
    $sql_check = "SELECT * FROM student WHERE roll_no = '$rollno' AND status = 'active'";
    $result_check = mysqli_query($conn, $sql_check);
    if (mysqli_num_rows($result_check) > 0) {
        echo "The Roll Number already exists";
    } else {
        $sql_insert = "INSERT INTO student (student_name, roll_no, class, section) VALUES ('$student_name', '$rollno', '$s_class', '$section')";
        if (mysqli_query($conn, $sql_insert)) {
            echo "Added successfully";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }
} ?>
<?php
if ($op_code == 4) {
    $sql = "UPDATE student SET status = 'inactive' WHERE student_id = '$student_id'";

    if (!mysqli_query($conn, $sql)) {
        echo mysqli_error($conn);
    } else {
        echo "Deleted Successfully";
    }
} ?>
<?php
if ($op_code == 5) { ?>
    <?php
    $student_id = $_REQUEST['student_id'];
    $sql = "SELECT * FROM student WHERE student_id = $student_id";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        if ($row = mysqli_fetch_assoc($result)) {
            $name = $row['student_name'];
            $rollno = $row['roll_no'];
            $class = $row['class'];
            $section = $row['section'];
        }
    }
    ?>
    <div style="margin:auto; width: 50%;">
        <h1 class="mb-3">Update Student</h1>

        <input type="text" class="form-control p-3 mb-3" autocomplete="off" id="name" placeholder="Enter Student Name" name="sname" value="<?php echo $name ?>">
        <input type="text" class="form-control p-3" autocomplete="off" id="rollno" placeholder="Enter Student Roll No" name="rollno" value="<?php echo $rollno ?>">


        <select class="form-select form-select-lg mt-3 p-2" aria-label="Large select example" id="s_class" name="sclass">
            <option value="">Select Class</option>
            <option value="1" <?php if ($class == '1') echo 'selected' ?>>One</option>
            <option value="2" <?php if ($class == '2') echo 'selected' ?>>Two</option>
            <option value="3" <?php if ($class == '3') echo 'selected' ?>>Three</option>
            <option value="4" <?php if ($class == '4') echo 'selected' ?>>Four</option>
            <option value="5" <?php if ($class == '5') echo 'selected' ?>>Five</option>
        </select>
        <select class="form-select form-select-lg mt-3 p-2" aria-label="Large select example" id="section" name="section">
            <option value="">Select Section</option>
            <option value="A" <?php if ($section == 'A') echo 'selected' ?>>A</option>
            <option value="B" <?php if ($section == 'B') echo 'selected' ?>>B</option>
            <option value="C" <?php if ($section == 'C') echo 'selected' ?>>C</option>
            <option value="D" <?php if ($section == 'D') echo 'selected' ?>>D</option>
            <option value="E" <?php if ($section == 'E') echo 'selected' ?>>E</option>
        </select>
        <div>
            <button class="btn btn-success mt-3" type="button" onclick="validateAndSubmitupdate(<?php echo $student_id ?>)">Save</button>
            <button class="btn btn-danger mt-3 ms-2" type="button" onclick="clearFieldsupdate(<?php echo $student_id ?>)">Clear</button>
        </div>
    </div>
<?php } ?>
<?php
if ($op_code == 6) {

    $sql = "UPDATE student SET student_name = '$name' , roll_no = '$roll_no', class = '$s_class', section = '$section' WHERE student_id = '$student_id'";

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
                        <th>STUDENT NAME</th>
                        <th>ROLL NO</th>
                        <th>CLASS</th>
                        <th>SECTION</th>
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
                        <th>STUDENT NAME</th>
                        <th>ROLL NO</th>
                        <th>CLASS</th>
                        <th>SECTION</th>
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
                            $rollno = $row[1];
                            $class = $row[2];
                            $section = $row[3];

                            $sno += 1;
                            echo "<tr style='text-align:center;'>";
                            echo "<td>" . $sno . "</td>";
                            echo "<td>" . $name . "</td>";
                            echo "<td>" . $rollno . "</td>";
                            echo "<td>" . $class . "</td>";
                            echo "<td>" . $section . "</td>";
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

            mysqli_query($conn, "INSERT INTO student (`student_name`,`roll_no`,`class`,`section` ) VALUES('$name', '$rollno', '$class', '$section')");
        }
        echo ("Added Successfully");
    } ?>