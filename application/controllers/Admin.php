<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        check_backup();
    }

    public function index()
    {
        $this->db2 = $this->load->database('compro', true);

        // Disable cache
        $this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
        ('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
        $this->output->set_header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");

        $data['title'] = "Dashboard";
        $data['user'] = $this->db2->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $this->db->order_by('date', 'DESC');
        $data['priode'] = $this->db->get('priode', '6')->result_array();

        $data['month'] = $this->db->get('month')->result_array();

        $data['anggota_alumni'] = $this->db->get_where('member', ['id_status' => 2])->num_rows();

        $this->db->where('id_jabatan !=', 5);
        $data['pengurus'] = $this->db->get_where('member')->num_rows();

        $data['total_anggota'] = $this->db->get('member')->num_rows();

        $report = $this->db->get('report')->num_rows();

        if ($report < 1) {
            // ambil periode terkini
            $data['get_report'] = false;
            $this->db->order_by('date', 'DESC');
            $priode = $this->db->get('priode')->row_array();
            $data['anggota_aktif'] = $this->db->get_where('member', ['id_status' => 1])->num_rows();
        } else {
            $priode = $this->db->get('report')->row_array();
            $data['anggota_aktif'] = $this->db->get_where('presensi', ['date' => $priode['date']])->num_rows();
            $data['get_report'] = true;
        }


        // ambil presensi sesuai periode
        $presensi = $this->db->get_where('presensi', ['date' => $priode['date']])->result_array();

        // hitung yang hadir setiap pertemuannya
        $data['week_1'] = 0;
        $data['week_2'] = 0;
        $data['week_3'] = 0;
        $data['week_4'] = 0;
        foreach ($presensi as $pre) {
            if ($pre['week_1'] == 1) {
                $data['week_1']++;
            }
            if ($pre['week_2'] == 1) {
                $data['week_2']++;
            }
            if ($pre['week_3'] == 1) {
                $data['week_3']++;
            }
            if ($pre['week_4'] == 1) {
                $data['week_4']++;
            }
        }

        // hitung hadir, izin, alpha
        $data['hadir'] = 0;
        $data['izin'] = 0;
        $data['alpha'] = 0;
        foreach ($presensi as $pre) {
            if ($pre['week_1'] == 1) {
                $data['hadir']++;
            } elseif ($pre['week_1'] == 2) {
                $data['izin']++;
            } elseif ($pre['week_1'] == 3) {
                $data['alpha']++;
            }
            if ($pre['week_2'] == 1) {
                $data['hadir']++;
            } elseif ($pre['week_2'] == 2) {
                $data['izin']++;
            } elseif ($pre['week_2'] == 3) {
                $data['alpha']++;
            }
            if ($pre['week_3'] == 1) {
                $data['hadir']++;
            } elseif ($pre['week_3'] == 2) {
                $data['izin']++;
            } elseif ($pre['week_3'] == 3) {
                $data['alpha']++;
            }
            if ($pre['week_4'] == 1) {
                $data['hadir']++;
            } elseif ($pre['week_4'] == 2) {
                $data['izin']++;
            } elseif ($pre['week_4'] == 3) {
                $data['alpha']++;
            }
        }

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/index', $data);
        $this->load->view('templates/footer');
    }

    public function report()
    {
        $selectPriode = $this->input->post('selectPriode');
        $inputMonth = $this->input->post('inputMonth');
        $inputYear = $this->input->post('inputYear');

        if ($selectPriode == NULL and $inputMonth == NULL and $inputYear == "") {
            $this->session->set_flashdata('title', 'Error!');
            $this->session->set_flashdata('message', 'Field priode required!');
            $this->session->set_flashdata('icon', 'error');
            redirect('/');
        }

        if ($inputMonth == NULL and $inputYear == "") {

            $this->db->insert('report', ['date' => $selectPriode]);
        } else {

            if ($selectPriode != NULL) {
                $this->session->set_flashdata('title', 'Error!');
                $this->session->set_flashdata('message', 'Please choose one select or input methode!');
                $this->session->set_flashdata('icon', 'error');
                redirect('/');
            }

            $priode = mktime(NULL, NULL, NULL, $inputMonth, NULL, $inputYear);

            $numrows = $this->db->get_where('presensi', ['date' => $priode])->num_rows();

            if ($numrows < 1) {
                $this->session->set_flashdata('title', 'Error!');
                $this->session->set_flashdata('message', 'Priode not found!');
                $this->session->set_flashdata('icon', 'error');
                redirect('/');
            } else {
                $this->db->insert('report', ['date' => $priode]);
            }
        }

        $this->session->set_flashdata('title', 'Congratulation!');
        $this->session->set_flashdata('message', 'Generate report success!');
        $this->session->set_flashdata('icon', 'success');
        redirect('/');
    }

    public function resetReport()
    {
        $this->db->truncate('report');

        $this->session->set_flashdata('title', 'Congratulation!');
        $this->session->set_flashdata('message', 'Reset report success!');
        $this->session->set_flashdata('icon', 'success');
        redirect('/');
    }
}
