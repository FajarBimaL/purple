<?php

include "koneksi.php";
// $con= new classku();
// $data=$con->coba();
// echo $data;
// $nm_barang = $_GET["nm_barang"];
// $hrg_barang = $_GET["hrg_barang"];
// $stok_barang = $_GET["stok_barang"];

// echo "tampilkan"
?>

<link rel="stylesheet" href="https://cdn.datatables.net/2.0.0/css/dataTables.dataTables.css">
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://cdn.datatables.net/2.0.0/js/dataTables.js"></script>

<div class="col-md-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <div>
                <h3 class="text-center">Riwayat Transaksi</h3><br>
            </div>
            <div class="table-responsive">
                <table id="transaction" class="table table-hover">
                <?php
                    // $query = "SELECT A.id_pembeli, B.kuantitas, B.harga_barang, B.total_harga, B.tgl_transaksi FROM tb_pembeli A, tb_transaksi B WHERE A.id_pembeli=B.id_pembeli && A.id_pembeli='$id_pembeli'";
                    $query = "SELECT * FROM tb_transaksi";
                    $sql = mysqli_query($link,$query);
                ?>
                    <thead class="table-primary">
                        <tr>
                            <th class="text-center">Nama Barang</th>
                            <th class="text-center">Kuantitas</th>
                            <th class="text-center">Harga Barang</th>
                            <th class="text-center">Total Harga</th>
                            <th class="text-center">Tanggal Transaksi</th>
                        </tr>
                    </thead>

                    <tbody>
                    <?php while ($hasil = mysqli_fetch_array($sql)) { ?>       
                        <tr>
                            <td class="text-center"><?php echo $hasil['nm_barang'];?></td>
                            <td class="text-center"><?php echo $hasil['kuantitas'];?></td>
                            <td class="text-center"><?php echo $hasil['harga_barang'];?></td>
                            <td class="text-center"><?php echo $hasil['total_harga'];?></td>
                            <td class="text-center"><?php echo $hasil['tanggal'];?></td>

                            <!-- <td>a</td>
                            <td>a</td> -->
                            <!-- <td>
                            <button type="button" class="btn btn-success">button</button>
                            </td> -->
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
    new DataTable('#transaction');
</script>