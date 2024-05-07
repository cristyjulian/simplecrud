<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="../OUTPUT/css/style.css">

</head>
<body>
    <?php
    session_start();
    include 'conn.php';
    if (isset($_POST['login'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $conn = new mysqli('localhost', 'root', '', 'almost');
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "SELECT id, username, password FROM users WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                header("Location: index.php");
                exit();
            } else {
                echo "Invalid login credentials.";
            }
        } else {
            echo "Invalid login credentials.";
        }

        $stmt->close();
        $conn->close();
    }
    ?>

    <form action="login.php" method="post">
        <div class="container">
        <h2>Login Form</h2>
        <input type="text" id="username" name="username" placeholder="Username" required><br>
        <input type="text" id="password" name="password" placeholder="Password" required><br>
        <button type="submit" name="login" class="btn">Login</button>
        <p>Not a member yet? <a href="register.php">Register</a></p>
        </div>
    </form>
</body>
</html>
