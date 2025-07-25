<?php
function pagarConPSE($datos) {
    try {
        $wsdl = "https://test.abcpagos.com:8443/WsRealtechTransaciones/Transacciones?wsdl";
        $client = new SoapClient($wsdl, [
            'trace' => 1,
            'exception' => true,
            'cache_wsdl' => WSDL_CACHE_NONE,
        ]);

        $claveOriginal = '9*2z2n5mo$PIDR+P&b&V';
        $codEmpresa = '0081';
        $valorTotal = (float)$datos['monto'];
        $referencia = date("YmdHis"); // Referencia válida de 14 dígitos numéricos

        $clave = md5($claveOriginal . $codEmpresa . $referencia . intval($valorTotal));

        $params = [
            'codEmpresa'        => $codEmpresa,
            'clave'             => $clave,
            'referencia'        => $referencia,
            'descripcionPago'   => 'Compra de ' . $_POST['producto'],
            'valorTotal'        => $valorTotal,
            'iva'               => 0.00,    
            'urlretorno'        => 'https://webhook.site/tu_id_unico',  // temporal para prueba
            'urlconfirmacion'   => 'https://webhook.site/tu_id_unico',
            'email'             => $_POST['email'],
            'codServicio'       => '1001',
            'tipoIdentificacion'=> 'CC',
            'identificacion'    => '1234567890',
            'nombrePagador'     => $_POST['nombre']
        ];

        #echo $clave;

        #echo "<pre>Parámetros enviados:\n" . print_r($params, true) . "</pre>";

        $response = $client->__soapCall("InicioPago", [$params]);

        return $response;

    } catch (Exception $e) {
        return (object)[
            'return' => (object)[
                'codigoError' => 999,
                'descripcionError' => $e->getMessage(),
                'idPago' => 0
            ]
        ];
    }
}
