<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ajaxsearch_model extends CI_Model
{
	//ajax search org
	public function fetch_data($query)
  {
    $this->db->select("*");
    $this->db->from("ost_organization_test");

    if($query != '')
    {
      $this->db->like('name', $query);
      /*$this->db->or_like('manager', $query);*/
    }

    $this->db->order_by('name', 'ASC');
    return $this->db->get();
  }

 	//ajax search user
 	public function fetch_data_user($query)
  {
    $staff_depart = $_SESSION['staffdept'];
    $this->db->select("*");
    $this->db->from("ost_user_test");
    $this->db->where('user_depart', $staff_depart  ); // Produces: WHERE name = 'Joe'

    if($query != '')
    {
      $this->db->like('user_name', $query);
      $this->db->like('user_email', $query);
    }
    
    $this->db->order_by('user_name', 'ASC');
    
    return $this->db->get();
  }
}
?>