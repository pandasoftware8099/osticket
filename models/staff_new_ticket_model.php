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
        $assigned_alert_active = $this->db->query("SELECT value FROM ost_config_test WHERE id = '59'")->row('value');
        $assigned_alert_staff = $this->db->query("SELECT value FROM ost_config_test WHERE id = '60'")->row('value');
        $assigned_alert_team_lead = $this->db->query("SELECT value FROM ost_config_test WHERE id = '61'")->row('value');
        $assigned_alert_team_members = $this->db->query("SELECT value FROM ost_config_test WHERE id = '62'")->row('value');
        $alluseremail = array();

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

				if($assigned_alert_active == '1')
				{
					if($assigned_alert_staff == '1')
					{
						if($staff_guid != '0')
						{
							$staff_email = $this->db->query("SELECT email FROM ost_staff_test WHERE staff_guid = '$staff_guid'")->row('email');

							if (!in_array($staff_email, $alluseremail))
		                    {
		                        array_push($alluseremail, $staff_email);
		                    }
						}
					}

					if($assigned_alert_team_lead == '1')
					{
						if($team_guid != '0')
						{
							$team_lead_email = $this->db->query("SELECT a.email FROM ost_staff_test a INNER JOIN ost_team_test b ON b.lead_guid = a.staff_guid WHERE b.team_guid = '$team_guid'")->row('email');

							if (!in_array($team_lead_email, $alluseremail))
		                    {
		                        array_push($alluseremail, $team_lead_email);
		                    }
						}
					}

					if($assigned_alert_team_members == '1')
					{
						if($team_guid != '0')
						{
							$team_members_email = $this->db->query("SELECT a.email FROM ost_staff_test a INNER JOIN ost_team_member_test b ON b.staff_guid = a.staff_guid WHERE b.team_guid = '$team_guid'");

							foreach($team_members_email->result() as $value)
							{
								if (!in_array($value->email, $alluseremail))
			                    {
			                        array_push($alluseremail, $value->email);
			                    }
			                }
						}
					}
				}

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

					if($assigned_alert_active == '1')
					{
						$alluseremail = array();

						if($assigned_alert_staff == '1')
						{
							if($autostaff_guid != '0')
							{
								$staff_email = $this->db->query("SELECT email FROM ost_staff_test WHERE staff_guid = '$autostaff_guid'")->row('email');

								if (!in_array($staff_email, $alluseremail))
			                    {
			                        array_push($alluseremail, $staff_email);
			                    }
							}
						}

						if($assigned_alert_team_lead == '1')
						{
							if($autoteam_guid != '0')
							{
								$team_lead_email = $this->db->query("SELECT a.email FROM ost_staff_test a INNER JOIN ost_team_test b ON b.lead_guid = a.staff_guid WHERE b.team_guid = '$autoteam_guid'")->row('email');

								if (!in_array($team_lead_email, $alluseremail))
			                    {
			                        array_push($alluseremail, $team_lead_email);
			                    }
							}
						}

						if($assigned_alert_team_members == '1')
						{
							if($autoteam_guid != '0')
							{
								$team_members_email = $this->db->query("SELECT a.email FROM ost_staff_test a INNER JOIN ost_team_member_test b ON b.staff_guid = a.staff_guid WHERE b.team_guid = '$autoteam_guid'");

								foreach($team_members_email->result() as $value)
								{
									if (!in_array($value->email, $alluseremail))
				                    {
				                        array_push($alluseremail, $value->email);
				                    }
				                }
							}
						}
					}

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

				if($assigned_alert_active == '1')
				{
					if($assigned_alert_staff == '1')
					{
						if($staff_guid != '0')
						{
							$staff_email = $this->db->query("SELECT email FROM ost_staff_test WHERE staff_guid = '$staff_guid'")->row('email');

							if (!in_array($staff_email, $alluseremail))
		                    {
		                        array_push($alluseremail, $staff_email);
		                    }
						}
					}

					if($assigned_alert_team_lead == '1')
					{
						if($team_guid != '0')
						{
							$team_lead_email = $this->db->query("SELECT a.email FROM ost_staff_test a INNER JOIN ost_team_test b ON b.lead_guid = a.staff_guid WHERE b.team_guid = '$team_guid'")->row('email');

							if (!in_array($team_lead_email, $alluseremail))
		                    {
		                        array_push($alluseremail, $team_lead_email);
		                    }
						}
					}

					if($assigned_alert_team_members == '1')
					{
						if($team_guid != '0')
						{
							$team_members_email = $this->db->query("SELECT a.email FROM ost_staff_test a INNER JOIN ost_team_member_test b ON b.staff_guid = a.staff_guid WHERE b.team_guid = '$team_guid'");

							foreach($team_members_email->result() as $value)
							{
								if (!in_array($value->email, $alluseremail))
			                    {
			                        array_push($alluseremail, $value->email);
			                    }
			                }
						}
					}
				}
				
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

					if($assigned_alert_active == '1')
					{
						$alluseremail = array();

						if($assigned_alert_staff == '1')
						{
							if($autostaff_guid != '0')
							{
								$staff_email = $this->db->query("SELECT email FROM ost_staff_test WHERE staff_guid = '$autostaff_guid'")->row('email');

								if (!in_array($staff_email, $alluseremail))
			                    {
			                        array_push($alluseremail, $staff_email);
			                    }
							}
						}

						if($assigned_alert_team_lead == '1')
						{
							if($autoteam_guid != '0')
							{
								$team_lead_email = $this->db->query("SELECT a.email FROM ost_staff_test a INNER JOIN ost_team_test b ON b.lead_guid = a.staff_guid WHERE b.team_guid = '$autoteam_guid'")->row('email');

								if (!in_array($team_lead_email, $alluseremail))
			                    {
			                        array_push($alluseremail, $team_lead_email);
			                    }
							}
						}

						if($assigned_alert_team_members == '1')
						{
							if($autoteam_guid != '0')
							{
								$team_members_email = $this->db->query("SELECT a.email FROM ost_staff_test a INNER JOIN ost_team_member_test b ON b.staff_guid = a.staff_guid WHERE b.team_guid = '$autoteam_guid'");

								foreach($team_members_email->result() as $value)
								{
									if (!in_array($value->email, $alluseremail))
				                    {
				                        array_push($alluseremail, $value->email);
				                    }
				                }
							}
						}
					}

					echo "<script> alert('Ticket #$todaydate2$number has been AUTO-ASSIGNED to Account Manager $staffname. Kindly change the auto-assignment setting inside organization page if you want to assign to another staff.');</script>";
				}

				if ($datetime > $todaydatetime)
					$insertdue = $this->db->query("UPDATE osticket.ost_ticket_test SET duedate = '$datetime' WHERE ticket_guid = $ticket_guid");

				$sql1 = $this->db->query("INSERT INTO osticket.ost_thread_entry_test (thread_entry_guid, ticket_guid, staff_guid, type, poster, body, ip_address, created, updated, class, avatar )
					VALUES (REPLACE(UPPER(UUID()),'-',''), '$ticket_guid', '$poster_id', 'S','$posterfname $posterlname', '$description', '$ipaddress', now(), now(), 'response', 'left')");

				if ($notes != '')
				{
					$sql2 = $this->db->query("INSERT INTO osticket.ost_thread_entry_test ( thread_entry_guid, ticket_guid, staff_guid, type, poster, body, ip_address, created, updated, class, avatar )
					VALUES (REPLACE(UPPER(UUID()),'-',''), '$ticket_guid', '$poster_id', 'N','$posterfname $posterlname', '$notes', '$ipaddress', now(), now(), 'note', 'left')");
				}
			}

			foreach ($alluseremail as $value)
            {
                $this->load->library('email');

                $username = $this->db->query("SELECT CONCAT(a.firstname,' ',a.lastname) AS username, b.name FROM ost_staff_test a INNER JOIN ost_department_test b ON b.department_guid = a.dept_guid WHERE email = '$value'");
                $result = $this->db->query("SELECT ticket_guid FROM ost_ticket_test ORDER BY created_at DESC LIMIT 1")->row('ticket_guid');
                $poster = $this->db->query("SELECT CONCAT(a.firstname,' ',a.lastname) AS username FROM ost_staff_test a WHERE staff_guid = '$poster_id'")->row('username');
                $emailinfo = $this->db->query("SELECT * FROM ost_ticket_test WHERE ticket_guid = '$result'");
                $topicinfo = $this->db->query("SELECT * FROM ost_ticket_test b
                INNER JOIN ost_help_topic_test AS c ON b.topic_guid = c.topic_guid
                INNER JOIN ost_list_items_test AS d ON b.subtopic_guid = d.list_item_guid
                WHERE ticket_guid = '$result'");
                
                $default_template_id = $this->db->query("SELECT * FROM ost_config_test WHERE id = '87'")->row('value');

                    $login = 'http://[::1]/helpme/index.php/user_controller/login';

                $data = array(
                    'body' => $this->db->query("SELECT REPLACE(subject, '%number%', '".$emailinfo->row('number')."') AS email_subject, 
                        REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(body, '%user_name%', '".$username->row('username')."'), '%assigner%', '$poster'), '%number%', '".$emailinfo->row('number')."'), '%topic%', '".$topicinfo->row('topic')."'), '%department%', '".$username->row('name')."'), '%subtopic%', '".$topicinfo->row('value')."') AS email
                        FROM ost_email_template_test WHERE code_name = 'assigned.alert' AND tpl_guid = '$default_template_id'"),
                    'ticketsign' => $this->db->query("SELECT a.*, b.*, a.signature AS staffsign, b.signature AS deptsign FROM ost_staff_test AS a
                        INNER JOIN ost_department_test AS b ON a.dept_guid = b.department_guid
                        WHERE staff_guid = '$poster_id'"),
                    'template' => $this->db->query("SELECT * FROM ost_company_test"),
                );

                $default_email = $this->db->query("SELECT value FROM ost_config_test WHERE id='83'")->row('value');
                $sender_email = $this->db->query("SELECT * FROM ost_email_test WHERE email_guid='$default_email'")->row();

                $config = array(
    
                    'smtp_user' => $sender_email->userid,
                    'smtp_pass' => $sender_email->userpass,
                    'smtp_host' => $sender_email->smtp_host,
                    'smtp_port' => $sender_email->smtp_port,
                    
                );
                $bodyContent = $this->load->view('email_template', $data, TRUE);

                $this->email->initialize($config);
                $this->email->from($sender_email->userid); 
                $this->email->reply_to($sender_email->userid);    // Optional, an account where a human being reads.
                $this->email->to($value);
                $this->email->subject($data['body']->row('email_subject'));
                $this->email->message($bodyContent);
                $this->email->send();
            }

			return $ticket_guid;
		}

		else{

			redirect('staff_new_ticket_model/add_new');

		}
	}
}
?>