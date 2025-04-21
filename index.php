<?php include 'koneksi.php'; include 'header.php'; ?>

<!-- Form Pencarian -->
<form method="GET" class="mb-4">
    <div class="input-group">
        <input type="text" name="cari" class="form-control" placeholder="Cari nama barang..." value="<?= isset($_GET['cari']) ? htmlspecialchars($_GET['cari']) : '' ?>">
        <button type="submit" class="btn btn-primary">Search</button>
    </div>
</form>

    <h3 align= center> DAFTAR BARANG 🧾</h3>
    
    <a href="export_pdf.php" class="btn btn-success mb-3">Export ke PDF</a>

<table class="table table-bordered table-striped">
    <thead class="table-light text-center">
        <tr>
            <th>ID</th>
            <th>🛒 Nama Produk</th>
            <th>🏷️ Kategori</th>
            <th>📦 Stok Tersedia</th>
            <th>💸 Harga Satuan</th>
            <th>🗓️ Tanggal Masuk</th>
            <th>🛠️ Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php
        // Jika ada pencarian
        if (isset($_GET['cari']) && $_GET['cari'] != '') {
            $cari = $koneksi->real_escape_string($_GET['cari']);
            $sql = "SELECT barang.*, kategori.nama_kategori FROM barang 
                    JOIN kategori ON barang.id_kategori = kategori.id_kategori
                    WHERE barang.nama_barang LIKE '%$cari%'";
        } else {
            $sql = "SELECT barang.*, kategori.nama_kategori FROM barang 
                    JOIN kategori ON barang.id_kategori = kategori.id_kategori";
        }

        $result = $koneksi->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['id_barang']}</td>
                        <td>{$row['nama_barang']}</td>
                        <td>{$row['nama_kategori']}</td>
                        <td>{$row['jumlah_stok']}</td>
                        <td>{$row['harga_barang']}</td>
                        <td>{$row['tanggal_masuk']}</td>
                        <td>
                            <a href='edit_barang.php?id={$row['id_barang']}' class='btn btn-warning btn-sm'>Edit</a>
                            <a href='hapus_barang.php?id={$row['id_barang']}' class='btn btn-danger btn-sm' onclick=\"return confirm('Yakin?')\">Hapus</a>
                        </td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='7' class='text-center'>Data tidak ditemukan.</td></tr>";
        }
        ?>
    </tbody>
</table>

<?php include 'footer.php'; ?>
