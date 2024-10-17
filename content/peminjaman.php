<?php
$query = mysqli_query($koneksi, "SELECT anggota.nama_anggota, peminjaman.*
 FROM peminjaman LEFT JOIN anggota ON anggota.id = peminjaman.id_anggota  ORDER BY id DESC");
?>
<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <fieldset class="border border-black border-2 p-3">
                <legend class="float-none w-auto px-3">Data Peminjaman</legend>
                <div align="right">
                    <a href="?pg=tambah-peminjaman" class="btn btn-primary">Tambah</a>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover mt-3">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Anggota</th>
                                <th>No Peminjaman</th>
                                <th>Tanggal Peminjaman</th>
                                <th>Tanggal Pengembalian</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            while ($row = mysqli_fetch_assoc($query)):
                            ?>
                                <tr>
                                    <td><?php echo $no++ ?></td>
                                    <td><?php echo $row['nama_anggota'] ?></td>
                                    <td><?php echo $row['no_peminjaman'] ?></td>
                                    <td><?php echo $row['tgl_peminjaman'] ?></td>
                                    <td><?php echo $row['tgl_pengembalian'] ?></td>
                                    <td><?php echo $row['status'] ?></td>
                                    <td>
                                        <a id="edit-user" data-id="<?php echo $row['id'] ?>" href="?pg=tambah-peminjaman&detail=<?php echo $row['id'] ?>"
                                            class="btn btn-success btn-sm">Detail

                                        </a> |
                                        <a
                                            href="?pg=tambah-peminjaman&delete=<?php echo $row['id'] ?>"
                                            class="btn btn-danger btn-sm"
                                            onclick="return confirm('Apakah anda yakin akan menghapus data ini??')">Delete</a>
                                    </td>
                                </tr>
                            <?php endwhile ?>
                        </tbody>
                    </table>
                </div>
            </fieldset>
        </div>
    </div>
</div>