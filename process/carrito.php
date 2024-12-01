<?php
error_reporting(E_PARSE);
include '../library/configServer.php';
include '../library/consulSQL.php';
session_start();
$suma = 0;
if(isset($_GET['precio'])){
    $_SESSION['producto'][$_SESSION['contador']] = $_GET['precio'];
}
$_SESSION['contador']++;
echo '<table class="table table-bordered">';
for($i = 0; $i < $_SESSION['contador']; $i++){
    $consulta = ejecutarSQL::consultar("select * from producto where CodigoProd='".$_SESSION['producto'][$i]."'");
}
while($fila = mysqli_fetch_array($consulta)) {
    echo "<tr><td>".$fila['NombreProd']."</td><td> ".number_format($fila['Precio'], 0, ',', '.')."</td></tr>";
    $suma += $fila['Precio'];
}
echo "<tr><td>Subtotal</td><td>₲ ".number_format($suma, 0, ',', '.')."</td></tr>";
echo "</table>";
$_SESSION['sumaTotal'] = $suma;
