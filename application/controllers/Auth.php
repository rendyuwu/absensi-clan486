<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
    }

    public function index()
    {
        if ($this->session->userdata('email')) {
            redirect('user');
        }
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'required|trim');

        if ($this->form_validation->run() == false) {
            $data['title'] = 'Login Page';
            $this->load->view('templates/auth_header', $data);
            $this->load->view('auth/login');
            $this->load->view('templates/auth_footer');
        } else {
            $this->_login();
        }
    }


    private function _login()
    {
        $this->db2 = $this->load->database('compro', true);

        $email = $this->input->post('email');
        $password = $this->input->post('password');

        $user = $this->db2->get_where('user', ['email' => $email])->row_array();

        // jika usernya ada
        if ($user) {
            // jika usernya aktif
            if ($user['is_active'] == 1) {
                // cek password
                if (password_verify($password, $user['password'])) {
                    $data = [
                        'email' => $user['email'],
                        'role_id' => $user['role_id']
                    ];
                    $this->session->set_userdata($data);
                    if ($user['role_id'] == 1) {
                        redirect(base_url());
                    } else {
                        redirect('user');
                    }
                } else {
                    $this->session->set_flashdata('title', 'Error!');
                    $this->session->set_flashdata('message', 'Wrong password!');
                    $this->session->set_flashdata('icon', 'error');
                    redirect('auth');
                }
            } else {
                $this->session->set_flashdata('title', 'Error!');
                $this->session->set_flashdata('message', 'This email has not been activated. Please contact admin for activate your email!');
                $this->session->set_flashdata('icon', 'error');
                redirect('auth');
            }
        } else {
            $this->session->set_flashdata('title', 'Error!');
            $this->session->set_flashdata('message', 'Email is not registered!');
            $this->session->set_flashdata('icon', 'error');
            redirect('auth');
        }
    }

    public function logout()
    {
        $this->session->unset_userdata('email');
        $this->session->unset_userdata('role_id');

        $this->session->set_flashdata('title', 'Congratulation!');
        $this->session->set_flashdata('message', 'You have been logged out!');
        $this->session->set_flashdata('icon', 'success');
        redirect('auth');
    }


    public function blocked()
    {
        $this->load->view('auth/blocked');
    }
}
