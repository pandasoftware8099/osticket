<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class user_model extends CI_Model
{
	public function add_process($user_name, $user_pas, $user_email, $user_phone, $user_phoneext)
	{
        $user_email = addslashes($user_email);
        $user_name = addslashes($user_name);
        $user_phone = addslashes($user_phone);
        $user_pas = addslashes($user_pas);
        $user_phoneext = addslashes($user_phoneext);

        $usercheck = $this->db->query("SELECT * FROM ost_user_test WHERE user_name = '$user_name' OR user_email = '$user_email' ");
        $emailcheck = $this->db->query("SELECT * FROM ost_user_test WHERE user_email = '$user_email' ");
        $namecheck = $this->db->query("SELECT * FROM ost_user_test WHERE user_name = '$user_name' ");
      
        if($usercheck->num_rows() == 0){
    		$this->db->query("INSERT INTO osticket.ost_user_test (user_guid, user_name , user_pas, user_created_at, user_updated_at, user_depart, user_email, user_phone, user_phoneext, status, active )
    		VALUES (REPLACE(UPPER(UUID()),'-',''), '$user_name', '$user_pas', now(), now(), '1', '$user_email', '$user_phone', '$user_phoneext', '3', '0' )");

    		$splitemail = explode('@', $user_email);
            $domain = '@'.$splitemail[1];
            $org = $this->db->query("SELECT * FROM ost_organization_test");
            $user_guid = $this->db->query("SELECT * FROM ost_user_test WHERE user_name = '$user_name'")->row('user_guid');

            foreach ($org->result() as $orgdomain)
            {
                if ($orgdomain->domain == $domain)
                    $this->db->query("UPDATE ost_user_test SET user_org_guid = '$orgdomain->organization_guid' WHERE user_guid = '$user_guid' ");
            }
        }
        else if ($emailcheck->num_rows() !== 0 && $namecheck->num_rows() !== 0)
        {
            echo "<script> alert('User already exists');</script>";
            echo "<script> document.location='" . base_url() . "/index.php/user_controller/register' </script>";
        }
        else if ($emailcheck->num_rows() !== 0){
            echo "<script> alert('Email duplicated');</script>";
            echo "<script> document.location='" . base_url() . "/index.php/user_controller/register' </script>";
        }
        else if ($namecheck->num_rows() !== 0){
            echo "<script> alert('Name duplicated');</script>";
            echo "<script> document.location='" . base_url() . "/index.php/user_controller/register' </script>";
        }
	}

	public function login_data($username, $userpass)
    {
        //data is retrive from this query
        $sql = "SELECT * FROM osticket.ost_user_test WHERE user_name='$username' AND user_pas='$userpass'";

        $query = $this->db->query($sql);
        return $query->num_rows();
        
    }

    public function checkpass($userid, $userpass)
    {
        //data is retrive from this query
        $sql = "SELECT * FROM osticket.ost_user_test WHERE user_guid='$userid' AND user_pas='$userpass'";

        $query = $this->db->query($sql);
        return $query->num_rows();
        
    }

    public function super_login_data($username, $userpass)
    {
        //data is retrive from this query
        $sql = "SELECT * FROM osticket.ost_staff_test WHERE username='$username' AND passwd='$userpass'";

        $query = $this->db->query($sql);
        return $query->num_rows();
        
    }
}
?>