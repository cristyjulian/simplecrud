
	<!DOCTYPE html>
	<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" href="css/style.css">
		<title>Simple Crud</title>
	</head>
	<body>
		<?php include 'header.php'; ?>
		
	
<?php
session_start();
?>
<?php
if( isset($_SESSION['ERRMSG_ARR']) && is_array($_SESSION['ERRMSG_ARR']) && count($_SESSION['ERRMSG_ARR']) >0 ) {
	echo '<ul style="padding:0; color:red;">';
	foreach($_SESSION['ERRMSG_ARR'] as $msg) {
		echo '<li>',$msg,'</li>'; 
	}
	echo '</ul>';
	unset($_SESSION['ERRMSG_ARR']);
}
?>
<div class="container">
<form action="reg.php" method="POST" style="width: 50%; margin: 50px auto; height: 54px;">
<div style="float:left;width:25%;">
First Name<br>
<input type="text" name="fname" />
</div>
<div style="float:left;width:25%;">
Last Name<br>
<input type="text" name="lname" />
</div>
<div style="float:left;width:25%;">
Age<br>
<input type="text" name="age" />
</div>
<div style="float:left;width:25%;">
<input type="submit" value="Save" id="secret" />
</div>
</form>
<center>
<table cellspacing="0" cellpadding="2" id="sample" >
<thead>
	<tr>
		<th> First Name </th>
		<th> Last Name </th>
		<th> Age </th>
		<th> Action </th>
	</tr>
</thead></center>
<tbody>
	<?php
		include('connect.php');
		if (isset($_GET["page"])) { $page  = $_GET["page"]; } else { $page=1; };
		$start_from = ($page-1) * 6; 		
		$result = $db->prepare("SELECT * FROM members ORDER BY id ASC LIMIT $start_from, 6");
		$result->execute();
		for($i=0; $row = $result->fetch(); $i++){
	?>
	<tr class="record">
		<td><?php echo $row['fname']; ?></td>
		<td><?php echo $row['lname']; ?></td>
		<td><?php echo $row['age']; ?></td>
		<td><a href="editform.php?id=<?php echo $row['id']; ?>"> edit </a> | <a href="delete.php?id=<?php echo $row['id']; ?>"> delete </a></td>
	</tr>
	<?php
		}
	?>
</tbody>
</table>

<div id="pagination">
	<?php 

	$result = $db->prepare("SELECT COUNT(id) FROM members");
	$result->execute(); 
	$row = $result->fetch(); 
	$total_records = $row[0]; 
	$total_pages = ceil($total_records / 6); 
	  
	for ($i=1; $i<=$total_pages; $i++) { 
				echo "<a href='index.php?page=".$i."'";
				if($page==$i)
				{
				echo "id=active";
				}
				echo ">";
				echo "".$i."</a> "; 
	}; 
	?>
</div>
</div>
</body>
</html>

<?php include 'footer.php'; ?>
