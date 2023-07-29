<?php
include "menu.php";

if (isset($_POST['submit']) && isset($_FILES['notice_image'])) {
    echo "<pre>";
    print_r($_FILES['notice_image']);
    echo "</pre>";

    //image properties
    $img_name = $_FILES['notice_image']['name'];
    $img_size = $_FILES['notice_image']['size'];
    $tmp_name = $_FILES['notice_image']['tmp_name'];
    $error = $_FILES['notice_image']['error'];

    //checking for the images errors
    if ($error === 0) {
        //calling the database connection file
        include "db_conn.php";

        if ($img_size > 5000000) {
            $img_error = "The chosen file is too large!";
            header("Location: index.php?error=$img_error");
        } else {
            $img_ext = pathinfo($img_name, PATHINFO_EXTENSION);
            $img_ext_loc = strtolower($img_ext);

            $allowed_ext = array("jpg", "jpeg", "png");

            if (in_array($img_ext_loc, $allowed_ext)) {
                $new_img_name = uniqid("IMG-", true) . '.' . $img_ext_loc;
                $img_upload_path = 'uploads/' . $new_img_name;

                //inserting into a database
                $insert_image_query = "INSERT INTO notices(image_url)
                                       VALUES('$new_img_name')";

                mysqli_query($conn,$insert_image_query);
                header("Location: view.php");
                // $statement = mysqli_prepare($conn, $insert_image_query);

                // if ($statement === FALSE) {
                //     echo $conn->error;
                // } else {
                //     mysqli_stmt_bind_param($statement, "s", $img_name);
                //     mysqli_stmt_execute($statement);
                //     header("Location: view.php");
                // }

                move_uploaded_file($tmp_name, $img_upload_path);
            } else {
                $img_error = "You cannot uppload files of this type!";
                header("Location: index.php?error=$img_error");
            }
        }
    } else {
        $img_error = "Unknown error occurred!";
        header("Location: index.php?error=$img_error");
    }
} else {
    header("Location: index.php");
}
