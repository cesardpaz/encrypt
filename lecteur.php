<?php

require_once 'encrypt_decrypt_functions.php';


/*
    FUNCIONES ENCRIPTAR
*/
function base64url_encode($data) {
    return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
}

function encriptarData($string){
    $config = array();
$config['encrypted_password'] = '!@#(!@+SD_asd23sd@#!)#@!@29319230ASDkALSDja012031';
    $pass = $config['encrypted_password'];
	$method = 'aes128';
	return base64url_encode(@openssl_encrypt($string, $method, $pass));
}

function cifrar($txt){
	$txt = encriptarData($txt);
	return $txt;
}

function base64url_decode($data) {
	return base64_decode(str_pad(strtr($data, '-_', '+/'), strlen($data) % 4, '=', STR_PAD_RIGHT));
}

function desencriptarData($string){
	$config = array();
$config['encrypted_password'] = '!@#(!@+SD_asd23sd@#!)#@!@29319230ASDkALSDja012031';
	$string = base64url_decode($string);
	$pass = $config['encrypted_password'];
	$method = 'aes128';
	$data = @openssl_decrypt($string, $method, $pass);
	if(empty($data)) return false;
	//
	return $data;
}

function descifrar($txt){
	$txt = desencriptarData($txt);
	return $txt;
}

function get_server_info($link){
	$data = array(
		'link' => $link,
		'icono' => null,
		'name' => null,
		'txt' => null
	);

	if(strpos($link, 'fembed') !== false or strpos($link, 'feurl') !== false or strpos($link, 'femax') !== false){
		$data['icono'] = 'fembed.png';
		$data['name'] = 'fembed';
		$data['txt'] = 'Serveur rapide - 2 pop';
		$data['link'] = 'https://pelispluss.net/sc/?h='.cifrar($data['link']);
		$data['link'] = str_replace('//pelispluss.net/','//gnula.club/',$data['link']);
	} elseif(strpos($link, 'streamtape') !== false){
		$data['icono'] = 'streamtape.png';
		$data['name'] = 'streamtape';
		$data['txt'] = 'Serveur rapide - 4 pop';
		$data['link'] = 'https://pelispluss.net/sc/?h='.cifrar($data['link']);
		$data['link'] = str_replace('//pelispluss.net/','//gnula.club/',$data['link']);
	} elseif(strpos($link, 'evoload') !== false){
		$data['icono'] = 'uqload.png';
		$data['name'] = 'evoload';
		$data['txt'] = 'Serveur rapide - 1 pop';
		$data['link'] = 'https://pelispluss.net/sc/?h='.cifrar($data['link']);
		$data['link'] = str_replace('//pelispluss.net/','//gnula.club/',$data['link']);
 
	} elseif(strpos($link, 'mega') !== false){
		$data['icono'] = 'mega.png';
		$data['name'] = 'mega';
		$data['txt'] = 'Serveur rapide';
	} elseif(strpos($link, '1fichier') !== false){
		$data['icono'] = '1fichier.png';
		$data['name'] = '1fichier';
		$data['txt'] = 'Serveur rapide';
	} elseif(strpos($link, 'uptobox') !== false){
		$data['icono'] = 'uptobox.png';
		$data['name'] = 'uptobox';
		$data['txt'] = 'Serveur rapide';
	} elseif(strpos($link, 'upstream') !== false){
		$data['icono'] = 'upstream.jpg';
		$data['name'] = 'upstream';
		$data['txt'] = 'Serveur rapide';
	} elseif(strpos($link, 'mediafire') !== false){
		$data['icono'] = 'mediafire.png';
		$data['name'] = 'mediafire';
		$data['txt'] = 'Serveur rapide';
	} elseif(strpos($link, 'doodstream') !== false){
		$data['icono'] = 'doostream.png';
		$data['name'] = 'doostream';
		$data['txt'] = 'Serveur rapide';
	} elseif(strpos($link, 'netutv') !== false){
		$data['icono'] = 'netutv.jpg';
		$data['name'] = 'netutv';
		$data['txt'] = 'Serveur rapide';
	} elseif(strpos($link, 'streamlare') !== false){
		$data['icono'] = 'streamlare.jpg';
		$data['name'] = 'streamlare';
		$data['txt'] = 'Serveur rapide';
	} elseif(strpos($link, 'streamsb') !== false){
		$data['icono'] = 'streamsb.png';
		$data['name'] = 'streamsb';
		$data['txt'] = 'Serveur Ultra rapide';
	} elseif(strpos($link, 'sbbrisk') !== false){
		$data['icono'] = 'streamsb.png';
		$data['name'] = 'streamsb';
		$data['txt'] = 'Serveur Ultra rapide';
	} elseif(strpos($link, 'tomacloud.com') !== false){ 
        $data['icono'] = 'streamsb.png';
		$data['name'] = 'Coflix VIP / Pas de publicité';
		$data['txt'] = 'Français - Serveur Ultra Rapide sans Publicité';
    }else {
		$name = parse_url($link, PHP_URL_HOST);
		$data['icono'] = $name.'.png';
		$data['txt'] = 'Serveur Ultra rapide - 1 pop';
		$data['name'] = $name;
	}

	if(!file_exists(__DIR__ . '/static/server/'.$data['icono'])){
		$data['icono'] = 'uqload.png';
	}

	return $data;
}


function mostrar_descargas($list, $value, $adfly_base = "https://ares.adfly.pro/#")
{
	//Declarar variables
	$html_players = "";
	$html_downloads = "";
	foreach ($list as $link) {
		$has_download = FALSE;
		$start = FALSE;
		$dd_link = "";
		$server_info = get_server_info($link);
		if ($server_info['name'] == 'streamtape') {
			continue;
		}
		//Verificar si el servidor es valido para descargas
		if ($server_info['name'] == 'uqload.co') {
			$start = TRUE;
			//Indicar que tiene opcion de descarga
			$has_download = TRUE;
			//Obtener enlace equivalente a la descarga
			$dd_link = str_replace("embed-", "", $server_info['link']);
			//Agregar acortador al enlace
			$dd_link = $adfly_base . base64_encode(base64_encode(base64_encode($dd_link)));
		} else if ($server_info['name'] == 'fembed') {
			//Indicar que tiene opcion de descarga
			$has_download = TRUE;
			//Obtener enlace equivalente a la descarga            
			$dd_link = str_replace("/?h", "/d.php?d", $server_info['link']);
			//Agregar acortador al enlace
			$dd_link = $adfly_base . base64_encode(base64_encode(base64_encode($dd_link)));
		}

		//Si existe opcion de descarga, agregar al texto de descargas
		if ($has_download) {
			$temporal = "";
			if ($start) {
				$temporal = $html_downloads;
				$html_downloads = "";
			}
			$html_downloads .= '<li onclick="go_to_player(\'' . $server_info['link'] . '\')">';
			$html_downloads .= '<a href="' . $dd_link . '" target="_blank">';
			$html_downloads .= '<img src="static/server/' . $server_info['icono'] . '">';
			$html_downloads .= '</a>';
			$html_downloads .= '<a href="' . $dd_link . '" target="_blank">';
			$html_downloads .= '<span>' . $server_info['name'] . '</span>';
			$html_downloads .= '<p>' . $value . ' - Opción para descargar</p>';
			$html_downloads .= '</a></li>';
			$html_downloads .= $temporal;
		}
		//Si existe opcion de descarga, agregar al texto de reproductores
		$html_players .= '<li onclick="go_to_player(\'' . $server_info['link'] . '\')">';
		$html_players .= '<img src="static/server/' . $server_info['icono'] . '">';
		$html_players .= '<span>' . $server_info['name'] . '</span>';
		$html_players .= '<p>' . $value . ' - ' . $server_info['txt'] . '</p></li>';
	}
	//Pintar HTML de descargas
	echo $html_downloads;
	//Pintar HTML de reproductores
	echo $html_players;
}

$first = true;

?>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Player</title>
    <link href="static/iframe.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto+Condensed:300,400,700" rel="stylesheet">
    <meta name="robots" content="noindex,nofollow">

    <style>
        .OD.OD_FR.REactiv{
            display: flex;
            flex-wrap: wrap;
        }
        .OD.OD_FR.REactiv > li {
            width: 100%;
        }
        .order-0 {
            order: 0;
        }
        .order-1 {
            order: 1;
        }
        .order-2 {
            order: 2;
        }
        .order-3 {
            order: 3;
        }
        .order-4 {
            order: 4;
        }
        .order-5 {
            order: 5;
        }
    </style>
</head>


<?php

$dts = [];
if(isset($language_options) and !empty($language_options) and is_array($language_options)){
	foreach($language_options as $key => $value){
      
		/*
		1fitchier, uploaded, uptobox, uqload, upstream, google drive, mega, fembed, upfiles
		*/
		if(isset($data_link['data']['embeds'][$key]) or isset($data_link['data']['embeds'][$key])){
			foreach($data_link['data']['embeds'][$key] as $link){
 		        if ( strpos($link, 'streamtape') !== false ){
                } else {
                    if ( strpos($link, '1fichier') !== false ||
                        strpos($link, 'uploaded') !== false ||
                        strpos($link, 'uptobox') !== false ||
                        strpos($link, 'google drive') !== false ||
                        strpos($link, 'mega') !== false ||
                        strpos($link, 'mediafire') !== false ||
                        strpos($link, 'upfiles') !== false
                    ) {
                        $server_info = get_server_info($link);
                        $dts[] =[
                            'lang' => $key,
                            'link' => $link,
                            'server' => $server_info,
                        ];
                    } elseif(strpos($link, 'upstream') !== false){

                        if(strpos($link, 'upstream.to/embed') !== false){

                        } else{
                        $server_info = get_server_info($link);
                            $dts[] =[
                                'lang' => $key,
                                'link' => $link,
                                'server' => $server_info,
                            ];
                        }

                    }
                }
			}

		}
	}
}

?>

<body class="directAc" style="">
    <div id="DisplayContent">
        <div id="PlayerDisplay">
            <div class="wpw"
                style="background-image: linear-gradient(rgba(16, 16, 23, 59%), #000000), url('<?php echo htmlentities($data_link['data']['poster_link']); ?>'); background-size: 100%; background-repeat: no-repeat;">
            </div>
            <div class="SelectLangDisp">
                <?php
				if(isset($language_options) and !empty($language_options) and is_array($language_options)){
					foreach($language_options as $key => $value){
						if(!isset($data_link['data']['embeds'][$key]) or empty($data_link['data']['embeds'][$key])) continue; ?>
						<li onclick="SelLang(this, '<?php echo $key; ?>');"
							class="<?php if($first === true){ echo 'SLD_A'; $first = false; } ?>"><img
							src="static/lang/<?php echo $key; ?>.png"></li>
					<?php }
				} ?>

				<li style="
					width: auto;
					height: auto;
					border-radius: inherit;
					box-shadow: none;
					font-size: 18px;
					padding: 10px 20px;
					background: #000000bf;
					border-radius: 6px;
				" onclick="SelLang(this, 'down');">Télécharger</li>
            </div>
            <div class="OptionsLangDisp">
                <div class="ODDIV">

					<?php
					$first = true;
					if(isset($language_options) and !empty($language_options) and is_array($language_options)){
						foreach($language_options as $key => $value){

							if(!isset($data_link['data']['embeds'][$key]) or empty($data_link['data']['embeds'][$key])) continue; ?>
								<div class="OD OD_<?php echo $key; ?> <?php if($first === true){ echo 'REactiv'; $first = false; } ?>">
									<?php
									if (isset($_SERVER['HTTP_REFERER']) && strpos($_SERVER['HTTP_REFERER'], "seriesyonkis.cx") !== false) {
										mostrar_descargas($data_link['data']['embeds'][$key], $value);
									} else { ?>
                                        <?php
                                        $list = [];

                                        foreach($data_link['data']['embeds'][$key] as $link){

                                            if (  strpos($link, 'nodispounnnerbler') !== false ||  strpos($link, 'streamtape') !== false){

                                            } else{

                                                if( strpos( $link, 'streamsb' ) !== false || strpos( $link, 'sbanh' ) !== false || strpos($link, 'tomacloud') !== false ){
                                                    $orderClass = 'order-0';
                                                } //uqload
                                                elseif( strpos( $link, 'uqload' ) !== false ){
                                                    $orderClass = 'order-1';
                                                } //upstream
                                                elseif( strpos( $link, 'upstream' ) !== false ){
                                                    $orderClass = 'order-2';
                                                } //fembed
                                                elseif( strpos( $link, 'fembed' ) !== false ){
                                                    $orderClass = 'order-3';
                                                } //dood
                                                elseif( strpos( $link, 'dood' ) !== false ){
                                                    $orderClass = 'order-4';
                                                } else{
                                                    $orderClass = 'order-5';
                                                }

                                                $server_info = get_server_info($link);
                                                if ($server_info['name'] == 'streamtape'){
                                                    continue;
                                                } ?>

                                                <?php
                                                if (  strpos($link, '1fichier') !== false ||
                                                    strpos($link, 'uploaded') !== false ||
                                                    strpos($link, 'uptobox') !== false ||
                                                    strpos($link, 'google drive') !== false ||
                                                    strpos($link, 'mega') !== false ||
                                                    strpos($link, 'mediafire') !== false ||
                                                    strpos($link, 'upfiles') !== false
                                                ) {

                                                } elseif(strpos($link, 'upstream') !== false){

                                                    if(strpos($link, 'upstream.to/embed') !== false){

                                                            ?>

                                                    <li class="<?php echo $orderClass; ?>" onclick="showVideo('<?php echo base64_encode($server_info['link']); ?>')">
                                                        <img src="static/server/<?php echo $server_info['icono']; ?>">
                                                        <span><?php echo $server_info['name']; ?></span>
                                                        <p><?php echo $value; ?> - <?php echo $server_info['txt']; ?></p>
                                                    </li>

                                                        <?php }

                                                } else {

                                                    ?>
                                                    <li class="<?php echo $orderClass; ?>" onclick="showVideo('<?php echo base64_encode($server_info['link']); ?>')">
                                                        <img src="static/server/<?php echo $server_info['icono']; ?>">
                                                        <span><?php echo $server_info['name']; ?></span>
                                                        <p><?php echo $value; ?> - <?php echo $server_info['txt']; ?></p>
                                                    </li>
                                                <?php }
                                            }
                                        }
									} ?>
								</div>
						<?php }
					} ?>

					<?php if(count($dts > 0)){ ?>
						<div class="OD OD_down">
							<?php foreach($dts as $dt){ ?>
								<li>
									<a target="_blank" href="<?php echo $dt['link'] ?>">
										<img src="static/server/<?php echo $dt['server']['icono']; ?>">
										<span><?php echo $dt['server']['name']; ?></span>
										<p><?php echo $language_options[$dt['lang']]; ?> - <?php echo $dt['server']['txt']; ?></p>
									</a>
								</li>
							<?php } ?>
						</div>
					<?php } ?>
                </div>

            </div>
        </div>
        <div class="FirstLoad"></div>
        <div class="BotHumano"></div>
        <div class="DisplayVideo"></div>
    </div>

    <script src="static/iframen2.js"></script>

    <script>
        function showVideo(encodedLink){
            console.log(encodedLink);
            let iframe = `<iframe id="IFR" src="video.php?link=${encodedLink}" frameborder="0" allowfullscreen="true" webkitallowfullscreen="true" mozallowfullscreen="true"></iframe>`;

            var displayVideo = document.querySelector(".DisplayVideo");
        displayVideo.classList.add('DisplayVideoA');
        displayVideo.innerHTML = `
        <span onclick="listPlayer();">
            <img src="https://imagizer.imageshack.com/img923/3885/l1Thrs.png">
        </span>`;

        displayVideo.innerHTML +=iframe;
        }
    </script>
</body>

</html>