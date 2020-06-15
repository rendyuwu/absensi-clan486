<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Backup extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->db2 = $this->load->database('compro', true);
        $this->load->model('Clan_model', 'clan');
        check_backup();
    }

    public function index()
    {
        $data['title'] = "Backup";
        $data['user'] = $this->db2->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $this->db->order_by('expire', 'ASC');
        $data['backup'] = $this->db->get('backup_priode')->result_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('backup/index', $data);
        $this->load->view('templates/footer');
    }

    public function delete()
    {
        $this->clan->deleteBackup();

        $this->session->set_flashdata('title', 'Congratulation!');
        $this->session->set_flashdata('message', 'Data backup deleted!');
        $this->session->set_flashdata('icon', 'success');
        redirect('backup');
    }

    public function restore()
    {
        $this->clan->restoreBackup();

        $this->clan->deleteBackup();

        $this->session->set_flashdata('title', 'Congratulation!');
        $this->session->set_flashdata('message', 'Data restored!');
        $this->session->set_flashdata('icon', 'success');
        redirect('presensi');
    }
}
