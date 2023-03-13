<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Attendance extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        check_login_permission();
        check_access_menu();

        // if ($this->session->userdata('role_name') == 'guest') {
        //     redirect('attendance');
        // }


    }

    public function index()
    {
        $data['title'] = 'Home';
        $this->load->view('templates/topbar', $data);
        // $this->load->view('templates/content');
        $this->load->view('home/index');
        $this->load->view('templates/footer');
    }

    public function pull()
    {

        //get all machine status is active
        $getAllMachineSQL = "SELECT * FROM machine_finger WHERE is_active ='Y' ORDER BY ip_address ASC";
        $result1 = $this->db->query($getAllMachineSQL)->result_array();

        //get info latest data download each machine
        $getLatestDatePull = "SELECT MAX(a.date_att) AS max_date, a.ip_machine, b.machine_loc FROM download_att a, machine_finger b WHERE a.ip_machine = b.ip_address AND b.is_active ='Y' GROUP BY a.ip_machine, b.machine_loc ORDER BY a.ip_machine";
        $result2 = $this->db->query($getLatestDatePull)->result_array();


        $data['machine'] = $result1;
        $data['latest'] = $result2;
        $data['title'] = "Pull";
        $this->load->view('templates/topbar', $data);
        // $this->load->view('templates/content');
        $this->load->view('attendance/pull', $data);
        $this->load->view('templates/footer');
    }

    public function pull_process()
    {
        set_time_limit(3600); //seconds
        $ip_address = $this->input->post('ip_address');
        $created_at = date('Y-m-d');

        // var_dump($ip_address);
        // die;
        if ($ip_address == 'ALL') {  //jika narik data machine semua


            // query semua data machine di DB yg is_active Y
            $sql = "SELECT ip_address, machine_loc FROM machine_finger WHERE is_active ='Y'";
            $result = $this->db->query($sql);
            $IP = $result->result_array();

            // default key is 0
            $Key = '0';
            $number=1;
            foreach ($IP as $IA) {
                
                $IIP = $IA['ip_address'];
                $MACHINE_LOC = $IA['machine_loc'];

                // ping ip machine
                exec("ping -n 1 $IIP", $output, $resultPing);

                // if ($resultPing == 0) {
                //     echo "<br>";
                //     echo "<a style='color:green; font-size:15pt; text:bold;'>" . $number++ . ". " ."Ping successful! " . $IIP . " " . $MACHINE_LOC . "</a>";
                //     echo "<br>";
                    
                // } else {

                //     echo "<br>";
                //     echo "<a style='color:red; font-size:15pt; text:bold;'>Ping failure, errorrr!" . $IIP . " " . $MACHINE_LOC . "</a>";
                //     echo "<br>";                    

                // }

                // jika ip tidak kosong dan ping ok
                if (($IIP != "") && ($resultPing == 0)) {
                // if ($IIP != "") {

                    $Connect = fsockopen($IIP, "80", $errno, $errstr, 1);
                    if ($Connect) {
                        $soap_request = "<GetAttLog><ArgComKey xsi:type=\"xsd:integer\">" . $Key . "</ArgComKey><Arg><PIN xsi:type=\"xsd:integer\">All</PIN></Arg></GetAttLog>";
                        $newLine = "\r\n";

                        // var_dump($soap_request);
                        // die;
                        fputs($Connect, "POST /iWsService HTTP/1.0" . $newLine);
                        fputs($Connect, "Content-Type: text/xml" . $newLine);
                        fputs($Connect, "Content-Length: " . strlen($soap_request) . $newLine . $newLine);
                        fputs($Connect, $soap_request . $newLine);
                        $buffer = "";
                        while ($Response = fgets($Connect, 1024)) {
                            $buffer = $buffer . $Response;
                        }
                    } else {
                        echo "Koneksi ke mesin Gagal";
                        // $messageConMachine = "Koneksi mesin gagal!";
                        // $this->session->set_flashdata('messageConMachine', $messageConMachine);
                    }

                    // include_once("parse.php"); diganti dengan $this->Parse_Data() funciton private
                    $buffer = $this->Parse_Data($buffer, "<GetAttLogResponse>", "</GetAttLogResponse>");
                    $buffer = explode("\r\n", $buffer);
                    for ($a = 0; $a < count($buffer); $a++) {
                        $data = $this->Parse_Data($buffer[$a], "<Row>", "</Row>");
                        $PIN = $this->Parse_Data($data, "<PIN>", "</PIN>");
                        $DateTime = $this->Parse_Data($data, "<DateTime>", "</DateTime>");
                        $Verified = $this->Parse_Data($data, "<Verified>", "</Verified>");
                        $Status = $this->Parse_Data($data, "<Status>", "</Status>");

                        // echo $PIN . '#' . $DateTime . '#' . $Status . '#' . $IIP;
                        // var_dump($PIN);
                        // die;
                        // echo "<br>";
                        // pengecekan di db, jika data sudah ada maka skip

                        $checkNIK = "SELECT * FROM download_att WHERE empno = '$PIN' and date_att = '$DateTime' and ip_machine = '$IIP'";
                        // $checkNIK = "SELECT * FROM download_att WHERE empno = '310123' AND date_att = '2023-02-14 11:46:42' AND ip_machine = '10.5.4.115'";

                        $result = $this->db->query($checkNIK)->num_rows();
                        // print_r($result);
                        

                        if ($result > 0) {
                            // for debuging
                            // echo $PIN . "#" . $DateTime . "data sudah ada";
                            // echo "<br>";

                            // $this->session->set_flashdata('message_no_save_db', $PIN . $DateTime . $IIP . 'data tidak disimpan di DB!');
                            // $messageNotInsertDB = "data tidak disimpan di DB!" . $IIP;
                            // $this->session->set_flashdata('messageNotInsertDB', $messageNotInsertDB);
                            continue;
                        } else {
                            $dataa = [
                                'empno' => $PIN,
                                'date_att' => $DateTime,
                                'is_closed' => 'N',
                                'ip_machine' => $IIP,
                                'created_at' => $created_at,
                                'created_by' => $this->session->userdata('username')
                            ];
                            $this->db->insert('download_att', $dataa);

                            // echo $PIN . $DateTime . "data baru berhasil insert";
                            // echo "<br>";

                            // $this->session->set_flashdata('message_save_db', $PIN . $DateTime . $IIP . 'insert ke DB berhasil!');
                            // $messageInsertDB = "insert ke DB berhasil" . $IIP;
                            // $this->session->set_flashdata('messageInsertDB', $messageInsertDB);
                        }
                    //    prgoress bar
                    }
                    if ($resultPing == 0) {
                        echo "<br>";
                        echo "<a style='color:green; font-size:15pt; text:bold;'>" . $number++ . ". " ."Ping successful! " . $IIP . " " . $MACHINE_LOC . "</a>";
                        echo "<br>";
                        
                    } else {
    
                        echo "<br>";
                        echo "<a style='color:red; font-size:15pt; text:bold;'>Ping failure, errorrr!" . $IIP . " " . $MACHINE_LOC . "</a>";
                        echo "<br>";                    
    
                    }
                }
            }
        } else {    //jika narik data machine satu satu
            $IIP = $ip_address;
            $Key = '0';
            exec("ping -n 1 $IIP", $output, $resultPing);

            if ($resultPing == 0) {
                // echo "Ping successful!" . $IIP;
                echo "<a style='color:green; font-size:15pt; text:bold;'>Ping successful!" . $IIP ."</a>";
              
            } else {

                // echo "Ping unsuccessful!" . $IIP;
                echo "<a style='color:red; font-size:15pt; text:bold;'>Ping failure error!" . $IIP . "</a>";
            } 
            // jika ip tidak kosong dan ping ok
            if (($IIP != "") && ($resultPing == 0)) {

                $Connect = fsockopen($IIP, "80", $errno, $errstr, 1);
                if ($Connect) {
                    $soap_request = "<GetAttLog><ArgComKey xsi:type=\"xsd:integer\">" . $Key . "</ArgComKey><Arg><PIN xsi:type=\"xsd:integer\">All</PIN></Arg></GetAttLog>";
                    $newLine = "\r\n";

                    // var_dump($soap_request);
                    // die;
                    fputs($Connect, "POST /iWsService HTTP/1.0" . $newLine);
                    fputs($Connect, "Content-Type: text/xml" . $newLine);
                    fputs($Connect, "Content-Length: " . strlen($soap_request) . $newLine . $newLine);
                    fputs($Connect, $soap_request . $newLine);
                    $buffer = "";
                    while ($Response = fgets($Connect, 1024)) {
                        $buffer = $buffer . $Response;
                    }
                } else {
                    echo "Koneksi Gagal";
                }

                // include_once("parse.php");  this from  $this->Parse_Data()
                $buffer = $this->Parse_Data($buffer, "<GetAttLogResponse>", "</GetAttLogResponse>");
                $buffer = explode("\r\n", $buffer);
                for ($a = 0; $a < count($buffer); $a++) {
                    $data = $this->Parse_Data($buffer[$a], "<Row>", "</Row>");
                    $PIN = $this->Parse_Data($data, "<PIN>", "</PIN>");
                    $DateTime = $this->Parse_Data($data, "<DateTime>", "</DateTime>");
                    $Verified = $this->Parse_Data($data, "<Verified>", "</Verified>");
                    $Status = $this->Parse_Data($data, "<Status>", "</Status>");


                    // debug to looking the data
                    // echo $PIN . '#' . $DateTime . '#' . $Status . '#' . $IIP;

                    echo "<br>";
                    // pengecekan di db, jika data sudah ada maka skip

                    $checkNIK = "SELECT *  FROM download_att WHERE empno = '$PIN' and date_att = '$DateTime' and ip_machine = '$IIP'";
                    // $checkNIK = "SELECT * FROM download_att WHERE empno = '310123' AND date_att = '2023-02-14 11:46:42' AND ip_machine = '10.5.4.115'";

                    $result = $this->db->query($checkNIK)->num_rows();
                    // print_r($result);

                    if ($result > 0) {

                        // echo "data sudah ada" . $PIN . '#' . $DateTime . $IIP;
                      continue; //if have data, continue with the loop
                    } else {
                        $dataa = [
                            'empno' => $PIN,
                            'date_att' => $DateTime,
                            'is_closed' => 'N',
                            'ip_machine' => $IIP,
                            'created_at' => $created_at,
                            'created_by' => $this->session->userdata('username')
                        ];
                        $this->db->insert('download_att', $dataa);

                        // echo "berhasil di insert";
                    }
                    
                }          
            }

           
        }
    }

    private function Parse_Data($data, $p1, $p2)
    {
        $data = " " . $data;
        $hasil = "";
        $awal = strpos($data, $p1);

        if ($awal != "") {
            $akhir = strpos(strstr($data, $p1), $p2);
            if ($akhir != "") {
                $hasil = substr($data, $awal + strlen($p1), $akhir - strlen($p1));
            }
        }
        return $hasil;
    }




    public function download()
    {
        $data['title'] = "Download";
        $this->load->view('templates/topbar', $data);
        // $this->load->view('templates/content');
        $this->load->view('attendance/download');
        $this->load->view('templates/footer');
    }

    public function download_process()
    {

        //get data from input user date time
        $date_att1 = $this->input->post('date_att1');
        $date_att2 = $this->input->post('date_att2');
        // print_r(date_format($date_att, 'Y-m-d H:i:s'));

        //convert to date time format yyyy-mm-dd hh:ii:ss
        $date1 = date_create($date_att1);
        $date2 = date_create($date_att2);
        $date1ForTxt = date_format($date1, "Y-m-d H:i:s");
        $date2ForTxt = date_format($date2, "Y-m-d H:i:s");

        $date1ForShow = date_format($date1, "Y-m-d");
        $date2ForShow = date_format($date2, "Y-m-d");

        // debug
        // echo "date 1 for txt " . $date1ForTxt;
        // echo "<br>";
        // echo "date 2 for txt " . $date2ForTxt;
        // echo "<br>";
        // echo "<br>";

        // echo "date 1 for show  " . $date1ForShow;
        // echo "<br>";
        // echo "date 2 for show  " . $date2ForShow;
        // echo "<br>";
        // echo "<br>";


        //get all data from download_att between date time input
        $getAllFingerForTXT = "SELECT empno, DATE_FORMAT(date_att, '%m/%d/%Y %H:%i')  FROM download_att WHERE date_att >= '$date1ForTxt' and date_att <= '$date2ForTxt' AND is_closed != 'Y' GROUP BY empno, date_att ORDER BY empno ASC";
        $result1 = $this->db->query($getAllFingerForTXT)->result_array();
        // print_r($result1);

        // $getAllFingerForShowing = "SELECT ip_machine, count(empno) as total, DATE(date_att) FROM download_att WHERE DATE(date_att) >= '$date1ForShow' and DATE(date_att) <= '$date2ForShow' GROUP BY ip_machine";
        // print_r($getAllFingerForShowing);


        $path = "file.txt";   //directory to store the file
        $content = "";

        foreach ($result1 as $row) {

            $content .= implode(   //seperate with space " " to make format data txt, follow HP to upload in HP system attendance
                " ",
                $row
            ) . "\n";
        }

        $this->load->helper('file'); //helper store sql db to path file.txt
        write_file($path, $content);
        $this->load->helper('download'); //helper to download data file.txt
        force_download($path, NULL);



        // $data['download_process'] = $result1;
        // $data['title'] = "Download";
        // $this->load->view('templates/topbar', $data);
        // // $this->load->view('templates/content');
        // $this->load->view('attendance/download_process');
        // $this->load->view('templates/footer');
    }

    // public function clear()
    // {
    //     $data['title'] = "Clear";
    //     $this->load->view('templates/topbar', $data);
    //     // $this->load->view('templates/content');
    //     $this->load->view('attendance/clear');
    //     $this->load->view('templates/footer');
    // }

    // public function clear_process()
    // {
    // }


    public function change_password()
    {

        $username = $this->session->userdata('username');
        $getUsers = "SELECT username FROM users WHERE username = '$username'";
        $result = $this->db->query($getUsers)->row_array();


        $data['username'] = $result;
        $data['title'] = "Change Password";
        $this->load->view('templates/topbar', $data);
        // $this->load->view('templates/content');
        $this->load->view('attendance/change_password');
        $this->load->view('templates/footer');
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

            $passwordOld = password_verify($passOldInput, $resultCheckOldPassword['password']);

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

            redirect('attendance/change_password');
        } //end if form validation
    }
}
