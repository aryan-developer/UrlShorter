<?php
require_once "UrlShorter.php";
use AryanDev\UrlShorter\UrlShorter;
$urlShorter = new UrlShorter(array(
    "dbname" => "url",
    "username" => "root",
    "password" => ""
));
if ($_GET["path"] == ""){
    $showAlertSuccess = isset($_POST["url"]) and !empty($_POST["url"]);
    $showAlertWarning = false;
    if ($showAlertSuccess) {
        /**
         * Call Once For Create Table
         */
        //$urlShorter->create_table();

        /**
         * Call For Add new Url
         */
        $url = $urlShorter->insertNewUrl($_POST["url"],$_SERVER["REQUEST_URI"],$_SERVER["HTTP_ORIGIN"]);
    }
}else{
    /**
     * Go To URL
     */
    if(sizeof($urlShorter->getUrl($_GET["path"]))!=0){
        $link = json_decode(json_encode($urlShorter->getUrl($_GET["path"])),true)[0]["url"];
    }else{
        $showAlertWarning = true;
        $showAlertSuccess = false;
        $data = "همچین لینکی پیدا نشد!";
    }
}
?>
<!doctype html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>URLShorter</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css">
    <style>
        .fullscreen {
            width: 100vw;
            height: 100vh;
        }
    </style>
</head>
<body>
<section class=" container-fluid "
         style="background-color:#ececec;">
    <div class="row d-flex justify-content-center fullscreen align-items-center p-2">
        <?php
        if ($showAlertSuccess) {
            echo '
            <div class="alert alert-dismissible alert-success fade show">
            '."<a href='$data' class='alert-link'>$data</a>".'
             <span class="btn-close" data-bs-dismiss="alert"></span>
            </div>
        ';
        }
        if($showAlertWarning){
            echo '
            <div class="alert alert-dismissible alert-warning fade show">
            '."<h6 dir='rtl'>$data</h6>".'
             <span class="btn-close" data-bs-dismiss="alert"></span>
            </div>
        ';
        }
        ?>
    <div class="col-xl-8 col-lg-8 col-11 bg-light h-75 justify-content-center align-items-center d-flex row">
        <form action="" method="post" class="text-center col-12">
            <label for="url" class="form-label"> URL: </label>
            <input type="url" name="url" id="url" required class="form-control">
            <button class="btn btn-outline-danger m-2"> کوتاهش کن</button>
        </form>
    </div>
    </div>
    
</section>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>
</html>
