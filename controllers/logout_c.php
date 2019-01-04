<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class logout_c extends CI_Controller {
    
    function logout()
    {

        $this->session->sess_destroy();
        redirect('welcome/index');
    }

    function stafflogout()
    {

        $this->session->sess_destroy();
        redirect('user_controller/superlogin');
    }

    function clearSession()
    {
        if($this->session->userdata('loginuser') == true && $this->session->userdata('username') != '')
        {
            $username = $_SESSION['username'];
            $sub_location = $_SESSION['sub_location'];
            $location = $_SESSION['location'];
            $loc_group = $_SESSION['loc_group'];
            $loginuser = $_SESSION['loginuser'];
            $chinese_char  = $_SESSION['chinese_char'];

            redirect('logout_c/destroy?username='.$username."&sub_location=".$sub_location."&location=".$location."&loc_group=".$loc_group."&loginuser=".$loginuser."&chinese_char=".$chinese_char);
        }
        else
        {
            redirect('main_controller');
        }
    	
    }

    function destroy()
    {
    	$username = $_REQUEST['username'];
        $sub_location = $_REQUEST['sub_location'];
        $location = $_REQUEST['location'];
        $loc_group = $_REQUEST['loc_group'];
        $loginuser = $_REQUEST['loginuser'];
        $chinese_char = $_REQUEST['chinese_char'];
    	
    	$this->session->sess_destroy();
    	redirect('logout_c/home?username='.$username."&sub_location=".$sub_location."&location=".$location."&loc_group=".$loc_group."&loginuser=".$loginuser."&chinese_char=".$chinese_char);
    	
    }

    function home()
    {
    	$data = array(
    		'username' => $_REQUEST['username'],
            'sub_location' => $_REQUEST['sub_location'],
            'location' => $_REQUEST['location'],
            'loc_group' => $_REQUEST['loc_group'],
            'loginuser' => $_REQUEST['loginuser'],
            'chinese_char' => $_REQUEST['chinese_char'],
    		);

    	$this->session->set_userdata($data);
    	redirect('main_controller/homemenu');
    }
    
}