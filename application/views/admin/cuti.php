<!DOCTYPE html>
<html lang="en">

<head>
    <?php $this->load->view("admin/components/header.php") ?>
</head>

<body class="hold-transition sidebar-mini layout-fixed">

    <?php if ($this->session->flashdata('edit')){ ?>
    <script>
    swal({
        title: "Success!",
        text: "Data Berhasil Diedit!",
        icon: "success"
    });
    </script>
    <?php } ?>

    <?php if ($this->session->flashdata('eror_edit')){ ?>
    <script>
    swal({
        title: "Error!",
        text: "Data Gagal Diedit!",
        icon: "error"
    });
    </script>
    <?php } ?>

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

    <?php if ($this->session->flashdata('input')){ ?>
    <script>
    swal({
        title: "Success!",
        text: "Status Cuti Berhasil Diubah!",
        icon: "success"
    });
    </script>
    <?php } ?>

    <?php if ($this->session->flashdata('eror_input')){ ?>
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
        <?php $this->load->view("admin/components/navbar.php") ?>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <?php $this->load->view("admin/components/sidebar.php") ?>

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
                                                <th>Jenis Kelamin</th>
                                                <th>Jenis Cuti</th>
                                                <th>Tanggal Diajukan</th>
                                                <th>Mulai</th>
                                                <th>Berakhir</th>
                                                <th>Status</th>
                                                <th>Cetak Surat</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $no = 0;
                                            foreach($cuti as $i):
                                                $no++;
                                                $id_cuti = $i['id_cuti'];
                                                $id_user = $i['id_user'];
                                                $nama = $i['nama'];
                                                $jenis_kelamin = $i['jenis_kelamin']; // Diambil langsung dari tabel pegawai
                                                $jenis_cuti = $i['jenis_cuti']; // Menggantikan perihal_cuti
                                                $tgl_diajukan = $i['tgl_diajukan'];
                                                $mulai = $i['mulai'];
                                                $berakhir = $i['berakhir'];
                                                $status = $i['status']; // Menggantikan id_status_cuti
                                            ?>
                                            <tr>
                                                <td><?= $no ?></td>
                                                <td><?= $nama ?></td>
                                                <td><?= $jenis_kelamin ?></td>
                                                <td><?= $jenis_cuti ?></td>
                                                <td><?= $tgl_diajukan ?></td>
                                                <td><?= $mulai ?></td>
                                                <td><?= $berakhir ?></td>
                                                <td>
                                                    <?php if ($status == 'Menunggu Konfirmasi') { ?>
                                                    <div class="table-responsive">
                                                        <a href="" class="btn btn-info" data-toggle="modal"
                                                            data-target="#edit_data_pegawai">
                                                            Menunggu Konfirmasi
                                                        </a>
                                                    </div>
                                                    <?php } elseif ($status == 'Diterima') { ?>
                                                    <div class="table-responsive">
                                                        <a href="" class="btn btn-success" data-toggle="modal"
                                                            data-target="#edit_data_pegawai">
                                                            Izin Cuti Diterima
                                                        </a>
                                                    </div>
                                                    <?php } elseif ($status == 'Ditolak') { ?>
                                                    <div class="table-responsive">
                                                        <a href="" class="btn btn-danger" data-toggle="modal"
                                                            data-target="#edit_data_pegawai">
                                                            Izin Cuti Ditolak
                                                        </a>
                                                    </div>
                                                    <?php } ?>
                                                </td>
                                                <td>
                                                    <?php if ($status == 'Diterima') { ?>
                                                    <a href="<?= base_url();?>Cetak/surat_cuti_pdf/<?=$id_cuti?>"
                                                        class="btn btn-info" target="_blank">
                                                        Cetak Surat
                                                    </a>
                                                    <?php } else { ?>
                                                    <a href="#" class="btn btn-danger">Belum Dapat Mencetak</a>
                                                    <?php } ?>
                                                </td>
                                                <td>
                                                    <a href="" class="btn btn-primary" data-toggle="modal"
                                                        data-target="#edit<?= $id_cuti ?>">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <a href="" data-toggle="modal" data-target="#hapus<?= $id_cuti ?>"
                                                        class="btn btn-danger">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                </td>
                                            </tr>

                                            <!-- Modal Edit Cuti -->
                                            <div class="modal fade" id="edit<?= $id_cuti ?>" tabindex="-1"
                                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Edit Data
                                                                Cuti
                                                            </h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>

                                                        <div class="modal-body">
                                                            <form action="<?=base_url();?>Cuti/edit_cuti_admin"
                                                                method="POST">
                                                                <input type="text" value="<?=$id_cuti?>" name="id_cuti"
                                                                    hidden>
                                                                <div class="form-group">
                                                                    <label for="alasan">Alasan</label>
                                                                    <textarea class="form-control" id="alasan" rows="3"
                                                                        name="alasan" required><?=$i['alasan']?></textarea>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="jenis_cuti">Jenis Cuti</label>
                                                                    <input type="text" class="form-control"
                                                                        id="jenis_cuti"
                                                                        name="jenis_cuti" value="<?=$jenis_cuti?>"
                                                                        required>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="tgl_diajukan">Tanggal Diajukan</label>
                                                                    <input type="date" class="form-control"
                                                                        id="tgl_diajukan"
                                                                        name="tgl_diajukan" value="<?=$tgl_diajukan?>"
                                                                        required>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="mulai">Mulai</label>
                                                                    <input type="date" class="form-control" id="mulai"
                                                                        name="mulai" value="<?=$mulai?>" required>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="berakhir">Berakhir</label>
                                                                    <input type="date" class="form-control"
                                                                        id="berakhir" name="berakhir"
                                                                        value="<?=$berakhir?>" required>
                                                                </div>

                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-dismiss="modal">Close</button>
                                                                    <button type="submit"
                                                                        class="btn btn-primary">Save
                                                                        changes</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Modal Hapus Cuti -->
                                            <div class="modal fade" id="hapus<?= $id_cuti ?>" tabindex="-1"
                                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Hapus Data
                                                                Cuti</h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            Apakah anda yakin ingin menghapus data cuti ini?
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-dismiss="modal">Close</button>
                                                            <a href="<?= base_url();?>Cuti/hapus_cuti_admin/<?=$id_cuti?>"
                                                                class="btn btn-danger">Hapus</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

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
                    <!-- /.row -->
                </div>
                <!-- /.container-fluid -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        <?php $this->load->view("admin/components/footer.php") ?>

    </div>
    <!-- ./wrapper -->

    <?php $this->load->view("admin/components/js.php") ?>

</body>

</html>