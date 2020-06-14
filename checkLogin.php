<?php 
session_start();
if (isset($_POST["submit"])) {
    include 'model/dbh.php';

    $user = mysqli_real_escape_string($conn, $_POST["uname"]);
    $password = mysqli_real_escape_string($conn, $_POST["psw"]);

    //Error Handlers
    //Check if inputs are empty

    if (empty($user) || empty($password)) {
        header("Location: login.php");
        exit();
    } else {
        $sql = "SELECT * FROM users WHERE userName = '$user'";
        $result = mysqli_query($conn, $sql);
        $resultCheck = mysqli_num_rows($result);
        if ($resultCheck < 1) {
            header("Location: login.php");
            exit();
        } else {
            if($row = mysqli_fetch_assoc($result)) {
                $passwordCheck;
                if ($password == $row["password"]) {
                    $passwordCheck = 1;
                } else {
                    $passwordCheck = 0;
                }
                //$passwordCheck = password_verify($password, $row["password"]);

                if ($passwordCheck == false) {
                    header("Location: login.php");
                    exit();
                } elseif ($passwordCheck == true) {
                    // log the user here
                    $_SESSION['user'] = $row['userName'];
                    header("Location: livros.php");
                }
            }
        } 
    }
} else {
    header("Location: login.php");
    exit();
}