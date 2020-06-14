<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Clan_model extends CI_Model
{
    public function addNewMember()
    {
        $data = [
            'nim' => htmlspecialchars($this->input->post('nim', true)),
            'nama' => htmlspecialchars($this->input->post('nama', true)),
            'id_jabatan' => htmlspecialchars($this->input->post('id_jabatan', true)),
            'id_prodi' => htmlspecialchars($this->input->post('id_prodi', true)),
            'telp' => htmlspecialchars($this->input->post('telp', true)),
            'id_status' => htmlspecialchars($this->input->post('id_status', true))
        ];

        $this->db->insert('member', $data);
    }

    public function delete($table, $id)
    {
        $this->db->delete($table, ['id' => $id]);
    }

    public function editMember()
    {
        $id = $this->input->post('id', true);

        $data = [
            'nim' => htmlspecialchars($this->input->post('nim', true)),
            'nama' => htmlspecialchars($this->input->post('nama', true)),
            'id_jabatan' => htmlspecialchars($this->input->post('id_jabatan', true)),
            'id_prodi' => htmlspecialchars($this->input->post('id_prodi', true)),
            'telp' => htmlspecialchars($this->input->post('telp', true)),
            'id_status' => htmlspecialchars($this->input->post('id_status', true))
        ];

        $this->db->update('member', $data, ['id' => $id]);
    }

    public function addPresensi()
    {
        $year = $this->input->post('year', true);
        $month = $this->input->post('month', true);
        $month++;
        $week = $this->input->post('week', true);

        $date = mktime(null, null, null, $month, null, $year);

        $member = $this->db->get_where('member', ['id_status' => 1])->result_array();

        $result = $this->db->get_where('member', ['id_status' => 1])->num_rows();

        $kosong = 0;

        foreach ($member as $m) {
            $id_absen = $this->input->post('id_absen-' . $m['id'], true);
            if ($id_absen == 0) {
                $kosong++;
            }
        }
        if ($result == $kosong) {
            $validasi = true;
        } else if ($kosong == 0) {
            $validasi = true;
        } else {
            $validasi = false;
        }

        if ($validasi == true) {
            foreach ($member as $m) {
                $id_member = $this->input->post('id_member-' . $m['id'], true);
                $id_absen = $this->input->post('id_absen-' . $m['id'], true);

                $data = [
                    'id_member' => $id_member,
                    'date' => $date,
                    'week_' . $week => $id_absen
                ];

                $this->db->insert('presensi', $data);
            }
            return true;
        } else {
            return false;
        }
    }

    public function updatePresensi()
    {
        $year = $this->input->post('year', true);
        $month = $this->input->post('month', true);
        $month++;
        $week = $this->input->post('week', true);

        $date = mktime(null, null, null, $month, null, $year);

        $lastPriode = $this->input->post('lastPriode', true);
        if ($lastPriode == 3) {
            $member = $this->db->get_where('member', ['id_status' => 1])->result_array();
        } else {
            $member = $this->db->get_where('presensi', ['date' => $date])->result_array();
        }

        $result = $this->db->get_where('presensi', ['date' => $date])->num_rows();

        $kosong = 0;

        foreach ($member as $m) {
            if ($lastPriode == 3) {
                $id_absen = $this->input->post('id_absen-' . $m['id'], true);
            } else {
                $id_absen = $this->input->post('id_absen-' . $m['id_member'], true);
            }
            if ($id_absen == 0) {
                $kosong++;
            }
        }
        if ($result == $kosong) {
            $validasi = true;
        } else if ($kosong == 0) {
            $validasi = true;
        } else {
            $validasi = false;
        }

        if ($validasi == true) {
            foreach ($member as $m) {
                if ($lastPriode == 3) {
                    $id_absen = $this->input->post('id_absen-' . $m['id'], true);
                    $id_member = $this->input->post('id_member-' . $m['id'], true);

                    $this->db->where('id_member', $id_member);
                    $this->db->where('date', $date);
                    if ($this->db->get('presensi')->num_rows() > 0) {
                        $data = [
                            'week_' . $week => $id_absen
                        ];

                        $this->db->where('id_member', $id_member);
                        $this->db->where('date', $date);
                        $this->db->update('presensi', $data);
                    } else {
                        $data = [
                            'id_member' => $id_member,
                            'date' => $date,
                            'week_' . $week => $id_absen
                        ];

                        $this->db->insert('presensi', $data);
                    }
                } else {
                    $id_absen = $this->input->post('id_absen-' . $m['id_member'], true);
                    $id_presensi = $this->input->post('id_presensi-' . $m['id_member'], true);

                    $data = [
                        'week_' . $week => $id_absen
                    ];
                    $this->db->where('id', $id_presensi);
                    $this->db->update('presensi', $data);
                }
            }
            return true;
        } else {
            return false;
        }
    }

    public function addMemberToPresensi()
    {
        $year = $this->input->post('year', true);
        $month = $this->input->post('month', true);
        $month++;

        $date = mktime(null, null, null, $month, null, $year);

        $newNim = htmlspecialchars($this->input->post('newNim', true));

        $member = $this->db->get_where('member', ['nim' => $newNim])->row_array();

        $data = [
            'id_member' => $member['id'],
            'date' => $date,
            'week_1' => 3,
            'week_2' => 3,
            'week_3' => 3,
            'week_4' => 3,
        ];

        $this->db->insert('presensi', $data);
    }
}
