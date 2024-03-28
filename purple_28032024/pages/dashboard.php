<?php 

    include "koneksi.php";
    // echo"dashboard";
?>

<!-- menampilkan info update mulai -->
<div class="row g-3">
    <!-- Top 3 info mulai -->
    <div class="col-md-6 col-lg-3 col-xs-2 stretch-card">
        <?php
            $query_top3 = "SELECT nm_barang,SUM(total_harga) AS total_harga FROM tb_jual GROUP BY nm_barang ORDER BY total_harga DESC LIMIT 3";
            $sql_top3 = mysqli_query($link,$query_top3);    
        ?>
        <div class="card bg-gradient-info card-img-holder text-white">
            <div class="card-body">
                <img src="assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
                <h5 class="font-weight-bold text-center mb-2">TOP 3 <i class="mdi mdi-poll"></i></h5><br>
                <?php   
                while ($hasil_top3= mysqli_fetch_array($sql_top3)) { ?>
                <h5 class="font-weight-normal"><?php echo $hasil_top3['nm_barang'];?></h5>
                <?php } ?>
            </div>
        </div>
    </div>
    <!-- Top 3 info selesai -->
    <!-- Stok limit mulai -->
    <div class="col-md-6 col-lg-3 stretch-card">
        <?php
            $query_Stkbarang = "SELECT nm_barang,stok_barang FROM tb_barang WHERE  stok_barang <= 5 ORDER BY stok_barang ASC LIMIT 5";
            $sql_Stkbarang = mysqli_query($link,$query_Stkbarang);
        ?>
        <div class="card bg-gradient-danger card-img-holder text-white">
            <div class="card-body">
                <img src="assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
                <h5 class="font-weight-bold text-center mb-2">Limited Stok</h5><br>
                <?php
                while ($hasil_Stkbarang= mysqli_fetch_array($sql_Stkbarang)) { ?>
                <h4 class="font-weight-normal text-center"><?php echo $hasil_Stkbarang['nm_barang'], ' : ',$hasil_Stkbarang['stok_barang'];?></h4>
                <?php } ?>
            </div>
        </div>
    </div>
    <!-- Stok limit selesai -->
    <!-- Monthly sales mulai -->
    <div class="col-md-6 col-lg-3 stretch-card">
        <?php 
            $query_sale = "SELECT SUM(total_harga) AS total_harga FROM tb_jual WHERE MONTH(tanggal) = MONTH(NOW()) AND YEAR(tanggal) = YEAR(NOW())";
            $sql_sale = mysqli_query($link,$query_sale);
        ?>
        <div class="card bg-gradient-primary card-img-holder text-white">
            <div class="card-body">
            <img src="assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
                <h5 class="font-weight-bold text-center mb-5">Monthly Sales <i class="mdi mdi-chart-line"></i></h5>
                <?php while ($hasil_sale = mysqli_fetch_array($sql_sale)) { ?>
                <h4 class="font-weight-normal text-center">Rp <?php echo number_format($hasil_sale['total_harga'], 0 , ',', '.');?></h4>
                <?php } ?>
            </div>
        </div>
    </div>
    <!-- Monthly sales selesai -->
    <div class="col-md-6 col-lg-3 stretch-card">
        <?php
            $query_sup = "SELECT nama_sp FROM tb_supplier LIMIT 3";
            $sql_sup = mysqli_query($link,$query_sup);
        ?>
        <div class="card bg-gradient-dark card-img-holder text-white">
            <div class="card-body">
            <img src="assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
                    <h5 class="font-weight-bold text-center mb-4">Supplier</h5>
                    <?php while ($hasil_sup = mysqli_fetch_array($sql_sup)) { ?>
                    <h4 class="font-weight-normal text-center"><?php echo $hasil_sup['nama_sp']; ?></h4>
                    <?php } ?>
            </div>
        </div>
    </div>
</div>
<!-- menampilkan info update selesai -->

<!-- Menampilkan table riwayat beli pada dashboard mulai -->
<div class="row">
    <div class="col-12 grid-margin">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title text-center">Riwayat Beli</h4><br>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <?php 
                            // $query = "SELECT A.id_pembeli, B.kuantitas, B.harga_barang, B.total_harga, B.tgl_transaksi FROM tb_pembeli A, tb_transaksi B WHERE A.id_pembeli=B.id_pembeli && A.id_pembeli='$id_pembeli'";
                            $query = "SELECT * FROM tb_beli WHERE id_beli ORDER BY id_beli DESC LIMIT 5";
                            $sql = mysqli_query($link,$query);
                        ?>
                        <thead class="table-dark">
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
                                <td class="text-center">Rp <?php echo number_format($hasil['total_harga'],'0',',','.');?></td>
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
</div>
<!-- Menampilkan table riwayat beli pada dashboard selesai -->


