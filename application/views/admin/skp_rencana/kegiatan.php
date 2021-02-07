<br /><br /><br />
<?= $this->session->flashdata('pesan') ?>
<table id="example1" class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>Nama Kegiatan</th>
            <th>Sat. Keg.</th>
            <th>AK.</th>
            <th>Kuantitas</th>
            <th>%</th>
            <th>Waktu</th>
            <th>Biaya</th>
            <th>Status</th>
            <th>Nilai</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($data as $item) : ?>
            <tr>
                <td><?= $item['kegiatan'] ?></td>
                <td>0</td>
                <td>0</td>
                <td><?= $item['qty_volume'] . ' ' . $item['qty_satuan'] ?></td>
                <td><?= $item['kualitas'] ?></td>
                <td><?= $item['wkt_lama'] . ' ' . $item['wkt_satuan'] ?></td>
                <td><?= $item['biaya'] ?></td>
                <td>Tersedia</td>
                <td>
                    <?php if ($rencana) : ?>
                        <button class="btn btn-info btn-sm btn-edit" data-id="<?= $item['id'] ?>">Edit</button>
                    <?php else : ?>
                        <?php if ($item['nilai']) : ?>
                            <?= $item['nilai'] ?>
                        <?php else : ?>
                            <button class="btn btn-info btn-sm btn-nilai" data-id="<?= $item['id'] ?>">Nilai</button>
                        <?php endif; ?>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php if ($rencana) : ?>
    <table class="table">
        <input type="hidden" id="id">
        <tr>
            <td colspan="2">
                <div class="alert alert-warning mt-4" style="margin-top: 50px;" role="alert">
                    Menambahkan Data Kegiatan
                </div>
            </td>
        </tr>
        <tr>
            <th>Nama Kegiatan</th>
            <td>
                <input type="text" class="form-control" id="kegiatan" placeholder="Kegiatan">
            </td>
        </tr>
        <tr>
            <th>Kuantitas Volume</th>
            <td>
                <input type="text" class="form-control" id="qty_volume" placeholder="Kuantitas Volume">
            </td>
        </tr>
        <tr>
            <th>Kuantitas Satuan</th>
            <td>
                <input type="text" class="form-control" id="qty_satuan" placeholder="Kuantitas Satuan">
            </td>
        </tr>
        <tr>
            <th>Kualitas (%)</th>
            <td>
                <input type="text" class="form-control" id="kualitas" placeholder="Kualitas">
            </td>
        </tr>
        <tr>
            <th>Waktu Lama</th>
            <td>
                <input type="text" class="form-control" id="wkt_lama" placeholder="Waktu Lama">
            </td>
        </tr>
        <tr>
            <th>Waktu Satuan</th>
            <td>
                <input type="text" class="form-control" id="wkt_satuan" placeholder="Waktu Satuan">
            </td>
        </tr>
        <tr>
            <th>Biaya</th>
            <td>
                <input type="text" class="form-control" id="biaya" placeholder="Biaya">
            </td>
        </tr>
        <tr>
            <td></td>
            <td>
                <button type="submit" class="btn btn-primary btn-simpan">Simpan Data</button>
            </td>
        </tr>
    </table>

    <script>
        const _id = document.querySelector('#id');
        const _kegiatan = document.querySelector('#kegiatan');
        const _qtyVolume = document.querySelector('#qty_volume');
        const _qtySatuan = document.querySelector('#qty_satuan');
        const _kualitas = document.querySelector('#kualitas');
        const _wktLama = document.querySelector('#wkt_lama');
        const _wktSatuan = document.querySelector('#wkt_satuan');
        const _biaya = document.querySelector('#biaya');

        const path = location.pathname.split('/');
        const skp_id = path[path.length - 1];

        const parseUrl = (endpoint) => `${location.protocol}//${location.host}/ajax/${endpoint}`;

        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('btn-edit')) {
                const kegiatanId = e.target.dataset.id;
                console.log(kegiatanId);
                fetch(parseUrl(`get_kegiatan/${kegiatanId}`))
                    .then(data => data.json())
                    .then(data => {
                        _id.value = data.id
                        _kegiatan.value = data.kegiatan
                        _qtyVolume.value = data.qty_volume
                        _qtySatuan.value = data.qty_satuan
                        _kualitas.value = data.kualitas
                        _wktLama.value = data.wkt_lama
                        _wktSatuan.value = data.wkt_satuan
                        _biaya.value = data.biaya
                    });
            }

            if (e.target.classList.contains('btn-simpan')) {

                const id = _id.value
                const kegiatan = _kegiatan.value
                const qty_volume = _qtyVolume.value
                const qty_satuan = _qtySatuan.value
                const kualitas = _kualitas.value
                const wkt_lama = _wktLama.value
                const wkt_satuan = _wktSatuan.value
                const biaya = _biaya.value

                const obj = {
                    kegiatan,
                    qty_volume,
                    qty_satuan,
                    kualitas,
                    wkt_lama,
                    wkt_satuan,
                    biaya,
                    skp_id
                };

                if (id) {
                    obj.id = id;
                }

                const data = new FormData();
                data.append('data', JSON.stringify(obj));

                fetch(parseUrl(`create`), {
                    method: 'POST',
                    body: data
                }).then(item => item.json()).then(item => {
                    console.log(item)
                    fetch(parseUrl(`get_kegiatan_table/${skp_id}`)).then(el => el.json()).then(el => {
                        document.querySelector('tbody').innerHTML = el;
                        // console.log(el);
                    })
                });

                clearInput();

            }
        });

        function clearInput() {
            const _input = document.querySelectorAll('input');
            _input.forEach(element => {
                element.value = '';
            });
        }
    </script>

<?php else : ?>
    <script>
        const parseUrl = (endpoint) => `${location.protocol}//${location.host}/ajax/${endpoint}`;

        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('btn-nilai')) {
                const id = parseInt(e.target.dataset.id);
                const nilai = parseFloat(prompt('Berikan penilaian'));

                const obj = {
                    id,
                    nilai
                };

                const data = new FormData();
                data.append('data', JSON.stringify(obj));
                fetch(parseUrl(`create`), {
                    method: 'POST',
                    body: data
                }).then(item => item.json()).then(item => {
                    console.log(item);
                    e.target.outerHTML = nilai;
                })
            }
        });
    </script>
<?php endif; ?>