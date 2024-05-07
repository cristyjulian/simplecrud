<?php
include 'conn.php'; // Include your database connection file

$id = $name = $age = $birthdate = $gender = $address = $gmailAccount = "";
$isNewRecord = true; // Flag to check if it's a new record or an edit

if (isset($_GET['edit'])) {
    $isNewRecord = false;
    $id = $_GET['edit'];
    $stmt = $con->prepare("SELECT * FROM People WHERE ID = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    
    if ($row) {
        $name = $row['Name'];
        $age = $row['Age'];
        $birthdate = $row['Birthdate'];
        $gender = $row['Gender'];
        $address = $row['Address'];
        $gmailAccount = $row['GmailAccount'];
    }
    $stmt->close();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['save'])) {
    $name = $_POST['name'];
    $age = $_POST['age'];
    $birthdate = $_POST['birthdate'];
    $gender = $_POST['gender'];
    $address = $_POST['address'];
    $gmailAccount = $_POST['gmailAccount'];
    $id = $_POST['id']; // This will be empty for new records

    if ($isNewRecord) {
        // Insert new record
        $stmt = $con->prepare("INSERT INTO People (Name, Age, Birthdate, Gender, Address, GmailAccount) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sissss", $name, $age, $birthdate, $gender, $address, $gmailAccount);
    } else {
        // Update existing record
        $stmt = $con->prepare("UPDATE People SET Name = ?, Age = ?, Birthdate = ?, Gender = ?, Address = ?, GmailAccount = ? WHERE ID = ?");
        $stmt->bind_param("sissssi", $name, $age, $birthdate, $gender, $address, $gmailAccount, $id);
    }
    $stmt->execute();
    $stmt->close();
    header("Location: about.php"); // Redirect to index after operation
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= $isNewRecord ? 'Add New Record' : 'Edit Record'; ?></title>
    <link rel="stylesheet" href="../OUTPUT/css/ed.css">
</head>
<body>
<form action="<?= htmlspecialchars($_SERVER["PHP_SELF"]) . ($isNewRecord ? '' : '?edit=' . $id); ?>" method="post">
    <div class="container">
        <h2>Information</h2>
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <input type="text" name="name" class="input-field" placeholder="Name" required value="<?php echo $name; ?>">
        <input type="number" name="age" class="input-field" placeholder="Age" required value="<?php echo $age; ?>">
        <input type="date" name="birthdate" class="input-field" placeholder="Birthdate" required value="<?php echo $birthdate; ?>">
        <select name="gender" class="input-field" required>
            <option value="Male" <?= $gender === 'Male' ? 'selected' : ''; ?>>Male</option>
            <option value="Female" <?= $gender === 'Female' ? 'selected' : ''; ?>>Female</option>
            <option value="Other" <?= $gender === 'Other' ? 'selected' : ''; ?>>Other</option>
        </select>
        <input type="text" name="address" class="input-field" placeholder="Address" required value="<?php echo $address; ?>">
        <input type="email" name="gmailAccount" class="input-field" placeholder="Gmail Account" required value="<?php echo $gmailAccount; ?>">
        <button type="submit" name="save" class="btn"><?= $isNewRecord ? 'SAVE' : 'UPDATE'; ?></button>
    </div>
</form>

</body>
</html>
