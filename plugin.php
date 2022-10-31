<?php

/**
 * Plugin Name: Test plugin rubrica
 * Description: Usa [form_rubrica] come shortcode
 */

if (!empty($_POST)) {
    $conn = connect();
    if (isset($_POST["btn-submit"])) { 
        submit($conn);
    } else if (isset($_POST["btn-update"])) {
        show($conn);
    }

    $conn->close();
}

function connect()
{
    $server = "localhost";
    $user = "root";
    $password = "";
    $nameDB = "test";

    $conn = new mysqli($server, $user, $password, $nameDB);

    if ($conn->connect_error) {
        die("Errore durante la connessione al DB <br>");
    }

    return $conn;
}

function submit(mysqli $conn)
{
    $testo = $_POST["testo"];

    $sql = "INSERT INTO prova(testo) VALUES ('" . $testo . "'); ";

    if ($conn->query($sql) === FALSE) {
        die("Errore durante l'inserimento dei dati <br>");
    }

    $conn->close();
}

function show(mysqli $conn) 
{
    $sql = "SELECT * FROM prova";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        ?>
        <table>
            <tr>
                <td>ID</td>
                <td>Testo</td>
            </tr>
            <?php
            while ($row = $result->fetch_assoc()) {
                echo "
                <tr>
                    <td>".$row['id']."</td>
                    <td>".$row['testo']."</td>
                </tr>
                ";
            }
            ?>
        </table>
        <?php
    } else {
        return 
        ?>
            <h3> Non sono presenti dati all'interno del DB </h3> <br>
        <?php ;
    }
}

function form_rubrica()
{
    return
?>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">

        <label for="testo">
            Testo
        </label>

        <input name="testo" type="text" id="testo">

        <input type="submit" name="btn-submit" value="Invia">
        <input type="submit" name="btn-update" value="Modifica">

    </form>

<?php ;
}

add_shortcode('form_rubrica', 'form_rubrica');
