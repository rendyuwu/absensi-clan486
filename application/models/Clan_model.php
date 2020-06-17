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
            die;
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
        } elseif ($kosong == 0) {
            $validasi = true;
        } else {
            return false;
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

                        if ($id_member == NULL) {
                            return false;
                        }
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

    public function deleteBackup()
    {
        $id = $this->uri->segment(3);

        $priode = $this->db->get_where('backup_priode', ['id' => $id])->row_array();

        $this->db->where('date', $priode['date']);
        $this->db->where('expire', $priode['expire']);
        $this->db->delete('backup_presensi');

        $this->db->delete('backup_priode', ['id' => $id]);
    }

    public function restoreBackup()
    {
        $id = $this->uri->segment(3);

        $backupPriode = $this->db->get_where('backup_priode', ['id' => $id])->row_array();

        $priode = $this->db->get_where('priode', ['date' => $backupPriode['date']])->num_rows();
        if ($priode > 0) {
            $this->db->delete('priode', ['date' => $backupPriode['date']]);
            $this->db->delete('presensi', ['date' => $backupPriode['date']]);
        }

        $this->db->where('date', $backupPriode['date']);
        $this->db->where('expire', $backupPriode['expire']);
        $presensiBackup = $this->db->get('backup_presensi')->result_array();

        foreach ($presensiBackup as $presensi) {
            $data = [
                'id_member' => $presensi['id_member'],
                'date' => $presensi['date'],
                'week_1' => $presensi['week_1'],
                'week_2' => $presensi['week_2'],
                'week_3' => $presensi['week_3'],
                'week_4' => $presensi['week_4']
            ];
            $this->db->insert('presensi', $data);
        }
        $this->db->insert('priode', ['date' => $backupPriode['date']]);
    }

    public function generateSuratActive()
    {
        $selectToPriode = $this->input->post('selectToPriode');
        $selectFromPriode = $this->input->post('selectFromPriode');

        if ($selectFromPriode >= $selectToPriode) {
            $this->session->set_flashdata('title', 'Error!');
            $this->session->set_flashdata('message', 'Please check field priode!');
            $this->session->set_flashdata('icon', 'error');
            redirect('active');
        }

        $this->db->where('date >=', $selectFromPriode);
        $this->db->where('date <=', $selectToPriode);
        $priode = $this->db->get('priode')->result_array();

        $total = 0;
        $max = 0;
        foreach ($priode as $p) {
            $presensi = $this->db->get_where('presensi', ['date' => $p['date']])->result_array();

            foreach ($presensi as $pre) {
                $id_member = $pre['id_member'];
                $date = $pre['date'];
                $numrows = $this->db->get_where('total_active', ['id_member' => $id_member, 'date' => $date])->num_rows();

                if ($numrows < 1) {
                    $total = 0;
                    $max = 0;
                }

                if ($numrows < 1) {
                    if ($pre['week_1'] == 1) {
                        $total++;
                        $max++;
                    } elseif ($pre['week_1'] != 0) {
                        $max++;
                    }
                    if ($pre['week_2'] == 1) {
                        $total++;
                        $max++;
                    } elseif ($pre['week_2'] != 0) {
                        $max++;
                    }
                    if ($pre['week_3'] == 1) {
                        $total++;
                        $max++;
                    } elseif ($pre['week_3'] != 0) {
                        $max++;
                    }
                    if ($pre['week_4'] == 1) {
                        $total++;
                        $max++;
                    } elseif ($pre['week_4'] != 0) {
                        $max++;
                    }

                    $this->db->insert('total_active', ['id_member' => $id_member, 'total' => $total, 'max' => $max, 'date' => $date]);
                } else {
                    if ($pre['week_1'] == 1) {
                        $total++;
                        $max++;
                    } elseif ($pre['week_1'] != 0) {
                        $max++;
                    }
                    if ($pre['week_2'] == 1) {
                        $total++;
                        $max++;
                    } elseif ($pre['week_2'] != 0) {
                        $max++;
                    }
                    if ($pre['week_3'] == 1) {
                        $total++;
                        $max++;
                    } elseif ($pre['week_3'] != 0) {
                        $max++;
                    }
                    if ($pre['week_4'] == 1) {
                        $total++;
                        $max++;
                    } elseif ($pre['week_4'] != 0) {
                        $max++;
                    }

                    $this->db->update('total_active', ['total' => $total, 'max' => $max], ['id_member' => $id_member]);
                }
            }
        }

        $total_active = $this->db->get('total_active')->result_array();

        foreach ($total_active as $ta) {
            $id_member = $ta['id_member'];

            $numrows = $this->db->get_where('active', ['id_member' => $id_member])->num_rows();

            if ($numrows < 1) {

                $data = [
                    'id_member' => $id_member,
                    'from_date' => $selectFromPriode,
                    'to_date' => $selectToPriode,
                    'total' => $ta['total'],
                    'max' => $ta['max'],
                    'minimal' => 75,
                ];

                $this->db->insert('active', $data);
            } else {
                $active = $this->db->get_where('active', ['id_member' => $id_member])->row_array();

                $max = $active['max'] + $ta['max'];
                $total = $active['total'] + $ta['total'];

                $presentase = floor($total / $max * 100);

                if ($presentase >= $active['minimal']) {
                    $active = true;
                } else {
                    $active = false;
                }

                $data = [
                    'total' => $total,
                    'max' => $max,
                    'presentase' => $presentase,
                    'active' => $active
                ];
                $this->db->update('active', $data, ['id_member' => $id_member]);
            }
        }
    }
}
