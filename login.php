<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

</head>
<body>

<?php

include_once "config.php";

$errors = array();

if(isset($_POST) && !empty($_POST)) {


    if (!isset($_POST["username"]) || empty($_POST["username"])) {
        $errors[] = "chưa nhập Username";
    }

    if (!isset($_POST["password"]) || empty($_POST["password"])) {
        $errors[] = "chưa nhập Password";
    }

    if (is_array($errors) && empty($errors)) {

        $username = $_POST["username"];
        $password = md5($_POST["password"]);

        $sqllogin = "SELECT FROM user WHERE username = ? AND password = ?";

        $stmt = $connection->prepare($sqllogin);

        $stmt->bind_param("ss", $username, $password);

        $stmt->execute();

        $res = $stmt->get_result();

        $row = $res->fetch_array(MYSQLI_ASSOC);

        if (isset($row['id']) && ($row['id'] > 0)) {
            $_SESSION["loggedin"] = true;
            $_SESSION["username"] = $row["username"];

            echo "<pre>";
            print_r($row);
            echo "</pre>";

            echo "<pre>";
            print_r($_SESSION);
            echo "</pre>";
        }

    }

}
?>

<div class="container" style="margin-top: 50px">
    <div class="row">
        <div class="col-md-12">
            <h1>Đăng nhập</h1>
            <form name="login" action="" method="post">
                <div class="form-group">
                    <label>Username</label>
                    <input type="text" class="form-control" name="username" placeholder="Enter username" autocomplete="off">
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" class="form-control" name="password" placeholder="Comfirm Password">
                </div>
                <div class="form-group form-check">
                    <p><a href="register.php">Đăng ký</a></p>
                </div>
                <button type="submit" class="btn btn-primary">Đăng nhập</button>
            </form>
        </div>
    </div>
</div>

</body>
</html>