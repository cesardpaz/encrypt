<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        Encrypted Links
    </title>
</head>
<body>
    
<?php $links = [
    'https://www.youtube.com/embed/gAKGCC2S638',
    'https://www.youtube.com/embed/0R4xyAuz_Nk',
    'https://uptobox.com/pvo32ch3e9ww'
]; ?>

<ul>
    <?php
        foreach($links as $k => $link) { ?>
            <li>
                <a onClick="showVideo('<?php echo base64_encode($link); ?>')">
                   Link <?php echo $k+1; ?>
                </a>
            </li>
        <?php }
    ?>
</ul>

<div class="res"></div>

<script>
    function showVideo(encodedLink){
        console.log(encodedLink);
        let iframe = `<iframe width="560" height="315" src="video.php?link=${encodedLink}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>`;
        document.querySelector('.res').innerHTML = iframe;
    }
</script>

</body>
</html>