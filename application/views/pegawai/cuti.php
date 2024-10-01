<!DOCTYPE html>
<html lang="en">

<head>
    <?php $this->load->view("pegawai/components/header.php") ?>
</head>

<body class="hold-transition sidebar-mini layout-fixed">

    <?php if ($this->session->flashdata('hapus')){ ?>
    <script>
    swal({
        title: "Success!",
        text: "Data Berhasil Dihapus!",
        icon: "success"
    });
    </script>
    <?php } ?>

    <?php if ($this->session->flashdata('eror_hapus')){ ?>
    <script>
    swal({
        title: "Error!",
        text: "Data Gagal Dihapus!",
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
        <?php $this->load->view("pegawai/components/navbar.php") ?>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <?php $this->load->view("pegawai/components/sidebar.php") ?>

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
                                    <h3 class="card-title">Data Cuti</h3>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama</th> <!-- Diambil dari tabel users -->
                                                <th>Jenis Cuti</th> <!-- Kolom baru -->
                                                <th>Alasan</th>
                                                <th>Tanggal Diajukan</th>
                                                <th>Tanggal Mulai</th>
                                                <th>Tanggal Berakhir</th>
                                                <th>Lama Cuti</th>
                                                <th>Status Cuti</th>
                                                <th>Alasan Verifikasi</th>
                                                <th>Cetak Surat</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $no = 0;
                                                foreach($cuti as $i) :
                                                    $no++;
                                                    // Ensure that the ID variables are correctly fetched
                                                    $id_cuti = isset($i['id_cuti']) ? $i['id_cuti'] : 'N/A'; 
                                                    $id_user = isset($i['id_user']) ? $i['id_user'] : 'N/A'; 
                                                    $nama_user = isset($i['nama_user']) ? $i['nama_user'] : 'N/A'; 
                                                    $jenis_cuti = isset($i['nama_jenis_cuti']) ? $i['nama_jenis_cuti'] : 'N/A';
                                                    $alasan = isset($i['alasan']) ? $i['alasan'] : 'N/A'; 
                                                    $tgl_diajukan = isset($i['tgl_diajukan']) ? date('d-m-Y', strtotime($i['tgl_diajukan'])) : 'N/A';
                                                    $mulai = isset($i['mulai']) ? date('d-m-Y', strtotime($i['mulai'])) : 'N/A';
                                                    $berakhir = isset($i['berakhir']) ? date('d-m-Y', strtotime($i['berakhir'])) : 'N/A';
                                                    $lama_cuti = isset($i['lama_cuti']) ? $i['lama_cuti'] : 'N/A'; 
                                                    $status = isset($i['status']) ? $i['status'] : 'N/A';
                                                    $status_cuti = ""; // Set status text
                                            ?>
                                            <tr>
                                                <td><?= $no ?></td>
                                                <td><?= $nama_user ?></td>
                                                <td><?= $jenis_cuti ?></td>
                                                <td><?= $alasan ?></td>
                                                <td><?= $tgl_diajukan ?></td>
                                                <td><?= $mulai ?></td>
                                                <td><?= $berakhir ?></td>
                                                <td><?= $lama_cuti ?> hari</td>
                                                <td><?= $status_cuti ?></td>
                                                <td><?= isset($i['alasan_verifikasi']) ? $i['alasan_verifikasi'] : 'N/A'; ?></td>
                                                <td>
                                                    <?php if ($status == 4) { ?>
                                                    <a href="<?= base_url('Cetak/surat_cuti_pdf/' . $id_cuti) ?>" target="_blank" class="btn btn-info">Cetak Surat</a>
                                                    <?php } else { ?>
                                                    <a href="#" class="btn btn-danger">Belum Dapat Mencetak</a>
                                                    <?php } ?>
                                                </td>
                                                <td>
                                                    <!-- Delete Button -->
                                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#hapusModal<?= $id_cuti ?>">
                                                        <i class="fas fa-trash"></i>
                                                    </button>

                                                    <!-- Delete Modal -->
                                                    <div class="modal fade" id="hapusModal<?= $id_cuti ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title">Hapus Data Cuti</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    Apakah kamu yakin ingin menghapus data ini?
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <form action="<?= base_url('Cuti/hapus_cuti/' . $id_cuti) ?>" method="POST">
                                                                        <input type="hidden" name="id_user" value="<?= $id_user ?>">
                                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                                        <button type="submit" class="btn btn-danger">Hapus</button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <?php endforeach; ?>
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
            <!-- Modal -->

        </div>
        <!-- /.content-wrapper -->


        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <?php $this->load->view("pegawai/components/js.php") ?>
</body>

</html>
