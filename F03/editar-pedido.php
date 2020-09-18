<?php
 session_start();
require 'includes/templates/header.php';
require 'includes/funciones/funciones.php';

if(isset($_GET['id']) == true){
$codigo = filter_var($_GET['id'], FILTER_VALIDATE_INT);
$resultado = obtenerDescripcionProducto($_SESSION['cesto'][$codigo-1]);
$productos = $resultado->fetchAll();
$pos=$codigo-1;

            $productos_cesto=$_SESSION['cesto'];
            $Cantidad = $_SESSION['cestoCantidad'];
            $sub = $_SESSION['cestosSub'];

?>
<div class="container-fluid">
  <div class="row bg-light">
    <div class="col-lg-6 d-flex justify-content-md-center justify-content-lg-end">
         <div class="card" style="margin:20px 0;border:none;">
            <?php foreach($productos as $producto):?>
            <a href="#"><img src="data:image/jpg;base64,<?php echo base64_encode($producto['Imagen']) ; ?>" alt="" width="450"></a>
            <div class="card-body text-center mt-3">

               <p class="nombre"><?php echo $producto['Nombre'].' '.$producto['Marca']?></p>
               <p class="descripcion"><?php echo $producto['Descripcion']?></p>
               <div class="precio" style="font-size:20px;font-weight: 700;">Precio</div>
               <input id="precio" class="precio bg-white" type="number" value="<?php echo $producto['Precio']?>" disabled>
            </div>
            <?php endforeach;?>
         </div>
    </div>

    <div class="col-lg-6 mb-3 d-flex justify-content-center align-items-lg-center">
        <?php foreach($productos as $producto):?>
        <form class="shadow bg-white bg-white text-center rounded" 
        action="editar-pedido.php"
        method="post">

            <input type="hidden" id="id_producto" name="id_producto" value="<?php echo $producto['IdProducto']?>">
            <input type="hidden" id="subtotal1" name="subtotal1" value="<?php echo $producto['Precio']?>">
             <input type="hidden" id="pos" name="pos" value="<?php echo $pos?>">

            <div class="stock text-center my-3 p-3">Stock  <span id="stock"> <?php echo $producto['Stock']?> </span>unidades</div>
            <div class="form-group row">
                <label for="cantidad" class="col-sm-4 col-form-label text-lg-right">Cantidad</label>
                <div class="col-sm-6 col-lg-7">
                    <input type="number" class="form-control text-center" id="cantidad-prod"  name="cantidad-prod" value="<?php echo $Cantidad[$pos]?>">
                </div>
            </div>
            <div class="form-group row">
            <label for="subtotal"  class="col-sm-4 col-form-label text-lg-right">Subtotal</label>
                <!-- AGREGANDO EL SUBTOTAL -->
                <div id="div-subtotal"  class="div-subtotal input-group col-sm-6 col-lg-7"> 
                
                </div> 
            </div>
            <div><input id="btnAgregarCarrito" type="submit" class="btn btn-primary btn-lg btn-block" value="GUARDAR"></div> 
        </form>   
        <?php endforeach;?>
    </div>

  </div>
</div>
<?php


            //OBTENIENDO POSICIÓN

                  /* $k=0; 
                    $EU=0;
            foreach( $productos_cesto as $buscar):
                    
                    if( $buscar==$codigo){
                        $EU=$k;
                    }
                   $k++;
                       
                            
                        
                    endforeach; */
            // AGREGANDO SUBTOTAL
                   // var_dump($_SESSION['cestoCantidad'][$EU]);
  
} if(isset($_POST['cantidad-prod']) == true &&
          isset($_POST['pos']) == true &&
        isset($_POST['id_producto']) == true){
 
            // $codigo = $_POST['id_producto'];

            $pos=$_POST['pos'];
           // $codigoSubtotal = $_POST['subtotal1'];


            $Cantidad = $_SESSION['cestoCantidad'];
            $sub = $_SESSION['cestosSub'];

         
            if(isset($_SESSION['cestosSub']) == true){
              $_SESSION['cestosSub'][$pos] = $_POST['subtotal1'] * $_POST['cantidad-prod'];
            
               
            }

            //  AGREGANDO CANTIDAD
 
             if(isset($_POST['cantidad-prod']) == true){
              
                $_SESSION['cestoCantidad'][$pos] = $_POST['cantidad-prod'];
              
             }

?>
<meta http-equiv="refresh" content="0;url=lista-pedido.php">
<?php

}

?>



<?php require 'includes/templates/footer.php';?>