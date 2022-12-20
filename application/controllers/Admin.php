<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';
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
            $this->form_validation->set_rules('landline','Landline','trim|required|max_length[128]');
            $this->form_validation->set_rules('address','Address','trim|required');
            $this->form_validation->set_rules('phone_1','Phone 1','trim|numeric|max_length[50]');
            $this->form_validation->set_rules('contact_person','Contact Person','trim|required|max_length[50]');
            $this->form_validation->set_rules('mobile','Mobile','trim|required|numeric|max_length[50]');
            $this->form_validation->set_rules('email','Email','trim|required|valid_email|max_length[50]');
            $this->form_validation->set_rules('mobile_2','Mobile 2','trim|numeric|max_length[50]');
            $this->form_validation->set_rules('fax','Fax','trim|max_length[50]');
            $this->form_validation->set_rules('GSTIN','GSTIN','trim|required|max_length[50]');

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
            $this->form_validation->set_rules('landline','Landline','trim|required|max_length[128]');
            $this->form_validation->set_rules('address','Address','trim|required');
            $this->form_validation->set_rules('phone_1','Phone 1','trim|numeric|max_length[50]');
            $this->form_validation->set_rules('contact_person','Contact Person','trim|required|max_length[50]');
            $this->form_validation->set_rules('mobile','Mobile','trim|required|numeric|max_length[50]');
            $this->form_validation->set_rules('email','Email','trim|required|valid_email|max_length[50]');
            $this->form_validation->set_rules('mobile_2','Mobile 2','trim|numeric|max_length[50]');
            $this->form_validation->set_rules('fax','Fax','trim|max_length[50]');
            $this->form_validation->set_rules('GSTIN','GSTIN','trim|required|max_length[50]');

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
                    $save_rawmatrial_response['error'] = array('part_number'=>'Part Number Alreday Exits','type_of_raw_material'=>'Type of Raw Material Alreday Exits');
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
                        $update_rawmaterial_response['error'] = array('part_number'=>'Part Number Alreday Exits','type_of_raw_material'=>'Type of Raw Material Alreday Exits');
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
            $this->form_validation->set_rules('landline','Landline','trim|required|numeric|max_length[128]');
            $this->form_validation->set_rules('address','Address','trim|required');
            $this->form_validation->set_rules('phone_1','Phone 1','trim|numeric|max_length[50]');
            $this->form_validation->set_rules('contact_person','Contact Person','trim|required|max_length[50]');
            $this->form_validation->set_rules('mobile','Mobile','trim|required|numeric|max_length[50]');
            $this->form_validation->set_rules('email','Email','trim|required|valid_email|max_length[50]');
            $this->form_validation->set_rules('mobile_2','Mobile 2','trim|numeric|max_length[50]');
            $this->form_validation->set_rules('fax','Fax','trim|max_length[50]');
            $this->form_validation->set_rules('GSTIN','GSTIN','trim|required|max_length[50]');

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
            $this->form_validation->set_rules('landline','Landline','trim|required|numeric|max_length[128]');
            $this->form_validation->set_rules('address','Address','trim|required');
            $this->form_validation->set_rules('phone_1','Phone 1','trim|numeric|max_length[50]');
            $this->form_validation->set_rules('contact_person','Contact Person','trim|required|max_length[50]');
            $this->form_validation->set_rules('mobile','Mobile','trim|required|numeric|max_length[50]');
            $this->form_validation->set_rules('email','Email','trim|required|valid_email|max_length[50]');
            $this->form_validation->set_rules('mobile_2','Mobile 2','trim|numeric|max_length[50]');
            $this->form_validation->set_rules('fax','Fax','trim|max_length[50]');
            $this->form_validation->set_rules('GSTIN','GSTIN','trim|required|max_length[50]');

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
            $this->form_validation->set_rules('contact_person','Contact Person','trim|required|max_length[50]');
            $this->form_validation->set_rules('mobile','Mobile','trim|numeric|required|max_length[50]');
            $this->form_validation->set_rules('email','Email','trim|valid_email|max_length[50]');
            $this->form_validation->set_rules('mobile_2','Mobile 2','trim|numeric|max_length[50]');
            $this->form_validation->set_rules('fax','Fax','trim|max_length[50]');
            $this->form_validation->set_rules('GSTIN','GSTIN','trim|required|max_length[50]');

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
            $this->form_validation->set_rules('contact_person','Contact Person','trim|required|max_length[50]');
            $this->form_validation->set_rules('mobile','Mobile','trim|required|numeric|max_length[50]');
            $this->form_validation->set_rules('email','Email','trim|valid_email|max_length[50]');
            $this->form_validation->set_rules('mobile_2','Mobile 2','trim|max_length[50]');
            $this->form_validation->set_rules('fax','Fax','trim|max_length[50]');
            $this->form_validation->set_rules('GSTIN','GSTIN','trim|required|max_length[50]');

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
            $this->form_validation->set_rules('hsn_code','HSN Code','trim|required');
            $this->form_validation->set_rules('gross_weight','Gross Weight','trim|required');
            $this->form_validation->set_rules('net_weight','Net Weight','trim|required');
            $this->form_validation->set_rules('sac','SAC','trim|required');
            $this->form_validation->set_rules('drawing_number','Drawing Number','trim|required');
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

                $checkIfexitsFinishedgoods = $this->admin_model->checkIfexitsFinishedgoods(trim($this->input->post('name')));
                if($checkIfexitsFinishedgoods > 0){
                    $save_finished_goods_response['status'] = 'failure';
                    $save_finished_goods_response['error'] = array('name'=>'Name Alreday Exits');
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
            $this->form_validation->set_rules('hsn_code','HSN Code','trim|required');
            $this->form_validation->set_rules('gross_weight','Gross Weight','trim|required');
            $this->form_validation->set_rules('net_weight','Net Weight','trim|required');
            $this->form_validation->set_rules('sac','SAC','trim|required');
            $this->form_validation->set_rules('drawing_number','Drawing Number','trim|required');
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

               
                $checkifexitfinishedgoodsupdate = $this->admin_model->checkifexitfinishedgoodsupdate(trim($this->input->post('finished_goods_id')),trim($this->input->post('name')));

                if($checkifexitfinishedgoodsupdate > 0){
                    $updatefinishedgoodsdata = $this->admin_model->saveFinishedgoodsdata(trim($this->input->post('finished_goods_id')),$data);
                    if($updatefinishedgoodsdata){
                        $update_finished_goods_response['status'] = 'success';
                        $update_finished_goods_response['error'] = array('part_number'=>'', 'name'=>'', 'hsn_code'=>'', 'gross_weight'=>'','net_weight'=>'','sac'=>'','drawing_number'=>'','description_1'=>'','description_2'=>'');
                    }

                }else{

                    $checkifexitsfinished = $this->admin_model->checkIfexitsFinishedgoods(trim($this->input->post('name')));
                    if($checkifexitsfinished > 0){
                        $update_finished_goods_response['status'] = 'failure';
                        $update_finished_goods_response['error'] = array('name'=>'Finished Alreday Exits');
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

}