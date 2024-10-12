<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Link navbar sebelah kiri -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
    </ul>

    <!-- Link navbar sebelah kanan -->
    <ul class="navbar-nav ml-auto">
        <!-- Menu dropdown Notifikasi -->
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="far fa-user"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#exampleModal">Lengkapi Data</a>
                <a href="<?= base_url();?>Login/log_out" class="dropdown-item">Logout</a>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                <i class="fas fa-expand-arrows-alt"></i>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-widget="control-sidebar" data-controlsidebar-slide="true" href="#" role="button">
                <i class="fas fa-th-large"></i>
            </a>
        </li>
    </ul>
</nav>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Lengkapi Data Akun</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?php
                // Memastikan data pegawai untuk pengguna yang masuk tersedia
                if (!empty($pegawai_data)) {
                    $pegawai = $pegawai_data[0]; // Mengambil elemen pertama karena hanya ada satu pengguna yang masuk
                    ?>
                    <form action="<?= base_url();?>Settings/lengkapi_data" method="POST">
                        <input type="hidden" name="id_user" value="<?= $this->session->userdata('id_user'); ?>">

                            <div class="form-group">
                                <label for="nama">Nama</label>
                                <input type="text" class="form-control" id="nama" name="nama" value="<?= $users['nama']; ?>" required>
                            </div>

                            <div class="form-group">
                                <label for="jenis_kelamin">Jenis Kelamin</label>
                                <select class="form-control" id="jenis_kelamin" name="jenis_kelamin" required>
                                    <option value="L" <?= $pegawai['jenis_kelamin'] == 'L' ? 'selected' : ''; ?>>Laki-laki</option>
                                    <option value="P" <?= $pegawai['jenis_kelamin'] == 'P' ? 'selected' : ''; ?>>Perempuan</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="telepon">No HP</label>
                                <input type="text" class="form-control" id="telepon" name="telepon" value="<?= $pegawai['telepon']; ?>" required>
                            </div>

                            <div class="form-group">
                                <label for="nip">NIP</label>
                                <input type="text" class="form-control" id="nip" name="nip" value="<?= $pegawai['nip']; ?>" required>
                            </div>

                            <div class="form-group">
                                <label for="status_pegawai">Status Pegawai</label>
                                <input type="text" class="form-control" id="status_pegawai" name="status_pegawai" value="<?= $pegawai['status_pegawai']; ?>" required>
                            </div>

                            <div class="form-group">
                                <label for="id_jabatan">Jabatan</label>
                                <select class="form-control" id="id_jabatan" name="id_jabatan" required>
                                    <?php foreach($jabatan as $j): ?>
                                        <option value="<?= $j['id_jabatan']; ?>" <?= $pegawai['id_jabatan'] == $j['id_jabatan'] ? 'selected' : ''; ?>>
                                            <?= $j['nama_jabatan']; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="id_ruangan">Ruangan</label>
                                <select class="form-control" id="id_ruangan" name="id_ruangan" required>
                                    <?php foreach($ruangan as $r): ?>
                                        <option value="<?= $r['id_ruangan']; ?>" <?= $pegawai['id_ruangan'] == $r['id_ruangan'] ? 'selected' : ''; ?>>
                                            <?= $r['nama_ruangan']; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="alamat">Alamat</label>
                                <textarea class="form-control" id="alamat" rows="3" name="alamat" required><?= $pegawai['alamat']; ?></textarea>
                            </div>

                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                <?php } else { ?>
                    <p>Tidak ada data pegawai ditemukan.</p>
                <?php } ?>
            </div>
        </div>
    </div>
</div>