<?php
if (isset($_GET['link'])) {
    $encodedLink = $_GET['link'];
    $link = base64_decode($encodedLink);
?>
    <iframe  src="<?php echo $link; ?>" frameborder="0" allowfullscreen="true" webkitallowfullscreen="true" mozallowfullscreen="true"></iframe>
<?php } ?>