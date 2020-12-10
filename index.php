<?php
    date_default_timezone_set("America/Mexico_City");
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" href="images/favicon.ico" type="image/ico" />

    <title>Clima</title>
    <link href="vendors/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="vendors/nprogress/nprogress.css" rel="stylesheet">
    <link href="vendors/iCheck/skins/flat/green.css" rel="stylesheet">
    <link href="vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet">
    <link href="vendors/jqvmap/dist/jqvmap.min.css" rel="stylesheet"/>
    <link href="vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
    <link href="build/css/custom.min.css" rel="stylesheet">
  </head>

  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0;">
              <a href="index.php" class="site_title"><i class="fas fa-snowflake"></i><span>Clima</span></a>
            </div>

            <div class="clearfix"></div>

            <br />
            <?php                 
        $val = ' ';
        $remp = '%20';
        $link = 'https://api-sepomex.hckdrk.mx/query/get_estados';
        $json2 = file_get_contents($link);
        $res = json_decode($json2);
        $estados = $res->{'response'}->{'estado'};
        $estado = str_replace($val, $remp, $estados);
    ?> 
            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
              <div class="col-auto text-center">                
                <form action="#" method="post" class="form-group">
                    <h6 class="text-white">Estado</h6>   
                    <br>
                    <select name="estados" id="estados" class="custom-select mr-sm-2">         
                        <option value="Aguascalientes">Aguascalientes</option>
                        <option value="Baja California">Baja California</option>
                        <option value="Baja California Sur">Baja California Sur</option>
                        <option value="Campeche">Campeche</option>
                        <option value="Coahuila de Zaragoza">Coahuila de Zaragoza</option>
                        <option value="Colima">Colima</option>
                        <option value="Chiapas">Chiapas</option>
                        <option value="Chihuahua">Chihuahua</option>
                        <option value="Ciudad de Mexico">Ciudad de México</option>
                        <option value="Durango">Durango</option>
                        <option value="Guanajuato">Guanajuato</option>
                        <option value="Guerrero">Guerrero</option>
                        <option value="Hidalgo">Hidalgo</option>
                        <option value="Jalisco">Jalisco</option>
                        <option value="Mexico">México</option>
                        <option value="Michoacan de Ocampo">Michoacán de Ocampo</option>
                        <option value="Morelos">Morelos</option>
                        <option value="Nayarit">Nayarit</option>
                        <option value="Nuevo Leon">Nuevo León</option>
                        <option value="Oaxaca">Oaxaca</option>
                        <option value="Puebla">Puebla</option>
                        <option value="Queretaro">Querétaro</option>
                        <option value="Quintana Roo">Quintana Roo</option>
                        <option value="San Luis Potosi">San Luis Potosí</option>
                        <option value="Sinaloa">Sinaloa</option>
                        <option value="Sonora">Sonora</option>
                        <option value="Tabasco">Tabasco</option>
                        <option value="Tamaulipas">Tamaulipas</option>
                        <option value="Tlaxcala">Tlaxcala</option>
                        <option value="Veracruz de Ignacio de la Llave">Veracruz de Ignacio de la Llave</option>
                        <option value="Yucatan">Yucatán</option>
                        <option value="Zacatecas">Zacatecas</option>
                    </select>  
                    <br>
                    <br>
                    <h6 class="text-white">Municipio</h6>
                    <br>                                      
                    <div id="municipios"></div>
                    <br>
                    <input type="submit" value="Enviar" class="btn btn-outline-light">
                </form>
              </div>
              

            </div>
          </div>
        </div>

        <div class="top_nav">
            <?php            
            $hoy = date("y-m-d");
            $hora = date("H:i:s");            
            $date = new DateTime($hoy."T".$hora);
            $unix = $date->format("U");

            $diaA1 = date("y-m-d",strtotime($hoy." - 1 days"));
            $dateA1 = new DateTime($hoy."T12:00:00");
            if ( isset($_POST['estados']) ) {
              $estadoI = $_POST['estados'];
              $municipioI = $_POST['municipios'];
            } else {
              $estadoI = 'Chiapas';
              $municipioI = 'Ocosingo';
            }           
            $unixA2 = $date->format("U");$cad = "https://api-sepomex.hckdrk.mx/query/search_cp_advanced/".$estadoI."?limit=10&municipio=".$municipioI;
            $link2 = str_replace($val, $remp, $cad);
            $json3 = file_get_contents($link2);
            $resp2 = json_decode($json3);
            $cp = $resp2->{'response'}->{'cp'}[0]; 
            $urlE = 'https://api-sepomex.hckdrk.mx/query/info_cp/'.$cp;
            $jsonE = file_get_contents($urlE);
            $respE = json_decode($jsonE);
            $oEstado = $respE[0]->{'response'}->{'estado'};
            $oMunicipio = $respE[0]->{'response'}->{'municipio'};                                 
            $url = "https://api.openweathermap.org/data/2.5/weather?zip=".$cp.",mx&appid=b4db3149a3f9ba23ee8607086cc3f210";
            $json = file_get_contents($url);
            $resp = json_decode($json);
            $lon = $resp->{'coord'}->{'lon'};
            $lat = $resp->{'coord'}->{'lat'};
            ?>
            <div class="nav_menu">
                <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
                </div>
                <nav class="nav navbar-nav">
                <a href="integrantes.php">                
                  <button class="my-3 mx-5 float-right btn btn-outline-dark">Integrantes</button>
                </a>
                </nav>
            </div>
            </div>

        <div class="right_col" role="main">
          <div class="row" style="display: inline-block;" >
          <div class="tile_count">
          </div>
        </div>

          <div class="row">
            <div class="col-md-12 col-sm-12 ">
              <div class="dashboard_graph">
                <div class="row x_title">
                  <div class="col-md-6">
                    <h3>Clima</h3>
                  </div>
                  <div class="col-md-6">
                  </div>
                </div>

                <div class="col-md-12 col-sm-12">
                  <div class="x_panel">
                    <div class="x_title">
                              <?php
                                echo date("l").'</b>,'.date("h:i A"); 
                              ?>                      
                      <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </li>
                        <li><a class="close-link"><i class="fa fa-close"></i></a>
                        </li>
                      </ul>
                      <div class="clearfix"></div>
                    </div>
                    <?php
                    $urlh = 'https://api.openweathermap.org/data/2.5/onecall?lat='.$lat.'&lon='.$lon.'&exclude=hourly,minutely&units=metric&appid=b4db3149a3f9ba23ee8607086cc3f210';
                    $jsonh = file_get_contents($urlh);
                    $resph = json_decode($jsonh);
                    $temp = $resph->{'current'}->{'temp'};
                    $pressure = $resph->{'current'}->{'pressure'};
                    $humidity = $resph->{'current'}->{'humidity'};
                    $point = $resph->{'current'}->{'dew_point'};
                    $icon = $resph->{'current'}->{'weather'}[0]->{'icon'};
                    ?>
                    <div class="x_content">
                      <div class="row">
                        <div class="col-sm-12">
                        
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-sm-4">
                          <div class="weather-icon text-center">
                            <img src="http://openweathermap.org/img/wn/<?= $icon ?>@4x.png">
                            <br>
                            <h3 class="degrees"><?= $temp ?></h3>
                            <hr>
                          </div>
                        </div>
                        <div class="col-sm-8">
                          <div class="weather-text">
                            <h2> <?php echo $oMunicipio.', '.$oEstado; ?></h2>
                            <br>
                            <h2>Precipitación:  <?= $pressure ?> hPa </h2>
                            <h2>Humedad:  <?= $humidity ?>% </h2>
                            <h2>Punto de rocío:  <?= $point ?>°C </h2>
                          </div>
                        </div>
                      </div>                        
                      <div class="col-sm-12">
                      </div>
                      <div class="clearfix"></div>
                      <div class="row weather-days">   
                      <?php                        
                                $urlD = 'https://api.openweathermap.org/data/2.5/onecall?lat='.$lat.'&lon='.$lon.'&exclude=hourly,current,minutely&units=metric&appid=b4db3149a3f9ba23ee8607086cc3f210';
                                $jsonD = file_get_contents($urlD);
                                $respD = json_decode($jsonD);
                                $temp = $respD->{'daily'}[0]->{'temp'}->{'max'};
                                foreach ($respD->{'daily'} as $key => $temp) {
                                    $dia = date("l", strtotime($hoy."+".$key."days"));
                                    $tempD = $respD->{'daily'}[$key]->{'temp'}->{'max'};
                                    $speed = $respD->{'daily'}[$key]->{'wind_speed'};
                                    $icon = $respD->{'daily'}[$key]->{'weather'}[0]->{'icon'};
                                    ?>                                                                                      
                                    <div class="col-sm-2">                            
                          <div class="daily-weather text-center">
                            <h2 class="day"><?= $dia ?></h2>
                            <h3 class="degrees"><?= $tempD ?></h3>
                            <img src="http://openweathermap.org/img/wn/<?= $icon ?>@2x.png">
                            <h5><?= $speed ?><i>km/h</i></h5>
                            <br>
                        </div>
                        </div>
                            <?php          
                                }                                
                            ?>
                            <div class="clearfix"></div>
                      </div>
                    </div>
                  </div>
                </div>                            

                <div class="clearfix"></div>
              </div>
            </div>

          </div>
          <br /> 
          <div class="row">
            <div class="col-md-4 col-sm-4 ">
              <div class="x_panel">
                <div class="x_title">
                  <h2>Tweets</h2>
                  <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                    <li><a class="close-link"><i class="fa fa-close"></i></a>
                    </li>
                  </ul>
                  <div class="clearfix"></div>
                  </div>
                <div class="x_content">
                  <div class="dashboard-widget-content">
                  <?php
                    $cad = str_replace(' ', '', $estadoI);
                    $hashtag = $cad.' clima';
                    include "twitterQuery.php";
                    $respuesta = queryTwitter( $hashtag );
                    $json2 = json_decode($respuesta);            
                    foreach ($json2->statuses as $key => $respuesta) {                    
                    $name = $json2->{'statuses'}[$key]->{'user'}->{'name'};
                    $screen_name = $json2->{'statuses'}[$key]->{'user'}->{'screen_name'};
                    $text = $json2->{'statuses'}[$key]->{'text'};                                                      
               ?>
                <div class="col-lg-6 mb-4  d-inline p-2">
                  <div class="card bg-white shadow">
                    <div class="card-body">
                      <i class="fab fa-twitter fa-2x text-primary float-left"></i>
                      <?php echo "<p>"."&nbsp"."&nbsp".$name."</p>" ?>                                            
                      <?php echo "<a href='https://twitter.com/$screen_name' target='_blank'>"." @"."<span class='font-weight-bold'>".$screen_name."</span>"."</a>" ?>
                      <br>
                      <br>
                      <div><?php echo $text ?></div>
                    </div>
                    <?php 
                      if ( !empty( $url = @$json2->{'statuses'}[$key]->{'entities'}->{'urls'}[0]->{'url'}) ) { ?>
                        <a href="<?= $url ?>" target="_blank" class="text-center">
                          <button type="button" class="btn btn-outline-primary">
                            Ver Tweet
                          </button>
                        </a>
                        <br>
                     <?php      
                      }
                     ?>
                  </div>
                </div>
              <?php } ?>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-8 col-sm-8 "><div class="row">
                <div class="col-md-12 col-sm-12 ">
                  <div class="x_panel">
                  <div class="x_title">
                  <h2>Videos</h2>
                  <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                    <li><a class="close-link"><i class="fa fa-close"></i></a>
                    </li>
                  </ul>
                  <div class="clearfix"></div>
                </div>                
                  <?php
                require_once 'api/vendor/autoload.php';
                $busqueda = $estadoI.' clima';
                $max =  4;
                    $DEVELOPER_KEY = 'AIzaSyA4-cG74_Xz2bJTXssFTeqdIqW3TIDVJ_E';
                    $client = new Google_client();
                    $client->setApplicationName('UTSelva4B');
                    $client->setDeveloperKey($DEVELOPER_KEY);
                    $youtube = new Google_Service_YouTube($client);
                    $respuesta = $youtube->search->listSearch('id,snippet', array(
                        'q' => $busqueda,
                        'maxResults' => $max,
                        'order' => 'date'
                    ));

                    foreach ($respuesta['items'] as $video) {
                        $titulo = $video['snippet']['title'];
                        $texto = $video['snippet']['description'];
                        $fecha = $video['snippet']['publishedAt'];
                        $thumbnails = $video['snippet']['thumbnails'];
                        $imagen = $thumbnails['medium']['url'];
                        $id = $video['id']['videoId'];
                        ?>
                        <div class="col-lg-6 mb-4">
                  <div class="card bg-white shadow">
                    <div class="card-body d-inline p-2">
                    <a href="https://www.youtube.com/watch?v=<?php echo $id; ?>" target="_blank">
                      <img src="<?php echo $imagen; ?>" class="card-img" alt="...">
                      <br>
                      <br>
                    </a>
                      <div>
                      <h5 class="card-title"><?php echo $titulo; ?></h5>
                        </div>
                      </div>                    
                        <a href="https://www.youtube.com/watch?v=<?php echo $id; ?>" target="_blank" class="text-center">
                          <button type="button" class="btn btn-outline-danger">
                            Ver en YouTube
                          </button>
                        </a>
                        <br>
                  </div>
                </div>
                    <?php    
                    }
            ?>
                  </div>
                </div>
            </div>              
          </div>
        </div>
        <footer>
          <div class="clearfix"></div>
        </footer>
      </div>
    </div>

    <script src="vendors/jquery/dist/jquery.min.js"></script>
    <script src="vendors/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="vendors/fastclick/lib/fastclick.js"></script>
    <script src="vendors/nprogress/nprogress.js"></script>
    <script src="vendors/Chart.js/dist/Chart.min.js"></script>
    <script src="vendors/gauge.js/dist/gauge.min.js"></script>
    <script src="vendors/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
    <script src="vendors/iCheck/icheck.min.js"></script>
    <script src="vendors/skycons/skycons.js"></script>
    <script src="vendors/Flot/jquery.flot.js"></script>
    <script src="vendors/Flot/jquery.flot.pie.js"></script>
    <script src="vendors/Flot/jquery.flot.time.js"></script>
    <script src="vendors/Flot/jquery.flot.stack.js"></script>
    <script src="vendors/Flot/jquery.flot.resize.js"></script>
    <script src="vendors/flot.orderbars/js/jquery.flot.orderBars.js"></script>
    <script src="vendors/flot-spline/js/jquery.flot.spline.min.js"></script>
    <script src="vendors/flot.curvedlines/curvedLines.js"></script>
    <script src="vendors/DateJS/build/date.js"></script>
    <script src="vendors/jqvmap/dist/jquery.vmap.js"></script>
    <script src="vendors/jqvmap/dist/maps/jquery.vmap.world.js"></script>
    <script src="vendors/jqvmap/examples/js/jquery.vmap.sampledata.js"></script>
    <script src="vendors/moment/min/moment.min.js"></script>
    <script src="vendors/bootstrap-daterangepicker/daterangepicker.js"></script>
    <script src="build/js/custom.min.js"></script>
	
  </body>
</html>

<script type="text/javascript">
    $(document).ready(function() {
        recargarLista();
    
        $('#estados').change(function() {
        recargarLista();
        });

    })
</script>

<script type="text/javascript">
    function recargarLista(){
        $.ajax({
            type: "POST",
            url: "municipios.php",
            data: "estado=" + $('#estados').val(),
            success: function(r) {
                $('#municipios').html(r);
            }
        });
    }
</script>