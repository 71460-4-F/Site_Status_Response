<?php

$file = 'file.txt';
$ip = '';
$status = '';
$color = '';
$host = '';
$msg = '';

if (isset($_REQUEST['host']) && !empty($_REQUEST['host'])) {

    $host = $_REQUEST['host'];
    $host = preg_replace("(^https?://)", "", $host);
    $host = trim($host, '/');

    $myfile = fopen($file, "w") or die("Unable to open file!");
    $txt = $host;
    fwrite($myfile, $txt);
    fclose($myfile);
}

if (filesize($file) > 0) {
    $domain = file_get_contents($file);
    if (checkdnsrr($domain, "MX")) {
        $status = "Site Online";
        $color = "green";
    } else {
        $status = "Site Offline";
        $color = "brown";
    }

    $host = file_get_contents($file);
    if (str_contains($host, 'http') == false) {
        $host = 'https://' . file_get_contents($file);
    }
    $msg = 'Host monitorado: ';
}

?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="refresh" content="15">
    <title>Site Status</title>
    <link rel="stylesheet" href="style/stilo.css">
</head>

<body>
    <div id="i_form">
        <div>
            <h1>Status Site Response</h1>
        </div>
        <div>
            <form method="POST">
                <div>
                    <input type="text" name="host" id="id_site" maxlength="50" placeholder="informe o host" required>
                </div>
                <div>
                    <button id="botao" type="submit">OK</button>
            </form>
        </div>
    </div>
    <div>
        <div>
            <h3>
                <?php echo $msg ?>
                <a href="<?php echo $host ?>" target="_blank"><?php echo $host ?></a>
            </h3>
        </div>
        <div id="status">
            <h3 style="color: <?php echo $color ?>;">
                <?php echo $status ?>
            </h3>
        </div>
    </div>
</body>

</html>