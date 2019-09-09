<?php
session_start();
if (isset($_SESSION["loggedin"]) && ($_SESSION["loggedin"] == true)){
    header("Location: index.php");
    exit;
}
// nạp kết nối CSDL vào
include_once "config.php";
/*
 * xủa lý đăng nhập
 */
//tạo biến chứa lỗi trong quá trình đăng nhập
$errors=array();
if(isset($_POST)&&!empty($_POST)){
    if(!isset($_POST["username"]) || empty($_POST["username"])){
        $errors[]="Tên đăng nhập bị sai";
    }
    if(!isset($_POST["password"]) || empty($_POST["password"])){
        $errors[]="Mật khẩu bị sai";
    }
    if(is_array($errors) && empty($errors)){
        $username=$_POST["username"];
        $password=md5($_POST["password"]);
        $sqlLogin="SELECT * FROM user WHERE username = ? AND password = ?";

        $stmt = $connection->prepare($sqlLogin);

        //Bind 3 biến vào trong câu lệnh SQL
        $stmt->bind_param("ss", $username, $password);

        $stmt->execute();

        $res=$stmt->get_result();

        $row=$res->fetch_array(MYSQLI_ASSOC);
        if(isset($row['id'])&&($row['id']>0)){
            /*
             * nếu tồn tại bản ghi
             * thì sẽ tạo ra session đăng nhập
             */
            $_SESSION["loggedin"]=true;
            $_SESSION["username"]=$row['username'];
            header("Location: index.php");
            exit;
        }else{
            $errors[]="Thông tin đăng nhập không đúng";
        }
    }
}
if(is_array($errors)&&!empty($errors)){
    $errors_string = implode("<br>", $errors);
    echo "<div class='alert alert-danger'>";
    echo $errors_string;
    echo "</div>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

</head>
<body>

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