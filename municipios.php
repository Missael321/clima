<?php
    $cadena = $_POST['estado'];
    $val = ' ';
    $remp = '%20';
    $estado = str_replace($val, $remp, $cadena);
    $link = 'https://api-sepomex.hckdrk.mx/query/get_municipio_por_estado/'.$estado;
    $json2 = file_get_contents($link);
    $res = json_decode($json2);
    $municipio = $res->{'response'}->{'municipios'};

    $cadena = "<select id='municipios' name='municipios' class='custom-select'>";
    sort($res->{'response'}->{'municipios'}, SORT_NATURAL | SORT_FLAG_CASE);
    foreach ($res->{'response'}->{'municipios'} as $key => $municipio) {
        $cadena = $cadena.'<option value='.$municipio.'>'.$municipio.'</option>';        
    }
    echo $cadena."</select><br><div id='cp'><p></p></div>";
?>