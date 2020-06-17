<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Detail extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->db2 = $this->load->database('compro', true);
        $this->load->model("Clan_model", "clan");
    }

    public function presensi($year, $month, $week)
    {
        $data['title'] = "Presensi Clan486";
        $data['user'] = $this->db2->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $month++;
        $data['date'] = mktime(null, null, null, $month, null, $year);

        $this->db->order_by('date');
        $priodeLast = $this->db->get('priode')->last_row('array');

        if ($data['date'] == $priodeLast['date']) {
            if ($this->db->get_where('presensi', ['date' => $data['date']])->num_rows() > 0) {
                $data['presensi'] = $this->db->get_where('member', ['id_status' => 1])->result_array();
                $data['button'] = "Update presensi";
                $data['lastPriode'] = 3;
            } else {
                $data['presensi'] = $this->db->get_where('member', ['id_status' => 1])->result_array();
                if ($this->db->get_where('presensi', ['date' => $data['date']])->num_rows() > 0) {
                    $data['button'] = "Update presensi";
                } else {
                    $data['button'] = "Add presensi";
                }
                $data['lastPriode'] = 1;
            }
        } else {
            $data['presensi'] = $this->db->get_where('presensi', ['date' => $data['date']])->result_array();
            $data['button'] = "Update presensi";
            $data['lastPriode'] = 0;
        }

        if ($week == 1) {
            $data['week'] = "Minggu Pertama";
        } elseif ($week == 2) {
            $data['week'] = "Minggu Kedua";
        } elseif ($week == 3) {
            $data['week'] = "Minggu Ketiga";
        } elseif ($week == 4) {
            $data['week'] = "Minggu Keempat";
        }

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('detail/index', $data);
        $this->load->view('templates/footer');
    }

    public function update()
    {
        $year = $this->input->post('year', true);
        $month = $this->input->post('month', true);
        $week = $this->input->post('week', true);

        $lastPriode = $this->input->post('lastPriode', true);
        if ($lastPriode == 1) {
            $result = $this->clan->addPresensi();

            if ($result == false) {
                $this->session->set_flashdata('title', 'Failed update presensi!');
                $this->session->set_flashdata('message', 'Field kosong only can checked all or not checked!');
                $this->session->set_flashdata('icon', 'error');
                redirect('detail/presensi/' . $year . "/" . $month . "/" . $week);
            } else {
                $this->session->set_flashdata('title', 'Congratulation!');
                $this->session->set_flashdata('message', 'New presensi added!');
                $this->session->set_flashdata('icon', 'success');
                redirect('detail/presensi/' . $year . "/" . $month . "/" . $week);
            }
        } elseif ($lastPriode == 3) {
            $result = $this->clan->updatePresensi();
            if ($result == false) {
                $this->session->set_flashdata('title', 'Failed update presensi!');
                $this->session->set_flashdata('message', 'Field kosong only can checked all or not checked!');
                $this->session->set_flashdata('icon', 'error');
                redirect('detail/presensi/' . $year . "/" . $month . "/" . $week);
            } else {
                $this->session->set_flashdata('title', 'Congratulation!');
                $this->session->set_flashdata('message', 'Presensi updated!');
                $this->session->set_flashdata('icon', 'success');
                redirect('detail/presensi/' . $year . "/" . $month . "/" . $week);
            }
        } else {
            $result = $this->clan->updatePresensi();
            if ($result == false) {
                $this->session->set_flashdata('title', 'Failed update presensi!');
                $this->session->set_flashdata('message', 'Field kosong only can checked all or not checked!');
                $this->session->set_flashdata('icon', 'error');
                redirect('detail/presensi/' . $year . "/" . $month . "/" . $week);
            } else {
                $this->session->set_flashdata('title', 'Congratulation!');
                $this->session->set_flashdata('message', 'Presensi updated!');
                $this->session->set_flashdata('icon', 'success');
                redirect('detail/presensi/' . $year . "/" . $month . "/" . $week);
            }
        }
    }

    public function add()
    {
        $year = $this->input->post('year', true);
        $month = $this->input->post('month', true);
        $week = $this->input->post('week', true);
        $newNim = htmlspecialchars($this->input->post('newNim', true));

        $query = $this->db->get_where('member', ['nim' => $newNim])->num_rows();
        if ($query < 1) {
            $this->session->set_flashdata('title', 'Error!');
            $this->session->set_flashdata('message', 'Nim not registered!');
            $this->session->set_flashdata('icon', 'error');
            redirect('detail/presensi/' . $year . "/" . $month . "/" . $week);
        } else {
            $this->clan->addMemberToPresensi();

            $this->session->set_flashdata('title', 'Congratulation!');
            $this->session->set_flashdata('message', 'Member added!');
            $this->session->set_flashdata('icon', 'success');
            redirect('detail/presensi/' . $year . "/" . $month . "/" . $week);
        }
    }

    public function backup($year, $month, $week)
    {
        $data['title'] = "Backup";
        $data['user'] = $this->db2->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $month++;
        $data['date'] = mktime(null, null, null, $month, null, $year);

        $data['presensi'] = $this->db->get_where('backup_presensi', ['date' => $data['date']])->result_array();

        if ($week == 1) {
            $data['week'] = "Minggu Pertama";
        } elseif ($week == 2) {
            $data['week'] = "Minggu Kedua";
        } elseif ($week == 3) {
            $data['week'] = "Minggu Ketiga";
        } elseif ($week == 4) {
            $data['week'] = "Minggu Keempat";
        }

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('detail/backup', $data);
        $this->load->view('templates/footer');
    }
}
