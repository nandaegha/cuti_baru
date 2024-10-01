<?php
// Koneksi ke database
$conn = new mysqli("localhost", "root", "", "db_cuti");

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Fungsi untuk mengekspor data ke file Excel
if (isset($_POST['export_excel'])) {
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment; filename="rekap_cuti_pegawai.xls"');

    $sql = "SELECT * FROM cuti";
    $result = $conn->query($sql);

    echo "ID\tNama\tTanggal Mulai\tTanggal Selesai\tAlasan\n";

    while ($row = $result->fetch_assoc()) {
        echo $row['id'] . "\t" . $row['nama'] . "\t" . $row['tanggal_mulai'] . "\t" . $row['tanggal_selesai'] . "\t" . $row['alasan'] . "\n";
    }

    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php $this->load->view("admin/components/header.php") ?>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <?php $this->load->view("admin/components/navbar.php") ?>
        <?php $this->load->view("admin/components/sidebar.php") ?>

        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Rekap Cuti Pegawai</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">Rekap Cuti</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-header">
                <h3 class="card-title">Data Cuti Pegawai</h3>
                <form method="POST" action="">
                    <button type="submit" name="export_excel" class="btn btn-success float-right">
                        Export ke Excel
                    </button>
                </form>
            </div>

            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Data Rekap Cuti Pegawai</h3>
                                </div>
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
                                                <th>Lama Cuti</th>
                                                <th>Jenis Cuti</th>
                                                <th>Status</th>
                                                <th>Sisa Cuti</th>
                                                <th>Cetak Surat</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $no = 0;
                                            foreach($cuti as $i) {
                                                $no++;
                                                $id_cuti = $i['id_cuti'];
                                                $nama = $i['nama'];
                                                $alasan = $i['alasan'];
                                                $tgl_diajukan = $i['tgl_diajukan'];
                                                $mulai = $i['mulai'];
                                                $berakhir = $i['berakhir'];
                                                $jenis_cuti = $i['jenis_cuti'];
                                                $status = $i['status'];
                                                $sisa_cuti = $i['sisa_cuti'];

                                                // Menghitung lama cuti
                                                $lama_cuti = (strtotime($berakhir) - strtotime($mulai)) / (60 * 60 * 24) + 1; // ditambah 1 untuk menghitung hari pertama
                                            ?>
                                            <tr>
                                                <td><?= $no ?></td>
                                                <td><?= $nama ?></td>
                                                <td><?= $alasan ?></td>
                                                <td><?= $tgl_diajukan ?></td>
                                                <td><?= $mulai ?></td>
                                                <td><?= $berakhir ?></td>
                                                <td><?= $lama_cuti ?> hari</td>
                                                <td><?= $jenis_cuti ?></td>
                                                <td>
                                                    <?php if($status == 1) { ?>
                                                        <span class="badge badge-warning">Menunggu Konfirmasi</span>
                                                    <?php } elseif($status == 2) { ?>
                                                        <span class="badge badge-success">Izin Cuti Diterima</span>
                                                    <?php } elseif($status == 3) { ?>
                                                        <span class="badge badge-danger">Izin Cuti Ditolak</span>
                                                    <?php } ?>
                                                </td>
                                                <td><?= $sisa_cuti ?> hari</td>
                                                <td>
                                                    <?php if($status == 2) { ?>
                                                        <a href="<?= base_url();?>Cetak/surat_cuti_pdf/<?= $id_cuti ?>" class="btn btn-info" target="_blank">Cetak Surat</a>
                                                    <?php } else { ?>
                                                        <span class="btn btn-danger">Belum Dapat Mencetak</span>
                                                    <?php } ?>
                                                </td>
                                                <td>
                                                    <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#edit<?= $id_cuti ?>"><i class="fas fa-edit"></i></a>
                                                    <a href="#" class="btn btn-danger" data-toggle="modal" data-target="#hapus<?= $id_cuti ?>"><i class="fas fa-trash"></i></a>
                                                </td>
                                            </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <aside class="control-sidebar control-sidebar-dark"></aside>
    </div>
    <?php $this->load->view("admin/components/js.php") ?>
</body>

</html>