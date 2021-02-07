<?php
if (!defined('BASEPATH')) exit(header('Location:../'));
class Ajax extends CI_controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('m_admin');
    }

    public function get_skp($id = null)
    {
        if ($id) $this->db->where('id', $id);
        echo json_encode($this->db->get('skp')->result_array());
        exit;
    }

    public function get_kegiatan($id)
    {
        $kegiatan = $this->db->where('id', $id)->get('skp_kegiatan')->row_array();
        echo json_encode($kegiatan);
        exit;
    }

    public function get_kegiatan_table($id)
    {
        $row = "";
        $this->db->where('skp_id', $id);
        $kegiatan = $this->db->get('skp_kegiatan')->result_array();
        // var_dump($kegiatan);die;
        foreach ($kegiatan as $item) {
            $row .= "<tr>
                <td>" . $item['kegiatan'] . "</td>
                <td>0</td>
                <td>0</td>
                <td>" . $item['qty_volume'] . ' ' . $item['qty_satuan'] . "</td>
                <td>" . $item['kualitas'] . "</td>
                <td>" . $item['wkt_lama'] . ' ' . $item['wkt_satuan'] . "</td>
                <td>" . $item['biaya'] . "</td>
                <td>Tersedia</td>
                <td>
                    <button class='btn btn-info btn-sm btn-edit' data-id='" . $item['id'] . "'>Edit</button>
                </td>
            </tr>";
        }
        // echo $row;
        echo json_encode([$row]);
        // echo json_encode(['row' => json_encode($kegiatan)]);
    }


    public function create()
    {
        $data = $this->input->post('data');
        $data = json_decode($data, true);
        if (isset($data['id'])) {
            $id = $data['id'];
            unset($data['id']);
            $this->db->where('id', $id);
            $updated = $this->db->update('skp_kegiatan', $data);
            if ($updated) {
                echo json_encode([
                    'status' => 'success',
                    'message' => 'updated successful'
                ]);
            }
        } else {
            $created = $this->db->insert('skp_kegiatan', $data);
            if ($created) {
                echo json_encode([
                    'status' => 'success',
                    'message' => 'created successful'
                ]);
            }
        }
    }
}
