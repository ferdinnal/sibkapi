<?php

ServerConfig();

$PdfUploadFolder = '../file/';

$ServerURL = 'http://192.168.18.9/nambahilmusukaresikapi/'.$PdfUploadFolder;

if ($_SERVER['REQUEST_METHOD']=='POST') {
    if (isset($_POST['name']) and isset($_FILES['pdf']['name'])) {
        $con = mysqli_connect(HostName, HostUser, HostPass, DatabaseName);

        $PdfName = $_POST['name'];

        $PdfInfo = pathinfo($_FILES['pdf']['name']);

        $PdfFileExtension = $PdfInfo['extension'];

        $PdfFileURL = GenerateFileNameUsingID() . '.' . $PdfFileExtension;

        $PdfFileFinalPath = $PdfUploadFolder . GenerateFileNameUsingID() . '.'. $PdfFileExtension;


        // $id_guru = $_POST['id_guru'];
        // $id_kelas = $_POST['id_kelas'];
        // $id_mata_pelajaran = $_POST['id_mata_pelajaran'];
        // $id_pertemuan = $_POST['id_pertemuan2'];
        // $nama_materiNa = $_POST['nama_materi'];

        try {
            move_uploaded_file($_FILES['pdf']['tmp_name'], $PdfFileFinalPath);
            // $InsertTableSQLQuery = "INSERT INTO materi (id_materi,file_link, nama_materi,id_guru,id_kelas,id_mata_pelajaran,id_pertemuan) VALUES (null,'$PdfFileURL', '$nama_materiNa','$id_guru','$id_kelas','$id_mata_pelajaran','$id_pertemuan') ";
            // echo "New record created successfully";
            // mysqli_query($con, $InsertTableSQLQuery);
            echo "New record created successfully";
        } catch (Exception $e) {
            echo "Gagal";
        }
        mysqli_close($con);
    }
}

function ServerConfig()
{
    define('HostName', 'localhost');
    define('HostUser', 'root');
    define('HostPass', '');
    define('DatabaseName', 'db_nambah_ilmu');
}

function GenerateFileNameUsingID()
{
    $con2 = mysqli_connect(HostName, HostUser, HostPass, DatabaseName);

    $GenerateFileSQL = "SELECT max(id_file_materi) as id FROM file_materi";

    $Holder = mysqli_fetch_array(mysqli_query($con2, $GenerateFileSQL));

    mysqli_close($con2);

    if ($Holder['id']==null) {
        return 1;
    } else {
        return ++$Holder['id'];
    }
}
