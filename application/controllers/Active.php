<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Active extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->db2 = $this->load->database('compro', true);
        $this->load->model('Clan_model', 'clan');
    }

    public function index()
    {
        $data['title'] = "Surat Aktif";
        $data['user'] = $this->db2->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $this->db->order_by('date', 'DESC');
        $data['priode'] = $this->db->get('priode', '12')->result_array();

        $data['active'] = $this->db->get('active')->result_array();


        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('active/index', $data);
        $this->load->view('templates/footer');
    }

    public function generate()
    {

        $this->clan->generateSuratActive();

        $this->session->set_flashdata('title', 'Congratulation!');
        $this->session->set_flashdata('message', 'Generate success!');
        $this->session->set_flashdata('icon', 'success');
        redirect('active');
    }

    public function truncate()
    {
        $this->db->truncate('active');
        $this->db->truncate('total_active');

        $this->session->set_flashdata('title', 'Congratulation!');
        $this->session->set_flashdata('message', 'Data deleted!');
        $this->session->set_flashdata('icon', 'success');
        redirect('active');
    }
}
