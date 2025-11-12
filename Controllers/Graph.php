<?php
class Graph extends Controller
{
    public function __construct() 
    {
        session_start();
        if (empty($_SESSION['activo_ztrack'])) {
            header("location: " . base_url);
        }
        parent::__construct();      
    }
    public function index()
    {

        $this->views->getView($this, "index");
    }
    //ListaDispositivoEmpresa
    public function ListaDispositivoEmpresa()
    {
        $data = $this->model->ListaDispositivoEmpresa($_SESSION['empresa_genset_id']);
        $data = json_decode($data);
        $data = $data->data;
        $data=$data[0];

        /*
        $text ="";
        $data2 =[];
        $url = base_url;
        $fecha=[];
        
        foreach($data as $val){
            $tipo = $val->extra_1;
            $enlace = ContenedorPlantilla($val,$url, $tipo) ;
            $fecha =  determinarEstado($val->ultima_fecha ,$id =1,$fecha);
            $text.=$enlace['text'];
            array_push($data2 ,array(
                'latitud'=>$enlace['latitud'],
                'longitud'=>$enlace['longitud'],
                'nombre_contenedor'=> $enlace['nombre_contenedor'],
            ));
        }
        //$data->text = $text;
        $data1 =array(
            //'data'=>tarjetamadurador($val)
            'data'=>$data2,
            'text'=>$text,
            'extraer'=>$_SESSION['data'],
            'estadofecha'=>$fecha
        );
        */

        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();

    } 

    //GraficaInicial
    public function GraficaInicial($param){
        //echo json_encode($param, JSON_UNESCAPED_UNICODE);
        if($param!=""){
            $pros = explode(",",$param);
            //se debe enviar id de telemetria
            $nombre = $pros[0];
            $telemetria = $pros[1];

            $fechaI =(isset($pros[2])) ? $pros[2] :"0" ;
            $fechaF =(isset($pros[3])) ? $pros[3] :"0" ;
            // consultar para nombre_contenedor y ultima fecha 
            $consultaUltima = $this->model->ContenedorData($nombre);
            $resultadoL = json_decode($consultaUltima);
            $resultadoL = $resultadoL->data;
            $ultimaFecha = $resultadoL[0]->ultima_fecha;
            if($fechaI=="0" && $fechaF=="0"){
                $cadena = array(
                    'device'=>$telemetria,
                    'ultima'=>gmtFecha($ultimaFecha),
                    'utc'=>$_SESSION['utc']
                );
            }else{
                if(fechaGrafica($fechaI,$fechaF)=="ok"){
                    $cadena = array(
                        'device'=>$telemetria,
                        'ultima'=>gmtFecha($ultimaFecha),
                        //'fechaI'=>$fechaI.":00",
                        //'fechaF'=>$fechaF.":00"
                        'fechaI'=> validateDate($fechaI),
                        'fechaF'=> validateDate($fechaF),
                        'utc'=>$_SESSION['utc']
                        
                    );
                    //validateDate($fechaI, $format = 'Y-m-d H:i:s')
                }else{
                    $cadena = array();
                }
            }
            if(count($cadena)!=0){
                //hacer peticion de data en el servidor 
                $dataMadurador = $this->model->DatosGraficaTabla($cadena);
                $resultadoMadurador = json_decode($dataMadurador);
                $resultadoMadurador = $resultadoMadurador->data;
            }else{
                $resultadoMadurador =fechaGrafica($fechaI,$fechaF);
            }
        }else{
            $resultadoMadurador ="";
        }
        echo json_encode($resultadoMadurador , JSON_UNESCAPED_UNICODE);

    }

    public function DatosDispositivo(){ 
        $data = [];
        for($i=0;$i<10;$i++){
            $fecha_r = strtotime('2024-10-01');
            $fecha = date("Y-m-d H:i:s",rand($fecha_r,time()));
            $data[$i]['created_at'] = $fecha;
            $data[$i]['b_voltage'] = $i+1;
            $data[$i]['w_tmp'] = rand(0,71);
            $data[$i]['r_freq'] = rand(0,100);
            $data[$i]['f_lvl'] = rand(0,52);
            $data[$i]['v_msr'] = rand(0,32);
            $data[$i]['r_current'] = rand(400,427);
            $data[$i]['f_current'] = rand(0,100);
            $data[$i]['speed'] = rand(0,1);
            $data[$i]['eco_pwr'] = 0;
            $data[$i]['rpm'] = 0;
            $data[$i]['horometro'] = 0;
            $data[$i]['modelo'] = 'SG+';
            $data[$i]['latitud'] = rand(-11,-119);
            $data[$i]['longitud'] = rand(-771,-772);
            $data[$i]['alarma'] = 0;
            $data[$i]['evento'] = 0;
            $data[$i]['rfr_con'] = '-';
            $data[$i]['set_point'] = 0;
            $data[$i]['tmp_supply'] = 0;
            $data[$i]['return_air'] = 0;
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
    }

    public function DatosDispositivoPorFecha(){
        $dispositivo = $_POST['listaDivece'];
        $f_inicio = $_POST['f_inicio'].':00';
        $f_fin = $_POST['f_fin'].':00';
        
        if($dispositivo == 0){
            $res = array('msg' => 'Seleccione un dispositivo', 'icono' => 'warning');
        }else if($f_inicio > $f_fin){
            $res = array('msg' => 'La fecha de inicio no puede ser mayor a la fecha final', 'icono' => 'warning');
        }else{
            $cadena = array(
                'fechaF' => $f_fin,
                'fechaI' => $f_inicio,
                'imei' => $dispositivo,
            );
            $dataMadurador = $this->model->DatosGraficaGenset($cadena);
            $resultadoMadurador = json_decode($dataMadurador);
            $resultadoMadurador = $resultadoMadurador->data;
            if($resultadoMadurador == null || $resultadoMadurador == ''){
                $res = array('msg' => 'No se encontraron datos', 'icono' => 'warning');
            }else{
                $res = array('msg' => 'Datos obtenidos correctamente','icono' => 'success', 'data' => $resultadoMadurador);
            }
        }

        echo json_encode($res, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function listaGenset(){
        //pedir a modelo todo los dispositivos de empresa 3 
        $novo =[];
        $data = $this->model->ListaGensetEmpresa($_SESSION['empresa_genset_id']);
        $resultadoMadurador = json_decode($data);
        $resultadoMadurador = $resultadoMadurador->data->genset;
        foreach ($resultadoMadurador as $producto) {
            $por =  ['id' => $producto->config, 'imei' => $producto->imei, 'dispositivo' => $producto->descripcion . ' - ' . $producto->imei];
            array_push($novo,$por);

        }

        //echo json_encode($resultadoMadurador, JSON_UNESCAPED_UNICODE);
        echo json_encode($novo, JSON_UNESCAPED_UNICODE);            
            

    }
    public function datosTablaHoy($param){
        if($param!=""){
            $pros = explode(",",$param);
            $nombre = $pros[0];
            $fechaI =(isset($pros[1])) ? $pros[2] :"0" ;
            $fechaF =(isset($pros[2])) ? $pros[3] :"0" ;
          
            if($fechaI=="0" && $fechaF=="0"){
                $cadena = array(
                    'imei'=>$nombre
                );
            }else{
                if(fechaGrafica($fechaI,$fechaF)=="ok"){
                    $cadena = array(
                        'fechaI'=> validateDate($fechaI),
                        'fechaF'=> validateDate($fechaF),
                        'imei'=>$nombre
                    );
                }else{
                    $cadena = array();
                }
            }
            if(count($cadena)!=0){
                $dataMadurador = $this->model->DatosTablaGenset($cadena);
                $resultadoMadurador = json_decode($dataMadurador);
                $resultadoMadurador = $resultadoMadurador->data;

                // CAMPO = fecha_r
                $horasVistas = [];
                $filteredIndices = [];

                //se utiliza un indice, ya que se necesita saber si ya se ha visto la hora para no repetir datos
                foreach ($resultadoMadurador as $index => $val) {
                    $dateTime = new DateTime($val->fecha_r);
                    $hora = $dateTime->format('Y-m-d H'); 
                    if (!isset($horasVistas[$hora])) {
                        $horasVistas[$hora] = true;
                        $filteredIndices[] = $index;
                    }
                }

                // Filtrar todos los datos en resultadoMadurador
                $filteredData = [];
                foreach ($filteredIndices as $index) {
                    $filteredData[] = $resultadoMadurador[$index];
                }

                // Convertir las fechas si es necesario
                foreach ($filteredData as $val) {
                    $val->fecha_r = convertirFecha2($val->fecha_r);
                }

                $resultadoMadurador = $filteredData;
            }else{
                $resultadoMadurador =fechaGrafica($fechaI,$fechaF);
            }
        }else{
            $resultadoMadurador ="";
        }
        echo json_encode($resultadoMadurador , JSON_UNESCAPED_UNICODE);
    }

    public function datosGraficoHoy($param){
        //echo json_encode($param, JSON_UNESCAPED_UNICODE);
        if($param!=""){
            $pros = explode(",",$param);
            //se debe enviar id de telemetria
            $nombre = $pros[0];
            //$telemetria = $pros[1];

            $fechaI =(isset($pros[1])) ? $pros[2] :"0" ;
            $fechaF =(isset($pros[2])) ? $pros[3] :"0" ;
            // consultar para nombre_contenedor y ultima fecha 
            //$consultaUltima = $this->model->ContenedorData($nombre);
            //$resultadoL = json_decode($consultaUltima);
            //$resultadoL = $resultadoL->data;
            //$ultimaFecha = $resultadoL[0]->ultima_fecha;
            if($fechaI=="0" && $fechaF=="0"){
                $cadena = array(
                    //'device'=>$telemetria,
                    //'ultima'=>gmtFecha($ultimaFecha),
                    //'utc'=>$_SESSION['utc']
                    'imei'=>$nombre
                );
            }else{
                if(fechaGrafica($fechaI,$fechaF)=="ok"){
                    $cadena = array(
                        //'device'=>$telemetria,
                        //'ultima'=>gmtFecha($ultimaFecha),
                        //'fechaI'=>$fechaI.":00",
                        //'fechaF'=>$fechaF.":00"
                        'fechaI'=> validateDate($fechaI),
                        'fechaF'=> validateDate($fechaF),
                        //'utc'=>$_SESSION['utc']
                        'imei'=>$nombre
                        
                    );
                    //validateDate($fechaI, $format = 'Y-m-d H:i:s')
                }else{
                    $cadena = array();
                }
            }
            if(count($cadena)!=0){
                //hacer peticion de data en el servidor 
                $dataMadurador = $this->model->DatosGraficaGenset($cadena);
                $resultadoMadurador = json_decode($dataMadurador);
                $resultadoMadurador = $resultadoMadurador->data;
            }else{
                $resultadoMadurador =fechaGrafica($fechaI,$fechaF);
            }
        }else{
            $resultadoMadurador ="";
        }
        echo json_encode($resultadoMadurador , JSON_UNESCAPED_UNICODE);

    }
    
}

