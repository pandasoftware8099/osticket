<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class staff_faqs_controller extends CI_Controller {
    
    public function __construct()
    {
        parent::__construct();
        $this->load->model('');
        $this->load->library(array('session'));
        $this->load->library('session');
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper(array('form','url'));
        $this->load->helper('html');
        $this->load->database();
        $this->load->library('form_validation');
 
    }


    public function main()
    {      
        if($this->session->userdata('loginstaff') == true && $this->session->userdata('staffname') != '')
        {   
            $data = array(

           'faqcate' => $this->db->query("SELECT * FROM ost_faq_category_test"),

            );
        $browser_id = $_SERVER["HTTP_USER_AGENT"];
        if(strpos($browser_id,"Windows CE") || strpos($browser_id,"Windows NT 5.1") )
            {

                /*$this->load->view('WinCe/header');
                $this->load->view('WinCe/po/po_main',$data);*/
                
            }
        else
            {
                $this->load->view('headerstaff');
                $this->load->view('faqs/faqs_main', $data);
                /*$this->load->view('footer');*/
            }    
        }

        else       
        {
           redirect('user_controller/superlogin');
        }

    }

    public function faqsearch_process()

    {   $search = $this->input->post('search');

        $data = array(
            'search' => $this->db->query("SELECT * FROM ost_faq_test WHERE question LIKE '$search%';"),

            );
        $this->load->view('headerstaff');  
        $this->load->view('faqs/faqs_search', $data);    

    }

    public function faqcategory()
    {      
        if($this->session->userdata('loginstaff') == true && $this->session->userdata('staffname') != '')
        {   $category_guid = $_REQUEST['cid'];
           $staffid = $_SESSION["staffid"];
            $data = array(
            'faqcate' => $this->db->query("SELECT * FROM ost_faq_category_test WHERE category_guid ='$category_guid' "),
            'faqinfo' => $this->db->query("SELECT * FROM ost_faq_test WHERE category_guid = '$category_guid' "),

            'faqallow' => $this->db->query(" SELECT * FROM ost_staff_test WHERE staff_guid = '$staffid' AND permissions LIKE '%faq.manage%'")->num_rows(),

            );

        $browser_id = $_SERVER["HTTP_USER_AGENT"];
        if(strpos($browser_id,"Windows CE") || strpos($browser_id,"Windows NT 5.1") )
            {

                /*$this->load->view('WinCe/header');
                $this->load->view('WinCe/po/po_main',$data);*/
                
            }
        else
            {
                $this->load->view('headerstaff');
                $this->load->view('faqs/faqs_category', $data);
                /*$this->load->view('footer');*/
            }    
        }

        else       
        {
           redirect('user_controller/superlogin');
        }

    }

    public function faqinfo()
    {      
        if($this->session->userdata('loginstaff') == true && $this->session->userdata('staffname') != '')
        {   $faqid = $_REQUEST['id'];
           $staffid = $_SESSION["staffid"];
            $data = array(
            'faqdetails' => $this->db->query("SELECT * FROM ost_faq_info_test WHERE faq_guid ='$faqid' "),
            'faqinfo' => $this->db->query("SELECT * FROM ost_faq_test WHERE faq_guid = '$faqid' "),

            'faqcate' => $this->db->query("SELECT * FROM ost_faq_test INNER JOIN ost_faq_category_test ON ost_faq_test.category_guid = ost_faq_category_test.category_guid WHERE faq_guid = '$faqid' ")->row(),

            'faqallow' => $this->db->query(" SELECT * FROM ost_staff_test WHERE staff_guid = '$staffid' AND permissions LIKE '%faq.manage%'")->num_rows(),

            );
        $browser_id = $_SERVER["HTTP_USER_AGENT"];
        if(strpos($browser_id,"Windows CE") || strpos($browser_id,"Windows NT 5.1") )
            {

                /*$this->load->view('WinCe/header');
                $this->load->view('WinCe/po/po_main',$data);*/
                
            }
        else
            {
                $this->load->view('headerstaff');
                $this->load->view('faqs/faqs_info', $data);
                /*$this->load->view('footer');*/
            }    
        }

        else       
        {
           redirect('user_controller/superlogin');
        }

    }

    public function faqadd()
    {      
        if($this->session->userdata('loginstaff') == true && $this->session->userdata('staffname') != '')
        {   
            $data = array(
                'faqcate' => $this->db->query("SELECT * FROM ost_faq_category_test "),
                'faqinfo' => $this->db->query("SELECT * FROM ost_faq_test "),
                'max_file_size' => $this->db->query("SELECT value FROM ost_config_test WHERE id = '77'")->row('value'),
                'max_files' => $this->db->query("SELECT value FROM ost_config_test WHERE id = '119'")->row('value'),
            );
        $browser_id = $_SERVER["HTTP_USER_AGENT"];
        if(strpos($browser_id,"Windows CE") || strpos($browser_id,"Windows NT 5.1") )
            {

                /*$this->load->view('WinCe/header');
                $this->load->view('WinCe/po/po_main',$data);*/
                
            }
        else
            {
                $this->load->view('headerstaff');
                $this->load->view('faqs/faqs_addfaq', $data);
                /*$this->load->view('footer');*/
            }    
        }

        else       
        {
           redirect('user_controller/superlogin');
        }

    }

    public function faqadd_process()
    {      
        $cate_id = $this->input->post('category_guid');
        $ispublished = $this->input->post('ispublished');
        $question = $this->input->post('question');
        $answer = $this->input->post('answer');
        $notes = $this->input->post('notes');

        $ipaddress = $_SERVER['REMOTE_ADDR'];

        $faq_guid = $this->db->query("SELECT REPLACE(UPPER(UUID()),'-','') AS guid")->row('guid');
        $this->db->query("INSERT INTO ost_faq_test (faq_guid, category_guid, ispublished, question, answer, notes, created, updated) VALUES ('$faq_guid', '$cate_id', '$ispublished', '$question', '$answer', '$notes', NOW(),NOW() ); ");
            
        //filename none wont report error
        if(isset($_POST['submit']))
        {
            // Count total files
            $countfiles = count($_FILES['file']['name']);

            if ($_FILES['file']['name'][0] != "")
            {
                // Looping all files
                for($i=0;$i<$countfiles;$i++)
                {
                    $faq_guid = $this->db->query("SELECT faq_guid FROM ost_faq_test WHERE created = now() ")->row('faq_guid');
                    $filename = 'faq'.$faq_guid.'_'.$_FILES['file']['name'][$i];

                    // Upload file
                    move_uploaded_file($_FILES['file']['tmp_name'][$i],'../helpme/uploads/'.$filename);

                    $this->db->query("INSERT ost_file_test (file_guid, type, name, created , faq_guid )
                    VALUES (REPLACE(UPPER(UUID()),'-',''), 'faq', '$filename', NOW(), '$faq_guid' ) ");
                }
                echo "<script> alert('$i File(s) and FAQ submitted.');</script>";
            }
            else
            {
                echo "<script> alert('FAQ submitted.');</script>";
            }
        }

        echo "<script> document.location='" . base_url() . "/index.php/staff_faqs_controller/faqcategory?cid=$cate_id' </script>";
    }

    public function faqeditfaq()
    {      
        if($this->session->userdata('loginstaff') == true && $this->session->userdata('staffname') != '')
        {   
            $faq_guid = $_REQUEST['id'];
            $data = array(
                'faqcate' => $this->db->query("SELECT * FROM ost_faq_category_test"),
                'faqinfo' => $this->db->query("SELECT * FROM ost_faq_test WHERE faq_guid = '$faq_guid' "),
                'max_file_size' => $this->db->query("SELECT value FROM ost_config_test WHERE id = '77'")->row('value'),
                'max_files' => $this->db->query("SELECT value FROM ost_config_test WHERE id = '119'")->row('value'),
            );

            $browser_id = $_SERVER["HTTP_USER_AGENT"];
            if(strpos($browser_id,"Windows CE") || strpos($browser_id,"Windows NT 5.1") )
            {

                /*$this->load->view('WinCe/header');
                $this->load->view('WinCe/po/po_main',$data);*/
                
            }
            else
            {
                $this->load->view('headerstaff');
                $this->load->view('faqs/faqs_editfaq', $data);
                /*$this->load->view('footer');*/
            }    
        }

        else       
        {
           redirect('user_controller/superlogin');
        }
    }

    public function faqedit_process()
    {                         
        $faq_guid = $_REQUEST['id'];   
        $cate_id = $this->input->post('category_guid');
        $ispublished = $this->input->post('ispublished');
        $question = $this->input->post('question');
        $answer = $this->input->post('answer');
        $notes = $this->input->post('notes');

        $this->db->query("UPDATE ost_faq_test
            SET category_guid = '$cate_id', 
            ispublished = '$ispublished', 
            question = '$question', 
            answer = '$answer',
            notes = '$notes',
            updated = now()
            WHERE faq_guid = '$faq_guid';");

        //filename none wont report error
        error_reporting(0);
        if(isset($_POST['submit'])){
     
            // Count total files
            $countfiles = count($_FILES['file']['name']);

            // Looping all files
            for($i=0;$i<$countfiles;$i++){

                if ($_FILES['file']['name'][0] != "") {

                    $filename = 'faq'.$faq_guid.'_'.$_FILES['file']['name'][$i];

                    // Upload file
                    move_uploaded_file($_FILES['file']['tmp_name'][$i],'../helpme/uploads/'.$filename);

                    $this->db->query("INSERT ost_file_test (file_guid, type, name, created , faq_guid )
                    VALUES (REPLACE(UPPER(UUID()),'-',''), 'faq', '$filename', NOW(), '$faq_guid' ) ");
                }
            }

            if ($filename == ""){

                echo "<script> alert('FAQ submitted.');</script>"; 
                echo "<script> document.location='" . base_url() . "/index.php/staff_faqs_controller/faqcategory?cid=$cate_id' </script>";

            }

            else {

            echo "<script> alert('$i File(s) and FAQ submitted.');</script>";
            echo "<script> document.location='" . base_url() . "/index.php/staff_faqs_controller/faqcategory?cid=$cate_id' </script>";

            }
        }
    }

    public function faqdelete_process()

    {   $faq_guid = $_REQUEST['id'];   
        
        $name = $this->db->query("SELECT question FROM ost_faq_test WHERE faq_guid = '$faq_guid' ")->row('question');
        $this->db->query("DELETE FROM ost_faq_test WHERE faq_guid='$faq_guid' ");
        $this->db->query("DELETE FROM ost_file_test WHERE faq_guid='$faq_guid' ");

        echo "<script> alert('$name FAQ deleted.');</script>";
        echo "<script> document.location='" . base_url() . "/index.php/staff_faqs_controller/main' </script>";
    }

    public function faqeditcate()
    {      
        if($this->session->userdata('loginstaff') == true && $this->session->userdata('staffname') != '')
        {   $cate_id = $_REQUEST['id'];
            $data = array(
            'faqcate' => $this->db->query("SELECT * FROM ost_faq_category_test WHERE category_guid = '$cate_id' "),
            'faqinfo' => $this->db->query("SELECT * FROM ost_faq_test ")


            );
        $browser_id = $_SERVER["HTTP_USER_AGENT"];
        if(strpos($browser_id,"Windows CE") || strpos($browser_id,"Windows NT 5.1") )
            {

                /*$this->load->view('WinCe/header');
                $this->load->view('WinCe/po/po_main',$data);*/
                
            }
        else
            {
                $this->load->view('headerstaff');
                $this->load->view('faqs/faqs_editcate', $data);
                /*$this->load->view('footer');*/
            }    
        }

        else       
        {
           redirect('user_controller/superlogin');
        }

    }

    public function faqeditcate_process()
    {   
        $cate_id = $_REQUEST['id'];   
        $ispublic = $this->input->post('ispublic');
        $catename = $this->input->post('catename');
        $catedescrip = $this->input->post('catedescrip');
        $catenotes = $this->input->post('catenotes');

        $this->db->query("UPDATE ost_faq_category_test SET
            name = '$catename', 
            ispublic = '$ispublic',
            description = '$catedescrip',
            notes = '$catenotes',
            updated = now()
            WHERE category_guid = '$cate_id' ;");

        echo "<script> alert('FAQ category edited succesfully.');</script>";
        echo "<script> document.location='" . base_url() . "/index.php/staff_faqs_controller/faqcategory?cid=$cate_id' </script>";
    }

    public function printprewviewfaq()
    {      
        if($this->session->userdata('loginstaff') == true && $this->session->userdata('staffname') != '')
        {

            $faq_guid = $_REQUEST['id'];
            $data = array(
            'faqcate' => $this->db->query("SELECT * FROM ost_faq_category_test WHERE category_guid = '$faq_guid' "),
            'faqinfo' => $this->db->query("SELECT * FROM ost_faq_test WHERE faq_guid = '$faq_guid' ")

            );

        $browser_id = $_SERVER["HTTP_USER_AGENT"];
        if(strpos($browser_id,"Windows CE") || strpos($browser_id,"Windows NT 5.1") )
            {

                /*$this->load->view('WinCe/header');
                $this->load->view('WinCe/po/po_main',$data);*/
                
            }
        else
            {
                /*$this->load->view('header');*/
                $this->load->view('faqs/faqs_print',$data);
                /*$this->load->view('footer');*/
            }    
        }

        else       
        {
           redirect('user_controller/superlogin');
        }

    }

     public function categories()
    {      
        if($this->session->userdata('loginstaff') == true && $this->session->userdata('staffname') != '')
        {  
            $data = array(
                'faqcate' => $this->db->query("SELECT * FROM ost_faq_category_test"),
                'faqinfocount' => $this->db->query("SELECT * FROM ost_faq_test "),
                'max_page_size' => $this->db->query("SELECT value FROM ost_config_test WHERE id = '21'")->row('value'),
            );
            
            $browser_id = $_SERVER["HTTP_USER_AGENT"];
            if(strpos($browser_id,"Windows CE") || strpos($browser_id,"Windows NT 5.1") )
            {

                /*$this->load->view('WinCe/header');
                $this->load->view('WinCe/po/po_main',$data);*/
                
            }
            else
            {
                $this->load->view('headerstaff');
                $this->load->view('faqs/knowledgebase_categories', $data);
                /*$this->load->view('footer');*/
            }    
        }

        else       
        {
           redirect('user_controller/superlogin');
        }

    }

    public function categories_delete_process()

    {   

        /*$faq_guid = $this->input->post('tids[]');*/
        $category_guid = $_REQUEST['cid'];
        $file_faq_guid = $this->db->query("SELECT faq_guid FROM ost_faq_test WHERE category_guid = '$category_guid' ")->row('faq_guid');
        $name = $this->db->query("SELECT name FROM ost_faq_category_test WHERE category_guid = '$category_guid' ")->row('name');

        $this->db->query("DELETE FROM ost_faq_category_test WHERE category_guid='$category_guid' ");    
        $this->db->query("DELETE FROM ost_faq_test WHERE category_guid='$category_guid' ");
        $this->db->query("DELETE FROM ost_file_test WHERE faq_guid='$file_faq_guid' ");


        echo "<script> alert('Category name $name deleted.');</script>";
        /*echo "<script> document.location='" . base_url() . "/index.php/staff_faqs_controller/main' </script>";*/
        echo "<script> document.location='" . base_url() . "/index.php/staff_faqs_controller/main' </script>";

        

    }

    public function categories_add()
    {      
        if($this->session->userdata('loginstaff') == true && $this->session->userdata('staffname') != '')
        {  
            $data = array(
            'faqcate' => $this->db->query("SELECT * FROM ost_faq_category_test"),
            
            'faqinfocount' => $this->db->query("SELECT * FROM ost_faq_test "),

            );
        $browser_id = $_SERVER["HTTP_USER_AGENT"];
        if(strpos($browser_id,"Windows CE") || strpos($browser_id,"Windows NT 5.1") )
            {

                /*$this->load->view('WinCe/header');
                $this->load->view('WinCe/po/po_main',$data);*/
                
            }
        else
            {
                $this->load->view('headerstaff');
                $this->load->view('faqs/knowledgebase_categories_add', $data);
                /*$this->load->view('footer');*/
            }    
        }

        else       
        {
           redirect('user_controller/superlogin');
        }

    }

    public function categories_add_process()
    {      
        $ispublic = $this->input->post('ispublic');
        $catename = $this->input->post('catename');
        $catedescrip = $this->input->post('catedescrip');
        $catenotes = $this->input->post('catenotes');

        $this->db->query("INSERT INTO ost_faq_category_test 
            (ispublic, name, description, notes, created, updated) 
            VALUES 
            ('$ispublic', '$catename', '$catedescrip', '$catenotes', NOW(),NOW() ); ");

        $cate_id = $this->db->query("SELECT category_guid FROM ost_faq_category_test WHERE created =now() ")->row('category_guid');

        echo "<script> alert('FAQ category added succesfully.');</script>";
        echo "<script> document.location='" . base_url() . "/index.php/staff_faqs_controller/faqcategory?cid=$cate_id' </script>";

    }



    public function agent()
    {      
        if($this->session->userdata('loginstaff') == true && $this->session->userdata('staffname') != '')
        {
         
        $browser_id = $_SERVER["HTTP_USER_AGENT"];
        if(strpos($browser_id,"Windows CE") || strpos($browser_id,"Windows NT 5.1") )
            {

                /*$this->load->view('WinCe/header');
                $this->load->view('WinCe/po/po_main',$data);*/
                
            }
        else
            {
                $this->load->view('headerstaff');
                $this->load->view('faqs/faqs_agent');
                /*$this->load->view('footer');*/
            }    
        }

        else       
        {
           redirect('user_controller/superlogin');
        }

    }

    public function canned_response()
    {      
        if($this->session->userdata('loginstaff') == true && $this->session->userdata('staffname') != '')
        {  
            $data = array(
                'faqcanned' => $this->db->query("SELECT a.isenabled,a.canned_id, a.title, a.response, a.dept_id, b.department_guid, b.`name` FROM ost_canned_response a LEFT JOIN ost_department_test b ON a.`dept_id` = b.`department_guid` "),
                'faqinfocount' => $this->db->query("SELECT * FROM ost_faq_test "),
                'max_page_size' => $this->db->query("SELECT value FROM ost_config_test WHERE id = '21'")->row('value'),
            );
            
            $browser_id = $_SERVER["HTTP_USER_AGENT"];
            if(strpos($browser_id,"Windows CE") || strpos($browser_id,"Windows NT 5.1") )
            {

                /*$this->load->view('WinCe/header');
                $this->load->view('WinCe/po/po_main',$data);*/
                
            }
            else
            {
                $this->load->view('headerstaff');
                $this->load->view('faqs/knowledgebase_canned', $data);
                /*$this->load->view('footer');*/
            }    
        }

        else       
        {
           redirect('user_controller/superlogin');
        }

    }

    public function canned_response_process()
    {      
        $canned_guid = $this->input->post('tids[]');
        $status = $this->input->post('status');

        if ($status == '2') {
            foreach ($canned_guid as $value) {
            $this->db->query("DELETE FROM ost_canned_response WHERE canned_id = '$value' ");
            }

            echo "<script> alert('Selected canned response(s) deleted.');</script>";
            echo "<script> document.location='" . base_url() . "/index.php/staff_faqs_controller/canned_response' </script>";
        }

        else{

            foreach ($canned_guid as $value) {
            $this->db->query("UPDATE ost_canned_response SET isenabled = '$status' WHERE canned_id = '$value'  ");
        }

        echo "<script> alert('Selected canned response(s) status changed.');</script>";
        echo "<script> document.location='" . base_url() . "/index.php/staff_faqs_controller/canned_response' </script>";

        }

        

    }

    public function canned_response_add()
    {      
        if($this->session->userdata('loginstaff') == true && $this->session->userdata('staffname') != '')
        {  $data = array(
                'department' => $this->db->query("SELECT * FROM ost_department_test "),
            );
            
            
            $browser_id = $_SERVER["HTTP_USER_AGENT"];
            if(strpos($browser_id,"Windows CE") || strpos($browser_id,"Windows NT 5.1") )
            {

                /*$this->load->view('WinCe/header');
                $this->load->view('WinCe/po/po_main',$data);*/
                
            }
            else
            {
                $this->load->view('headerstaff');
                $this->load->view('faqs/knowledgebase_canned_add', $data);
                /*$this->load->view('footer');*/
            }    
        }

        else       
        {
           redirect('user_controller/superlogin');
        }

    }

    public function canned_response_add_process()
    {      
        $isenabled = $this->input->post('isenabled');
        $dept_guid = $this->input->post('dept_guid');
        $title = $this->input->post('title');
        $canned_response = $this->input->post('canned_response');
        $notes = $this->input->post('notes');


        $this->db->query("INSERT INTO ost_canned_response (isenabled, dept_id, title, response, notes, created, updated  )
            VALUES ('$isenabled', '$dept_guid', '$title', '$canned_response','$notes', NOW(), NOW() )");

            echo "<script> alert('Canned response added.');</script>";
            echo "<script> document.location='" . base_url() . "/index.php/staff_faqs_controller/canned_response' </script>";
      

    }

    public function canned_response_info()
    {      
        if($this->session->userdata('loginstaff') == true && $this->session->userdata('staffname') != '')
        {  

            $canned_guid = $_REQUEST['id'];

            $data = array(
                'department' => $this->db->query("SELECT * FROM ost_department_test "),
                'canned_info' => $this->db->query("SELECT * FROM ost_canned_response WHERE canned_id = '$canned_guid' ")
            );
            
            
            $browser_id = $_SERVER["HTTP_USER_AGENT"];
            if(strpos($browser_id,"Windows CE") || strpos($browser_id,"Windows NT 5.1") )
            {

                /*$this->load->view('WinCe/header');
                $this->load->view('WinCe/po/po_main',$data);*/
                
            }
            else
            {
                $this->load->view('headerstaff');
                $this->load->view('faqs/knowledgebase_canned_info', $data);
                /*$this->load->view('footer');*/
            }    
        }

        else       
        {
           redirect('user_controller/superlogin');
        }

    }

    public function canned_response_info_process()
    {      
        $isenabled = $this->input->post('isenabled');
        $dept_guid = $this->input->post('dept_guid');
        $title = $this->input->post('title');
        $canned_response = $this->input->post('canned_response');
        $notes = $this->input->post('notes');
        $canned_id = $_REQUEST['id'];


        $this->db->query("UPDATE ost_canned_response 
            SET isenabled = '$isenabled',
            dept_id = '$dept_guid',
            title = '$title',
            response ='$canned_response',
            notes ='$notes',
            updated = NOW()
            WHERE canned_id = '$canned_id'  ");

            echo "<script> alert('Canned response added.');</script>";
            echo "<script> document.location='" . base_url() . "/index.php/staff_faqs_controller/canned_response' </script>";
      

    }


}
?>