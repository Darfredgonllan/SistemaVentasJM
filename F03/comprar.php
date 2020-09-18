<?php

$serie = 0;
$numero = 0;
$tipoDoc = '';
$msje = '';

session_start();

require 'includes/funciones/funciones.php';
require 'includes/templates/header.php'; 

if(
  isset($_SESSION['usuario']) == true){

if( isset($_SESSION['cesto']) == true){  

    ini_set('date.timezone','America/Lima');
    $time = date('Y-m-d, H:i:s',time());
        
    $Fecha =  $time;
    $Dni=$_SESSION['usuario'];
    $Estado=1;
    $productos_cesto = $_SESSION['cesto'];
    $CantidadPedido = $_SESSION['cestoCantidad'];
    $CantidadDetalles = count($productos_cesto);
    $Sub = $_SESSION['cestosSub'];

    $Suma=0;
    $k=0;  
    foreach($Sub as $total):  
      $Suma=$Suma + $total;
      $k++;
    endforeach; 
  
            //$sqlPedido = InsertarPedidos($Dni,$Estado,$Suma);
      $sqlPedido = 'INSERT INTO pedido(Dni, Estado, Total,Fecha)
                    VALUES(\''. $Dni . '\', \''. $Estado .'\',\''. $Suma .'\', \''. $Fecha .'\')';

                    try{
                        require 'includes/funciones/conectar.php';
                        $conexion->beginTransaction();
                        $cantidad = $conexion->exec($sqlPedido);

                        if(!( $cantidad > 0)){
                            throw new Exception('No se pudo registrar la venta',1);
                        }
                          $sqldatosVenta = 'SELECT last_insert_id() AS Codigo';
                          $datosVenta = $conexion->query($sqldatosVenta);
                          if($datosVenta != false){
                            $fila = $datosVenta->fetchAll();
                            $codigoVenta = $fila[0]['Codigo'];
                          }else{
                            throw new Exception('No se pudo obtener el codigo de la venta',1);
                          }

                          for($i = 0; $i < $CantidadDetalles; $i++){                             

                             // $sqlDetallePedido = InsertarDetalles($productos_cesto[$i],$codigoVenta,$CantidadPedido[$i],$Sub[$i]);               
                            $sqlDetallePedido = 'INSERT INTO detalle_pedido( IdProducto, IdPedido, Cantidad, SubTotal)
                                                VALUES('. $productos_cesto[$i] .','. $codigoVenta .','. $CantidadPedido[$i] .','. $Sub[$i] .')';

                                                     $cantidad = $conexion->exec($sqlDetallePedido);      
                                                 
                                                 

                                              if ($cantidad == false) {
                                                  throw new Exception('No se pudo registrar el detalle', 1);
                                              }
                              }

                              $conexion->commit();
                              $_SESSION['cesto'] = null;
                              $_SESSION['cestoCantidad'] = null;
                              $_SESSION['cestosSub'] = null;
                              $_SESSION['usuario'] = null;
                              unset($_SESSION['cesto']);
                              unset($_SESSION['cestoCantidad']);
                              unset($_SESSION['cestosSub']);
                              unset($_SESSION['usuario']);
                              
                               ?>
        <meta http-equiv="refresh" content="0;url=lista-pedido.php">
<?php

                    }catch(Exception $e){
                          $conexion->rollback();
                          $msje = 'No se pudo registrar la compra';
                    }
   }else{
   require 'error.php';
  } 
}else{
   require 'errorPedido.php';
  } 
       
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
  <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
  <link href="https://fonts.googleapis.com/css?family=Nunito+Sans:400,600,700&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Slabo+27px" rel="stylesheet" type="text/css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous"> <link rel="stylesheet" href="css/estilos-header.css">
  <link rel="stylesheet" href="fonts/style.css">
  <link rel="stylesheet" href="css/paginacion.css">
  <link rel="stylesheet" href="css/font-awesome.min.css">
  <title>Comprar</title>
</head>
<body>
        
  <?php
    if( $msje != ''){
      echo '<div>' . $msje . '</div>';
    }
  ?>
  
</body>
</html>
