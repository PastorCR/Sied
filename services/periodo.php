<?php
include '../database/database.php';
include '../database/periodoData.php';
include '../database/usuarioData.php';
include '../database/notificacionData.php';
include '../libraries/phpMailer/PHPMailerAutoload.php';
include '../database/correosData.php';
$today = date("Y-m-d");
$today2 = date("Y-m-d H:i:s");
$data = periodoData::getAll()[0];//get actual
$dato = [];
$dato['id']= $data['id'];
//echo date('Y-m-d', strtotime($data[0]["fechainicio"] . ' -1 day')) ."<br>";
//echo $data[0]["fechainicio"] ."<br>";
//echo $data[0]["fechainicio"] . ' -1 day';
//$stop_date = strtotime($data[0]["fechainicio"] . ' -1 day');
//->modify('+1 day');->format('Y-m-d H:i:s');
$today_time = new DateTime($today);
$exact_time = new DateTime($today2);

$fechainicio = new DateTime($data["fechainicio"]);
$dato["fechainicio"] = $fechainicio->format('Y-m-d');

$fechainicioantes = new DateTime($data["fechainicio"] . ' -5 day');

$fiper1 = new DateTime($data["fiper1"]);
$dato["fiper1"]= $fiper1->format('Y-m-d');
$fiper1antes = new DateTime($data["fiper1"] . ' -5 day');

$ffper1 = new DateTime($data["ffper1"]);
$dato["ffper1"]= $ffper1->format('Y-m-d');
$ffper1antes = new DateTime($data["ffper1"] . ' -5 day');

$fiper2 = new DateTime($data["fiper2"]);
$dato["fiper2"]= $fiper2->format('Y-m-d');
$fiper2antes = new DateTime($data["fiper2"] . ' -5 day');

$ffper2 = new DateTime($data["ffper2"]);
$dato["ffper2"]= $ffper2->format('Y-m-d');
$ffper2antes = new DateTime($data["ffper2"] . ' -5 day');

$fechafinal = new DateTime($data["fechafinal"]);
$dato["fechafinal"]= $fechafinal->format('Y-m-d');
$fechafinalantes = new DateTime($data["fechafinal"] . ' -5 day');

echo "Hora actual: ".$exact_time->format('Y-m-d H:i:s') . " <br> \n";

if ($today_time == $fechainicioantes) { 
    echo $today_time->format('Y-m-d H:i:s') . " = ". $fechainicioantes->format('Y-m-d H:i:s');
    // A todos los usuarios activos  se les genera una notificacion y en caso de ser nesesario se envia un correo
    echo "antes fecha inicio";
   // usuarioData::setAll();
   // usuarioData::setAllNotificacion(0);
    usuarioData::setAllCorreo($dato,"antesFi");
    
}
if ($today_time == $fechainicio) { 
    echo $today_time->format('Y-m-d H:i:s') . " = ".$fechainicio->format('Y-m-d H:i:s');
    echo "hoy es la fecha inicio";
    //usuarioData::setAllNotificacion(1);
    usuarioData::setAllCorreo($dato,"Fi");
}
if ($today_time == $fiper1antes) { 
    echo $today_time->format('Y-m-d H:i:s') . " = ". $fiper1antes->format('Y-m-d H:i:s');
    // A todos los usuarios activos  se les genera una notificacion y en caso de ser nesesario se envia un correo
    echo "antes fecha ingreso de metas";
    usuarioData::setAllNotificacion(2);
    usuarioData::setAllCorreo($dato,"antesFiper1");
}
if ($today_time == $fiper1) { 
    echo $today_time->format('Y-m-d H:i:s') . " = ". $fiper1->format('Y-m-d H:i:s');
    // A todos los usuarios activos  se les genera una notificacion y en caso de ser nesesario se envia un correo
    echo "hoy fecha ingreso de metas";
    usuarioData::setAllNotificacion(3);
    usuarioData::setAllCorreo($dato,"Fiper1");
}
if ($today_time == $ffper1antes) { 
    echo $today_time->format('Y-m-d H:i:s') . " = ". $ffper1antes->format('Y-m-d H:i:s');
    // A todos los usuarios activos  se les genera una notificacion y en caso de ser nesesario se envia un correo
    echo "antes fecha ingreso de metas final";  
    usuarioData::setAllNotificacion(4);
    usuarioData::setAllCorreo($dato,"antesFfper1");
}
if ($today_time == $ffper1) { 
    echo $today_time->format('Y-m-d H:i:s') . " = ". $ffper1->format('Y-m-d H:i:s');
    // A todos los usuarios activos  se les genera una notificacion y en caso de ser nesesario se envia un correo
    echo "hoy fecha ingreso de metas final";
    usuarioData::setAllNotificacion(5);
    usuarioData::setAllCorreo($dato,"Ffper1");
}
if ($today_time == $fiper2antes) { 
    echo $today_time->format('Y-m-d H:i:s') . " = ". $fiper2antes->format('Y-m-d H:i:s');
    // A todos los usuarios activos  se les genera una notificacion y en caso de ser nesesario se envia un correo
    echo "antes fecha calificacion de metas final";
    usuarioData::setAllNotificacion(6);
    usuarioData::setAllCorreo($dato,"antesFiper2");
  
}
if ($today_time == $fiper2) { 
    echo $today_time->format('Y-m-d H:i:s') . " = ". $fiper2->format('Y-m-d H:i:s');
    // A todos los usuarios activos  se les genera una notificacion y en caso de ser nesesario se envia un correo
    echo "hoy fecha calificacion de metas ";
    usuarioData::setAllNotificacion(7);
    usuarioData::setAllCorreo($dato,"Fiper2");
    
}
if ($today_time == $ffper2antes) { 
    echo $today_time->format('Y-m-d H:i:s') . " = ". $ffper2antes->format('Y-m-d H:i:s');
    // A todos los usuarios activos  se les genera una notificacion y en caso de ser nesesario se envia un correo
    echo "antes fecha calificacion de metas final";
    usuarioData::setAllNotificacion(8);
    usuarioData::setAllCorreo($dato,"antesFfper2");
}
if ($today_time == $ffper2) { 
    echo $today_time->format('Y-m-d H:i:s') . " = ". $ffper2->format('Y-m-d H:i:s');
    // A todos los usuarios activos  se les genera una notificacion y en caso de ser nesesario se envia un correo
    echo "hoy fecha calificacion de metas final";
    usuarioData::setAllNotificacion(9);
    usuarioData::setAllCorreo($dato,"Ffper2");
}


if ($today_time == $fechafinalantes) { 
    echo $today_time->format('Y-m-d H:i:s') . " = ".  $fechafinalantes->format('Y-m-d H:i:s');
    echo "antes de la fecha final";
    usuarioData::setAllNotificacion(10);
    usuarioData::setAllCorreo($dato,"antesFf");
}
if ($today_time == $fechafinal) { 
    echo $today_time->format('Y-m-d H:i:s') . " = ". $fechafinal->format('Y-m-d H:i:s');
    echo "hoy es la fecha final";
    usuarioData::setAllNotificacion(11);
    usuarioData::setAllCorreo($dato,"Ff");
}
//if($data['fechainicio'] == date('Y-M-D')){
//    echo "prueba";
//}