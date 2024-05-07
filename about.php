<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../OUTPUT/css/entry.css">
</head>
<body>
    <?php include 'header.php'; ?>
    <center>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="container">
                <h2>Information</h2>
                <input type="text" name="name" placeholder="Name" required>
                <input type="number" name="age" placeholder="Age" required>
                <input type="date" name="birthdate" placeholder="Birthdate" required>
                <select name="gender" required>
                    <option value="">Select Gender</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                    <option value="Other">Other</option>
                </select>
                <input type="text" name="address" placeholder="Address">
                <input type="email" name="gmailAccount" placeholder="Gmail Account" required>
                <button type="submit" name="SAVE" class="btn">SAVE</button>
            </div>
        </form>
        <?php
        include 'conn.php'; // This should be your database connection file

        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['SAVE'])) {
            // Prepare and bind
            $stmt = $con->prepare("INSERT INTO People (Name, Age, Birthdate, Gender, Address, GmailAccount) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sissss", $name, $age, $birthdate, $gender, $address, $gmailAccount);

            // Set parameters and execute
            $name = $_POST['name'];
            $age = $_POST['age'];
            $birthdate = $_POST['birthdate'];
            $gender = $_POST['gender'];
            $address = $_POST['address'];
            $gmailAccount = $_POST['gmailAccount'];
            $stmt->execute();

            echo '<script>alert("Record added successfully!");</script>';
            $stmt->close();
        }
        ?>
        <table>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Age</th>
                <th>Birthdate</th>
                <th>Gender</th>
                <th>Address</th>
                <th>Gmail Account</th>
                <th>Action</th>
            </tr>
            <?php
            $result = mysqli_query($con, "SELECT * FROM People");
            while($row = mysqli_fetch_array($result)) {
            ?>
            <tr>
                <td><?php echo $row['ID'];?></td>
                <td><?php echo htmlspecialchars($row['Name']);?></td>
                <td><?php echo $row['Age'];?></td>
                <td><?php echo $row['Birthdate'];?></td>
                <td><?php echo htmlspecialchars($row['Gender']);?></td>
                <td><?php echo htmlspecialchars($row['Address']);?></td>
                <td><?php echo htmlspecialchars($row['GmailAccount']);?></td>
                <td>
                    <a href="delete.php?delete=<?php echo $row['ID'];?>">Delete</a> | 
                    <a href="edit.php?edit=<?php echo $row['ID'];?>">Edit</a>
                </td>
            </tr>
            <?php
            }
            mysqli_close($con);
            ?>
        </table>
    </center>
    
</body>
</html>
<?php include 'footer.php'; ?>
