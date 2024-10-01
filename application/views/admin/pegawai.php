<!DOCTYPE html>
<html lang="en">

<head>
    <?php $this->load->view("admin/components/header.php") ?>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <!-- Flashdata Success/Error Messages -->
    <?php if ($this->session->flashdata('input')){ ?>
    <script>
    swal({
        title: "Success!",
        text: "Data Berhasil Ditambahkan!",
        icon: "success"
    });
    </script>
    <?php } ?>
    <?php if ($this->session->flashdata('eror')){ ?>
    <script>
    swal({
        title: "Error!",
        text: "Data Gagal Ditambahkan!",
        icon: "error"
    });
    </script>
    <?php } ?>
    <!-- Add other flashdata notifications here -->

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
                            <h1 class="m-0">Pegawai</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">Pegawai</li>
                            </ol>
                        </div><!-- /.col -->

                        <button type="button" class="btn btn-primary mt-3" data-toggle="modal"
                            data-target="#exampleModal">
                            Tambah Pegawai
                        </button>
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
                                    <h3 class="card-title">Data Pegawai</h3>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Username</th>
                                                <th>Nama</th> <!-- Sesuaikan Nama -->
                                                <th>Jenis Kelamin</th> <!-- Sesuaikan dengan Tabel Pegawai -->
                                                <th>No Telp</th>
                                                <th>Alamat</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $no = 0;
                                            foreach($pegawai as $i):
                                                $no++;
                                                $id_user = $i['id_user'];
                                                $username = $i['username'];
                                                $password = $i['password'];
                                                $email = $i['email'];
                                                $nama = $i['nama']; // Sesuaikan Nama
                                                $jenis_kelamin = $i['jenis_kelamin']; // Ambil langsung dari tabel pegawai
                                                $no_telp = $i['no_telp'];
                                                $alamat = $i['alamat'];
                                            ?>
                                            <tr>
                                                <td><?= $no ?></td>
                                                <td><?= $username ?></td>
                                                <td><?= $nama ?></td>
                                                <td><?= $jenis_kelamin ?></td>
                                                <td><?= $no_telp ?></td>
                                                <td><?= $alamat ?></td>
                                                <td>
                                                    <div class="table-responsive">
                                                        <a href="" class="btn btn-primary" data-toggle="modal"
                                                            data-target="#edit_data_pegawai<?=$id_user?>">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <a href="" data-toggle="modal"
                                                            data-target="#hapus<?=$id_user?>"
                                                            class="btn btn-danger">
                                                            <i class="fas fa-trash"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>

                                            <!-- Modal Hapus Data Pegawai -->
                                            <div class="modal fade" id="hapus<?= $id_user ?>" tabindex="-1"
                                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Hapus Data Pegawai</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action="<?= base_url() ?>Pegawai/hapus_pegawai"
                                                                method="post">
                                                                <input type="hidden" name="id_user" value="<?= $id_user ?>" />
                                                                <p>Apakah kamu yakin ingin menghapus data ini?</p>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Tidak</button>
                                                                    <button type="submit" class="btn btn-success">Ya</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Modal Edit Pegawai -->
                                            <div class="modal fade" id="edit_data_pegawai<?= $id_user ?>" tabindex="-1"
                                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Edit Pegawai</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action="<?= base_url() ?>Pegawai/edit_pegawai" method="POST">
                                                                <input type="hidden" name="id_user" value="<?= $id_user ?>" />
                                                                <div class="form-group">
                                                                    <label for="username">Username</label>
                                                                    <input type="text" class="form-control" id="username" name="username" value="<?= $username ?>" required>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="password">Password</label>
                                                                    <input type="text" class="form-control" id="password" name="password" value="<?= $password ?>" required>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="email">Email</label>
                                                                    <input type="text" class="form-control" id="email" name="email" value="<?= $email ?>" required>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="nama">Nama</label>
                                                                    <input type="text" class="form-control" id="nama" name="nama" value="<?= $nama ?>" required>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="jenis_kelamin">Jenis Kelamin</label>
                                                                    <select class="form-control" id="jenis_kelamin" name="jenis_kelamin" required>
                                                                        <?php foreach($jenis_kelamin_p as $u): ?>
                                                                            <option value="<?= $u['jenis_kelamin'] ?>" <?= ($u['jenis_kelamin'] == $jenis_kelamin) ? 'selected' : '' ?>><?= $u['jenis_kelamin'] ?></option>
                                                                        <?php endforeach ?>
                                                                    </select>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="no_telp">No Telp</label>
                                                                    <input type="text" class="form-control" id="no_telp" name="no_telp" value="<?= $no_telp ?>" required>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="alamat">Alamat</label>
                                                                    <input type="text" class="form-control" id="alamat" name="alamat" value="<?= $alamat ?>" required>
                                                                </div>
                                                                <button type="submit" class="btn btn-primary">Submit</button>
                                                            </form>
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
                    </div>
                </div><!-- /.container-fluid -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        <?php $this->load->view("admin/components/footer.php") ?>
    </div>
    <!-- ./wrapper -->
</body>
</html>