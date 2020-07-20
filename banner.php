<?php
require_once('librerias/ts3admin.class.php');
require_once('librerias/TeamSpeak3.php');

if (isset ($_GET['ip']) && isset ($_GET['port'])) {

    try {
    //Connection 
    	$ts3_VirtualServer = TeamSpeak3::factory("serverquery://USUARIO:CLAVE@{$_GET['ip']}:PUERTOQUERY/?server_port={$_GET['port']}");
	$useronline = $ts3_VirtualServer->virtualserver_clientsonline - $ts3->virtualserver_queryclientsonline;
  	$maxclientes = $ts3_VirtualServer->virtualserver_maxclients;
  	$clientListe = $ts3_VirtualServer->clientList(array('connection_client_ip' => $_SERVER["REMOTE_ADDR"]));

	foreach($clientListe as $clientListeYaz)
  	{
    	$nickname = $clientListeYaz['client_nickname'];
  	}

    } catch (TeamSpeak3_Exception $e) {
        echo "Error " . $e->getCode() . ": " . $e->getMessage();
    }
    
} else {
    echo "Syntax: banner.php?ip=127.0.0.1&port=9987";
}
date_default_timezone_set("America/Santiago");
setlocale(LC_ALL,"es_ES");
$hoy = strftime("%A %d de %B del %Y. ");
$horas = date ( 'H:i:s' );
$string = $hoy.' CL';
$string2 = 'Hora: '.$horas."";
$string3 = 'ZGaming.CL';
$string4 = "Usuarios conectados: ".$useronline."/".$maxclientes;

// Set the content-type
header("Content-Type: image/png");
header('refresh: 20; url=');

$background = explode(",",hex2rgb(FFF));
$color = explode(",",hex2rgb(FFF));
$font = 'CaviarDreams_Bold.ttf';
$image = imagecreatefromjpeg("banner.jpg");

$width = 1000;
$height = 421;

//$image = @imagecreate($width, $height)
//    or die("Cannot Initialize new GD image stream");


$background_color = imagecolorallocate($image, $background[0], $background[1], $background[2]);
$text_color = imagecolorallocate($image, $color[0], $color[1], $color[2]);
$white = imagecolorallocate($image, 10, 255, 255);


// Orden: Tamaño - Angulo - X - Y - Color - FontFile - Texto
//imagestring($image, 5, 500, 5, $string, $text_color);
imagettftext($image, 20, -2, 400, 30, $text_color, $font , $string);
imagettftext($image, 30, 7, 10, 320, $text_color, $font , $string2);
imagettftext($image, 20, -10, 10, 200, $text_color, $font , $string3);
imagettftext($image, 25, -10, 500, 240, $white, $font , $string4);

imagettftext($image, 31, 0, 0, 419, $white, $font , 'Bienvenido:');
imagettftext($image, 31, 0, 235, 419, $white, $font , ''.$nickname.'!');

// Using imagepng() results in clearer text compared with imagejpeg()
imagepng($image);
imagedestroy($image);

function hex2rgb($hex) {
   $hex = str_replace("#", "", $hex);

   switch (strlen($hex)) {
       case 1:
           $hex = $hex.$hex;
       case 2:
          $r = hexdec($hex);
          $g = hexdec($hex);
          $b = hexdec($hex);
           break;

       case 3:
          $r = hexdec(substr($hex,0,1).substr($hex,0,1));
          $g = hexdec(substr($hex,1,1).substr($hex,1,1));
          $b = hexdec(substr($hex,2,1).substr($hex,2,1));
           break;

       default:
          $r = hexdec(substr($hex,0,2));
          $g = hexdec(substr($hex,2,2));
          $b = hexdec(substr($hex,4,2));
           break;
   }

   $rgb = array($r, $g, $b);
   return implode(",", $rgb);
}


?>
