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
		$sql = "INSERT INTO osticket.ost_ticket_test ( number, topic_id, description , created_at, ticket_updated, user_id, department, status_id, ipadd )
		VALUES ( '$todaydate2$NowisTime', '$subject', '$description', now(), now(), '$userid', '$userdepname', '1', '$ipaddress' )";
		$query = $this->db->query($sql);
        return $query;
	}
}
?>