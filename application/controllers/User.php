<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

/**
 * Class : User (UserController)
 * User Class to control all user related operations.
 * @author : Samet Aydın / sametay153@gmail.com
 * @version : 1.0
 * @since : 27.02.2018
 */
class User extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('user_model');
        $this->load->model('admin_model');
        $this->isLoggedIn();
    }
    
    /**
     * This function used to load the first screen of the user
     */
    public function index()
    {
        $this->global['pageTitle'] = 'Admin : Home page';

        $data['tasksCount'] = $this->user_model->tasksCount();
        $data['finishedTasksCount'] = $this->user_model->finishedTasksCount();
        $data['logsCount'] = $this->user_model->logsCount();
        $data['usersCount'] = $this->user_model->usersCount();
        $data['finishgoodList']= $this->admin_model->fetchALLFinishgoodList();
        $data['rawmaterialList']= $this->admin_model->fetchALLRawmaterialList();
        
        // if ($this->getUserStatus() == TRUE)
        // {
        //     $this->session->set_flashdata('error', 'Please change your Priority Password for your security.');
        //     redirect('loadChangePass');
        // }


        if( $this->session->userdata('roleText')=='Team'){

            $process = 'Hourly Inspection Report';
            $processFunction = 'Admin/hourly_inspection_report';
            $this->logrecord($process,$processFunction);
            $this->global['pageTitle'] = 'Hourly Inspection Report';
            $data['vendorList']= $this->admin_model->fetchALLvendorList();
            $data['getAllteammaster']= $this->admin_model->getAllteammaster();

            $this->loadViews("masters/hourly_inspection_report", $this->global, $data , NULL);

        }else{
            $this->loadViews("dashboard", $this->global, $data , NULL);

        }

    }

    /**
     * This function is used to check whether email already exist or not
     */
    function checkEmailExists()
    {
        $userId = $this->input->post("userId");
        $email = $this->input->post("email");

        if(empty($userId)){
            $result = $this->user_model->checkEmailExists($email);
        } else {
            $result = $this->user_model->checkEmailExists($email, $userId);
        }

        if(empty($result)){ echo("true"); }
        else { echo("false"); }
    }

    /**
     * This function is used to load edit user view
     */
    function loadUserEdit()
    {
        $this->global['pageTitle'] = 'Admin : Account Settingsı';
        
        $data['userInfo'] = $this->user_model->getUserInfo($this->vendorId);

        $this->loadViews("userEdit", $this->global, $data, NULL);
    }

    /**
     * This function is used to update the of the user info
     */
    function updateUser()
    {
        $this->load->library('form_validation');
            
        $userId = $this->input->post('userId');
        
        $this->form_validation->set_rules('fname','Full Name','trim|required|max_length[128]');
        $this->form_validation->set_rules('email','Email','trim|required|valid_email|max_length[128]');
        $this->form_validation->set_rules('oldpassword','Old password','max_length[20]');
        // $this->form_validation->set_rules('cpassword','Password','matches[cpassword2]|max_length[20]');
        // $this->form_validation->set_rules('cpassword2','Confirm Password','matches[cpassword]|max_length[20]');
        $this->form_validation->set_rules('cpassword','Password','max_length[20]');
        $this->form_validation->set_rules('cpassword2','Confirm Password','max_length[20]');
        $this->form_validation->set_rules('mobile','Mobile Number','required|min_length[10]');
        
        if($this->form_validation->run() == FALSE)
        {
            $this->loadUserEdit();
        }
        else
        {
            $name = $this->security->xss_clean($this->input->post('fname'));
            $email = $this->security->xss_clean($this->input->post('email'));
            $password = $this->input->post('cpassword');
            $mobile = $this->security->xss_clean($this->input->post('mobile'));
            $oldPassword = $this->input->post('oldpassword');

            $userInfo = array();

            if(empty($password))
            {
            $userInfo = array('email'=>$email,'name'=>$name,
                            'mobile'=>$mobile, 'status'=>1, 'updatedBy'=>$this->vendorId, 'updatedDtm'=>date('Y-m-d H:i:s'));
            }
            else
            {
                // $resultPas = $this->user_model->matchOldPassword($this->vendorId, $oldPassword);
            
                // if(empty($resultPas))
                // {
                // $this->session->set_flashdata('nomatch', 'Your Old Password doğru değil');
                // redirect('userEdit');
                // }
                // else
                // {
                $userInfo = array('email'=>$email, 'password'=>getHashedPassword($password),
                    'name'=>ucwords($name), 'mobile'=>$mobile,'status'=>1, 'updatedBy'=>$this->vendorId, 
                    'updatedDtm'=>date('Y-m-d H:i:s'));
                // }
            }
            
            $result = $this->user_model->editUser($userInfo, $userId);
            
            if($result == true)
            {
                $process = 'Account settingsGüncelleme';
                $processFunction = 'User/updateUser';
                $this->logrecord($process,$processFunction);

                $this->session->set_flashdata('success', 'Your Account Settings have been successfully updated');
            }
            else
            {
                $this->session->set_flashdata('error', 'Failed to update Account Settings');
            }
            
            redirect('userEdit');
        }
    }


    
    /**
     * This function is used to load the change password view
     */
    function loadChangePass()
    {
        $this->global['pageTitle'] = 'Admin : Change Password';
        
        $this->loadViews("changePassword", $this->global, NULL, NULL);
    }
    
    
    /**
     * This function is used to change the password of the user
     */
    function changePassword()
    {
        $this->load->library('form_validation');
        
        $this->form_validation->set_rules('oldPassword','Old password','required|max_length[20]');
        $this->form_validation->set_rules('newPassword','New password','required|max_length[20]');
        $this->form_validation->set_rules('cNewPassword','Confirm new password','required|matches[newPassword]|max_length[20]');
        
        if($this->form_validation->run() == FALSE)
        {
            $this->loadChangePass();
        }
        else
        {
            $oldPassword = $this->input->post('oldPassword');
            $newPassword = $this->input->post('newPassword');
            
            $resultPas = $this->user_model->matchOldPassword($this->vendorId, $oldPassword);
            
            if(empty($resultPas))
            {
                $this->session->set_flashdata('nomatch', 'Your Old Password doğru değil');
                redirect('loadChangePass');
            }
            else
            {
                $usersData = array('password'=>getHashedPassword($newPassword),'status'=>1, 'updatedBy'=>$this->vendorId,
                                'updatedDtm'=>date('Y-m-d H:i:s'));
                
                $result = $this->user_model->changePassword($this->vendorId, $usersData);
                
                if($result > 0) {

                    $process = 'Change Passwordme';
                    $processFunction = 'User/changePassword';
                    $this->logrecord($process,$processFunction);

                     $this->session->set_flashdata('success', 'Change Passwordme başarılı');
                     }
                else {
                     $this->session->set_flashdata('error', 'Change Passwordme başarısız'); 
                    }
                
                redirect('loadChangePass');
            }
        }
    }

    /**
     * This function is used to open 404 view
     */
    function pageNotFound()
    {
        $this->global['pageTitle'] = 'Admin : Page Not Found';
        
        $this->loadViews("404", $this->global, NULL, NULL);
    }

    /**
     * This function is used to finish tasks.
     */
    function endTask($taskId)
    {
            $taskInfo = array('statusId'=>2,'endDtm'=>date('Y-m-d H:i:s'));
            
            $result = $this->user_model->endTask($taskId, $taskInfo);
            
            if ($result > 0) {
                 $process = 'Görev Bitirme';
                 $processFunction = 'User/endTask';
                 $this->logrecord($process,$processFunction);
                 $this->session->set_flashdata('success', 'Görev başarıyla tamamlandı');
                 if ($this->role != ROLE_EMPLOYEE){
                    redirect('tasks');
                 }
                 else{
                    redirect('etasks');
                 }
                }
            else {
                $this->session->set_flashdata('error', 'Görev tamamlama başarısız');
                if ($this->role != ROLE_EMPLOYEE){
                    redirect('tasks');
                 }
                 else{
                    redirect('etasks');
                 }
            }
    }

    /**
     * This function is used to open the tasks page for users (no edit/delete etc)
     */
    function etasks()
    {
            $data['taskRecords'] = $this->user_model->getTasks();

            $process = 'UserAllTasks';
            $processFunction = 'User/etasks';
            $this->logrecord($process,$processFunction);

            $this->global['pageTitle'] = 'Admin : AllTasks';
            
            $this->loadViews("etasks", $this->global, $data, NULL);
    }


}

?>