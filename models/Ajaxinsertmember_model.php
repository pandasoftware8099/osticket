<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ajaxinsertmodel extends CI_Model
{
	$sql = "SELECT * FROM osticket.ost_staff WHERE CONCAT('\'',staff_id, '\'') NOT IN (SELECT CONCAT('\'',staff_id, '\'') FROM osticket.ost_staff_dept_access WHERE dept_id = '".$_REQUEST['id']."') AND dept_id = '".$_REQUEST['id1']."'";

echo json_encode($array);
}
?>