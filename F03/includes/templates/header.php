<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,900" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans|Oswald|PT+Sans">
    <link rel="stylesheet" href="css/sweetalert2.min.css">
    <title>Document</title>
</head>
<!-- CSS only -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
<!--  -->
<link rel="stylesheet" href="css/style.css">
<!-- normalize -->
<link rel="stylesheet" href="css/normalize.css">

<body class="bg-light">
    
<!-- NAVBAR -->
<nav style="background-color:#2b1b34;" class="navbar navbar-expand-lg navbar-light">
  <a class="titulo navbar-brand p-2" href="index.php">Jolca <span>Motors<span></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

    <div class="collapse navbar-collapse justify-content-around mx-0" id="navbarSupportedContent">
       <!-- MENU -->
        <div class="items">
            <ul class="navbar-nav mr-auto">
                <!-- <li  class="nav-item p-2">
                    <a style="color:#fff;" class="nav-link" href="#">INICIO <span class="sr-only" style="color:red;">(current)</span></a>
                </li> -->
                <li class="nav-item p-2">
                    <a style="color:#fff;" class="nav-link" href="index.php">PRODUCTOS</a>
                </li>
                <li class="nav-item dropdown p-2">
                    <a style="color:#fff;" class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">REPORTES</a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                      <a class="dropdown-item" href="reporteGenPedidos.php">Reporte General Pedidos</a>
                      <!-- <a class="dropdown-item" href="#">Opcion 5</a>
                      <div class="dropdown-divider"></div>
                      <a class="dropdown-item" href="#">Opcion 6</a>
                    </div> -->
                </li>
                <!-- <li class="nav-item p-2">
                    <a style="color:#fff;" class="nav-link" href="#">OPCION 2</a>
                </li>
                <li class="nav-item p-2">
                    <a style="color:#fff;" class="nav-link" href="productos.php">OPCION 3</a>
                </li> -->
            </ul>
        </div>
        <?php 
            // session_start();
            // require '../funciones/funciones.php';

            if(isset($_SESSION['cesto']) == true &&
                isset($_SESSION['cestoCantidad']) == true  &&
                isset($_SESSION['cestosSub'])){
                $productos_cesto = $_SESSION['cesto'];
                $Cantidad = $_SESSION['cestoCantidad'];
                $Sub = $_SESSION['cestosSub'];
            }
        ?>
        <!-- CARRITO -->
        <div class="carrito">
            <ul>
                <li class="submenu">
                    <img src="img/cart.png" id="img-carrito">
                    <div id="carrito">       
                        <table id="lista-carrito" class="u-full-width">
                            <thead id="detallePedido" class="detallePedido">
                                <tr>
                                    <th>Imagen</th>
                                    <th>Nombre</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                              <?php if(isset($productos_cesto) == true):?>
                                <?php
                                    $i = 1;
                                    try{
                                        require 'includes/funciones/conectar.php';
                                        foreach($productos_cesto as $codigo):
                                            $sql = 'SELECT Nombre, Descripcion,Marca, Imagen FROM producto
                                                    WHERE IdProducto = '. $codigo;
                                            $datos = $conexion->query($sql);
                                            if($datos == true):
                                                $filas = $datos->fetchAll();?>
                                            <tr>
                                                <td><img src="data:image/jpg;base64,<?php echo base64_encode($filas[0]['Imagen']) ; ?>" alt="Imagen del Producto" width="80"></td>
                                                <td><?php echo $filas[0]['Nombre'].' '.$filas[0]['Marca'];?></td>
                                                <td><?php echo 'S/'.$_SESSION['cestosSub'][$i-1];?></td>
                                            </tr> 
                                        <?php 
                                            endif;
                                            $i++;
                                        endforeach;     
                                    }catch(PDOException $e){
                                        echo 'No se puede acceder a la base de datos';  
                                    }    
                                ?>

                              <?php endif;?>
                            </tbody>
                        </table>
                        <a href="lista-pedido.php" id="lista-pedido" class="lista-pedido">Listar Pedido</a>
                    </div>
                </li>
            </ul>
            
        </div>
    <div>
</nav>




                                <!-- <tr>
                                    <td><img src="img/1.png" width="100"></td>
                                    <td>$15</td>
                                </tr> -->

                      
