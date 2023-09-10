<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $password = md5($_POST['password']); // Hash the password for security
    $adminName = $_POST['admin_name'];
    $mobileNumber = $_POST['mobile_number'];
    $email = $_POST['email'];

    // Check if the username already exists
    $checkUsernameQuery = "SELECT ID FROM tbladmin WHERE UserName = :username";
    $checkUsernameStmt = $dbh->prepare($checkUsernameQuery);
    $checkUsernameStmt->bindParam(':username', $username, PDO::PARAM_STR);
    $checkUsernameStmt->execute();

    if ($checkUsernameStmt->rowCount() > 0) {
        echo "<script>alert('Username already exists. Please choose a different username.');</script>";
    } else {
        // Continue with the registration process
        $insertUserQuery = "INSERT INTO tbladmin (UserName, Password, AdminName, MobileNumber, Email) 
                            VALUES (:username, :password, :admin_name, :mobile_number, :email)";
        $insertUserStmt = $dbh->prepare($insertUserQuery);
        $insertUserStmt->bindParam(':username', $username, PDO::PARAM_STR);
        $insertUserStmt->bindParam(':password', $password, PDO::PARAM_STR);
        $insertUserStmt->bindParam(':admin_name', $adminName, PDO::PARAM_STR);
        $insertUserStmt->bindParam(':mobile_number', $mobileNumber, PDO::PARAM_STR);
        $insertUserStmt->bindParam(':email', $email, PDO::PARAM_STR);
        $insertUserStmt->execute();

        echo "<script>alert('Registration successful. Please login.'); window.location='login.php'; </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Student Notice System || Registration Page</title>
    <link rel="stylesheet" href="vendors/simple-line-icons/css/simple-line-icons.css">
    <link rel="stylesheet" href="vendors/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="css/style.css"> <!-- Use the same CSS file as the login page -->
</head>
<body>
    <div class="container-scroller">
        <div class="container-fluid page-body-wrapper full-page-wrapper">
            <div class="content-wrapper d-flex align-items-center auth">
                <div class="row flex-grow">
                    <div class="col-lg-4 mx-auto">
                        <div class="auth-form-light text-left p-5">
                            <div class="brand-logo">
                                <img src="images/logo.svg">
                            </div>
                            <h4>Hello! Let's get started</h4>
                            <h6 class="font-weight-light">Create an account.</h6>
                            <form class="pt-3" id="registration" method="post" name="registration">
                                <div class="form-group">
                                    <input type="text" class="form-control form-control-lg" placeholder="Enter your username" required="true" name="username">
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control form-control-lg" placeholder="Enter your password" name="password" required="true">
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control form-control-lg" placeholder="Your full name" name="admin_name" required="true">
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control form-control-lg" placeholder="Your mobile number" name="mobile_number" required="true">
                                </div>
                                <div class="form-group">
                                    <input type="email" class="form-control form-control-lg" placeholder="Your email address" name="email" required="true">
                                </div>
                                <div class="mt-3">
                                    <button class="btn btn-primary btn-block" name="register" type="submit">Register</button>
                                </div>
                            </form>
                            <p>Already have an account? <a href="login.php">Login here</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="vendors/js/vendor.bundle.base.js"></script>
    <script src="js/off-canvas.js"></script>
    <script src="js/misc.js"></script>
</body>
</html>
