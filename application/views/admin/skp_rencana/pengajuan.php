<form action="" method="post">
    <table class="table">
        <input type="hidden" name="id" value="<?= $skp_id; ?>">
        <tr>
            <th>Pejabat Penilai</th>
            <td>
                <select class="form-control" name="pejabat_id" required>
                    <option>-</option>
                    <?php foreach ($pegawai as $item) : ?>
                        <option value="<?= $item['id_pegawai'] ?>" <?= ($skp['pejabat_id'] == $item['id_pegawai']) ? 'selected' : ''; ?>><?= $item['nama'] ?></option>
                    <?php endforeach; ?>
                </select>
            </td>
        </tr>
        <tr>
            <th>Atasan Pejabat Penilai</th>
            <td>
                <select class="form-control" name="atasan_id" required>
                    <option>-</option>
                    <?php foreach ($pegawai as $item) : ?>
                        <option value="<?= $item['id_pegawai'] ?>" <?= ($skp['atasan_id'] == $item['id_pegawai']) ? 'selected' : ''; ?>><?= $item['nama'] ?></option>
                    <?php endforeach; ?>
                </select>
            </td>
        </tr>
        <tr>
            <td></td>
            <td>
                <button type="submit" class="btn btn-primary btn-simpan" onclick="return check()" name="simpan">Ajukan Online</button>
                <a href="<?= base_url('admin/skp_realisasi'); ?>" class="btn btn-danger">Batalkan</a>
            </td>
        </tr>
    </table>
</form>

<script>
    function check() {
        const _pejabat = document.querySelector('select[name=pejabat_id]')
        const _atasan = document.querySelector('select[name=atasan_id]')

        if (_pejabat.value === '-' || _atasan.value === '-') {
            alert('Harus diisikan keduanya');
            return false;
        }

        if (_pejabat.value === _atasan.value) {
            alert('Pejabat penilai dan Atasan Pejabat penilai tidak boleh sama');
            return false;
        }
        return true;
    }
</script>