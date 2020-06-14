<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Presensi extends CI_Controller
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
        $data['title'] = "Presensi Clan486";
        $data['user'] = $this->db2->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $this->db->order_by('date', 'DESC');
        $data['priode'] = $this->db->get('priode')->result_array();

        $data['month'] = $this->db->get('month')->result_array();

        $this->form_validation->set_rules('month', 'Month', 'required');
        $this->form_validation->set_rules('year', 'Year', 'required|trim|numeric|min_length[4]|max_length[4]');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('presensi/index', $data);
            $this->load->view('templates/footer');
        } else {
            $month = $this->input->post('month', true);
            $year = htmlspecialchars($this->input->post('year', true));

            $date = mktime(null, null, null, $month, null, $year);

            if ($this->db->get_where('priode', ['date' => $date])->num_rows() > 0) {
                $this->session->set_flashdata('title', 'Error!');
                $this->session->set_flashdata('message', 'Priode alredy added!');
                $this->session->set_flashdata('icon', 'error');
                redirect('presensi');
            } else {
                $this->db->insert('priode', ['date' => $date]);

                $this->session->set_flashdata('title', 'Congratulation!');
                $this->session->set_flashdata('message', 'New priode added!');
                $this->session->set_flashdata('icon', 'success');
                redirect('presensi');
            }
        }
    }

    public function edit()
    {
        $data['title'] = "Presensi Clan486";
        $data['user'] = $this->db2->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $this->db->where('id', $this->uri->segment(3));
        $data['priode'] = $this->db->get('priode')->row_array();

        $data['month'] = $this->db->get('month')->result_array();

        $this->form_validation->set_rules('month', 'Month', 'required');
        $this->form_validation->set_rules('year', 'Year', 'required|trim|numeric|min_length[4]|max_length[4]');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('presensi/edit', $data);
            $this->load->view('templates/footer');
        } else {
            $id = $this->input->post('id', true);
            $month = $this->input->post('month', true);
            $year = htmlspecialchars($this->input->post('year', true));

            $date = mktime(null, null, null, $month, null, $year);

            $this->db->update('priode', ['date' => $date], ['id' => $id]);

            $this->session->set_flashdata('title', 'Congratulation!');
            $this->session->set_flashdata('message', 'Priode updated!');
            $this->session->set_flashdata('icon', 'success');
            redirect('presensi');
        }
    }

    public function delete()
    {
        $this->clan->delete('priode', $this->uri->segment(3));

        $this->session->set_flashdata('title', 'Congratulation!');
        $this->session->set_flashdata('message', 'Priode deleted!');
        $this->session->set_flashdata('icon', 'success');
        redirect('presensi');
    }
}