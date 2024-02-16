<?php
    include("../common/connessione.php");
    session_start();
?>
<!DOCTYPE html>
<html lang="it">
    <head>
        <title>Menu del Ristorante</title>
        <link rel="stylesheet" type="text/css" href="../css/stile.css">
        <script src="../js/navbar.js"></script>
        <script src="../js/javascript.js"></script>
    </head>
    <body>
        <?php include("../common/navbar_ristorante.php"); ?>
        <h1>Il tuo menu</h1>
        <section class="page-content">
        <?php
        if (isset($_SESSION['utente'])) {
            $mail = $_SESSION['utente'];
            //visualizzo il menu del ristorante
            $stmt = $conn->prepare("SELECT nome,prezzo,descrizione,tipo,elenco,immagine FROM pietanza WHERE mail = ?");
            $stmt->bind_param("s", $mail);
            $stmt->execute();
            $result = $stmt->get_result();
            
            $mailmod = str_replace(['@', '.'], '', $mail);
            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    //stampo le pietanze di quel ristorante
                    echo "<p class=\"menu-item\" id=\"" . $mail . str_replace(' ', '', $row['nome']) . str_replace('.', '', $row['prezzo']) . "\"> " . $row['nome'] . " - " . $row['prezzo'] . " - " . $row['descrizione'] . " - " . $row['tipo'] . " - " . $row['elenco'] . "";
                    echo "<img src='{$row['immagine']}' style='max-width: 150px; max-height: 150px; margin-left: auto; margin-right: auto;display: inline-block; vertical-align: middle;'>";
                    echo "<img src='../immagini/delete-icon2.png' onclick=\"confirmDelete('$mail','{$row['nome']}', '{$row['prezzo']}','{$row['descrizione']}')\" alt='Delete'></img></p>";
        ?>
                    <div class="modal" id="myModal">
                        <div class="modal-content">
                            <span class="close" onclick="closeModal()">&times;</span>
                            <p id="modalMessage"></p>
                        </div>
                    </div>
                    <?php
                }
            } else {
                echo "No menu items found.";
            }
            $conn->close();
        } else {
            // Reindirizzo al login
            header("Location: ../login.php");
            exit();
        }
        ?>
    </section>
        <?php include("../common/footer.html"); ?>
    </body>
</html>
