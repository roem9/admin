<?php
    class Peserta extends CI_CONTROLLER{
        public function __construct(){
            parent::__construct();
            $this->load->model('Peserta_model');
            $this->load->model('Wl_model');
            $this->load->model('Main_model');
            ini_set('xdebug.var_display_max_depth', '10');
            ini_set('xdebug.var_display_max_children', '256');
            ini_set('xdebug.var_display_max_data', '1024');
            if($this->session->userdata('status') != "login"){
                $this->session->set_flashdata('login', 'Maaf, Anda harus login terlebih dahulu');
                redirect(base_url("login"));
            }
        }

        public function index(){
            $data['title'] = 'List Peserta';
            $data['program'] = ["Hifdzi 1"];

            // konfirm = 1 telah dikonfirmasi
            $data['konfirm'] = '1';

            $data['kelas'] = $this->Main_model->get_all("kelas", ["status" => "aktif"], "nama_kelas");

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar');
            $this->load->view('peserta/peserta', $data);
            $this->load->view('templates/footer');
        }
        
        public function konfirm(){
            $data['title'] = 'Konfirmasi Peserta';
            $data['program'] = ["Hifdzi 1"];
            
            // konfirm = 0 belum dikonfirmasi
            $data['konfirm'] = '0';

            $data['kelas'] = $this->Main_model->get_all("kelas", ["status" => "aktif"], "nama_kelas");

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar');
            $this->load->view('peserta/peserta', $data);
            $this->load->view('templates/footer');
        }

        public function wl(){
            $data['title'] = 'Waiting List Peserta';
            $data['program'] = ["Hifdzi 1"];
            
            // konfirm = 0 belum dikonfirmasi
            $data['konfirm'] = '0';

            $data['kelas'] = $this->Main_model->get_all("kelas", ["status" => "aktif"], "nama_kelas");

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar');
            $this->load->view('peserta/peserta-wl', $data);
            $this->load->view('templates/footer');
        }

        public function ajax_list($konfirm){
            $list = $this->Peserta_model->get_datatables("konfirm = $konfirm");
            $data = array();
            $no = $_POST['start'];
            foreach ($list as $peserta) {
                $no++;
                $row = array();
                $row[] = '<center>'.$no.'</center>';
                if($peserta->username == "") $row[] = '<a href="#" class="btn btn-sm btn-primary" data-id="'.$peserta->id_user.'|'.$peserta->nama.'" id="btnAddId">buat ID</a>';
                else $row[] = $peserta->username;
                $row[] = $peserta->nama;
                $row[] = '<center><a href="#modalEdit" data-toggle="modal" data-id="'.$peserta->id_user.'" class="btn btn-sm btn-outline-dark peserta">' . COUNT($this->Main_model->get_all("kelas_user", ["id_user" => $peserta->id_user, "id_kelas <>" => NULL])) . '</a></center>';
                $row[] = '<center><a href="#modalEdit" data-toggle="modal" data-id="'.$peserta->id_user.'" class="btn btn-sm btn-outline-warning peserta">' . COUNT($this->Main_model->get_all("kelas_user", ["id_user" => $peserta->id_user, "id_kelas =" => NULL])) . '</a></center>';
                $row[] = '<a href="#modalEdit" data-toggle="modal" data-id="'.$peserta->id_user.'" class="btn btn-sm btn-info detail">detail</a>';
                if($konfirm == 0){
                    $wl = COUNT($this->Main_model->get_all("kelas_user", ["id_user" => $peserta->id_user, "id_kelas =" => NULL]));
                    if($peserta->username == "" || $wl == 0) $row[] = "<center>-</center>";
                    else $row[] = '<a href="#" data-toggle="modal" data-id="'.$peserta->id_user.'|'.$peserta->nama.'" class="btn btn-sm btn-success konfirmasi">konfirmasi</a>';
                    if($peserta->username == "") {
                        if($peserta->followup == 2){
                            $row[] = '<center>
                                    <a target="_blank" href="#" data-id="'.$peserta->id_user.'|'.$peserta->nama.'|https://api.whatsapp.com/send?phone=62'.substr($peserta->no_hp, 1).'&text=Follow%20Up%201|1" id="followUp1" class="btn btn-sm btn-success mr-1">1</a>
                                    <a target="_blank" href="#" data-id="'.$peserta->id_user.'|'.$peserta->nama.'|https://api.whatsapp.com/send?phone=62'.substr($peserta->no_hp, 1).'&text=Follow%20Up%202|2" id="followUp2" class="btn btn-sm btn-success">2</a>
                            </center>';
                        } else if($peserta->followup == 1){
                            $row[] = '<center>
                                    <a target="_blank" href="#" data-id="'.$peserta->id_user.'|'.$peserta->nama.'|https://api.whatsapp.com/send?phone=62'.substr($peserta->no_hp, 1).'&text=Follow%20Up%201|1" id="followUp1" class="btn btn-sm btn-success mr-1">1</a>
                                    <a target="_blank" href="#" data-id="'.$peserta->id_user.'|'.$peserta->nama.'|https://api.whatsapp.com/send?phone=62'.substr($peserta->no_hp, 1).'&text=Follow%20Up%202|2" id="followUp2" class="btn btn-sm btn-secondary">2</a>
                            </center>';
                        } else {
                            $row[] = '<center>
                                    <a target="_blank" href="#" data-id="'.$peserta->id_user.'|'.$peserta->nama.'|https://api.whatsapp.com/send?phone=62'.substr($peserta->no_hp, 1).'&text=Follow%20Up%201|1" id="followUp1" class="btn btn-sm btn-secondary mr-1">1</a>
                                    <a target="_blank" href="#" data-id="'.$peserta->id_user.'|'.$peserta->nama.'|https://api.whatsapp.com/send?phone=62'.substr($peserta->no_hp, 1).'&text=Follow%20Up%202|2" id="followUp2" class="btn btn-sm btn-secondary">2</a>
                            </center>';
                        }
                    } else $row[] = '<center>-</center>';
                    if($peserta->username == "") $row[] = '<center><a href="#" data-id="'.$peserta->id_user.'|'.$peserta->nama.'" class="btn btn-sm btn-danger delete_peserta"><i class="fa fa-trash-alt"></i></a></center>';
                    else $row[] = "<center>-</center>";
                }
    
                $data[] = $row;
            }
    
            $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->Peserta_model->count_all("konfirm = $konfirm"),
                        "recordsFiltered" => $this->Peserta_model->count_filtered("konfirm = $konfirm"),
                        "data" => $data,
                    );
            //output to json format
            echo json_encode($output);
        }

        public function wl_list($where = "Hifdzi 1"){
            $list = $this->Wl_model->get_datatables($where);
            $data = array();
            $no = $_POST['start'];
            foreach ($list as $peserta) {
                $no++;
                $row = array();
                $row[] = '<center>'.$no.'</center>';
                $row[] = $peserta->username;
                $row[] = $peserta->nama;
                $row[] = $peserta->program;
                $row[] = '<a href="#modalAdd" data-toggle="modal" data-id="'.$peserta->id.'|'.$peserta->nama.'|'.$peserta->program.'" class="btn btn-sm btn-info kelas">kelas</a>';
    
                $data[] = $row;
            }
    
            $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->Wl_model->count_all($where),
                        "recordsFiltered" => $this->Wl_model->count_filtered($where),
                        "data" => $data,
                    );
            //output to json format
            echo json_encode($output);
        }

        // get
            public function get_detail_peserta(){
                $id = $this->input->post("id");
                $data = $this->Main_model->get_one("user", ["id_user" => $id]);
                $data['link'] = 'https://api.whatsapp.com/send?phone=62'.substr($data["no_hp"], 1).'&text=*Data%20Login*%0A%0Akunjungi%20link%20berikut%20%3A%20app.mrscholae.com%0ASilahkan%20gunakan%20data%20berikut%20ini%20untuk%20masuk%20masuk%20ke%20akun%20Anda.%0AUsername%20%3A%20'.$data['username'].'%0APassword%20%3A%20'.date('dmY', strtotime($data['tgl_lahir'])).'%0A*harap%20menyimpan%20data%20ini%20dan%20jangan%20diberikan%20kepada%20orang%20lain*';
                // kelas peserta 
                    $kelas = $this->Main_model->get_all("kelas_user", ["id_user" => $id, "id_kelas <>" => NULL], "id");
                    foreach ($kelas as $i => $kelas) {
                        $data['user'][$i] = $kelas;
                        $data['user'][$i]['kelas'] = $this->Main_model->get_one("kelas", ["id_kelas" => $kelas['id_kelas']]);
                    }
                // kelas peserta 
                
                // waiting list peserta 
                    $wl = $this->Main_model->get_all("kelas_user", ["id_user" => $id, "id_kelas =" => NULL], "id");
                    foreach ($wl as $i => $wl) {
                        $data['wl'][$i] = $wl;
                    }
                // waiting list peserta 
                echo json_encode($data);
            }

            public function get_kelas_peserta(){
                $id = $this->input->post("id");
                $kelas = $this->Main_model->get_all("kelas_user", ["id_user" => $id, "id_kelas <>" => NULL]);
                foreach ($kelas as $i => $kelas) {
                    $data['user'][$i] = $kelas;
                    $data['user'][$i]['kelas'] = $this->Main_model->get_one("kelas", ["id_kelas" => $kelas['id_kelas']]);
                }
                echo json_encode($data);
            }
        // get

        // edit
            public function edit_peserta(){
                $id = $this->input->post("id_user", TRUE);
                $data = [
                    "nama" => $this->input->post("nama", TRUE),
                    "no_hp" => $this->input->post("no_hp", TRUE),
                    "alamat" => $this->input->post("alamat", TRUE),
                    "t4_lahir" => $this->input->post("t4_lahir", TRUE),
                    "tgl_lahir" => $this->input->post("tgl_lahir", TRUE),
                    "email" => $this->input->post("email", TRUE)
                ];

                $this->Main_model->edit_data("user", ["id_user" => $id], $data);
                echo json_encode("1");
            }

            public function konfirmasi(){
                $id_user = $this->input->post("id_user", TRUE);
                $this->Main_model->edit_data("user", ["id_user" => $id_user], ["konfirm" => 1]);
                echo json_encode("1");
            }
        // edit

        // delete
            public function remove_kelas(){
                $kelas = $this->input->post("id");
                foreach ($kelas as $kelas) {
                    $this->Main_model->delete_data("kelas_user", ["id" => $kelas]);
                }
                echo json_encode("1");
            }

            public function delete_wl(){
                $id = $this->input->post("id");
                $data = $this->Main_model->get_one("kelas_user", ["id" => $id]);
                $this->Main_model->delete_data("kelas_user", ["id" => $id]);
                echo json_encode($data['id_user']);
            }

            public function delete_peserta(){
                $id = $this->input->post("id");
                $this->Main_model->edit_data("user", ["id_user" => $id], ["konfirm" => 2]);
                echo json_encode("1");
            }
        // delete

        // add
            public function add_kelas(){
                $id_kelas = $this->input->post("id_kelas", TRUE);
                if($id_kelas == "") $id_kelas = NULL;
                $data = [
                    "id_kelas" => $id_kelas,
                    "id_user" => $this->input->post("id_user", TRUE),
                    "program" => $this->input->post("program", TRUE)
                ];

                $cek = $this->Main_model->get_one("kelas_user", $data);
                if($cek){
                    echo json_encode("0");
                } else {
                    $this->Main_model->add_data("kelas_user", $data);
                    echo json_encode("1");
                }
            }

            public function add_kelas_wl(){
                $id = $this->input->post("id");
                $id_kelas = $this->input->post("id_kelas");

                $this->Main_model->edit_data("kelas_user", ["id" => $id], ["id_kelas" => $id_kelas]);
                echo json_encode("1");
            }

            public function add_peserta(){
                $user = $this->username($this->input->post("tgl_masuk", TRUE));
                $password = date('dmY', strtotime($this->input->post("tgl_lahir", TRUE)));
                $data = [
                    "nama" => $this->input->post("nama", TRUE),
                    "no_hp" => $this->input->post("no_hp", TRUE),
                    "alamat" => $this->input->post("alamat", TRUE),
                    "tgl_lahir" => $this->input->post("tgl_lahir", TRUE),
                    "tgl_masuk" => $this->input->post("tgl_masuk", TRUE),
                    "t4_lahir" => $this->input->post("t4_lahir", TRUE),
                    "email" => $this->input->post("email", TRUE),
                    "username" => $user,
                    "password" => MD5($password),
                ];

                $this->Main_model->add_data("user", $data);
                echo json_encode("1");
            }

            public function buat_id(){
                $id = $this->input->post("id");
                $tgl = date("Y-m-d");
                $user = $this->username($tgl);
                $data = [
                    "username" => $user,
                    "tgl_masuk" => $tgl
                ];

                $this->Main_model->edit_data("user", ["id_user" => $id], $data);
                echo json_encode("1");
            }

            public function add_followup(){
                $id = $this->input->post("id");
                $followup = $this->input->post("followup");
                $data = $this->Main_model->get_one("user", ["id_user" => $id]);
                $this->Main_model->edit_data("user", ["id_user" => $id], ["followup" => $followup]);
                echo json_encode("1");
            }

            public function username($tgl){
                $username = $this->Main_model->get_username_terakhir($tgl);
                if($username){
                    $id = $username['id'] + 1;
                } else {
                    $id = 1;
                }

                if($id >= 1 && $id < 10){
                    $user = date('ym', strtotime($tgl))."000".$id;
                } else if($id >= 10 && $id < 100){
                    $user = date('ym', strtotime($tgl))."00".$id;
                } else if($id >= 100 && $id < 1000){
                    $user = date('ym', strtotime($tgl))."0".$id;
                } else {
                    $user = date('ym', strtotime($tgl)).$id;
                }
                return $user;
            }

    }