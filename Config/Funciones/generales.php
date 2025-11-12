<?php 
    function formatearFecha($fecha) {
        $dateTime = new DateTime($fecha);   
        return $dateTime->format('H:i:s d/m/Y');
    }

    function convertirFecha($fecha){
        $fecha = explode("T", $fecha);
        $fecha1 = explode("-", $fecha[0]);
        $hora = explode(".", $fecha[1]);
        $hora = $hora[0];
        $hoy = $fecha1[2] . "-" . $fecha1[1] . "-" . $fecha1[0] . " " . $hora;
        return $hoy;
    }

    function convertirFecha2($fecha){
        $fecha = explode("T", $fecha);
        $fecha1 = explode("-", $fecha[0]);
        $hora = explode(".", $fecha[1]);
        $hora = $hora[0];
        $hoy = $hora;
        return $hoy;
    }
    function status($dato){
        if($dato==1){$res ="Required";
        }elseif($dato==2){$res ="Executed";
        }elseif($dato==3){$res ="Validated";    
        }else{$res ="canceled";}
        return $res;
    }
    function validarco2($dato){
        if($dato<0 ||$dato>30){$dato="NA";}
        return $dato;
    }
    function parametro($dato){
        if($dato==1){$res ="PPM";
        }elseif($dato==2){$res ="%";
        }elseif($dato==3){$res ="F°";    
        }else{$res ="H";}
        return $res;
    }
    //pasar_celcius
    function pasar_celcius($dato){
        $celsius = (5 / 9) * ($dato - 32);  
        return number_format($celsius, 1);
    }
    function validarModal($matriz){
        $text1 ="<div class='container'>
            <div class='row'>
                <div class='col'></div>
                <div class='col-3'>
                    <h3 class='text-warning'><strong>".$matriz[0]." ".parametro($matriz[2])."</strong></h3></div>
                <div class='col-2'>
                    <i class='bi bi-box-arrow-right'></i>
                </div>
                <div class='col-3'><h3 class='text-success'><strong>".$matriz[1]." ".parametro($matriz[2])."</strong></h3></div>
                <div class='col'></div>
            </div>
        </div>";
        return $text1;
    }
    function comandos_pendientes($testComandos){
        $text_comanos="<div> no pending commands </div>";
        if($testComandos){
            $resultadoComando = json_decode($testComandos);
            $resultadoComando = $resultadoComando->data;
            if($resultadoComando){
                $epa =" hay en total estos  elementos :  ".count($resultadoComando);
                $text_comanos ="<p></p>
                <div><h1>Pending Commands, please wait  :</h1></div>
                <table class='table'>
                <thead>
                  <tr>
                    <th scope='col'>#</th>
                    <th scope='col'>Resumen</th>
                    <th scope='col'>Date</th>
                    <th scope='col'>Status</th>
                  </tr>
                </thead>
                <tbody>";
                //aqui ocurre el foreach 
                foreach ($resultadoComando as $index => $valor) {
                    $index_id=$index +1;
                    $text_comanos =$text_comanos."<tr>
                    <th scope='row'>".$index_id."</th>
                    <td>".$valor->evento."</td>
                    <td>".formatearFecha($valor->fecha_creacion)."</td>
                    <td>".status($valor->status)."</td>
                  </tr>";
                }
                $text_comanos =$text_comanos."</tbody>
              </table>";

            }else{
                $epa = "No hay resultados";
            }
        } 
        return $text_comanos;
    }

    function fechaGrafica($dateI,$dateF){
        // Crear objetos DateTime a partir de las cadenas de fecha
        $dateInicial = new DateTime($dateI);
        $dateFinal = new DateTime($dateF);
        //$actual = new DateTime("now");
        if($dateFinal<$dateInicial ){
            $dif="mal";
        }else{
            //si paso 2 años decir que deb contactarse con el administrador
            $interval = $dateInicial->diff($dateFinal);
            $colosal = $interval->format('%Y');
            if($colosal>=2){ $dif="rango";
            }else{ $dif="ok";}
        }
        return $dif;

    }
function tempNormal($val){ 
    // Verificar si el valor está dentro del rango permitido
    if($val < -40 || $val > 120) {
        return "NA";
    }

    if($val>=0 && $val<120){
        	
        //(0 °C × 9/5) + 32 = 32 °F
        $val = ($val*9)/5+32 ;
        $valor="+".$val ;
    }elseif($val>-40 && $val<0){
        if($val==-38.5){
            $valor="NA";
        }else{
            $val = ($val*9)/5+32 ;
            $valor=$val ;
        }
    }else{
        $valor="NA";
    }
    return $valor;
}

function porcentaje($val){
    //Si val es menor a 0 y mayor a 100 = NA
    if($val>=0 && $val<=100){
        $valor=$val ;
    }else{
        $valor="NA";
    }
    return $valor;
}

function validateDate($date, $format = 'Y-m-d\TH:i:s'){
    $d = DateTime::createFromFormat($format, $date);
    if($d && $d->format($format) == $date){
        return $date;
    }else{
        return $date.":00";   
    }
    //return $d && $d->format($format) == $date;
}
function gmtFecha($val){
    if($_SESSION['utc']!=300){
        $val1 =  strtotime($val);
        $dif =300-$_SESSION['utc'];
        $minutes = $dif." minutes";
        $puntoA1 = strtotime($minutes,$val1);
        $val = date('Y-m-d\TH:i:s', $puntoA1);
    }
    return $val;
}

function determinarEstado($ultima_fecha ,$id,$est) {
    if($est==[]){
        $est=[0,0,0];
    }
    date_default_timezone_set('UTC');
    $hoy = date("Y-m-d H:i:s");                   
    $fechaActual = new DateTime($hoy);
    $fechaUltima = new DateTime($ultima_fecha);
    #$diferencia = $fechaActual->getTimestamp() - $fechaUltima->getTimestamp();
    $diferencia = $fechaActual->diff($fechaUltima);
    
    // Convertir la diferencia en minutos
    $diferenciaEnMinutos = ($diferencia->days * 24 * 60) + ($diferencia->h * 60) + $diferencia->i;
    
    //tiempo en segundos
    if ($diferenciaEnMinutos <= 30+300) { 
        $est[0]=$est[0]+1;
        #return 'Online';
    } elseif ($diferenciaEnMinutos <= 1440+300) { 
        $est[1]=$est[1]+1;
        #return 'Wait';
    } else {
        $est[2]=$est[2]+1;
        #return 'Offline';
    }
    //array_push($est,$ultima_fecha,$diferenciaEnMinutos,$fechaActual);
    return $est;
}

function porNormal($val){
    if($val>=0 && $val<100){$valor=$val ;}else{$valor="NA";}
    return $valor;
}
function val_eti($val){
    if($val>=0 && $val<280){$valor=$val ;}else{$valor="NA";}
    return $valor;
}
function validateP($val){
    /*
    if($val == 5){
        $valor = "Active";
    }else{
        $valor = "Inactive";
    }*/
   // $valor="Ripener Mode";
    $valor = "Inactive";
    //$valor = "Cooling Mode";


    return $valor;
} 
function ContenedorPlantilla($val,$url=0, $tipo=1){      
    if($tipo==0){
        $result = ContenedorReefer($val,$url);
    }elseif($tipo==1){
        $result = ContenedorMadurador($val,$url);
    }elseif($tipo==2){
        $result = ContenedorTunel($val,$url);
    }
    return $result;
}
function fechaPro($val){
    //echo $val;
    //previa validacion de GMT  "Y-m-d\TH:i:s
    $_SESSION['utc']=300;
    if($_SESSION['utc']!=300){
        $val1 =  strtotime($val);
        $dif =300-(int)$_SESSION['utc'];
        $minutes = $dif." minutes";
        $puntoA1 = strtotime($minutes,$val1);
        $val = date('Y-m-d\TH:i:s', $puntoA1);
    }
    $ultima = explode("T",$val) ;
    $fech = explode("-",$ultima[0]);
    //echo $ultima[0];
    //echo " luis ";
    //echo $fech;
    $fech1 = $fech[2]."/".$fech[1]."/".$fech[0] ; 
    //echo $fech1;
    $fechita =$ultima[1]." - ".$fech1;           

    //$fech1 = $fech[2]."/".$fech[1]."/".$fech[0] ; 
    //$fechita =$ultima[1]." del  ".$fech1;
    return $fechita;
}

function ContenedorReefer($val, $url){
}

function ContenedorTunel($val, $url){
}
function avl_1($dato){
    if($dato==0){
        $res = 0 ;
    }else{
        if($dato>0&& $dato<200){
            $res =$dato/2;
        }else{
            $res="NA";
        }
    }
    return $res;
}
function horas_simuladas($dato){
   //return 24 ;
   // return 12 ;
    return 0 ;


}
function ContenedorMadurador_2($val){ 
    $text = "
            <div class='row text-center'>
                <div class='py-2 col-4 col-lg-4'>
                    <div class='card' id='alarmaModal'>
                        <div class='card-body'>
                            <i class='bi bi-bell fs-1 text-warning modal-icon'></i>
                            <div class='d-flex justify-content-center align-items-center gap-1'>
                                <h5 class='text-uppercase text-warning modal-text'>Alarmas</h5>
                                <span class='badge bg-warning text-white fs-6'>{$val->alarmas}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class='py-2 col-4 col-lg-4'>
                    <div class='card' id='mensajeModal'>
                        <div class='card-body'>
                            <i class='bi bi-chat fs-1 text-success modal-icon'></i>
                            <div class='d-flex justify-content-center align-items-center gap-1'>
                                <h5 class='text-uppercase text-success modal-text'>Mensajes</h5>
                                <span class='badge bg-success text-white fs-6'>{$val->mensajes}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class='py-2 col-4 col-lg-4'>
                    <div class='card' id='horasModal'>
                        <div class='card-body'>
                            <i class='bi bi-clock fs-1 text-secondary modal-icon'></i>
                            <div class='d-flex justify-content-center align-items-center gap-1'>
                                <h5 class='text-uppercase text-secondary modal-text'>Horas</h5>
                                <span class='badge bg-secondary text-white fs-6'>{$val->horas}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        <div class='card'>
            <div class='card-body'>
                <div class='d-flex flex-wrap justify-content-center'>
                    <div class='col-12 col-lg-8 table-responsive'>
                        <table class='table text-center' id='tblGenset' width='100%'>
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>IMEI</th>
                                    <th>Código</th>
                                    <th>Estado</th>
                                    <th>Horómetro</th>
                                    <th>Alertas</th>
                                    <th>Combustible</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    <div class='col-12 col-lg-4'>
                        <div class='card border-0'>
                            <div class='card-body'>
                                <h5 class='text-uppercase'>Gráfico</h5>
                                <div class='d-flex justify-content-center'>
                                    <canvas id='gBarra' width='200' height='200'></canvas>
                                </div>
                            </div>
                            <div class='card-body'>
                                <h5 class='text-uppercase'>Gráfico</h5>
                                <div class='d-flex justify-content-center'>
                                    <canvas id='gPastel' width='200' height='200'></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class='card mt-2'>
            <div class='card-body'>
                <div class='d-flex flex-wrap justify-content-center'>
                    <div class='col-12 col-lg-12'>
                        <!-- map leaflet-->
                        <div id='map' style='height: 400px;'></div>
                    </div>
                </div>
            </div>
        </div>";
        /*
        $result = array(
            'text'=>$text
            //'latitud'=>$val->latitud,
            //'longitud'=>$val->longitud,
            //'nombre_contenedor'=> $val->nombre_contenedor,
        );
        return $result;*/
        return $text;
    }

    /*
    //parte de los usdas 2 y 3

                        <div class='col-6 col-lg-3 border-top border-bottom hide-content' hidden>
                        <div class='text-center'>
                            <i class='bi bi-eyedropper fs-1'></i>
                            <h4 class='text-uppercase text_params'>USDA 2</h4>
                            <div class='d-flex justify-content-center align-content-center'>
                                <p class='value-icon' id='usda_2_icon_{$val->telemetria_id}'><i class='bi bi-arrows me-2 align-items-center mb-1 text-primary value-icon'></i></p>
                                <label for='usda_2' class='fw-bold value_params value_icon' id='usda_2_{$val->telemetria_id}'>{$cargo_2_temp_f} F°</label>
                            </div>
                        </div>
                    </div>
                                        <div class='col-6 col-lg-3 border-top border-bottom hide-content' hidden>
                        <div class='text-center '>
                            <i class='bi bi-eyedropper fs-1'></i>
                            <h4 class='text-uppercase text_params'>USDA 3</h4>
                            <div class='d-flex justify-content-center align-content-center'>
                                <p class='value-icon' id='usda_3_icon_{$val->telemetria_id}'><i class='bi bi-arrows me-2 align-items-center mb-1 text-primary value-icon'></i></p>
                                <label for='usda_3' class='fw-bold value_params value_icon' id='usda_3_{$val->telemetria_id}'>{$cargo_3_temp_f} F°</label>
                            </div>
                        </div>
                    </div>


    */

