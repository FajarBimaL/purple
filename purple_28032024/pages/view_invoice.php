<?php
include "koneksi.php";

// echo"berhasil";

if (isset($_GET['no'])) {
    $no_invoice = $_GET['no'];
}
?>

<style>
    @media print {
        .btn {
            display: none;
        }
    }
</style>

<div>
    <h3 class="text-center">INVOICE</h3>
</div>
<div class="header">
    <?php
        $tanggal = "SELECT id_invoice,tanggal FROM tb_jual where no_invoice = $no_invoice";
        $sql_tgl = mysqli_query($link,$tanggal);
        $hasil_tgl = mysqli_fetch_array($sql_tgl);
    ?>
    <h5>
        No.Inv : <?php echo $hasil_tgl['id_invoice'];?>
    </h5>
    <h5>
        Tanggal : <?php echo $hasil_tgl['tanggal'];?>
    </h5>
</div>

<div class="table-responsive">
    <table class="table table-hover">
        <?php
            $query = "SELECT * FROM tb_jual where no_invoice = $no_invoice";
            $sql = mysqli_query($link,$query);
        ?>

        <thead>
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
    </table>
</div><br>

<button class="btn" onclick="window.print()">Print</button>

<a href="/purple/index.php?page=view_jual"><button>back</button></a>



