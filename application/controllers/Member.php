<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Member extends CI_Controller
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
        $data['title'] = "Member Management";
        $data['user'] = $this->db2->get_where('user', ['email' => $this->session->userdata('email')])->row_array();


        // Query data member
        $this->db->order_by('id_jabatan', 'ASC');
        $data['member'] = $this->db->get('member')->result_array();

        // Query data jabatan
        $data['jb'] = $this->db->get('jabatan')->result_array();

        // Query data prodi
        $data['pr'] = $this->db->get('prodi')->result_array();

        // Query data status
        $data['st'] = $this->db->get('status')->result_array();

        $this->form_validation->set_rules('nim', 'NIM', 'required|trim|is_unique[member.nim]', [
            'is_unique' => 'Nim alredy registered!'
        ]);
        $this->form_validation->set_rules('nama', 'Nama', 'required|trim');
        $this->form_validation->set_rules('id_jabatan', 'Jabatan', 'required|trim');
        $this->form_validation->set_rules('id_prodi', 'Prodi', 'required|trim');
        $this->form_validation->set_rules('telp', 'No Telp', 'required|trim|numeric|min_length[10]|max_length[13]');
        $this->form_validation->set_rules('id_status', 'Status', 'required|trim');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('member/index', $data);
            $this->load->view('templates/footer');
        } else {


            $this->clan->addNewMember();
            $this->session->set_flashdata('title', 'Congratulation!');
            $this->session->set_flashdata('message', 'New member added!');
            $this->session->set_flashdata('icon', 'success');
            redirect('member');
        }
    }
    public function delete()
    {
        check_role();
        $id = $this->uri->segment(3);
        $this->clan->delete('member', $id);

        $this->session->set_flashdata('title', 'Congratulation!');
        $this->session->set_flashdata('message', 'Submenu deleted!');
        $this->session->set_flashdata('icon', 'success');
        redirect('member');
    }

    public function edit()
    {
        check_role();
        $data['title'] = "Member Management";
        $data['user'] = $this->db2->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $id = $this->uri->segment(3);
        // Query data member
        $this->db->where('id', $id);
        $data['member'] = $this->db->get('member')->row_array();

        // Query data jabatan
        $data['jb'] = $this->db->get('jabatan')->result_array();

        // Query data prodi
        $data['pr'] = $this->db->get('prodi')->result_array();

        // Query data status
        $data['st'] = $this->db->get('status')->result_array();

        $this->form_validation->set_rules('nim', 'NIM', 'required|trim');
        $this->form_validation->set_rules('nama', 'Nama', 'required|trim');
        $this->form_validation->set_rules('id_jabatan', 'Jabatan', 'required|trim');
        $this->form_validation->set_rules('id_prodi', 'Prodi', 'required|trim');
        $this->form_validation->set_rules('telp', 'No Telp', 'required|trim|numeric|min_length[10]|max_length[13]');
        $this->form_validation->set_rules('id_status', 'Status', 'required|trim');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('member/edit', $data);
            $this->load->view('templates/footer');
        } else {
            $id = $this->input->post('id', true);
            $nim = $this->input->post('nim', true);

            // Query member untuk cek nim
            $member = $this->db->get_where('member', ['id' => $id])->row_array();

            if ($nim != $member['nim']) {
                $result = $this->db->get_where('member', ['nim' => $nim])->num_rows();

                if ($result > 0) {
                    $this->session->set_flashdata('title', 'Error!');
                    $this->session->set_flashdata('message', 'Nim alredy registered!');
                    $this->session->set_flashdata('icon', 'error');
                    redirect('member/edit/' . $id);
                }
            }

            $this->clan->editMember();

            $this->session->set_flashdata('title', 'Congratulation!');
            $this->session->set_flashdata('message', 'Member updated!');
            $this->session->set_flashdata('icon', 'success');
            redirect('member');
        }
    }
}
