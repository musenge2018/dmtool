<?php include "db_conn.php" ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <title>Notice board</title>

    <style>
        * {
            margin: 0;
            padding: 0;
        }

        .container {
            width: 100%;
            padding: 0px;
            /* border-top: 3px solid #696e71;
            border-left: 4px solid #696e71;
            border-right: 4px solid #696e71; */
            height: 100vh;
            background: linear-gradient(135deg,
                    rgba(133, 227, 254, 0.5) 0%,
                    rgba(133, 227, 254, 0.5) 100%),
                url("./images/background.jpg") center no-repeat fixed;
            background-size: cover;
            position: absolute;
        }

        .item {
            height: 100vh;
        }

        img {
            height: 600px;
            margin: auto;
            padding: 0px;
        }

        .bottom {
            position: absolute;
            bottom: 0px;
            right: 0px;
            width: 100%;
        }

        marquee p {
            margin: auto;
            color: #696e71;
            font-size: 15px;
        }

        p span {
            color: royalblue;
        }

        marquee {
            width: 100%;
            background-color: rgba(133, 227, 254, 0.8);
            padding: 0.4%;
            margin: 0;
        }

        .notice-slide{
            width: 100vh;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }
    </style>
</head>

<body>
    <!-- <a href="index.php">&#8592;</a> -->
    <?php
    function make_query($conn)
    {
        $sql = "SELECT * FROM notices ORDER BY notice_id DESC";
        $results = mysqli_query($conn, $sql);
        return $results;
    }

    function make_slide_indicators($connect)
    {
        $output = '';
        $count = 0;
        $result = make_query($connect);
        while ($row = mysqli_fetch_array($result)) {
            if ($count == 0) {
                $output .= '
   <li data-target="#dynamic_slide_show" data-slide-to="' . $count . '" class="active"></li>
   ';
            } else {
                $output .= '
   <li data-target="#dynamic_slide_show" data-slide-to="' . $count . '"></li>
   ';
            }
            $count = $count + 1;
        }
        return $output;
    }

    function make_slides($connect)
    {
        $output = '';
        $count = 0;
        $result = make_query($connect);
        while ($row = mysqli_fetch_array($result)) {
            if ($count == 0) {
                $output .= '<div class="item active">';
            } else {
                $output .= '<div class="item">';
            }
            $output .= '
            <img class="notice-slide" src="uploads/' . $row["image_url"] . '" alt="" />
            <div class="carousel-caption">
                <h3></h3>
            </div>
        </div>
  ';
            $count = $count + 1;
        }
        return $output;
    }

    ?>
    <div class="container">
        <div id="dynamic_slide_show" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
                <?php echo make_slides($conn); ?>

                <div class="bottom">
                    <marquee direction="right">
                        <p>Email us on: <span>adverts@icleanwalls.com</span> Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum</p>
                    </marquee>
                </div>
                <script>
                    $('.carousel').carousel({
                        interval: 5000
                    })
                </script>
            </div>
        </div>
    </div>
</body>

</html>