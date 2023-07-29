<?php
// Initialize the session
session_start();

// Check if the user is already logged in, if yes then redirect him to welcome page
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("location: http://localhost:8501");
    exit;
}

session_destroy();

// Include config file
require_once "db_conn.php";

// Define variables and initialize with empty values
$username = $userpassword = "";
$username_err = $password_err = $login_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Check if username is empty
    if (empty(trim($_POST["username"]))) {
        $username_err = "Please enter username.";
    } else {
        $username = trim($_POST["username"]);
    }

    // Check if password is empty
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter your password.";
    } else {
        $userpassword = trim($_POST["password"]);
    }

    // Validate credentials
    if (empty($username_err) && empty($password_err)) {
        // Prepare a select statement
        $sql = "SELECT id, username, password FROM users WHERE username = ?";

        if ($stmt = mysqli_prepare($conn, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);

            // Set parameters
            $param_username = $username;

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Store result
                mysqli_stmt_store_result($stmt);

                // Check if username exists, if yes then verify password
                if (mysqli_stmt_num_rows($stmt) === 1) {
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $id, $username, $password);

                    if (mysqli_stmt_fetch($stmt)) {
                        if (($userpassword === $password)) {
                            // Password is correct, so start a new session
                            session_start();

                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;

                            // Redirect user to welcome page
                            header("location: upload.php");
                        } else {
                            // Password is not valid, display a generic error message
                            $login_err = "Invalid username or password. Inside: ";
                            // }
                        }
                    } else {
                        // Username doesn't exist, display a generic error message
                        $login_err = "Invalid username or password .";
                    }
                } else {
                    echo "Oops! Something went wrong. Please try again later.";
                }

                // Close statement
                mysqli_stmt_close($stmt);
            }
        }

        // Close connection
        mysqli_close($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Big+Shoulders+Stencil+Display:wght@500&display=swap');

        h2 {
            font-family: 'Big Shoulders Stencil Display', cursive;
            font-size: 30px;
        }

        body {
            font: 14px sans-serif;
        }

        .wrapper {
            width: 360px;
            padding: 20px;
            background-color: rgba(105, 110, 113, 0.4);
            border-radius: 10px;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        input[type=text],
        input[type=password] {
            background-color: rgba(255, 255, 255, 0.8);
        }

        .login-wraper {
            width: 100%;
            background:
                url("g.jpg") center no-repeat fixed;
            background-size: cover;
            position: absolute;
            height: 100vh;
        }

        .wrapper input[type=submit] {
            background-color: rgba(133, 227, 254, 0.8);
            border: none;
            color: #6a6d71;
        }

        .wrapper input[type=submit]:hover {
            background-color: rgba(133, 227, 254, 0.6);
            border: none;
        }


        .wrapper input[type=reset] {
            border: none;
        }

        @media (max-width:600px) {
            .wrapper {
                width: 90%;
            }
        }

        .footer {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 2rem;
            background: rgb(13, 13, 209);
            color: white;
            font-weight: 300;
            display: flex;
            justify-content: center;
            align-items: center;
        }
    </style>
</head>

<body>
    <div class="login-wraper">
        <div class="wrapper">
            <h2>Login</h2>
            <p>Please fill in your credentials to login.</p>

            <?php
            if (!empty($login_err)) {
                echo '<div class="alert alert-danger">' . $login_err . '</div>';
            }
            ?>

            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="form-group">
                    <input type="text" placeholder="Username" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                    <span class="invalid-feedback"><?php echo $username_err; ?></span>
                </div>
                <div class="form-group">
                    <input type="password" placeholder="Password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>">
                    <span class="invalid-feedback"><?php echo $password_err; ?></span>
                </div>
                <div class="form-group">
                    <input type="submit" class="btn btn-primary" value="Login">
                </div>
            </form>
        </div>
        <div class="footer">&copy;<span id="year"> </span><span> Developed by Musenge Joseph & Kaundje Metaramuje. All rights reserved by NSA</span></div>
    </div>

</body>

</html>