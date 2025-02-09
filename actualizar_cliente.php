<?php
/*

  ____          _____               _ _           _       
 |  _ \        |  __ \             (_) |         | |      
 | |_) |_   _  | |__) |_ _ _ __ _____| |__  _   _| |_ ___ 
 |  _ <| | | | |  ___/ _` | '__|_  / | '_ \| | | | __/ _ \
 | |_) | |_| | | |  | (_| | |   / /| | |_) | |_| | ||  __/
 |____/ \__, | |_|   \__,_|_|  /___|_|_.__/ \__, |\__\___|
         __/ |                               __/ |        
        |___/                               |___/         
    
____________________________________
/ Si necesitas ayuda, contáctame en \
\ https://parzibyte.me               /
 ------------------------------------
        \   ^__^
         \  (oo)\_______
            (__)\       )\/\
                ||----w |
                ||     ||
Creado por Parzibyte (https://parzibyte.me).
------------------------------------------------------------------------------------------------
            | IMPORTANTE |
Si vas a borrar este encabezado, considera:
Seguirme: https://parzibyte.me/blog/sigueme/
Y compartir mi blog con tus amigos
También tengo canal de YouTube: https://www.youtube.com/channel/UCroP4BTWjfM0CkGB6AFUoBg?sub_confirmation=1
Twitter: https://twitter.com/parzibyte
Facebook: https://facebook.com/parzibyte.fanpage
Instagram: https://instagram.com/parzibyte
Hacer una donación vía PayPal: https://paypal.me/LuisCabreraBenito
------------------------------------------------------------------------------------------------
*/ ?>
<?php
include_once "funciones.php";

// Verifica que todos los campos necesarios están presentes
if (isset($_POST["nombre"], $_POST["edad"], $_POST["departamento"], $_POST["direccion"], $_POST["sexo"], $_POST["telefono"], $_POST["id"])) {
    // Llama a la función actualizarCliente con todos los parámetros necesarios
    $ok = actualizarCliente($_POST["nombre"], $_POST["edad"], $_POST["departamento"], $_POST["direccion"], $_POST["sexo"], $_POST["telefono"], $_POST["id"]);
    if (!$ok) {
        echo "Error actualizando cliente.";
    } else {
        header("Location: clientes.php");
    }
} else {
    echo "Por favor, complete todos los campos.";
}
?>
