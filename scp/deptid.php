<?php
	$servername = "localhost";
	$username = "root";
	$password = "";

	// Create connection
	$conn = new mysqli($servername, $username, $password);

	$sql = "SELECT * FROM osticket.ost_staff WHERE CONCAT('\'',staff_id, '\'') NOT IN (SELECT CONCAT('\'',staff_id, '\'') FROM osticket.ost_staff_dept_access WHERE dept_id = '".$_REQUEST['id']."') AND dept_id = '".$_REQUEST['id1']."'";
	$query = mysqli_query($conn, $sql);
	$a = array(
		'a' => array(),
	);

	$i = 0;
	while($row = mysqli_fetch_assoc($query)) {
		$array['a'][$i++] = $row;
	}

	echo json_encode($array);
?>