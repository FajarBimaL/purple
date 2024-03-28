<?php

include "koneksi.php";
// $con= new classku();
// $data=$con->coba();
// echo $data;

// echo "tampilkan"

// POST NEW ITEM
if (isset($_POST['new'])) {
    $id_barang = $_POST['id_barang'];
    $nm_barang = $_POST['nm_barang'];
    $harga_barang = $_POST['harga_barang'];
    $stok_barang = $_POST['stok_barang'];

    $query_tambahBrg = "INSERT INTO tb_barang (nm_barang, harga_barang, stok_barang) VALUES ('$nm_barang', '$harga_barang', '$stok_barang')";
    $sql_tmbhBrg = mysqli_query($link,$query_tambahBrg);
    $hasil = mysqli_fetch_array($sql_tmbhBrg);
    if ($sql_tmbhBrg) {
        echo "<script>alert('Berhasil menambah item baru');</script>";
    } else {
        echo "Gagal menambah item baru";
    }

}
// POST BELI
if (isset($_POST['beli'])) {
    $id_barang = $_POST['id_barang'];
    $kuantitas = $_POST['kuantitas'];
    $harga_barang = $_POST['harga_barang'];
    $id_beli = $_POST['id_beli'];
    $total_harga = $kuantitas * $harga_barang;

    $query = "SELECT * FROM tb_barang WHERE id_barang=$id_barang";
    $sqll = mysqli_query($link,$query);  
    $hasil = mysqli_fetch_array($sqll);
    $nm_barang=$hasil[1];
    echo $nm_barang;
    
    // $queryBeli = "SELECT * FROM tb_beli WHERE id_beli=$id_beli";
    // $sqlBeli = mysqli_query($link,$queryBeli);
    // $hasil = mysqli_fetch_array($sqlBeli);
    // $nm_barang = $hasil[1];
    // echo $nm_barang;

    //query untuk tb_beli
    $query = "INSERT INTO tb_beli(id_barang,nm_barang,kuantitas,harga_barang,total_harga,tanggal) VALUES('$id_barang','$nm_barang', '$kuantitas', '$harga_barang','$total_harga',NOW())";
    $sql = mysqli_query($link,$query);
    // $query2 = "INSERT INTO tb_transaksi(id_beli,id_barang,nm_barang,kuantitas,harga_barang,total_harga,tanggal) VALUES ('$id_beli','$id_barang','$nm_barang', '$kuantitas', '$harga_barang', '$total_harga', NOW())";
    // $sql2 = mysqli_query($link,$query2);
    if($sql) {
        // query update harga
        echo"<script>alert('Informasi telah ditambahkan'); window.location='index.php?page=view_barang';</script>";        
    } else {
        echo "<h2><font color=red>Informasi gagal ditambahkan</font></h2>";
    }
}
// POST JUAL
if (isset($_POST['jual'])) {
    $id_barang = $_POST['id_barang'];
    $kuantitas = $_POST['kuantitas'];
    $harga_barang = $_POST['harga_barang'];
    $total_harga= $harga_barang;


    $query = "SELECT * FROM tb_barang WHERE id_barang=$id_barang";
    $sqll = mysqli_query($link,$query);  
    $hasil = mysqli_fetch_array($sqll);
    $nm_barang=$hasil[1];
    echo $nm_barang;

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
    
    //query untuk tb_jual
    $query = "INSERT INTO tb_jual(id_barang,no_invoice,id_invoice,nm_barang,kuantitas,harga_barang,total_harga,tanggal) VALUES('$id_barang','$no_invoice','$id_invoice','$nm_barang','$kuantitas','$harga_barang','$total_harga',NOW())";
    $sql = mysqli_query($link,$query);
    if($sql) {
        // query update harga
            // $query_up = "UPDATE tb_barang SET harga_barang= $harga_barang WHERE id_barang=$id_barang";
            // $sql_up = mysqli_query($link,$query_up);
        echo"<script>alert('Informasi telah ditambahkan'); window.location='index.php?page=view_barang';</script>";        
    } else {
        echo "<h2><font color=red>Informasi gagal ditambahkan</font></h2>";
    }
}

// POST KERANJANG
if(isset($_POST['keranjang'])) {
    $id_barang = $_POST['id_barang'];
    $kuantitas = $_POST['kuantitas'];
    $harga_barang = $_POST['harga_barang'];
    $total_harga = $kuantitas * $harga_barang;

    $query = "SELECT * FROM tb_barang WHERE id_barang=$id_barang";
    $sqll = mysqli_query($link,$query);  
    $hasil = mysqli_fetch_array($sqll);
    $nm_barang=$hasil[1];

    $query_stok = "SELECT stok_barang WHERE id_barang=$id_barang";
    $sql_stok = mysqli_query($link,$query);

    $query_cek = "SELECT * FROM tb_keranjang WHERE id_barang = $id_barang";
    $sql_cek = mysqli_query($link,$query_cek);

    if ($sql_stok){
        $hasil_stok = mysqli_fetch_assoc($sql_stok);
        $stok_tersedia = $hasil_stok['stok_barang'];
        
        if ($kuantitas > $stok_tersedia) {
            echo "stok tidak cukup";
        } else {

            if (mysqli_num_rows($sql_cek) > 0) {
                $query_update = "UPDATE tb_keranjang SET kuantitas = kuantitas + $kuantitas, total_harga = total_harga + $total_harga WHERE id_barang = $id_barang";
                mysqli_query($link,$query_update);
                echo "stok berhasil ditambah";
            }else{
                $query = "INSERT INTO tb_keranjang (id_barang,nm_barang,kuantitas,harga_barang,total_harga) VALUES ('$id_barang', '$nm_barang', '$kuantitas', '$harga_barang', '$total_harga')";
                $sql = mysqli_query($link,$query);
                if($sql) {
                    echo "item ditambahkan ke keranjang";
                } else {
                    echo "item gagal ditambah";
                }
            }
            echo "stok cukup";
        }
    }
}
?>
<!-- Datatables -->
<link rel="stylesheet" href="https://cdn.datatables.net/2.0.0/css/dataTables.dataTables.css">
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://cdn.datatables.net/2.0.0/js/dataTables.js"></script>
<!-- select2 -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" integrity="sha512-nMNlpuaDPrqlEls3IX/Q56H36qvBASwb3ipuo3MxeWbsQB1881ox0cRv7UPTgBlriqoynt35KjEwgGUeUXIPnw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js" integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>


<div class="col-md-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <!--Button Tambah Item, Beli & Jual barang -->
            <div class="row">
                <div class="col-xs-4 col-sm-8">                   
                    <button
                        type="button"
                        class="btn btn-primary btn-md btn-space mr-5"
                        data-bs-toggle="modal"
                        data-bs-target="#modalId0">
                        Tambah Item
                    </button>
                </div>
                <div class="col-xs-8 col-sm-2"> 
                    <!-- Button beli -->
                    <button
                        type="button"
                        class="btn btn-primary btn-md btn-space mr-5"
                        data-bs-toggle="modal"
                        data-bs-target="#modalId">
                        Beli
                    </button>
                </div>
                <!-- Button Jual -->
                <div class="col-xs-4 col-sm-2">                   
                    <button
                        type="button"
                        class="btn btn-primary btn-md btn-space mr-5"
                        data-bs-toggle="modal"
                        data-bs-target="#modalId2">
                        Jual
                    </button>
                </div>
            </div><br>
            <!-- Modal action tambah item mulai-->
            <FORM ACTION="" method="POST" NAME="new">
                <div
                    class="modal fade"
                    id="modalId0"
                    tabindex="-1"
                    role="dialog"
                    aria-labelledby="modalTitleId"
                    aria-hidden="true">

                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title text-center col-md-10" id="modalTitleId">
                                    Tambah Item
                                    <div class="modal-body">
                                        <label class="col-sm-4" for="id_barang">Barang :</label>
                                        <input class="col-sm-6" type="text" name="nm_barang">
                                        <br><br>

                                        <label class="col-sm-4" for="stok_barang">Stok :</label>
                                        <input class="col-sm-6" type="text" name="stok_barang"><br>
                                        <br>

                                        <label class="col-sm-4" for="harga_barang">Harga :</label>
                                        <input class="col-sm-6" type="text" name="harga_barang"><br>
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

                                <button class="btn btn-primary" type="submit" name="new" value="new">
                                    Save
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </FORM>
            <!-- Modal action tambah item selesai -->

            <!-- modal action beli mulai -->
            <FORM ACTION="" method="POST" NAME="beli">
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
                            <h5 class="modal-title text-center col-md-10" id="modalTitleId">
                                Tambah Stok
                                <div class="modal-body">
                                    <label class="col-sm-4" for="id_barang">Barang :</label>
                                    <select class="col-sm-6 js-example-basic-multiple" style="width: 50%;" name="id_barang" class="form-control" required="required">
                                        <?php
                                            $query = "SELECT id_barang, nm_barang FROM tb_barang";
                                            $sql = mysqli_query($link,$query);
                                            while ($hasil = mysqli_fetch_array($sql)){
                                                // $id_barang = $hasil['id_barang'];
                                                // $nm_barang = $hasil['nm_barang'];
                                                echo "<option value='$hasil[id_barang]'>$hasil[nm_barang]</option>";    
                                        }
                                        ?>
                                    </select>
                                    <br><br>
                                    <label class="col-sm-4" for="kuantitas">Kuantitas :</label>
                                    <input class="col-sm-6" type="text" name="kuantitas"><br>
                                    <br>
                                    <label class="col-sm-4" for="harga_barang">Harga :</label>
                                    <input class="col-sm-6" type="text" name="harga_barang"><br>
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
                            <button class="btn btn-primary" type="submit" name="beli" value="beli">
                                Save
                            </button>
                        </div>
                    </div>
                </div>
                </div>
            </FORM>

            <script>
                var modalId = document.getElementById('modalId');

                modalId.addEventListener('show.bs.modal', function (event) {
                    // Button that triggered the modal
                    let button = event.relatedTarget;
                    // Extract info from data-bs-* attributes
                    let recipient = button.getAttribute('data-bs-whatever');

                    // Use above variables to manipulate the DOM
                });
            </script>
            <!-- modal action beli selesai -->

            <!-- modal action jual mulai -->
            <FORM ACTION="" method="POST" NAME="jual">
                <div
                    class="modal fade"
                    id="modalId2"
                    tabindex="-1"
                    role="dialog"
                    aria-labelledby="modalTitleId"
                    aria-hidden="true">

                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title text-center col-md-10" id="modalTitleId">
                                    Kurang Stok
                                    <div class="modal-body">
                                        <label class="col-sm-4" for="id_barang">Barang :</label>
                                        <select class="col-sm-6 js-example-basic-single" style="width: 50%;" name="id_barang" class="form-control" required="required">
                                            <?php
                                                
                                                $query = "SELECT id_barang, nm_barang FROM tb_barang";
                                                $sql = mysqli_query($link,$query);
                                                while ($hasil = mysqli_fetch_array($sql)){
                                                    // $id_barang = $hasil['id_barang'];
                                                    // $nm_barang = $hasil['nm_barang'];
                                                    echo "<option value='$hasil[id_barang]'>$hasil[nm_barang]</option>";
                                                    
                                            }
                                            ?>
                                        </select><br><br>

                                        <label class="col-sm-4" for="kuantitas">Kuantitas :</label>
                                        <input class="col-sm-6" type="text" name="kuantitas"><br><br>

                                        <label class="col-sm-4" for="harga_barang">Harga :</label>
                                        <input class="col-sm-6" type="text" name="harga_barang"><br>
                                        <!-- <input class="col-sm-6" type="text" name="harga_barang"><br> -->
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

                                <button class="btn btn-primary" type="submit" name="jual" value="jual">
                                    Save
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </FORM>

            <script>
                var modalId2 = document.getElementById('modalId2');

                modalId2.addEventListener('show.bs.modal', function (event) {
                    // Button that triggered the modal
                    let button = event.relatedTarget;
                    // Extract info from data-bs-* attributes
                    let recipient = button.getAttribute('data-bs-whatever');

                    // Use above variables to manipulate the DOM
                });
            </script><br>
            <!-- modal action jual selesai -->   

            <!-- menampilkan tabel barang mulai-->
            <div class="table-responsive">
                <table id="barang" class="table table-striped">
                    <?php 
                        $query = "SELECT * FROM tb_barang";
                        $sql = mysqli_query($link,$query);
                    ?>
                    <thead class="table-info">
                        <tr>
                            <th class="text-center">Nama Barang</th>
                            <th class="text-center">Harga Barang</th>
                            <th class="text-center">Stok Barang</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php while ($hasil = mysqli_fetch_array($sql)) { ?>       
                            <tr>
                                <td class="text-center"><?php echo $hasil['nm_barang'];?></td>
                                <td class="text-center"><?php echo $hasil['harga_barang'];?></td>
                                <td class="text-center"><?php echo $hasil['stok_barang'];?></td>                
                                
                                <td class="text-center">
                                    <!-- BUTTON KERANJANG -->               
                                    <button
                                        type="button"
                                        class="btn btn-primary btn-lg btn-space mr-5"
                                        data-bs-toggle="modal"
                                        onclick="modalID3(<?php echo $hasil['id_barang'];?>, <?php echo $hasil['harga_barang'];?>, '<?php echo $hasil['nm_barang'];?>')"
                                        data-bs-target="#modalId3">
                                        <i class="mdi mdi-basket menu-icon"></i>
                                    </button>

                                    <!-- modal action keranjang mulai -->
                                    <FORM ACTION="" method="POST" NAME="keranjang">
                                        <div
                                            class="modal fade"
                                            id="modalId3"
                                            tabindex="-1"
                                            role="dialog"
                                            aria-labelledby="modalTitleId"
                                            aria-hidden="true">
                                        
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title text-center col-md-10" id="modalTitleId">
                                                            Masukan ke keranjang
                                                            <div class="modal-body">

                                                                <!-- <label for="id_barang">Barang :</label> -->
                                                                <input type="text" name="id_barang" id="modalID_barang" hidden>
                                                                <br>
                                                                <label class="col-sm-4" for="id_barang">Barang :</label>
                                                                <input class="col-sm-6" type="text" name="nm_barang" id="modalnm_barang" readonly>
                                                                <br><br>
                                                                <label class="col-sm-4" for="kuantitas">Kuantitas</label>
                                                                <input class="col-sm-6" type="text" name="kuantitas"><br><br>

                                                                <label class="col-sm-4" for="harga_barang">Harga</label>
                                                                <input class="col-sm-6" type="text" name="harga_barang" id="modalHarga" readonly><br>

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
                                                        <button class="btn btn-primary" type="submit" name="keranjang" value="keranjang">
                                                            Save
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </FORM>
                                    <script>
                                        function modalID3(id_barang, harga_barang,nm_barang) {
                                            document.getElementById('modalID_barang').value = id_barang;
                                            document.getElementById('modalnm_barang').value = nm_barang;
                                            document.getElementById('modalHarga').value = harga_barang;
                                        }
                                    </script>
                                    <!-- modal action keranjang selesai -->
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <!-- menampilkan tabel barang selesai -->
        </div>
    </div>
</div>
<script>
    // script datatables
    new DataTable('#barang');
   

    // $(document).ready(function() {
    //     $('#id_barang').select2();
    // });

    // script select2
    $('.js-example-basic-multiple').select2({
        width:'resolve',
        placeholder: 'Select an option',
        dropdownParent:'#modalId'
    });

    $('.js-example-basic-single').select2({
        width:'resolve',
        placeholder: 'Select an option',
        dropdownParent: '#modalId2'
    });

</script>




