<?php

session_start();

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

?>