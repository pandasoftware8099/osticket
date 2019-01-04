<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class staff_new_ticket_model extends CI_Model
{
	public function add_new( $user_id , $status_id, $priority_id, $userdepname, $sla_id, $subject, $subtopic_id, $description, $assign_id, $staff_id, $team_id, $datetime, $source, $user_name, $user_email, $notes)
	{
		$todaydate = date('Ymd');
		$todaydate2 = substr($todaydate, 2);
		$number_random_digit = $this->db->query("SELECT * FROM ost_config_test WHERE id = '70'")->row('value');
		$number = $this->db->query("SELECT LPAD(FLOOR(RAND() * 999999.99), '$number_random_digit', '0') as randno")->row('randno');
		$poster_id = $_SESSION["staffid"];
		$ipaddress = $_SERVER['REMOTE_ADDR'];
		$datetime = date('Y-m-d H:i', strtotime("$datetime"));

		$checknumber = $this->db->query("SELECT * FROM ost_ticket_test WHERE number ='$todaydate2$number'")->num_rows();
		$checkuser = $this->db->query("SELECT * FROM ost_user_test WHERE user_name = '$user_name'")->num_rows();
		$checkemail = $this->db->query("SELECT * FROM ost_user_test WHERE user_email = '$user_email'")->num_rows();

		$posterfname = $this->db->query("SELECT * FROM ost_staff_test WHERE staff_id = '$poster_id'")->row('firstname');
        $posterlname = $this->db->query("SELECT * FROM ost_staff_test WHERE staff_id = '$poster_id'")->row('lastname');

        $manager = $this->db->query("SELECT * FROM ost_organization_test AS a
                LEFT JOIN ost_user_test AS b ON a.id = b.user_org_id WHERE b.user_id = '$user_id'")->row('manager');
        $autoassign = $this->db->query("SELECT * FROM ost_organization_test AS a
                LEFT JOIN ost_user_test AS b ON a.id = b.user_org_id WHERE b.user_id = '$user_id'")->row('autoassignment');

        $todaydatetime = date('Y-m-d H:i');

		if ($checknumber == 0) 
		{
			if ($checkuser == 0 && $checkemail == 0)
			{
				$createuser = $this->db->query("INSERT INTO osticket.ost_user_test ( user_name, user_created_at, user_updated_at, user_email, status ) 
				VALUES ('$user_name', now(), now(), '$user_email', '4')");

				$user_id = $this->db->query("SELECT * FROM ost_user_test WHERE user_name = '$user_name'")->row('user_id');

				$splitemail = explode('@', $user_email);
                $domain = '@'.$splitemail[1];
                $org = $this->db->query("SELECT * FROM ost_organization_test");

                foreach ($org->result() as $orgdomain)
                {
                    if ($orgdomain->domain == $domain)
                        $this->db->query("UPDATE ost_user_test SET user_org_id = '$orgdomain->id' WHERE user_id = '$user_id' ");
                }

				$createticket = $this->db->query("INSERT INTO osticket.ost_ticket_test ( number, user_id, status_id, priority_id, department, sla_id, topic_id, subtopic_id, description, created_at, ticket_updated, ticket_updated_by_id, ticket_updated_by_role, assigned_to, team_id, ipadd, source)
				VALUES ( '$todaydate2$number', '$user_id', '$status_id', '$priority_id', '$userdepname', '$sla_id', '$subject', '$subtopic_id', '$description', now(), now(), '$poster_id', 'agent', '$staff_id', '$team_id', '$ipaddress', '$source')");

				$manager = $this->db->query("SELECT * FROM ost_organization_test AS a
	                LEFT JOIN ost_user_test AS b ON a.id = b.user_org_id WHERE b.user_id = '$user_id'")->row('manager');
	        	$autoassign = $this->db->query("SELECT * FROM ost_organization_test AS a
	                LEFT JOIN ost_user_test AS b ON a.id = b.user_org_id WHERE b.user_id = '$user_id'")->row('autoassignment');
				$ticket_id = $this->db->query("SELECT ticket_id FROM ost_ticket_test WHERE number = '$todaydate2$number'")->row('ticket_id');

				if ($manager != $assign_id && $manager != '' && $autoassign == '1')
				{	
	                if ($manager{0} == 'a')
	                {
	                    $autostaff_id = substr($manager, 1);
	                    $autoteam_id = '0';
	                    $firstname = $this->db->query("SELECT * FROM ost_staff_test WHERE staff_id = '$autostaff_id'")->row('firstname');
	                    $lastname = $this->db->query("SELECT * FROM ost_staff_test WHERE staff_id = '$autostaff_id'")->row('lastname');
	                    $staffname = $firstname.' '.$lastname;
	                }
	                else if ($manager{0} == 't')
	                {
	                    $autoteam_id = substr($manager, 1);
	                    $autostaff_id = '0';
	                    $staffname = $this->db->query("SELECT * FROM ost_team_test WHERE team_id = '$autoteam_id'")->row('name');
	                }

					$this->db->query("UPDATE osticket.ost_ticket_test SET assigned_to = '$autostaff_id', team_id = '$autoteam_id' WHERE ticket_id = '$ticket_id'");

					echo "<script> alert('Ticket #$todaydate2$number has been AUTO-ASSIGNED to Account Manager $staffname. Kindly change the auto-assignment setting inside organization page if you want to assign to another staff.');</script>";
				}

				if ($datetime > $todaydatetime)
					$insertdue = $this->db->query("UPDATE osticket.ost_ticket_test SET duedate = '$datetime' WHERE ticket_id = '$ticket_id'");

				$sql1 = $this->db->query("INSERT INTO osticket.ost_thread_entry_test ( ticket_id, staff_id, type, poster, body, ip_address, created, updated, class, avatar )
					VALUES ('$ticket_id', '$poster_id', 'S','$posterfname $posterlname', '$description', '$ipaddress', now(), now(), 'response', 'left')");

				if ($notes != '')
				{
					$sql2 = $this->db->query("INSERT INTO osticket.ost_thread_entry_test ( ticket_id, staff_id, type, poster, body, ip_address, created, updated, class, avatar )
					VALUES ('$ticket_id', '$poster_id', 'N','$posterfname $posterlname', '$notes', '$ipaddress', now(), now(), 'note', 'left')");
				}
			}

			else if (($checkuser == 0 && $checkemail != 0) || ($checkuser != 0 && $checkemail == 0))
			{
				echo "<script>alert('Email Address and Full Name Do Not Match');
					window.location = 'newticket?id=';</script>";die;
			}

			else if ($checkuser != 0 && $checkemail != 0)
			{
				$createticket = $this->db->query("INSERT INTO osticket.ost_ticket_test ( number, user_id, status_id, priority_id, department, sla_id, topic_id, subtopic_id, description, created_at, ticket_updated, ticket_updated_by_id, ticket_updated_by_role, assigned_to, team_id, ipadd, source)
				VALUES ( '$todaydate2$number', '$user_id', '$status_id', '$priority_id', '$userdepname', '$sla_id', '$subject', '$subtopic_id', '$description', now(), now(), '$poster_id', 'agent', '$staff_id', '$team_id', '$ipaddress', '$source')");
				
				$ticket_id = $this->db->query("SELECT * FROM ost_ticket_test WHERE number = '$todaydate2$number'")->row('ticket_id');

				if ($manager != $assign_id && $manager != '' && $autoassign == '1')
				{	
	                if ($manager{0} == 'a')
	                {
	                    $autostaff_id = substr($manager, 1);
	                    $autoteam_id = '0';
	                    $firstname = $this->db->query("SELECT * FROM ost_staff_test WHERE staff_id = '$autostaff_id'")->row('firstname');
	                    $lastname = $this->db->query("SELECT * FROM ost_staff_test WHERE staff_id = '$autostaff_id'")->row('lastname');
	                    $staffname = $firstname.' '.$lastname;
	                }
	                else if ($manager{0} == 't')
	                {
	                    $autoteam_id = substr($manager, 1);
	                    $autostaff_id = '0';
	                    $staffname = $this->db->query("SELECT * FROM ost_team_test WHERE team_id = '$autoteam_id'")->row('name');
	                }

					$this->db->query("UPDATE osticket.ost_ticket_test SET assigned_to = '$autostaff_id', team_id = '$autoteam_id' WHERE ticket_id = '$ticket_id'");

					echo "<script> alert('Ticket #$todaydate2$number has been AUTO-ASSIGNED to Account Manager $staffname. Kindly change the auto-assignment setting inside organization page if you want to assign to another staff.');</script>";
				}

				if ($datetime > $todaydatetime)
					$insertdue = $this->db->query("UPDATE osticket.ost_ticket_test SET duedate = '$datetime' WHERE ticket_id = $ticket_id");

				$sql1 = $this->db->query("INSERT INTO osticket.ost_thread_entry_test ( ticket_id, staff_id, type, poster, body, ip_address, created, updated, class, avatar )
					VALUES ('$ticket_id', '$poster_id', 'S','$posterfname $posterlname', '$description', '$ipaddress', now(), now(), 'response', 'left')");

				if ($notes != '')
				{
					$sql2 = $this->db->query("INSERT INTO osticket.ost_thread_entry_test ( ticket_id, staff_id, type, poster, body, ip_address, created, updated, class, avatar )
					VALUES ('$ticket_id', '$poster_id', 'N','$posterfname $posterlname', '$notes', '$ipaddress', now(), now(), 'note', 'left')");
				}
			}

			return $ticket_id;
		}

		else{

			redirect('staff_new_ticket_model/add_new');

		}
	}
}
?>