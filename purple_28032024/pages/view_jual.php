<?php

include "koneksi.php";

// if(isset($_POST['print'])){
//     $id_jual = $_POST['id_jual'];
//     $id_invoice = $_POST['id_invoice'];
//     $no_invoice = $_POST['no_invoice'];
//     $id_barang = $_POST['id_barang'];
//     $nm_barang = $_POST['nm_barang'];

//     $query_print = "SELECT * FROM tb_jual WHERE no_invoice = $no_invoice";
//     $sql_print = mysqli_query($link,$query_print);

// }

?>

<link rel="stylesheet" href="https://cdn.datatables.net/2.0.0/css/dataTables.dataTables.css">
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://cdn.datatables.net/2.0.0/js/dataTables.js"></script>

<div class="col-md-12 grind-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <div>
            <h3 class="text-center">Riwayat Jual</h3><br>
            </div>
            <div class="table-responsive">
                <table id="penjualan" class="table table-hover">
                <?php 
                    // $query = "SELECT A.id_pembeli, B.kuantitas, B.harga_barang, B.total_harga, B.tgl_transaksi FROM tb_pembeli A, tb_transaksi B WHERE A.id_pembeli=B.id_pembeli && A.id_pembeli='$id_pembeli'";
                    $query = "SELECT * FROM tb_jual WHERE id_jual ORDER BY id_jual DESC";
                    $sql = mysqli_query($link,$query);
                ?>
                    <thead class="table-primary">
                        <tr>
                            <th class="text-center">No.Invoice</th>
                            <th class="text-center">Nama Barang</th>
                            <th class="text-center">Kuantitas</th>
                            <th class="text-center">Harga Barang</th>
                            <th class="text-center">Total Harga</th>
                            <th class="text-center">Tanggal Transaksi</th>
                            <!-- <th class="text-center">Action</th> -->
                        </tr>
                    </thead>

                    <tbody>
                    <?php while ($hasil = mysqli_fetch_array($sql)) { ?>       
                        <tr>
                            <td class="text-center"><?php echo $hasil['id_invoice'];?></td>
                            <td class="text-center"><?php echo $hasil['nm_barang'];?></td>
                            <td class="text-center"><?php echo $hasil['kuantitas'];?></td>
                            <td class="text-center">Rp <?php echo number_format($hasil['harga_barang'],0 ,',','.');?></td>
                            <td class="text-center">Rp <?php echo number_format($hasil['total_harga'],0 ,',','.');?></td>
                            <td class="text-center"><?php echo $hasil['tanggal'];?></td>
                            <!-- <td>
                            
                            <button class="btn btn-inverse-info" onclick="openWin('<?php echo $hasil['no_invoice'];?>')">
                            <i class="mdi mdi-printer menu-icon"></i></button>
                            
                            <script>
                                function openWin(id){
                                    // alert(id);
                                    window.open("pages/cetak.php?no="+id, "_blank");
                                }
                            </script>
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
    new DataTable('#penjualan',{
        ajax: 'server_side.php',
        processing: true,
        serverSide: true,
        // columnDefs: [{'render': createManageBtn}]
        // render: createManageBtn()
        // columnDefs: [{
        //     target: [6], searchable: false
        // }]

    });
</script>
