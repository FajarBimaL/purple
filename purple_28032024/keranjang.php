<?php

// session_start();

// $id_barang = $_GET['id_barang'];

// if(isset($_SESSION['keranjang_belanja'][$id_barang]))
// {
//     $_SESSION['keranjang_belanja'][$id_barang] +=1;
// }else 
// {
//     $_SESSION['keranjang_belanja'][$id_barang] =1;

// }
// include "koneksi.php";

// if (isset($_POST['add_to_cart'])) {
//     if (isset($_SESSION['cart'])) {

//     } else {
//         $session_array = array(
//             $id_barang = $_GET['id_barang'],
//             $nm_barang = $_POST['nm_barang'],
//             $harga_barang = $_POST['harga_barang'],

//         );
//         $_SESSION['cart'][]=$session_array;
//     }
// }

// echo "<pre>";
// print_r($_SESSION['keranjang_belanja']);

// echo "</pre>";

echo "<script>alert('Produk berhasil ditambah ke keranjang')</script>";
echo "<script>location='index.php?page=view_keranjang';</script>";


// var_dump($_SESSION['cart']);



?>