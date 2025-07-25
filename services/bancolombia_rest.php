<?php
function pagarConBancolombia($datos) {
    $url = "https://test.abcpagos.com/api_transacciones/InicioPago"; // Endpoint real
    $claveOriginal = '9*2z2n5mo$PIDR+P&b&V';
    $codEmpresa = '0081';
    $codServicio = '1001';
    $referencia = uniqid('ref_');
    $valorTotal = (int)$datos['monto'];

    $claveMd5 = md5($claveOriginal . $codEmpresa . $referencia . $valorTotal);

    $payload = [
        "conceptoServicio" => "Pago de producto",
        "codEmpresa" => $codEmpresa,
        "codServicio" => $codServicio,
        "referencia" => $referencia,
        "nombrePagador" => $datos['nombre'],
        "email" => $datos['email'],
        "tipoIdentificacion" => "CC",
        "identificacion" => "1234567890", // puedes adaptar esto si tienes el dato
        "iva" => 0,
        "valorTotal" => $valorTotal,
        "descripcionPago" => "Compra desde botón Bancolombia",
        "clave" => $claveMd5,
        "infoAdicional" => "Botón Bancolombia",
        "codMedioPago" => "4",
        "urlRetorno" => "http://localhost:8000/index.php",
        "urlConfirmacion" => "http://localhost:8000/index.php"
    ];

    #echo "<pre>Parametros enviados:\n" . print_r($payload, true) . "</pre>";

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));

    $result = curl_exec($ch);

    if (curl_errno($ch)) {
        return ["error" => curl_error($ch)];
    }

    curl_close($ch);

    return [
        "statusCode" => http_response_code(),
        "message" => $result
    ];
}
