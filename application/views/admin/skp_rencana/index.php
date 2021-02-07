<br /><br /><br />
<?= $this->session->flashdata('pesan') ?>
<table id="example1" class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>Tahun</th>
            <th>Periode Awal</th>
            <th>Periode Akhir</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($data as $item) : ?>
            <tr>
                <td><?= $item['tahun'] ?></td>
                <td><?= $item['periode_awal'] ?></td>
                <td><?= $item['periode_akhir'] ?></td>
                <td><?= $item['status'] ?></td>
                <td>
                    <?php if (!$rencana) : ?>
                        <a href="<?= base_url("admin/skp_kegiatan_realisasi/" . $item['id']) ?>" class="btn btn-info btn-sm">Kegiatan</a>
                        <a href="<?= base_url("excel/skp_realisasi/" . $item['id']) ?>" class="btn btn-danger btn-sm">Print XLS</a>
                        <a href="<?= base_url("admin/pengajuan_skp/" . $item['id']) ?>" class="btn btn-warning btn-sm">Ajukan</a>
                    <?php else : ?>
                        <a href="<?= base_url("admin/skp_kegiatan/" . $item['id']) ?>" class="btn btn-info btn-sm">Kegiatan</a>
                        <a href="<?= base_url("excel/skp_rencana/" . $item['id']) ?>" class="btn btn-danger btn-sm">Print XLS</a>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<script>



</script>