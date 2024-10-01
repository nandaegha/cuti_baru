<!DOCTYPE html>
<html lang="en">

<head>
    <?php $this->load->view("pegawai/components/header.php") ?>
</head>

<body class="hold-transition sidebar-mini layout-fixed">

    <?php if ($this->session->flashdata('input')) { ?>
    <script>
        swal({
            title: "Success!",
            text: "Data Berhasil Ditambahkan!",
            icon: "success"
        });
    </script>
    <?php } ?>

    <?php if ($this->session->flashdata('eror_input')) { ?>
    <script>
        swal({
            title: "Error!",
            text: "Data Gagal Ditambahkan!",
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
                            <h1 class="m-0">Form Permohonan Cuti</h1>
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

                    <form action="<?= base_url(); ?>Form_Cuti/proses_cuti" method="POST" enctype="multipart/form-data">
                        <input type="hidden" value="<?= $this->session->userdata('id_user') ?>" name="id_user">

                        <div class="form-group">
                            <label for="alasan">Alasan</label>
                            <textarea class="form-control" id="alasan" rows="3" name="alasan" required style="max-width: 500px; width: 100%;"></textarea>
                        </div>

                        <div class="form-group">
                            <label for="jenis_cuti">Jenis Cuti</label>
                            <select class="form-control" id="jenis_cuti" name="jenis_cuti" required style="max-width: 500px; width: 100%;">
                                <option value="" disabled selected>Pilih Jenis Cuti</option>
                                <option value="Cuti Tahunan">Cuti Tahunan</option>
                                <option value="Cuti Besar">Cuti Besar</option>
                                <option value="Cuti Sakit">Cuti Sakit</option>
                                <option value="Cuti Melahirkan">Cuti Melahirkan</option>
                                <option value="Cuti Karena Alasan Penting">Cuti Karena Alasan Penting</option>
                                <option value="Cuti Diluar Tanggungan Negara">Cuti Diluar Tanggungan Negara</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="mulai">Mulai Cuti</label>
                            <input type="date" class="form-control" id="mulai" name="mulai" required style="max-width: 500px; width: 100%;" onchange="calculateLeaveDuration()">
                        </div>

                        <div class="form-group">
                            <label for="berakhir">Berakhir Cuti</label>
                            <input type="date" class="form-control" id="berakhir" name="berakhir" required style="max-width: 500px; width: 100%;" onchange="calculateLeaveDuration()">
                        </div>

                        <div class="form-group">
                            <label for="lama_cuti">Lama Cuti (hari)</label>
                            <input type="text" class="form-control" id="lama_cuti" name="lama_cuti" readonly style="max-width: 500px; width: 100%;">
                        </div>

                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
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

    <?php $this->load->view("pegawai/components/js.php") ?>

    <!-- JavaScript for calculating the duration -->
    <script>
        function calculateLeaveDuration() {
            const mulai = document.getElementById('mulai').value;
            const berakhir = document.getElementById('berakhir').value;
            
            if (mulai && berakhir) {
                const startDate = new Date(mulai);
                const endDate = new Date(berakhir);
                const timeDiff = endDate - startDate;
                const dayDiff = Math.ceil(timeDiff / (1000 * 3600 * 24)) + 1; // Adding 1 to include the end date

                document.getElementById('lama_cuti').value = dayDiff;
            }
        }
    </script>
</body>

</html>