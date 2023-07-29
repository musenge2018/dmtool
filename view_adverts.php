<?php
include_once "db_conn.php";

//reading data from the mysql database
$sql = "SELECT * FROM notices ORDER BY notice_id ASC";
$results = mysqli_query($conn, $sql);

?>
<?php
include "menu.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notice page</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Big+Shoulders+Stencil+Display:wght@500&display=swap');
        *{
            margin: 0;
            padding: 0;
        }
        body {
            font-family: Arial, Helvetica, sans-serif;
        }

        table {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 70%;
            margin: auto;
            background-color: rgba(133, 227, 254, 0.7);
            color: #6a6d71;
        }

        .table-container{
            width: 100%;
            background: linear-gradient(135deg,
                    rgba(133, 227, 254, 0.5) 0%,
                    rgba(133, 227, 254, 0.5) 100%),
                url("./images/background.jpg") center no-repeat fixed;
            background-size: cover;
            position: absolute;
            padding-bottom: 4%;
        }

        .table-container h2{
            font-family: 'Big Shoulders Stencil Display', cursive;
            font-size: 30px;
            text-align: center;
            padding: 5%;
            color: #6a6d71;
            text-decoration: underline;
        }

        td,
        th {
            border: none;
            text-align: center;
            padding: 8px;

        }

        th{
            border-top: 3px solid rgb(140,148,144,0.8);
            border-left: 1px solid rgb(140,148,144,0.8);
            border-right: 1px solid rgb(140,148,144,0.8);
        }

        tr:nth-child(even) {
            background-color: rgb(140,148,144,0.8);
            color: #dcdde1;
        }

        table td img {
            width: 35px;
            height: 35px;
        }

    </style>
</head>

<body>
    <div class="table-container">
        <h2>Notice board notices</h2>
        <?php
        //cheking if the results statement is empty
        if (mysqli_num_rows($results) > 0) {
        ?>
            <table>
                <tr>
                    <th>Notice id</th>
                    <th>Notice image</th>
                    <th>Date posted</th>
                </tr>
                <?php
                $i = 0;
                while ($row = mysqli_fetch_array($results)) {
                ?>
                    <tr>
                        <td><?php echo $row['notice_id'] ?></td>
                        <td><img class="notice-slide" src="uploads/<?php echo $row['image_url'] ?>" alt="" /></< /td>
                        <td><?php echo $row['date'] ?></td>
                    </tr>
                <?php
                    $i++;
                } ?>
            </table>
        <?php
        } else {
            echo "<p>No results found!</p>";
        }
        ?>
    </div>
</body>

</html>