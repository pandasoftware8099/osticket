<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ticket_model extends CI_Model
{
	public function add_process($subject, $description, $userid, $userdepname)
	{

		$todaydate = date('Ymd');
		$time_utc=mktime(date('G'),date('i'),date('s'));
		$NowisTime=date('Gis',$time_utc);
		$todaydate2 = substr($todaydate, 2);

		$ipaddress = $_SERVER['REMOTE_ADDR'];   
		$ipINT = ip2long($ipaddress);

        $description = addslashes($description);
		$sql = "INSERT INTO osticket.ost_ticket_test (ticket_guid, number, topic_guid, description , created_at, ticket_updated, user_guid, department, status_guid, ipadd )
		VALUES (REPLACE(UPPER(UUID()),'-',''), '$todaydate2$NowisTime', '$subject', '$description', now(), now(), '$userid', '$userdepname', '1', '$ipaddress' )";
		$query = $this->db->query($sql);
        return $query;
	}
}
?>