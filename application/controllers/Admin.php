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
            $this->form_validation->set_rules('remark','Remark','trim');


            if($this->form_validation->run() == FALSE)
            {
                $save_buyerpo_response['status'] = 'failure';
                $save_buyerpo_response['error'] = array('sales_order_number'=>strip_tags(form_error('sales_order_number')), 'date'=>strip_tags(form_error('date')), 'buyer_po_number'=>strip_tags(form_error('buyer_po_number')), 'buyer_po_date'=>strip_tags(form_error('buyer_po_date')),'buyer_name'=>strip_tags(form_error('buyer_name')),'currency'=>strip_tags(form_error('currency')),'rate'=>strip_tags(form_error('rate')),'value'=>strip_tags(form_error('value')),'part_number'=>strip_tags(form_error('part_number')),'order_quantity'=>strip_tags(form_error('order_quantity')),'description'=>strip_tags(form_error('description')),'delivery_date'=>strip_tags(form_error('delivery_date')),'remark'=>strip_tags(form_error('remark')));
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
                                    $save_buyerpo_response['error'] = array('sales_order_number'=>strip_tags(form_error('sales_order_number')), 'date'=>strip_tags(form_error('date')), 'buyer_po_number'=>strip_tags(form_error('buyer_po_number')), 'buyer_po_date'=>strip_tags(form_error('buyer_po_date')),'buyer_name'=>strip_tags(form_error('buyer_name')),'currency'=>strip_tags(form_error('currency')),'rate'=>strip_tags(form_error('rate')),'value'=>strip_tags(form_error('value')),'part_number'=>strip_tags(form_error('part_number')),'order_quantity'=>strip_tags(form_error('order_quantity')),'description'=>strip_tags(form_error('description')),'delivery_date'=>strip_tags(form_error('delivery_date')),'remark'=>strip_tags(form_error('remark')));
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
                            'remark' =>    trim($this->input->post('remark')),
                        );

                        $saveBuyerpodata = $this->admin_model->saveBuyerpodata($po_id,$data);
                        if($saveBuyerpodata){
                                $save_buyerpo_response['status'] = 'success';
                                $save_buyerpo_response['error'] = array('sales_order_number'=>strip_tags(form_error('sales_order_number')), 'date'=>strip_tags(form_error('date')), 'buyer_po_number'=>strip_tags(form_error('buyer_po_number')), 'buyer_po_date'=>strip_tags(form_error('buyer_po_date')),'buyer_name'=>strip_tags(form_error('buyer_name')),'currency'=>strip_tags(form_error('currency')),'rate'=>strip_tags(form_error('rate')),'value'=>strip_tags(form_error('value')),'part_number'=>strip_tags(form_error('part_number')),'order_quantity'=>strip_tags(form_error('order_quantity')),'description'=>strip_tags(form_error('description')),'delivery_date'=>strip_tags(form_error('delivery_date')),'remark'=>strip_tags(form_error('remark')));
                          
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
        
            if($this->form_validation->run() == FALSE)
            {
                $save_buyerpoitem_response['status'] = 'failure';
                $save_buyerpoitem_response['error'] = array('part_number'=>strip_tags(form_error('part_number')), 'description'=>strip_tags(form_error('description')), 'qty'=>strip_tags(form_error('qty')), 'rate'=>strip_tags(form_error('rate')),'value'=>strip_tags(form_error('value')));
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
                            'pre_buyer_po_number'=>trim($this->input->post('buyer_po_number')),
                            'pre_date'=>trim($this->input->post('date')),
                            'pre_buyer_po_date'=>trim($this->input->post('buyer_po_date')),
                            'pre_buyer_name' =>trim($this->input->post('buyer_name')),
                            'pre_currency' =>trim($this->input->post('currency')),
                            'pre_delivery_date' =>trim($this->input->post('delivery_date')),
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
                                'pre_buyer_po_number'=>trim($this->input->post('buyer_po_number')),
                                'pre_date'=>trim($this->input->post('date')),
                                'pre_buyer_po_date'=>trim($this->input->post('buyer_po_date')),
                                'pre_buyer_name' =>trim($this->input->post('buyer_name')),
                                'pre_currency' =>trim($this->input->post('currency')),
                                'pre_delivery_date' =>trim($this->input->post('delivery_date')),
                                'pre_remark' =>trim($this->input->post('remark')),
                            );

                        }

                // $checkIfexitsbuyerpo = $this->admin_model->checkIfexitsbuyerpo(trim($this->input->post('sales_order_number')));
                // if($checkIfexitsbuyerpo > 0){
                //     $save_buyerpo_response['status'] = 'failure';
                //     $save_buyerpo_response['error'] = array('sales_order_number'=>'Buyer PO Alreday Exits (Sales Order Number Alreday Exits)');
                // }else{
                    $saveBuyerpoitemdata = $this->admin_model->saveBuyerpoitemdata($po_id,$data);
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
                    $saveSupplierpoitemdata = $this->admin_model->saveSupplierpoitemdata($supplier_po_id,$data);
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
            $result = $this->admin_model->deleteSupplierpoconfirmationitem(trim($this->input->post('id')));
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
			$getAllponumber = $this->admin_model->getAllBuyerpoNUmber($this->input->post('buyer_name'));
			if(count($getAllponumber) >= 1) {
                $content = $content.'<option value="">Select Buyer Number</option>';
				foreach($getAllponumber as $value) {
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

    public function getBuyerItemsforDisplay(){


        $post_submit = $this->input->post();

        if($post_submit){

            $buyer_po_number = $this->input->post('buyer_po_number');
        
            // load table library
            $this->load->library('table');
            
            // set heading
            $this->table->set_heading('Part Number', 'Description', 'Order Qty','Unit', 'Rate','Value');

            // set template
            $style = array('table_open'  => '<p><b>Buyer PO Item</b></p><table style="width: 70% !important; max-width: 100%;margin-bottom: 20px;" class="table">');

            $this->table->set_template($style);

            $this->db->select(TBL_FINISHED_GOODS.'.part_number,'.TBL_BUYER_PO_MASTER_ITEM.'.description,'.TBL_BUYER_PO_MASTER_ITEM.'.order_oty,'.TBL_BUYER_PO_MASTER_ITEM.'.unit,'.TBL_BUYER_PO_MASTER_ITEM.'.rate,'.TBL_BUYER_PO_MASTER_ITEM.'.value');
            $this->db->join(TBL_FINISHED_GOODS, TBL_FINISHED_GOODS.'.fin_id = '.TBL_BUYER_PO_MASTER_ITEM.'.part_number_id');
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
                $getPartNameBypartid = $this->admin_model->getfinishedgoodsPartnumberByid($this->input->post('part_number'),$this->input->post('flag'));

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
                    $saveSupplierpoitemdata = $this->admin_model->saveVendorpoitemdata('',$data);
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

        $process = 'Edit Vendor PO';
        $processFunction = 'Admin/editSupplierconfirmation';
        $this->logrecord($process,$processFunction);
        $this->global['pageTitle'] = 'Edit Vendor PO';
        $data['supplierList']= $this->admin_model->fetchALLsupplierList();
        $data['buyerList']= $this->admin_model->fetchAllbuyerList();
        $data['vendorList']= $this->admin_model->fetchALLvendorList();
        $data['supplierpoconfirmationid'] = $supplierpoconfirmationid;
        $data['getSupplierpoconfirmationdetails']= $this->admin_model->getSupplierpoconfirmationdetails($supplierpoconfirmationid)[0];
        $data['fetchALLSupplierPOitemsforview']= $this->admin_model->fetchALLSupplierPOitemsforview($supplierpoconfirmationid);
        $this->loadViews("masters/editSupplierpoconfirmation", $this->global, $data, NULL);
    }


    public function getSupplierPonumberbySupplierid(){

        $supplier_name=$this->input->post('supplier_name');

        if($supplier_name) {
			$getSupplierdetails = $this->admin_model->getSupplierDeatilsbyid($supplier_name);
			if(count($getSupplierdetails) >= 1) {
                $content = $content.'<option value="">Select Supplier PO Number</option>';
				foreach($getSupplierdetails as $value) {
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

    public function getSupplierItemsforDisplay(){


        $post_submit = $this->input->post();

        if($post_submit){

            $supplier_po_number = $this->input->post('supplier_po_number');
        
            // load table library
            $this->load->library('table');
            
            // set heading
            $this->table->set_heading('Part Number', 'Description', 'Order Qty','Unit', 'Rate','Value');

            // set template
            $style = array('table_open'  => '<p><b>Supplier PO Item</b></p><table style="width: 70% !important; max-width: 100%;margin-bottom: 20px;" class="table">');

            $this->table->set_template($style);

            $this->db->select(TBL_RAWMATERIAL.'.part_number,'.TBL_SUPPLIER_PO_MASTER_ITEM.'.description,'.TBL_SUPPLIER_PO_MASTER_ITEM.'.order_oty,'.TBL_SUPPLIER_PO_MASTER_ITEM.'.unit,'.TBL_SUPPLIER_PO_MASTER_ITEM.'.rate,'.TBL_SUPPLIER_PO_MASTER_ITEM.'.value');
            $this->db->join(TBL_RAWMATERIAL, TBL_RAWMATERIAL.'.raw_id = '.TBL_SUPPLIER_PO_MASTER_ITEM.'.part_number_id');
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
                    $saveSupplierpoconfirmationitemdata = $this->admin_model->saveSupplierpoconfirmationitemdata('',$data);
                    
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
			$getVendoritemsonly = $this->admin_model->getVendoritemsonly($vendor_po_number);
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

    public function getSuppliergoodsPartnumberByid(){

        if($this->input->post('part_number')) {
            $getPartNameBypartid = $this->admin_model->getSuppliergoodsPartnumberByid($this->input->post('part_number'));

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
                    $saveVendorconfromation_main_id = '';
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

                    $saveVendorpoconfirmationitemdata = $this->admin_model->saveVendorpoconfirmationitemdata('',$data);
                    
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
            $this->form_validation->set_rules('grand_total','Grand Total','trim|required');
            //$this->form_validation->set_rules('item_remark ','Item Remark','trim|required');
    
            if($this->form_validation->run() == FALSE)
            {
                $save_jobwork_response['status'] = 'failure';
                $save_jobwork_response['error'] = array(
                    'part_number'=>strip_tags(form_error('part_number')),'description'=>strip_tags(form_error('description')),'rm_actual_aty'=>strip_tags(form_error('rm_actual_aty')),'vendor_order_qty'=>strip_tags(form_error('vendor_order_qty')),'unit'=>strip_tags(form_error('unit')),'rm_rate'=>strip_tags(form_error('rm_rate')),'value'=>strip_tags(form_error('value')),'packing_and_forwarding'=>strip_tags(form_error('packing_and_forwarding')),'total'=>strip_tags(form_error('total')),'gst'=>strip_tags(form_error('gst')),'grand_total'=>strip_tags(form_error('grand_total')));
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
                    'grand_total'	=>trim($this->input->post('grand_total')),
                    'item_remark' =>trim($this->input->post('item_remark')),
                    'pre_date'=> trim($this->input->post('pre_date')),
                    'pre_vendor_name' => trim($this->input->post('pre_vendor_name')),
                    'pre_vendor_po_number' => trim($this->input->post('pre_vendor_po_number')),
                    'pre_raw_material_supplier_name' => trim($this->input->post('pre_raw_material_supplier_name')),
                    'pre_remark' => trim($this->input->post('pre_remark')),
                );


               }


               

                // $checkIfexitsbuyerpo = $this->admin_model->checkIfexitsbuyerpo(trim($this->input->post('sales_order_number')));
                // if($checkIfexitsbuyerpo > 0){
                //     $save_buyerpo_response['status'] = 'failure';
                //     $save_buyerpo_response['error'] = array('sales_order_number'=>'Buyer PO Alreday Exits (Sales Order Number Alreday Exits)');
                // }else{
                    $saveJobworkitemdata = $this->admin_model->saveJobworkitemdata('',$data);

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
                    'buyer_name' =>    trim($this->input->post('buyer_name')),
                    'buyer_po_number' =>    trim($this->input->post('buyer_po_number')),
                    'buyer_po_date' =>    trim($this->input->post('buyer_po_date')),
                    'buyer_delivery_date' =>    trim($this->input->post('buyer_delivery_date')),
                    'bom_status' =>    trim($this->input->post('bom_status')),
                    'incoming_details'=>   trim($this->input->post('incoming_details')),
                    'remark' =>    trim($this->input->post('remark')),
                );

                $checkIfexitsBillofmaterial = $this->admin_model->checkIfexitsBillofmaterial(trim($this->input->post('bom_number')));
                if($checkIfexitsBillofmaterial > 0){
                        $save_Billofmaterial_response['status'] = 'failure';
                        $save_Billofmaterial_response['error'] = array( 'bom_number'=>strip_tags(form_error('bom_number')),
                        'date'=>strip_tags(form_error('date')),
                        'vendor_name'=>strip_tags(form_error('vendor_name')),
                        'vendor_po_number'=>strip_tags(form_error('vendor_po_number')),
                        'supplier_name'=>strip_tags(form_error('supplier_name')),
                        'supplier_po_number'=>strip_tags(form_error('supplier_po_number')),
                        'buyer_name'=>strip_tags(form_error('buyer_name')),
                        'buyer_po_number'=>strip_tags(form_error('buyer_po_number')),
                        'buyer_po_date'=>strip_tags(form_error('buyer_po_date')),
                        'buyer_delivery_date'=>strip_tags(form_error('buyer_delivery_date')),
                        'buyer_delivery_date'=>strip_tags(form_error('buyer_delivery_date')),
                        'incoming_details'=>strip_tags(form_error('incoming_details')),
                        'bom_status'=>strip_tags(form_error('bom_status')),
                        'remark'=>strip_tags(form_error('remark')));
                }else{
                    $saveBillofmaterial = $this->admin_model->saveBillofmaterial('',$data);

                    

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

                }

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

                $checkIfexitsvendorBillofmaterial = $this->admin_model->checkIfexitsvendorBillofmaterial(trim($this->input->post('bom_number')));
                if($checkIfexitsvendorBillofmaterial > 0){
                    $save_vendorBillofmaterial_response['status'] = 'failure';
                    $save_vendorBillofmaterial_response['error'] = array( 'bom_number'=>strip_tags(form_error('bom_number')),'date'=>strip_tags(form_error('date')),'vendor_name'=>strip_tags(form_error('vendor_name')),'vendor_po_number'=>strip_tags(form_error('vendor_po_number')),'bom_status'=>strip_tags(form_error('bom_status')),'remark'=>strip_tags(form_error('remark')), 'buyer_name'=>strip_tags(form_error('buyer_name')),'buyer_po_number'=>strip_tags(form_error('buyer_po_number')),'buyer_po_date'=>strip_tags(form_error('buyer_po_date')),'buyer_delivery_date'=>strip_tags(form_error('buyer_delivery_date')),'bom_status'=>strip_tags(form_error('bom_status')));
                }else{

                    $savevendorBillofmaterial = $this->admin_model->savevendorBillofmaterial('',$data);

                    if($savevendorBillofmaterial){
                        $update_last_inserted_id_vendor_bill_of_materil= $this->admin_model->update_last_inserted_id_vendor_bill_of_materil($savevendorBillofmaterial);
                        if($update_last_inserted_id_vendor_bill_of_materil){
                             $save_vendorBillofmaterial_response['status'] = 'success';
                             $save_vendorBillofmaterial_response['error'] = array( 'bom_number'=>strip_tags(form_error('bom_number')),'date'=>strip_tags(form_error('date')),'vendor_name'=>strip_tags(form_error('vendor_name')),'vendor_po_number'=>strip_tags(form_error('vendor_po_number')),'bom_status'=>strip_tags(form_error('bom_status')),'remark'=>strip_tags(form_error('remark')), 'buyer_name'=>strip_tags(form_error('buyer_name')),'buyer_po_number'=>strip_tags(form_error('buyer_po_number')),'buyer_po_date'=>strip_tags(form_error('buyer_po_date')),'buyer_delivery_date'=>strip_tags(form_error('buyer_delivery_date')),'bom_status'=>strip_tags(form_error('bom_status')));
                        }
                    }

                }
            }

            echo json_encode($save_vendorBillofmaterial_response);
        }else{

            $process = 'Add New Vendor Bill Of Material';
            $processFunction = 'Admin/addjobwork';
            $this->logrecord($process,$processFunction);
            $this->global['pageTitle'] = 'Add New Vendor Bill Of Material';
            $data['getPreviousBomnumber']= $this->admin_model->getPreviousBomnumbervendor()[0];
            $data['fetchALLpreVendorpoitemList']= $this->admin_model->fetchALLpreVendorpoitemList();
            $data['buyerList']= $this->admin_model->fetchAllbuyerList();
            $data['vendorList']= $this->admin_model->fetchALLvendorListwithoutsupplier();
            $data['incoming_details']= $this->admin_model->fetchAllincomingdetailsList();
            $this->loadViews("masters/addvendorBillofmaterial", $this->global, $data, NULL);

        }
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
            $this->form_validation->set_rules('vendor_received_aty','Vendor Received Qty','trim|required');
            $this->form_validation->set_rules('balanced_aty','Balanced Qty','trim|required');
            $this->form_validation->set_rules('item_remark','Item Remark','trim');

            if($this->form_validation->run() == FALSE)
            {
                $save_billofmaterial_response['status'] = 'failure';
                $save_billofmaterial_response['error'] = array('part_number'=>strip_tags(form_error('part_number')), 'description'=>strip_tags(form_error('description')), 'buyer_order_qty'=>strip_tags(form_error('buyer_order_qty')), 'vendor_order_qty'=>strip_tags(form_error('vendor_order_qty')),'vendor_received_aty'=>strip_tags(form_error('vendor_received_aty')),'balanced_aty'=>strip_tags(form_error('balanced_aty')));
            }else{

                
                $data = array(
                    'part_number_id'   => trim($this->input->post('part_number')),
                    'description'     => trim($this->input->post('description')),
                    'buyer_order_qty'=> trim($this->input->post('buyer_order_qty')),
                    'vendor_order_qty'=> trim($this->input->post('vendor_order_qty')),
                    'vendor_received_qty'=> trim($this->input->post('vendor_received_aty')),
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
                    $saveVendorbillofmaterilitemdata = $this->admin_model->saveVendorbillofmaterilitemdata('',$data);
                    
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
            $this->form_validation->set_rules('remark','Remark','trim');

            if($this->form_validation->run() == FALSE)
            {
                $packing_instrction_response['status'] = 'failure';
                $packing_instrction_response['error'] = array( 'packing_id_number'=>strip_tags(form_error('packing_id_number')),'buyer_name'=>strip_tags(form_error('buyer_name')),'buyer_po_number'=>strip_tags(form_error('buyer_po_number')),'buyer_po_date'=>strip_tags(form_error('buyer_po_date')),'remark'=>strip_tags(form_error('remark')));
           
            }else{

                $data = array(
                    'packing_instrauction_id'   => trim($this->input->post('packing_id_number')),
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
                            'remark' =>    trim($this->input->post('remark'))
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
                                    'remark' =>    trim($this->input->post('remark'))
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
            $this->loadViews("masters/addnewencomingdetails", $this->global, $data, NULL);

        }
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


                if($this->input->post('incomingdetail_editid')){

                     /*Check Uniqe Validation in lot number*/
                     $checkLotnumberisexits= $this->admin_model->checkLotnumberisexitsedit(trim($this->input->post('incomingdetail_editid')),trim($this->input->post('lot_no')), trim($this->input->post('part_number')));

                     if($checkLotnumberisexits){

                        $save_incoming_details_items['status'] = 'failure';
                        $save_incoming_details_items['error'] = array('part_number'=>strip_tags(form_error('part_number')),'description'=>strip_tags(form_error('description')),'p_o_qty'=>strip_tags(form_error('p_o_qty')),'net_weight'=>strip_tags(form_error('net_weight')),'invoice_no'=>strip_tags(form_error('invoice_no')),'invoice_date'=>strip_tags(form_error('invoice_date')),'challan_no'=>strip_tags(form_error('challan_no')),'challan_date'=>strip_tags(form_error('challan_date')),'received_date'=>strip_tags(form_error('received_date')),'invoice_qty'=>strip_tags(form_error('invoice_qty')),'invoice_qty_in_kgs'=>strip_tags(form_error('invoice_qty_in_kgs')),'balance_qty'=>strip_tags(form_error('balance_qty')),'fg_material_gross_weight'=>strip_tags(form_error('fg_material_gross_weight')),'units'=>strip_tags(form_error('units')),'boxex_goni_bundle'=>strip_tags(form_error('boxex_goni_bundle')),'remarks'=>strip_tags(form_error('remarks')),'lot_no'=>'Lot Number Alreday Exits');

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

                            $saveIncomingdetailsitem= $this->admin_model->saveIncomingdetailsitem('',$data);

                            if($saveIncomingdetailsitem){
                                $save_incoming_details_items['status'] = 'success';
                                $save_incoming_details_items['error'] = array('part_number'=>strip_tags(form_error('part_number')),'description'=>strip_tags(form_error('description')),'p_o_qty'=>strip_tags(form_error('p_o_qty')),'net_weight'=>strip_tags(form_error('net_weight')),'invoice_no'=>strip_tags(form_error('invoice_no')),'invoice_date'=>strip_tags(form_error('invoice_date')),'challan_no'=>strip_tags(form_error('challan_no')),'challan_date'=>strip_tags(form_error('challan_date')),'received_date'=>strip_tags(form_error('received_date')),'invoice_qty'=>strip_tags(form_error('invoice_qty')),'invoice_qty_in_kgs'=>strip_tags(form_error('invoice_qty_in_kgs')),'balance_qty'=>strip_tags(form_error('balance_qty')),'fg_material_gross_weight'=>strip_tags(form_error('fg_material_gross_weight')),'units'=>strip_tags(form_error('units')),'boxex_goni_bundle'=>strip_tags(form_error('boxex_goni_bundle')),'remarks'=>strip_tags(form_error('remarks')),'lot_no'=>strip_tags(form_error('lot_no')));
                            }
                }


                }else{


                     /*Check Uniqe Validation in lot number*/
                     $checkLotnumberisexits= $this->admin_model->checkLotnumberisexitsadd(trim($this->input->post('lot_no')),trim($this->input->post('part_number')),trim($this->input->post('pre_vendor_po_number')));

                     if($checkLotnumberisexits){

                        $save_incoming_details_items['status'] = 'failure';
                        $save_incoming_details_items['error'] = array('part_number'=>strip_tags(form_error('part_number')),'description'=>strip_tags(form_error('description')),'p_o_qty'=>strip_tags(form_error('p_o_qty')),'net_weight'=>strip_tags(form_error('net_weight')),'invoice_no'=>strip_tags(form_error('invoice_no')),'invoice_date'=>strip_tags(form_error('invoice_date')),'challan_no'=>strip_tags(form_error('challan_no')),'challan_date'=>strip_tags(form_error('challan_date')),'received_date'=>strip_tags(form_error('received_date')),'invoice_qty'=>strip_tags(form_error('invoice_qty')),'invoice_qty_in_kgs'=>strip_tags(form_error('invoice_qty_in_kgs')),'balance_qty'=>strip_tags(form_error('balance_qty')),'fg_material_gross_weight'=>strip_tags(form_error('fg_material_gross_weight')),'units'=>strip_tags(form_error('units')),'boxex_goni_bundle'=>strip_tags(form_error('boxex_goni_bundle')),'remarks'=>strip_tags(form_error('remarks')),'lot_no'=>'Lot Number Alreday Exits');

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

                        $saveIncomingdetailsitem= $this->admin_model->saveIncomingdetailsitem('',$data);

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
        $data['getbuyeritemdetails'] =  $this->admin_model->getbuyeritemdetails(trim($buyer_po_number));
        $data['getpackingdetails_itemdetails'] =  $this->admin_model->getpackingdetails_itemdetails(trim($main_id));
        $this->loadViews("masters/addpackinginstractiondetails", $this->global, $data, NULL);  


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

            if($this->form_validation->run() == FALSE)
            {
                $add_packing_instraction_details_response['status'] = 'failure';
                $add_packing_instraction_details_response['error'] = array('part_number'=>strip_tags(form_error('part_number')),'buyer_invoice_number'=>strip_tags(form_error('buyer_invoice_number')),'buyer_invoice_date'=>strip_tags(form_error('buyer_invoice_date')),'buyer_invoice_qty'=>strip_tags(form_error('buyer_invoice_qty')),'box_qty'=>strip_tags(form_error('box_qty')),'remark'=>strip_tags(form_error('remark')));
           
            }else{


                $data = array(
                    'packing_instract_id'   => trim($this->input->post('main_id')),
                    'part_number'  => trim($this->input->post('part_number')),
                    'buyer_invoice_number'=> trim($this->input->post('buyer_invoice_number')),
                    'buyer_invoice_date' =>    trim($this->input->post('buyer_invoice_date')),
                    'buyer_invoice_qty' =>    trim($this->input->post('buyer_invoice_qty')),
                    'box_qty' =>    trim($this->input->post('box_qty')),
                    'remark' =>    trim($this->input->post('remark'))
                );


                $savePackinginstarction= $this->admin_model->savePackinginstarctiondetails('',$data);

                if($savePackinginstarction){
                    $add_packing_instraction_details_response['status'] = 'success';
                    $add_packing_instraction_details_response['error'] = array( 'incoming_no'=>strip_tags(form_error('incoming_no')),'vendor_name'=>strip_tags(form_error('vendor_name')),'vendor_po_number'=>strip_tags(form_error('vendor_po_number')),'reported_by'=>strip_tags(form_error('reported_by')),'reported_date'=>strip_tags(form_error('reported_date')),'remark'=>strip_tags(form_error('remark')));
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
                     $buyer_po_number =  $this->input->post('buyer_po_number_existing');
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

            $this->db->select(TBL_RAWMATERIAL.'.part_number,'.TBL_VENDOR_PO_MASTER_ITEM.'.description,'.TBL_VENDOR_PO_MASTER_ITEM.'.order_oty,'.TBL_VENDOR_PO_MASTER_ITEM.'.unit,'.TBL_VENDOR_PO_MASTER_ITEM.'.rate,'.TBL_VENDOR_PO_MASTER_ITEM.'.value');
            $this->db->join(TBL_RAWMATERIAL, TBL_RAWMATERIAL.'.raw_id = '.TBL_VENDOR_PO_MASTER_ITEM.'.part_number_id');
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

                 $data = array(
                    'part_number'=>$this->input->post('part_number'),
                    'rm_actual_aty'=>$this->input->post('rm_actual_aty'),
                    'expected_qty'=>$this->input->post('expected_qty'),
                    'vendor_actual_recived_qty'=>$this->input->post('vendor_actual_received_Qty'),
                    'net_weight_per_pcs'=>$this->input->post('net_weight_per_pcs'),
                    'total_neight_weight'=>$this->input->post('total_net_weight'),
                    'short_excess'=>$this->input->post('short_access'),
                    'scrap_in_kgs'=>$this->input->post('scrap'),
                    'actual_scrap_received_in_kgs'=>$this->input->post('actual_scrap_recived'),
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

                    $saveBillofmaterialitamdata = $this->admin_model->saveBillofmaterialitamdata('',$data);

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
            $this->form_validation->set_rules('vendor_name','Vendor Name','trim');
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
                
                $saveIncomingdetailsitem= $this->admin_model->saveNewscrapreturn('',$data);

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
            $objPHPExcel->getActiveSheet()->SetCellValue('D1', 'Buyer Part No');
            $objPHPExcel->getActiveSheet()->SetCellValue('E1', 'Buyer Order Qty');    
            $objPHPExcel->getActiveSheet()->SetCellValue('F1', 'Buyer Delivery Date');
            $objPHPExcel->getActiveSheet()->SetCellValue('G1', 'Vendor PO Number');
            $objPHPExcel->getActiveSheet()->SetCellValue('H1', 'Vendor PO DATE');
            $objPHPExcel->getActiveSheet()->SetCellValue('I1', 'Raw Material Supplier');   
            $objPHPExcel->getActiveSheet()->SetCellValue('J1', 'Vendor');  
            $objPHPExcel->getActiveSheet()->SetCellValue('K1', 'Part Description');  
            $objPHPExcel->getActiveSheet()->SetCellValue('L1', 'Part No');  
            $objPHPExcel->getActiveSheet()->SetCellValue('M1', 'Order Quantity');  
            $objPHPExcel->getActiveSheet()->SetCellValue('N1', 'Delivery Date');  
            $objPHPExcel->getActiveSheet()->SetCellValue('O1', 'Received Quantity');  
            $objPHPExcel->getActiveSheet()->SetCellValue('P1', 'Scrap Received');  
            $objPHPExcel->getActiveSheet()->SetCellValue('Q1', 'Current Status');  
            $objPHPExcel->getActiveSheet()->SetCellValue('R1', 'Remarks');  

            // set Row
            $rowCount = 2;
            foreach ($empInfo as $element) {
                $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $element['buyer_name']);
                $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $element['sales_order_number']);
                $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $element['buyer_po_date']);
                $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $element['part_number'] .' - '. $element['partname']);
                $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $element['vendor_order_qty']);
                $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, $element['buyer_delivery_date']);
                $objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, $element['vendor_po']);
                $objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, $element['date']);
                $objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, "");
                $objPHPExcel->getActiveSheet()->SetCellValue('J' . $rowCount, $element['vendor']);
                $objPHPExcel->getActiveSheet()->SetCellValue('K' . $rowCount, $element['partname']);
                $objPHPExcel->getActiveSheet()->SetCellValue('L' . $rowCount, $element['part_number']);
                $objPHPExcel->getActiveSheet()->SetCellValue('M' . $rowCount, $element['vendor_order_qty']);
                $objPHPExcel->getActiveSheet()->SetCellValue('N' . $rowCount, $element['buyer_delivery_date']); 
                $objPHPExcel->getActiveSheet()->SetCellValue('O' . $rowCount, $element['vendor_received_qty']); 
                $objPHPExcel->getActiveSheet()->SetCellValue('P' . $rowCount, ""); 
                $objPHPExcel->getActiveSheet()->SetCellValue('Q' . $rowCount,$element['bom_status']); 
                $objPHPExcel->getActiveSheet()->SetCellValue('R' . $rowCount,$element['item_remark']); 

                $rowCount++;
            }

            foreach(range('A','R') as $columnID) {
                $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
			}
			/*********************Autoresize column width depending upon contents END***********************/
			
            $objPHPExcel->getActiveSheet()->getStyle('A1:R1')->getFont()->setBold(true); //Make heading font bold
			
			/*********************Add color to heading START**********************/
            $objPHPExcel->getActiveSheet()
						->getStyle('A1:R1')
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
        if($this->input->post('part_number')) {
            $getPartNameBypartid = $this->admin_model->getSuppliergoodsreworkrejectionsupplier($this->input->post('part_number'),$this->input->post('vendor_po_number'),$this->input->post('supplier_po_number'));
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
            $this->form_validation->set_rules('rate','Rate','trim|required');
            $this->form_validation->set_rules('value','value','trim|required');
            $this->form_validation->set_rules('row_material_cost','row_material_cost','trim|required');
            $this->form_validation->set_rules('gst_rate','gst_rate','trim|required');
            $this->form_validation->set_rules('grand_total','gst_rate','trim|required');
            $this->form_validation->set_rules('item_remark','Item Remark','trim');

            if($this->form_validation->run() == FALSE)
            {
                $savereworkrejectiontem_response['status'] = 'failure';
                $savereworkrejectiontem_response['error'] = array('part_number'=>strip_tags(form_error('part_number')),'description'=>strip_tags(form_error('description')),'rejected_work_reason'=>strip_tags(form_error('rejected_work_reason')),'quantity'=>strip_tags(form_error('quantity')),'rate'=>strip_tags(form_error('rate')),'value'=>strip_tags(form_error('value')),'row_material_cost'=>strip_tags(form_error('row_material_cost')),'gst_rate'=>strip_tags(form_error('gst_rate')),'grand_total'=>strip_tags(form_error('grand_total')),'item_remark'=>strip_tags(form_error('item_remark')));
           
            }else{

                $reworkrejectionid =  trim($this->input->post('reworkrejectionid'));
                if($reworkrejectionid){
                    $data = array(
                        'part_number' =>  trim($this->input->post('part_number')),
                        'rework_rejection_id' =>  $reworkrejectionid,
                        'rejection_rework_reason' =>  trim($this->input->post('rejected_work_reason')),
                        'qty' =>  trim($this->input->post('quantity')),
                        'rate' =>  trim($this->input->post('rate')),
                        'value' =>  trim($this->input->post('value')),
                        'row_material_cost' =>  trim($this->input->post('row_material_cost')),
                        'gst_rate' =>  trim($this->input->post('gst_rate')),
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
                        'pre_total_bags' =>    trim($this->input->post('pre_total_bags')),
                        'pre_remark' =>    trim($this->input->post('pre_remark')),
                    );
                }else{

                    $data = array(
                        'part_number' =>  trim($this->input->post('part_number')),
                         // 'description' =>  trim($this->input->post('description')),
                        'rejection_rework_reason' =>  trim($this->input->post('rejected_work_reason')),
                        'qty' =>  trim($this->input->post('quantity')),
                        'rate' =>  trim($this->input->post('rate')),
                        'value' =>  trim($this->input->post('value')),
                        'row_material_cost' =>  trim($this->input->post('row_material_cost')),
                        'gst_rate' =>  trim($this->input->post('gst_rate')),
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
                        'pre_total_bags' =>    trim($this->input->post('pre_total_bags')),
                        'pre_remark' =>    trim($this->input->post('pre_remark')),
                    );
                }

                $savereworkrejectionitemdetails= $this->admin_model->savereworkrejectionitemdetails('',$data);
                if($savereworkrejectionitemdetails){
                    $savereworkrejectiontem_response['status'] = 'success';
                    $savereworkrejectiontem_response['error'] = array('part_number'=>strip_tags(form_error('part_number')),'description'=>strip_tags(form_error('description')),'rejected_work_reason'=>strip_tags(form_error('rejected_work_reason')),'quantity'=>strip_tags(form_error('quantity')),'rate'=>strip_tags(form_error('rate')),'value'=>strip_tags(form_error('value')),'row_material_cost'=>strip_tags(form_error('row_material_cost')),'gst_rate'=>strip_tags(form_error('gst_rate')),'grand_total'=>strip_tags(form_error('grand_total')),'item_remark'=>strip_tags(form_error('item_remark')));
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

            if($this->form_validation->run() == FALSE)
            {
                $addmewchallanform_response['status'] = 'failure';
                $addmewchallanform_response['error'] = array('challan_no'=>strip_tags(form_error('challan_no')),'challan_date'=>strip_tags(form_error('challan_date')),'vendor_name'=>strip_tags(form_error('vendor_name')),'vendor_po_number'=>strip_tags(form_error('vendor_po_number')),'supplier_name'=>strip_tags(form_error('supplier_name')),'supplier_po_number'=>strip_tags(form_error('supplier_po_number')),'remark'=>strip_tags(form_error('remark')));
            }else{

                $data = array(
                    'challan_no' =>  trim($this->input->post('challan_no')),
                    'challan_date' => trim($this->input->post('challan_date')),
                    'vendor_supplier_type'=>trim($this->input->post('vendor_supplier_name')),
                    'vendor_name' =>  trim($this->input->post('vendor_name')),
                    'vendor_po_number' =>  trim($this->input->post('vendor_po_number')),
                    'supplier_name' =>  trim($this->input->post('supplier_name')),
                    'supplier_po_number' =>  trim($this->input->post('supplier_po_number')),
                    'remark' =>  trim($this->input->post('remark')),
                );

                $challanformid = trim($this->input->post('challan_id'));
                if($challanformid){
                    $saveNewchallan= $this->admin_model->savechallanformdetails($challanformid,$data);
                    if($saveNewchallan){
                        $addmewchallanform_response['status'] = 'success';
                        $addmewchallanform_response['error'] = array('challan_no'=>strip_tags(form_error('challan_no')),'challan_date'=>strip_tags(form_error('challan_date')),'vendor_name'=>strip_tags(form_error('vendor_name')),'vendor_po_number'=>strip_tags(form_error('vendor_po_number')),'supplier_name'=>strip_tags(form_error('supplier_name')),'supplier_po_number'=>strip_tags(form_error('supplier_po_number')),'remark'=>strip_tags(form_error('remark')));
                    }
                }else{
                    $saveNewchallan= $this->admin_model->savechallanformdetails('',$data);
                    if($saveNewchallan){
                        $update_last_inserted_id_challan_form = $this->admin_model->update_last_inserted_id_challan_form($saveNewchallan);
                         if($update_last_inserted_id_challan_form){
                            $addmewchallanform_response['status'] = 'success';
                            $addmewchallanform_response['error'] = array('challan_no'=>strip_tags(form_error('challan_no')),'challan_date'=>strip_tags(form_error('challan_date')),'vendor_name'=>strip_tags(form_error('vendor_name')),'vendor_po_number'=>strip_tags(form_error('vendor_po_number')),'supplier_name'=>strip_tags(form_error('supplier_name')),'supplier_po_number'=>strip_tags(form_error('supplier_po_number')),'remark'=>strip_tags(form_error('remark')));
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
            $this->form_validation->set_rules('type_of_raw_platting','Type of Raw Platting','trim|required');
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
                        'type_of_raw_platting' =>  trim($this->input->post('type_of_raw_platting')),
                        'row_material_cost' =>  trim($this->input->post('row_material_cost')),
                        'gst_rate' =>  trim($this->input->post('gst_rate')),
                        'grand_total' =>  trim($this->input->post('grand_total')),
                        'item_remark' =>  trim($this->input->post('item_remark')),
                        'pre_challan_date' =>   trim($this->input->post('pre_challan_date')),
                        'pre_vendor_supplier_name ' =>   trim($this->input->post('pre_vendor_supplier_name')),
                        'pre_vendor_name' =>   trim($this->input->post('pre_vendor_name')),
                        'pre_vendor_po_number' =>    trim($this->input->post('pre_vendor_po_number')),
                        'pre_supplier_name' =>  trim($this->input->post('pre_supplier_name')),
                        'pre_supplier_po_number' =>    trim($this->input->post('pre_supplier_po_number')),
                        'pre_remark' =>    trim($this->input->post('pre_remark')),
                    );
                }else{

                    $data = array(
                        'part_number' =>  trim($this->input->post('part_number')),
                         // 'description' =>  trim($this->input->post('description')),
                        'qty' =>  trim($this->input->post('quantity')),
                        'rate' =>  trim($this->input->post('rate')),
                        'value' =>  trim($this->input->post('value')),
                        'type_of_raw_platting' =>  trim($this->input->post('type_of_raw_platting')),
                        'row_material_cost' =>  trim($this->input->post('row_material_cost')),
                        'gst_rate' =>  trim($this->input->post('gst_rate')),
                        'grand_total' =>  trim($this->input->post('grand_total')),
                        'item_remark' =>  trim($this->input->post('item_remark')),
                        'pre_challan_date' =>   trim($this->input->post('pre_challan_date')),
                        'pre_vendor_supplier_name ' =>   trim($this->input->post('pre_vendor_supplier_name')),
                        'pre_vendor_name' =>   trim($this->input->post('pre_vendor_name')),
                        'pre_vendor_po_number' =>    trim($this->input->post('pre_vendor_po_number')),
                        'pre_supplier_name' =>  trim($this->input->post('pre_supplier_name')),
                        'pre_supplier_po_number' =>    trim($this->input->post('pre_supplier_po_number')),
                        'pre_remark' =>    trim($this->input->post('pre_remark')),
                    );
                }

                $savechallanformitemdetails= $this->admin_model->savechallanformitemdetails('',$data);
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


                $this->form_validation->set_rules('total_debit_amount','Total Debit Amount','trim|required');
                $this->form_validation->set_rules('total_debit_amount_ok_qty','Total Debit Amount OK Qty','trim');
               // $this->form_validation->set_rules('p_and_f_charges','P_And F Charges','trim|required');
                $this->form_validation->set_rules('tds_amount','TDS Amount','trim|required');
                $this->form_validation->set_rules('freight_amount_charge','Freight Amount Charge','trim|required');
                $this->form_validation->set_rules('grand_total_main','Grand Total main','trim|required');


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
                        //'p_and_f_charges' =>  trim($this->input->post('p_and_f_charges')),
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
                        'total_amount_of_ok_qty_data' =>trim($this->input->post('total_amount_of_ok_qty_data')),
                       // 'grand_total' =>  trim($this->input->post('grand_total')),
                        'total_amount_of_ok_qty' =>trim($this->input->post('total_ok_qty_amount')),
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
    
                       // 'grand_total' =>  trim($this->input->post('grand_total')),
                        'total_amount_of_ok_qty' =>trim($this->input->post('total_ok_qty_amount')),
                        'total_amount_of_ok_qty_data' =>trim($this->input->post('total_amount_of_ok_qty_data')),
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

            

                $savedebitnoteitemdetails= $this->admin_model->savedebitnoteitemdetails('',$data);
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

                    
                    $data = array(
                        'payment_details_number' =>  trim($this->input->post('payment_details_number')),
                        'payment_details_date' => trim($this->input->post('payment_details_date')),
                      //  'type'=>trim($this->input->post('select_with_po_without_po')),
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

                    if(trim($this->input->post('payment_details_id'))){
                        $saveNewdPaymentDetails= $this->admin_model->saveNewdPaymentDetails(trim($this->input->post('payment_details_id')),$data);
                    }else{
                        $saveNewdPaymentDetails= $this->admin_model->saveNewdPaymentDetails('',$data);
                    }

                    if($saveNewdPaymentDetails){
                        $paymentdetails_response['status'] = 'success';
                        $paymentdetails_response['error'] = array('vendor_supplier_name'=>strip_tags(form_error('vendor_supplier_name')),'payment_details_number'=>strip_tags(form_error('payment_details_number')),'payment_details_date'=>strip_tags(form_error('payment_details_date')),'select_with_po_without_po'=>strip_tags(form_error('select_with_po_without_po')),'vendor_name'=>strip_tags(form_error('vendor_name')),'vendor_po_number'=>strip_tags(form_error('vendor_po_number')),'supplier_name'=>strip_tags(form_error('supplier_name')),'supplier_po_number'=>strip_tags(form_error('supplier_po_number')),'remark'=>strip_tags(form_error('remark')),'po_date'=>strip_tags(form_error('po_date')),'bill_number'=>strip_tags(form_error('bill_number')),'bill_date'=>strip_tags(form_error('bill_date')),'bill_amount'=>strip_tags(form_error('bill_amount')),'cheque_number'=>strip_tags(form_error('cheque_number')),'cheque_date'=>strip_tags(form_error('cheque_date')),'amount_paid'=>strip_tags(form_error('amount_paid')),'tds'=>strip_tags(form_error('tds')),'debit_note_amount'=>strip_tags(form_error('debit_note_amount')),'debit_note_no'=>strip_tags(form_error('debit_note_no')),'payment_status'=>strip_tags(form_error('payment_status')));
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

                    $saveNewdPODDetails= $this->admin_model->saveNewdPODDetails('',$data);

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
            $this->form_validation->set_rules('short_excess_qty','Short Excess Qty','trim|required');

            if($this->form_validation->run() == FALSE)
            {
                $savepoitem_response['status'] = 'failure';
                $savepoitem_response['error'] = array('part_number'=>strip_tags(form_error('part_number')),'description'=>strip_tags(form_error('description')), 'order_qty'=>strip_tags(form_error('order_qty')), 'lot_no'=>strip_tags(form_error('lot_no')),'qty_recived'=>strip_tags(form_error('qty_recived')), 'unit'=>strip_tags(form_error('unit')), 'bill_no'=>strip_tags(form_error('bill_no')),'bill_date'=>strip_tags(form_error('bill_date')),'short_excess_qty'=>strip_tags(form_error('short_excess_qty')), 'item_remark'=>strip_tags(form_error('item_remark')));
           
            }else{

                    $data = array(
                        'part_number' =>  trim($this->input->post('part_number')),
                        'order_qty' =>  trim($this->input->post('order_qty')),
                        'lot_no' =>  trim($this->input->post('lot_no')),
                        'qty_recived' =>  trim($this->input->post('qty_recived')),
                        'unit' =>  trim($this->input->post('unit')),
                        'bill_no' =>  trim($this->input->post('bill_no')),
                        'bill_date' =>  trim($this->input->post('bill_date')),
                        'short_excess_qty' =>  trim($this->input->post('short_excess_qty')),
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

                $savepoitem= $this->admin_model->savepoitem('',$data);
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
        if($vendor_po_id) {
			$vendor_po_number_data = $this->admin_model->get_vendorpodata_with_debit_data($vendor_po_id);

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

                    $saveualitydetails= $this->admin_model->saveualitydetails('',$data);
                    if($saveualitydetails){
                        $qualitydetails_response['status'] = 'success';
                        $qualitydetails_response['error'] = array('QR_details_number'=>strip_tags(form_error('QR_details_number')),'QR_details_date'=>strip_tags(form_error('QR_details_date')),'vendor_name'=>strip_tags(form_error('vendor_name')),'vendor_po_number'=>strip_tags(form_error('vendor_po_number')),'po_date'=>strip_tags(form_error('po_date')),'buyer_name'=>strip_tags(form_error('buyer_name')),'buyer_po_number'=>strip_tags(form_error('buyer_po_number')),'remark'=>strip_tags(form_error('remark')));
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

               $savequlityrecorditem = $this->admin_model->savequlityrecorditem('',$data);

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

                    $saveStockformitemdetails= $this->admin_model->saveStockformitemdetails('',$data);

                    
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
                        'remark' =>  trim($this->input->post('itemremark')),
                        'pre_oms_challan_date' =>  trim($this->input->post('pre_oms_challan_date')),
                        'pre_vendor_name' =>  trim($this->input->post('pre_vendor_name')),
                        'pre_vendor_po_number' =>  trim($this->input->post('pre_vendor_po_number')),
                        'pre_vendor_date'		 =>  trim($this->input->post('pre_vendor_po_date')),
                        'pre_remark' =>  trim($this->input->post('pre_remark')),

                    );
                    $saveomsChallanformdetails= $this->admin_model->saveomsChallanformdetails('',$data);

                }else{
                    $data = array(
                        'part_number'  =>  trim($this->input->post('part_number')),
                        'gross_weight'  =>  trim($this->input->post('gross_weight')),
                        'net_weight'  =>  trim($this->input->post('net_weight')),
                        'qty' =>trim($this->input->post('qty')),
                        'no_of_bags'  =>  trim($this->input->post('no_of_bags')),
                        'hsn_no'  =>  trim($this->input->post('hsn_no')),
                        'remark' =>  trim($this->input->post('itemremark')),
                        'pre_oms_challan_date' =>  trim($this->input->post('pre_oms_challan_date')),
                        'pre_vendor_name' =>  trim($this->input->post('pre_vendor_name')),
                        'pre_vendor_po_number' =>  trim($this->input->post('pre_vendor_po_number')),
                        'pre_vendor_date'		 =>  trim($this->input->post('pre_vendor_po_date')),
                        'pre_remark' =>  trim($this->input->post('pre_remark')),

                    );
                    $saveomsChallanformdetails= $this->admin_model->saveomsChallanformdetails('',$data);
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
                    'buyer_enquiry_no' => trim($this->input->post('buyer_enquiry_no')),
                    'buyer_enquiry_date' => trim($this->input->post('buyer_enquiry_date')),
                    'remark' => trim($this->input->post('remark')),
                    'enquiry_status'  => trim($this->input->post('status')),
                );
                $saveenquirydetailsform= $this->admin_model->saveenquirydetailsform('',$data);
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

            $data['getallenquiryformitemadd']= $this->admin_model->getallenquiryformitemadd();
            
            $this->loadViews("masters/addNewenquiryform", $this->global, $data, NULL);
        }
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
                $data = array(
                    'part_number'  =>  trim($this->input->post('part_number')),
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

                    'pre_enquiry_date'	=>  trim($this->input->post('pre_enquiry_date')),
                    'pre_buyer_enquiry_number' =>  trim($this->input->post('pre_buyer_enquiry_no')),
                    'pre_buyer_enquiry_date' =>  trim($this->input->post('pre_buyer_enquiry_date')),
                    'pre_status' =>  trim($this->input->post('pre_status')),
                    'pre_remark' =>  trim($this->input->post('pre_remark'))
                );

                $saveenquiryformitem = $this->admin_model->saveenquiryformitem('',$data);
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

}