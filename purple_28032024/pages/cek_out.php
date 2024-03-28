
                                                        
                                                        
                                                        
                                                        
                                                        
<FORM ACTION="" method="" NAME="">
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