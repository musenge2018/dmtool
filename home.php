<?php
include "menu.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online notice board</title>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Big+Shoulders+Stencil+Display:wght@500&display=swap');

        * {
            padding: 0;
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
        }

        form {
            background-color: rgba(105, 110, 113, 0.4);
            width: 35%;
            padding: 2%;
            display: block;
            border-radius: 10px;

            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);

        }

        .form input {
            width: 100%;
            border: none;
            margin: 2% 0;
        }

        ::-webkit-file-upload-button {
            background: rgba(133, 227, 254, 0.8);
            color: #696e71;
            padding: 0.7em 2em;
            border: none;
            cursor: pointer;
        }

        .form h2 {
            font-family: 'Big Shoulders Stencil Display', cursive;
            padding: 2%;
            margin-bottom: 10px;
            font-weight: lighter;
            font-size: 30px;
        }

        .form input[type=submit] {
            background-color: rgba(133, 227, 254, 0.8);
            padding: 2.5%;
            width: 50%;
            cursor: pointer;
            color: #696e71;
            border-radius: 30px;
        }

        .form input[type=submit]:hover {
            background-color: rgba(133, 227, 254, 0.6);
        }

        .form {
            margin-top: 10%;
        }

        form {
            margin: auto;
        }

        p {
            color: red;
        }

        .upload-wraper {
            width: 100%;
            background: linear-gradient(135deg,
                    rgba(133, 227, 254, 0.5) 0%,
                    rgba(133, 227, 254, 0.5) 100%),
                url("./images/background.jpg") center no-repeat fixed;
            background-size: cover;
            position: absolute;
            height: 100vh;
        }

        @media only screen and (max-width:600px) {
            form {
                background-color: rgba(105, 110, 113, 0.4);
                margin: auto;
                width: 90%;
                padding: 2%;
                display: block;
                border-radius: 10px;
                align-items: center;
            }
        }
    </style>
</head>

<body>
    <div class="upload-wraper">
        <div class="form">
            <form action="upload.php" method="POST" enctype="multipart/form-data">
                <h2>Upload adverts here</h2>
                <?php if (isset($_GET['error'])) : ?>
                    <p><?php echo $_GET['error']; ?></p>
                <?php endif ?>
                <input type="file" name="notice_image" id="" required>
                <input type="submit" name="submit" value="Upload">
            </form>
        </div>
    </div>
</body>

</html>