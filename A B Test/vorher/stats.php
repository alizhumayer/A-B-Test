<?php
require_once __DIR__ . "/inc/functions.php";
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Statistik</title>
        <link rel="stylesheet" type="text/css" href="./css/styles.css" />
    </head>
    <body>
        <div id="container">
            <h1>Statistiken</h1>

            <?php $stats = visitor_stats(); ?>
            <table>
                <thead>
                    <tr>
                        <th>Farbe</th>
                        <th>Insgesamt</th>
                        <th>Erfolgreich</th>
                        <th>Quote</th>
                    </tr>
                </thead>
                <?php foreach($stats AS $color => $count): ?>
                    <?php
                        $total = $count['total'];
                        $success = $count['success'];
                    ?>
                    <tr>
                        <th><?php echo $color; ?></th>
                        <td><?php echo $total; ?></td>
                        <td><?php echo $success; ?></td>
                        <td><?php echo round(($success / $total) * 100); ?>%</td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </body>
</html>