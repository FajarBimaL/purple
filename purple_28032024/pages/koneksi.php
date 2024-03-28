<?php
$host = "192.168.2.254";
$user = "fajar";
$pass = "P@ssw0rd131";
$dbnm = "db_warehouse";
$link = mysqli_connect($host,$user,$pass,$dbnm);
// if (mysqli_connect_errno()){
// 	echo "Koneksi database gagal : " . mysqli_connect_error();
// }else{ 
//     // echo "berhasil";
// }

class classku
    {
        public $db;
        function __construct()
        {
            date_default_timezone_set("Asia/Jakarta");
            $this->db = mysqli_connect('192.168.2.254','fajar','P@ssw0rd131','db_warehouse'); 


        }

        function coba(){
            $var="aku";
            return $var;
        }
    }

if ($link) {
    // echo "Berhasil konek";
} else {
    echo "gagal";
}

?>