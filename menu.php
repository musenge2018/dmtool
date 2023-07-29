<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/c9653721ea.js" crossorigin="anonymous"></script>
    <title>Menu</title>
</head>
<style>
    * {
        padding: 0;
        margin: 0;
        text-decoration: none;
        list-style: none;
        box-sizing: border-box;
    }

    body {
        font-family: Arial, Helvetica, sans-serif;
    }

    nav {
        background-color: rgba(106, 109, 113, 0.7);
        height: 80px;
        width: 100%;
    }

    nav img {
        height: 70px;
        padding: 0.5% 2%;
    }

    nav ul {
        float: right;
        margin-right: 20px;
    }

    nav ul li {
        display: inline;
        line-height: 80px;
        margin: 0 2px;
    }

    nav ul li a {
        color: #dcdde1;
        padding: 7px 13px;
        border-radius: 3px;
    }

    nav ul li a i {
        padding: 0 5px;
        color: #353b48;
    }

    a.active,
    a:hover {
        background-color: #64868d;
        transition: .5s;
    }

    .checkbtn {
        font-size: 30px;
        color: #dcdde1;
        float: right;
        line-height: 80px;
        margin-right: 20px;
        cursor: pointer;
        display: none;
    }

    #check {
        display: none;
    }

    /**Responsive styling */
    @media (max-width:952px) {
        nav ul li a {
            font-size: 15px;
        }
    }

    @media (max-width:858px) {
        .checkbtn {
            display: block;
        }

        ul {
            position: fixed;
            width: 100%;
            height: 100vh;
            background: #6a6d71;
            top: 80px;
            left: -100%;
            text-align: left;
            transition: all .5s;
        }

        nav ul li {
            display: block;
            line-height: 60px;
            border-bottom: 1px solid #8c9490;
        }

        nav ul li a {
            font-size: 15px;
            padding: 10px;
        }

        a:hover,
        a.active {
            background: none;
        }

        nav ul li a i {
            padding: 0 2%;
            color: #70b8d3;
        }

        #check:checked~ul {
            left: 0;
        }
    }
</style>

<body>
    <nav class="logo">
        <input type="checkbox" id="check">
        <label class="checkbtn" for="check">
            <i class="fas fa-bars"></i>
        </label>
        <img src="./images/logo.png" alt="">
        <ul>
            <li><a href="upload.php" class="active"><i class="fa fa-upload" aria-hidden="true"></i>Upload advert</a></li>
            <li><a href="signup.php"><i class="fa fa-id-card-o" aria-hidden="true"></i>Add user</a></li>
            <li><a href="view_adverts.php"><i class="fa fa-television" aria-hidden="true"></i>Notice board</a></li>
            <li><a href="view.php"><i class="fa fa-list-alt" aria-hidden="true"></i>Notices</a></li>
            <li><a href="index.php"><i class="fa fa-sign-out" aria-hidden="true"></i>Logout</a></li>
        </ul>
    </nav>
</body>

</html>