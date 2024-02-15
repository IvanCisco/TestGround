<?php

$sql = "SELECT zona
        FROM operainfatt
        WHERE mail = '$mail'";

$risultato = $conn->query($sql);
if ($risultato->num_rows >= 0) {
    $zone = [];
    while($row = $risultato->fetch_assoc()) {
        $zone[] = $row['zona'];
    }

    for ($i = 1; $i <= 5; $i++) {
        echo "<input type=\"checkbox\" id=\"zone_$i\" name=\"zone[]\" value=\"$i\"";
        if (in_array(strval($i), $zone)) {
            echo "checked";
        }
        echo "><label for=\"zone_$i\">$i</label><br>";
    }
}
?>