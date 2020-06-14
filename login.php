<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.0-2/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="Assets/css/login.css">
    <link href="https://fonts.googleapis.com/css2?family=Sriracha&family=Roboto&display=swap" rel="stylesheet">
</head>
<body>

    <div class="form-wrapper">
        <div class="form-background">
            <div class="form-content">
                <form action="checkLogin.php" method="post">
                    <div class="text-1">
                    LOGIN
                    </div>
                
                    <div class="container">
                        <div class="input-container">
                            <i class="fas fa-user"></i>
                            <input type="text" placeholder="Insira Username" name="uname" autocomplete="off" required>
                        </div>

                        <div class="input-container">
                            <i class="fas fa-lock"></i>
                            <input type="password" placeholder="Insira Password" name="psw" required>
                        </div>
                        <button type="submit" name="submit" class="btnSubmit"><span>Login</span></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>