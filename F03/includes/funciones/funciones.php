<?php

$producto_por_pagina = 20;
$pagina_actual = isset($_GET['pagina_actual']) ? (int)$_GET['pagina_actual'] : 1;
$inicio = ($pagina_actual > 1) ? ($pagina_actual * $producto_por_pagina - $producto_por_pagina) : 0;


// LISTAR PRODUCTOS
function listarProductos(){ 
    include 'conectar.php';
    // Mostrar productos
    try{
        global $producto_por_pagina;
        global $inicio;
        $sqlProducto = "SELECT SQL_CALC_FOUND_ROWS *
                        FROM producto
                        ORDER BY IdProducto
                        LIMIT $inicio, $producto_por_pagina";

        $sqlProducto = $conexion->prepare($sqlProducto);
        $sqlProducto->execute();
        $productos = $sqlProducto->fetchAll(); 
        return $productos;
    }catch(Exception $e){
        echo "Error!!". $e->getMessage(). "<br>";
        return false;
    }
            
}

// TOTAL PAGINAS
function totalPaginas(){

    include 'conectar.php';
    global $producto_por_pagina;
    $sql = "SELECT COUNT(IdProducto) as total_filas FROM producto";
    $sql = $conexion->prepare($sql);
    $sql->execute();
    $total_producto = $sql->fetch()['total_filas'];   
    
    $total_paginas = ceil($total_producto / $producto_por_pagina);

    if($total_paginas > 8){
        $total_paginas = 8;   
    }
    return $total_paginas;
}

// BUSCAR PRODUCTO
function buscarProducto($buscarProducto){
    include 'conectar.php';
    try{   
        return $conexion->query("call Pa_buscar_producto_cliente('$buscarProducto')");

    }catch(Exception $e){
        echo "Error!!". $e->getMessage(). "<br>";
        return false;
    }
}

// OBTENER DESCRIPCION DEL PRODUCTO
function obtenerDescripcionProducto($id){
    include 'conectar.php';
    try{
        return $conexion->query("call Pa_Select_producto($id)");
    }catch(Exception $e){
        echo 'Error!!'. $e->getMessage(). '<br>';
        return false;
    }

}

// BUSCAR CLIENTES
function buscarCliente($buscar_cliente){
    include 'conectar.php';
    try{   
        return $conexion->query("call Pa_buscar_cliente('$buscar_cliente')");

    }catch(Exception $e){
        echo "Error!!". $e->getMessage(). "<br>";
        return false;
    }
}

// INSERTE DETALLES
function InsertarDetalles($IdProducto, $IdPedido, $Cantidad, $SubTotal){
    include 'conectar.php';
    try{   
        return $conexion->query("call Pa_InsertarDetalle($IdProducto, $IdPedido, $Cantidad, $SubTotal)");

    }catch(Exception $e){
        echo "Error!!". $e->getMessage(). "<br>";
        return false;
    }
}

// INSERTE PEDIDOS
function InsertarPedidos($Dni, $Estado, $Suma){
    include 'conectar.php';
    try{   
        return $conexion->query("call  Pa_InsertarPedido('$Dni', $Estado, $Suma)");

    }catch(Exception $e){
        echo "Error!!". $e->getMessage(). "<br>";
        return false;
    }
}

// LISTA PEDIDOD
function ListarPedido(){
    include 'conectar.php';
    // Mostrar productos
    try{
        $sql = "SELECT C.Dni, C.Nombres, C.Apellidos, P.IdPedido, P.Dni, P.Fecha, P.Total, P.Estado FROM cliente as C JOIN pedido
                as P ON C.Dni = P.Dni
                WHERE P.Estado = 1";

        $sql = $conexion->prepare($sql);
        $sql->execute();
        $pedidos = $sql->fetchAll(); 
        return $pedidos;
    }catch(Exception $e){
        echo "Error!!". $e->getMessage(). "<br>";
        return false;
    }

}