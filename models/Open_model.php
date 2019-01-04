<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class open_model extends CI_Model
{
	public function add_process($subject, $subtopic, $description, $userid, $userdepname,$username)
	{

		$todaydate = date('Ymd');
/*		$time_utc=mktime(date('G'),date('i'),date('s'));
		$NowisTime=date('Gis',$time_utc);*/
		$todaydate2 = substr($todaydate, 2);

		$ipaddress = $_SERVER['REMOTE_ADDR'];   
		/*$ipINT = ip2long($ipaddress);*/

		$number_random_digit = $this->db->query("SELECT * FROM ost_config_test WHERE id = '70'")->row('value');
		$number = $this->db->query("SELECT LPAD(FLOOR(RAND() * 999999.99), '$number_random_digit', '0') as randno")->row('randno');
        $description = addslashes($description);

		$checknumber = $this->db->query("SELECT * FROM ost_ticket_test WHERE number ='$todaydate2$number'");

		$manager = $this->db->query("SELECT * FROM ost_organization_test AS a
                LEFT JOIN ost_user_test AS b ON a.id = b.user_org_id WHERE b.user_id = '$userid'")->row('manager');
        $autoassign = $this->db->query("SELECT * FROM ost_organization_test AS a
                LEFT JOIN ost_user_test AS b ON a.id = b.user_org_id WHERE b.user_id = '$userid'")->row('autoassignment');

        //if customer had no department , auto assign to panda
        $defaultdept = $this->db->query("SELECT name FROM ost_department_test WHERE id = (SELECT VALUE FROM ost_config_test WHERE id = '85')")->row('name');
        $defaultslaid = $this->db->query("SELECT value FROM ost_config_test WHERE id = '86'")->row('value');
        $defaultpriorityid = $this->db->query("SELECT value FROM ost_config_test WHERE id = '9'")->row('value');
        $defaultstatusid = $this->db->query("SELECT value FROM ost_config_test WHERE id = '103'")->row('value');
					
		if ($checknumber->num_rows() == 0)
		{
			if ($userdepname != '')
			{
				$this->db->query("INSERT INTO osticket.ost_ticket_test ( number, topic_id, subtopic_id, description, assigned_to, team_id, created_at, ticket_updated, ticket_updated_by_id, ticket_updated_by_role, user_id, department, sla_id, status_id, ipadd, priority_id )
				VALUES ( '$todaydate2$number', '$subject', '$subtopic', '$description', '0', '0', now(), now(), '$userid', 'user', '$userid', '$userdepname', '$defaultslaid', '$defaultstatusid', '$ipaddress', '$defaultpriorityid' )");
			}

			else {

				$this->db->query("INSERT INTO osticket.ost_ticket_test ( number, topic_id, subtopic_id, description , created_at, ticket_updated, ticket_updated_by_id, ticket_updated_by_role, user_id, department, sla_id, status_id, ipadd, priority_id )
				VALUES ( '$todaydate2$number', '$subject', '$subtopic', '$description', now(), now(), '$userid', 'user', '$userid', '$defaultdept', '$defaultslaid', '$defaultstatusid', '$ipaddress', '$defaultpriorityid' )");

			}

			$ticketid = $this->db->query("SELECT * FROM osticket.ost_ticket_test WHERE number = '$todaydate2$number'")->row('ticket_id');

			if ($manager != '' && $autoassign == '1')
			{	
                if ($manager{0} == 'a')
                {
                    $autostaff_id = substr($manager, 1);
                    $autoteam_id = '0';
                }
                else if ($manager{0} == 't')
                {
                    $autoteam_id = substr($manager, 1);
                    $autostaff_id = '0';
                }
			}
			else
            {
               	$autoteam_id = '0';
                $autostaff_id = '0';
            }

            $this->db->query("UPDATE osticket.ost_ticket_test SET assigned_to = '$autostaff_id', team_id = '$autoteam_id' WHERE ticket_id = '$ticketid'");

			$this->db->query("INSERT INTO osticket.ost_thread_entry_test ( ticket_id , user_id , type, poster , body , ip_address, created, updated, class , avatar )
				VALUES ('$ticketid', '$userid', 'U' ,'$username', '$description', '$ipaddress', now(), now(), 'message', 'right')");
			
			$new_refno = $todaydate2.$number;
	        return $new_refno;

		}

		else
		{

			redirect('open_model/add_process');

		}
	}
}
?>