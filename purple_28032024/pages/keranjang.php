<?php

session_start();

$id_barang = $_GET['id_barang'];

if(isset($_SESSION['keranjang_belanja'][$id_barang]))
{
    $_SESSION['keranjang_belanja'][$id_barang] +=1;
}else 
{
    $_SESSION['keranjang_belanja'][$id_barang] =1;

}

// echo "<pre>";
// print_r($_SESSION['keranjang_belanja']);
// echo "</pre>";

echo "<script>alert('Produk berhasil ditambah ke keranjang')</script>";
echo "<script>location='view_keranjang.php';</script>";



?>