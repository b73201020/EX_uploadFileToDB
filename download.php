<?php
if(isset($_GET['id'])){
    // if id is set then get the file with the id from database
    // 如果 id 有值，則從 database 取回檔案
    $id    = $_GET['id'];

    include 'config.php';
    include 'opendb.php';

    $query = "SELECT name, type, size, content " .
            "FROM filetb WHERE id = '$id'";

    $result = $mysqli->query($query) or die('Error, query failed');

    if($result->num_rows == 0){  // 檔案編號不存在
        echo "File with id = $id doesn't exist. <br>";
    }
    else{
        list($name, $type, $size, $content) = $result->fetch_array(MYSQLI_NUM);

        header("Content-length: $size");
        header("Content-type: $type");
        header("Content-Disposition: attachment; filename=$name");
        echo $content;

        include 'closedb.php';
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="zh-Hant-TW">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Download File from MySQL</title>
</head>
<body>
<?php
    // 沒有設定 id
    include 'config.php';
    include 'opendb.php';

    $query = "SELECT id, name FROM filetb";
    $result = $mysqli->query($query) or die('Error, query failed');
    
    //取出所有檔案的編號及名稱
    echo "<h2>File name:</h2>";
    if($result->num_rows == 0){
        echo "Database is empty <br>";
    }
    else{
        echo "<ul>";
        while(list($id, $name) = $result->fetch_array(MYSQLI_NUM)){
            echo '<li><a href="download.php?id='.$id.'">'.$name.'</a> </li>';
        }
        echo "</ul>";
    }
    include 'closedb.php';
?>

<a href="upload.php">upload file</a> <a href="download.php">download file</a> 
</body>
</html>



