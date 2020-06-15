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

function check_backup()
{
    $clan = get_instance();

    if ($clan->db->get('backup_priode')->num_rows() > 0) {
        $priode = $clan->db->get('backup_priode')->result_array();
        $curentDate = time();

        foreach ($priode as $p) {
            $expire = $p['expire'];

            if ($curentDate > $expire) {
                $clan->db->delete('backup_presensi', ['expire' => $expire]);
                $clan->db->delete('backup_priode', ['expire' => $expire]);
            }
        }
    }
}
