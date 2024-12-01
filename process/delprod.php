<?php
include '../library/configServer.php';
include '../library/consulSQL.php';

sleep(4);

$codeProd = $_POST['prod-code'];
$cons = ejecutarSQL::consultar("SELECT * FROM producto WHERE CodigoProd='$codeProd'");
$totalproductos = mysqli_num_rows($cons);
$tmp = mysqli_fetch_array($cons);
$imagen = $tmp['Imagen'];

if ($totalproductos > 0) {
    if (consultasSQL::DeleteSQL('producto', "CodigoProd='$codeProd'")) {
        $carpeta = '../assets/img-products/';
        $directorio = $carpeta . $imagen;
        chmod($directorio, 0777);
        unlink($directorio);
        echo '<img src="assets/img/ok.png" class="center-all-contens"><br><p class="lead text-center">El producto se eliminó de la tienda con éxito</p>';
    } else {
        echo '<img src="assets/img/error.png" class="center-all-contens"><br><p class="lead text-center">Ha ocurrido un error.<br>Por favor intente nuevamente</p>';
    }
} else {
    echo '<img src="assets/img/error.png" class="center-all-contens"><br><p class="lead text-center">El código del producto no existe</p>';
}
?>
