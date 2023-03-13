<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        //pengecekan sudah login
        // if ($this->session->userdata('role_name') == 'guest') {
        //     redirect('attendance');
        // } elseif ($this->session->userdata('role_name') == 'admin') {
        //     redirect('admin');
        // }
    }

    public function index()
    {
        //if user already login, cannot access auth login
        if ($this->session->userdata('role_name') == 'guest') {
            redirect('attendance');
        } elseif ($this->session->userdata('role_name') == 'admin') {
            redirect('admin');
        }
        $data['title'] = 'Login';
        $this->load->view('auth/login', $data);
    }


    public function login_process()
    {

        $username = htmlspecialchars(strtolower($this->input->post('username', true)));
        $password = htmlspecialchars($this->input->post('password', true));

        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->index();
        } else {
            //check username di db
            $checkUsername = "SELECT a.username, a.password, a.role_name, a.full_name,  b.dept_name FROM users a, departments b WHERE a.username ='$username' AND a.dept_id = b.dept_id AND a.is_active ='Y'";
            $result1 = $this->db->query($checkUsername)->row_array();

            if ($result1) {
                if (password_verify($password, $result1['password'])) {

                    $data = [
                        'username' => $result1['username'],
                        'role_name' => $result1['role_name'],
                        'dept_name' => $result1['dept_name'],
                        'full_name' => $result1['full_name'],
                        'is_loged_in' => TRUE
                    ];

                    $this->session->set_userdata($data);

                    if ($this->session->userdata('role_name') == 'guest') {

                        redirect('attendance');
                    } else {

                        redirect('admin');
                    }
                } else { //password salah
                    $this->session->set_flashdata(
                        'message',
                        '<div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        Wrong Password!!
                        </div>'
                    );
                    $this->index();
                }
            } else { //username not found in db
                $this->session->set_flashdata(
                    'message',
                    '<div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        Username Not Found! or Disable
                        </div>'
                );
                $this->index();
            }
        }
    }





    // public function register()
    // {
    //     check_login_permission();
    //     $data['title'] = 'Login';
    //     $this->load->view('auth/register', $data);
    // }
    // public function register_process()
    // {

    //     //get data from user filled in form
    //     $username = htmlspecialchars($this->input->post('username', true));
    //     $role_name = htmlspecialchars($this->input->post('role_name', true));
    //     $empno = htmlspecialchars($this->input->post('empno', true));
    //     $fullname = htmlspecialchars($this->input->post('fullname', true));
    //     $dept_id = htmlspecialchars($this->input->post('dept_id', true));

    //     //validation
    //     $this->form_validation->set_rules('username', 'Username', 'trim|required|is_unique[users.username]');
    //     $this->form_validation->set_rules('role_name', 'Role Name', 'trim|required');
    //     $this->form_validation->set_rules('empno', 'EmpNo', 'trim|required|is_unique[users.empno]');
    //     $this->form_validation->set_rules('fullname', 'FullName', 'trim|required');
    //     $this->form_validation->set_rules('dept_id', 'DepartmentID', 'trim|required');

    //     if ($this->form_validation->run() == FALSE) {
    //         $this->register();
    //     } else {
    //         $data = [
    //             'username' => $username,
    //             'role_name' => $role_name,
    //             'password' => password_hash('sht123', PASSWORD_DEFAULT),
    //             'empno' => $empno,
    //             'full_name' => $fullname,
    //             'is_active' => 'Y',
    //             'dept_id' => $dept_id

    //         ];
    //         $this->session->set_flashdata(
    //             'message',
    //             '<div class="alert alert-success alert-dismissible">
    //                     <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    //                     Registered success, please login!
    //                     </div>'
    //         );
    //         $this->db->insert('users', $data);
    //         redirect('auth');
    //     }
    // }


    public function logout()
    {
        $this->session->unset_userdata('username');
        $this->session->unset_userdata('role_name');
        $this->session->unset_userdata('dept_name');
        $this->session->unset_userdata('is_loged_in');
        // $this->session->sess_destroy();

        $this->session->set_flashdata(
            'message',
            '<div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                       Logout successfully!!
                        </div>'
        );
        redirect('auth');
    }

    public function blocked()
    {
        $this->load->view('auth/blocked');
    }
}
