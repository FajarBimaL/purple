<!-- contoh OOP XD -->
<?php

// bikin class terlebih dahulu, diberi nama bebas, Ex-> laptop
// class laptop {

//     // membuat property
//     public $laptop;
//     public $warna;
//     // var $processor;

//     // function tampilkan_nama_pemilik(){
//     //     return "Pemilik Laptop Fajar Bima Laksono</br>";
//     // }
//     function __construct($laptop,$warna){
//         $this->laptop = $laptop;
//         $this->warna = $warna;
//     }

//     function __destruct()
//     {
//         echo "Laptop ini merk {$this->laptop} berwarna {$this->warna}";
//     }
// }

// $asus = new laptop("Asus" , "Hitam");

// class hp {
//     public $merk;
//     public $warna;
//     public $storage;

//     // function set_merk($n){
//     //     $this->merk = $n;
//     // }
// }

// $Samsung = new hp();
// $Samsung->merk = "samsung";
// $Samsung->warna = 'Aqua';
// $Samsung->storage = '256gb';

// inheritance (protected method)
// class elektronik {
//     public $merk;
//     public $warna;

//     public function __construct($merk, $warna)
//     {
//         $this->merk = $merk;
//         $this->warna = $warna;
//     }

//     protected function deskripsi(){
//         echo "Elektronik ini bermerk {$this->merk} dan memiliki warna {$this->warna}";
//     }
// }

// class asus extends elektronik {
//     public function pertanyaan(){
//         echo "Apaka elektronik ini laptop/hp? <br>";
//         $this->deskripsi();
//     }
// }

// $asus = new asus("Asus","Aqua");
// $asus->pertanyaan();


// overridden inheritance method
class elektronik {
    public $merk;
    public $warna;

    public function __construct($merk, $warna)
    {
        $this->merk = $merk;
        $this->warna = $warna;
    }

    protected function deskripsi(){
        echo "Elektronik ini bermerk {$this->merk} dan memiliki warna {$this->warna}";
    }
}

class asus extends elektronik {
    public function pertanyaan(){
        echo "Apaka elektronik ini laptop/hp? <br>";
        $this->deskripsi();
    }
}

$asus = new asus("Asus","Aqua");
$asus->pertanyaan();
?>