<?php
include "koneksi.php";


// echo "tampilkan"
?>

<div class="col-md-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <div>
                <h3 class="text-center">List Supplier</h3><br>
            </div>
            <div class="table-responsive">
                <table class="table table-hover">
                <?php 
                    $query = "SELECT * FROM tb_supplier";
                    $sql = mysqli_query($link,$query);
                    
                    
                ?>
                    <thead>
                        <tr>
                            <th class="text-center">Supplier</th>
                            <th class="text-center">No Telepon</th>
                            <th class="text-center">Alamat</th>
                            <th class="text-center">Barang</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php while ($hasil = mysqli_fetch_array($sql)) { ?>
                        <tr>
                            <td class="text-center"><?php echo $hasil['nama_sp'];?></td>
                            <td class="text-center"><?php echo $hasil['no_telp'];?></td>
                            <td class="text-center"><?php echo $hasil['alamat'];?></td>
                            <td class="text-center"><?php echo $hasil['supply_brg'];?></td>
                        </tr>
                    <?php } ?>
                        <!-- <tr>
                            <td class="text-center"></td>
                        </tr> -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>