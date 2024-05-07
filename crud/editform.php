<?php
	include('connect.php');
	$id=$_GET['id'];
	$result = $db->prepare("SELECT * FROM members WHERE id= :userid");
	$result->bindParam(':userid', $id);
	$result->execute();
	for($i=0; $row = $result->fetch(); $i++){
?>
<center>
<form action="edit.php" method="POST">
    <table>
        <tbody>
            <tr>
			<input type="hidden" name="memids" value="<?php echo $id; ?>" />
                <th>First Name</th>
                <td><input type="text" name="fname" value="<?php echo $row['fname']; ?>" /></td>
            </tr>
            <tr>
                <th>Last Name</th>
                <td><input type="text" name="lname" value="<?php echo $row['lname']; ?>" /></td>
            </tr>
            <tr>
                <th>Age</th>
                <td><input type="text" name="age" value="<?php echo $row['age']; ?>" /></td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: center;"><input type="submit" value="Save" /></td>
            </tr>
        </tbody>
    </table>
</form>
<style>
 /* Style for the table */
 table {
        width: 50%;
        margin: 20px auto;
        border-collapse: collapse;
    }

    /* Style for table headers */
    th {
        background-color: #f2f2f2;
        border: 1px solid #ddd;
        padding: 8px;
        text-align: left;
    }

    /* Style for table cells */
    td {
        border: 1px solid #ddd;
        padding: 8px;
    }

    /* Style for form input fields */
    input[type="text"] {
        padding: 5px;
        width: 100%;
        box-sizing: border-box;
    }

    /* Style for submit button */
    input[type="submit"] {
        padding: 8px 16px;
        background-color: #007bff;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    /* Style for submit button when hovered */
    input[type="submit"]:hover {
        background-color: #0056b3;
    }
</style>
<?php
	}
?>