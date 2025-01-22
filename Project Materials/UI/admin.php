<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($username === $valid_username && $password === $valid_password) {
        $_SESSION['logged_in'] = true;
        header("Location: dashboard.php");
        exit;
    } else {
        $error = "Invalid username or password!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <style>
        body {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
            background: rgb(238,174,202);
            background: -moz-radial-gradient(circle, rgba(238,174,202,1) 0%, rgba(148,187,233,1) 100%); 
            background: -webkit-radial-gradient(circle, rgba(238,174,202,1) 0%, rgba(148,187,233,1) 100%);
            background: radial-gradient(circle, rgba(238,174,202,1) 0%, rgba(148,187,233,1) 100%);
            filter: progid:DXImageTransform.Microsoft.gradient(startColorstr="#eeaeca",endColorstr="#94bbe9",GradientType=1);
        }
        .container {
            width: 100%;
            max-width: 400px;
            padding: 20px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .error-message {
            color: red;
            font-size: 14px;
            display: none;
            margin-top: 10px;
            text-align: center;
        }
        .btn-success {
            background-color: #7B1818; /* Green for login */
            border-color: #7B1818;
        }
        .btn-success:hover {
            background-color: #AA4A44; /* Darker green */
            border-color: #AA4A44;
        }
    </style>
</head>
<body>

    <div class="container login-section">
        <h2>Admin Login</h2>
        <form id="adminLoginForm">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" id="username" class="form-control" placeholder="Enter Username" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" id="password" class="form-control" placeholder="Enter Password" required>
            </div>
            <button type="submit" class="btn btn-success w-100">Login</button>
            <p class="error-message" id="errorMessage">Invalid Username or Password!</p><br><br>
            <center><p><a href="index.html" class="btn">Back to Home Page</a></p></center>
        </form>
    </div>

    <script>
        document.getElementById('adminLoginForm').addEventListener('submit', function (e) {
            e.preventDefault();

            const validUsername = "Admin001";
            const validPassword = "@dm!n123";

            const username = document.getElementById('username').value.trim();
            const password = document.getElementById('password').value.trim();

            if (username === validUsername && password === validPassword) {
                // Redirect to dashboard.html
                window.location.href = "dashboard.php";
            } else {
                // Show error message
                document.getElementById('errorMessage').style.display = 'block';
            }
        });
    </script>

</body>
</html>