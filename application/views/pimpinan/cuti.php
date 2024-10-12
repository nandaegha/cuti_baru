<!DOCTYPE html>
<html lang="en">

<head>
    <?php $this->load->view("pimpinan/components/header.php") ?>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <?php if ($this->session->flashdata('input')) { ?>
    <script>
        swal({
            title: "Success!",
            text: "Status Cuti Berhasil Diubah!",
            icon: "success"
        });
    </script>
    <?php } ?>

    <?php if ($this->session->flashdata('eror_input')) { ?>
    <script>
        swal({
            title: "Error!",
            text: "Status Cuti Gagal Diubah!",
            icon: "error"
        });
    </script>
    <?php } ?>

    <div class="wrapper">

        <!-- Preloader -->
        <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__shake" src="<?= base_url();?>assets/admin_lte/dist/img/Loading.png"
                alt="AdminLTELogo" height="60" width="60">
        </div>

        <!-- Navbar -->
        <?php $this->load->view("pimpinan/components/navbar.php") ?>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <?php $this->load->view("pimpinan/components/sidebar.php") ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Cuti</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">Cuti</li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">

                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Data Cuti Pegawai</h3>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama</th>
                                                <th>Alasan</th>
                                                <th>Tanggal Diajukan</th>
                                                <th>Mulai</th>
                                                <th>Berakhir</th>
                                                <th>Jenis Cuti</th>
                                                <th>Alasan Verifikasi</th>
                                                <th>Status Cuti</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $no = 0;
                                            foreach ($cuti as $i) {
                                                $no++;
                                                $id_cuti = $i['id_cuti'];
                                                $id_user = $i['id_user'];
                                                $nama = $i['nama'];
                                                $alasan = $i['alasan'];
                                                $tgl_diajukan = $i['tgl_diajukan'];
                                                $mulai = $i['mulai'];
                                                $berakhir = $i['berakhir'];
                                                $id_status_cuti = $i['id_status_cuti'];
                                                $alasan_verifikasi = $i['alasan_verifikasi'];
                                                $jenis_cuti = $i['jenis_cuti'];
                                            ?>
                                            <tr>
                                                <td><?= $no ?></td>
                                                <td><?= $nama ?></td>
                                                <td><?= $alasan ?></td>
                                                <td><?= $tgl_diajukan ?></td>
                                                <td><?= $mulai ?></td>
                                                <td><?= $berakhir ?></td>
                                                <td><?= $jenis_cuti ?></td>
                                                <td>
                                                    <?= $alasan_verifikasi ? $alasan_verifikasi : '<span class="text-danger">Belum Ada</span>' ?>
                                                </td>
                                                <td>
                                                    <?php 
                                                    switch ($id_status_cuti) {
                                                        case 1:
                                                            echo '<span class="badge badge-warning">Menunggu Konfirmasi</span>';
                                                            break;
                                                        case 2:
                                                            echo '<span class="badge badge-success">Izin Cuti Diterima</span>';
                                                            break;
                                                        case 3:
                                                            echo '<span class="badge badge-danger">Izin Cuti Ditolak</span>';
                                                            break;
                                                    }
                                                    ?>
                                                </td>
                                                <td>
                                                    <a href="" class="btn btn-primary" data-toggle="modal"
                                                       data-target="#setuju<?= $id_cuti ?>">
                                                       <i class="fas fa-check"></i> Setujui
                                                    </a>
                                                    <a href="" data-toggle="modal"
                                                       data-target="#tidak_setuju<?= $id_cuti ?>"
                                                       class="btn btn-danger"><i class="fas fa-times"></i> Tolak
                                                    </a>
                                                </td>
                                            </tr>

                                            <!-- Modal Setuju Cuti -->
                                            <div class="modal fade" id="setuju<?= $id_cuti ?>" tabindex="-1"
                                                 aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Setujui Data Cuti</h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                    aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>

                                                        <div class="modal-body">
                                                            <form action="<?= base_url() ?>Cuti/acc_cuti_pimpinan/2" method="post">
                                                                <input type="hidden" name="id_cuti" value="<?= $id_cuti ?>" />
                                                                <input type="hidden" name="id_user" value="<?= $id_user ?>" />
                                                                <p>Apakah kamu yakin ingin Menyetujui Izin Cuti ini?</p>
                                                                <div class="form-group">
                                                                    <label for="alasan_verifikasi">Alasan</label>
                                                                    <textarea class="form-control" id="alasan_verifikasi" name="alasan_verifikasi" rows="3" required></textarea>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Tidak</button>
                                                                    <button type="submit" class="btn btn-success">Ya</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Modal Tolak Cuti -->
                                            <div class="modal fade" id="tidak_setuju<?= $id_cuti ?>" tabindex="-1"
                                                 aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Tolak Data Cuti</h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                    aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>

                                                        <div class="modal-body">
                                                            <form action="<?= base_url() ?>Cuti/acc_cuti_pimpinan/3" method="post">
                                                                <input type="hidden" name="id_cuti" value="<?= $id_cuti ?>" />
                                                                <input type="hidden" name="id_user" value="<?= $id_user ?>" />
                                                                <p>Apakah kamu yakin ingin Menolak Izin Cuti ini?</p>
                                                                <div class="form-group">
                                                                    <label for="alasan_verifikasi">Alasan</label>
                                                                    <textarea class="form-control" id="alasan_verifikasi" name="alasan_verifikasi" rows="3" required></textarea>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Tidak</button>
                                                                    <button type="submit" class="btn btn-success">Ya</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        </div>
                        <!-- /.col -->
                    </div>

                </div><!-- /.container-fluid -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <?php $this->load->view("pimpinan/components/js.php") ?>
</body>

</html>
