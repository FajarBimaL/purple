<?php

include "koneksi.php";

// Check Out barang
if (isset($_POST['payment'])){
    // $id_keranjang = $_POST['id_keranjang'];
    // $id_barang = $_POST['id_barang'];
    // $nm_barang = $_POST['nm_barang'];
    // $kuantitas = $_POST['kuantitas'];
    // $harga_barang = ['harga_barang'];

    // menampilkan data yang ada di tabel keranjang
    $query = "SELECT * FROM tb_keranjang";
    $sqll = mysqli_query($link,$query);
    
    // query pembuatan invoice mulai
    $queryInvoice = "SELECT MAX(no_invoice) AS no_invoice FROM tb_jual WHERE YEAR(tanggal) = YEAR(NOW())";
    $dataInvoice = mysqli_query($link,$queryInvoice);
    $hasilInvoice = mysqli_fetch_array($dataInvoice);
    print_r($hasilInvoice);
    if($hasilInvoice['no_invoice']==''){
        $bulan=date("m/Y");
        $id_invoice='1/INV/'.$bulan;
        $no_invoice=1;
    }else{
        $bulan=date("m/Y");
        $no_invoice=(int)$hasilInvoice['no_invoice']+1;
        $id_invoice=$no_invoice.'/INV/'.$bulan;
    }
    // query pembuatan invoice selesai

// query memasukan item kedalam tb_jual setelah cek out mulai
    while ($hasil = mysqli_fetch_array($sqll)) {
        $nm_barang=$hasil['nm_barang'];
        $id_barang=$hasil['id_barang'];
        $kuantitas=$hasil['kuantitas'];
        $harga_barang=$hasil['harga_barang'];
        $total_harga=$hasil['total_harga'];

        $cek_stok = "SELECT stok_barang FROM tb_barang WHERE id_barang=$id_barang";
        $stok_skrg = mysqli_query($link,$cek_stok);

        if ($stok_skrg){
            $hasil_stok = mysqli_fetch_assoc($stok_skrg);
            $stok_tersedia = $hasil_stok['stok_barang'];

            if ($kuantitas > $stok_tersedia){
                echo "<script>alert('stok kurang')</script>";
            } else {
                $query3 = "INSERT INTO tb_jual (id_barang,no_invoice,id_invoice,nm_barang,kuantitas,harga_barang,total_harga,tanggal)VALUES('$id_barang','$no_invoice','$id_invoice','$nm_barang','$kuantitas','$harga_barang','$total_harga',NOW())";
                $sql3 = mysqli_query($link,$query3);
                if ($sql3) {
                //     // update stok setelah melakukan cek out, jika belum cek out stok tidak akan berkurang
                //     // $query_up = "UPDATE tb_barang SET stok_barang= $kuantitas - $stok_barang WHERE id_barang=$id_barang";
                //     // $sql_up = mysqli_query($link,$query_up);
                    // menghapus semua data yang ada di keranjang setelah dilakukan check out
                    $query_del = "DELETE FROM tb_keranjang";
                    $sql_del = mysqli_query($link,$query_del);
                    echo "berhasil";
                }
            }
            
        }
        
    }
}
// query memasukan item kedalam tb_jual setelah cek out selesai

// kurangi jumlah stok
if (isset($_POST['kurangi_stok'])) {
    $id_keranjang = $_POST['id_keranjang'];
    $id_barang = $_POST['id_barang'];
    $nm_barang = $_POST['nm_barang'];
    $kuantitas = $_POST['kuantitas'];
    $harga_barang = $_POST['harga_barang'];
    $total_harga = $kuantitas * $harga_barang;

    $query = "UPDATE tb_keranjang SET kuantitas = kuantitas - $kuantitas, total_harga = total_harga - $total_harga WHERE id_keranjang = $id_keranjang";
    $sql = mysqli_query($link,$query);
    // $hasil = mysqli_fetch_array($sql_kurangi);

}

// Hapus Barang
if (isset($_POST['delete'])) {
    $id_keranjang = $_POST['id_keranjang'];

    $query = "DELETE FROM tb_keranjang WHERE id_keranjang=$id_keranjang";
    $sql = mysqli_query($link,$query);
}
// Hapus semua isi keranjang
if (isset($_POST['deleteAll'])) {
    $id_barang = $_POST['id_keranjang'];

    $query2 = "DELETE FROM tb_keranjang";
    $sql2 = mysqli_query($link,$query2);
}

?>

<link rel="stylesheet" href="https://cdn.datatables.net/2.0.0/css/dataTables.dataTables.css">
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://cdn.datatables.net/2.0.0/js/dataTables.js"></script>

<div class="col-md-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <!-- Menampilkan item keranjang mulai -->
            <div>
                <h3 class="text-center">Keranjang</h3><br>
            </div>
            <div class="table-responsive">
                <table id="cart" class="table table-hover">
                <?php 
                    // $query = "SELECT A.id_pembeli, B.kuantitas, B.harga_barang, B.total_harga, B.tgl_transaksi FROM tb_pembeli A, tb_transaksi B WHERE A.id_pembeli=B.id_pembeli && A.id_pembeli='$id_pembeli'";
                    $query = "SELECT * FROM tb_keranjang";
                    $sql = mysqli_query($link,$query);
                ?>
                    <thead class="table-primary">
                        <tr>
                            <th class="text-center">Nama Barang</th>
                            <th class="text-center">Kuantitas</th>
                            <th class="text-center">Harga Barang</th>
                            <th class="text-center">Total Harga</th>
                            <th class="text-center">Action</th>
                            <!-- <th class="text-center">Tanggal Transaksi</th> -->
                        </tr>
                    </thead>

                    <tbody>
                    <?php while ($hasil = mysqli_fetch_array($sql)) { ?>       
                        <tr>
                            <td class="text-center"><?php echo $hasil['nm_barang'];?></td>
                            <td class="text-center"><?php echo $hasil['kuantitas'];?></td>
                            <td class="text-center"><?php echo $hasil['harga_barang'];?></td>
                            <td class="text-center"><?php echo $hasil['total_harga'];?></td>
                            <td class="text-center">
                                <!-- BUTTON KURANGI JUMLAH ITEM -->               
                                <button
                                    type="button"
                                    class="btn btn-primary"
                                    data-bs-toggle="modal"
                                    onclick="modalID5(<?php echo $hasil['id_keranjang'];?>,<?php echo $hasil['id_barang'];?>, '<?php echo $hasil['nm_barang'];?>', '<?php echo $hasil['harga_barang'];?>')"
                                    data-bs-target="#modalId5">
                                    Kurangi
                                </button>

                                <!-- modal action kurangi jumlah item mulai -->
                                <FORM ACTION="" method="POST" NAME="kurangi_stok">
                                    <div
                                        class="modal fade"
                                        id="modalId5"
                                        tabindex="-1"
                                        role="dialog"
                                        aria-labelledby="modalTitleId"
                                        aria-hidden="true">
                                    
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title text-center col-md-10" id="modalTitleId">
                                                        Kurangi jumlah pesanan
                                                        <div class="modal-body">

                                                            <input type="text" name="id_keranjang" id="modalID_keranjang" hidden>
                                                            <input type="text" name="id_barang" id="modalID_barang" hidden>
                                                            <br>
                                                            <label class="col-sm-4" for="id_barang">Barang :</label>
                                                            <input class="col-sm-6" type="text" name="nm_barang" id="modalnm_barang" readonly>
                                                            <br><br>
                                                            <label class="col-sm-4" for="kuantitas">Kuantitas</label>
                                                            <input class="col-sm-6" type="text" name="kuantitas"><br><br>
                                                            <br>
                                                            <input type="text" name="harga_barang" id="modalHarga" hidden>

                                                        </div>
                                                    </h5>
                                                </div>
                                                <!-- button close & save -->
                                                <div class="modal-footer">
                                                    <button
                                                        type="button"
                                                        class="btn btn-secondary"
                                                        data-bs-dismiss="modal">
                                                        Close
                                                    </button>
                                                    <button class="btn btn-primary" type="submit" name="kurangi_stok" value="kurangi_stok">
                                                        Save
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </FORM><br>
                                <script>
                                    function modalID5(id_keranjang, id_barang, nm_barang, harga_barang) {
                                        document.getElementById('modalID_keranjang').value = id_keranjang;
                                        document.getElementById('modalID_barang').value = id_barang;
                                        document.getElementById('modalnm_barang').value = nm_barang;
                                        document.getElementById('modalHarga').value = harga_barang;
                                    }
                                </script>
                                <!-- modal action kurangi jumlah item selesai -->
                                <form action="" method="POST" name="delete">
                                    <input type="hidden" name="id_keranjang" value="<?php echo $hasil['id_keranjang'];?>">
                                    <input type="submit" name="delete" class="btn btn-danger" value="Remove">
                                </form>
                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div><br>
            <!-- Menampilkan item keranjang selesai -->

            <!-- Button Check Out Mulai -->
            <div class="row">
                <div class="col-xs-4 col-sm-3">
                    <form action="" method="POST" name="deleteAll">
                        <button type="submit" class="btn btn-danger" name="deleteAll">Clear All</button>
                    </form>
                </div>
                <div class="col-xs-4 col-sm-3">
                    <!-- <button type="submit" class="btn btn-primary">Check Out</button> -->
                    <button
                        type="button"
                        class="btn btn-primary btn-md btn-space mr-5"
                        data-bs-toggle="modal"
                        data-bs-target="#modalId">
                        Check Out
                    </button>
                </div>
            </div>
            <!-- Button Check Out Selesai -->

            <!-- Check Out Modal Form Mulai -->
            <FORM ACTION="" method="POST" NAME="payment">
                <div
                    class="modal fade"
                    id="modalId"
                    tabindex="-1"
                    role="dialog"
                    aria-labelledby="modalTitleId"
                    aria-hidden="true">

                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title text-center col-md-10" style="font-size: 15px;" id="modalTitleId">
                                    Check Out
                                </h5>
                            </div>
                            <div class="modal-body">
                                <table class="table">
                                    <?php 
                                        $query = "SELECT nm_barang,kuantitas,total_harga FROM tb_keranjang";
                                        $sql = mysqli_query($link,$query);
                                        // $total = $kuantitas['kuantitas'] * $harga_barang['harga_barag'];
                                    ?>
                                    <thead>
                                        <tr>
                                            <th>Nama Barang</th>
                                            <th>Kuantitas</th>
                                            <th>Total Harga</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php while ($hasil = mysqli_fetch_array($sql)) {?>
                                            <tr>
                                                <td><?php echo $hasil['nm_barang']; ?></td>
                                                <td><?php echo $hasil['kuantitas']; ?></td>
                                                <td> Rp <?php echo number_format($hasil['total_harga'], '0',',','.'); ?></td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                    <tbody>
                                        <tr>
                                            <td></td>
                                            <td>Total</td>
                                            <?php 
                                            $query = "SELECT SUM(kuantitas*harga_barang) AS grand_total FROM tb_keranjang";
                                            $sql = mysqli_query($link,$query);
                                            $hasil = mysqli_fetch_array($sql);
                                            // $grand_total = $hasil['grand_total'];
                                            ?>
                                            <td>Rp <?php echo number_format($hasil['grand_total'], 0, ',', '.'); ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <!-- button close & save -->
                            <div class="modal-footer">
                                <button
                                    type="button"
                                    class="btn btn-secondary"
                                    data-bs-dismiss="modal">
                                    Close
                                </button>
                                <button class="btn btn-primary" type="submit" name="payment">
                                    Save
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </FORM>
            <!-- Check Out Modal Form Selesai -->
        </div>
    </div>
</div>

<script>
    new DataTable('#cart');
</script>
