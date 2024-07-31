<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <style>
        .login-container {
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f7f7f7;
        }

        .login-form {
            height: 450px;
            max-width: 400px;
            width: 100%;
            padding: 2rem;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .login-form h1 {
            margin-bottom: 1.5rem;
            margin-top: 50px;
        }

        .login-form .form-group {
            position: relative;
            margin-bottom: 20px;
        }

        .login-form .form-group i {
            position: absolute;
            top: 50%;
            left: 15px;
            transform: translateY(-50%);
            color: #aaa;
        }

        .login-form .form-group input {
            padding-left: 2.5rem;
        }
    </style>
</head>

<body>

    <div class="login-container">
        <div class="login-form">
            <h1 class="text-center">Login</h3>
                <form action="login_action.php" method="post">
                    <div class="form-group">
                        <i class="fas fa-user"></i>
                        <input type="text" class="form-control" autocomplete="off" name="username" placeholder="Username" required>
                    </div>
                    <div class="form-group">
                        <i class="fas fa-lock"></i>
                        <input type="password" class="form-control" autocomplete="off" name="password" placeholder="Password" required>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Login</button>
                </form>
                <p style="margin-top: 10px;"><a href="change_password.php">change password ?</a></p>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>

<?php
extract($_REQUEST);

if (isset($error)) { ?>

    <script>
        alert("Please Enter a Valid User Name And Password");
        window.location.href = "login.php";
    </script>

<?php }
?>