# SIMPEG _modified_

## Pembuka

_Bismillah_,
Aplikasi web ini adalah penyesuaian dari aplikasi yang dikembangkan oleh [Adlu Bagus Irawan](https://github.com/adlubagusi/simpeg-Sistem-Infromasi-Kepegawaian-) yang dimodifikasi untuk keperluan tugas kuliah.

## Prasyarat

Pastikan di perangkat kita telah terinstal [MySQL](https://www.mysql.com/downloads/) atau [MariaDB](https://downloads.mariadb.org/) agar dapat mengakses _database_. Gunakan juga _web server_ seperti [Apache HTTP Server](https://httpd.apache.org/download.cgi) atau [NginX](http://nginx.org/en/download.html).
Opsi lain, kita dapat menginstal [XAMPP](https://www.apachefriends.org/download.html) atau [Laragon](https://laragon.org/download/index.html) (khusus _Windows_) yang hadir dalam paket _bundle_ untuk _web server_ dan DBMS (_Database Management System_).

Selain itu, kita juga memerlukan [Composer](https://getcomposer.org/download/) untuk menginstal _library_ yang dibutuhkan, yakni [PhpSpreadsheet](https://phpspreadsheet.readthedocs.io/en/latest/). Disarankan juga untuk menginstall [Git](https://git-scm.com/downloads).

## Persiapan

Buat _database_ kosong dengan nama `simpeg`

## Pemasangan

Ada dua cara yang bisa dilakukan untuk menyalin aplikasi web ini ke perangkat kita:

1.  Dengan Git

    -   Buka `terminal`, `bash`, `cmd`, atau `git bash`
    -   Pastikan kita berada pada direktori yang kita inginkan (_folder_ _htdocs_ pada XAMPP atau _folder_ _www_ pada Laragon) untuk menyimpan aplikasi web ini
    -   Jalankan perintah:

        ```bash
        git clone git@github.com:iqbaleff214/simpeg-skp.git
        ```

    -   Aplikasi web telah terpasang di perangkat

2.  _Download_ ZIP

    -   Kita juga dapat mengunduh _file_ yang berupa zip, dengan menekan tombol Code berwarna hijau kemudian tekan _`Download ZIP`_ atau dapat juga dengan menekan [tautan ini](https://github.com/iqbaleff214/simpeg-skp/archive/main.zip).
    -   _Extract file_ zip yang telah didownload di _folder_ atau direktori yang diinginkan (_folder_ _htdocs_ pada XAMPP atau _folder_ _www_ pada Laragon).

## Konfigurasi

Kita dapat membuka aplikasi web terlebih dahulu menggunakan editor kesayangan kita masing-masing, entah itu [Visual Studio Code](https://code.visualstudio.com/download), [Sublime Text](https://www.sublimetext.com/3), atau bahkan [PhpStorm](https://www.jetbrains.com/phpstorm/download/) yang berbayar.

-   Buka `terminal`, `bash`, `cmd`, atau `git bash` dan pastikan kita telah berada di dalam _folder_ atau direktori aplikasi web ini
-   Buka _file_ `database.php` yang terletak di _folder_ `application/config/` dan lakukan penyesuaian terhadap _host_, _password_, dan nama _database_
-   Jalankan perintah:

    ```bash
    composer install
    ```


## Menjalankan

-   Untuk menjalankan aplikasi web ini, anda cukup membuka _browser_ dan ketikkan url `http://localhost/simpeg`. Pastikan _web server_ dan _database management system_ anda telah diaktifkan.

## Penutup

_Alhamdulillah_, aplikasi web ini tentunya memiliki banyak kekurangan dan masih bisa ditingkatkan lagi. Harapannya aplikasi web ini dapat menjadi bahan referensi dan dikembangkan menjadi lebih baik kedepannya.

## _Credit_
Aplikasi web ini digunakan untuk memenuhi tugas kuliah dan merupakan modifikasi dari aplikasi web buatan [Adlu Bagus Irawan](https://github.com/adlubagusi/simpeg-Sistem-Infromasi-Kepegawaian-).