<?php
if (isset($_GET['link'])) {
    $encodedLink = $_GET['link'];
    $link = base64_decode($encodedLink);

    // Comprueba si es un enlace de YouTube
    if (preg_match('/^https:\/\/www\.youtube\.com\/embed\/[a-zA-Z0-9_-]+/', $link)) {
        header('Content-Type: text/html');
        echo file_get_contents($link);
    }
    // Aquí puedes agregar más comprobaciones para otros servicios, como Uptobox
}