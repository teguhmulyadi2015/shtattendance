<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        check_login_permission();
        check_access_menu();
        // if ($this->session->userdata('role_name') == 'guest') {
        //     redirect('attendance');
        // } elseif ($this->session->userdata('role_name') == 'admin') {
        //     redirect('admin');
        // }

    }
    public function index()
    {
        $sqlGetAllMachines = "SELECT COUNT(*) as count FROM machine_finger";
        $resultMachine = $this->db->query($sqlGetAllMachines)->row_array();

        $sqlGetAllUsers = "SELECT COUNT(*) as count FROM users WHERE is_active ='Y'";
        $resultUser = $this->db->query($sqlGetAllUsers)->row_array();

        $sqlGetAllDept = "SELECT COUNT(*) as count FROM departments";
        $resultDept = $this->db->query($sqlGetAllDept)->row_array();

        $data['title'] = 'Dashboard';

        $data['countmachine'] = $resultMachine;
        $data['countuser'] = $resultUser;
        $data['countdept'] = $resultDept;
        $this->load->view('templates/admin/header');
        $this->load->view('templates/admin/sidebar', $data);
        $this->load->view('admin/index');
        $this->load->view('templates/admin/footer');
    }

    public function master_machine()
    {
        // get all machine attendance
        $sqlGetAllMachines = "SELECT * FROM machine_finger ORDER BY ip_address ASC";
        $result = $this->db->query($sqlGetAllMachines)->result_array();
        $data['machines'] =  $result;
        $data['title'] = 'Machine Attendance';


        $this->load->view('templates/admin/header');
        $this->load->view('templates/admin/sidebar', $data);
        $this->load->view('admin/master_machine', $data);
        $this->load->view('templates/admin/footer');
    }

    public function add_master_machine()
    {

        $data['title'] = 'Machine Attendance';
        $this->load->view('templates/admin/header');
        $this->load->view('templates/admin/sidebar', $data);
        $this->load->view('admin/add_master_machine', $data);
        $this->load->view('templates/admin/footer');
    }

    public function add_master_machine_process()
    {
        $ip_address = htmlspecialchars($this->input->post('ip_address', true));
        $machine_loc = htmlspecialchars($this->input->post('machine_loc', true));
        $is_active = htmlspecialchars($this->input->post('is_active', true));
        $date = date('Y-m-d');
        $created_by = $this->session->userdata('username');


        $this->form_validation->set_rules('ip_address', 'IP Address', 'trim|required|is_unique[machine_finger.ip_address]');
        $this->form_validation->set_rules('machine_loc', 'MachineLocation', 'trim|required');
        $this->form_validation->set_rules('is_active', 'Is Active', 'trim|required');

        if ($this->form_validation->run() == FALSE) {
            $this->add_master_machine();
        } else {
            $data = [
                'ip_address' => $ip_address,
                'machine_loc' => $machine_loc,
                'is_active' => $is_active,
                'updated_at' => $date,
                'created_by' => $created_by
            ];
            $this->db->insert('machine_finger', $data);
            $this->session->set_flashdata(
                'message',
                '<div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        Insert succesfully!!
                        </div>'
            );
            redirect('admin/master_machine');
        }
    }

    public function edit_master_machine($id)
    {
        // get all machine attendance
        $sqlGetMachine = "SELECT * FROM machine_finger WHERE id='$id'";
        $result = $this->db->query($sqlGetMachine)->row_array();
        $data['machine'] =  $result;
        $data['title'] = 'Machine Attendance';


        $this->load->view('templates/admin/header');
        $this->load->view('templates/admin/sidebar', $data);
        $this->load->view('admin/edit_master_machine', $data);
        $this->load->view('templates/admin/footer');
    }

    public function edit_master_machine_process()
    {
        $id = htmlspecialchars($this->input->post('id', true));
        $ip_address = htmlspecialchars($this->input->post('ip_address', true));
        $machine_loc = htmlspecialchars($this->input->post('machine_loc', true));
        $is_active = htmlspecialchars($this->input->post('is_active', true));
        $date = date('Y-m-d');
        $created_by = $this->session->userdata('username');


        $this->form_validation->set_rules('machine_loc', 'Machine Location', 'trim|required');

        if ($this->form_validation->run() == FALSE) {
            $this->edit_master_machine($id);
        } else {
            $sqlUpdateMachine = "UPDATE machine_finger SET machine_loc = '$machine_loc', is_active='$is_active', updated_at='$date', created_by='$created_by' WHERE id='$id' AND ip_address='$ip_address'";
            $result = $this->db->query($sqlUpdateMachine);

            if ($result == TRUE) {
                $this->session->set_flashdata(
                    'message',
                    '<div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        Update successfully!!
                        </div>'
                );
            } else {
                $this->session->set_flashdata(
                    'message',
                    '<div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        Update error. 
                        </div>'
                );
            }
            redirect('admin/master_machine');
        }
    }

    public function master_users()
    {
        $usernameSession = $this->session->userdata('username');
        // get all users
        $getAllUsers = "SELECT a.*, d.dept_name FROM users a, departments d WHERE a.dept_id=d.dept_id AND a.username != '$usernameSession'";
        $result = $this->db->query($getAllUsers)->result_array();
        $data['users'] =  $result;
        $data['title'] = 'Users';

        $this->load->view('templates/admin/header');
        $this->load->view('templates/admin/sidebar', $data);
        $this->load->view('admin/master_users', $data);
        $this->load->view('templates/admin/footer');
    }

    public function add_master_users()
    {
        $getAllDepartments = "SELECT * FROM departments";
        $result = $this->db->query($getAllDepartments)->result_array();
        $data['dept'] = $result;
        $data['title'] = 'Users';
        $this->load->view('templates/admin/header');
        $this->load->view('templates/admin/sidebar', $data);
        $this->load->view('admin/add_master_users', $data);
        $this->load->view('templates/admin/footer');
    }

    public function add_master_users_process()
    {
        //get data from user filled in form
        $username = htmlspecialchars(strtolower($this->input->post('username', true)));
        $role_name = htmlspecialchars($this->input->post('role_name', true));
        $empno = htmlspecialchars($this->input->post('empno', true));
        $fullname = htmlspecialchars($this->input->post('fullname', true));
        $dept_id = htmlspecialchars($this->input->post('dept_id', true));

        //validation
        $this->form_validation->set_rules('username', 'Username', 'trim|required|is_unique[users.username]');
        $this->form_validation->set_rules('role_name', 'Role Name', 'trim|required');
        $this->form_validation->set_rules('empno', 'EmpNo', 'trim|required|is_unique[users.empno]');
        $this->form_validation->set_rules('fullname', 'FullName', 'trim|required');
        $this->form_validation->set_rules('dept_id', 'DepartmentID', 'trim|required');

        if ($this->form_validation->run() == FALSE) {
            $this->add_master_users();
        } else {
            $data = [
                'username' => $username,
                'role_name' => $role_name,
                'password' => password_hash('sht123', PASSWORD_DEFAULT),
                'empno' => $empno,
                'full_name' => $fullname,
                'is_active' => 'Y',
                'dept_id' => $dept_id

            ];
            $this->session->set_flashdata(
                'message',
                '<div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        Registered new user success, please try to login!
                        </div>'
            );
            $this->db->insert('users', $data);
            redirect('admin/master_users');
        }
    }


    public function edit_master_users($id)
    {
        $getUser = "SELECT a.*, d.dept_name FROM users a, departments d WHERE a.dept_id=d.dept_id AND a.id = '$id'";
        $result1 = $this->db->query($getUser)->row_array();

        $getAllDepartments = "SELECT * FROM departments";
        $result2 = $this->db->query($getAllDepartments)->result_array();

        $data['user'] = $result1;
        $data['dept'] = $result2;
        $data['title'] = 'Users';
        $this->load->view('templates/admin/header');
        $this->load->view('templates/admin/sidebar', $data);
        $this->load->view('admin/edit_master_users', $data);
        $this->load->view('templates/admin/footer');
    }

    public function edit_master_users_process()
    {
        $id = htmlspecialchars($this->input->post('id', true));
        $username = htmlspecialchars($this->input->post('username', true));
        $role_name = htmlspecialchars($this->input->post('role_name', true));
        $empno = htmlspecialchars($this->input->post('empno', true));
        $is_active = htmlspecialchars($this->input->post('is_active', true));
        $dept_id = htmlspecialchars($this->input->post('dept_id', true));
        $fullname = htmlspecialchars($this->input->post('fullname', true));
        $date = date('Y-m-d');
        $created_by = $this->session->userdata('username');


        $this->form_validation->set_rules('role_name', 'Role Name', 'trim|required');
        $this->form_validation->set_rules('empno', 'Empno', 'trim|required');
        $this->form_validation->set_rules('is_active', 'Is Active', 'trim|required');

        if ($this->form_validation->run() == FALSE) {
            $this->edit_master_users($id);
        } else {
            $sqlUpdateUser = "UPDATE users SET role_name = '$role_name', empno='$empno', is_active='$is_active', created_at='$date', created_by='$created_by', dept_id='$dept_id', full_name='$fullname' WHERE id='$id' AND username='$username'";
            $result = $this->db->query($sqlUpdateUser);


            if ($result == TRUE) {
                $this->session->set_flashdata(
                    'message',
                    '<div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        Update successfully!!
                        </div>'
                );
            } else {
                $this->session->set_flashdata(
                    'message',
                    '<div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        Update error. 
                        </div>'
                );
            }
            redirect('admin/master_users');
        }
    }

    public function reset_password($id)
    {
        $passwordHash = password_hash('sht123', PASSWORD_DEFAULT);
        $date = date('Y-m-d');
        $created_by = $this->session->userdata('username');



        $sqlReset = "UPDATE users SET password='$passwordHash', created_at='$date', created_by='$created_by' WHERE id='$id'";
        $result2 = $this->db->query($sqlReset);

        // $checkWhoReset = "SELECT COUNT(*) as count FROM users WHERE id='$id' AND username='$created_by'";
        // $result1 = $this->db->query($checkWhoReset)->row_array();

        if ($result2 == TRUE) {
            $this->session->set_flashdata(
                'message',
                '<div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                       Password reset success
                        </div>'
            );
            redirect('admin/master_users');
        } else {
            $this->session->set_flashdata(
                'message',
                '<div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        Password reset fatal error!!!
                        </div>'
            );
            redirect('admin/master_users');
        }


        // if ($result1 > 0) {
        //     $this->session->unset_userdata('username');
        //     $this->session->unset_userdata('role_name');
        //     $this->session->unset_userdata('dept_name');
        //     $this->session->unset_userdata('is_loged_in');
        //     // $this->session->sess_destroy();

        //     $this->session->set_flashdata(
        //         'message',
        //         '<div class="alert alert-success alert-dismissible">
        //                 <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        //                Logout successfully!!
        //                 </div>'
        //     );
        //     redirect('auth');
        // }
    }

    public function change_password()
    {

        $username = $this->session->userdata('username');
        $getUsers = "SELECT username FROM users WHERE username = '$username'";
        $result = $this->db->query($getUsers)->row_array();


        $data['username'] = $result;
        $data['title'] = "Change Password";
        $this->load->view('templates/admin/header');
        $this->load->view('templates/admin/sidebar', $data);
        $this->load->view('admin/change_password', $data);
        $this->load->view('templates/admin/footer');
    }

    public function change_password_process()
    {
        $username = $this->session->userdata('username');
        $passOldInput = htmlspecialchars($this->input->post('old_password', true));
        $passNewInput1 = htmlspecialchars($this->input->post('new_password1', true));
        $passNewInput2 = htmlspecialchars($this->input->post('new_password2', true));


        $this->form_validation->set_rules('old_password', 'Old Password', 'trim|required');
        $this->form_validation->set_rules('new_password1', 'New Password', 'trim|required|min_length[5]');
        $this->form_validation->set_rules('new_password2', 'Retype Password', 'trim|required|min_length[5]|matches[new_password1]');

        if ($this->form_validation->run() == FALSE) {
            $this->change_password();
        } else {

            // check old password, make sure same as in database
            $checkOldPassword = "SELECT password FROM users WHERE username = '$username'";
            $resultCheckOldPassword = $this->db->query($checkOldPassword)->row_array();

            $passwordOld = password_verify($passOldInput, $resultCheckOldPassword['password']); //apaakah input password old sama dengan yg ada di db

            $newPasswordHash = password_hash($passNewInput1, PASSWORD_DEFAULT);
            // print_r($newPasswordHash);
            // // die;

            //if old password not same, then show error. old password must be same
            if (!$passwordOld) {
                $this->session->set_flashdata(
                    'message',
                    '<div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        Wrong Old Password! please try again!
                        </div>'
                );
            } else { //if success, will update new password and session will destroy and logout
                $updateNewPassword = "UPDATE users SET password='$newPasswordHash' WHERE username = '$username'";
                $resultUpdateNewPassword = $this->db->query($updateNewPassword);

                if ($resultUpdateNewPassword == TRUE) {
                    $this->session->unset_userdata('username');
                    $this->session->unset_userdata('role_name');
                    $this->session->unset_userdata('dept_name');
                    $this->session->unset_userdata('is_loged_in');
                    // $this->session->sess_destroy();

                    $this->session->set_flashdata(
                        'message',
                        '<div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                       Change password successfully!! please try to login!
                        </div>'
                    );
                    redirect('auth');
                }
            }

            redirect('admin/change_password');
        } //end if form validation
    }


    public function master_department()
    {
        $getAllDepartments = "SELECT * FROM departments";
        $result = $this->db->query($getAllDepartments)->result_array();

        $data['department'] = $result;
        $data['title'] = 'Departments Code';
        $this->load->view('templates/admin/header');
        $this->load->view('templates/admin/sidebar', $data);
        $this->load->view('admin/master_departments', $data);
        $this->load->view('templates/admin/footer');
    }

    public function add_master_department()
    {
        $data['title'] = 'Departments Code';
        $this->load->view('templates/admin/header');
        $this->load->view('templates/admin/sidebar', $data);
        $this->load->view('admin/add_master_department', $data);
        $this->load->view('templates/admin/footer');
    }

    public function add_master_department_process()

    {
        $dept_code = htmlspecialchars($this->input->post('dept_code', true));
        $dept_name = htmlspecialchars($this->input->post('dept_name', true));

        $this->form_validation->set_rules('dept_code', 'Dept Code', 'trim|required|is_unique[departments.dept_id]');
        $this->form_validation->set_rules('dept_name', 'Dept Name', 'trim|required');

        if ($this->form_validation->run() == FALSE) {
            $this->add_master_department();
        } else {
            $data = [
                'dept_id' => $dept_code,
                'dept_name' => $dept_name,
                'created_at' => date('Y-m-d'),
                'created_by' => $this->session->userdata('username')
            ];
            $result = $this->db->insert('departments', $data);
            if ($result == TRUE) {
                $this->session->set_flashdata(
                    'message',
                    '<div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                      New Department already add successfully!
                        </div>'
                );
            } else {
                $this->session->set_flashdata(
                    'message',
                    '<div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                      error departments sql found!!
                        </div>'
                );
            }
            redirect('admin/master_department');
        }
    }
    public function edit_master_department($id)
    {
        $getDept = "SELECT * FROM departments WHERE id='$id'";
        $result = $this->db->query($getDept)->row_array();

        $data['dept'] = $result;
        $data['title'] = 'Departments Code';
        $this->load->view('templates/admin/header');
        $this->load->view('templates/admin/sidebar', $data);
        $this->load->view('admin/edit_master_department', $data);
        $this->load->view('templates/admin/footer');
    }

    public function edit_master_department_process()
    {
        $id = htmlspecialchars($this->input->post('id', true));
        $dept_name = htmlspecialchars($this->input->post('dept_name', true));
        $dept_code = htmlspecialchars($this->input->post('dept_code', true));
        $date = date('Y-m-d');
        $created_by = $this->session->userdata('username');


        $this->form_validation->set_rules('dept_name', 'Department Name', 'trim|required');

        if ($this->form_validation->run() == FALSE) {
            $this->edit_master_department($id);
        } else {
            $sqlUpdateUser = "UPDATE departments SET dept_name='$dept_name', created_at='$date', created_by='$created_by' WHERE id='$id' AND dept_id='$dept_code'";
            $result = $this->db->query($sqlUpdateUser);


            if ($result == TRUE) {
                $this->session->set_flashdata(
                    'message',
                    '<div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        Update successfully!!
                        </div>'
                );
            } else {
                $this->session->set_flashdata(
                    'message',
                    '<div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        Update error. 
                        </div>'
                );
            }
            redirect('admin/master_department');
        }
    }

    public function delete_department($id)
    {
        $result = $this->db->delete('departments', ['id' => $id]);
        if ($result == TRUE) {
            $this->session->set_flashdata(
                'message',
                '<div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        deleted successfully!
                        </div>'
            );
        } else {
            $this->session->set_flashdata(
                'message',
                '<div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        delete errorr!!!. 
                        </div>'
            );
        }
        redirect('admin/master_department');
    }
    public function delete_machine($id)
    {
        $result = $this->db->delete('machine_finger', ['id' => $id]);
        if ($result == TRUE) {
            $this->session->set_flashdata(
                'message',
                '<div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        deleted successfully!
                        </div>'
            );
        } else {
            $this->session->set_flashdata(
                'message',
                '<div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        delete errorr!!!. 
                        </div>'
            );
        }
        redirect('admin/master_machine');
    }

    public function ping_machine($ip_address)
    {

        // Execute the ping command
        exec("ping -n 1 $ip_address", $output, $result);

        // Check the result of the command
        if ($result === 0) {
            $this->session->set_flashdata(
                'message',
                '<div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        Ping ' . $ip_address . ' Successfully!!
                        </div>'
            );
        } else {
            $this->session->set_flashdata(
                'message',
                '<div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        Ping ' . $ip_address . ' Failure!!
                        </div>'
            );
        }
        redirect('admin/master_machine');
    }
}
