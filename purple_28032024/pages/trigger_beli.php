<?php
include "koneksi.php";

$query = "
CREATE TRIGGER tr_restok
AFTER INSERT ON tb_beli
FOR EACH ROW
BEGIN
    UPDATE tb_barang SET stok_barang = stok_barang + NEW.kuantitas WHERE id_barang = NEW.id_barang;
END";

if ($link->query($query) === TRUE) {
    echo "TRIGGER created Success";
} else {
    echo "ERROR creating trigger: ". $link->error; 
}
?>