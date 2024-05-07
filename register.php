<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link rel="stylesheet" href="../OUTPUT/css/style.css">
</head>
<body>
<?php
        include 'conn.php'; // Ensure this path is correct for your connection script
        if (isset($_POST['register'])) {
            $name = $_POST['name'];
            $username = $_POST['username'];
            $password = $_POST['password'];
            $confirm_password = $_POST['confirm_password'];

            if ($password !==$confirm_password) {
                echo '<div class="message" style="display:block;">Passwords didnt match!</div>';
                echo '<script>hideMessage();</script>';
            } else {
                $conn = new mysqli('localhost', 'root', '', 'almost');
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                $userCheck = $conn->prepare("SELECT username FROM users WHERE username = ?");
                $userCheck->bind_param("s", $username);
                $userCheck->execute();
                $result = $userCheck->get_result();
                if ($result->num_rows > 0) {
                    echo '<div class="message" style="display:block;">Username already exists, please try another!</div>';
                    echo '<script>hideMessage();</script>';
                } else {
                    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                    $sql = "INSERT INTO users (name, username, password) VALUES (?, ?, ?)";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("sss", $name, $username, $hashed_password);

                    if ($stmt->execute()) {
                        echo '<div class="message" style="display:block;">Registration successful!</div>';
                        echo '<script>hideMessage();</script>';
                    } else {
                        echo '<div class="message" style="display:block;">Error: ' . $stmt->error . '</div>';
                        echo '<script>hideMessage();</script>';
                    }
                    $stmt->close();
                }
                $userCheck->close();
                $conn->close();
            }
        }
    ?>

    <form action="register.php" method="post">
        <div class="container">
            <h2>Registration Form</h2>
            <input type="text" id="name" name="name" placeholder="Name" required><br>
            <input type="text" id="username" name="username" placeholder="Username" required><br>
            <input type="password" id="password" name="password" placeholder="Password" required><br>
            <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm Password" required><br>
            <button type="submit" name="register" class="btn">Register</button>
            <p>Already a member? <a href="login.php">Login</a></p>
        </div>
    </form>

    <script>
        function hideMessage() {
            var msg = document.querySelector('.message');
            if (msg) {
                setTimeout(function() {
                    msg.style.display = 'none';
                }, 1000); // Hide the message after 3 seconds for better readability
            }
        }
    </script>
</body>
</html>
