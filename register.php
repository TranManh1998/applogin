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

if(isset($_POST) && !empty($_POST)){

    $errors = array();

    if (!isset($_POST["username"]) || empty($_POST["username"])){
        $errors[] = "Username không hợp lệ";
    }

    if (!isset($_POST["password"]) || empty($_POST["password"])){
        $errors[] = "Password không hợp lệ";
    }

    if (!isset($_POST["comfirm_password"]) || empty($_POST["comfirm_password"])){
        $errors[] = "comfirm_password không hợp lệ";
    }

    if ($_POST["comfirm_password"] !== $_POST["password"]){
        $errors[] = "comfirm_password khác password";
    }

    if(empty($errors)){

        $username = $_POST["username"];
        $password = md5($_POST["password"]);
        $created_at = date("Y-m-d H:i:s");
        $sqlInsert = "INSERT INTO user (username, password, created_at) VALUES (?,?,?)";

        $stmt = $connection->prepare($sqlInsert);

        $stmt->bind_param("sss", $username, $password, $created_at);

        $stmt->execute();

        $stmt->close();

        echo "<div class='alert alert-success'>";
        echo "Đăng ký người dùng mới thành công. Hãy <a href='login.php'>đăng nhập</a>";
        echo "</div>";

    }else{
        $errors_string = implode("<br>", $errors);
        echo "<div class='alert alert-danger'>";
        echo $errors_string;
        echo "</div>";
    }
}

?>

<div class="container" style="margin-top: 50px">
    <div class="row">
        <div class="col-md-12">
            <h1>Đăng ký</h1>
            <form name="register" action="" method="post">
                <div class="form-group">
                    <label>Username</label>
                    <input type="text" class="form-control" name="username" placeholder="Enter username" autocomplete="off">
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control" placeholder="Password">
                </div>
                <div class="form-group">
                    <label>Comfirm Password</label>
                    <input type="password" class="form-control" name="comfirm_password" placeholder="Password">
                </div>
                <button type="submit" class="btn btn-primary">Đăng ký</button>
            </form>
        </div>
    </div>
</div>

</body>
</html>