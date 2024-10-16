<?php
$buku = mysqli_query($koneksi, "SELECT kategori.nama_kategori, buku.*
 FROM buku LEFT JOIN kategori ON kategori.id = buku.id_kategori  ORDER BY id DESC");
?>
<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <fieldset class="border border-black border-2 p-3">
                <legend class="float-none w-auto px-3">Data Buku</legend>
                <div align="right">
                    <a href="?pg=tambah-buku" class="btn btn-primary">Tambah</a>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover mt-3">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Kategori</th>
                                <th>Nama Buku</th>
                                <th>Penerbit</th>
                                <th>Tahun Terbit</th>
                                <th>Pengarang</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            while ($row = mysqli_fetch_assoc($buku)):
                            ?>
                                <tr>
                                    <td><?php echo $no++ ?></td>
                                    <td><?php echo $row['nama_kategori'] ?></td>
                                    <td><?php echo $row['nama_buku'] ?></td>
                                    <td><?php echo $row['penerbit'] ?></td>
                                    <td><?php echo $row['tahun_terbit'] ?></td>
                                    <td><?php echo $row['pengarang'] ?></td>
                                    <td>
                                        <a id="edit-user" data-id="<?php echo $row['id'] ?>" href="?pg=tambah-buku&edit=<?php echo $row['id'] ?>"
                                            class="btn btn-success btn-sm">Edit

                                        </a> |
                                        <a
                                            href="?pg=tambah-buku&delete=<?php echo $row['id'] ?>"
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