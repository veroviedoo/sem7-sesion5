<?php
include './library/configServer.php';
include './library/consulSQL.php';
include './process/securityPanel.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Admin</title>
    <?php include './inc/link.php'; ?>
    <script type="text/javascript" src="js/admin.js"></script>
</head>
<body id="container-page-configAdmin">
    <?php include './inc/navbar.php'; ?>
    <section id="prove-product-cat-config">
        <div class="container">
            <div class="page-header">
                <h1>Panel de administración <small class="tittles-pages-logo">LP3 Electronics</small></h1>
            </div>
            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active"><a href="#Productos" role="tab" data-toggle="tab">Productos</a></li>
                <li role="presentation"><a href="#Proveedores" role="tab" data-toggle="tab">Proveedores</a></li>
                <li role="presentation"><a href="#Categorias" role="tab" data-toggle="tab">Categorías</a></li>
                <li role="presentation"><a href="#Admins" role="tab" data-toggle="tab">Admin</a></li>
                <li role="presentation"><a href="#Pedidos" role="tab" data-toggle="tab">Pedidos</a></li>
            </ul>
            <div class="tab-content">
                <!--==============================Panel productos===============================-->
                <div role="tabpanel" class="tab-pane fade in active" id="Productos">
                    <div class="row">
                        <div class="col-xs-12 col-sm-6">
                            <br><br>
                            <div id="add-product">
                                <h2 class="text-primary text-center"><small><i class="fa fa-plus"></i></small>&nbsp;&nbsp;Agregar un producto nuevo</h2>
                                <form role="form" action="process/regproduct.php" method="post" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label>Código de producto</label>
                                        <input type="text" class="form-control" placeholder="Código" required maxlength="30" name="prod-codigo">
                                    </div>
                                    <div class="form-group">
                                        <label>Nombre de producto</label>
                                        <input type="text" class="form-control" placeholder="Nombre" required maxlength="30" name="prod-name">
                                    </div>
                                    <div class="form-group">
                                        <label>Categoría</label>
                                        <select class="form-control" name="prod-categoria">
                                            <?php 
                                            $categoriac= ejecutarSQL::consultar("select * from categoria");
                                            while($catec=mysqli_fetch_array($categoriac)){
                                                echo '<option value="'.$catec['CodigoCat'].'">'.$catec['Nombre'].'</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Precio</label>
                                        <input type="text" class="form-control" placeholder="Precio" required maxlength="20" pattern="[0-9]{1,20}" name="prod-price">
                                    </div>
                                    <div class="form-group">
                                        <label>Modelo</label>
                                        <input type="text" class="form-control" placeholder="Modelo" required maxlength="30" name="prod-model">
                                    </div>
                                    <div class="form-group">
                                        <label>Marca</label>
                                        <input type="text" class="form-control" placeholder="Marca" required maxlength="30" name="prod-marca">
                                    </div>
                                    <div class="form-group">
                                        <label>Unidades disponibles</label>
                                        <input type="text" class="form-control" placeholder="Unidades" required maxlength="20" pattern="[0-9]{1,20}" name="prod-stock">
                                    </div>
                                    <div class="form-group">
                                        <label>Proveedor</label>
                                        <select class="form-control" name="prod-codigoP">
                                            <?php 
                                            $proveedoresc= ejecutarSQL::consultar("select * from proveedor");
                                            while($provc=mysqli_fetch_array($proveedoresc)){
                                                echo '<option value="'.$provc['RUCProveedor'].'">'.$provc['NombreProveedor'].'</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Imagen de producto</label>
                                        <input type="file" name="img">
                                        <p class="help-block">Formato de imagenes admitido png, jpg, gif, jpeg</p>
                                    </div>
                                    <input type="hidden" name="admin-name" value="<?php echo $_SESSION['nombreAdmin'] ?>">
                                    <p class="text-center"><button type="submit" class="btn btn-primary">Agregar a la tienda</button></p>
                                    <div id="res-form-add" style="width: 100%; text-align: center; margin: 0;"></div>
                                </form>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6">
                            <br><br>
                            <div id="del-prod-form">
                                <h2 class="text-danger text-center"><small><i class="fa fa-trash-o"></i></small>&nbsp;&nbsp;Eliminar un producto</h2>
                                <form action="process/delprod.php" method="post" role="form">
                                    <div class="form-group">
                                        <label>Productos</label>
                                        <select class="form-control" name="prod-code">
                                            <?php 
                                            $productoc= ejecutarSQL::consultar("select * from producto");
                                            while($prodc=mysqli_fetch_array($productoc)){
                                                echo '<option value="'.$prodc['CodigoProd'].'">'.$prodc['Marca'].'-'.$prodc['NombreProd'].' '.$prodc['Modelo'].'</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <p class="text-center"><button type="submit" class="btn btn-danger">Eliminar</button></p>
                                    <br>
                                    <div id="res-form-del-prod" style="width: 100%; text-align: center; margin: 0;"></div>
                                </form>
                            </div>
                        </div>
                        <div class="col-xs-12">
                            <br><br>
                            <div class="panel panel-info">
                                <div class="panel-heading text-center"><i class="fa fa-refresh fa-2x"></i><h3>Actualizar datos de producto</h3></div>
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th class="text-center">Código</th>
                                                <th class="text-center">Nombre</th>
                                                <th class="text-center">Categoría</th>
                                                <th class="text-center">Precio</th>
                                                <th class="text-center">Modelo</th>
                                                <th class="text-center">Marca</th>
                                                <th class="text-center">Unidades</th>
                                                <th class="text-center">Proveedor</th>
                                                <th class="text-center">Opciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $productos= ejecutarSQL::consultar("select * from producto");
                                            $upr=1;
                                            while($prod=mysqli_fetch_array($productos)){
                                                echo '
                                                <div id="update-product">
                                                    <form method="post" action="process/updateProduct.php" id="res-update-product-'.$upr.'">
                                                        <tr>
                                                            <td>
                                                                <input class="form-control" type="hidden" name="code-old-prod" required value="'.$prod['CodigoProd'].'">
                                                                <input class="form-control" type="text" name="code-prod" maxlength="30" required value="'.$prod['CodigoProd'].'">
                                                            </td>
                                                            <td><input class="form-control" type="text" name="prod-name" maxlength="30" required value="'.$prod['NombreProd'].'"></td>
                                                            <td>';
                                                                $categoriac3= ejecutarSQL::consultar("select * from categoria where CodigoCat='".$prod['CodigoCat']."'");
                                                                while($catec3=mysqli_fetch_array($categoriac3)){
                                                                    $codeCat=$catec3['CodigoCat'];
                                                                    $nameCat=$catec3['Nombre'];
                                                                }
                                                                echo '<select class="form-control" name="prod-category">';
                                                                    echo '<option value="'.$codeCat.'">'.$nameCat.'</option>';
                                                                    $categoriac2= ejecutarSQL::consultar("select * from categoria");
                                                                    while($catec2=mysqli_fetch_array($categoriac2)){
                                                                        if($catec2['CodigoCat']!=$codeCat){
                                                                            echo '<option value="'.$catec2['CodigoCat'].'">'.$catec2['Nombre'].'</option>';
                                                                        }
                                                                    }
                                                                echo '</select>';
                                                                echo '</td>
                                                            <td><input class="form-control" type="text" name="price-prod" required value="'.$prod['Precio'].'"></td>
                                                            <td><input class="form-control" type="tel" name="model-prod" required maxlength="20" value="'.$prod['Modelo'].'"></td>
                                                            <td><input class="form-control" type="text" name="marc-prod" maxlength="30" required value="'.$prod['Marca'].'"></td>
                                                            <td><input class="form-control" type="text" name="stock-prod" maxlength="30" required value="'.$prod['Stock'].'"></td>
                                                            <td>';
                                                                $proveedoresc3= ejecutarSQL::consultar("select * from proveedor where RUCProveedor='".$prod['CodigoP']."'");
                                                                while($provc3=mysqli_fetch_array($proveedoresc3)){
                                                                    $codeP=$provc3['RUCProveedor'];
                                                                    $nameP=$provc3['NombreProveedor'];
                                                                }
                                                                echo '<select class="form-control" name="prod-prove">';
                                                                    echo '<option value="'.$codeP.'">'.$nameP.'</option>';
                                                                    $proveedoresc2= ejecutarSQL::consultar("select * from proveedor");
                                                                    while($provc2=mysqli_fetch_array($proveedoresc2)){
                                                                        if($provc2['RUCProveedor']!=$codeP){
                                                                            echo '<option value="'.$provc2['RUCProveedor'].'">'.$provc2['NombreProveedor'].'</option>';
                                                                        }
                                                                    }
                                                                echo '</select>
                                                            </td>
                                                            <td class="text-center">
                                                                <button type="submit" class="btn btn-sm btn-primary button-UMR" value="res-update-product-'.$upr.'">Actualizar</button>
                                                                <div id="res-update-product-'.$upr.'" style="width: 100%; margin:0px; padding:0px;"></div>
                                                            </td>
                                                        </tr>
                                                    </form>
                                                </div>';
                                                $upr=$upr+1;
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
<!--==============================Panel Proveedores===============================-->
<div role="tabpanel" class="tab-pane fade" id="Proveedores">
    <div class="row">
        <div class="col-xs-12 col-sm-6">
            <br><br>
            <div id="add-provee">
                <h2 class="text-primary text-center"><small><i class="fa fa-plus"></i></small>&nbsp;&nbsp;Agregar un proveedor</h2>
                <form action="process/regprove.php" method="post" role="form">
                    <div class="form-group">
                        <label>RUC</label>
                        <input class="form-control" type="text" name="prove-RUC" placeholder="RUC proveedor" maxlength="30" required="">
                    </div>
                    <div class="form-group">
                        <label>Nombre</label>
                        <input class="form-control" type="text" name="prove-name" placeholder="Nombre proveedor" maxlength="30" required="">
                    </div>
                    <div class="form-group">
                        <label>Dirección</label>
                        <input class="form-control" type="text" name="prove-dir" placeholder="Dirección proveedor" required="">
                    </div>
                    <div class="form-group">
                        <label>Teléfono</label>
                        <input class="form-control" type="tel" name="prove-tel" placeholder="Número telefónico" pattern="[0-9]{1,20}" maxlength="20" required="">
                    </div>
                    <div class="form-group">
                        <label>Página web</label>
                        <input class="form-control" type="text" name="prove-web" placeholder="Página web proveedor" required="">
                    </div>
                    <p class="text-center"><button type="submit" class="btn btn-primary">Añadir proveedor</button></p>
                    <br>
                    <div id="res-form-add-prove" style="width: 100%; text-align: center; margin: 0;"></div>
                </form>
            </div>
        </div>
        <div class="col-xs-12 col-sm-6">
            <br><br>
            <div id="del-prove">
                <h2 class="text-danger text-center"><small><i class="fa fa-trash-o"></i></small>&nbsp;&nbsp;Eliminar un proveedor</h2>
                <form action="process/delprove.php" method="post" role="form">
                    <div class="form-group">
                        <label>Proveedores</label>
                        <select class="form-control" name="RUC-prove">
                            <?php 
                                $proveRUC= ejecutarSQL::consultar("select * from proveedor");
                                while($PN=mysqli_fetch_array($proveRUC)){
                                    echo '<option value="'.$PN['RUCProveedor'].'">'.$PN['RUCProveedor'].' - '.$PN['NombreProveedor'].'</option>';
                                }
                            ?>
                        </select>
                    </div>
                    <p class="text-center"><button type="submit" class="btn btn-danger">Eliminar proveedor</button></p>
                    <br>
                    <div id="res-form-del-prove" style="width: 100%; text-align: center; margin: 0;"></div>
                </form>
            </div>    
        </div>
        <div class="col-xs-12">
            <br><br>
            <div class="panel panel-info">
                <div class="panel-heading text-center"><i class="fa fa-refresh fa-2x"></i><h3>Actualizar datos de proveedor</h3></div>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th class="text-center">RUC</th>
                                <th class="text-center">Nombre</th>
                                <th class="text-center">Dirección</th>
                                <th class="text-center">Telefono</th>
                                <th class="text-center">Página web</th>
                                <th class="text-center">Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $proveedores= ejecutarSQL::consultar("select * from proveedor");
                                $up=1;
                                while($prov=mysqli_fetch_array($proveedores)){
                                    echo '
                                        <div id="update-proveedor">
                                            <form method="post" action="process/updateProveedor.php" id="res-update-prove-'.$up.'">
                                                <tr>
                                                    <td>
                                                        <input class="form-control" type="hidden" name="RUC-prove-old" required="" value="'.$prov['RUCProveedor'].'">
                                                        <input class="form-control" type="text" name="RUC-prove" maxlength="30" required="" value="'.$prov['RUCProveedor'].'">
                                                    </td>
                                                    <td><input class="form-control" type="text" name="prove-name" maxlength="30" required="" value="'.$prov['NombreProveedor'].'"></td>
                                                    <td><input class="form-control" type="text-area" name="prove-dir" required="" value="'.$prov['Direccion'].'"></td>
                                                    <td><input class="form-control" type="tel" name="prove-tel" required="" maxlength="20" value="'.$prov['Telefono'].'"></td>
                                                    <td><input class="form-control" type="text-area" name="prove-web" maxlength="30" required="" value="'.$prov['PaginaWeb'].'"></td>
                                                    <td class="text-center">
                                                        <button type="submit" class="btn btn-sm btn-primary button-UP" value="res-update-prove-'.$up.'">Actualizar</button>
                                                        <div id="res-update-prove-'.$up.'" style="width: 100%; margin:0px; padding:0px;"></div>
                                                    </td>
                                                </tr>
                                            </form>
                                        </div>
                                    ';
                                    $up=$up+1;
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!--==============================Panel Admins===============================-->
<div role="tabpanel" class="tab-pane fade" id="Admins">
    <div class="row">
        <div class="col-xs-12 col-sm-6">
            <br><br>
            <div id="add-admin">
                <h2 class="text-info text-center"><small><i class="fa fa-plus"></i></small>&nbsp;&nbsp;Agregar administrador</h2>
                <form action="process/regAdmin.php" method="post" role="form">
                    <div class="form-group">
                        <label>Nombre</label>
                        <input class="form-control" type="text" name="admin-name" placeholder="Nombre" maxlength="30" required="">
                    </div>
                    <div class="form-group">
                        <label>Contraseña</label>
                        <input class="form-control" type="password" name="adminpass" placeholder="Contraseña" required="">
                    </div>
                    <p class="text-center"><button type="submit" class="btn btn-primary">Agregar administrador</button></p>
                    <br>
                    <div id="res-form-add-admin" style="width: 100%; text-align: center; margin: 0;"></div>
                </form>
            </div>
        </div>
        <div class="col-xs-12 col-sm-6">
            <br><br>
            <div id="del-admin">
                <h2 class="text-danger text-center"><small><i class="fa fa-trash-o"></i></small>&nbsp;&nbsp;Eliminar administrador</h2>
                <form action="process/deladmin.php" method="post" role="form">
                    <div class="form-group">
                        <label>Administradores</label>
                        <select class="form-control" name="name-admin">
                            <?php 
                                $adminCon=  ejecutarSQL::consultar("select * from administrador");
                                while($AdminD=mysqli_fetch_array($adminCon)){
                                    echo '<option value="'.$AdminD['Nombre'].'">'.$AdminD['Nombre'].'</option>';
                                }
                            ?>
                        </select>
                    </div>
                    <p class="text-center"><button type="submit" class="btn btn-danger">Eliminar administrador</button></p>
                    <br>
                    <div id="res-form-del-admin" style="width: 100%; text-align: center; margin: 0;"></div>
                </form>
            </div>
        </div>
        <div class="col-xs-12"></div>
    </div>
</div>
<!--==============================Panel pedidos===============================-->
<div role="tabpanel" class="tab-pane fade" id="Pedidos">
    <div class="row">
        <div class="col-xs-12">
            <br><br>
            <div id="del-pedido">
                <h2 class="text-danger text-center"><small><i class="fa fa-trash-o"></i></small>&nbsp;&nbsp;Eliminar pedido</h2>
                <form action="process/delPedido.php" method="post" role="form">
                    <div class="form-group">
                        <label>Pedidos</label>
                        <select class="form-control" name="num-pedido">
                            <?php 
                                $pedidoC=  ejecutarSQL::consultar("select * from venta");
                                while($pedidoD=mysqli_fetch_array($pedidoC)){
                                    echo '<option value="'.$pedidoD['NumPedido'].'">Pedido #'.$pedidoD['NumPedido'].' - Estado('.$pedidoD['Estado'].') - Fecha('.$pedidoD['Fecha'].')</option>';
                                }
                            ?>
                        </select>
                    </div>
                    <p class="text-center"><button type="submit" class="btn btn-danger">Eliminar pedido</button></p>
                    <br>
                    <div id="res-form-del-pedido" style="width: 100%; text-align: center; margin: 0;"></div>
                </form>
            </div>
            <br><br>
            <div class="panel panel-info">
                <div class="panel-heading text-center"><i class="fa fa-refresh fa-2x"></i><h3>Actualizar estado de pedido</h3></div>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="">
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">Fecha</th>
                                <th class="text-center">Cliente</th>
                                <th class="text-center">Producto</th>
                                <th class="text-center">Total</th>
                                <th class="text-center">Estado</th>
                                <th class="text-center">Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $pedidoU=  ejecutarSQL::consultar("SELECT venta.NumPedido,venta.Fecha,venta.RUC,venta.TotalPagar,venta.Estado,GROUP_CONCAT(producto.NombreProd SEPARATOR '|') AS Productos FROM venta join detalle ON venta.NumPedido=detalle.NumPedido join producto on producto.CodigoProd=detalle.CodigoProd GROUP BY venta.NumPedido");
                                $upp=1;
                                while($peU=mysqli_fetch_array($pedidoU)){
                                    echo '
                                        <div id="update-pedido">
                                            <form method="post" action="process/updatePedido.php" id="res-update-pedido-'.$upp.'">
                                                <tr>
                                                    <td>'.$peU['NumPedido'].'<input type="hidden" name="num-pedido" value="'.$peU['NumPedido'].'"></td>
                                                    <td>'.$peU['Fecha'].'</td>
                                                    <td>';
                                                        $conUs= ejecutarSQL::consultar("select * from cliente where RUC='".$peU['RUC']."'");
                                                        while($UsP=mysqli_fetch_array($conUs)){
                                                            echo $UsP['NombreCompleto']." ".$UsP['Apellido'];
                                                        }
                                            echo '</td>
                                                    <td>'.$peU['Productos'].'</td>
                                                    <td>'.number_format($peU['TotalPagar'], 0, ',', '.').'</td>
                                                    <td>
                                                        <select class="form-control" name="pedido-status">';
                                                            if($peU['Estado']=="Pendiente"){
                                                                echo '<option value="Pendiente">Pendiente</option>'; 
                                                                echo '<option value="Entregado">Entregado</option>'; 
                                                            }
                                                            if($peU['Estado']=="Entregado"){
                                                                echo '<option value="Entregado">Entregado</option>';
                                                                echo '<option value="Pendiente">Pendiente</option>'; 
                                                            }
                                            echo '</select>
                                                    </td>
                                                    <td class="text-center">
                                                        <button type="submit" class="btn btn-sm btn-primary button-UPPE" value="res-update-pedido-'.$upp.'">Actualizar</button>
                                                        <div id="res-update-pedido-'.$upp.'" style="width: 100%; margin:0px; padding:0px;"></div>
                                                    </td>
                                                </tr>
                                            </form>
                                        </div>
                                    ';
                                    $upp=$upp+1;
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
</section>
<?php include './inc/footer.php'; ?>
</body>
</html>