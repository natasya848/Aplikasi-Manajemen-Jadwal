<?php

namespace App\Controllers;

use App\Models\M_log;

class Log extends BaseController
{
    public function tabel_riwayat()
    {
        $this->logActivity("Mengakses Riwayat Aktivitas");

        $session = session();
        $id_user = $session->get('id_user'); 
        $level = $session->get('level');

        $logModel = new \App\Models\M_log();
        $logModel->select('log_activity.*, user.nama_user, user.username');
        $logModel->join('user', 'user.id_user = log_activity.id_user', 'left');

        if ($level == 1) {
            $idUserFilter = $this->request->getGet('id_user') ?? 'all';
            if ($idUserFilter !== 'all') {
                $logModel->where('log_activity.id_user', $idUserFilter);
            }
        } else {
            $logModel->where('log_activity.id_user', $id_user);
        }

        $logs = $logModel->orderBy('waktu', 'DESC')->findAll();

        $userList = [];
        if ($level == 1) {
            $db = \Config\Database::connect();
            $userList = $db->table('user')
                        ->select('DISTINCT(nama_user), id_user')
                        ->get()
                        ->getResultArray();
        }

        return view('log_act', [
            'logs' => $logs,
            'userList' => $userList,
            'selectedUser' => $level == 1 ? ($idUserFilter ?? 'all') : $id_user
        ]);
    }

    public function filter_ajax()
    {
        $id_user = $this->request->getGet('id_user');
        $logModel = new M_log();

        $logModel->select('log_activity.*, user.nama_user, user.username');
        $logModel->join('user', 'user.id_user = log_activity.id_user', 'LEFT');

        if ($id_user && $id_user !== 'all') {
            $logModel->where('log_activity.id_user', $id_user);
        }

        $logs = $query->orderBy('waktu', 'DESC')->findAll();

        $no = 1;
        foreach ($logs as $log) {
            echo "<tr>
                    <td>" . $no++ . "</td>
                    <td>" . ($log['id_user'] ?? '') . "</td>
                    <td>" . ($log['nama_user'] ?? 'User Tidak Diketahui') . "</td>
                    <td>" . ($log['username'] ?? '-') . "</td>
                    <td>id_user=" . ($log['id_user'] ?? '') . " " . ($log['aktivitas'] ?? '') . "</td>
                    <td>" . ($log['ip_address'] ?? 'Tidak Ada IP') . "</td>
                    <td>" . (isset($log['waktu']) ? date('d-m-Y H:i:s', strtotime($log['waktu'])) : '-') . "</td>
                </tr>";
        }
    }
}