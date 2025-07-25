<?php
function consultarClima($ciudad) {
    $url = "https://api.weatherapi.com/v1/current.json?key=6d69c8bcb87741c1a6e150500252407&q=" . urlencode($ciudad);

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $resultado = curl_exec($ch);

    if (curl_errno($ch)) {
        return ["error" => curl_error($ch)];
    }

    curl_close($ch);
    return json_decode($resultado, true);
}
