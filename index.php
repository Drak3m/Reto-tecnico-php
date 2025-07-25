<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reto Draken - Realtech</title>
    <link rel="stylesheet" href="assets/styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
</head>
<body>

    <div class="contenedor">
        <!-- Columna 1: Simulación de Compra -->
        <div class="columna">
        <img src="img/pago.png" style="width: 100%; height: auto; border-radius: 12px; margin-bottom: 20px;">
            <h2>Simulación de Compra</h2>
            <form method="POST">
                <input type="text" name="nombre" placeholder="Nombre completo" required>
                <input type="email" name="email" placeholder="Email" required>
                <input type="text" name="producto" placeholder="Producto" required>
                <input type="number" name="monto" placeholder="Monto" required>
                <button name="accion" value="pse">Pagar con PSE</button>
                <button name="accion" value="bancolombia">Pagar con Bancolombia</button>
            </form>

            <div class="resultado">
                <?php
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $accion = $_POST['accion'];

                    require_once 'services/pse_soap.php';
                    require_once 'services/bancolombia_rest.php';
                    

                    switch ($accion) {
                        case 'pse':
                            $respuesta = pagarConPSE($_POST);
                            $retorno = $respuesta->return ?? null;
                        
                            #echo "<h3>Respuesta PSE:</h3><pre>";
                            #print_r($retorno);
                            #echo "</pre>";
                        
                            if ($retorno && isset($retorno->codigoError) && $retorno->codigoError == 0) {
                                echo '
                                    <div class="exito-pago">
                                        <h2>✅ ¡Pago iniciado exitosamente!</h2>
                                        <p>Tu número de pago es: <strong>#' . $retorno->idPago . '</strong></p>
                                        <a class="boton-pago" href="https://test.abcpagos.com/transaccion?idPago=' . $retorno->idPago . '" target="_blank">
                                            Ir al botón de pago PSE
                                        </a>
                                    </div>';
                            } else {
                                echo '<div class="error-pago"><strong>Error:</strong> ' . htmlspecialchars($retorno->descripcionError ?? 'Error desconocido') . '</div>';
                            }
                            break;
                        

                        case 'bancolombia':
                            $respuesta = pagarConBancolombia($_POST);
                            echo "<h3>Respuesta Bancolombia:</h3>";
                            $mensaje = json_decode($respuesta['message'], true);

                            if (isset($mensaje['codigoError']) && $mensaje['codigoError'] === "0") {
                                $idPago = $mensaje['idPago'];
                                echo '
                                <div class="exito-pago">
                                    <h2>✅ ¡Pago iniciado exitosamente!</h2>
                                    <p>Tu número de pago es: <strong>#' . $idPago . '</strong></p>
                                    <p>Puedes continuar con tu transacción dando clic en el botón:</p>
                                    <a class="boton-pago" href="https://test.abcpagos.com/transaccion?idPago=' . $idPago . '" target="_blank">
                                        Ir al botón de pago Bancolombia
                                    </a>
                                </div>';
                            } else {
                                echo '<div class="error-pago"><strong>Error:</strong> ' . htmlspecialchars($mensaje['descripcionError'] ?? 'Error desconocido') . '</div>';
                            }
                            break;
                    }
                }
                ?>
            </div>
        </div>

        <!-- Columna 2: Consulta de Clima -->
        <div class="columna">
        <img src="img/weather.png" style="width: 100%; height: auto; border-radius: 12px; margin-bottom: 20px;">

            <h2>Consulta de Clima</h2>
            <form method="POST">
                <input type="text" name="ciudad" placeholder="Ciudad para consultar clima" required>
                <button name="accion" value="clima">Consultar Clima</button>
            </form>

            <div class="resultado">
                <?php
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $accion = $_POST['accion'];

                    require_once 'services/pse_soap.php';
                    require_once 'services/bancolombia_rest.php';
                    require_once 'services/clima_rest.php';

                    switch ($accion) {
                        case 'clima':
                            $respuesta = consultarClima($_POST['ciudad']);
                            $temp = $respuesta['current']['temp_c'] ?? null;
                            if ($temp !== null) {
                                echo '
                                <div class="exito-clima">
                                    <h3>Temperatura actual en ' . $_POST['ciudad'] . ': ' . $temp . '°C</h3>
                                </div>';
                                
                            } else {
                                echo "<h3>No se pudo obtener la temperatura.</h3>";
                            }
                            break;
                    }
                }
                ?>
            </div>
        </div>
    </div>

</body>
</html>
