<?php include("../../../includes/config.php");
extract($_REQUEST) ?>
<?php if ($op_code == 1) { ?>
    <h1 class="mb-3">List Books <button type="submit" onclick="addbook()" class="btn btn-success ms-2">Add Book <i class="bi bi-plus-circle"></i> </button>
        <button type="submit" onclick="graph()" class="btn btn-success ms-2">Import Graph</button>
    </h1>
    <div class="tbl p-3" style="background-color: #222831; color :aliceblue; width: auto;">
        <table id="example">
            <thead>
                <tr>
                    <th>Serial No</th>
                    <th>Book Name</th>
                    <th>Image</th>
                    <th>Category Name</th>
                    <th>Created Date And Time</th>
                    <th>Updated Date And Time</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $serial_no = 0;
                $query1 = "Select * from book join category on book.category_id = category.category_id where book.status = 'active' and category.status = 'active'";
                if ($sql = mysqli_query($conn, $query1)) {
                    while ($row = mysqli_fetch_assoc($sql)) {
                        $serial_no++;
                ?>
                        <tr>
                            <td><?php echo $serial_no; ?></td>
                            <td><?php echo $row['book_name']; ?></td>
                            <td><img src="../../../images/bk_images/<?php echo $row['image']; ?>" height="100px" width="100px" alt="book"></td>

                            <?php
                            $sql1 = "SELECT category_name FROM category WHERE category_id =" . $row['category_id'];
                            $result = mysqli_query($conn, $sql1);
                            if (mysqli_num_rows($result) > 0) {
                                if ($row1 = mysqli_fetch_assoc($result)) {
                            ?>
                                    <td><?php echo $row1['category_name']; ?></td>
                            <?php
                                }
                            }
                            ?>

                            <td><?php echo date("d-m-Y h:i:s A", strtotime($row['create_date_time'])); ?></td>
                            <td><?php echo date("d-m-Y h:i:s A", strtotime($row['update_date_time'])); ?></td>
                            <td>
                                <button class="btn btn-success" title="Click me to update this Book." onclick="update(<?php echo $row['book_id']; ?>)" type="submit" name="update">Update <i class="bi bi-arrow-repeat"></i></button>
                                <button class="btn btn-danger" title="Click me to delete this Book." onclick="deletebook(<?php echo $row['book_id']; ?>)" type="submit" name="delete">Delete <i class="bi bi-trash3-fill"></i></button>
                            </td>
                        </tr>
                <?php
                    }
                }
                ?>

            </tbody>
        </table>
    </div>
<?php } ?>
<?php if ($op_code == 2) { ?>
    <div class="bg-dark p-5" style="width: 50%; margin: auto;">

        <h1 class="mb-2">Add Book</h1>

        <input type="text" class="form-control p-3" id="bname" autocomplete="off" placeholder="Enter Book Name" name="bname">

        <div class="mb-3 mt-2">
            <label for="exampleFormControlInput1" class="form-label text-white">Upload Your Book Image</label>
            <input type="file" class="form-control bg-muted p-3" id="book_img" name="book_img" accept=".jpg, .jpeg, .png">
        </div>

        <div class="mb-3 mt-4">
            <label for="category" class="form-label text-white">Select a Book category</label>
            <select class="form-select form-select-lg mb-3" aria-label=".form-select-lg example" id="category" name="category">
                <option value="">Select a category</option>
                <?php
                $query = "SELECT * FROM category WHERE status = 'active'";
                $result = mysqli_query($conn, $query);

                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<option value='" . $row['category_id'] . "'>" . $row['category_name'] . "</option>";
                }
                ?>
            </select>
        </div>

        <div>
            <button class="btn btn-success mt-3" onclick="add_book()" type="button" name="submit">Save</button>
            <button class="btn btn-danger mt-3 ms-2" onclick="cancel()" type="button" name="reset">cancel</button>
        </div>

    </div>
<?php } ?>
<?php if ($op_code == 3) {
    if (isset($_REQUEST['add_newbook'])) {
        $bname = $_REQUEST['bname'];
        $category = $_REQUEST['category'];
        $book_img = $_FILES['book_img']['name'];
        $temp = $_FILES['book_img']['tmp_name'];
        $folder = "../../../images/bk_images/" . $book_img;

        $sql_query = "SELECT * FROM book";
        $result = mysqli_query($conn, $sql_query);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $book_name = $row['book_name'];
                $status = $row['status'];

                if ($book_name == $bname) {

                    if ($status == 'active') {
                        echo ('The Book Name is Already Exists');
                    }
                    break;
                }
            }
        }
        if (move_uploaded_file($temp, $folder)) {
            $sql = "INSERT INTO book (book_name, image, category_id) VALUES ('$bname', '$book_img', '$category')";


            if (mysqli_query($conn, $sql)) {
                echo "Book Added successfully";
            } else {
                echo mysqli_error($conn);
            }
        } else {
            echo "Error uploading file.";
        }
    }
} ?>
<?php if ($op_code == 4) {

    $sql = "UPDATE book SET status = 'inactive' WHERE book_id = '$book_id'";

    if (!mysqli_query($conn, $sql)) {
        echo mysqli_error($conn);
    } else {
        echo "Deleted Successfully";
    }
} ?>
<?php if ($op_code == 5) {

    $sql = "SELECT * FROM book WHERE book_id = $book_id";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        if ($row = mysqli_fetch_assoc($result)) {
            $book_name = $row['book_name'];
            $category_id = $row['category_id'];
            $image = $row['image'];
        }
    }

?>
    <div class="bg-dark p-5" style="width: 50%; margin: auto;">

        <h1 class="mb-2">Update Book</h1>

        <input type="text" class="form-control p-3" id="bname" autocomplete="off" placeholder="Enter Book Name" value="<?php echo $book_name ?>" name="bname">

        <div class="mb-3 mt-2">
            <label for="exampleFormControlInput1" class="form-label text-white">Upload Your Book Image</label>
            <input type="file" class="form-control bg-muted p-3" id="book_img" name="book_img" accept=".jpg, .jpeg, .png">
        </div>

        <div class="mb-3 mt-4">
            <label for="category" class="form-label text-white">Select a Book category</label>
            <select class="form-select form-select-lg mb-3" aria-label=".form-select-lg example" id="category" name="category">
                <option value="">Select a category</option>
                <?php
                $query = "SELECT * FROM category WHERE status = 'active'";
                $result = mysqli_query($conn, $query);

                while ($row = mysqli_fetch_assoc($result)) {
                    $selected = ($row['category_id'] == $category_id) ? "selected" : "";
                    echo "<option value='" . $row['category_id'] . "' $selected>" . $row['category_name'] . "</option>";
                }
                ?>
            </select>
        </div>

        <div>
            <button class="btn btn-success mt-3" onclick="update_book(<?php echo $book_id; ?>)" type="button" name="submit">Save</button>
            <button class="btn btn-danger mt-3 ms-2" onclick="cancel()" type="button" name="reset">cancel</button>
        </div>
    </div>
<?php } ?>
<?php
if ($op_code == 6) {
    if (isset($_REQUEST['update_newbook'])) {


        $bname = $_REQUEST['bname'];
        $category = $_REQUEST['category'];

        if (isset($_FILES['book_img'])) {
            $book_img = $_FILES['book_img']['name'];
            $temp = $_FILES['book_img']['tmp_name'];
            $folder = "../../../images/bk_images/" . $book_img;

            if (move_uploaded_file($temp, $folder)) {
                $sql = "UPDATE book SET book_name = '$bname', image = '$book_img', category_id = '$category'  WHERE book_id = '$book_id'";
            } else {
                echo "Failed to move uploaded file.";
                exit;
            }
        } else {
            $sql = "UPDATE book SET book_name = '$bname', category_id = '$category'  WHERE book_id = '$book_id'";
        }

        if (!mysqli_query($conn, $sql)) {
            echo mysqli_error($conn);
        } else {
            echo "Book Update Successfully";
        }
    }
}
?>
<?php
if ($op_code == "graph") {





}
?>