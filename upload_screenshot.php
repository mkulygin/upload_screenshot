<?php
if($_SERVER['REQUEST_METHOD'] == 'GET'){
?>

<html>
<head>
    <meta charset="utf-8" />
    <title>Screen shoter</title>
    <script src="http://yastatic.net/jquery/2.1.3/jquery.min.js"></script>
</head>
<body>

<div>Click this pane, and paste a screenshot from clipboard.</div>

<script>

    $('html').bind('paste', function(e) {
        e.preventDefault();
        var item = (e.clipboardData || e.originalEvent.clipboardData).items[0];
        var type = item.type.split('/').shift();
        if (type == "image"){
            var blob = item.getAsFile();
            var url = URL.createObjectURL(blob); // Blob
            var reader = new FileReader();
            reader.onload = function(event){
                var blob2 = event.target.result; //event.target.results contains the base64 code to create the image
                $.ajax({
                    url: 'http://msk1-mcdev09.synergy.local/test_upload_screenshot2.php',
                    type: "POST",
                    data: { image: {blob2} },
                    success: function(data,status) {
                        alert("Status: " + status + " data: " + data);
                    }
                });
            };
            reader.readAsDataURL(blob); //Convert the blob from clipboard to base64
        }
        if (type == 'text'){
            //alert("You cannot insert text from clipboard. You must make a screenshot (Alt+PrtScn)");
        }
    });

</script>
</body>
</html>

<?
}

// Decode Base64 and save to file
define('UPLOAD_DIR', '/var/www/html/mc2/mc_2.0/public/attached_files/tmp/dialogscreenshot/');
$error = '';
($_SERVER['REQUEST_METHOD'] != 'POST') ? $error .= "For uploading use only POST method. Used ".$_SERVER['REQUEST_METHOD'].' method.' : null ;
(!isset($_POST['image'])) ? $error .= " POST['image'] is empty." : null ;

// show errors and warnings
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    echo $error;
}

if(isset($_POST['image']) && $_SERVER['REQUEST_METHOD'] == 'POST'){
    foreach ($_POST['image'] as $img) {
        $img = str_replace('data:image/png;base64,', '', $img);
        $data = base64_decode($img);
        $file = UPLOAD_DIR . uniqid() . '.png';
        $success = file_put_contents($file, $data);
        $data1[] = $file;
    }
    echo json_encode($data1);
}
?>