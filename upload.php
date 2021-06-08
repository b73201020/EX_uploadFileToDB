<!DOCTYPE html>
<html lang="zh-Hant-TW">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload File to MySQL</title>
</head>
<body>

<form method="post" enctype="multipart/form-data">
<table width="350" border="0" cellpadding="1" cellspacing="1" class="box">
    <tr>
    <td width="246">
    <input type="hidden" name="MAX_FILE_SIZE" value="2000000">
    <input name="userfile" type="file" id="userfile">
    </td>
    <td width="80"><input name="upload" type="submit" class="box" id="upload" value=" Upload "></td>
    </tr>
</table>
</form>


<?php 
// 上傳狀態且檔案大小>0
if(isset($_POST['upload']) && $_FILES['userfile']['size'] > 0){
    $fileName = $_FILES['userfile']['name'];
    $tmpName  = $_FILES['userfile']['tmp_name'];
    $fileSize = $_FILES['userfile']['size'];
    $fileType = $_FILES['userfile']['type'];

    $fp      = fopen($tmpName, 'r');
    $content = fread($fp, filesize($tmpName));
    $content = addslashes($content);
    fclose($fp);


    /*
    magic_quotes_gpc函式在php中的作用是判斷解析使用者提示的資料，
    如包括有:post、get、cookie過來的資料增加轉義字元“\”，以確保這些資料不會引起程式，
    特別是資料庫語句因為特殊字元(單引號，雙引號，反斜線）引起的汙染而出現致命的錯誤。

    get_magic_quotes_runtime()設定和檢測php.ini檔案中magic_quotes_runtime狀態。
    get_magic_quotes_gpc()檢測系統設定。如果沒有開啟這項設定，可以使用
    addslashes()函式新增，它的功能就是給資料庫查詢語句等的需要在某些字元前加上了反斜線。
    這些字元是單引號（’）、雙引號（”）、反斜線（\）與 NUL（NULL 字元）。

    */

    if(!get_magic_quotes_gpc())
    {
        $fileName = addslashes($fileName);
    }

    include 'config.php';
    include 'opendb.php';

    // 檔案寫入資料庫
    $query = "INSERT INTO filetb (name, size, type, content ) ".
    "VALUES ('$fileName', '$fileSize', '$fileType', '$content')";

    $result = $mysqli->query($query) or die('Error, query failed');

    include 'closedb.php';

    echo "<br>File $fileName uploaded<br>";
}
?>

<a href="upload.php">upload file</a> <a href="download.php">download file</a> 
</body>
</html>