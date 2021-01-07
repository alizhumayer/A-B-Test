<?php
require __DIR__ . "/inc/functions.php";

$visitorId = $_SESSION["visitorId"];
visitor_success($visitorId);

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Einstiegs-Seite</title>
        <link rel="stylesheet" type="text/css" href="./css/styles.css" />
    </head>
    <body>
        <div id="container">
            <h1>Vielen Dank für deinen Einkauf</h1>
        </div>
    </body>
</html>