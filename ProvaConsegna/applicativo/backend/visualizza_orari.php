<?php
$sql = "SELECT giorno, orainizio, orafine
        FROM  turno
        WHERE id IN (
            SELECT turno
            FROM $tabella
            WHERE mail = '$mail');";
$risultato = $conn->query($sql);
if ($risultato->num_rows > 0) {
    while($row = $risultato->fetch_assoc()) {
        echo "<p>" . $row['giorno'] . "   " . $row['orainizio'] . " - " . $row['orafine'] . "</p>";
    }
} else {
    echo "<p>Non ci sono orari da mostrare.</p>";
}
?>