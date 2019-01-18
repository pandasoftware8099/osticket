<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class staff_new_ticket_model extends CI_Model
{
	public function add_new( $user_guid , $status_guid, $priority_guid, $userdepname, $sla_guid, $subject, $subtopic_guid, $description, $assign_id, $staff_guid, $team_guid, $datetime, $source, $user_name, $user_email, $notes)
	{
		$todaydate = date('Ymd');
		$todaydate2 = substr($todaydate, 2);
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

		$poster_id = $_SESSION["staffid"];
		$ipaddress = $_SERVER['REMOTE_ADDR'];
		$datetime = date('Y-m-d H:i', strtotime("$datetime"));

		$checknumber = $this->db->query("SELECT * FROM ost_ticket_test WHERE number ='$todaydate2$number'")->num_rows();
		$checkuser = $this->db->query("SELECT * FROM ost_user_test WHERE user_name = '$user_name'")->num_rows();
		$checkemail = $this->db->query("SELECT * FROM ost_user_test WHERE user_email = '$user_email'")->num_rows();

		$posterfname = $this->db->query("SELECT * FROM ost_staff_test WHERE staff_guid = '$poster_id'")->row('firstname');
        $posterlname = $this->db->query("SELECT * FROM ost_staff_test WHERE staff_guid = '$poster_id'")->row('lastname');

        $manager = $this->db->query("SELECT * FROM ost_organization_test AS a
                LEFT JOIN ost_user_test AS b ON a.organization_guid = b.user_org_guid WHERE b.user_guid = '$user_guid'")->row('manager');
        $autoassign = $this->db->query("SELECT * FROM ost_organization_test AS a
                LEFT JOIN ost_user_test AS b ON a.organization_guid = b.user_org_guid WHERE b.user_guid = '$user_guid'")->row('autoassignment');

        $todaydatetime = date('Y-m-d H:i');

		if ($checknumber == 0) 
		{
			if ($checkuser == 0 && $checkemail == 0)
			{
				$createuser = $this->db->query("INSERT INTO osticket.ost_user_test (user_guid, user_name, user_created_at, user_updated_at, user_email, status ) 
				VALUES (REPLACE(UPPER(UUID()),'-',''), '$user_name', now(), now(), '$user_email', '4')");

				$user_guid = $this->db->query("SELECT * FROM ost_user_test WHERE user_name = '$user_name'")->row('user_guid');

				$splitemail = explode('@', $user_email);
                $domain = '@'.$splitemail[1];
                $org = $this->db->query("SELECT * FROM ost_organization_test");

                foreach ($org->result() as $orgdomain)
                {
                    if ($orgdomain->domain == $domain)
                        $this->db->query("UPDATE ost_user_test SET user_org_guid = '$orgdomain->organization_guid' WHERE user_guid = '$user_guid' ");
                }

				$createticket = $this->db->query("INSERT INTO osticket.ost_ticket_test (ticket_guid, number, sequence_guid, user_guid, status_guid, priority_guid, department, sla_guid, topic_guid, subtopic_guid, description, created_at, ticket_updated, ticket_updated_by_id, ticket_updated_by_role, assigned_to, team_guid, ipadd, source)
				VALUES (REPLACE(UPPER(UUID()),'-',''), '$todaydate2$number', '$ticket_seq_id', '$user_guid', '$status_guid', '$priority_guid', '$userdepname', '$sla_guid', '$subject', '$subtopic_guid', '$description', now(), now(), '$poster_id', 'agent', '$staff_guid', '$team_guid', '$ipaddress', '$source')");

				$manager = $this->db->query("SELECT * FROM ost_organization_test AS a
	                LEFT JOIN ost_user_test AS b ON a.organization_guid = b.user_org_guid WHERE b.user_guid = '$user_guid'")->row('manager');
	        	$autoassign = $this->db->query("SELECT * FROM ost_organization_test AS a
	                LEFT JOIN ost_user_test AS b ON a.organization_guid = b.user_org_guid WHERE b.user_guid = '$user_guid'")->row('autoassignment');
				$ticket_guid = $this->db->query("SELECT ticket_guid FROM ost_ticket_test WHERE number = '$todaydate2$number'")->row('ticket_guid');

				if ($manager != $assign_id && $manager != '' && $autoassign == '1')
				{	
	                if ($manager{0} == 'a')
	                {
	                    $autostaff_guid = substr($manager, 1);
	                    $autoteam_guid = '0';
	                    $firstname = $this->db->query("SELECT * FROM ost_staff_test WHERE staff_guid = '$autostaff_guid'")->row('firstname');
	                    $lastname = $this->db->query("SELECT * FROM ost_staff_test WHERE staff_guid = '$autostaff_guid'")->row('lastname');
	                    $staffname = $firstname.' '.$lastname;
	                }
	                else if ($manager{0} == 't')
	                {
	                    $autoteam_guid = substr($manager, 1);
	                    $autostaff_guid = '0';
	                    $staffname = $this->db->query("SELECT * FROM ost_team_test WHERE team_guid = '$autoteam_guid'")->row('name');
	                }

					$this->db->query("UPDATE osticket.ost_ticket_test SET assigned_to = '$autostaff_guid', team_guid = '$autoteam_guid' WHERE ticket_guid = '$ticket_guid'");

					echo "<script> alert('Ticket #$todaydate2$number has been AUTO-ASSIGNED to Account Manager $staffname. Kindly change the auto-assignment setting inside organization page if you want to assign to another staff.');</script>";
				}

				if ($datetime > $todaydatetime)
					$insertdue = $this->db->query("UPDATE osticket.ost_ticket_test SET duedate = '$datetime' WHERE ticket_guid = '$ticket_guid'");

				$sql1 = $this->db->query("INSERT INTO osticket.ost_thread_entry_test (thread_entry_guid, ticket_guid, staff_guid, type, poster, body, ip_address, created, updated, class, avatar )
					VALUES (REPLACE(UPPER(UUID()),'-',''), '$ticket_guid', '$poster_id', 'S','$posterfname $posterlname', '$description', '$ipaddress', now(), now(), 'response', 'left')");

				if ($notes != '')
				{
					$sql2 = $this->db->query("INSERT INTO osticket.ost_thread_entry_test (thread_entry_guid, ticket_guid, staff_guid, type, poster, body, ip_address, created, updated, class, avatar )
					VALUES (REPLACE(UPPER(UUID()),'-',''), '$ticket_guid', '$poster_id', 'N','$posterfname $posterlname', '$notes', '$ipaddress', now(), now(), 'note', 'left')");
				}
			}

			else if (($checkuser == 0 && $checkemail != 0) || ($checkuser != 0 && $checkemail == 0))
			{
				echo "<script>alert('Email Address and Full Name Do Not Match');
					window.location = 'newticket?id=';</script>";die;
			}

			else if ($checkuser != 0 && $checkemail != 0)
			{
				$createticket = $this->db->query("INSERT INTO osticket.ost_ticket_test (ticket_guid, number, sequence_guid, user_guid, status_guid, priority_guid, department, sla_guid, topic_guid, subtopic_guid, description, created_at, ticket_updated, ticket_updated_by_id, ticket_updated_by_role, assigned_to, team_guid, ipadd, source)
				VALUES (REPLACE(UPPER(UUID()),'-',''), '$todaydate2$number', '$ticket_seq_id', '$user_guid', '$status_guid', '$priority_guid', '$userdepname', '$sla_guid', '$subject', '$subtopic_guid', '$description', now(), now(), '$poster_id', 'agent', '$staff_guid', '$team_guid', '$ipaddress', '$source')");
				
				$ticket_guid = $this->db->query("SELECT * FROM ost_ticket_test WHERE number = '$todaydate2$number'")->row('ticket_guid');

				if ($manager != $assign_id && $manager != '' && $autoassign == '1')
				{	
	                if ($manager{0} == 'a')
	                {
	                    $autostaff_guid = substr($manager, 1);
	                    $autoteam_guid = '0';
	                    $firstname = $this->db->query("SELECT * FROM ost_staff_test WHERE staff_guid = '$autostaff_guid'")->row('firstname');
	                    $lastname = $this->db->query("SELECT * FROM ost_staff_test WHERE staff_guid = '$autostaff_guid'")->row('lastname');
	                    $staffname = $firstname.' '.$lastname;
	                }
	                else if ($manager{0} == 't')
	                {
	                    $autoteam_guid = substr($manager, 1);
	                    $autostaff_guid = '0';
	                    $staffname = $this->db->query("SELECT * FROM ost_team_test WHERE team_guid = '$autoteam_guid'")->row('name');
	                }

					$this->db->query("UPDATE osticket.ost_ticket_test SET assigned_to = '$autostaff_guid', team_guid = '$autoteam_guid' WHERE ticket_guid = '$ticket_guid'");

					echo "<script> alert('Ticket #$todaydate2$number has been AUTO-ASSIGNED to Account Manager $staffname. Kindly change the auto-assignment setting inside organization page if you want to assign to another staff.');</script>";
				}

				if ($datetime > $todaydatetime)
					$insertdue = $this->db->query("UPDATE osticket.ost_ticket_test SET duedate = '$datetime' WHERE ticket_guid = $ticket_guid");

				$sql1 = $this->db->query("INSERT INTO osticket.ost_thread_entry_test (thread_entry_guid, ticket_guid, staff_guid, type, poster, body, ip_address, created, updated, class, avatar )
					VALUES (REPLACE(UPPER(UUID()),'-',''), '$ticket_guid', '$poster_id', 'S','$posterfname $posterlname', '$description', '$ipaddress', now(), now(), 'response', 'left')");

				if ($notes != '')
				{
					$sql2 = $this->db->query("INSERT INTO osticket.ost_thread_entry_test ( ticket_guid, staff_guid, type, poster, body, ip_address, created, updated, class, avatar )
					VALUES ('$ticket_guid', '$poster_id', 'N','$posterfname $posterlname', '$notes', '$ipaddress', now(), now(), 'note', 'left')");
				}
			}

			return $ticket_guid;
		}

		else{

			redirect('staff_new_ticket_model/add_new');

		}
	}
}
?>