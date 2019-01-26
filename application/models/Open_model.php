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
		$ticket_seq_id = $this->db->query("SELECT value FROM ost_config_test WHERE id='71'")->row('value');
		$checkstring = str_repeat("_", $number_random_digit);

		if($ticket_seq_id == '0')
		{
			$number = $this->db->query("SELECT LPAD(FLOOR(RAND() * 999999.99), '$number_random_digit', '0') as randno")->row('randno');
		}
		else
		{
			$next = $this->db->query("SELECT next FROM ost_sequence_test WHERE sequence_guid='$ticket_seq_id'")->row('next');
			$increment = $this->db->query("SELECT increment FROM ost_sequence_test WHERE sequence_guid='$ticket_seq_id'")->row('increment');
			$padding = $this->db->query("SELECT padding FROM ost_sequence_test WHERE sequence_guid='$ticket_seq_id'")->row('padding');
			$lastnumber = $this->db->query("SELECT number FROM ost_ticket_test WHERE number LIKE '$todaydate2$checkstring' AND sequence_guid = '$ticket_seq_id' ORDER BY number DESC LIMIT 1");

			if($lastnumber->num_rows() != '0')
			{
				$number = $lastnumber->row('number')+$increment;
			}
			else
			{
				$pad = str_repeat($padding,$number_random_digit-1);
				$number = $todaydate2.$pad.$next;
			}

			$checknumber2 = $this->db->query("SELECT * FROM ost_ticket_test WHERE number ='$number'")->num_rows();

			while($checknumber2 != 0){
				$number += $increment;
				$checknumber2 = $this->db->query("SELECT * FROM ost_ticket_test WHERE number ='$number'")->num_rows();
			}
			$number = substr($number, 6);
		}

        $description = addslashes($description);

		$checknumber = $this->db->query("SELECT * FROM ost_ticket_test WHERE number ='$todaydate2$number'");

		$manager = $this->db->query("SELECT * FROM ost_organization_test AS a
                LEFT JOIN ost_user_test AS b ON a.organization_guid = b.user_org_guid WHERE b.user_guid = '$userid'")->row('manager');
        $autoassign = $this->db->query("SELECT * FROM ost_organization_test AS a
                LEFT JOIN ost_user_test AS b ON a.organization_guid = b.user_org_guid WHERE b.user_guid = '$userid'")->row('autoassignment');

        //if customer had no department , auto assign to panda
        $defaultdept = $this->db->query("SELECT name FROM ost_department_test WHERE department_guid = (SELECT VALUE FROM ost_config_test WHERE id = '85')")->row('name');
        $defaultslaid = $this->db->query("SELECT value FROM ost_config_test WHERE id = '86'")->row('value');
        $defaultpriorityid = $this->db->query("SELECT value FROM ost_config_test WHERE id = '9'")->row('value');
        $defaultstatusid = $this->db->query("SELECT value FROM ost_config_test WHERE id = '103'")->row('value');
					
		if ($checknumber->num_rows() == 0)
		{
			if ($userdepname != '')
			{
				$this->db->query("INSERT INTO osticket.ost_ticket_test (ticket_guid, number, sequence_guid, topic_guid, subtopic_guid, description, assigned_to, team_guid, created_at, ticket_updated, ticket_updated_by_id, ticket_updated_by_role, user_guid, department, sla_guid, status_guid, ipadd, priority_guid )
				VALUES (REPLACE(UPPER(UUID()),'-',''), '$todaydate2$number', '$ticket_seq_id', '$subject', '$subtopic', '$description', '0', '0', now(), now(), '$userid', 'user', '$userid', '$userdepname', '$defaultslaid', '$defaultstatusid', '$ipaddress', '$defaultpriorityid' )");
			}

			else {

				$this->db->query("INSERT INTO osticket.ost_ticket_test (ticket_guid, number, sequence_guid, topic_guid, subtopic_guid, description , created_at, ticket_updated, ticket_updated_by_id, ticket_updated_by_role, user_guid, department, sla_guid, status_guid, ipadd, priority_guid )
				VALUES (REPLACE(UPPER(UUID()),'-',''), '$todaydate2$number', '$ticket_seq_id', '$subject', '$subtopic', '$description', now(), now(), '$userid', 'user', '$userid', '$defaultdept', '$defaultslaid', '$defaultstatusid', '$ipaddress', '$defaultpriorityid' )");

			}

			$ticketid = $this->db->query("SELECT * FROM osticket.ost_ticket_test WHERE number = '$todaydate2$number'")->row('ticket_guid');

			if ($manager != '' && $autoassign == '1')
			{	
                if ($manager{0} == 'a')
                {
                    $autostaff_guid = substr($manager, 1);
                    $autoteam_guid = '0';
                }
                else if ($manager{0} == 't')
                {
                    $autoteam_guid = substr($manager, 1);
                    $autostaff_guid = '0';
                }
			}
			else
            {
               	$autoteam_guid = '0';
                $autostaff_guid = '0';
            }

            $this->db->query("UPDATE osticket.ost_ticket_test SET assigned_to = '$autostaff_guid', team_guid = '$autoteam_guid' WHERE ticket_guid = '$ticketid'");

			$this->db->query("INSERT INTO osticket.ost_thread_entry_test (thread_entry_guid, ticket_guid , user_guid , type, poster , body , ip_address, created, updated, class , avatar )
				VALUES (REPLACE(UPPER(UUID()),'-',''), '$ticketid', '$userid', 'U' ,'$username', '$description', '$ipaddress', now(), now(), 'message', 'right')");
			
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