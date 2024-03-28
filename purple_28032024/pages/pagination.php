<?php 
    $halaman=@$_GET['page'];

    switch ($halaman) {
        case 'view_barang':
            include"view_barang.php";
        break;
        case 'view_penjualan':
            include"view_penjualan.php";
        break;
        case 'view_supplier':
            include"view_supplier.php";
        break;
        case 'view_beli':
            include"view_beli.php";
        break;
        case 'view_jual':
            include"view_jual.php";
        break;
        case 'view_keranjang':
            include"view_keranjang.php";
        break;
        // case 'view_invoice':
        //     include"view_invoice.php";
        // break;
        // case 'cek_out';
        //     include"cek_out.php";
        // break;
        default:
            include"dashboard.php";
            echo "<script> $('#preloader').addClass('d-none'); </script>";
            
            break;
    }
    ?>