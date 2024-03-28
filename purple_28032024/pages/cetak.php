<?php include "koneksi.php";

// echo"berhasil";

if (isset($_GET['no'])) {
    $no_invoice = $_GET['no'];
} ?>


<!doctype html>
<html lang="en">
    <br>
    <head>
        <title>INVOICE#<?php echo $_GET['no'];?></title>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    </head>
    <div class="">
        <?php
            $tanggal = "SELECT id_invoice,tanggal FROM tb_jual where no_invoice = $no_invoice";
            $sql_tgl = mysqli_query($link,$tanggal);
            $hasil_tgl = mysqli_fetch_array($sql_tgl);
            // $tanggal = [''];
            
            
        ?>
        <h2 class="text-center text-info">INVOICE</h2>
        <h6 class="col px-md-5 text-right">Date : <?php echo $hasil_tgl['tanggal']; ?></h6>
        <h6 class="col px-md-5 text-right">No.Invoice : <?php echo $hasil_tgl['id_invoice']; ?></h6>
    </div><br>
    <body>
        <div class="table-responsive">
            <table class="table table-striped">
                <?php
                    $query = "SELECT * FROM tb_jual where no_invoice = $no_invoice";
                    $sql = mysqli_query($link,$query);
                ?>

                <thead class="thead-dark">
                    <tr>
                        <th class="text-center">Barang</th>
                        <th class="text-center">Jumlah</th>
                        <th class="text-center">Harga</th>
                        <th class="text-center">Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($hasil = mysqli_fetch_array($sql)) { ?>
                        <tr>
                            <td class="text-center"><?php echo $hasil['nm_barang'];?></td>
                            <td class="text-center"><?php echo $hasil['kuantitas'];?></td>
                            <td class="text-center">Rp <?php echo number_format($hasil['harga_barang'],0 ,',','.');?></td>
                            <td class="text-center">Rp <?php echo number_format($hasil['total_harga'],0 ,',','.');?></td>
                        </tr>
                    <?php } ?>
                </tbody>
                <tbody class="table-secondary">
                    <tr>
                        <td class="text-right" colspan="3">Sub Total : </td>
                        <?php 
                            $query_sub = "SELECT SUM(kuantitas*harga_barang) AS grand_total FROM tb_jual WHERE no_invoice = $no_invoice";
                            $sql_sub = mysqli_query($link,$query_sub);
                            $hasil_sub = mysqli_fetch_array($sql_sub);
                            // $grand_total = $hasil['grand_total'];
                        ?>
                        <td class="text-center">Rp <?php echo number_format($hasil_sub['grand_total'], 0, '.', '.'); ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
        
        <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    </body>
    <div>

    </div>

</html>