<?php
require __DIR__ . '/vendor/autoload.php';
include 'koneksi.php';

$mpdf = new \Mpdf\Mpdf();

$html = '
<h2 style="text-align: center;">Daftar Barang</h2>
<table border="1" cellpadding="10" cellspacing="0" style="width: 100%; border-collapse: collapse;">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nama Produk</th>
            <th>Kategori</th>
            <th>Stok</th>
            <th>Harga</th>
            <th>Tanggal Masuk</th>
        </tr>
    </thead>
    <tbody>';

$sql = "SELECT barang.*, kategori.nama_kategori FROM barang 
        JOIN kategori ON barang.id_kategori = kategori.id_kategori";
$result = $koneksi->query($sql);

while ($row = $result->fetch_assoc()) {
    $html .= "<tr>
                <td>{$row['id_barang']}</td>
                <td>{$row['nama_barang']}</td>
                <td>{$row['nama_kategori']}</td>
                <td>{$row['jumlah_stok']}</td>
                <td>Rp " . number_format($row['harga_barang'], 0, ',', '.') . "</td>
                <td>{$row['tanggal_masuk']}</td>
              </tr>";
}

$html .= '
    </tbody>
</table>';

$mpdf->WriteHTML($html);
$mpdf->Output("daftar_barang.pdf", \Mpdf\Output\Destination::INLINE);
