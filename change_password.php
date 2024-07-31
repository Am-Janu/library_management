<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://code.jquery.com/ui/1.13.3/jquery-ui.js"></script>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f4f4f4;
        }

        .container {
            background: white;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2 class="mb-4">Change Password</h2>

        <div class="mb-3">
            <label for="current-password" class="form-label">Current Password</label>
            <input type="password" id="current-password" class="form-control" name="current_password" required>
        </div>
        <div class="mb-3">
            <label for="new-password" class="form-label">New Password</label>
            <input type="password" id="new-password" class="form-control" name="new_password" required>
        </div>
        <div class="mb-3">
            <button onclick="submit_form()" class="btn btn-primary">Change Password</button>
        </div>
        <div class="error" id="error-message"></div>

    </div>

    <script>
        function submit_form() {
            const currentPassword = document.getElementById('current-password').value;
            const newPassword = document.getElementById('new-password').value;

            const xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    alert(this.responseText);
                    if( this.responseText == "Password changed Successfully")
                    {
                        window.history.back();
                    } 
                }
            };
            var url = "change_password_ajax.php";
            url += "?op_code=" + 1 + "&new_password=" + newPassword + "&current_password=" + currentPassword;

            xhttp.open("GET", url, true);
            xhttp.send();
        }
    </script>
</body>

</html>