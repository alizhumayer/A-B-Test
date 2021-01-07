<?php
require __DIR__ . "/inc/functions.php";

if (!isset($_SESSION["visitorId"])) {
    $_SESSION["visitorId"] = create_visitor();
}

$color = visitor_color($_SESSION["visitorId"]);

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
            <div>
                Anzahl in DB: <?php echo number_of_entries(); ?><br />
                
            </div>
            <h1>Kaufe jetzt ein tolles Produkt!</h1>
            <p>
                Dieses Produkt ist unglaublich praktisch. 
                Du solltest es sofort kaufen. Schaue dir 
                dazu auf dieser Seite weitere Details zu dem
                Produkt an. Und dann kannst du entscheiden,
                ob du das Produkt kaufen möchtest. Wir sind aber
                überzeugt, es ist super. Deswegen kaufe es jetzt!
            </p>
            <?php if ($color == "blue"): ?>
                <a id="buy-button-blue" href="buy.php">Jetzt kaufen!</a>
            <?php else: ?> 
                <a id="buy-button-green" href="buy.php">Jetzt kaufen!</a>
            <?php endif; ?>
        </div>
    </body>

</html>