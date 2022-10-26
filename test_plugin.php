<?php

/**
 * Plugin Name: Test plugin
 * Description: [hello_world] shortcode to print Hello World
 */

if (!defined('ABSPATH')) {
    die('You\'re not human');
}

if (!empty($_POST)) {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $nameDB = "test";
    $page = $_SERVER['PHP_SELF'];

    $conn = new mysqli($servername, $username, $password, $nameDB);

    if ($conn->connect_error) {
        die();
    }

    $nome = $_POST['nome'];
    $cognome = $_POST['cognome'];

    $sql = "INSERT INTO utenti(nome, cognome) VALUES ('" . $nome . "', '" . $cognome . "');";

    if ($conn->query($sql) === TRUE) { 

        echo "<script> window.location='" . $page . "' </script>";

    } else {
        die();
    }

} 



function display_form()
{ ?>

        <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">

            <label for="nome"> Nome </label>
            <input type="text" name="nome" required>
            <br>
            <label for="cognome"> Cognome </label>
            <input type="text" name="cognome" required>
            <br>

            <input onclick="check_field()" type="submit" value="Submit">
        </form>

<?php

}


add_shortcode('insert-form', 'display_form');
