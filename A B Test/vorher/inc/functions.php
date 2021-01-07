<?php

require_once __DIR__ . "/database.php";

session_start();
date_default_timezone_set("Europe/Berlin");

function number_of_entries() 
{
    global $pdo;
    $stmt = $pdo->prepare("SELECT COUNT(*) AS c FROM `visitors`");
    $stmt->execute();

    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    return $row['c'];
}

function should_run_ab_test($x) 
{
    if ($x < 50) return true;

    $y = 50 / $x;

    // Generiere Zufallszahl zwischen 0 und 1
    $rand = rand() / getrandmax();

    if ($rand < $y) {
        return true;
    } else {
        return false;
    }
}

function get_best_color() 
{
    $stats = visitor_stats();
    
    $bestColor = null;
    $bestQuota = 0;
    foreach($stats AS $color => $colorInfo) {
        $quota = $colorInfo['success'] / $colorInfo['total'];
        if ($quota > $bestQuota) {
            $bestQuota = $quota;
            $bestColor = $color;
        }
    }
    return $bestColor;
}


function create_visitor() 
{
    global $pdo;

    $color = null;
    if (rand(0, 1) == 0) {
        $color = "blue";
    } else {
        $color = "green";
    }

    $stmt = $pdo->prepare("INSERT INTO `visitors` (`color`, `timestamp`) VALUES(:color, :timestamp)");
    $stmt->bindParam(":color", $color);
    $stmt->bindParam(":timestamp", date("Y-m-d H:i:s"));
    $stmt->execute();

    $id = $pdo->lastInsertId();
    return $id;
}

function visitor_color($id) 
{
    global $pdo;

    $stmt = $pdo->prepare("SELECT `color` FROM `visitors` WHERE `id`=:id");
    $stmt->bindParam(":id", $id);
    $stmt->execute();

    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if (empty($row)) {
        return "green";
    } else {
        return $row["color"];
    }
}

function visitor_success($id)
{
    global $pdo;
    $stmt = $pdo->prepare("UPDATE `visitors` SET `success` = :success WHERE `id` = :id");
    $stmt->bindParam(":id", $id);
    $stmt->bindParam(":success", date("Y-m-d H:i:s"));
    $stmt->execute();
}

function visitor_stats()
{
    global $pdo;

    $successStmt = $pdo->prepare(
        "SELECT `color`, COUNT(*) AS c FROM `visitors` 
         WHERE `success` IS NOT NULL GROUP BY `color`"
    );
    $successStmt->execute();

    $success = [];
    while($row = $successStmt->fetch(PDO::FETCH_ASSOC)) {
        $color = $row["color"];
        $c = $row["c"];
        $success[$color] = $c;
    }


    $allStmt = $pdo->prepare(
        "SELECT `color`, COUNT(*) AS c FROM `visitors` GROUP BY `color`"
    );
    $allStmt->execute();

    $all = [];
    while($row = $allStmt->fetch(PDO::FETCH_ASSOC)) {
        $color = $row["color"];
        $c = $row["c"];
        $all[$color] = $c;
    }

    /*
    var_dump($all); // $all = ["green" => 10]
    var_dump($success); // $success = ["green" => 5]
    */

    $data = [];
    foreach($all AS $key => $value) {
        $data[$key] = [
            'total' => $value
        ];
    }
    foreach($success AS $key => $value) {
        $data[$key]['success'] = $value;
    }

    return $data;
}

?>