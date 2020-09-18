<?php   

session_start();


require 'includes/funciones/funciones.php';
require 'includes/templates/header.php';

        $codigo = filter_var($_GET['id'], FILTER_VALIDATE_INT);
        if(!$codigo){
            die('No es valido');
        }
        $resultado = obtenerDescripcionProducto($codigo);
        $productos = $resultado->fetchAll();

        if(isset( $_POST['id_producto']) == true &&
        	isset($_POST['cantidad-prod']) == true &&
        isset( $_POST['subtotal1']) == true){


     $cont=0;
        if( isset($_SESSION['cesto']) == true){
            $productos_cesto = $_SESSION['cesto'];
                               $k=0; 
                    $EU=0;
               
            foreach( $productos_cesto as $buscar):
                    
                    if( $buscar==$_POST['id_producto']){
                        $EU=$k;
                        $cont=1;
                    }
                   $k++;
                       
                            
                        
                    endforeach; 
        }else{
            $productos_cesto = [];
        }

        if($cont==1){
           
           $Cantidad =0;
           $sub =0;
         
            if(isset($_SESSION['cestosSub']) == true){

             $sub = $_SESSION['cestosSub'][$EU]+($_POST['subtotal1']*$_POST['cantidad-prod']);
                $_SESSION['cestosSub'][$EU] = $sub;
               
            }

            //  AGREGANDO CANTIDAD
 
             if(isset($_POST['cantidad-prod']) == true){

                 $Cantidad = $_SESSION['cestoCantidad'][$EU]+$_POST['cantidad-prod'];
                $_SESSION['cestoCantidad'][$EU] = $Cantidad;
              
             }

        }else{
        $productos_cesto[] = $_POST['id_producto'];
        $_SESSION['cesto'] = $productos_cesto;

        if(isset($_SESSION['cestoCantidad']) == true){
           $Cantidad = $_SESSION['cestoCantidad']; 
        }else{
           $Cantidad = [];
        }
  
        $Cantidad[] = $_POST['cantidad-prod'];
        $_SESSION['cestoCantidad'] = $Cantidad;


        if(isset($_SESSION['cestosSub']) == true){
           $sub = $_SESSION['cestosSub']; 
        }else{
           $sub = [];
        }
    
        $sub[]= $_POST['subtotal1']*$_POST['cantidad-prod'];
        $_SESSION['cestosSub'] = $sub;
        ?>
        <meta http-equiv="refresh" content="0;url=index.php">
<?php   
    }     
  }
?>

<div class="container-fluid producto-carrito">
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
              action="descripcion-producto.php?id=<?php echo $producto['IdProducto'];?>"
              method="post">

            <input type="hidden" id="id_producto" name="id_producto" value="<?php echo $producto['IdProducto']?>">
            <input type="hidden" id="subtotal1" name="subtotal1" value="<?php echo $producto['Precio']?>">
            <div class="stock text-center my-3 p-3">Stock  <span id="stock"> <?php echo $producto['Stock']?></span> unidades</div>
            <div class="form-group row">
                 
            <label for="cantidad" class="col-sm-4 col-form-label text-lg-right">Cantidad</label>
                <div class="col-sm-6 col-lg-7">
                    <input type="number" class="form-control text-center" id="cantidad-prod"  name="cantidad-prod">
                </div>
            </div>
            <div class="form-group row">
            <label for="subtotal" class="col-sm-4 col-form-label text-lg-right">Subtotal</label>
                <!-- AGREGANDO EL SUBTOTAL -->
                <div id="div-subtotal" class="div-subtotal input-group col-sm-6 col-lg-7"> 
                
                </div> 
            </div>
            <input id="btnAgregarCarrito" type="submit" class="botonAgregarCarrito btn btn-primary btn-lg btn-block" value="AGREGAR AL CARRITO" disabled="true">
           
            
        </form>   
        <?php endforeach;?>
    </div>
    
  </div>
</div>

<?php require 'includes/templates/footer.php';?>