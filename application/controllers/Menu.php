<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Menu extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model('Menu_model', 'menu');
        $this->db2 = $this->load->database('compro', true);
    }


    public function index()
    {
        $data['title'] = "Menu Managament";
        $data['user'] = $this->db2->get_where('user', ['email' => $this->session->userdata('email')])->row_array();


        // QUERY MENU
        $data['menu'] = $this->db->get('user_menu')->result_array();

        // Form validation untuk add menu
        $this->form_validation->set_rules('menu', 'Menu', 'required|trim');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('menu/index', $data);
            $this->load->view('templates/footer');
        } else {
            // QUERY INSERT DATA MENU
            $this->db->insert('user_menu', ['menu' => htmlspecialchars($this->input->post('menu', true))]);
            $this->session->set_flashdata('title', 'Congratulation!');
            $this->session->set_flashdata('message', 'New menu added!');
            $this->session->set_flashdata('icon', 'success');
            redirect('menu');
        }
    }

    public function delete()
    {
        check_role();
        $id = $this->uri->segment(3);
        $this->db->delete('user_menu', ['id' => $id]);

        $this->session->set_flashdata('title', 'Congratulation!');
        $this->session->set_flashdata('message', 'Menu deleted!');
        $this->session->set_flashdata('icon', 'success');
        redirect('menu');
    }

    public function edit()
    {
        check_role();
        $data['title'] = "Menu Managament";
        $data['user'] = $this->db2->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        // QUERY MENU WITH ID
        $id = $this->uri->segment(3);
        $data['menu'] = $this->db->get_where('user_menu', ['id' => $id])->row_array();

        // FORM VALIDATION UNTUK EDIT MENU
        $this->form_validation->set_rules('menu', 'Menu', 'required');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('menu/edit', $data);
            $this->load->view('templates/footer');
        } else {
            $this->db->update('user_menu', ['menu' => htmlspecialchars($this->input->post('menu', true))], ['id' => $this->input->post('id')]);
            $this->session->set_flashdata('title', 'Congratulation!');
            $this->session->set_flashdata('message', 'Menu updated!');
            $this->session->set_flashdata('icon', 'success');
            redirect('menu');
        }
    }




    // SUB MENU
    public function submenu()
    {
        $data['title'] = "Submenu Management";
        $data['user'] = $this->db2->get_where('user', ['email' => $this->session->userdata('email')])->row_array();


        $data['subMenu'] = $this->menu->getSubMenu();
        $data['menu'] = $this->db->get('user_menu')->result_array();

        $this->form_validation->set_rules('title', 'Title', 'required|trim');
        $this->form_validation->set_rules('menu_id', 'Menu', 'required|trim');
        $this->form_validation->set_rules('url', 'URL', 'required|trim');
        $this->form_validation->set_rules('icon', 'Icon', 'required|trim');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('menu/submenu', $data);
            $this->load->view('templates/footer');
        } else {
            $data = [
                'title' => htmlspecialchars($this->input->post('title', true)),
                'menu_id' => htmlspecialchars($this->input->post('menu_id', true)),
                'url' => htmlspecialchars($this->input->post('url', true)),
                'icon' => htmlspecialchars($this->input->post('icon', true)),
                'is_active' => htmlspecialchars($this->input->post('is_active', true))
            ];
            $this->db->insert('user_sub_menu', $data);
            $this->session->set_flashdata('title', 'Congratulation!');
            $this->session->set_flashdata('message', 'Submenu added!');
            $this->session->set_flashdata('icon', 'success');
            redirect('menu/submenu');
        }
    }

    public function submenudelete()
    {
        check_role();
        $id = $this->uri->segment(3);
        $this->db->delete('user_sub_menu', ['id' => $id]);

        $this->session->set_flashdata('title', 'Congratulation!');
        $this->session->set_flashdata('message', 'Submenu deleted!');
        $this->session->set_flashdata('icon', 'success');
        redirect('menu/submenu');
    }

    public function submenuedit()
    {
        check_role();
        $data['title'] = "Submenu Management";
        $data['user'] = $this->db2->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['menu'] = $this->db->get('user_menu')->result_array();

        // QUERY SUB MENU WITH ID
        $id = $this->uri->segment(3);
        $data['subMenu'] = $this->db->get_where('user_sub_menu', ['id' => $id])->row_array();


        // FORM VALIDATION
        $this->form_validation->set_rules('title', 'Title', 'required|trim');
        $this->form_validation->set_rules('url', 'URL', 'required|trim');
        $this->form_validation->set_rules('icon', 'Icon', 'required|trim');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('menu/submenuedit', $data);
            $this->load->view('templates/footer');
        } else {
            $dataSubMenu = [
                'title' => htmlspecialchars($this->input->post('title', true)),
                'menu_id' => htmlspecialchars($this->input->post('menu_id', true)),
                'url' => htmlspecialchars($this->input->post('url', true)),
                'icon' => htmlspecialchars($this->input->post('icon', true)),
                'is_active' => htmlspecialchars($this->input->post('is_active', true))
            ];
            $id = $this->input->post('id');

            $this->db->update('user_sub_menu', $dataSubMenu, ['id' => $id]);

            $this->session->set_flashdata('title', 'Congratulation!');
            $this->session->set_flashdata('message', 'Submenu edited!');
            $this->session->set_flashdata('icon', 'success');
            redirect('menu/submenu');
        }
    }
}
