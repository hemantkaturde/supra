<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

use PhpOffice\PhpWord\Shared\Html;
use PhpOffice\PhpWord\Element\TableRow;


/**
 * Class : Admin (AdminController)
 * Admin class to control to authenticate admin credentials and include admin functions.
 * @author : Samet Aydın / sametay153@gmail.com
 * @version : 1.0
 * @since : 27.02.2018
 */
class Admin extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('login_model');
        $this->load->model('user_model');
        $this->load->model('admin_model');
        $this->load->library('form_validation');
        $this->load->library('excel');
        // Datas -> libraries ->BaseController / This function used load user sessions
        $this->datas();
        // isLoggedIn / Login control function /  This function used login control
        $isLoggedIn = $this->session->userdata('isLoggedIn');
        if(!isset($isLoggedIn) || $isLoggedIn != TRUE)
        {
            redirect('login');
        }
        
        else
        {
            // isAdmin / Admin role control function / This function used admin role control
            if($this->isAdmin() == TRUE)
            {
                $this->accesslogincontrol();
            }
        }
    }
	
     /**
     * This function is used to load the user list
     */
    function userListing()
    {   
            $searchText = $this->security->xss_clean($this->input->post('searchText'));
            $data['searchText'] = $searchText;
            
            $this->load->library('pagination');
            
            $count = $this->user_model->userListingCount($searchText);

			$returns = $this->paginationCompress ( "userListing/", $count, 10 );
            
            $data['userRecords'] = $this->user_model->userListing($searchText, $returns["page"], $returns["segment"]);
            
            $process = 'User Listing';
            $processFunction = 'Admin/userListing';
            $this->logrecord($process,$processFunction);

            $this->global['pageTitle'] = 'Admin : User Listing';
            
            $this->loadViews("users", $this->global, $data, NULL);
    }

    /**
     * This function is used to load the add new form
     */
    function addNew()
    {
            $data['roles'] = $this->user_model->getUserRoles();

            $this->global['pageTitle'] = 'Admin : Add User';

            $this->loadViews("addNew", $this->global, $data, NULL);
    }


    /**
     * This function is used to add new user to the system
     */
    function addNewUser()
    {
            $this->load->library('form_validation');
            
            $this->form_validation->set_rules('fname','Full Name','trim|required|max_length[128]');
            $this->form_validation->set_rules('email','Email','trim|required|valid_email|max_length[128]');
            $this->form_validation->set_rules('password','Password','required|max_length[20]');
            $this->form_validation->set_rules('cpassword','Confirm Password','trim|required|matches[password]|max_length[20]');
            $this->form_validation->set_rules('role','Role','trim|required|numeric');
            $this->form_validation->set_rules('mobile','Mobile Number','required|min_length[10]');
            
            if($this->form_validation->run() == FALSE)
            {
                $this->addNew();
            }
            else
            {
                $name = ucwords(strtolower($this->security->xss_clean($this->input->post('fname'))));
                $email = $this->security->xss_clean($this->input->post('email'));
                $password = $this->input->post('password');
                $roleId = $this->input->post('role');
                $mobile = $this->security->xss_clean($this->input->post('mobile'));
                
                $userInfo = array('email'=>$email, 'password'=>getHashedPassword($password), 'roleId'=>$roleId, 'name'=> $name,
                                    'mobile'=>$mobile, 'createdBy'=>$this->vendorId, 'createdDtm'=>date('Y-m-d H:i:s'));
                                    
                $result = $this->user_model->addNewUser($userInfo);
                
                if($result > 0)
                {
                    $process = 'Add Userme';
                    $processFunction = 'Admin/addNewUser';
                    $this->logrecord($process,$processFunction);

                    $this->session->set_flashdata('success', 'User created successfully');
                }
                else
                {
                    $this->session->set_flashdata('error', 'User creation failed');
                }
                
                redirect('userListing');
            }
    }

     /**
     * This function is used load user edit information
     * @param number $userId : Optional : This is user id
     */
    function editOld($userId = NULL)
    {
            if($userId == null)
            {
                redirect('userListing');
            }
            
            $data['roles'] = $this->user_model->getUserRoles();
            $data['userInfo'] = $this->user_model->getUserInfo($userId);

            $this->global['pageTitle'] = 'Admin : Edit User';
            
            $this->loadViews("editOld", $this->global, $data, NULL);
    }


    /**
     * This function is used to edit the user informations
     */
    function editUser()
    {
            $this->load->library('form_validation');
            
            $userId = $this->input->post('userId');
            
            $this->form_validation->set_rules('fname','Full Name','trim|required|max_length[128]');
            $this->form_validation->set_rules('email','Email','trim|required|valid_email|max_length[128]');
            $this->form_validation->set_rules('password','Password','matches[cpassword]|max_length[20]');
            $this->form_validation->set_rules('cpassword','Confirm Password','matches[password]|max_length[20]');
            $this->form_validation->set_rules('role','Role','trim|required|numeric');
            $this->form_validation->set_rules('mobile','Mobile Number','required|min_length[10]');
            
            if($this->form_validation->run() == FALSE)
            {
                $this->editOld($userId);
            }
            else
            {
                $name = ucwords(strtolower($this->security->xss_clean($this->input->post('fname'))));
                $email = $this->security->xss_clean($this->input->post('email'));
                $password = $this->input->post('password');
                $roleId = $this->input->post('role');
                $mobile = $this->security->xss_clean($this->input->post('mobile'));
                
                $userInfo = array();
                
                if(empty($password))
                {
                    $userInfo = array('email'=>$email, 'roleId'=>$roleId, 'name'=>$name,
                                    'mobile'=>$mobile, 'status'=>0, 'updatedBy'=>$this->vendorId, 'updatedDtm'=>date('Y-m-d H:i:s'));
                }
                else
                {
                    $userInfo = array('email'=>$email, 'password'=>getHashedPassword($password), 'roleId'=>$roleId,
                        'name'=>ucwords($name), 'mobile'=>$mobile,'status'=>0, 'updatedBy'=>$this->vendorId, 
                        'updatedDtm'=>date('Y-m-d H:i:s'));
                }
                
                $result = $this->user_model->editUser($userInfo, $userId);
                
                if($result == true)
                {
                    $process = 'Update User';
                    $processFunction = 'Admin/editUser';
                    $this->logrecord($process,$processFunction);

                    $this->session->set_flashdata('success', 'User successfully updated');
                }
                else
                {
                    $this->session->set_flashdata('error', 'User update failed');
                }
                
                redirect('userListing');
            }
    }

     /**
     * This function is used to delete the user using userId
     * @return boolean $result : TRUE / FALSE
     */
    function deleteUser()
    {
            $userId = $this->input->post('userId');
            $userInfo = array('isDeleted'=>1,'updatedBy'=>$this->vendorId, 'updatedDtm'=>date('Y-m-d H:i:s'));
            
            $result = $this->user_model->deleteUser($userId, $userInfo);
            
            if ($result > 0) {
                 echo(json_encode(array('status'=>TRUE)));

                 $process = 'Delete User';
                 $processFunction = 'Admin/deleteUser';
                 $this->logrecord($process,$processFunction);

                }
            else { echo(json_encode(array('status'=>FALSE))); }
    }

     /**
     * This function used to show log history
     * @param number $userId : This is user id
     */
    function logHistory($userId = NULL)
    {
            $data['dbinfo'] = $this->user_model->gettablemb('tbl_log','cias');
            if(isset($data['dbinfo']->total_size))
            {
                if(($data['dbinfo']->total_size)>1000){
                    $this->backupLogTable();
                }
            }
            $data['userRecords'] = $this->user_model->logHistory($userId);

            $process = 'Log Records';
            $processFunction = 'Admin/logHistory';
            $this->logrecord($process,$processFunction);

            $this->global['pageTitle'] = 'Admin : Log Records';
            
            $this->loadViews("logHistory", $this->global, $data, NULL);
    }

    /**
     * This function used to show specific user log history
     * @param number $userId : This is user id
     */
    function logHistorysingle($userId = NULL)
    {       
            $userId = ($userId == NULL ? $this->session->userdata("userId") : $userId);
            $data["userInfo"] = $this->user_model->getUserInfoById($userId);
            $data['userRecords'] = $this->user_model->logHistory($userId);
            
            $process = 'Single Log Viewing';
            $processFunction = 'Admin/logHistorysingle';
            $this->logrecord($process,$processFunction);

            $this->global['pageTitle'] = 'Admin : User Login History';
            
            $this->loadViews("logHistorysingle", $this->global, $data, NULL);      
    }
    
    /**
     * This function used to backup and delete log table
     */
    function backupLogTable()
    {
        $this->load->dbutil();
        $prefs = array(
            'tables'=>array('tbl_log')
        );
        $backup=$this->dbutil->backup($prefs) ;

        date_default_timezone_set('Europe/Istanbul');
        $date = date('d-m-Y H-i');

        $filename = './backup/'.$date.'.sql.gz';
        $this->load->helper('file');
        write_file($filename,$backup);

        $this->user_model->clearlogtbl();

        if($backup)
        {
            $this->session->set_flashdata('success', 'Spare and Table cleaning successful');
            redirect('log-history');
        }
        else
        {
            $this->session->set_flashdata('error', 'Spare and Table cleanup failed');
            redirect('log-history');
        }
    }

    /**
     * This function used to open the logHistoryBackup page
     */
    function logHistoryBackup()
    {
            $data['dbinfo'] = $this->user_model->gettablemb('tbl_log_backup','cias');
            if(isset($data['dbinfo']->total_size))
            {
            if(($data['dbinfo']->total_size)>1000){
                $this->backupLogTable();
            }
            }
            $data['userRecords'] = $this->user_model->logHistoryBackup();

            $process = 'Spare Log Viewing';
            $processFunction = 'Admin/logHistoryBackup';
            $this->logrecord($process,$processFunction);

            $this->global['pageTitle'] = 'Admin : User Spare Login History';
            
            $this->loadViews("logHistoryBackup", $this->global, $data, NULL);
    }

    /**
     * This function used to delete backup_log table
     */
    function backupLogTableDelete()
    {
        $backup=$this->user_model->clearlogBackuptbl();

        if($backup)
        {
            $this->session->set_flashdata('success', 'Table cleanup successful');
            redirect('log-history-backup');
        }
        else
        {
            $this->session->set_flashdata('error', 'Table cleanup failed');
            redirect('log-history-backup');
        }
    }

    /**
     * This function used to open the logHistoryUpload page
     */
    function logHistoryUpload()
    {       
            $this->load->helper('directory');
            $map = directory_map('./backup/', FALSE, TRUE);
        
            $data['backups']=$map;

            $process = 'Upload Backup Logme';
            $processFunction = 'Admin/logHistoryUpload';
            $this->logrecord($process,$processFunction);

            $this->global['pageTitle'] = 'Admin : User Log Upload';
            
            $this->loadViews("logHistoryUpload", $this->global, $data, NULL);      
    }

    /**
     * This function used to upload backup for backup_log table
     */
    function logHistoryUploadFile()
    {
        $optioninput = $this->input->post('optionfilebackup');

        if ($optioninput == '0' && $_FILES['filebackup']['name'] != '')
        {
            $config = array(
            'upload_path' => "./uploads/",
            'allowed_types' => "gz|sql|gzip",
            'overwrite' => TRUE,
            'max_size' => "20048000", // Can be set to particular file size , here it is 20 MB(20048 Kb)
            );

            $this->load->library('upload', $config);
            $upload= $this->upload->do_upload('filebackup');
                $data = $this->upload->data();
                $filepath = $data['full_path'];
                $path_parts = pathinfo($filepath);
                $filetype = $path_parts['extension'];
                if ($filetype == 'gz')
                {
                    // Read entire gz file
                    $lines = gzfile($filepath);
                    $lines = str_replace('tbl_log','tbl_log_backup', $lines);
                }
                else
                {
                    // Read in entire file
                    $lines = file($filepath);
                    $lines = str_replace('tbl_log','tbl_log_backup', $lines);
                }
        }

        else if ($optioninput != '0' && $_FILES['filebackup']['name'] == '')
        {
            $filepath = './backup/'.$optioninput;
            $path_parts = pathinfo($filepath);
            $filetype = $path_parts['extension'];
            if ($filetype == 'gz')
            {
                // Read entire gz file
                $lines = gzfile($filepath);
                $lines = str_replace('tbl_log','tbl_log_backup', $lines);
            }
            else
            {
                // Read in entire file
                $lines = file($filepath);
                $lines = str_replace('tbl_log','tbl_log_backup', $lines);
            }
        }
                // Set line to collect lines that wrap
                $templine = '';
                
                // Loop through each line
                foreach ($lines as $line)
                {
                    // Skip it if it's a comment
                    if (substr($line, 0, 2) == '--' || $line == '')
                    continue;
                    // Add this line to the current templine we are creating
                    $templine .= $line;

                    // If it has a semicolon at the end, it's the end of the query so can process this templine
                    if (substr(trim($line), -1, 1) == ';')
                    {
                        // Perform the query
                        $this->db->query($templine);

                        // Reset temp variable to empty
                        $templine = '';
                    }
                }
            if (empty($lines) || !isset($lines))
            {
                $this->session->set_flashdata('error', 'Upload Backupme operation failed');
                redirect('log-history-upload');
            }
            else
            {
                $this->session->set_flashdata('success', 'Upload Backupme operation successful');
                redirect('log-history-upload');
            }
    }


    /**
     * This function is used to load the Comapny Master
     */
    function companymaster()
    {  
            $process = 'Company Master';
            $processFunction = 'Admin/companyMaster';
            $this->logrecord($process,$processFunction);
            $data['getCompanyInfo'] = $this->user_model->getCompanyInformation();
            $this->global['pageTitle'] = 'Company Master';
            $this->loadViews("masters/companyMaster", $this->global, $data, NULL);
    }

    /**
     * This function is used to update Company Master
     */
    public function updateCompanyInfo(){

        $post_submit = $this->input->post();

        if(!empty($post_submit)){
                $updatecompany_response = array();

                $this->form_validation->set_rules('company_name','Company Name','trim|required|max_length[128]');
                $this->form_validation->set_rules('phone_1','Phone 1','trim|required|numeric|max_length[128]');
                $this->form_validation->set_rules('company_address','Company Address','trim|required');
                $this->form_validation->set_rules('phone_2','Phone 2','trim|numeric|max_length[50]');
                $this->form_validation->set_rules('Website','Website','trim|required|max_length[50]');
                $this->form_validation->set_rules('email','Email','trim|required|valid_email|max_length[50]');
                $this->form_validation->set_rules('GSTIN','GSTIN','trim|required|max_length[50]');

                if($this->form_validation->run() == FALSE)
                {
                    $updatecompany_response['status'] = 'failure';
                    $updatecompany_response['error'] = array('company_name'=>strip_tags(form_error('company_name')), 'phone_1'=>strip_tags(form_error('phone_1')), 'company_address'=>strip_tags(form_error('company_address')), 'phone_2'=>strip_tags(form_error('phone_2')),'Website'=>strip_tags(form_error('Website')),'email'=>strip_tags(form_error('email')),'GSTIN'=>strip_tags(form_error('GSTIN')));
                }else{

                    $data = array(
                        'company_name'   => trim($this->input->post('company_name')),
                        'phone_1'     => trim($this->input->post('phone_1')),
                        'company_address'    => trim($this->input->post('company_address')),
                        'phone_2'  => trim($this->input->post('phone_2')),
                        'Website' => trim($this->input->post('Website')),
                        'email' =>   trim($this->input->post('email')),
                        'GSTIN' =>    trim($this->input->post('GSTIN'))
                    );

                    $saveCompanydata = $this->admin_model->saveCompanydata(trim($this->input->post('company_id')),$data);

                    if($saveCompanydata){
                        $updatecompany_response['status'] = 'success';
                        $updatecompany_response['error'] =array('company_name'=>strip_tags(form_error('company_name')), 'phone_1'=>strip_tags(form_error('phone_1')), 'company_address'=>strip_tags(form_error('company_address')), 'phone_2'=>strip_tags(form_error('phone_2')),'Website'=>strip_tags(form_error('Website')),'email'=>strip_tags(form_error('email')),'GSTIN'=>strip_tags(form_error('GSTIN')));
                    }
                }
                
                echo json_encode($updatecompany_response);

        }
    }

    /**
     * This function is used to load the Supplier Master
     */
    public function suppliermaster(){
        $process = 'Supplier Master';
        $processFunction = 'Admin/suppliermaster';
        $this->logrecord($process,$processFunction);
        $this->global['pageTitle'] = 'Supplier Master';
        $this->loadViews("masters/supplierMaster", $this->global, $data, NULL);
    }

    /**
     * This function is used to load the Supplier Master Listing
     */

     public function fetchSupplier(){

        $params = $_REQUEST;
        $totalRecords = $this->admin_model->getSupplierCount($params); 
        $queryRecords = $this->admin_model->getSupplierdata($params); 

        $data = array();
        foreach ($queryRecords as $key => $value)
        {
            $i = 0;
            foreach($value as $v)
            {
                $data[$key][$i] = $v;
                $i++;
            }
        }
        $json_data = array(
            "draw"            => intval( $params['draw'] ),   
            "recordsTotal"    => intval( $totalRecords ),  
            "recordsFiltered" => intval($totalRecords),
            "data"            => $data   // total data array
            );
        echo json_encode($json_data);
     }

     /**
     * This function is used to Add the Supplier Master
     */

     public function addnewSupplier(){
        $post_submit = $this->input->post();
        if($post_submit){
            $save_supplier_response = array();

            $this->form_validation->set_rules('supplier_name','Supplier Name','trim|required|max_length[128]');
            $this->form_validation->set_rules('landline','Landline','trim|max_length[128]');
            $this->form_validation->set_rules('address','Address','trim|required');
            $this->form_validation->set_rules('phone_1','Phone 1','trim|numeric|max_length[50]');
            $this->form_validation->set_rules('contact_person','Contact Person','trim|max_length[50]');
            $this->form_validation->set_rules('mobile','Mobile','trim|required|numeric|max_length[50]');
            $this->form_validation->set_rules('email','Email','trim|required|valid_email|max_length[50]');
            $this->form_validation->set_rules('mobile_2','Mobile 2','trim|numeric|max_length[50]');
            $this->form_validation->set_rules('fax','Fax','trim|max_length[50]');
            $this->form_validation->set_rules('GSTIN','GSTIN','trim|max_length[50]');

            if($this->form_validation->run() == FALSE)
            {
                $save_supplier_response['status'] = 'failure';
                $save_supplier_response['error'] = array('supplier_name'=>strip_tags(form_error('supplier_name')), 'landline'=>strip_tags(form_error('landline')), 'address'=>strip_tags(form_error('address')), 'phone_1'=>strip_tags(form_error('phone_1')),'contact_person'=>strip_tags(form_error('contact_person')),'mobile'=>strip_tags(form_error('mobile')),'email'=>strip_tags(form_error('email')),'mobile_2'=>strip_tags(form_error('mobile_2')),'fax'=>strip_tags(form_error('fax')),'GSTIN'=>strip_tags(form_error('GSTIN')));
            }else{

                $data = array(
                    'supplier_name'   => trim($this->input->post('supplier_name')),
                    'landline'     => trim($this->input->post('landline')),
                    'address'    => trim($this->input->post('address')),
                    'phone1'  => trim($this->input->post('phone_1')),
                    'contact_person' => trim($this->input->post('contact_person')),
                    'mobile' =>   trim($this->input->post('mobile')),
                    'email' =>    trim($this->input->post('email')),
                    'mobile2' =>    trim($this->input->post('mobile_2')),
                    'fax' =>    trim($this->input->post('fax')),
                    'GSTIN' =>    trim($this->input->post('GSTIN'))
                );

                $checkIfexits = $this->admin_model->checkifexits(trim($this->input->post('supplier_name')));
                if($checkIfexits > 0){
                    $save_supplier_response['status'] = 'failure';
                    $save_supplier_response['error'] = array('supplier_name'=>'Suplier Alreday Exits');
                }else{
                    $saveSupplierdata = $this->admin_model->saveSupplierdata('',$data);
                    if($saveSupplierdata){
                        $save_supplier_response['status'] = 'success';
                        $save_supplier_response['error'] = array('supplier_name'=>'', 'landline'=>'', 'address'=>'', 'phone_1'=>'','contact_person'=>'','mobile'=>'','email'=>'','mobile_2'=>'','fax'=>'','GSTIN'=>'');
                    }
                }
            }
            echo json_encode($save_supplier_response);
        }else{
            $process = 'Add Supplier Master';
            $processFunction = 'Admin/addnewSupplier';
            $this->logrecord($process,$processFunction);
            $this->global['pageTitle'] = 'Add Supplier Master';
            $this->loadViews("masters/addsupplierMaster", $this->global, $data, NULL);
        }
     }

     /**
     * This function is used to Update the Supplier Master
     */

     public function updateSupplier($id){
        $post_submit = $this->input->post();
        if($post_submit){

            $update_supplier_response = array();

            $this->form_validation->set_rules('supplier_name','Supplier Name','trim|required|max_length[128]');
            $this->form_validation->set_rules('landline','Landline','trim|max_length[128]');
            $this->form_validation->set_rules('address','Address','trim|required');
            $this->form_validation->set_rules('phone_1','Phone 1','trim|numeric|max_length[50]');
            $this->form_validation->set_rules('contact_person','Contact Person','trim|max_length[50]');
            $this->form_validation->set_rules('mobile','Mobile','trim|required|numeric|max_length[50]');
            $this->form_validation->set_rules('email','Email','trim|required|valid_email|max_length[50]');
            $this->form_validation->set_rules('mobile_2','Mobile 2','trim|numeric|max_length[50]');
            $this->form_validation->set_rules('fax','Fax','trim|max_length[50]');
            $this->form_validation->set_rules('GSTIN','GSTIN','trim|max_length[50]');

            if($this->form_validation->run() == FALSE)
            {
                $update_supplier_response['status'] = 'failure';
                $update_supplier_response['error'] = array('supplier_name'=>strip_tags(form_error('supplier_name')), 'landline'=>strip_tags(form_error('landline')), 'address'=>strip_tags(form_error('address')), 'phone_1'=>strip_tags(form_error('phone_1')),'contact_person'=>strip_tags(form_error('contact_person')),'mobile'=>strip_tags(form_error('mobile')),'email'=>strip_tags(form_error('email')),'mobile_2'=>strip_tags(form_error('mobile_2')),'fax'=>strip_tags(form_error('fax')),'GSTIN'=>strip_tags(form_error('GSTIN')));
            }else{

                $data = array(
                    'supplier_name'   => trim($this->input->post('supplier_name')),
                    'landline'     => trim($this->input->post('landline')),
                    'address'    => trim($this->input->post('address')),
                    'phone1'  => trim($this->input->post('phone_1')),
                    'contact_person' => trim($this->input->post('contact_person')),
                    'mobile' =>   trim($this->input->post('mobile')),
                    'email' =>    trim($this->input->post('email')),
                    'mobile2' =>    trim($this->input->post('mobile_2')),
                    'fax' =>    trim($this->input->post('fax')),
                    'GSTIN' =>    trim($this->input->post('GSTIN'))
                );

                $checkifexitsupdate = $this->admin_model->checkifexitsupdate(trim($this->input->post('supplier_id')),trim($this->input->post('supplier_name')));

                if($checkifexitsupdate > 0){
                    $updateSupplierdata = $this->admin_model->saveSupplierdata(trim($this->input->post('supplier_id')),$data);
                    if($updateSupplierdata){
                        $update_supplier_response['status'] = 'success';
                        $update_supplier_response['error'] = array('supplier_name'=>'', 'landline'=>'', 'address'=>'', 'phone_1'=>'','contact_person'=>'','mobile'=>'','email'=>'','mobile_2'=>'','fax'=>'','GSTIN'=>'');
                    }

                }else{

                    $checkIfexits = $this->admin_model->checkifexits(trim($this->input->post('supplier_name')));
                    if($checkIfexits > 0){
                        $update_supplier_response['status'] = 'failure';
                        $update_supplier_response['error'] = array('supplier_name'=>'Suplier Alreday Exits');
                    }else{
                        $updateSupplierdata = $this->admin_model->saveSupplierdata(trim($this->input->post('supplier_id')),$data);
                        if($updateSupplierdata){
                           $update_supplier_response['status'] = 'success';
                           $update_supplier_response['error'] = array('supplier_name'=>'', 'landline'=>'', 'address'=>'', 'phone_1'=>'','contact_person'=>'','mobile'=>'','email'=>'','mobile_2'=>'','fax'=>'','GSTIN'=>'');
                        }

                    }
                }
           
            }
            echo json_encode($update_supplier_response);
        }else{
            $process = 'Edit Supplier Master';
            $processFunction = 'Admin/updateSupplier';
            $this->logrecord($process,$processFunction);
            $this->global['pageTitle'] = 'Edit Supplier Master';
            $data['getSupplierdata'] = $this->admin_model->getSuplierdetails($id);
            $this->loadViews("masters/editsupplierMaster", $this->global, $data, NULL);

        }

     }

     /**
     * This function is used to Delete the Supplier Master
     */

     public function deleteSupplier(){
            $post_submit = $this->input->post();
            if($post_submit){
                $result = $this->admin_model->deleteSupplier(trim($this->input->post('id')));
                if ($result) {
                            $process = 'Supplier Delete';
                            $processFunction = 'Admin/deleteSupplier';
                            $this->logrecord($process,$processFunction);
                        echo(json_encode(array('status'=>'success')));
                    }
                else { echo(json_encode(array('status'=>'failed'))); }
            }else{
                echo(json_encode(array('status'=>'failed'))); 
            }
     }

     /**
     * This function is used to Show the rowmaterialmaster Master
     */
    
     public function rowmaterialmaster(){
        $process = 'Row Material Master';
        $processFunction = 'Admin/rowmaterialmaster';
        $this->logrecord($process,$processFunction);
        $this->global['pageTitle'] = 'Row Material Master';
        $this->loadViews("masters/rowmaterialmaster", $this->global, $data, NULL);
     }

    /**
     * This function is used to Show the rowmaterialmaster Master
     */

     public function fetchRowmaterial(){

        $params = $_REQUEST;
        $totalRecords = $this->admin_model->getRowmaterialCount($params); 
        $queryRecords = $this->admin_model->getRowmaterialdata($params); 

        $data = array();
        foreach ($queryRecords as $key => $value)
        {
            $i = 0;
            foreach($value as $v)
            {
                $data[$key][$i] = $v;
                $i++;
            }
        }
        $json_data = array(
            "draw"            => intval( $params['draw'] ),   
            "recordsTotal"    => intval( $totalRecords ),  
            "recordsFiltered" => intval($totalRecords),
            "data"            => $data   // total data array
            );
        echo json_encode($json_data);
     }


      /**
     * This function is used to Add the Material Master
     */

     public function addnewmaterialdata(){
        $post_submit = $this->input->post();
        if($post_submit){
            $save_rawmatrial_response = array();

            $this->form_validation->set_rules('part_number','Part Number','trim|required|max_length[128]');
            $this->form_validation->set_rules('type_of_raw_material','Type of Raw Material','trim|required|max_length[128]');
            $this->form_validation->set_rules('daimeter','Daimeter','trim');
            $this->form_validation->set_rules('sitting_size','Sitting size','trim|max_length[50]');
            $this->form_validation->set_rules('thickness','Thickness','trim|max_length[50]');
            $this->form_validation->set_rules('hex_a_f','Hex A/F','trim|max_length[50]');
            $this->form_validation->set_rules('hsn_code','HSN_code','trim|max_length[50]');
            $this->form_validation->set_rules('length','Length','trim|max_length[50]');
            $this->form_validation->set_rules('gross_weight','Gross Weight','trim|max_length[50]');
            $this->form_validation->set_rules('net_weight','Net Weight','trim|max_length[50]');
            $this->form_validation->set_rules('sac','SAC','trim|max_length[50]');

            if($this->form_validation->run() == FALSE)
            {
                $save_rawmatrial_response['status'] = 'failure';
                $save_rawmatrial_response['error'] = array('part_number'=>strip_tags(form_error('part_number')), 'type_of_raw_material'=>strip_tags(form_error('type_of_raw_material')), 'daimeter'=>strip_tags(form_error('daimeter')), 'sitting_size'=>strip_tags(form_error('sitting_size')),'thickness'=>strip_tags(form_error('thickness')),'hex_a_f'=>strip_tags(form_error('hex_a_f')),'hsn_code'=>strip_tags(form_error('hsn_code')),'length'=>strip_tags(form_error('length')),'gross_weight'=>strip_tags(form_error('gross_weight')),'net_weight'=>strip_tags(form_error('net_weight')),'sac'=>strip_tags(form_error('sac')));
            }else{

                $data = array(
                    'part_number'   => trim($this->input->post('part_number')),
                    'type_of_raw_material'   => trim($this->input->post('type_of_raw_material')),
                    'diameter'    => trim($this->input->post('daimeter')),
                    'sitting_size'  => trim($this->input->post('sitting_size')),
                    'thickness' => trim($this->input->post('thickness')),
                    'hex_a_f' =>   trim($this->input->post('hex_a_f')),
                    'hsn_code' =>    trim($this->input->post('hsn_code')),
                    'length' =>    trim($this->input->post('length')),
                    'gross_weight' =>    trim($this->input->post('gross_weight')),
                    'sac' =>    trim($this->input->post('sac')),
                    'net_weight' =>    trim($this->input->post('net_weight'))
                );

                $checkIfexitsrawmdata = $this->admin_model->checkifexitsrawmaterial(trim($this->input->post('part_number')),trim($this->input->post('type_of_raw_material')));
                if($checkIfexitsrawmdata > 0){
                    $save_rawmatrial_response['status'] = 'failure';
                    $save_rawmatrial_response['error'] = array('part_number'=>'Part Number Already Exits');
                }else{
                    $saveSupplierdata = $this->admin_model->saveMaterialdata('',$data);
                    if($saveSupplierdata){
                        $save_rawmatrial_response['status'] = 'success';
                        $save_rawmatrial_response['error'] = array('part_number'=>'', 'type_of_raw_material'=>'', 'daimeter'=>'', 'sitting_size'=>'','thickness'=>'','hex_a_f'=>'','hsn_code'=>'','length'=>'','gross_weight'=>'','net_weight'=>'');
                    }
                }
            }
            echo json_encode($save_rawmatrial_response);
        }else{
            $process = 'Add Material Master';
            $processFunction = 'Admin/addNewMaterialdata';
            $this->logrecord($process,$processFunction);
            $this->global['pageTitle'] = 'Add Material Master';
            $this->loadViews("masters/addNewRowmaterialMaster", $this->global, $data, NULL);
        }
     }

     /**
     * This function is used to Update the Supplier Master
     */

     public function updateRawmaterial($id){
        $post_submit = $this->input->post();
        if($post_submit){

            $update_rawmaterial_response = array();

            $this->form_validation->set_rules('part_number','Part Number','trim|required|max_length[128]');
            $this->form_validation->set_rules('type_of_raw_material','Type of Raw Material','trim|required|max_length[128]');
            $this->form_validation->set_rules('daimeter','Daimeter','trim');
            $this->form_validation->set_rules('sitting_size','Sitting size','trim|max_length[50]');
            $this->form_validation->set_rules('thickness','Thickness','trim|max_length[50]');
            $this->form_validation->set_rules('hex_a_f','Hex A/F','trim|max_length[50]');
            $this->form_validation->set_rules('hsn_code','HSN_code','trim|max_length[50]');
            $this->form_validation->set_rules('length','Length','trim|max_length[50]');
            $this->form_validation->set_rules('gross_weight','Gross Weight','trim|max_length[50]');
            $this->form_validation->set_rules('net_weight','Net Weight','trim|max_length[50]');
            $this->form_validation->set_rules('sac','SAC','trim|max_length[50]');

            if($this->form_validation->run() == FALSE)
            {
                $update_rawmaterial_response['status'] = 'failure';
                $update_rawmaterial_response['error'] = array('part_number'=>strip_tags(form_error('part_number')), 'type_of_raw_material'=>strip_tags(form_error('type_of_raw_material')), 'daimeter'=>strip_tags(form_error('daimeter')), 'sitting_size'=>strip_tags(form_error('sitting_size')),'thickness'=>strip_tags(form_error('thickness')),'hex_a_f'=>strip_tags(form_error('hex_a_f')),'hsn_code'=>strip_tags(form_error('hsn_code')),'length'=>strip_tags(form_error('length')),'gross_weight'=>strip_tags(form_error('gross_weight')),'net_weight'=>strip_tags(form_error('net_weight')),'sac'=>strip_tags(form_error('sac')));
            }else{

                $data = array(
                    'part_number'   => trim($this->input->post('part_number')),
                    'type_of_raw_material'   => trim($this->input->post('type_of_raw_material')),
                    'diameter'    => trim($this->input->post('daimeter')),
                    'sitting_size'  => trim($this->input->post('sitting_size')),
                    'thickness' => trim($this->input->post('thickness')),
                    'hex_a_f' =>   trim($this->input->post('hex_a_f')),
                    'hsn_code' =>    trim($this->input->post('hsn_code')),
                    'length' =>    trim($this->input->post('length')),
                    'gross_weight' =>    trim($this->input->post('gross_weight')),
                    'net_weight' =>    trim($this->input->post('net_weight')),
                    'sac' =>    trim($this->input->post('sac'))
                );

                $checkifexitsupdaterawmaterial = $this->admin_model->checkifexitsupdaterawmaterial(trim($this->input->post('rawmaetrial_id')),trim($this->input->post('part_number')),trim($this->input->post('type_of_raw_material')));

                if($checkifexitsupdaterawmaterial > 0){
                    $updateSupplierdata = $this->admin_model->saveMaterialdata(trim($this->input->post('rawmaetrial_id')),$data);
                    if($updateSupplierdata){
                        $update_rawmaterial_response['status'] = 'success';
                        $update_rawmaterial_response['error'] = array('part_number'=>'', 'type_of_raw_material'=>'', 'daimeter'=>'', 'sitting_size'=>'','thickness'=>'','hex_a_f'=>'','hsn_code'=>'','length'=>'','gross_weight'=>'','net_weight'=>'');
                     }

                }else{

                    $checkifexitsrawmaterial = $this->admin_model->checkifexitsrawmaterial(trim($this->input->post('part_number')),trim($this->input->post('type_of_raw_material')));
                    if($checkifexitsrawmaterial > 0){
                        $update_rawmaterial_response['status'] = 'failure';
                        $update_rawmaterial_response['error'] = array('part_number'=>'Part Number Already Exits');
                    }else{
                        $updateSupplierdata = $this->admin_model->saveMaterialdata(trim($this->input->post('rawmaetrial_id')),$data);
                        if($updateSupplierdata){
                            $update_rawmaterial_response['status'] = 'success';
                            $update_rawmaterial_response['error'] = array('part_number'=>'', 'type_of_raw_material'=>'', 'daimeter'=>'', 'sitting_size'=>'','thickness'=>'','hex_a_f'=>'','hsn_code'=>'','length'=>'','gross_weight'=>'','net_weight'=>'');
                        }

                    }
                }
           
            }
            echo json_encode($update_rawmaterial_response);

        }else{
            $process = 'Edit Material Master';
            $processFunction = 'Admin/updateSupplier';
            $this->logrecord($process,$processFunction);
            $this->global['pageTitle'] = 'Edit Raw Material Master';
            $data['getRawmateraildata'] = $this->admin_model->getRawmateraildetails($id);
            $this->loadViews("masters/editrawmaterilMaster", $this->global, $data, NULL);

        }

     }

    /**
     * This function is used to Delete the Raw Material Master
     */

     public function deleteRawmaterial(){
        $post_submit = $this->input->post();
        if($post_submit){
            $result = $this->admin_model->deleteRawmaterial(trim($this->input->post('id')));
            if ($result) {
                        $process = 'Raw Materail Delete';
                        $processFunction = 'Admin/deleteRawmaterial';
                        $this->logrecord($process,$processFunction);
                    echo(json_encode(array('status'=>'success')));
                }
            else { echo(json_encode(array('status'=>'failed'))); }
        }else{
            echo(json_encode(array('status'=>'failed'))); 
        }
     }

         /**
     * This function is used to load the Supplier Master
     */
    public function vendormaster(){
        $process = 'Vendor Master';
        $processFunction = 'Admin/vendormaster';
        $this->logrecord($process,$processFunction);
        $this->global['pageTitle'] = 'Vendor Master';
        $this->loadViews("masters/vendorMaster", $this->global, $data, NULL);
    }

    /**
     * This function is used to load the Supplier Master Listing
     */

     public function fetchVendor(){
        $params = $_REQUEST;
        $totalRecords = $this->admin_model->getVedorCount($params); 
        $queryRecords = $this->admin_model->getVendordata($params); 

        $data = array();
        foreach ($queryRecords as $key => $value)
        {
            $i = 0;
            foreach($value as $v)
            {
                $data[$key][$i] = $v;
                $i++;
            }
        }
        $json_data = array(
            "draw"            => intval( $params['draw'] ),   
            "recordsTotal"    => intval( $totalRecords ),  
            "recordsFiltered" => intval($totalRecords),
            "data"            => $data   // total data array
            );
        echo json_encode($json_data);
     }

     /**
     * This function is used to Add the Supplier Master
     */

     public function addnewVendor(){
        $post_submit = $this->input->post();
        if($post_submit){
            $save_vendor_response = array();

            $this->form_validation->set_rules('vendor_name','Supplier Name','trim|required|max_length[128]');
            $this->form_validation->set_rules('landline','Landline','trim|numeric|max_length[128]');
            $this->form_validation->set_rules('address','Address','trim|required');
            $this->form_validation->set_rules('phone_1','Phone 1','trim|numeric|max_length[50]');
            $this->form_validation->set_rules('contact_person','Contact Person','trim|max_length[50]');
            $this->form_validation->set_rules('mobile','Mobile','trim|required|numeric|max_length[50]');
            $this->form_validation->set_rules('email','Email','trim|required|valid_email|max_length[50]');
            $this->form_validation->set_rules('mobile_2','Mobile 2','trim|numeric|max_length[50]');
            $this->form_validation->set_rules('fax','Fax','trim|max_length[50]');
            $this->form_validation->set_rules('GSTIN','GSTIN','trim|max_length[50]');

            if($this->form_validation->run() == FALSE)
            {
                $save_vendor_response['status'] = 'failure';
                $save_vendor_response['error'] = array('vendor_name'=>strip_tags(form_error('vendor_name')), 'landline'=>strip_tags(form_error('landline')), 'address'=>strip_tags(form_error('address')), 'phone_1'=>strip_tags(form_error('phone_1')),'contact_person'=>strip_tags(form_error('contact_person')),'mobile'=>strip_tags(form_error('mobile')),'email'=>strip_tags(form_error('email')),'mobile_2'=>strip_tags(form_error('mobile_2')),'fax'=>strip_tags(form_error('fax')),'GSTIN'=>strip_tags(form_error('GSTIN')));
            }else{

                $data = array(
                    'vendor_name'   => trim($this->input->post('vendor_name')),
                    'landline'     => trim($this->input->post('landline')),
                    'address'    => trim($this->input->post('address')),
                    'phone1'  => trim($this->input->post('phone_1')),
                    'contact_person' => trim($this->input->post('contact_person')),
                    'mobile' =>   trim($this->input->post('mobile')),
                    'email' =>    trim($this->input->post('email')),
                    'mobile2' =>    trim($this->input->post('mobile_2')),
                    'fax' =>    trim($this->input->post('fax')),
                    'GSTIN' =>    trim($this->input->post('GSTIN'))
                );

                $checkifexitsvendor = $this->admin_model->checkifexitsvendor(trim($this->input->post('vendor_name')));
                if($checkifexitsvendor > 0){
                    $save_vendor_response['status'] = 'failure';
                    $save_vendor_response['error'] = array('vendor_name'=>'Vendor Alreday Exits');
                }else{
                    $saveVendordata = $this->admin_model->saveVendordata('',$data);
                    if($saveVendordata){
                        $save_vendor_response['status'] = 'success';
                        $save_vendor_response['error'] = array('vendor_name'=>'', 'landline'=>'', 'address'=>'', 'phone_1'=>'','contact_person'=>'','mobile'=>'','email'=>'','mobile_2'=>'','fax'=>'','GSTIN'=>'');
                    }
                }
            }
            echo json_encode($save_vendor_response);
        }else{
            $process = 'Add Vendor Master';
            $processFunction = 'Admin/addnewVendor';
            $this->logrecord($process,$processFunction);
            $this->global['pageTitle'] = 'Add Vendor Master';
            $this->loadViews("masters/addVendormaster", $this->global, NULL, NULL);
        }
     }

     /**
     * This function is used to Update the Supplier Master
     */

     public function updateVendor($id){
        $post_submit = $this->input->post();
        if($post_submit){

            $update_vendor_response = array();

            $this->form_validation->set_rules('vendor_name','Vendor Name','trim|required|max_length[128]');
            $this->form_validation->set_rules('landline','Landline','trim|numeric|max_length[128]');
            $this->form_validation->set_rules('address','Address','trim|required');
            $this->form_validation->set_rules('phone_1','Phone 1','trim|numeric|max_length[50]');
            $this->form_validation->set_rules('contact_person','Contact Person','trim|max_length[50]');
            $this->form_validation->set_rules('mobile','Mobile','trim|required|numeric|max_length[50]');
            $this->form_validation->set_rules('email','Email','trim|required|valid_email|max_length[50]');
            $this->form_validation->set_rules('mobile_2','Mobile 2','trim|numeric|max_length[50]');
            $this->form_validation->set_rules('fax','Fax','trim|max_length[50]');
            $this->form_validation->set_rules('GSTIN','GSTIN','trim|max_length[50]');

            if($this->form_validation->run() == FALSE)
            {
                $update_vendor_response['status'] = 'failure';
                $update_vendor_response['error'] = array('vendor_name'=>strip_tags(form_error('vendor_name')), 'landline'=>strip_tags(form_error('landline')), 'address'=>strip_tags(form_error('address')), 'phone_1'=>strip_tags(form_error('phone_1')),'contact_person'=>strip_tags(form_error('contact_person')),'mobile'=>strip_tags(form_error('mobile')),'email'=>strip_tags(form_error('email')),'mobile_2'=>strip_tags(form_error('mobile_2')),'fax'=>strip_tags(form_error('fax')),'GSTIN'=>strip_tags(form_error('GSTIN')));
            }else{

                $data = array(
                    'vendor_name'   => trim($this->input->post('vendor_name')),
                    'landline'     => trim($this->input->post('landline')),
                    'address'    => trim($this->input->post('address')),
                    'phone1'  => trim($this->input->post('phone_1')),
                    'contact_person' => trim($this->input->post('contact_person')),
                    'mobile' =>   trim($this->input->post('mobile')),
                    'email' =>    trim($this->input->post('email')),
                    'mobile2' =>    trim($this->input->post('mobile_2')),
                    'fax' =>    trim($this->input->post('fax')),
                    'GSTIN' =>    trim($this->input->post('GSTIN'))
                );

                $checkifexitvendorsupdate = $this->admin_model->checkifexitvendorsupdate(trim($this->input->post('vendor_id')),trim($this->input->post('vendor_name')));

                if($checkifexitvendorsupdate > 0){
                    $updateVendordata = $this->admin_model->saveVendordata(trim($this->input->post('vendor_id')),$data);
                    if($updateVendordata){
                        $update_vendor_response['status'] = 'success';
                        $update_vendor_response['error'] = array('vendor_name'=>'', 'landline'=>'', 'address'=>'', 'phone_1'=>'','contact_person'=>'','mobile'=>'','email'=>'','mobile_2'=>'','fax'=>'','GSTIN'=>'');
                    }

                }else{

                    $checkifexitsvendor = $this->admin_model->checkifexitsvendor(trim($this->input->post('vendor_name')));
                    if($checkifexitsvendor > 0){
                        $update_vendor_response['status'] = 'failure';
                        $update_vendor_response['error'] = array('vendor_name'=>'Vendor Alreday Exits');
                    }else{
                        $updateVendordata = $this->admin_model->saveVendordata(trim($this->input->post('vendor_id')),$data);
                        if($updateVendordata){
                           $update_vendor_response['status'] = 'success';
                           $update_vendor_response['error'] = array('vendor_name'=>'', 'landline'=>'', 'address'=>'', 'phone_1'=>'','contact_person'=>'','mobile'=>'','email'=>'','mobile_2'=>'','fax'=>'','GSTIN'=>'');
                        }

                    }
                }
           
            }
            echo json_encode($update_vendor_response);
        }else{
            $process = 'Edit Vendor Master';
            $processFunction = 'Admin/updateVendor';
            $this->logrecord($process,$processFunction);
            $this->global['pageTitle'] = 'Edit Vendor Master';
            $data['getVendordata'] = $this->admin_model->getVendordetails($id);
            $this->loadViews("masters/editvendorMaster", $this->global, $data, NULL);

        }

     }

     /**
     * This function is used to Delete the Supplier Master
     */

     public function deleteVendor(){
            $post_submit = $this->input->post();
            if($post_submit){
                $result = $this->admin_model->deleteVendor(trim($this->input->post('id')));
                if ($result) {
                            $process = 'Vensor Delete';
                            $processFunction = 'Admin/deleteVendor';
                            $this->logrecord($process,$processFunction);
                        echo(json_encode(array('status'=>'success')));
                    }
                else { echo(json_encode(array('status'=>'failed'))); }
            }else{
                echo(json_encode(array('status'=>'failed'))); 
            }
     }

    /**
     * This function is used to load the USP Master
     */
    public function uspmaster(){
        $process = 'USP Master';
        $processFunction = 'Admin/uspmaster';
        $this->logrecord($process,$processFunction);
        $this->global['pageTitle'] = 'USP Master';
        $this->loadViews("masters/uspmaster", $this->global, $data, NULL);
    }


    /**
     * This function is used to load the USP Master Listing
     */

     public function fetchUSP(){
        $params = $_REQUEST;
        $totalRecords = $this->admin_model->getUspCount($params); 
        $queryRecords = $this->admin_model->getUspdata($params); 

        $data = array();
        foreach ($queryRecords as $key => $value)
        {
            $i = 0;
            foreach($value as $v)
            {
                $data[$key][$i] = $v;
                $i++;
            }
        }
        $json_data = array(
            "draw"            => intval( $params['draw'] ),   
            "recordsTotal"    => intval( $totalRecords ),  
            "recordsFiltered" => intval($totalRecords),
            "data"            => $data   // total data array
            );
        echo json_encode($json_data);
     }

     
    /**
     * This function is used to Add the USP Master
     */

     public function addnewUSP(){
        $post_submit = $this->input->post();
        if($post_submit){
            $save_usp_response = array();

            $this->form_validation->set_rules('usp_name','USP Name','trim|required|max_length[128]');
            $this->form_validation->set_rules('landline','Landline','trim|required|max_length[128]');
            $this->form_validation->set_rules('address','Address','trim|required');
            $this->form_validation->set_rules('phone_1','Phone 1','trim|numeric|max_length[50]');
            $this->form_validation->set_rules('contact_person','Contact Person','trim|max_length[50]');
            $this->form_validation->set_rules('mobile','Mobile','trim|numeric|required|max_length[50]');
            $this->form_validation->set_rules('email','Email','trim|valid_email|max_length[50]');
            $this->form_validation->set_rules('mobile_2','Mobile 2','trim|numeric|max_length[50]');
            $this->form_validation->set_rules('fax','Fax','trim|max_length[50]');
            $this->form_validation->set_rules('GSTIN','GSTIN','trim|max_length[50]');

            if($this->form_validation->run() == FALSE)
            {
                $save_usp_response['status'] = 'failure';
                $save_usp_response['error'] = array('usp_name'=>strip_tags(form_error('usp_name')), 'landline'=>strip_tags(form_error('landline')), 'address'=>strip_tags(form_error('address')), 'phone_1'=>strip_tags(form_error('phone_1')),'contact_person'=>strip_tags(form_error('contact_person')),'mobile'=>strip_tags(form_error('mobile')),'email'=>strip_tags(form_error('email')),'mobile_2'=>strip_tags(form_error('mobile_2')),'fax'=>strip_tags(form_error('fax')),'GSTIN'=>strip_tags(form_error('GSTIN')));
            }else{

                $data = array(
                    'usp_name'   => trim($this->input->post('usp_name')),
                    'landline'     => trim($this->input->post('landline')),
                    'address'    => trim($this->input->post('address')),
                    'phone1'  => trim($this->input->post('phone_1')),
                    'contact_person' => trim($this->input->post('contact_person')),
                    'mobile' =>   trim($this->input->post('mobile')),
                    'email' =>    trim($this->input->post('email')),
                    'mobile2' =>    trim($this->input->post('mobile_2')),
                    'fax' =>    trim($this->input->post('fax')),
                    'GSTIN' =>    trim($this->input->post('GSTIN'))
                );

                $checkIfexitsusp = $this->admin_model->checkIfexitsusp(trim($this->input->post('usp_name')));
                if($checkIfexitsusp > 0){
                    $save_usp_response['status'] = 'failure';
                    $save_usp_response['error'] = array('usp_name'=>'USP Mame Alreday Exits');
                }else{
                    $saveUSPdata = $this->admin_model->saveUSPdata('',$data);
                    if($saveUSPdata){
                        $save_usp_response['status'] = 'success';
                        $save_usp_response['error'] = array('usp_name'=>'', 'landline'=>'', 'address'=>'', 'phone_1'=>'','contact_person'=>'','mobile'=>'','email'=>'','mobile_2'=>'','fax'=>'','GSTIN'=>'');
                    }
                }
            }
            echo json_encode($save_usp_response);
        }else{
            $process = 'Add USP Master';
            $processFunction = 'Admin/addnewUSP';
            $this->logrecord($process,$processFunction);
            $this->global['pageTitle'] = 'Add USP Master';
            $this->loadViews("masters/addsUSPMaster", $this->global, $data, NULL);
        }
     }

    /**
     * This function is used to Delete the USP Master
     */

     public function deleteUSP(){
        $post_submit = $this->input->post();
        if($post_submit){
            $result = $this->admin_model->deleteUSP(trim($this->input->post('id')));
            if ($result) {
                        $process = 'USP Materail Delete';
                        $processFunction = 'Admin/deleteUSP';
                        $this->logrecord($process,$processFunction);
                    echo(json_encode(array('status'=>'success')));
                }
            else { echo(json_encode(array('status'=>'failed'))); }
        }else{
            echo(json_encode(array('status'=>'failed'))); 
        }
     }


    /**
     * This function is used to Update the USP Master
     */

     public function updateUSP($id){
        $post_submit = $this->input->post();
        if($post_submit){

            $update_supplier_response = array();

            $this->form_validation->set_rules('usp_name','USP Name','trim|required|max_length[128]');
            $this->form_validation->set_rules('landline','Landline','trim|required|max_length[128]');
            $this->form_validation->set_rules('address','Address','trim|required');
            $this->form_validation->set_rules('phone_1','Phone 1','trim|numeric|max_length[50]');
            $this->form_validation->set_rules('contact_person','Contact Person','trim|max_length[50]');
            $this->form_validation->set_rules('mobile','Mobile','trim|required|numeric|max_length[50]');
            $this->form_validation->set_rules('email','Email','trim|valid_email|max_length[50]');
            $this->form_validation->set_rules('mobile_2','Mobile 2','trim|max_length[50]');
            $this->form_validation->set_rules('fax','Fax','trim|max_length[50]');
            $this->form_validation->set_rules('GSTIN','GSTIN','trim|max_length[50]');

            if($this->form_validation->run() == FALSE)
            {
                $update_supplier_response['status'] = 'failure';
                $update_supplier_response['error'] = array('usp_name'=>strip_tags(form_error('usp_name')), 'landline'=>strip_tags(form_error('landline')), 'address'=>strip_tags(form_error('address')), 'phone_1'=>strip_tags(form_error('phone_1')),'contact_person'=>strip_tags(form_error('contact_person')),'mobile'=>strip_tags(form_error('mobile')),'email'=>strip_tags(form_error('email')),'mobile_2'=>strip_tags(form_error('mobile_2')),'fax'=>strip_tags(form_error('fax')),'GSTIN'=>strip_tags(form_error('GSTIN')));
            }else{

                $data = array(
                    'usp_name'   => trim($this->input->post('usp_name')),
                    'landline'     => trim($this->input->post('landline')),
                    'address'    => trim($this->input->post('address')),
                    'phone1'  => trim($this->input->post('phone_1')),
                    'contact_person' => trim($this->input->post('contact_person')),
                    'mobile' =>   trim($this->input->post('mobile')),
                    'email' =>    trim($this->input->post('email')),
                    'mobile2' =>    trim($this->input->post('mobile_2')),
                    'fax' =>    trim($this->input->post('fax')),
                    'GSTIN' =>    trim($this->input->post('GSTIN'))
                );

                $checkifexituspdate = $this->admin_model->checkifexituspdate(trim($this->input->post('usp_id')),trim($this->input->post('usp_name')));

                if($checkifexituspdate > 0){
                    $updateSupplierdata = $this->admin_model->saveUSPdata(trim($this->input->post('usp_id')),$data);
                    if($updateSupplierdata){
                        $update_supplier_response['status'] = 'success';
                        $update_supplier_response['error'] = array('usp_name'=>'', 'landline'=>'', 'address'=>'', 'phone_1'=>'','contact_person'=>'','mobile'=>'','email'=>'','mobile_2'=>'','fax'=>'','GSTIN'=>'');
                    }

                }else{

                    $checkIfexitsusp = $this->admin_model->checkIfexitsusp(trim($this->input->post('usp_name')));
                    if($checkIfexitsusp > 0){
                        $update_supplier_response['status'] = 'failure';
                        $update_supplier_response['error'] = array('usp_name'=>'USP Alreday Exits');
                    }else{
                        $updateSupplierdata = $this->admin_model->saveUSPdata(trim($this->input->post('usp_id')),$data);
                        if($updateSupplierdata){
                           $update_supplier_response['status'] = 'success';
                           $update_supplier_response['error'] = array('usp_name'=>'', 'landline'=>'', 'address'=>'', 'phone_1'=>'','contact_person'=>'','mobile'=>'','email'=>'','mobile_2'=>'','fax'=>'','GSTIN'=>'');
                        }

                    }
                }
           
            }
            echo json_encode($update_supplier_response);
        }else{
            $process = 'Edit USP Master';
            $processFunction = 'Admin/updateUSP';
            $this->logrecord($process,$processFunction);
            $this->global['pageTitle'] = 'Edit USP Master';
            $data['getUSPdata'] = $this->admin_model->getUSPdetails($id);
            $this->loadViews("masters/edituspMaster", $this->global, $data, NULL);

        }

     }


     /**
     * This function is used to load the USP Master
     */
    public function finishedgoodsmaster(){
        $process = 'Finished Goods Master';
        $processFunction = 'Admin/finishedgoodsmaster';
        $this->logrecord($process,$processFunction);
        $this->global['pageTitle'] = 'Finished Goods Master';
        $this->loadViews("masters/finishedgoodsmaster", $this->global, $data, NULL);
    }

     /**
     * This function is used to load the Finished Goods Master Data
     */
    public function fetchfinishedgoods(){
        $params = $_REQUEST;
        $totalRecords = $this->admin_model->getfinishedCount($params); 
        $queryRecords = $this->admin_model->getfinisheddata($params); 

        $data = array();
        foreach ($queryRecords as $key => $value)
        {
            $i = 0;
            foreach($value as $v)
            {
                $data[$key][$i] = $v;
                $i++;
            }
        }
        $json_data = array(
            "draw"            => intval( $params['draw'] ),   
            "recordsTotal"    => intval( $totalRecords ),  
            "recordsFiltered" => intval($totalRecords),
            "data"            => $data   // total data array
            );
        echo json_encode($json_data);

    }


    /**
     * This function is used to Add the Finished Goods 
     */

     public function addnewFinishedgoods(){
        $post_submit = $this->input->post();
        if($post_submit){
            $save_finished_goods_response = array();

            $this->form_validation->set_rules('part_number','Part Number','trim|required');
            $this->form_validation->set_rules('name','Name','trim|required');
            $this->form_validation->set_rules('hsn_code','HSN Code','trim');
            $this->form_validation->set_rules('gross_weight','Gross Weight','trim');
            $this->form_validation->set_rules('net_weight','Net Weight','trim');
            $this->form_validation->set_rules('sac','SAC','trim');
            $this->form_validation->set_rules('drawing_number','Drawing Number','trim');
            $this->form_validation->set_rules('description_1','description_1','trim');
            $this->form_validation->set_rules('description_2','description_2','trim');

            if($this->form_validation->run() == FALSE)
            {
                $save_finished_goods_response['status'] = 'failure';
                $save_finished_goods_response['error'] = array('part_number'=>strip_tags(form_error('part_number')), 'name'=>strip_tags(form_error('name')), 'hsn_code'=>strip_tags(form_error('hsn_code')), 'gross_weight'=>strip_tags(form_error('gross_weight')),'net_weight'=>strip_tags(form_error('net_weight')),'sac'=>strip_tags(form_error('sac')),'drawing_number'=>strip_tags(form_error('drawing_number')),'description_1'=>strip_tags(form_error('description_1')),'description_2'=>strip_tags(form_error('description_2')));
            }else{

                $data = array(
                    'part_number'   => trim($this->input->post('part_number')),
                    'name'     => trim($this->input->post('name')),
                    'hsn_code'    => trim($this->input->post('hsn_code')),
                    'groass_weight'  => trim($this->input->post('gross_weight')),
                    'net_weight' => trim($this->input->post('net_weight')),
                    'sac' =>   trim($this->input->post('sac')),
                    'drawing_number' =>    trim($this->input->post('drawing_number')),
                    'description_1' =>    trim($this->input->post('description_1')),
                    'description_2' =>    trim($this->input->post('description_2'))
                );

                $checkIfexitsFinishedgoods = $this->admin_model->checkIfexitsFinishedgoods(trim($this->input->post('part_number')));
                if($checkIfexitsFinishedgoods > 0){
                    $save_finished_goods_response['status'] = 'failure';
                    $save_finished_goods_response['error'] = array('part_number'=>'Part Number Already Exits');
                }else{
                    $saveFinishedgoodsdata = $this->admin_model->saveFinishedgoodsdata('',$data);
                    if($saveFinishedgoodsdata){
                        $save_finished_goods_response['status'] = 'success';
                        $save_finished_goods_response['error'] = array('part_number'=>'', 'name'=>'', 'hsn_code'=>'', 'gross_weight'=>'','net_weight'=>'','sac'=>'','drawing_number'=>'','description_1'=>'','description_2'=>'');
                    }
                }
            }
            echo json_encode($save_finished_goods_response);
        }else{
            $process = 'Add Finished Goods';
            $processFunction = 'Admin/addnewFinishedgoods';
            $this->logrecord($process,$processFunction);
            $this->global['pageTitle'] = 'Add Finished Goods';
            $this->loadViews("masters/addsFinishedgoodsmaster", $this->global, NULL, NULL);
        }
     }


    /**
     * This function is used to Delete the USP Master
     */

     public function deletefinishedgoods(){
        $post_submit = $this->input->post();
        if($post_submit){
            $result = $this->admin_model->deletefinishedgoods(trim($this->input->post('id')));
            if ($result) {
                        $process = 'USP Materail Delete';
                        $processFunction = 'Admin/deleteUSP';
                        $this->logrecord($process,$processFunction);
                    echo(json_encode(array('status'=>'success')));
                }
            else { echo(json_encode(array('status'=>'failed'))); }
        }else{
            echo(json_encode(array('status'=>'failed'))); 
        }
     }


    /**
     * This function is used to Add the Finished Goods 
     */

     public function updateFinishedgoods($id){
        $post_submit = $this->input->post();
        if($post_submit){
            $update_finished_goods_response = array();

            $this->form_validation->set_rules('part_number','Part Number','trim|required');
            $this->form_validation->set_rules('name','Name','trim|required');
            $this->form_validation->set_rules('hsn_code','HSN Code','trim');
            $this->form_validation->set_rules('gross_weight','Gross Weight','trim');
            $this->form_validation->set_rules('net_weight','Net Weight','trim');
            $this->form_validation->set_rules('sac','SAC','trim');
            $this->form_validation->set_rules('drawing_number','Drawing Number','trim');
            $this->form_validation->set_rules('description_1','description_1','trim');
            $this->form_validation->set_rules('description_2','description_2','trim');

            if($this->form_validation->run() == FALSE)
            {
                $update_finished_goods_response['status'] = 'failure';
                $update_finished_goods_response['error'] = array('part_number'=>strip_tags(form_error('part_number')), 'name'=>strip_tags(form_error('name')), 'hsn_code'=>strip_tags(form_error('hsn_code')), 'gross_weight'=>strip_tags(form_error('gross_weight')),'net_weight'=>strip_tags(form_error('net_weight')),'sac'=>strip_tags(form_error('sac')),'drawing_number'=>strip_tags(form_error('drawing_number')),'description_1'=>strip_tags(form_error('description_1')),'description_2'=>strip_tags(form_error('description_2')));
            }else{

                $data = array(
                    'part_number'   => trim($this->input->post('part_number')),
                    'name'     => trim($this->input->post('name')),
                    'hsn_code'    => trim($this->input->post('hsn_code')),
                    'groass_weight'  => trim($this->input->post('gross_weight')),
                    'net_weight' => trim($this->input->post('net_weight')),
                    'sac' =>   trim($this->input->post('sac')),
                    'drawing_number' =>    trim($this->input->post('drawing_number')),
                    'description_1' =>    trim($this->input->post('description_1')),
                    'description_2' =>    trim($this->input->post('description_2'))
                );

               
                $checkifexitfinishedgoodsupdate = $this->admin_model->checkifexitfinishedgoodsupdate(trim($this->input->post('finished_goods_id')),trim($this->input->post('part_number')));

                if($checkifexitfinishedgoodsupdate > 0){
                    $updatefinishedgoodsdata = $this->admin_model->saveFinishedgoodsdata(trim($this->input->post('finished_goods_id')),$data);
                    if($updatefinishedgoodsdata){
                        $update_finished_goods_response['status'] = 'success';
                        $update_finished_goods_response['error'] = array('part_number'=>'', 'name'=>'', 'hsn_code'=>'', 'gross_weight'=>'','net_weight'=>'','sac'=>'','drawing_number'=>'','description_1'=>'','description_2'=>'');
                    }

                }else{

                    $checkifexitsfinished = $this->admin_model->checkIfexitsFinishedgoods(trim($this->input->post('part_number')));
                    if($checkifexitsfinished > 0){
                        $update_finished_goods_response['status'] = 'failure';
                        $update_finished_goods_response['error'] = array('part_number'=>'Finished good Already Exits');
                    }else{
                        $updatedata = $this->admin_model->saveFinishedgoodsdata(trim($this->input->post('finished_goods_id')),$data);
                        if($updatedata){
                           $update_finished_goods_response['status'] = 'success';
                           $update_finished_goods_response['error'] = array('part_number'=>'', 'name'=>'', 'hsn_code'=>'', 'gross_weight'=>'','net_weight'=>'','sac'=>'','drawing_number'=>'','description_1'=>'','description_2'=>'');
                        }

                    }
                }

            }
            echo json_encode($update_finished_goods_response);
        }else{
            $process = 'Update Finished Goods';
            $processFunction = 'Admin/updateFinishedgoods';
            $this->logrecord($process,$processFunction);
            $this->global['pageTitle'] = 'Update Finished Goods';
            $data['getFinishedgoodsdata'] = $this->admin_model->getFinishedgoodsdata($id);

            $this->loadViews("masters/editFinishedgoodsmaster", $this->global, $data, NULL);
        }
     }


    /**
     * This function is used to load the Supplier Master
     */
    public function plattingmaster(){
        $process = 'Platting Master';
        $processFunction = 'Admin/plattingmaster';
        $this->logrecord($process,$processFunction);
        $this->global['pageTitle'] = 'Platting Master';
        $this->loadViews("masters/plattingmaster", $this->global, $data, NULL);
    }


    /**
     * This function is used to load the Platting Master Data
     */
    public function fetchplattinglist(){
        $params = $_REQUEST;
        $totalRecords = $this->admin_model->getPlattingCount($params); 
        $queryRecords = $this->admin_model->getPlattingdata($params); 

        $data = array();
        foreach ($queryRecords as $key => $value)
        {
            $i = 0;
            foreach($value as $v)
            {
                $data[$key][$i] = $v;
                $i++;
            }
        }
        $json_data = array(
            "draw"            => intval( $params['draw'] ),   
            "recordsTotal"    => intval( $totalRecords ),  
            "recordsFiltered" => intval($totalRecords),
            "data"            => $data   // total data array
            );
        echo json_encode($json_data);

    }
  

     /**
     * This function is used to load the Platting Master Data
     */

    public function addnewPlatting(){
        $post_submit = $this->input->post();
        if($post_submit){
            $new_plattimg_response = array();

            $this->form_validation->set_rules('type_of_raw_material','Type of Raw Material','trim|required');
            $this->form_validation->set_rules('type_of_platting','Type of Platting','trim|required');

            if($this->form_validation->run() == FALSE)
            {
                $new_plattimg_response['status'] = 'failure';
                $new_plattimg_response['error'] = array('type_of_raw_material'=>strip_tags(form_error('type_of_raw_material')), 'type_of_platting'=>strip_tags(form_error('type_of_platting')));
            }else{

                $data = array(
                    'type_of_raw_material'   => trim($this->input->post('type_of_raw_material')),
                    'type_of_platting'     => trim($this->input->post('type_of_platting'))
                );

                $checkifexitsplatting = $this->admin_model->checkifexitsplatting(trim($this->input->post('type_of_raw_material')));
                if($checkifexitsplatting > 0){
                    $new_plattimg_response['status'] = 'failure';
                    $new_plattimg_response['error'] = array('type_of_raw_material'=>'Type of Raw Material Alreday Exits');
                }else{
                    $saveplattingdata = $this->admin_model->saveplattingdata('',$data);
                    if($saveplattingdata){
                        $new_plattimg_response['status'] = 'success';
                        $new_plattimg_response['error'] = array('type_of_raw_material'=>'', 'type_of_platting'=>'');
                    }
                }
            }
            echo json_encode($new_plattimg_response);
        }else{
            $process = 'Add Platting Master';
            $processFunction = 'Admin/addnewPlatting';
            $this->logrecord($process,$processFunction);
            $this->global['pageTitle'] = 'Add Platting Master';
            $this->loadViews("masters/addPlattingmaster", $this->global, NULL, NULL);
        }
    }


    /**
     * This function is used to Delete the USP Master
     */

     public function deleteplatting(){
        $post_submit = $this->input->post();
        if($post_submit){
            $result = $this->admin_model->deleteplatting(trim($this->input->post('id')));
            if ($result) {
                        $process = 'Platting Delete';
                        $processFunction = 'Admin/deleteplatting';
                        $this->logrecord($process,$processFunction);
                    echo(json_encode(array('status'=>'success')));
                }
            else { echo(json_encode(array('status'=>'failed'))); }
        }else{
            echo(json_encode(array('status'=>'failed'))); 
        }
     }


     /**
     * This function is used to load the Platting Master Data
     */

    public function updatePlattingmaster($id){
        $post_submit = $this->input->post();
        if($post_submit){
            $update_plattimg_response = array();

            $this->form_validation->set_rules('type_of_raw_material','Type of Raw Material','trim|required');
            $this->form_validation->set_rules('type_of_platting','Type of Platting','trim|required');

            if($this->form_validation->run() == FALSE)
            {
                $update_plattimg_response['status'] = 'failure';
                $update_plattimg_response['error'] = array('type_of_raw_material'=>strip_tags(form_error('type_of_raw_material')), 'type_of_platting'=>strip_tags(form_error('type_of_platting')));
            }else{

                $data = array(
                    'type_of_raw_material'   => trim($this->input->post('type_of_raw_material')),
                    'type_of_platting'     => trim($this->input->post('type_of_platting'))
                );

                
                $checkifexitplattingupdate = $this->admin_model->checkifexitplattingupdate(trim($this->input->post('platting_id')),trim($this->input->post('type_of_raw_material')));

                if($checkifexitplattingupdate > 0){
                    $saveplattingdata = $this->admin_model->saveplattingdata(trim($this->input->post('platting_id')),$data);
                    if($saveplattingdata){
                        $update_plattimg_response['status'] = 'success';
                        $update_plattimg_response['error'] = array('type_of_raw_material'=>'', 'type_of_platting'=>'');
                    }

                }else{

                    $checkifexitsplatting = $this->admin_model->checkifexitsplatting(trim($this->input->post('type_of_raw_material')));
                    if($checkifexitsplatting > 0){
                        $update_plattimg_response['status'] = 'failure';
                        $update_plattimg_response['error'] = array('type_of_raw_material'=>'Type Of Raw Material Alreday Exits', 'type_of_platting'=>'');
                    }else{
                        $updatedata = $this->admin_model->saveplattingdata(trim($this->input->post('platting_id')),$data);
                        if($updatedata){
                           $update_plattimg_response['status'] = 'success';
                           $update_plattimg_response['error'] = array('part_number'=>'', 'name'=>'');
                        }

                    }
                }
               
            }
            echo json_encode($update_plattimg_response);
        }else{
            $process = 'Update Platting Master';
            $processFunction = 'Admin/addnewPlatting';
            $this->logrecord($process,$processFunction);
            $this->global['pageTitle'] = 'Update Platting Master';
            $data['getPlattingmasterdata'] = $this->admin_model->getPlattingmasterdata($id);
            $this->loadViews("masters/updatePlattingmaster", $this->global, $data, NULL);
        }
    }

    /**
     * This function is used to laod Rejection Master
     */

     public function rejectionmaster(){

        $process = 'Rejection Master';
        $processFunction = 'Admin/rejectionmaster';
        $this->logrecord($process,$processFunction);
        $this->global['pageTitle'] = 'Rejection Master';
        $this->loadViews("masters/rejectionmaster", $this->global, $data, NULL);

    }

    /**
     * This function is used to laod Rejection Master
     */

    public function fetchrRjectionglist(){
        
        $params = $_REQUEST;
        $totalRecords = $this->admin_model->getRejectionCount($params); 
        $queryRecords = $this->admin_model->getRejectiondata($params); 

        $data = array();
        foreach ($queryRecords as $key => $value)
        {
            $i = 0;
            foreach($value as $v)
            {
                $data[$key][$i] = $v;
                $i++;
            }
        }
        $json_data = array(
            "draw"            => intval( $params['draw'] ),   
            "recordsTotal"    => intval( $totalRecords ),  
            "recordsFiltered" => intval($totalRecords),
            "data"            => $data   // total data array
            );
        echo json_encode($json_data);


    }

     /**
     * This function is used to load the Rejection Master Data
     */

    public function addnewRejection(){
        $post_submit = $this->input->post();
        if($post_submit){
            $new_rejection_response = array();

            $this->form_validation->set_rules('rejection_reason','Rejection Reason','trim|required');

            if($this->form_validation->run() == FALSE)
            {
                $new_rejection_response['status'] = 'failure';
                $new_rejection_response['error'] = array('rejection_reason'=>strip_tags(form_error('rejection_reason')));
            }else{

                $data = array(
                    'rejection_reason'   => trim($this->input->post('rejection_reason'))
                );

                $checkifexitrejection = $this->admin_model->checkifexitrejection(trim($this->input->post('rejection_reason')));
                if($checkifexitrejection > 0){
                    $new_rejection_response['status'] = 'failure';
                    $new_rejection_response['error'] = array('rejection_reason'=>'Rejection Reason Alreday Exits');
                }else{
                    $saveRejectiondata = $this->admin_model->savRejectiongdata('',$data);
                    if($saveRejectiondata){
                        $new_rejection_response['status'] = 'success';
                        $new_rejection_response['error'] = array('rejection_reason'=>'');
                    }
                }
            }
            echo json_encode($new_rejection_response);
        }else{
            $process = 'Add Rejection Master';
            $processFunction = 'Admin/addnewRejection';
            $this->logrecord($process,$processFunction);
            $this->global['pageTitle'] = 'Add Rejection Master';
            $this->loadViews("masters/addRejectiongmaster", $this->global, NULL, NULL);
        }
    }


    /**
     * This function is used to Delete the USP Master
     */

     public function deleteRejection(){
        $post_submit = $this->input->post();
        if($post_submit){
            $result = $this->admin_model->deleteRejection(trim($this->input->post('id')));
            if ($result) {
                        $process = 'Rejection Delete';
                        $processFunction = 'Admin/deleteRejection';
                        $this->logrecord($process,$processFunction);
                    echo(json_encode(array('status'=>'success')));
                }
            else { echo(json_encode(array('status'=>'failed'))); }
        }else{
            echo(json_encode(array('status'=>'failed'))); 
        }
     }


     /**
     * This function is used to load the Rejection Master Data
     */

     public function updateRejectionmaster($id){
        $post_submit = $this->input->post();
        if($post_submit){
            $update_Rejection_response = array();

            $this->form_validation->set_rules('rejection_reason','Rejection Reason','trim|required');

            if($this->form_validation->run() == FALSE)
            {
                $update_Rejection_response['status'] = 'failure';
                $update_Rejection_response['error'] = array('rejection_reason'=>strip_tags(form_error('rejection_reason')));
            }else{

                $data = array(
                    'rejection_reason'   => trim($this->input->post('rejection_reason'))
                );

                $checkifexitRejectionupdate = $this->admin_model->checkifexitRejectionupdate(trim($this->input->post('rejection_reason_id')),trim($this->input->post('rejection_reason')));

                if($checkifexitRejectionupdate > 0){
                    $saverejectiondata = $this->admin_model->savRejectiongdata(trim($this->input->post('rejection_reason_id')),$data);
                    if($saverejectiondata){
                        $update_Rejection_response['status'] = 'success';
                        $update_Rejection_response['error'] = array('rejection_reason'=>'');
                    }

                }else{

                    $checkifexitrejection = $this->admin_model->checkifexitrejection(trim($this->input->post('rejection_reason')));
                    if($checkifexitrejection > 0){
                        $update_Rejection_response['status'] = 'failure';
                        $update_Rejection_response['error'] = array('rejection_reason'=>'Rejection Reason Alreday Exits');
                    }else{
                        $updatedata = $this->admin_model->savRejectiongdata(trim($this->input->post('rejection_reason_id')),$data);
                        if($updatedata){
                           $update_Rejection_response['status'] = 'success';
                           $update_Rejection_response['error'] = array('part_number'=>'', 'name'=>'');
                        }

                    }
                }
               
            }
            echo json_encode($update_Rejection_response);
        }else{
            $process = 'Update Rejection Master';
            $processFunction = 'Admin/updateRejectionmaster';
            $this->logrecord($process,$processFunction);
            $this->global['pageTitle'] = 'Update Rejection Master';
            $data['getRejectiongmasterdata'] = $this->admin_model->getRejectiongmasterdata($id);
            $this->loadViews("masters/updateRejectionmaster", $this->global, $data, NULL);
        }
    }


      /**
     * This function is used to laod Rejection Master
     */

     public function buyermaster(){
        $process = 'Buyer Master';
        $processFunction = 'Admin/buyermaster';
        $this->logrecord($process,$processFunction);
        $this->global['pageTitle'] = 'Buyer Master';
        $this->loadViews("masters/buyernmaster", $this->global, $data, NULL);

    }


    /**
     * This function is used to laod Buyer Master
     */

    public function fetchrBuyerlist(){
        
        $params = $_REQUEST;
        $totalRecords = $this->admin_model->getBuyerCount($params); 
        $queryRecords = $this->admin_model->getBuyerdata($params); 

        $data = array();
        foreach ($queryRecords as $key => $value)
        {
            $i = 0;
            foreach($value as $v)
            {
                $data[$key][$i] = $v;
                $i++;
            }
        }
        $json_data = array(
            "draw"            => intval( $params['draw'] ),   
            "recordsTotal"    => intval( $totalRecords ),  
            "recordsFiltered" => intval($totalRecords),
            "data"            => $data   // total data array
            );
        echo json_encode($json_data);
    }


    /**
     * This function is used to add Buyer Master
     */

    public function addnewBuyer(){
        $post_submit = $this->input->post();
        if($post_submit){
            $save_buyer_response = array();

            $this->form_validation->set_rules('buyer_name','Buyer Name','trim|required|max_length[128]');
            $this->form_validation->set_rules('currency','Currency','trim|required|max_length[50]');
            $this->form_validation->set_rules('address','Address','trim|required');
            $this->form_validation->set_rules('landline','Landline','trim|max_length[128]');
            $this->form_validation->set_rules('mobile','Mobile','trim|numeric|max_length[50]');
            $this->form_validation->set_rules('contact_person','Contact Person','trim|max_length[50]');
            $this->form_validation->set_rules('email','Email','trim|valid_email|max_length[50]');
            $this->form_validation->set_rules('GSTIN','GSTIN','trim|max_length[50]');

            if($this->form_validation->run() == FALSE)
            {
                $save_buyer_response['status'] = 'failure';
                $save_buyer_response['error'] = array('buyer_name'=>strip_tags(form_error('buyer_name')), 'currency'=>strip_tags(form_error('currency')), 'address'=>strip_tags(form_error('address')), 'landline'=>strip_tags(form_error('landline')),'contact_person'=>strip_tags(form_error('contact_person')),'mobile'=>strip_tags(form_error('mobile')),'email'=>strip_tags(form_error('email')),'GSTIN'=>strip_tags(form_error('GSTIN')));
            }else{

                $data = array(
                    'buyer_name'   => trim($this->input->post('buyer_name')),
                    'currency'     => trim($this->input->post('currency')),
                    'address'    => trim($this->input->post('address')),
                    'landline'  => trim($this->input->post('landline')),
                    'mobile' =>   trim($this->input->post('mobile')),
                    'contact_person' => trim($this->input->post('contact_person')),
                    'email' =>    trim($this->input->post('email')),
                    'GSTIN' =>    trim($this->input->post('GSTIN'))
                );

                $checkIfexitsbuyer = $this->admin_model->checkIfexitsbuyer(trim($this->input->post('buyer_name')));
                if($checkIfexitsbuyer > 0){
                    $save_buyer_response['status'] = 'failure';
                    $save_buyer_response['error'] = array('buyer_name'=>'Buyer Mame Alreday Exits');
                }else{
                    $saveBuyerdata = $this->admin_model->saveBuyerdata('',$data);
                    if($saveBuyerdata){
                        $save_buyer_response['status'] = 'success';
                        $save_buyer_response['error'] = array('buyer_name'=>'', 'currency'=>'', 'address'=>'', 'landline'=>'','contact_person'=>'','mobile'=>'','email'=>'','GSTIN'=>'');
                    }
                }
            }
            echo json_encode($save_buyer_response);
        }else{
            $process = 'Add Buyer Master';
            $processFunction = 'Admin/addnewBuyer';
            $this->logrecord($process,$processFunction);
            $this->global['pageTitle'] = 'Add Buyer Master';
            $this->loadViews("masters/addsbuyerMaster", $this->global, $data, NULL);
        }
    }


    /**
     * This function is used to Delete the Buyer Master
     */

     public function deleteBuyer(){
        $post_submit = $this->input->post();
        if($post_submit){
            $result = $this->admin_model->deleteBuyer(trim($this->input->post('id')));
            if ($result) {
                        $process = 'Buyer Delete';
                        $processFunction = 'Admin/deleteRejection';
                        $this->logrecord($process,$processFunction);
                    echo(json_encode(array('status'=>'success')));
                }
            else { echo(json_encode(array('status'=>'failed'))); }
        }else{
            echo(json_encode(array('status'=>'failed'))); 
        }
     }

      /**
     * This function is used to add Buyer Master
     */


    public function updateBuyer($id){
        $post_submit = $this->input->post();
        if($post_submit){
            $update_buyer_response = array();

            $this->form_validation->set_rules('buyer_name','Buyer Name','trim|required|max_length[128]');
            $this->form_validation->set_rules('currency','Currency','trim|required|max_length[50]');
            $this->form_validation->set_rules('address','Address','trim|required');
            $this->form_validation->set_rules('landline','Landline','trim|max_length[128]');
            $this->form_validation->set_rules('mobile','Mobile','trim|numeric|max_length[50]');
            $this->form_validation->set_rules('contact_person','Contact Person','trim|max_length[50]');
            $this->form_validation->set_rules('email','Email','trim|valid_email|max_length[50]');
            $this->form_validation->set_rules('GSTIN','GSTIN','trim|max_length[50]');

            if($this->form_validation->run() == FALSE)
            {
                $update_buyer_response['status'] = 'failure';
                $update_buyer_response['error'] = array('buyer_name'=>strip_tags(form_error('buyer_name')), 'currency'=>strip_tags(form_error('currency')), 'address'=>strip_tags(form_error('address')), 'landline'=>strip_tags(form_error('landline')),'contact_person'=>strip_tags(form_error('contact_person')),'mobile'=>strip_tags(form_error('mobile')),'email'=>strip_tags(form_error('email')),'GSTIN'=>strip_tags(form_error('GSTIN')));
            }else{

                $data = array(
                    'buyer_name'   => trim($this->input->post('buyer_name')),
                    'currency'     => trim($this->input->post('currency')),
                    'address'    => trim($this->input->post('address')),
                    'landline'  => trim($this->input->post('landline')),
                    'mobile' =>   trim($this->input->post('mobile')),
                    'contact_person' => trim($this->input->post('contact_person')),
                    'email' =>    trim($this->input->post('email')),
                    'GSTIN' =>    trim($this->input->post('GSTIN'))
                );

              
                $checkifexitBuyerupdate = $this->admin_model->checkifexitBuyerupdate(trim($this->input->post('buyer_id')),trim($this->input->post('buyer_name')));

                if($checkifexitBuyerupdate > 0){
                    $saveBuyerdata = $this->admin_model->saveBuyerdata(trim($this->input->post('buyer_id')),$data);
                    if($saveBuyerdata){
                        $update_buyer_response['status'] = 'success';
                        $update_buyer_response['error'] = array('buyer_name'=>'', 'currency'=>'', 'address'=>'', 'landline'=>'','contact_person'=>'','mobile'=>'','email'=>'','GSTIN'=>'');
                    }

                }else{

                    $checkIfexitsbuyer = $this->admin_model->checkIfexitsbuyer(trim($this->input->post('buyer_name')));
                    if($checkIfexitsbuyer > 0){
                        $update_buyer_response['status'] = 'failure';
                        $update_buyer_response['error'] = array('buyer_name'=>'Rejection Reason Alreday Exits');
                    }else{
                        $updatedata = $this->admin_model->saveBuyerdata(trim($this->input->post('buyer_id')),$data);
                        if($updatedata){
                           $update_buyer_response['status'] = 'success';
                           $update_buyer_response['error'] = array('buyer_name'=>'', 'currency'=>'', 'address'=>'', 'landline'=>'','contact_person'=>'','mobile'=>'','email'=>'','GSTIN'=>'');
                       }

                    }
                }
            }
            echo json_encode($update_buyer_response);
        }else{
            $process = 'Update Buyer Master';
            $processFunction = 'Admin/updateBuyer';
            $this->logrecord($process,$processFunction);
            $this->global['pageTitle'] = 'Update Buyer Master';
            $data['getBuyergmasterdata'] = $this->admin_model->getBuyergmasterdata($id);
            $this->loadViews("masters/editbuyerMaster", $this->global, $data, NULL);
        }
    }


     /**
     * This function is used to laod buyerpo
     */

     public function buyerpo(){
        $process = 'Buyer PO Master';
        $processFunction = 'Admin/buyerpo';
        $this->logrecord($process,$processFunction);
        $this->global['pageTitle'] = 'Buyer PO';
        $this->loadViews("masters/buyerpo", $this->global, $data, NULL);
    }



    /**
     * This function is used to laod Buyer PO Master
     */

     public function fetchrBuyerpolist(){
        
        $params = $_REQUEST;
        $totalRecords = $this->admin_model->getBuyerpoCount($params); 
        $queryRecords = $this->admin_model->getBuyerpodata($params); 

        $data = array();
        foreach ($queryRecords as $key => $value)
        {
            $i = 0;
            foreach($value as $v)
            {
                $data[$key][$i] = $v;
                $i++;
            }
        }
        $json_data = array(
            "draw"            => intval( $params['draw'] ),   
            "recordsTotal"    => intval( $totalRecords ),  
            "recordsFiltered" => intval($totalRecords),
            "data"            => $data   // total data array
            );
        echo json_encode($json_data);
    }

     /**
     * This function is used to add New Buyer PO
     */

     public function addnewBuyerPO(){
        $post_submit = $this->input->post();
        if($post_submit){
            $save_buyerpo_response = array();

            $this->form_validation->set_rules('sales_order_number','Sales Order Number','trim|required');
            $this->form_validation->set_rules('date','Date','trim|required');
            $this->form_validation->set_rules('buyer_po_number','Buyer PO Number','trim|required');
            $this->form_validation->set_rules('buyer_po_date','Buyer PO Date','trim|required');
            $this->form_validation->set_rules('buyer_name','Buyer Name','trim|required');
            $this->form_validation->set_rules('currency','Currency','trim|required');
            $this->form_validation->set_rules('delivery_date','Delivery Date','trim|required');
            $this->form_validation->set_rules('generate_po','Generate PO','trim|required');
            $this->form_validation->set_rules('po_status','PO Status','trim|required');
            $this->form_validation->set_rules('remark','Remark','trim');


            if($this->form_validation->run() == FALSE)
            {
                $save_buyerpo_response['status'] = 'failure';
                $save_buyerpo_response['error'] = array('sales_order_number'=>strip_tags(form_error('sales_order_number')), 'date'=>strip_tags(form_error('date')), 'buyer_po_number'=>strip_tags(form_error('buyer_po_number')), 'buyer_po_date'=>strip_tags(form_error('buyer_po_date')),'buyer_name'=>strip_tags(form_error('buyer_name')),'currency'=>strip_tags(form_error('currency')),'rate'=>strip_tags(form_error('rate')),'value'=>strip_tags(form_error('value')),'part_number'=>strip_tags(form_error('part_number')),'order_quantity'=>strip_tags(form_error('order_quantity')),'description'=>strip_tags(form_error('description')),'delivery_date'=>strip_tags(form_error('delivery_date')),'generate_po'=>strip_tags(form_error('generate_po')),'po_status'=>strip_tags(form_error('po_status')),'remark'=>strip_tags(form_error('remark')));
            }else{

                    $po_id =  trim($this->input->post('po_id'));
                    if(empty($po_id)){
                        $data = array(
                            'sales_order_number'   => trim($this->input->post('sales_order_number')),
                            'date'     => trim($this->input->post('date')),
                            'buyer_po_number'    => trim($this->input->post('buyer_po_number')),
                            'buyer_po_date'  => trim($this->input->post('buyer_po_date')),
                            'buyer_name_id' =>   trim($this->input->post('buyer_name')),
                            'currency' => trim($this->input->post('currency')),
                            'delivery_date' =>    trim($this->input->post('delivery_date')),
                            'generate_po' =>    trim($this->input->post('generate_po')),
                            'po_status' => trim($this->input->post('po_status')),
                            'remark' =>    trim($this->input->post('remark')),
                        );

                        $checkIfexitsbuyerpo = $this->admin_model->checkIfexitsbuyerpo(trim($this->input->post('sales_order_number')));
                        if($checkIfexitsbuyerpo > 0){
                            $save_buyerpo_response['status'] = 'failure';
                            $save_buyerpo_response['error'] = array('sales_order_number'=>'Buyer PO Alreday Exits (Sales Order Number Alreday Exits)');
                        }else{
                            $saveBuyerpodata = $this->admin_model->saveBuyerpodata('',$data);
                            if($saveBuyerpodata){
                                $update_last_inserted_id = $this->admin_model->update_last_inserted_id($saveBuyerpodata);
                                if($update_last_inserted_id){
                                    $save_buyerpo_response['status'] = 'success';
                                    $save_buyerpo_response['error'] = array('sales_order_number'=>strip_tags(form_error('sales_order_number')), 'date'=>strip_tags(form_error('date')), 'buyer_po_number'=>strip_tags(form_error('buyer_po_number')), 'buyer_po_date'=>strip_tags(form_error('buyer_po_date')),'buyer_name'=>strip_tags(form_error('buyer_name')),'currency'=>strip_tags(form_error('currency')),'rate'=>strip_tags(form_error('rate')),'value'=>strip_tags(form_error('value')),'part_number'=>strip_tags(form_error('part_number')),'order_quantity'=>strip_tags(form_error('order_quantity')),'description'=>strip_tags(form_error('description')),'delivery_date'=>strip_tags(form_error('delivery_date')),'generate_po'=>strip_tags(form_error('generate_po')),'remark'=>strip_tags(form_error('remark')));
                                }
                            }
                        }

                }else{
                        $data = array(
                            'sales_order_number'   => trim($this->input->post('sales_order_number')),
                            'date'     => trim($this->input->post('date')),
                            'buyer_po_number'    => trim($this->input->post('buyer_po_number')),
                            'buyer_po_date'  => trim($this->input->post('buyer_po_date')),
                            'buyer_name_id' =>   trim($this->input->post('buyer_name')),
                            'currency' => trim($this->input->post('currency')),
                            'delivery_date' =>    trim($this->input->post('delivery_date')),
                            'generate_po' =>    trim($this->input->post('generate_po')),
                            'po_status' => trim($this->input->post('po_status')),
                            'remark' =>    trim($this->input->post('remark')),
                        );

                        $saveBuyerpodata = $this->admin_model->saveBuyerpodata($po_id,$data);
                        if($saveBuyerpodata){
                                $save_buyerpo_response['status'] = 'success';
                                $save_buyerpo_response['error'] = array('sales_order_number'=>strip_tags(form_error('sales_order_number')), 'date'=>strip_tags(form_error('date')), 'buyer_po_number'=>strip_tags(form_error('buyer_po_number')), 'buyer_po_date'=>strip_tags(form_error('buyer_po_date')),'buyer_name'=>strip_tags(form_error('buyer_name')),'currency'=>strip_tags(form_error('currency')),'rate'=>strip_tags(form_error('rate')),'value'=>strip_tags(form_error('value')),'part_number'=>strip_tags(form_error('part_number')),'order_quantity'=>strip_tags(form_error('order_quantity')),'description'=>strip_tags(form_error('description')),'delivery_date'=>strip_tags(form_error('delivery_date')),'generate_po'=>strip_tags(form_error('generate_po')),'remark'=>strip_tags(form_error('remark')));
                          
                        }

                }
            }
            echo json_encode($save_buyerpo_response);
        }else{
            $process = 'Add Buyer PO';
            $processFunction = 'Admin/addnewBuyerPO';
            $data['buyerList']= $this->admin_model->fetchAllbuyerList();
            // $data['rowMaterialList']= $this->admin_model->fetchALLrowMaterialList();
            $data['finishgoodList']= $this->admin_model->fetchALLFinishgoodList();

            $data['getPreviousSalesOrderNumber']= $this->admin_model->getPreviousSalesOrderNumber()[0];
            $data['fetchALLitemList']= $this->admin_model->fetchALLitemList();
            $this->logrecord($process,$processFunction);
            $this->global['pageTitle'] = 'Add Buyer PO';
            $this->loadViews("masters/addsbuyerpo", $this->global, $data, NULL);
        }
     }


    /**
     * This function is used to Delete the Buyer Master
     */

     public function deleteBuyerpo(){
        $post_submit = $this->input->post();
        if($post_submit){
            $result = $this->admin_model->deleteBuyerpo(trim($this->input->post('id')));
            if ($result) {
                        $process = 'Buyer PO Delete';
                        $processFunction = 'Admin/deleteRejection';
                        $this->logrecord($process,$processFunction);
                        
                    echo(json_encode(array('status'=>'success')));
                }
            else { echo(json_encode(array('status'=>'failed'))); }
        }else{
            echo(json_encode(array('status'=>'failed'))); 
        }
     }



    /**
     * This function is used to laod suppllierpo
     */

     public function supplierpo(){

        $process = 'Supplier PO Master';
        $processFunction = 'Admin/suppllierpo';
        $this->logrecord($process,$processFunction);
        $this->global['pageTitle'] = 'Supplier PO';
        $this->loadViews("masters/supplierpo", $this->global, $data, NULL);

    }

     /**
     * This function is used to add New Supplier PO
     */

     public function addnewSupplierpo(){
        $post_submit = $this->input->post();
        if($post_submit){
            $save_supplierpo_response = array();

            $this->form_validation->set_rules('po_number','PO Number','trim|required');
            $this->form_validation->set_rules('date','Date','trim|required');
            $this->form_validation->set_rules('supplier_name','Supplier Name','trim|required');
            $this->form_validation->set_rules('buyer_name','Buyer Name','trim|required');
            $this->form_validation->set_rules('buyer_po_number','Buyer PO Number','trim');
            $this->form_validation->set_rules('vendor_name','Vendor Name','trim|required');
            $this->form_validation->set_rules('quatation_ref_no','Quatation Ref No','trim');
            $this->form_validation->set_rules('quatation_date','Quatation Date','trim');
            $this->form_validation->set_rules('delivery_date','Delivery Date','trim|required');
            $this->form_validation->set_rules('delivery','Delivery','trim');
            $this->form_validation->set_rules('delivery_address','Delivery Address','trim');
            $this->form_validation->set_rules('work_order','Work Order','trim');
            $this->form_validation->set_rules('remark','Remark','trim');
            
            if($this->form_validation->run() == FALSE)
            {
                $save_supplierpo_response['status'] = 'failure';
                $save_supplierpo_response['error'] = array('po_number'=>strip_tags(form_error('po_number')),'date'=>strip_tags(form_error('date')), 'supplier_name'=>strip_tags(form_error('supplier_name')),'buyer_name'=>strip_tags(form_error('buyer_name')),'vendor_name'=>strip_tags(form_error('vendor_name')),'total_amount'=>strip_tags(form_error('total_amount')),'quatation_ref_no'=>strip_tags(form_error('quatation_ref_no')),'quatation_date'=>strip_tags(form_error('quatation_date')),'delivery_date'=>strip_tags(form_error('delivery_date')),'delivery'=>strip_tags(form_error('delivery')),'work_order'=>strip_tags(form_error('work_order')),'remark'=>strip_tags(form_error('remark')),'buyer_po_number'=>strip_tags(form_error('buyer_po_number')));
            }else{


    
                $data = array(
                    'po_number'=> trim($this->input->post('po_number')),
                    'date'=> trim($this->input->post('date')),
                    'supplier_name'=> trim($this->input->post('supplier_name')),
                    'buyer_name'=> trim($this->input->post('buyer_name')),
                    'buyer_po_number'=> trim($this->input->post('buyer_po_number')),
                    'vendor_name'=> trim($this->input->post('vendor_name')),
                    'quatation_ref_no'=> trim($this->input->post('quatation_ref_no')),
                    'quatation_date'=> trim($this->input->post('quatation_date')),
                    'delivery_date'=> trim($this->input->post('delivery_date')),
                    'delivery'=> trim($this->input->post('delivery')),
                    'delivery_address'=> trim($this->input->post('delivery_address')),
                    'work_order'=> trim($this->input->post('work_order')),
                    'remark'=> trim($this->input->post('remark')),
                );

                if($this->input->post('sup_id')){
                    $checkIfexitssupplierrpo = 0;
                }else{
                    $checkIfexitssupplierrpo = $this->admin_model->checkIfexitssupplierrpo(trim($this->input->post('po_number')));
                }

                if($checkIfexitssupplierrpo > 0){
                    $save_supplierpo_response['status'] = 'failure';
                    $save_supplierpo_response['error'] = array('po_number'=>'PO Alreday Exits (PO Number Alreday Exits)');
                }else{
                    $saveSupplierpodata = $this->admin_model->saveSupplierpodata($this->input->post('sup_id'),$data);
                    if($saveSupplierpodata){
                        $update_last_inserted_id = $this->admin_model->update_last_inserted_id_supplier_po($saveSupplierpodata);
                        if($update_last_inserted_id){
                            $save_supplierpo_response['status'] = 'success';
                            $save_supplierpo_response['error'] = array('po_number'=>strip_tags(form_error('po_number')),'date'=>strip_tags(form_error('date')), 'supplier_name'=>strip_tags(form_error('supplier_name')),'buyer_name'=>strip_tags(form_error('buyer_name')),'vendor_name'=>strip_tags(form_error('vendor_name')),'total_amount'=>strip_tags(form_error('total_amount')),'quatation_ref_no'=>strip_tags(form_error('quatation_ref_no')),'quatation_date'=>strip_tags(form_error('quatation_date')),'delivery_date'=>strip_tags(form_error('delivery_date')),'delivery'=>strip_tags(form_error('delivery')),'work_order'=>strip_tags(form_error('work_order')),'remark'=>strip_tags(form_error('remark')),'buyer_po_number'=>strip_tags(form_error('buyer_po_number')));
                        }
                    }
                }
            }
            echo json_encode($save_supplierpo_response);
        }else{
            $process = 'Add Supplier PO';
            $processFunction = 'Admin/addnewSupplierpo';
            $data['buyerList']= $this->admin_model->fetchAllbuyerList();
            $data['rowMaterialList']= $this->admin_model->fetchALLrowMaterialList();
            $data['supplierList']= $this->admin_model->fetchALLsupplierList();
            $data['vendorList']= $this->admin_model->fetchALLvendorList();
           
            $data['getPreviousPONumber']= $this->admin_model->getPreviousPONumber()[0];
            $data['getPreviousvendorPONumber']= $this->admin_model->getPreviousvendorPONumber()[0];

            $data['fetchALLpresupplieritemList']= $this->admin_model->fetchALLpresupplieritemList();
            $this->logrecord($process,$processFunction);
            $this->global['pageTitle'] = 'Add Supplier PO';
            $this->loadViews("masters/addSupplierpo", $this->global, $data, NULL);
        }
     }



    /**
     * This function is used to laod Buyer PO Master
     */

     public function fetchSupplierpolist(){
        
        $params = $_REQUEST;
        $totalRecords = $this->admin_model->getSupplierpoCount($params); 
        $queryRecords = $this->admin_model->getSupplierpodata($params); 

        $data = array();
        foreach ($queryRecords as $key => $value)
        {
            $i = 0;
            foreach($value as $v)
            {
                $data[$key][$i] = $v;
                $i++;
            }
        }
        $json_data = array(
            "draw"            => intval( $params['draw'] ),   
            "recordsTotal"    => intval( $totalRecords ),  
            "recordsFiltered" => intval($totalRecords),
            "data"            => $data   // total data array
            );
        echo json_encode($json_data);
    }


    /**
     * This function is used to Delete the Buyer Master
     */

    public function deleteSupplierpo(){
        $post_submit = $this->input->post();
        if($post_submit){
            $result = $this->admin_model->deleteSupplierpo(trim($this->input->post('id')));
            if ($result) {
                        $process = 'Supplier PO Delete';
                        $processFunction = 'Admin/deleteSupplierpo';
                        $this->logrecord($process,$processFunction);
                    echo(json_encode(array('status'=>'success')));
                }
            else { echo(json_encode(array('status'=>'failed'))); }
        }else{
            echo(json_encode(array('status'=>'failed'))); 
        }
    }


    public function addbuyeritem(){

        $post_submit = $this->input->post();
      
        if($post_submit){
            $save_buyerpoitem_response = array();

            $this->form_validation->set_rules('part_number','Part Number','trim|required');
            $this->form_validation->set_rules('description','Part Name','trim|required');
            $this->form_validation->set_rules('qty','Qty','trim|numeric|required');
            $this->form_validation->set_rules('rate','Rate','trim|required');
            $this->form_validation->set_rules('value','Value','trim|required');
            $this->form_validation->set_rules('unit','Unit','trim');
            $this->form_validation->set_rules('buyer_po_delivery_date','Buyer PO Delivery Date','trim');
        
            if($this->form_validation->run() == FALSE)
            {
                $save_buyerpoitem_response['status'] = 'failure';
                $save_buyerpoitem_response['error'] = array('part_number'=>strip_tags(form_error('part_number')), 'description'=>strip_tags(form_error('description')), 'qty'=>strip_tags(form_error('qty')), 'rate'=>strip_tags(form_error('rate')),'value'=>strip_tags(form_error('value')),'buyer_po_delivery_date'=>strip_tags(form_error('buyer_po_delivery_date')));
            }else{

                    $po_id = trim($this->input->post('po_id'));
                    if(empty($po_id)){

                        $data = array(
                            'part_number_id'   => trim($this->input->post('part_number')),
                            'description'     => trim($this->input->post('description')),
                            'order_oty'    => trim($this->input->post('qty')),
                            'rate'  => trim($this->input->post('rate')),
                            'value' =>   trim($this->input->post('value')),
                            'unit' =>  trim($this->input->post('unit')),
                            'buyer_po_part_delivery_date' => trim($this->input->post('buyer_po_part_delivery_date')),
                            'pre_buyer_po_number'=>trim($this->input->post('buyer_po_number')),
                            'pre_date'=>trim($this->input->post('date')),
                            'pre_buyer_po_date'=>trim($this->input->post('buyer_po_date')),
                            'pre_buyer_name' =>trim($this->input->post('buyer_name')),
                            'pre_currency' =>trim($this->input->post('currency')),
                            'pre_delivery_date' =>trim($this->input->post('delivery_date')),
                            'pre_generate_po' =>trim($this->input->post('generate_po')),
                            'pre_po_status' =>trim($this->input->post('po_status')),
                            'pre_remark' =>trim($this->input->post('remark')),
                        );
                     }else{
                            $data = array(
                                'buyer_po_id'   => trim($this->input->post('po_id')),
                                'part_number_id'   => trim($this->input->post('part_number')),
                                'description'     => trim($this->input->post('description')),
                                'order_oty'    => trim($this->input->post('qty')),
                                'rate'  => trim($this->input->post('rate')),
                                'value' =>   trim($this->input->post('value')),
                                'unit' =>  trim($this->input->post('unit')),
                                'buyer_po_part_delivery_date' => trim($this->input->post('buyer_po_part_delivery_date')),
                                'pre_buyer_po_number'=>trim($this->input->post('buyer_po_number')),
                                'pre_date'=>trim($this->input->post('date')),
                                'pre_buyer_po_date'=>trim($this->input->post('buyer_po_date')),
                                'pre_buyer_name' =>trim($this->input->post('buyer_name')),
                                'pre_currency' =>trim($this->input->post('currency')),
                                'pre_delivery_date' =>trim($this->input->post('delivery_date')),
                                'pre_generate_po' =>trim($this->input->post('generate_po')),
                                'pre_po_status' =>trim($this->input->post('po_status')),
                                'pre_remark' =>trim($this->input->post('remark')),
                            );

                        }

                // $checkIfexitsbuyerpo = $this->admin_model->checkIfexitsbuyerpo(trim($this->input->post('sales_order_number')));
                // if($checkIfexitsbuyerpo > 0){
                //     $save_buyerpo_response['status'] = 'failure';
                //     $save_buyerpo_response['error'] = array('sales_order_number'=>'Buyer PO Alreday Exits (Sales Order Number Alreday Exits)');
                // }else{

                    $buyer_po_item_id = trim($this->input->post('buyer_po_item_id'));
                    if( $buyer_po_item_id){
                        $buyerpoitemid = $buyer_po_item_id;
                    }else{
                        $buyerpoitemid = '';
                    }

                    $saveBuyerpoitemdata = $this->admin_model->saveBuyerpoitemdata($buyerpoitemid,$data);
                    if($saveBuyerpoitemdata){
                        $save_buyerpoitem_response['status'] = 'success';
                        $save_buyerpoitem_response['error'] = array('part_number'=>'', 'description'=>'', 'qty'=>'', 'rate'=>'','value'=>'');
                    }
                //  }
                
               
            }

            echo json_encode($save_buyerpoitem_response);

        }

    }

    public function deleteBuyerpoitem(){

        $post_submit = $this->input->post();
        if($post_submit){
            $result = $this->admin_model->deleteBuyerpoitem(trim($this->input->post('id')));
            if ($result) {
                        $process = 'Buyer PO Item Delete';
                        $processFunction = 'Admin/deleteBuyerpoitem';
                        $this->logrecord($process,$processFunction);
                    echo(json_encode(array('status'=>'success')));
                }
            else { echo(json_encode(array('status'=>'failed'))); }
        }else{
            echo(json_encode(array('status'=>'failed'))); 
        }

    }

    public function getBuyerCurrency() {
            if($this->input->post('buyer_name')) {
                        $getBuyerCurrency = $this->admin_model->getBuyerCurrency($this->input->post('buyer_name'));
                        $content = $getBuyerCurrency[0]['currency'];
                    echo $content;
            } else {
                echo 'failure';
            }
    }

    public function viewBuyerpo($buyerpoid){
        $process = 'View Buyer PO';
        $processFunction = 'Admin/viewBuyerpo';
        $this->logrecord($process,$processFunction);
        $this->global['pageTitle'] = 'Buyer PO View';
        $data['getbuyerpodetails']= $this->admin_model->getbuyerpodetails($buyerpoid);
        $data['fetchALLitemList']= $this->admin_model->fetchALLBuyeritemList($buyerpoid);
        $data['buyerList']= $this->admin_model->fetchAllbuyerList();
        $this->loadViews("masters/viewbuyerpo", $this->global, $data, NULL);
    }

    public function editBuyerpo($buyerpoid){
        $process = 'Edit Buyer PO';
        $processFunction = 'Admin/editBuyerpo';
        $this->logrecord($process,$processFunction);
        $this->global['pageTitle'] = 'Edit Buyer PO';
        $data['getbuyerpodetails']= $this->admin_model->getbuyerpodetails($buyerpoid);
        $data['fetchALLitemList']= $this->admin_model->fetchALLBuyeritemList($buyerpoid);
        $data['buyerList']= $this->admin_model->fetchAllbuyerList();
        $data['finishgoodList']= $this->admin_model->fetchALLFinishgoodList();
           
        $this->loadViews("masters/editbuyerpo", $this->global, $data, NULL);
    }
 
    public function getPartnumberByid(){

        if($this->input->post('part_number')) {
            $getPartNameBypartid = $this->admin_model->getPartnumberBypartnumber($this->input->post('part_number'));
            $content = $getPartNameBypartid[0];
            echo json_encode($content);
        } else {
            echo 'failure';
        }


    }

    public function addSuplieritem(){


        $post_submit = $this->input->post();
      
        if($post_submit){
            $save_supplierpoitem_response = array();

            $this->form_validation->set_rules('part_number','Part Number','trim|required');
            $this->form_validation->set_rules('description','Part Name','trim|required');
            $this->form_validation->set_rules('qty','Qty','trim|numeric|required');
            $this->form_validation->set_rules('rate','Rate','trim|required');
            $this->form_validation->set_rules('value','Value','trim|required');
            $this->form_validation->set_rules('vendor_qty','Vendor qty','trim');
            $this->form_validation->set_rules('unit','Unit','trim');
            $this->form_validation->set_rules('item_remark','Item Remark','trim');
            $this->form_validation->set_rules('description_1','Description 1','trim');
            $this->form_validation->set_rules('description_2','Description 2','trim');

        
            if($this->form_validation->run() == FALSE)
            {
                $save_supplierpoitem_response['status'] = 'failure';
                $save_supplierpoitem_response['error'] = array('part_number'=>strip_tags(form_error('part_number')), 'description'=>strip_tags(form_error('description')), 'qty'=>strip_tags(form_error('qty')), 'rate'=>strip_tags(form_error('rate')),'value'=>strip_tags(form_error('value')),'item_remark'=>strip_tags(form_error('item_remark')),'unit'=>strip_tags(form_error('unit')),'vendor_qty'=>strip_tags(form_error('vendor_qty')),'description_1'=>strip_tags(form_error('description_1')),'description_2'=>strip_tags(form_error('description_2')));
            }else{

                $supplier_po_id =trim($this->input->post('sup_id'));

               
            
                if($supplier_po_id){

                    $data = array(
                            'supplier_po_id'  => $supplier_po_id,
                            'part_number_id'   => trim($this->input->post('part_number')),
                            'description'     => trim($this->input->post('description')),
                            'order_oty'    => trim($this->input->post('qty')),
                            'rate'  => trim($this->input->post('rate')),
                            'value' =>   trim($this->input->post('value')),
                            'vendor_qty' =>   trim($this->input->post('vendor_qty')),
                            'unit' =>   trim($this->input->post('unit')),
                            'item_remark' =>   trim($this->input->post('item_remark')),
                            'description_1' => trim($this->input->post('description_1')),
                            'description_2' => trim($this->input->post('description_2')),
                            'pre_date'=>trim($this->input->post('date')),
                            'pre_supplier_name'=>trim($this->input->post('supplier_name')),
                            'pre_buyer_name'=>trim($this->input->post('buyer_name')),
                            'pre_buyer_po_number'=>trim($this->input->post('buyer_po_number')),
                            'pre_vendor_name'=>trim($this->input->post('vendor_name')),
                            'pre_quatation_ref_number' =>trim($this->input->post('quatation_ref_no')),
                            'pre_quatation_date' =>trim($this->input->post('quatation_date')),
                            'pre_delivery_date' =>trim($this->input->post('delivery_date')),
                            'pre_delivery' =>trim($this->input->post('delivery')),
                            'pre_deliveey_address' =>trim($this->input->post('delivery_address')),
                            'pre_work_order' =>trim($this->input->post('work_order')),
                            'pre_remark' =>trim($this->input->post('remark')),
                        );

                }else{
                
                    $data = array(
                    // 'supplier_po_id'  => $supplier_po_id,
                        'part_number_id'   => trim($this->input->post('part_number')),
                        'description'     => trim($this->input->post('description')),
                        'order_oty'    => trim($this->input->post('qty')),
                        'rate'  => trim($this->input->post('rate')),
                        'value' =>   trim($this->input->post('value')),
                        'vendor_qty' =>   trim($this->input->post('vendor_qty')),
                        'unit' =>   trim($this->input->post('unit')),
                        'item_remark' =>   trim($this->input->post('item_remark')),
                        'pre_date'=>trim($this->input->post('date')),
                        'description_1' => trim($this->input->post('description_1')),
                        'description_2' => trim($this->input->post('description_2')),
                        'pre_supplier_name'=>trim($this->input->post('supplier_name')),
                        'pre_buyer_name'=>trim($this->input->post('buyer_name')),
                        'pre_buyer_po_number'=>trim($this->input->post('buyer_po_number')),
                        'pre_vendor_name'=>trim($this->input->post('vendor_name')),
                        'pre_quatation_ref_number' =>trim($this->input->post('quatation_ref_no')),
                        'pre_quatation_date' =>trim($this->input->post('quatation_date')),
                        'pre_delivery_date' =>trim($this->input->post('delivery_date')),
                        'pre_delivery' =>trim($this->input->post('delivery')),
                        'pre_deliveey_address' =>trim($this->input->post('delivery_address')),
                        'pre_work_order' =>trim($this->input->post('work_order')),
                        'pre_remark' =>trim($this->input->post('remark')),
                    );
            }

                // $checkIfexitsbuyerpo = $this->admin_model->checkIfexitsbuyerpo(trim($this->input->post('sales_order_number')));
                // if($checkIfexitsbuyerpo > 0){
                //     $save_buyerpo_response['status'] = 'failure';
                //     $save_buyerpo_response['error'] = array('sales_order_number'=>'Buyer PO Alreday Exits (Sales Order Number Alreday Exits)');
                // }else{

                    $supplier_po_item_id = trim($this->input->post('supplier_po_item_id'));
                    if( $supplier_po_item_id){
                        $supplierpoitemid = $supplier_po_item_id;
                    }else{
                        $supplierpoitemid = '';
                    }

                    $saveSupplierpoitemdata = $this->admin_model->saveSupplierpoitemdata($supplierpoitemid,$data);
                    if($saveSupplierpoitemdata){
                        $save_supplierpoitem_response['status'] = 'success';
                        $save_supplierpoitem_response['error'] = array('part_number'=>'', 'description'=>'', 'qty'=>'', 'rate'=>'','value'=>'');
                    }
                //  }
                
               
            }

            echo json_encode($save_supplierpoitem_response);

        }

    }

    public function viewSupplierpo($supplierpoid){

        $process = 'View Supplier PO';
        $processFunction = 'Admin/viewSupplierpo';
        $this->logrecord($process,$processFunction);
        $this->global['pageTitle'] = 'Supplier PO View';
        $data['supplierList']= $this->admin_model->fetchALLsupplierList();
        $data['buyerList']= $this->admin_model->fetchAllbuyerList();
        $data['vendorList']= $this->admin_model->fetchALLvendorList();
        $data['getSuplierpodetails']= $this->admin_model->getSuplierpodetails($supplierpoid);
        $data['fetchALLsupplieritemlistforview']= $this->admin_model->fetchALLsupplieritemlistforview($supplierpoid);
        $this->loadViews("masters/viewSupplierpo", $this->global, $data, NULL);

    }

    public function editSupplierpo($supplierpoid){

        $process = 'Edit Supplier PO';
        $processFunction = 'Admin/viewSupplierpo';
        $this->logrecord($process,$processFunction);
        $this->global['pageTitle'] = 'Edit Supplier PO';
        $data['supplierList']= $this->admin_model->fetchALLsupplierList();
        $data['rowMaterialList']= $this->admin_model->fetchALLrowMaterialList();
        $data['buyerList']= $this->admin_model->fetchAllbuyerList();
        $data['vendorList']= $this->admin_model->fetchALLvendorList();
        $data['getSuplierpodetails']= $this->admin_model->getSuplierpodetails($supplierpoid);
        $data['fetchALLsupplieritemlistforview']= $this->admin_model->fetchALLsupplieritemlistforview($supplierpoid);
        $data['buyerpoList']= $this->admin_model->fetchAllbuyerpoList($data['fetchALLsupplieritemlistforview'][0]['pre_buyer_name']);
        $this->loadViews("masters/editSupplierpo", $this->global, $data, NULL);

    }

    public function deleteSupplierpoitem(){
        $post_submit = $this->input->post();
        if($post_submit){
            $result = $this->admin_model->deleteSupplierpoitem(trim($this->input->post('id')));
            if ($result) {
                        $process = 'Supplier PO Delete';
                        $processFunction = 'Admin/deleteSupplierpoitem';
                        $this->logrecord($process,$processFunction);
                    echo(json_encode(array('status'=>'success')));
                }
            else { echo(json_encode(array('status'=>'failed'))); }
        }else{
            echo(json_encode(array('status'=>'failed'))); 
        }

    }

    public function getBuyerPonumberbyBuyerid(){

		if($this->input->post('buyer_name')) {
			$getAllponumber = $this->admin_model->getBuyerPonumberbyBuyerid($this->input->post('buyer_name'));
			if(count($getAllponumber) >= 1) {
                $content = $content.'<option value="">Select Buyer Number</option>';
				foreach($getAllponumber as $value) {
                    
					  $content = $content.'<option value="'.$value["id"].'">'.$value["sales_order_number"].' - '.$value["buyer_po_number"].'</option>';
                    
				}
				echo $content;
			} else {
				echo 'failure';
			}
		} else {
			echo 'failure';
		}

    }


    public function getBuyerPonumberbyBuyeridvendorpo(){

		if($this->input->post('buyer_name')) {
			$getAllponumber = $this->admin_model->getBuyerPonumberbyBuyeridvendorpo($this->input->post('buyer_name'));
			if(count($getAllponumber) >= 1) {
                $content = $content.'<option value="">Select Buyer Number</option>';
				foreach($getAllponumber as $value) {
                    if($value['po_status']=='Open'){
					  $content = $content.'<option value="'.$value["id"].'">'.$value["sales_order_number"].' - '.$value["buyer_po_number"].'</option>';
                    }
				}
				echo $content;
			} else {
				echo 'failure';
			}
		} else {
			echo 'failure';
		}

    }


    public function getBuyerPonumberbyBuyeridforsupplierandvendorpo(){
		if($this->input->post('buyer_name')) {
			$getAllponumber = $this->admin_model->getBuyerPonumberbyBuyeridforsupplierandvendorpo($this->input->post('buyer_name'));
			if(count($getAllponumber) >= 1) {
                $content = $content.'<option value="">Select Buyer Number</option>';
				foreach($getAllponumber as $value) {
                    if($value['po_status']=='Open'){
                        $content = $content.'<option value="'.$value["id"].'">'.$value["sales_order_number"].' - '.$value["buyer_po_number"].'</option>';
                    }
				}
				echo $content;
			} else {
				echo 'failure';
			}
		} else {
			echo 'failure';
		}

    }



    

    public function getBuyerItemsforDisplay(){

        $post_submit = $this->input->post();

        if($post_submit){

            $buyer_po_number = $this->input->post('buyer_po_number');

            // print_r($buyer_po_number);
            // exit;
        
            // load table library
            $this->load->library('table');
            
            // set heading
            //$this->table->set_heading('Part Number', 'Description', 'Order Qty','Unit', 'Rate','Value');
            $this->table->set_heading('Part Number', 'Description', 'Order Qty','Delivery Date');

            // set template
            $style = array('table_open'  => '<p><b>Buyer PO Item</b></p><table style="width: 70% !important; max-width: 100%;margin-bottom: 20px;" class="table">');

            $this->table->set_template($style);

            // $this->db->select(TBL_FINISHED_GOODS.'.part_number,'.TBL_BUYER_PO_MASTER_ITEM.'.description,'.TBL_BUYER_PO_MASTER_ITEM.'.order_oty,'.TBL_BUYER_PO_MASTER_ITEM.'.unit,'.TBL_BUYER_PO_MASTER_ITEM.'.rate,'.TBL_BUYER_PO_MASTER_ITEM.'.value');
            $this->db->select(TBL_FINISHED_GOODS.'.part_number,'.TBL_BUYER_PO_MASTER_ITEM.'.description,'.TBL_BUYER_PO_MASTER_ITEM.'.order_oty,'.TBL_BUYER_PO_MASTER_ITEM.'.buyer_po_part_delivery_date');
            $this->db->join(TBL_FINISHED_GOODS, TBL_FINISHED_GOODS.'.fin_id = '.TBL_BUYER_PO_MASTER_ITEM.'.part_number_id');
            $this->db->join(TBL_BUYER_PO_MASTER, TBL_BUYER_PO_MASTER.'.id = '.TBL_BUYER_PO_MASTER_ITEM.'.buyer_po_id');
            //$this->db->where(TBL_BUYER_PO_MASTER_ITEM.'.part_number_id NOT IN (SELECT part_number_id FROM tbl_supplierpo_item where pre_buyer_po_number='.$buyer_po_number.')');
            $this->db->where(TBL_BUYER_PO_MASTER_ITEM.'.buyer_po_id',$buyer_po_number);
            $query_result = $this->db->get(TBL_BUYER_PO_MASTER_ITEM);
            $data = $query_result->result_array();
            
            if($data){
                echo $this->table->generate($query_result);

            }else{
                echo '';
            }
    
       }
    }

    public function getBuyerItemsforDisplayBybuyerid(){
        $buyer_po_id=$this->input->post('buyer_po_id');
        if($buyer_po_id) {
			$getbuyerdetails = $this->admin_model->getBuyerDeatilsbyid($buyer_po_id);
			if(count($getbuyerdetails) >= 1) {
                $content = $content.'<option value="">Select Buyer PO Number</option>';
				foreach($getbuyerdetails as $value) {
					$content = $content.'<option value="'.$value["id"].'">'.$value["sales_order_number"].'</option>';
				}
				echo $content;
			} else {
				echo 'failure';
			}
		} else {
			echo 'failure';
		}
    }

    public function vendorpo(){
        $process = 'Vendor PO Master';
        $processFunction = 'Admin/vendorpo';
        $this->logrecord($process,$processFunction);
        $this->global['pageTitle'] = 'Vendor PO Master';
        $this->loadViews("masters/vendorpo", $this->global, $data, NULL);

    }

    public function fetchVendorpolist(){

        $params = $_REQUEST;
        $totalRecords = $this->admin_model->getVendorpoCount($params); 
        $queryRecords = $this->admin_model->getVendorpodata($params); 

        $data = array();
        foreach ($queryRecords as $key => $value)
        {
            $i = 0;
            foreach($value as $v)
            {
                $data[$key][$i] = $v;
                $i++;
            }
        }
        $json_data = array(
            "draw"            => intval( $params['draw'] ),   
            "recordsTotal"    => intval( $totalRecords ),  
            "recordsFiltered" => intval($totalRecords),
            "data"            => $data   // total data array
            );
        echo json_encode($json_data);

    }


    public function addnewVendorpo(){
            $post_submit = $this->input->post();
            if($post_submit){
                $save_vendorpo_response = array();
    
                $this->form_validation->set_rules('po_number','PO Number','trim|required');
                $this->form_validation->set_rules('date','Date','trim|required');
                $this->form_validation->set_rules('supplier_name','Supplier Name','trim');
                $this->form_validation->set_rules('buyer_name','Buyer Name','trim|required');
                $this->form_validation->set_rules('supplier_po_number','Supplier PO Number','trim');
                $this->form_validation->set_rules('vendor_name','Vendor Name','trim|required');
                $this->form_validation->set_rules('buyer_po_number','Buyer PO Number','trim|required');
                $this->form_validation->set_rules('quatation_ref_no','Quatation Ref No','trim');
                $this->form_validation->set_rules('quatation_date','Quatation Date','trim');
                $this->form_validation->set_rules('delivery_date','Delivery Date','trim|required');
                $this->form_validation->set_rules('delivery','Delivery','trim');
                $this->form_validation->set_rules('delivery_address','Delivery Address','trim');
                $this->form_validation->set_rules('work_order','Work Order','trim');
                $this->form_validation->set_rules('remark','Remark','trim');
                
                if($this->form_validation->run() == FALSE)
                {
                    $save_vendorpo_response['status'] = 'failure';
                    $save_vendorpo_response['error'] = array('po_number'=>strip_tags(form_error('po_number')),'date'=>strip_tags(form_error('date')), 'supplier_name'=>strip_tags(form_error('supplier_name')),'buyer_name'=>strip_tags(form_error('buyer_name')),'vendor_name'=>strip_tags(form_error('vendor_name')),'total_amount'=>strip_tags(form_error('total_amount')),'quatation_ref_no'=>strip_tags(form_error('quatation_ref_no')),'quatation_date'=>strip_tags(form_error('quatation_date')),'delivery_date'=>strip_tags(form_error('delivery_date')),'delivery'=>strip_tags(form_error('delivery')),'work_order'=>strip_tags(form_error('work_order')),'remark'=>strip_tags(form_error('remark')),'buyer_po_number'=>strip_tags(form_error('buyer_po_number')),'supplier_po_number'=>strip_tags(form_error('supplier_po_number')));
                }else{
    
                    $data = array(
                        'po_number'=> trim($this->input->post('po_number')),
                        'date'=> trim($this->input->post('date')),
                        'supplier_name'=> trim($this->input->post('supplier_name')),
                        'supplier_po_number'=> trim($this->input->post('supplier_po_number')),
                        'buyer_name'=> trim($this->input->post('buyer_name')),
                        'buyer_po_number'=> trim($this->input->post('buyer_po_number')),
                        'vendor_name'=> trim($this->input->post('vendor_name')),
                        'quatation_ref_no'=> trim($this->input->post('quatation_ref_no')),
                        'quatation_date'=> trim($this->input->post('quatation_date')),
                        'delivery_date'=> trim($this->input->post('delivery_date')),
                        'delivery'=> trim($this->input->post('delivery')),
                        'delivery_address'=> trim($this->input->post('delivery_address')),
                        'work_order'=> trim($this->input->post('work_order')),
                        'remark'=> trim($this->input->post('remark')),
                    );

        
                    $vendor_id = $this->input->post('vendor_id');

                    if($vendor_id){

                        $saveVensorpodata = $this->admin_model->saveVensorpodata($vendor_id,$data);
                        if($saveVensorpodata){
                            $update_last_inserted_id = $this->admin_model->update_last_inserted_id_vendor_po($saveVensorpodata);
                            if($update_last_inserted_id){
                                $save_vendorpo_response['status'] = 'success';
                                $save_vendorpo_response['error'] = array('po_number'=>strip_tags(form_error('po_number')),'date'=>strip_tags(form_error('date')), 'supplier_name'=>strip_tags(form_error('supplier_name')),'buyer_name'=>strip_tags(form_error('buyer_name')),'vendor_name'=>strip_tags(form_error('vendor_name')),'total_amount'=>strip_tags(form_error('total_amount')),'quatation_ref_no'=>strip_tags(form_error('quatation_ref_no')),'quatation_date'=>strip_tags(form_error('quatation_date')),'delivery_date'=>strip_tags(form_error('delivery_date')),'delivery'=>strip_tags(form_error('delivery')),'work_order'=>strip_tags(form_error('work_order')),'remark'=>strip_tags(form_error('remark')),'buyer_po_number'=>strip_tags(form_error('buyer_po_number')),'supplier_po_number'=>strip_tags(form_error('supplier_po_number')));
                            }
                        }


                    }else{

                        $checkIfexitsvendorrpo = $this->admin_model->checkIfexitsvendorrpo(trim($this->input->post('po_number')));
                        if($checkIfexitsvendorrpo > 0){
                            $save_vendorpo_response['status'] = 'failure';
                            $save_vendorpo_response['error'] = array('po_number'=>'PO Alreday Exits (PO Number Alreday Exits)');
                        }else{
                            $saveVensorpodata = $this->admin_model->saveVensorpodata('',$data);
                            if($saveVensorpodata){
                                $update_last_inserted_id = $this->admin_model->update_last_inserted_id_vendor_po($saveVensorpodata);
                                if($update_last_inserted_id){
                                    $save_vendorpo_response['status'] = 'success';
                                    $save_vendorpo_response['error'] = array('po_number'=>strip_tags(form_error('po_number')),'date'=>strip_tags(form_error('date')), 'supplier_name'=>strip_tags(form_error('supplier_name')),'buyer_name'=>strip_tags(form_error('buyer_name')),'vendor_name'=>strip_tags(form_error('vendor_name')),'total_amount'=>strip_tags(form_error('total_amount')),'quatation_ref_no'=>strip_tags(form_error('quatation_ref_no')),'quatation_date'=>strip_tags(form_error('quatation_date')),'delivery_date'=>strip_tags(form_error('delivery_date')),'delivery'=>strip_tags(form_error('delivery')),'work_order'=>strip_tags(form_error('work_order')),'remark'=>strip_tags(form_error('remark')),'buyer_po_number'=>strip_tags(form_error('buyer_po_number')),'supplier_po_number'=>strip_tags(form_error('supplier_po_number')));
                                }
                            }
                        }
                   }
                }
                echo json_encode($save_vendorpo_response);
            }else{
                $process = 'Add Vendor PO';
                $processFunction = 'Admin/addnewSupplierpo';
                $data['buyerList']= $this->admin_model->fetchAllbuyerList();
                $data['finishgoodList']= $this->admin_model->fetchALLFinishgoodList();
                $data['supplierList']= $this->admin_model->fetchALLsupplierList();
                $data['vendorList']= $this->admin_model->fetchALLvendorList();
                $data['getPreviousPONumber']= $this->admin_model->getPreviousvendorPONumber()[0];
                $data['getPrevioussupplierPONumber']= $this->admin_model->getPreviousPONumber()[0];
                $data['fetchALLpreVendoritemList']= $this->admin_model->fetchALLpreVendoritemList();
                $this->logrecord($process,$processFunction);
                $this->global['pageTitle'] = 'Add Vendor PO';
                $this->loadViews("masters/addVendorpo", $this->global, $data, NULL);
            }
    }


    public function getfinishedgoodsPartnumberByidvendor(){

            if($this->input->post('part_number')) {
                $getPartNameBypartid = $this->admin_model->getfinishedgoodsPartnumberByid($this->input->post('part_number'),$this->input->post('flag'),$this->input->post('po_number'));

                if($getPartNameBypartid){
                    $content = $getPartNameBypartid[0];
                    echo json_encode($content);

                }else{
                    echo 'failure';
                }
               
            } else {
                echo 'failure';
            }
    }

    public function getfinishedgoodsPartnumberByid(){

        if($this->input->post('part_number')) {
            $getPartNameBypartid = $this->admin_model->getfinishedgoodsPartnumberByidforbuyer($this->input->post('part_number'));

            if($getPartNameBypartid){
                $content = $getPartNameBypartid[0];
                echo json_encode($content);

            }else{
                echo 'failure';
            }
           
        } else {
            echo 'failure';
        }
    }

    public function addVendoritem(){

        $post_submit = $this->input->post();
      
        if($post_submit){
            $save_vendorpoitem_response = array();

            $this->form_validation->set_rules('part_number','Part Number','trim|required');
            $this->form_validation->set_rules('description','Part Name','trim|required');
            $this->form_validation->set_rules('qty','Qty','trim|numeric|required');
            $this->form_validation->set_rules('rate','Rate','trim|required');
            $this->form_validation->set_rules('value','Value','trim|required');

            $this->form_validation->set_rules('vendor_qty','Vendor qty','trim');
            $this->form_validation->set_rules('unit','Unit','trim');
            $this->form_validation->set_rules('item_remark','Item Remark','trim');
            $this->form_validation->set_rules('rm_type','rm_type','trim');

            $this->form_validation->set_rules('description_1','Description 1','trim');
            $this->form_validation->set_rules('description_2','Description 2','trim');
        
            if($this->form_validation->run() == FALSE)
            {
                $save_vendorpoitem_response['status'] = 'failure';
                $save_vendorpoitem_response['error'] = array('part_number'=>strip_tags(form_error('part_number')), 'description'=>strip_tags(form_error('description')), 'qty'=>strip_tags(form_error('qty')), 'rate'=>strip_tags(form_error('rate')),'value'=>strip_tags(form_error('value')),'item_remark'=>strip_tags(form_error('item_remark')),'unit'=>strip_tags(form_error('unit')),'vendor_qty'=>strip_tags(form_error('vendor_qty')));
            }else{

                $vendor_id =  $this->input->post('vendor_id');

                if($vendor_id){

                    $data = array(
                        'part_number_id'   => trim($this->input->post('part_number')),
                        'vendor_po_id' =>  trim($vendor_id),
                        'description'     => trim($this->input->post('description')),
                        'order_oty'    => trim($this->input->post('qty')),
                        'rate'  => trim($this->input->post('rate')),
                        'value' =>   trim($this->input->post('value')),
                        'vendor_qty' =>   trim($this->input->post('vendor_qty')),
                        'rm_type' =>trim($this->input->post('rm_type')),
                        'unit' =>   trim($this->input->post('unit')),
                        'item_remark' =>   trim($this->input->post('item_remark')),
                        'description_1' => trim($this->input->post('description_1')),
                        'description_2' => trim($this->input->post('description_2')),
                        'pre_date'=>trim($this->input->post('date')),
                        'pre_supplier_name'=>trim($this->input->post('supplier_name')),
                        'pre_supplier_po_number	'=>trim($this->input->post('supplier_po_number')),
                        'pre_buyer_name'=>trim($this->input->post('buyer_name')),
                        'pre_buyer_po_number'=>trim($this->input->post('buyer_po_number')),
                        'pre_vendor_name'=>trim($this->input->post('vendor_name')),
                        'pre_quatation_ref_number' =>trim($this->input->post('quatation_ref_no')),
                        'pre_quatation_date' =>trim($this->input->post('quatation_date')),
                        'pre_delivery_date' =>trim($this->input->post('delivery_date')),
                        'pre_delivery' =>trim($this->input->post('delivery')),
                        'pre_deliveey_address' =>trim($this->input->post('delivery_address')),
                        'pre_work_order' =>trim($this->input->post('work_order')),
                        'pre_remark' =>trim($this->input->post('remark')),
                    );


                }else{

                    $data = array(
                        'part_number_id'   => trim($this->input->post('part_number')),
                        'description'     => trim($this->input->post('description')),
                        'order_oty'    => trim($this->input->post('qty')),
                        'rate'  => trim($this->input->post('rate')),
                        'value' =>   trim($this->input->post('value')),
                        'vendor_qty' =>   trim($this->input->post('vendor_qty')),
                        'rm_type' =>trim($this->input->post('rm_type')),
                        'unit' =>   trim($this->input->post('unit')),
                        'item_remark' =>   trim($this->input->post('item_remark')),
                        'pre_date'=>trim($this->input->post('date')),
                        'description_1' => trim($this->input->post('description_1')),
                        'description_2' => trim($this->input->post('description_2')),
                        'pre_supplier_name'=>trim($this->input->post('supplier_name')),
                        'pre_supplier_po_number	'=>trim($this->input->post('supplier_po_number')),
                        'pre_buyer_name'=>trim($this->input->post('buyer_name')),
                        'pre_buyer_po_number'=>trim($this->input->post('buyer_po_number')),
                        'pre_vendor_name'=>trim($this->input->post('vendor_name')),
                        'pre_quatation_ref_number' =>trim($this->input->post('quatation_ref_no')),
                        'pre_quatation_date' =>trim($this->input->post('quatation_date')),
                        'pre_delivery_date' =>trim($this->input->post('delivery_date')),
                        'pre_delivery' =>trim($this->input->post('delivery')),
                        'pre_deliveey_address' =>trim($this->input->post('delivery_address')),
                        'pre_work_order' =>trim($this->input->post('work_order')),
                        'pre_remark' =>trim($this->input->post('remark')),
                    );

                }


                // $checkIfexitsbuyerpo = $this->admin_model->checkIfexitsbuyerpo(trim($this->input->post('sales_order_number')));
                // if($checkIfexitsbuyerpo > 0){
                //     $save_buyerpo_response['status'] = 'failure';
                //     $save_buyerpo_response['error'] = array('sales_order_number'=>'Buyer PO Alreday Exits (Sales Order Number Alreday Exits)');
                // }else{
                    $vendor_po_item_id = trim($this->input->post('vendor_po_item_id'));
                    if( $vendor_po_item_id){
                        $vendorpoitemid = $vendor_po_item_id;
                    }else{
                        $vendorpoitemid = '';
                    }

                    
                    $saveSupplierpoitemdata = $this->admin_model->saveVendorpoitemdata($vendorpoitemid,$data);
                    if($saveSupplierpoitemdata){
                        $save_vendorpoitem_response['status'] = 'success';
                        $save_vendorpoitem_response['error'] = array('part_number'=>'', 'description'=>'', 'qty'=>'', 'rate'=>'','value'=>'');
                    }
                //  }
                
               
            }

            echo json_encode($save_vendorpoitem_response);

        }

    }

    public function deleteVendorpo(){
        $post_submit = $this->input->post();
        if($post_submit){
            $result = $this->admin_model->deleteVendorpo(trim($this->input->post('id')));
            if ($result) {
                        $process = 'Vendor PO Delete';
                        $processFunction = 'Admin/deleteVendorpo';
                        $this->logrecord($process,$processFunction);
                    echo(json_encode(array('status'=>'success')));
                }
            else { echo(json_encode(array('status'=>'failed'))); }
        }else{
            echo(json_encode(array('status'=>'failed'))); 
        }


    }

    public function deleteVendorpoitem(){
        $post_submit = $this->input->post();
        if($post_submit){
            $result = $this->admin_model->deleteVendorpoitem(trim($this->input->post('id')));
            if ($result) {
                        $process = 'Vendor PO Delete';
                        $processFunction = 'Admin/deleteVendorpoitem';
                        $this->logrecord($process,$processFunction);
                    echo(json_encode(array('status'=>'success')));
                }
            else { echo(json_encode(array('status'=>'failed'))); }
        }else{
            echo(json_encode(array('status'=>'failed'))); 
        }

    }

    public function viewVendorpo($vendorpoid){

            $process = 'View Vendor PO';
            $processFunction = 'Admin/viewSupplierpo';
            $this->logrecord($process,$processFunction);
            $this->global['pageTitle'] = 'Vendor PO View';
            $data['supplierList']= $this->admin_model->fetchALLsupplierList();
            $data['buyerList']= $this->admin_model->fetchAllbuyerList();
            $data['vendorList']= $this->admin_model->fetchALLvendorList();
            $data['getVendorpodetails']= $this->admin_model->getVendorpodetails($vendorpoid);
            $data['fetchALLVendoritemlistforview']= $this->admin_model->fetchALLVendoritemlistforview($vendorpoid);
            $this->loadViews("masters/viewVendorpo", $this->global, $data, NULL);

    }

    public function supplierpoconfirmation(){

        $process = 'Supplier PO Confirmation';
        $processFunction = 'Admin/supplierpoconfirmation';
        $this->logrecord($process,$processFunction);
        $this->global['pageTitle'] = 'Supplier PO Confirmation';
        $this->loadViews("masters/supplierpoconfrimation", $this->global, $data, NULL);    
    }

    public function addSupplierpoconfirmation(){

        $post_submit = $this->input->post();
        if($post_submit){

            $save_supplierconfirmation_response = array();

            $this->form_validation->set_rules('po_number','PO Number','trim|required');
            $this->form_validation->set_rules('date','Date','trim|required');
            $this->form_validation->set_rules('supplier_name','Supplier Name','trim|required');
            $this->form_validation->set_rules('supplier_po_number','Supplier PO Number','trim|required');
            $this->form_validation->set_rules('buyer_name','Buyer Name','trim|required');
            $this->form_validation->set_rules('buyer_po_number','Buyer PO Number','trim');
            $this->form_validation->set_rules('po_confirmed','PO Confirmed','trim|required');
            $this->form_validation->set_rules('confirmed_date','Confirmed Date','trim|required');
            $this->form_validation->set_rules('confirmed_with','Confirmed With','trim|required');
            $this->form_validation->set_rules('confirmed_with','Material Sent','trim');
            $this->form_validation->set_rules('material_receipt_confirmation','Material Receipt Confirmation','trim');
            $this->form_validation->set_rules('remark','Remark','trim');


            if($this->form_validation->run() == FALSE)
            {
                $save_supplierconfirmation_response['status'] = 'failure';
                $save_supplierconfirmation_response['error'] = array( 'po_number'=>strip_tags(form_error('po_number')),'date'=>strip_tags(form_error('date')),'supplier_name'=>strip_tags(form_error('supplier_name')),'supplier_po_number'=>strip_tags(form_error('supplier_po_number')),'buyer_name'=>strip_tags(form_error('buyer_name')),'buyer_po_number'=>strip_tags(form_error('buyer_po_number')),'po_confirmed'=>strip_tags(form_error('po_confirmed')),'confirmed_date'=>strip_tags(form_error('confirmed_date')),'confirmed_with'=>strip_tags(form_error('confirmed_with')),'remark'=>strip_tags(form_error('remark')));
            }else{


                $supplierpoconfirmation_id = trim($this->input->post('supplierpoconfirmation_id'));

                $data = array(
                    'po_number'   => trim($this->input->post('po_number')),
                    'date'     => trim($this->input->post('date')),
                    'supplier_po_id'    => trim($this->input->post('supplier_name')),
                    'supplier_po_number'  => trim($this->input->post('supplier_po_number')),
                    'buyer_po_id' =>   trim($this->input->post('buyer_name')),
                    'buyer_po_number' => trim($this->input->post('buyer_po_number')),
                    'po_confirmed' =>    trim($this->input->post('po_confirmed')),
                    'confirmed_date' =>    trim($this->input->post('confirmed_date')),
                    'confirmed_with' =>    trim($this->input->post('confirmed_with')),
                    'material_sent' =>    trim($this->input->post('material_sent')),
                    'material_receipt_confirmation' =>    trim($this->input->post('material_receipt_confirmation')),
                    'remark' =>    trim($this->input->post('remark')),
                );

                // $checkIfexitsSupplierpoconfirmation = $this->admin_model->checkIfexitsSupplierpoconfirmation(trim($this->input->post('po_number')));
                // if($checkIfexitsSupplierpoconfirmation > 0){
                //     $save_supplierconfirmation_response['status'] = 'failure';
                //     $save_supplierconfirmation_response['error'] = array( 'po_number'=>strip_tags(form_error('po_number')),'date'=>strip_tags(form_error('date')),'supplier_name'=>strip_tags(form_error('supplier_name')),'supplier_po_number'=>strip_tags(form_error('supplier_po_number')),'buyer_name'=>strip_tags(form_error('buyer_name')),'buyer_po_number'=>strip_tags(form_error('buyer_po_number')),'po_confirmed'=>strip_tags(form_error('po_confirmed')),'confirmed_date'=>strip_tags(form_error('confirmed_date')),'confirmed_with'=>strip_tags(form_error('confirmed_with')),'remark'=>strip_tags(form_error('remark')));
                // }else{
                    $saveSupplierpoconfirmationdata = $this->admin_model->saveSupplierpoconfirmationdata($supplierpoconfirmation_id,$data);
                    if($saveSupplierpoconfirmationdata){
                        $update_last_inserted_id_supplier_po_confirmation = $this->admin_model->update_last_inserted_id_supplier_po_confirmation($saveSupplierpoconfirmationdata);
                        if($update_last_inserted_id_supplier_po_confirmation){
                             $save_supplierconfirmation_response['status'] = 'success';
                             $save_supplierconfirmation_response['error'] = array( 'po_number'=>strip_tags(form_error('po_number')),'date'=>strip_tags(form_error('date')),'supplier_name'=>strip_tags(form_error('supplier_name')),'supplier_po_number'=>strip_tags(form_error('supplier_po_number')),'buyer_name'=>strip_tags(form_error('buyer_name')),'buyer_po_number'=>strip_tags(form_error('buyer_po_number')),'po_confirmed'=>strip_tags(form_error('po_confirmed')),'confirmed_date'=>strip_tags(form_error('confirmed_date')),'confirmed_with'=>strip_tags(form_error('confirmed_with')),'remark'=>strip_tags(form_error('remark')));
                         }
                    }
               // }
            }
            echo json_encode($save_supplierconfirmation_response);
        }else{
            $process = 'Add Supplier PO Confirmation';
            $processFunction = 'Admin/addSupplierpoconfirmation';
            $data['buyerList']= $this->admin_model->fetchAllbuyerList();
            $data['supplierList']= $this->admin_model->fetchALLsupplierList();
            $data['rowMaterialList']= $this->admin_model->fetchALLrowMaterialList();
            $data['getPreviousSupplierPoconfirmationNumber']= $this->admin_model->getPreviousSupplierPoconfirmationNumber()[0];
            $data['getPreviousVendorPoconfirmationNumber']= $this->admin_model->getPreviousVendorPoconfirmationNumber()[0];
            $data['fetchALLpresupplierpoconfirmationitemList']= $this->admin_model->fetchALLpresupplierpoconfirmationitemList();
            $this->logrecord($process,$processFunction);
            $this->global['pageTitle'] = 'Add Supplier PO Confirmation';
            $this->loadViews("masters/addsupplierpoconfirmation", $this->global, $data, NULL);
        }

    }


    public function getRowmaterialPartnumberByidsupplierpoconfirmation(){

            if($this->input->post('part_number')) {
                $getPartNameBypartid = $this->admin_model->getRowmaterialPartnumberByidsupplierpoconfirmation($this->input->post('part_number'),$this->input->post('supplier_po_number'),$this->input->post('poitemid'));
    
                if($getPartNameBypartid){
                    $content = $getPartNameBypartid[0];
                    echo json_encode($content);
    
                }else{
                    echo 'failure';
                }
               
            } else {
                echo 'failure';
            }
    }

    public function fetchSupplierpoconfirmationlist(){

        $params = $_REQUEST;
        $totalRecords = $this->admin_model->getSupplierpoconfirmationCount($params); 
        $queryRecords = $this->admin_model->getSupplierpoconfirmationdata($params); 

        $data = array();
        foreach ($queryRecords as $key => $value)
        {
            $i = 0;
            foreach($value as $v)
            {
                $data[$key][$i] = $v;
                $i++;
            }
        }
        $json_data = array(
            "draw"            => intval( $params['draw'] ),   
            "recordsTotal"    => intval( $totalRecords ),  
            "recordsFiltered" => intval($totalRecords),
            "data"            => $data   // total data array
            );
        echo json_encode($json_data);


    }
    
    public function editSupplierpoconfirmation($supplierpoconfirmationid){
        $process = 'Edit Supplier PO Confirmation';
        $processFunction = 'Admin/editSupplierconfirmation';
        $this->logrecord($process,$processFunction);
        $this->global['pageTitle'] = 'Edit Supplier PO Confirmation';
        $data['supplierList']= $this->admin_model->fetchALLsupplierList();
        $data['buyerList']= $this->admin_model->fetchAllbuyerList();
        $data['vendorList']= $this->admin_model->fetchALLvendorList();
        $data['supplierpoconfirmationid'] = $supplierpoconfirmationid;
        $data['getSupplierpoconfirmationdetails']= $this->admin_model->getSupplierpoconfirmationdetails($supplierpoconfirmationid)[0];
        $data['fetchALLSupplierPOitemsforview']= $this->admin_model->fetchALLSupplierPOitemsforview($supplierpoconfirmationid);
        $this->loadViews("masters/editSupplierpoconfirmation", $this->global, $data, NULL);
    }



    public function getSupplierPonumberbySupplieridvendorponew(){

        $supplier_name=$this->input->post('supplier_name');

        if($supplier_name) {
			$getSupplierdetails = $this->admin_model->getSupplierDeatilsbyid($supplier_name);
			if(count($getSupplierdetails) >= 1) {
                $content = $content.'<option value="">Select Supplier PO Number</option>';
				foreach($getSupplierdetails as $value) {
                    if($value['po_status']=='Open'){
                        $content = $content.'<option value="'.$value["supplier_id"].'">'.$value["po_number"].'</option>';
                    }
				}
				echo $content;
			} else {
				echo 'failure';
			}
		} else {
			echo 'failure';
		}

    }



    public function getSupplierPonumberbySupplierid(){

        $supplier_name=$this->input->post('supplier_name');

        if($supplier_name) {
			$getSupplierdetails = $this->admin_model->getSupplierDeatilsbyid($supplier_name);
			if(count($getSupplierdetails) >= 1) {
                $content = $content.'<option value="">Select Supplier PO Number</option>';
				foreach($getSupplierdetails as $value) {
                        $content = $content.'<option value="'.$value["supplier_id"].'">'.$value["po_number"].'</option>';
				}
				echo $content;
			} else {
				echo 'failure';
			}
		} else {
			echo 'failure';
		}

    }

    public function getSupplierItemsforDisplay(){


        $post_submit = $this->input->post();

        if($post_submit){

            $supplier_po_number = $this->input->post('supplier_po_number');
        
            // load table library
            $this->load->library('table');
            
            // set heading
            //$this->table->set_heading('Part Number', 'Description', 'Order Qty','Unit', 'Rate','Value');
            $this->table->set_heading('Part Number', 'Description', 'Order Qty','Delivery date');

            // set template
            $style = array('table_open'  => '<p><b>Supplier PO Item</b></p><table style="width: 70% !important; max-width: 100%;margin-bottom: 20px;" class="table">');

            $this->table->set_template($style);

            //$this->db->select(TBL_RAWMATERIAL.'.part_number,'.TBL_SUPPLIER_PO_MASTER_ITEM.'.description,'.TBL_SUPPLIER_PO_MASTER_ITEM.'.order_oty,'.TBL_SUPPLIER_PO_MASTER_ITEM.'.unit,'.TBL_SUPPLIER_PO_MASTER_ITEM.'.rate,'.TBL_SUPPLIER_PO_MASTER_ITEM.'.value');
            $this->db->select(TBL_RAWMATERIAL.'.part_number,'.TBL_SUPPLIER_PO_MASTER_ITEM.'.description,'.TBL_SUPPLIER_PO_MASTER_ITEM.'.order_oty,'.TBL_BUYER_PO_MASTER.'.delivery_date');
            $this->db->join(TBL_RAWMATERIAL, TBL_RAWMATERIAL.'.raw_id = '.TBL_SUPPLIER_PO_MASTER_ITEM.'.part_number_id');
            $this->db->join(TBL_BUYER_PO_MASTER, TBL_BUYER_PO_MASTER.'.id = '.TBL_SUPPLIER_PO_MASTER_ITEM.'.pre_buyer_po_number');
            $this->db->where(TBL_SUPPLIER_PO_MASTER_ITEM.'.supplier_po_id',$supplier_po_number);
            $query_result = $this->db->get(TBL_SUPPLIER_PO_MASTER_ITEM);
            $data = $query_result->result_array();

            if($data){
                echo $this->table->generate($query_result);

            }else{
                echo '';

            }
    
       }
    }

    public function getSuppliritemonly(){

        $supplier_po_number=$this->input->post('supplier_po_number');

        $flag=$this->input->post('flag');
        if($supplier_po_number) {
			$getSupplieritemsonly = $this->admin_model->getSupplieritemsonly($supplier_po_number,$flag);
			if(count($getSupplieritemsonly) >= 1) {
                $content = $content.'<option value="">Select Part Number</option>';
				foreach($getSupplieritemsonly as $value) {
					$content = $content.'<option value="'.$value["item_id"].'" data_id="'.$value["supplier_po_item_id"].'">'.$value["part_number"].'</option>';
				}
				echo $content;
			} else {
				echo 'failure';
			}
		} else {
			echo 'failure';
		}

    }


    public function getSuppliritemonlyforgetbuyeritemonly(){

        $supplier_po_number=$this->input->post('supplier_po_number');

        $flag=$this->input->post('flag');

        if($supplier_po_number) {
			$getSupplieritemsonly = $this->admin_model->getSuppliritemonlyforgetbuyeritemonly($supplier_po_number,$flag);
			if(count($getSupplieritemsonly) >= 1) {
                $content = $content.'<option value="">Select Part Number</option>';
				foreach($getSupplieritemsonly as $value) {
					$content = $content.'<option value="'.$value["item_id"].'">'.$value["part_number"].'</option>';
				}
				echo $content;
			} else {
				echo 'failure';
			}
		} else {
			echo 'failure';
		}

    }


    public function deleteSupplierPoconfirmation(){

        $post_submit = $this->input->post();
        if($post_submit){
            $result = $this->admin_model->deleteSupplierPoconfirmation(trim($this->input->post('id')));
            if ($result) {
                        $process = 'Supplier PO Delete';
                        $processFunction = 'Admin/deleteSupplierPoconfirmation';
                        $this->logrecord($process,$processFunction);
                    echo(json_encode(array('status'=>'success')));
                }
            else { echo(json_encode(array('status'=>'failed'))); }
        }else{
            echo(json_encode(array('status'=>'failed'))); 
        }


    }

    public function viewSupplierpoconfirmation($supplierpoconfirmationid){

        $process = 'View Vendor PO';
        $processFunction = 'Admin/viewSupplierpo';
        $this->logrecord($process,$processFunction);
        $this->global['pageTitle'] = 'Vendor PO View';
        $data['supplierList']= $this->admin_model->fetchALLsupplierList();
        $data['buyerList']= $this->admin_model->fetchAllbuyerList();
        $data['vendorList']= $this->admin_model->fetchALLvendorList();
        $data['getSupplierpoconfirmationdetails']= $this->admin_model->getSupplierpoconfirmationdetails($supplierpoconfirmationid)[0];

        $data['fetchALLSupplierPOitemsforview']= $this->admin_model->fetchALLSupplierPOitemsforview($supplierpoconfirmationid);
        $this->loadViews("masters/viewSupplierpoconfirmation", $this->global, $data, NULL);

    }

    public function getRowmaterialPartnumberByid(){

        if($this->input->post('part_number')) {
            $getPartNameBypartid = $this->admin_model->getRowmaterialPartnumberByid($this->input->post('part_number'));

            if($getPartNameBypartid){
                $content = $getPartNameBypartid[0];
                echo json_encode($content);

            }else{
                echo 'failure';
            }
           
        } else {
            echo 'failure';
        }
    }

    public function addSupplierpoConfirmationitem(){
        $post_submit = $this->input->post();
        if($post_submit){
            $save_supplierpoconfirmationitem_response = array();

            $this->form_validation->set_rules('part_number','Part Number','trim|required');
            $this->form_validation->set_rules('description','Part Name','trim|required');
            $this->form_validation->set_rules('qty','Qty','trim|numeric|required');
            $this->form_validation->set_rules('rate','Rate','trim');
            $this->form_validation->set_rules('value','Value','trim');
            $this->form_validation->set_rules('sent_qty','Sent Qty','trim|required');
            $this->form_validation->set_rules('short_excess','Short Excess','trim|required');
            $this->form_validation->set_rules('sent_qty_pcs','Sent Qty PCS','trim');

            if($this->form_validation->run() == FALSE)
            {
                $save_supplierpoconfirmationitem_response['status'] = 'failure';
                $save_supplierpoconfirmationitem_response['error'] = array('part_number'=>strip_tags(form_error('part_number')), 'description'=>strip_tags(form_error('description')), 'qty'=>strip_tags(form_error('qty')), 'rate'=>strip_tags(form_error('rate')),'value'=>strip_tags(form_error('value')),'item_remark'=>strip_tags(form_error('item_remark')),'unit'=>strip_tags(form_error('unit')),'vendor_qty'=>strip_tags(form_error('vendor_qty')),'sent_qty'=>strip_tags(form_error('sent_qty')),'short_excess'=>strip_tags(form_error('short_excess')));
            }else{

                $supplierpoconfirmation_id = trim($this->input->post('supplierpoconfirmation_id'));
                if($supplierpoconfirmation_id){
                    $supplier_main_id = $supplierpoconfirmation_id;
                }else{
                    $supplier_main_id = NULL;
                }
                
                $data = array(
                    'supplier_po_confirmation_id' =>$supplier_main_id,
                    'part_number_id'   => trim($this->input->post('part_number')),
                    'description'     => trim($this->input->post('description')),
                    'order_oty'    => trim($this->input->post('qty')),
                    'rate'  =>       trim($this->input->post('rate')),
                    'value' =>   trim($this->input->post('value')),
                    'unit' =>    trim($this->input->post('unit')),
                    'vendor_qty'=>  trim($this->input->post('vendor_qty')),
                    'vendor_id'=>  trim($this->input->post('vendor_id')),
                    'item_remark' => trim($this->input->post('item_remark')),
                    'sent_qty'=>  trim($this->input->post('sent_qty')),
                    'short_excess' => trim($this->input->post('short_excess')),
                    'pre_date'		 => trim($this->input->post('pre_date')),
                    'pre_supplier_name'	 => trim($this->input->post('pre_supplier_name')),
                    'pre_supplier_po_number'	=> trim($this->input->post('pre_supplier_po_number')),
                    'pre_buyer_name'		 => trim($this->input->post('pre_buyer_name')),
                    'pre_buyer_po_number'		 => trim($this->input->post('pre_buyer_po_number')),
                    'pre_po_confirmed'	=> trim($this->input->post('pre_po_confirmed')),
                    'pre_confirmed_date'	=> trim($this->input->post('pre_confirmed_date')),
                    'pre_confirmed_with'	=> trim($this->input->post('pre_confirmed_with')),
                    'sent_qty_pcs'=> trim($this->input->post('sent_qty_pcs')),
                    'pre_remark'   => trim($this->input->post('pre_remark')),
                );

                // $checkIfexitsbuyerpo = $this->admin_model->checkIfexitsbuyerpo(trim($this->input->post('sales_order_number')));
                // if($checkIfexitsbuyerpo > 0){
                //     $save_buyerpo_response['status'] = 'failure';
                //     $save_buyerpo_response['error'] = array('sales_order_number'=>'Buyer PO Alreday Exits (Sales Order Number Alreday Exits)');
                // }else{

                    $supplier_confirmation_po_item_id = trim($this->input->post('supplier_confirmation_po_item_id'));
                    if( $supplier_confirmation_po_item_id){
                        $supplierconfirmationpoitemid = $supplier_confirmation_po_item_id;
                    }else{
                        $supplierconfirmationpoitemid = '';
                    }

                    $saveSupplierpoconfirmationitemdata = $this->admin_model->saveSupplierpoconfirmationitemdata($supplierconfirmationpoitemid,$data);
                    
                    if($saveSupplierpoconfirmationitemdata){
                        $save_supplierpoconfirmationitem_response['status'] = 'success';
                        $save_supplierpoconfirmationitem_response['error'] = array('part_number'=>'', 'description'=>'', 'qty'=>'', 'rate'=>'','value'=>'','sent_qty'=>'','short_excess'=>'');
                    }
                //  }
                
            }
            echo json_encode($save_supplierpoconfirmationitem_response);
        }

    }

    public function getVendorDetailsBysupplierponumber(){

        $supplier_po_number=$this->input->post('supplier_po_number');
        if($supplier_po_number) {
			$supplier_po_number = $this->admin_model->getVendorDetailsBysupplierponumber($supplier_po_number);
			if(count($supplier_po_number) >= 1) {
                //$content = $content.'<option value="">Select Vendor Name</option>';
				foreach($supplier_po_number as $value) {
					$content = $content.'<option value="'.$value["ven_id"].'">'.$value["vendor_name"].'</option>';
				}
				echo $content;
			} else {
				echo 'failure';
			}
		} else {
			echo 'failure';
		}

    }

    public function deleteSupplierpoconfirmationitem(){

        $post_submit = $this->input->post();
        if($post_submit){
            $result = $this->admin_model->deleteSupplierpoconfirmationitem(trim($this->input->post('id')));
            if ($result) {
                        $process = 'Supplier PO Confirmation Delete';
                        $processFunction = 'Admin/deleteSupplierpoconfirmationitem';
                        $this->logrecord($process,$processFunction);
                    echo(json_encode(array('status'=>'success')));
                }
            else { echo(json_encode(array('status'=>'failed'))); }
        }else{
            echo(json_encode(array('status'=>'failed'))); 
        }

    }


    public function vendorpoconfirmation(){
        $process = 'Vendor PO Confirmation';
        $processFunction = 'Admin/supplierpoconfirmation';
        $this->logrecord($process,$processFunction);
        $this->global['pageTitle'] = 'Vendor PO Confirmation';
        $this->loadViews("masters/vendorpoconfirmation", $this->global, $data, NULL);  
    }


    public function addVendorpoconfirmation(){
     
        $post_submit = $this->input->post();
        if($post_submit){

            $save_vendorconfirmation_response = array();

            $this->form_validation->set_rules('po_number','PO Number','trim|required');
            $this->form_validation->set_rules('date','Date','trim|required');
            $this->form_validation->set_rules('vendor_name','Vendor Name','trim|required');
            $this->form_validation->set_rules('vendor_po_number','Vendor PO Number','trim|required');
            $this->form_validation->set_rules('buyer_name','Buyer Name','trim|required');
            $this->form_validation->set_rules('po_confirmed','PO Confirmed','trim|required');
            $this->form_validation->set_rules('confirmed_date','Confirmed Date','trim|required');
            $this->form_validation->set_rules('confirmed_with','Confirmed With','trim|required');
            $this->form_validation->set_rules('remark','Remark','trim');


            if($this->form_validation->run() == FALSE)
            {
                $save_vendorconfirmation_response['status'] = 'failure';
                $save_vendorconfirmation_response['error'] = array( 'po_number'=>strip_tags(form_error('po_number')),'date'=>strip_tags(form_error('date')),'vendor_name'=>strip_tags(form_error('vendor_name')),'vendor_po_number'=>strip_tags(form_error('vendor_po_number')),'buyer_name'=>strip_tags(form_error('buyer_name')),'po_confirmed'=>strip_tags(form_error('po_confirmed')),'confirmed_date'=>strip_tags(form_error('confirmed_date')),'confirmed_with'=>strip_tags(form_error('confirmed_with')),'remark'=>strip_tags(form_error('remark')));
            }else{
                
                $venodr_po_confirmation_id = trim($this->input->post('venodr_po_confirmation_id'));



                $data = array(
                    'po_number'   => trim($this->input->post('po_number')),
                    'date'     => trim($this->input->post('date')),
                    'vendor_name'  => trim($this->input->post('vendor_name')),
                    'vendor_po_number' => trim($this->input->post('vendor_po_number')),
                    'buyer_name' =>    trim($this->input->post('buyer_name')),
                    'po_confirmed' =>    trim($this->input->post('po_confirmed')),
                    'confirmed_date' =>    trim($this->input->post('confirmed_date')),
                    'confirmed_with' =>    trim($this->input->post('confirmed_with')),
                    'remark' =>    trim($this->input->post('remark')),
                );

                // $checkIfexitsVendorpoconfirmation = $this->admin_model->checkIfexitsVendorpoconfirmation(trim($this->input->post('po_number')));
                // if($checkIfexitsVendorpoconfirmation > 0){
                //     $save_vendorconfirmation_response['status'] = 'failure';
                //     $save_vendorconfirmation_response['error'] = array( 'po_number'=>strip_tags(form_error('po_number')),'date'=>strip_tags(form_error('date')),'vendor_name'=>strip_tags(form_error('vendor_name')),'vendor_po_number'=>strip_tags(form_error('vendor_po_number')),'buyer_name'=>strip_tags(form_error('buyer_name')),'po_confirmed'=>strip_tags(form_error('po_confirmed')),'confirmed_date'=>strip_tags(form_error('confirmed_date')),'confirmed_with'=>strip_tags(form_error('confirmed_with')),'remark'=>strip_tags(form_error('remark')));
                // }else{

                    $saveVendorpoconfirmationdata = $this->admin_model->saveVendorpoconfirmationdata($venodr_po_confirmation_id,$data);
                    if($saveVendorpoconfirmationdata){

                        $update_last_inserted_id_vendor_po_confirmation = $this->admin_model->update_last_inserted_id_vendor_po_confirmation($saveVendorpoconfirmationdata);
                        if($update_last_inserted_id_vendor_po_confirmation){
                             $save_vendorconfirmation_response['status'] = 'success';
                             $save_vendorconfirmation_response['error'] = array( 'po_number'=>strip_tags(form_error('po_number')),'date'=>strip_tags(form_error('date')),'supplier_name'=>strip_tags(form_error('supplier_name')),'supplier_po_number'=>strip_tags(form_error('supplier_po_number')),'buyer_name'=>strip_tags(form_error('buyer_name')),'buyer_po_number'=>strip_tags(form_error('buyer_po_number')),'po_confirmed'=>strip_tags(form_error('po_confirmed')),'confirmed_date'=>strip_tags(form_error('confirmed_date')),'confirmed_with'=>strip_tags(form_error('confirmed_with')),'remark'=>strip_tags(form_error('remark')));
                         }
                    }

                //}
            }
            echo json_encode($save_vendorconfirmation_response);
        }else{
            $process = 'Add Vendor PO Confirmation';
            $processFunction = 'Admin/addVendorpoconfirmation';
            // $data['buyerList']= $this->admin_model->fetchAllbuyerList();
            // $data['supplierList']= $this->admin_model->fetchALLsupplierList();
            // $data['rowMaterialList']= $this->admin_model->fetchALLrowMaterialList();
            $data['getPreviousVendorPoconfirmationNumber']= $this->admin_model->getPreviousVendorPoconfirmationNumber()[0];
            $data['getPreviousSupplierPoconfirmationNumber']= $this->admin_model->getPreviousSupplierPoconfirmationNumber()[0];

            $data['fetchALLpreVendorpoconfirmationitemList']= $this->admin_model->fetchALLpreVendorpoconfirmationitemList();
            $data['vendorList']= $this->admin_model->fetchALLvendorList();
            $this->logrecord($process,$processFunction);
            $this->global['pageTitle'] = 'Add Vendor PO Confirmation';
            $this->loadViews("masters/addVendorpoconfirmation", $this->global, $data, NULL);
        }


    }


    public function fetchVendorrpoconfirmationlist(){

        $params = $_REQUEST;
        $totalRecords = $this->admin_model->getVendorpoconfirmationCount($params); 
        $queryRecords = $this->admin_model->getVendorpoconfirmationdata($params); 

        $data = array();
        foreach ($queryRecords as $key => $value)
        {
            $i = 0;
            foreach($value as $v)
            {
                $data[$key][$i] = $v;
                $i++;
            }
        }
        $json_data = array(
            "draw"            => intval( $params['draw'] ),   
            "recordsTotal"    => intval( $totalRecords ),  
            "recordsFiltered" => intval($totalRecords),
            "data"            => $data   // total data array
            );
        echo json_encode($json_data);

    }


    public function editvendorpoconfirmation($vendor_po_confirmation_id){

        $process = 'Edit Vendor PO Confirmation';
        $processFunction = 'Admin/editvendorpoconfirmation';
        $this->logrecord($process,$processFunction);
        $data['vendorList']= $this->admin_model->fetchALLvendorList();
        $data['buyerList']= $this->admin_model->fetchAllbuyerList();
        $data['venodr_po_confirmation_id']= $vendor_po_confirmation_id;
        $data['getVendorpoconfirmationdetails']= $this->admin_model->getVendorpoconfirmationdetails($vendor_po_confirmation_id);
        $data['fetchALLpreVendorpoconfirmationitemListedit']= $this->admin_model->fetchALLpreVendorpoconfirmationitemListedit($vendor_po_confirmation_id);
        $this->global['pageTitle'] = 'Edit Vendor PO Confirmation';
        $this->loadViews("masters/editvendorpoconfirmation", $this->global, $data, NULL);

    }



    public function getBuyerDetailsBysupplierponumber(){
        $supplier_po_number=$this->input->post('supplier_po_number');
        if($supplier_po_number) {
			$supplier_po_number = $this->admin_model->getBuyerDetailsBysupplierponumber($supplier_po_number);
			if(count($supplier_po_number) >= 1) {
                //$content = $content.'<option value="">Select Vendor Name</option>';
				foreach($supplier_po_number as $value) {
					$content = $content.'<option value="'.$value["buyer_id"].'">'.$value["buyer_name"].'</option>';
				}
				echo $content;
			} else {
				echo 'failure';
			}
		} else {
			echo 'failure';
		}

    }


    public function getVendorPonumberbySupplierid(){
        $vendor_name=$this->input->post('vendor_name');
        if($vendor_name) {
			$getVendordetails = $this->admin_model->getVendorPonumberbySupplierid($vendor_name);
			if(count($getVendordetails) >= 1) {
                $content = $content.'<option value="">Select Vendor PO Number</option>';
				foreach($getVendordetails as $value) {
					$content = $content.'<option value="'.$value["id"].'">'.$value["po_number"].'</option>';
				}
				echo $content;
			} else {
				echo 'failure';
			}
		} else {
			echo 'failure';
		}
    }


    public function getVendorPoconfirmationvendorlist(){
        $vendor_name=$this->input->post('vendor_name');
        if($vendor_name) {
			$getVendordetails = $this->admin_model->getVendorPoconfirmationvendorlist($vendor_name);
			if(count($getVendordetails) >= 1) {
                $content = $content.'<option value="">Select Vendor PO Number</option>';
				foreach($getVendordetails as $value) {
					$content = $content.'<option value="'.$value["id"].'">'.$value["po_number"].'</option>';
				}
				echo $content;
			} else {
				echo 'failure';
			}
		} else {
			echo 'failure';
		}
    }


    public function getVendorPonumberbySupplieridvendorbillofmaterial(){
        $vendor_name=$this->input->post('vendor_name');
        if($vendor_name) {
			$getVendordetails = $this->admin_model->getVendorPonumberbySupplieridvendorbillofmaterial($vendor_name);
			if(count($getVendordetails) >= 1) {
                $content = $content.'<option value="">Select Vendor PO Number</option>';
				foreach($getVendordetails as $value) {
					$content = $content.'<option value="'.$value["id"].'">'.$value["po_number"].'</option>';
				}
				echo $content;
			} else {
				echo 'failure';
			}
		} else {
			echo 'failure';
		}
    }


    public function getBuyerNamebySupplierid(){

        $vendor_name=$this->input->post('vendor_name');
        if($vendor_name) {
			$getVendordetails = $this->admin_model->getBuyerNamebySupplierid($vendor_name);
			if(count($getVendordetails) >= 1) {
                // $content = $content.'<option value="">Select Vendor PO Number</option>';
				foreach($getVendordetails as $value) {
					$content = $content.'<option value="'.$value["buyer_id"].'">'.$value["buyer_name"].'</option>';
				}
				echo $content;
			} else {
				echo 'failure';
			}
		} else {
			echo 'failure';
		}
    }


    public function getVendoritemonly(){

        $vendor_po_number=$this->input->post('vendor_po_number');
        if($vendor_po_number) {
			$getVendoritemsonly = $this->admin_model->getVendoritemsonly($vendor_po_number,$flag);
			if(count($getVendoritemsonly) >= 1) {
                $content = $content.'<option value="">Select Part Number</option>';
				foreach($getVendoritemsonly as $value) {
					$content = $content.'<option value="'.$value["fin_id"].'" data_id="'.$value["vendor_po_item_id"].'">'.$value["part_number"].'</option>';
				}
				echo $content;
			} else {
				echo 'failure';
			}
		} else {
			echo 'failure';
		}

    }

    public function getSuppliergoodsPartnumberByid(){


        $vendor_po_number=$this->input->post('vendor_po_number');
        $chekc_if_supplie_name = $this->admin_model->chekc_if_supplie_name_exits($vendor_po_number);

        // if($chekc_if_supplie_name['supplier_po_number']){
        //   $flag ='Vendor';
        // }else{
        //   $flag ='Supplier';
        // }

          if($chekc_if_supplie_name['supplier_po_number']){
            $flag ='Supplier';
          }else{
            $flag ='Vendor';
          }

          


        if($this->input->post('part_number')) {
            $getPartNameBypartid = $this->admin_model->getSuppliergoodsPartnumberByid($this->input->post('part_number'),$flag);

            if($getPartNameBypartid){
                $content = $getPartNameBypartid[0];
                echo json_encode($content);

            }else{
                echo 'failure';
            }
           
        } else {
            echo 'failure';
        }
    }


    public function getSuppliergoodsPartnumberByidvendorpoconfirmation(){


        $vendor_po_number=$this->input->post('vendor_po_number');
        $chekc_if_supplie_name = $this->admin_model->chekc_if_supplie_name_exits($vendor_po_number);

        // if($chekc_if_supplie_name['supplier_po_number']){
        //   $flag ='Vendor';
        // }else{
        //   $flag ='Supplier';
        // }

          if($chekc_if_supplie_name['supplier_po_number']){
            $flag ='Supplier';
          }else{
            $flag ='Vendor';
          }

        
        if($this->input->post('part_number')) {
            $getPartNameBypartid = $this->admin_model->getSuppliergoodsPartnumberByidvendorpoconfirmation($this->input->post('part_number'),$flag, $vendor_po_number,$this->input->post('poitemid'));

            if($getPartNameBypartid){
                $content = $getPartNameBypartid[0];
                echo json_encode($content);

            }else{
                echo 'failure';
            }
           
        } else {
            echo 'failure';
        }
    }



    public function saveVendorconfromationpoitem(){

        $post_submit = $this->input->post();
        if($post_submit){
            $save_buyerpoconfirmationitem_response = array();

            $this->form_validation->set_rules('part_number','Part Number','trim|required');
            $this->form_validation->set_rules('description','Part Name','trim|required');
            $this->form_validation->set_rules('vendor_qty','Vendor Qty','trim|numeric|required');
            $this->form_validation->set_rules('qty','Order Qty','trim|numeric|required');
            $this->form_validation->set_rules('rmqty','Row Material Received Quantity','trim|required');
            $this->form_validation->set_rules('finishedgoodqty','Finished Good Received Quantity','trim|required');
            $this->form_validation->set_rules('gross_weight','Gross Weight','trim|required');
            $this->form_validation->set_rules('expected_qty','Expected Qty','trim');
            $this->form_validation->set_rules('item_remark','Item Remark','trim');

            if($this->form_validation->run() == FALSE)
            {
                $save_buyerpoconfirmationitem_response['status'] = 'failure';
                $save_buyerpoconfirmationitem_response['error'] = array('part_number'=>strip_tags(form_error('part_number')), 'description'=>strip_tags(form_error('description')), 'qty'=>strip_tags(form_error('qty')), 'rate'=>strip_tags(form_error('rate')),'value'=>strip_tags(form_error('value')),'item_remark'=>strip_tags(form_error('item_remark')),'unit'=>strip_tags(form_error('unit')),'vendor_qty'=>strip_tags(form_error('vendor_qty')),'sent_qty'=>strip_tags(form_error('sent_qty')),'short_excess'=>strip_tags(form_error('short_excess')));
            }else{

            
                $saveVendorconfromationpoitem = trim($this->input->post('venodr_po_confirmation_id'));

                if($saveVendorconfromationpoitem){

                    $saveVendorconfromation_main_id = trim($this->input->post('venodr_po_confirmation_id'));
                }else{
                    $saveVendorconfromation_main_id = NULL;
                }

                $data = array(
                    'part_number_id'   => trim($this->input->post('part_number')),
                    'vendor_po_confirmation_id'  =>$saveVendorconfromation_main_id,
                    'description'     => trim($this->input->post('description')),
                    'vendor_qty'=> trim($this->input->post('vendor_qty')),
                    'order_qty'=> trim($this->input->post('qty')),
                    'row_material_recived_qty'=> trim($this->input->post('rmqty')),
                    'finished_good_recived_qty'=> trim($this->input->post('finishedgoodqty')),
                    'gross_weight'=> trim($this->input->post('gross_weight')),
                    'expected_qty'=> trim($this->input->post('expected_qty')),
                    'item_remark'=> trim($this->input->post('item_remark')),
                    'pre_date'=> trim($this->input->post('pre_date')),
                    'pre_vendor_name' => trim($this->input->post('pre_vendor_name')),
                    'pre_vendor_po_number' => trim($this->input->post('pre_vendor_po_number')),
                    'pre_buyer_name' => trim($this->input->post('pre_buyer_name')),
                    'pre_po_confirmed' => trim($this->input->post('pre_po_confirmed')),
                    'pre_confirmed_date' => trim($this->input->post('pre_confirmed_date')),
                    'pre_confirmed_with' => trim($this->input->post('pre_confirmed_with')),
                    'pre_remark' => trim($this->input->post('item_remark')),
                );

                // $checkIfexitsbuyerpo = $this->admin_model->checkIfexitsbuyerpo(trim($this->input->post('sales_order_number')));
                // if($checkIfexitsbuyerpo > 0){
                //     $save_buyerpo_response['status'] = 'failure';
                //     $save_buyerpo_response['error'] = array('sales_order_number'=>'Buyer PO Alreday Exits (Sales Order Number Alreday Exits)');
                // }else{

                    $vendor_po_confirmation_item_id = trim($this->input->post('vendor_po_confirmation_item_id'));
                    if( $vendor_po_confirmation_item_id){
                        $endor_po_confirmationid = $vendor_po_confirmation_item_id;
                    }else{
                        $endor_po_confirmationid = '';
                    }

                    $saveVendorpoconfirmationitemdata = $this->admin_model->saveVendorpoconfirmationitemdata($endor_po_confirmationid,$data);
                    
                    if($saveVendorpoconfirmationitemdata){
                        $save_buyerpoconfirmationitem_response['status'] = 'success';
                        $save_buyerpoconfirmationitem_response['error'] = array('part_number'=>'', 'description'=>'', 'qty'=>'', 'rate'=>'','value'=>'','sent_qty'=>'','short_excess'=>'');
                    }
                //  }
                
            }
            echo json_encode($save_buyerpoconfirmationitem_response);
        }


    }

    public function deleteVendorpoconfirmatuionitem(){

        $post_submit = $this->input->post();
        if($post_submit){
            $result = $this->admin_model->deleteVendorpoconfirmatuionitem(trim($this->input->post('id')));
            if ($result) {
                        $process = 'Vendor PO Confirmation Delete';
                        $processFunction = 'Admin/deleteVendorpoconfirmatuionitem';
                        $this->logrecord($process,$processFunction);
                    echo(json_encode(array('status'=>'success')));
                }
            else { echo(json_encode(array('status'=>'failed'))); }
        }else{
            echo(json_encode(array('status'=>'failed'))); 
        }

    }

    public function deleteVendorPoconfirmation(){

        $post_submit = $this->input->post();
        if($post_submit){
            $result = $this->admin_model->deleteVendorPoconfirmation(trim($this->input->post('id')));
            if ($result) {
                        $process = 'Vendor PO Confirmation Delete';
                        $processFunction = 'Admin/deleteVendorpoitem';
                        $this->logrecord($process,$processFunction);
                    echo(json_encode(array('status'=>'success')));
                }
            else { echo(json_encode(array('status'=>'failed'))); }
        }else{
            echo(json_encode(array('status'=>'failed'))); 
        }

    }

    public function jobWork(){

        $process = 'Job Work';
        $processFunction = 'Admin/jobWork';
        $this->logrecord($process,$processFunction);
        $this->global['pageTitle'] = 'Job Work';
        $this->loadViews("masters/jobWork", $this->global, $data, NULL);  
    }

    public function fetchJobworklist(){

        $params = $_REQUEST;
        $totalRecords = $this->admin_model->getJobworkCount($params); 
        $queryRecords = $this->admin_model->getJobworkdata($params); 

        $data = array();
        foreach ($queryRecords as $key => $value)
        {
            $i = 0;
            foreach($value as $v)
            {
                $data[$key][$i] = $v;
                $i++;
            }
        }
        $json_data = array(
            "draw"            => intval( $params['draw'] ),   
            "recordsTotal"    => intval( $totalRecords ),  
            "recordsFiltered" => intval($totalRecords),
            "data"            => $data   // total data array
            );
        echo json_encode($json_data);

    }
    
    public function addjobwork(){

        $post_submit = $this->input->post();
        if($post_submit){

            $save_jobwork_response = array();
            $this->form_validation->set_rules('job_work_no','PO Number','trim|required');
            $this->form_validation->set_rules('date','Date','trim|required');
            $this->form_validation->set_rules('vendor_name','Vendor Name','trim|required');
            $this->form_validation->set_rules('vendor_po_number','Vendor PO  Number','trim|required');
            $this->form_validation->set_rules('raw_material_supplier_name','Raw Material Supplier Name','trim|required');
            $this->form_validation->set_rules('remark','Remark','trim');

            if($this->form_validation->run() == FALSE)
            {
                $save_jobwork_response['status'] = 'failure';
                $save_jobwork_response['error'] = array( 'job_work_no'=>strip_tags(form_error('job_work_no')),'date'=>strip_tags(form_error('date')),'vendor_name'=>strip_tags(form_error('vendor_name')),'raw_material_supplier_name'=>strip_tags(form_error('raw_material_supplier_name')),'remark'=>strip_tags(form_error('remark')));
           
            }else{

                $job_work_id = trim($this->input->post('job_work_id'));

                    if($job_work_id){

                        $data = array(
                            'po_number'   => trim($this->input->post('job_work_no')),
                            'date'     => trim($this->input->post('date')),
                            'vendor_name'  => trim($this->input->post('vendor_name')),
                            'vendor_po_number'=> trim($this->input->post('vendor_po_number')),
                            'raw_material_supplier' =>    trim($this->input->post('raw_material_supplier_name')),
                            'remark' =>    trim($this->input->post('remark')),
                        );

                            $saveJobworkdata = $this->admin_model->saveJobworkdata($job_work_id,$data);
                        
                            if($saveJobworkdata){
                                $update_last_inserted_id_job_work = $this->admin_model->update_last_inserted_id_job_work($saveJobworkdata);
                                if($update_last_inserted_id_job_work){
                                    $save_jobwork_response['status'] = 'success';
                                    $save_jobwork_response['error'] = array('job_work_no'=>strip_tags(form_error('job_work_no')),'date'=>strip_tags(form_error('date')),'vendor_name'=>strip_tags(form_error('vendor_name')),'vendor_po_number'=>strip_tags(form_error('vendor_po_number')),'raw_material_supplier_name'=>strip_tags(form_error('raw_material_supplier_name')),'remark'=>strip_tags(form_error('remark')));
                                }
                            }

                    }else{

                
                        $data = array(
                            'po_number'   => trim($this->input->post('job_work_no')),
                            'date'     => trim($this->input->post('date')),
                            'vendor_name'  => trim($this->input->post('vendor_name')),
                            'vendor_po_number'=> trim($this->input->post('vendor_po_number')),
                            'raw_material_supplier' =>    trim($this->input->post('raw_material_supplier_name')),
                            'remark' =>    trim($this->input->post('remark')),
                        );

                        $checkIfexitsJobwork = $this->admin_model->checkIfexitsJobwork(trim($this->input->post('po_number')));
                        if($checkIfexitsJobwork > 0){
                            $save_jobwork_response['status'] = 'failure';
                            $save_jobwork_response['error'] = array( 'job_work_no'=>strip_tags(form_error('job_work_no')),'date'=>strip_tags(form_error('date')),'vendor_name'=>strip_tags(form_error('vendor_name')),'vendor_po_number'=>strip_tags(form_error('vendor_po_number')),'raw_material_supplier_name'=>strip_tags(form_error('raw_material_supplier_name')),'remark'=>strip_tags(form_error('remark')));
                        }else{
                            $saveJobworkdata = $this->admin_model->saveJobworkdata('',$data);
                        
                            if($saveJobworkdata){
                                $update_last_inserted_id_job_work = $this->admin_model->update_last_inserted_id_job_work($saveJobworkdata);
                                if($update_last_inserted_id_job_work){
                                    $save_jobwork_response['status'] = 'success';
                                    $save_jobwork_response['error'] = array('job_work_no'=>strip_tags(form_error('job_work_no')),'date'=>strip_tags(form_error('date')),'vendor_name'=>strip_tags(form_error('vendor_name')),'vendor_po_number'=>strip_tags(form_error('vendor_po_number')),'raw_material_supplier_name'=>strip_tags(form_error('raw_material_supplier_name')),'remark'=>strip_tags(form_error('remark')));
                                }
                            }

                        }
                    }
            }

           echo json_encode($save_jobwork_response);
        }else{

            $process = 'Add Job Work';
            $processFunction = 'Admin/addjobwork';
            $this->logrecord($process,$processFunction);
            $this->global['pageTitle'] = 'Add Job Work';
            $data['getPreviousjobworkponumber']= $this->admin_model->getPreviousjobworkponumber()[0];
            $data['fetchALLprejobworkitemList']= $this->admin_model->fetchALLprejobworkitemList();
            $data['vendorList']= $this->admin_model->fetchALLvendorList();
            $this->loadViews("masters/addjobwork", $this->global, $data, NULL);

        }


    }

    public function getSuppliernamebyvendorpo(){

        $vendor_po_number=$this->input->post('vendor_po_number');
        if($vendor_po_number) {
			$getSupplierdetails = $this->admin_model->getSuppliernamebyvendorpo($vendor_po_number);
			if(count($getSupplierdetails) >= 1) {
                //$content = $content.'<option value="">Select Raw Material Supplier Name</option>';
				foreach($getSupplierdetails as $value) {
					$content = $content.'<option value="'.$value["sup_id"].'">'.$value["supplier_name"].'</option>';
				}
				echo $content;
			} else {
				echo 'failure';
			}
		} else {
			echo 'failure';
		}

    }

    public function getSuppliergoodsPartnumberByidjobwork(){

        if($this->input->post('part_number')) {
            $getPartNameBypartid = $this->admin_model->getSuppliergoodsPartnumberByidjobwork($this->input->post('part_number'),$this->input->post('vendor_po_number'),$this->input->post('raw_material_supplier_name'));
            if($getPartNameBypartid){
                $content = $getPartNameBypartid[0];
                echo json_encode($content);

            }else{
                echo 'failure';
            }
           
        } else {
            echo 'failure';
        }
    }

    public function saveJobworktem(){

        $post_submit = $this->input->post();
        if($post_submit){
            $save_jobwork_response = array();

            $this->form_validation->set_rules('part_number','Part Number','trim|required');
            $this->form_validation->set_rules('description','Part Name','trim|required');
            $this->form_validation->set_rules('rm_actual_aty','RM Actual Qty','trim|required');
            $this->form_validation->set_rules('vendor_order_qty','Vendor Order Qty','trim|required');
            $this->form_validation->set_rules('unit','Unit','trim|required');
            $this->form_validation->set_rules('rm_rate','Part Name','trim|required');
            $this->form_validation->set_rules('value','value','trim|required');
            $this->form_validation->set_rules('packing_and_forwarding','Packing And Forwarding','trim|required');
            $this->form_validation->set_rules('total','Total','trim|required');
            $this->form_validation->set_rules('gst','GST','trim|required');
            $this->form_validation->set_rules('gst_rate','GST rate','trim|required');
            $this->form_validation->set_rules('grand_total','Grand Total','trim|required');
            //$this->form_validation->set_rules('item_remark ','Item Remark','trim|required');
    
            if($this->form_validation->run() == FALSE)
            {
                $save_jobwork_response['status'] = 'failure';
                $save_jobwork_response['error'] = array(
                    'part_number'=>strip_tags(form_error('part_number')),'description'=>strip_tags(form_error('description')),'rm_actual_aty'=>strip_tags(form_error('rm_actual_aty')),'vendor_order_qty'=>strip_tags(form_error('vendor_order_qty')),'unit'=>strip_tags(form_error('unit')),'rm_rate'=>strip_tags(form_error('rm_rate')),'value'=>strip_tags(form_error('value')),'packing_and_forwarding'=>strip_tags(form_error('packing_and_forwarding')),'total'=>strip_tags(form_error('total')),'gst'=>strip_tags(form_error('gst')),'grand_total'=>strip_tags(form_error('grand_total')),'gst_rate'=>strip_tags(form_error('gst_rate')));
            }else{


               $job_work_id = trim($this->input->post('job_work_id'));

               if($job_work_id){

                    $data = array(
                        'part_number_id' => trim($this->input->post('part_number')),
                        'description'	=>	trim($this->input->post('description')),
                        'jobwork_id'	=>	$job_work_id,
                        'rm_actual_qty'	=>  trim($this->input->post('rm_actual_aty')),
                        'vendor_qty'	=>  trim($this->input->post('vendor_order_qty')),
                        'ram_rate'=>       trim($this->input->post('rm_rate')),
                        'unit'=>           trim($this->input->post('unit')),
                        'value'	=>        trim($this->input->post('value')),
                        'packing_forwarding'	=>trim($this->input->post('packing_and_forwarding')),
                        'total'	=>trim($this->input->post('total')),
                        'gst'	=>trim($this->input->post('gst')),
                        'gst_rate' => trim($this->input->post('gst_rate')),
                        'grand_total'	=>trim($this->input->post('grand_total')),
                        'item_remark' =>trim($this->input->post('item_remark')),
                        'pre_date'=> trim($this->input->post('pre_date')),
                        'pre_vendor_name' => trim($this->input->post('pre_vendor_name')),
                        'pre_vendor_po_number' => trim($this->input->post('pre_vendor_po_number')),
                        'pre_raw_material_supplier_name' => trim($this->input->post('pre_raw_material_supplier_name')),
                        'pre_remark' => trim($this->input->post('pre_remark')),
                    );

               }else{

                $data = array(
                    'part_number_id' => trim($this->input->post('part_number')),
                    'description'	=>	trim($this->input->post('description')),
                    'rm_actual_qty'	=>  trim($this->input->post('rm_actual_aty')),
                    'vendor_qty'	=>  trim($this->input->post('vendor_order_qty')),
                    'ram_rate'=>       trim($this->input->post('rm_rate')),
                    'unit'=>           trim($this->input->post('unit')),
                    'value'	=>        trim($this->input->post('value')),
                    'packing_forwarding'	=>trim($this->input->post('packing_and_forwarding')),
                    'total'	=>trim($this->input->post('total')),
                    'gst'	=>trim($this->input->post('gst')),
                    'gst_rate' => trim($this->input->post('gst_rate')),
                    'grand_total'	=>trim($this->input->post('grand_total')),
                    'item_remark' =>trim($this->input->post('item_remark')),
                    'pre_date'=> trim($this->input->post('pre_date')),
                    'pre_vendor_name' => trim($this->input->post('pre_vendor_name')),
                    'pre_vendor_po_number' => trim($this->input->post('pre_vendor_po_number')),
                    'pre_raw_material_supplier_name' => trim($this->input->post('pre_raw_material_supplier_name')),
                    'pre_remark' => trim($this->input->post('pre_remark')),
                );


               }


               $jobwork_item_id = trim($this->input->post('jobwork_item_id'));
               if( $jobwork_item_id){
                   $jobworkitemid = $jobwork_item_id;
               }else{
                   $jobworkitemid = '';
               }
               

                // $checkIfexitsbuyerpo = $this->admin_model->checkIfexitsbuyerpo(trim($this->input->post('sales_order_number')));
                // if($checkIfexitsbuyerpo > 0){
                //     $save_buyerpo_response['status'] = 'failure';
                //     $save_buyerpo_response['error'] = array('sales_order_number'=>'Buyer PO Alreday Exits (Sales Order Number Alreday Exits)');
                // }else{
                    $saveJobworkitemdata = $this->admin_model->saveJobworkitemdata($jobworkitemid,$data);

                    if($saveJobworkitemdata){

                        $save_jobwork_response['status'] = 'success';
                        $save_jobwork_response['error'] = array('part_number'=>strip_tags(form_error('part_number')),'description'=>strip_tags(form_error('description')),'rm_actual_aty'=>strip_tags(form_error('rm_actual_aty')),'vendor_order_qty'=>strip_tags(form_error('vendor_order_qty')),'unit'=>strip_tags(form_error('unit')),'rm_rate'=>strip_tags(form_error('rm_rate')),'value'=>strip_tags(form_error('value')),'packing_and_forwarding'=>strip_tags(form_error('packing_and_forwarding')),'total'=>strip_tags(form_error('total')),'gst'=>strip_tags(form_error('gst')),'grand_total'=>strip_tags(form_error('grand_total')));
                    }
                //  }
                
            }
            echo json_encode($save_jobwork_response);
        }
    }

    public function deleteJobwork(){
        $post_submit = $this->input->post();
        if($post_submit){
            $result = $this->admin_model->deleteJobwork(trim($this->input->post('id')));
            if ($result) {
                        $process = 'Job Work Delete';
                        $processFunction = 'Admin/deleteJobwork';
                        $this->logrecord($process,$processFunction);
                    echo(json_encode(array('status'=>'success')));
                }
            else { echo(json_encode(array('status'=>'failed'))); }
        }else{
            echo(json_encode(array('status'=>'failed'))); 
        }

    }

    public function deletejobworkitem(){
        $post_submit = $this->input->post();
        if($post_submit){
            $result = $this->admin_model->deletejobworkitem(trim($this->input->post('id')));
            if ($result) {
                        $process = 'Job Work Delete Item';
                        $processFunction = 'Admin/deletejobworkitem';
                        $this->logrecord($process,$processFunction);
                    echo(json_encode(array('status'=>'success')));
                }
            else { echo(json_encode(array('status'=>'failed'))); }
        }else{
            echo(json_encode(array('status'=>'failed'))); 
        }

    }

    public function billofmaterial(){

        $process = 'Bill of Material';
        $processFunction = 'Admin/jobWork';
        $this->logrecord($process,$processFunction);
        $this->global['pageTitle'] = 'Bill of Material';
        $this->loadViews("masters/billofmaterial", $this->global, $data, NULL);  

    }

    public function fetchBillofmaterial(){

        $params = $_REQUEST;
        $totalRecords = $this->admin_model->getBillofmaterialCount($params); 
        $queryRecords = $this->admin_model->getBillofmaterialdata($params); 

        $data = array();
        foreach ($queryRecords as $key => $value)
        {
            $i = 0;
            foreach($value as $v)
            {
                $data[$key][$i] = $v;
                $i++;
            }
        }
        $json_data = array(
            "draw"            => intval( $params['draw'] ),   
            "recordsTotal"    => intval( $totalRecords ),  
            "recordsFiltered" => intval($totalRecords),
            "data"            => $data   // total data array
            );
        echo json_encode($json_data);
    }

    public function addnewBillofmaterial(){

        $post_submit = $this->input->post();
        if($post_submit){
            $save_Billofmaterial_response = array();
            $this->form_validation->set_rules('bom_number','PO Number','trim|required');
            $this->form_validation->set_rules('date','Date','trim|required');
            $this->form_validation->set_rules('vendor_name','Vendor Name','trim|required');
            $this->form_validation->set_rules('vendor_po_number','Vendor PO  Number','trim|required');
            $this->form_validation->set_rules('supplier_name','Supplier Name','trim');
            $this->form_validation->set_rules('supplier_po_number','Supplier PO  Number','trim');
            $this->form_validation->set_rules('supplier_po_date','Supplier PO Date','trim');
            $this->form_validation->set_rules('buyer_name','Buyer_name','trim|required');
            $this->form_validation->set_rules('buyer_po_number','Buyer PO Number','trim|required');
            $this->form_validation->set_rules('buyer_po_date','Buyer PO Date','trim|required');
            $this->form_validation->set_rules('buyer_delivery_date','Buyer Delivery Date','trim|required');
            $this->form_validation->set_rules('bom_status','BOM Status','trim|required');
            $this->form_validation->set_rules('incoming_details','Incoming Details','trim');
            $this->form_validation->set_rules('remark','Remark','trim');



            if($this->form_validation->run() == FALSE)
            {
                $save_Billofmaterial_response['status'] = 'failure';
                $save_Billofmaterial_response['error'] = array( 'bom_number'=>strip_tags(form_error('bom_number')),
                                                                'date'=>strip_tags(form_error('date')),
                                                                'vendor_name'=>strip_tags(form_error('vendor_name')),
                                                                'vendor_po_number'=>strip_tags(form_error('vendor_po_number')),
                                                                'supplier_name'=>strip_tags(form_error('supplier_name')),
                                                                'supplier_po_number'=>strip_tags(form_error('supplier_po_number')),
                                                                'supplier_po_date'=>strip_tags(form_error('supplier_po_date')),
                                                                'buyer_name'=>strip_tags(form_error('buyer_name')),
                                                                'buyer_po_number'=>strip_tags(form_error('buyer_po_number')),
                                                                'buyer_po_date'=>strip_tags(form_error('buyer_po_date')),
                                                                'buyer_delivery_date'=>strip_tags(form_error('buyer_delivery_date')),
                                                                'buyer_delivery_date'=>strip_tags(form_error('buyer_delivery_date')),
                                                                'incoming_details'=>strip_tags(form_error('incoming_details')),
                                                                'bom_status'=>strip_tags(form_error('bom_status')),
                                                                'remark'=>strip_tags(form_error('remark')));
           
            }else{


                $data = array(
                    'bom_number'   => trim($this->input->post('bom_number')),
                    'date'     => trim($this->input->post('date')),
                    'vendor_name'  => trim($this->input->post('vendor_name')),
                    'vendor_po_number'=> trim($this->input->post('vendor_po_number')),
                    'supplier_name'=> trim($this->input->post('supplier_name')),
                    'supplier_po_number'=> trim($this->input->post('supplier_po_number')),
                    'supplier_po_date'=>trim($this->input->post('supplier_po_date')),
                    'buyer_name' =>    trim($this->input->post('buyer_name')),
                    'buyer_po_number' =>    trim($this->input->post('buyer_po_number')),
                    'buyer_po_date' =>    trim($this->input->post('buyer_po_date')),
                    'buyer_delivery_date' =>    trim($this->input->post('buyer_delivery_date')),
                    'bom_status' =>    trim($this->input->post('bom_status')),
                    'incoming_details'=>   trim($this->input->post('incoming_details')),
                    'remark' =>    trim($this->input->post('remark')),
                );

                // $checkIfexitsBillofmaterial = $this->admin_model->checkIfexitsBillofmaterial(trim($this->input->post('bom_number')));
                // if($checkIfexitsBillofmaterial > 0){

                   
                        $save_Billofmaterial_response['status'] = 'failure';
                        $save_Billofmaterial_response['error'] = array( 'bom_number'=>strip_tags(form_error('bom_number')),
                        'date'=>strip_tags(form_error('date')),
                        'vendor_name'=>strip_tags(form_error('vendor_name')),
                        'vendor_po_number'=>strip_tags(form_error('vendor_po_number')),
                        'supplier_name'=>strip_tags(form_error('supplier_name')),
                        'supplier_po_number'=>strip_tags(form_error('supplier_po_number')),
                        'supplier_po_date'=>strip_tags(form_error('supplier_po_date')),
                        'buyer_name'=>strip_tags(form_error('buyer_name')),
                        'buyer_po_number'=>strip_tags(form_error('buyer_po_number')),
                        'buyer_po_date'=>strip_tags(form_error('buyer_po_date')),
                        'buyer_delivery_date'=>strip_tags(form_error('buyer_delivery_date')),
                        'buyer_delivery_date'=>strip_tags(form_error('buyer_delivery_date')),
                        'incoming_details'=>strip_tags(form_error('incoming_details')),
                        'bom_status'=>strip_tags(form_error('bom_status')),
                        'remark'=>strip_tags(form_error('remark')));
                // }else{

                    $saveBillofmaterial = $this->admin_model->saveBillofmaterial(trim($this->input->post('bom_id_edit')),$data);

                  

                    if($saveBillofmaterial){
                        $update_last_inserted_Bill_of_material = $this->admin_model->update_last_inserted_Bill_of_material($saveBillofmaterial);
                         if($update_last_inserted_Bill_of_material){
                                $save_Billofmaterial_response['status'] = 'success';
                                $save_Billofmaterial_response['error'] = array( 'bom_number'=>strip_tags(form_error('bom_number')),
                                'date'=>strip_tags(form_error('date')),
                                'vendor_name'=>strip_tags(form_error('vendor_name')),
                                'vendor_po_number'=>strip_tags(form_error('vendor_po_number')),
                                'supplier_name'=>strip_tags(form_error('supplier_name')),
                                'supplier_po_number'=>strip_tags(form_error('supplier_po_number')),
                                'supplier_po_date'=>strip_tags(form_error('supplier_po_date')),
                                'buyer_name'=>strip_tags(form_error('buyer_name')),
                                'buyer_po_number'=>strip_tags(form_error('buyer_po_number')),
                                'buyer_po_date'=>strip_tags(form_error('buyer_po_date')),
                                'buyer_delivery_date'=>strip_tags(form_error('buyer_delivery_date')),
                                'buyer_delivery_date'=>strip_tags(form_error('buyer_delivery_date')),
                                'incoming_details'=>strip_tags(form_error('incoming_details')),
                                'bom_status'=>strip_tags(form_error('bom_status')),
                                'remark'=>strip_tags(form_error('remark')));
                         }
                    }

                //}

            }

            echo json_encode($save_Billofmaterial_response);

        }else{

            $process = 'Add New Bill Of Material';
            $processFunction = 'Admin/addjobwork';
            $this->logrecord($process,$processFunction);
            $this->global['pageTitle'] = 'Add New Bill Of Material';
            $data['getPreviousBomnumber']= $this->admin_model->getPreviousBomnumber()[0];
            $data['getPreviousvendorBomnumber']= $this->admin_model->getPreviousBomnumbervendor()[0];
            $data['fetchALLpreBillofmaterailist']= $this->admin_model->fetchALLpreBillofmaterailist();
            $data['buyerList']= $this->admin_model->fetchAllbuyerList();
            $data['vendorList']= $this->admin_model->fetchALLvendorListwithsupplier();
            $data['incoming_details']= $this->admin_model->fetchAllincomingdetailsList();
            $this->loadViews("masters/addnewBillofmaterial", $this->global, $data, NULL);

        }

    }

    public function editbillofmaterial($billofmaterialid){

        $process = 'Edit Bill Of Material';
        $processFunction = 'Admin/editbillofmaterial';
        $this->logrecord($process,$processFunction);
        $this->global['pageTitle'] = 'Edit Bill Of Material';
        $data['vendorList']= $this->admin_model->fetchALLvendorListwithsupplier();
        $data['buyerList']= $this->admin_model->fetchAllbuyerList();
        $data['getbillofmaterialdataforedit']= $this->admin_model->getbillofmaterialdataforedit($billofmaterialid);
        $data['fetchALLpreBillofmaterailistedit']= $this->admin_model->fetchALLpreBillofmaterailistedit($billofmaterialid);
        $data['incoming_details']= $this->admin_model->fetchAllincomingdetailsList();
        $data['billofmaterialid']= $billofmaterialid;
        $this->loadViews("masters/editbillofmaterial", $this->global, $data, NULL);

    }

    public function deleteBillofmaterial(){
        $post_submit = $this->input->post();
        if($post_submit){
            $result = $this->admin_model->deleteBillofmaterial(trim($this->input->post('id')));
            if ($result) {
                        $process = 'Bill Of Material Work Delete';
                        $processFunction = 'Admin/deleteBillofmaterial';
                        $this->logrecord($process,$processFunction);
                    echo(json_encode(array('status'=>'success')));
                }
            else { echo(json_encode(array('status'=>'failed'))); }
        }else{
            echo(json_encode(array('status'=>'failed'))); 
        }

    }

    public function vendorbillofmaterial(){
        $process = 'Vendor Bill of Material';
        $processFunction = 'Admin/jobWork';
        $this->logrecord($process,$processFunction);
        $this->global['pageTitle'] = 'Vendor Bill of Material';
        $this->loadViews("masters/vendorbillofmaterial", $this->global, $data, NULL);  
    }

    public function fetchvendorBillofmaterial(){

        $params = $_REQUEST;
        $totalRecords = $this->admin_model->getvendorBillofmaterialCount($params); 
        $queryRecords = $this->admin_model->getvendorBillofmaterialdata($params); 

        $data = array();
        foreach ($queryRecords as $key => $value)
        {
            $i = 0;
            foreach($value as $v)
            {
                $data[$key][$i] = $v;
                $i++;
            }
        }
        $json_data = array(
            "draw"            => intval( $params['draw'] ),   
            "recordsTotal"    => intval( $totalRecords ),  
            "recordsFiltered" => intval($totalRecords),
            "data"            => $data   // total data array
            );
        echo json_encode($json_data);

    }

    public function addvendorBillofmaterial(){

        $post_submit = $this->input->post();
        if($post_submit){;

            $save_vendorBillofmaterial_response = array();
            
            $this->form_validation->set_rules('bom_number','PO Number','trim|required');
            $this->form_validation->set_rules('date','Date','trim|required');
            $this->form_validation->set_rules('vendor_name','Vendor Name','trim|required');
            $this->form_validation->set_rules('vendor_po_number','Vendor PO  Number','trim|required');
            $this->form_validation->set_rules('buyer_name','Buyer Name','trim|required');
            $this->form_validation->set_rules('buyer_po_number','Buyer PO Number','trim|required');
            $this->form_validation->set_rules('buyer_po_date','Buyer PO Date','trim|required');
            $this->form_validation->set_rules('buyer_delivery_date','Buyer Delivery Date','trim|required');
            $this->form_validation->set_rules('bom_status','Bom Status','trim|required');


            $this->form_validation->set_rules('remark','Remark','trim');

            if($this->form_validation->run() == FALSE)
            {
                $save_vendorBillofmaterial_response['status'] = 'failure';
                $save_vendorBillofmaterial_response['error'] = array( 'bom_number'=>strip_tags(form_error('bom_number')),'date'=>strip_tags(form_error('date')),'vendor_name'=>strip_tags(form_error('vendor_name')),'vendor_po_number'=>strip_tags(form_error('vendor_po_number')),'bom_status'=>strip_tags(form_error('bom_status')),'remark'=>strip_tags(form_error('remark')), 'buyer_name'=>strip_tags(form_error('buyer_name')),'buyer_po_number'=>strip_tags(form_error('buyer_po_number')),'buyer_po_date'=>strip_tags(form_error('buyer_po_date')),'buyer_delivery_date'=>strip_tags(form_error('buyer_delivery_date')),'bom_status'=>strip_tags(form_error('bom_status')));
           
            }else{

                $data = array(
                    'bom_number'   => trim($this->input->post('bom_number')),
                    'date'     => trim($this->input->post('date')),
                    'vendor_name'  => trim($this->input->post('vendor_name')),
                    'vendor_po_number'=> trim($this->input->post('vendor_po_number')),
                    'buyer_name'=> trim($this->input->post('buyer_name')),
                    'buyer_po_number'=> trim($this->input->post('buyer_po_number')),
                    'buyer_po_date'=> trim($this->input->post('buyer_po_date')),
                    'buyer_delivery_date'=> trim($this->input->post('buyer_delivery_date')),
                    'bom_status' =>    trim($this->input->post('bom_status')),
                    'incoming_details' =>    trim($this->input->post('incoming_details')),
                    'remark' =>    trim($this->input->post('remark')),
                );

                // $checkIfexitsvendorBillofmaterial = $this->admin_model->checkIfexitsvendorBillofmaterial(trim($this->input->post('bom_number')));
                // if($checkIfexitsvendorBillofmaterial > 0){
                //     $save_vendorBillofmaterial_response['status'] = 'failure';
                //     $save_vendorBillofmaterial_response['error'] = array( 'bom_number'=>strip_tags(form_error('bom_number')),'date'=>strip_tags(form_error('date')),'vendor_name'=>strip_tags(form_error('vendor_name')),'vendor_po_number'=>strip_tags(form_error('vendor_po_number')),'bom_status'=>strip_tags(form_error('bom_status')),'remark'=>strip_tags(form_error('remark')), 'buyer_name'=>strip_tags(form_error('buyer_name')),'buyer_po_number'=>strip_tags(form_error('buyer_po_number')),'buyer_po_date'=>strip_tags(form_error('buyer_po_date')),'buyer_delivery_date'=>strip_tags(form_error('buyer_delivery_date')),'bom_status'=>strip_tags(form_error('bom_status')));
                // }else{

                    $savevendorBillofmaterial = $this->admin_model->savevendorBillofmaterial(trim($this->input->post('editvbmid')),$data);

                    if($savevendorBillofmaterial){
                        $update_last_inserted_id_vendor_bill_of_materil= $this->admin_model->update_last_inserted_id_vendor_bill_of_materil($savevendorBillofmaterial);
                        if($update_last_inserted_id_vendor_bill_of_materil){
                             $save_vendorBillofmaterial_response['status'] = 'success';
                             $save_vendorBillofmaterial_response['error'] = array( 'bom_number'=>strip_tags(form_error('bom_number')),'date'=>strip_tags(form_error('date')),'vendor_name'=>strip_tags(form_error('vendor_name')),'vendor_po_number'=>strip_tags(form_error('vendor_po_number')),'bom_status'=>strip_tags(form_error('bom_status')),'remark'=>strip_tags(form_error('remark')), 'buyer_name'=>strip_tags(form_error('buyer_name')),'buyer_po_number'=>strip_tags(form_error('buyer_po_number')),'buyer_po_date'=>strip_tags(form_error('buyer_po_date')),'buyer_delivery_date'=>strip_tags(form_error('buyer_delivery_date')),'bom_status'=>strip_tags(form_error('bom_status')));
                        }
                    }

                //}
            }

            echo json_encode($save_vendorBillofmaterial_response);
        }else{

            $process = 'Add New Vendor Bill Of Material';
            $processFunction = 'Admin/addjobwork';
            $this->logrecord($process,$processFunction);
            $this->global['pageTitle'] = 'Add New Vendor Bill Of Material';
            $data['getPreviousBomnumber']= $this->admin_model->getPreviousBomnumber()[0];
            $data['getPreviousBomnumbervendor']= $this->admin_model->getPreviousBomnumbervendor()[0];
            $data['fetchALLpreVendorpoitemList']= $this->admin_model->fetchALLpreVendorpoitemList();
            $data['buyerList']= $this->admin_model->fetchAllbuyerList();
            $data['vendorList']= $this->admin_model->fetchALLvendorListwithoutsupplier();
            $data['incoming_details']= $this->admin_model->fetchAllincomingdetailsList();
            $this->loadViews("masters/addvendorBillofmaterial", $this->global, $data, NULL);

        }
    }

    public function editvendorbillofmaterial($edit_id){
        $process = 'Edit Vendor Bill Of Material';
        $processFunction = 'Admin/editvendorbillofmaterial';
        $this->logrecord($process,$processFunction);

        $data['buyerList']= $this->admin_model->fetchAllbuyerList();
        $data['vendorList']= $this->admin_model->fetchALLvendorListwithoutsupplier();
        $data['incoming_details']= $this->admin_model->fetchAllincomingdetailsList();
        $data['fetchALLVendorbillofmaterialdetails']= $this->admin_model->fetchALLVendorbillofmaterialdetails($edit_id);

        $data['fetchALLpreVendorpoitemListedit']= $this->admin_model->fetchALLpreVendorpoitemListedit($edit_id);


        $this->global['pageTitle'] = 'Edit Vendor Bill Of Material';
        $this->loadViews("masters/editvendorBillofmaterial", $this->global, $data, NULL);
    }

    public function deletevendorBillofmaterial(){

        $post_submit = $this->input->post();
        if($post_submit){
            $result = $this->admin_model->deletevendorBillofmaterial(trim($this->input->post('id')));
            if ($result) {
                        $process = 'Vendor Bill Of Material Work Delete';
                        $processFunction = 'Admin/deletevendorBillofmaterial';
                        $this->logrecord($process,$processFunction);
                    echo(json_encode(array('status'=>'success')));
                }
            else { echo(json_encode(array('status'=>'failed'))); }
        }else{
            echo(json_encode(array('status'=>'failed'))); 
        }

    }

    public function getbuyerdetialsbybuyerponumber(){

        if($this->input->post('buyer_po_number')) {
            $getBuyeridbypoid = $this->admin_model->getbuyerdetialsbybuyerponumber($this->input->post('buyer_po_number'));
            if($getBuyeridbypoid){
                $content = $getBuyeridbypoid[0];
                echo json_encode($content);

            }else{
                echo 'failure';
            }
           
        } else {
            echo 'failure';
        }


    }

    public function getVendoritemsonlyvendorBillofmaterial(){

        $vendor_po_number=$this->input->post('vendor_po_number');
        $buyer_po_number=$this->input->post('buyer_po_number');

        if($vendor_po_number) {
			$getVendoritemsonly = $this->admin_model->getVendoritemsonlyvendorBillofmaterial($vendor_po_number,$buyer_po_number);
			if(count($getVendoritemsonly) >= 1) {
                $content = $content.'<option value="">Select Part Number</option>';
				foreach($getVendoritemsonly as $value) {
					$content = $content.'<option value="'.$value["fin_id"].'">'.$value["part_number"].'</option>';
				}
				echo $content;
			} else {
				echo 'failure';
			}
		} else {
			echo 'failure';
		}

    }

    public function getSuppliergoodsPartnumberByidforvendorbillofmaetrial(){

        if($this->input->post('part_number')) {
            $getPartNameBypartid = $this->admin_model->getSuppliergoodsPartnumberByidforvendorbillofmaetrial($this->input->post('part_number'),$this->input->post('vendor_po_number'));
            if($getPartNameBypartid){
                $content = $getPartNameBypartid[0];
                echo json_encode($content);

            }else{
                echo 'failure';
            }
           
        } else {
            echo 'failure';
        }
    }


    public function saveVendorbilloamaterialitems(){

        $post_submit = $this->input->post();;

        if($post_submit){
            $save_billofmaterial_response = array();

            $this->form_validation->set_rules('part_number','Part Number','trim|required');
            $this->form_validation->set_rules('description','Part Name','trim|required');
            $this->form_validation->set_rules('buyer_order_qty','Buyer Order Qty','trim|required');
            $this->form_validation->set_rules('vendor_order_qty','Vendor Order Qty','trim|required');
            $this->form_validation->set_rules('vendor_received_qty','Vendor Received Qty','trim|required');
            $this->form_validation->set_rules('balanced_aty','Balanced Qty','trim|required');
            $this->form_validation->set_rules('item_remark','Item Remark','trim');

            if($this->form_validation->run() == FALSE)
            {
                $save_billofmaterial_response['status'] = 'failure';
                $save_billofmaterial_response['error'] = array('part_number'=>strip_tags(form_error('part_number')), 'description'=>strip_tags(form_error('description')), 'buyer_order_qty'=>strip_tags(form_error('buyer_order_qty')), 'vendor_order_qty'=>strip_tags(form_error('vendor_order_qty')),'vendor_received_qty'=>strip_tags(form_error('vendor_received_qty')),'balanced_aty'=>strip_tags(form_error('balanced_aty')));
            }else{

                $editvbmid = trim($this->input->post('editvbmid'));

                if($editvbmid){
                    $main_vbm_id  = $editvbmid;
                }else{
                    $main_vbm_id  = NULL;
                }
            
                $data = array(
                    'part_number_id'   => trim($this->input->post('part_number')),
                    'vendor_bill_of_material_id' => $main_vbm_id,
                    'description'     => trim($this->input->post('description')),
                    'buyer_order_qty'=> trim($this->input->post('buyer_order_qty')),
                    'vendor_order_qty'=> trim($this->input->post('vendor_order_qty')),
                    'vendor_received_qty'=> trim($this->input->post('vendor_received_qty')),
                    'balenced_qty'=> trim($this->input->post('balanced_aty')),
                    'item_remark'=> trim($this->input->post('item_remark')),

                    'pre_bom_date'=> trim($this->input->post('pre_date')),
                    'pre_vendor_name' => trim($this->input->post('pre_vendor_name')),
                    'pre_vendor_po_number' => trim($this->input->post('pre_vendor_po_number')),
                    'pre_buyer_name' => trim($this->input->post('pre_buyer_name')),
                    'pre_buyer_po_number' => trim($this->input->post('pre_buyer_po_number')),
                    'pre_buyer_po_date' => trim($this->input->post('pre_buyer_po_date')),
                    'pre_buyer_delivery_date' => trim($this->input->post('pre_buyer_delivery_date')),
                    'pre_bom_status' => trim($this->input->post('pre_bom_status')),
                    'pre_incoming_details' => trim($this->input->post('pre_incoming_details')),
                    'pre_remark' => trim($this->input->post('item_remark')),
                );

                // $checkIfexitsbuyerpo = $this->admin_model->checkIfexitsbuyerpo(trim($this->input->post('sales_order_number')));
                // if($checkIfexitsbuyerpo > 0){
                //     $save_buyerpo_response['status'] = 'failure';
                //     $save_buyerpo_response['error'] = array('sales_order_number'=>'Buyer PO Alreday Exits (Sales Order Number Alreday Exits)');
                // }else{


                    $vendor_bill_of_material_item_id = trim($this->input->post('vendor_bill_of_material_item_id'));
                    if( $vendor_bill_of_material_item_id){
                        $vendorbillofmaterialitemid = $vendor_bill_of_material_item_id;
                    }else{
                        $vendorbillofmaterialitemid = '';
                    }
                    
                    
                    $saveVendorbillofmaterilitemdata = $this->admin_model->saveVendorbillofmaterilitemdata($vendorbillofmaterialitemid,$data);
                    
                    if($saveVendorbillofmaterilitemdata){
                        $save_billofmaterial_response['status'] = 'success';
                        $save_billofmaterial_response['error'] = array('part_number'=>strip_tags(form_error('part_number')), 'description'=>strip_tags(form_error('description')), 'buyer_order_qty'=>strip_tags(form_error('buyer_order_qty')), 'vendor_order_qty'=>strip_tags(form_error('vendor_order_qty')),'vendor_received_aty'=>strip_tags(form_error('vendor_received_aty')),'balanced_aty'=>strip_tags(form_error('balanced_aty')));
                    }
                //  }
                
            }
            echo json_encode($save_billofmaterial_response);
        }


    }


    public function deleteVendorbillofmaterialpoitem(){
        $post_submit = $this->input->post();
        if($post_submit){
            $result = $this->admin_model->deleteVendorbillofmaterialpoitem(trim($this->input->post('id')));
            if ($result) {
                        $process = 'Vendor Bill Of Material Delete';
                        $processFunction = 'Admin/deleteVendorbillofmaterialpoitem';
                        $this->logrecord($process,$processFunction);
                    echo(json_encode(array('status'=>'success')));
                }
            else { echo(json_encode(array('status'=>'failed'))); }
        }else{
            echo(json_encode(array('status'=>'failed'))); 
        }

    }


    public function viewVendorbillofmaterial($id){

        $process = 'View Vendor Bill of Material';
        $processFunction = 'Admin/viewVendorbillofmaterial';
        $this->logrecord($process,$processFunction);
        $this->global['pageTitle'] = 'View Vendor Bill of Material';
        $data['getVendorbillofmaterialDetails']= $this->admin_model->getVendorbillofmaterialDetails($id)[0];
        $data['getVendorbillofmaterialitem']= $this->admin_model->getVendorbillofmaterialitem($id);
        $data['buyerList']= $this->admin_model->fetchAllbuyerList();
        $data['vendorList']= $this->admin_model->fetchALLvendorList();
        $this->loadViews("masters/viewVendorbillofmaterial", $this->global, $data, NULL);


    }
    
    public function getVendorDetailsBybuyerPOnumber(){

        $supplier_po_number=$this->input->post('supplier_po_number');
        if($supplier_po_number) {
			$supplier_po_number = $this->admin_model->getVendorDetailsBybuyerPOnumber($supplier_po_number);
			if(count($supplier_po_number) >= 1) {
                $content = $content.'<option value="">Select Vendor Name</option>';
				foreach($supplier_po_number as $value) {
					$content = $content.'<option value="'.$value["ven_id"].'">'.$value["vendor_name"].'</option>';
				}
				echo $content;
			} else {
				echo 'failure';
			}
		} else {
			echo 'failure';
		}

    }

    public function getSupplierdetailsbyvendorponumber(){

        if($this->input->post('vendor_po_number')) {
            $getBuyeridbypoid = $this->admin_model->getSupplierdetailsbyvendorponumber($this->input->post('vendor_po_number'));
            if($getBuyeridbypoid){
                $content = $getBuyeridbypoid[0];
                echo json_encode($content);

            }else{
                echo 'failure';
            }
           
        } else {
            echo 'failure';
        }

    }


    public function getItemdetailsdependonvendorpobom(){

        if($this->input->post('part_number')) {
            $getPartNameBypartid = $this->admin_model->getItemdetailsdependonvendorpobom($this->input->post('part_number'),$this->input->post('vendor_po_number'),$this->input->post('vendor_name'));
        
            if($getPartNameBypartid){
                $content = $getPartNameBypartid[0];
                echo json_encode($content);

            }else{
                echo 'failure';
            }
           
        } else {
            echo 'failure';
        }

    }


    public function fetchpackinginstartion(){

        $params = $_REQUEST;
        $totalRecords = $this->admin_model->getPackinginstractionCount($params); 
        $queryRecords = $this->admin_model->getPackinginstractiondata($params); 

        $data = array();
        foreach ($queryRecords as $key => $value)
        {
            $i = 0;
            foreach($value as $v)
            {
                $data[$key][$i] = $v;
                $i++;
            }
        }
        $json_data = array(
            "draw"            => intval( $params['draw'] ),   
            "recordsTotal"    => intval( $totalRecords ),  
            "recordsFiltered" => intval($totalRecords),
            "data"            => $data   // total data array
            );
        echo json_encode($json_data);

    }


    public function packinginstaruction(){

        $process = 'Packing Instaruction';
        $processFunction = 'Admin/packinginstaruction';
        $this->logrecord($process,$processFunction);
        $this->global['pageTitle'] = 'Packing Instaruction';
        $this->loadViews("masters/packinginstaruction", $this->global, $data, NULL);  

    }

    
    public function addnewPackinginstruction(){

        $post_submit = $this->input->post();
        if($post_submit){

            $packing_instrction_response = array();
            $this->form_validation->set_rules('packing_id_number','PO Number','trim|required');
            $this->form_validation->set_rules('buyer_name','Date','trim|required');
            $this->form_validation->set_rules('buyer_po_number','Vendor Name','trim|required');
            $this->form_validation->set_rules('buyer_po_date','Buyer PO Date','trim|required');
            $this->form_validation->set_rules('export_id','Export Id','trim|required');
            $this->form_validation->set_rules('remark','Remark','trim');

            if($this->form_validation->run() == FALSE)
            {
                $packing_instrction_response['status'] = 'failure';
                $packing_instrction_response['error'] = array('export_id'=>strip_tags(form_error('export_id')), 'packing_id_number'=>strip_tags(form_error('packing_id_number')),'buyer_name'=>strip_tags(form_error('buyer_name')),'buyer_po_number'=>strip_tags(form_error('buyer_po_number')),'buyer_po_date'=>strip_tags(form_error('buyer_po_date')),'remark'=>strip_tags(form_error('remark')));
           
            }else{

                $data = array(
                    'packing_instrauction_id'   => trim($this->input->post('packing_id_number')),
                    'export_id'   => trim($this->input->post('export_id')),
                    'buyer_name'     => trim($this->input->post('buyer_name')),
                    'buyer_po_number'  => trim($this->input->post('buyer_po_number')),
                    'buyer_po_date'=> trim($this->input->post('buyer_po_date')),
                    'remark'=> trim($this->input->post('remark')),
                );

                $checkIpackinginstraction = $this->admin_model->checkIpackinginstraction(trim($this->input->post('packing_id_number')));
                if($checkIpackinginstraction > 0){
                        $packing_instrction_response['status'] = 'failure';
                        $packing_instrction_response['error'] = array( 'packing_id_number'=>strip_tags(form_error('packing_id_number')),'buyer_name'=>strip_tags(form_error('buyer_name')),'buyer_po_number'=>strip_tags(form_error('buyer_po_number')),'buyer_po_date'=>strip_tags(form_error('buyer_po_date')),'remark'=>strip_tags(form_error('remark')));
                    }else{
                    $savePackinginstarction = $this->admin_model->savePackinginstarction('',$data);
                    if($savePackinginstarction){
                             $packing_instrction_response['status'] = 'success';
                             $packing_instrction_response['error'] = array( 'packing_id_number'=>strip_tags(form_error('packing_id_number')),'buyer_name'=>strip_tags(form_error('buyer_name')),'buyer_po_number'=>strip_tags(form_error('buyer_po_number')),'buyer_po_date'=>strip_tags(form_error('buyer_po_date')),'remark'=>strip_tags(form_error('remark')));
                            
                    }

                }

            }

            echo json_encode($packing_instrction_response);

        }else{

            $process = 'Add New Packing Instaruction';
            $processFunction = 'Admin/addjobwork';
            $this->logrecord($process,$processFunction);
            $this->global['pageTitle'] = 'Add New Packing Instaruction';
            $data['getpreviouspackinginstarction']= $this->admin_model->getpreviouspackinginstarction();
            $data['buyerList']= $this->admin_model->fetchAllbuyerList();
            $this->loadViews("masters/addNewpackinginstaruction", $this->global, $data, NULL);

        }

    }


    public function exportdetails(){
        $process = 'Export Details';
        $processFunction = 'Admin/exportdetails';
        $this->logrecord($process,$processFunction);
        $this->global['pageTitle'] = 'Export Details';
        $this->loadViews("masters/exportdetails", $this->global, $data, NULL);  
    }

    public function fetchexportdetails(){
        $params = $_REQUEST;
        $totalRecords = $this->admin_model->getExportdetailsCount($params); 
        $queryRecords = $this->admin_model->getExportdetailsdata($params); 

        $data = array();
        foreach ($queryRecords as $key => $value)
        {
            $i = 0;
            foreach($value as $v)
            {
                $data[$key][$i] = $v;
                $i++;
            }
        }
        $json_data = array(
            "draw"            => intval( $params['draw'] ),   
            "recordsTotal"    => intval( $totalRecords ),  
            "recordsFiltered" => intval($totalRecords),
            "data"            => $data   // total data array
            );
        echo json_encode($json_data);

    }

    public function packagingform(){

        $process = 'Packaging Form';
        $processFunction = 'Admin/exportdetails';
        $this->logrecord($process,$processFunction);
        $this->global['pageTitle'] = 'Packaging Form';
        $this->loadViews("masters/packagingform", $this->global, $data, NULL);  
        
    }

    public function rrchallan(){

        $process = 'RR Challan';
        $processFunction = 'Admin/rrchallan';
        $this->logrecord($process,$processFunction);
        $this->global['pageTitle'] = 'RR Challan';
        $this->loadViews("masters/rrchallan", $this->global, $data, NULL);  
        
    }

    public function incomingdetails(){

        $process = 'Incoming Details';
        $processFunction = 'Admin/incomingdetails';
        $this->logrecord($process,$processFunction);
        $this->global['pageTitle'] = 'Incoming Details';
        $this->loadViews("masters/incomingdetails", $this->global, $data, NULL);  

    }

    public function getVendorPonumberbyVendorid(){

        $vendor_name=$this->input->post('vendor_name');
        if($vendor_name) {
			$getVendordetails = $this->admin_model->getVendorPonumberbyVendorid($vendor_name);
			if(count($getVendordetails) >= 1) {
                $content = $content.'<option value="">Select Vendor PO Number</option>';
				foreach($getVendordetails as $value) {
					$content = $content.'<option value="'.$value["id"].'">'.$value["po_number"].'</option>';
				}
				echo $content;
			} else {
				echo 'failure';
			}
		} else {
			echo 'failure';
		}
    }

    public function getVendorpoitems(){

        if($this->input->post('part_number')) {
            $getPartNameBypartid = $this->admin_model->getVendorpoitems($this->input->post('part_number'),$this->input->post('vendor_po_number'));
            if($getPartNameBypartid){
                $content = $getPartNameBypartid[0];
                echo json_encode($content);

            }else{
                echo 'failure';
            }
           
        } else {
            echo 'failure';
        }

    }

    public function fetchincomingdeatils(){

        $params = $_REQUEST;
        $totalRecords = $this->admin_model->getincomingdeatilscount($params); 
        $queryRecords = $this->admin_model->getincomingdeatilsdata($params); 

        $data = array();
        foreach ($queryRecords as $key => $value)
        {
            $i = 0;
            foreach($value as $v)
            {
                $data[$key][$i] = $v;
                $i++;
            }
        }
        $json_data = array(
            "draw"            => intval( $params['draw'] ),   
            "recordsTotal"    => intval( $totalRecords ),  
            "recordsFiltered" => intval($totalRecords),
            "data"            => $data   // total data array
            );
        echo json_encode($json_data);

    }

    public function addnewencomingdetails(){

        $post_submit = $this->input->post();
        if($post_submit){

            $save_incoming_details = array();

            $this->form_validation->set_rules('incoming_no','PO Number','trim|required');
            $this->form_validation->set_rules('vendor_name','Date','trim|required');
            $this->form_validation->set_rules('vendor_po_number','Vendor Name','trim|required');
            $this->form_validation->set_rules('reported_by','Buyer_name','trim');
            $this->form_validation->set_rules('reported_date','Buyer PO Number','trim');
            $this->form_validation->set_rules('remark','Buyer PO Date','trim');

            if($this->form_validation->run() == FALSE)
            {
                $save_incoming_details['status'] = 'failure';
                $save_incoming_details['error'] = array( 'incoming_no'=>strip_tags(form_error('incoming_no')),'vendor_name'=>strip_tags(form_error('vendor_name')),'vendor_po_number'=>strip_tags(form_error('vendor_po_number')),'reported_by'=>strip_tags(form_error('reported_by')),'reported_date'=>strip_tags(form_error('reported_date')),'remark'=>strip_tags(form_error('remark')));
           
            }else{

                if($this->input->post('incomingdetail_editid')){
                    $checkvendornameexits = $this->admin_model->checkvendorpoisaredayexitsedit(trim($this->input->post('incomingdetail_editid')),trim($this->input->post('vendor_po_number')));

                    if($checkvendornameexits['vendor_ids'] > 0){
                        $data = array(
                            'incoming_details_id'   => trim($this->input->post('incoming_no')),
                            'vendor_name'  => trim($this->input->post('vendor_name')),
                            'vendor_po_number'=> trim($this->input->post('vendor_po_number')),
                            'reported_by' =>    trim($this->input->post('reported_by')),
                            'reported_date' =>    trim($this->input->post('reported_date')),
                            'remark' =>    trim($this->input->post('remark')),
                            'updatedDtm' => date("Y-m-d h:m:s"),
                        );
        
                        $saveIncomingdetails= $this->admin_model->saveIncomingdetails(trim($this->input->post('incomingdetail_editid')),$data);
    
                        if($saveIncomingdetails){
                                $update_last_inserted_id_incoming_details = $this->admin_model->update_last_inserted_id_incoming_details($saveIncomingdetails);
                                if($update_last_inserted_id_incoming_details){
                                    $save_incoming_details['status'] = 'success';
                                    $save_incoming_details['error'] = array( 'incoming_no'=>strip_tags(form_error('incoming_no')),'vendor_name'=>strip_tags(form_error('vendor_name')),'vendor_po_number'=>strip_tags(form_error('vendor_po_number')),'reported_by'=>strip_tags(form_error('reported_by')),'reported_date'=>strip_tags(form_error('reported_date')),'remark'=>strip_tags(form_error('remark')));
                                }
                        }

                    }else{

                          
                            // $checkvendornameexits = $this->admin_model->checkvendorpoisaredayexits(trim($this->input->post('vendor_po_number')));

                            $checkvendornameexits = 0;

                            if($checkvendornameexits['vendor_ids'] > 0){
                                $save_incoming_details['status'] = 'failure';
                                $save_incoming_details['error'] = array( 'incoming_no'=>strip_tags(form_error('incoming_no')),'vendor_name'=>strip_tags(form_error('vendor_name')),'vendor_po_number'=>'Incoming Id Already Exits For This Vendor PO Number','reported_by'=>strip_tags(form_error('reported_by')),'reported_date'=>strip_tags(form_error('reported_date')),'remark'=>strip_tags(form_error('remark')));
                            }else{


                                $data = array(
                                    'incoming_details_id'   => trim($this->input->post('incoming_no')),
                                    'vendor_name'  => trim($this->input->post('vendor_name')),
                                    'vendor_po_number'=> trim($this->input->post('vendor_po_number')),
                                    'reported_by' =>    trim($this->input->post('reported_by')),
                                    'reported_date' =>    trim($this->input->post('reported_date')),
                                    'remark' =>    trim($this->input->post('remark')),
                                    'updatedDtm' => date("Y-m-d h:m:s"),
                                );
                
                                $saveIncomingdetails= $this->admin_model->saveIncomingdetails(trim($this->input->post('incomingdetail_editid')),$data);
            
                                if($saveIncomingdetails){
                                        $update_last_inserted_id_incoming_details = $this->admin_model->update_last_inserted_id_incoming_details($saveIncomingdetails);
                                        if($update_last_inserted_id_incoming_details){
                                            $save_incoming_details['status'] = 'success';
                                            $save_incoming_details['error'] = array( 'incoming_no'=>strip_tags(form_error('incoming_no')),'vendor_name'=>strip_tags(form_error('vendor_name')),'vendor_po_number'=>strip_tags(form_error('vendor_po_number')),'reported_by'=>strip_tags(form_error('reported_by')),'reported_date'=>strip_tags(form_error('reported_date')),'remark'=>strip_tags(form_error('remark')));
                                        }
                                }

                            }
                    }

                }else{

                    $data = array(
                        'incoming_details_id'   => trim($this->input->post('incoming_no')),
                        'vendor_name'  => trim($this->input->post('vendor_name')),
                        'vendor_po_number'=> trim($this->input->post('vendor_po_number')),
                        'reported_by' =>    trim($this->input->post('reported_by')),
                        'reported_date' =>    trim($this->input->post('reported_date')),
                        'remark' =>    trim($this->input->post('remark'))
                    );
                       /* Check if vendor PO is Alreday Exits */
                    
                    $checkvendornameexits = $this->admin_model->checkvendorpoisaredayexits(trim($this->input->post('vendor_po_number')));

                    if($checkvendornameexits['vendor_ids'] > 0){
                        $save_incoming_details['status'] = 'failure';
                        $save_incoming_details['error'] = array( 'incoming_no'=>strip_tags(form_error('incoming_no')),'vendor_name'=>strip_tags(form_error('vendor_name')),'vendor_po_number'=>'Incoming Id Already Exits For This Vendor PO Number','reported_by'=>strip_tags(form_error('reported_by')),'reported_date'=>strip_tags(form_error('reported_date')),'remark'=>strip_tags(form_error('remark')));
                    }else{

                    $checkIfexitsincomingdetails = $this->admin_model->checkIfexitsincomingdetails(trim($this->input->post('incoming_no')));
    
                    if($checkIfexitsincomingdetails > 0){
                        $save_incoming_details['status'] = 'failure';
                        $save_incoming_details['error'] = array( 'incoming_no'=>strip_tags(form_error('incoming_no')),'vendor_name'=>strip_tags(form_error('vendor_name')),'vendor_po_number'=>strip_tags(form_error('vendor_po_number')),'reported_by'=>strip_tags(form_error('reported_by')),'reported_date'=>strip_tags(form_error('reported_date')),'remark'=>strip_tags(form_error('remark')));
                    }else{
                        $saveIncomingdetails= $this->admin_model->saveIncomingdetails('',$data);
    
                        if($saveIncomingdetails){
                            $update_last_inserted_id_incoming_details = $this->admin_model->update_last_inserted_id_incoming_details($saveIncomingdetails);
                            if($update_last_inserted_id_incoming_details){
                                $save_incoming_details['status'] = 'success';
                                $save_incoming_details['error'] = array( 'incoming_no'=>strip_tags(form_error('incoming_no')),'vendor_name'=>strip_tags(form_error('vendor_name')),'vendor_po_number'=>strip_tags(form_error('vendor_po_number')),'reported_by'=>strip_tags(form_error('reported_by')),'reported_date'=>strip_tags(form_error('reported_date')),'remark'=>strip_tags(form_error('remark')));
                            }
                        }
    
                    }
                  }
                }
               
            }

            echo json_encode($save_incoming_details);
            
        }else{

            $process = 'Add New Incoming Details';
            $processFunction = 'Admin/addnewencomingdetails';
            $this->logrecord($process,$processFunction);
            $this->global['pageTitle'] = 'Add New Incoming Details';
            $data['vendorList']= $this->admin_model->fetchALLvendorList();
            $data['getPreviousincomingdetails']= $this->admin_model->getPreviousincomingdetails();
            //$data['getitemdetails']= $this->admin_model->getitemdetails();
            $data['getAllitemdetails']= $this->admin_model->getAllitemdetails();
            $data['getAllitemdetailsforfilter']= $this->admin_model->getAllitemdetailsforfilter();
            $this->loadViews("masters/addnewencomingdetails", $this->global, $data, NULL);

        }
    }

    public function fetchincomingdeatilsitemlistadd($part_number_serach){
        $params = $_REQUEST;
        $totalRecords = $this->admin_model->fetchincomingdeatilsitemlistaddcount($params,$part_number_serach); 
        $queryRecords = $this->admin_model->fetchincomingdeatilsitemlistadddata($params,$part_number_serach); 

        $data = array();
        foreach ($queryRecords as $key => $value)
        {
            $i = 0;
            foreach($value as $v)
            {
                $data[$key][$i] = $v;
                $i++;
            }
        }
        $json_data = array(
            "draw"            => intval( $params['draw'] ),   
            "recordsTotal"    => intval( $totalRecords ),  
            "recordsFiltered" => intval($totalRecords),
            "data"            => $data   // total data array
            );
        echo json_encode($json_data);

    }


    public function deleteIncomingDetailsitem(){
        $post_submit = $this->input->post();
        if($post_submit){
            $result = $this->admin_model->deleteIncomingDetailsitem(trim($this->input->post('id')));
            if ($result) {
                        $process = 'Delete Incoming Details Item';
                        $processFunction = 'Admin/deleteIncomingDetailsitem';
                        $this->logrecord($process,$processFunction);
                    echo(json_encode(array('status'=>'success')));
                }
            else { echo(json_encode(array('status'=>'failed'))); }
        }else{
            echo(json_encode(array('status'=>'failed'))); 
        }

    }


    public function editincomingdetails($id){

        $process = 'Edit Incoming Details';
        $processFunction = 'Admin/editincomingdetails';
        $this->logrecord($process,$processFunction);
        $this->global['pageTitle'] = 'Edit Incoming Details';
        $data['vendorList']= $this->admin_model->fetchALLvendorList();
        $data['getPreviousincomingdetails']= $this->admin_model->getPreviousincomingdetails();
        $data['getPreviousincomingdetailsforedit']= $this->admin_model->getPreviousincomingdetailsforedit($id);
        $data['getAllitemdetails']= $this->admin_model->getAllitemdetailsforedit($id);
        $data['getAllitemdetailsforfilteredit']= $this->admin_model->getAllitemdetailsforfilteredit($id);
        $data['edit_id']= $id;
        $this->loadViews("masters/editincomingdetails", $this->global, $data, NULL);

    }


    public function saveincomingitem(){
        $post_submit = $this->input->post();
        if($post_submit){
            $save_incoming_details_items = array();

            $this->form_validation->set_rules('part_number','Part Number','trim|required');
            // $this->form_validation->set_rules('description','Description','trim|required');
            $this->form_validation->set_rules('p_o_qty','P  O Qty','trim|required');
            $this->form_validation->set_rules('net_weight','Net Weight','trim|required');
            $this->form_validation->set_rules('invoice_no','Invoice No','trim|required');
            $this->form_validation->set_rules('invoice_date','Invoice Date','trim|required');
            $this->form_validation->set_rules('challan_no','Challan No','trim|required');
            $this->form_validation->set_rules('challan_date','Challan Date','trim|required');
            $this->form_validation->set_rules('received_date','Received Date','trim|required');
            $this->form_validation->set_rules('invoice_qty','Invoice Qty','trim|required');
            $this->form_validation->set_rules('invoice_qty_in_kgs','Invoice Qty In kgs','trim|required');
            $this->form_validation->set_rules('balance_qty','Balance Qty','trim|required');
            $this->form_validation->set_rules('fg_material_gross_weight','FG Material Gross Weight','trim|required');
            $this->form_validation->set_rules('units','Units','trim|required');
            $this->form_validation->set_rules('boxex_goni_bundle','Box Goni Bundle','trim|required');
            $this->form_validation->set_rules('lot_no','Lot No','trim|required');
            $this->form_validation->set_rules('remarks','Remarks','trim');

            if($this->form_validation->run() == FALSE)
            {
                $save_incoming_details_items['status'] = 'failure';
                $save_incoming_details_items['error'] = array('part_number'=>strip_tags(form_error('part_number')),'description'=>strip_tags(form_error('description')),'p_o_qty'=>strip_tags(form_error('p_o_qty')),'net_weight'=>strip_tags(form_error('net_weight')),'invoice_no'=>strip_tags(form_error('invoice_no')),'invoice_date'=>strip_tags(form_error('invoice_date')),'challan_no'=>strip_tags(form_error('challan_no')),'challan_date'=>strip_tags(form_error('challan_date')),'received_date'=>strip_tags(form_error('received_date')),'invoice_qty'=>strip_tags(form_error('invoice_qty')),'invoice_qty_in_kgs'=>strip_tags(form_error('invoice_qty_in_kgs')),'balance_qty'=>strip_tags(form_error('balance_qty')),'fg_material_gross_weight'=>strip_tags(form_error('fg_material_gross_weight')),'units'=>strip_tags(form_error('units')),'boxex_goni_bundle'=>strip_tags(form_error('boxex_goni_bundle')),'remarks'=>strip_tags(form_error('remarks')),'lot_no'=>strip_tags(form_error('lot_no')));
           
            }else{


                $incoiming_details_item_id = trim($this->input->post('incoiming_details_item_id'));
                if( $incoiming_details_item_id){
                    $incoiming_detail__item_id = $incoiming_details_item_id;
                }else{
                    $incoiming_detail__item_id = '';
                }


                if($this->input->post('incomingdetail_editid')){

                     /*Check Uniqe Validation in lot number*/
                     $checkLotnumberisexits= $this->admin_model->checkLotnumberisexitsedit(trim($this->input->post('incomingdetail_editid')),trim($this->input->post('lot_no')), trim($this->input->post('part_number')));


                    

                     if($checkLotnumberisexits){

                        $checkLotnumberisexitsaddedititem= $this->admin_model->checkLotnumberisexitsaddedititemedit(trim($this->input->post('lot_no')),trim($this->input->post('part_number')),trim($this->input->post('pre_vendor_po_number')),$incoiming_detail__item_id);

                    
                        if($checkLotnumberisexitsaddedititem){

                            $get_previous_balenace_qty = $this->admin_model->get_previous_item_balenace_qty_edit(trim($this->input->post('part_number')),trim($this->input->post('incomingdetail_editid')));

                            if($get_previous_balenace_qty){
                                $balence_qty = $get_previous_balenace_qty[0]['balance_qty']-trim($this->input->post('invoice_qty'));
                            }else{
                                $balence_qty = trim($this->input->post('p_o_qty'))-trim($this->input->post('invoice_qty'));
                            }

                            $data = array(
                                'incoming_details_id' =>  $this->input->post('incomingdetail_editid'),
                                'part_number'   => trim($this->input->post('part_number')),
                                'p_o_qty'       => trim($this->input->post('p_o_qty')),
                                'net_weight'    => trim($this->input->post('net_weight')),
                                'invoice_no'  => trim($this->input->post('invoice_no')),
                                'invoice_date'=> trim($this->input->post('invoice_date')),
                                'challan_no' =>    trim($this->input->post('challan_no')),
                                'challan_date' =>    trim($this->input->post('challan_date')),
                                'received_date' =>    trim($this->input->post('received_date')),
                                'invoice_qty' =>    trim($this->input->post('invoice_qty')),
                                'invoice_qty_in_kgs' =>    trim($this->input->post('invoice_qty_in_kgs')),
                                // 'balance_qty' =>    trim($this->input->post('balance_qty')),
                                'balance_qty' =>    $balence_qty,
                                'fg_material_gross_weight' =>    trim($this->input->post('fg_material_gross_weight')),
                                'units' =>    trim($this->input->post('units')),
                                'boxex_goni_bundle' =>    trim($this->input->post('boxex_goni_bundle')),
                                'lot_no'=>    trim($this->input->post('lot_no')),
                                'remarks' =>    trim($this->input->post('remarks')),
                                'pre_vendor_name' =>  trim($this->input->post('pre_vendor_name')),
                                'pre_vendor_po_number' =>  trim($this->input->post('pre_vendor_po_number')),
                                'pre_reported_by' =>  trim($this->input->post('pre_reported_by')),
                                'pre_report_date' =>  trim($this->input->post('pre_report_date')),
                                'pre_remark' =>  trim($this->input->post('pre_remark')),
                            );

                            $saveIncomingdetailsitem= $this->admin_model->saveIncomingdetailsitem($incoiming_detail__item_id,$data);

                            if($saveIncomingdetailsitem){
                                $save_incoming_details_items['status'] = 'success';
                                $save_incoming_details_items['error'] = array('part_number'=>strip_tags(form_error('part_number')),'description'=>strip_tags(form_error('description')),'p_o_qty'=>strip_tags(form_error('p_o_qty')),'net_weight'=>strip_tags(form_error('net_weight')),'invoice_no'=>strip_tags(form_error('invoice_no')),'invoice_date'=>strip_tags(form_error('invoice_date')),'challan_no'=>strip_tags(form_error('challan_no')),'challan_date'=>strip_tags(form_error('challan_date')),'received_date'=>strip_tags(form_error('received_date')),'invoice_qty'=>strip_tags(form_error('invoice_qty')),'invoice_qty_in_kgs'=>strip_tags(form_error('invoice_qty_in_kgs')),'balance_qty'=>strip_tags(form_error('balance_qty')),'fg_material_gross_weight'=>strip_tags(form_error('fg_material_gross_weight')),'units'=>strip_tags(form_error('units')),'boxex_goni_bundle'=>strip_tags(form_error('boxex_goni_bundle')),'remarks'=>strip_tags(form_error('remarks')),'lot_no'=>strip_tags(form_error('lot_no')));
                            }

                        }else{
                            $save_incoming_details_items['status'] = 'failure';
                            $save_incoming_details_items['error'] = array('part_number'=>strip_tags(form_error('part_number')),'description'=>strip_tags(form_error('description')),'p_o_qty'=>strip_tags(form_error('p_o_qty')),'net_weight'=>strip_tags(form_error('net_weight')),'invoice_no'=>strip_tags(form_error('invoice_no')),'invoice_date'=>strip_tags(form_error('invoice_date')),'challan_no'=>strip_tags(form_error('challan_no')),'challan_date'=>strip_tags(form_error('challan_date')),'received_date'=>strip_tags(form_error('received_date')),'invoice_qty'=>strip_tags(form_error('invoice_qty')),'invoice_qty_in_kgs'=>strip_tags(form_error('invoice_qty_in_kgs')),'balance_qty'=>strip_tags(form_error('balance_qty')),'fg_material_gross_weight'=>strip_tags(form_error('fg_material_gross_weight')),'units'=>strip_tags(form_error('units')),'boxex_goni_bundle'=>strip_tags(form_error('boxex_goni_bundle')),'remarks'=>strip_tags(form_error('remarks')),'lot_no'=>'Lot Number Alreday Exits');
    
                        }

                     }else{

                    
                            $get_previous_balenace_qty = $this->admin_model->get_previous_item_balenace_qty_edit(trim($this->input->post('part_number')),trim($this->input->post('incomingdetail_editid')));

                            if($get_previous_balenace_qty){
                                $balence_qty = $get_previous_balenace_qty[0]['balance_qty']-trim($this->input->post('invoice_qty'));
                            }else{
                                $balence_qty = trim($this->input->post('p_o_qty'))-trim($this->input->post('invoice_qty'));
                            }

                            $data = array(
                                'incoming_details_id' =>  $this->input->post('incomingdetail_editid'),
                                'part_number'   => trim($this->input->post('part_number')),
                                'p_o_qty'       => trim($this->input->post('p_o_qty')),
                                'net_weight'    => trim($this->input->post('net_weight')),
                                'invoice_no'  => trim($this->input->post('invoice_no')),
                                'invoice_date'=> trim($this->input->post('invoice_date')),
                                'challan_no' =>    trim($this->input->post('challan_no')),
                                'challan_date' =>    trim($this->input->post('challan_date')),
                                'received_date' =>    trim($this->input->post('received_date')),
                                'invoice_qty' =>    trim($this->input->post('invoice_qty')),
                                'invoice_qty_in_kgs' =>    trim($this->input->post('invoice_qty_in_kgs')),
                                // 'balance_qty' =>    trim($this->input->post('balance_qty')),
                                'balance_qty' =>    $balence_qty,
                                'fg_material_gross_weight' =>    trim($this->input->post('fg_material_gross_weight')),
                                'units' =>    trim($this->input->post('units')),
                                'boxex_goni_bundle' =>    trim($this->input->post('boxex_goni_bundle')),
                                'lot_no'=>    trim($this->input->post('lot_no')),
                                'remarks' =>    trim($this->input->post('remarks')),
                                'pre_vendor_name' =>  trim($this->input->post('pre_vendor_name')),
                                'pre_vendor_po_number' =>  trim($this->input->post('pre_vendor_po_number')),
                                'pre_reported_by' =>  trim($this->input->post('pre_reported_by')),
                                'pre_report_date' =>  trim($this->input->post('pre_report_date')),
                                'pre_remark' =>  trim($this->input->post('pre_remark')),
                            );

                            $saveIncomingdetailsitem= $this->admin_model->saveIncomingdetailsitem($incoiming_detail__item_id,$data);

                            if($saveIncomingdetailsitem){
                                $save_incoming_details_items['status'] = 'success';
                                $save_incoming_details_items['error'] = array('part_number'=>strip_tags(form_error('part_number')),'description'=>strip_tags(form_error('description')),'p_o_qty'=>strip_tags(form_error('p_o_qty')),'net_weight'=>strip_tags(form_error('net_weight')),'invoice_no'=>strip_tags(form_error('invoice_no')),'invoice_date'=>strip_tags(form_error('invoice_date')),'challan_no'=>strip_tags(form_error('challan_no')),'challan_date'=>strip_tags(form_error('challan_date')),'received_date'=>strip_tags(form_error('received_date')),'invoice_qty'=>strip_tags(form_error('invoice_qty')),'invoice_qty_in_kgs'=>strip_tags(form_error('invoice_qty_in_kgs')),'balance_qty'=>strip_tags(form_error('balance_qty')),'fg_material_gross_weight'=>strip_tags(form_error('fg_material_gross_weight')),'units'=>strip_tags(form_error('units')),'boxex_goni_bundle'=>strip_tags(form_error('boxex_goni_bundle')),'remarks'=>strip_tags(form_error('remarks')),'lot_no'=>strip_tags(form_error('lot_no')));
                            }
                }


                }else{


                    $incoiming_details_item_id = trim($this->input->post('incoiming_details_item_id'));
                    if( $incoiming_details_item_id){
                        $incoiming_detail__item_id = $incoiming_details_item_id;
                    }else{
                        $incoiming_detail__item_id = '';
                    }


                     /*Check Uniqe Validation in lot number*/
                     $checkLotnumberisexits= $this->admin_model->checkLotnumberisexitsadd(trim($this->input->post('lot_no')),trim($this->input->post('part_number')),trim($this->input->post('pre_vendor_po_number')));

                     if($checkLotnumberisexits){

                        $checkLotnumberisexitsaddedititem= $this->admin_model->checkLotnumberisexitsaddedititem(trim($this->input->post('lot_no')),trim($this->input->post('part_number')),trim($this->input->post('pre_vendor_po_number')),$incoiming_detail__item_id);

                        if($checkLotnumberisexitsaddedititem){

                            $get_previous_balenace_qty = $this->admin_model->get_previous_item_balenace_qty_add(trim($this->input->post('part_number')));

                            if($get_previous_balenace_qty){
                                $balence_qty = $get_previous_balenace_qty[0]['balance_qty']-trim($this->input->post('invoice_qty'));
                            }else{
                                $balence_qty = trim($this->input->post('p_o_qty'))-trim($this->input->post('invoice_qty'));
                            }
    
                            $data = array(
                                'part_number'   => trim($this->input->post('part_number')),
                                'p_o_qty'       => trim($this->input->post('p_o_qty')),
                                'net_weight'    => trim($this->input->post('net_weight')),
                                'invoice_no'  => trim($this->input->post('invoice_no')),
                                'invoice_date'=> trim($this->input->post('invoice_date')),
                                'challan_no' =>    trim($this->input->post('challan_no')),
                                'challan_date' =>    trim($this->input->post('challan_date')),
                                'received_date' =>    trim($this->input->post('received_date')),
                                'invoice_qty' =>    trim($this->input->post('invoice_qty')),
                                'invoice_qty_in_kgs' =>    trim($this->input->post('invoice_qty_in_kgs')),
                                // 'balance_qty' =>    trim($this->input->post('balance_qty')),
                                'balance_qty' =>    $balence_qty,
                                'fg_material_gross_weight' =>    trim($this->input->post('fg_material_gross_weight')),
                                'units' =>    trim($this->input->post('units')),
                                'boxex_goni_bundle' =>    trim($this->input->post('boxex_goni_bundle')),
                                'lot_no'=>    trim($this->input->post('lot_no')),
                                'remarks' =>    trim($this->input->post('remarks')),
                                'pre_vendor_name' =>  trim($this->input->post('pre_vendor_name')),
                                'pre_vendor_po_number' =>  trim($this->input->post('pre_vendor_po_number')),
                                'pre_reported_by' =>  trim($this->input->post('pre_reported_by')),
                                'pre_report_date' =>  trim($this->input->post('pre_report_date')),
                                'pre_remark' =>  trim($this->input->post('pre_remark')),
                            );

                            
                            $saveIncomingdetailsitem= $this->admin_model->saveIncomingdetailsitem($incoiming_detail__item_id,$data);
    
                            if($saveIncomingdetailsitem){
                                $save_incoming_details_items['status'] = 'success';
                                $save_incoming_details_items['error'] = array('part_number'=>strip_tags(form_error('part_number')),'description'=>strip_tags(form_error('description')),'p_o_qty'=>strip_tags(form_error('p_o_qty')),'net_weight'=>strip_tags(form_error('net_weight')),'invoice_no'=>strip_tags(form_error('invoice_no')),'invoice_date'=>strip_tags(form_error('invoice_date')),'challan_no'=>strip_tags(form_error('challan_no')),'challan_date'=>strip_tags(form_error('challan_date')),'received_date'=>strip_tags(form_error('received_date')),'invoice_qty'=>strip_tags(form_error('invoice_qty')),'invoice_qty_in_kgs'=>strip_tags(form_error('invoice_qty_in_kgs')),'balance_qty'=>strip_tags(form_error('balance_qty')),'fg_material_gross_weight'=>strip_tags(form_error('fg_material_gross_weight')),'units'=>strip_tags(form_error('units')),'boxex_goni_bundle'=>strip_tags(form_error('boxex_goni_bundle')),'remarks'=>strip_tags(form_error('remarks')),'lot_no'=>strip_tags(form_error('lot_no')));
                            }

                        }else{
                            $save_incoming_details_items['status'] = 'failure';
                            $save_incoming_details_items['error'] = array('part_number'=>strip_tags(form_error('part_number')),'description'=>strip_tags(form_error('description')),'p_o_qty'=>strip_tags(form_error('p_o_qty')),'net_weight'=>strip_tags(form_error('net_weight')),'invoice_no'=>strip_tags(form_error('invoice_no')),'invoice_date'=>strip_tags(form_error('invoice_date')),'challan_no'=>strip_tags(form_error('challan_no')),'challan_date'=>strip_tags(form_error('challan_date')),'received_date'=>strip_tags(form_error('received_date')),'invoice_qty'=>strip_tags(form_error('invoice_qty')),'invoice_qty_in_kgs'=>strip_tags(form_error('invoice_qty_in_kgs')),'balance_qty'=>strip_tags(form_error('balance_qty')),'fg_material_gross_weight'=>strip_tags(form_error('fg_material_gross_weight')),'units'=>strip_tags(form_error('units')),'boxex_goni_bundle'=>strip_tags(form_error('boxex_goni_bundle')),'remarks'=>strip_tags(form_error('remarks')),'lot_no'=>'Lot Number Alreday Exits');
                        }
                     }else{

                        $get_previous_balenace_qty = $this->admin_model->get_previous_item_balenace_qty_add(trim($this->input->post('part_number')));

                        if($get_previous_balenace_qty){
                            $balence_qty = $get_previous_balenace_qty[0]['balance_qty']-trim($this->input->post('invoice_qty'));
                        }else{
                            $balence_qty = trim($this->input->post('p_o_qty'))-trim($this->input->post('invoice_qty'));
                        }

                        $data = array(
                            'part_number'   => trim($this->input->post('part_number')),
                            'p_o_qty'       => trim($this->input->post('p_o_qty')),
                            'net_weight'    => trim($this->input->post('net_weight')),
                            'invoice_no'  => trim($this->input->post('invoice_no')),
                            'invoice_date'=> trim($this->input->post('invoice_date')),
                            'challan_no' =>    trim($this->input->post('challan_no')),
                            'challan_date' =>    trim($this->input->post('challan_date')),
                            'received_date' =>    trim($this->input->post('received_date')),
                            'invoice_qty' =>    trim($this->input->post('invoice_qty')),
                            'invoice_qty_in_kgs' =>    trim($this->input->post('invoice_qty_in_kgs')),
                            // 'balance_qty' =>    trim($this->input->post('balance_qty')),
                            'balance_qty' =>    $balence_qty,
                            'fg_material_gross_weight' =>    trim($this->input->post('fg_material_gross_weight')),
                            'units' =>    trim($this->input->post('units')),
                            'boxex_goni_bundle' =>    trim($this->input->post('boxex_goni_bundle')),
                            'lot_no'=>    trim($this->input->post('lot_no')),
                            'remarks' =>    trim($this->input->post('remarks')),
                            'pre_vendor_name' =>  trim($this->input->post('pre_vendor_name')),
                            'pre_vendor_po_number' =>  trim($this->input->post('pre_vendor_po_number')),
                            'pre_reported_by' =>  trim($this->input->post('pre_reported_by')),
                            'pre_report_date' =>  trim($this->input->post('pre_report_date')),
                            'pre_remark' =>  trim($this->input->post('pre_remark')),
                        );


                      
                        
                        $saveIncomingdetailsitem= $this->admin_model->saveIncomingdetailsitem($incoiming_detail__item_id,$data);

                        if($saveIncomingdetailsitem){
                            $save_incoming_details_items['status'] = 'success';
                            $save_incoming_details_items['error'] = array('part_number'=>strip_tags(form_error('part_number')),'description'=>strip_tags(form_error('description')),'p_o_qty'=>strip_tags(form_error('p_o_qty')),'net_weight'=>strip_tags(form_error('net_weight')),'invoice_no'=>strip_tags(form_error('invoice_no')),'invoice_date'=>strip_tags(form_error('invoice_date')),'challan_no'=>strip_tags(form_error('challan_no')),'challan_date'=>strip_tags(form_error('challan_date')),'received_date'=>strip_tags(form_error('received_date')),'invoice_qty'=>strip_tags(form_error('invoice_qty')),'invoice_qty_in_kgs'=>strip_tags(form_error('invoice_qty_in_kgs')),'balance_qty'=>strip_tags(form_error('balance_qty')),'fg_material_gross_weight'=>strip_tags(form_error('fg_material_gross_weight')),'units'=>strip_tags(form_error('units')),'boxex_goni_bundle'=>strip_tags(form_error('boxex_goni_bundle')),'remarks'=>strip_tags(form_error('remarks')),'lot_no'=>strip_tags(form_error('lot_no')));
                        }

                     }

                }
            }

            echo json_encode($save_incoming_details_items);
        }
    }


    public function deleteIncomingDetails(){

        $post_submit = $this->input->post();
        if($post_submit){
            $result = $this->admin_model->deleteIncomingDetails(trim($this->input->post('id')));
            if ($result) {
                        $process = 'Incoming Details Delete';
                        $processFunction = 'Admin/deleteIncomingDetails';
                        $this->logrecord($process,$processFunction);
                    echo(json_encode(array('status'=>'success')));
                }
            else { echo(json_encode(array('status'=>'failed'))); }
        }else{
            echo(json_encode(array('status'=>'failed'))); 
        }

    }

    public function deletepackinginstraction(){

        $post_submit = $this->input->post();
        if($post_submit){
            $result = $this->admin_model->deletepackinginstraction(trim($this->input->post('id')));
            if ($result) {
                        $process = 'Delete Packing Instraction';
                        $processFunction = 'Admin/deletepackinginstraction';
                        $this->logrecord($process,$processFunction);
                    echo(json_encode(array('status'=>'success')));
                }
            else { echo(json_encode(array('status'=>'failed'))); }
        }else{
            echo(json_encode(array('status'=>'failed'))); 
        }

    }


    public function addpackinginstractiondetails($packinginstarctionid){

        $packinginstarctionid=  $this->admin_model->getpackinginstarction_data_by_id(trim($packinginstarctionid));
        $buyer_po_number = $packinginstarctionid[0]['buyerpoid'];

    
        $main_id = $packinginstarctionid[0]['main_id'];


        $process = 'Add Packing Instraction Details';
        $processFunction = 'Admin/addpackinginstractiondetails';
        $this->logrecord($process,$processFunction);
        $this->global['pageTitle'] = 'Add Packing Instraction Details';
        $data['main_id'] =$main_id;
        $data['buyer_po_number_id'] =$buyer_po_number;
        $data['getbuyeritemdetails'] =  $this->admin_model->getbuyeritemdetails(trim($buyer_po_number));
        $data['getpackingdetails_itemdetails'] =  $this->admin_model->getpackingdetails_itemdetails(trim($main_id));
        $this->loadViews("masters/addpackinginstractiondetails", $this->global, $data, NULL);  


    }


    public function  getbuyerdetailsbybuteridoritemid(){

        $vendor_po_number=$this->input->post();
        if($vendor_po_number) {
			$vendor_po_number_data = $this->admin_model->getbuyerdetailsbybuteridoritemid(trim($this->input->post('buyer_po_number_id')),trim($this->input->post('part_number')),trim($this->input->post('poitemid')));

			if(count($vendor_po_number_data) >= 1) {
				echo json_encode($vendor_po_number_data[0]);
			} else {
				echo 'failure';
			}
		} else {
			echo 'failure';
		}

    }


    public function deletepackinginstractionsubitem(){

        $post_submit = $this->input->post();
        if($post_submit){
            $result = $this->admin_model->deletepackinginstractionsubitem(trim($this->input->post('id')));
            if ($result) {
                        $process = 'Delete Packing Instraction Item';
                        $processFunction = 'Admin/deletepackinginstractionsubitem';
                        $this->logrecord($process,$processFunction);
                    echo(json_encode(array('status'=>'success')));
                }
            else { echo(json_encode(array('status'=>'failed'))); }
        }else{
            echo(json_encode(array('status'=>'failed'))); 
        }

    }


    public function addpackinginstractiondetailsaction(){

        $post_submit = $this->input->post();
        if($post_submit){

            $add_packing_instraction_details_response = array();


            $this->form_validation->set_rules('part_number','Part Number','trim|required');
            $this->form_validation->set_rules('buyer_invoice_number','Date','trim|required');
            $this->form_validation->set_rules('buyer_invoice_date','Buyer Invoice Date','trim|required');
            $this->form_validation->set_rules('buyer_invoice_qty','Buyer Invoice qty','trim|required');
            $this->form_validation->set_rules('box_qty','Box qty','trim|required');
            $this->form_validation->set_rules('remark','Buyer PO Date','trim');
            $this->form_validation->set_rules('buyer_item_delivery_date','Buyer Item Delivery Date','trim');

            if($this->form_validation->run() == FALSE)
            {
                $add_packing_instraction_details_response['status'] = 'failure';
                $add_packing_instraction_details_response['error'] = array('part_number'=>strip_tags(form_error('part_number')),'buyer_invoice_number'=>strip_tags(form_error('buyer_invoice_number')),'buyer_invoice_date'=>strip_tags(form_error('buyer_invoice_date')),'buyer_invoice_qty'=>strip_tags(form_error('buyer_invoice_qty')),'box_qty'=>strip_tags(form_error('box_qty')),'remark'=>strip_tags(form_error('remark')),'buyer_item_delivery_date'=>strip_tags(form_error('buyer_item_delivery_date')));
           
            }else{


                $data = array(
                    'packing_instract_id'   => trim($this->input->post('main_id')),
                    'part_number'  => trim($this->input->post('part_number')),
                    'buyer_invoice_number'=> trim($this->input->post('buyer_invoice_number')),
                    'buyer_invoice_date' =>    trim($this->input->post('buyer_invoice_date')),
                    'buyer_invoice_qty' =>    trim($this->input->post('buyer_invoice_qty')),
                    'box_qty' =>    trim($this->input->post('box_qty')),
                    'remark' =>    trim($this->input->post('remark')),
                    'buyer_item_delivery_date' =>    trim($this->input->post('buyer_item_delivery_date'))
                );

                if(trim($this->input->post('packing_details_item_id'))){
                    $packing_details_item_id = trim($this->input->post('packing_details_item_id'));
                }else{
                    $packing_details_item_id = '';
                }

                $savePackinginstarction= $this->admin_model->savePackinginstarctiondetails($packing_details_item_id,$data);

                if($savePackinginstarction){
                    $add_packing_instraction_details_response['status'] = 'success';
                    $add_packing_instraction_details_response['error'] = array( 'incoming_no'=>strip_tags(form_error('incoming_no')),'vendor_name'=>strip_tags(form_error('vendor_name')),'vendor_po_number'=>strip_tags(form_error('vendor_po_number')),'reported_by'=>strip_tags(form_error('reported_by')),'reported_date'=>strip_tags(form_error('reported_date')),'remark'=>strip_tags(form_error('remark')),'buyer_item_delivery_date'=>strip_tags(form_error('buyer_item_delivery_date')));
                }


            }

            echo json_encode($add_packing_instraction_details_response);

        }
    }

    public function editpackinginstraction($packinginstractionid){

            $process = 'Edit Packing Instraction Details';
            $processFunction = 'Admin/addpackinginstractiondetails';
            $this->logrecord($process,$processFunction);
            $this->global['pageTitle'] = 'Edit Packing Instraction Details';
            $this->global['packinginstarctionid'] = $packinginstractionid;
            $data['getdetailsofpackinginsraction'] =  $this->admin_model->getdetailsofpackinginsraction(trim($packinginstractionid));
            $data['buyerList']= $this->admin_model->fetchAllbuyerList();
            $this->loadViews("masters/editpackinginstractiondetails", $this->global, $data, NULL);  

    }

    public function updatepackinginstraction(){

        $post_submit = $this->input->post();

    
        if($post_submit){

            $packing_instrction_response = array();
            $this->form_validation->set_rules('packing_id_number','PO Number','trim|required');
            $this->form_validation->set_rules('buyer_name','Date','trim|required');
            $this->form_validation->set_rules('buyer_po_number','Vendor Name','trim');
            $this->form_validation->set_rules('buyer_po_date','Buyer PO Date','trim');
            $this->form_validation->set_rules('remark','Remark','trim');

            if($this->form_validation->run() == FALSE)
            {
                $packing_instrction_response['status'] = 'failure';
                $packing_instrction_response['error'] = array( 'packing_id_number'=>strip_tags(form_error('packing_id_number')),'buyer_name'=>strip_tags(form_error('buyer_name')),'buyer_po_number'=>strip_tags(form_error('buyer_po_number')),'buyer_po_date'=>strip_tags(form_error('buyer_po_date')),'remark'=>strip_tags(form_error('remark')));
           
            }else{

                    if($this->input->post('buyer_po_date')){
                    $buyer_po_date =  $this->input->post('buyer_po_date');
                    }else{
                    $buyer_po_date =  $this->input->post('buyer_po_date_existing');
                    }

                    if($this->input->post('buyer_po_number')){
                        $buyer_po_number =  $this->input->post('buyer_po_number');
                    }else{
                        $buyer_po_number =  $this->input->post('buyer_po_number_existing_id');
                    }

                    $data = array(
                        'packing_instrauction_id'   => trim($this->input->post('packing_id_number')),
                        'buyer_name'     => trim($this->input->post('buyer_name')),
                        'buyer_po_number'  => trim($buyer_po_number),
                        'buyer_po_date'=> trim($buyer_po_date),
                        'remark'=> trim($this->input->post('remark')),
                    );
            
                    $savePackinginstarction = $this->admin_model->savePackinginstarction(trim($this->input->post('packinginstarctionid')),$data);
                    if($savePackinginstarction){
                             $packing_instrction_response['status'] = 'success';
                             $packing_instrction_response['error'] = array( 'packing_id_number'=>strip_tags(form_error('packing_id_number')),'buyer_name'=>strip_tags(form_error('buyer_name')),'buyer_po_number'=>strip_tags(form_error('buyer_po_number')),'buyer_po_date'=>strip_tags(form_error('buyer_po_date')),'remark'=>strip_tags(form_error('remark')));
                    }

            }

            echo json_encode($packing_instrction_response);

        }

     
    }

    public function getVendorsItemsforDisplay(){


        $post_submit = $this->input->post();

        if($post_submit){

            $vendor_po_number = $this->input->post('vendor_po_number');
        
            // load table library
            $this->load->library('table');
            
            // set heading
            $this->table->set_heading('Part Number', 'Description', 'Order Qty','Unit', 'Rate','Value');

            // set template
            $style = array('table_open'  => '<p><b>Vendor PO Item</b></p><table style="width: 70% !important; max-width: 100%;margin-bottom: 20px;" class="table">');

            $this->table->set_template($style);

            $this->db->select(TBL_FINISHED_GOODS.'.part_number,'.TBL_VENDOR_PO_MASTER_ITEM.'.description,'.TBL_VENDOR_PO_MASTER_ITEM.'.order_oty,'.TBL_VENDOR_PO_MASTER_ITEM.'.unit,'.TBL_VENDOR_PO_MASTER_ITEM.'.rate,'.TBL_VENDOR_PO_MASTER_ITEM.'.value');
            $this->db->join(TBL_FINISHED_GOODS, TBL_FINISHED_GOODS.'.fin_id = '.TBL_VENDOR_PO_MASTER_ITEM.'.part_number_id');
            $this->db->where(TBL_VENDOR_PO_MASTER_ITEM.'.vendor_po_id',$vendor_po_number);
            $query_result = $this->db->get(TBL_VENDOR_PO_MASTER_ITEM);
            $data = $query_result->result_array();

            if($data){
                echo $this->table->generate($query_result);

            }else{
                echo '';

            }
    
       }
    }

    public function getincomingListforDisplay(){

        $post_submit = $this->input->post();

        if($post_submit){

            $incoming_details = $this->input->post('incoming_details');
        
            // load table library
            $this->load->library('table');
            
            // set heading
            $this->table->set_heading('Part Number', 'Description', 'PO Qty (pcs)', 'invoice_qty (pcs)','invoice_qty (kgs)','Balance qty');

            // set template
            $style = array('table_open'  => '<p><b>Incoming Details Item</b></p><table style="width: 70% !important; max-width: 100%;margin-bottom: 20px;" class="table">');

            $this->table->set_template($style);

            $this->db->select(TBL_FINISHED_GOODS.'.part_number,'.TBL_FINISHED_GOODS.'.name,'.TBL_INCOMING_DETAILS_ITEM.'.p_o_qty,'.TBL_INCOMING_DETAILS_ITEM.'.invoice_qty,'.TBL_INCOMING_DETAILS_ITEM.'.invoice_qty_in_kgs,'.TBL_INCOMING_DETAILS_ITEM.'.balance_qty');
            
            $this->db->join(TBL_FINISHED_GOODS, TBL_FINISHED_GOODS.'.fin_id = '.TBL_INCOMING_DETAILS_ITEM.'.part_number');
            $this->db->where(TBL_INCOMING_DETAILS_ITEM.'.incoming_details_id',$incoming_details);
            $query_result = $this->db->get(TBL_INCOMING_DETAILS_ITEM);
            $data = $query_result->result_array();

            if($data){
                echo $this->table->generate($query_result);

            }else{
                echo '';

            }
    
       }

    }

    public function saveBillofmaterialtem(){

     
        $post_submit = $this->input->post();

        if($post_submit){

            $saveBillofmaterialtem_response = array();

            $this->form_validation->set_rules('part_number','Part Number','trim|required');
            $this->form_validation->set_rules('rm_actual_aty','RM Actual Qty','trim|required');
            $this->form_validation->set_rules('expected_qty','Expected Qty','trim|required');
            $this->form_validation->set_rules('vendor_actual_received_Qty','Vendor Actual Received Qty','trim|required');
            $this->form_validation->set_rules('net_weight_per_pcs','Net Weight Per PCS','trim|required');
            $this->form_validation->set_rules('total_net_weight','Total Net Weight','trim|required');
            $this->form_validation->set_rules('short_access','Short Access','trim|required');
            $this->form_validation->set_rules('scrap','Scrap','trim|required');
            $this->form_validation->set_rules('actual_scrap_recived','Actual Scrap Recived','trim');
            $this->form_validation->set_rules('item_remark','Item Remark','trim');


            if($this->form_validation->run() == FALSE)
            {
                $saveBillofmaterialtem_response['status'] = 'failure';
                $saveBillofmaterialtem_response['error'] = array(
                    'part_number'=>strip_tags(form_error('part_number')),
                    'description'=>strip_tags(form_error('description')),
                    'rm_order_qty'=>strip_tags(form_error('rm_order_qty')),
                    'rm_actual_aty'=>strip_tags(form_error('rm_actual_aty')),
                    'rm_type'=>strip_tags(form_error('rm_type')),
                    'gross_weight'=>strip_tags(form_error('gross_weight')),
                    'expected_qty'=>strip_tags(form_error('expected_qty')),
                    'vendor_actual_received_Qty'=>strip_tags(form_error('vendor_actual_received_Qty')),
                    'net_weight_per_pcs'=>strip_tags(form_error('net_weight_per_pcs')),
                    'total_net_weight'=>strip_tags(form_error('total_net_weight')),
                    'short_access'=>strip_tags(form_error('short_access')),
                    'scrap'=>strip_tags(form_error('scrap')),
                    'actual_scrap_recived'=>strip_tags(form_error('actual_scrap_recived')),
                    'item_remark'=>strip_tags(form_error('item_remark')));
            }else{

                $bom_id_edit =   $this->input->post('bom_id_edit');

                if($bom_id_edit){
                    $incoming_details_id =$bom_id_edit;
                }else{
                    $incoming_details_id =NULL;
                }

                 $data = array(
                    'bom_id'=>$incoming_details_id,
                    'part_number'=>$this->input->post('part_number'),
                    'rm_actual_aty'=>$this->input->post('rm_actual_aty'),
                    'expected_qty'=>$this->input->post('expected_qty'),
                    'vendor_actual_recived_qty'=>$this->input->post('vendor_actual_received_Qty'),
                    'net_weight_per_pcs'=>$this->input->post('net_weight_per_pcs'),
                    'total_neight_weight'=>$this->input->post('total_net_weight'),
                    'short_excess'=>$this->input->post('short_access'),
                    'scrap_in_kgs'=>$this->input->post('scrap'),
                    'actual_scrap_received_in_kgs'=>$this->input->post('actual_scrap_recived'),
                    'vendor_order_qty'=>$this->input->post('vendor_order_qty'),

                    'remark'=>$this->input->post('item_remark'),

                    'pre_date'   =>$this->input->post('pre_date'),
                    'pre_vendor_name'   =>$this->input->post('pre_vendor_name'),
                    'pre_vendor_po_number' =>$this->input->post('pre_vendor_po_number'),
                    'pre_supplier_name' =>$this->input->post('pre_supplier_name'),
                    'pre_supplier_po_number' =>$this->input->post('pre_supplier_po_number'),
                    'pre_supplier_po_date' =>$this->input->post('supplier_po_date'),
                    'pre_buyer_name' =>$this->input->post('pre_buyer_name'),
                    'pre_buyer_po_number'  =>$this->input->post('pre_buyer_po_number'),
                    'pre_buyer_po_date'  =>$this->input->post('pre_buyer_po_date'),
                    'pre_buyer_delivery_date'  =>$this->input->post('pre_buyer_delivery_date'),
                    'pre_bom_status' =>$this->input->post('pre_bom_status'),
                    'pre_incoming_details' =>$this->input->post('pre_incoming_details'),
                    'pre_remark'  =>$this->input->post('pre_remark')
                  );


                  $bill_of_material_item_id = trim($this->input->post('bill_of_material_item_id'));
                  if( $bill_of_material_item_id){
                      $billofmaterialitemid = $bill_of_material_item_id;
                  }else{
                      $billofmaterialitemid = '';
                  }
                  


                    $saveBillofmaterialitamdata = $this->admin_model->saveBillofmaterialitamdata($billofmaterialitemid,$data);

                    if($saveBillofmaterialitamdata){

                        $saveBillofmaterialtem_response['status'] = 'success';
                        $saveBillofmaterialtem_response['error'] = array(
                            'part_number'=>strip_tags(form_error('part_number')),
                            'description'=>strip_tags(form_error('description')),
                            'rm_order_qty'=>strip_tags(form_error('rm_order_qty')),
                            'rm_actual_aty'=>strip_tags(form_error('rm_actual_aty')),
                            'rm_type'=>strip_tags(form_error('rm_type')),
                            'gross_weight'=>strip_tags(form_error('gross_weight')),
                            'expected_qty'=>strip_tags(form_error('expected_qty')),
                            'vendor_actual_received_Qty'=>strip_tags(form_error('vendor_actual_received_Qty')),
                            'net_weight_per_pcs'=>strip_tags(form_error('net_weight_per_pcs')),
                            'total_net_weight'=>strip_tags(form_error('total_net_weight')),
                            'short_access'=>strip_tags(form_error('short_access')),
                            'scrap'=>strip_tags(form_error('scrap')),
                            'actual_scrap_recived'=>strip_tags(form_error('actual_scrap_recived')),
                            'item_remark'=>strip_tags(form_error('item_remark')));
                    }
            }
            
              echo json_encode($saveBillofmaterialtem_response);

        }


    }

    public function addnewExportDetails(){


        $post_submit = $this->input->post();
        if($post_submit){

            $export_details_response = array();

            $this->form_validation->set_rules('export_id_number','PO Number','trim|required');
            $this->form_validation->set_rules('buyer_name','Date','trim|required');
            $this->form_validation->set_rules('buyer_po_number','Vendor Name','trim|required');
            $this->form_validation->set_rules('buyer_po_date','Buyer PO Date','trim|required');
            $this->form_validation->set_rules('remark','Remark','trim');

            if($this->form_validation->run() == FALSE)
            {
                $export_details_response['status'] = 'failure';
                $export_details_response['error'] = array( 'export_id_number'=>strip_tags(form_error('export_id_number')),'buyer_name'=>strip_tags(form_error('buyer_name')),'buyer_po_number'=>strip_tags(form_error('buyer_po_number')),'buyer_po_date'=>strip_tags(form_error('buyer_po_date')),'remark'=>strip_tags(form_error('remark')));
           
            }else{

                $data = array(
                    'export_details_id'   => trim($this->input->post('export_id_number')),
                    'buyer_name'     => trim($this->input->post('buyer_name')),
                    'buyer_po_number'  => trim($this->input->post('buyer_po_number')),
                    'buyer_po_date'=> trim($this->input->post('buyer_po_date')),
                    'remark'=> trim($this->input->post('remark')),
                );

                $checkExportdetailsalredayexits = $this->admin_model->checkExportdetailsalredayexits(trim($this->input->post('export_id_number')));

                if($checkExportdetailsalredayexits > 0){
                        $export_details_response['status'] = 'failure';
                        $export_details_response['error'] = array( 'export_id_number'=>strip_tags(form_error('packing_id_number')),'buyer_name'=>strip_tags(form_error('buyer_name')),'buyer_po_number'=>strip_tags(form_error('buyer_po_number')),'buyer_po_date'=>strip_tags(form_error('buyer_po_date')),'remark'=>strip_tags(form_error('remark')));
                    }else{
                    $saveExportdetails = $this->admin_model->saveExportdetails('',$data);
                    if($saveExportdetails){
                             $export_details_response['status'] = 'success';
                             $export_details_response['error'] = array( 'export_id_number'=>strip_tags(form_error('packing_id_number')),'buyer_name'=>strip_tags(form_error('buyer_name')),'buyer_po_number'=>strip_tags(form_error('buyer_po_number')),'buyer_po_date'=>strip_tags(form_error('buyer_po_date')),'remark'=>strip_tags(form_error('remark')));    
                    }

                }
            }

            echo json_encode($export_details_response);

        }else{

            $process = 'Add New Export Details';
            $processFunction = 'Admin/addnewExportDetails';
            $this->logrecord($process,$processFunction);
            $this->global['pageTitle'] = 'Add New Export Details';
            $data['getpreviousexportdetailsinstarction']= $this->admin_model->getpreviousexportdetailsinstarction();
            $data['buyerList']= $this->admin_model->fetchAllbuyerList();
            $this->loadViews("masters/addNewexportdetails", $this->global, $data, NULL);

        }


    }

    public function editexportdetails($export_details_id){

        $process = 'Edit Export Details';
        $processFunction = 'Admin/editexportdetails';
        $this->logrecord($process,$processFunction);
        $this->global['pageTitle'] = 'Edit Export Details';
        $this->global['exportdetailsid'] = $export_details_id;
        $data['getexportdetailsforedit'] =  $this->admin_model->getexportdetailsforedit(trim($export_details_id));
        $data['buyerList']= $this->admin_model->fetchAllbuyerList();
        $this->loadViews("masters/editexportdetails", $this->global, $data, NULL); 

    }

    public function updatexportdetails(){

        $post_submit = $this->input->post();

    
        if($post_submit){

            $update_exportdetails_response = array();

            $this->form_validation->set_rules('export_details_id','PO Number','trim|required');
            $this->form_validation->set_rules('buyer_name','Date','trim|required');
            $this->form_validation->set_rules('buyer_po_number','Vendor Name','trim');
            $this->form_validation->set_rules('buyer_po_date','Buyer PO Date','trim');
            $this->form_validation->set_rules('remark','Remark','trim');

            if($this->form_validation->run() == FALSE)
            {
                $update_exportdetails_response['status'] = 'failure';
                $update_exportdetails_response['error'] = array( 'export_details_id'=>strip_tags(form_error('export_details_id')),'buyer_name'=>strip_tags(form_error('buyer_name')),'buyer_po_number'=>strip_tags(form_error('buyer_po_number')),'buyer_po_date'=>strip_tags(form_error('buyer_po_date')),'remark'=>strip_tags(form_error('remark')));
           
            }else{

                if($this->input->post('buyer_po_date')){
                   $buyer_po_date =  $this->input->post('buyer_po_date');
                }else{
                   $buyer_po_date =  $this->input->post('buyer_po_date_existing');
                }

                if($this->input->post('buyer_po_number')){
                    $buyer_po_number =  $this->input->post('buyer_po_number');
                 }else{
                     $buyer_po_number =  $this->input->post('buyer_po_number_existing');
                 }
                        $data = array(
                            'export_details_id'   => trim($this->input->post('export_details_id')),
                            'buyer_name'     => trim($this->input->post('buyer_name')),
                            'buyer_po_number'  => trim($buyer_po_number),
                            'buyer_po_date'=> trim($buyer_po_date),
                            'remark'=> trim($this->input->post('remark')),
                        );

            
                    $saveExportdetails = $this->admin_model->saveExportdetails(trim($this->input->post('exportdetailsid')),$data);
                    if($saveExportdetails){
                             $update_exportdetails_response['status'] = 'success';
                             $update_exportdetails_response['error'] = array( 'export_details_id'=>strip_tags(form_error('export_details_id')),'buyer_name'=>strip_tags(form_error('buyer_name')),'buyer_po_number'=>strip_tags(form_error('buyer_po_number')),'buyer_po_date'=>strip_tags(form_error('buyer_po_date')),'remark'=>strip_tags(form_error('remark')));
                        
                     }

            }

            echo json_encode($update_exportdetails_response);

        }

     
    }


    public function deleteexportdetailsmain(){

        $post_submit = $this->input->post();
        if($post_submit){
            $result = $this->admin_model->deleteexportdetailsmain(trim($this->input->post('id')));
            if ($result) {
                        $process = 'Export Details Delete';
                        $processFunction = 'Admin/deleteexportdetailsmain';
                        $this->logrecord($process,$processFunction);
                    echo(json_encode(array('status'=>'success')));
                }
            else { echo(json_encode(array('status'=>'failed'))); }
        }else{
            echo(json_encode(array('status'=>'failed'))); 
        }


    }


    public function addExportdetailsitems($main_id){

        $packinginstarctionid=  $this->admin_model->getexportdetailsbyid(trim($main_id));
        $buyer_po_number = $packinginstarctionid[0]['buyerpoid'];
        $data['getbuyeritemdetails'] =  $this->admin_model->getbuyeritemdetails(trim($buyer_po_number));

        $process = 'Add Export Details Items';
        $processFunction = 'Admin/addExportdetailsitems';
        $this->logrecord($process,$processFunction);
        $this->global['pageTitle'] = 'Add Export Details Items';
        $data['main_id'] = $main_id;
        $this->loadViews("masters/addexportdetailsitems", $this->global, $data, NULL);  

    }


    public function getbuyeramdpackgindetails(){

        if($this->input->post('exportdetailsid') && $this->input->post('part_number')) {
            $getBuyeridbypoid = $this->admin_model->getbuyeramdpackgindetails($this->input->post('exportdetailsid'),$this->input->post('part_number'));
            if($getBuyeridbypoid){
                $content = $getBuyeridbypoid[0];
                echo json_encode($content);

            }else{
                echo 'failure';
            }
           
        } else {
            echo 'failure';
        }

    }
    

    public function editVendorpo($vendorpoid){

        $process = 'Edit Vendor PO';
        $processFunction = 'Admin/editVendorpo';
        $this->logrecord($process,$processFunction);
        $this->global['pageTitle'] = 'Edit Vendor PO';
        $data['supplierList']= $this->admin_model->fetchALLsupplierList();
        $data['buyerList']= $this->admin_model->fetchAllbuyerList();
        $data['vendorList']= $this->admin_model->fetchALLvendorList();
        $data['getVendorpodetails']= $this->admin_model->getVendorpodetailsedit($vendorpoid);


        $data['fetchALLVendoritemlistforview']= $this->admin_model->fetchALLVendoritemlistforview($vendorpoid);
        $data['finishgoodList']= $this->admin_model->fetchALLFinishgoodList();
        $this->loadViews("masters/editVendorpo", $this->global, $data, NULL);

    }


    public function deleteVendorpoitemedit(){
        $post_submit = $this->input->post();
        if($post_submit){
            $result = $this->admin_model->deleteVendorpoitemedit(trim($this->input->post('id')));
            if ($result) {
                        $process = 'Vendor PO Item Delete';
                        $processFunction = 'Admin/deleteVendorpoitemedit';
                        $this->logrecord($process,$processFunction);
                    echo(json_encode(array('status'=>'success')));
                }
            else { echo(json_encode(array('status'=>'failed'))); }
        }else{
            echo(json_encode(array('status'=>'failed'))); 
        }

    }


    public function getBuyerDetailsBysupplierponumberforbuyer(){
        $supplier_po_number=$this->input->post('supplier_po_number');
        if($supplier_po_number) {
			$supplier_po_number = $this->admin_model->getBuyerDetailsBysupplierponumberforbuyer($supplier_po_number);
			if(count($supplier_po_number) >= 1) {
                //$content = $content.'<option value="">Select Vendor Name</option>';
				foreach($supplier_po_number as $value) {
					$content = $content.'<option value="'.$value["buyer_id"].'">'.$value["buyer"].'</option>';
				}
				echo $content;
			} else {
				echo 'failure';
			}
		} else {
			echo 'failure';
		}

    }

    public function getBuyerDetailsBysupplierponumberforbuyerpo(){
        $supplier_po_number=$this->input->post('supplier_po_number');
        if($supplier_po_number) {
			$supplier_po_number = $this->admin_model->getBuyerDetailsBysupplierponumberforbuyer($supplier_po_number);
			if(count($supplier_po_number) >= 1) {
                //$content = $content.'<option value="">Select Vendor Name</option>';
				foreach($supplier_po_number as $value) {
					$content = $content.'<option value="'.$value["id"].'">'.$value["sales_order_number"].'</option>';
				}
				echo $content;
			} else {
				echo 'failure';
			}
		} else {
			echo 'failure';
		}

    }

    public function getbuyerpoidforshowinitems(){
        $supplier_po_number=$this->input->post('supplier_po_number');
        if($supplier_po_number) {
			$supplier_po_number = $this->admin_model->getBuyerDetailsBysupplierponumberforbuyer($supplier_po_number);
			if(count($supplier_po_number) >= 1) {
                //$content = $content.'<option value="">Select Vendor Name</option>';
				foreach($supplier_po_number as $value) {
					$content = $value["id"];
				}
				echo $content;
			} else {
				echo 'failure';
			}
		} else {
			echo 'failure';
		}

    }

    public function viewexportdetails($packinginstarctionid){

        $packinginstarctionid=  $this->admin_model->getpackinginstarction_data_by_id(trim($packinginstarctionid));

        $data['packingintractiondetails_data']=$packinginstarctionid;

        $buyer_po_number = $packinginstarctionid[0]['buyerpoid'];
        $main_id = $packinginstarctionid[0]['main_id'];


        $process = 'View Export Details';
        $processFunction = 'Admin/viewexportdetails';
        $this->logrecord($process,$processFunction);
        $this->global['pageTitle'] = 'View Export Details';
        $data['main_id'] =$main_id;
        $data['getbuyeritemdetails'] =  $this->admin_model->getbuyeritemdetails(trim($buyer_po_number));
        $data['getpackingdetails_itemdetails'] =  $this->admin_model->getpackingdetails_itemdetails(trim($main_id));
        $this->loadViews("masters/viewexportdetails", $this->global, $data, NULL);  


    }

    public function editjobwork($jobworkid){
        $process = 'Edit Job Work';
        $processFunction = 'Admin/editjobwork';
        $this->global['pageTitle'] = 'Edit Job Work';
        $data['jobworkid'] =$jobworkid;
        $data['fetchALLprejobworkitemList']= $this->admin_model->fetchALLprejobworkitemListedit($jobworkid);
        $data['vendorList']= $this->admin_model->fetchALLvendorList();
        $data['getalljobworkdetails'] =  $this->admin_model->getalljobworkdetails(trim($jobworkid));
        $this->loadViews("masters/editjobwork", $this->global, $data, NULL);  

    }

    public function scrapreturn(){
        $process = 'Scrap Return';
        $processFunction = 'Admin/scrapreturn';
        $this->global['pageTitle'] = 'Scrap Return';
        $this->loadViews("masters/scrapreturn", $this->global, $data, NULL);  
    }

    public function addnewScrapreturn(){
        $post_submit = $this->input->post();
        if($post_submit){
            $scrapreturn_response = array();
            $this->form_validation->set_rules('challan_id','Challan Id','trim|required');
            $this->form_validation->set_rules('challan_date','Date','trim|required');
            $this->form_validation->set_rules('vendor_name','Vendor Name','trim|required');
            $this->form_validation->set_rules('supplier_name','Supplier Name','trim');
            $this->form_validation->set_rules('remark','Remark','trim');

            if($this->form_validation->run() == FALSE)
            {
                $scrapreturn_response['status'] = 'failure';
                $scrapreturn_response['error'] = array( 'challan_id'=>strip_tags(form_error('challan_id')),'challan_date'=>strip_tags(form_error('challan_date')),'vendor_name'=>strip_tags(form_error('vendor_name')),'supplier_name'=>strip_tags(form_error('supplier_name')),'remark'=>strip_tags(form_error('remark')));
           
            }else{
                $data = array(
                    'challan_id'   => trim($this->input->post('challan_id')),
                    'challan_date'     => trim($this->input->post('challan_date')),
                    'vendor_id'  => trim($this->input->post('vendor_name')),
                    'supplier_id'=> trim($this->input->post('supplier_name')),
                    'remarks'=> trim($this->input->post('remark')),
                );

                if(trim($this->input->post('challan_table_id'))){
                    $saveScrapreturn = $this->admin_model->saveScrapreturn(trim($this->input->post('challan_table_id')),$data);
                }else{

                    $saveScrapreturn = $this->admin_model->saveScrapreturn('',$data);
                }

               
                if($saveScrapreturn){

                    $update_last_inserted_id_scarp_retuns = $this->admin_model->update_last_inserted_id_scarp_retuns($saveScrapreturn);
                    if($update_last_inserted_id_scarp_retuns){
                        $scrapreturn_response['status'] = 'success';
                        $scrapreturn_response['error'] = array( 'challan_id'=>strip_tags(form_error('challan_id')),'challan_date'=>strip_tags(form_error('challan_date')),'vendor_name'=>strip_tags(form_error('vendor_name')),'supplier_name'=>strip_tags(form_error('supplier_name')),'remark'=>strip_tags(form_error('remark')));
                    }

                }
            }
            echo json_encode($scrapreturn_response);
        }else{
            $process = 'Add New Scrap Return';
            $processFunction = 'Admin/addnewscrapreturn';
            $this->logrecord($process,$processFunction);
            $this->global['pageTitle'] = 'Add New Scrap Return';
            $data['supplierList']= $this->admin_model->fetchALLsupplierList();
            $data['vendorList']= $this->admin_model->fetchALLvendorList();
            $data['fetchALLprescrapreturndetails']= $this->admin_model->fetchALLprescrapreturndetails();
            $data['getpriviousscrapreturn']= $this->admin_model->getpriviousscrpareturn()[0];
            $this->loadViews("masters/addnewscrapreturn", $this->global, $data, NULL);
        }

    }

    public function fetchscrapreturn(){

        $params = $_REQUEST;
        $totalRecords = $this->admin_model->getScrapreturncount($params); 
        $queryRecords = $this->admin_model->getScrapreturndata($params); 

        $data = array();
        foreach ($queryRecords as $key => $value)
        {
            $i = 0;
            foreach($value as $v)
            {
                $data[$key][$i] = $v;
                $i++;
            }
        }
        $json_data = array(
            "draw"            => intval( $params['draw'] ),   
            "recordsTotal"    => intval( $totalRecords ),  
            "recordsFiltered" => intval($totalRecords),
            "data"            => $data   // total data array
            );
        echo json_encode($json_data);

    }

    public function deletescrapreturn(){

        $post_submit = $this->input->post();
        if($post_submit){
            $result = $this->admin_model->deletescrapreturn(trim($this->input->post('id')));
            if ($result) {
                        $process = 'Scrap Return Delete';
                        $processFunction = 'Admin/deletescrapreturn';
                        $this->logrecord($process,$processFunction);
                    echo(json_encode(array('status'=>'success')));
                }
            else { echo(json_encode(array('status'=>'failed'))); }
        }else{
            echo(json_encode(array('status'=>'failed'))); 
        }

    }

    public function savescrapreturnitem(){
        $post_submit = $this->input->post();
        if($post_submit){

            $savescrapreturnitem_response = array();
            $this->form_validation->set_rules('description','Description','trim|required');
            $this->form_validation->set_rules('gross_weight','Gross Weight','trim');
            $this->form_validation->set_rules('net_weight','Net Weight','trim');
            $this->form_validation->set_rules('quantity','Quantity','trim');
            $this->form_validation->set_rules('number_of_bags','Number of Bags','trim');
            $this->form_validation->set_rules('hsn_code','HSN Code','trim');
            $this->form_validation->set_rules('estimated_value','Estimated Value','trim');
            $this->form_validation->set_rules('number_of_processing','Number of Processing','trim');
            $this->form_validation->set_rules('remark','Remark','trim');

            if($this->form_validation->run() == FALSE)
            {
                $savescrapreturnitem_response['status'] = 'failure';
                $savescrapreturnitem_response['error'] = array('description'=>strip_tags(form_error('description')),'gross_weight'=>strip_tags(form_error('gross_weight')),'net_weight'=>strip_tags(form_error('net_weight')),'quantity'=>strip_tags(form_error('quantity')),'number_of_bags'=>strip_tags(form_error('number_of_bags')),'hsn_code'=>strip_tags(form_error('hsn_code')),'estimated_value'=>strip_tags(form_error('estimated_value')),'number_of_processing'=>strip_tags(form_error('number_of_processing')),'remark'=>strip_tags(form_error('remark')));
           
            }else{

                
                $challan_table_id =  trim($this->input->post('challan_table_id'));

                if($challan_table_id){

                    $data = array(
                        'description' =>  trim($this->input->post('description')),
                        'scrap_return_id' => $challan_table_id,
                        'gross_weight' =>  trim($this->input->post('gross_weight')),
                        'net_weight' =>  trim($this->input->post('net_weight')),
                        'quantity' =>  trim($this->input->post('quantity')),
                        'number_of_bags' =>  trim($this->input->post('number_of_bags')),
                        'hsn_code' =>  trim($this->input->post('hsn_code')),
                        'estimated_value' =>  trim($this->input->post('estimated_value')),
                        'number_of_processing' =>  trim($this->input->post('number_of_processing')),
                        'remarks' =>  trim($this->input->post('item_remark')),
                        'pre_challan_date' =>  trim($this->input->post('pre_challan_date')),
                        'pre_vendor_name' =>  trim($this->input->post('pre_vendor_name')),
                        'pre_supplier_name' =>  trim($this->input->post('pre_supplier_name')),
                        'pre_remark' =>  trim($this->input->post('pre_remark')),
                    );

                }else{

                    $data = array(
                        'description' =>  trim($this->input->post('description')),
                        'gross_weight' =>  trim($this->input->post('gross_weight')),
                        'net_weight' =>  trim($this->input->post('net_weight')),
                        'quantity' =>  trim($this->input->post('quantity')),
                        'number_of_bags' =>  trim($this->input->post('number_of_bags')),
                        'hsn_code' =>  trim($this->input->post('hsn_code')),
                        'estimated_value' =>  trim($this->input->post('estimated_value')),
                        'number_of_processing' =>  trim($this->input->post('number_of_processing')),
                        'remarks' =>  trim($this->input->post('item_remark')),
                        'pre_challan_date' =>  trim($this->input->post('pre_challan_date')),
                        'pre_vendor_name' =>  trim($this->input->post('pre_vendor_name')),
                        'pre_supplier_name' =>  trim($this->input->post('pre_supplier_name')),
                        'pre_remark' =>  trim($this->input->post('pre_remark')),
                    );

                }
                


                if(trim($this->input->post('scrap_item_id'))){
                    $scrap_item_id = trim($this->input->post('scrap_item_id'));
                }else{
                    $scrap_item_id = '';
                }

                
                $saveIncomingdetailsitem= $this->admin_model->saveNewscrapreturn($scrap_item_id,$data);

                if($saveIncomingdetailsitem){
                    $savescrapreturnitem_response['status'] = 'success';
                    $savescrapreturnitem_response['error'] = array('description'=>strip_tags(form_error('description')),'gross_weight'=>strip_tags(form_error('gross_weight')),'net_weight'=>strip_tags(form_error('net_weight')),'quantity'=>strip_tags(form_error('quantity')),'number_of_bags'=>strip_tags(form_error('number_of_bags')),'hsn_code'=>strip_tags(form_error('hsn_code')),'estimated_value'=>strip_tags(form_error('estimated_value')),'number_of_processing'=>strip_tags(form_error('number_of_processing')),'remark'=>strip_tags(form_error('remark')));
                }

            }
            echo json_encode($savescrapreturnitem_response);
        }
    }

    public function deletescrapreturnitem(){

        $post_submit = $this->input->post();
        if($post_submit){
            $result = $this->admin_model->deletescrapreturnitem(trim($this->input->post('id')));
            if ($result) {
                        $process = 'Delete Scrap Return Item';
                        $processFunction = 'Admin/deletescrapreturnitem';
                        $this->logrecord($process,$processFunction);
                    echo(json_encode(array('status'=>'success')));
                }
            else { echo(json_encode(array('status'=>'failed'))); }
        }else{
            echo(json_encode(array('status'=>'failed'))); 
        }



    }

    public function editscrapreturn($scrapreturnid){

        $process = 'Edit Scrap Return';
        $processFunction = 'Admin/editscrapreturn';
        $this->logrecord($process,$processFunction);
        $this->global['pageTitle'] = 'Edit Scrap Return';

        $data['supplierList']= $this->admin_model->fetchALLsupplierList();
        $data['vendorList']= $this->admin_model->fetchALLvendorList();
        $data['getScrapreturndetails']= $this->admin_model->getScrapreturndetails($scrapreturnid);
        $data['fetchALLprescrapreturndetailsforview']= $this->admin_model->fetchALLprescrapreturndetailsforview($scrapreturnid);

        $this->loadViews("masters/editscrapreturn", $this->global, $data, NULL);

    }

    public function currentorderstatus(){

        $process = 'Current Order Status';
        $processFunction = 'Admin/currentorderstatus';
        $this->global['pageTitle'] = 'Current Order Status';
        $data['vendorList']= $this->admin_model->fetchALLvendorList();
        $this->loadViews("masters/currentorderstatus", $this->global, $data, NULL);  

    }

    public function fetchvendorBillofmaterialforcurrentorderstatus($from_date,$to_date,$status){

        $params = $_REQUEST;
        $totalRecords = $this->admin_model->fetchvendorBillofmaterialforcurrentorderstatusCount($params,$from_date,$to_date,$status); 
        $queryRecords = $this->admin_model->fetchvendorBillofmaterialforcurrentorderstatusdata($params,$from_date,$to_date,$status); 

        $data = array();
        foreach ($queryRecords as $key => $value)
        {
            $i = 0;
            foreach($value as $v)
            {
                $data[$key][$i] = $v;
                $i++;
            }
        }
        $json_data = array(
            "draw"            => intval( $params['draw'] ),   
            "recordsTotal"    => intval( $totalRecords ),  
            "recordsFiltered" => intval($totalRecords),
            "data"            => $data   // total data array
            );
        echo json_encode($json_data);

    }

    public function fetchcurrentorderstatusreport($vendor_name,$status){

        $params = $_REQUEST;
        $totalRecords = $this->admin_model->fetchcurrentorderstatusreportcount($params,$vendor_name,$status); 
        $queryRecords = $this->admin_model->fetchcurrentorderstatusreportdata($params,$vendor_name,$status); 

        $data = array();
        foreach ($queryRecords as $key => $value)
        {
            $i = 0;
            foreach($value as $v)
            {
                $data[$key][$i] = $v;
                $i++;
            }
        }
        $json_data = array(
            "draw"            => intval( $params['draw'] ),   
            "recordsTotal"    => intval( $totalRecords ),  
            "recordsFiltered" => intval($totalRecords),
            "data"            => $data   // total data array
            );
        echo json_encode($json_data);

    }

    public function downlaod_current_orderstatus($vendor_name,$status) {

    
            // create file name
            $fileName = 'Current_Order_Status_Report -'.date('d-m-Y').'.xlsx';  
            // load excel library
            $empInfo = $this->admin_model->getallcurrentstatusorder($vendor_name,$status);
            $objPHPExcel = new PHPExcel();
            $objPHPExcel->setActiveSheetIndex(0);
            // set Header
            $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'Buyer Name');
            $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Buyer PO No');
            $objPHPExcel->getActiveSheet()->SetCellValue('C1', 'Buyer PO Date');
            $objPHPExcel->getActiveSheet()->SetCellValue('D1', 'Buyer Order Qty'); 
            $objPHPExcel->getActiveSheet()->SetCellValue('E1', 'Buyer Delivery Date');
            $objPHPExcel->getActiveSheet()->SetCellValue('F1', 'Raw Material Supplier');   
            $objPHPExcel->getActiveSheet()->SetCellValue('G1', 'Type Of Raw Material');  
            $objPHPExcel->getActiveSheet()->SetCellValue('H1', 'Gross Weight Per Pcs in Kgs');  
            $objPHPExcel->getActiveSheet()->SetCellValue('I1', 'Raw Material Order Qty');  
            $objPHPExcel->getActiveSheet()->SetCellValue('J1', 'Raw Material Actual Recd Qty');  
            $objPHPExcel->getActiveSheet()->SetCellValue('K1', 'Expected Qty');  
            $objPHPExcel->getActiveSheet()->SetCellValue('L1', 'Vendor Name');  
            $objPHPExcel->getActiveSheet()->SetCellValue('M1', 'Vendor PO Number');
            $objPHPExcel->getActiveSheet()->SetCellValue('N1', 'Vendor PO DATE');
            $objPHPExcel->getActiveSheet()->SetCellValue('O1', 'F G Part Description');
            $objPHPExcel->getActiveSheet()->SetCellValue('P1', 'FG Part No');
            $objPHPExcel->getActiveSheet()->SetCellValue('Q1', 'FG Order Quantity');
            $objPHPExcel->getActiveSheet()->SetCellValue('R1', 'Received Quantity');
            $objPHPExcel->getActiveSheet()->SetCellValue('S1', 'Net Weight Per Pcs in Kgs');
            $objPHPExcel->getActiveSheet()->SetCellValue('T1', 'Vendor Delivery Date');
            $objPHPExcel->getActiveSheet()->SetCellValue('U1', 'Remarks');
            $objPHPExcel->getActiveSheet()->SetCellValue('V1', 'Form Name');
            $objPHPExcel->getActiveSheet()->SetCellValue('W1', 'Status');
    

            // set Row
            $rowCount = 2;
            foreach ($empInfo as $element) {
                $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $element['buyer_name']);
                $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $element['buyer_po_number']);
                $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $element['buyer_po_date']);
                $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $element['buyer_order_qty']);
                $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $element['buyer_delivery_date']);
                $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, $element['raw_material_supplier']);
                $objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, $element['type_of_raw_material']);
                $objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, $element['gross_weight_per_pcs_in_Kgs']);
                $objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, $element['raw_material_order_qty']);
                $objPHPExcel->getActiveSheet()->SetCellValue('J' . $rowCount, $element['raw_material_actual_recd_qty']);
                $objPHPExcel->getActiveSheet()->SetCellValue('K' . $rowCount, $element['expected_qty']);
                $objPHPExcel->getActiveSheet()->SetCellValue('L' . $rowCount, $element['vendor']);
                $objPHPExcel->getActiveSheet()->SetCellValue('M' . $rowCount, $element['vendor_po']);
                $objPHPExcel->getActiveSheet()->SetCellValue('N' . $rowCount, $element['vendor_po_date']);
                $objPHPExcel->getActiveSheet()->SetCellValue('O' . $rowCount, $element['part_decription']);
                $objPHPExcel->getActiveSheet()->SetCellValue('P' . $rowCount, $element['part_number']);
                $objPHPExcel->getActiveSheet()->SetCellValue('Q' . $rowCount, $element['vendor_order_qty']);
                $objPHPExcel->getActiveSheet()->SetCellValue('R' . $rowCount, $element['vendor_received_qty']);
                $objPHPExcel->getActiveSheet()->SetCellValue('S' . $rowCount, $element['net_Weight_per_pcs_in_kgs']);
                // $objPHPExcel->getActiveSheet()->SetCellValue('T' . $rowCount, $element['vendor_PO_date']);
                $objPHPExcel->getActiveSheet()->SetCellValue('T' . $rowCount, $element['vendor_delivery_date']);
                $objPHPExcel->getActiveSheet()->SetCellValue('U' . $rowCount, $element['item_remark']);
                $objPHPExcel->getActiveSheet()->SetCellValue('V' . $rowCount, $element['form_name']);
                $objPHPExcel->getActiveSheet()->SetCellValue('W' . $rowCount, $element['bom_status']);

                
                $rowCount++;
            }

            foreach(range('A','W') as $columnID) {
                $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
			}
			/*********************Autoresize column width depending upon contents END***********************/
			
            $objPHPExcel->getActiveSheet()->getStyle('A1:W1')->getFont()->setBold(true); //Make heading font bold
			
			/*********************Add color to heading START**********************/
            $objPHPExcel->getActiveSheet()
						->getStyle('A1:W1')
						->getFill()
						->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
						->getStartColor()
						->setARGB('99ff99');


            $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
              
            header('Content-Type: application/vnd.ms-excel');
			header("Content-Disposition: attachment;Filename=$fileName.xls");
			header('Cache-Control: max-age=0');
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
			$objWriter->save('php://output');

    }
        
    public function reworkrejectionreturn(){
        $process = 'Rework Rejection Return Form';
        $processFunction = 'Admin/reworkrejectionreturn';
        $this->global['pageTitle'] = 'Rework Rejection Return Form';
        $this->loadViews("masters/reworkrejectionreturn", $this->global, $data, NULL);  
    }

    public function fetchreworkrejection(){
        $params = $_REQUEST;
        $totalRecords = $this->admin_model->getreworkrejectioncount($params); 
        $queryRecords = $this->admin_model->getreworkrejectiondata($params); 

        $data = array();
        foreach ($queryRecords as $key => $value)
        {
            $i = 0;
            foreach($value as $v)
            {
                $data[$key][$i] = $v;
                $i++;
            }
        }
        $json_data = array(
            "draw"            => intval( $params['draw'] ),   
            "recordsTotal"    => intval( $totalRecords ),  
            "recordsFiltered" => intval($totalRecords),
            "data"            => $data   // total data array
            );
        echo json_encode($json_data);

    }

    public function addneworkrejection(){

        $post_submit = $this->input->post();
        if($post_submit){

            $addnewreworkrejection_response = array();
            $this->form_validation->set_rules('challan_no','Challan No','trim|required');
            $this->form_validation->set_rules('challan_date','Challan Date','trim|required');
            $this->form_validation->set_rules('vendor_name','Vendor Name','trim');
            $this->form_validation->set_rules('vendor_po_number','Vendor PO Number','trim');
            $this->form_validation->set_rules('supplier_name','Supplier Name','trim');
            $this->form_validation->set_rules('supplier_po_number','Supplier PO Number','trim');
            $this->form_validation->set_rules('dispath_through','Dispath Through','trim');
            $this->form_validation->set_rules('total_weight','Total Weight','trim');
            $this->form_validation->set_rules('remark','Remark','trim');
            $this->form_validation->set_rules('vendor_supplier_name','vendor/supplier','trim|required');

            if($this->form_validation->run() == FALSE)
            {
                $addnewreworkrejection_response['status'] = 'failure';
                $addnewreworkrejection_response['error'] = array('challan_no'=>strip_tags(form_error('challan_no')),'challan_date'=>strip_tags(form_error('challan_date')),'vendor_name'=>strip_tags(form_error('vendor_name')),'vendor_po_number'=>strip_tags(form_error('vendor_po_number')),'supplier_name'=>strip_tags(form_error('supplier_name')),'supplier_po_number'=>strip_tags(form_error('supplier_po_number')),'dispath_through'=>strip_tags(form_error('dispath_through')),'total_weight'=>strip_tags(form_error('total_weight')),'total_bags'=>strip_tags(form_error('total_bags')),'remark'=>strip_tags(form_error('remark')));
           
            }else{

            
                $data = array(
                    'challan_no' =>  trim($this->input->post('challan_no')),
                    'challan_date' => trim($this->input->post('challan_date')),
                    'vendor_supplier_name'=>trim($this->input->post('vendor_supplier_name')),
                    'vendor_name' =>  trim($this->input->post('vendor_name')),
                    'vendor_po_number' =>  trim($this->input->post('vendor_po_number')),
                    'supplier_name' =>  trim($this->input->post('supplier_name')),
                    'supplier_po_number' =>  trim($this->input->post('supplier_po_number')),
                    'dispath_through' =>  trim($this->input->post('dispath_through')),
                    'total_weight' =>  trim($this->input->post('total_weight')),
                    'total_netweight_in_kgs' => trim($this->input->post('total_netweight_weight')),
                    'total_bags' =>  trim($this->input->post('total_bags')),
                    'remark' =>  trim($this->input->post('remark')),
                   
                );

                $reworkrejectionid = trim($this->input->post('reworkrejectionid'));

                if($reworkrejectionid){
                    $saveNewreworkrejection= $this->admin_model->saveNewreworkrejection($reworkrejectionid,$data);
                }else{
                    $saveNewreworkrejection= $this->admin_model->saveNewreworkrejection('',$data);
                }
                
                if($saveNewreworkrejection){

                 $update_last_inserted_id_rework_rejection = $this->admin_model->update_last_inserted_id_rework_rejection($saveNewreworkrejection);
                    if($update_last_inserted_id_rework_rejection){
                       $addnewreworkrejection_response['status'] = 'success';
                       $addnewreworkrejection_response['error'] = array('challan_no'=>strip_tags(form_error('challan_no')),'challan_date'=>strip_tags(form_error('challan_date')),'vendor_name'=>strip_tags(form_error('vendor_name')),'vendor_po_number'=>strip_tags(form_error('vendor_po_number')),'supplier_name'=>strip_tags(form_error('supplier_name')),'supplier_po_number'=>strip_tags(form_error('supplier_po_number')),'dispath_through'=>strip_tags(form_error('dispath_through')),'total_weight'=>strip_tags(form_error('total_weight')),'total_bags'=>strip_tags(form_error('total_bags')),'remark'=>strip_tags(form_error('remark')));
                    }
                }

            }

            echo json_encode($addnewreworkrejection_response);

        }else{

            $process = 'Add New Rework Rejection';
            $processFunction = 'Admin/addneworkrejection';
            $this->logrecord($process,$processFunction);
            $this->global['pageTitle'] = 'Add New Rework Rejection';
            $data['vendorList']= $this->admin_model->fetchALLvendorList();
            $data['supplierList']= $this->admin_model->fetchALLsupplierList();
            $data['getPreviousReworkreturnnumber']= $this->admin_model->getPreviousReworkreturnnumber();
            $data['getReworkRejectionitemslist']= $this->admin_model->getReworkRejectionitemslist();
            $this->loadViews("masters/addneworkrejection", $this->global, $data, NULL);

        }

    }

    public function deletereworkrejection(){

        $post_submit = $this->input->post();
        if($post_submit){
            $result = $this->admin_model->deletereworkrejection(trim($this->input->post('id')));
            if ($result) {
                        $process = 'Delete Rework Rejection';
                        $processFunction = 'Admin/deletereworkrejection';
                        $this->logrecord($process,$processFunction);
                    echo(json_encode(array('status'=>'success')));
                }
            else { echo(json_encode(array('status'=>'failed'))); }
        }else{
            echo(json_encode(array('status'=>'failed'))); 
        }


    }

    public function editreworkrejection($id){

        $process = 'Edit Rework Rejection';
        $processFunction = 'Admin/editreworkrejection';
        $this->logrecord($process,$processFunction);
        $this->global['pageTitle'] = 'Edit Rework Rejection';
        $data['vendorList']= $this->admin_model->fetchALLvendorList();
        $data['supplierList']= $this->admin_model->fetchALLsupplierList();
        $data['getReworkrejectiondetails']= $this->admin_model->getReworkrejectiondetails($id);
        $data['getReworkRejectionitemslistforedit']= $this->admin_model->getReworkRejectionitemslistforedit($id);
        // $data['fetchALLprescrapreturndetailsforview']= $this->admin_model->fetchALLprescrapreturndetailsforview($scrapreturnid);
        $this->loadViews("masters/editreworkrejection", $this->global, $data, NULL);

    }

    public function getbuyerpodetailsforvendorbillofmaterial(){

        $vendor_po_number=$this->input->post('vendor_po_number');
        if($vendor_po_number) {
			$vendor_po_number_data = $this->admin_model->getbuyerpodetailsforvendorbillofmaterial($vendor_po_number);

			if(count($vendor_po_number_data) >= 1) {
                //$content = $content.'<option value="">Select Vendor Name</option>';
				foreach($vendor_po_number_data as $value) {
					$content = $content.'<option value="'.$value["buyer_id"].'">'.$value["buyer"].'</option>';
				}
				echo $content;
			} else {
				echo 'failure';
			}
		} else {
			echo 'failure';
		}
        
    }

    public function getBuyerDetailsByvendorpoautofill(){

        $vendor_po_number=$this->input->post('vendor_po_number');
        if($vendor_po_number) {
			$vendor_po_number_data = $this->admin_model->getBuyerDetailsByvendorpoautofill($vendor_po_number);

			if(count($vendor_po_number_data) >= 1) {
                //$content = $content.'<option value="">Select Vendor Name</option>';
				foreach($vendor_po_number_data as $value) {
					$content = $content.'<option value="'.$value["id"].'">'.$value["sales_order_number"].'</option>';
				}
				echo $content;
			} else {
				echo 'failure';
			}
		} else {
			echo 'failure';
		}

    }

    public function getIncomingDetailsofbillofmaterial(){

        $vendor_po_number=$this->input->post('vendor_po_number');
        if($vendor_po_number) {
			$vendor_po_number_data = $this->admin_model->getIncomingDetailsofbillofmaterial($vendor_po_number);

			if(count($vendor_po_number_data) >= 1) {
                //$content = $content.'<option value="">Select Vendor Name</option>';
				foreach($vendor_po_number_data as $value) {
					$content = $content.'<option value="'.$value["id"].'">'.$value["incoming_details_id"].'</option>';
				}
				echo $content;
			} else {
				echo 'failure';
			}
		} else {
			echo 'failure';
		}
        
    }

    public function getSuppliergoodsreworkrejectionvendor(){
        if($this->input->post('part_number')) {
            $getPartNameBypartid = $this->admin_model->getSuppliergoodsreworkrejectionvendor($this->input->post('part_number'),$this->input->post('vendor_po_number'));
            if($getPartNameBypartid){
                $content = $getPartNameBypartid[0];
                echo json_encode($content);

            }else{
                echo 'failure';
            }
           
        } else {
            echo 'failure';
        }
    }

    public function getSuppliergoodsreworkrejectionsupplier(){


        $vendor_po_number=$this->input->post('vendor_po_number');
        $chekc_if_supplie_name = $this->admin_model->chekc_if_supplie_name_exits($vendor_po_number);

        if($chekc_if_supplie_name['supplier_po_number']){
          $flag ='Vendor';
        }else{
          $flag ='Supplier';
        }

        if($this->input->post('part_number')) {
            $getPartNameBypartid = $this->admin_model->getSuppliergoodsreworkrejectionsupplier($this->input->post('part_number'),$this->input->post('vendor_po_number'),$this->input->post('supplier_po_number'),$flag);
            if($getPartNameBypartid){
                $content = $getPartNameBypartid[0];
                echo json_encode($content);

            }else{
                echo 'failure';
            }
           
        } else {
            echo 'failure';
        }

    }

    public function savereworkrejectiontem(){

        $post_submit = $this->input->post();
        if($post_submit){

            $savereworkrejectiontem_response = array();

            $this->form_validation->set_rules('part_number','Part Number','trim|required');
            $this->form_validation->set_rules('description','Description','trim|required');
            $this->form_validation->set_rules('rejected_work_reason','Rejected Work Reason','trim|required');
            $this->form_validation->set_rules('quantity','Quantity','trim|required');
            $this->form_validation->set_rules('unit','Unit','trim|required');
            $this->form_validation->set_rules('rate','Rate','trim|required');
            $this->form_validation->set_rules('value','value','trim|required');
            $this->form_validation->set_rules('row_material_cost','row_material_cost','trim|required');
            $this->form_validation->set_rules('gst_rate','gst_rate','trim|required');
            $this->form_validation->set_rules('grand_total','gst_rate','trim|required');
            $this->form_validation->set_rules('item_remark','Item Remark','trim');

            if($this->form_validation->run() == FALSE)
            {
                $savereworkrejectiontem_response['status'] = 'failure';
                $savereworkrejectiontem_response['error'] = array('part_number'=>strip_tags(form_error('part_number')),'description'=>strip_tags(form_error('description')),'rejected_work_reason'=>strip_tags(form_error('rejected_work_reason')),'quantity'=>strip_tags(form_error('quantity')),'rate'=>strip_tags(form_error('rate')),'value'=>strip_tags(form_error('value')),'row_material_cost'=>strip_tags(form_error('row_material_cost')),'gst_rate'=>strip_tags(form_error('gst_rate')),'grand_total'=>strip_tags(form_error('grand_total')),'item_remark'=>strip_tags(form_error('item_remark')),'unit'=>strip_tags(form_error('unit')));
           
            }else{

                $reworkrejectionid =  trim($this->input->post('reworkrejectionid'));
                if($reworkrejectionid){
                    $data = array(
                        'part_number' =>  trim($this->input->post('part_number')),
                        'rework_rejection_id' =>  $reworkrejectionid,
                        'rejection_rework_reason' =>  trim($this->input->post('rejected_work_reason')),
                        'qty' =>  trim($this->input->post('quantity')),
                        'unit' =>  trim($this->input->post('unit')),
                        'rate' =>  trim($this->input->post('rate')),
                        'value' =>  trim($this->input->post('value')),
                        'row_material_cost' =>  trim($this->input->post('row_material_cost')),
                        'gst_rate' =>  trim($this->input->post('gst_rate')),
                        'gst_value' =>  trim($this->input->post('gst_val')),
                        'grand_total' =>  trim($this->input->post('grand_total')),
                        'item_remark' =>  trim($this->input->post('item_remark')),
                        'pre_challan_date' =>   trim($this->input->post('pre_challan_date')),
                        'pre_vendor_supplier_name ' =>   trim($this->input->post('pre_vendor_supplier_name')),
                        'pre_vendor_name' =>   trim($this->input->post('pre_vendor_name')),
                        'pre_vendor_po_number' =>    trim($this->input->post('pre_vendor_po_number')),
                        'pre_supplier_name' =>  trim($this->input->post('pre_supplier_name')),
                        'pre_supplier_po_number' =>    trim($this->input->post('pre_supplier_po_number')),
                        'pre_dispath_through' =>    trim($this->input->post('pre_dispath_through')),
                        'pre_total_weight' =>    trim($this->input->post('pre_total_weight')),
                        'pre_total_netweight' =>    trim($this->input->post('pre_total_netweight_weight')),
                        'pre_total_bags' =>    trim($this->input->post('pre_total_bags')),
                        'pre_remark' =>    trim($this->input->post('pre_remark')),
                    );
                }else{

                    $data = array(
                        'part_number' =>  trim($this->input->post('part_number')),
                         // 'description' =>  trim($this->input->post('description')),
                        'rejection_rework_reason' =>  trim($this->input->post('rejected_work_reason')),
                        'qty' =>  trim($this->input->post('quantity')),
                        'unit' =>  trim($this->input->post('unit')),
                        'rate' =>  trim($this->input->post('rate')),
                        'value' =>  trim($this->input->post('value')),
                        'row_material_cost' =>  trim($this->input->post('row_material_cost')),
                        'gst_rate' =>  trim($this->input->post('gst_rate')),
                        'gst_value' =>  trim($this->input->post('gst_val')),
                        'grand_total' =>  trim($this->input->post('grand_total')),
                        'item_remark' =>  trim($this->input->post('item_remark')),
                        'pre_challan_date' =>   trim($this->input->post('pre_challan_date')),
                        'pre_vendor_supplier_name ' =>   trim($this->input->post('pre_vendor_supplier_name')),
                        'pre_vendor_name' =>   trim($this->input->post('pre_vendor_name')),
                        'pre_vendor_po_number' =>    trim($this->input->post('pre_vendor_po_number')),
                        'pre_supplier_name' =>  trim($this->input->post('pre_supplier_name')),
                        'pre_supplier_po_number' =>    trim($this->input->post('pre_supplier_po_number')),
                        'pre_dispath_through' =>    trim($this->input->post('pre_dispath_through')),
                        'pre_total_weight' =>    trim($this->input->post('pre_total_weight')),
                        'pre_total_netweight' =>    trim($this->input->post('pre_total_netweight_weight')),
                        'pre_total_bags' =>    trim($this->input->post('pre_total_bags')),
                        'pre_remark' =>    trim($this->input->post('pre_remark')),
                    );
                }

                $rework_rejection_item_id = trim($this->input->post('rework_rejection_item_id'));
                if( $rework_rejection_item_id){
                    $reworkrejectionitemid = $rework_rejection_item_id;
                }else{
                    $reworkrejectionitemid = '';
                }

                $savereworkrejectionitemdetails= $this->admin_model->savereworkrejectionitemdetails($reworkrejectionitemid,$data);
                if($savereworkrejectionitemdetails){
                    $savereworkrejectiontem_response['status'] = 'success';
                    $savereworkrejectiontem_response['error'] = array('part_number'=>strip_tags(form_error('part_number')),'description'=>strip_tags(form_error('description')),'rejected_work_reason'=>strip_tags(form_error('rejected_work_reason')),'quantity'=>strip_tags(form_error('quantity')),'rate'=>strip_tags(form_error('rate')),'value'=>strip_tags(form_error('value')),'row_material_cost'=>strip_tags(form_error('row_material_cost')),'gst_rate'=>strip_tags(form_error('gst_rate')),'grand_total'=>strip_tags(form_error('grand_total')),'item_remark'=>strip_tags(form_error('item_remark')),'unit'=>strip_tags(form_error('unit')));
                }
            }
            echo json_encode($savereworkrejectiontem_response);
        }

    }

    public function deleteReworkRejectionitem(){
        $post_submit = $this->input->post();
        if($post_submit){
            $result = $this->admin_model->deleteReworkRejectionitem(trim($this->input->post('id')));
            if ($result) {
                        $process = 'Rework Rejection  Item Delete';
                        $processFunction = 'Admin/deleteReworkRejectionitem';
                        $this->logrecord($process,$processFunction);
                    echo(json_encode(array('status'=>'success')));
                }
            else { echo(json_encode(array('status'=>'failed'))); }
        }else{
            echo(json_encode(array('status'=>'failed'))); 
        }


    }

    public function challanform(){
        $process = 'Challan Form';
        $processFunction = 'Admin/challanform';
        $this->logrecord($process,$processFunction);
        $this->global['pageTitle'] = 'Challan Form';
        $this->loadViews("masters/challanform", $this->global, $data, NULL);  
    }

    public function fetchchallanform(){

        $params = $_REQUEST;
        $totalRecords = $this->admin_model->getchallanformcount($params); 
        $queryRecords = $this->admin_model->getchallanformdata($params); 

        $data = array();
        foreach ($queryRecords as $key => $value)
        {
            $i = 0;
            foreach($value as $v)
            {
                $data[$key][$i] = $v;
                $i++;
            }
        }
        $json_data = array(
            "draw"            => intval( $params['draw'] ),   
            "recordsTotal"    => intval( $totalRecords ),  
            "recordsFiltered" => intval($totalRecords),
            "data"            => $data   // total data array
            );
        echo json_encode($json_data);

    }

    public function addchallanform(){

        $post_submit = $this->input->post();
        if($post_submit){
            $addmewchallanform_response = array();
            $this->form_validation->set_rules('challan_no','Challan No','trim|required');
            $this->form_validation->set_rules('challan_date','Challan Date','trim|required');
            $this->form_validation->set_rules('vendor_name','Vendor Name','trim');
            $this->form_validation->set_rules('vendor_po_number','Vendor PO Number','trim');
            $this->form_validation->set_rules('supplier_name','Supplier Name','trim');
            $this->form_validation->set_rules('supplier_po_number','Supplier PO Number','trim');
            $this->form_validation->set_rules('remark','Remark','trim');
            $this->form_validation->set_rules('vendor_supplier_name','vendor/supplier','trim|required');
            $this->form_validation->set_rules('usp','USP','trim');

            if($this->form_validation->run() == FALSE)
            {
                $addmewchallanform_response['status'] = 'failure';
                $addmewchallanform_response['error'] = array('vendor_supplier_name'=>strip_tags(form_error('vendor_supplier_name')),'challan_no'=>strip_tags(form_error('challan_no')),'challan_date'=>strip_tags(form_error('challan_date')),'vendor_name'=>strip_tags(form_error('vendor_name')),'vendor_po_number'=>strip_tags(form_error('vendor_po_number')),'supplier_name'=>strip_tags(form_error('supplier_name')),'supplier_po_number'=>strip_tags(form_error('supplier_po_number')),'usp'=>strip_tags(form_error('usp')),'remark'=>strip_tags(form_error('remark')));
            }else{

                $data = array(
                    'challan_no' =>  trim($this->input->post('challan_no')),
                    'challan_date' => trim($this->input->post('challan_date')),
                    'vendor_supplier_type'=>trim($this->input->post('vendor_supplier_name')),
                    'vendor_name' =>  trim($this->input->post('vendor_name')),
                    'vendor_po_number' =>  trim($this->input->post('vendor_po_number')),
                    'supplier_name' =>  trim($this->input->post('supplier_name')),
                    'supplier_po_number' =>  trim($this->input->post('supplier_po_number')),
                    'usp_id'  =>  trim($this->input->post('usp')),
                    'remark' =>  trim($this->input->post('remark')),
                    'dispatched_by' =>  trim($this->input->post('dispatched_by')),
                    'total_gross_weight_in_kgs' =>  trim($this->input->post('total_gross_weight_in_kgs')),
                    'total_netweight_in_kgs' =>  trim($this->input->post('total_netweight_in_kgs')),
                    'no_of_bags_boxs_goni'  =>  trim($this->input->post('no_of_bags_boxs_goni')),

                );

                $challanformid = trim($this->input->post('challan_id'));
                if($challanformid){
                    $saveNewchallan= $this->admin_model->savechallanformdetails($challanformid,$data);
                    if($saveNewchallan){
                        $addmewchallanform_response['status'] = 'success';
                        $addmewchallanform_response['error'] = array('vendor_supplier_name'=>strip_tags(form_error('vendor_supplier_name')),'challan_no'=>strip_tags(form_error('challan_no')),'challan_date'=>strip_tags(form_error('challan_date')),'vendor_name'=>strip_tags(form_error('vendor_name')),'vendor_po_number'=>strip_tags(form_error('vendor_po_number')),'supplier_name'=>strip_tags(form_error('supplier_name')),'supplier_po_number'=>strip_tags(form_error('supplier_po_number')),'usp'=>strip_tags(form_error('usp')),'remark'=>strip_tags(form_error('remark')));
                    }
                }else{
                    $saveNewchallan= $this->admin_model->savechallanformdetails('',$data);
                    if($saveNewchallan){
                        $update_last_inserted_id_challan_form = $this->admin_model->update_last_inserted_id_challan_form($saveNewchallan);
                         if($update_last_inserted_id_challan_form){
                            $addmewchallanform_response['status'] = 'success';
                            $addmewchallanform_response['error'] = array('vendor_supplier_name'=>strip_tags(form_error('vendor_supplier_name')),'challan_no'=>strip_tags(form_error('challan_no')),'challan_date'=>strip_tags(form_error('challan_date')),'vendor_name'=>strip_tags(form_error('vendor_name')),'vendor_po_number'=>strip_tags(form_error('vendor_po_number')),'supplier_name'=>strip_tags(form_error('supplier_name')),'supplier_po_number'=>strip_tags(form_error('supplier_po_number')),'usp'=>strip_tags(form_error('usp')),'remark'=>strip_tags(form_error('remark')));
                         }
                     }
                }
            }
            echo json_encode($addmewchallanform_response);
        }else{
            $process = 'Add New Challan Form';
            $processFunction = 'Admin/addchallanform';
            $this->logrecord($process,$processFunction);
            $this->global['pageTitle'] = 'Add New Challan Form';
            $data['vendorList']= $this->admin_model->fetchALLvendorList();
            $data['supplierList']= $this->admin_model->fetchALLsupplierList();
            $data['getPreviousChallanform_number']= $this->admin_model->getPreviousChallanform_number();
            $data['getChallanformlist']= $this->admin_model->getChallanformlist();
            $data['getUSPmasterlist']= $this->admin_model->getUSPmasterlist();
            $this->loadViews("masters/addnewchallanform", $this->global, $data, NULL);
        }

    }

    public function deletechallanform(){

        $post_submit = $this->input->post();
        if($post_submit){
            $result = $this->admin_model->deletechallanform(trim($this->input->post('id')));
            if ($result) {
                        $process = 'Delete Challan Form';
                        $processFunction = 'Admin/deletechallanform';
                        $this->logrecord($process,$processFunction);
                    echo(json_encode(array('status'=>'success')));
                }
            else { echo(json_encode(array('status'=>'failed'))); }
        }else{
            echo(json_encode(array('status'=>'failed'))); 
        }
    }

    public function saveChallanformitem(){

        $post_submit = $this->input->post();
        if($post_submit){

            $savechallnitem_response = array();
            $this->form_validation->set_rules('part_number','Part Number','trim|required');
            $this->form_validation->set_rules('description','Description','trim|required');
            $this->form_validation->set_rules('type_of_raw_platting','Type of Raw Platting','trim');
            $this->form_validation->set_rules('row_material_cost','Row Material Cost','trim|required');
            $this->form_validation->set_rules('quantity','Quantity','trim|required');
            $this->form_validation->set_rules('rate','Rate','trim|required');
            $this->form_validation->set_rules('value','value','trim|required');
            $this->form_validation->set_rules('gst_rate','gst_rate','trim|required');
            $this->form_validation->set_rules('grand_total','gst_rate','trim|required');
            $this->form_validation->set_rules('item_remark','Item Remark','trim');

            if($this->form_validation->run() == FALSE)
            {
                $savechallnitem_response['status'] = 'failure';
                $savechallnitem_response['error'] = array('part_number'=>strip_tags(form_error('part_number')),'description'=>strip_tags(form_error('description')),'type_of_raw_platting'=>strip_tags(form_error('type_of_raw_platting')),'quantity'=>strip_tags(form_error('quantity')),'rate'=>strip_tags(form_error('rate')),'value'=>strip_tags(form_error('value')),'row_material_cost'=>strip_tags(form_error('row_material_cost')),'gst_rate'=>strip_tags(form_error('gst_rate')),'grand_total'=>strip_tags(form_error('grand_total')),'item_remark'=>strip_tags(form_error('item_remark')));
           
            }else{
                $challan_id =  trim($this->input->post('challan_id'));
                if($challan_id){
                    $data = array(
                        'part_number' =>  trim($this->input->post('part_number')),
                        'challan_id' =>  $challan_id,
                        'qty' =>  trim($this->input->post('quantity')),
                        'rate' =>  trim($this->input->post('rate')),
                        'value' =>  trim($this->input->post('value')),
                        'unit' =>  trim($this->input->post('unit')),
                        'type_of_raw_platting' =>  trim($this->input->post('type_of_raw_platting')),
                        'row_material_cost' =>  trim($this->input->post('row_material_cost')),
                        'gst_rate' =>  trim($this->input->post('gst_rate')),
                        'gst_value' =>  trim($this->input->post('gst_value')),
                        'grand_total' =>  trim($this->input->post('grand_total')),
                        'item_remark' =>  trim($this->input->post('item_remark')),
                        'pre_challan_date' =>   trim($this->input->post('pre_challan_date')),
                        'pre_vendor_supplier_name ' =>   trim($this->input->post('pre_vendor_supplier_name')),
                        'pre_vendor_name' =>   trim($this->input->post('pre_vendor_name')),
                        'pre_vendor_po_number' =>    trim($this->input->post('pre_vendor_po_number')),
                        'pre_supplier_name' =>  trim($this->input->post('pre_supplier_name')),
                        'pre_supplier_po_number' =>    trim($this->input->post('pre_supplier_po_number')),
                        'pre_usp_id' =>    trim($this->input->post('pre_usp_id')),
                        'pre_remark' =>    trim($this->input->post('pre_remark')),

                        'dispatched_by' =>    trim($this->input->post('dispatched_by')),
                        'total_gross_weight_in_kgs' =>    trim($this->input->post('total_gross_weight_in_kgs')),
                        'total_netweight_in_kgs' =>    trim($this->input->post('total_netweight_in_kgs')),
                        'no_of_bags_boxs_goni' =>    trim($this->input->post('no_of_bags_boxs_goni')),
                    );
                }else{

                    $data = array(
                        'part_number' =>  trim($this->input->post('part_number')),
                         // 'description' =>  trim($this->input->post('description')),
                        'qty' =>  trim($this->input->post('quantity')),
                        'rate' =>  trim($this->input->post('rate')),
                        'value' =>  trim($this->input->post('value')),
                        'unit' =>  trim($this->input->post('unit')),
                        'type_of_raw_platting' =>  trim($this->input->post('type_of_raw_platting')),
                        'row_material_cost' =>  trim($this->input->post('row_material_cost')),
                        'gst_rate' =>  trim($this->input->post('gst_rate')),
                        'gst_value' =>  trim($this->input->post('gst_value')),
                        'grand_total' =>  trim($this->input->post('grand_total')),
                        'item_remark' =>  trim($this->input->post('item_remark')),
                        'pre_challan_date' =>   trim($this->input->post('pre_challan_date')),
                        'pre_vendor_supplier_name ' =>   trim($this->input->post('pre_vendor_supplier_name')),
                        'pre_vendor_name' =>   trim($this->input->post('pre_vendor_name')),
                        'pre_vendor_po_number' =>    trim($this->input->post('pre_vendor_po_number')),
                        'pre_supplier_name' =>  trim($this->input->post('pre_supplier_name')),
                        'pre_supplier_po_number' =>    trim($this->input->post('pre_supplier_po_number')),
                        'pre_usp_id' =>    trim($this->input->post('pre_usp_id')),
                        'pre_remark' =>    trim($this->input->post('pre_remark')),

                        'pre_dispatched_by' =>    trim($this->input->post('dispatched_by')),
                        'pre_total_gross_weight_in_kgs' =>    trim($this->input->post('total_gross_weight_in_kgs')),
                        'pre_total_netweight_in_kgs' =>    trim($this->input->post('total_netweight_in_kgs')),
                        'pre_no_of_bags_boxs_goni' =>    trim($this->input->post('no_of_bags_boxs_goni')),
                    );
                }


                $challan_form_item_id = trim($this->input->post('challan_form_item_id'));
                if( $challan_form_item_id){
                    $challanformitemid = $challan_form_item_id;
                }else{
                    $challanformitemid = '';
                }

                $savechallanformitemdetails= $this->admin_model->savechallanformitemdetails($challanformitemid,$data);
                if($savechallanformitemdetails){
                    $savechallnitem_response['status'] = 'success';
                    $savechallnitem_response['error'] = array('part_number'=>strip_tags(form_error('part_number')),'description'=>strip_tags(form_error('description')),'type_of_raw_platting'=>strip_tags(form_error('type_of_raw_platting')),'quantity'=>strip_tags(form_error('quantity')),'rate'=>strip_tags(form_error('rate')),'value'=>strip_tags(form_error('value')),'row_material_cost'=>strip_tags(form_error('row_material_cost')),'gst_rate'=>strip_tags(form_error('gst_rate')),'grand_total'=>strip_tags(form_error('grand_total')),'item_remark'=>strip_tags(form_error('item_remark')));
                }
            }
            echo json_encode($savechallnitem_response);
        }

    }

    public Function editchallanform($id){
        $process = 'Edit Challan Form';
        $processFunction = 'Admin/editchallanform';
        $this->logrecord($process,$processFunction);
        $this->global['pageTitle'] = 'Edit Challan Form';
        $data['vendorList']= $this->admin_model->fetchALLvendorList();
        $data['supplierList']= $this->admin_model->fetchALLsupplierList();
        $data['getChallanformdetails']= $this->admin_model->getChallanformdetails($id);
        $data['getUSPmasterlist']= $this->admin_model->getUSPmasterlist();
        $data['getChallanformlistedit']= $this->admin_model->getChallanformlistedit($id);
        $this->loadViews("masters/editchallanform", $this->global, $data, NULL);

    }

    public function deleteChallanformitem(){

        $post_submit = $this->input->post();
        if($post_submit){
            $result = $this->admin_model->deleteChallanformitem(trim($this->input->post('id')));
            if ($result) {
                        $process = 'Delete Rework Rejection';
                        $processFunction = 'Admin/deleteChallanformitem';
                        $this->logrecord($process,$processFunction);
                    echo(json_encode(array('status'=>'success')));
                }
            else { echo(json_encode(array('status'=>'failed'))); }
        }else{
            echo(json_encode(array('status'=>'failed'))); 
        }

    }

    public function debitnote(){
        $process = 'Debit Note';
        $processFunction = 'Admin/debitnote';
        $this->logrecord($process,$processFunction);
        $this->global['pageTitle'] = 'Debit Note';
        $this->loadViews("masters/debitnote", $this->global, $data, NULL);  
    }

    public function addnewdebitnote(){

        $post_submit = $this->input->post();
        if($post_submit){
               $newdebitnote_response = array();

                $this->form_validation->set_rules('debit_note_number','Debit Note Number','trim|required');
                $this->form_validation->set_rules('debit_note_date','Debit Note Date','trim|required');
                // $this->form_validation->set_rules('select_with_po_without_po','With PO Without PO','trim');
                $this->form_validation->set_rules('vendor_supplier_name','Vendor/Supplier Name','trim|required');
                $this->form_validation->set_rules('vendor_name','Vendor Name','trim');
                $this->form_validation->set_rules('vendor_po_number','Vendor PO Number','trim');
                $this->form_validation->set_rules('supplier_name','Supplier Name','trim');
                $this->form_validation->set_rules('supplier_po_number','Supplier PO Number','trim');
                $this->form_validation->set_rules('po_date','PO Date','trim');
                $this->form_validation->set_rules('remark','Remark','trim');


                $this->form_validation->set_rules('total_debit_amount','Total Debit Amount','trim');
                $this->form_validation->set_rules('total_debit_amount_ok_qty','Total Debit Amount OK Qty','trim');
               // $this->form_validation->set_rules('p_and_f_charges','P_And F Charges','trim|required');
                $this->form_validation->set_rules('tds_amount','TDS Amount','trim');
                $this->form_validation->set_rules('freight_amount_charge','Freight Amount Charge','trim');
                $this->form_validation->set_rules('grand_total_main','Grand Total main','trim');


                if($this->form_validation->run() == FALSE)
                {
                    $newdebitnote_response['status'] = 'failure';
                    $newdebitnote_response['error'] = array('debit_note_number'=>strip_tags(form_error('debit_note_number')),'debit_note_date'=>strip_tags(form_error('debit_note_date')),'select_with_po_without_po'=>strip_tags(form_error('select_with_po_without_po')),'vendor_name'=>strip_tags(form_error('vendor_name')),'vendor_po_number'=>strip_tags(form_error('vendor_po_number')),'supplier_name'=>strip_tags(form_error('supplier_name')),'supplier_po_number'=>strip_tags(form_error('supplier_po_number')),'remark'=>strip_tags(form_error('remark')),'po_date'=>strip_tags(form_error('po_date')),'total_debit_amount'=>strip_tags(form_error('total_debit_amount')),'total_debit_amount_ok_qty'=>strip_tags(form_error('total_debit_amount_ok_qty')),'p_and_f_charges'=>strip_tags(form_error('p_and_f_charges')),'tds_amount'=>strip_tags(form_error('tds_amount')),'freight_amount_charge'=>strip_tags(form_error('freight_amount_charge')),'grand_total_main'=>strip_tags(form_error('grand_total_main')));
                }else{

                    $data = array(
                        'debit_note_number' =>  trim($this->input->post('debit_note_number')),
                        'debit_note_date' => trim($this->input->post('debit_note_date')),
                        // 'type'=>trim($this->input->post('select_with_po_without_po')),
                        'supplier_vendor_name' =>  trim($this->input->post('vendor_supplier_name')),
                        'vendor_id' =>  trim($this->input->post('vendor_name')),
                        'vendor_po' =>  trim($this->input->post('vendor_po_number')),
                        'supplier_id' =>  trim($this->input->post('supplier_name')),
                        'supplier_po' =>  trim($this->input->post('supplier_po_number')),
                        'po_date' =>  trim($this->input->post('po_date')),
                        'remark' =>  trim($this->input->post('remark')),
                        'total_debit_amount' =>  trim($this->input->post('total_debit_amount')),
                        'total_amount_of_ok_qty_amt' =>  trim($this->input->post('total_debit_amount_ok_qty')),
                        'chq_amount' => trim($this->input->post('chq_amt')),
                        'p_and_f_charges' =>  trim($this->input->post('p_and_f_charges')),
                        'tds_amount' =>  trim($this->input->post('tds_amount')),
                        'freight_amount_charge' =>  trim($this->input->post('freight_amount_charge')),
                        'grand_total_main' =>  trim($this->input->post('grand_total_main')),

                    );

                    $debit_id = trim($this->input->post('debit_id'));
                    if($debit_id){
                        $saveNewdebitnote= $this->admin_model->saveNewdebitnote($debit_id,$data);
                        if($saveNewdebitnote){
                            $newdebitnote_response['status'] = 'success';
                            $newdebitnote_response['error'] = array('debit_note_number'=>strip_tags(form_error('debit_note_number')),'debit_note_date'=>strip_tags(form_error('debit_note_date')),'select_with_po_without_po'=>strip_tags(form_error('select_with_po_without_po')),'vendor_name'=>strip_tags(form_error('vendor_name')),'vendor_po_number'=>strip_tags(form_error('vendor_po_number')),'supplier_name'=>strip_tags(form_error('supplier_name')),'supplier_po_number'=>strip_tags(form_error('supplier_po_number')),'remark'=>strip_tags(form_error('remark')),'po_date'=>strip_tags(form_error('po_date')),'total_debit_amount'=>strip_tags(form_error('total_debit_amount')),'total_debit_amount_ok_qty'=>strip_tags(form_error('total_debit_amount_ok_qty')),'p_and_f_charges'=>strip_tags(form_error('p_and_f_charges')),'tds_amount'=>strip_tags(form_error('tds_amount')),'freight_amount_charge'=>strip_tags(form_error('freight_amount_charge')),'grand_total_main'=>strip_tags(form_error('grand_total_main')));
                        }
                    }else{
                        $saveNewdebitnote= $this->admin_model->saveNewdebitnote('',$data);
                        if($saveNewdebitnote){
                            $update_last_inserted_id_debit_note = $this->admin_model->update_last_inserted_id_debit_note($saveNewdebitnote);
                            if($update_last_inserted_id_debit_note){
                                $newdebitnote_response['status'] = 'success';
                                $newdebitnote_response['error'] = array('debit_note_number'=>strip_tags(form_error('debit_note_number')),'debit_note_date'=>strip_tags(form_error('debit_note_date')),'select_with_po_without_po'=>strip_tags(form_error('select_with_po_without_po')),'vendor_name'=>strip_tags(form_error('vendor_name')),'vendor_po_number'=>strip_tags(form_error('vendor_po_number')),'supplier_name'=>strip_tags(form_error('supplier_name')),'supplier_po_number'=>strip_tags(form_error('supplier_po_number')),'remark'=>strip_tags(form_error('remark')),'po_date'=>strip_tags(form_error('po_date')),'total_debit_amount'=>strip_tags(form_error('total_debit_amount')),'total_debit_amount_ok_qty'=>strip_tags(form_error('total_debit_amount_ok_qty')),'p_and_f_charges'=>strip_tags(form_error('p_and_f_charges')),'tds_amount'=>strip_tags(form_error('tds_amount')),'freight_amount_charge'=>strip_tags(form_error('freight_amount_charge')),'grand_total_main'=>strip_tags(form_error('grand_total_main')));
                            }
                        }
                    }
                }
             echo json_encode($newdebitnote_response);
        }else{
            $process = 'Add New Debit Note';
            $processFunction = 'Admin/addnewdebitnote';
            $this->logrecord($process,$processFunction);
            $this->global['pageTitle'] = 'Add New Debit Note';
            $data['vendorList']= $this->admin_model->fetchALLvendorList();
            $data['supplierList']= $this->admin_model->fetchALLsupplierList();
            $data['getdebitnoteitemdetails']= $this->admin_model->getdebitnoteitemdetails();
            $data['getPreviousDebitnote_number'] = $this->admin_model->getPreviousDebitnote_number();
            $data['totalDebitAndokQty'] = $this->admin_model->getTotalDebitAndokQty()[0];
            $this->loadViews("masters/addnewdebitnote", $this->global, $data, NULL);
        }

    }

    public function fetchdebitnotedetails(){

        $params = $_REQUEST;
        $totalRecords = $this->admin_model->getdebitnotecount($params); 
        $queryRecords = $this->admin_model->getdebitnotedata($params); 

        $data = array();
        foreach ($queryRecords as $key => $value)
        {
            $i = 0;
            foreach($value as $v)
            {
                $data[$key][$i] = $v;
                $i++;
            }
        }
        $json_data = array(
            "draw"            => intval( $params['draw'] ),   
            "recordsTotal"    => intval( $totalRecords ),  
            "recordsFiltered" => intval($totalRecords),
            "data"            => $data   // total data array
            );
        echo json_encode($json_data);
    }

    public function paymentdetails(){
        $process = 'Payment Details';
        $processFunction = 'Admin/paymentdetails';
        $this->logrecord($process,$processFunction);
        $this->global['pageTitle'] = 'Payment Details';
        $this->loadViews("masters/paymentdetails", $this->global, $data, NULL);  
    }

    public function editdebitnoteform($id){

        $process = 'Edit Debit Note Form';
        $processFunction = 'Admin/editdebitnoteform';
        $this->logrecord($process,$processFunction);
        $this->global['pageTitle'] = 'Edit Debit Note Form';
        $data['vendorList']= $this->admin_model->fetchALLvendorList();
        $data['supplierList']= $this->admin_model->fetchALLsupplierList();
        $data['getdebitnoteditailsdata']= $this->admin_model->getdebitnoteditailsdata($id);
        $data['getdebitnoteitemdetailsedit']= $this->admin_model->getdebitnoteitemdetailsedit($id);
        $data['totalDebitAndokQty'] = $this->admin_model->getTotalDebitAndokQtyedit($id)[0];
        $this->loadViews("masters/editdebitnoteform", $this->global, $data, NULL);
    }

    public function deletedebitnote(){
        $post_submit = $this->input->post();
        if($post_submit){
            $result = $this->admin_model->deletedebitnote(trim($this->input->post('id')));
            if ($result) {
                        $process = 'Delete Debit Note';
                        $processFunction = 'Admin/deletedebitnote';
                        $this->logrecord($process,$processFunction);
                    echo(json_encode(array('status'=>'success')));
                }
            else { echo(json_encode(array('status'=>'failed'))); }
        }else{
            echo(json_encode(array('status'=>'failed'))); 
        }

    }

    public function saveDebitnoteitem(){

        $post_submit = $this->input->post();
        if($post_submit){

            $savdebitnoteitem_response = array();
            $this->form_validation->set_rules('part_number','Part Number','trim|required');
            $this->form_validation->set_rules('description','Description','trim');
            $this->form_validation->set_rules('invoice_no','Invoice No','trim|required');
            $this->form_validation->set_rules('invoice_date','Invoice Date','trim|required');
            $this->form_validation->set_rules('invoice_qty','Invoice Qty','trim|required');
            $this->form_validation->set_rules('ok_qty','Ok Qty','trim|required');
            $this->form_validation->set_rules('less_quantity','Less Quantity','trim|required');
            $this->form_validation->set_rules('rejected_quantity','Rejected Quantity','trim|required');
            $this->form_validation->set_rules('received_quantity','Received Quantity','trim|required');
            $this->form_validation->set_rules('rate','Rate','trim|required');
            $this->form_validation->set_rules('gst_rate','GST Rate','trim|required');
            $this->form_validation->set_rules('sgst_value','SGST Value','trim');
            $this->form_validation->set_rules('cgst_value','CGST Value','trim');
            $this->form_validation->set_rules('igst_rate','IGST Value','trim');
            $this->form_validation->set_rules('p_and_f_charges','P And F Charges','trim');
            $this->form_validation->set_rules('item_remark','Item Remark','trim');


            $this->form_validation->set_rules('total_qty_into_rate','Total Qty Into Rate','trim');
            $this->form_validation->set_rules('total_qty_normal_qty_plus_pnf','total_qty_normal_qty_plus_pnf','trim');
            $this->form_validation->set_rules('total_normal_gst_value','total_normal_gst_value','trim');
            $this->form_validation->set_rules('total_normal_gst_value_plus_total','total_normal_gst_value_plus_total','trim');



            if($this->form_validation->run() == FALSE)
            {
                $savdebitnoteitem_response['status'] = 'failure';
                $savdebitnoteitem_response['error'] = array('part_number'=>strip_tags(form_error('part_number')),'description'=>strip_tags(form_error('description')), 'invoice_no'=>strip_tags(form_error('invoice_no')), 'invoice_date'=>strip_tags(form_error('invoice_date')),'invoice_qty'=>strip_tags(form_error('invoice_qty')), 'ok_qty'=>strip_tags(form_error('ok_qty')), 'rejected_quantity'=>strip_tags(form_error('rejected_quantity')),'received_quantity'=>strip_tags(form_error('received_quantity')),'rate'=>strip_tags(form_error('rate')), 'gst_rate'=>strip_tags(form_error('gst_rate')),'sgst_value'=>strip_tags(form_error('sgst_value')),'cgst_value'=>strip_tags(form_error('cgst_value')),'igst_rate'=>strip_tags(form_error('igst_rate')),'grand_total'=>strip_tags(form_error('grand_total')),'item_remark'=>strip_tags(form_error('item_remark')));
           
            }else{

                $debit_id =  trim($this->input->post('debit_id'));
                if($debit_id){
                    $data = array(
                        'part_number' =>  trim($this->input->post('part_number')),
                        'debit_note_id' =>  trim($debit_id),
                        'invoice_no' =>  trim($this->input->post('invoice_no')),
                        'invoice_date' =>  trim($this->input->post('invoice_date')),
                        'invoice_qty' =>  trim($this->input->post('invoice_qty')),
                        'ok_qty' =>  trim($this->input->post('ok_qty')),
                        'less_quantity' =>  trim($this->input->post('less_quantity')),
                        'rejected_quantity' =>  trim($this->input->post('rejected_quantity')),
                        'received_quantity' =>  trim($this->input->post('received_quantity')),
                        'rate' =>  trim($this->input->post('rate')),
                        'gst_rate' =>  trim($this->input->post('gst_rate')),
                        'SGST_value' =>  trim($this->input->post('sgst_value')),
                        'CGST_value' =>  trim($this->input->post('cgst_value')),
                        'IGST_value' =>  trim($this->input->post('igst_rate')),
    
                        'SGST_value_ok_val' =>  trim($this->input->post('SGST_rate_ok')),
                        'CGST_value_ok_val' =>  trim($this->input->post('CGST_rate_ok')),
                        'IGST_value_ok_val' =>  trim($this->input->post('igst_rate_ok')),
                        'p_and_f_charges' =>  trim($this->input->post('p_and_f_charges')),
                        'total_amount_of_ok_qty_data' =>trim($this->input->post('rate')) * trim($this->input->post('ok_qty')),
                       // 'grand_total' =>  trim($this->input->post('grand_total')),
                        'total_amount_of_ok_qty' =>trim($this->input->post('total_ok_qty_amount')),
                        'debit_amount' =>  trim($this->input->post('debit_amount')),


                        'total_qty_into_rate' => trim($this->input->post('total_qty_into_rate')),
                        'total_qty_normal_qty_plus_pnf' => trim($this->input->post('total_qty_normal_qty_plus_pnf')),
                        'total_normal_gst_value' => trim($this->input->post('total_normal_gst_value')),
                        'total_normal_gst_value_plus_total' => trim($this->input->post('total_normal_gst_value_plus_total')),


                        'remark'=>  trim($this->input->post('item_remark')),
                        'pre_debit_note_date' =>   trim($this->input->post('pre_debit_note_date')),
                        'pre_select_with_po_without_po ' =>   trim($this->input->post('pre_select_with_po_without_po')),
                        'pre_vendor_supplier_name' =>   trim($this->input->post('pre_vendor_supplier_name')),
                        'pre_vendor_name' =>    trim($this->input->post('pre_vendor_name')),
                        'pre_vendor_po_number' =>  trim($this->input->post('pre_vendor_po_number')),
                        'pre_supplier_name' =>    trim($this->input->post('pre_supplier_name')),
                        'pre_supplier_po_number' =>    trim($this->input->post('pre_supplier_po_number')),
                        'pre_po_date' =>    trim($this->input->post('pre_po_date')),
                        'pre_remark' =>    trim($this->input->post('pre_remark')),
                    );


                }else{

                    $data = array(
                        'part_number' =>  trim($this->input->post('part_number')),
                        'invoice_no' =>  trim($this->input->post('invoice_no')),
                        'invoice_date' =>  trim($this->input->post('invoice_date')),
                        'invoice_qty' =>  trim($this->input->post('invoice_qty')),
                        'ok_qty' =>  trim($this->input->post('ok_qty')),
                        'less_quantity' =>  trim($this->input->post('less_quantity')),
                        'rejected_quantity' =>  trim($this->input->post('rejected_quantity')),
                        'received_quantity' =>  trim($this->input->post('received_quantity')),
                        'rate' =>  trim($this->input->post('rate')),
                        'gst_rate' =>  trim($this->input->post('gst_rate')),
                        'SGST_value' =>  trim($this->input->post('sgst_value')),
                        'CGST_value' =>  trim($this->input->post('cgst_value')),
                        'IGST_value' =>  trim($this->input->post('igst_rate')),
    
                        'SGST_value_ok_val' =>  trim($this->input->post('SGST_rate_ok')),
                        'CGST_value_ok_val' =>  trim($this->input->post('CGST_rate_ok')),
                        'IGST_value_ok_val' =>  trim($this->input->post('igst_rate_ok')),
                        'p_and_f_charges' =>  trim($this->input->post('p_and_f_charges')),
    


                        'total_qty_into_rate' => trim($this->input->post('total_qty_into_rate')),
                        'total_qty_normal_qty_plus_pnf' => trim($this->input->post('total_qty_normal_qty_plus_pnf')),
                        'total_normal_gst_value' => trim($this->input->post('total_normal_gst_value')),
                        'total_normal_gst_value_plus_total' => trim($this->input->post('total_normal_gst_value_plus_total')),
                        'total_amount_of_ok_qty_data' =>trim($this->input->post('rate')) * trim($this->input->post('ok_qty')),

                       // 'grand_total' =>  trim($this->input->post('grand_total')),
                        'total_amount_of_ok_qty' =>trim($this->input->post('total_ok_qty_amount')),
                        //'total_amount_of_ok_qty_data' =>trim($this->input->post('total_amount_of_ok_qty_data')),
                        'debit_amount' =>  trim($this->input->post('debit_amount')),
                        'remark'=>  trim($this->input->post('item_remark')),
                        'pre_debit_note_date' =>   trim($this->input->post('pre_debit_note_date')),
                        'pre_select_with_po_without_po ' =>   trim($this->input->post('pre_select_with_po_without_po')),
                        'pre_vendor_supplier_name' =>   trim($this->input->post('pre_vendor_supplier_name')),
                        'pre_vendor_name' =>    trim($this->input->post('pre_vendor_name')),
                        'pre_vendor_po_number' =>  trim($this->input->post('pre_vendor_po_number')),
                        'pre_supplier_name' =>    trim($this->input->post('pre_supplier_name')),
                        'pre_supplier_po_number' =>    trim($this->input->post('pre_supplier_po_number')),
                        'pre_po_date' =>    trim($this->input->post('pre_po_date')),
                        'pre_remark' =>    trim($this->input->post('pre_remark')),
                    );

                }

                $debit_note_item_id = trim($this->input->post('debit_note_item_id'));
                if( $debit_note_item_id){
                    $debitnoteitemid = $debit_note_item_id;
                }else{
                    $debitnoteitemid = '';
                }
                
                $savedebitnoteitemdetails= $this->admin_model->savedebitnoteitemdetails($debitnoteitemid,$data);
                if($savedebitnoteitemdetails){
                    $savdebitnoteitem_response['status'] = 'success';
                    $savdebitnoteitem_response['error'] = array('part_number'=>strip_tags(form_error('part_number')),'description'=>strip_tags(form_error('description')), 'invoice_no'=>strip_tags(form_error('invoice_no')), 'invoice_date'=>strip_tags(form_error('invoice_date')),'invoice_qty'=>strip_tags(form_error('invoice_qty')), 'ok_qty'=>strip_tags(form_error('ok_qty')), 'rejected_quantity'=>strip_tags(form_error('rejected_quantity')),'received_quantity'=>strip_tags(form_error('received_quantity')),'rate'=>strip_tags(form_error('rate')), 'gst_rate'=>strip_tags(form_error('gst_rate')),'sgst_value'=>strip_tags(form_error('sgst_value')),'cgst_value'=>strip_tags(form_error('cgst_value')),'igst_rate'=>strip_tags(form_error('igst_rate')),'grand_total'=>strip_tags(form_error('grand_total')),'item_remark'=>strip_tags(form_error('item_remark')));
                }

            }

            echo json_encode($savdebitnoteitem_response);
        }

    }

    public function deleteDebitnoteitem(){

        $post_submit = $this->input->post();
        if($post_submit){
            $result = $this->admin_model->deleteDebitnoteitem(trim($this->input->post('id')));
            if ($result) {
                        $process = 'Delete Debit Note Item';
                        $processFunction = 'Admin/deleteDebitnoteitem';
                        $this->logrecord($process,$processFunction);
                    echo(json_encode(array('status'=>'success')));
                }
            else { echo(json_encode(array('status'=>'failed'))); }
        }else{
            echo(json_encode(array('status'=>'failed'))); 
        }


    }

    public function fetchPaymentdetails(){
        $params = $_REQUEST;
        $totalRecords = $this->admin_model->getPaymentcount($params); 
        $queryRecords = $this->admin_model->getPaymentdata($params); 

        $data = array();
        foreach ($queryRecords as $key => $value)
        {
            $i = 0;
            foreach($value as $v)
            {
                $data[$key][$i] = $v;
                $i++;
            }
        }
        $json_data = array(
            "draw"            => intval( $params['draw'] ),   
            "recordsTotal"    => intval( $totalRecords ),  
            "recordsFiltered" => intval($totalRecords),
            "data"            => $data   // total data array
            );
        echo json_encode($json_data);

    }

    public function addNewpaymentdetails(){

        $post_submit = $this->input->post();
        if($post_submit){
               $paymentdetails_response = array();

                $this->form_validation->set_rules('payment_details_number','Payment Details Number','trim|required');
                $this->form_validation->set_rules('payment_details_date','Payment  Details Date','trim|required');
                //$this->form_validation->set_rules('select_with_po_without_po','With PO Without PO','trim|required');
                $this->form_validation->set_rules('vendor_supplier_name','Vendor/Supplier Name','trim|required');
                $this->form_validation->set_rules('vendor_name','Vendor Name','trim');
                $this->form_validation->set_rules('vendor_po_number','Vendor PO Number','trim');
                $this->form_validation->set_rules('supplier_name','Supplier Name','trim');
                $this->form_validation->set_rules('supplier_po_number','Supplier PO Number','trim');
                $this->form_validation->set_rules('po_date','PO Date','trim');
                $this->form_validation->set_rules('remark','Remark','trim');
                $this->form_validation->set_rules('bill_number','Bill Number','trim');
                $this->form_validation->set_rules('bill_date','Bill Date','trim');
                $this->form_validation->set_rules('bill_amount','Bill Amount','trim');
                $this->form_validation->set_rules('cheque_number','Cheque Number','trim');
                $this->form_validation->set_rules('cheque_date','Cheque Date','trim');
                $this->form_validation->set_rules('amount_paid','Amount Paid','trim');
                $this->form_validation->set_rules('tds','TDS','trim');
                $this->form_validation->set_rules('debit_note_amount','Debit Note Amount','trim');
                $this->form_validation->set_rules('debit_note_no','Debit Note No','trim');
                $this->form_validation->set_rules('payment_status','Payment Status','trim|required');

                if($this->form_validation->run() == FALSE)
                {
                    $paymentdetails_response['status'] = 'failure';
                    $paymentdetails_response['error'] = array('vendor_supplier_name'=>strip_tags(form_error('vendor_supplier_name')),'payment_details_number'=>strip_tags(form_error('payment_details_number')),'payment_details_date'=>strip_tags(form_error('payment_details_date')),'select_with_po_without_po'=>strip_tags(form_error('select_with_po_without_po')),'vendor_name'=>strip_tags(form_error('vendor_name')),'vendor_po_number'=>strip_tags(form_error('vendor_po_number')),'supplier_name'=>strip_tags(form_error('supplier_name')),'supplier_po_number'=>strip_tags(form_error('supplier_po_number')),'remark'=>strip_tags(form_error('remark')),'po_date'=>strip_tags(form_error('po_date')),'bill_number'=>strip_tags(form_error('bill_number')),'bill_date'=>strip_tags(form_error('bill_date')),'bill_amount'=>strip_tags(form_error('bill_amount')),'cheque_number'=>strip_tags(form_error('cheque_number')),'cheque_date'=>strip_tags(form_error('cheque_date')),'amount_paid'=>strip_tags(form_error('amount_paid')),'tds'=>strip_tags(form_error('tds')),'debit_note_amount'=>strip_tags(form_error('debit_note_amount')),'debit_note_no'=>strip_tags(form_error('debit_note_no')),'payment_status'=>strip_tags(form_error('payment_status')));
                }else{

                    if(trim($this->input->post('payment_details_id'))){
                        $payment_details_id_edit =trim($this->input->post('payment_details_id'));
                    }else{
                        $payment_details_id_edit ='';
                    }

                    $check_uniuqe_update_check= $this->admin_model->check_uniuqe_validation_payment_details_update($payment_details_id_edit,trim($this->input->post('bill_number')),trim($this->input->post('bill_date')),trim($this->input->post('vendor_supplier_name')),trim($this->input->post('vendor_po_number')),trim($this->input->post('supplier_po_number')));

                    if($check_uniuqe_update_check > 0){
                        //$paymentdetails_response['status'] = 'failure';
                        //$paymentdetails_response['error'] = array('bill_number'=>'Bill Number Alreday Exists','bill_date'=>'Bill Date Alreday Exists','vendor_po_number'=>'Vendor PO Number Alreday Exists','supplier_po_number'=>'Supplier PO Number Alreday Exists');
                
                
                        $data = array(
                            'payment_details_number' =>  trim($this->input->post('payment_details_number')),
                            'payment_details_date' => trim($this->input->post('payment_details_date')),
                            // 'type'=>trim($this->input->post('select_with_po_without_po')),
                            'supplier_vendor_name' =>  trim($this->input->post('vendor_supplier_name')),
                            'vendor_id' =>  trim($this->input->post('vendor_name')),
                            'vendor_po' =>  trim($this->input->post('vendor_po_number')),
                            'supplier_id' =>  trim($this->input->post('supplier_name')),
                            'supplier_po' =>  trim($this->input->post('supplier_po_number')),
                            'po_date' =>  trim($this->input->post('po_date')),
                            'bill_number' =>  trim($this->input->post('bill_number')),
                            'bill_date' =>  trim($this->input->post('bill_date')),
                            'bill_amount' =>  trim($this->input->post('bill_amount')),
                            'cheque_number' =>  trim($this->input->post('cheque_number')),
                            'cheque_date' =>  trim($this->input->post('cheque_date')),
                            'amount_paid'  =>  trim($this->input->post('amount_paid')),
                            'tds'  =>  trim($this->input->post('tds')),
                            'debit_note_amount'  =>  trim($this->input->post('debit_note_amount')),
                            'debit_note_no' =>  trim($this->input->post('debit_note_amount')),
                            'payment_status' =>  trim($this->input->post('payment_status')),
                            'remark' =>  trim($this->input->post('remark'))
                        );

                    
                        $saveNewdPaymentDetails= $this->admin_model->saveNewdPaymentDetails($payment_details_id_edit,$data);
                    
                        if($saveNewdPaymentDetails){
                            $paymentdetails_response['status'] = 'success';
                            $paymentdetails_response['error'] = array('vendor_supplier_name'=>strip_tags(form_error('vendor_supplier_name')),'payment_details_number'=>strip_tags(form_error('payment_details_number')),'payment_details_date'=>strip_tags(form_error('payment_details_date')),'select_with_po_without_po'=>strip_tags(form_error('select_with_po_without_po')),'vendor_name'=>strip_tags(form_error('vendor_name')),'vendor_po_number'=>strip_tags(form_error('vendor_po_number')),'supplier_name'=>strip_tags(form_error('supplier_name')),'supplier_po_number'=>strip_tags(form_error('supplier_po_number')),'remark'=>strip_tags(form_error('remark')),'po_date'=>strip_tags(form_error('po_date')),'bill_number'=>strip_tags(form_error('bill_number')),'bill_date'=>strip_tags(form_error('bill_date')),'bill_amount'=>strip_tags(form_error('bill_amount')),'cheque_number'=>strip_tags(form_error('cheque_number')),'cheque_date'=>strip_tags(form_error('cheque_date')),'amount_paid'=>strip_tags(form_error('amount_paid')),'tds'=>strip_tags(form_error('tds')),'debit_note_amount'=>strip_tags(form_error('debit_note_amount')),'debit_note_no'=>strip_tags(form_error('debit_note_no')),'payment_status'=>strip_tags(form_error('payment_status')));
                        }
                
                
                    }else{

                    /*check if duplicate payment details */
                    $check_uniuqe= $this->admin_model->check_uniuqe_validation_payment_details(trim($this->input->post('bill_number')),trim($this->input->post('bill_date')),trim($this->input->post('vendor_supplier_name')),trim($this->input->post('vendor_po_number')),trim($this->input->post('supplier_po_number')));

                    if( $check_uniuqe > 0){

                        $paymentdetails_response['status'] = 'failure';
                        $paymentdetails_response['error'] = array('bill_number'=>'Bill Number Alreday Exists','bill_date'=>'Bill Date Alreday Exists','vendor_po_number'=>'Vendor PO Number Alreday Exists','supplier_po_number'=>'Supplier PO Number Alreday Exists');
                   
                    }else{

                            $check_uniuqe_for_browser= $this->admin_model->checkforbrowserduplicate(trim($this->input->post('payment_details_number')));
                            if($check_uniuqe_for_browser){

                                if($check_uniuqe_for_browser[0]['payment_details_number']){

                                    $current_month = date("n");

                                    if ($current_month >= 4) {
                                        // If the current month is April or later, the financial year is from April (current year) to March (next year)
                                        $financial_year_indian = date("y") . "" . (date("y") + 1);
                                    } else {
                                        // If the current month is before April, the financial year is from April (last year) to March (current year)
                                        $financial_year_indian = (date("y") - 1) . "" . date("y");
                                    }

                                
                                    $string = $check_uniuqe_for_browser[0]['payment_details_number'];
                                    $n = 4; // Number of characters to extract from the end
                                    $lastNCharacters1 = substr($string, -$n);
                                    
                                    if($lastNCharacters1  > 0){

                                        if ($currentDate >= $financialYearStart && $currentDate <= $financialYearEnd) {

                                            $string1 =$check_uniuqe_for_browser[0]['payment_details_number'];
                                        }else{
                                            $string1 =0;
                                        }

                                    }else{
                                        $string1 =0;
                                    }

                                    $lastNCharacters = substr($string1, -$n);
                                    $inrno= "SQPN".$financial_year_indian.str_pad((int)$lastNCharacters+1, 4, 0, STR_PAD_LEFT);
                                    $payment_details_number = $inrno;
                                    $payment_details_number =   $inrno;


                                }else{

                                    $payment_details_number =  trim($this->input->post('payment_details_number'));
                                }

                            }else{

                                 $payment_details_number =  trim($this->input->post('payment_details_number'));
                            }


                    
                            $data = array(
                                'payment_details_number' =>  $payment_details_number,
                                'payment_details_date' => trim($this->input->post('payment_details_date')),
                                // 'type'=>trim($this->input->post('select_with_po_without_po')),
                                'supplier_vendor_name' =>  trim($this->input->post('vendor_supplier_name')),
                                'vendor_id' =>  trim($this->input->post('vendor_name')),
                                'vendor_po' =>  trim($this->input->post('vendor_po_number')),
                                'supplier_id' =>  trim($this->input->post('supplier_name')),
                                'supplier_po' =>  trim($this->input->post('supplier_po_number')),
                                'po_date' =>  trim($this->input->post('po_date')),
                                'bill_number' =>  trim($this->input->post('bill_number')),
                                'bill_date' =>  trim($this->input->post('bill_date')),
                                'bill_amount' =>  trim($this->input->post('bill_amount')),
                                'cheque_number' =>  trim($this->input->post('cheque_number')),
                                'cheque_date' =>  trim($this->input->post('cheque_date')),
                                'amount_paid'  =>  trim($this->input->post('amount_paid')),
                                'tds'  =>  trim($this->input->post('tds')),
                                'debit_note_amount'  =>  trim($this->input->post('debit_note_amount')),
                                'debit_note_no' =>  trim($this->input->post('debit_note_amount')),
                                'payment_status' =>  trim($this->input->post('payment_status')),
                                'remark' =>  trim($this->input->post('remark'))
                            );

                        
                            $saveNewdPaymentDetails= $this->admin_model->saveNewdPaymentDetails($payment_details_id_edit,$data);
                        
                            if($saveNewdPaymentDetails){
                                $paymentdetails_response['status'] = 'success';
                                $paymentdetails_response['error'] = array('vendor_supplier_name'=>strip_tags(form_error('vendor_supplier_name')),'payment_details_number'=>strip_tags(form_error('payment_details_number')),'payment_details_date'=>strip_tags(form_error('payment_details_date')),'select_with_po_without_po'=>strip_tags(form_error('select_with_po_without_po')),'vendor_name'=>strip_tags(form_error('vendor_name')),'vendor_po_number'=>strip_tags(form_error('vendor_po_number')),'supplier_name'=>strip_tags(form_error('supplier_name')),'supplier_po_number'=>strip_tags(form_error('supplier_po_number')),'remark'=>strip_tags(form_error('remark')),'po_date'=>strip_tags(form_error('po_date')),'bill_number'=>strip_tags(form_error('bill_number')),'bill_date'=>strip_tags(form_error('bill_date')),'bill_amount'=>strip_tags(form_error('bill_amount')),'cheque_number'=>strip_tags(form_error('cheque_number')),'cheque_date'=>strip_tags(form_error('cheque_date')),'amount_paid'=>strip_tags(form_error('amount_paid')),'tds'=>strip_tags(form_error('tds')),'debit_note_amount'=>strip_tags(form_error('debit_note_amount')),'debit_note_no'=>strip_tags(form_error('debit_note_no')),'payment_status'=>strip_tags(form_error('payment_status')));
                            }
                        }
                    }
                                      
                }
             echo json_encode($paymentdetails_response);
        }else{
            $process = 'Add New Payment Details';
            $processFunction = 'Admin/addNewpaymentdetails';
            $this->logrecord($process,$processFunction);
            $this->global['pageTitle'] = 'Add New Payment Details';
            $data['vendorList']= $this->admin_model->fetchALLvendorList();
            $data['supplierList']= $this->admin_model->fetchALLsupplierList();
            $data['getPreviousPaymentdetails_number'] = $this->admin_model->getPreviousPaymentdetails_number();
            $this->loadViews("masters/addNewpaymentdetails", $this->global, $data, NULL);
        }

    }

    public function editpaymentdetails($payment_details_id){
        $process = 'Edit Payment Details';
        $processFunction = 'Admin/editpaymentdetails';
        $this->logrecord($process,$processFunction);
        $this->global['pageTitle'] = 'Edit Payment Details';
        $data['vendorList']= $this->admin_model->fetchALLvendorList();
        $data['supplierList']= $this->admin_model->fetchALLsupplierList();
        $data['getPaymentdetails'] = $this->admin_model->getPaymentdetails($payment_details_id);
        $this->loadViews("masters/editpaymentdetails", $this->global, $data, NULL);

    }

    public function deletepaymentdetails(){

        $post_submit = $this->input->post();
        if($post_submit){
            $result = $this->admin_model->deletepaymentdetails(trim($this->input->post('id')));
            if ($result) {
                        $process = 'Delete Payment Details';
                        $processFunction = 'Admin/deletepaymentdetails';
                        $this->logrecord($process,$processFunction);
                    echo(json_encode(array('status'=>'success')));
                }
            else { echo(json_encode(array('status'=>'failed'))); }
        }else{
            echo(json_encode(array('status'=>'failed'))); 
        }
    }

    public function poddetails(){
        $process = 'POD Detials';
        $processFunction = 'Admin/poddetails';
        $this->logrecord($process,$processFunction);
        $this->global['pageTitle'] = 'POD Detials';
        $this->loadViews("masters/poddetails", $this->global, $data, NULL);  
    }

    public function fetchpoddetails(){
        $params = $_REQUEST;
        $totalRecords = $this->admin_model->getpoddetailscount($params); 
        $queryRecords = $this->admin_model->getpoddetailsdata($params); 

        $data = array();
        foreach ($queryRecords as $key => $value)
        {
            $i = 0;
            foreach($value as $v)
            {
                $data[$key][$i] = $v;
                $i++;
            }
        }
        $json_data = array(
            "draw"            => intval( $params['draw'] ),   
            "recordsTotal"    => intval( $totalRecords ),  
            "recordsFiltered" => intval($totalRecords),
            "data"            => $data   // total data array
            );
        echo json_encode($json_data);

    }

    public function addNewPODdetails(){

        $post_submit = $this->input->post();
        if($post_submit){
               $PODdetails_response = array();

                $this->form_validation->set_rules('POD_details_number','POD Details Number','trim|required');
                $this->form_validation->set_rules('POD_details_date','POD Details Date','trim|required');
                $this->form_validation->set_rules('vendor_supplier_name','Vendor/Supplier Name','trim|required');
                $this->form_validation->set_rules('vendor_name','Vendor Name','trim');
                $this->form_validation->set_rules('vendor_po_number','Vendor PO Number','trim');
                $this->form_validation->set_rules('supplier_name','Supplier Name','trim');
                $this->form_validation->set_rules('supplier_po_number','Supplier PO Number','trim');
                $this->form_validation->set_rules('po_date','PO Date','trim');
                $this->form_validation->set_rules('remark','Remark','trim');

                if($this->form_validation->run() == FALSE)
                {
                    $PODdetails_response['status'] = 'failure';
                    $PODdetails_response['error'] = array('POD_details_date'=>strip_tags(form_error('POD_details_date')),'POD_details_date'=>strip_tags(form_error('POD_details_date')),'select_with_po_without_po'=>strip_tags(form_error('select_with_po_without_po')),'vendor_name'=>strip_tags(form_error('vendor_name')),'vendor_po_number'=>strip_tags(form_error('vendor_po_number')),'supplier_name'=>strip_tags(form_error('supplier_name')),'supplier_po_number'=>strip_tags(form_error('supplier_po_number')),'remark'=>strip_tags(form_error('remark')),'po_date'=>strip_tags(form_error('po_date')));
                }else{

                    $data = array(
                        'POD_details_number' =>  trim($this->input->post('POD_details_number')),
                        'POD_details_date' => trim($this->input->post('POD_details_date')),
                        'supplier_vendor_name' =>  trim($this->input->post('vendor_supplier_name')),
                        'vendor_id' =>  trim($this->input->post('vendor_name')),
                        'vendor_po' =>  trim($this->input->post('vendor_po_number')),
                        'supplier_id' =>  trim($this->input->post('supplier_name')),
                        'supplier_po' =>  trim($this->input->post('supplier_po_number')),
                        'po_date' =>  trim($this->input->post('po_date')),
                        'remark' =>  trim($this->input->post('remark'))
                    );


                    if(trim($this->input->post('POD_details_id'))){

                        $POD_details_id = trim($this->input->post('POD_details_id'));

                    }else{
                        $POD_details_id = '';

                    }

                    $saveNewdPODDetails= $this->admin_model->saveNewdPODDetails($POD_details_id,$data);

                    if($saveNewdPODDetails){

                        $update_last_inserted_id_poddetails = $this->admin_model->update_last_inserted_id_poddetails($saveNewdPODDetails);
                        if($update_last_inserted_id_poddetails){

                            $PODdetails_response['status'] = 'success';
                            $PODdetails_response['error'] = array('POD_details_date'=>strip_tags(form_error('POD_details_date')),'POD_details_date'=>strip_tags(form_error('POD_details_date')),'select_with_po_without_po'=>strip_tags(form_error('select_with_po_without_po')),'vendor_name'=>strip_tags(form_error('vendor_name')),'vendor_po_number'=>strip_tags(form_error('vendor_po_number')),'supplier_name'=>strip_tags(form_error('supplier_name')),'supplier_po_number'=>strip_tags(form_error('supplier_po_number')),'remark'=>strip_tags(form_error('remark')),'po_date'=>strip_tags(form_error('po_date')));
                        }
                    }
                    
                }
             echo json_encode($PODdetails_response);
        }else{
            $process = 'Add New POD Details';
            $processFunction = 'Admin/addNewpaymentdetails';
            $this->logrecord($process,$processFunction);
            $this->global['pageTitle'] = 'Add New POD Details';
            $data['vendorList']= $this->admin_model->fetchALLvendorList();
            $data['supplierList']= $this->admin_model->fetchALLsupplierList();
            $data['getpoddetails']= $this->admin_model->getpoddetails();
            $data['getPreviousPODdetails_number'] = $this->admin_model->getPreviousPODdetails_number();
            $this->loadViews("masters/addnewPODdetails", $this->global, $data, NULL);
        }

    }

    public function savepoditem(){

        $post_submit = $this->input->post();
        if($post_submit){

            $savepoitem_response = array();

            $this->form_validation->set_rules('part_number','Part Number','trim|required');
            $this->form_validation->set_rules('order_qty','Order Qty','trim|required');
            $this->form_validation->set_rules('lot_no','Lot No','trim|required');
            $this->form_validation->set_rules('qty_recived','Qty Recived','trim|required');
            $this->form_validation->set_rules('unit','Unit','trim|required');
            $this->form_validation->set_rules('bill_no','Bill No','trim|required');
            $this->form_validation->set_rules('bill_date','Bill Date','trim|required');
            $this->form_validation->set_rules('short_excess_qty','Short Excess Qty','required|trim');
            $this->form_validation->set_rules('previous_short_excess_qty','Previous Short Excess Qty','trim');

            if($this->form_validation->run() == FALSE)
            {
                $savepoitem_response['status'] = 'failure';
                $savepoitem_response['error'] = array('part_number'=>strip_tags(form_error('part_number')),'description'=>strip_tags(form_error('description')), 'order_qty'=>strip_tags(form_error('order_qty')), 'lot_no'=>strip_tags(form_error('lot_no')),'qty_recived'=>strip_tags(form_error('qty_recived')), 'unit'=>strip_tags(form_error('unit')), 'bill_no'=>strip_tags(form_error('bill_no')),'bill_date'=>strip_tags(form_error('bill_date')),'short_excess_qty'=>strip_tags(form_error('short_excess_qty')), 'item_remark'=>strip_tags(form_error('item_remark')));
           
            }else{

                    $POD_details_id =  trim($this->input->post('POD_details_id'));
                    if($POD_details_id){
                        $POD_details_id_main =$POD_details_id;
                    }else{
                        $POD_details_id_main =NULL;
                    }

                    $data = array(
                        'part_number' =>  trim($this->input->post('part_number')),
                        'POD_id' => $POD_details_id_main,
                        'order_qty' =>  trim($this->input->post('order_qty')),
                        'lot_no' =>  trim($this->input->post('lot_no')),
                        'qty_recived' =>  trim($this->input->post('qty_recived')),
                        'unit' =>  trim($this->input->post('unit')),
                        'bill_no' =>  trim($this->input->post('bill_no')),
                        'bill_date' =>  trim($this->input->post('bill_date')),
                        'short_excess_qty' =>  trim($this->input->post('short_excess_qty')),
                        'previous_short_excess_qty' =>  trim($this->input->post('previous_short_excess_qty')),
                        'remark' =>  trim($this->input->post('item_remark')),
                        'pre_pod_date' =>   trim($this->input->post('pre_pod_date')),
                        'pre_vendor_supplier_name' =>   trim($this->input->post('pre_vendor_supplier_name')),
                        'pre_vendor_name' =>    trim($this->input->post('pre_vendor_name')),
                        'pre_vendor_po_number' =>  trim($this->input->post('pre_vendor_po_number')),
                        'pre_supplier_name' =>    trim($this->input->post('pre_supplier_name')),
                        'pre_supplier_po_number' =>    trim($this->input->post('pre_supplier_po_number')),
                        'pre_po_date' =>    trim($this->input->post('pre_po_date')),
                        'pre_remark' =>    trim($this->input->post('pre_remark')),
                    );

                    $poditems_id =  trim($this->input->post('poditems_id'));
                    if($poditems_id){
                        $poditemsid =$poditems_id;
                    }else{
                        $poditemsid =NULL;
                    }


                $savepoitem= $this->admin_model->savepoitem( $poditemsid,$data);
                if($savepoitem){
                    $savepoitem_response['status'] = 'success';
                    $savepoitem_response['error'] = array('part_number'=>strip_tags(form_error('part_number')),'description'=>strip_tags(form_error('description')), 'order_qty'=>strip_tags(form_error('order_qty')), 'lot_no'=>strip_tags(form_error('lot_no')),'qty_recived'=>strip_tags(form_error('qty_recived')), 'unit'=>strip_tags(form_error('unit')), 'bill_no'=>strip_tags(form_error('bill_no')),'bill_date'=>strip_tags(form_error('bill_date')),'short_excess_qty'=>strip_tags(form_error('short_excess_qty')), 'item_remark'=>strip_tags(form_error('item_remark')));
                }

            }

            echo json_encode($savepoitem_response);
        }

    }

    public function get_vendorpodata(){

        $vendor_po_id=$this->input->post('vendor_po_id');
        if($vendor_po_id) {
			$vendor_po_number_data = $this->admin_model->get_vendorpodata($vendor_po_id);

			if($vendor_po_number_data) {

                $content = $vendor_po_number_data[0];
                echo json_encode($content);
             
			} else {
				echo 'failure';
			}
		} else {
			echo 'failure';
		}


    }

    public function get_supplierpodata(){

        $supplier_po_id=$this->input->post('supplier_po_id');
        if($supplier_po_id) {
			$upplier_po_number_data = $this->admin_model->get_supplierpodata($supplier_po_id);

			if($upplier_po_number_data) {

                $content = $upplier_po_number_data[0];
                echo json_encode($content);
             
			} else {
				echo 'failure';
			}
		} else {
			echo 'failure';
		}
    }

    public function get_vendorpodata_with_debit_data(){

        $vendor_po_id=$this->input->post('vendor_po_id');
        $vendor_supplier_name=$this->input->post('vendor_supplier_name');
        $supplier_po_number=$this->input->post('supplier_po_number');
        if($vendor_po_id) {
			$vendor_po_number_data = $this->admin_model->get_vendorpodata_with_debit_data($vendor_po_id,$vendor_supplier_name,$supplier_po_number);

			if($vendor_po_number_data) {

                $content = $vendor_po_number_data[0];
                echo json_encode($content);
             
			} else {
				echo 'failure';
			}
		} else {
			echo 'failure';
		}


    }

    public function get_supplierpodata_debit_data(){

        $supplier_po_id=$this->input->post('supplier_po_id');
        if($supplier_po_id) {
			$upplier_po_number_data = $this->admin_model->get_supplierpodata_debit_data($supplier_po_id);

			if($upplier_po_number_data) {

                $content = $upplier_po_number_data[0];
                echo json_encode($content);
             
			} else {
				echo 'failure';
			}
		} else {
			echo 'failure';
		}


    }

    public function deletepoddetails(){

        $post_submit = $this->input->post();
        if($post_submit){
            $result = $this->admin_model->deletepoddetails(trim($this->input->post('id')));
            if ($result) {
                        $process = 'Delete POD Details';
                        $processFunction = 'Admin/deletepoddetails';
                        $this->logrecord($process,$processFunction);
                    echo(json_encode(array('status'=>'success')));
                }
            else { echo(json_encode(array('status'=>'failed'))); }
        }else{
            echo(json_encode(array('status'=>'failed'))); 
        }

    }

    public function deletePODitem(){
        $post_submit = $this->input->post();
        if($post_submit){
            $result = $this->admin_model->deletePODitem(trim($this->input->post('id')));
            if ($result) {
                        $process = 'Delete POD Item';
                        $processFunction = 'Admin/deletePODitem';
                        $this->logrecord($process,$processFunction);
                    echo(json_encode(array('status'=>'success')));
                }
            else { echo(json_encode(array('status'=>'failed'))); }
        }else{
            echo(json_encode(array('status'=>'failed'))); 
        }
    }

    public function editpoddetails($i){
        $process = 'edit POD Details';
        $processFunction = 'Admin/editpoddetails';
        $this->logrecord($process,$processFunction);
        $this->global['pageTitle'] = 'edit POD Details';
        $data['vendorList']= $this->admin_model->fetchALLvendorList();
        $data['supplierList']= $this->admin_model->fetchALLsupplierList();
        $data['getpoddetailsforedit']= $this->admin_model->getpoddetailsforedit($i)[0];
        $data['getpoddetailsforedititem']= $this->admin_model->getpoddetailsforedititem($i);
        $this->loadViews("masters/editpoddetails", $this->global, $data, NULL);

    }

    public function qualityrecord(){
        $process = 'Qulity Record';
        $processFunction = 'Admin/qualityrecord';
        $this->logrecord($process,$processFunction);
        $this->global['pageTitle'] = 'Qulity Record';
        $this->loadViews("masters/qualityrecord", $this->global, $data, NULL);  
    }
    
    public function addNewqualityrecord(){
        $post_submit = $this->input->post();
        if($post_submit){
               $qualitydetails_response = array();
                $this->form_validation->set_rules('QR_details_number','QR Number','trim|required');
                $this->form_validation->set_rules('QR_details_date','QR Date','trim|required');
                $this->form_validation->set_rules('vendor_name','Vendor Name','trim|required');
                $this->form_validation->set_rules('vendor_po_number','Vendor PO Number','trim|required');
                $this->form_validation->set_rules('po_date','PO Date','trim');
                $this->form_validation->set_rules('buyer_name','Buyer Name','trim');
                $this->form_validation->set_rules('buyer_po_number','Buyer PO Number','trim');
                $this->form_validation->set_rules('remark','Remark','trim');

                if($this->form_validation->run() == FALSE)
                {
                    $qualitydetails_response['status'] = 'failure';
                    $qualitydetails_response['error'] = array('QR_details_number'=>strip_tags(form_error('QR_details_number')),'QR_details_date'=>strip_tags(form_error('QR_details_date')),'vendor_name'=>strip_tags(form_error('vendor_name')),'vendor_po_number'=>strip_tags(form_error('vendor_po_number')),'po_date'=>strip_tags(form_error('po_date')),'buyer_name'=>strip_tags(form_error('buyer_name')),'buyer_po_number'=>strip_tags(form_error('buyer_po_number')),'remark'=>strip_tags(form_error('remark')));
                }else{

                    $data = array(
                        'quality_records_number' =>  trim($this->input->post('QR_details_number')),
                        'quality_records_date' => trim($this->input->post('QR_details_date')),
                        'vendor_id' =>  trim($this->input->post('vendor_name')),
                        'vendor_po' =>  trim($this->input->post('vendor_po_number')),
                        'po_date' =>  trim($this->input->post('po_date')),
                        'buyer_name' =>  trim($this->input->post('buyer_name')),
                        'buyer_po_number' =>  trim($this->input->post('buyer_po_number')),
                        'remark' =>  trim($this->input->post('remark'))
                    );

                    $quality_record_id = trim($this->input->post('quality_record_id'));

                    $saveualitydetails= $this->admin_model->saveualitydetails($quality_record_id,$data);
                    if($saveualitydetails){

                       if($saveualitydetails){
                            $update_last_inqulity_record = $this->admin_model->update_last_inqulity_record($saveualitydetails);
                            if($update_last_inqulity_record){
                                $qualitydetails_response['status'] = 'success';
                                 $qualitydetails_response['error'] = array('QR_details_number'=>strip_tags(form_error('QR_details_number')),'QR_details_date'=>strip_tags(form_error('QR_details_date')),'vendor_name'=>strip_tags(form_error('vendor_name')),'vendor_po_number'=>strip_tags(form_error('vendor_po_number')),'po_date'=>strip_tags(form_error('po_date')),'buyer_name'=>strip_tags(form_error('buyer_name')),'buyer_po_number'=>strip_tags(form_error('buyer_po_number')),'remark'=>strip_tags(form_error('remark')));
                            }
                        }
                    }
                    
                }
             echo json_encode($qualitydetails_response);
        }else{
            $process = 'Add New Qulity Record Form';
            $processFunction = 'Admin/addNewqualityrecord';
            $this->logrecord($process,$processFunction);
            $this->global['pageTitle'] = 'Add New Qulity Record Form';
            $data['vendorList']= $this->admin_model->fetchALLvendorList();
            $data['get_prevoius_QR_REcord']= $this->admin_model->get_prevoius_QR_REcord();
            $data['get_qulityrecorditemrecord']= $this->admin_model->get_qulityrecorditemrecord();
            $this->loadViews("masters/addnewqulityrecord", $this->global, $data, NULL);
        }
       
    }


    public function fetchqulityrecords(){
        $params = $_REQUEST;
        $totalRecords = $this->admin_model->getqulityformcount($params); 
        $queryRecords = $this->admin_model->getqulityformdata($params); 

        $data = array();
        foreach ($queryRecords as $key => $value)
        {
            $i = 0;
            foreach($value as $v)
            {
                $data[$key][$i] = $v;
                $i++;
            }
        }
        $json_data = array(
            "draw"            => intval( $params['draw'] ),   
            "recordsTotal"    => intval( $totalRecords ),  
            "recordsFiltered" => intval($totalRecords),
            "data"            => $data   // total data array
            );
        echo json_encode($json_data);
    }

    public function editqulityrecordform($qulity_record_id){
        $process = 'Edit Qulity Record Form';
        $processFunction = 'Admin/editqulityrecordform';
        $this->logrecord($process,$processFunction);
        $this->global['pageTitle'] = 'Edit Qulity Record Form';
        $data['vendorList']= $this->admin_model->fetchALLvendorList();
        $data['get_qulityrecorditemrecord_edit']= $this->admin_model->get_qulityrecorditemrecord_edit($qulity_record_id);
        $data['getqualityrecords_details']= $this->admin_model->getqualityrecords_details($qulity_record_id);
        $this->loadViews("masters/editnewqulityrecord", $this->global, $data, NULL);
    }

    public function deletequlityrecords(){
        $post_submit = $this->input->post();
        if($post_submit){
            $result = $this->admin_model->deletequlityrecords(trim($this->input->post('id')));
            if ($result) {
                        $process = 'Delete Quality Details';
                        $processFunction = 'Admin/deletequlityrecords';
                        $this->logrecord($process,$processFunction);
                    echo(json_encode(array('status'=>'success')));
                }
            else { echo(json_encode(array('status'=>'failed'))); }
        }else{
            echo(json_encode(array('status'=>'failed'))); 
        }
    }

    public function deletequalityrecordsitem(){
        $post_submit = $this->input->post();
        if($post_submit){
            $result = $this->admin_model->deletequalityrecordsitem(trim($this->input->post('id')));
            if ($result) {
                        $process = 'Delete Quality Details item';
                        $processFunction = 'Admin/deletequalityrecordsitem';
                        $this->logrecord($process,$processFunction);
                    echo(json_encode(array('status'=>'success')));
                }
            else { echo(json_encode(array('status'=>'failed'))); }
        }else{
            echo(json_encode(array('status'=>'failed'))); 
        }
    }

    public function savequlityrecorditem(){
        $post_submit = $this->input->post();
        if($post_submit){
            $savequlity_item_response = array();
            $this->form_validation->set_rules('part_number','Part Number','trim|required');
            $this->form_validation->set_rules('inspection_report_no','Inspection Report No','trim|required');
            $this->form_validation->set_rules('inspection_report_date','Inspection Report Date','trim|required');
            $this->form_validation->set_rules('lot_qty','Lot Qty','trim|required');
            $this->form_validation->set_rules('inspected_by','Inspected By','trim|required');
            $this->form_validation->set_rules('item_remark','Item Remark','trim');

            if($this->form_validation->run() == FALSE)
            {
                $savequlity_item_response['status'] = 'failure';
                $savequlity_item_response['error'] = array('part_number'=>strip_tags(form_error('part_number')),'description'=>strip_tags(form_error('description')), 'inspection_report_no'=>strip_tags(form_error('inspection_report_no')), 'inspection_report_date'=>strip_tags(form_error('inspection_report_date')),'lot_qty'=>strip_tags(form_error('lot_qty')), 'inspected_by'=>strip_tags(form_error('inspected_by')), 'item_remark'=>strip_tags(form_error('item_remark')));
           
            }else{

                if(trim($this->input->post('quality_record_id'))){
                    $data = array(
                        'part_number' =>  trim($this->input->post('part_number')),
                        'quality_records_id'=>trim($this->input->post('quality_record_id')),
                        'inspection_report_no' =>  trim($this->input->post('inspection_report_no')),
                        'inspection_report_date' =>  trim($this->input->post('inspection_report_date')),
                        'lot_qty' =>  trim($this->input->post('lot_qty')),
                        'inspected_by' =>  trim($this->input->post('inspected_by')),
                        'remark' =>  trim($this->input->post('item_remark')),
                        'pre_quality_records_date' =>  trim($this->input->post('pre_QR_details_date')),
                        'pre_vendor_name' =>  trim($this->input->post('pre_vendor_name')),
                        'pre_vendor_po_number' =>  trim($this->input->post('pre_vendor_po_number')),
                        'pre_po_date' =>  trim($this->input->post('pre_vedor_po_date')),
                        'pre_buyer_name' =>  trim($this->input->post('pre_buyer_name')),
                        'pre_buyer_po_number' =>  trim($this->input->post('pre_buyer_po_number')),
                        'pre_remark' =>  trim($this->input->post('pre_remark')),
                    );
    

                }else{

                    $data = array(
                        'part_number' =>  trim($this->input->post('part_number')),
                        'inspection_report_no' =>  trim($this->input->post('inspection_report_no')),
                        'inspection_report_date' =>  trim($this->input->post('inspection_report_date')),
                        'lot_qty' =>  trim($this->input->post('lot_qty')),
                        'inspected_by' =>  trim($this->input->post('inspected_by')),
                        'remark' =>  trim($this->input->post('item_remark')),
                        'pre_quality_records_date' =>  trim($this->input->post('pre_QR_details_date')),
                        'pre_vendor_name' =>  trim($this->input->post('pre_vendor_name')),
                        'pre_vendor_po_number' =>  trim($this->input->post('pre_vendor_po_number')),
                        'pre_po_date' =>  trim($this->input->post('pre_vedor_po_date')),
                        'pre_buyer_name' =>  trim($this->input->post('pre_buyer_name')),
                        'pre_buyer_po_number' =>  trim($this->input->post('pre_buyer_po_number')),
                        'pre_remark' =>  trim($this->input->post('pre_remark')),
                    );

                }

            
                $quality_record_item_id = trim($this->input->post('quality_record_item_id'));
                if( $quality_record_item_id){
                    $qualityrecorditemid = $quality_record_item_id;
                }else{
                    $qualityrecorditemid = '';
                }
                
               $savequlityrecorditem = $this->admin_model->savequlityrecorditem($qualityrecorditemid,$data);

               if($savequlityrecorditem){
                   $savequlity_item_response['status'] = 'success';
                   $savequlity_item_response['error'] = array('part_number'=>strip_tags(form_error('part_number')),'description'=>strip_tags(form_error('description')), 'inspection_report_no'=>strip_tags(form_error('inspection_report_no')), 'inspection_report_date'=>strip_tags(form_error('inspection_report_date')),'lot_qty'=>strip_tags(form_error('lot_qty')), 'inspected_by'=>strip_tags(form_error('inspected_by')), 'item_remark'=>strip_tags(form_error('item_remark')));
                }
            }
            echo json_encode($savequlity_item_response);
        }

    }

    public function getbuyerpodetailsforvendorstockform(){
        $vendor_po_number=$this->input->post('vendor_po_number');
        if($vendor_po_number) {
			$vendor_po_number_data = $this->admin_model->getbuyerpodetailsforvendorstockform($vendor_po_number);
			if(count($vendor_po_number_data) >= 1) {
				echo json_encode($vendor_po_number_data[0]);
			} else {
				echo 'failure';
			}
		} else {
			echo 'failure';
		}
    }

    public function getItemdetailsdependonvendorpoforstockform(){
        if($this->input->post('part_number')) {
            $getPartNameBypartid = $this->admin_model->getItemdetailsdependonvendorpoforstockform($this->input->post('part_number'),$this->input->post('vendor_po_number'),$this->input->post('vendor_name'));
        
            if($getPartNameBypartid){
                $content = $getPartNameBypartid[0];
                echo json_encode($content);

            }else{
                echo 'failure';
            }
           
        } else {
            echo 'failure';
        }

    }

    public function stockform(){
        $process = 'Stock Form';
        $processFunction = 'Admin/stockform';
        $this->logrecord($process,$processFunction);
        $this->global['pageTitle'] = 'Stock Form';
        $this->loadViews("masters/stockform", $this->global, $data, NULL);  
    }

    public function fetchstockformrecords(){
        $params = $_REQUEST;
        $totalRecords = $this->admin_model->getstockformcount($params); 
        $queryRecords = $this->admin_model->getstockformdata($params); 

        $data = array();
        foreach ($queryRecords as $key => $value)
        {
            $i = 0;
            foreach($value as $v)
            {
                $data[$key][$i] = $v;
                $i++;
            }
        }
        $json_data = array(
            "draw"            => intval( $params['draw'] ),   
            "recordsTotal"    => intval( $totalRecords ),  
            "recordsFiltered" => intval($totalRecords),
            "data"            => $data   // total data array
            );
        echo json_encode($json_data);
    }

    public function addNewstockform(){
        $post_submit = $this->input->post();
        if($post_submit){

            $newstockform_response = array();
            $this->form_validation->set_rules('stock_id','Stock Id','trim|required');
            $this->form_validation->set_rules('stock_date','Stock Date','trim|required');
            $this->form_validation->set_rules('vendor_name','Vendor Name','trim|required');
            $this->form_validation->set_rules('vendor_po_number','Vendor PO Number','trim');
            $this->form_validation->set_rules('vendor_po_date','Vendor PO Date','trim');
            $this->form_validation->set_rules('buyer_name','Buyer Name','trim');
            $this->form_validation->set_rules('buyer_po_number','Buyer PO Number','trim');
            $this->form_validation->set_rules('buyer_po_id','Buyer PO Id','trim');
            $this->form_validation->set_rules('buyer_po_date','Buyer PO Date','trim');
            $this->form_validation->set_rules('buyer_delivery_date','Buyer Delivery Date','trim');
            $this->form_validation->set_rules('Invoice_qty_in_pcs','Invoice_qty_in_pcs','trim');
            $this->form_validation->set_rules('Invoice_qty_in_kgs','Invoice_qty_in_kgs','trim');
            $this->form_validation->set_rules('actual_received_qty_in_pcs','actual_received_qty_in_pcs','trim');
            $this->form_validation->set_rules('actual_received_qty_in_kgs','actual_received_qty_in_kgs','trim');
            // $this->form_validation->set_rules('total_rejected_in_pcs','total_rejected_in_pcs','trim');
            // $this->form_validation->set_rules('total_rejected_in_pcs_kgs','total_rejected_in_pcs_kgs','trim');
            // $this->form_validation->set_rules('reday_for_export_pcs','reday_for_export_pcs','trim');
            // $this->form_validation->set_rules('reday_for_export_kgs','reday_for_export_kgs','trim');
            // $this->form_validation->set_rules('total_rejection_qty_kgs','total_rejection_qty_kgs','trim');
            // $this->form_validation->set_rules('total_export_qty_pcs','total_export_qty_pcs','trim');
            // $this->form_validation->set_rules('balance_qty_in_pics','balance_qty_in_pics','trim');
            // $this->form_validation->set_rules('balance_qty_in_kgs','balance_qty_in_kgs','trim');
            $this->form_validation->set_rules('remark','remark','trim');
          
            if($this->form_validation->run() == FALSE)
            {
                $newstockform_response['status'] = 'failure';
                $newstockform_response['error'] = array('stock_id'=>strip_tags(form_error('stock_id')),'stock_date'=>strip_tags(form_error('stock_date')),'vendor_name'=>strip_tags(form_error('vendor_name')),'vendor_po_number'=>strip_tags(form_error('vendor_po_number')),'vendor_po_date'=>strip_tags(form_error('vendor_po_date')),'buyer_name'=>strip_tags(form_error('buyer_name')),'buyer_po_number'=>strip_tags(form_error('buyer_po_number')),'buyer_po_date'=>strip_tags(form_error('buyer_po_date')),'buyer_delivery_date'=>strip_tags(form_error('buyer_delivery_date')),'Invoice_qty_in_pcs'=>strip_tags(form_error('Invoice_qty_in_pcs')),'Invoice_qty_in_kgs'=>strip_tags(form_error('Invoice_qty_in_kgs')),'actual_received_qty_in_pcs'=>strip_tags(form_error('actual_received_qty_in_pcs')),'actual_received_qty_in_kgs'=>strip_tags(form_error('actual_received_qty_in_kgs')),'total_rejected_in_pcs'=>strip_tags(form_error('total_rejected_in_pcs')),'total_rejected_in_pcs_kgs'=>strip_tags(form_error('total_rejected_in_pcs_kgs')),'reday_for_export_pcs'=>strip_tags(form_error('reday_for_export_pcs')),'reday_for_export_kgs'=>strip_tags(form_error('reday_for_export_kgs')),'total_rejection_qty_kgs'=>strip_tags(form_error('total_rejection_qty_kgs')),'total_export_qty_pcs'=>strip_tags(form_error('total_export_qty_pcs')),'balance_qty_in_pics'=>strip_tags(form_error('balance_qty_in_pics')),'balance_qty_in_kgs'=>strip_tags(form_error('balance_qty_in_kgs')),'remark'=>strip_tags(form_error('remark')));

            }else{
                $stock_id = trim($this->input->post('stock_id_main'));
                if($stock_id){

                    $data = array(
                        //'stock_id_number' => trim($this->input->post('stock_id')),
                        'stock_date' => trim($this->input->post('stock_date')),
                        'vendor_name' => trim($this->input->post('vendor_name')),
                        'vendor_po_number' => trim($this->input->post('vendor_po_number')),
                        'vendor_po_date' => trim($this->input->post('vendor_po_date')),
                        'buyer_name' => trim($this->input->post('buyer_name')),
                        'buyer_po_number' => trim($this->input->post('buyer_po_id')),
                        'buyer_po_date' => trim($this->input->post('buyer_po_date')),
                        'buyer_delivery_date' => trim($this->input->post('buyer_delivery_date')),
                        'Invoice_qty_in_pcs' => trim($this->input->post('Invoice_qty_in_pcs')),
                        'Invoice_qty_in_kgs' => trim($this->input->post('Invoice_qty_in_kgs')),
                        'actual_received_qty_in_pcs'  => trim($this->input->post('actual_received_qty_in_pcs')),
                        'actual_received_qty_in_kgs'  => trim($this->input->post('actual_received_qty_in_kgs')),
                        // 'total_rejected_in_pcs'  => trim($this->input->post('total_rejected_in_pcs')),
                        // 'total_rejected_in_pcs_kgs' => trim($this->input->post('total_rejected_in_pcs_kgs')),
                        // 'reday_for_export_pcs' => trim($this->input->post('reday_for_export_pcs')),
                        // 'reday_for_export_kgs' => trim($this->input->post('reday_for_export_kgs')),
                        // 'total_rejection_qty_kgs' => trim($this->input->post('total_rejection_qty_kgs')),
                        // 'total_export_qty_pcs' => trim($this->input->post('total_export_qty_pcs')),
                        // 'balance_qty_in_pics'  => trim($this->input->post('balance_qty_in_pics')),
                        // 'balance_qty_in_kgs' => trim($this->input->post('balance_qty_in_kgs')),
                        'remark' => trim($this->input->post('remark')),
                    );

                    $savestockform= $this->admin_model->savestockform($stock_id,$data);
                }else{
                    $data = array(
                        'stock_id_number' => trim($this->input->post('stock_id')),
                        'stock_date' => trim($this->input->post('stock_date')),
                        'vendor_name' => trim($this->input->post('vendor_name')),
                        'vendor_po_number' => trim($this->input->post('vendor_po_number')),
                        'vendor_po_date' => trim($this->input->post('vendor_po_date')),
                        'buyer_name' => trim($this->input->post('buyer_name')),
                        'buyer_po_number' => trim($this->input->post('buyer_po_id')),
                        'buyer_po_date' => trim($this->input->post('buyer_po_date')),
                        'buyer_delivery_date' => trim($this->input->post('buyer_delivery_date')),
                        'Invoice_qty_in_pcs' => trim($this->input->post('Invoice_qty_in_pcs')),
                        'Invoice_qty_in_kgs' => trim($this->input->post('Invoice_qty_in_kgs')),
                        'actual_received_qty_in_pcs'  => trim($this->input->post('actual_received_qty_in_pcs')),
                        'actual_received_qty_in_kgs'  => trim($this->input->post('actual_received_qty_in_kgs')),
                        // 'total_rejected_in_pcs'  => trim($this->input->post('total_rejected_in_pcs')),
                        // 'total_rejected_in_pcs_kgs' => trim($this->input->post('total_rejected_in_pcs_kgs')),
                        // 'reday_for_export_pcs' => trim($this->input->post('reday_for_export_pcs')),
                        // 'reday_for_export_kgs' => trim($this->input->post('reday_for_export_kgs')),
                        // 'total_rejection_qty_kgs' => trim($this->input->post('total_rejection_qty_kgs')),
                        // 'total_export_qty_pcs' => trim($this->input->post('total_export_qty_pcs')),
                        // 'balance_qty_in_pics'  => trim($this->input->post('balance_qty_in_pics')),
                        // 'balance_qty_in_kgs' => trim($this->input->post('balance_qty_in_kgs')),
                        'remark' => trim($this->input->post('remark')),
                    );

                    $savestockform= $this->admin_model->savestockform('',$data);
                }
               
                if($savestockform){
                    $update_last_inserted_id_stock_from = $this->admin_model->update_last_inserted_id_stock_from($savestockform);
                    if($update_last_inserted_id_stock_from){
                            $newstockform_response['status'] = 'success';
                            $newstockform_response['error'] = array('stock_id'=>strip_tags(form_error('stock_id')),'stock_date'=>strip_tags(form_error('stock_date')),'vendor_name'=>strip_tags(form_error('vendor_name')),'vendor_po_number'=>strip_tags(form_error('vendor_po_number')),'vendor_po_date'=>strip_tags(form_error('vendor_po_date')),'buyer_name'=>strip_tags(form_error('buyer_name')),'buyer_po_number'=>strip_tags(form_error('buyer_po_number')),'buyer_po_date'=>strip_tags(form_error('buyer_po_date')),'buyer_delivery_date'=>strip_tags(form_error('buyer_delivery_date')),'Invoice_qty_in_pcs'=>strip_tags(form_error('Invoice_qty_in_pcs')),'Invoice_qty_in_kgs'=>strip_tags(form_error('Invoice_qty_in_kgs')),'actual_received_qty_in_pcs'=>strip_tags(form_error('actual_received_qty_in_pcs')),'actual_received_qty_in_kgs'=>strip_tags(form_error('actual_received_qty_in_kgs')),'total_rejected_in_pcs'=>strip_tags(form_error('total_rejected_in_pcs')),'total_rejected_in_pcs_kgs'=>strip_tags(form_error('total_rejected_in_pcs_kgs')),'reday_for_export_pcs'=>strip_tags(form_error('reday_for_export_pcs')),'reday_for_export_kgs'=>strip_tags(form_error('reday_for_export_kgs')),'total_rejection_qty_kgs'=>strip_tags(form_error('total_rejection_qty_kgs')),'total_export_qty_pcs'=>strip_tags(form_error('total_export_qty_pcs')),'balance_qty_in_pics'=>strip_tags(form_error('balance_qty_in_pics')),'balance_qty_in_kgs'=>strip_tags(form_error('balance_qty_in_kgs')),'remark'=>strip_tags(form_error('remark')));
                    }
                }
            }
            echo json_encode($newstockform_response);
        }else{
            $process = 'Add New Stock Form';
            $processFunction = 'Admin/addNewstockform';
            $this->logrecord($process,$processFunction);
            $this->global['pageTitle'] = 'Add New Stock Form';
            $data['vendorList']= $this->admin_model->fetchALLvendorList();
            $data['getPriviousstockid']= $this->admin_model->getPriviousstockid();
            $data['getItemlistStockform']= $this->admin_model->getItemlistStockform();
            $data['getStockforminformation']= $this->admin_model->getStockforminformation();
            $data['getAlltotalcalculation']= $this->admin_model->getAlltotalcalculation();
            $this->loadViews("masters/addNewstockform", $this->global, $data, NULL);
        }

    }

    public function editstcokformdetails($stock_id){

        $process = 'Edit Stock Form';
        $processFunction = 'Admin/editstcokformdetails';
        $this->logrecord($process,$processFunction);
        $this->global['pageTitle'] = 'Edit Stock Form';
        $data['vendorList']= $this->admin_model->fetchALLvendorList();
        $data['getItemlistStockformedit']= $this->admin_model->getItemlistStockformedit($stock_id);
        $data['getStockdetailsData']= $this->admin_model->getStockdetailsData($stock_id);
        $data['getAlltotalcalculation']= $this->admin_model->getAlltotalcalculationedit($stock_id);
        $this->loadViews("masters/editStockform", $this->global, $data, NULL);
    }

    public function saveStockformitem(){
        $post_submit = $this->input->post();
        if($post_submit){

            $saveStockformitem_response = array();
             $this->form_validation->set_rules('part_number','Part Number','trim|required');            
             $this->form_validation->set_rules('buyre_order_qty','Part Number','trim');
             $this->form_validation->set_rules('fg_order_qty','FG Order Qty','trim');
             $this->form_validation->set_rules('invoice_number','Invoice Number','trim');
             $this->form_validation->set_rules('invoice_date','Invoice Date','trim');
             $this->form_validation->set_rules('invoice_qty_in_pcs','Invoice Qty In Pcs','trim');
             $this->form_validation->set_rules('invoice_qty_in_kgs','Invoice Qty In kgs','trim');
             $this->form_validation->set_rules('lot_number','Lot Number','trim');
             $this->form_validation->set_rules('actaul_recived_qty_in_pics','Actaul Recived Qty In Pics','trim');
             $this->form_validation->set_rules('actaul_recived_qty_in_kgs','Actaul Recived Qty In Kgs','trim');
             $this->form_validation->set_rules('privious_balenace','Privious Balenace','trim');
             $this->form_validation->set_rules('itemremark','Ite Remark','trim');

            if($this->form_validation->run() == FALSE)
            {
                $saveStockformitem_response['status'] = 'failure';
                $saveStockformitem_response['error'] =  array('part_number'=>strip_tags(form_error('part_number')),'buyre_order_qty'=>strip_tags(form_error('buyre_order_qty')),'fg_order_qty'=>strip_tags(form_error('fg_order_qty')),'invoice_number'=>strip_tags(form_error('invoice_number')),'invoice_date'=>strip_tags(form_error('invoice_date')),'invoice_qty_in_pcs'=>strip_tags(form_error('invoice_qty_in_pcs')),'invoice_qty_in_kgs'=>strip_tags(form_error('invoice_qty_in_kgs')),'lot_number'=>strip_tags(form_error('lot_number')),'actaul_recived_qty_in_pics'=>strip_tags(form_error('actaul_recived_qty_in_pics')),'actaul_recived_qty_in_kgs'=>strip_tags(form_error('actaul_recived_qty_in_kgs')),'privious_balenace'=>strip_tags(form_error('privious_balenace')),'itemremark'=>strip_tags(form_error('itemremark')));
           
            }else{
                    $stock_id = trim($this->input->post('stock_id'));

                    if($stock_id){

                        $data = array(
                            'stock_form_id'  =>  trim($this->input->post('stock_id')),
                            'part_number'  =>  trim($this->input->post('part_number')),
                            'buyer_order_qty'  =>  trim($this->input->post('buyre_order_qty')),
                            'f_g_order_qty'  =>  trim($this->input->post('fg_order_qty')),
                            'invoice_number'  =>  trim($this->input->post('invoice_number')),
                            'invoice_date'  =>  trim($this->input->post('invoice_date')),
                            'invoice_qty_in_pcs'  =>  trim($this->input->post('invoice_qty_in_pcs')),
                            'invoice_qty_in_kgs'  =>  trim($this->input->post('invoice_qty_in_kgs')),
                            'lot_number'  =>  trim($this->input->post('lot_number')),
                            'actual_received_qty_in_pcs'  =>  trim($this->input->post('actaul_recived_qty_in_pics')),
                            'actual_received_qty_in_kgs'  =>  trim($this->input->post('actaul_recived_qty_in_kgs')),
                            'previous_balence'  =>  trim($this->input->post('privious_balenace')),
                            'item_remark' =>  trim($this->input->post('itemremark')),
    
                            'pre_stock_date'=>trim($this->input->post('pre_stock_date')),
                            'pre_vendor_name'=>trim($this->input->post('pre_vendor_name')),
                            'pre_vendor_po_number'=>trim($this->input->post('pre_vendor_po_number')),
                            'pre_vendor_po_date'=>trim($this->input->post('pre_vendor_po_date')),
    
                            'pre_buyer_name'=>trim($this->input->post('pre_buyer_name')),
                            'pre_buyer_po_id'=>trim($this->input->post('pre_buyer_po_id')),
                            'pre_buyer_po_date'=>trim($this->input->post('pre_buyer_po_date')),
                            'pre_buyer_delivery_date'=>trim($this->input->post('pre_buyer_delivery_date')),
                            'pre_remark' =>trim($this->input->post('pre_remark')),
                        );
    

                    }else{

                        $data = array(
                            'part_number'  =>  trim($this->input->post('part_number')),
                            'buyer_order_qty'  =>  trim($this->input->post('buyre_order_qty')),
                            'f_g_order_qty'  =>  trim($this->input->post('fg_order_qty')),
                            'invoice_number'  =>  trim($this->input->post('invoice_number')),
                            'invoice_date'  =>  trim($this->input->post('invoice_date')),
                            'invoice_qty_in_pcs'  =>  trim($this->input->post('invoice_qty_in_pcs')),
                            'invoice_qty_in_kgs'  =>  trim($this->input->post('invoice_qty_in_kgs')),
                            'lot_number'  =>  trim($this->input->post('lot_number')),
                            'actual_received_qty_in_pcs'  =>  trim($this->input->post('actaul_recived_qty_in_pics')),
                            'actual_received_qty_in_kgs'  =>  trim($this->input->post('actaul_recived_qty_in_kgs')),
                            'previous_balence'  =>  trim($this->input->post('privious_balenace')),
                            'item_remark' =>  trim($this->input->post('itemremark')),
    
                            'pre_stock_date'=>trim($this->input->post('pre_stock_date')),
                            'pre_vendor_name'=>trim($this->input->post('pre_vendor_name')),
                            'pre_vendor_po_number'=>trim($this->input->post('pre_vendor_po_number')),
                            'pre_vendor_po_date'=>trim($this->input->post('pre_vendor_po_date')),
    
                            'pre_buyer_name'=>trim($this->input->post('pre_buyer_name')),
                            'pre_buyer_po_id'=>trim($this->input->post('pre_buyer_po_id')),
                            'pre_buyer_po_date'=>trim($this->input->post('pre_buyer_po_date')),
                            'pre_buyer_delivery_date'=>trim($this->input->post('pre_buyer_delivery_date')),
                            'pre_remark' =>trim($this->input->post('pre_remark')),
                        );

                    }


                    

                    $stock_form_item_id =  trim($this->input->post('stock_form_item_id'));
                    if($stock_form_item_id){
                        $stockformitemid =$stock_form_item_id;
                    }else{
                        $stockformitemid =NULL;
                    }

                    $saveStockformitemdetails= $this->admin_model->saveStockformitemdetails($stockformitemid,$data);

                    
                if($saveStockformitemdetails){
                    $saveStockformitem_response['status'] = 'success';
                    $saveStockformitem_response['error'] =  array('part_number'=>strip_tags(form_error('part_number')),'buyre_order_qty'=>strip_tags(form_error('buyre_order_qty')),'fg_order_qty'=>strip_tags(form_error('fg_order_qty')),'invoice_number'=>strip_tags(form_error('invoice_number')),'invoice_date'=>strip_tags(form_error('invoice_date')),'invoice_qty_in_pcs'=>strip_tags(form_error('invoice_qty_in_pcs')),'invoice_qty_in_kgs'=>strip_tags(form_error('invoice_qty_in_kgs')),'lot_number'=>strip_tags(form_error('lot_number')),'actaul_recived_qty_in_pics'=>strip_tags(form_error('actaul_recived_qty_in_pics')),'actaul_recived_qty_in_kgs'=>strip_tags(form_error('actaul_recived_qty_in_kgs')),'privious_balenace'=>strip_tags(form_error('privious_balenace')),'itemremark'=>strip_tags(form_error('itemremark')));
                }
            }
            echo json_encode($saveStockformitem_response);
        }
    }

    public function deleteStockformitem(){
        $post_submit = $this->input->post();
        if($post_submit){
            $result = $this->admin_model->deleteStockformitem(trim($this->input->post('id')));
            if ($result) {
                        $process = 'Delete Stock Form Item';
                        $processFunction = 'Admin/deleteStockformitem';
                        $this->logrecord($process,$processFunction);
                    echo(json_encode(array('status'=>'success')));
                }
            else { echo(json_encode(array('status'=>'failed'))); }
        }else{
            echo(json_encode(array('status'=>'failed'))); 
        }
    }

    public function deletestockform(){
        $post_submit = $this->input->post();
        if($post_submit){
            $result = $this->admin_model->deletestockform(trim($this->input->post('id')));
            if ($result) {
                        $process = 'Delete Stock Form Details';
                        $processFunction = 'Admin/deletestockform';
                        $this->logrecord($process,$processFunction);
                    echo(json_encode(array('status'=>'success')));
                }
            else { echo(json_encode(array('status'=>'failed'))); }
        }else{
            echo(json_encode(array('status'=>'failed'))); 
        }
    }

    public function searchstock(){
        $process = 'Search Stock';
        $processFunction = 'Admin/searchstock';
        $this->logrecord($process,$processFunction);
        $this->global['pageTitle'] = 'Search Stock';
        $data['vendorList']= $this->admin_model->fetchALLvendorList();
        $data['buyerList']= $this->admin_model->fetchAllbuyerList();
        $data['getallitemsfromfgorrawmaterial']= $this->admin_model->getallitemsfromfgorrawmaterial();
        $this->loadViews("masters/searchstock", $this->global, $data, NULL);  
    }

    public function fetchsearchstockrecords(){

        $params = $_REQUEST;
        $totalRecords = $this->admin_model->getsearchstockformcount($params); 
        $queryRecords = $this->admin_model->getsearchstockformdata($params); 

        $data = array();
        foreach ($queryRecords as $key => $value)
        {
            $i = 0;
            foreach($value as $v)
            {
                $data[$key][$i] = $v;
                $i++;
            }
        }
        $json_data = array(
            "draw"            => intval( $params['draw'] ),   
            "recordsTotal"    => intval( $totalRecords ),  
            "recordsFiltered" => intval($totalRecords),
            "data"            => $data   // total data array
            );
        echo json_encode($json_data);
    }

    public function getincominglotnumberbyvendor(){

       $submit = $this->input->post();
        if($submit) {
            $getIncomingdetailsbyvendorid = $this->admin_model->getincominglotnumberbyvendor($this->input->post('part_number'),$this->input->post('vendor_id'),$this->input->post('vendor_po_number'));
            if(count($getIncomingdetailsbyvendorid) >= 1) {
                $content = $content.'<option value="">Select Lot Number</option>';
				foreach($getIncomingdetailsbyvendorid as $value) {
					$content = $content.'<option value="'.$value["id"].'">'.$value["lot_no"].'</lot_no>';
				}
				echo $content;
			} else {
				echo 'failure';
			}
		  }else{

            echo 'failure';
          }
    }

    public function getinvoiceqtybyLotnumber(){

        if($this->input->post('lot_id')) {
            $getinvoiceqtybyLotnumber = $this->admin_model->getinvoiceqtybyLotnumber($this->input->post('lot_id'));
        
            if($getinvoiceqtybyLotnumber){
                $content = $getinvoiceqtybyLotnumber[0];
                echo json_encode($content);

            }else{
                echo 'failure';
            }
           
        } else {
            echo 'failure';
        }

    }

    public function getalltotalcalculationstockform(){
        $getalltotalcalculationstockform = $this->admin_model->getalltotalcalculationstockform();

        if($getalltotalcalculationstockform){
            $content = $getalltotalcalculationstockform[0];
            echo json_encode($content);
        }else{
            echo 'failure';
        }
    }

    public function fetchexportrecordsitem(){
        $params = $_REQUEST;
        $totalRecords = $this->admin_model->getexportrecordsitemcount($params); 
        $queryRecords = $this->admin_model->getexportrecordsitemdata($params); 

        $data = array();
        foreach ($queryRecords as $key => $value)
        {
            $i = 0;
            foreach($value as $v)
            {
                $data[$key][$i] = $v;
                $i++;
            }
        }
        $json_data = array(
            "draw"            => intval( $params['draw'] ),   
            "recordsTotal"    => intval( $totalRecords ),  
            "recordsFiltered" => intval($totalRecords),
            "data"            => $data   // total data array
            );
        echo json_encode($json_data);
    }

    public function fetchrejecteditem(){
        $params = $_REQUEST;
        $totalRecords = $this->admin_model->getexportrejecteditemcount($params); 
        $queryRecords = $this->admin_model->getexportrejecteditemdata($params); 

        $data = array();
        foreach ($queryRecords as $key => $value)
        {
            $i = 0;
            foreach($value as $v)
            {
                $data[$key][$i] = $v;
                $i++;
            }
        }
        $json_data = array(
            "draw"            => intval( $params['draw'] ),   
            "recordsTotal"    => intval( $totalRecords ),  
            "recordsFiltered" => intval($totalRecords),
            "data"            => $data   // total data array
            );
        echo json_encode($json_data);
    }

    public function omschallan(){
        $process = 'OMS challan';
        $processFunction = 'Admin/omschallan';
        $this->logrecord($process,$processFunction);
        $this->global['pageTitle'] = 'OMS challan';
        $data['vendorList']= $this->admin_model->fetchALLvendorList();
        $this->loadViews("masters/omschallan", $this->global, $data, NULL);  
    }

    public function fetchomschallan(){
        $params = $_REQUEST;
        $totalRecords = $this->admin_model->getomsChallancount($params); 
        $queryRecords = $this->admin_model->getomsChallandata($params); 

        $data = array();
        foreach ($queryRecords as $key => $value)
        {
            $i = 0;
            foreach($value as $v)
            {
                $data[$key][$i] = $v;
                $i++;
            }
        }
        $json_data = array(
            "draw"            => intval( $params['draw'] ),   
            "recordsTotal"    => intval( $totalRecords ),  
            "recordsFiltered" => intval($totalRecords),
            "data"            => $data   // total data array
            );
        echo json_encode($json_data);
    }

    public function addNewOMSChallan(){
        $post_submit = $this->input->post();
        if($post_submit){
            $newpmsform_response = array();
            $this->form_validation->set_rules('blasting_id','Blasting Id','trim|required');
            $this->form_validation->set_rules('oms_challan_date','OMS Challan Date','trim|required');
            $this->form_validation->set_rules('vendor_name','Vendor Name','trim|required');
            $this->form_validation->set_rules('vendor_po_number','Vendor PO Number','trim|required');
            $this->form_validation->set_rules('vendor_po_date','Vendor PO Date','trim|required');
            $this->form_validation->set_rules('remark','Remark','trim');

            if($this->form_validation->run() == FALSE)
            {
                $newpmsform_response['status'] = 'failure';
                $newpmsform_response['error'] = array('blasting_id'=>strip_tags(form_error('blasting_id')),'oms_challan_date'=>strip_tags(form_error('oms_challan_date')),'vendor_name'=>strip_tags(form_error('vendor_name')),'vendor_po_number'=>strip_tags(form_error('vendor_po_number')),'vendor_po_date'=>strip_tags(form_error('vendor_po_date')),'remark'=>strip_tags(form_error('remark')));
            }else{
                $data = array(
                    'blasting_id' => trim($this->input->post('blasting_id')),
                    'date' => trim($this->input->post('oms_challan_date')),
                    'vendor_name' => trim($this->input->post('vendor_name')),
                    'vendor_po_id' => trim($this->input->post('vendor_po_number')),
                    'vendor_po_date' => trim($this->input->post('vendor_po_date')), 
                    'remark' => trim($this->input->post('remark')),
                );

                $oms_challan_id = trim($this->input->post('oms_challan_id'));
                if($oms_challan_id){
                    $saveomschallanform= $this->admin_model->saveomschallanform($oms_challan_id,$data);
                }else{
                    $saveomschallanform= $this->admin_model->saveomschallanform('',$data);
                }
                if($saveomschallanform){
                    $update_oms_challan_from = $this->admin_model->update_oms_challan_from($saveomschallanform);
                    if($update_oms_challan_from){
                        $newpmsform_response['status'] = 'success';
                        $newpmsform_response['error'] = array('blasting_id'=>strip_tags(form_error('blasting_id')),'oms_challan_date'=>strip_tags(form_error('oms_challan_date')),'vendor_name'=>strip_tags(form_error('vendor_name')),'vendor_po_number'=>strip_tags(form_error('vendor_po_number')),'vendor_po_date'=>strip_tags(form_error('vendor_po_date')),'remark'=>strip_tags(form_error('remark')));
                     }
                }
            }    
            echo json_encode($newpmsform_response);

        }else{
            $process = 'Add New OMS challan';
            $processFunction = 'Admin/addNewOMSChallan';
            $this->logrecord($process,$processFunction);
            $this->global['pageTitle'] = 'Add New OMS challan';
            $data['vendorList']= $this->admin_model->fetchALLvendorList();
            $data['getpreviuousblasterId']= $this->admin_model->getpreviuousblasterId();
            $data['getomschallanitems']= $this->admin_model->getomschallanitems();
            $this->loadViews("masters/addNewomschallan", $this->global, $data, NULL);
        }

    }

    public function deleteomschallan(){
        $post_submit = $this->input->post();
        if($post_submit){
            $result = $this->admin_model->deleteomschallan(trim($this->input->post('id')));
            if ($result) {
                        $process = 'Delete OMS Challan';
                        $processFunction = 'Admin/deleteomschallan';
                        $this->logrecord($process,$processFunction);
                    echo(json_encode(array('status'=>'success')));
                }
            else { echo(json_encode(array('status'=>'failed'))); }
        }else{
            echo(json_encode(array('status'=>'failed'))); 
        }
    }

    public function saveomschallanitem(){

        $post_submit = $this->input->post();
        if($post_submit){

             $saveomsChallanformitem_response = array();
             $this->form_validation->set_rules('part_number','Part Number','trim|required');            
             $this->form_validation->set_rules('gross_weight','Gross Weight','trim|required');
             $this->form_validation->set_rules('net_weight','Net Weight','trim|required');
             $this->form_validation->set_rules('no_of_bags','No of Bags','trim|required');
             $this->form_validation->set_rules('qty','Qty','trim|required');
             $this->form_validation->set_rules('hsn_no','HSN No','trim|required');
             $this->form_validation->set_rules('itemremark','Ite Remark','trim');

            if($this->form_validation->run() == FALSE)
            {
                $saveChallanformitem_response['status'] = 'failure';
                $saveChallanformitem_response['error'] =  array('part_number'=>strip_tags(form_error('part_number')),'qty'=>strip_tags(form_error('qty')),'gross_weight'=>strip_tags(form_error('gross_weight')),'net_weight'=>strip_tags(form_error('net_weight')),'no_of_bags'=>strip_tags(form_error('no_of_bags')),'hsn_no'=>strip_tags(form_error('hsn_no')),'itemremark'=>strip_tags(form_error('itemremark')));
           
            }else{
                
              $oms_challan_id =  trim($this->input->post('oms_challan_id'));
                if($oms_challan_id){
                    $data = array(
                        'oms_chllan_id'  =>  trim($this->input->post('oms_challan_id')),
                        'part_number'  =>  trim($this->input->post('part_number')),
                        'gross_weight'  =>  trim($this->input->post('gross_weight')),
                        'net_weight'  =>  trim($this->input->post('net_weight')),
                        'qty' =>trim($this->input->post('qty')),
                        'no_of_bags'  =>  trim($this->input->post('no_of_bags')),
                        'hsn_no'  =>  trim($this->input->post('hsn_no')),
                        'unit'  =>  trim($this->input->post('unit')),
                        'calculation'  =>  trim($this->input->post('calculation')),
                        'remark' =>  trim($this->input->post('itemremark')),
                        'pre_oms_challan_date' =>  trim($this->input->post('pre_oms_challan_date')),
                        'pre_vendor_name' =>  trim($this->input->post('pre_vendor_name')),
                        'pre_vendor_po_number' =>  trim($this->input->post('pre_vendor_po_number')),
                        'pre_vendor_date'		 =>  trim($this->input->post('pre_vendor_po_date')),
                        'pre_remark' =>  trim($this->input->post('pre_remark')),

                    );

                    $oms_challan_item_id =  trim($this->input->post('oms_challan_item_id'));
                    if($oms_challan_item_id){
                        $omschallanitemid =$oms_challan_item_id;
                    }else{
                        $omschallanitemid =NULL;
                    }
                    
                    $saveomsChallanformdetails= $this->admin_model->saveomsChallanformdetails($omschallanitemid,$data);

                }else{
                    $data = array(
                        'part_number'  =>  trim($this->input->post('part_number')),
                        'gross_weight'  =>  trim($this->input->post('gross_weight')),
                        'net_weight'  =>  trim($this->input->post('net_weight')),
                        'qty' =>trim($this->input->post('qty')),
                        'no_of_bags'  =>  trim($this->input->post('no_of_bags')),
                        'hsn_no'  =>  trim($this->input->post('hsn_no')),
                        'unit'  =>  trim($this->input->post('unit')),
                        'calculation'  =>  trim($this->input->post('calculation')),
                        'remark' =>  trim($this->input->post('itemremark')),
                        'pre_oms_challan_date' =>  trim($this->input->post('pre_oms_challan_date')),
                        'pre_vendor_name' =>  trim($this->input->post('pre_vendor_name')),
                        'pre_vendor_po_number' =>  trim($this->input->post('pre_vendor_po_number')),
                        'pre_vendor_date'		 =>  trim($this->input->post('pre_vendor_po_date')),
                        'pre_remark' =>  trim($this->input->post('pre_remark')),

                    );

                    $oms_challan_item_id =  trim($this->input->post('oms_challan_item_id'));
                    if($oms_challan_item_id){
                        $omschallanitemid =$oms_challan_item_id;
                    }else{
                        $omschallanitemid =NULL;
                    }

                    $saveomsChallanformdetails= $this->admin_model->saveomsChallanformdetails($omschallanitemid,$data);
                 }

                 if($saveomsChallanformdetails){
                    $saveChallanformitem_response['status'] = 'success';
                    $saveChallanformitem_response['error'] =  array('part_number'=>strip_tags(form_error('part_number')),'gross_weight'=>strip_tags(form_error('gross_weight')),'net_weight'=>strip_tags(form_error('net_weight')),'no_of_bags'=>strip_tags(form_error('no_of_bags')),'hsn_no'=>strip_tags(form_error('hsn_no')),'itemremark'=>strip_tags(form_error('itemremark')));
                }
            }
            echo json_encode($saveChallanformitem_response);

        }

    }

    public function deleteOmschallnitem(){
        $post_submit = $this->input->post();
        if($post_submit){
            $result = $this->admin_model->deleteOmschallnitem(trim($this->input->post('id')));
            if ($result) {
                        $process = 'Delete Stock Item Form Details';
                        $processFunction = 'Admin/deleteOmschallnitem';
                        $this->logrecord($process,$processFunction);
                    echo(json_encode(array('status'=>'success')));
                }
            else { echo(json_encode(array('status'=>'failed'))); }
        }else{
            echo(json_encode(array('status'=>'failed'))); 
        }


    }

    public function editomschallan($id){

        $process = 'Edit OMS Chllan Form';
        $processFunction = 'Admin/editomschallan';
        $this->logrecord($process,$processFunction);
        $this->global['pageTitle'] = 'Edit OMS Chllan Form';
        $data['vendorList']= $this->admin_model->fetchALLvendorList();
        $data['getomsitemlistforedit']= $this->admin_model->getomsitemlistforedit($id);
        $data['getomsChllanData']= $this->admin_model->getomsChllanData($id);
        $this->loadViews("masters/editomschallan", $this->global, $data, NULL);

        
    }

    public function enquiryform(){
        $process = 'Enquiry Form';
        $processFunction = 'Admin/enquiryform';
        $this->logrecord($process,$processFunction);
        $this->global['pageTitle'] = 'Enquiry Form';
        $data['vendorList']= $this->admin_model->fetchALLvendorList();
        $this->loadViews("masters/enquiryform", $this->global, $data, NULL);  
    }

    public function fetchenquiryform(){
        $params = $_REQUEST;
        $totalRecords = $this->admin_model->getenquiryformcount($params); 
        $queryRecords = $this->admin_model->getenquiryformdata($params); 

        $data = array();
        foreach ($queryRecords as $key => $value)
        {
            $i = 0;
            foreach($value as $v)
            {
                $data[$key][$i] = $v;
                $i++;
            }
        }
        $json_data = array(
            "draw"            => intval( $params['draw'] ),   
            "recordsTotal"    => intval( $totalRecords ),  
            "recordsFiltered" => intval($totalRecords),
            "data"            => $data   // total data array
            );
        echo json_encode($json_data);
    }

    public function addnewenquiryform(){

        $post_submit = $this->input->post();
        if($post_submit){
            $add_newenquiry_response = array();
            $this->form_validation->set_rules('enquiry_number','Enquiry Number','trim|required');
            $this->form_validation->set_rules('enquiry_date','Enquiry Date','trim|required');
            $this->form_validation->set_rules('buyer_enquiry_no','Buyer Enquiry No','trim|required');
            $this->form_validation->set_rules('buyer_enquiry_date','Buyer Enquiry Date','trim|required');
            $this->form_validation->set_rules('status','Status','trim|required');
            $this->form_validation->set_rules('remark','Remark','trim');

            if($this->form_validation->run() == FALSE)
            {
                $add_newenquiry_response['status'] = 'failure';
                $add_newenquiry_response['error'] = array('enquiry_number'=>strip_tags(form_error('enquiry_number')),'enquiry_date'=>strip_tags(form_error('enquiry_date')),'buyer_enquiry_no'=>strip_tags(form_error('buyer_enquiry_no')),'buyer_enquiry_date'=>strip_tags(form_error('buyer_enquiry_date')),'remark'=>strip_tags(form_error('remark')),'status'=>strip_tags(form_error('status')));

            }else{
                $data = array(
                    'enquiry_number' => trim($this->input->post('enquiry_number')),
                    'date' => trim($this->input->post('enquiry_date')),
                    'buyer_name' => trim($this->input->post('buyer_enquiry_no')),
                    'buyer_enquiry_no' => trim($this->input->post('buyer_enquiry_no')),
                    'buyer_enquiry_date' => trim($this->input->post('buyer_enquiry_date')),
                    'remark' => trim($this->input->post('remark')),
                    'enquiry_status'  => trim($this->input->post('status')),
                );

                $enquiry_form_id = trim($this->input->post('enquiry_form_id'));

                if($enquiry_form_id){
                    $enquiryformid = $enquiry_form_id;
                }else{
                    $enquiryformid =NULL;
                }

                $saveenquirydetailsform= $this->admin_model->saveenquirydetailsform($enquiryformid,$data);
                if($saveenquirydetailsform){

                    $update_enquiry_from = $this->admin_model->update_enquiry_from_id_in_items($saveenquirydetailsform);
                    if($update_enquiry_from){
                        $add_newenquiry_response['status'] = 'success';
                        $add_newenquiry_response['error'] = array('enquiry_number'=>strip_tags(form_error('enquiry_number')),'enquiry_date'=>strip_tags(form_error('enquiry_date')),'buyer_enquiry_no'=>strip_tags(form_error('buyer_enquiry_no')),'buyer_enquiry_date'=>strip_tags(form_error('buyer_enquiry_date')),'remark'=>strip_tags(form_error('remark')),'status'=>strip_tags(form_error('status')));
                    }else{
                        $add_newenquiry_response['status'] = 'failure';
                        $add_newenquiry_response['error'] = array('enquiry_number'=>strip_tags(form_error('enquiry_number')),'enquiry_date'=>strip_tags(form_error('enquiry_date')),'buyer_enquiry_no'=>strip_tags(form_error('buyer_enquiry_no')),'buyer_enquiry_date'=>strip_tags(form_error('buyer_enquiry_date')),'remark'=>strip_tags(form_error('remark')),'status'=>strip_tags(form_error('status')));

                    }

                 }
            }
            echo json_encode($add_newenquiry_response);
        }else{
            $process = 'Add New Enquiry Form';
            $processFunction = 'Admin/addNewenquiryform';
            $this->logrecord($process,$processFunction);
            $this->global['pageTitle'] = 'Add New Enquiry Form';
            $data['vendorList']= $this->admin_model->fetchALLvendorList();
            $data['supplierList']= $this->admin_model->fetchALLsupplierList();
            $data['partNumberlistforenquirylist']= $this->admin_model->partNumberlistforenquirylist();
            $data['getallenquiryformitemadd']= $this->admin_model->getallenquiryformitemadd();
            $data['getpreviuousenquirynumber']= $this->admin_model->getpreviuousenquirynumber();
            $this->loadViews("masters/addNewenquiryform", $this->global, $data, NULL);
        }
    }

    public function deleteenquiryformdata(){
        $post_submit = $this->input->post();
        if($post_submit){
            $result = $this->admin_model->deleteenquiryformdata(trim($this->input->post('id')));
            if ($result) {
                        $process = 'Delete Enquiry Data';
                        $processFunction = 'Admin/deleteenquiryformdata';
                        $this->logrecord($process,$processFunction);
                    echo(json_encode(array('status'=>'success')));
                }
            else { echo(json_encode(array('status'=>'failed'))); }
        }else{
            echo(json_encode(array('status'=>'failed'))); 
        }
    }


    public function deleteenquiryformitemdata(){
        $post_submit = $this->input->post();
        if($post_submit){
            $result = $this->admin_model->deleteenquiryformitemdata(trim($this->input->post('id')));
            if ($result) {
                        $process = 'Delete Enquiry Item Data';
                        $processFunction = 'Admin/deleteenquiryformitemdata';
                        $this->logrecord($process,$processFunction);
                    echo(json_encode(array('status'=>'success')));
                }
            else { echo(json_encode(array('status'=>'failed'))); }
        }else{
            echo(json_encode(array('status'=>'failed'))); 
        }
    }


    public function editeqnuiryformdatabyid($enquiryformid){

        $process = 'Edit New Enquiry Form';
        $processFunction = 'Admin/editeqnuiryformdata';
        $this->logrecord($process,$processFunction);
        $this->global['pageTitle'] = 'Edit New Enquiry Form';
        $data['vendorList']= $this->admin_model->fetchALLvendorList();
        $data['supplierList']= $this->admin_model->fetchALLsupplierList();
        $data['partNumberlistforenquirylist']= $this->admin_model->partNumberlistforenquirylist();
        $data['getallenquiryformitemedit']= $this->admin_model->getallenquiryformitemedit($enquiryformid);

        $data['getenquirydetailsforedit']= $this->admin_model->getenquirydetailsforedit($enquiryformid);
        $this->loadViews("masters/editenquiryform", $this->global, $data, NULL);

    }



    public function saveenquiryformitem(){
        
        $post_submit = $this->input->post();
        if($post_submit){
            $saveenquiryform_response = array();
            $this->form_validation->set_rules('part_number','Part Number','trim|required');            
           if($this->form_validation->run() == FALSE)
           {
               $saveenquiryform_response['status'] = 'failure';
               $saveenquiryform_response['error'] =  array('part_number'=>strip_tags(form_error('part_number')));
          
           }else{



            if(trim($this->input->post('enquiry_form_id'))){
                $enquiry_form_id = trim($this->input->post('enquiry_form_id'));
            }else{
                $enquiry_form_id =NULL;
            }


                $data = array(
                    'part_number'  =>  trim($this->input->post('part_number')),
                    'enquiry_form_id' =>  $enquiry_form_id,
                    'rm_description'  =>  trim($this->input->post('rm_description')),
                    'groass_weight'  =>  trim($this->input->post('gross_weight')),
                    'rm_size'  =>  trim($this->input->post('rm_size')),
                    'supplier_qty_in_kgs'  =>  trim($this->input->post('supplier_qty_in_kgs')),
                    'venodr_qty_in_pcs'  =>  trim($this->input->post('venodr_qty_in_pcs')),

                    'suplier_id_1'  =>  trim($this->input->post('supplier_name_1')),
                    'suplier_rate_1'  =>  trim($this->input->post('rate_1')),
                    'suplier_id_2'  =>  trim($this->input->post('supplier_name_2')),
                    'suplier_rate_2'  =>  trim($this->input->post('rate_2')),
                    'suplier_id_3'  =>  trim($this->input->post('supplier_name_3')),
                    'suplier_rate_3'  =>  trim($this->input->post('rate_3')),
                    'suplier_id_4'  =>  trim($this->input->post('supplier_name_4')),
                    'suplier_rate_4'  =>  trim($this->input->post('rate_4')),
                    'suplier_id_5'  =>  trim($this->input->post('supplier_name_5')),
                    'suplier_rate_5'  =>  trim($this->input->post('rate_5')),

                    'vendor_id_1'  =>  trim($this->input->post('vendor_name_1')),
                    'vendor_rate_1'  =>  trim($this->input->post('venodr_rate_1')),
                    'vendor_id_2'  =>  trim($this->input->post('vendor_name_2')),
                    'vendor_rate_2'  =>  trim($this->input->post('venodr_rate_2')),
                    'vendor_id_3'  =>  trim($this->input->post('vendor_name_3')),
                    'vendor_rate_3'  =>  trim($this->input->post('venodr_rate_3')),
                    'vendor_id_4'  =>  trim($this->input->post('vendor_name_4')),
                    'vendor_rate_4'  =>  trim($this->input->post('venodr_rate_4')),
                    'vendor_id_5'  =>  trim($this->input->post('vendor_name_5')),
                    'vendor_rate_5'  =>  trim($this->input->post('venodr_rate_5')),

                    'remark_1'  =>  trim($this->input->post('remark_1')),
                    'remark_2'  =>  trim($this->input->post('remark_2')),
                    'remark_3'  =>  trim($this->input->post('remark_3')),
                    'remark_4'  =>  trim($this->input->post('remark_4')),
                    'remark_5'  =>  trim($this->input->post('remark_5')),


                    'remark_6'  =>  trim($this->input->post('remark_6')),
                    'remark_7'  =>  trim($this->input->post('remark_7')),
                    'remark_8'  =>  trim($this->input->post('remark_8')),
                    'remark_9'  =>  trim($this->input->post('remark_9')),
                    'remark_10'  =>  trim($this->input->post('remark_10')),



                    'pre_enquiry_date'	=>  trim($this->input->post('pre_enquiry_date')),
                    'pre_buyer_enquiry_number' =>  trim($this->input->post('pre_buyer_enquiry_no')),
                    'pre_buyer_enquiry_date' =>  trim($this->input->post('pre_buyer_enquiry_date')),
                    'pre_status' =>  trim($this->input->post('pre_status')),
                    'pre_remark' =>  trim($this->input->post('pre_remark')),



                );

                $enquiry_form_item_id =  trim($this->input->post('enquiry_form_item_id'));
                if($enquiry_form_item_id){
                    $enquiryformitemid =$enquiry_form_item_id;
                }else{
                    $enquiryformitemid =NULL;
                }


                $saveenquiryformitem = $this->admin_model->saveenquiryformitem($enquiryformitemid,$data);
                if($saveenquiryformitem){
                    $saveenquiryform_response['status'] = 'success';
                    $saveenquiryform_response['error'] =  array('part_number'=>strip_tags(form_error('part_number')));
                }
           }
           echo json_encode($saveenquiryform_response);
        }
    }


    public function deleteBillofmaterialitem(){

        $post_submit = $this->input->post();
        if($post_submit){
            $result = $this->admin_model->deleteBillofmaterialitem(trim($this->input->post('id')));
            if ($result) {
                        $process = 'Delete Bill of material Item';
                        $processFunction = 'Admin/deleteBillofmaterialitem';
                        $this->logrecord($process,$processFunction);
                    echo(json_encode(array('status'=>'success')));
                }
            else { echo(json_encode(array('status'=>'failed'))); }
        }else{
            echo(json_encode(array('status'=>'failed'))); 
        }

    }


    public function checkvendorpoandvendornumber(){
        $post_submit = $this->input->post();
        if($post_submit){
             $result = $this->admin_model->checkvendorpoandvendornumber($post_submit);
             if ($result) {
                $content = $result[0];
                echo json_encode($content);
             }else{
                echo 'failure';
             }
        }else{
            echo 'failure';
        }
    }
   
    public function checkvendorpoandvendornumberinbillofmaterial(){

        $post_submit = $this->input->post();
        if($post_submit){
             $result = $this->admin_model->checkvendorpoandvendornumberinbillofmaterial($post_submit);
             if ($result) {
                $content = $result[0];
                echo json_encode($content);
             }else{
                echo 'failure';
             }
        }else{
            echo 'failure';
        }


    }


    public function checkvendorpoandvendornumberinvendorbillofmaterial(){

        $post_submit = $this->input->post();
        if($post_submit){
             $result = $this->admin_model->checkvendorpoandvendornumberinvendorbillofmaterial($post_submit);
             if ($result) {
                $content = $result[0];
                echo json_encode($content);
             }else{
                echo 'failure';
             }
        }else{
            echo 'failure';
        }
    }

    public function fetchincomingdeatilsitemlistedit($searchid,$edit_id){

        $params = $_REQUEST;
        $totalRecords = $this->admin_model->fetchincomingdeatilsitemlistaddcountedit($params,$searchid,$edit_id); 
        $queryRecords = $this->admin_model->fetchincomingdeatilsitemlistadddataedit($params,$searchid,$edit_id); 

        $data = array();
        foreach ($queryRecords as $key => $value)
        {
            $i = 0;
            foreach($value as $v)
            {
                $data[$key][$i] = $v;
                $i++;
            }
        }
        $json_data = array(
            "draw"            => intval( $params['draw'] ),   
            "recordsTotal"    => intval( $totalRecords ),  
            "recordsFiltered" => intval($totalRecords),
            "data"            => $data   // total data array
            );
        echo json_encode($json_data);

    }

    public function stockrejectionform(){
            $process = 'Stockrejection Form';
            $processFunction = 'Admin/stockrejectionform';
            $this->logrecord($process,$processFunction);
            $this->global['pageTitle'] = 'Stockrejection Form';
            $data['vendorList']= $this->admin_model->fetchALLvendorList();   
            $this->loadViews("masters/stockrejectionform", $this->global, $data, NULL);
    }

    public function fetchenstockrejectionform(){
        $params = $_REQUEST;
        $totalRecords = $this->admin_model->fetchenstockrejectionformCount($params); 
        $queryRecords = $this->admin_model->fetchenstockrejectionformData($params); 

        $data = array();
        foreach ($queryRecords as $key => $value)
        {
            $i = 0;
            foreach($value as $v)
            {
                $data[$key][$i] = $v;
                $i++;
            }
        }
        $json_data = array(
            "draw"            => intval( $params['draw'] ),   
            "recordsTotal"    => intval( $totalRecords ),  
            "recordsFiltered" => intval($totalRecords),
            "data"            => $data   // total data array
            );
        echo json_encode($json_data);


    }


    public function addnewrejectionform(){

        $post_submit = $this->input->post();
        if($post_submit){
            $add_newrejection_response = array();
            $this->form_validation->set_rules('rejection_number','Rejection Number','trim|required');
            $this->form_validation->set_rules('rejection_form_date','Rejection Form Date','trim|required');
            $this->form_validation->set_rules('vendor_name','Vendor Name','trim|required');
            $this->form_validation->set_rules('vendor_po_number','Vendor PO Number','trim|required');
            $this->form_validation->set_rules('remark','Remark','trim');

            if($this->form_validation->run() == FALSE)
            {
                $add_newrejection_response['status'] = 'failure';
                $add_newrejection_response['error'] = array('rejection_number'=>strip_tags(form_error('rejection_number')),'rejection_form_date'=>strip_tags(form_error('rejection_form_date')),'vendor_name'=>strip_tags(form_error('vendor_name')),'vendor_po_number'=>strip_tags(form_error('vendor_po_number')),'remark'=>strip_tags(form_error('remark')));
            }else{
                $data = array(
                    'rejection_number' => trim($this->input->post('rejection_number')),
                    'rejection_form_date' => trim($this->input->post('rejection_form_date')),
                    'vendor_id' => trim($this->input->post('vendor_name')),
                    'vendor_po_number' => trim($this->input->post('vendor_po_number')),
                    'remark' => trim($this->input->post('remark'))
                );
                $rejection_form_id =  trim($this->input->post('rejection_form_id'));
                
                $savenewrejectionform= $this->admin_model->savenewrejectionform($rejection_form_id,$data);
                if($savenewrejectionform){
                    $add_newrejection_response['status'] = 'success';
                    $add_newrejection_response['error'] = array('rejection_number'=>strip_tags(form_error('rejection_number')),'rejection_form_date'=>strip_tags(form_error('rejection_form_date')),'vendor_name'=>strip_tags(form_error('vendor_name')),'vendor_po_number'=>strip_tags(form_error('vendor_po_number')),'remark'=>strip_tags(form_error('remark')));
                 }else{
                    $add_newrejection_response['status'] = 'failure';
                    $add_newrejection_response['error'] = array('rejection_number'=>strip_tags(form_error('rejection_number')),'rejection_form_date'=>strip_tags(form_error('rejection_form_date')),'vendor_name'=>strip_tags(form_error('vendor_name')),'vendor_po_number'=>strip_tags(form_error('vendor_po_number')),'remark'=>strip_tags(form_error('remark')));
                 }
            }
            echo json_encode($add_newrejection_response);
        }else{
            $process = 'Add New Rejection Form';
            $processFunction = 'Admin/addnewrejectionform';
            $this->logrecord($process,$processFunction);
            $this->global['pageTitle'] = 'Add New Rejection Form';
            $data['vendorList']= $this->admin_model->fetchALLvendorList();
            $data['getPreviousrejectionformnumber']= $this->admin_model->getPreviousrejectionformnumber();
            $this->loadViews("masters/addnewrejectionform", $this->global, $data, NULL);
        }
    }


    public function editrejetionform($id){

        $process = 'Edit Rejection Form';
        $processFunction = 'Admin/editrejetionform';
        $this->logrecord($process,$processFunction);
        $this->global['pageTitle'] = 'Edit Rejection Form';
        $data['vendorList']= $this->admin_model->fetchALLvendorList();
        $data['getalldataofeditrejectionform']= $this->admin_model->getalldataofeditrejectionform($id);
        $this->loadViews("masters/editstockrejetionform", $this->global, $data, NULL);

    }

    public function deleterejectionform(){
        $post_submit = $this->input->post();
        if($post_submit){
            $result = $this->admin_model->deleterejectionform(trim($this->input->post('id')));
            if ($result) {
                        $process = 'Delete Rejection Form';
                        $processFunction = 'Admin/deleterejectionform';
                        $this->logrecord($process,$processFunction);
                    echo(json_encode(array('status'=>'success')));
                }
            else { echo(json_encode(array('status'=>'failed'))); }
        }else{
            echo(json_encode(array('status'=>'failed'))); 
        }
    }


    public function addrejectionformitemsdata($id){
        $process = 'Add Rejection Form Data';
        $processFunction = 'Admin/editrejetionform';
        $this->logrecord($process,$processFunction);
        $this->global['pageTitle'] = 'Add Rejection Form Data';
        $data['getalldataofeditrejectionform']= $this->admin_model->getalldataofeditrejectionform($id);
        $this->loadViews("masters/addrejectionformitemsdata", $this->global, $data, NULL);
    }


    public function fetchenstockrejectionformitemdata($id){
        $data['getalldataofeditrejectionform']= $this->admin_model->getalldataofeditrejectionform($id);
        $vendor_po_id =  trim($data['getalldataofeditrejectionform']['vpn']);

        $params = $_REQUEST;
        $totalRecords = $this->admin_model->getstockrejectionformitemcount($params, $vendor_po_id,$id); 
        $queryRecords = $this->admin_model->getstockrejectionformitemdata($params, $vendor_po_id,$id); 

        $data = array();
        foreach ($queryRecords as $key => $value)
        {
            $i = 0;
            foreach($value as $v)
            {
                $data[$key][$i] = $v;
                $i++;
            }
        }
        $json_data = array(
            "draw"            => intval( $params['draw'] ),   
            "recordsTotal"    => intval( $totalRecords ),  
            "recordsFiltered" => intval($totalRecords),
            "data"            => $data   // total data array
            );
        echo json_encode($json_data);

    }


    public function viewrejectionformitemdetails(){

        $data['rejection_form_id']= $_GET['rejection_form_id'];
        $data['vendor_po_item_id']= $_GET['vendor_po_item_id'];
        $data['vendor_po_id']=  $_GET['vendor_po_id'];
        $getstockrejectionformitemdataitemdetailsforedit = $this->admin_model->getstockrejectionformitemdataitemdetailsforedit(trim($_GET['vendor_po_id']));
        $data['net_weight_fg'] =  $getstockrejectionformitemdataitemdetailsforedit[0]['net_weight_fg'];
        $process = 'View Rejection Form Data';
        $processFunction = 'Admin/editrejetionform';
        $this->logrecord($process,$processFunction);
        $this->global['pageTitle'] = 'View Rejection Form Data';

        $this->loadViews("masters/viewrejectionformitemdetails", $this->global, $data, NULL);

    }

    public function saverejectedformitemdata(){
        $post_submit = $this->input->post();
        if($post_submit){
            $saverejectedform_response = array();
            $this->form_validation->set_rules('rejected_reason','Rejected Reason','trim|required'); 
            $this->form_validation->set_rules('qty_in_pcs','Qty In Pcs','trim|required');   
            $this->form_validation->set_rules('qty_in_kgs','Qty In Kgs','trim|required');      
            $this->form_validation->set_rules('remark','Remark','trim');                   
            if($this->form_validation->run() == FALSE)
            {
                $saverejectedform_response['status'] = 'failure';
                $saverejectedform_response['error'] =  array('rejected_reason'=>strip_tags(form_error('rejected_reason')),'qty_in_pcs'=>strip_tags(form_error('qty_in_pcs')),'qty_in_kgs'=>strip_tags(form_error('qty_in_kgs')),'remark'=>strip_tags(form_error('remark')));
            
            }else{

                $data = array(
                    'item_id '=> trim($this->input->post('vendor_po_item_id')),
                    'rejection_form_id '=> trim($this->input->post('rejection_form_id_popup')),
                    'vendor_po_id '=> trim($this->input->post('vendor_po_id')),
                    'rejected_reason' => trim($this->input->post('rejected_reason')),
                    'qty_in_pcs' => trim($this->input->post('qty_in_pcs')),
                    'qty_in_kgs' => trim($this->input->post('qty_in_kgs')),
                    'remark' => trim($this->input->post('remark')),
                );

                $savenewrejectionform= $this->admin_model->saverejectedformitemdata('',$data);
                if($savenewrejectionform){
                    $saverejectedform_response['status'] = 'success';
                    $saverejectedform_response['error'] =  array('rejected_reason'=>strip_tags(form_error('rejected_reason')),'qty_in_pcs'=>strip_tags(form_error('qty_in_pcs')),'qty_in_kgs'=>strip_tags(form_error('qty_in_kgs')),'remark'=>strip_tags(form_error('remark')));
                }else{
                    $saverejectedform_response['status'] = 'failure';
                    $saverejectedform_response['error'] =  array('rejected_reason'=>strip_tags(form_error('rejected_reason')),'qty_in_pcs'=>strip_tags(form_error('qty_in_pcs')),'qty_in_kgs'=>strip_tags(form_error('qty_in_kgs')),'remark'=>strip_tags(form_error('remark')));
                 }

            }

            echo json_encode($saverejectedform_response);
        }
    }

    public function fetch_stock_rejection_form_ttem_details(){
        $rejection_form_id= trim($this->input->post('rejection_form_id'));
        $vendor_po_item_id= trim($this->input->post('vendor_po_item_id'));
        $vendor_po_id=  trim($this->input->post('vendor_po_id'));

        $params = $_REQUEST;
        $totalRecords = $this->admin_model->getfetch_stock_rejection_form_ttem_detailscount($params, $rejection_form_id,$vendor_po_item_id,$vendor_po_id); 
        $queryRecords = $this->admin_model->getfetch_stock_rejection_form_ttem_detailsdata($params, $rejection_form_id,$vendor_po_item_id,$vendor_po_id); 

        $data = array();
        foreach ($queryRecords as $key => $value)
        {
            $i = 0;
            foreach($value as $v)
            {
                $data[$key][$i] = $v;
                $i++;
            }
        }
        $json_data = array(
            "draw"            => intval( $params['draw'] ),   
            "recordsTotal"    => intval( $totalRecords ),  
            "recordsFiltered" => intval($totalRecords),
            "data"            => $data   // total data array
            );
        echo json_encode($json_data);

    }

    public function deleterejectionformitem(){

        $post_submit = $this->input->post();
        if($post_submit){
            $result = $this->admin_model->deleterejectionformitem(trim($this->input->post('id')));
            if ($result) {
                        $process = 'Delete Rejection Form Items';
                        $processFunction = 'Admin/deleterejectionformitem';
                        $this->logrecord($process,$processFunction);
                    echo(json_encode(array('status'=>'success')));
                }
            else { echo(json_encode(array('status'=>'failed'))); }
        }else{
            echo(json_encode(array('status'=>'failed'))); 
        }
        
    }

    public function getStockdatadependsonvendorpo(){

        $vendor_po_number=$this->input->post('vendor_po_number');
        if($vendor_po_number) {
			$vendor_po_number_stock_data = $this->admin_model->getStockdatadependsonvendorpo($vendor_po_number);
			if(count($vendor_po_number_stock_data) >= 1) {
				echo json_encode($vendor_po_number_stock_data[0]);
			} else {
				echo 'failure';
			}
		} else {
			echo 'failure';
		}
    }

    public function getbuyerorderqtyfrompartnumber(){

        $vendor_po_number=$this->input->post('vendor_po_number');
        $item_number=$this->input->post('item_number');
        if($vendor_po_number && $item_number) {
			$vendor_po_number_stock_data = $this->admin_model->getbuyerorderqtyfrompartnumber($vendor_po_number,$item_number);
			if(count($vendor_po_number_stock_data) >= 1) {
				echo json_encode($vendor_po_number_stock_data[0]);
			} else {
				echo 'failure';
			}
		} else {
			echo 'failure';
		}

    }

    public function vendorponumberforviewitemstockform_display(){
        $post_submit = $this->input->post();
        if($post_submit){
    
            $vendor_po_number = $this->input->post('vendor_po_number');
        
            // load table library
            $this->load->library('table');
            
            // set heading
            $this->table->set_heading('Part Number', 'Order Qty','Invoice Number', 'Invoice Date','Invoice Qty In Pcs','Invoice Qty In Kgs','Lot No','Actual Received Qty In Pcs','Actual Received Qty In Kgs');
    
            // set template
            $style = array('table_open'  => '<p><b>Stock Form Item</b></p><table style="max-width: 70%;display: block;overflow-x: auto; white-space: nowrap;" class="table">');
    
            $this->table->set_template($style);
    
            $this->db->select(TBL_FINISHED_GOODS.'.part_number,'.TBL_STOCKS_ITEM.'.f_g_order_qty,'.TBL_STOCKS_ITEM.'.invoice_number,'.TBL_STOCKS_ITEM.'.invoice_date,'.TBL_STOCKS_ITEM.'.invoice_qty_In_pcs,'.TBL_STOCKS_ITEM.'.invoice_qty_In_kgs,'.TBL_STOCKS_ITEM.'.lot_number,'.TBL_STOCKS_ITEM.'.actual_received_qty_in_pcs,'.TBL_STOCKS_ITEM.'.actual_received_qty_in_kgs');
            $this->db->join(TBL_VENDOR_PO_MASTER_ITEM, TBL_VENDOR_PO_MASTER_ITEM.'.part_number_id = '.TBL_STOCKS_ITEM.'.part_number');
            $this->db->join(TBL_FINISHED_GOODS, TBL_FINISHED_GOODS.'.fin_id = '.TBL_STOCKS_ITEM.'.part_number');
            $this->db->join(TBL_STOCKS, TBL_STOCKS.'.stock_id = '.TBL_STOCKS_ITEM.'.stock_form_id');
            $this->db->where(TBL_STOCKS.'.vendor_po_number',$vendor_po_number);
            $query_result = $this->db->get(TBL_STOCKS_ITEM);
            $data = $query_result->result_array();
    
            if($data){
                echo $this->table->generate($query_result);
    
            }else{
                echo '';
            }
    
        }
    }

    public function getallcalculationrejecteditems(){

        $getallcalculationrejecteditems = $this->admin_model->getallcalculationrejecteditems();
        if($getallcalculationrejecteditems){
            $content = $getallcalculationrejecteditems[0];
            echo json_encode($content);
        }else{
            echo 'failure';
        }
    }


    public function getallcalculationexportitems(){

        $getallcalculationexportitems = $this->admin_model->getallcalculationexportitems();
        if($getallcalculationexportitems){
            $content = $getallcalculationexportitems[0];
            echo json_encode($content);
        }else{
            echo 'failure';
        }
    }


    public function getallbalencecalculationexportitems(){

        $getallbalencecalculationexportitems = $this->admin_model->getallbalencecalculationexportitems();
        if($getallbalencecalculationexportitems){
            $content = $getallbalencecalculationexportitems[0];
            echo json_encode($content);
        }else{
            echo 'failure';
        }
    }


    public function getbuyeritemdataforitemedit(){
        $post_submit = $this->input->post();
        if($post_submit){
            $getbuyeritemdataforitemedit = $this->admin_model->getbuyeritemdataforitemedit(trim($this->input->post('id')));
            if($getbuyeritemdataforitemedit){
                $content = $getbuyeritemdataforitemedit[0];
                echo json_encode($content);
            }else{
                echo 'failure';
            }
        }
    }


    public function getSupplieritemdataforitemedit(){
        $post_submit = $this->input->post();
        if($post_submit){
            $getSupplieritemdataforitemedit = $this->admin_model->getSupplieritemdataforitemedit(trim($this->input->post('id')));
            if($getSupplieritemdataforitemedit){
                $content = $getSupplieritemdataforitemedit[0];
                echo json_encode($content);
            }else{
                echo 'failure';
            }
        }
    }
    
    public function getVendoritemdataforitemedit(){
        $post_submit = $this->input->post();
        if($post_submit){
            $getVendoritemdataforitemedit = $this->admin_model->getVendoritemdataforitemedit(trim($this->input->post('id')));
            if($getVendoritemdataforitemedit){
                $content = $getVendoritemdataforitemedit[0];
                echo json_encode($content);
            }else{
                echo 'failure';
            }
        }
    }

    public function getSupplierpoconfimationitemedit(){
        $post_submit = $this->input->post();
        if($post_submit){
            $getSupplierpoconfimationitemedit = $this->admin_model->getSupplierpoconfimationitemedit(trim($this->input->post('id')));
            if($getSupplierpoconfimationitemedit){
                $content = $getSupplierpoconfimationitemedit[0];
                echo json_encode($content);
            }else{
                echo 'failure';
            }
        }
    }


    public function getvendorpoconfirmationitemedit(){
        $post_submit = $this->input->post();
        if($post_submit){
            $getvendorpoconfirmationitemedit = $this->admin_model->getvendorpoconfirmationitemedit(trim($this->input->post('id')));
            if($getvendorpoconfirmationitemedit){
                $content = $getvendorpoconfirmationitemedit[0];
                echo json_encode($content);
            }else{
                echo 'failure';
            }
        }
    }


    public function getIncomingDetailitemedit(){
        $post_submit = $this->input->post();
        if($post_submit){
            $getIncomingDetailitemedit = $this->admin_model->getIncomingDetailitemedit(trim($this->input->post('id')));
            if($getIncomingDetailitemedit){
                $content = $getIncomingDetailitemedit[0];
                echo json_encode($content);
            }else{
                echo 'failure';
            }
        }
    }


    public function geteditBillofmaterialitem(){
        $post_submit = $this->input->post();
        if($post_submit){
            $geteditBillofmaterialitem = $this->admin_model->geteditBillofmaterialitem(trim($this->input->post('id')));
            if($geteditBillofmaterialitem){
                $content = $geteditBillofmaterialitem[0];
                echo json_encode($content);
            }else{
                echo 'failure';
            }
        }
    }

    public function geteditVendorbillofmaterialpoitem(){
        $post_submit = $this->input->post();
        if($post_submit){
            $geteditVendorbillofmaterialpoitem = $this->admin_model->geteditVendorbillofmaterialpoitem(trim($this->input->post('id')));
            if($geteditVendorbillofmaterialpoitem){
                $content = $geteditVendorbillofmaterialpoitem[0];
                echo json_encode($content);
            }else{
                echo 'failure';
            }
        }
    }


    public function geteditDebitnoteitemedit(){

        $post_submit = $this->input->post();
        if($post_submit){
            $geteditDebitnoteitemedit = $this->admin_model->geteditDebitnoteitemedit(trim($this->input->post('id')));
            if($geteditDebitnoteitemedit){
                $content = $geteditDebitnoteitemedit[0];
                echo json_encode($content);
            }else{
                echo 'failure';
            }
        }

    }


    public function geteditjobworkitem(){
        $post_submit = $this->input->post();
        if($post_submit){
            $geteditjobworkitem = $this->admin_model->geteditjobworkitem(trim($this->input->post('id')));
            if($geteditjobworkitem){
                $content = $geteditjobworkitem[0];
                echo json_encode($content);
            }else{
                echo 'failure';
            }
        }

    }


    public function geteditReworkRejectionitem(){
        $post_submit = $this->input->post();
        if($post_submit){
            $geteditReworkRejectionitem = $this->admin_model->geteditReworkRejectionitem(trim($this->input->post('id')),trim($this->input->post('vendor_po_number')),trim($this->input->post('vendor_supplier_name')));
            if($geteditReworkRejectionitem){
                $content = $geteditReworkRejectionitem[0];
                echo json_encode($content);
            }else{
                echo 'failure';
            }
        }
    }


    public function geteditqualityrecordsitem(){
        $post_submit = $this->input->post();
        if($post_submit){
            $geteditqualityrecordsitem = $this->admin_model->geteditqualityrecordsitem(trim($this->input->post('id')));
            if($geteditqualityrecordsitem){
                $content = $geteditqualityrecordsitem[0];
                echo json_encode($content);
            }else{
                echo 'failure';
            }
        }
    }
    
    
    public function geteditrejectionformitem(){
        $post_submit = $this->input->post();
        if($post_submit){
            $geteditrejectionformitem = $this->admin_model->geteditrejectionformitem(trim($this->input->post('id')));
            if($geteditrejectionformitem){
                $content = $geteditrejectionformitem[0];
                echo json_encode($content);
            }else{
                echo 'failure';
            }
        }

    }


    public function geteditpackinginstractionsubitem(){

        $post_submit = $this->input->post();
        if($post_submit){
            $geteditpackinginstractionsubitem = $this->admin_model->geteditpackinginstractionsubitem(trim($this->input->post('id')));
            if($geteditpackinginstractionsubitem){
                $content = $geteditpackinginstractionsubitem[0];
                echo json_encode($content);
            }else{
                echo 'failure';
            }
        }

    }


    public function geteditStockformitem(){

        $post_submit = $this->input->post();
        if($post_submit){
            $geteditStockformitem = $this->admin_model->geteditStockformitem(trim($this->input->post('id')));
            if($geteditStockformitem){
                $content = $geteditStockformitem[0];
                echo json_encode($content);
            }else{
                echo 'failure';
            }
        }

    }


    public function geteditChallanformitem(){
        $post_submit = $this->input->post();
        if($post_submit){
            $geteditChallanformitem = $this->admin_model->geteditChallanformitem(trim($this->input->post('id')),trim($this->input->post('vendor_po_number')),trim($this->input->post('vendor_supplier_name')));
            if($geteditChallanformitem){
                $content = $geteditChallanformitem[0];
                echo json_encode($content);
            }else{
                echo 'failure';
            }
        }
    }


    public function geteditScrpareturnid(){
        $post_submit = $this->input->post();
        if($post_submit){
            $geteditScrpareturnid = $this->admin_model->geteditScrpareturnid(trim($this->input->post('id')));
            if($geteditScrpareturnid){
                $content = $geteditScrpareturnid[0];
                echo json_encode($content);
            }else{
                echo 'failure';
            }
        }
    }

    public function geteditPODitem(){
        $post_submit = $this->input->post();
        if($post_submit){
            $geteditPODitem = $this->admin_model->geteditPODitemedit(trim($this->input->post('id')));
            if($geteditPODitem){
                $content = $geteditPODitem[0];
                echo json_encode($content);
            }else{
                echo 'failure';
            }
        }
    }

    
    public function editrejectedformitemdata(){

        $post_submit = $this->input->post();
        if($post_submit){
            $saveenquiryform_response = array();
            $this->form_validation->set_rules('rejected_reason','Rejected Reason','trim|required');    
            $this->form_validation->set_rules('qty_in_pcs','Qty In PCS','trim|required');     
            $this->form_validation->set_rules('qty_in_kgs','Qty In KGS','trim|required');    
            $this->form_validation->set_rules('remark','Remark','trim');    

           if($this->form_validation->run() == FALSE)
           {
               $saveenquiryform_response['status'] = 'failure';
               $saveenquiryform_response['error'] =  array('rejected_reason'=>strip_tags(form_error('rejected_reason')),'qty_in_pcs'=>strip_tags(form_error('qty_in_pcs')),'qty_in_kgs'=>strip_tags(form_error('qty_in_kgs')));
          
           }else{
                $data = array(
                    'rejected_reason'  =>  trim($this->input->post('rejected_reason')),
                    'qty_in_pcs'  =>  trim($this->input->post('qty_in_pcs')),
                    'qty_in_kgs'  =>  trim($this->input->post('qty_in_kgs')),
                    'remark'  =>  trim($this->input->post('remark'))
                );

                $saveenquiryformitem = $this->admin_model->saveenquiryformitemedit(trim($this->input->post('rejection_form_id_popup')),$data);
                if($saveenquiryformitem){
                    $saveenquiryform_response['status'] = 'success';
                    $saveenquiryform_response['error'] =  array('rejected_reason'=>strip_tags(form_error('rejected_reason')),'qty_in_pcs'=>strip_tags(form_error('qty_in_pcs')),'qty_in_kgs'=>strip_tags(form_error('qty_in_kgs')));
                }
           }
           echo json_encode($saveenquiryform_response);
        }


    }   
    
    public function getVendoritemonlyforpod(){

        $vendor_po_number=$this->input->post('vendor_po_number');

        $flag=$this->input->post('vendor_supplier_name');

        if($vendor_po_number) {
			$getVendoritemsonly = $this->admin_model->getVendoritemonlyforpod($vendor_po_number,$flag);
			if(count($getVendoritemsonly) >= 1) {
                $content = $content.'<option value="">Select Part Number</option>';
				foreach($getVendoritemsonly as $value) {
					$content = $content.'<option value="'.$value["fin_id"].'"  data_id="'.$value["vendor_po_item_id"].'">'.$value["part_number"].'</option>';
				}
				echo $content;
			} else {
				echo 'failure';
			}
		} else {
			echo 'failure';
		}

    }


    public function getVendoritemonlyforchallan(){

        $vendor_po_number=$this->input->post('vendor_po_number');

        $flag=$this->input->post('vendor_supplier_name');

        if($vendor_po_number) {
			$getVendoritemsonly = $this->admin_model->getVendoritemonlyforchallan($vendor_po_number,$flag);
			if(count($getVendoritemsonly) >= 1) {
                $content = $content.'<option value="">Select Part Number</option>';
				foreach($getVendoritemsonly as $value) {
					$content = $content.'<option value="'.$value["fin_id"].'">'.$value["part_number"].'</option>';
				}
				echo $content;
			} else {
				echo 'failure';
			}
		} else {
			echo 'failure';
		}

    }

    public function getSuppliergoodsreworkrejectionvendorpod(){
        
        if($this->input->post('part_number')) {
            $getPartNameBypartid = $this->admin_model->getSuppliergoodsreworkrejectionvendorpod($this->input->post('part_number'),$this->input->post('vendor_po_number'),trim($this->input->post('vendor_supplier_name')));
            if($getPartNameBypartid){
                $content = $getPartNameBypartid[0];
                echo json_encode($content);

            }else{
                echo 'failure';
            }
           
        } else {
            echo 'failure';
        }
    }

    public function getSuppliergoodsreworkrejectionvendorchallan(){
        
        if($this->input->post('part_number')) {
            $getPartNameBypartid = $this->admin_model->getSuppliergoodsreworkrejectionvendorchallan($this->input->post('part_number'),$this->input->post('vendor_po_number'),trim($this->input->post('vendor_supplier_name')));
            if($getPartNameBypartid){
                $content = $getPartNameBypartid[0];
                echo json_encode($content);

            }else{
                echo 'failure';
            }
           
        } else {
            echo 'failure';
        }
    }


    
    public function getSuppliergoodsreworkrejectionvendorreworkrejection(){
        
        if($this->input->post('part_number')) {
            $getPartNameBypartid = $this->admin_model->getSuppliergoodsreworkrejectionvendorreworkrejection($this->input->post('part_number'),$this->input->post('vendor_po_number'),trim($this->input->post('vendor_supplier_name')));
            if($getPartNameBypartid){
                $content = $getPartNameBypartid[0];
                echo json_encode($content);

            }else{
                echo 'failure';
            }
           
        } else {
            echo 'failure';
        }
    }


    public function getexportdetailsforqulityrecord(){
        $post_submit = $this->input->post();
        if($post_submit){
    
            $buyer_po = $this->input->post('buyer_po');
        
            // load table library
            $this->load->library('table');
            
            // set heading
            $this->table->set_heading('Part Number', 'Description','Buyer Invoice Number', 'Buyer Invoice Date','Buyer Invoice Qty','Box Qty','Remark');
    
            // set template
            $style = array('table_open'  => '<p><b>Export Details</b></p><table style="max-width: 70%;display: block;overflow-x: auto; white-space: nowrap;" class="table">');
    
            $this->table->set_template($style);
            $this->db->select(TBL_FINISHED_GOODS.'.part_number,'.TBL_FINISHED_GOODS.'.name,'.TBL_PACKING_INSTRACTION_DETAILS.'.buyer_invoice_number,'.TBL_PACKING_INSTRACTION_DETAILS.'.buyer_invoice_date,'.TBL_PACKING_INSTRACTION_DETAILS.'.buyer_invoice_qty,'.TBL_PACKING_INSTRACTION_DETAILS.'.box_qty,'.TBL_PACKING_INSTRACTION_DETAILS.'.remark');
            $this->db->join(TBL_PACKING_INSTRACTION_DETAILS, TBL_PACKING_INSTRACTION_DETAILS.'.packing_instract_id = '.TBL_PACKING_INSTRACTION.'.id');
            $this->db->join(TBL_FINISHED_GOODS, TBL_FINISHED_GOODS.'.fin_id = '.TBL_PACKING_INSTRACTION_DETAILS.'.part_number');
            $this->db->where(TBL_PACKING_INSTRACTION.'.buyer_po_number',$buyer_po);
            $query_result = $this->db->get(TBL_PACKING_INSTRACTION);
            $data = $query_result->result_array();
    
            if($data){
                echo $this->table->generate($query_result);
    
            }else{
                echo '';
            }
        }

    }

    public function geteditChallanformitemforedititem(){

        $post_submit = $this->input->post();
        if($post_submit){
            $geteditPODitem = $this->admin_model->geteditChallanformitemforedititem(trim($this->input->post('id')));
            if($geteditPODitem){
                $content = $geteditPODitem[0];
                echo json_encode($content);
            }else{
                echo 'failure';
            }
        }

    }


    public function geteditenquiryformitemdata(){
        $post_submit = $this->input->post();
        if($post_submit){
            $geteditPODitem = $this->admin_model->geteditenquiryformitemdata(trim($this->input->post('id')));
            if($geteditPODitem){
                $content = $geteditPODitem[0];
                echo json_encode($content);
            }else{
                echo 'failure';
            }
        }
    }


   public function getdebitnotepartnumberdetails_byvendor(){
        if($this->input->post('part_number')) {
            $getPartNameBypartid = $this->admin_model->getdebitnotepartnumberdetails_byvendor($this->input->post('part_number'),$this->input->post('vendor_po_number'));
            if($getPartNameBypartid){
                $content = $getPartNameBypartid[0];
                echo json_encode($content);

            }else{
                echo 'failure';
            }
        
        } else {
            echo 'failure';
        }
   }
    

   public function getVendoritemonlyforreworkrejection(){

    $vendor_po_number=$this->input->post('vendor_po_number');

    $flag=$this->input->post('flag');

    if($vendor_po_number) {
        $getVendoritemsonly = $this->admin_model->getVendoritemonlyforreworkrejection($vendor_po_number,$flag);
        if(count($getVendoritemsonly) >= 1) {
            $content = $content.'<option value="">Select Part Number</option>';
            foreach($getVendoritemsonly as $value) {
                $content = $content.'<option value="'.$value["fin_id"].'">'.$value["part_number"].'</option>';
            }
            echo $content;
        } else {
            echo 'failure';
        }
    } else {
        echo 'failure';
    }

}


public function downlaodsupplierpo($id){
    $getsupplierdeatilsForInvoice = $this->admin_model->getsupplierdeatilsForInvoice($id);
    $getsupplierItemdeatilsForInvoice = $this->admin_model->getsupplierItemdeatilsForInvoice($id);

    if($getsupplierdeatilsForInvoice['quatation_date']!='0000-00-00'){
        $quatation_date =  date('d-m-Y',strtotime($getsupplierdeatilsForInvoice['quatation_date']));
    }else{
        $quatation_date = '';
    }

    $CartItem = "";
    $i =1;
    $subtotal = 0;

    $item_count =count($getsupplierItemdeatilsForInvoice);

    if($item_count==1){
        $padding_bottom = '95px';
    }else if($item_count==2){
        $padding_bottom = '28px';
    }else if($item_count==3){
        $padding_bottom = '10px';
    }else{
        $padding_bottom = '10px';
    }

    foreach ($getsupplierItemdeatilsForInvoice as $key => $value) {
        $CartItem .= '
                <tr style="style=border-left: 1px solid black;border-right: 1px solid black;">
                    <td style="border-left: 1px solid black;border-right: 1px solid black;text-align:left;padding: 10px;" valign="top">'.$i.'</td>
                    <td style="border-left: 1px solid black;border-right: 1px solid black;text-align:left;padding: 10px;" valign="top">'.$value['type_of_raw_material'].' <br>Vendor Qty-'.$value['vendor_qty'].' pcs </br> <br>Gross Weight-'.$value['rmgrossweight'].' kgs </br><br>'.$value['description_1'].'</br><br>'.$value['description_2'].'</br></td>   
                    <td style="border-left: 1px solid black;border-right: 1px solid black;text-align:left;padding: 10px;" valign="top">'.$value['part_number'].'</td>
                    <td style="border-left: 1px solid black;border-right: 1px solid black;text-align:left;padding: 10px;" valign="top">'.$value['order_oty'].'</td>
                    <td style="border-left: 1px solid black;border-right: 1px solid black;text-align:left;padding: 10px;" valign="top">'.$value['unit'].'</td> 
                    <td style="border-left: 1px solid black;border-right: 1px solid black;text-align:left;padding: 10px;" valign="top">'.$value['rate'].'/-'.'</td>    
                    <td style="border-left: 1px solid black;border-right: 1px solid black;text-align:left;padding: 10px;" valign="top">'.$value['value'].'/-'.'</td>
                </tr>';
                $subtotal+=$value['value'];
            $i++;       
    }

    $space = '<tr>
        <td style="padding-bottom: '.$padding_bottom.';border-left: 1px solid black;border-right: 1px solid black;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </td>
        <td style="padding-bottom: '.$padding_bottom.';border-left: 1px solid black;border-right: 1px solid black;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </td>
        <td style="padding-bottom: '.$padding_bottom.';border-left: 1px solid black;border-right: 1px solid black;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </td>
        <td style="padding-bottom: '.$padding_bottom.';border-left: 1px solid black;border-right: 1px solid black;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </td>
        <td style="padding-bottom: '.$padding_bottom.';border-left: 1px solid black;border-right: 1px solid black;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </td>
        <td style="padding-bottom: '.$padding_bottom.';border-left: 1px solid black;border-right: 1px solid black;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </td>
        <td style="padding-bottom: '.$padding_bottom.';border-left: 1px solid black;border-right: 1px solid black;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </td>
    </tr>';

    $mpdf = new \Mpdf\Mpdf();
    // $html = $this->load->view('html_to_pdf',[],true);
    $html = '<table style=" width: 100%;text-align: center;border-collapse: collapse;border: #cccccc 0px solid;font-family:cambria;">
                <tr>
                  <td rowspan="2"><img src="'.base_url().'assets/images/supra_logo_1.jpg" width="80" height="80"></td>
                  <td style="color:#000080"><h2>SUPRA QUALITY EXPORTS (I) PVT. LTD</h2></td>
                  <td rowspan="2"><img src="'.base_url().'assets/images/logo_2.png"width="80" height="80"></td>
                </tr>
                <tr>
                  <td style="font-weight: bold;">
                    <p>MANUFACTURER & EXPORTERS OF:</p>
                    <p>PRECISION TURNED COMPONENTS, STAMPED /PRESSED PARTS IN FERROUS & NON-FERROUS METAL</p>
                    <p>MOULDED & EXTRUDED PLASTIC AND RUBBER COMPONENTS</p> 
                  </td>
                </tr>
            </table>
            <hr>
            <table style="width: 100%;text-align: left;border-collapse: collapse;border: #ccc 0px solid;font-family:cambria;">
                    <tr>
                        <td width="60%">
                          <p><b>Office:</b> 229 to 232, Bharat Industrial Estate,
                          <p> L.B.S. Marg, Bhandup West, Mumbai – 400078. INDIA.</b>
                          <p>Tel: +91 22 66959505 / +91 22 66600196 </p>
                          <p>+91 22 62390222 / +91 22 46061497 / +91 22 35115396 </p>
                          <p style="color:#206a9b"><b>GSTIN : 27AAJCS7869M1ZB </b></p>
                        </td>
                        <td width="40%">
                            <p><b>Email:</b></p> 
                            <p style="color:#206a9b">purchase@supraexports.in</p>
                            <p style="color:#206a9b">purchase1@supraexports.in</p>
                            <p style="color:#206a9b">purchase2@supraexports.in</p>
                        </td>  
                    </tr>
            </table>

            <table style=" width: 100%;text-align: center;border-collapse: collapse;border: #ccc 0px solid;margin-top:10px;margin-bottom:10px;font-family:cambria;">
                    <tr>
                        <td style="color:red;font-size:15px">
                          <u><p><h3>PURCHASE ORDER</h3></p>
                        </td>
                    </tr>
            </table>

            <table style=" width: 100%;text-align: left;border-collapse: collapse;font-family:cambria;font-size:13px;border: #ccc 1px solid">
                <tr style="border: 1px solid black;">
                    <td width="50%" style="padding-left: 15px;">
                        <div>
                            <p>To,</p>
                            <p><b>'.$getsupplierdeatilsForInvoice['supplier_name'].'</b></p>
                            <p>'.$getsupplierdeatilsForInvoice['supplier_addess'].'</p>
                            <p><b>Contact No:</b> '.$getsupplierdeatilsForInvoice['suplier_mobile'].' / '.$getsupplierdeatilsForInvoice['suplier_landline'].'</p>
                            <p><b>Contact Person:</b> '.$getsupplierdeatilsForInvoice['sup_conatct'].'</p>
                            <p><b>Email:</b> '.$getsupplierdeatilsForInvoice['sup_email'].'</p>
                            <p style="color:red">GSTIN:'.$getsupplierdeatilsForInvoice['sup_GSTIN'].'</p>
                        <div>    
                    </td> 
                    <td style="border-left: 1px solid black;padding-left: 15px;font-size:13px" width="50%" >
                        <div>
                            <p><b>P.O.NO :</b> '.'<span style="color:red">'.$getsupplierdeatilsForInvoice['po_number'].'</span></p>
                            <p>&nbsp;</p>
                            <p><b>P.O.DATE :</b> '.date('d-m-Y',strtotime($getsupplierdeatilsForInvoice['date'])).'</p>
                            <p>&nbsp;</p>
                            <p><b>QUOTATION REFERENCE :</b> '.$getsupplierdeatilsForInvoice['quatation_ref_no'].'</p>
                            <p>&nbsp;</p>
                            <p><b>QUOTATION DATE :</b> '.$quatation_date.'</p>
                        </div>
                    </td>
                </tr>
            </table>

            <table style=" width: 100%;text-align: left;border-collapse: collapse;border: #ccc 1px solid;margin-top:10px;margin-bottom:10px;font-family:cambria;font-size:12px">
                <tr style="border: 1px solid black;">
                    <th align="left" style="border: 1px solid black;" margin-bottom: 10%;>NEED TEST CERTIFICATE</th>
                    <th align="left" style="border: 1px solid black;" margin-bottom: 10%;>DELIVERY DATE</th>
                    <th align="left" style="border: 1px solid black;" margin-bottom: 10%;>PAYMENT TERMS</th>    
                </tr>
                <tr style="border: 1px solid black;">
                    <td style="border: 1px solid black;text-align:center"><b>YES<b></td>
                    <td style="border: 1px solid black;padding-left: 15px;">'.date('d-m-Y',strtotime($getsupplierdeatilsForInvoice['delivery_date'])).'</td>    
                    <td style="border: 1px solid black;padding-left: 15px;">'.$getsupplierdeatilsForInvoice['work_order'].'</td>
                </tr>
            </table>


            <table style=" width: 100%;text-align: left;border-collapse: collapse;border: #ccc 1px solid;margin-top:10px;margin-bottom:10px;font-family:cambria;font-size:12px">
                <tr style="border: 1px solid black;">
                    <th align="left" style="border: 1px solid black;text-align:center;" margin-bottom: 10%;>SR.NO.</th>
                    <th align="left" style="border: 1px solid black;text-align:center;" margin-bottom: 10%;>PART DESCRIPTION</th>
                    <th align="left" style="border: 1px solid black;text-align:center;" margin-bottom: 10%;>PART NO.</th>  
                    <th align="left" style="border: 1px solid black;text-align:center;" margin-bottom: 10%;>QTY</th> 
                    <th align="left" style="border: 1px solid black;text-align:center;" margin-bottom: 10%;>UNITS</th>  
                    <th align="left" style="border: 1px solid black;text-align:center;" margin-bottom: 10%;>RATE</th>  
                    <th align="left"  style="border: 1px solid black;text-align:center;" margin-bottom: 10%;>AMOUNT</th>
                </tr>
                '.$CartItem.$space.' 
                   
               
 
                <tr style="border-left: 1px solid black;border-right: 1px solid black;">
                    <td style="border-left: 1px solid black;border-right: 1px solid black;"></td>
                    <td style="border-left: 1px solid black;border-right: 1px solid black;padding-left: 15px;"><p><b>Delivery Address</b></p>
                        <p>'.$getsupplierdeatilsForInvoice['vendor_name'].'</p>
                        <p>'.$getsupplierdeatilsForInvoice['ven_address'].'</p>
                        <p> <b>Kind Attn:</b> '.$getsupplierdeatilsForInvoice['ven_contact_person'].'</p>
                        <p> <b>Tel No:</b> '.$getsupplierdeatilsForInvoice['mobile'].' / '.$getsupplierdeatilsForInvoice['ven_landline'].'</p>
                        <p> <b>GSTIN:</b> '.$getsupplierdeatilsForInvoice['ven_GSTIN'].'</p> 
                    </td>
                    <td style="border-left: 1px solid black;border-right: 1px solid black;"></td>
                    <td style="border-left: 1px solid black;border-right: 1px solid black;"></td>
                    <td style="border-left: 1px solid black;border-right: 1px solid black;"></td>
                    <td style="border-left: 1px solid black;border-right: 1px solid black;"></td>
                    <td style="border-left: 1px solid black;border-right: 1px solid black;"></td>
                </tr>


                <tr style="border: 1px solid black;">
                    <td colspan="4" style="padding: 8px;">'.$this->amount_in_word($subtotal).'</td>
                
                    <td colspan="2"  style="border: 1px solid black;padding-left: 10px;padding-right: 10px;font-family:cambria;font-size:12px;">SUB TOTAL (+) GST </td>    
                    <td style="border: 1px solid black;padding-left: 10px;">'.$subtotal.'/-'.'</td>
                </tr>
            </table>

            <table style=" width: 100%;border-collapse: collapse;border: #ccc 1px solid;font-family:cambria;font-size:12px">
                <tr style="border: 1px solid black;">
                        <td style="border: 1px solid black;padding-left: 10px;">
                            <p><b>Remark :</b>'.$getsupplierdeatilsForInvoice['remark'].'</p>    
                    </td>   
                </tr>
            </table>

            <table style=" width: 100%;text-align: left;border-collapse: collapse;border: #ccc 1px solid;margin-top:10px;margin-bottom:10px;font-family:cambria;font-size:12px">
                  
                   <tr style="border: 1px solid black;">
                        <td style="border: 1px solid black;padding-left: 10px;" width="75%;">
                            <p><b>NOTE :</b></p>
                            <p><b>1. Confirmation of PO is Mandatory</b></p>
                            <p><b>2. Mentioning P.O.No. on Invoice is Mandatory</b></p>
                            <p><b>3. Once order issued & accepted, cannot be cancelled</b></p>
                            <p><b>4. Essence of this order is delivering the specified quality product on time.</b></p>
                            <p><b>5. If any Prices issue, should inform in 24hrs after receipt of P.O.</b></p>
                        </td>
                        <td style="border: 1px solid black;text-align: center;" width="25%" valign="top">
                            <p style="vertical-align: text-top;font-size:12px;color:#206a9b"><b>FOR SUPRA QUALITY EXPORTS (I) PVT. LTD.</b></p>
                            <br/><img src="'.base_url().'assets/images/stmps/supplierpostampsignature.png" width="130" height="100">
                            <p style="vertical-align: text-top;font-size:10px;color:#206a9b"><b>AUTHORIZED SIGNATORY</b></p>
                        </td> 
                </tr>
            </table>';

            // <p>FOR SUPRA QUALITY EXPORTS (I) PVT. LTD.</p>
    $invoice_name =  $getsupplierdeatilsForInvoice['po_number'].' - '.$getsupplierdeatilsForInvoice['supplier_name'].'.pdf';
    $mpdf->WriteHTML($html);
    $mpdf->Output($invoice_name,'D'); // opens in browser


}



public function getpreviousshortexcess(){

    $post_submit = $this->input->post();

    if($post_submit){
        $getpreviousshortexcess = $this->admin_model->getpreviousshortexcess(trim($this->input->post('part_number')),trim($this->input->post('vendor_po_number')),trim($this->input->post('supplier_po_number')));
        if($getpreviousshortexcess){
            $content = $getpreviousshortexcess[0];
            echo json_encode($content);
        }else{
            echo 'failure';
        }
    }

}


public function buyerpodetailsreport(){

    $process = 'View Buyer PO Details Report';
    $processFunction = 'Admin/editrejetionform';
    $this->logrecord($process,$processFunction);
    $this->global['pageTitle'] = 'View Buyer PO Details Report';
    $data['buyerList']= $this->admin_model->fetchAllbuyerList();
    $data['itemList']= $this->admin_model->fetchALLFinishgoodListforbuyerpodetailreport();
    $this->loadViews("masters/viewbuyerpodetailsreport", $this->global, $data, NULL);
}


public function fetchbuyerpodetailsreport($buyer_name,$part_number,$from_date,$to_date){
    $params = $_REQUEST;
    $totalRecords = $this->admin_model->fetchbuyerpodetailsreportCount($params,$buyer_name,$part_number,$from_date,$to_date); 
    $queryRecords = $this->admin_model->fetchbuyerpodetailsreportData($params,$buyer_name,$part_number,$from_date,$to_date); 

    $data = array();
    foreach ($queryRecords as $key => $value)
     {
            $i = 0;
            foreach($value as $v)
            {
                $data[$key][$i] = $v;
                $i++;
            }
     }
     
     $json_data = array(
            "draw"            => intval( $params['draw'] ),   
            "recordsTotal"    => intval( $totalRecords ),  
            "recordsFiltered" => intval($totalRecords),
            "data"            => $data   // total data array
            );
     echo json_encode($json_data);
}


public function calculatesumofallbuyerdetails($buyer_name,$part_number,$from_date,$to_date){

    $vendor_po_number_stock_data = $this->admin_model->calculatesumofallbuyerdetails($buyer_name,$part_number,$from_date,$to_date);
    if(count($vendor_po_number_stock_data) >= 1) {
        echo json_encode($vendor_po_number_stock_data[0]);
    } else {
        echo 'failure';
    }

}


public function exportbuyerdetailsrecord($buyer_name,$part_number,$from_date,$to_date){

    
    // create file name
    $fileName = 'Buyer Order & Exports Report -'.date('d-m-Y').'.xlsx';  
    // load excel library
    $empInfo = $this->admin_model->exportbuyerdetailsrecord($buyer_name,$part_number,$from_date,$to_date);

    $objPHPExcel = new PHPExcel();
    $objPHPExcel->setActiveSheetIndex(0);
    // set Header
    $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'Buyer Name');
    $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Buyer PO No');
    $objPHPExcel->getActiveSheet()->SetCellValue('C1', 'Buyer PO Date');
    $objPHPExcel->getActiveSheet()->SetCellValue('D1', 'Part Number'); 
    $objPHPExcel->getActiveSheet()->SetCellValue('E1', 'Part Description');
    $objPHPExcel->getActiveSheet()->SetCellValue('F1', 'Order Qty');   
    $objPHPExcel->getActiveSheet()->SetCellValue('G1', 'Delivery Date');  
    $objPHPExcel->getActiveSheet()->SetCellValue('H1', 'Export Invoice No');  
    $objPHPExcel->getActiveSheet()->SetCellValue('I1', 'Export Qty');  
    $objPHPExcel->getActiveSheet()->SetCellValue('J1', 'Export Invoice Date');  
    $objPHPExcel->getActiveSheet()->SetCellValue('K1', 'Remark');


    // set Row
    $rowCount = 2;
    foreach ($empInfo as $element) {
        $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $element['buyer_name']);
        $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $element['sales_order_number']);
        $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $element['buyer_po_date']);
        $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $element['part_number']);
        $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $element['name']);
        $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, $element['order_oty']);
        $objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, $element['buyer_po_part_delivery_date']);
        $objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, $element['buyer_invoice_number']);
        $objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, $element['buyer_invoice_qty']);
        $objPHPExcel->getActiveSheet()->SetCellValue('J' . $rowCount, $element['buyer_invoice_date']);
        $objPHPExcel->getActiveSheet()->SetCellValue('K' . $rowCount, $element['remark']);
        $rowCount++;
    }

    foreach(range('A','K') as $columnID) {
        $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
    }
    /*********************Autoresize column width depending upon contents END***********************/
    
    $objPHPExcel->getActiveSheet()->getStyle('A1:K1')->getFont()->setBold(true); //Make heading font bold
    
    /*********************Add color to heading START**********************/
    $objPHPExcel->getActiveSheet()
                ->getStyle('A1:K1')
                ->getFill()
                ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                ->getStartColor()
                ->setARGB('99ff99');


    $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
      
    header('Content-Type: application/vnd.ms-excel');
    header("Content-Disposition: attachment;Filename=$fileName.xls");
    header('Cache-Control: max-age=0');
    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
    $objWriter->save('php://output');    
}

public function complaintform(){

    $process = 'Complaint Form';
    $processFunction = 'Admin/complaintform';
    $this->logrecord($process,$processFunction);
    $this->global['pageTitle'] = 'Complaint Form';
    $data['vendorList']= $this->admin_model->fetchALLvendorList();
    $this->loadViews("masters/viewcomplaintform", $this->global, $data, NULL);  
}

public function addcomplaintform(){

    $post_submit = $this->input->post();
    if($post_submit){
        $add_complainform_response = array();
        $this->form_validation->set_rules('report_no','Report No','trim|required');
        $this->form_validation->set_rules('stage','Stage','trim|required');
        $this->form_validation->set_rules('drawing_no_rev_no','Drawing No / Rev No','trim|required');
        $this->form_validation->set_rules('vendor_name','Vendor Name','trim|required');
        $this->form_validation->set_rules('po_no_wo_no','PO_NO/WO_NO','trim|required');
        $this->form_validation->set_rules('component_description','Component Description','trim|required');
      
        if($this->form_validation->run() == FALSE)
        {
            $add_complainform_response['status'] = 'failure';
            $add_complainform_response['error'] = array('report_no'=>strip_tags(form_error('report_no')),'stage'=>strip_tags(form_error('stage')),'drawing_no_rev_no'=>strip_tags(form_error('drawing_no_rev_no')),'vendor_name'=>strip_tags(form_error('vendor_name')),'po_no_wo_no'=>strip_tags(form_error('po_no_wo_no')),'component_description'=>strip_tags(form_error('component_description')));

        }else{

            $data = array(
                'report_no' => trim($this->input->post('report_no')),
                'stage' => trim($this->input->post('stage')),
                'date_of_observation_rejection_found' => trim($this->input->post('date_of_observation_rejection_found')),
                'total_failure_qty' => trim($this->input->post('total_failure_qty')),
                'drawing_no_rev_no' => trim($this->input->post('drawing_no_rev_no')),
                'challan_no' => trim($this->input->post('challan_no')),
                'vendor_name' => trim($this->input->post('vendor_name')),
                'po_no_wo_no' => trim($this->input->post('po_no_wo_no')),
                'poac' => trim($this->input->post('poac')),
                'inword_no' => trim($this->input->post('inword_no')),
                'component_description' => trim($this->input->post('component_description')),
                'total_qty_checked' => trim($this->input->post('total_qty_checked')),
                'problem_description' => trim($this->input->post('total_qty_checked')),
                'intermidiate_disposal' => trim($this->input->post('intermidiate_disposal')),
                'root_cause' => trim($this->input->post('root_cause')),
                'coorection' => trim($this->input->post('coorection')),
                'coorection_responsibility' => trim($this->input->post('coorection_responsibility')),
                'coorection_date' => trim($this->input->post('coorection_date')),
                'corrective_action_taken' => trim($this->input->post('corrective_action_taken')),
                'corrective_action_responsibility' => trim($this->input->post('corrective_action_responsibility')),
                'corrective_action_date' => trim($this->input->post('corrective_action_date')),
                'effective_action' => trim($this->input->post('effective_action')),
                'effective_action_responsiblity' => trim($this->input->post('effective_action_responsiblity')),
                'effective_action_date' => trim($this->input->post('effective_action_date')),
                'team' => trim($this->input->post('team')),
                'prepared_by' => trim($this->input->post('prepared_by')),
                'prepared_by_date' => trim($this->input->post('prepared_by_date')),                
                'approved_by' => trim($this->input->post('approved_by')),
                'approved_by_date' => trim($this->input->post('approved_by_date')),
                'report_closed_by' => trim($this->input->post('report_closed_by')),
                'report_close_date' => trim($this->input->post('report_close_date')),
            );

            if(trim($this->input->post('complain_form_id'))){
                $complain_form_id = trim($this->input->post('complain_form_id'));
            }else{
                $complain_form_id = '';
            }    

            $savenewcomplaintform= $this->admin_model->savenewcomplaintform($complain_form_id,$data);
              if($savenewcomplaintform){
                  $add_complainform_response['status'] = 'success';
                  $add_complainform_response['error'] = array('report_no'=>strip_tags(form_error('report_no')),'stage'=>strip_tags(form_error('stage')),'drawing_no_rev_no'=>strip_tags(form_error('drawing_no_rev_no')),'vendor_name'=>strip_tags(form_error('vendor_name')),'po_no_wo_no'=>strip_tags(form_error('po_no_wo_no')),'component_description'=>strip_tags(form_error('component_description')));
                }else{
                  $add_complainform_response['status'] = 'failure';
                  $add_complainform_response['error'] = array('report_no'=>strip_tags(form_error('report_no')),'stage'=>strip_tags(form_error('stage')),'drawing_no_rev_no'=>strip_tags(form_error('drawing_no_rev_no')),'vendor_name'=>strip_tags(form_error('vendor_name')),'po_no_wo_no'=>strip_tags(form_error('po_no_wo_no')),'component_description'=>strip_tags(form_error('component_description')));
                }
        }
        echo json_encode($add_complainform_response);
    }else{

        $process = 'Add New Compalint Form';
        $processFunction = 'Admin/addanalaysisandcorrectiveactionreport';
        $this->logrecord($process,$processFunction);
        $this->global['pageTitle'] = 'Add New Compalint Form';
        $data['getPreviousCompalinformnumber']= $this->admin_model->getPreviousCompalinformnumber()[0];
        $data['vendorList']= $this->admin_model->fetchALLvendorList();
        $this->loadViews("masters/addcomplaintform", $this->global, $data, NULL);
    }
}

public function fetchcompalintrecords(){
    $params = $_REQUEST;
    $totalRecords = $this->admin_model->fetchcompalintrecordsCount($params); 
    $queryRecords = $this->admin_model->fetchcompalintrecordsData($params); 

    $data = array();
    foreach ($queryRecords as $key => $value)
     {
            $i = 0;
            foreach($value as $v)
            {
                $data[$key][$i] = $v;
                $i++;
            }
     }
     
     $json_data = array(
            "draw"            => intval( $params['draw'] ),   
            "recordsTotal"    => intval( $totalRecords ),  
            "recordsFiltered" => intval($totalRecords),
            "data"            => $data   // total data array
            );
     echo json_encode($json_data);
}


public function itcreport(){
    $process = 'ITC Report';
    $processFunction = 'Admin/itcreport';
    $this->logrecord($process,$processFunction);
    $this->global['pageTitle'] = 'ITC Report';
    $data['jobworkdetails']= $this->admin_model->getjobworkdetails();
    $this->loadViews("masters/viewitcreport", $this->global, $data, NULL);  
}


public function exportitcreportITC($ITC_report,$job_work_no,$from_date,$to_date){


      if($ITC_report=='itc_4'){
                // create file name
                $fileName = 'ITC 4 Report -'.date('d-m-Y').'.xlsx';  
                // load excel library
                $empInfo = $this->admin_model->exportitcreportITCrecord($ITC_report,$job_work_no,$from_date,$to_date);
            
                $objPHPExcel = new PHPExcel();
                $objPHPExcel->setActiveSheetIndex(0);
                // set Header
                $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'GST No');
                $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'State');
                $objPHPExcel->getActiveSheet()->SetCellValue('C1', 'Job worker`s type');
                $objPHPExcel->getActiveSheet()->SetCellValue('D1', 'Challan No'); 
                $objPHPExcel->getActiveSheet()->SetCellValue('E1', 'Challan date');
                $objPHPExcel->getActiveSheet()->SetCellValue('F1', 'Type of Goods');   
                $objPHPExcel->getActiveSheet()->SetCellValue('G1', 'Description of goods');  
                $objPHPExcel->getActiveSheet()->SetCellValue('H1', 'UQC');  
                $objPHPExcel->getActiveSheet()->SetCellValue('I1', 'Quantity');  
                $objPHPExcel->getActiveSheet()->SetCellValue('J1', 'Taxable value');  
                $objPHPExcel->getActiveSheet()->SetCellValue('K1', 'Integrated tax rate(%)');
                $objPHPExcel->getActiveSheet()->SetCellValue('L1', 'central tax(%)');
                $objPHPExcel->getActiveSheet()->SetCellValue('M1', 'state tax(%)');
            
            
                // set Row
                $rowCount = 2;
                foreach ($empInfo as $element) {

                    if($element['gst_rate']=='CGST_SGST'){
                        $centraltax = '9.00';
                        $statetax   = '9.00';
                    }else{
                        $centraltax = '';
                        $statetax   = '';
                    }
                    
                    if($element['gst_rate']=='IGST'){
                        $igsttax = '18.00';
                    }else{
                        $igsttax = '';
                    }  

                    $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $element['GSTIN']);
                    $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, '');
                    $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, 'Non SEZ');
                    $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $element['po_number']);
                    $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, date("d-m-Y", strtotime($element['date'])));
                    $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, 'Inputs');
                    $objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, 'Part No '.$element['part_number']);
                    $objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, $element['unit']);
                    $objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, $element['rm_actual_qty']);
                    $objPHPExcel->getActiveSheet()->SetCellValue('J' . $rowCount, $element['total']);
                    $objPHPExcel->getActiveSheet()->SetCellValue('K' . $rowCount, $igsttax);
                    $objPHPExcel->getActiveSheet()->SetCellValue('L' . $rowCount, $centraltax);
                    $objPHPExcel->getActiveSheet()->SetCellValue('M' . $rowCount, $statetax);
                    $rowCount++;
                }
            
                foreach(range('A','M') as $columnID) {
                    $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
                }
                /*********************Autoresize column width depending upon contents END***********************/
                
                $objPHPExcel->getActiveSheet()->getStyle('A1:M1')->getFont()->setBold(true); //Make heading font bold
                
                /*********************Add color to heading START**********************/
                $objPHPExcel->getActiveSheet()
                            ->getStyle('A1:M1')
                            ->getFill()
                            ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                            ->getStartColor()
                            ->setARGB('99ff99');
            
            
                $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
                    
                header('Content-Type: application/vnd.ms-excel');
                header("Content-Disposition: attachment;Filename=$fileName.xls");
                header('Cache-Control: max-age=0');
                $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
                $objWriter->save('php://output');  

      }

      if($ITC_report=='itc_5'){

        // create file name
                $fileName = 'ITC 5 Report -'.date('d-m-Y').'.xlsx';  
                // load excel library
                $empInfo = $this->admin_model->exportitcreportITCrecord($ITC_report,$job_work_no,$from_date,$to_date);
            
                $objPHPExcel = new PHPExcel();
                $objPHPExcel->setActiveSheetIndex(0);
                // set Header
                $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'GST No');
                $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'State');
                $objPHPExcel->getActiveSheet()->SetCellValue('C1', 'Job worker`s type');
                $objPHPExcel->getActiveSheet()->SetCellValue('D1', 'Challan No'); 
                $objPHPExcel->getActiveSheet()->SetCellValue('E1', 'Challan date');
                // $objPHPExcel->getActiveSheet()->SetCellValue('F1', 'Type of Goods');  
                $objPHPExcel->getActiveSheet()->SetCellValue('F1', 'Challan no issued by job worker');  
                $objPHPExcel->getActiveSheet()->SetCellValue('G1', 'Challan date issued by job worker');  
                $objPHPExcel->getActiveSheet()->SetCellValue('H1', 'Nature Of Job Work');  
                $objPHPExcel->getActiveSheet()->SetCellValue('I1', 'Description of goods');  
                $objPHPExcel->getActiveSheet()->SetCellValue('J1', 'UQC');  
                $objPHPExcel->getActiveSheet()->SetCellValue('K1', 'Quantity');
            
            
                // set Row
                $rowCount = 2;
                foreach ($empInfo as $element) {
                    $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $element['GSTIN']);
                    $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, '');
                    $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, '');
                    $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $element['po_number']);
                    $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount,  date("d-m-Y", strtotime($element['date'])));
                    $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, '');
                    $objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, '');
                    $objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, 'Goods received back from JW');
                    $objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, 'Part No '.$element['part_number']);
                    $objPHPExcel->getActiveSheet()->SetCellValue('J' . $rowCount, 'Pieces');
                    $objPHPExcel->getActiveSheet()->SetCellValue('K' . $rowCount, '');
                    $rowCount++;
                }
            
                foreach(range('A','K') as $columnID) {
                    $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
                }
                /*********************Autoresize column width depending upon contents END***********************/
                
                $objPHPExcel->getActiveSheet()->getStyle('A1:K1')->getFont()->setBold(true); //Make heading font bold
                
                /*********************Add color to heading START**********************/
                $objPHPExcel->getActiveSheet()
                            ->getStyle('A1:K1')
                            ->getFill()
                            ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                            ->getStartColor()
                            ->setARGB('99ff99');
            
            
                $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
                    
                header('Content-Type: application/vnd.ms-excel');
                header("Content-Disposition: attachment;Filename=$fileName.xls");
                header('Cache-Control: max-age=0');
                $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
                $objWriter->save('php://output'); 
      }
    
}

public function deletecomplainform(){

    $post_submit = $this->input->post();
    if($post_submit){
        $result = $this->admin_model->deletecomplainform(trim($this->input->post('id')));
        if ($result) {
                    $process = 'Delete Compliant Form';
                    $processFunction = 'Admin/deletecomplainform';
                    $this->logrecord($process,$processFunction);
                echo(json_encode(array('status'=>'success')));
            }
        else { echo(json_encode(array('status'=>'failed'))); }
    }else{
        echo(json_encode(array('status'=>'failed'))); 
    }

}

public function getPartDetailsbypartnumber(){
    $drawing_no_rev_no=$this->input->post('drawing_no_rev_no');
    if($drawing_no_rev_no) {
        $drawing_no_rev_noItem = $this->admin_model->getPartDetailsbypartnumber($drawing_no_rev_no);
        if(count($drawing_no_rev_noItem) >= 1) {
            $content = $content.'<option value="">Select Part Number</option>';
            foreach($drawing_no_rev_noItem as $value) {
                $content = $content.'<option value="'.$value["fin_id"].'" selected>'.$value["name"].'</option>';
            }
            echo $content;
        } else {
            echo 'failure';
        }
    } else {
        echo 'failure';
    }

}

public function editcomplainform($id){
    $process = 'Edit Complain Form';
    $processFunction = 'Admin/editcomplainform';
    $this->logrecord($process,$processFunction);
    $this->global['pageTitle'] = 'Edit Complain Form';
    $data['getcompalinformdata']= $this->admin_model->getcompalinformdata($id);
    $data['vendorList']= $this->admin_model->fetchALLvendorList();
    $this->loadViews("masters/editcomplainform", $this->global, $data, NULL);
}


public function creditnote(){

    $process = 'Credit Note';
    $processFunction = 'Admin/creditnote';
    $this->logrecord($process,$processFunction);
    $this->global['pageTitle'] = 'Credit Note';
    $data['vendorList']= $this->admin_model->fetchALLvendorList();
    $this->loadViews("masters/viewcreditnote", $this->global, $data, NULL);  
}

public function addcreditnote(){

    $post_submit = $this->input->post();
    if($post_submit){
        $add_creditnote_response = array();
        $this->form_validation->set_rules('credit_note_number','credit_note_number','trim|required');
        $this->form_validation->set_rules('date','date','trim|required');
        $this->form_validation->set_rules('buyer_name','buyer_name','trim|required');
        $this->form_validation->set_rules('buyer_po_number','Buyer PO  Number','trim|required');
        $this->form_validation->set_rules('currency','Currency','trim');
        $this->form_validation->set_rules('remark','Remark','trim');
      
        if($this->form_validation->run() == FALSE)
        {
            $add_creditnote_response['status'] = 'failure';
            $add_creditnote_response['error'] = array('credit_note_number'=>strip_tags(form_error('credit_note_number')),'date'=>strip_tags(form_error('date')),'buyer_name'=>strip_tags(form_error('buyer_name')),'buyer_po_number'=>strip_tags(form_error('buyer_po_number')),'currency'=>strip_tags(form_error('currency')),'remark'=>strip_tags(form_error('remark')));

        }else{

            $data = array(
                'credit_note_number' => trim($this->input->post('credit_note_number')),
                'date' => trim($this->input->post('date')),
                'buyer_name' => trim($this->input->post('buyer_name')),
                'buyer_po_number' => trim($this->input->post('buyer_po_number')),
                'currency' => trim($this->input->post('currency')),
                'remark' => trim($this->input->post('remark')),
            );

            if(trim($this->input->post('cerdit_note_id'))){
                $cerdit_note_id = trim($this->input->post('cerdit_note_id'));
            }else{
                $cerdit_note_id = '';
            }    

            $savenewcreditnote= $this->admin_model->savenewcreditnote($cerdit_note_id,$data);
              if($savenewcreditnote){
                $update_last_inserted_id_credite_note_details = $this->admin_model->update_last_inserted_id_credite_note_details($savenewcreditnote);
                if($update_last_inserted_id_credite_note_details){

                  $add_creditnote_response['status'] = 'success';
                  $add_creditnote_response['error'] = array('credit_note_number'=>strip_tags(form_error('credit_note_number')),'date'=>strip_tags(form_error('date')),'buyer_name'=>strip_tags(form_error('buyer_name')),'buyer_po_number'=>strip_tags(form_error('buyer_po_number')),'currency'=>strip_tags(form_error('currency')),'remark'=>strip_tags(form_error('remark')));
                }else{
                    $add_creditnote_response['status'] = 'failure';
                    $add_creditnote_response['error'] = array('credit_note_number'=>strip_tags(form_error('credit_note_number')),'date'=>strip_tags(form_error('date')),'buyer_name'=>strip_tags(form_error('buyer_name')),'buyer_po_number'=>strip_tags(form_error('buyer_po_number')),'currency'=>strip_tags(form_error('currency')),'remark'=>strip_tags(form_error('remark')));
               
                }
                }else{
                  $add_creditnote_response['status'] = 'failure';
                  $add_creditnote_response['error'] = array('credit_note_number'=>strip_tags(form_error('credit_note_number')),'date'=>strip_tags(form_error('date')),'buyer_name'=>strip_tags(form_error('buyer_name')),'buyer_po_number'=>strip_tags(form_error('buyer_po_number')),'currency'=>strip_tags(form_error('currency')),'remark'=>strip_tags(form_error('remark')));
                }
        }
        echo json_encode($add_creditnote_response);
    }else{

        $process = 'Add Credit Note';
        $processFunction = 'Admin/addcreditnote';
        $this->logrecord($process,$processFunction);
        $this->global['pageTitle'] = 'Add Credit Note';
        $data['getPreviousCreditnotenumber']= $this->admin_model->getPreviousCreditnotenumber()[0];
        $data['buyerList']= $this->admin_model->fetchAllbuyerList();
        $data['exportInvoiceList']= $this->admin_model->fetchexportInvoiceList();
        $data['fetchALLpreCredititemList']= $this->admin_model->fetchALLpreCredititemList();
        $this->loadViews("masters/addcreditnote", $this->global, $data, NULL);
    }

}

public function getBuyerPonumbercreditnote(){
    if($this->input->post('buyer_name')) {
        $getAllponumber = $this->admin_model->getBuyerPonumbercreditnote($this->input->post('buyer_name'));
        if(count($getAllponumber) >= 1) {
            $content = $content.'<option value="">Select Buyer Number</option>';
            foreach($getAllponumber as $value) {
                
                    $content = $content.'<option value="'.$value["id"].'">'.$value["sales_order_number"].' - '.$value["buyer_po_number"].'</option>';
            
            }
            echo $content;
        } else {
            echo 'failure';
        }
    } else {
        echo 'failure';
    }

}


public function getPartnumberBypartnumberforcreitnote(){

    if($this->input->post('part_number')) {
        $getPartNameBypartid = $this->admin_model->getPartnumberBypartnumberforcreitnote($this->input->post('part_number'));
        $content = $getPartNameBypartid[0];
        echo json_encode($content);
    } else {
        echo 'failure';
    }
}


public function getexportInvoicebybyerpo(){
    $buyer_po_number=$this->input->post('buyer_po_number');
    $part_number_for_export_invoice=$this->input->post('part_number_for_export_invoice');

    if($buyer_po_number) {
        $getSupplieritemsonly = $this->admin_model->getexportInvoicebybyerpo($buyer_po_number,$part_number_for_export_invoice);
        if(count($getSupplieritemsonly) >= 1) {
            $content = $content.'<option value="">Select Part Number</option>';
            foreach($getSupplieritemsonly as $value) {
                $content = $content.'<option value="'.$value["invoice_id"].'">'.$value["buyer_invoice_number"].'</option>';
            }
            echo $content;
        } else {
            echo 'failure';
        }
    } else {
        echo 'failure';
    }

}


public function getInvoicedateforcreditdate() {
    if($this->input->post('invoice_number')) {
                $getBuyerCurrency = $this->admin_model->getInvoicedateforcreditdate($this->input->post('invoice_number'));
                $content = $getBuyerCurrency[0]['buyer_invoice_date'];
            echo $content;
    } else {
        echo 'failure';
    }
}



public function saveCreditnoteitem(){
    $post_submit = $this->input->post();
    if($post_submit){

        $saveCreditnoteitem_response = array();
        $this->form_validation->set_rules('part_number','Part Number','trim|required');
        $this->form_validation->set_rules('invoice_no','Invoice Number','trim|required');
        $this->form_validation->set_rules('invoice_date','Invoice_date','trim|required');
        $this->form_validation->set_rules('qty','Qty','trim');
        $this->form_validation->set_rules('rate','Rate','trim');
        $this->form_validation->set_rules('invoice_value','Invoice Value','trim');
        $this->form_validation->set_rules('recivable_amount','Recivable Amount','trim');
        $this->form_validation->set_rules('diff_value','Diff Value','trim');
        $this->form_validation->set_rules('item_remark','Item Remark','trim');

        if($this->form_validation->run() == FALSE)
        {
            $saveCreditnoteitem_response['status'] = 'failure';
            $saveCreditnoteitem_response['error'] = array(
                'part_number'=>strip_tags(form_error('part_number')),
                'invoice_no'=>strip_tags(form_error('invoice_no')),
                'invoice_date'=>strip_tags(form_error('invoice_date')),
                'qty'=>strip_tags(form_error('qty')),
                'rate'=>strip_tags(form_error('rate')),
                'invoice_value'=>strip_tags(form_error('invoice_value')),
                'recivable_amount'=>strip_tags(form_error('recivable_amount')),
                'diff_value'=>strip_tags(form_error('diff_value')),
                'item_remark'=>strip_tags(form_error('item_remark')));
        }else{

            $cerdit_note_id =   $this->input->post('cerdit_note_id');

            if($cerdit_note_id){
                $credit_note_id_item =$cerdit_note_id;
            }else{
                $credit_note_id_item =NULL;
            }

             $data = array(
                'credit_note_id'=>$credit_note_id_item,
                'part_number'=>$this->input->post('part_number'),
                'invoice_no'=>$this->input->post('invoice_no'),
                'invoice_date'=>$this->input->post('invoice_date'),
                'qty'=>$this->input->post('qty'),
                'price'=>$this->input->post('rate'),
                'invoice_value'=>$this->input->post('invoice_value'),
                'recivable_amount'=>$this->input->post('recivable_amount'),
                'diff_credite_note_value'=>$this->input->post('diff_value'),
                'remark'=>$this->input->post('item_remark'),

                'pre_date'   =>$this->input->post('pre_date'),
                'pre_buyer_name'   =>$this->input->post('pre_buyer_name'),
                'pre_buyer_po_number' =>$this->input->post('pre_buyer_po_number'),
                'pre_currency' =>$this->input->post('pre_currency'),
                'pre_remark' =>$this->input->post('pre_remark'),
              );

              $cerdit_note_item_id = trim($this->input->post('cerdit_note_item_id'));
              if( $cerdit_note_item_id){
                  $cerditnoteitemid = $cerdit_note_item_id;
              }else{
                  $cerditnoteitemid = '';
              }

            //   print_r($cerditnoteitemid);
            //   exit;
              
                $saveCreditNoteitamdata = $this->admin_model->saveCreditNoteitamdata($cerditnoteitemid,$data);

                if($saveCreditNoteitamdata){

                    $saveCreditnoteitem_response['status'] = 'success';
                    $saveCreditnoteitem_response['error'] = array(
                        'part_number'=>strip_tags(form_error('part_number')),
                        'invoice_number'=>strip_tags(form_error('invoice_number')),
                        'invoice_date'=>strip_tags(form_error('invoice_date')),
                        'qty'=>strip_tags(form_error('qty')),
                        'rate'=>strip_tags(form_error('rate')),
                        'invoice_value'=>strip_tags(form_error('invoice_value')),
                        'recivable_amount'=>strip_tags(form_error('recivable_amount')),
                        'diff_value'=>strip_tags(form_error('diff_value')),
                        'item_remark'=>strip_tags(form_error('item_remark')));
                }
        }
          echo json_encode($saveCreditnoteitem_response);
    }


}


public function fetchcreditnoterecords(){

    $params = $_REQUEST;
    $totalRecords = $this->admin_model->fetchcreditnoterecordsCount($params); 
    $queryRecords = $this->admin_model->fetchcreditnoterecordstData($params); 

    $data = array();
    foreach ($queryRecords as $key => $value)
     {
            $i = 0;
            foreach($value as $v)
            {
                $data[$key][$i] = $v;
                $i++;
            }
     }
     
     $json_data = array(
            "draw"            => intval( $params['draw'] ),   
            "recordsTotal"    => intval( $totalRecords ),  
            "recordsFiltered" => intval($totalRecords),
            "data"            => $data   // total data array
            );
     echo json_encode($json_data);

}


public function deletecreditnote(){
    $post_submit = $this->input->post();
    if($post_submit){
        $result = $this->admin_model->deletecreditnote(trim($this->input->post('id')));
        if ($result) {
                    $process = 'Delete Rejection Form';
                    $processFunction = 'Admin/deleterejectionform';
                    $this->logrecord($process,$processFunction);
                echo(json_encode(array('status'=>'success')));
            }
        else { echo(json_encode(array('status'=>'failed'))); }
    }else{
        echo(json_encode(array('status'=>'failed'))); 
    }


}


public function deletecreditnoteitem(){

    $post_submit = $this->input->post();
    if($post_submit){
        $result = $this->admin_model->deletecreditnoteitem(trim($this->input->post('id')));
        if ($result) {
                    $process = 'Delete Credit Note Items';
                    $processFunction = 'Admin/deletecreditnoteitem';
                    $this->logrecord($process,$processFunction);
                echo(json_encode(array('status'=>'success')));
            }
        else { echo(json_encode(array('status'=>'failed'))); }
    }else{
        echo(json_encode(array('status'=>'failed'))); 
    }
}


public function editcreditnote($id){

    $process = 'Edit Credit Note';
    $processFunction = 'Admin/editcreditnote';
    $this->logrecord($process,$processFunction);
    $this->global['pageTitle'] = 'Edit Credit Note';
    $data['buyerList']= $this->admin_model->fetchAllbuyerList();
    $data['getcreditenotedetails']= $this->admin_model->getcreditenotedetailsforedit($id);
    $data['fetchALLpreCredititemList']= $this->admin_model->getcreditnoteitemdetails($id);
    $this->loadViews("masters/editcreditnote", $this->global, $data, NULL);

}


public function getbuyeritemonly(){

    $buyer_po_number=$this->input->post('buyer_po_number');

    $flag=$this->input->post('flag');

    if($buyer_po_number) {
        $getbuyeritemonly = $this->admin_model->getbuyeritemonly($buyer_po_number);
        if(count($getbuyeritemonly) >= 1) {
            $content = $content.'<option value="">Select Part Number</option>';
            foreach($getbuyeritemonly as $value) {
                $content = $content.'<option value="'.$value["item_id"].'">'.$value["part_number"].'</option>';
            }
            echo $content;
        } else {
            echo 'failure';
        }
    } else {
        echo 'failure';
    }

}


public function checkvendorpoandvendornumberinvendorpoconfirmation(){

    $post_submit = $this->input->post();
    if($post_submit){
         $result = $this->admin_model->checkvendorpoandvendornumberinvendorpoconfirmation($post_submit);
         if ($result) {
            $content = $result[0];
            echo json_encode($content);
         }else{
            echo 'failure';
         }
    }else{
        echo 'failure';
    }
}


public function checkvendorpoandvendornumberinsupplierpoconfirmation(){

    $post_submit = $this->input->post();
    if($post_submit){
         $result = $this->admin_model->checkvendorpoandvendornumberinsupplierpoconfirmation($post_submit);
         if ($result) {
            $content = $result[0];
            echo json_encode($content);
         }else{
            echo 'failure';
         }
    }else{
        echo 'failure';
    }
}


public function geteditcreditnoteitem(){
    $post_submit = $this->input->post();
    if($post_submit){
        $geteditcreditnoteitem = $this->admin_model->geteditcreditnoteitem(trim($this->input->post('id')));
        if($geteditcreditnoteitem){
            $content = $geteditcreditnoteitem[0];
            echo json_encode($content);
        }else{
            echo 'failure';
        }
    }

}


public function checkvendorpoandvendornumberinpoddetails(){

    $post_submit = $this->input->post();
    if($post_submit){
         $result = $this->admin_model->checkvendorpoandvendornumberinpoddetails($post_submit);
         if ($result) {
            $content = $result[0];
            echo json_encode($content);
         }else{
            echo 'failure';
         }
    }else{
        echo 'failure';
    }
}


public function checksupplierandvendornumberinpoddetails(){

    $post_submit = $this->input->post();
    if($post_submit){
         $result = $this->admin_model->checksupplierandvendornumberinpoddetails($post_submit);
         if ($result) {
            $content = $result[0];
            echo json_encode($content);
         }else{
            echo 'failure';
         }
    }else{
        echo 'failure';
    }

}


public function preexport(){

    $process = 'Pre Export';
    $processFunction = 'Admin/preexport';
    $this->logrecord($process,$processFunction);
    $this->global['pageTitle'] = 'Pre Export';
    //$data['vendorList']= $this->admin_model->fetchALLvendorList();
    $this->loadViews("masters/preexport", $this->global, $data, NULL);  

}


public function fetchpreexportdetails(){

    $params = $_REQUEST;
    $totalRecords = $this->admin_model->getpreexportcount($params); 
    $queryRecords = $this->admin_model->getpreexportdata($params); 

    $data = array();
    foreach ($queryRecords as $key => $value)
    {
        $i = 0;
        foreach($value as $v)
        {
            $data[$key][$i] = $v;
            $i++;
        }
    }
    $json_data = array(
        "draw"            => intval( $params['draw'] ),   
        "recordsTotal"    => intval( $totalRecords ),  
        "recordsFiltered" => intval($totalRecords),
        "data"            => $data   // total data array
        );
    echo json_encode($json_data);

}


public function addnewfreexport(){
    $post_submit = $this->input->post();
    if($post_submit){

        $savePreexport_response = array();
        $this->form_validation->set_rules('invoice_number','Invoice Number','trim|required');
        $this->form_validation->set_rules('date','Date','trim|required');
        $this->form_validation->set_rules('buyer_name','Buyer Name','trim|required');
        $this->form_validation->set_rules('buyer_po_number','Buyer PO Number','trim|required');
        $this->form_validation->set_rules('total_no_of_pallets','Total No Of Pallets','trim');
        $this->form_validation->set_rules('total_weight_of_pallets','Total weight Of Pallets','trim');
        $this->form_validation->set_rules('pallet_1','Pallet 1','trim');
        $this->form_validation->set_rules('pallet_2','Pallet 2','trim');
        $this->form_validation->set_rules('remark','Remark','trim');

        $this->form_validation->set_rules('preexport_invoice_number','Preexport Invoice Number','trim');
        $this->form_validation->set_rules('mode_of_shipment','Mode of Shipment','trim|required');


        if($this->form_validation->run() == FALSE)
        {
            $savePreexport_response['status'] = 'success';
            $savePreexport_response['error'] = array('invoice_number'=>strip_tags(form_error('invoice_number')),'date'=>strip_tags(form_error('date')),'buyer_name'=>strip_tags(form_error('buyer_name')),'buyer_po_number'=>strip_tags(form_error('buyer_po_number')),'total_no_of_pallets'=>strip_tags(form_error('total_no_of_pallets')),'total_weight_of_pallets'=>strip_tags(form_error('total_weight_of_pallets')),'pallet_1'=>strip_tags(form_error('pallet_1')),'pallet_2'=>strip_tags(form_error('pallet_2')),'remark'=>strip_tags(form_error('remark')),'preexport_invoice_number'=>strip_tags(form_error('preexport_invoice_number')),'mode_of_shipment'=>strip_tags(form_error('mode_of_shipment')));
    
        }else{

            $data = array(
                'pre_export_invoice_no' => trim($this->input->post('invoice_number')),
                'date' => trim($this->input->post('date')),
                'buyer_name' => trim($this->input->post('buyer_name')),
                'buyer_po' => trim($this->input->post('buyer_po_number')),
                'total_no_of_pallets' => trim($this->input->post('total_no_of_pallets')),
                'total_weight_of_pallets' => trim($this->input->post('total_weight_of_pallets')),
                'pallet_1' => trim($this->input->post('pallet_1')),
                'pallet_2' => trim($this->input->post('pallet_2')),
                'remark' => trim($this->input->post('remark')),
                'invoice_number' => trim($this->input->post('preexport_invoice_number')),
                'mode_of_shipment' => trim($this->input->post('mode_of_shipment')),
            );


            if(trim($this->input->post('preexport_id'))){
                $preexport_id = trim($this->input->post('preexport_id'));
            }else{
                $preexport_id = '';
            }    

            $savenepreexport= $this->admin_model->savenepreexport($preexport_id,$data);
            if($savenepreexport){
                $savePreexport_response['status'] = 'success';
                $savePreexport_response['error'] = array('invoice_number'=>strip_tags(form_error('invoice_number')),'date'=>strip_tags(form_error('date')),'buyer_name'=>strip_tags(form_error('buyer_name')),'buyer_po_number'=>strip_tags(form_error('buyer_po_number')),'total_no_of_pallets'=>strip_tags(form_error('total_no_of_pallets')),'total_weight_of_pallets'=>strip_tags(form_error('total_weight_of_pallets')),'pallet_1'=>strip_tags(form_error('pallet_1')),'pallet_2'=>strip_tags(form_error('pallet_2')),'remark'=>strip_tags(form_error('remark')),'preexport_invoice_number'=>strip_tags(form_error('preexport_invoice_number')),'mode_of_shipment'=>strip_tags(form_error('mode_of_shipment')));
            }
        }
        echo json_encode($savePreexport_response);
    }else{
        $process = 'Add New Export Export';
        $processFunction = 'Admin/addnewpreexport';
        $this->logrecord($process,$processFunction);
        $this->global['pageTitle'] = 'Add New Export Export';
        $data['getPreviousPreexport']= $this->admin_model->getPreviousPreexport()[0];
        $data['buyerList']= $this->admin_model->fetchAllbuyerList();
        $this->loadViews("masters/addnewpreexport", $this->global, $data, NULL); 
    }
}

public function deletepreexport(){

    $post_submit = $this->input->post();
    if($post_submit){
        $result = $this->admin_model->deletepreexport(trim($this->input->post('id')));
        if ($result) {
                    $process = 'Delete Export';
                    $processFunction = 'Admin/deletepreexport';
                    $this->logrecord($process,$processFunction);
                echo(json_encode(array('status'=>'success')));
            }
        else { echo(json_encode(array('status'=>'failed'))); }
    }else{
        echo(json_encode(array('status'=>'failed'))); 
    }

}

public function editpreexport($id){
    $process = 'Edit Pre Export';
    $processFunction = 'Admin/editpreexport';
    $this->logrecord($process,$processFunction);
    $this->global['pageTitle'] = 'Edit Pre Export';
    $data['getexportdetailsforedit']= $this->admin_model->getpreexportdetailsforedit($id);
    $data['buyerList']= $this->admin_model->fetchAllbuyerList();
    $this->loadViews("masters/editpreexport", $this->global, $data, NULL);
}

public function exportdetailsitemdetails($id){

    $process = 'Pre Export Item Details';
    $processFunction = 'Admin/exportdetailsitemdetails';
    $this->logrecord($process,$processFunction);
    $this->global['pageTitle'] = 'Pre Export Item Details';
    $data['getexportetails']= $this->admin_model->getbuyerpodetailsforexportdetails($id);
    $data['main_export_id']= $id;
    $this->loadViews("masters/exportdetailsitemdetails", $this->global, $data, NULL);

}

public function fetchpreexportitemdetails($id){

    $params = $_REQUEST;
    $totalRecords = $this->admin_model->getpreexportitemdetailscount($params,$id); 
    $queryRecords = $this->admin_model->getpreexportitemdetailsdata($params,$id); 

    $data = array();
    foreach ($queryRecords as $key => $value)
    {
        $i = 0;
        foreach($value as $v)
        {
            $data[$key][$i] = $v;
            $i++;
        }
    }
    $json_data = array(
        "draw"            => intval( $params['draw'] ),   
        "recordsTotal"    => intval( $totalRecords ),  
        "recordsFiltered" => intval($totalRecords),
        "data"            => $data   // total data array
        );
    echo json_encode($json_data);

}

public function addpreexportitemdetails($id){

    $post_submit = $this->input->post();
    if($post_submit){

        $saveExportitemdetails_response = array();
        $this->form_validation->set_rules('part_number','Part Number','trim|required');
        $this->form_validation->set_rules('part_description','Part Description','trim');
        $this->form_validation->set_rules('total_item_net_weight','Total Item Net Weight','trim');
        $this->form_validation->set_rules('remark','Remark','trim');
        $this->form_validation->set_rules('main_export_id','Main Export Id','trim');


        if($this->form_validation->run() == FALSE)
        {

            $saveExportitemdetails_response['status'] = 'failure';
            $saveExportitemdetails_response['error'] = array('part_number'=>strip_tags(form_error('part_number')),'part_description'=>strip_tags(form_error('part_description')),'total_item_net_weight'=>strip_tags(form_error('total_item_net_weight')),'remark'=>strip_tags(form_error('remark')),'main_export_id'=>strip_tags(form_error('main_export_id')));
        }else{

             $data = array(
                'pre_export_id'=>$this->input->post('main_export_id'),
                'part_number'=>$this->input->post('part_number'),
                'total_item_net_weight'=>$this->input->post('total_item_net_weight'),
                'remark'=>$this->input->post('remark'),
              );

              if(trim($this->input->post('preexportitemdetailsid'))){
                $preexportitemdetailsid =trim($this->input->post('preexportitemdetailsid'));
              }else{
                $preexportitemdetailsid ='';
              }

              $savePreexportitemdata = $this->admin_model->savePreexportitemdata($preexportitemdetailsid,$data);

              if($savePreexportitemdata){
                $saveExportitemdetails_response['status'] = 'success';                
                $saveExportitemdetails_response['error'] = array('part_number'=>strip_tags(form_error('part_number')),'part_description'=>strip_tags(form_error('part_description')),'total_item_net_weight'=>strip_tags(form_error('total_item_net_weight')),'remark'=>strip_tags(form_error('remark')),'main_export_id'=>strip_tags(form_error('main_export_id')));

              }else{

                $saveExportitemdetails_response['status'] = 'failure';
                $saveExportitemdetails_response['error'] = array('part_number'=>strip_tags(form_error('part_number')),'part_description'=>strip_tags(form_error('part_description')),'total_item_net_weight'=>strip_tags(form_error('total_item_net_weight')),'remark'=>strip_tags(form_error('remark')),'main_export_id'=>strip_tags(form_error('main_export_id')));

              }

        }
            echo json_encode($saveExportitemdetails_response);

    }else{

        $process = 'Add New Pre Export Item Details';
        $processFunction = 'Admin/addpreexportitemdetails';
        $this->logrecord($process,$processFunction);
        $this->global['pageTitle'] = 'Add New Pre Export Item Details';
        $data['getexportetails']= $this->admin_model->getbuyerpodetailsforexportdetails($id);
        $data['getbuyerpoitemdetails']= $this->admin_model->getbuyerpoitemdetails($data['getexportetails'][0]['buyer_po']);
        $data['main_export_id']= $id;
        $data['buyer_po_id']= $data['getexportetails'][0]['buyer_po'];
        $this->loadViews("masters/addpreexportitemdetails", $this->global, $data, NULL);
    }
}


public function get_preexport_item_details(){

    $post_submit = $this->input->post();
    if($post_submit){
        $getpreexportitemdetails = $this->admin_model->get_preexport_item_details(trim($this->input->post('part_number')),trim($this->input->post('main_export_id')),trim($this->input->post('buyer_po_id')));
        if($getpreexportitemdetails){
            $content = $getpreexportitemdetails[0];
            echo json_encode($content);
        }else{
            echo 'failure';
        }
    }

}


public function deletepreexportitemdetails(){

    $post_submit = $this->input->post();
    if($post_submit){
        $result = $this->admin_model->deletepreexportitemdetails(trim($this->input->post('id')));
        if ($result) {
                    $process = 'Delete Export Item Details';
                    $processFunction = 'Admin/deletepreexportitemdetails';
                    $this->logrecord($process,$processFunction);
                echo(json_encode(array('status'=>'success')));
            }
        else { echo(json_encode(array('status'=>'failed'))); }
    }else{
        echo(json_encode(array('status'=>'failed'))); 
    }

}


public function editaddpreexportitemdetails($id){

    $process = 'Edit Pre Export Item Details';
    $processFunction = 'Admin/editpreexport';
    $this->logrecord($process,$processFunction);
    $this->global['pageTitle'] = 'Edit Pre Export Item Details';
    $data['getexportetails']= $this->admin_model->getbuyerpodetailsforexportdetailsedititemdetails($id);
    $data['main_export_id']= $data['getexportetails'][0]['export_id'];
    $data['preexportitemdetailsid']= $id;
    $data['getbuyerpoitemdetails']= $this->admin_model->getbuyerpoitemdetails($data['getexportetails'][0]['buyer_po']);
    $this->loadViews("masters/editaddpreexportitemdetails", $this->global, $data, NULL);
}


public function addexportitemdetailswithattributes($id){
    $process = 'Pre Export Item Attributes';
    $processFunction = 'Admin/addexportitemdetailswithattributes';
    $this->logrecord($process,$processFunction);
    $this->global['pageTitle'] = 'Pre Export Item Attributes';
    $data['getexportetails']= $this->admin_model->getbuyerpodetailsforexportdetailsedititemdetails($id);
    $data['main_export_id']= $data['getexportetails'][0]['export_id'];
    $data['preexportitemdetailsid']= $id;
    $this->loadViews("masters/addexportitemdetailswithattributes", $this->global, $data, NULL);
}


public function fetchpreexportitemdetailsattribute($id){

    $params = $_REQUEST;
    $totalRecords = $this->admin_model->getpreexportitemdetailsattributecount($params,$id); 
    $queryRecords = $this->admin_model->getpreexportitemdetailsattributedata($params,$id); 

    $data = array();
    foreach ($queryRecords as $key => $value)
    {
        $i = 0;
        foreach($value as $v)
        {
            $data[$key][$i] = $v;
            $i++;
        }
    }
    $json_data = array(
        "draw"            => intval( $params['draw'] ),   
        "recordsTotal"    => intval( $totalRecords ),  
        "recordsFiltered" => intval($totalRecords),
        "data"            => $data   // total data array
        );
    echo json_encode($json_data);

}


public function addexportitemdetailswithattributesvalues($id){

    $post_submit = $this->input->post();
    if($post_submit){

        $saveexportdetailsattributes_response = array();
        $this->form_validation->set_rules('gross_per_box_weight','Gross Per Box Weight','trim|required');
        $this->form_validation->set_rules('no_of_cartoons','No Of Cartoons','trim|required');
        $this->form_validation->set_rules('total_qty','Total Qty','trim|required');
        $this->form_validation->set_rules('total_net_weight','Total Net Weight','trim');
        $this->form_validation->set_rules('total_gross_weight','Total Gross Weight','trim');
        $this->form_validation->set_rules('remark','Remark','trim');

        if($this->form_validation->run() == FALSE)
        {
            $saveexportdetailsattributes_response['status'] = 'failure';
            $saveexportdetailsattributes_response['error'] = array('gross_per_box_weight'=>strip_tags(form_error('gross_per_box_weight')),'no_of_cartoons'=>strip_tags(form_error('no_of_cartoons')),'total_qty'=>strip_tags(form_error('total_qty')),'total_net_weight'=>strip_tags(form_error('total_net_weight')),'total_gross_weight'=>strip_tags(form_error('total_gross_weight')),'remark'=>strip_tags(form_error('remark')));
        }else{


            $data = array(
                'pre_export_item_id'=>$this->input->post('preexportitemdetailsid'),
                'main_export_id'=>$this->input->post('main_export_id'),
                'gross_per_box_weight'=>$this->input->post('gross_per_box_weight'),
                'no_of_cartoons'=>$this->input->post('no_of_cartoons'),
                'per_box_PCS' => $this->input->post('per_boc_pcs'),
                'total_qty'=>$this->input->post('total_qty'),
                'total_net_weight'=>$this->input->post('total_net_weight'),
                'total_gross_weight'=>$this->input->post('total_gross_weight'),
                'remark'=>$this->input->post('remark'),
            );
           
            if(trim($this->input->post('pre_export_item_attribute_id'))){
                $pre_export_item_attribute_id=trim($this->input->post('pre_export_item_attribute_id'));
            }else{
                $pre_export_item_attribute_id='';
            }

            $savePreexportitemattributes = $this->admin_model->savePreexportitemattributes($pre_export_item_attribute_id,$data);

            if( $savePreexportitemattributes){

                $saveexportdetailsattributes_response['status'] = 'success';
                $saveexportdetailsattributes_response['error'] = array('gross_per_box_weight'=>strip_tags(form_error('gross_per_box_weight')),'no_of_cartoons'=>strip_tags(form_error('no_of_cartoons')),'total_qty'=>strip_tags(form_error('total_qty')),'total_net_weight'=>strip_tags(form_error('total_net_weight')),'total_gross_weight'=>strip_tags(form_error('total_gross_weight')),'remark'=>strip_tags(form_error('remark')));
         
            }else{
                $saveexportdetailsattributes_response['status'] = 'failure';
                $saveexportdetailsattributes_response['error'] = array('gross_per_box_weight'=>strip_tags(form_error('gross_per_box_weight')),'no_of_cartoons'=>strip_tags(form_error('no_of_cartoons')),'total_qty'=>strip_tags(form_error('total_qty')),'total_net_weight'=>strip_tags(form_error('total_net_weight')),'total_gross_weight'=>strip_tags(form_error('total_gross_weight')),'remark'=>strip_tags(form_error('remark')));
         

            }
        }

        echo json_encode($saveexportdetailsattributes_response);

    }else{

        $process = 'Pre Export Item Attributes add';
        $processFunction = 'Admin/addexportitemdetailswithattributesvalues';
        $this->logrecord($process,$processFunction);
        $this->global['pageTitle'] = 'Pre Export Item Attributes add';
        $data['getexportetails']= $this->admin_model->getbuyerpodetailsforexportdetailsedititemdetails($id);
        $data['main_export_id']= $data['getexportetails'][0]['export_id'];
        $data['preexportitemdetailsid']= $id;
        $this->loadViews("masters/addexportitemdetailswithattributesvalues", $this->global, $data, NULL);

    }

}


public function deletepreexportitemattributes(){

    $post_submit = $this->input->post();
    if($post_submit){
        $result = $this->admin_model->deletepreexportitemattributes(trim($this->input->post('id')));
        if ($result) {
                    $process = 'Delete Export Item Details';
                    $processFunction = 'Admin/deletepreexportitemattributes';
                    $this->logrecord($process,$processFunction);
                echo(json_encode(array('status'=>'success')));
            }
        else { echo(json_encode(array('status'=>'failed'))); }
    }else{
        echo(json_encode(array('status'=>'failed'))); 
    }

}


public function editexportitemdetailswithattributesvalues($id){

    $process = 'Pre Export Item Attributes Edit';
    $processFunction = 'Admin/editexportitemdetailswithattributesvalues';
    $this->logrecord($process,$processFunction);
    $this->global['pageTitle'] = 'Pre Export Item Attributes Edit';
    $data['getpreexportidbyattributesid'] = $this->admin_model->getpreexportidbyattributesid($id);

    $data['pre_export_item_id'] = $data['getpreexportidbyattributesid'][0]['pre_export_item_id'];

    $data['getexportetails']= $this->admin_model->getbuyerpodetailsforexportdetailsedititemdetails($data['getpreexportidbyattributesid'][0]['pre_export_item_id']);
    $data['main_export_id']= $data['getexportetails'][0]['export_id'];
    $data['pre_export_item_attribute_id']= $id;
    $this->loadViews("masters/editexportitemdetailswithattributesvalues", $this->global, $data, NULL);
}


public function chamaster(){
    $process = 'CHA Master';
    $processFunction = 'Admin/chamaster';
    $this->logrecord($process,$processFunction);
    $this->global['pageTitle'] = 'CHA Master';
    $this->loadViews("masters/chaMaster", $this->global, $data, NULL);
}


public function fetchCHA(){
    $params = $_REQUEST;
    $totalRecords = $this->admin_model->getCHACount($params); 
    $queryRecords = $this->admin_model->getCHAdata($params); 

    $data = array();
    foreach ($queryRecords as $key => $value)
    {
        $i = 0;
        foreach($value as $v)
        {
            $data[$key][$i] = $v;
            $i++;
        }
    }
    $json_data = array(
        "draw"            => intval( $params['draw'] ),   
        "recordsTotal"    => intval( $totalRecords ),  
        "recordsFiltered" => intval($totalRecords),
        "data"            => $data   // total data array
        );
    echo json_encode($json_data);
}


public function addnewCha(){
    $post_submit = $this->input->post();
    if($post_submit){
        $save_cha_response = array();

        $this->form_validation->set_rules('cha_name','CHA Name','trim|required|max_length[128]');
        $this->form_validation->set_rules('landline','Landline','trim|numeric|max_length[128]');
        $this->form_validation->set_rules('address','Address','trim|required');
        $this->form_validation->set_rules('phone_1','Phone 1','trim|numeric|max_length[50]');
        $this->form_validation->set_rules('contact_person','Contact Person','trim|max_length[50]');
        $this->form_validation->set_rules('mobile','Mobile','trim|required|numeric|max_length[50]');
        $this->form_validation->set_rules('email','Email','trim|required|valid_email|max_length[50]');
        $this->form_validation->set_rules('mobile_2','Mobile 2','trim|numeric|max_length[50]');
        $this->form_validation->set_rules('fax','Fax','trim|max_length[50]');
        $this->form_validation->set_rules('GSTIN','GSTIN','trim|max_length[50]');

        if($this->form_validation->run() == FALSE)
        {
            $save_cha_response['status'] = 'failure';
            $save_cha_response['error'] = array('cha_name'=>strip_tags(form_error('cha_name')), 'landline'=>strip_tags(form_error('landline')), 'address'=>strip_tags(form_error('address')), 'phone_1'=>strip_tags(form_error('phone_1')),'contact_person'=>strip_tags(form_error('contact_person')),'mobile'=>strip_tags(form_error('mobile')),'email'=>strip_tags(form_error('email')),'mobile_2'=>strip_tags(form_error('mobile_2')),'fax'=>strip_tags(form_error('fax')),'GSTIN'=>strip_tags(form_error('GSTIN')));
        }else{

            $data = array(
                'cha_name'   => trim($this->input->post('cha_name')),
                'landline'     => trim($this->input->post('landline')),
                'address'    => trim($this->input->post('address')),
                'phone1'  => trim($this->input->post('phone_1')),
                'contact_person' => trim($this->input->post('contact_person')),
                'mobile' =>   trim($this->input->post('mobile')),
                'email' =>    trim($this->input->post('email')),
                'mobile2' =>    trim($this->input->post('mobile_2')),
                'fax' =>    trim($this->input->post('fax')),
                'GSTIN' =>    trim($this->input->post('GSTIN'))
            );

            $checkifexitscha = $this->admin_model->checkifexitscha(trim($this->input->post('cha_name')));
            if($checkifexitscha > 0){
                $save_cha_response['status'] = 'failure';
                $save_cha_response['error'] = array('cha_name'=>'Vendor Alreday Exits');
            }else{
                $savechadata = $this->admin_model->saveChadata('',$data);
                if($savechadata){
                    $save_cha_response['status'] = 'success';
                    $save_cha_response['error'] = array('cha_name'=>'', 'landline'=>'', 'address'=>'', 'phone_1'=>'','contact_person'=>'','mobile'=>'','email'=>'','mobile_2'=>'','fax'=>'','GSTIN'=>'');
                }
            }
        }
        echo json_encode($save_cha_response);
    }else{
        $process = 'Add New CHA Master';
        $processFunction = 'Admin/addnewCha';
        $this->logrecord($process,$processFunction);
        $this->global['pageTitle'] = 'Add New CHA Master';
        $this->loadViews("masters/addnewCha", $this->global, NULL, NULL);
    }
}


public function deletecha(){
    $post_submit = $this->input->post();
    if($post_submit){
        $result = $this->admin_model->deletecha(trim($this->input->post('id')));
        if ($result) {
                    $process = 'CHA Delete';
                    $processFunction = 'Admin/deletecha';
                    $this->logrecord($process,$processFunction);
                echo(json_encode(array('status'=>'success')));
            }
        else { echo(json_encode(array('status'=>'failed'))); }
    }else{
        echo(json_encode(array('status'=>'failed'))); 
    }
}



public function updatecha($id){
    $post_submit = $this->input->post();
    if($post_submit){

        $update_cha_response = array();

        $this->form_validation->set_rules('cha_name','CHA Name','trim|required|max_length[128]');
        $this->form_validation->set_rules('landline','Landline','trim|numeric|max_length[128]');
        $this->form_validation->set_rules('address','Address','trim|required');
        $this->form_validation->set_rules('phone_1','Phone 1','trim|numeric|max_length[50]');
        $this->form_validation->set_rules('contact_person','Contact Person','trim|max_length[50]');
        $this->form_validation->set_rules('mobile','Mobile','trim|required|numeric|max_length[50]');
        $this->form_validation->set_rules('email','Email','trim|required|valid_email|max_length[50]');
        $this->form_validation->set_rules('mobile_2','Mobile 2','trim|numeric|max_length[50]');
        $this->form_validation->set_rules('fax','Fax','trim|max_length[50]');
        $this->form_validation->set_rules('GSTIN','GSTIN','trim|max_length[50]');

        if($this->form_validation->run() == FALSE)
        {
            $update_cha_response['status'] = 'failure';
            $update_cha_response['error'] = array('cha_name'=>strip_tags(form_error('cha_name')), 'landline'=>strip_tags(form_error('landline')), 'address'=>strip_tags(form_error('address')), 'phone_1'=>strip_tags(form_error('phone_1')),'contact_person'=>strip_tags(form_error('contact_person')),'mobile'=>strip_tags(form_error('mobile')),'email'=>strip_tags(form_error('email')),'mobile_2'=>strip_tags(form_error('mobile_2')),'fax'=>strip_tags(form_error('fax')),'GSTIN'=>strip_tags(form_error('GSTIN')));
        }else{

            $data = array(
                'cha_name'   => trim($this->input->post('cha_name')),
                'landline'     => trim($this->input->post('landline')),
                'address'    => trim($this->input->post('address')),
                'phone1'  => trim($this->input->post('phone_1')),
                'contact_person' => trim($this->input->post('contact_person')),
                'mobile' =>   trim($this->input->post('mobile')),
                'email' =>    trim($this->input->post('email')),
                'mobile2' =>    trim($this->input->post('mobile_2')),
                'fax' =>    trim($this->input->post('fax')),
                'GSTIN' =>    trim($this->input->post('GSTIN'))
            );

            $checkifexitchaupdate = $this->admin_model->checkifexitchaupdate(trim($this->input->post('cha_id')),trim($this->input->post('cha_name')));

            if($checkifexitchaupdate > 0){
                $updateCHAdata = $this->admin_model->saveChadata(trim($this->input->post('cha_id')),$data);
                if($updateCHAdata){
                    $update_cha_response['status'] = 'success';
                    $update_cha_response['error'] = array('cha_name'=>'', 'landline'=>'', 'address'=>'', 'phone_1'=>'','contact_person'=>'','mobile'=>'','email'=>'','mobile_2'=>'','fax'=>'','GSTIN'=>'');
                }

            }else{

                $checkifexitscha = $this->admin_model->checkifexitscha(trim($this->input->post('cha_name')));
                if($checkifexitscha > 0){
                    $update_cha_response['status'] = 'failure';
                    $update_cha_response['error'] = array('cha_name'=>'CHA Alreday Exits');
                }else{
                    $updateCHAdata = $this->admin_model->saveChadata(trim($this->input->post('cha_id')),$data);
                    if($updateCHAdata){
                       $update_cha_response['status'] = 'success';
                       $update_cha_response['error'] = array('cha_name'=>'', 'landline'=>'', 'address'=>'', 'phone_1'=>'','contact_person'=>'','mobile'=>'','email'=>'','mobile_2'=>'','fax'=>'','GSTIN'=>'');
                    }

                }
            }
       
        }
        echo json_encode($update_cha_response);
    }else{
        $process = 'Edit CHA Master';
        $processFunction = 'Admin/updateCha';
        $this->logrecord($process,$processFunction);
        $this->global['pageTitle'] = 'Edit CHA Master';
        $data['getChadata'] = $this->admin_model->getChadataforedit($id);
        $this->loadViews("masters/updateCha", $this->global, $data, NULL);

    }

}


public function salestrackingreport(){
    $process = 'Sales Tracking Report';
    $processFunction = 'Admin/salestrackingreport';
    $this->logrecord($process,$processFunction);
    $this->global['pageTitle'] = 'Sales Tracking Report';
    $this->loadViews("masters/salestrackingreport", $this->global, $data, NULL);
}


public function fetchsalestrackingReport(){
    $params = $_REQUEST;
    $totalRecords = $this->admin_model->getfetchsalestrackingReportcount($params); 
    $queryRecords = $this->admin_model->getfetchsalestrackingReportdata($params); 

    $data = array();
    foreach ($queryRecords as $key => $value)
    {
        $i = 0;
        foreach($value as $v)
        {
            $data[$key][$i] = $v;
            $i++;
        }
    }
    $json_data = array(
        "draw"            => intval( $params['draw'] ),   
        "recordsTotal"    => intval( $totalRecords ),  
        "recordsFiltered" => intval($totalRecords),
        "data"            => $data   // total data array
        );
    echo json_encode($json_data);
}

public function addsalestrackingreport(){

    $post_submit = $this->input->post();
    if($post_submit){
        $save_salestracking_response = array();

        $this->form_validation->set_rules('invoice_number','Invoice Number','trim|required');
        $this->form_validation->set_rules('cha_forworder','CHA Forworder','trim');
        $this->form_validation->set_rules('clearance_done_by','Clearance Done By','trim');
        $this->form_validation->set_rules('mode_of_Shipment','Mode of Shipment','trim');
        $this->form_validation->set_rules('payment_terms','Payment Terms','trim');
        $this->form_validation->set_rules('inv_amount','Inv Amount','trim');
        $this->form_validation->set_rules('igst_value','Igst Value','trim');
        $this->form_validation->set_rules('igst_rcved_amt','Igst Rcved Amt','trim');
        $this->form_validation->set_rules('igst_rcved_date','Igst Rcved Date','trim');
        $this->form_validation->set_rules('no_of_ctns','No of CTNS','trim');
        $this->form_validation->set_rules('port_code','Port Code','trim');
        $this->form_validation->set_rules('port_of_discharge','Port Of Discharge','trim');
        $this->form_validation->set_rules('sb_no','SB No','trim');
        $this->form_validation->set_rules('sb_date','SB Date','trim');
        $this->form_validation->set_rules('fob_amount_rs','FOB Amount RS','trim');
        $this->form_validation->set_rules('drawback','Drawback','trim');
        $this->form_validation->set_rules('bl_awb_no','BL AWB No','trim');
        $this->form_validation->set_rules('bl_awb_date','BL AWB Date','trim');
        $this->form_validation->set_rules('brc_number_and_dt','Brc Number And DT','trim');
        $this->form_validation->set_rules('transaction_id','Transaction id','trim');
        $this->form_validation->set_rules('brc_value','BRC Value','trim');
        $this->form_validation->set_rules('foreign_bank_charges','Foreign Bank Charges','trim');
        $this->form_validation->set_rules('foreign_bank_charges_in_inr','Foreign Bank Charges In INR','trim');
        $this->form_validation->set_rules('credit_note_number','Credit Note Number','trim');
        $this->form_validation->set_rules('credit_note_date','Credit Note Date','trim');
        $this->form_validation->set_rules('receivable_amt','Receivable Amt','trim');
        $this->form_validation->set_rules('difference','Difference','trim');
        $this->form_validation->set_rules('credit_note_reason','Credit Note Reason','trim');
        $this->form_validation->set_rules('debit_note_number','Debit Note Number','trim');
        $this->form_validation->set_rules('debit_note_date','Debit Note Date','trim');
        $this->form_validation->set_rules('difference_debit_note_amt','Difference Debit Note Amt','trim');
        $this->form_validation->set_rules('debit_amount_reason','Debit Amount Reason','trim');
        $this->form_validation->set_rules('exchange_rate_as_per_sb','Exchange Rate As Per SB','trim');
        $this->form_validation->set_rules('EGM_status','EGM status','trim');
        $this->form_validation->set_rules('payment_exchange_amt','payment_exchange_amt','trim');
        $this->form_validation->set_rules('payment_status','Payment Status','trim');

        $this->form_validation->set_rules('carrier_bill_number','carrier_bill_number','trim');
        $this->form_validation->set_rules('carrier_bill_date','carrier_bill_date','trim');
        $this->form_validation->set_rules('bill_amt','bill_amt','trim');
        $this->form_validation->set_rules('bill_paid_amount','bill_paid_amount','trim');
        $this->form_validation->set_rules('tds_amt','tds_amt','trim');
        $this->form_validation->set_rules('cheque_no','cheque_no','trim');
        $this->form_validation->set_rules('bill_paid_date','bill_paid_date','trim');
        $this->form_validation->set_rules('dbk_recd_amount','dbk_recd_amount','trim');
        $this->form_validation->set_rules('dbk_recd_date','dbk_recd_date','trim');
        $this->form_validation->set_rules('rodtep','rodtep','trim');
        $this->form_validation->set_rules('escript_number_license_no','escript_number_license_no','trim');
        $this->form_validation->set_rules('payment_recvd_date','payment_recvd_date','trim');
        $this->form_validation->set_rules('payment_rcivd_amt','payment_rcivd_amt','trim');
        $this->form_validation->set_rules('realised_amt_in_inr','realised_amt_in_inr','trim');
        $this->form_validation->set_rules('bank_charges_inr','bank_charges_inr','trim');
        $this->form_validation->set_rules('receivable_amt_debit','receivable_amt_debit','trim');
        

        if($this->form_validation->run() == FALSE)
        {
            $save_salestracking_response['status'] = 'failure';
            $save_salestracking_response['error'] = array(
                'invoice_number'=>strip_tags(form_error('invoice_number')),
                'cha_forworder'=>strip_tags(form_error('cha_forworder')),
                'clearance_done_by'=>strip_tags(form_error('clearance_done_by')),
                'mode_of_Shipment'=>strip_tags(form_error('mode_of_Shipment')),
                'payment_terms'=>strip_tags(form_error('payment_terms')),
                'inv_amount'=>strip_tags(form_error('inv_amount')),
                'igst_value'=>strip_tags(form_error('igst_value')),
                'igst_rcved_amt'=>strip_tags(form_error('igst_rcved_amt')),
                'igst_rcved_date'=>strip_tags(form_error('igst_rcved_date')),
                'no_of_ctns'=>strip_tags(form_error('no_of_ctns')),
                'port_code'=>strip_tags(form_error('port_code')),
                'port_of_discharge'=>strip_tags(form_error('port_of_discharge')),
                'sb_no'=>strip_tags(form_error('sb_no')),
                'sb_date'=>strip_tags(form_error('sb_date')),
                'fob_amount_rs'=>strip_tags(form_error('fob_amount_rs')),
                'drawback'=>strip_tags(form_error('drawback')),
                'bl_awb_no'=>strip_tags(form_error('bl_awb_no')),
                'bl_awb_date'=>strip_tags(form_error('bl_awb_date')),
                'brc_number_and_dt'=>strip_tags(form_error('brc_number_and_dt')),
                'transaction_id'=>strip_tags(form_error('transaction_id')),
                'brc_value'=>strip_tags(form_error('brc_value')),
                'foreign_bank_charges'=>strip_tags(form_error('foreign_bank_charges')),
                'foreign_bank_charges_in_inr'=>strip_tags(form_error('foreign_bank_charges_in_inr')),
                'credit_note_number'=>strip_tags(form_error('credit_note_number')),
                'credit_note_date'=>strip_tags(form_error('credit_note_date')),
                'receivable_amt'=>strip_tags(form_error('receivable_amt')),
                'difference'=>strip_tags(form_error('difference')),
                'credit_note_reason'=>strip_tags(form_error('credit_note_reason')),
                'debit_note_number'=>strip_tags(form_error('debit_note_number')),
                'debit_note_date'=>strip_tags(form_error('debit_note_date')),
                'difference_debit_note_amt'=>strip_tags(form_error('difference_debit_note_amt')),
                'debit_amount_reason'=>strip_tags(form_error('debit_amount_reason')),
                'payment_exchange_amt'=>strip_tags(form_error('payment_exchange_amt')),
                'EGM_status'=>strip_tags(form_error('EGM_status')),
                'payment_status'=>strip_tags(form_error('payment_status')),
                'receivable_amt_debit' =>strip_tags(form_error('receivable_amt_debit')),
                'exchange_rate_as_per_sb'=>strip_tags(form_error('exchange_rate_as_per_sb')));

        }else{

            $data = array(
                'invoice_number'=> trim($this->input->post('invoice_number')),
                'CHA_forwarder'=> trim($this->input->post('cha_forworder')),
                'clearance_done_by'=>trim($this->input->post('clearance_done_by')),
                'mode_of_Shipment'=>trim($this->input->post('mode_of_Shipment')),
                'payment_terms'=>trim($this->input->post('payment_terms')),
                'inv_amount'=>trim($this->input->post('inv_amount')),
                'igst_value'=>trim($this->input->post('igst_value')),
                'igst_rcved_amt'=>trim($this->input->post('igst_rcved_amt')),
                'igst_rcved_date'=>trim($this->input->post('igst_rcved_date')),
                'no_of_ctns'=>trim($this->input->post('no_of_ctns')),
                'port_code'=>trim($this->input->post('port_code')),
                'port_of_discharge'=>trim($this->input->post('port_of_discharge')),
                'sb_no'=>trim($this->input->post('sb_no')),
                'sb_date'=>trim($this->input->post('sb_date')),
                'fob_amount_rs'=>trim($this->input->post('fob_amount_rs')),
                'drawback'=>trim($this->input->post('drawback')),
                'bl_awb_no'=>trim($this->input->post('bl_awb_no')),
                'bl_awb_date'=>trim($this->input->post('bl_awb_date')),
                'brc_number_and_dt'=>trim($this->input->post('brc_number_and_dt')),
                'transaction_id'=>trim($this->input->post('transaction_id')),
                'brc_value'=>trim($this->input->post('brc_value')),
                'foreign_bank_charges'=>trim($this->input->post('foreign_bank_charges')),
                'foreign_bank_charges_in_inr'=>trim($this->input->post('foreign_bank_charges_in_inr')),
                'payment_exchange_amt'=>trim($this->input->post('payment_exchange_amt')),
                'EGM_status'=>trim($this->input->post('EGM_status')),
                'credit_note_number'=>trim($this->input->post('credit_note_number')),
                'credit_note_date'=>trim($this->input->post('credit_note_date')),
                'receivable_amt'=>trim($this->input->post('receivable_amt')),
                'difference'=>trim($this->input->post('difference')),
                'credit_note_reason'=>trim($this->input->post('credit_note_reason')),
                'debit_note_number'=>trim($this->input->post('debit_note_number')),
                'debit_note_date'=>trim($this->input->post('debit_note_date')),
                'difference_debit_note_amt'=>trim($this->input->post('difference_debit_note_amt')),
                'debit_amount_reason'=>trim($this->input->post('debit_amount_reason')),
                'payment_status'=>trim($this->input->post('payment_status')),
                'exchange_rate_as_per_sb'=>trim($this->input->post('exchange_rate_as_per_sb')),
                'carrier_bill_number'=>trim($this->input->post('carrier_bill_number')),
                'carrier_bill_date'=>trim($this->input->post('carrier_bill_date')),
                'bill_amt'=>trim($this->input->post('bill_amt')),
                'bill_paid_amount'=>trim($this->input->post('bill_paid_amount')),
                'tds_amt'=>trim($this->input->post('tds_amt')),
                'cheque_no'=>trim($this->input->post('cheque_no')),
                'bill_paid_date'=>trim($this->input->post('bill_paid_date')),
                'dbk_recd_amount'=>trim($this->input->post('dbk_recd_amount')),
                'dbk_recd_date'=>trim($this->input->post('dbk_recd_date')),
                'rodtep'=>trim($this->input->post('rodtep')),
                'escript_number_license_no'=>trim($this->input->post('escript_number_license_no')),
                'payment_recvd_date'=>trim($this->input->post('payment_recvd_date')),
                'payment_rcivd_amt'=>trim($this->input->post('payment_rcivd_amt')),
                'realised_amt_in_inr'=>trim($this->input->post('realised_amt_in_inr')),
                'bank_charges_inr'=>trim($this->input->post('bank_charges_inr')),
                'receivable_amt_debit'=>trim($this->input->post('receivable_amt_debit'))
            );

        
                if(trim($this->input->post('salestracking_id'))){
                    $salestracking_id =  trim($this->input->post('salestracking_id'));
                }else{
                    $salestracking_id='';
                }

                $savesalestrackingdata = $this->admin_model->savesalestrackingreportdata($salestracking_id,$data);
                
                if($savesalestrackingdata){
                    $save_salestracking_response['status'] = 'success';
                    $save_salestracking_response['error'] = array(
                        'invoice_number'=>strip_tags(form_error('invoice_number')),
                        'cha_forworder'=>strip_tags(form_error('cha_forworder')),
                        'clearance_done_by'=>strip_tags(form_error('clearance_done_by')),
                        'mode_of_Shipment'=>strip_tags(form_error('mode_of_Shipment')),
                        'payment_terms'=>strip_tags(form_error('payment_terms')),
                        'inv_amount'=>strip_tags(form_error('inv_amount')),
                        'igst_value'=>strip_tags(form_error('igst_value')),
                        'igst_rcved_amt'=>strip_tags(form_error('igst_rcved_amt')),
                        'igst_rcved_date'=>strip_tags(form_error('igst_rcved_date')),
                        'no_of_ctns'=>strip_tags(form_error('no_of_ctns')),
                        'port_code'=>strip_tags(form_error('port_code')),
                        'port_of_discharge'=>strip_tags(form_error('port_of_discharge')),
                        'sb_no'=>strip_tags(form_error('sb_no')),
                        'sb_date'=>strip_tags(form_error('sb_date')),
                        'fob_amount_rs'=>strip_tags(form_error('fob_amount_rs')),
                        'drawback'=>strip_tags(form_error('drawback')),
                        'bl_awb_no'=>strip_tags(form_error('bl_awb_no')),
                        'bl_awb_date'=>strip_tags(form_error('bl_awb_date')),
                        'brc_number_and_dt'=>strip_tags(form_error('brc_number_and_dt')),
                        'transaction_id'=>strip_tags(form_error('transaction_id')),
                        'brc_value'=>strip_tags(form_error('brc_value')),
                        'foreign_bank_charges'=>strip_tags(form_error('foreign_bank_charges')),
                        'foreign_bank_charges_in_inr'=>strip_tags(form_error('foreign_bank_charges_in_inr')),
                        'credit_note_number'=>strip_tags(form_error('credit_note_number')),
                        'credit_note_date'=>strip_tags(form_error('credit_note_date')),
                        'receivable_amt'=>strip_tags(form_error('receivable_amt')),
                        'difference'=>strip_tags(form_error('difference')),
                        'credit_note_reason'=>strip_tags(form_error('credit_note_reason')),
                        'debit_note_number'=>strip_tags(form_error('debit_note_number')),
                        'debit_note_date'=>strip_tags(form_error('debit_note_date')),
                        'difference_debit_note_amt'=>strip_tags(form_error('difference_debit_note_amt')),
                        'debit_amount_reason'=>strip_tags(form_error('debit_amount_reason')),
                        'payment_exchange_amt'=>strip_tags(form_error('payment_exchange_amt')),
                        'EGM_status'=>strip_tags(form_error('EGM_status')),
                        'payment_status'=>strip_tags(form_error('payment_status')),
                        'receivable_amt_debit' =>strip_tags(form_error('receivable_amt_debit')),
                        'exchange_rate_as_per_sb'=>strip_tags(form_error('exchange_rate_as_per_sb')));
             
            }
        }
        echo json_encode($save_salestracking_response);
    }else{
        $process = 'Add Sales Tracking Report';
        $processFunction = 'Admin/addsalestrackingreport';
        $this->logrecord($process,$processFunction);
        $this->global['pageTitle'] = 'Add Sales Tracking Report';
        $data['invoicenumberfromPackaging']= $this->admin_model->invoicenumberfromPackaging();
        $data['getchamaster']= $this->admin_model->getchamaster();
        $data['getcreditnotenumber']= $this->admin_model->getcreditnotenumber();
        $data['getdebitenotenumber']= $this->admin_model->getdebitenotenumber();
        $this->loadViews("masters/addsalestrackingreport", $this->global, $data, NULL);
    }

}



// public function downloadvendorpo($id){

//     $getvendordeatilsForInvoice = $this->admin_model->getvendordeatilsForInvoice($id);
//     $getvendorItemdeatilsForInvoice = $this->admin_model->getvendorItemdeatilsForInvoice($id);

//     $CartItem = "";
//     $i =1;
//     $subtotal = 0;
//     foreach ($getvendorItemdeatilsForInvoice as $key => $value) {
//         $CartItem .= '
//                 <tr style="border-left: 1px solid black;border-right: 1px solid black;">
//                     <td style="border: 1px solid black;text-align:left;padding: 10px;" valign="top">'.$i.'</td>
//                     <td style="border: 1px solid black;text-align:left;padding: 10px;" valign="top">'.$value['type_of_raw_material'].' <br>Vendor Qty-'.$value['vendor_qty'].' pcs </br> <br>Gross Weight-'.$value['rmgrossweight'].' kgs </br><br>'.$value['description_1'].'</br><br>'.$value['description_2'].'</br></td>   
//                     <td style="border: 1px solid black;text-align:left;padding: 10px;" valign="top">'.$value['part_number'].'</td>
//                     <td style="border: 1px solid black;text-align:left;padding: 10px;" valign="top">'.$value['order_oty'].'</td>
//                     <td style="border: 1px solid black;text-align:left;padding: 10px;" valign="top">'.$value['unit'].'</td> 
//                     <td style="border: 1px solid black;text-align:left;padding: 10px;" valign="top">'.$value['rate'].'/-'.'</td>    
//                     <td style="border: 1px solid black;text-align:left;padding: 10px;" valign="top">'.$value['value'].'/-'.'</td>
//                 </tr>';
//                 $subtotal+=$value['value'];
//             $i++;       
//     }



//     $mpdf = new \Mpdf\Mpdf();
//     // $html = $this->load->view('html_to_pdf',[],true);
//     $html = '<table style=" width: 100%;text-align: center;border-collapse: collapse;border: #cccccc 0px solid;font-family:cambria;">
//                 <tr>
//                   <td rowspan="2"><img src="'.base_url().'assets/images/supra_logo_1.jpg" width="80" height="80"></td>
//                   <td style="color:#000080"><h2>SUPRA QUALITY EXPORTS (I) PVT. LTD</h2></td>
//                   <td rowspan="2"><img src="'.base_url().'assets/images/logo_2.png"width="80" height="80"></td>
//                 </tr>
//                 <tr>
//                   <td style="font-weight: bold;">
//                     <p>MANUFACTURER & EXPORTERS OF:</p>
//                     <p>PRECISION TURNED COMPONENTS, STAMPED /PRESSED PARTS IN FERROUS & NON-FERROUS METAL</p>
//                     <p>MOULDED & EXTRUDED PLASTIC AND RUBBER COMPONENTS</p> 
//                   </td>
//                 </tr>
//             </table>
//             <hr>
//             <table style="width: 100%;text-align: left;border-collapse: collapse;border: #ccc 0px solid;font-family:cambria;">
//                     <tr>
//                         <td width="60%">
//                           <p><b>Office:</b> 229 to 232, Bharat Industrial Estate,
//                           <p> L.B.S. Marg, Bhandup West, Mumbai – 400078. INDIA.</b>
//                           <p>Tel: +91 22 66959505 / +91 22 66600196 </p>
//                           <p>+91 22 62390222 / +91 22 46061497 / +91 22 35115396 </p>
//                           <p style="color:#206a9b"><b>GSTIN : 27AAJCS7869M1ZB </b></p>
//                         </td>
//                         <td width="40%">
//                             <p><b>Email:</b></p> 
//                             <p style="color:#206a9b">purchase@supraexports.in</p>
//                             <p style="color:#206a9b">purchase1@supraexports.in</p>
//                             <p style="color:#206a9b">purchase2@supraexports.in</p>
//                         </td>  
//                     </tr>
//             </table>

//             <table style=" width: 100%;text-align: center;border-collapse: collapse;border: #ccc 0px solid;margin-top:10px;margin-bottom:10px;font-family:cambria;">
//                     <tr>
//                         <td style="color:red;font-size:15px">
//                           <u><p><h3>PURCHASE ORDER</h3></p>
//                         </td>
//                     </tr>
//             </table>

//             <table style=" width: 100%;text-align: left;border-collapse: collapse;font-family:cambria;font-size:13px;border: #ccc 1px solid">
//                 <tr style="border: 1px solid black;">
//                     <td width="50%" style="padding-left: 15px;">
//                         <div>
//                             <p>To,</p>
//                             <p><b>'.$getvendordeatilsForInvoice['vendor_name'].'</b></p>
//                             <p>'.$getvendordeatilsForInvoice['ven_address'].'</p>
//                             <p><b>Contact No:</b> '.$getvendordeatilsForInvoice['mobile'].' / '.$getvendordeatilsForInvoice['ven_landline'].'</p>
//                             <p><b>Contact Person:</b> '.$getvendordeatilsForInvoice['ven_contact_person'].'</p>
//                             <p><b>Email:</b> '.$getvendordeatilsForInvoice['ven_email'].'</p>
//                             <p style="color:red">GSTIN:'.$getvendordeatilsForInvoice['ven_GSTIN'].'</p>
//                         <div>    
//                     </td> 
//                     <td style="border-left: 1px solid black;padding-left: 15px;font-size:13px" width="50%" >
//                         <div>
//                             <p><b>P.O.NO :</b> '.'<span style="color:red">'.$getvendordeatilsForInvoice['ven_po_number'].'</span></p>
//                             <p>&nbsp;</p>
//                             <p><b>P.O.DATE :</b> '.date('d-m-Y',strtotime($getvendordeatilsForInvoice['ven_date'])).'</p>
//                             <p>&nbsp;</p>
//                             <p><b>QUOTATION REFERENCE :</b> '.$getvendordeatilsForInvoice['ven_quatation_ref_no'].'</p>
//                             <p>&nbsp;</p>
//                             <p><b>QUOTATION DATE :</b> '.date('d-m-Y',strtotime($getvendordeatilsForInvoice['ven_quatation_date'])).'</p>
//                         </div>
//                     </td>
//                 </tr>
//             </table>

//             <table style=" width: 100%;text-align: left;border-collapse: collapse;border: #ccc 1px solid;margin-top:10px;margin-bottom:10px;font-family:cambria;font-size:12px">
//                 <tr style="border: 1px solid black;">
//                     <th align="left" style="border: 1px solid black;" margin-bottom: 10%;>NEED TEST CERTIFICATE</th>
//                     <th align="left" style="border: 1px solid black;" margin-bottom: 10%;>DELIVERY DATE</th>
//                     <th align="left" style="border: 1px solid black;" margin-bottom: 10%;>PAYMENT TERMS</th>    
//                 </tr>
//                 <tr style="border: 1px solid black;">
//                     <td style="border: 1px solid black;text-align:center"><b>YES<b></td>
//                     <td style="border: 1px solid black;padding-left: 15px;">'.date('d-m-Y',strtotime($getvendordeatilsForInvoice['ven_delivery_date'])).'</td>    
//                     <td style="border: 1px solid black;padding-left: 15px;">'.$getvendordeatilsForInvoice['ven_work_order'].'</td>
//                 </tr>
//             </table>


//             <table style=" width: 100%;text-align: left;border-collapse: collapse;border: #ccc 1px solid;margin-top:10px;margin-bottom:10px;font-family:cambria;font-size:12px">
//                 <tr style="border: 1px solid black;">
//                     <th align="left" style="border: 1px solid black;text-align:center;" margin-bottom: 10%;>SR.NO.</th>
//                     <th align="left" style="border: 1px solid black;text-align:center;" margin-bottom: 10%;>PART DESCRIPTION</th>
//                     <th align="left" style="border: 1px solid black;text-align:center;" margin-bottom: 10%;>PART NO.</th>  
//                     <th align="left" style="border: 1px solid black;text-align:center;" margin-bottom: 10%;>QTY</th> 
//                     <th align="left" style="border: 1px solid black;text-align:center;" margin-bottom: 10%;>UNITS</th>  
//                     <th align="left" style="border: 1px solid black;text-align:center;" margin-bottom: 10%;>RATE</th>  
//                     <th align="left"  style="border: 1px solid black;text-align:center;" margin-bottom: 10%;>AMOUNT</th>
//                 </tr>
//                 '.$CartItem.'

//                 <tr style="border-left: 1px solid black;border-right: 1px solid black;">
//                     <td style="border-left: 1px solid black;border-right: 1px solid black;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </td>
//                     <td style="border-left: 1px solid black;border-right: 1px solid black;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </td>
//                     <td style="border-left: 1px solid black;border-right: 1px solid black;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </td>
//                     <td style="border-left: 1px solid black;border-right: 1px solid black;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </td>
//                     <td style="border-left: 1px solid black;border-right: 1px solid black;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </td>
//                     <td style="border-left: 1px solid black;border-right: 1px solid black;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </td>
//                     <td style="border-left: 1px solid black;border-right: 1px solid black;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </td>
//                 </tr>

        

//                 <tr style="border-left: 1px solid black;border-right: 1px solid black;">
//                     <td style="border-left: 1px solid black;border-right: 1px solid black;"></td>
//                     <td style="border-left: 1px solid black;border-right: 1px solid black;padding-left: 15px;"><p><b> Material From</b></p>
//                         <p>'.$getvendordeatilsForInvoice['supplier_name'].'</p>
//                         <p>'.$getvendordeatilsForInvoice['supplier_addess'].'</p>
//                         <p> <b>Kind Attn:</b> '.$getvendordeatilsForInvoice['ven_contact_person'].'</p>
//                         <p> <b>Tel No:</b> '.$getvendordeatilsForInvoice['sup_mobile'].' / '.$getvendordeatilsForInvoice['suplier_landline'].'</p>
//                         <p> <b>GSTIN:</b> '.$getvendordeatilsForInvoice['sup_GSTIN'].'</p> 
//                     </td>
//                     <td style="border-left: 1px solid black;border-right: 1px solid black;"></td>
//                     <td style="border-left: 1px solid black;border-right: 1px solid black;"></td>
//                     <td style="border-left: 1px solid black;border-right: 1px solid black;"></td>
//                     <td style="border-left: 1px solid black;border-right: 1px solid black;"></td>
//                     <td style="border-left: 1px solid black;border-right: 1px solid black;"></td>
//                 </tr>


//                 <tr style="border: 1px solid black;">
//                     <td colspan="5" style="padding-left: 10px;">'.$this->amount_in_word($subtotal).'</td>
                
//                     <td style="border: 1px solid black;padding-left: 10px;font-family:cambria;font-size:14px;">SUB TOTAL (+) GST </td>    
//                     <td style="border: 1px solid black;padding-left: 10px;">'.$subtotal.'/-'.'</td>
//                 </tr>
//             </table>

//             <table style=" width: 100%;border-collapse: collapse;border: #ccc 1px solid;font-family:cambria;font-size:12px">
//                 <tr style="border: 1px solid black;">
//                         <td style="border: 1px solid black;padding-left: 10px;">
//                             <p><b>Remark :</b>'.$getvendordeatilsForInvoice['remark'].'</p>    
//                     </td>   
//                 </tr>
//             </table>

//             <table style=" width: 100%;text-align: left;border-collapse: collapse;border: #ccc 1px solid;margin-top:10px;margin-bottom:10px;font-family:cambria;font-size:12px">
                  
//                    <tr style="border: 1px solid black;">
//                         <td style="border: 1px solid black;padding-left: 10px;" width="75%;">
//                             <p><b>NOTE :</b></p>
//                             <p><b>1. Confirmation of PO is Mandatory</b></p>
//                             <p><b>2. Mentioning P.O.No. on Invoice is Mandatory</b></p>
//                             <p><b>3. Once order issued & accepted, cannot be cancelled</b></p>
//                             <p><b>4. Essence of this order is delivering the specified quality product on time.</b></p>
//                             <p><b>5. If any Prices issue, should inform in 24hrs after receipt of P.O.</b></p>
//                         </td>
//                         <td style="border: 1px solid black;text-align: center;" width="25%" valign="top">
//                             <p style="vertical-align: text-top;font-size:12px;color:#206a9b"><b>FOR SUPRA QUALITY EXPORTS (I) PVT. LTD.</b></p>
//                             <br/><img src="'.base_url().'assets/images/stmps/supplierpostampsignature.png" width="150" height="100">
//                             <p style="vertical-align: text-top;font-size:10px;color:#206a9b"><b>AUTHORIZED SIGNATORY</b></p>
//                         </td> 
//                 </tr>
//             </table>';

//             // <p>FOR SUPRA QUALITY EXPORTS (I) PVT. LTD.</p>
    
//     $mpdf->WriteHTML($html);
//     $mpdf->Output('purshase_order.pdf','I'); // opens in browser



// }

public function downloadvendorpo($id){
    // $getsupplierdeatilsForInvoice = $this->admin_model->getsupplierdeatilsForInvoice($id);
    // $getsupplierItemdeatilsForInvoice = $this->admin_model->getsupplierItemdeatilsForInvoice($id);

    $getvendordeatilsForInvoice = $this->admin_model->getvendordeatilsForInvoice($id);
    $getvendorItemdeatilsForInvoice = $this->admin_model->getvendorItemdeatilsForInvoice($id);
    $getsuppliertemdeatilsForInvoiceonvendorpo = $this->admin_model->getsuppliertemdeatilsForInvoiceonvendorpo(trim($getvendordeatilsForInvoice['supplier_po_id']));

    if($getvendordeatilsForInvoice['ven_quatation_date']!='0000-00-00'){
        $quatation_date =  date('d-m-Y',strtotime($getvendordeatilsForInvoice['ven_quatation_date']));
    }else{
        $quatation_date = '';
    }

    $CartItem = "";
    $supplierItem = "";
    $i =1;
    $ii =1;
    $subtotal = 0;

    $item_count =count($getvendorItemdeatilsForInvoice);

    if($item_count==1){
        $padding_bottom = '95px';
    }else if($item_count==2){
        $padding_bottom = '28px';
    }else if($item_count==3){
        $padding_bottom = '10px';
    }else{
        $padding_bottom = '10px';
    }

    foreach ($getsuppliertemdeatilsForInvoiceonvendorpo as $key => $value) {
        $supplierItem .= '
            <tr style="border-left: 1px solid black;border-right: 1px solid black;">
                <td style="border-left: 1px solid black;border-right: 1px solid black;text-align:left;padding-left: 15px;" valign="top"></td>
                <td style="border-left: 1px solid black;border-right: 1px solid black;text-align:left;padding-left: 15px;" valign="top">'.$i.') '.$value['type_of_raw_material'].' - '.$value['order_oty'].' '.$value['unit'].' * '.$value['rate'].' = '.$value['value'].'</td> 
                <td style="border-left: 1px solid black;border-right: 1px solid black;text-align:left;padding-left: 10px;" valign="top"></td>
                <td style="border-left: 1px solid black;border-right: 1px solid black;text-align:left;padding-left: 10px;" valign="top"></td>
                <td style="border-left: 1px solid black;border-right: 1px solid black;text-align:left;padding-left: 10px;" valign="top"></td> 
                <td style="border-left: 1px solid black;border-right: 1px solid black;text-align:left;padding-left: 10px;" valign="top"></td>    
                <td style="border-left: 1px solid black;border-right: 1px solid black;text-align:left;padding-left: 10px;" valign="top"></td>
            </tr>';
            $i++;       
    }



    foreach ($getvendorItemdeatilsForInvoice as $key => $value) {
        $CartItem .= '
                <tr style="border-left: 1px solid black;border-right: 1px solid black;">
                    <td style="border-left: 1px solid black;border-right: 1px solid black;text-align:left;padding: 10px;" valign="top">'.$ii.'</td>
                    <td style="border-left: 1px solid black;border-right: 1px solid black;text-align:left;padding: 10px;" valign="top">'.$value['name'].'<br>Gross Weight-'.$value['rmgrossweight'].' kgs </br><br>HSN Code -'.$value['hsn_code'].'</br><br>'.$value['desc1'].'</br><br>'.$value['desc2'].'</br></td> 
                    <td style="border-left: 1px solid black;border-right: 1px solid black;text-align:left;padding: 10px;" valign="top">'.$value['part_number'].'</td>
                    <td style="border-left: 1px solid black;border-right: 1px solid black;text-align:left;padding: 10px;" valign="top">'.$value['order_oty'].'</td>
                    <td style="border-left: 1px solid black;border-right: 1px solid black;text-align:left;padding: 10px;" valign="top">'.$value['unit'].'</td> 
                    <td style="border-left: 1px solid black;border-right: 1px solid black;text-align:left;padding: 10px;" valign="top">'.$value['rate'].'/-'.'</td>    
                    <td style="border-left: 1px solid black;border-right: 1px solid black;text-align:left;padding: 10px;" valign="top">'.$value['value'].'/-'.'</td>
                </tr>';
                $subtotal+=$value['value'];
            $ii++;       
    }

    $space = '<tr>
        <td style="padding-bottom: '.$padding_bottom.';border-left: 1px solid black;border-right: 1px solid black;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </td>
        <td style="padding-bottom: '.$padding_bottom.';border-left: 1px solid black;border-right: 1px solid black;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </td>
        <td style="padding-bottom: '.$padding_bottom.';border-left: 1px solid black;border-right: 1px solid black;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </td>
        <td style="padding-bottom: '.$padding_bottom.';border-left: 1px solid black;border-right: 1px solid black;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </td>
        <td style="padding-bottom: '.$padding_bottom.';border-left: 1px solid black;border-right: 1px solid black;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </td>
        <td style="padding-bottom: '.$padding_bottom.';border-left: 1px solid black;border-right: 1px solid black;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </td>
        <td style="padding-bottom: '.$padding_bottom.';border-left: 1px solid black;border-right: 1px solid black;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </td>
    </tr>';

    $mpdf = new \Mpdf\Mpdf();
    // $html = $this->load->view('html_to_pdf',[],true);
    $html = '<table style=" width: 100%;text-align: center;border-collapse: collapse;border: #cccccc 0px solid;font-family:cambria;">
                <tr>
                  <td rowspan="2"><img src="'.base_url().'assets/images/supra_logo_1.jpg" width="80" height="80"></td>
                  <td style="color:#000080"><h2>SUPRA QUALITY EXPORTS (I) PVT. LTD</h2></td>
                  <td rowspan="2"><img src="'.base_url().'assets/images/logo_2.png"width="80" height="80"></td>
                </tr>
                <tr>
                  <td style="font-weight: bold;">
                    <p>MANUFACTURER & EXPORTERS OF:</p>
                    <p>PRECISION TURNED COMPONENTS, STAMPED /PRESSED PARTS IN FERROUS & NON-FERROUS METAL</p>
                    <p>MOULDED & EXTRUDED PLASTIC AND RUBBER COMPONENTS</p> 
                  </td>
                </tr>
            </table>
            <hr>
            <table style="width: 100%;text-align: left;border-collapse: collapse;border: #ccc 0px solid;font-family:cambria;">
                    <tr>
                        <td width="60%">
                          <p><b>Office:</b> 229 to 232, Bharat Industrial Estate,
                          <p> L.B.S. Marg, Bhandup West, Mumbai – 400078. INDIA.</b>
                          <p>Tel: +91 22 66959505 / +91 22 66600196 </p>
                          <p>+91 22 62390222 / +91 22 46061497 / +91 22 35115396 </p>
                          <p style="color:#206a9b"><b>GSTIN : 27AAJCS7869M1ZB </b></p>
                        </td>
                        <td width="40%">
                            <p><b>Email:</b></p> 
                            <p style="color:#206a9b">purchase@supraexports.in</p>
                            <p style="color:#206a9b">purchase1@supraexports.in</p>
                            <p style="color:#206a9b">purchase2@supraexports.in</p>
                        </td>  
                    </tr>
            </table>

            <table style=" width: 100%;text-align: center;border-collapse: collapse;border: #ccc 0px solid;margin-top:10px;margin-bottom:10px;font-family:cambria;">
                    <tr>
                        <td style="color:red;font-size:15px">
                          <u><p><h3>PURCHASE ORDER</h3></p>
                        </td>
                    </tr>
            </table>

            <table style=" width: 100%;text-align: left;border-collapse: collapse;font-family:cambria;font-size:13px;border: #ccc 1px solid">
                <tr style="border: 1px solid black;">
                    <td width="50%" style="padding-left: 15px;">
                        <div>
                            <p>To,</p>
                            <p><b>'.$getvendordeatilsForInvoice['vendor_name'].'</b></p>
                            <p>'.$getvendordeatilsForInvoice['ven_address'].'</p>
                            <p><b>Contact No:</b> '.$getvendordeatilsForInvoice['ven_mobile'].' / '.$getvendordeatilsForInvoice['ven_landline'].'</p>
                            <p><b>Contact Person:</b> '.$getvendordeatilsForInvoice['ven_contact_person'].'</p>
                            <p><b>Email:</b> '.$getvendordeatilsForInvoice['ven_email'].'</p>
                            <p style="color:red">GSTIN:'.$getvendordeatilsForInvoice['ven_GSTIN'].'</p>
                        <div>    
                    </td> 
                    <td style="border-left: 1px solid black;padding-left: 15px;font-size:13px" width="50%" >
                        <div>
                            <p><b>P.O.NO :</b> '.'<span style="color:red">'.$getvendordeatilsForInvoice['ven_po_number'].'</span></p>
                            <p>&nbsp;</p>
                            <p><b>P.O.DATE :</b> '.date('d-m-Y',strtotime($getvendordeatilsForInvoice['ven_date'])).'</p>
                            <p>&nbsp;</p>
                            <p><b>QUOTATION REFERENCE :</b> '.$getvendordeatilsForInvoice['ven_quatation_ref_no'].'</p>
                            <p>&nbsp;</p>
                            <p><b>QUOTATION DATE :</b> '.$quatation_date.'</p>
                        </div>
                    </td>
                </tr>
            </table>

            <table style=" width: 100%;text-align: left;border-collapse: collapse;border: #ccc 1px solid;margin-top:10px;margin-bottom:10px;font-family:cambria;font-size:12px">
                <tr style="border: 1px solid black;">
                    <th align="left" style="border: 1px solid black;padding-left: 10px;" margin-bottom: 10%;>DELIVERY DATE</th>
                    <th align="left" style="border: 1px solid black;padding-left: 10px;" margin-bottom: 10%;>PAYMENT TERMS</th>    
                </tr>
                <tr style="border: 1px solid black;">
                    <td style="border: 1px solid black;padding-left: 10px;">'.date('d-m-Y',strtotime($getvendordeatilsForInvoice['ven_delivery_date'])).'</td>    
                    <td style="border: 1px solid black;padding-left: 10px;">'.$getvendordeatilsForInvoice['ven_work_order'].'</td>
                </tr>
            </table>


            <table style=" width: 100%;text-align: left;border-collapse: collapse;border: #ccc 1px solid;margin-top:10px;margin-bottom:10px;font-family:cambria;font-size:12px">
                <tr style="border: 1px solid black;">
                    <th align="left" style="border: 1px solid black;text-align:center;" margin-bottom: 10%;>SR.NO.</th>
                    <th align="left" style="border: 1px solid black;text-align:center;" margin-bottom: 10%;>PART DESCRIPTION</th>
                    <th align="left" style="border: 1px solid black;text-align:center;" margin-bottom: 10%;>PART NO.</th>  
                    <th align="left" style="border: 1px solid black;text-align:center;" margin-bottom: 10%;>QTY</th> 
                    <th align="left" style="border: 1px solid black;text-align:center;" margin-bottom: 10%;>UNITS</th>  
                    <th align="left" style="border: 1px solid black;text-align:center;" margin-bottom: 10%;>RATE</th>  
                    <th align="left"  style="border: 1px solid black;text-align:center;" margin-bottom: 10%;>AMOUNT</th>
                </tr>
                '.$CartItem.$space.' 
                   
               
 
                <tr style="border-left: 1px solid black;border-right: 1px solid black;">
                    <td style="border-left: 1px solid black;border-right: 1px solid black;"></td>
                    <td style="border-left: 1px solid black;border-right: 1px solid black;padding-left: 15px;"><p><b>Material From : </b></p>
                        <b><p>'.$getvendordeatilsForInvoice['supplier_name'].'</p></b>
                    </td>
                    <td style="border-left: 1px solid black;border-right: 1px solid black;"></td>
                    <td style="border-left: 1px solid black;border-right: 1px solid black;"></td>
                    <td style="border-left: 1px solid black;border-right: 1px solid black;"></td>
                    <td style="border-left: 1px solid black;border-right: 1px solid black;"></td>
                    <td style="border-left: 1px solid black;border-right: 1px solid black;"></td>
                </tr>
                '.$supplierItem.'
                <tr style="border: 1px solid black;">
                    <td colspan="4" style="padding: 8px;">'.$this->amount_in_word($subtotal).'</td>
                
                    <td colspan="2"  style="border: 1px solid black;padding-left: 10px;padding-right: 5px;font-family:cambria;font-size:10px;">SUB TOTAL (+) GST </td>    
                    <td style="border: 1px solid black;padding-left: 10px;">'.$subtotal.'/-'.'</td>
                </tr>
            </table>

            <table style=" width: 100%;border-collapse: collapse;border: #ccc 1px solid;font-family:cambria;font-size:12px">
                <tr style="border: 1px solid black;">
                        <td style="border: 1px solid black;padding-left: 10px;">
                            <p><b>Remark :</b>'.$getvendordeatilsForInvoice['ven_remark'].'</p>    
                    </td>   
                </tr>
            </table>

            <table style=" width: 100%;text-align: left;border-collapse: collapse;border: #ccc 1px solid;margin-top:10px;margin-bottom:10px;font-family:cambria;font-size:12px">
                  
                   <tr style="border: 1px solid black;">
                        <td style="border: 1px solid black;padding-left: 10px;" width="75%;">
                            <p><b>NOTE :</b></p>
                            <p><b>1. Confirmation of PO is Mandatory</b></p>
                            <p><b>2. Mentioning P.O.No. on Invoice is Mandatory</b></p>
                            <p><b>3. Once order issued & accepted, cannot be cancelled</b></p>
                            <p><b>4. Essence of this order is delivering the specified quality product on time.</b></p>
                            <p><b>5. If any Prices issue, should inform in 24hrs after receipt of P.O.</b></p>
                        </td>
                        <td style="border: 1px solid black;text-align: center;" width="25%" valign="top">
                            <p style="vertical-align: text-top;font-size:12px;color:#206a9b"><b>FOR SUPRA QUALITY EXPORTS (I) PVT. LTD.</b></p>
                            <br/><img src="'.base_url().'assets/images/stmps/supplierpostampsignature.png" width="130" height="100">
                            <p style="vertical-align: text-top;font-size:10px;color:#206a9b"><b>AUTHORIZED SIGNATORY</b></p>
                        </td> 
                </tr>
            </table>';

            // <p>FOR SUPRA QUALITY EXPORTS (I) PVT. LTD.</p>
    $invoice_name =  $getvendordeatilsForInvoice['ven_po_number'].' - '.$getvendordeatilsForInvoice['vendor_name'].'.pdf';
    $mpdf->WriteHTML($html);
    $mpdf->Output($invoice_name,'D'); // opens in browser


}

public function downloadvendorpowithoutsupplier($id){
    // $getsupplierdeatilsForInvoice = $this->admin_model->getsupplierdeatilsForInvoice($id);
    // $getsupplierItemdeatilsForInvoice = $this->admin_model->getsupplierItemdeatilsForInvoice($id);

    $getvendordeatilsForInvoice = $this->admin_model->getvendordeatilsForInvoicewithoutsupplier($id);
    $getvendorItemdeatilsForInvoice = $this->admin_model->getvendorItemdeatilsForInvoicewithoutsupplier($id);

    if($getvendordeatilsForInvoice['ven_quatation_date']!='0000-00-00'){
        $quatation_date =  date('d-m-Y',strtotime($getvendordeatilsForInvoice['ven_quatation_date']));
    }else{
        $quatation_date = '';
    }

    $CartItem = "";
    $ii =1;
    $subtotal = 0;

    $item_count =count($getvendorItemdeatilsForInvoice);

    if($item_count==1){
        $padding_bottom = '200px';
    }else if($item_count==2){
        $padding_bottom = '28px';
    }else if($item_count==3){
        $padding_bottom = '10px';
    }else{
        $padding_bottom = '10px';
    }

    foreach ($getvendorItemdeatilsForInvoice as $key => $value) {
        $CartItem .= '
                <tr style="border-left: 1px solid black;border-right: 1px solid black;">
                    <td style="border-left: 1px solid black;border-right: 1px solid black;text-align:left;padding: 10px;" valign="top">'.$ii.'</td>
                    <td style="border-left: 1px solid black;border-right: 1px solid black;text-align:left;padding: 10px;" valign="top">'.$value['name'].'<br>Gross Weight-'.$value['rmgrossweight'].' kgs </br><br>HSN Code -'.$value['hsn_code'].'</br><br>'.$value['desc1'].'</br><br>'.$value['desc2'].'</br></td> 
                    <td style="border-left: 1px solid black;border-right: 1px solid black;text-align:left;padding: 10px;" valign="top">'.$value['part_number'].'</td>
                    <td style="border-left: 1px solid black;border-right: 1px solid black;text-align:left;padding: 10px;" valign="top">'.$value['order_oty'].'</td>
                    <td style="border-left: 1px solid black;border-right: 1px solid black;text-align:left;padding: 10px;" valign="top">'.$value['unit'].'</td> 
                    <td style="border-left: 1px solid black;border-right: 1px solid black;text-align:left;padding: 10px;" valign="top">'.$value['rate'].'/-'.'</td>    
                    <td style="border-left: 1px solid black;border-right: 1px solid black;text-align:left;padding: 10px;" valign="top">'.$value['value'].'/-'.'</td>
                </tr>';
                $subtotal+=$value['value'];
            $ii++;       
    }

    $space = '<tr>
        <td style="padding-bottom: '.$padding_bottom.';border-left: 1px solid black;border-right: 1px solid black;border-bottom: 1px solid black">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </td>
        <td style="padding-bottom: '.$padding_bottom.';border-left: 1px solid black;border-right: 1px solid black;border-bottom: 1px solid black">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </td>
        <td style="padding-bottom: '.$padding_bottom.';border-left: 1px solid black;border-right: 1px solid black;border-bottom: 1px solid black">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </td>
        <td style="padding-bottom: '.$padding_bottom.';border-left: 1px solid black;border-right: 1px solid black;border-bottom: 1px solid black">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </td>
        <td style="padding-bottom: '.$padding_bottom.';border-left: 1px solid black;border-right: 1px solid black;border-bottom: 1px solid black">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </td>
        <td style="padding-bottom: '.$padding_bottom.';border-left: 1px solid black;border-right: 1px solid black;border-bottom: 1px solid black">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </td>
        <td style="padding-bottom: '.$padding_bottom.';border-left: 1px solid black;border-right: 1px solid black;border-bottom: 1px solid black">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </td>
    </tr>';

    $mpdf = new \Mpdf\Mpdf();
    // $html = $this->load->view('html_to_pdf',[],true);
    $html = '<table style=" width: 100%;text-align: center;border-collapse: collapse;border: #cccccc 0px solid;font-family:cambria;">
                <tr>
                  <td rowspan="2"><img src="'.base_url().'assets/images/supra_logo_1.jpg" width="80" height="80"></td>
                  <td style="color:#000080"><h2>SUPRA QUALITY EXPORTS (I) PVT. LTD</h2></td>
                  <td rowspan="2"><img src="'.base_url().'assets/images/logo_2.png"width="80" height="80"></td>
                </tr>
                <tr>
                  <td style="font-weight: bold;">
                    <p>MANUFACTURER & EXPORTERS OF:</p>
                    <p>PRECISION TURNED COMPONENTS, STAMPED /PRESSED PARTS IN FERROUS & NON-FERROUS METAL</p>
                    <p>MOULDED & EXTRUDED PLASTIC AND RUBBER COMPONENTS</p> 
                  </td>
                </tr>
            </table>
            <hr>
            <table style="width: 100%;text-align: left;border-collapse: collapse;border: #ccc 0px solid;font-family:cambria;">
                    <tr>
                        <td width="60%">
                          <p><b>Office:</b> 229 to 232, Bharat Industrial Estate,
                          <p> L.B.S. Marg, Bhandup West, Mumbai – 400078. INDIA.</b>
                          <p>Tel: +91 22 66959505 / +91 22 66600196 </p>
                          <p>+91 22 62390222 / +91 22 46061497 / +91 22 35115396 </p>
                          <p style="color:#206a9b"><b>GSTIN : 27AAJCS7869M1ZB </b></p>
                        </td>
                        <td width="40%">
                            <p><b>Email:</b></p> 
                            <p style="color:#206a9b">purchase@supraexports.in</p>
                            <p style="color:#206a9b">purchase1@supraexports.in</p>
                            <p style="color:#206a9b">purchase2@supraexports.in</p>
                        </td>  
                    </tr>
            </table>

            <table style=" width: 100%;text-align: center;border-collapse: collapse;border: #ccc 0px solid;margin-top:10px;margin-bottom:10px;font-family:cambria;">
                    <tr>
                        <td style="color:red;font-size:15px">
                          <u><p><h3>PURCHASE ORDER</h3></p>
                        </td>
                    </tr>
            </table>

            <table style=" width: 100%;text-align: left;border-collapse: collapse;font-family:cambria;font-size:13px;border: #ccc 1px solid">
                <tr style="border: 1px solid black;">
                    <td width="50%" style="padding-left: 15px;">
                        <div>
                            <p>To,</p>
                            <p><b>'.$getvendordeatilsForInvoice['vendor_name'].'</b></p>
                            <p>'.$getvendordeatilsForInvoice['ven_address'].'</p>
                            <p><b>Contact No:</b> '.$getvendordeatilsForInvoice['ven_mobile'].' / '.$getvendordeatilsForInvoice['ven_landline'].'</p>
                            <p><b>Contact Person:</b> '.$getvendordeatilsForInvoice['ven_contact_person'].'</p>
                            <p><b>Email:</b> '.$getvendordeatilsForInvoice['ven_email'].'</p>
                            <p style="color:red">GSTIN:'.$getvendordeatilsForInvoice['ven_GSTIN'].'</p>
                        <div>    
                    </td> 
                    <td style="border-left: 1px solid black;padding-left: 15px;font-size:13px" width="50%" >
                        <div>
                            <p><b>P.O.NO :</b> '.'<span style="color:red">'.$getvendordeatilsForInvoice['ven_po_number'].'</span></p>
                            <p>&nbsp;</p>
                            <p><b>P.O.DATE :</b> '.date('d-m-Y',strtotime($getvendordeatilsForInvoice['ven_date'])).'</p>
                            <p>&nbsp;</p>
                            <p><b>QUOTATION REFERENCE :</b> '.$getvendordeatilsForInvoice['ven_quatation_ref_no'].'</p>
                            <p>&nbsp;</p>
                            <p><b>QUOTATION DATE :</b> '.$quatation_date.'</p>
                        </div>
                    </td>
                </tr>
            </table>

            <table style=" width: 100%;text-align: left;border-collapse: collapse;border: #ccc 1px solid;margin-top:10px;margin-bottom:10px;font-family:cambria;font-size:12px">
                <tr style="border: 1px solid black;">
                    <th align="left" style="border: 1px solid black;padding-left: 10px;" margin-bottom: 10%;>DELIVERY DATE</th>
                    <th align="left" style="border: 1px solid black;padding-left: 10px;" margin-bottom: 10%;>PAYMENT TERMS</th>    
                </tr>
                <tr style="border: 1px solid black;">
                    <td style="border: 1px solid black;padding-left: 10px;">'.date('d-m-Y',strtotime($getvendordeatilsForInvoice['ven_delivery_date'])).'</td>    
                    <td style="border: 1px solid black;padding-left: 10px;">'.$getvendordeatilsForInvoice['ven_work_order'].'</td>
                </tr>
            </table>


            <table style=" width: 100%;text-align: left;border-collapse: collapse;border: #ccc 1px solid;margin-top:10px;margin-bottom:10px;font-family:cambria;font-size:12px">
                <tr style="border: 1px solid black;">
                    <th align="left" style="border: 1px solid black;text-align:center;" margin-bottom: 10%;>SR.NO.</th>
                    <th align="left" style="border: 1px solid black;text-align:center;" margin-bottom: 10%;>PART DESCRIPTION</th>
                    <th align="left" style="border: 1px solid black;text-align:center;" margin-bottom: 10%;>PART NO.</th>  
                    <th align="left" style="border: 1px solid black;text-align:center;" margin-bottom: 10%;>QTY</th> 
                    <th align="left" style="border: 1px solid black;text-align:center;" margin-bottom: 10%;>UNITS</th>  
                    <th align="left" style="border: 1px solid black;text-align:center;" margin-bottom: 10%;>RATE</th>  
                    <th align="left"  style="border: 1px solid black;text-align:center;" margin-bottom: 10%;>AMOUNT</th>
                </tr>
                '.$CartItem.$space.' 

                <tr style="border: 1px solid black;">
                <td colspan="4" style="padding: 8px;">'.$this->amount_in_word($subtotal).'</td>
            
                <td colspan="2"  style="border: 1px solid black;padding-left: 10px;padding-right: 5px;font-family:cambria;font-size:10px;">SUB TOTAL (+) GST </td>    
                <td style="border: 1px solid black;padding-left: 10px;">'.$subtotal.'/-'.'</td>
            </tr>
            </table>

            <table style=" width: 100%;border-collapse: collapse;border: #ccc 1px solid;font-family:cambria;font-size:12px">
                <tr style="border: 1px solid black;">
                        <td style="border: 1px solid black;padding-left: 10px;">
                            <p><b>Remark :</b>'.$getvendordeatilsForInvoice['ven_remark'].'</p>    
                    </td>   
                </tr>
            </table>

            <table style=" width: 100%;text-align: left;border-collapse: collapse;border: #ccc 1px solid;margin-top:10px;margin-bottom:10px;font-family:cambria;font-size:12px">
                  
                   <tr style="border: 1px solid black;">
                        <td style="border: 1px solid black;padding-left: 10px;" width="75%;">
                            <p><b>NOTE :</b></p>
                            <p><b>1. Confirmation of PO is Mandatory</b></p>
                            <p><b>2. Mentioning P.O.No. on Invoice is Mandatory</b></p>
                            <p><b>3. Once order issued & accepted, cannot be cancelled</b></p>
                            <p><b>4. Essence of this order is delivering the specified quality product on time.</b></p>
                            <p><b>5. If any Prices issue, should inform in 24hrs after receipt of P.O.</b></p>
                        </td>
                        <td style="border: 1px solid black;text-align: center;" width="25%" valign="top">
                            <p style="vertical-align: text-top;font-size:12px;color:#206a9b"><b>FOR SUPRA QUALITY EXPORTS (I) PVT. LTD.</b></p>
                            <br/><img src="'.base_url().'assets/images/stmps/supplierpostampsignature.png" width="130" height="100">
                            <p style="vertical-align: text-top;font-size:10px;color:#206a9b"><b>AUTHORIZED SIGNATORY</b></p>
                        </td> 
                </tr>
            </table>';

            // <p>FOR SUPRA QUALITY EXPORTS (I) PVT. LTD.</p>
    $invoice_name =  $getvendordeatilsForInvoice['ven_po_number'].' - '.$getvendordeatilsForInvoice['vendor_name'].'.pdf';
    $mpdf->WriteHTML($html);
    $mpdf->Output($invoice_name,'D'); // opens in browser


}


public function amount_in_word($number){

    $no = floor($number);
    $point = round($number - $no, 2) * 100;
    $hundred = null;
    $digits_1 = strlen($no);
    $i = 0;
    $str = array();
    $words = array('0' => '', '1' => 'One', '2' => 'Two',
     '3' => 'Three', '4' => 'Four', '5' => 'Five', '6' => 'Six',
     '7' => 'Seven', '8' => 'Eight', '9' => 'Nine',
     '10' => 'Ten', '11' => 'Eleven', '12' => 'Twelve',
     '13' => 'Thirteen', '14' => 'Fourteen',
     '15' => 'Fifteen', '16' => 'Sixteen', '17' => 'Seventeen',
     '18' => 'Eighteen', '19' =>'Nineteen', '20' => 'Twenty',
     '30' => 'Thirty', '40' => 'Forty', '50' => 'Fifty',
     '60' => 'Sixty', '70' => 'Seventy',
     '80' => 'Eighty', '90' => 'Ninety');
    $digits = array('', 'Hundred', 'Thousand', 'Lakh', 'Crore');
    while ($i < $digits_1) {
      $divider = ($i == 2) ? 10 : 100;
      $number = floor($no % $divider);
      $no = floor($no / $divider);
      $i += ($divider == 10) ? 1 : 2;
      if ($number) {
         $plural = (($counter = count($str)) && $number > 9) ? '' : null;
         $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
         $str [] = ($number < 21) ? $words[$number] .
             " " . $digits[$counter] . $plural . " " . $hundred
             :
             $words[floor($number / 10) * 10]
             . " " . $words[$number % 10] . " "
             . $digits[$counter] . $plural . " " . $hundred;
      } else $str[] = null;
   }
   $str = array_reverse($str);
   $result = implode('', $str);
   $points = ($point) ?
     "." . $words[$point / 10] . " " . 
           $words[$point = $point % 10] : '';
   //return $result . "Rupees  " . $points . " Paise";

   return  "Rupees  " .$result . $points. " Only";
}


public function downloadreworkrejection($id){

    $getReworkrejectionforInvoice = $this->admin_model->getReworkrejectionforInvoicesupplier($id);
    $getReworkRejectionitemdeatilsForInvoice = $this->admin_model->getReworkRejectionitemdeatilsForInvoice($id);

   
    $CartItem = "";
    $supplierItem = "";
    $i =1;
    $ii =1;
    $subtotal = 0;

    $raw_material_cost = 0;
    $cgst_tax_rate = 0;
    $sgst_tax_rate = 0;
    $igst_tax_rate = 0;
    $gst_rate ='';

    $item_count =count($getReworkRejectionitemdeatilsForInvoice);

    if($item_count==1){
        $padding_bottom = '200px';
    }else if($item_count==2){
        $padding_bottom = '40px';
    }else if($item_count==3){
        $padding_bottom = '10px';
    }else{
        $padding_bottom = '10px';
    }

   
    
    foreach ($getReworkRejectionitemdeatilsForInvoice as $key => $value) {

        if($value['raw_material_neight_weight']){
            $net_weigth = $value['qty'] * $value['raw_material_neight_weight'];
        }else{
            $net_weigth ='';
        }


        $CartItem .= '
                <tr style="border-left: 1px solid black;border-right: 1px solid black;">
                    <td style="border-left: 1px solid black;border-right: 1px solid black;text-align:left;padding: 10px;" valign="top">'.$ii.'</td>
                    <td style="border-left: 1px solid black;border-right: 1px solid black;text-align:left;padding: 10px;" valign="top">'.$value['type_of_raw_material'].'</br></td> 
                    <td style="border-left: 1px solid black;border-right: 1px solid black;text-align:left;padding: 10px;" valign="top">'.$value['part_number'].'</td>
                    <td style="border-left: 1px solid black;border-right: 1px solid black;text-align:left;padding: 10px;" valign="top"></td>
                    <td style="border-left: 1px solid black;border-right: 1px solid black;text-align:left;padding: 10px;" valign="top">'.$value['rejection_rework_reason'].'</td> 
                    <td style="border-left: 1px solid black;border-right: 1px solid black;text-align:left;padding: 10px;" valign="top">'.$value['qty'].'</td>    
                    <td style="border-left: 1px solid black;border-right: 1px solid black;text-align:left;padding: 10px;" valign="top">'.$value['rejection_rate'].'</td>    
                    <td style="border-left: 1px solid black;border-right: 1px solid black;text-align:left;padding: 10px;" valign="top">'.$value['value'].'/-'.'</td>
                </tr>';
                $subtotal+=$value['value'];
                $raw_material_cost +=$value['row_material_cost'];
                $grand_total +=$value['grand_total'];
                $gst_rate = $value['gst_rate'];

                if($value['gst_rate']=='CGST_SGST'){
                    $cgst_tax_rate = 9;
                    $sgst_tax_rate = 9;

                    $cgst_tax_value = $value['gst_value']/2;
                    $sgst_tax_value = $value['gst_value']/2;

                }else if($value['gst_rate']=='CGST_SGST_6'){
                    $cgst_tax_rate = 6;
                    $sgst_tax_rate = 6;

                    $cgst_tax_value = $value['gst_value']/2;
                    $sgst_tax_value = $value['gst_value']/2;

                }else if($value['gst_rate']=='IGST'){
                    $igst_tax_rate = 18;
                    $igst_tax_value = $value['gst_value'];
                }else if($value['gst_rate']=='IGST_12'){
                    $igst_tax_rate = 12;
                    $igst_tax_value = $value['gst_value'];

                }

            $ii++;       
    }

    $space = '<tr>
        <td style="padding-bottom: '.$padding_bottom.';border-left: 1px solid black;border-right: 1px solid black;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </td>
        <td style="padding-bottom: '.$padding_bottom.';border-left: 1px solid black;border-right: 1px solid black;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </td>
        <td style="padding-bottom: '.$padding_bottom.';border-left: 1px solid black;border-right: 1px solid black;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </td>
        <td style="padding-bottom: '.$padding_bottom.';border-left: 1px solid black;border-right: 1px solid black;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </td>
        <td style="padding-bottom: '.$padding_bottom.';border-left: 1px solid black;border-right: 1px solid black;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </td>
        <td style="padding-bottom: '.$padding_bottom.';border-left: 1px solid black;border-right: 1px solid black;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </td>
        <td style="padding-bottom: '.$padding_bottom.';border-left: 1px solid black;border-right: 1px solid black;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </td>
        <td style="padding-bottom: '.$padding_bottom.';border-left: 1px solid black;border-right: 1px solid black;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </td>
    </tr>';


     if($gst_rate=='CGST_SGST' || $gst_rate=='CGST_SGST_6'){
        $tax_value = '<tr style="border: 1px solid black;">               
            <td colspan="7"  style="text-align: right;border: 1px solid black;padding-left: 10px;padding-right: 5px;font-family:cambria;font-size:14px;"><b>(+) '.$cgst_tax_rate.'% CGST </b></td>    
                <td style="border: 1px solid black;padding-left: 10px;">'.$cgst_tax_value.'</td>
            </tr>

            <tr style="border: 1px solid black;">

                <td colspan="7"  style="text-align: right;border: 1px solid black;padding-left: 10px;padding-right: 5px;font-family:cambria;font-size:14px;"><b>(+) '.$sgst_tax_rate.'% SGST </b></td>    
                <td style="border: 1px solid black;padding-left: 10px;">'.$sgst_tax_value.'</td>
            </tr>';
     }else{
        $tax_value = '
            <tr style="border: 1px solid black;">
                <td colspan="7"  style="text-align: right;border: 1px solid black;padding-left: 10px;padding-right: 5px;font-family:cambria;font-size:14px;"><b>(+) '.$igst_tax_rate.'% IGST </b></td>    
                <td style="border: 1px solid black;padding-left: 10px;">'.$igst_tax_value.'</td>
            </tr>';
     }

  
    $mpdf = new \Mpdf\Mpdf();
    // $html = $this->load->view('html_to_pdf',[],true);
    $html = '<table style=" width: 100%;text-align: center;border-collapse: collapse;border: #cccccc 0px solid;font-family:cambria;">
                <tr>
                  <td rowspan="2"><img src="'.base_url().'assets/images/supra_logo_1.jpg" width="80" height="80"></td>
                  <td style="color:#000080"><h2>SUPRA QUALITY EXPORTS (I) PVT. LTD</h2></td>
                  <td rowspan="2"><img src="'.base_url().'assets/images/logo_2.png"width="80" height="80"></td>
                </tr>
                <tr>
                  <td style="font-weight: bold;">
                    <p>MANUFACTURER & EXPORTERS OF:</p>
                    <p>PRECISION TURNED COMPONENTS, STAMPED /PRESSED PARTS IN FERROUS & NON-FERROUS METAL</p>
                    <p>MOULDED & EXTRUDED PLASTIC AND RUBBER COMPONENTS</p> 
                  </td>
                </tr>
            </table>
            <hr>
            <table style="width: 100%;text-align: left;border-collapse: collapse;border: #ccc 0px solid;font-family:cambria;">
                    <tr>
                        <td width="60%">
                          <p><b>Office:</b> 229 to 232, Bharat Industrial Estate,
                          <p> L.B.S. Marg, Bhandup West, Mumbai – 400078. INDIA.</b>
                          <p>Tel: +91 22 66959505 / +91 22 66600196 </p>
                          <p>+91 22 62390222 / +91 22 46061497 / +91 22 35115396 </p>
                          <p style="color:#206a9b"><b>GSTIN : 27AAJCS7869M1ZB </b></p>
                        </td>
                        <td width="40%">
                            <p><b>Email:</b></p> 
                            <p style="color:#206a9b">purchase@supraexports.in</p>
                            <p style="color:#206a9b">purchase1@supraexports.in</p>
                            <p style="color:#206a9b">purchase2@supraexports.in</p>
                        </td>  
                    </tr>
            </table>

            <table style=" width: 100%;text-align: center;border-collapse: collapse;border: #ccc 0px solid;margin-top:10px;margin-bottom:10px;font-family:cambria;">
                    <tr>
                        <td style="color:red;font-size:15px">
                          <u><p><h3>R R CHALLAN</h3></p>
                        </td>
                    </tr>
            </table>

            <table style=" width: 100%;text-align: left;border-collapse: collapse;font-family:cambria;font-size:13px;border: #ccc 1px solid">
                <tr style="border: 1px solid black;">
                    <td width="50%" style="padding-left: 15px;">
                        <div>
                            <p>To,</p>
                            <p><b>'.$getReworkrejectionforInvoice['supplier_name'].'</b></p>
                            <p>'.$getReworkrejectionforInvoice['supplier_addess'].'</p>
                            <p><b>Contact No:</b> '.$getReworkrejectionforInvoice['mobile'].' / '.$getReworkrejectionforInvoice['suplier_landline'].'</p>
                            <p><b>Contact Person:</b> '.$getReworkrejectionforInvoice['sup_conatct'].'</p>
                            <p><b>Email:</b> '.$getReworkrejectionforInvoice['sup_email'].'</p>
                            <p style="color:red">GSTIN:'.$getReworkrejectionforInvoice['sup_GSTIN'].'</p>
                        <div>    
                    </td> 
                    <td style="border-left: 1px solid black;padding-left: 15px;font-size:13px;" width="50%" valign="top">
                        <div>
                            <p><b></b>'. str_repeat('&nbsp;', 5).'<span style="color:red"></span></p>
                            <p><b>CHALLAN NO :</b> '.'<span style="color:red">'.$getReworkrejectionforInvoice['rrchallaon'].'</span></p>
                            <p>&nbsp;</p>
                            <p><b>CHALLAN DATE :</b> '.date('d-m-Y',strtotime($getReworkrejectionforInvoice['challan_date'])).'</p>
                            <p>&nbsp;</p>
                        </div>
                    </td>
                </tr>
            </table>


            <table style=" width: 100%;text-align: left;border-collapse: collapse;border: #ccc 1px solid;margin-top:10px;margin-bottom:10px;font-family:cambria;font-size:12px">
                <tr style="border: 1px solid black;">
                    <th align="left" style="border: 1px solid black;text-align:center;" margin-bottom: 10%;>SR.NO.</th>
                    <th align="left" style="border: 1px solid black;text-align:center;" margin-bottom: 10%;>F.G. PART DESCRIPTION</th>
                    <th align="left" style="border: 1px solid black;text-align:center;" margin-bottom: 10%;>F.G. PART NO.</th>  
                    <th align="left" style="border: 1px solid black;text-align:center;" margin-bottom: 10%;>RM TYPE</th> 
                    <th align="left" style="border: 1px solid black;text-align:center;" margin-bottom: 10%;>Rejection Reason</th>  
                    <th align="left" style="border: 1px solid black;text-align:center;" margin-bottom: 10%;>Qty in pcs/kgs</th>  
                    <th align="left" style="border: 1px solid black;text-align:center;" margin-bottom: 10%;>Rate</th>  
                    <th align="left"  style="border: 1px solid black;text-align:center;" margin-bottom: 10%;>AMOUNT</th>
                </tr>
                '.$CartItem.$space.' 

                <tr style="border: 1px solid black;">               
                <td colspan="7"  style="text-align: right;border: 1px solid black;padding-left: 10px;padding-right: 5px;font-family:cambria;font-size:14px;"><b>Total Raw Material Cost </b></td>    
                <td style="border: 1px solid black;padding-left: 10px;">'. $raw_material_cost.'</td>
            </tr>
             '. $tax_value.'
            

            <tr style="border: 1px solid black;">
                    <td colspan="7"  style="text-align: right;border: 1px solid black;padding-left: 10px;padding-right: 5px;font-family:cambria;font-size:14px;"><b>TOTAL</b></td>    
                    <td style="border: 1px solid black;padding-left: 10px;">'.$grand_total.'/-'.'</td>
              </tr>
          
            </table>

            <table style=" width: 100%;border-collapse: collapse;border: #ccc 1px solid;font-family:cambria;font-size:12px">
                <tr style="border: 1px solid black;">
                        <td style="border: 1px solid black;padding-left: 10px;">
                            <p><b>Remark :</b>'.$getReworkrejectionforInvoice['supplier_remark'].'</p>    
                    </td>   
                </tr>
            </table>

            <table style=" width: 100%;text-align: left;border-collapse: collapse;border: #ccc 1px solid;margin-top:10px;margin-bottom:10px;font-family:cambria;font-size:12px">
                  
                   <tr style="border: 1px solid black;">
                        <td style="border: 1px solid black;padding-left: 10px;" width="75%;" valign="top">
                            <div style="margin-bottom:10px;">
                                <p><b>Received the above-mentioned goods in good order & condition & 
                                returned the Duplicate Duty sealed & signed.</b></p>
                            </div>
                            <br>

                            <p><b>Dispatched By: </b>'.$getReworkrejectionforInvoice['dispath_through'].'</p>
                            <p><b>No.of Bags/ Boxes/ Goni: </b>'.$getReworkrejectionforInvoice['total_bags'].'</p>
                            <p><b>Total Gross Weight: </b>'.$getReworkrejectionforInvoice['total_weight'].'</p>
                            <p><b>Total Net Weight: </b>'.$getReworkrejectionforInvoice['total_netweight_in_kgs'].'</p>
                          
                        </td>
                        <td style="border: 1px solid black;text-align: center;" width="25%" valign="top">
                            <p style="vertical-align: text-top;font-size:12px;color:#206a9b"><b>FOR SUPRA QUALITY EXPORTS (I) PVT. LTD.</b></p>
                            <br/><img src="'.base_url().'assets/images/stmps/rr_challan.png" width="130" height="100">
                            <p style="vertical-align: text-top;font-size:10px;color:#206a9b"><b>AUTHORIZED SIGNATORY</b></p>
                        </td> 
                </tr>
            </table>';

            // <p>FOR SUPRA QUALITY EXPORTS (I) PVT. LTD.</p>
    $invoice_name =  $getReworkrejectionforInvoice['rrchallaon'].' - '.$getReworkrejectionforInvoice['supplier_name'].'.pdf';
    $mpdf->WriteHTML($html);
    $mpdf->Output($invoice_name,'D'); // opens in browser

}

public function downloadreworkrejectionvendor($id){

    $getReworkrejectionforInvoice = $this->admin_model->getReworkrejectionforInvoicevendor($id);
    $getReworkRejectionitemdeatilsForInvoice = $this->admin_model->getReworkRejectionitemdeatilsForInvoicevendor($id);

   
    $CartItem = "";
    $supplierItem = "";
    $i =1;
    $ii =1;
    $subtotal = 0;

    $raw_material_cost = 0;
    $cgst_tax_rate = 0;
    $sgst_tax_rate = 0;
    $igst_tax_rate = 0;
    $gst_rate ='';

    $item_count =count($getReworkRejectionitemdeatilsForInvoice);

    if($item_count==1){
        $padding_bottom = '200px';
    }else if($item_count==2){
        $padding_bottom = '40px';
    }else if($item_count==3){
        $padding_bottom = '10px';
    }else{
        $padding_bottom = '10px';
    }

  
    
    
    foreach ($getReworkRejectionitemdeatilsForInvoice as $key => $value) {


        if($value['raw_material_neight_weight']){
            $net_weigth = $value['qty'] *$value['raw_material_neight_weight'];
        }else{
            $net_weigth ='';
        }

        $CartItem .= '
                <tr style="border-left: 1px solid black;border-right: 1px solid black;">
                    <td style="border-left: 1px solid black;border-right: 1px solid black;text-align:left;padding: 10px;" valign="top">'.$ii.'</td>
                    <td style="border-left: 1px solid black;border-right: 1px solid black;text-align:left;padding: 10px;" valign="top">'.$value['name'].'</br></td> 
                    <td style="border-left: 1px solid black;border-right: 1px solid black;text-align:left;padding: 10px;" valign="top">'.$value['fg_part'].'</td>
                    <td style="border-left: 1px solid black;border-right: 1px solid black;text-align:left;padding: 10px;" valign="top">'.$value['type_of_raw_material'].'</td>
                    <td style="border-left: 1px solid black;border-right: 1px solid black;text-align:left;padding: 10px;" valign="top">'.$value['rejection_rework_reason'].'</td> 
                    <td style="border-left: 1px solid black;border-right: 1px solid black;text-align:left;padding: 10px;" valign="top">'.$value['qty'].'</td>    
                    <td style="border-left: 1px solid black;border-right: 1px solid black;text-align:left;padding: 10px;" valign="top">'.$net_weigth.'</td>    
                    <td style="border-left: 1px solid black;border-right: 1px solid black;text-align:left;padding: 10px;" valign="top">'.$value['value'].'/-'.'</td>
                </tr>';
                $subtotal+=$value['value'];
                $raw_material_cost +=$value['row_material_cost'];
                $grand_total +=$value['grand_total'];
                $gst_rate = $value['gst_rate'];

                if($value['gst_rate']=='CGST_SGST'){
                    $cgst_tax_rate = 9;
                    $sgst_tax_rate = 9;

                    $cgst_tax_value = $value['gst_value']/2;
                    $sgst_tax_value = $value['gst_value']/2;

                }else if($value['gst_rate']=='CGST_SGST_6'){
                    $cgst_tax_rate = 6;
                    $sgst_tax_rate = 6;

                    $cgst_tax_value = $value['gst_value']/2;
                    $sgst_tax_value = $value['gst_value']/2;

                }else if($value['gst_rate']=='IGST'){
                    $igst_tax_rate = 18;
                    $igst_tax_value = $value['gst_value'];
                }else if($value['gst_rate']=='IGST_12'){
                    $igst_tax_rate = 12;
                    $igst_tax_value = $value['gst_value'];

                }

            $ii++;       
    }

    $space = '<tr>
        <td style="padding-bottom: '.$padding_bottom.';border-left: 1px solid black;border-right: 1px solid black;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </td>
        <td style="padding-bottom: '.$padding_bottom.';border-left: 1px solid black;border-right: 1px solid black;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </td>
        <td style="padding-bottom: '.$padding_bottom.';border-left: 1px solid black;border-right: 1px solid black;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </td>
        <td style="padding-bottom: '.$padding_bottom.';border-left: 1px solid black;border-right: 1px solid black;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </td>
        <td style="padding-bottom: '.$padding_bottom.';border-left: 1px solid black;border-right: 1px solid black;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </td>
        <td style="padding-bottom: '.$padding_bottom.';border-left: 1px solid black;border-right: 1px solid black;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </td>
        <td style="padding-bottom: '.$padding_bottom.';border-left: 1px solid black;border-right: 1px solid black;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </td>
        <td style="padding-bottom: '.$padding_bottom.';border-left: 1px solid black;border-right: 1px solid black;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </td>
    </tr>';


     if($gst_rate=='CGST_SGST' || $gst_rate=='CGST_SGST_6'){
        $tax_value = '<tr style="border: 1px solid black;">               
            <td colspan="7"  style="text-align: right;border: 1px solid black;padding-left: 10px;padding-right: 5px;font-family:cambria;font-size:14px;"><b>(+) '.$cgst_tax_rate.'% CGST </b></td>    
                <td style="border: 1px solid black;padding-left: 10px;">'.$cgst_tax_value.'</td>
            </tr>

            <tr style="border: 1px solid black;">

                <td colspan="7"  style="text-align: right;border: 1px solid black;padding-left: 10px;padding-right: 5px;font-family:cambria;font-size:14px;"><b>(+) '.$sgst_tax_rate.'% SGST </b></td>    
                <td style="border: 1px solid black;padding-left: 10px;">'.$sgst_tax_value.'</td>
            </tr>';
     }else{
        $tax_value = '
            <tr style="border: 1px solid black;">
                <td colspan="7"  style="text-align: right;border: 1px solid black;padding-left: 10px;padding-right: 5px;font-family:cambria;font-size:14px;"><b>(+) '.$igst_tax_rate.'% IGST </b></td>    
                <td style="border: 1px solid black;padding-left: 10px;">'.$igst_tax_value.'</td>
            </tr>';
     }

  
    $mpdf = new \Mpdf\Mpdf();
    // $html = $this->load->view('html_to_pdf',[],true);
    $html = '<table style=" width: 100%;text-align: center;border-collapse: collapse;border: #cccccc 0px solid;font-family:cambria;">
                <tr>
                  <td rowspan="2"><img src="'.base_url().'assets/images/supra_logo_1.jpg" width="80" height="80"></td>
                  <td style="color:#000080"><h2>SUPRA QUALITY EXPORTS (I) PVT. LTD</h2></td>
                  <td rowspan="2"><img src="'.base_url().'assets/images/logo_2.png"width="80" height="80"></td>
                </tr>
                <tr>
                  <td style="font-weight: bold;">
                    <p>MANUFACTURER & EXPORTERS OF:</p>
                    <p>PRECISION TURNED COMPONENTS, STAMPED /PRESSED PARTS IN FERROUS & NON-FERROUS METAL</p>
                    <p>MOULDED & EXTRUDED PLASTIC AND RUBBER COMPONENTS</p> 
                  </td>
                </tr>
            </table>
            <hr>
            <table style="width: 100%;text-align: left;border-collapse: collapse;border: #ccc 0px solid;font-family:cambria;">
                    <tr>
                        <td width="60%">
                          <p><b>Office:</b> 229 to 232, Bharat Industrial Estate,
                          <p> L.B.S. Marg, Bhandup West, Mumbai – 400078. INDIA.</b>
                          <p>Tel: +91 22 66959505 / +91 22 66600196 </p>
                          <p>+91 22 62390222 / +91 22 46061497 / +91 22 35115396 </p>
                          <p style="color:#206a9b"><b>GSTIN : 27AAJCS7869M1ZB </b></p>
                        </td>
                        <td width="40%">
                            <p><b>Email:</b></p> 
                            <p style="color:#206a9b">purchase@supraexports.in</p>
                            <p style="color:#206a9b">purchase1@supraexports.in</p>
                            <p style="color:#206a9b">purchase2@supraexports.in</p>
                        </td>  
                    </tr>
            </table>

            <table style=" width: 100%;text-align: center;border-collapse: collapse;border: #ccc 0px solid;margin-top:10px;margin-bottom:10px;font-family:cambria;">
                    <tr>
                        <td style="color:red;font-size:15px">
                          <u><p><h3>R R CHALLAN</h3></p>
                        </td>
                    </tr>
            </table>

            <table style=" width: 100%;text-align: left;border-collapse: collapse;font-family:cambria;font-size:13px;border: #ccc 1px solid">
                <tr style="border: 1px solid black;">
                    <td width="50%" style="padding-left: 15px;">
                        <div>
                            <p>To,</p>
                            <p><b>'.$getReworkrejectionforInvoice['vendor_name'].'</b></p>
                            <p>'.$getReworkrejectionforInvoice['ven_address'].'</p>
                            <p><b>Contact No:</b> '.$getReworkrejectionforInvoice['ven_mobile'].' / '.$getReworkrejectionforInvoice['ven_landline'].'</p>
                            <p><b>Contact Person:</b> '.$getReworkrejectionforInvoice['ven_contact_person'].'</p>
                            <p><b>Email:</b> '.$getReworkrejectionforInvoice['ven_mobile'].'</p>
                            <p style="color:red">GSTIN:'.$getReworkrejectionforInvoice['ven_GSTIN'].'</p>
                        <div>    
                    </td> 
                    <td style="border-left: 1px solid black;padding-left: 15px;font-size:13px;" width="50%" valign="top">
                        <div>
                            <p><b></b>'. str_repeat('&nbsp;', 5).'<span style="color:red"></span></p>
                            <p><b>CHALLAN NO :</b> '.'<span style="color:red">'.$getReworkrejectionforInvoice['rrchallaon'].'</span></p>
                            <p>&nbsp;</p>
                            <p><b>CHALLAN DATE :</b> '.date('d-m-Y',strtotime($getReworkrejectionforInvoice['challan_date'])).'</p>
                            <p>&nbsp;</p>
                        </div>
                    </td>
                </tr>
            </table>


            <table style=" width: 100%;text-align: left;border-collapse: collapse;border: #ccc 1px solid;margin-top:10px;margin-bottom:10px;font-family:cambria;font-size:12px">
                <tr style="border: 1px solid black;">
                    <th align="left" style="border: 1px solid black;text-align:center;" margin-bottom: 10%;>SR.NO.</th>
                    <th align="left" style="border: 1px solid black;text-align:center;" margin-bottom: 10%;>F.G. PART DESCRIPTION</th>
                    <th align="left" style="border: 1px solid black;text-align:center;" margin-bottom: 10%;>F.G. PART NO.</th>  
                    <th align="left" style="border: 1px solid black;text-align:center;" margin-bottom: 10%;>RM TYPE</th> 
                    <th align="left" style="border: 1px solid black;text-align:center;" margin-bottom: 10%;>Rejection Reason</th>  
                    <th align="left" style="border: 1px solid black;text-align:center;" margin-bottom: 10%;>QTY IN PCS</th>  
                    <th align="left" style="border: 1px solid black;text-align:center;" margin-bottom: 10%;>Net Weight In kgs</th>  
                    <th align="left"  style="border: 1px solid black;text-align:center;" margin-bottom: 10%;>AMOUNT</th>
                </tr>
                '.$CartItem.$space.' 

                <tr style="border: 1px solid black;">               
                <td colspan="7"  style="text-align: right;border: 1px solid black;padding-left: 10px;padding-right: 5px;font-family:cambria;font-size:14px;"><b>Total Raw Material Cost </b></td>    
                <td style="border: 1px solid black;padding-left: 10px;">'. $raw_material_cost.'</td>
            </tr>
             '. $tax_value.'
            

            <tr style="border: 1px solid black;">
                    <td colspan="7"  style="text-align: right;border: 1px solid black;padding-left: 10px;padding-right: 5px;font-family:cambria;font-size:14px;"><b>TOTAL</b></td>    
                    <td style="border: 1px solid black;padding-left: 10px;">'.$grand_total.'/-'.'</td>
              </tr>
          
            </table>

            <table style=" width: 100%;border-collapse: collapse;border: #ccc 1px solid;font-family:cambria;font-size:12px">
                <tr style="border: 1px solid black;">
                        <td style="border: 1px solid black;padding-left: 10px;">
                            <p><b>Remark :</b>'.$getReworkrejectionforInvoice['supplier_remark'].'</p>    
                    </td>   
                </tr>
            </table>

            <table style=" width: 100%;text-align: left;border-collapse: collapse;border: #ccc 1px solid;margin-top:10px;margin-bottom:10px;font-family:cambria;font-size:12px">
                  
                   <tr style="border: 1px solid black;">
                        <td style="border: 1px solid black;padding-left: 10px;" width="75%;" valign="top">
                            <div style="margin-bottom:10px;">
                                <p><b>Received the above-mentioned goods in good order & condition & 
                                returned the Duplicate Duty sealed & signed.</b></p>
                            </div>
                            <br>

                            <p><b>Dispatched By: </b>'.$getReworkrejectionforInvoice['dispath_through'].'</p>
                            <p><b>No.of Bags/ Boxes/ Goni: </b>'.$getReworkrejectionforInvoice['total_bags'].'</p>
                            <p><b>Total Gross Weight: </b>'.$getReworkrejectionforInvoice['total_weight'].'</p>
                            <p><b>Total Net Weight :</b>'.$getReworkrejectionforInvoice['total_netweight_in_kgs'].'</p>
                          
                        </td>
                        <td style="border: 1px solid black;text-align: center;" width="25%" valign="top">
                            <p style="vertical-align: text-top;font-size:12px;color:#206a9b"><b>FOR SUPRA QUALITY EXPORTS (I) PVT. LTD.</b></p>
                            <br/><img src="'.base_url().'assets/images/stmps/rr_challan.png" width="130" height="100">
                            <p style="vertical-align: text-top;font-size:10px;color:#206a9b"><b>AUTHORIZED SIGNATORY</b></p>
                        </td> 
                </tr>
            </table>';

            // <p>FOR SUPRA QUALITY EXPORTS (I) PVT. LTD.</p>
    $invoice_name =  $getReworkrejectionforInvoice['rrchallaon'].' - '.$getReworkrejectionforInvoice['vendor_name'].'.pdf';
    $mpdf->WriteHTML($html);
    $mpdf->Output($invoice_name,'D'); // opens in browser
}

public function downloadpackinginstraction($packing_details_item_id){

        $getPackingInstructionData = $this->admin_model->getPackingInstructionData($packing_details_item_id);

        // Create a new PHPWord object
        $phpWord = new \PhpOffice\PhpWord\PhpWord();

        // Add a section to the document
        $section = $phpWord->addSection();

        // Sample HTML table string
        $htmlTable = '<table style="width:80%;font-size:18px;font-family:cambria;" border="0.5">
                <tr>
                    <th colspan="3" style="text-align:center;padding: 10px;"><b>PACKAGING INSTRUCTION</b></th>
                </tr>
                <tr>
                    <td style="text-align:left;padding-letf: 10px;width:30%;font-size:17px"><b>PO No and Date</b></td>
                    <td style="text-align:left;padding: 10px;width:10%"></td>
                    <td style="text-align:left;padding: 10px;width:60%">'.$getPackingInstructionData[0]['buyer_po_number'].str_repeat('&nbsp;', 5).date('d-m-Y',strtotime($getPackingInstructionData[0]['buyer_po_date'])).'</td>
                </tr>
                <tr>
                    <td style="text-align:left;margin-top: 10px;width:30%;font-size:17px"><b>Invoice No</b></td>
                    <td style="text-align:left;padding: 10px;width:10%"></td>
                    <td style="text-align:left;padding: 10px;width:60%">'.$getPackingInstructionData[0]['buyer_invoice_number'].'</td>
                </tr>
                <tr>
                    <td style="text-align:left;margin-top: 10px;width:30%;font-size:17px"><b>Date</b></td>
                    <td style="text-align:left;padding: 10px;width:10%"></td>
                    <td style="text-align:left;padding: 10px;width:60%">'.date('d-m-Y',strtotime($getPackingInstructionData[0]['buyer_invoice_date'])).'</td>
                </tr>
                <tr>
                    <td style="text-align:left;margin-top: 10px;width:30%;font-size:17px"><b>Description</b></td>
                    <td style="text-align:left;padding: 10px;width:10%"></td>
                    <td style="text-align:left;padding: 10px;width:60%">'.$getPackingInstructionData[0]['name'].'</td>
                </tr>
                <tr>
                    <td style="text-align:left;margin-top: 10px;width:30%;font-size:17px"><b>Part No</b></td>
                    <td style="text-align:left;padding: 10px;width:10%"></td>
                    <td style="text-align:left;padding: 10px;width:60%">'.$getPackingInstructionData[0]['part_number'].'</td>
                </tr>
                <tr>
                    <td style="text-align:left;margin-top: 10px;width:30%;font-size:17px"><b>Quantity</b></td>
                    <td style="text-align:left;padding: 10px;width:10%"></td>
                    <td style="text-align:left;padding: 10px;width:60%">'.$getPackingInstructionData[0]['box_qty'].'</td>
                </tr>
                <tr>
                    <td style="text-align:left;margin-top: 10px;width:30%;font-size:17px"><b>Final Check Signature</b></td>
                    <td style="text-align:left;padding: 10px;width:10%"></td>
                    <td style="text-align:left;padding: 10px;width:60%"></td>
                </tr>
            </table>   <br/>

            <table style="width:80%;font-size:18px;font-family:cambria;" border="0.5">
                <tr>
                    <th colspan="3" style="text-align:center;padding: 10px;"><b>PACKAGING INSTRUCTION</b></th>
                </tr>
                <tr>
                    <td style="text-align:left;padding-letf: 10px;width:30%;font-size:17px"><b>PO No and Date</b></td>
                    <td style="text-align:left;padding: 10px;width:10%"></td>
                    <td style="text-align:left;padding: 10px;width:60%">'.$getPackingInstructionData[0]['buyer_po_number'].str_repeat('&nbsp;', 5).date('d-m-Y',strtotime($getPackingInstructionData[0]['buyer_po_date'])).'</td>
                </tr>
                <tr>
                    <td style="text-align:left;margin-top: 10px;width:30%;font-size:17px"><b>Invoice No</b></td>
                    <td style="text-align:left;padding: 10px;width:10%"></td>
                    <td style="text-align:left;padding: 10px;width:60%">'.$getPackingInstructionData[0]['buyer_invoice_number'].'</td>
                </tr>
                <tr>
                    <td style="text-align:left;margin-top: 10px;width:30%;font-size:17px"><b>Date</b></td>
                    <td style="text-align:left;padding: 10px;width:10%"></td>
                    <td style="text-align:left;padding: 10px;width:60%">'.date('d-m-Y',strtotime($getPackingInstructionData[0]['buyer_invoice_date'])).'</td>
                </tr>
                <tr>
                    <td style="text-align:left;margin-top: 10px;width:30%;font-size:17px"><b>Description</b></td>
                    <td style="text-align:left;padding: 10px;width:10%"></td>
                    <td style="text-align:left;padding: 10px;width:60%">'.$getPackingInstructionData[0]['name'].'</td>
                </tr>
                <tr>
                    <td style="text-align:left;margin-top: 10px;width:30%;font-size:17px"><b>Part No</b></td>
                    <td style="text-align:left;padding: 10px;width:10%"></td>
                    <td style="text-align:left;padding: 10px;width:60%">'.$getPackingInstructionData[0]['part_number'].'</td>
                </tr>
                <tr>
                    <td style="text-align:left;margin-top: 10px;width:30%;font-size:17px"><b>Quantity</b></td>
                    <td style="text-align:left;padding: 10px;width:10%"></td>
                    <td style="text-align:left;padding: 10px;width:60%">'.$getPackingInstructionData[0]['box_qty'].'</td>
                </tr>
                <tr>
                    <td style="text-align:left;margin-top: 10px;width:30%;font-size:17px"><b>Final Check Signature</b></td>
                    <td style="text-align:left;padding: 10px;width:10%"></td>
                    <td style="text-align:left;padding: 10px;width:60%"></td>
                </tr>
            </table>
            <br/>

            <table style="width:80%;font-size:18px;font-family:cambria;" border="0.5">
                <tr>
                    <th colspan="3" style="text-align:center;padding: 10px;"><b>PACKAGING INSTRUCTION</b></th>
                </tr>
                <tr>
                    <td style="text-align:left;padding-letf: 10px;width:30%;font-size:17px"><b>PO No and Date</b></td>
                    <td style="text-align:left;padding: 10px;width:10%"></td>
                    <td style="text-align:left;padding: 10px;width:60%">'.$getPackingInstructionData[0]['buyer_po_number'].str_repeat('&nbsp;', 5).date('d-m-Y',strtotime($getPackingInstructionData[0]['buyer_po_date'])).'</td>
                </tr>
                <tr>
                    <td style="text-align:left;margin-top: 10px;width:30%;font-size:17px"><b>Invoice No</b></td>
                    <td style="text-align:left;padding: 10px;width:10%"></td>
                    <td style="text-align:left;padding: 10px;width:60%">'.$getPackingInstructionData[0]['buyer_invoice_number'].'</td>
                </tr>
                <tr>
                    <td style="text-align:left;margin-top: 10px;width:30%;font-size:17px"><b>Date</b></td>
                    <td style="text-align:left;padding: 10px;width:10%"></td>
                    <td style="text-align:left;padding: 10px;width:60%">'.date('d-m-Y',strtotime($getPackingInstructionData[0]['buyer_invoice_date'])).'</td>
                </tr>
                <tr>
                    <td style="text-align:left;margin-top: 10px;width:30%;font-size:17px"><b>Description</b></td>
                    <td style="text-align:left;padding: 10px;width:10%"></td>
                    <td style="text-align:left;padding: 10px;width:60%">'.$getPackingInstructionData[0]['name'].'</td>
                </tr>
                <tr>
                    <td style="text-align:left;margin-top: 10px;width:30%;font-size:17px"><b>Part No</b></td>
                    <td style="text-align:left;padding: 10px;width:10%"></td>
                    <td style="text-align:left;padding: 10px;width:60%">'.$getPackingInstructionData[0]['part_number'].'</td>
                </tr>
                <tr>
                    <td style="text-align:left;margin-top: 10px;width:30%;font-size:17px"><b>Quantity</b></td>
                    <td style="text-align:left;padding: 10px;width:10%"></td>
                    <td style="text-align:left;padding: 10px;width:60%">'.$getPackingInstructionData[0]['box_qty'].'</td>
                </tr>
                <tr>
                    <td style="text-align:left;margin-top: 10px;width:30%;font-size:17px"><b>Final Check Signature</b></td>
                    <td style="text-align:left;padding: 10px;width:10%"></td>
                    <td style="text-align:left;padding: 10px;width:60%"></td>
                </tr>
            </table>
            ';

            // Parse HTML table
            $table = Html::addHtml($section, $htmlTable, false, false);

            // Save the document
            $filename = 'Packing_Instructions.docx';
            $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
            $objWriter->save($filename);

            // Offer the document as a download
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . $filename . '"');
            
            readfile($filename);

            // Clean up: delete the temporary file
            unlink($filename);
    
}

public function downloadchallanform($id){

    $getChallanformdetailsforInvoice = $this->admin_model->getChallanformdetailsforInvoice($id);
    $getChallanformditemdeatilsForInvoice = $this->admin_model->getChallanformditemdeatilsForInvoice($id);

   
    $CartItem = "";
    $supplierItem = "";
    $i =1;
    $ii =1;
    $subtotal = 0;

    $raw_material_cost = 0;
    $cgst_tax_rate = 0;
    $sgst_tax_rate = 0;
    $igst_tax_rate = 0;
    $gst_rate ='';

    $item_count =count($getChallanformditemdeatilsForInvoice);

    if($item_count==1){
        $padding_bottom = '200px';
    }else if($item_count==2){
        $padding_bottom = '40px';
    }else if($item_count==3){
        $padding_bottom = '10px';
    }else{
        $padding_bottom = '10px';
    }


    if($getChallanformdetailsforInvoice['usp_id']){
        $to_data = ' <td width="50%" style="padding-left: 15px;">
                        <div>
                            <p>To,</p>
                            <p><b>'.$getChallanformdetailsforInvoice['usp_name'].'</b></p>
                            <p>'.$getChallanformdetailsforInvoice['usp_addess'].'</p>
                            <p><b>Contact No:</b> '.$getChallanformdetailsforInvoice['usp_mobile'].' / '.$getChallanformdetailsforInvoice['usp_landline'].'</p>
                            <p><b>Contact Person:</b> '.$getChallanformdetailsforInvoice['contact_person'].'</p>
                            <p><b>Email:</b> '.$getChallanformdetailsforInvoice['usp_email'].'</p>
                            <p style="color:red">GSTIN:'.$getChallanformdetailsforInvoice['usp_GSTIN'].'</p>
                        <div>    
                    </td> ';
          
        $pdf_name = $getChallanformdetailsforInvoice['usp_name'];
                    

    }else{

        $to_data = ' <td width="50%" style="padding-left: 15px;">
                        <div>
                            <p>To,</p>
                            <p><b>'.$getChallanformdetailsforInvoice['supplier_name'].'</b></p>
                            <p>'.$getChallanformdetailsforInvoice['supplier_addess'].'</p>
                            <p><b>Contact No:</b> '.$getChallanformdetailsforInvoice['mobile'].' / '.$getChallanformdetailsforInvoice['suplier_landline'].'</p>
                            <p><b>Contact Person:</b> '.$getChallanformdetailsforInvoice['usp_conatct'].'</p>
                            <p><b>Email:</b> '.$getChallanformdetailsforInvoice['sup_email'].'</p>
                            <p style="color:red">GSTIN:'.$getChallanformdetailsforInvoice['sup_GSTIN'].'</p>
                        <div>    
                    </td> ';
                    $pdf_name = $getChallanformdetailsforInvoice['supplier_name'];
    }


    
    foreach ($getChallanformditemdeatilsForInvoice as $key => $value) {
        $CartItem .= '
                <tr style="border-left: 1px solid black;border-right: 1px solid black;">
                    <td style="border-left: 1px solid black;border-right: 1px solid black;text-align:left;padding: 10px;" valign="top">'.$ii.'</td>
                    <td style="border-left: 1px solid black;border-right: 1px solid black;text-align:left;padding: 10px;" valign="top">'.$value['type_of_raw_material'].'</br></td> 
                    <td style="border-left: 1px solid black;border-right: 1px solid black;text-align:left;padding: 10px;" valign="top">'.$value['part_number'].'</td>
                    <td style="border-left: 1px solid black;border-right: 1px solid black;text-align:left;padding: 10px;" valign="top">'.$value['type_of_raw_material'].'</td>
                    <td style="border-left: 1px solid black;border-right: 1px solid black;text-align:left;padding: 10px;" valign="top">'.$value['type_of_raw_platting'].'</td> 
                    <td style="border-left: 1px solid black;border-right: 1px solid black;text-align:left;padding: 10px;" valign="top">'.trim($value['qty']).'</td>    
                    <td style="border-left: 1px solid black;border-right: 1px solid black;text-align:left;padding: 10px;" valign="top">'.$value['value'].'/-'.'</td>
                </tr>';
                $subtotal+=$value['value'];
                $raw_material_cost +=$value['row_material_cost'];
                $grand_total +=$value['grand_total'];
                $gst_rate = $value['gst_rate'];

                if($value['gst_rate']=='CGST_SGST'){
                    $cgst_tax_rate = 9;
                    $sgst_tax_rate = 9;

                    $cgst_tax_value = $value['gst_value']/2;
                    $sgst_tax_value = $value['gst_value']/2;

                }else if($value['gst_rate']=='CGST_SGST_6'){
                    $cgst_tax_rate = 6;
                    $sgst_tax_rate = 6;

                    $cgst_tax_value = $value['gst_value']/2;
                    $sgst_tax_value = $value['gst_value']/2;

                }else if($value['gst_rate']=='IGST'){
                    $igst_tax_rate = 18;
                    $igst_tax_value = $value['gst_value'];
                }else if($value['gst_rate']=='IGST_12'){
                    $igst_tax_rate = 12;
                    $igst_tax_value = $value['gst_value'];

                }

            $ii++;       
    }

    $space = '<tr>
        <td style="padding-bottom: '.$padding_bottom.';border-left: 1px solid black;border-right: 1px solid black;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </td>
        <td style="padding-bottom: '.$padding_bottom.';border-left: 1px solid black;border-right: 1px solid black;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </td>
        <td style="padding-bottom: '.$padding_bottom.';border-left: 1px solid black;border-right: 1px solid black;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </td>
        <td style="padding-bottom: '.$padding_bottom.';border-left: 1px solid black;border-right: 1px solid black;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </td>
        <td style="padding-bottom: '.$padding_bottom.';border-left: 1px solid black;border-right: 1px solid black;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </td>
        <td style="padding-bottom: '.$padding_bottom.';border-left: 1px solid black;border-right: 1px solid black;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </td>
        <td style="padding-bottom: '.$padding_bottom.';border-left: 1px solid black;border-right: 1px solid black;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </td>
    </tr>';


     if($gst_rate=='CGST_SGST' || $gst_rate=='CGST_SGST_6'){
        $tax_value = '<tr style="border: 1px solid black;">               
            <td colspan="6"  style="text-align: right;border: 1px solid black;padding-left: 10px;padding-right: 5px;font-family:cambria;font-size:14px;"><b>(+) '.$cgst_tax_rate.' CGST </b></td>    
                <td style="border: 1px solid black;padding-left: 10px;">'.$cgst_tax_value.'</td>
            </tr>

            <tr style="border: 1px solid black;">

                <td colspan="6"  style="text-align: right;border: 1px solid black;padding-left: 10px;padding-right: 5px;font-family:cambria;font-size:14px;"><b>(+) '.$sgst_tax_rate.' SGST </b></td>    
                <td style="border: 1px solid black;padding-left: 10px;">'.$sgst_tax_value.'</td>
            </tr>';
     }else{
        $tax_value = '
            <tr style="border: 1px solid black;">
                <td colspan="6"  style="text-align: right;border: 1px solid black;padding-left: 10px;padding-right: 5px;font-family:cambria;font-size:14px;"><b>(+) '.$igst_tax_rate.' IGST </b></td>    
                <td style="border: 1px solid black;padding-left: 10px;">'.$igst_tax_value.'</td>
            </tr>';
     }

  
    $mpdf = new \Mpdf\Mpdf();
    // $html = $this->load->view('html_to_pdf',[],true);
    $html = '<table style=" width: 100%;text-align: center;border-collapse: collapse;border: #cccccc 0px solid;font-family:cambria;">
                <tr>
                  <td rowspan="2"><img src="'.base_url().'assets/images/supra_logo_1.jpg" width="80" height="80"></td>
                  <td style="color:#000080"><h2>SUPRA QUALITY EXPORTS (I) PVT. LTD</h2></td>
                  <td rowspan="2"><img src="'.base_url().'assets/images/logo_2.png"width="80" height="80"></td>
                </tr>
                <tr>
                  <td style="font-weight: bold;">
                    <p>MANUFACTURER & EXPORTERS OF:</p>
                    <p>PRECISION TURNED COMPONENTS, STAMPED /PRESSED PARTS IN FERROUS & NON-FERROUS METAL</p>
                    <p>MOULDED & EXTRUDED PLASTIC AND RUBBER COMPONENTS</p> 
                  </td>
                </tr>
            </table>
            <hr>
            <table style="width: 100%;text-align: left;border-collapse: collapse;border: #ccc 0px solid;font-family:cambria;">
                    <tr>
                        <td width="60%">
                          <p><b>Office:</b> 229 to 232, Bharat Industrial Estate,
                          <p> L.B.S. Marg, Bhandup West, Mumbai – 400078. INDIA.</b>
                          <p>Tel: +91 22 66959505 / +91 22 66600196 </p>
                          <p>+91 22 62390222 / +91 22 46061497 / +91 22 35115396 </p>
                          <p style="color:#206a9b"><b>GSTIN : 27AAJCS7869M1ZB </b></p>
                        </td>
                        <td width="40%">
                            <p><b>Email:</b></p> 
                            <p style="color:#206a9b">purchase@supraexports.in</p>
                            <p style="color:#206a9b">purchase1@supraexports.in</p>
                            <p style="color:#206a9b">purchase2@supraexports.in</p>
                        </td>  
                    </tr>
            </table>

            <table style=" width: 100%;text-align: center;border-collapse: collapse;border: #ccc 0px solid;margin-top:10px;margin-bottom:10px;font-family:cambria;">
                    <tr>
                        <td style="color:red;font-size:15px">
                          <u><p><h3>CHALLAN</h3></p>
                        </td>
                    </tr>
            </table>

            <table style=" width: 100%;text-align: left;border-collapse: collapse;font-family:cambria;font-size:13px;border: #ccc 1px solid">
                <tr style="border: 1px solid black;">
                   '.$to_data.'
                    <td style="border-left: 1px solid black;padding-left: 15px;font-size:13px;" width="50%" valign="top">
                        <div>
                            <p><b></b>'. str_repeat('&nbsp;', 5).'<span style="color:red"></span></p>
                            <p><b>CHALLAN NO :</b> '.'<span style="color:red">'.$getChallanformdetailsforInvoice['rrchallaon'].'</span></p>
                            <p>&nbsp;</p>
                            <p><b>CHALLAN DATE :</b> '.date('d-m-Y',strtotime($getChallanformdetailsforInvoice['challan_date'])).'</p>
                            <p>&nbsp;</p>
                        </div>
                    </td>
                </tr>
            </table>


            <table style=" width: 100%;text-align: left;border-collapse: collapse;border: #ccc 1px solid;margin-top:10px;margin-bottom:10px;font-family:cambria;font-size:12px">
                <tr style="border: 1px solid black;">
                    <th align="left" style="border: 1px solid black;text-align:center;" margin-bottom: 10%; width="10%">SR.NO.</th>
                    <th align="left" style="border: 1px solid black;text-align:center;" margin-bottom: 10%; width="30%">F.G. PART DESCRIPTION</th>
                    <th align="left" style="border: 1px solid black;text-align:center;" margin-bottom: 10%; width="20%">F.G. PART NO</th>  
                    <th align="left" style="border: 1px solid black;text-align:center;" margin-bottom: 10%; width="10%">RM TYPE</th> 
                    <th align="left" style="border: 1px solid black;text-align:center;" margin-bottom: 10%; width="10%">PROCESS</th>  
                    <th align="left" style="border: 1px solid black;text-align:center;" margin-bottom: 10%; width="10%">QTY IN PCS</th>  
                    <th align="left" style="border: 1px solid black;text-align:center;" margin-bottom: 10%; width="10%">AMOUNT</th>
                </tr>
                '.$CartItem.$space.' 

            <tr style="border: 1px solid black;">               
                <td colspan="6"  style="text-align: right;border: 1px solid black;padding-left: 10px;padding-right: 5px;font-family:cambria;font-size:14px;"><b>Total Raw Material Cost </b></td>    
                <td style="border: 1px solid black;padding-left: 10px;">'. $raw_material_cost.'</td>
            </tr>
             '. $tax_value.'
            

            <tr style="border: 1px solid black;">
                    <td colspan="6"  style="text-align: right;border: 1px solid black;padding-left: 10px;padding-right: 5px;font-family:cambria;font-size:14px;"><b>TOTAL</b></td>    
                    <td style="border: 1px solid black;padding-left: 10px;">'.$grand_total.'/-'.'</td>
              </tr>
          
            </table>

            <table style=" width: 100%;border-collapse: collapse;border: #ccc 1px solid;font-family:cambria;font-size:12px">
                <tr style="border: 1px solid black;">
                        <td style="border: 1px solid black;padding-left: 10px;">
                            <p><b>Remark :</b>'.$getChallanformdetailsforInvoice['supplier_remark'].'</p>    
                    </td>   
                </tr>
            </table>

            <table style=" width: 100%;text-align: left;border-collapse: collapse;border: #ccc 1px solid;margin-top:10px;margin-bottom:10px;font-family:cambria;font-size:12px">
                  
                   <tr style="border: 1px solid black;">
                        <td style="border: 1px solid black;padding-left: 10px;" width="75%;" valign="top">
                            <div style="margin-bottom:10px;">
                                <p><b>Received the above-mentioned goods in good order & condition & 
                                returned the Duplicate Duty sealed & signed.</b></p>
                            </div>
                            <br>

                           
                            <p><b>Dispatched By: </b>'.$getChallanformdetailsforInvoice['dispatched_by'].'</p>
                            <p><b>No.of Bags/ Boxes/ Goni: </b>'.$getChallanformdetailsforInvoice['no_of_bags_boxs_goni'].'</p>
                            <p><b>Total Gross Weight: </b>'.$getChallanformdetailsforInvoice['total_gross_weight_in_kgs'].'</p>
                            <p><b>Total Net Weight: </b>'.$getChallanformdetailsforInvoice['total_netweight_in_kgs'].'</p>
                          
                        </td>
                        <td style="border: 1px solid black;text-align: center;" width="25%" valign="top">
                            <p style="vertical-align: text-top;font-size:12px;color:#206a9b"><b>FOR SUPRA QUALITY EXPORTS (I) PVT. LTD.</b></p>
                            <br/><img src="'.base_url().'assets/images/stmps/rr_challan.png" width="130" height="100">
                            <p style="vertical-align: text-top;font-size:10px;color:#206a9b"><b>AUTHORIZED SIGNATORY</b></p>
                        </td> 
                </tr>
            </table>';

            // <p>FOR SUPRA QUALITY EXPORTS (I) PVT. LTD.</p>
    $invoice_name =  $getChallanformdetailsforInvoice['rrchallaon'].' - '.$pdf_name.'.pdf';
    $mpdf->WriteHTML($html);
    $mpdf->Output($invoice_name,'D'); // opens in browser

}

public function downloadchallanformvendor($id){

    $getChallanformdetailsforInvoice = $this->admin_model->getchallanformInvoicevendor($id);
    $getChallanformditemdeatilsForInvoice = $this->admin_model->getchallanformeatilsForInvoicevendor($id);

   
    $CartItem = "";
    $supplierItem = "";
    $i =1;
    $ii =1;
    $subtotal = 0;

    $raw_material_cost = 0;
    $cgst_tax_rate = 0;
    $sgst_tax_rate = 0;
    $igst_tax_rate = 0;
    $gst_rate ='';

    $item_count =count($getChallanformditemdeatilsForInvoice);

    if($item_count==1){
        $padding_bottom = '200px';
    }else if($item_count==2){
        $padding_bottom = '40px';
    }else if($item_count==3){
        $padding_bottom = '10px';
    }else{
        $padding_bottom = '10px';
    }


    if($getChallanformdetailsforInvoice['usp_id']){
                    $to_data = ' <td width="50%" style="padding-left: 15px;">
                        <div>
                            <p>To,</p>
                            <p><b>'.$getChallanformdetailsforInvoice['usp_name'].'</b></p>
                            <p>'.$getChallanformdetailsforInvoice['usp_addess'].'</p>
                            <p><b>Contact No:</b> '.$getChallanformdetailsforInvoice['usp_mobile'].' / '.$getChallanformdetailsforInvoice['usp_landline'].'</p>
                            <p><b>Contact Person:</b> '.$getChallanformdetailsforInvoice['usp_conatct'].'</p>
                            <p><b>Email:</b> '.$getChallanformdetailsforInvoice['usp_email'].'</p>
                            <p style="color:red">GSTIN:'.$getChallanformdetailsforInvoice['usp_GSTIN'].'</p>
                        <div>    
                    </td> ';
          
        $pdf_name = $getChallanformdetailsforInvoice['usp_name'];
    }else{

                    $to_data = ' <td width="50%" style="padding-left: 15px;">
                        <div>
                            <p>To,</p>
                            <p><b>'.$getChallanformdetailsforInvoice['vendor_name'].'</b></p>
                            <p>'.$getChallanformdetailsforInvoice['ven_address'].'</p>
                            <p><b>Contact No:</b> '.$getChallanformdetailsforInvoice['ven_mobile'].' / '.$getChallanformdetailsforInvoice['ven_landline'].'</p>
                            <p><b>Contact Person:</b> '.$getChallanformdetailsforInvoice['ven_contact_person'].'</p>
                            <p><b>Email:</b> '.$getChallanformdetailsforInvoice['ven_email'].'</p>
                            <p style="color:red">GSTIN:'.$getChallanformdetailsforInvoice['ven_GSTIN'].'</p>
                        <div>    
                    </td> ';
                    $pdf_name = $getChallanformdetailsforInvoice['vendor_name'];
    }

    foreach ($getChallanformditemdeatilsForInvoice as $key => $value) {
        $CartItem .= '
                <tr style="border-left: 1px solid black;border-right: 1px solid black;">
                    <td style="border-left: 1px solid black;border-right: 1px solid black;text-align:left;padding: 10px;" valign="top">'.$ii.'</td>
                    <td style="border-left: 1px solid black;border-right: 1px solid black;text-align:left;padding: 10px;" valign="top">'.$value['name'].'</br></td> 
                    <td style="border-left: 1px solid black;border-right: 1px solid black;text-align:left;padding: 10px;" valign="top">'.$value['fg_part'].'</td>
                    <td style="border-left: 1px solid black;border-right: 1px solid black;text-align:left;padding: 10px;" valign="top">'.$value['type_of_raw_material'].'</td>
                    <td style="border-left: 1px solid black;border-right: 1px solid black;text-align:left;padding: 10px;" valign="top">'.$value['type_of_raw_platting'].'</td> 
                    <td style="border-left: 1px solid black;border-right: 1px solid black;text-align:left;padding: 10px;" valign="top">'.$value['qty'].'</td>    
                    <td style="border-left: 1px solid black;border-right: 1px solid black;text-align:left;padding: 10px;" valign="top">'.$value['value'].'/-'.'</td>
                </tr>';
                $subtotal+=$value['value'];
                $raw_material_cost +=$value['row_material_cost'];
                $grand_total +=$value['grand_total'];
                $gst_rate = $value['gst_rate'];

                if($value['gst_rate']=='CGST_SGST'){
                    $cgst_tax_rate = 9;
                    $sgst_tax_rate = 9;

                    $cgst_tax_value = $value['gst_value']/2;
                    $sgst_tax_value = $value['gst_value']/2;

                }else if($value['gst_rate']=='CGST_SGST_6'){
                    $cgst_tax_rate = 6;
                    $sgst_tax_rate = 6;

                    $cgst_tax_value = $value['gst_value']/2;
                    $sgst_tax_value = $value['gst_value']/2;

                }else if($value['gst_rate']=='IGST'){
                    $igst_tax_rate = 18;
                    $igst_tax_value = $value['gst_value'];
                }else if($value['gst_rate']=='IGST_12'){
                    $igst_tax_rate = 12;
                    $igst_tax_value = $value['gst_value'];

                }

            $ii++;       
    }

    $space = '<tr>
        <td style="padding-bottom: '.$padding_bottom.';border-left: 1px solid black;border-right: 1px solid black;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </td>
        <td style="padding-bottom: '.$padding_bottom.';border-left: 1px solid black;border-right: 1px solid black;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </td>
        <td style="padding-bottom: '.$padding_bottom.';border-left: 1px solid black;border-right: 1px solid black;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </td>
        <td style="padding-bottom: '.$padding_bottom.';border-left: 1px solid black;border-right: 1px solid black;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </td>
        <td style="padding-bottom: '.$padding_bottom.';border-left: 1px solid black;border-right: 1px solid black;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </td>
        <td style="padding-bottom: '.$padding_bottom.';border-left: 1px solid black;border-right: 1px solid black;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </td>
        <td style="padding-bottom: '.$padding_bottom.';border-left: 1px solid black;border-right: 1px solid black;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </td>
    </tr>';


     if($gst_rate=='CGST_SGST' || $gst_rate=='CGST_SGST_6'){
        $tax_value = '<tr style="border: 1px solid black;">               
            <td colspan="6"  style="text-align: right;border: 1px solid black;padding-left: 10px;padding-right: 5px;font-family:cambria;font-size:14px;"><b>(+) '.$cgst_tax_rate.' CGST </b></td>    
                <td style="border: 1px solid black;padding-left: 10px;">'.$cgst_tax_value.'</td>
            </tr>

            <tr style="border: 1px solid black;">

                <td colspan="6"  style="text-align: right;border: 1px solid black;padding-left: 10px;padding-right: 5px;font-family:cambria;font-size:14px;"><b>(+) '.$sgst_tax_rate.' SGST </b></td>    
                <td style="border: 1px solid black;padding-left: 10px;">'.$sgst_tax_value.'</td>
            </tr>';
     }else{
        $tax_value = '
            <tr style="border: 1px solid black;">
                <td colspan="6"  style="text-align: right;border: 1px solid black;padding-left: 10px;padding-right: 5px;font-family:cambria;font-size:14px;"><b>(+) '.$igst_tax_rate.' IGST </b></td>    
                <td style="border: 1px solid black;padding-left: 10px;">'.$igst_tax_value.'</td>
            </tr>';
     }

  
    $mpdf = new \Mpdf\Mpdf();
    // $html = $this->load->view('html_to_pdf',[],true);
    $html = '<table style=" width: 100%;text-align: center;border-collapse: collapse;border: #cccccc 0px solid;font-family:cambria;">
                <tr>
                  <td rowspan="2"><img src="'.base_url().'assets/images/supra_logo_1.jpg" width="80" height="80"></td>
                  <td style="color:#000080"><h2>SUPRA QUALITY EXPORTS (I) PVT. LTD</h2></td>
                  <td rowspan="2"><img src="'.base_url().'assets/images/logo_2.png"width="80" height="80"></td>
                </tr>
                <tr>
                  <td style="font-weight: bold;">
                    <p>MANUFACTURER & EXPORTERS OF:</p>
                    <p>PRECISION TURNED COMPONENTS, STAMPED /PRESSED PARTS IN FERROUS & NON-FERROUS METAL</p>
                    <p>MOULDED & EXTRUDED PLASTIC AND RUBBER COMPONENTS</p> 
                  </td>
                </tr>
            </table>
            <hr>
            <table style="width: 100%;text-align: left;border-collapse: collapse;border: #ccc 0px solid;font-family:cambria;">
                    <tr>
                        <td width="60%">
                          <p><b>Office:</b> 229 to 232, Bharat Industrial Estate,
                          <p> L.B.S. Marg, Bhandup West, Mumbai – 400078. INDIA.</b>
                          <p>Tel: +91 22 66959505 / +91 22 66600196 </p>
                          <p>+91 22 62390222 / +91 22 46061497 / +91 22 35115396 </p>
                          <p style="color:#206a9b"><b>GSTIN : 27AAJCS7869M1ZB </b></p>
                        </td>
                        <td width="40%">
                            <p><b>Email:</b></p> 
                            <p style="color:#206a9b">purchase@supraexports.in</p>
                            <p style="color:#206a9b">purchase1@supraexports.in</p>
                            <p style="color:#206a9b">purchase2@supraexports.in</p>
                        </td>  
                    </tr>
            </table>

            <table style=" width: 100%;text-align: center;border-collapse: collapse;border: #ccc 0px solid;margin-top:10px;margin-bottom:10px;font-family:cambria;">
                    <tr>
                        <td style="color:red;font-size:15px">
                          <u><p><h3>CHALLAN</h3></p>
                        </td>
                    </tr>
            </table>

            <table style=" width: 100%;text-align: left;border-collapse: collapse;font-family:cambria;font-size:13px;border: #ccc 1px solid">
                <tr style="border: 1px solid black;">
                   '.$to_data.'
                    <td style="border-left: 1px solid black;padding-left: 15px;font-size:13px;" width="50%" valign="top">
                        <div>
                            <p><b></b>'. str_repeat('&nbsp;', 5).'<span style="color:red"></span></p>
                            <p><b>CHALLAN NO :</b> '.'<span style="color:red">'.$getChallanformdetailsforInvoice['rrchallaon'].'</span></p>
                            <p>&nbsp;</p>
                            <p><b>CHALLAN DATE :</b> '.date('d-m-Y',strtotime($getChallanformdetailsforInvoice['challan_date'])).'</p>
                            <p>&nbsp;</p>
                        </div>
                    </td>
                </tr>
            </table>


            <table style=" width: 100%;text-align: left;border-collapse: collapse;border: #ccc 1px solid;margin-top:10px;margin-bottom:10px;font-family:cambria;font-size:12px">
                <tr style="border: 1px solid black;">
                    <th align="left" style="border: 1px solid black;text-align:center;" margin-bottom: 10%; width="10%">SR.NO.</th>
                    <th align="left" style="border: 1px solid black;text-align:center;" margin-bottom: 10%; width="35%">F.G. PART DESCRIPTION</th>
                    <th align="left" style="border: 1px solid black;text-align:center;" margin-bottom: 10%; width="10%">F.G. PART NO</th>  
                    <th align="left" style="border: 1px solid black;text-align:center;" margin-bottom: 10%; width="15%">RM TYPE</th> 
                    <th align="left" style="border: 1px solid black;text-align:center;" margin-bottom: 10%; width="10%">PROCESS</th>  
                    <th align="left" style="border: 1px solid black;text-align:center;" margin-bottom: 10%; width="10%">QTY IN PCS</th>  
                    <th align="left" style="border: 1px solid black;text-align:center;" margin-bottom: 10%; width="10%">AMOUNT</th>
                </tr>
                '.$CartItem.$space.' 

                <tr style="border: 1px solid black;">               
                <td colspan="6"  style="text-align: right;border: 1px solid black;padding-left: 10px;padding-right: 5px;font-family:cambria;font-size:14px;"><b>Total Raw Material Cost </b></td>    
                <td style="border: 1px solid black;padding-left: 10px;">'. $raw_material_cost.'</td>
            </tr>
             '. $tax_value.'
            

            <tr style="border: 1px solid black;">
                    <td colspan="6"  style="text-align: right;border: 1px solid black;padding-left: 10px;padding-right: 5px;font-family:cambria;font-size:14px;"><b>TOTAL</b></td>    
                    <td style="border: 1px solid black;padding-left: 10px;">'.$grand_total.'/-'.'</td>
              </tr>
          
            </table>

            <table style=" width: 100%;border-collapse: collapse;border: #ccc 1px solid;font-family:cambria;font-size:12px">
                <tr style="border: 1px solid black;">
                        <td style="border: 1px solid black;padding-left: 10px;">
                            <p><b>Remark :</b>'.$getChallanformdetailsforInvoice['supplier_remark'].'</p>    
                    </td>   
                </tr>
            </table>

            <table style=" width: 100%;text-align: left;border-collapse: collapse;border: #ccc 1px solid;margin-top:10px;margin-bottom:10px;font-family:cambria;font-size:12px">
                  
                   <tr style="border: 1px solid black;">
                        <td style="border: 1px solid black;padding-left: 10px;" width="75%;" valign="top">
                            <div style="margin-bottom:10px;">
                                <p><b>Received the above-mentioned goods in good order & condition & 
                                returned the Duplicate Duty sealed & signed.</b></p>
                            </div>
                            <br>

                            <p><b>Dispatched By:</b> '.$getChallanformdetailsforInvoice['dispatched_by'].'</p>
                            <p><b>No.of Bags/ Boxes/ Goni:</b> '.$getChallanformdetailsforInvoice['no_of_bags_boxs_goni'].'</p>
                            <p><b>Total Gross Weight:</b> '.$getChallanformdetailsforInvoice['total_gross_weight_in_kgs'].'</p>
                            <p><b>Total Net Weight:</b> '.$getChallanformdetailsforInvoice['total_netweight_in_kgs'].'</p>
                          
                        </td>
                        <td style="border: 1px solid black;text-align: center;" width="25%" valign="top">
                            <p style="vertical-align: text-top;font-size:12px;color:#206a9b"><b>FOR SUPRA QUALITY EXPORTS (I) PVT. LTD.</b></p>
                            <br/><img src="'.base_url().'assets/images/stmps/rr_challan.png" width="130" height="100">
                            <p style="vertical-align: text-top;font-size:10px;color:#206a9b"><b>AUTHORIZED SIGNATORY</b></p>
                        </td> 
                </tr>
            </table>';

            // <p>FOR SUPRA QUALITY EXPORTS (I) PVT. LTD.</p>
    $invoice_name =  $getChallanformdetailsforInvoice['rrchallaon'].' - '.$pdf_name.'.pdf';
    $mpdf->WriteHTML($html);
    $mpdf->Output($invoice_name,'D'); // opens in browser
}

public function downlaodjobworkchllan($id){

    $getJobworkchallandetailsForInvoice = $this->admin_model->getJobworkchallandetailsForInvoice($id);
    $getJobworkchallanItemdeatilsForInvoice = $this->admin_model->getJobworkchallanItemdeatilsForInvoice($id);

    $CartItem = "";
    $i =1;
    $subtotal = 0;


    $packing_forwarding = 0;
    $cgst_tax_rate = 0;
    $sgst_tax_rate = 0;
    $igst_tax_rate = 0;
    $gst_rate ='';

    $item_count =count($getJobworkchallanItemdeatilsForInvoice);

    if($item_count==1){
        $padding_bottom = '150px';
    }else if($item_count==2){
        $padding_bottom = '28px';
    }else if($item_count==3){
        $padding_bottom = '10px';
    }else{
        $padding_bottom = '10px';
    }

    foreach ($getJobworkchallanItemdeatilsForInvoice as $key => $value) {
        $CartItem .= '
                <tr style="style=border-left: 1px solid black;border-right: 1px solid black;">
                    <td style="border-left: 1px solid black;border-right: 1px solid black;text-align:left;padding: 10px;" valign="top">'.$i.'</td>
                    <td style="border-left: 1px solid black;border-right: 1px solid black;text-align:left;padding: 10px;" valign="top"> Material Description : '.$value['type_of_raw_material'].'<br/>For Part No : '.$value['part_number'].'-'.$value['fg_description'].'<br/>Vendor Qty : '.$value['vendor_qty'].' pcs <br/>HSN Code :' .$value['HSN_code'].'<br/></td>   
                    <td style="border-left: 1px solid black;border-right: 1px solid black;text-align:left;padding: 10px;" valign="top">'.$value['part_number'].'</td>
                    <td style="border-left: 1px solid black;border-right: 1px solid black;text-align:left;padding: 10px;" valign="top">'.$value['rm_qty'].' '.$value['unit'].'</td>
                    <td style="border-left: 1px solid black;border-right: 1px solid black;text-align:left;padding: 10px;" valign="top">'.$value['rm_qty'] * $value['ram_rate'].'</td> 
                </tr>';


                $subtotal+=$value['value'];
                $packing_forwarding +=$value['packing_forwarding'];
                $grand_total +=$value['grand_total'];
                $gst_rate = $value['gst_rate'];

                if($value['gst_rate']=='CGST_SGST'){
                    $cgst_tax_rate = 9;
                    $sgst_tax_rate = 9;

                    $cgst_tax_value = $value['gst']/2;
                    $sgst_tax_value = $value['gst']/2;

                }else if($value['gst_rate']=='CGST_SGST_6'){
                    $cgst_tax_rate = 6;
                    $sgst_tax_rate = 6;

                    $cgst_tax_value = $value['gst']/2;
                    $sgst_tax_value = $value['gst']/2;

                }else if($value['gst_rate']=='IGST'){
                    $igst_tax_rate = 18;
                    $igst_tax_value = $value['gst'];
                }else if($value['gst_rate']=='IGST_12'){
                    $igst_tax_rate = 12;
                    $igst_tax_value = $value['gst'];

                }

            $i++;
    }

    $space = '<tr>
        <td style="padding-bottom: '.$padding_bottom.';border-left: 1px solid black;border-right: 1px solid black;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </td>
        <td style="padding-bottom: '.$padding_bottom.';border-left: 1px solid black;border-right: 1px solid black;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </td>
        <td style="padding-bottom: '.$padding_bottom.';border-left: 1px solid black;border-right: 1px solid black;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </td>
        <td style="padding-bottom: '.$padding_bottom.';border-left: 1px solid black;border-right: 1px solid black;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </td>
        <td style="padding-bottom: '.$padding_bottom.';border-left: 1px solid black;border-right: 1px solid black;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </td>
    </tr>';


    if($gst_rate=='CGST_SGST' || $gst_rate=='CGST_SGST_6'){
        $tax_value = '<tr style="border: 1px solid black;">               
            <td colspan="4"  style="text-align: right;border: 1px solid black;padding-left: 10px;padding-right: 5px;font-family:cambria;font-size:14px;"><b>(+) '.$cgst_tax_rate.' % CGST </b></td>    
                <td style="border: 1px solid black;padding-left: 10px;">'.$cgst_tax_value.'</td>
            </tr>

            <tr style="border: 1px solid black;">

                <td colspan="4"  style="text-align: right;border: 1px solid black;padding-left: 10px;padding-right: 5px;font-family:cambria;font-size:14px;"><b>(+) '.$sgst_tax_rate.' % SGST </b></td>    
                <td style="border: 1px solid black;padding-left: 10px;">'.$sgst_tax_value.'</td>
            </tr>';
     }else{
        $tax_value = '
            <tr style="border: 1px solid black;">
                <td colspan="4"  style="text-align: right;border: 1px solid black;padding-left: 10px;padding-right: 5px;font-family:cambria;font-size:14px;"><b>(+) '.$igst_tax_rate.' % IGST </b></td>    
                <td style="border: 1px solid black;padding-left: 10px;">'.$igst_tax_value.'</td>
            </tr>';
     }

  

    $mpdf = new \Mpdf\Mpdf();
    // $html = $this->load->view('html_to_pdf',[],true);
    $html = '<table style=" width: 100%;text-align: center;border-collapse: collapse;border: #cccccc 0px solid;font-family:cambria;">
                <tr>
                  <td rowspan="2"><img src="'.base_url().'assets/images/supra_logo_1.jpg" width="80" height="80"></td>
                  <td style="color:#000080"><h2>SUPRA QUALITY EXPORTS (I) PVT. LTD</h2></td>
                  <td rowspan="2"><img src="'.base_url().'assets/images/logo_2.png"width="80" height="80"></td>
                </tr>
                <tr>
                  <td style="font-weight: bold;">
                    <p>MANUFACTURER & EXPORTERS OF:</p>
                    <p>PRECISION TURNED COMPONENTS, STAMPED /PRESSED PARTS IN FERROUS & NON-FERROUS METAL</p>
                    <p>MOULDED & EXTRUDED PLASTIC AND RUBBER COMPONENTS</p> 
                  </td>
                </tr>
            </table>
            <hr>
            <table style="width: 100%;text-align: left;border-collapse: collapse;border: #ccc 0px solid;font-family:cambria;">
                    <tr>
                        <td width="60%">
                          <p><b>Office:</b> 229 to 232, Bharat Industrial Estate,
                          <p> L.B.S. Marg, Bhandup West, Mumbai – 400078. INDIA.</b>
                          <p>Tel: +91 22 66959505 / +91 22 66600196 </p>
                          <p>+91 22 62390222 / +91 22 46061497 / +91 22 35115396 </p>
                          <p style="color:#206a9b"><b>GSTIN : 27AAJCS7869M1ZB </b></p>
                        </td>
                        <td width="40%">
                            <p><b>Email:</b></p> 
                            <p style="color:#206a9b">purchase@supraexports.in</p>
                            <p style="color:#206a9b">purchase1@supraexports.in</p>
                            <p style="color:#206a9b">purchase2@supraexports.in</p>
                        </td>  
                    </tr>
            </table>

            <table style=" width: 100%;text-align: center;border-collapse: collapse;border: #ccc 0px solid;margin-top:10px;margin-bottom:10px;font-family:cambria;">
                    <tr>
                        <td style="color:red;font-size:15px">
                          <u><p><h3>JOB WORK CHALLAN</h3></p>
                        </td>
                    </tr>
            </table>

            <table style=" width: 100%;text-align: left;border-collapse: collapse;font-family:cambria;font-size:13px;border: #ccc 1px solid">
                <tr style="border: 1px solid black;">
                    <td width="50%" style="padding-left: 15px;">
                        <div>
                            <p>To,</p>
                            <p><b>'.$getJobworkchallandetailsForInvoice['vendor_name'].'</b></p>
                            <p>'.$getJobworkchallandetailsForInvoice['ven_address'].'</p>
                            <p><b>Contact No:</b> '.$getJobworkchallandetailsForInvoice['ven_mobile'].' / '.$getJobworkchallandetailsForInvoice['ven_landline'].'</p>
                            <p><b>Contact Person:</b> '.$getJobworkchallandetailsForInvoice['ven_contact_person'].'</p>
                            <p><b>Email:</b> '.$getJobworkchallandetailsForInvoice['ven_email'].'</p>
                            <p style="color:red">GSTIN:'.$getJobworkchallandetailsForInvoice['ven_GSTIN'].'</p>
                        <div>    
                    </td> 
                    <td style="border-left: 1px solid black;padding-left: 15px;font-size:13px" width="50%" >
                        <div>
                            <p><b>CHALLAN NO :</b> '.'<span style="color:red">'.$getJobworkchallandetailsForInvoice['po_number'].'</span></p>
                            <p>&nbsp;</p>
                            <p><b>CHALLAN DATE :</b> '.date('d-m-Y',strtotime($getJobworkchallandetailsForInvoice['date'])).'</p>
                            <p>&nbsp;</p>
                            <p><b>P.O.NO :</b> '.$getJobworkchallandetailsForInvoice['ven_po_number'].'</p>
                            <p>&nbsp;</p>
                            <p><b>P.O.DATE :</b> '.date('d-m-Y',strtotime($getJobworkchallandetailsForInvoice['ven_date'])).'</p>
                        </div>
                    </td>
                </tr>
            </table>


            <table style=" width: 100%;text-align: left;border-collapse: collapse;border: #ccc 1px solid;margin-top:10px;margin-bottom:10px;font-family:cambria;font-size:12px">
                <tr style="border: 1px solid black;">
                    <th align="left" style="border: 1px solid black;text-align:center;" margin-bottom: 10%; width="10%">SR.NO.</th>
                    <th align="left" style="border: 1px solid black;text-align:center;" margin-bottom: 10%; width="10%">PART DESCRIPTION</th>
                    <th align="left" style="border: 1px solid black;text-align:center;" margin-bottom: 10%; width="10%">PART NO.</th>  
                    <th align="left" style="border: 1px solid black;text-align:center;" margin-bottom: 10%; width="10%">Raw Material Qty</th> 
                    <th align="left" style="border: 1px solid black;text-align:center;" margin-bottom: 10%; width="10%">Raw Material Value</th>  
                </tr>
                '.$CartItem.$space.' 

                <tr style="border: 1px solid black;">               
                    <td colspan="4"  style="text-align: right;border: 1px solid black;padding-left: 10px;padding-right: 5px;font-family:cambria;font-size:14px;"><b>Packing & Forwarding </b></td>    
                    <td style="border: 1px solid black;padding-left: 10px;">'. $packing_forwarding.'</td>
                </tr>
                '. $tax_value.'
            
                <tr style="border: 1px solid black;">
                        <td colspan="4"  style="text-align: right;border: 1px solid black;padding-left: 10px;padding-right: 5px;font-family:cambria;font-size:14px;"><b>GRAND TOTAL</b></td>    
                        <td style="border: 1px solid black;padding-left: 10px;">'.$grand_total.'/-'.'</td>
                </tr>
            </table>

            <table style=" width: 100%;text-align: left;border-collapse: collapse;border: #ccc 1px solid;margin-top:10px;margin-bottom:10px;font-family:cambria;font-size:12px">
                  
                   <tr style="border: 1px solid black;">
                        <td style="border: 1px solid black;padding-left: 10px;" width="75%;" valign="top">
                            <p><b>Remark :</b></p>
                            <p><b>'.$getJobworkchallandetailsForInvoice['ven_remark'].'</b></p>
                        </td>
                        <td style="border: 1px solid black;text-align: center;" width="25%" valign="top">
                            <p style="vertical-align: text-top;font-size:12px;color:#206a9b"><b>FOR SUPRA QUALITY EXPORTS (I) PVT. LTD.</b></p>
                            <br/><img src="'.base_url().'assets/images/stmps/supplierpostampsignature.png" width="130" height="100">
                            <p style="vertical-align: text-top;font-size:10px;color:#206a9b"><b>AUTHORIZED SIGNATORY</b></p>
                        </td> 
                </tr>
            </table>';

            // <p>FOR SUPRA QUALITY EXPORTS (I) PVT. LTD.</p>
    $invoice_name =  $getJobworkchallandetailsForInvoice['po_number'].' - '.$getJobworkchallandetailsForInvoice['vendor_name'].'.pdf';
    $mpdf->WriteHTML($html);
    $mpdf->Output($invoice_name,'D'); // opens in browser
    
}

public function downloadscrapreturn($id){

    $getscrapreturnForInvoice = $this->admin_model->getscrapreturnForInvoice($id);
    $getscrapreturnItemdeatilsForInvoice = $this->admin_model->getscrapreturnItemdeatilsForInvoice($id);

    $mpdf = new \Mpdf\Mpdf();
    // $html = $this->load->view('html_to_pdf',[],true);
    $html = '<table style=" width: 100%;border-collapse: collapse;border: #cccccc 0px solid;font-family:Times New Roman;font-size:13px">
                <tr style="border: 1px solid black;" valign="top">
                    <td width="50%" style="padding: 10px;text-align: left;">
                        <p><h3 style="color:#000080">SUPRA QUALITY EXPORTS INDIA PVT LTD </h3></p>
                        <p>229 to 232, Bharat Industrial Estate,</p>
                        <p>L.B.S. Marg, Bhandup West, Mumbai – 400078. INDIA.</p>
                        <p></p>
                        <p></p>
                        <p><span style="color:#000080">GSTIN : 27AAJCS7869M1ZB</span></p>
                    </td> 

                    <td style="border-left: 1px solid black;padding: 10px;" width="50%" valign="top">
                          <p style="text-align: center"><h4>DELIVERY CHALLAN</h4></p>
                          <p style="text-align: left;"> Movement of inputs or partially processed goods
                            for job work under Rule 55 ofthe Central Goods
                            ‘8; Service Tax Rules.20l7. from one factory to
                            another factory for further processing / operation.
                          </p>
                    </td>
                </tr>
           
                <tr style="border: 1px solid black;padding: 10px;">
                    <td width="50%" style="padding: 10px;text-align: left;">
                       Sr. No. : <span style="color:red">'.$getscrapreturnForInvoice['challan_id'].'</span>
                    </td> 

                    <td style="border-left: 1px solid black;padding: 10px;" width="50%" valign="top">
                       <input type="checkbox" style="width: 100px;height: 100px;zoom:5;"> Original  <input type="checkbox"> Duplicate  <input type="checkbox"> Triplicate
                    </td>
                </tr>

                <tr style="border: 1px solid black;">
                    <td width="50%" style="padding: 10px;text-align: left;valign="top"">
                        <p>Part-I </p>
                        <p>'. str_repeat('&nbsp;', 5).'</p>
                        <p>'. str_repeat('&nbsp;', 5).'</p>
                        <p>'. str_repeat('&nbsp;', 5).'</p>
                        <p>'. str_repeat('&nbsp;', 5).'</p>
                    </td> 

                    <td style="border-left: 1px solid black;padding: 10px;" width="50%" valign="top">
                        <p>Part-II </p>
                        <p>to be filled by the processing factory in original and duplicate challans. </p>
                    </td>
                </tr>

                <tr style="border: 1px solid black;">
                    <td width="50%" style="padding: 10px;text-align: left;">
                         <p>1. Description </p>
                         <p>'.$getscrapreturnItemdeatilsForInvoice[0]['description'].'</p>
                    </td> 

                    <td style="border-left: 1px solid black;padding: 10px;" width="50%" valign="top">
                        <p>1. Details of type,qty, date & time of processing done and Return of processed goods to parent factory </p>
                    </td>
                </tr>

             
            </table>

            <table style=" width: 100%;border-collapse: collapse;border: #cccccc 0px solid;font-family:Times New Roman;font-size:13px;">
                
                <tr style="border-left: 1px solid black;border-right: 1px solid black;border-bottom: 1px solid black;">
                    <td style="text-align:left;padding: 10px;"          width="50%">2. Identification marks & number if any</td> 
                    <td style="border-left: 1px solid black;padding:10px;">Size / Type</td>
                    <td style="border-left: 1px solid black;padding: 10px;" >Quantity</td>
                    <td style="border-left: 1px solid black;padding: 10px;" >Date</td>
                    <td style="border-left: 1px solid black;padding: 10px;" >Time</td>
                </tr>

                <tr style="border-left: 1px solid black;border-right: 1px solid black;">
                    <td style="padding-left: 10px;text-align: left;"  width="50%">
                       <p> 3. Quantity (Nos. / Weight / Metre /Litre) </p>
                     </td> 
                    <td style="border-left: 1px solid black;padding-left: 10px;">1</td>
                    <td style="border-left: 1px solid black;padding-left: 10px;"></td>
                    <td style="border-left: 1px solid black;padding-left: 10px;"></td>
                    <td style="border-left: 1px solid black;padding-left: 10px;"></td>
                </tr>


                <tr style="border-left: 1px solid black;border-right: 1px solid black;">
                    <td style="padding-left: 10px;text-align: left;"  width="50%">
                       <p> Gross Weight: '.$getscrapreturnItemdeatilsForInvoice[0]['gross_weight'].' kgs </p>
                     </td> 
                    <td style="border-left: 1px solid black;padding-left: 10px;"></td>
                    <td style="border-left: 1px solid black;padding-left: 10px;"></td>
                    <td style="border-left: 1px solid black;padding-left: 10px;"></td>
                    <td style="border-left: 1px solid black;padding-left: 10px;"></td>
                </tr>


                <tr style="border-left: 1px solid black;border-right: 1px solid black;">
                    <td style="padding-left: 10px;text-align: left;"  width="50%">
                      <p> Net Weight:   '.$getscrapreturnItemdeatilsForInvoice[0]['net_weight'].' kgs </p>
                    </td> 
                    <td style="border-left: 1px solid black;padding-left: 10px;">2</td>
                    <td style="border-left: 1px solid black;padding-left: 10px;"></td>
                    <td style="border-left: 1px solid black;padding-left: 10px;"></td>
                    <td style="border-left: 1px solid black;padding-left: 10px;"></td>
                </tr>


                <tr style="border-left: 1px solid black;border-right: 1px solid black;">
                    <td style="padding-left: 10px;text-align: left;"  width="50%">
                    <p> Quantity:   '.$getscrapreturnItemdeatilsForInvoice[0]['quantity'].' </p>
                    </td> 
                    <td style="border-left: 1px solid black;padding-left: 10px;"></td>
                    <td style="border-left: 1px solid black;padding-left: 10px;"></td>
                    <td style="border-left: 1px solid black;padding-left: 10px;"></td>
                    <td style="border-left: 1px solid black;padding-left: 10px;"></td>
                </tr>


                <tr style="border-left: 1px solid black;border-right: 1px solid black;">
                        <td style="text-align: left;border-right: 1px solid black;border-bottom: 1px solid black"  width="50%">
                         <p>'.str_repeat('&nbsp;', 1).' No. of Bags:  '.$getscrapreturnItemdeatilsForInvoice[0]['number_of_bags'].' </p>
                        </td> 
                        <hr style="margin-left: 10px;"></hr>
                        <td style="border-left: 1px solid black;padding-left: 10px;">3</td>
                        <td style="border-left: 1px solid black;padding-left: 10px;"></td>
                        <td style="border-left: 1px solid black;padding-left: 10px;"></td>
                        <td style="border-left: 1px solid black;padding-left: 10px;"></td>
                </tr>


                <tr style="border-left: 1px solid black;border-right: 1px solid black;">
                    <td style="text-align: left;border-right: 1px solid black;border-bottom: 1px solid black"  width="50%">
                       <p>'.str_repeat('&nbsp;', 1).' 4. HSN NO: '.$getscrapreturnItemdeatilsForInvoice[0]['hsn_code'].'  </p>
                    </td> 
                    <hr style="margin-left: 10px;"></hr>
                    <td style="border-left: 1px solid black;padding-left: 10px;">4</td>
                    <td style="border-left: 1px solid black;padding-left: 10px;"></td>
                    <td style="border-left: 1px solid black;padding-left: 10px;"></td>
                    <td style="border-left: 1px solid black;padding-left: 10px;"></td>
                </tr>


                <tr style="border-left: 1px solid black;border-right: 1px solid black;">
                    <td style="padding-left: 10px;text-align: left;border-right: 1px solid black"  width="50%">
                    <p> 5. Estimated Value of inputs / Partially processed inputs  </p>
                    <p>'.$getscrapreturnItemdeatilsForInvoice[0]['estimated_value'].'</p>
                   
                    </td> 
                    <td style="border-left: 1px solid black;padding-left: 10px;">5</td>
                    <td style="border-left: 1px solid black;padding-left: 10px;"></td>
                    <td style="border-left: 1px solid black;padding-left: 10px;"></td>
                    <td style="border-left: 1px solid black;padding-left: 10px;"></td>
                </tr>


                <tr style="border-left: 1px solid black;border-right: 1px solid black;">
                    <td style="padding-left: 10px;text-align: left;border-right: 1px solid black"  width="50%">
                    <p>  </p>
                    </td> 
                    <td style="border-left: 1px solid black;padding-left: 10px;">6</td>
                    <td style="border-left: 1px solid black;padding-left: 10px;"></td>
                    <td style="border-left: 1px solid black;padding-left: 10px;"></td>
                    <td style="border-left: 1px solid black;padding-left: 10px;"></td>
                </tr>
            </table>
            
            <table style=" width: 100%;border-collapse: collapse;border: #cccccc 0px solid;font-family:Times New Roman;font-size:13px;">

                <tr style="border: 1px solid black;">
                    <td width="50%" style="padding: 10px;text-align: left;">
                        <p>6.Date & Time of Issue : '.date('d-m-Y',strtotime($getscrapreturnForInvoice['challan_date'])).'</p>
                    </td> 

                    <td style="border-left: 1px solid black;padding: 10px;" width="50%" valign="top">
                        <p>2. Nature of Proc. / Manufacturing done</p>
                    </td>
                </tr>

                <tr style="border: 1px solid black;">
                    <td width="50%" style="padding: 10px;text-align: left;">
                        <p>7. Nature of processing: '.$getscrapreturnItemdeatilsForInvoice[0]['number_of_processing'].'</p>
                        <p>'. str_repeat('&nbsp;', 5).'</p>
                        <p>'. str_repeat('&nbsp;', 5).'</p>
                    </td> 

                    <td style="border-left: 1px solid black;padding-left: 10px;" width="50%" valign="top">
                        <p>3. Qty of waste material / rejection returned to the factory &</p>
                    </td>
                </tr>

                <tr style="border: 1px solid black;">
                    <td width="50%" style="padding: 10px;text-align: left;">
                        <p>8. Factory / Place of processing / Manufacturing : '.$getscrapreturnForInvoice['supplier_name'].'</p>
                        <p>'.$getscrapreturnForInvoice['supplier_addess'].'</p>
                        <p style="color:#000080">GSTIN :'.$getscrapreturnForInvoice['sup_GSTIN'].'</p>
                        <p>'. str_repeat('&nbsp;', 5).'</p>
                        <p>'. str_repeat('&nbsp;', 5).'</p>
                    </td> 

                    <td style="border-left: 1px solid black;padding: 10px;" width="50%" valign="top">
                        <p>4. Name & Address of the Processor:</p>
                        <p>'. str_repeat('&nbsp;', 5).'</p>
                        <p>'. str_repeat('&nbsp;', 5).'</p>
                    </td>
                </tr>

                
                <tr style="border: 1px solid black;">
                    <td width="50%" style="padding: 10px;text-align: left;">
                        <p style="vertical-align: text-top;font-size:12px;color:#000080"><b>FOR SUPRA QUALITY EXPORTS (I) PVT. LTD.</b></p>
                        <p>'.date('d-m-Y').'</p>
                        <p>Place: Mumbai</p>
                       
                        <br/><img src="'.base_url().'assets/images/stmps/supplierpostampsignature.png" width="130" height="100">
                        <p style="vertical-align: text-top;font-size:10px;color:#000080;text-align: right;"><b>AUTHORIZED SIGNATORY</b></p>

                    </td> 

                    <td style="border-left: 1px solid black;padding: 10px;" width="50%" valign="top">
                        <p>5. Signature of Processor </p>
                    </td>
                </tr>
            </table>
            
            ';

            // <p>FOR SUPRA QUALITY EXPORTS (I) PVT. LTD.</p>
    $invoice_name =  $getscrapreturnForInvoice['challan_id'].' - '.$getscrapreturnForInvoice['vendor_name'].' To '.$getscrapreturnForInvoice['supplier_name'].'.pdf';
    $mpdf->WriteHTML($html);
    $mpdf->Output($invoice_name,'D'); // opens in browser
    
}

public function downlaoddebitnote($id){

    $getDebitnotedetailsforInvoice = $this->admin_model->getDebitnotedetailsforInvoice($id);
    $getDebitnoteitemdeatilsForInvoice = $this->admin_model->getDebitnoteitemdeatilsForInvoice($id);

    $CartItem = "";
    $supplierItem = "";
    $i =1;
    $ii =1;
    $subtotal = 0;

    $paid_amount =0;
    $total_paid_amount = 0;
    $total_debit_amount =0;
    $total_amount =0;
    $cgst_tax_rate = 0;
    $sgst_tax_rate = 0;
    $igst_tax_rate = 0;
    $gst_rate ='';

    $item_count =count($getDebitnoteitemdeatilsForInvoice);

    if($item_count==1){
        $padding_bottom = '200px';
    }else if($item_count==2){
        $padding_bottom = '40px';
    }else if($item_count==3){
        $padding_bottom = '10px';
    }else{
        $padding_bottom = '10px';
    }

    
    foreach ($getDebitnoteitemdeatilsForInvoice as $key => $value) {

        if($value['raw_material_neight_weight']){
            $net_weigth = $value['qty'] * $value['raw_material_neight_weight'];
        }else{
            $net_weigth ='';
        }

        $paid_amount = $value['rate'] * $value['ok_qty'];
        $total_paid_amount += $value['rate'] * $value['ok_qty'];
        $total_debit_amount +=$value['debit_amount'];

        $CartItem .= '
                <tr style="border-left: 1px solid black;border-right: 1px solid black;">
                    <td style="border-left: 1px solid black;border-right: 1px solid black;text-align:left;padding: 10px;" valign="top">'.$value['type_of_raw_material'].'<br/>'.$value['part_number'].'</td>
                    <td style="border-left: 1px solid black;border-right: 1px solid black;text-align:left;padding: 10px;" valign="top">'.$value['invoice_no'].'<br/>'.date('d-m-Y',strtotime($value['invoice_date'])).'</br></td> 
                    <td style="border-left: 1px solid black;border-right: 1px solid black;text-align:left;padding: 10px;" valign="top">'.$value['invoice_qty'].' '.$value['supplier_po_unit'].'<br/> Recd Qty '.$value['received_quantity'].' '.$value['supplier_po_unit'].'</td>
                    <td style="border-left: 1px solid black;border-right: 1px solid black;text-align:left;padding: 10px;" valign="top">'.$value['ok_qty'].' '.$value['supplier_po_unit'].'</td>
                    <td style="border-left: 1px solid black;border-right: 1px solid black;text-align:left;padding: 10px;" valign="top">'.$value['less_quantity'].' '.$value['supplier_po_unit'].'</td> 
                    <td style="border-left: 1px solid black;border-right: 1px solid black;text-align:left;padding: 10px;" valign="top">'.$value['rejected_quantity'].' '.$value['supplier_po_unit'].'</td>    
                    <td style="border-left: 1px solid black;border-right: 1px solid black;text-align:left;padding: 10px;" valign="top">'.$value['rate'].'</td>    
                    <td style="border-left: 1px solid black;border-right: 1px solid black;text-align:left;padding: 10px;" valign="top">'.round($value['debit_amount'],2).'</td>    
                    <td style="border-left: 1px solid black;border-right: 1px solid black;text-align:left;padding: 10px;" valign="top">'.$paid_amount.'</td>
                </tr>';
          

              
                $gst_rate = $value['gst_rate'];

                if($value['gst_rate']=='CGST_SGST'){
                    $cgst_tax_rate = 9;
                    $sgst_tax_rate = 9;

                    $cgst_tax_value = $value['CGST_value'];
                    $sgst_tax_value = $value['SGST_value'];

                }else if($value['gst_rate']=='CGST_SGST_6'){
                    $cgst_tax_rate = 6;
                    $sgst_tax_rate = 6;

                    $cgst_tax_value = $value['CGST_value'];
                    $sgst_tax_value = $value['SGST_value'];

                }else if($value['gst_rate']=='IGST'){
                    $igst_tax_rate = 18;
                    $igst_tax_value = $value['IGST_value'];
                }else if($value['gst_rate']=='IGST_12'){
                    $igst_tax_rate = 12;
                    $igst_tax_value = $value['IGST_value'];

                }

                $total_amount +=   $sgst_tax_value+$cgst_tax_value+$igst_tax_value+$paid_amount;
                $total_amount_debit +=   $sgst_tax_value+$cgst_tax_value+$igst_tax_value+$value['debit_amount'];

            $ii++;       
    }

  


     if($gst_rate=='CGST_SGST' || $gst_rate=='CGST_SGST_6'){
        $tax_value = '<tr style="border: 1px solid black;">               
            <td colspan="8"  style="text-align: right;border: 1px solid black;padding: 5px;font-family:cambria;font-size:14px;">CGST @ '.$cgst_tax_rate.'% </td>    
                <td style="border: 1px solid black;padding: 5px;">'.round($cgst_tax_value,2).'</td>
            </tr>

            <tr style="border: 1px solid black;">
                <td colspan="8"  style="text-align: right;border: 1px solid black;padding: 5px;font-family:cambria;font-size:14px;">SGST @ '.$sgst_tax_rate.'% </td>    
                <td style="border: 1px solid black;padding: 5px;">'.round($sgst_tax_value,2).'</td>
            </tr>';

            $total_tax_rate = 'CGST @ '.$cgst_tax_rate.'% = '.round($cgst_tax_value,2).'<br/> SGST @ '.$sgst_tax_rate.'% = '.round($sgst_tax_value,2);

     }else{
        $tax_value = '
            <tr style="border: 1px solid black;">
                <td colspan="8"  style="text-align: right;border: 1px solid black;padding: 5px;font-family:cambria;font-size:14px;">IGST @ '.$igst_tax_rate.'%</td>    
                <td style="border: 1px solid black;padding: 5px;">'.round($igst_tax_value,2).'</td>
            </tr>';

        $total_tax_rate = 'IGST @ '.$igst_tax_rate.'%'.round($igst_tax_value,2);
     }

  
    $mpdf = new \Mpdf\Mpdf();
    // $html = $this->load->view('html_to_pdf',[],true);
    $html = '<table style=" width: 100%;text-align: center;border-collapse: collapse;font-family:cambria;">
                <tr>
                  <td rowspan="2"><img src="'.base_url().'assets/images/supra_logo_1.jpg" width="80" height="80"></td>
                  <td style="color:#000080"><h2>SUPRA QUALITY EXPORTS (I) PVT. LTD</h2></td>
                  <td rowspan="2"><img src="'.base_url().'assets/images/logo_2.png"width="80" height="80"></td>
                </tr>
                <tr>
                  <td style="font-weight: bold;">
                    <p>MANUFACTURER & EXPORTERS OF:</p>
                    <p>PRECISION TURNED COMPONENTS, STAMPED /PRESSED PARTS IN FERROUS & NON-FERROUS METAL</p>
                    <p>MOULDED & EXTRUDED PLASTIC AND RUBBER COMPONENTS</p> 
                  </td>
                </tr>
            </table>
            <hr>
            <table style=" width: 100%;text-align: center;margin-top:10px;margin-bottom:10px;font-family:cambria;">
                    <tr>
                        <td style="color:red;font-size:15px">
                          <u><p><h3>DEBIT NOTE</h3></p>
                        </td>
                    </tr>
            </table>

            <table style=" width: 100%;text-align: left;border-collapse: collapse;font-family:cambria;font-size:13px;">
                <tr>
                    <td width="50%">
                        <div>
                            <p>To,</p>
                            <p><b>'.$getDebitnotedetailsforInvoice['supplier_name'].'</b></p>
                            <p>'.$getDebitnotedetailsforInvoice['supplier_addess'].'</p>
                            <p><b>Contact No:</b> '.$getDebitnotedetailsforInvoice['mobile'].' / '.$getDebitnotedetailsforInvoice['suplier_landline'].'</p>
                            <p><b>Contact Person:</b> '.$getDebitnotedetailsforInvoice['sup_conatct'].'</p>
                            <p><b>Email:</b> '.$getDebitnotedetailsforInvoice['sup_email'].'</p>
                            <p style="color:red">GSTIN:'.$getDebitnotedetailsforInvoice['sup_GSTIN'].'</p>
                        <div>    
                    </td> 
                    <td style="font-size:13px;" width="50%" valign="top">
                        <div>
                            <p><b></b>'. str_repeat('&nbsp;', 5).'<span style="color:red"></span></p>
                            <p><b>DEBIT NOTE NO :</b> '.'<span style="color:red">'.$getDebitnotedetailsforInvoice['debit_note_number'].'</span></p>
                            <p>&nbsp;</p>
                            <p><b>Date :</b> '.date('d-m-Y',strtotime($getDebitnotedetailsforInvoice['debit_note_date'])).'</p>
                            <p>&nbsp;</p>
                        </div>
                    </td>
                </tr>
            </table>

            <table style="margin-top:20px;width: 100%;text-align: left;border-collapse: collapse;font-family:cambria;font-size:13px;">
                <tr>
                    <td width="50%">
                        <div>
                            <p>Dear Sir,</p>
                            <p><b>Sub: Debit Note</b></p>
                            <p>With reference to the above subject we have debited your account vide your Inv No.'.$getDebitnoteitemdeatilsForInvoice[0]['invoice_no'].' Dated '.date('d-m-Y',strtotime($getDebitnoteitemdeatilsForInvoice[0]['invoice_date'])).'
                               The details are as follows: </p>
                        <div>    
                    </td>  
                </tr>
            </table>

            <table style="margin-top:10px;width: 100%;text-align: left;border-collapse: collapse;border: #ccc 1px solid;margin-top:10px;margin-bottom:10px;font-family:cambria;font-size:12px">
                <tr style="border: 1px solid black;">
                    <th align="left" style="border: 1px solid black;text-align:center;" margin-bottom: 10%;>Part Description & PartNo</th>
                    <th align="left" style="border: 1px solid black;text-align:center;" margin-bottom: 10%;>Inv No Inv Date</th>  
                    <th align="left" style="border: 1px solid black;text-align:center;" margin-bottom: 10%;>Bill Qty</th> 
                    <th align="left" style="border: 1px solid black;text-align:center;" margin-bottom: 10%;>Ok Qty</th>  
                    <th align="left" style="border: 1px solid black;text-align:center;" margin-bottom: 10%;>Less Qty</th>  
                    <th align="left" style="border: 1px solid black;text-align:center;" margin-bottom: 10%;>Rej Qty</th>  
                    <th align="left" style="border: 1px solid black;text-align:center;" margin-bottom: 10%;>Rate</th>
                    <th align="left" style="border: 1px solid black;text-align:center;" margin-bottom: 10%;>Debit Amt</th>
                    <th align="left" style="border: 1px solid black;text-align:center;" margin-bottom: 10%;>Paid Amt</th>
                </tr>
                '.$CartItem.' 

                <tr style="border: 1px solid black;">               
                    <td colspan="8"  style="text-align: right;border: 1px solid black;padding: 5px;;padding: 5px;;font-family:cambria;font-size:14px;"><b>Total </b></td>    
                    <td style="border: 1px solid black;padding: 5px;"></td>
                </tr>

             '. $tax_value.'
            

             <tr style="border: 1px solid black;">
                    <td colspan="8"  style="text-align: right;border: 1px solid black;padding: 5px;font-family:cambria;font-size:14px;"><b>Total amount</b></td>    
                    <td style="border: 1px solid black;padding: 5px;">'.round($total_amount,2).'</td>
              </tr>

              <tr style="border: 1px solid black;">
                <td colspan="8"  style="text-align: right;border: 1px solid black;padding: 5px;font-family:cambria;font-size:14px;">Less TDS</td>    
                <td style="border: 1px solid black;padding: 5px;">'.$getDebitnotedetailsforInvoice['tds_amount'].'</td>
              </tr>

              <tr style="border: 1px solid black;">
                <td colspan="8"  style="text-align: right;border: 1px solid black;padding: 5px;font-family:cambria;font-size:14px;"><b>Cheque Amt</b></td>    
                <td style="border: 1px solid black;padding: 5px">'.$getDebitnotedetailsforInvoice['chq_amount'].'</td>
              </tr>

              <tr style="border: 1px solid black;">
                <td colspan="8"  style="text-align: right;border: 1px solid black;padding: 5px;font-family:cambria;font-size:14px;">We Have Debit Amt = '.round($total_debit_amount,2).' <br/> '.$total_tax_rate.'<br>____________<br/>'.round($total_amount_debit,2).'</td>    
                <td style="border: 1px solid black;padding: 5px">'.$getDebitnotedetailsforInvoice['tds_amount'].'<br/><br/>'.round($total_amount_debit,2).'<br/>____________<br/>'.$getDebitnotedetailsforInvoice['tds_amount']+$total_amount_debit.'</td>
              </tr>

                <tr style="border: 1px solid black;">
                <td colspan="8"  style="text-align: right;border: 1px solid black;padding: 5px;font-family:cambria;font-size:14px;"><b>Grand Total</b></td>    
                <td style="border: 1px solid black;padding: 5px"><b>'.round($getDebitnotedetailsforInvoice['grand_total_main'],2).'</b></td>
                </tr>
          
            </table>

            <table style=" width: 100%;border-collapse: collapse;border: #ccc 1px solid;font-family:cambria;font-size:12px">
                <tr style="border: 1px solid black;">
                        <td style="border: 1px solid black;padding-left: 10px;">
                            <p><b>Remark :</b>'.$getDebitnotedetailsforInvoice['debit_note_remark'].'</p>    
                    </td>   
                </tr>
            </table>

            <table style=" width: 100%;text-align: left;margin-top:10px;margin-bottom:10px;font-family:cambria;font-size:12px">
                   <tr >
                        <td style="padding-left: 10px;" width="75%;" valign="top">
                            <p>Thanking You,</p>
                            <p>Yours truly</p>
                            <p style="vertical-align: text-top;font-size:12px;color:#206a9b"><b>FOR SUPRA QUALITY EXPORTS (I) PVT. LTD.</b></p>
                            <br/><img src="'.base_url().'assets/images/stmps/rr_challan.png" width="130" height="100">
                            <p style="vertical-align: text-top;font-size:10px;color:#206a9b"><b>AUTHORIZED SIGNATORY</b></p>
                        </td>
                        <td style="text-align: center;" width="25%" valign="top">
                        </td> 
                </tr>
            </table>';

            // <p>FOR SUPRA QUALITY EXPORTS (I) PVT. LTD.</p>
    $invoice_name =  $getDebitnotedetailsforInvoice['debit_note_number'].' - '.$getDebitnotedetailsforInvoice['supplier_name'].'.pdf';
    $mpdf->WriteHTML($html);
    $mpdf->Output($invoice_name,'D'); // opens in browser

}  

public function downlaoddebitnotevendor($id){

    $getDebitnotedetailsforInvoice = $this->admin_model->getDebitnotedetailsforInvoicevendor($id);
    $getDebitnoteitemdeatilsForInvoice = $this->admin_model->getDebitnoteitemdeatilsForInvoicevendor($id);

    $CartItem = "";
    $supplierItem = "";
    $i =1;
    $ii =1;
    $subtotal = 0;

    $paid_amount =0;
    $total_paid_amount = 0;
    $total_debit_amount =0;
    $total_amount =0;
    $cgst_tax_rate = 0;
    $sgst_tax_rate = 0;
    $igst_tax_rate = 0;
    $gst_rate ='';

    $item_count =count($getDebitnoteitemdeatilsForInvoice);

    if($item_count==1){
        $padding_bottom = '200px';
    }else if($item_count==2){
        $padding_bottom = '40px';
    }else if($item_count==3){
        $padding_bottom = '10px';
    }else{
        $padding_bottom = '10px';
    }

    
    foreach ($getDebitnoteitemdeatilsForInvoice as $key => $value) {

        if($value['raw_material_neight_weight']){
            $net_weigth = $value['qty'] * $value['raw_material_neight_weight'];
        }else{
            $net_weigth ='';
        }

        $paid_amount = $value['rate'] * $value['ok_qty'];
        $total_paid_amount += $value['rate'] * $value['ok_qty'];
        $total_debit_amount +=$value['debit_amount'];

        $CartItem .= '
                <tr style="border-left: 1px solid black;border-right: 1px solid black;">
                    <td style="border-left: 1px solid black;border-right: 1px solid black;text-align:left;padding: 10px;" valign="top">'.$value['name'].'<br/>'.$value['fgpart'].'</td> 
                    <td style="border-left: 1px solid black;border-right: 1px solid black;text-align:left;padding: 10px;" valign="top">'.$value['invoice_no'].'<br/>'.date('d-m-Y',strtotime($value['invoice_date'])).'</br></td> 
                    <td style="border-left: 1px solid black;border-right: 1px solid black;text-align:left;padding: 10px;" valign="top">'.$value['invoice_qty'].' '.$value['vendor_po_unit'].'<br/> Recd Qty '.$value['received_quantity'].' '.$value['vendor_po_unit'].'</td>
                    <td style="border-left: 1px solid black;border-right: 1px solid black;text-align:left;padding: 10px;" valign="top">'.$value['ok_qty'].' '.$value['vendor_po_unit'].'</td>
                    <td style="border-left: 1px solid black;border-right: 1px solid black;text-align:left;padding: 10px;" valign="top">'.$value['less_quantity'].' '.$value['vendor_po_unit'].'</td> 
                    <td style="border-left: 1px solid black;border-right: 1px solid black;text-align:left;padding: 10px;" valign="top">'.$value['rejected_quantity'].' '.$value['vendor_po_unit'].'</td>    
                    <td style="border-left: 1px solid black;border-right: 1px solid black;text-align:left;padding: 10px;" valign="top">'.$value['rate'].'</td>    
                    <td style="border-left: 1px solid black;border-right: 1px solid black;text-align:left;padding: 10px;" valign="top">'.round($value['debit_amount'],2).'</td>    
                    <td style="border-left: 1px solid black;border-right: 1px solid black;text-align:left;padding: 10px;" valign="top">'.$paid_amount.'</td>
                </tr>';
          

              
                $gst_rate = $value['gst_rate'];

                if($value['gst_rate']=='CGST_SGST'){
                    $cgst_tax_rate = 9;
                    $sgst_tax_rate = 9;

                    $cgst_tax_value = $value['CGST_value'];
                    $sgst_tax_value = $value['SGST_value'];

                }else if($value['gst_rate']=='CGST_SGST_6'){
                    $cgst_tax_rate = 6;
                    $sgst_tax_rate = 6;

                    $cgst_tax_value = $value['CGST_value'];
                    $sgst_tax_value = $value['SGST_value'];

                }else if($value['gst_rate']=='IGST'){
                    $igst_tax_rate = 18;
                    $igst_tax_value = $value['IGST_value'];
                }else if($value['gst_rate']=='IGST_12'){
                    $igst_tax_rate = 12;
                    $igst_tax_value = $value['IGST_value'];

                }

                $total_amount +=   $sgst_tax_value+$cgst_tax_value+$igst_tax_value+$paid_amount;
                $total_amount_debit +=   $sgst_tax_value+$cgst_tax_value+$igst_tax_value+$value['debit_amount'];

            $ii++;       
    }

  


     if($gst_rate=='CGST_SGST' || $gst_rate=='CGST_SGST_6'){
        $tax_value = '<tr style="border: 1px solid black;">               
            <td colspan="8"  style="text-align: right;border: 1px solid black;padding: 5px;font-family:cambria;font-size:14px;">CGST @ '.$cgst_tax_rate.'% </td>    
                <td style="border: 1px solid black;padding: 5px;">'.round($cgst_tax_value,2).'</td>
            </tr>

            <tr style="border: 1px solid black;">
                <td colspan="8"  style="text-align: right;border: 1px solid black;padding: 5px;font-family:cambria;font-size:14px;">SGST @ '.$sgst_tax_rate.'% </td>    
                <td style="border: 1px solid black;padding: 5px;">'.round($sgst_tax_value,2).'</td>
            </tr>';

            $total_tax_rate = 'CGST @ '.$cgst_tax_rate.'% = '.round($cgst_tax_value,2).'<br/> SGST @ '.$sgst_tax_rate.'% = '.round($sgst_tax_value,2);

     }else{
        $tax_value = '
            <tr style="border: 1px solid black;">
                <td colspan="8"  style="text-align: right;border: 1px solid black;padding: 5px;font-family:cambria;font-size:14px;">IGST @ '.$igst_tax_rate.'%</td>    
                <td style="border: 1px solid black;padding: 5px;">'.round($igst_tax_value,2).'</td>
            </tr>';

        $total_tax_rate = 'IGST @ '.$igst_tax_rate.'%'.round($igst_tax_value,2);
     }

  
    $mpdf = new \Mpdf\Mpdf();
    // $html = $this->load->view('html_to_pdf',[],true);
    $html = '<table style=" width: 100%;text-align: center;border-collapse: collapse;font-family:cambria;">
                <tr>
                  <td rowspan="2"><img src="'.base_url().'assets/images/supra_logo_1.jpg" width="80" height="80"></td>
                  <td style="color:#000080"><h2>SUPRA QUALITY EXPORTS (I) PVT. LTD</h2></td>
                  <td rowspan="2"><img src="'.base_url().'assets/images/logo_2.png"width="80" height="80"></td>
                </tr>
                <tr>
                  <td style="font-weight: bold;">
                    <p>MANUFACTURER & EXPORTERS OF:</p>
                    <p>PRECISION TURNED COMPONENTS, STAMPED /PRESSED PARTS IN FERROUS & NON-FERROUS METAL</p>
                    <p>MOULDED & EXTRUDED PLASTIC AND RUBBER COMPONENTS</p> 
                  </td>
                </tr>
            </table>
            <hr>
            <table style=" width: 100%;text-align: center;margin-top:10px;margin-bottom:10px;font-family:cambria;">
                    <tr>
                        <td style="color:red;font-size:15px">
                          <u><p><h3>DEBIT NOTE</h3></p>
                        </td>
                    </tr>
            </table>

            <table style=" width: 100%;text-align: left;border-collapse: collapse;font-family:cambria;font-size:13px;">
                <tr>
                    <td width="50%">
                        <div>
                            <p>To,</p>
                            <p><b>'.$getDebitnotedetailsforInvoice['vendor_name'].'</b></p>
                            <p>'.$getDebitnotedetailsforInvoice['ven_address'].'</p>
                            <p><b>Contact No:</b> '.$getDebitnotedetailsforInvoice['ven_mobile'].' / '.$getDebitnotedetailsforInvoice['ven_landline'].'</p>
                            <p><b>Contact Person:</b> '.$getDebitnotedetailsforInvoice['ven_contact_person'].'</p>
                            <p><b>Email:</b> '.$getDebitnotedetailsforInvoice['ven_email'].'</p>
                            <p style="color:red">GSTIN:'.$getDebitnotedetailsforInvoice['ven_GSTIN'].'</p>
                        <div>    
                    </td> 
                    <td style="font-size:13px;" width="50%" valign="top">
                        <div>
                            <p><b></b>'. str_repeat('&nbsp;', 5).'<span style="color:red"></span></p>
                            <p><b>DEBIT NOTE NO :</b> '.'<span style="color:red">'.$getDebitnotedetailsforInvoice['debit_note_number'].'</span></p>
                            <p>&nbsp;</p>
                            <p><b>Date :</b> '.date('d-m-Y',strtotime($getDebitnotedetailsforInvoice['debit_note_date'])).'</p>
                            <p>&nbsp;</p>
                        </div>
                    </td>
                </tr>
            </table>

            <table style="margin-top:20px;width: 100%;text-align: left;border-collapse: collapse;font-family:cambria;font-size:13px;">
                <tr>
                    <td width="50%">
                        <div>
                            <p>Dear Sir,</p>
                            <p><b>Sub: Debit Note</b></p>
                            <p>With reference to the above subject we have debited your account vide your Inv No.'.$getDebitnoteitemdeatilsForInvoice[0]['invoice_no'].' Dated '.date('d-m-Y',strtotime($getDebitnoteitemdeatilsForInvoice[0]['invoice_date'])).'
                               The details are as follows: </p>
                        <div>    
                    </td>  
                </tr>
            </table>

            <table style="margin-top:10px;width: 100%;text-align: left;border-collapse: collapse;border: #ccc 1px solid;margin-top:10px;margin-bottom:10px;font-family:cambria;font-size:12px">
                <tr style="border: 1px solid black;">
                    <th align="left" style="border: 1px solid black;text-align:center;" margin-bottom: 10%;>Part Description & PartNo</th>
                    <th align="left" style="border: 1px solid black;text-align:center;" margin-bottom: 10%;>Inv No Inv Date</th>  
                    <th align="left" style="border: 1px solid black;text-align:center;" margin-bottom: 10%;>Bill Qty</th> 
                    <th align="left" style="border: 1px solid black;text-align:center;" margin-bottom: 10%;>Ok Qty</th>  
                    <th align="left" style="border: 1px solid black;text-align:center;" margin-bottom: 10%;>Less Qty</th>  
                    <th align="left" style="border: 1px solid black;text-align:center;" margin-bottom: 10%;>Rej Qty</th>  
                    <th align="left" style="border: 1px solid black;text-align:center;" margin-bottom: 10%;>Rate</th>
                    <th align="left" style="border: 1px solid black;text-align:center;" margin-bottom: 10%;>Debit Amt</th>
                    <th align="left" style="border: 1px solid black;text-align:center;" margin-bottom: 10%;>Paid Amt</th>
                </tr>
                '.$CartItem.' 

                <tr style="border: 1px solid black;">               
                    <td colspan="8"  style="text-align: right;border: 1px solid black;padding: 5px;;padding: 5px;;font-family:cambria;font-size:14px;"><b>Total </b></td>    
                    <td style="border: 1px solid black;padding: 5px;"></td>
                </tr>

             '. $tax_value.'
            

             <tr style="border: 1px solid black;">
                    <td colspan="8"  style="text-align: right;border: 1px solid black;padding: 5px;font-family:cambria;font-size:14px;"><b>Total amount</b></td>    
                    <td style="border: 1px solid black;padding: 5px;">'.round($total_amount,2).'</td>
              </tr>

              <tr style="border: 1px solid black;">
                <td colspan="8"  style="text-align: right;border: 1px solid black;padding: 5px;font-family:cambria;font-size:14px;">Less TDS</td>    
                <td style="border: 1px solid black;padding: 5px;">'.$getDebitnotedetailsforInvoice['tds_amount'].'</td>
              </tr>

              <tr style="border: 1px solid black;">
                <td colspan="8"  style="text-align: right;border: 1px solid black;padding: 5px;font-family:cambria;font-size:14px;"><b>Cheque Amt</b></td>    
                <td style="border: 1px solid black;padding: 5px">'.$getDebitnotedetailsforInvoice['chq_amount'].'</td>
              </tr>

              <tr style="border: 1px solid black;">
                <td colspan="8"  style="text-align: right;border: 1px solid black;padding: 5px;font-family:cambria;font-size:14px;">We Have Debit Amt = '.round($total_debit_amount,2).' <br/> '.$total_tax_rate.'<br>____________<br/>'.round($total_amount_debit,2).'</td>    
                <td style="border: 1px solid black;padding: 5px">'.$getDebitnotedetailsforInvoice['tds_amount'].'<br/><br/>'.round($total_amount_debit,2).'<br/>____________<br/>'.$getDebitnotedetailsforInvoice['tds_amount']+round($total_amount_debit,2).'</td>
              </tr>

                <tr style="border: 1px solid black;">
                <td colspan="8"  style="text-align: right;border: 1px solid black;padding: 5px;font-family:cambria;font-size:14px;"><b>Grand Total</b></td>    
                <td style="border: 1px solid black;padding: 5px"><b>'.round($getDebitnotedetailsforInvoice['grand_total_main'],2).'</b></td>
                </tr>
          
            </table>

            <table style=" width: 100%;border-collapse: collapse;border: #ccc 1px solid;font-family:cambria;font-size:12px">
                <tr style="border: 1px solid black;">
                        <td style="border: 1px solid black;padding-left: 10px;">
                            <p><b>Remark :</b>'.$getDebitnotedetailsforInvoice['debit_note_remark'].'</p>    
                    </td>   
                </tr>
            </table>

            <table style=" width: 100%;text-align: left;margin-top:10px;margin-bottom:10px;font-family:cambria;font-size:12px">
                   <tr >
                        <td style="padding-left: 10px;" width="75%;" valign="top">
                            <p>Thanking You,</p>
                            <p>Yours truly</p>
                            <p style="vertical-align: text-top;font-size:12px;color:#206a9b"><b>FOR SUPRA QUALITY EXPORTS (I) PVT. LTD.</b></p>
                            <br/><img src="'.base_url().'assets/images/stmps/rr_challan.png" width="130" height="100">
                            <p style="vertical-align: text-top;font-size:10px;color:#206a9b"><b>AUTHORIZED SIGNATORY</b></p>
                        </td>
                        <td style="text-align: center;" width="25%" valign="top">
                        </td> 
                </tr>
            </table>';

            // <p>FOR SUPRA QUALITY EXPORTS (I) PVT. LTD.</p>
    $invoice_name =  $getDebitnotedetailsforInvoice['debit_note_number'].' - '.$getDebitnotedetailsforInvoice['vendor_name'].'.pdf';
    $mpdf->WriteHTML($html);
    $mpdf->Output($invoice_name,'D'); // opens in browser

}  


public function downloadomsblasting($id){

    $getblastingdetailsforinvoice = $this->admin_model->getblastingdetailsforinvoice($id);
    $getblastingItemdeatilsForInvoice = $this->admin_model->getblastingItemdeatilsForInvoice($id);

    $mpdf = new \Mpdf\Mpdf();
    // $html = $this->load->view('html_to_pdf',[],true);
    $html = '<table style=" width: 100%;border-collapse: collapse;border: #cccccc 0px solid;font-family:Times New Roman;font-size:13px">
                <tr style="border: 1px solid black;" valign="top">
                    <td width="50%" style="padding: 10px;text-align: left;">
                        <p><h3 style="color:#000080">SUPRA QUALITY EXPORTS INDIA PVT LTD </h3></p>
                        <p>229 to 232, Bharat Industrial Estate,</p>
                        <p>L.B.S. Marg, Bhandup West, Mumbai – 400078. INDIA.</p>
                        <p></p>
                        <p></p>
                        <p><span style="color:#000080">GSTIN : 27AAJCS7869M1ZB</span></p>
                    </td> 

                    <td style="border-left: 1px solid black;padding: 10px;" width="50%" valign="top">
                          <p style="text-align: center"><h4>DELIVERY CHALLAN</h4></p>
                          <p style="text-align: left;"> Movement of inputs or partially processed goods
                            for job work under Rule 55 ofthe Central Goods
                            & Service Tax Rules.20l7. from one factory to
                            another factory for further processing / operation.
                          </p>
                    </td>
                </tr>
           
                <tr style="border: 1px solid black;padding: 10px;">
                    <td width="50%" style="padding: 10px;text-align: left;">
                       Sr. No. : <span style="color:red">'.$getblastingdetailsforinvoice['blasting_id'].'-A '.date('d-m-Y',strtotime($getblastingdetailsforinvoice['date'])).'</span>
                    </td> 

                    <td style="border-left: 1px solid black;padding: 10px;" width="50%" valign="top">
                       <input type="checkbox" style="width: 100px;height: 100px;zoom:5;"> Original  <input type="checkbox"> Duplicate  <input type="checkbox"> Triplicate
                    </td>
                </tr>

                <tr style="border: 1px solid black;">
                    <td width="50%" style="padding: 10px;text-align: left;valign="top"">
                        <p>'. str_repeat('&nbsp;', 5).'</p>
                        <p>'. str_repeat('&nbsp;', 5).'</p>
                        <p>'. str_repeat('&nbsp;', 5).'</p>
                    </td> 

                    <td style="border-left: 1px solid black;padding: 10px;" width="50%" valign="top">
                        <p>Part-II </p>
                        <p>to be filled by the processing factory in original and duplicate challans. </p>
                    </td>
                </tr>

                <tr style="border: 1px solid black;">
                    <td width="50%" style="padding: 10px;text-align: left;">
                         <p>1. Description </p>
                         <p>'.$getblastingItemdeatilsForInvoice[0]['type_of_raw_material'].'</p>
                    </td> 

                    <td style="border-left: 1px solid black;padding: 10px;" width="50%" valign="top">
                        <p>1. Details of type,qty, date & time of processing done and Return of processed goods to parent factory </p>
                    </td>
                </tr>
            </table>

            <table style=" width: 100%;border-collapse: collapse;border: #cccccc 0px solid;font-family:Times New Roman;font-size:13px;">
                <tr style="border-left: 1px solid black;border-right: 1px solid black;border-bottom: 1px solid black;">
                    <td style="text-align:left;padding: 10px;">'.str_repeat('&nbsp;', 5).'</td> 
                    <td style="border-left: 1px solid black;padding:10px;" width="10%">'.str_repeat('&nbsp;', 5).'</td>
                    <td style="border-left: 1px solid black;padding:10px;" width="10%">'.str_repeat('&nbsp;', 5).'</td>
                    <td style="border-left: 1px solid black;padding:10px;" width="10%">'.str_repeat('&nbsp;', 5).'</td>
                    <td style="border-left: 1px solid black;padding:10px;" width="10%">'.str_repeat('&nbsp;', 5).'</td>
                    <td style="border-left: 1px solid black;padding:10px;" width="50%">'.str_repeat('&nbsp;', 5).'</td>
                </tr>
            </table>


            <table style=" width: 100%;border-collapse: collapse;border: #cccccc 0px solid;font-family:Times New Roman;font-size:13px;">
                
                <tr style="border-left: 1px solid black;border-right: 1px solid black;border-bottom: 1px solid black;">
                    <td style="text-align:left;padding: 10px;"          width="50%">2. Identification marks & number if any</td> 
                    <td style="border-left: 1px solid black;padding:10px;">Size / Type</td>
                    <td style="border-left: 1px solid black;padding: 10px;" >Quantity</td>
                    <td style="border-left: 1px solid black;padding: 10px;" >Date</td>
                    <td style="border-left: 1px solid black;padding: 10px;" >Time</td>
                </tr>

                <tr style="border-left: 1px solid black;border-right: 1px solid black;">
                    <td style="padding-left: 10px;text-align: left;"  width="50%">
                       <p> 3. Quantity (Nos. / Weight / Metre /Litre) </p>
                     </td> 
                    <td style="border-left: 1px solid black;padding-left: 10px;">1</td>
                    <td style="border-left: 1px solid black;padding-left: 10px;"></td>
                    <td style="border-left: 1px solid black;padding-left: 10px;"></td>
                    <td style="border-left: 1px solid black;padding-left: 10px;"></td>
                </tr>


                <tr style="border-left: 1px solid black;border-right: 1px solid black;">
                    <td style="padding-left: 10px;text-align: left;"  width="50%">
                       <p> Gross Weight: '.$getblastingItemdeatilsForInvoice[0]['gross_weight_oms'].' kgs </p>
                     </td> 
                    <td style="border-left: 1px solid black;padding-left: 10px;"></td>
                    <td style="border-left: 1px solid black;padding-left: 10px;"></td>
                    <td style="border-left: 1px solid black;padding-left: 10px;"></td>
                    <td style="border-left: 1px solid black;padding-left: 10px;"></td>
                </tr>


                <tr style="border-left: 1px solid black;border-right: 1px solid black;">
                    <td style="padding-left: 10px;text-align: left;"  width="50%">
                      <p> Net Weight:   '.$getblastingItemdeatilsForInvoice[0]['net_weight_oms'].' kgs </p>
                    </td> 
                    <td style="border-left: 1px solid black;padding-left: 10px;">2</td>
                    <td style="border-left: 1px solid black;padding-left: 10px;"></td>
                    <td style="border-left: 1px solid black;padding-left: 10px;"></td>
                    <td style="border-left: 1px solid black;padding-left: 10px;"></td>
                </tr>


                <tr style="border-left: 1px solid black;border-right: 1px solid black;">
                    <td style="padding-left: 10px;text-align: left;"  width="50%">
                    <p> Quantity:   '.$getblastingItemdeatilsForInvoice[0]['qty'].' Pcs</p>
                    </td> 
                    <td style="border-left: 1px solid black;padding-left: 10px;"></td>
                    <td style="border-left: 1px solid black;padding-left: 10px;"></td>
                    <td style="border-left: 1px solid black;padding-left: 10px;"></td>
                    <td style="border-left: 1px solid black;padding-left: 10px;"></td>
                </tr>


                <tr style="border-left: 1px solid black;border-right: 1px solid black;">
                        <td style="text-align: left;border-right: 1px solid black;border-bottom: 1px solid black"  width="50%">
                         <p>'.str_repeat('&nbsp;', 1).' No. of Bags:  '.$getblastingItemdeatilsForInvoice[0]['no_of_bags'].' Bags</p>
                        </td> 
                        <hr style="margin-left: 10px;"></hr>
                        <td style="border-left: 1px solid black;padding-left: 10px;">3</td>
                        <td style="border-left: 1px solid black;padding-left: 10px;"></td>
                        <td style="border-left: 1px solid black;padding-left: 10px;"></td>
                        <td style="border-left: 1px solid black;padding-left: 10px;"></td>
                </tr>


                <tr style="border-left: 1px solid black;border-right: 1px solid black;">
                    <td style="text-align: left;border-right: 1px solid black;border-bottom: 1px solid black"  width="50%">
                       <p>'.str_repeat('&nbsp;', 1).' 4. HSN NO: '.$getblastingItemdeatilsForInvoice[0]['hsn_code'].'  </p>
                    </td> 
                    <hr style="margin-left: 10px;"></hr>
                    <td style="border-left: 1px solid black;padding-left: 10px;">4</td>
                    <td style="border-left: 1px solid black;padding-left: 10px;"></td>
                    <td style="border-left: 1px solid black;padding-left: 10px;"></td>
                    <td style="border-left: 1px solid black;padding-left: 10px;"></td>
                </tr>


                <tr style="border-left: 1px solid black;border-right: 1px solid black;">
                    <td style="padding-left: 10px;text-align: left;border-right: 1px solid black"  width="50%">
                    <p> 5. Estimated Value of inputs / Partially processed inputs  </p>
                    <p>'.$getblastingItemdeatilsForInvoice[0]['calculation'].'</p>
                   
                    </td> 
                    <td style="border-left: 1px solid black;padding-left: 10px;">5</td>
                    <td style="border-left: 1px solid black;padding-left: 10px;"></td>
                    <td style="border-left: 1px solid black;padding-left: 10px;"></td>
                    <td style="border-left: 1px solid black;padding-left: 10px;"></td>
                </tr>


                <tr style="border-left: 1px solid black;border-right: 1px solid black;">
                    <td style="padding-left: 10px;text-align: left;border-right: 1px solid black"  width="50%">
                    <p>  </p>
                    </td> 
                    <td style="border-left: 1px solid black;padding-left: 10px;">6</td>
                    <td style="border-left: 1px solid black;padding-left: 10px;"></td>
                    <td style="border-left: 1px solid black;padding-left: 10px;"></td>
                    <td style="border-left: 1px solid black;padding-left: 10px;"></td>
                </tr>
            </table>
            
            <table style=" width: 100%;border-collapse: collapse;border: #cccccc 0px solid;font-family:Times New Roman;font-size:13px;">

                <tr style="border: 1px solid black;">
                    <td width="50%" style="padding: 10px;text-align: left;">
                        <p>6.Date & Time of Issue : '.date('d-m-Y',strtotime($getblastingdetailsforinvoice['date'])).'</p>
                    </td> 

                    <td style="border-left: 1px solid black;padding: 10px;" width="50%" valign="top">
                        <p>2. Nature of Proc. / Manufacturing done</p>
                    </td>
                </tr>

                <tr style="border: 1px solid black;">
                    <td width="50%" style="padding: 10px;text-align: left;">
                        <p>7. Nature of processing: <b>For Blasting</b></p>
                        <p>'. str_repeat('&nbsp;', 5).'</p>
                    </td> 

                    <td style="border-left: 1px solid black;padding-left: 10px;" width="50%" valign="top">
                        <p>3. Qty of waste material / rejection returned to the factory &</p>
                    </td>
                </tr>

                <tr style="border: 1px solid black;">
                    <td width="50%" style="padding: 10px;text-align: left;">
                        <p>8. Factory / Place of processing / Manufacturing : Divya Industries </p>
                        <p>Plot No. 3892, Road no.: Y, Phase: 3, G.I.D.C. Jamnagar</p>
                        <p style="color:#000080">GSTIN : 24ADKPP4265F1ZH</p>
                        <p>'. str_repeat('&nbsp;', 5).'</p>
                    </td> 

                    <td style="border-left: 1px solid black;padding: 10px;" width="50%" valign="top">
                        <p>4. Name & Address of the Processor:</p>
                        <p>'. str_repeat('&nbsp;', 5).'</p>
                    </td>
                </tr>

                
                <tr style="border: 1px solid black;">
                    <td width="50%" style="padding: 10px;text-align: left;">
                        <p style="vertical-align: text-top;font-size:12px;color:#000080"><b>FOR SUPRA QUALITY EXPORTS (I) PVT. LTD.</b></p>
                        <p>'.date('d-m-Y').'</p>
                        <p>Place: Mumbai</p>
                       
                        <br/><img src="'.base_url().'assets/images/stmps/supplierpostampsignature.png" width="130" height="100">
                        <p style="vertical-align: text-top;font-size:10px;color:#000080;text-align: right;"><b>AUTHORIZED SIGNATORY</b></p>

                    </td> 

                    <td style="border-left: 1px solid black;padding: 10px;" width="50%" valign="top">
                        <p>5. Signature of Processor </p>
                    </td>
                </tr>
            </table>
            
            ';

            // <p>FOR SUPRA QUALITY EXPORTS (I) PVT. LTD.</p>
    $invoice_name =  $getblastingdetailsforinvoice['blasting_id'].'-A-'.$getblastingdetailsforinvoice['vendor_name'].'.pdf';
    $mpdf->WriteHTML($html);
    $mpdf->Output($invoice_name,'D'); // opens in browser


}


public function downloadomsmachinary($id){

    $getblastingdetailsforinvoice = $this->admin_model->getblastingdetailsforinvoice($id);
    $getblastingItemdeatilsForInvoice = $this->admin_model->getblastingItemdeatilsForInvoice($id);

    $mpdf = new \Mpdf\Mpdf();
    // $html = $this->load->view('html_to_pdf',[],true);
    $html = '<table style=" width: 100%;border-collapse: collapse;border: #cccccc 0px solid;font-family:Times New Roman;font-size:13px">
                <tr style="border: 1px solid black;" valign="top">
                    <td width="50%" style="padding: 8px;text-align: left;">
                        <p><h3 style="color:#000080">SUPRA QUALITY EXPORTS INDIA PVT LTD </h3></p>
                        <p>229 to 232, Bharat Industrial Estate,</p>
                        <p>L.B.S. Marg, Bhandup West, Mumbai – 400078. INDIA.</p>
                        <p></p>
                        <p></p>
                        <p><span style="color:#000080">GSTIN : 27AAJCS7869M1ZB</span></p>
                    </td> 

                    <td style="border-left: 1px solid black;padding: 8px;" width="50%" valign="top">
                          <p style="text-align: center"><h4>DELIVERY CHALLAN</h4></p>
                          <p style="text-align: left;"> Movement of inputs or partially processed goods
                            for job work under Rule 55 of the Central Goods
                            & Service Tax Rules.20l7. from one factory to
                            another factory for further processing / operation.
                          </p>
                    </td>
                </tr>
           
                <tr style="border: 1px solid black;padding: 8px;">
                    <td width="50%" style="padding: 8px;text-align: left;">
                       Sr. No. : <span style="color:red">'.$getblastingdetailsforinvoice['blasting_id'].'-B '.date('d-m-Y',strtotime($getblastingdetailsforinvoice['date'])).'</span>
                    </td> 

                    <td style="border-left: 1px solid black;padding: 8px;" width="50%" valign="top">
                       <input type="checkbox" style="width: 100px;height: 100px;zoom:5;"> Original  <input type="checkbox"> Duplicate  <input type="checkbox"> Triplicate
                    </td>
                </tr>

                <tr style="border: 1px solid black;">
                    <td width="50%" style="padding: 8px;text-align: left;valign="top"">
                        <p>'. str_repeat('&nbsp;', 5).'</p>
                    </td> 

                    <td style="border-left: 1px solid black;padding: 8px;" width="50%" valign="top">
                        <p>Part-II </p>
                        <p>to be filled by the processing factory in original and duplicate challans. </p>
                    </td>
                </tr>

                <tr style="border: 1px solid black;">
                    <td width="50%" style="padding: 8px;text-align: left;">
                         <p>1. Description </p>
                         <p>'.$getblastingItemdeatilsForInvoice[0]['type_of_raw_material'].'</p>
                    </td> 

                    <td style="border-left: 1px solid black;padding: 8px;" width="50%" valign="top">
                        <p>1. Details of type,qty, date & time of processing done and Return of processed goods to parent factory </p>
                    </td>
                </tr>
            </table>

            <table style=" width: 100%;border-collapse: collapse;border: #cccccc 0px solid;font-family:Times New Roman;font-size:13px;">
                <tr style="border-left: 1px solid black;border-right: 1px solid black;border-bottom: 1px solid black;">
                    <td style="text-align:left;padding: 8px;">'.str_repeat('&nbsp;', 2).'</td> 
                    <td style="border-left: 1px solid black;padding:5px;" width="10%">'.str_repeat('&nbsp;', 2).'</td>
                    <td style="border-left: 1px solid black;padding:5px;" width="10%">'.str_repeat('&nbsp;', 2).'</td>
                    <td style="border-left: 1px solid black;padding:5px;" width="10%">'.str_repeat('&nbsp;', 2).'</td>
                    <td style="border-left: 1px solid black;padding:5px;" width="10%">'.str_repeat('&nbsp;', 2).'</td>
                    <td style="border-left: 1px solid black;padding:5px;" width="50%">'.str_repeat('&nbsp;', 2).'</td>
                </tr>
            </table>


            <table style=" width: 100%;border-collapse: collapse;border: #cccccc 0px solid;font-family:Times New Roman;font-size:13px;">
                
                <tr style="border-left: 1px solid black;border-right: 1px solid black;border-bottom: 1px solid black;">
                    <td style="text-align:left;padding: 8px;"          width="50%">2. Identification marks & number if any</td> 
                    <td style="border-left: 1px solid black;padding: 8px;">Size / Type</td>
                    <td style="border-left: 1px solid black;padding: 8px;" >Quantity</td>
                    <td style="border-left: 1px solid black;padding: 8px;" >Date</td>
                    <td style="border-left: 1px solid black;padding: 8px;" >Time</td>
                </tr>

                <tr style="border-left: 1px solid black;border-right: 1px solid black;">
                    <td style="padding-left: 10px;text-align: left;"  width="50%">
                       <p> 3. Quantity (Nos. / Weight / Metre /Litre) </p>
                     </td> 
                    <td style="border-left: 1px solid black;padding-left: 10px;">1</td>
                    <td style="border-left: 1px solid black;padding-left: 10px;"></td>
                    <td style="border-left: 1px solid black;padding-left: 10px;"></td>
                    <td style="border-left: 1px solid black;padding-left: 10px;"></td>
                </tr>


                <tr style="border-left: 1px solid black;border-right: 1px solid black;">
                    <td style="padding-left: 10px;text-align: left;"  width="50%">
                       <p> Gross Weight: '.$getblastingItemdeatilsForInvoice[0]['gross_weight_oms'].' kgs </p>
                     </td> 
                    <td style="border-left: 1px solid black;padding-left: 10px;"></td>
                    <td style="border-left: 1px solid black;padding-left: 10px;"></td>
                    <td style="border-left: 1px solid black;padding-left: 10px;"></td>
                    <td style="border-left: 1px solid black;padding-left: 10px;"></td>
                </tr>


                <tr style="border-left: 1px solid black;border-right: 1px solid black;">
                    <td style="padding-left: 10px;text-align: left;"  width="50%">
                      <p> Net Weight:   '.$getblastingItemdeatilsForInvoice[0]['net_weight_oms'].' kgs </p>
                    </td> 
                    <td style="border-left: 1px solid black;padding-left: 10px;">2</td>
                    <td style="border-left: 1px solid black;padding-left: 10px;"></td>
                    <td style="border-left: 1px solid black;padding-left: 10px;"></td>
                    <td style="border-left: 1px solid black;padding-left: 10px;"></td>
                </tr>


                <tr style="border-left: 1px solid black;border-right: 1px solid black;">
                    <td style="padding-left: 10px;text-align: left;"  width="50%">
                    <p> Quantity:   '.$getblastingItemdeatilsForInvoice[0]['qty'].' Pcs</p>
                    </td> 
                    <td style="border-left: 1px solid black;padding-left: 10px;"></td>
                    <td style="border-left: 1px solid black;padding-left: 10px;"></td>
                    <td style="border-left: 1px solid black;padding-left: 10px;"></td>
                    <td style="border-left: 1px solid black;padding-left: 10px;"></td>
                </tr>


                <tr style="border-left: 1px solid black;border-right: 1px solid black;">
                        <td style="text-align: left;border-right: 1px solid black;border-bottom: 1px solid black"  width="50%">
                         <p>'.str_repeat('&nbsp;', 1).' No. of Bags:  '.$getblastingItemdeatilsForInvoice[0]['no_of_bags'].' Bags</p>
                        </td> 
                        <hr style="margin-left: 10px;"></hr>
                        <td style="border-left: 1px solid black;padding-left: 10px;">3</td>
                        <td style="border-left: 1px solid black;padding-left: 10px;"></td>
                        <td style="border-left: 1px solid black;padding-left: 10px;"></td>
                        <td style="border-left: 1px solid black;padding-left: 10px;"></td>
                </tr>


                <tr style="border-left: 1px solid black;border-right: 1px solid black;">
                    <td style="text-align: left;border-right: 1px solid black;border-bottom: 1px solid black"  width="50%">
                       <p>'.str_repeat('&nbsp;', 1).' 4. HSN NO: '.$getblastingItemdeatilsForInvoice[0]['hsn_code'].'  </p>
                    </td> 
                    <hr style="margin-left: 10px;"></hr>
                    <td style="border-left: 1px solid black;padding-left: 10px;">4</td>
                    <td style="border-left: 1px solid black;padding-left: 10px;"></td>
                    <td style="border-left: 1px solid black;padding-left: 10px;"></td>
                    <td style="border-left: 1px solid black;padding-left: 10px;"></td>
                </tr>


                <tr style="border-left: 1px solid black;border-right: 1px solid black;">
                    <td style="padding-left: 10px;text-align: left;border-right: 1px solid black"  width="50%">
                    <p> 5. Estimated Value of inputs / Partially processed inputs  </p>
                     <p>'.$getblastingItemdeatilsForInvoice[0]['calculation'].'</p>
                   
                    </td> 
                    <td style="border-left: 1px solid black;padding-left: 10px;">5</td>
                    <td style="border-left: 1px solid black;padding-left: 10px;"></td>
                    <td style="border-left: 1px solid black;padding-left: 10px;"></td>
                    <td style="border-left: 1px solid black;padding-left: 10px;"></td>
                </tr>


                <tr style="border-left: 1px solid black;border-right: 1px solid black;">
                    <td style="padding-left: 10px;text-align: left;border-right: 1px solid black"  width="50%">
                    <p>  </p>
                    </td> 
                    <td style="border-left: 1px solid black;padding-left: 10px;">6</td>
                    <td style="border-left: 1px solid black;padding-left: 10px;"></td>
                    <td style="border-left: 1px solid black;padding-left: 10px;"></td>
                    <td style="border-left: 1px solid black;padding-left: 10px;"></td>
                </tr>
            </table>
            
            <table style=" width: 100%;border-collapse: collapse;border: #cccccc 0px solid;font-family:Times New Roman;font-size:13px;">

                <tr style="border: 1px solid black;">
                    <td width="50%" style="padding: 8px;text-align: left;">
                        <p>6.Date & Time of Issue : '.date('d-m-Y',strtotime($getblastingdetailsforinvoice['date'])).'</p>
                    </td> 

                    <td style="border-left: 1px solid black;padding: 8px;" width="50%" valign="top">
                        <p>2. Nature of Proc. / Manufacturing done</p>
                    </td>
                </tr>

                <tr style="border: 1px solid black;">
                    <td width="50%" style="padding: 8px;text-align: left;">
                        <p>7. Nature of processing:</p>
                        <p>'.$getblastingItemdeatilsForInvoice[0]['name'].'  Part Number - '.$getblastingItemdeatilsForInvoice[0]['part_number'].'</p>
                    </td> 

                    <td style="border-left: 1px solid black;padding-left: 10px;" width="50%" valign="top">
                        <p>3. Qty of waste material / rejection returned to the factory &</p>
                    </td>
                </tr>


                <tr style="border: 1px solid black;">
                <td width="50%" style="padding: 8px;text-align: left;">
                    <p>Against P.O.No: '.$getblastingdetailsforinvoice['vendor_po_number'].' dated '.date('d-m-Y',strtotime($getblastingdetailsforinvoice['v_po_date'])).'</p>
                </td> 

                <td style="border-left: 1px solid black;padding-left: 10px;" width="50%" valign="top">
                    <p></p>
                </td>
            </tr>

                <tr style="border: 1px solid black;">
                    <td width="50%" style="padding: 8px;text-align: left;">
                        <p>8. Factory / Place of processing / Manufacturing : '.$getblastingdetailsforinvoice['vendor_name'].' </p>
                        <p>'.$getblastingdetailsforinvoice['ven_address'].'</p>
                        <p style="color:#000080">GSTIN : '.$getblastingdetailsforinvoice['ven_GSTIN'].'</p>
                    </td> 

                    <td style="border-left: 1px solid black;padding: 8px;" width="50%" valign="top">
                        <p>4. Name & Address of the Processor:</p>
                    </td>
                </tr>

                
                <tr style="border: 1px solid black;">
                    <td width="50%" style="padding: 8px;text-align: left;">
                        <p style="vertical-align: text-top;font-size:12px;color:#000080"><b>FOR SUPRA QUALITY EXPORTS (I) PVT. LTD.</b></p>
                        <p>'.date('d-m-Y').'</p>
                        <p>Place: Mumbai</p>
                       
                        <br/><img src="'.base_url().'assets/images/stmps/supplierpostampsignature.png" width="130" height="100">
                        <p style="vertical-align: text-top;font-size:10px;color:#000080;text-align: right;"><b>AUTHORIZED SIGNATORY</b></p>

                    </td> 

                    <td style="border-left: 1px solid black;padding: 8px;" width="50%" valign="top">
                        <p>5. Signature of Processor </p>
                    </td>
                </tr>
            </table>
            
            ';

            // <p>FOR SUPRA QUALITY EXPORTS (I) PVT. LTD.</p>
    $invoice_name =  $getblastingdetailsforinvoice['blasting_id'].'-B-'.$getblastingdetailsforinvoice['vendor_name'].'.pdf';
    $mpdf->WriteHTML($html);
    $mpdf->Output($invoice_name,'D'); // opens in browser


}

public function getinvoicedetilsbyinvoiceid(){

    $invoice_number=$this->input->post('invoice_number');
    if($invoice_number) {
        $invoice_number_data = $this->admin_model->getinvoicedetilsbyinvoiceid($invoice_number);
        if(count($invoice_number_data) >= 1) {
            echo json_encode($invoice_number_data[0]);
        } else {
            echo 'failure';
        }
    } else {
        echo 'failure';
    }

}

public function getcreditnotedetailsbycreditnoteid(){

    $credit_note_number=$this->input->post('credit_note_number');
    if($credit_note_number) {
        $credit_note_number_data = $this->admin_model->getcreditnotedetailsbycreditnoteid($credit_note_number);
        if(count($credit_note_number_data) >= 1) {
            echo json_encode($credit_note_number_data[0]);
        } else {
            echo 'failure';
        }
    } else {
        echo 'failure';
    }
}

public function getdebitnotedetailsbydebitenoteeid(){

    $debit_note_number=$this->input->post('debit_note_number');
    if($debit_note_number) {
        $debit_note_number_data = $this->admin_model->getdebitnotedetailsbydebitenoteeid($debit_note_number);
        if(count($debit_note_number_data) >= 1) {
            echo json_encode($debit_note_number_data[0]);
        } else {
            echo 'failure';
        }
    } else {
        echo 'failure';
    }
}

public function deletesalestracking(){
    $post_submit = $this->input->post();
    if($post_submit){
        $result = $this->admin_model->deletesalestracking(trim($this->input->post('id')));
        if ($result) {
                    $process = 'Sales Tracking Delete';
                    $processFunction = 'Admin/deletesalestracking';
                    $this->logrecord($process,$processFunction);
                echo(json_encode(array('status'=>'success')));
            }
        else { echo(json_encode(array('status'=>'failed'))); }
    }else{
        echo(json_encode(array('status'=>'failed'))); 
    }
}

public function getnumberofcartoonsfrompreexport(){

    $get_numberofcartoons=$this->input->post('get_numberofcartoons');
    if($get_numberofcartoons) {
        $get_numberofcartoons_data = $this->admin_model->get_numberofcartoons($get_numberofcartoons);
        if(count($get_numberofcartoons_data) >= 1) {
            echo json_encode($get_numberofcartoons_data[0]);
        } else {
            echo 'failure';
        }
    } else {
        echo 'failure';
    }
}

public function editsalestrackingreport($id){
    $process = 'Edit Tracking Report';
    $processFunction = 'Admin/editsalestrackingreport';
    $this->logrecord($process,$processFunction);
    $this->global['pageTitle'] = 'Edit Tracking Report';
    $data['getsalestrackingdetailsforedit']= $this->admin_model->getsalestrackingdetailsforedit($id);
    $data['invoicenumberfromPackaging']= $this->admin_model->invoicenumberfromPackaging();
    $data['getchamaster']= $this->admin_model->getchamaster();
    $data['getcreditnotenumber']= $this->admin_model->getcreditnotenumber();
    $data['getdebitenotenumber']= $this->admin_model->getdebitenotenumber();
    $this->loadViews("masters/editsalestrackingreport", $this->global, $data, NULL);
}

public function checkifpartnumberisalreadyexists(){

    $post_submit = $this->input->post();
    if($post_submit){

       $part_number =  trim($this->input->post('part_number'));
       $main_id =  trim($this->input->post('main_id'));

       if($part_number && $main_id ){

            $checkifpartnumberisalreadyexists = $this->admin_model->checkifpartnumberisalreadyexists($part_number,$main_id);
            if(count($checkifpartnumberisalreadyexists) >= 1) {

                echo 'success';
            }else{

                echo 'failure';
            }
       }else{
        echo 'failure';
       }
    }else{

        echo 'failure';
    }

}

public function downloadcomplainform($id){

    $getcompalinformdetailsforInvoice = $this->admin_model->getcompalinformdetailsforInvoice($id);


    $mpdf = new \Mpdf\Mpdf();
    // $html = $this->load->view('html_to_pdf',[],true);
    $html = '<table style=" width: 100%;border-collapse: collapse;border: #cccccc 0px solid;font-family:Times New Roman;font-size:12px;">
                <tr style="border: 1px solid black;" valign="top">
                    <td width="20%" style="padding: 5px;text-align: center;">
                        <p><h6 style="color:#000080">SUPRA QUALITY EXPORTS INDIA PVT LTD </h6></p>
                    </td> 

                    <td width="55%"  style="text-align: center;border-left: 1px solid black;padding: 5px;">
                          <p style="text-align: center;color:#000080"><h2>Analysis and Corrective Action Report</h2></p>
                    </td>

                    <td width="30%" style="border-left: 1px solid black;padding: 5px;" valign="top">
                        <p style="font-size:13px;">Format No:-001 </p>
                        <p>Rev. No. 001 </p>
                        <p>Report No=</p>
                    </td>
                </tr>
            </table>

            <table style=" width: 100%;border-collapse: collapse;border: #cccccc 0px solid;font-family:Times New Roman;font-size:12px;">
                <tr style="border: 1px solid black;" valign="top">
                    <td width="25%" style="padding: 5px;text-align: left;">
                        <p>STAGE :  INCOMING / INPROCESS /  FINAL INSPECTION / AT CUSTOMER /
                        AT SUPPLIER END</p>
                    </td> 

                    <td width="25%"  style="border-left: 1px solid black;padding: 5px;" valign="top">
                          <p style="text-align: center">'.$getcompalinformdetailsforInvoice['stage'].'</p>
                    </td>

                    <td width="25%" style="border-left: 1px solid black;padding: 5px;" valign="top">
                        <p style="font-size:13px;">DATE OF OBSERVATION /  REJECTION FOUND:</p>
                    </td>

                    <td width="30%" style="border-left: 1px solid black;padding: 5px;" valign="top">
                        <p>'.$getcompalinformdetailsforInvoice['date_of_observation_rejection_found'].' </p>
                    </td>
                </tr>
            </table>

            <table style=" width: 100%;border-collapse: collapse;border: #cccccc 0px solid;font-family:Times New Roman;font-size:12px;">
                <tr style="border: 1px solid black;" valign="top">
                    <td width="25%" style="padding: 5px;text-align: left;">
                        <p>DRAWING NO / REV NO :</p>
                    </td> 

                    <td width="25%"  style="border-left: 1px solid black;padding: 5px;" valign="top">
                        <p>'.$getcompalinformdetailsforInvoice['drawing_no_rev_no'].'</p>
                    </td>

                    <td width="25%" style="border-left: 1px solid black;padding: 5px;" valign="top">
                        <p style="font-size:13px;">
                         CHALLAN NO :
                         PO NO / WO NO :
                         INWARD NO :</p>
                    </td>

                    <td width="30%" style="border-left: 1px solid black;padding: 5px;" valign="top">
                        <p> '.$getcompalinformdetailsforInvoice['challan_no'].'</p>
                    </td>
                </tr>
            </table>


            <table style=" width: 100%;border-collapse: collapse;border: #cccccc 0px solid;font-family:Times New Roman;font-size:12px;">
                <tr style="border: 1px solid black;" valign="top">
                    <td width="25%" style="padding: 5px;text-align: left;">
                        <p>COMPONENT DESCRIPTION :</p>
                    </td> 

                    <td width="25%"  style="border-left: 1px solid black;padding: 5px;" valign="top">
                        <p>'.$getcompalinformdetailsforInvoice['component_description'].'</p>
                    </td>

                    <td width="25%" style="border-left: 1px solid black;padding: 5px;" valign="top">
                        <p style="font-size:13px;">TOTAL QTY CHECKED :</p>
                    </td>

                    <td width="30%" style="border-left: 1px solid black;padding: 5px;" valign="top">
                        <p>'.$getcompalinformdetailsforInvoice['total_qty_checked'].' </p>
                    </td>
                </tr>
            </table>


            <table style=" width: 100%;border-collapse: collapse;border: #cccccc 0px solid;font-family:Times New Roman;font-size:12px;">
                <tr style="border: 1px solid black;" valign="top">
                    <td width="25%" style="padding: 5px;text-align: left;">
                        <p>PROBLEM OCCURS AT CUSTOMER END / SUPPLIER END/INITIAL STAGE :</p>
                    </td> 

                    <td width="25%"  style="border-left: 1px solid black;padding: 5px;" valign="top">
                      <p>'.$getcompalinformdetailsforInvoice['problem_description'].' </p>
                    </td>

                    <td width="25%" style="border-left: 1px solid black;padding: 5px;" valign="top">
                        <p style="font-size:13px;">TOTAL FAILURE QTY :</p>
                    </td>

                    <td width="30%" style="border-left: 1px solid black;padding: 5px;" valign="top">
                      <p>'.$getcompalinformdetailsforInvoice['total_failure_qty'].' </p>
                    </td>
                </tr>
           </table>


           <table style=" width: 100%;border-collapse: collapse;border: #cccccc 0px solid;font-family:Times New Roman;font-size:12px;">
                   <tr style="border: 1px solid black;" valign="top">
                      <td width="25%" style="padding: 5px;text-align: left;">
                        <p>1. PROBLEM DESCRIPTION :</p>
                      </td>
                    </tr>
           </table>

           <table style=" width: 100%;border-collapse: collapse;border: #cccccc 0px solid;font-family:Times New Roman;font-size:12px;">
                <tr style="border: 1px solid black;" valign="top">
                <td width="25%" style="padding: 5px;text-align: left;">
                    <p>'.$getcompalinformdetailsforInvoice['problem_description'].' </p>
                    <p>'.str_repeat('&nbsp;', 5).'</p>
                </td>
                </tr>
          </table>

          <table style=" width: 100%;border-collapse: collapse;border: #cccccc 0px solid;font-family:Times New Roman;font-size:12px;">
            <tr style="border: 1px solid black;" valign="top">
                <td width="25%" style="padding: 5px;text-align: left;">
                <p>2. INTERMIDIATE DISPOSAL :</p>
                </td>
            </tr>
            </table>

            <table style=" width: 100%;border-collapse: collapse;border: #cccccc 0px solid;font-family:Times New Roman;font-size:12px;">
                <tr style="border: 1px solid black;" valign="top">
                <td width="25%" style="padding: 5px;text-align: left;">
                    <p>'.$getcompalinformdetailsforInvoice['intermidiate_disposal'].' </p>
                    <p>'.str_repeat('&nbsp;', 5).'</p>
                </td>
                </tr>
            </table>

            <table style=" width: 100%;border-collapse: collapse;border: #cccccc 0px solid;font-family:Times New Roman;font-size:12px;">
             <tr style="border: 1px solid black;" valign="top">
                <td width="25%" style="padding: 5px;text-align: left;">
                <p>3. ROOT CAUSE(S) : </p>
                </td>
             </tr>
            </table>

            <table style=" width: 100%;border-collapse: collapse;border: #cccccc 0px solid;font-family:Times New Roman;font-size:12px;">
                <tr style="border: 1px solid black;" valign="top">
                <td width="25%" style="padding: 5px;text-align: left;">
                    <p>'.$getcompalinformdetailsforInvoice['root_cause'].' </p>
                    <p>'.str_repeat('&nbsp;', 5).'</p>
                </td>
                </tr>
            </table>


            <table style=" width: 100%;border-collapse: collapse;border: #cccccc 0px solid;font-family:Times New Roman;font-size:12px;">
                <tr style="border: 1px solid black;" valign="top">
                    <td width="70%" style="padding: 5px;text-align: left;border-right:1px solid black;">
                       <p>4. CORRECTION : </p>
                    </td>

                    <td width="20%" style="padding: 5px;text-align: left;border-right:1px solid black;">
                       <p>RESPONSIBILITY</p>
                    </td>

                    <td width="12%" style="padding: 5px;text-align: left;">
                       <p>DATE</p>
                    </td>
                </tr>
           </table>

           <table style=" width: 100%;border-collapse: collapse;border: #cccccc 0px solid;font-family:Times New Roman;font-size:12px;">
                <tr style="border: 1px solid black;" valign="top">
                <td width="70%" style="padding: 5px;text-align: left;border-right:1px solid black;">
                    <p>'.$getcompalinformdetailsforInvoice['coorection'].' </p>
                    <p>'.str_repeat('&nbsp;', 5).'</p>
                    <p>'.str_repeat('&nbsp;', 5).'</p>
                </td>

                <td width="20%" style="padding: 5px;text-align: left;border-right:1px solid black;">
                    <p>'.$getcompalinformdetailsforInvoice['coorection_responsibility'].' </p>
                    <p>'.str_repeat('&nbsp;', 5).'</p>
                    <p>'.str_repeat('&nbsp;', 5).'</p>
                </td>

                <td width="12%" style="padding: 5px;text-align: left;">
                    <p>'.$getcompalinformdetailsforInvoice['coorection_date'].' </p>
                    <p>'.str_repeat('&nbsp;', 5).'</p>
                    <p>'.str_repeat('&nbsp;', 5).'</p>
                </td>
            </tr>
          </table>

          <table style=" width: 100%;border-collapse: collapse;border: #cccccc 0px solid;font-family:Times New Roman;font-size:12px;">
          <tr style="border: 1px solid black;" valign="top">
              <td width="70%" style="padding: 5px;text-align: left;border-right:1px solid black;">
                 <p> 5. CORRECTIVE ACTION TAKEN : </p>
              </td>

              <td width="20%" style="padding: 5px;text-align: left;border-right:1px solid black;">
                 <p>RESPONSIBILITY</p>
              </td>

              <td width="12%" style="padding: 5px;text-align: left;">
                 <p>DATE</p>
              </td>
          </tr>
        </table>

        <table style=" width: 100%;border-collapse: collapse;border: #cccccc 0px solid;font-family:Times New Roman;font-size:12px;">
          <tr style="border: 1px solid black;" valign="top">
          <td width="70%" style="padding: 5px;text-align: left;border-right:1px solid black;">
              <p>'.$getcompalinformdetailsforInvoice['corrective_action_taken'].' </p>
              <p>'.str_repeat('&nbsp;', 5).'</p>
          </td>

          <td width="20%" style="padding: 5px;text-align: left;border-right:1px solid black;">
              <p>'.$getcompalinformdetailsforInvoice['corrective_action_responsibility'].' </p>
              <p>'.str_repeat('&nbsp;', 5).'</p>
          </td>

          <td width="12%" style="padding: 5px;text-align: left;">
               <p>'.$getcompalinformdetailsforInvoice['corrective_action_date'].' </p>
               <p>'.str_repeat('&nbsp;', 5).'</p>
          </td>
      </tr>
    </table>

       <table style=" width: 100%;border-collapse: collapse;border: #cccccc 0px solid;font-family:Times New Roman;font-size:12px;">
          <tr style="border: 1px solid black;" valign="top">
              <td width="70%" style="padding: 5px;text-align: left;border-right:1px solid black;">
                 <p> 6. EFFECTIVE ACTION : </p>
              </td>

              <td width="20%" style="padding: 5px;text-align: left;border-right:1px solid black;">
                 <p>RESPONSIBILITY</p>
              </td>

              <td width="12%" style="padding: 5px;text-align: left;">
                 <p>DATE</p>
              </td>
          </tr>
        </table>

        <table style=" width: 100%;border-collapse: collapse;border: #cccccc 0px solid;font-family:Times New Roman;font-size:12px;">
          <tr style="border: 1px solid black;" valign="top">
          <td width="70%" style="padding: 5px;text-align: left;border-right:1px solid black;">
              <p>'.$getcompalinformdetailsforInvoice['effective_action'].' </p>
              <p>'.str_repeat('&nbsp;', 5).'</p>
          </td>

          <td width="20%" style="padding: 5px;text-align: left;border-right:1px solid black;">
              <p>'.$getcompalinformdetailsforInvoice['effective_action_responsiblity'].' </p>
              <p>'.str_repeat('&nbsp;', 5).'</p>
          </td>

          <td width="12%" style="padding: 5px;text-align: left;">
              <p>'.$getcompalinformdetailsforInvoice['effective_action_date'].' </p>
              <p>'.str_repeat('&nbsp;', 5).'</p>
          </td>
      </tr>
    </table>
    

    <table style=" width: 100%;border-collapse: collapse;border: #cccccc 0px solid;font-family:Times New Roman;font-size:12px;">
          <tr style="border: 1px solid black;" valign="top">
              <td width="43%" style="padding: 5px;text-align: left;border-right:1px solid black;">
                 <p> 7. TEAM :</p>
              </td>

              <td width="15%" style="padding: 5px;text-align: left;border-right:1px solid black;">
                <p>PREPARED BY</p>
              </td>

              <td width="12%" style="padding: 5px;text-align: left;border-right:1px solid black;">
                 <p>DATE</p>
              </td>

              <td width="20%" style="padding: 5px;text-align: left;border-right:1px solid black;">
                 <p>APPROVED BY</p>
              </td>

              <td width="12%" style="padding: 5px;text-align: left;">
                 <p>DATE</p>
              </td>
          </tr>
        </table>

        <table style=" width: 100%;border-collapse: collapse;border: #cccccc 0px solid;font-family:Times New Roman;font-size:12px;">
          <tr style="border: 1px solid black;" valign="top">
          <td width="43%" style="padding: 5px;text-align: left;border-right:1px solid black;">
              <p>'.$getcompalinformdetailsforInvoice['team'].' </p>
              <p>'.str_repeat('&nbsp;', 5).'</p>
          </td>

            <td width="15%" style="padding: 5px;text-align: left;border-right:1px solid black;">
                <p>'.$getcompalinformdetailsforInvoice['prepared_by'].' </p>
                <p>'.str_repeat('&nbsp;', 5).'</p>
            </td>

            <td width="12%" style="padding: 5px;text-align: left;border-right:1px solid black;">
                <p>'.$getcompalinformdetailsforInvoice['prepared_by_date'].' </p>
                <p>'.str_repeat('&nbsp;', 5).'</p>
            </td>


          <td width="20%" style="padding: 5px;text-align: left;border-right:1px solid black;">
              <p>'.$getcompalinformdetailsforInvoice['approved_by'].' </p>
              <p>'.str_repeat('&nbsp;', 5).'</p>
          </td>

          <td width="12%" style="padding: 5px;text-align: left;">
              <p>'.$getcompalinformdetailsforInvoice['approved_by_date'].' </p>
              <p>'.str_repeat('&nbsp;', 5).'</p>
          </td>
      </tr>
    </table>


    <table style=" width: 100%;border-collapse: collapse;border: #cccccc 0px solid;font-family:Times New Roman;font-size:12px;">
          <tr style="border: 1px solid black;" valign="top">
              <td width="70%" style="padding: 5px;text-align: left;border-right:1px solid black;">
                 <p> 8. REPORT CLOSED BY  : </p>
              </td>

              <td width="20%" style="padding: 5px;text-align: left;border-right:1px solid black;">
                 <p>RESPONSIBILITY</p>
              </td>

              <td width="12%" style="padding: 5px;text-align: left;">
                 <p>DATE</p>
              </td>
          </tr>
        </table>

        <table style=" width: 100%;border-collapse: collapse;border: #cccccc 0px solid;font-family:Times New Roman;font-size:12px;">
          <tr style="border: 1px solid black;" valign="top">
          <td width="70%" style="padding: 5px;text-align: left;border-right:1px solid black;">
              <p>'.$getcompalinformdetailsforInvoice['report_closed_by'].' </p>
              <p>'.str_repeat('&nbsp;', 5).'</p>
          </td>

          <td width="20%" style="padding: 5px;text-align: left;border-right:1px solid black;">
              <p>'.$getcompalinformdetailsforInvoice['report_closed_by'].' </p>
              <p>'.str_repeat('&nbsp;', 5).'</p>
          </td>

          <td width="12%" style="padding: 5px;text-align: left;">
              <p>'.$getcompalinformdetailsforInvoice['report_close_date'].' </p>
              <p>'.str_repeat('&nbsp;', 5).'</p>
          </td>
      </tr>
    </table>';

            // <p>FOR SUPRA QUALITY EXPORTS (I) PVT. LTD.</p>
    $invoice_name =  'Analysis & Corrective Action Report final-'.$getcompalinformdetailsforInvoice['report_no'].'.pdf';
    $mpdf->WriteHTML($html);
    $mpdf->Output($invoice_name,'D'); // opens in browser
    
}

public function downloadpreexportform($id){

    $getpreexportdetailsforInvoice = $this->admin_model->getpreexportdetailsforInvoice($id);
    $getpreexportdetailsitemsforInvoice = $this->admin_model->getpreexportdetailsitemsforInvoice($id);
    //$getpreexportdetailsitemsAttributeforInvoice = $this->admin_model->getpreexportdetailsitemsAttributeforInvoice($id);
    $getpreexportallcountdataforinvoice = $this->admin_model->getpreexportallcountdataforinvoice($id);

    $CartItem = '';
    $i =1;

   

     foreach ($getpreexportdetailsitemsforInvoice as $key => $value) {

        $getpreexportdetailsitemsAttributeforInvoice = $this->admin_model->getpreexportdetailsitemsAttributeforInvoice($value['pre_export_id'],$value['itemidwwww']);
        $CartItemattribute='';

        $gross_per_box_weight =0;
        $no_of_cartoons =0;
        $per_box_PCS =0;
        $total_qty =0;
        $total_gross_weight = 0;
        $total_net_weight =0;
    

        foreach ($getpreexportdetailsitemsAttributeforInvoice as $key => $value1) {
            $CartItemattribute .= '
                    <tr style=" border-bottom: 1px solid #000;">
                        <td style="text-align:left;padding: 5px;border: 1px solid black;" valign="top">'.$value1['gross_per_box_weight'].' kgs</br></td>   
                        <td style="text-align:left;padding: 5px;border: 1px solid black;" valign="top">'.$value1['no_of_cartoons'].' ctns </td>
                        <td style="text-align:left;padding: 5px;border: 1px solid black;" valign="top">'.$value1['per_box_PCS'].' pcs</td>
                        <td style="text-align:left;padding: 5px;border: 1px solid black;" valign="top">'.$value1['total_qty'].' pcs</td> 
                        <td style="text-align:left;padding: 5px;border: 1px solid black;" valign="top" >'.$value1['tg'].' kgs</td>   
                        <td style="text-align:left;padding: 5px;border: 1px solid black;" valign="top" >'.$value1['attribute_remark'].'</td>    
                        <td style="text-align:left;padding: 5px;border: 1px solid black;" valign="top" ></td>     
                    </tr>';  
                    
                    $gross_per_box_weight += $value1['gross_per_box_weight'];
                    $no_of_cartoons += $value1['no_of_cartoons'];
                    $per_box_PCS += $value1['per_box_PCS'];
                    $total_qty += $value1['total_qty'];

                    $total_gross_weight += $value1['tg'];

                    $total_net_weight += $value1['total_net_weight_item'];
        }
    

           $CartItem .= '<div>
                        <p><b>'.$i.') '.$value['name'].'</b></p>
                        <p>'.$value['part_number'].' </p>
                        <p>'.$value['item_remark'].'</p>
                    </div>
                    <table style=" width: 100%;border-collapse: collapse;border: #cccccc 0px solid;font-family:Times New Roman;font-size:12px;border: 1px solid black;">
                    <tr>
                        <td style="text-align:left;padding: 5px;border: 1px solid black;" valign="top"><b>Gross Wt per Box</b></td>   
                        <td style="text-align:left;padding: 5px;border: 1px solid black;" valign="top"><b>No. of Cartoons</b></td>
                        <td style="text-align:left;padding: 5px;border: 1px solid black;" valign="top"><b>Qty Per Qty</b></td>
                        <td style="text-align:left;padding: 5px;border: 1px solid black;" valign="top"><b>Total Qty</b></td> 
                        <td style="text-align:left;padding: 5px;border: 1px solid black;" valign="top"><b>Gross Weight with Ctns</b></td>  
                        <td style="text-align:left;padding: 5px;border: 1px solid black;" valign="top"><b>Box Size</b></td>    
                        <td style="text-align:left;padding: 5px;border: 1px solid black;" valign="top"><b>Net Weight</b></td>    
                    </tr>
                       '.$CartItemattribute.'
                        <tr>
                                <td style="text-align:left;padding: 5px;border: 1px solid black;" valign="top"><b>Total</b></td>   
                                <td style="text-align:left;padding: 5px;border: 1px solid black;" valign="top"><b>'.$no_of_cartoons.' ctns </b></td>
                                <td style="text-align:left;padding: 5px;border: 1px solid black;" valign="top"><b></td>
                                <td style="text-align:left;padding: 5px;border: 1px solid black;" valign="top"><b>'.$total_qty.' pcs</b></td> 
                                <td style="text-align:left;padding: 5px;border: 1px solid black;" valign="top"><b>'.number_format($total_gross_weight,3).' kgs</b></td>   
                                <td style="text-align:left;padding: 5px;border: 1px solid black;" valign="top"> </td>   
                                <td style="text-align:left;padding: 5px;border: 1px solid black;" valign="top"><b>'.number_format($total_net_weight,3).' kgs</b></td>    
                        </tr>
                    </table>';
            $i++;
     }


    
    $mpdf = new \Mpdf\Mpdf();
    // $html = $this->load->view('html_to_pdf',[],true);
    $html = '<div style="text-align:center"> 
                 <p>'.$getpreexportdetailsforInvoice['buyer_name'].' - '.$getpreexportdetailsforInvoice['mode_of_shipment'].'</p>
            </div>'.$CartItem.'
                
            <div>
                    <p><b>Total ctns : </b> '.$getpreexportallcountdataforinvoice[0]['total_no_of_carttons'].'</p>
                    <p><b>Total Nt.Weight : </b>'.number_format($getpreexportallcountdataforinvoice[0]['total_net_weight_of_shipment'],3).' kgs</p>
                    <p><b>Total Gr.Weight : </b>'.number_format($getpreexportallcountdataforinvoice[0]['total_gross_only'],3).' kgs</p>
                    <p><b>Total No of Pallets : </b>'.$getpreexportallcountdataforinvoice[0]['tnp'].'</p>
                    <p><b>Total Weight of Pallets : </b>'.$getpreexportallcountdataforinvoice[0]['twp'].' kgs</p>
                    <p><b>Final Gross Weight : </b>'.$getpreexportallcountdataforinvoice[0]['total_gross_shipment_weight'].' kgs</p>
            </div>';

            // <p>FOR SUPRA QUALITY EXPORTS (I) PVT. LTD.</p>
    $invoice_name =  $getpreexportdetailsforInvoice['pre_export_invoice_no'].'.pdf';
    $mpdf->WriteHTML($html);
    $mpdf->Output($invoice_name,'D'); // opens in browser

}

public function chadebitnote(){
    $process = 'CHA Debit Note';
    $processFunction = 'Admin/chadebitnote';
    $this->logrecord($process,$processFunction);
    $this->global['pageTitle'] = 'CHA Debit Note';
    $this->loadViews("masters/chadebitnote", $this->global, $data, NULL);
}

public function fetchadebitnote(){

    $params = $_REQUEST;
    $totalRecords = $this->admin_model->fetchadebitnotecount($params); 
    $queryRecords = $this->admin_model->fetchadebitnotedata($params); 

    $data = array();
    foreach ($queryRecords as $key => $value)
    {
        $i = 0;
        foreach($value as $v)
        {
            $data[$key][$i] = $v;
            $i++;
        }
    }
    $json_data = array(
        "draw"            => intval( $params['draw'] ),   
        "recordsTotal"    => intval( $totalRecords ),  
        "recordsFiltered" => intval($totalRecords),
        "data"            => $data   // total data array
        );
    echo json_encode($json_data);
}

public function addchadebitnote(){

    $post_submit = $this->input->post();
    if($post_submit){
        $save_chadebitnote_response = array();
        
        $this->form_validation->set_rules('cha_debit_note_number','Cha Debit Note Number','trim|required');
        $this->form_validation->set_rules('cha_debit_note_date','Cha debit Note Date','trim');
        $this->form_validation->set_rules('taxable_amount','Taxable Amount','trim');
        $this->form_validation->set_rules('cgst_sgst','Cgst Sgst','trim');
        $this->form_validation->set_rules('bill_amount','Bill Amount','trim');
        $this->form_validation->set_rules('debit_amount','Debit Amount','trim');
        $this->form_validation->set_rules('amount_payable_before_tds','Amount Payable Before TDS','trim');
        $this->form_validation->set_rules('less_tds','Less TDS','trim');
        $this->form_validation->set_rules('payable_amount','Payable Amount','trim');

        if($this->form_validation->run() == FALSE)
        {
            $save_chadebitnote_response['status'] = 'failure';
            $save_chadebitnote_response['error'] = array('cha_debit_note_number'=>strip_tags(form_error('cha_debit_note_number')), 'cha_debit_note_date'=>strip_tags(form_error('cha_debit_note_date')), 'taxable_amount'=>strip_tags(form_error('taxable_amount')), 'cgst_sgst'=>strip_tags(form_error('cgst_sgst')),'bill_amount'=>strip_tags(form_error('bill_amount')),'debit_amount'=>strip_tags(form_error('debit_amount')),'amount_payable_before_tds'=>strip_tags(form_error('amount_payable_before_tds')),'less_tds'=>strip_tags(form_error('less_tds')),'payable_amount'=>strip_tags(form_error('payable_amount')));
        }else{

            $data = array(
                'cha_debit_number' =>trim($this->input->post('cha_debit_note_number')),
                'cha_debit_note_date'=>trim($this->input->post('cha_debit_note_date')),
                'cha_name' =>trim($this->input->post('cha_name')),
                'subject'  =>trim($this->input->post('subject')),
                'invoice_1'  =>trim($this->input->post('invoice_1')),
                'invoice_2'  =>trim($this->input->post('invoice_2')),
                'invoice_3'  =>trim($this->input->post('invoice_3')),
                'date_1'  =>trim($this->input->post('date_1')),
                'date_2'  =>trim($this->input->post('date_2')),
                'date_3'  =>trim($this->input->post('date_3')),
                'taxable_amount'=>trim($this->input->post('taxable_amount')),
                'cgst_sgst'=>trim($this->input->post('cgst_sgst')),
                'bill_amount'=>trim($this->input->post('bill_amount')),
                'debit_amount'=>trim($this->input->post('debit_amount_total')),
                'amount_payable_before_tds'=>trim($this->input->post('amount_payable_before_tds')),
                'less_tds'=>trim($this->input->post('less_tds')),
                'remark'=>trim($this->input->post('remark')),
                'payable_amount'=>trim($this->input->post('payable_amount'))
            );

            if($this->input->post('cha_debit_note_id')){

                $cha_debit_note_id = trim($this->input->post('cha_debit_note_id'));
            }else{

                $cha_debit_note_id = '';
            }
            
            $savechadebitnote= $this->admin_model->savechadebitnote($cha_debit_note_id,$data);

            if($savechadebitnote){

                 if($cha_debit_note_id){


                    $this->db->where('cha_debit_id', $cha_debit_note_id);
                    $this->db->delete(TBL_CHA_DEBIT_NOTE_TRANSACTION);

                    $AWB_No = $_POST['AWB_No'];
                    $debit_amount = $_POST['debit_amount'];
                    $SGST = $_POST['SGST'];
                    $CGST = $_POST['CGST'];
                    $total = $_POST['total'];
                
                    if(!empty($AWB_No)){
                        for($i = 0; $i < count($AWB_No); $i++){
                            if(!empty($AWB_No[$i])){
                                $data1['AWB_No'] = $AWB_No[$i];
                                $data1['debit_amount'] = $debit_amount[$i];
                                $data1['SGST'] = $SGST[$i];
                                $data1['CGST'] = $CGST[$i];
                                $data1['total'] = $total[$i];
                                $data1['cha_debit_id'] = $savechadebitnote;
                              //  $this->db->where('cha_debit_id', $cha_debit_note_id);
                                $this->db->insert(TBL_CHA_DEBIT_NOTE_TRANSACTION,$data1);
                            }
                        }
                    }

                 }else{
                        $AWB_No = $_POST['AWB_No'];
                        $debit_amount = $_POST['debit_amount'];
                        $SGST = $_POST['SGST'];
                        $CGST = $_POST['CGST'];
                        $total = $_POST['total'];
                    
                        if(!empty($AWB_No)){
                            for($i = 0; $i < count($AWB_No); $i++){
                                // if(!empty($AWB_No[$i])){
                                    $data1['AWB_No'] = $AWB_No[$i];
                                    $data1['debit_amount'] = $debit_amount[$i];
                                    $data1['SGST'] = $SGST[$i];
                                    $data1['CGST'] = $CGST[$i];
                                    $data1['total'] = $total[$i];
                                    $data1['cha_debit_id'] = $savechadebitnote;
                                    $this->db->insert(TBL_CHA_DEBIT_NOTE_TRANSACTION,$data1);
                                // }
                            }
                        }
                 }

                
                    $save_chadebitnote_response['status'] = 'success';
                    $save_chadebitnote_response['error'] = array('cha_debit_note_number'=>strip_tags(form_error('cha_debit_note_number')), 'cha_debit_note_date'=>strip_tags(form_error('cha_debit_note_date')), 'taxable_amount'=>strip_tags(form_error('taxable_amount')), 'cgst_sgst'=>strip_tags(form_error('cgst_sgst')),'bill_amount'=>strip_tags(form_error('bill_amount')),'debit_amount'=>strip_tags(form_error('debit_amount')),'amount_payable_before_tds'=>strip_tags(form_error('amount_payable_before_tds')),'less_tds'=>strip_tags(form_error('less_tds')),'payable_amount'=>strip_tags(form_error('payable_amount')));
            
                }
          }

        echo json_encode($save_chadebitnote_response);

    }else{
            $process = 'Add CHA Debit note';
            $processFunction = 'Admin/addchadebitnote';
            $this->logrecord($process,$processFunction);
            $this->global['pageTitle'] = 'Add CHA Debit note';
            $data['getchamaster']= $this->admin_model->getchamaster();
            $data['getPreviousCHAdebitnotnumber']= $this->admin_model->getPreviousCHAdebitnotnumber()[0];
            $this->loadViews("masters/addchadebitnote", $this->global, $data, NULL);

    }

}

public function downloadenquiryformdata($id){

         // create file name
        // $fileName = 'Enquiry_Form_Report -'.date('d-m-Y').'.xlsx';  
        $getEnquiryInfo = $this->admin_model->downloadenquiryformdata($id);

        $fileName = ' Enq No - '.$getEnquiryInfo[0]['enquiry_number'].' - '.$getEnquiryInfo[0]['buyer_name'].' - '.date('d-m-Y',strtotime($getEnquiryInfo[0]['buyer_enquiry_date']));  

        
         // load excel library


        // $getEnquiryInforowdata = $this->admin_model->getEnquiryInforowdata($excelvalue['enquiry_form_id']);


         $html = '<html>';
         $html.= '<table>';

         $html.= '<tr>';
         $html.= '<td><b>Enquiry Form Report</b></td>';
         $html.= '</tr>';

         $html.= '<tr>';
         $html.= '<td>Buyer Name : '.$getEnquiryInfo[0]['buyer_name'].'</td>';
         $html.= '</tr>';

         $html.= '<tr>';
         $html.= '<td>Enquiry Number :'.$getEnquiryInfo[0]['enquiry_number'].'</td>';
         $html.= '</tr>';

         $html.= '<tr>';
         $html.= '<td>Enquiry Date : '.  date('d-m-Y',strtotime($getEnquiryInfo[0]['buyer_enquiry_date'])).'</td>';
         $html.= '</tr>';

         $html.= '</table>';

       
          //$html.= '<p>Enquiry Number : '.$getEnquiryInfo[0]['enquiry_number'].'</p>';
          $html.= '<table style="border: 1px solid;">';
          $html.= '<caption style="text-align:left;"><h5>Supplier Details</h5></caption>';

         foreach ($getEnquiryInfo as  $value) {

            $html.= '<tr style="text-align:left;background-color:yellow">';
                $html.= '<th style="text-align:left;border: 1px solid;"> </th>';
                $html.= '<th style="text-align:left;border: 1px solid;"> </th>';
                $html.= '<th style="text-align:left;border: 1px solid;">'.$value['suplier_id_name_1'].'</th>';
                $html.= '<th style="text-align:left;border: 1px solid;">'.$value['suplier_id_name_2'].'</th>';
                $html.= '<th style="text-align:left;border: 1px solid;">'.$value['suplier_id_name_3'].'</th>';
                $html.= '<th style="text-align:left;border: 1px solid;">'.$value['suplier_id_name_4'].'</th>';
                $html.= '<th style="text-align:left;border: 1px solid;">'.$value['suplier_id_name_5'].'</th>';
            $html.= '</tr>';

            $html.= '<tr style="text-align:left;border: 1px solid;">';
                $html.= '<td style="text-align:left;border: 1px solid;">Part Number</td>';
                $html.= '<td style="text-align:left;border: 1px solid;">'.$value['part_number'].'</td>';
                $html.= '<td style="text-align:left;border: 1px solid;"></td>';
                $html.= '<td style="text-align:left;border: 1px solid;"></td>';
                $html.= '<td style="text-align:left;border: 1px solid;"></td>';
                $html.= '<td style="text-align:left;border: 1px solid;"></td>';
                $html.= '<td style="text-align:left;border: 1px solid;"></td>';
            $html.= '</tr>';

           
            $html.= '<tr style="text-align:left;border: 1px solid;">';
                $html.= '<td style="text-align:left;border: 1px solid;">Required Qty</td>';
                $html.= '<td style="text-align:left;border: 1px solid;">'.$value['supplier_qty_in_kgs'].' kgs</td>';
                $html.= '<td style="text-align:left;border: 1px solid;">'.$value['suplier_rate_1'].'/-</td>';
                $html.= '<td style="text-align:left;border: 1px solid;">'.$value['suplier_rate_2'].'/-</td>';
                $html.= '<td style="text-align:left;border: 1px solid;">'.$value['suplier_rate_3'].'/-</td>';
                $html.= '<td style="text-align:left;border: 1px solid;">'.$value['suplier_rate_4'].'/-</td>';
                $html.= '<td style="text-align:left;border: 1px solid;">'.$value['suplier_rate_5'].'/-</td>';
            $html.= '</tr>';


        
            $html.= '<tr style="text-align:left;border: 1px solid;">';
                $html.= '<td style="text-align:left;border: 1px solid;">Raw Material</td>';
                $html.= '<td style="text-align:left;border: 1px solid;">'.$value['rm_description'].'</td>';
                $html.= '<td style="text-align:left;border: 1px solid;"></td>';
                $html.= '<td style="text-align:left;border: 1px solid;"></td>';
                $html.= '<td style="text-align:left;border: 1px solid;"></td>';
                $html.= '<td style="text-align:left;border: 1px solid;"></td>';
                $html.= '<td style="text-align:left;border: 1px solid;"></td>';
            $html.= '</tr>';

            $html.= '<tr style="text-align:left;border: 1px solid;">';
            $html.= '<td style="text-align:left;border: 1px solid;">Grade</td>';
            $html.= '<td style="text-align:left;border: 1px solid;">'.$value['rm_size'].'</td>';
            $html.= '<td style="text-align:left;border: 1px solid;"></td>';
            $html.= '<td style="text-align:left;border: 1px solid;"></td>';
            $html.= '<td style="text-align:left;border: 1px solid;"></td>';
            $html.= '<td style="text-align:left;border: 1px solid;"></td>';
            $html.= '<td style="text-align:left;border: 1px solid;"></td>';
            $html.= '</tr>';

            $html.= '<tr style="text-align:left;border: 1px solid;">';
            $html.= '<td style="text-align:left;border: 1px solid;">Gross Weight</td>';
            $html.= '<td style="text-align:left;border: 1px solid;">'.$value['groass_weight'].'</td>';
            $html.= '<td style="text-align:left;border: 1px solid;"></td>';
            $html.= '<td style="text-align:left;border: 1px solid;"></td>';
            $html.= '<td style="text-align:left;border: 1px solid;"></td>';
            $html.= '<td style="text-align:left;border: 1px solid;"></td>';
            $html.= '<td style="text-align:left;border: 1px solid;"></td>';
            $html.= '</tr>';


            $html.= '<tr style="text-align:left;border: 1px solid;">';
            $html.= '<td style="text-align:left;border: 1px solid;">Remark</td>';
            $html.= '<td style="text-align:left;border: 1px solid;"></td>';
            $html.= '<td style="text-align:left;border: 1px solid;">'.$value['remark_1'].'</td>';
            $html.= '<td style="text-align:left;border: 1px solid;">'.$value['remark_2'].'</td>';
            $html.= '<td style="text-align:left;border: 1px solid;">'.$value['remark_3'].'</td>';
            $html.= '<td style="text-align:left;border: 1px solid;">'.$value['remark_4'].'</td>';
            $html.= '<td style="text-align:left;border: 1px solid;">'.$value['remark_5'].'</td>';
            $html.= '</tr>';

        
         }

         $html.= '</table>';


         $html.= '<table style="border: 1px solid;">';
         $html.= '<caption style="text-align:left;"><h5>Vendor Details</h5></caption>';

         foreach ($getEnquiryInfo as  $value) {


            $html.= '<tr style="text-align:left;background-color:yellow">';
            $html.= '<th style="text-align:left;border: 1px solid;"> </th>';
            $html.= '<th style="text-align:left;border: 1px solid;"> </th>';
            $html.= '<th style="text-align:left;border: 1px solid;">'.$value['vendor_name_1'].'</th>';
            $html.= '<th style="text-align:left;border: 1px solid;">'.$value['vendor_name_2'].'</th>';
            $html.= '<th style="text-align:left;border: 1px solid;">'.$value['vendor_name_3'].'</th>';
            $html.= '<th style="text-align:left;border: 1px solid;">'.$value['vendor_name_4'].'</th>';
            $html.= '<th style="text-align:left;border: 1px solid;">'.$value['vendor_name_5'].'</th>';
            $html.= '</tr>';

            $html.= '<tr style="text-align:left;border: 1px solid;">';
            $html.= '<td style="text-align:left;border: 1px solid;">Part Number</td>';
            $html.= '<td style="text-align:left;border: 1px solid;">'.$value['part_number'].'</td>';
            $html.= '<td style="text-align:left;border: 1px solid;"></td>';
            $html.= '<td style="text-align:left;border: 1px solid;"></td>';
            $html.= '<td style="text-align:left;border: 1px solid;"></td>';
            $html.= '<td style="text-align:left;border: 1px solid;"></td>';
            $html.= '<td style="text-align:left;border: 1px solid;"></td>';
            $html.= '</tr>';

            $html.= '<tr style="text-align:left;border: 1px solid;">';
            $html.= '<td style="text-align:left;border: 1px solid;">Required Qty</td>';
            $html.= '<td style="text-align:left;border: 1px solid;">'.$value['venodr_qty_in_pcs'].' pcs</td>';
            $html.= '<td style="text-align:left;border: 1px solid;">'.$value['vendor_rate_1'].'/-</td>';
            $html.= '<td style="text-align:left;border: 1px solid;">'.$value['vendor_rate_2'].'/-</td>';
            $html.= '<td style="text-align:left;border: 1px solid;">'.$value['vendor_rate_3'].'/-</td>';
            $html.= '<td style="text-align:left;border: 1px solid;">'.$value['vendor_rate_4'].'/-</td>';
            $html.= '<td style="text-align:left;border: 1px solid;">'.$value['vendor_rate_5'].'/-</td>';
            $html.= '</tr>';

            $html.= '<tr style="text-align:left;border: 1px solid;">';
            $html.= '<td style="text-align:left;border: 1px solid;">Raw Material</td>';
            $html.= '<td style="text-align:left;border: 1px solid;">'.$value['rm_description'].'</td>';
            $html.= '<td style="text-align:left;border: 1px solid;"></td>';
            $html.= '<td style="text-align:left;border: 1px solid;"></td>';
            $html.= '<td style="text-align:left;border: 1px solid;"></td>';
            $html.= '<td style="text-align:left;border: 1px solid;"></td>';
            $html.= '<td style="text-align:left;border: 1px solid;"></td>';
            $html.= '</tr>';

            $html.= '<tr style="text-align:left;border: 1px solid;">';
            $html.= '<td style="text-align:left;border: 1px solid;">Grade</td>';
            $html.= '<td style="text-align:left;border: 1px solid;">'.$value['rm_size'].'</td>';
            $html.= '<td style="text-align:left;border: 1px solid;"></td>';
            $html.= '<td style="text-align:left;border: 1px solid;"></td>';
            $html.= '<td style="text-align:left;border: 1px solid;"></td>';
            $html.= '<td style="text-align:left;border: 1px solid;"></td>';
            $html.= '<td style="text-align:left;border: 1px solid;"></td>';
            $html.= '</tr>';

            $html.= '<tr style="text-align:left;border: 1px solid;">';
            $html.= '<td style="text-align:left;border: 1px solid;">Gross Weight</td>';
            $html.= '<td style="text-align:left;border: 1px solid;">'.$value['groass_weight'].'</td>';
            $html.= '<td style="text-align:left;border: 1px solid;"></td>';
            $html.= '<td style="text-align:left;border: 1px solid;"></td>';
            $html.= '<td style="text-align:left;border: 1px solid;"></td>';
            $html.= '<td style="text-align:left;border: 1px solid;"></td>';
            $html.= '<td style="text-align:left;border: 1px solid;"></td>';
            $html.= '</tr>';

            $html.= '<tr style="text-align:left;border: 1px solid;">';
            $html.= '<td style="text-align:left;border: 1px solid;">Remark</td>';
            $html.= '<td style="text-align:left;border: 1px solid;"></td>';
            $html.= '<td style="text-align:left;border: 1px solid;">'.$value['remark_6'].'</td>';
            $html.= '<td style="text-align:left;border: 1px solid;">'.$value['remark_7'].'</td>';
            $html.= '<td style="text-align:left;border: 1px solid;">'.$value['remark_8'].'</td>';
            $html.= '<td style="text-align:left;border: 1px solid;">'.$value['remark_9'].'</td>';
            $html.= '<td style="text-align:left;border: 1px solid;">'.$value['remark_10'].'</td>';
            $html.= '</tr>';

         }



         $html.= '</table>';
         $html.= '</html>';
           
         header('Content-Type: application/vnd.ms-excel');
         header("Content-Disposition: attachment;Filename=$fileName.xls");
         header('Cache-Control: max-age=0');

         echo $html;
      
}

public function scrapcalculationreport(){

    $process = 'Scrap Calculation Report';
    $processFunction = 'Admin/scrapcalculationreport';
    $this->global['pageTitle'] = 'Scrap Calculation Report';
    $data['vendorList']= $this->admin_model->fetchALLvendorList();
    $this->loadViews("masters/scrapcalculationreport", $this->global, $data, NULL);  
}

public function fetchscrapcalculationreport($status){

    $params = $_REQUEST;
    $totalRecords = $this->admin_model->fetchscrapcalculationreportcount($params,$status); 
    $queryRecords = $this->admin_model->fetchscrapcalculationreportdata($params,$status); 

    $data = array();
    foreach ($queryRecords as $key => $value)
    {
        $i = 0;
        foreach($value as $v)
        {
            $data[$key][$i] = $v;
            $i++;
        }
    }
    $json_data = array(
        "draw"            => intval( $params['draw'] ),   
        "recordsTotal"    => intval( $totalRecords ),  
        "recordsFiltered" => intval($totalRecords),
        "data"            => $data   // total data array
        );
    echo json_encode($json_data);

}

public function downlaod_scrap_calculation_report($status) {

    
    // create file name
    $fileName = 'Scrap_Calculation_Report_Report -'.date('d-m-Y').'.xlsx';  
    // load excel library
    $empInfo = $this->admin_model->getscrapcalculationreportdata($status);
    $objPHPExcel = new PHPExcel();
    $objPHPExcel->setActiveSheetIndex(0);
    // set Header
    $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'Vendor Name');
    $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Vendor PO NUmber');
    $objPHPExcel->getActiveSheet()->SetCellValue('C1', 'Vendor PO Date');
    $objPHPExcel->getActiveSheet()->SetCellValue('D1', 'FG Part No'); 
    $objPHPExcel->getActiveSheet()->SetCellValue('E1', 'RM Type');
    $objPHPExcel->getActiveSheet()->SetCellValue('F1', 'Raw Material Actual Qty');   
    $objPHPExcel->getActiveSheet()->SetCellValue('G1', 'Raw Material In pcs');  
    $objPHPExcel->getActiveSheet()->SetCellValue('H1', 'Vendor Actual Received Qty');  
    $objPHPExcel->getActiveSheet()->SetCellValue('I1', 'Scrap In Kgs');  
    $objPHPExcel->getActiveSheet()->SetCellValue('J1', 'Supra`s Total Net weight');  
    $objPHPExcel->getActiveSheet()->SetCellValue('K1', 'Net Weight Per pcs');  


    // set Row
    $rowCount = 2;
    foreach ($empInfo as $element) {
        $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $element['vendorname']);
        $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $element['bom_number']);
        $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $element['date']);
        $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $element['fg_part_number']);
        $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $element['rm_type']);
        $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, $element['rm_actual_aty']);
        $objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, $element['raw_material_in_pcs']);
        $objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, $element['vendor_actual_recived_qty']);
        $objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, $element['scrap_in_kgs']);
        $objPHPExcel->getActiveSheet()->SetCellValue('J' . $rowCount, $element['supras_total_net_weight']);
        $objPHPExcel->getActiveSheet()->SetCellValue('K' . $rowCount, $element['net_weight_per_pcs']);
              
        $rowCount++;
    }

    foreach(range('A','K') as $columnID) {
        $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
    }
    /*********************Autoresize column width depending upon contents END***********************/
    
    $objPHPExcel->getActiveSheet()->getStyle('A1:K1')->getFont()->setBold(true); //Make heading font bold
    
    /*********************Add color to heading START**********************/
    $objPHPExcel->getActiveSheet()
                ->getStyle('A1:K1')
                ->getFill()
                ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                ->getStartColor()
                ->setARGB('99ff99');


    $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
      
    header('Content-Type: application/vnd.ms-excel');
    header("Content-Disposition: attachment;Filename=$fileName.xls");
    header('Cache-Control: max-age=0');
    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
    $objWriter->save('php://output');

}

public function productionstatusreport(){
    $process = 'Production Status Report';
    $processFunction = 'Admin/productionstatusreport';
    $this->global['pageTitle'] = 'Production Status Report';
    $data['vendorList']= $this->admin_model->fetchALLvendorList();
    $data['finishgoodList']= $this->admin_model->fetchALLFinishgoodList();
    $data['vendorpoList']= $this->admin_model->fetchALLvendorpoList();
    $this->loadViews("masters/productionstatusreport", $this->global, $data, NULL);  
}

public function fetchproductionstatusreport($vendor_name,$status,$part_number,$vendor_po){

    $params = $_REQUEST;
    $totalRecords = $this->admin_model->fetchproductionstatusreportcount($params,$vendor_name,$status,$part_number,$vendor_po); 
    $queryRecords = $this->admin_model->fetchproductionstatusreportdata($params,$vendor_name,$status,$part_number,$vendor_po); 

    $data = array();
    foreach ($queryRecords as $key => $value)
    {
        $i = 0;
        foreach($value as $v)
        {
            $data[$key][$i] = $v;
            $i++;
        }
    }
    $json_data = array(
        "draw"            => intval( $params['draw'] ),   
        "recordsTotal"    => intval( $totalRecords ),  
        "recordsFiltered" => intval($totalRecords),
        "data"            => $data   // total data array
        );
    echo json_encode($json_data);

}

public function checkifpackingintractionalreadyexists(){

    $post_submit = $this->input->post();
    if($post_submit){

       $buyer_name =  trim($this->input->post('buyer_name'));
       $buyer_po_number =  trim($this->input->post('buyer_po_number'));

       if($buyer_name && $buyer_po_number ){

            $checkifpackingintractionalreadyexists = $this->admin_model->checkifpackingintractionalreadyexists($buyer_name,$buyer_po_number);
           
           if($checkifpackingintractionalreadyexists){

            if(count($checkifpackingintractionalreadyexists) >= 1) {

                echo 'success';
            }else{

                echo 'failure';
            }

           }else{
               echo 'failure';
           }
           
       }else{
        echo 'failure';
       }
    }else{

        echo 'failure';
    }

}

public function downlaod_production_status_report($vendor_name,$status,$vendor_po_number,$part_number_id) {

    // create file name
    $fileName = 'Production_status_Report -'.date('d-m-Y').'.xlsx';  
    // load excel library
    $empInfo = $this->admin_model->getallproductionreportstatusdata($vendor_name,$status,$vendor_po_number,$part_number_id);

    $objPHPExcel = new PHPExcel();
    $objPHPExcel->setActiveSheetIndex(0);
    // set Header
    $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'Vendor Name');
    $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Vendor PO No');
    $objPHPExcel->getActiveSheet()->SetCellValue('C1', 'Vendor PO Date');
    $objPHPExcel->getActiveSheet()->SetCellValue('D1', 'FG Part Number'); 
    $objPHPExcel->getActiveSheet()->SetCellValue('E1', 'FG Part Description');
    $objPHPExcel->getActiveSheet()->SetCellValue('F1', 'FG Part Order Qty');   
    $objPHPExcel->getActiveSheet()->SetCellValue('G1', 'FG Part Expected Qty');  
    $objPHPExcel->getActiveSheet()->SetCellValue('H1', 'FG Part Received Qty');  
    $objPHPExcel->getActiveSheet()->SetCellValue('I1', 'Vendor Delivery Date');  
    $objPHPExcel->getActiveSheet()->SetCellValue('J1', 'Buyer Name');  
    // $objPHPExcel->getActiveSheet()->SetCellValue('K1', 'Buyer PO No');  
    // $objPHPExcel->getActiveSheet()->SetCellValue('L1', 'Buyer PO Date');  
    // $objPHPExcel->getActiveSheet()->SetCellValue('M1', 'Buyer Order Qty');
    // $objPHPExcel->getActiveSheet()->SetCellValue('N1', 'Buyer Delivery Date');
    $objPHPExcel->getActiveSheet()->SetCellValue('K1', 'Status');
    $objPHPExcel->getActiveSheet()->SetCellValue('L1', 'Notes');



    // set Row
    $rowCount = 2;
    foreach ($empInfo as $element) {
        $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $element['vendorname']);
        $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $element['v_po_number']);
        $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $element['vpodate']);
        $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $element['fg_part_number']);
        $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $element['part_description']);
        $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, $element['vendor_order_qty']);
        $objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, $element['vendor_received_qty']);
        $objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, $element['vendor_received_qtys']);
        $objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, $element['delivery_date']);
        $objPHPExcel->getActiveSheet()->SetCellValue('J' . $rowCount, $element['buyer_name']);
        // $objPHPExcel->getActiveSheet()->SetCellValue('K' . $rowCount, $element['buyer_po_number']);
        // $objPHPExcel->getActiveSheet()->SetCellValue('L' . $rowCount, $element['buyer_po_date']);
        // $objPHPExcel->getActiveSheet()->SetCellValue('M' . $rowCount, '');
        // $objPHPExcel->getActiveSheet()->SetCellValue('N' . $rowCount, $element['buyer_delivery_date']);
        $objPHPExcel->getActiveSheet()->SetCellValue('K' . $rowCount, $element['status']);
        $objPHPExcel->getActiveSheet()->SetCellValue('L' . $rowCount, $element['itemnote']);   
        $rowCount++;
    }

    foreach(range('A','L') as $columnID) {
        $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
    }
    /*********************Autoresize column width depending upon contents END***********************/
    
    $objPHPExcel->getActiveSheet()->getStyle('A1:L1')->getFont()->setBold(true); //Make heading font bold
    
    /*********************Add color to heading START**********************/
    $objPHPExcel->getActiveSheet()
                ->getStyle('A1:L1')
                ->getFill()
                ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                ->getStartColor()
                ->setARGB('99ff99');


    $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
      
    header('Content-Type: application/vnd.ms-excel');
    header("Content-Disposition: attachment;Filename=$fileName.xls");
    header('Cache-Control: max-age=0');
    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
    $objWriter->save('php://output');

}

public function getpreviousaddednotesfordisplay(){
    $bill_ofmaterial_id=$this->input->post('id');
    if($bill_ofmaterial_id) {
        $bill_ofmaterial_id_data = $this->admin_model->getpreviousaddednotesfordisplay($bill_ofmaterial_id);
        if(count($bill_ofmaterial_id_data) >= 1) {
            echo json_encode($bill_ofmaterial_id_data[0]);
        } else {
            echo 'failure';
        }
    } else {
        echo 'failure';
    }

}

public function savebillofmaterialnotes(){
    $post_submit=$this->input->post();

    if($post_submit){

        $savebillofmaterialnotes_response = array();
        $this->form_validation->set_rules('notes','Notes','trim|required');

        if($this->form_validation->run() == FALSE)
        {
            $savebillofmaterialnotes_response['status'] = 'failure';
            $savebillofmaterialnotes_response['error'] = array( 'notes'=>strip_tags(form_error('notes')));
       
        }else{
            $data = array('notes'=>trim($this->input->post('notes')));
            $bill_ofmaterial_id_data = $this->admin_model->savebillofmaterialnotes(trim($this->input->post('notes_id')),$data);

            if($bill_ofmaterial_id_data){
                $savebillofmaterialnotes_response['status'] = 'success';
                $savebillofmaterialnotes_response['error'] = array( 'notes'=>strip_tags(form_error('notes')));
            }

        }

        echo json_encode($savebillofmaterialnotes_response);
    }

}

public function supplierporeport(){

    $process = 'Supplier PO Confirmation Report';
    $processFunction = 'Admin/supplierporeport';
    $this->global['pageTitle'] = 'Supplier PO Confirmation Report';
    $data['supplierpoList']= $this->admin_model->getSuplierpoMasterList();
    $data['supplierlist']= $this->admin_model->fetchALLsupplierList();
    $this->loadViews("masters/supplierporeport", $this->global, $data, NULL);  
}

public function fetchsupplierporeport($supplier_name,$supplier_po,$material_sent,$materila_recipt_confirmation){

    $params = $_REQUEST;
    $totalRecords = $this->admin_model->fetchsupplierporeportcount($params,$supplier_name,$supplier_po,$material_sent,$materila_recipt_confirmation); 
    $queryRecords = $this->admin_model->fetchsupplierporeportdata($params,$supplier_name,$supplier_po,$material_sent,$materila_recipt_confirmation); 

    $data = array();
    foreach ($queryRecords as $key => $value)
    {
        $i = 0;
        foreach($value as $v)
        {
            $data[$key][$i] = $v;
            $i++;
        }
    }
    $json_data = array(
        "draw"            => intval( $params['draw'] ),   
        "recordsTotal"    => intval( $totalRecords ),  
        "recordsFiltered" => intval($totalRecords),
        "data"            => $data   // total data array
        );
    echo json_encode($json_data);

}

public function deletechadebitnote(){
    $post_submit = $this->input->post();
    if($post_submit){
        $result = $this->admin_model->deletechadebitnote(trim($this->input->post('id')));
        if ($result) {
                    $process = 'CHA Debit Delete';
                    $processFunction = 'Admin/deletechadebitnote';
                    $this->logrecord($process,$processFunction);
                echo(json_encode(array('status'=>'success')));
            }
        else { echo(json_encode(array('status'=>'failed'))); }
    }else{
        echo(json_encode(array('status'=>'failed'))); 
    }
}

public function editchadebitnote($id){

    $process = 'Edit CHA Debit Note';
    $processFunction = 'Admin/editchadebitnote';
    $this->logrecord($process,$processFunction);
    $this->global['pageTitle'] = 'Edit CHA Debit Note';
    $data['getchadebitnotedetails'] = $this->admin_model->getchadebitnotedetails($id);
    $data['getcurrentorderdetails']= $this->admin_model->getcurrentorderdetails($id);
    $data['getchamaster']= $this->admin_model->getchamaster();
    $this->loadViews("masters/editchadebitnote", $this->global, $data, NULL);
}

public function salestrackingexcelreport(){
    $process = 'Sales Tracking Excel Report';
    $processFunction = 'Admin/salestrackingexcelreport';
    $this->global['pageTitle'] = 'Sales Tracking Excel Report';
    $this->loadViews("masters/salestrackingexcelreport", $this->global, $data, NULL);  
}

public function downlaod_supplier_po_details_report($supplier_name,$supplier_po,$material_sent,$materila_recipt_confirmation) {

    // create file name
    $fileName = 'Supplier_PO_Report -'.date('d-m-Y').'.xlsx';  
    // load excel library
    $empInfo = $this->admin_model->downlaodsupplierpodetailsreportdata($supplier_name,$supplier_po,$material_sent,$materila_recipt_confirmation);

    $objPHPExcel = new PHPExcel();
    $objPHPExcel->setActiveSheetIndex(0);
    // set Header
    $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'PO Number');
    $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'PO Date');
    $objPHPExcel->getActiveSheet()->SetCellValue('C1', 'Supplier Name');
    $objPHPExcel->getActiveSheet()->SetCellValue('D1', 'Material Description'); 
    $objPHPExcel->getActiveSheet()->SetCellValue('E1', 'Vendor Name');
    $objPHPExcel->getActiveSheet()->SetCellValue('F1', 'Part No');   
    $objPHPExcel->getActiveSheet()->SetCellValue('G1', 'Ordered Qty kgs');  
    $objPHPExcel->getActiveSheet()->SetCellValue('H1', 'Sent Qty kgs');  
    $objPHPExcel->getActiveSheet()->SetCellValue('I1', 'Ordered Qty In Pcs');  
    $objPHPExcel->getActiveSheet()->SetCellValue('J1', 'Sent Qty In Pcs');  
    $objPHPExcel->getActiveSheet()->SetCellValue('K1', 'Material Sent');
    $objPHPExcel->getActiveSheet()->SetCellValue('L1', 'Material Receipt Confirmation');

    // set Row
    $rowCount = 2;
    foreach ($empInfo as $element) {
        $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $element['po_number']);
        $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $element['date']);
        $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $element['supplier_name']);
        $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $element['name']);
        $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $element['vendor_name']);
        $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, $element['part_number']);
        $objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, $element['order_oty']);
        $objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, $element['sent_qty']);
        $objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, $element['order_oty_pcs']);
        $objPHPExcel->getActiveSheet()->SetCellValue('J' . $rowCount, $element['sent_qty_pcs']);
        $objPHPExcel->getActiveSheet()->SetCellValue('K' . $rowCount, $element['material_sent']);
        $objPHPExcel->getActiveSheet()->SetCellValue('L' . $rowCount, $element['material_receipt_confirmation']);   
        $rowCount++;
    }

    foreach(range('A','L') as $columnID) {
        $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
    }
    /*********************Autoresize column width depending upon contents END***********************/
    
    $objPHPExcel->getActiveSheet()->getStyle('A1:L1')->getFont()->setBold(true); //Make heading font bold
    
    /*********************Add color to heading START**********************/
    $objPHPExcel->getActiveSheet()
                ->getStyle('A1:L1')
                ->getFill()
                ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                ->getStartColor()
                ->setARGB('99ff99');


    $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
      
    header('Content-Type: application/vnd.ms-excel');
    header("Content-Disposition: attachment;Filename=$fileName.xls");
    header('Cache-Control: max-age=0');
    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
    $objWriter->save('php://output');

}


public function paymentdetailsreport(){

    $process = 'PPayment Details Report';
    $processFunction = 'Admin/paymentdetailsreport';
    $this->logrecord($process,$processFunction);
    $this->global['pageTitle'] = 'Payment Details Report';
    $data['vendorList']= $this->admin_model->fetchALLvendorList();
    $data['supplierList']= $this->admin_model->fetchALLsupplierList();
    $data['paymentdetailsnumberList']= $this->admin_model->paymentdetailsnumberList();
    $this->loadViews("masters/paymentdetailsreport", $this->global, $data, NULL);  
}


public function fetchPaymentdetailsreport($vendor_name,$supplier_name,$payment_details_no,$status){
    $params = $_REQUEST;
    $totalRecords = $this->admin_model->getPaymentdetsilsreportcount($params,$vendor_name,$supplier_name,$payment_details_no,$status); 
    $queryRecords = $this->admin_model->getPaymentdetsilsreportdata($params,$vendor_name,$supplier_name,$payment_details_no,$status); 

    $data = array();
    foreach ($queryRecords as $key => $value)
    {
        $i = 0;
        foreach($value as $v)
        {
            $data[$key][$i] = $v;
            $i++;
        }
    }
    $json_data = array(
        "draw"            => intval( $params['draw'] ),   
        "recordsTotal"    => intval( $totalRecords ),  
        "recordsFiltered" => intval($totalRecords),
        "data"            => $data   // total data array
        );
    echo json_encode($json_data);

}


public function export_to_excel_payment_details($vendor_name,$supplier_name,$payment_details_no,$status) {

    // create file name
    $fileName = 'Payment_Details_Report -'.date('d-m-Y').'.xlsx';  
    // load excel library
    $empInfo = $this->admin_model->downlaodpaymentdetailsreportdata($vendor_name,$supplier_name,$payment_details_no,$status);

    $objPHPExcel = new PHPExcel();
    $objPHPExcel->setActiveSheetIndex(0);
    // set Header
    $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'Vendor Name');
    $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Supplier Name');
    $objPHPExcel->getActiveSheet()->SetCellValue('C1', 'Payment Details Number');
    $objPHPExcel->getActiveSheet()->SetCellValue('D1', 'Bill No'); 
    $objPHPExcel->getActiveSheet()->SetCellValue('E1', 'Bill Date');
    $objPHPExcel->getActiveSheet()->SetCellValue('F1', 'Bill Amount');   
    $objPHPExcel->getActiveSheet()->SetCellValue('G1', 'TDS');  
    $objPHPExcel->getActiveSheet()->SetCellValue('H1', 'Debit Note Amount');  
    $objPHPExcel->getActiveSheet()->SetCellValue('I1', 'Amount Paid');  
    $objPHPExcel->getActiveSheet()->SetCellValue('J1', 'Payment Status');  

    // set Row
    $rowCount = 2;
    foreach ($empInfo as $element) {
        $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $element['vendor_name']);
        $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $element['supplier_name']);
        $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $element['payment_details_number']);
        $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $element['bill_no']);
        $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $element['bill_date']);
        $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, $element['bill_amount']);
        $objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, $element['tds']);
        $objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, $element['debit_note_amount']);
        $objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, $element['amount_paid']);
        $objPHPExcel->getActiveSheet()->SetCellValue('J' . $rowCount, $element['payment_status']);
        $rowCount++;
    }

    foreach(range('A','J') as $columnID) {
        $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
    }
    /*********************Autoresize column width depending upon contents END***********************/
    
    $objPHPExcel->getActiveSheet()->getStyle('A1:J1')->getFont()->setBold(true); //Make heading font bold
    
    /*********************Add color to heading START**********************/
    $objPHPExcel->getActiveSheet()
                ->getStyle('A1:J1')
                ->getFill()
                ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                ->getStartColor()
                ->setARGB('99ff99');


    $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
      
    header('Content-Type: application/vnd.ms-excel');
    header("Content-Disposition: attachment;Filename=$fileName.xls");
    header('Cache-Control: max-age=0');
    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
    $objWriter->save('php://output');

}


public function downlaodchadebitnote($id){

    $getchaDebitnotedetailsforInvoice = $this->admin_model->getchaDebitnotedetailsforInvoice($id);
    $getchaDebitnoteitemdeatilsForInvoice = $this->admin_model->getchaDebitnoteitemdeatilsForInvoice($id);

    $i=1;
    $CartItem = "";
    foreach ($getchaDebitnoteitemdeatilsForInvoice as $key => $value) {
        $CartItem .= '
                <tr style="border: 1px solid black;border-left: 1px solid black;border-right: 1px solid black;">
                    <td style="border-left: 1px solid black;border-right: 1px solid black;text-align:left;padding: 10px;" valign="top">'.$i++.'</td>
                    <td style="border-left: 1px solid black;border-right: 1px solid black;text-align:left;padding: 10px;" valign="top">'.$value['AWB_No'].'</br></td> 
                    <td style="border-left: 1px solid black;border-right: 1px solid black;text-align:left;padding: 10px;" valign="top">'.$value['debit_amount'].' '.$value['supplier_po_unit'].'</td>
                    <td style="border-left: 1px solid black;border-right: 1px solid black;text-align:left;padding: 10px;" valign="top">'.$value['SGST'].' '.$value['supplier_po_unit'].'</td>
                    <td style="border-left: 1px solid black;border-right: 1px solid black;text-align:left;padding: 10px;" valign="top">'.$value['CGST'].' '.$value['supplier_po_unit'].'</td> 
                    <td style="border-left: 1px solid black;border-right: 1px solid black;text-align:left;padding: 10px;" valign="top">'.$value['total'].' '.$value['supplier_po_unit'].'</td>    
                </tr>';
        $ii++;       
    }

  
    $mpdf = new \Mpdf\Mpdf();
    // $html = $this->load->view('html_to_pdf',[],true);
    $html = '<table style=" width: 100%;text-align: center;border-collapse: collapse;font-family:cambria;">
                <tr>
                  <td rowspan="2"><img src="'.base_url().'assets/images/supra_logo_1.jpg" width="80" height="80"></td>
                  <td style="color:#000080"><h2>SUPRA QUALITY EXPORTS (I) PVT. LTD</h2></td>
                  <td rowspan="2"><img src="'.base_url().'assets/images/logo_2.png" width="80" height="80"></td>
                </tr> 
                <tr>
                  <td style="font-weight: bold;">
                    <p>MANUFACTURER & EXPORTERS OF:</p>
                    <p>PRECISION TURNED COMPONENTS, STAMPED /PRESSED PARTS IN FERROUS & NON-FERROUS METAL</p>
                    <p>MOULDED & EXTRUDED PLASTIC AND RUBBER COMPONENTS</p> 
                  </td>
                </tr>
            </table>
            <hr>
            <table style=" width: 100%;text-align: center;margin-top:10px;margin-bottom:10px;font-family:cambria;">
                    <tr>
                        <td style="color:red;font-size:15px">
                          <u><p><h3>DEBIT NOTE</h3></p>
                        </td>
                    </tr>
            </table>

            <table style=" width: 100%;text-align: left;border-collapse: collapse;font-family:cambria;font-size:13px;">
                <tr>
                    <td width="50%">
                        <div>
                            <p>To,</p>
                            <p><b>'.$getchaDebitnotedetailsforInvoice['cha_name'].'</b></p>
                            <p>'.$getchaDebitnotedetailsforInvoice['address'].'</p>
                            <p><b>Contact No:</b> '.$getchaDebitnotedetailsforInvoice['mobile'].' / '.$getchaDebitnotedetailsforInvoice['landline'].'</p>
                            <p><b>Contact Person:</b> '.$getchaDebitnotedetailsforInvoice['contact_person'].'</p>
                            <p><b>Email:</b> '.$getchaDebitnotedetailsforInvoice['email'].'</p>
                            <p style="color:red">GSTIN:'.$getchaDebitnotedetailsforInvoice['GSTIN'].'</p>
                        <div>    
                    </td> 
                    <td style="font-size:13px;" width="50%" valign="top">
                        <div>
                            <p><b></b>'. str_repeat('&nbsp;', 5).'<span style="color:red"></span></p>
                            <p><b>DEBIT NOTE NO :</b> '.'<span style="color:red">'.$getchaDebitnotedetailsforInvoice['cha_debit_number'].'</span></p>
                            <p>&nbsp;</p>
                            <p><b>Date :</b> '.date('d-m-Y',strtotime($getchaDebitnotedetailsforInvoice['cha_debit_note_date'])).'</p>
                            <p>&nbsp;</p>
                        </div>
                    </td>
                </tr>
            </table>

            <table style="margin-top:20px;width: 100%;text-align: left;border-collapse: collapse;font-family:cambria;font-size:13px;">
                <tr>
                    <td width="50%">
                        <div>
                            <p>Dear Sir,</p>
                            <p><b>Sub: Debit Note</b></p>
                            <p>With reference to the above subject we have debited your account vide your </p>
                            <p> Inv No.'.$getDebitnoteitemdeatilsForInvoice[0]['invoice_1'].' Dated '.date('d-m-Y',strtotime($getDebitnoteitemdeatilsForInvoice[0]['date_1'])).' </p>
                            <p> Inv No.'.$getDebitnoteitemdeatilsForInvoice[0]['invoice_2'].' Dated '.date('d-m-Y',strtotime($getDebitnoteitemdeatilsForInvoice[0]['date_2'])).' </p>
                            <p> Inv No.'.$getDebitnoteitemdeatilsForInvoice[0]['invoice_3'].' Dated '.date('d-m-Y',strtotime($getDebitnoteitemdeatilsForInvoice[0]['date_3'])).' </p>
                            <p>'. str_repeat('&nbsp;', 5).'</p>
                            <p>The details are as follows: </p>
                        <div>    
                    </td>  
                </tr>
            </table>

            <table style="border: 1px solid black;margin-top:10px;width: 100%;text-align: left;border-collapse: collapse;border: #ccc 1px solid;margin-top:10px;margin-bottom:10px;font-family:cambria;font-size:12px">
                <tr style="border: 1px solid black;">
                    <th align="left" style="border: 1px solid black;text-align:center;" margin-bottom: 10%;>Sr. No</th>
                    <th align="left" style="border: 1px solid black;text-align:center;" margin-bottom: 10%;>AWB No</th>  
                    <th align="left" style="border: 1px solid black;text-align:center;" margin-bottom: 10%;>Debit Amt</th> 
                    <th align="left" style="border: 1px solid black;text-align:center;" margin-bottom: 10%;>SGST 9%</th>  
                    <th align="left" style="border: 1px solid black;text-align:center;" margin-bottom: 10%;>CGST 9%</th>  
                    <th align="left" style="border: 1px solid black;text-align:center;" margin-bottom: 10%;>Total</th>  
                </tr>
                '.$CartItem.'   

                <tr style="border: 1px solid black;">
                    <td style="border: 1px solid black;padding-left: 10px;padding-right: 5px;font-family:cambria;font-size:13px;">Taxable Amount </td>    
                    <td colspan="5" style="border: 1px solid black;padding-left: 10px;">'.$getchaDebitnotedetailsforInvoice['taxable_amount'].'</td>
                </tr>

                <tr style="border: 1px solid black;">
                    <td style="border: 1px solid black;padding-left: 10px;padding-right: 5px;font-family:cambria;font-size:13px;">CGST + SGST 18% </td>    
                    <td colspan="5" style="border: 1px solid black;padding-left: 10px;">'.$getchaDebitnotedetailsforInvoice['cgst_sgst'].'</td>
                </tr>

                <tr style="border: 1px solid black;">
                    <td style="border: 1px solid black;padding-left: 10px;padding-right: 5px;font-family:cambria;font-size:13px;">Bill Amt. (incl GST)  </td>    
                    <td colspan="5" style="border: 1px solid black;padding-left: 10px;">'.$getchaDebitnotedetailsforInvoice['taxable_amount'] + $getchaDebitnotedetailsforInvoice['cgst_sgst'].'</td>
                </tr>

                <tr style="border: 1px solid black;">
                    <td style="border: 1px solid black;padding-left: 10px;padding-right: 5px;font-family:cambria;font-size:13px;">Debit Amt  Rs. </td>    
                    <td colspan="5" style="border: 1px solid black;padding-left: 10px;">'.$getchaDebitnotedetailsforInvoice['debit_amount'].'</td>
                </tr>


                <tr style="border: 1px solid black;">
                    <td style="border: 1px solid black;padding-left: 10px;padding-right: 5px;font-family:cambria;font-size:13px;">Amount payable before TDS </td>    
                    <td colspan="5" style="border: 1px solid black;padding-left: 10px;">'.$getchaDebitnotedetailsforInvoice['amount_payable_before_tds'].'</td>
                </tr>

                 <tr style="border: 1px solid black;">
                    <td style="border: 1px solid black;padding-left: 10px;padding-right: 5px;font-family:cambria;font-size:13px;">Less TDS </td>    
                    <td colspan="5" style="border: 1px solid black;padding-left: 10px;">'.$getchaDebitnotedetailsforInvoice['less_tds'].'</td>
                </tr>

                <tr style="border: 1px solid black;">
                    <td style="border: 1px solid black;padding-left: 10px;padding-right: 5px;font-family:cambria;font-size:13px;">Payable Amt</td>    
                    <td colspan="5" style="border: 1px solid black;padding-left: 10px;">'.$getchaDebitnotedetailsforInvoice['payable_amount'].'</td>
                </tr>
                        
            </table>

            <table style=" width: 100%;text-align: left;margin-top:10px;margin-bottom:10px;font-family:cambria;font-size:12px">
                   <tr >
                        <td style="padding-left: 10px;" width="75%;" valign="top">
                            <p>Thanking You,</p>
                            <p>Yours truly</p>
                            <p style="vertical-align: text-top;font-size:12px;color:#206a9b"><b>FOR SUPRA QUALITY EXPORTS (I) PVT. LTD.</b></p>
                            <br/><img src="'.base_url().'assets/images/stmps/aprana_sign_cha.png" width="130" height="100">
                            <p style="vertical-align: text-top;font-size:10px;color:#206a9b"><b>AUTHORIZED SIGNATORY</b></p>
                        </td>
                        <td style="text-align: center;" width="25%" valign="top">
                        </td> 
                </tr>
            </table>';

            // <p>FOR SUPRA QUALITY EXPORTS (I) PVT. LTD.</p>
    $invoice_name =  $getchaDebitnotedetailsforInvoice['cha_debit_number'].' - '.$getchaDebitnotedetailsforInvoice['cha_name'].'.pdf';
    $mpdf->WriteHTML($html);
    $mpdf->Output($invoice_name,'D'); // opens in browser

}  



}