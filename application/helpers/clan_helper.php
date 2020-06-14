<?php

function is_logged_in()
{
    $clan = get_instance();
    if (!$clan->session->userdata('email')) {
        redirect('auth');
    }
}


function check_access($role_id, $menu_id)
{
    $clan = get_instance();

    $result = $clan->db->get_where('user_access_menu', ['role_id' => $role_id, 'menu_id' => $menu_id]);

    if ($result->num_rows() > 0) {
        return "checked='checked'";
    }
}
