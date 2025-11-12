<?php
class GraphModel extends Query{ 
    public function __construct()
    {
        parent::__construct();
    }
    //ListaDispositivoEmpresa
    
    public function ListaDispositivoEmpresa($id)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, urlapiMysql."/contenedores/ListaDispositivoEmpresa/".$id);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $res = curl_exec($ch);
        curl_close($ch);   
        return $res;
    }
    //ContenedorData
    public function ContenedorData($id)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, urlapiMysql."/contenedores/ContenedorData/".$id);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $res = curl_exec($ch);
        curl_close($ch);   
        return $res;
    }
    //DatosGraficaTabla
    public function DatosGraficaTabla($data)
    {
        $ch = curl_init();
        $data =json_encode($data);
        curl_setopt($ch, CURLOPT_URL, urlapiMongo."/maduradores/DatosGraficaTablaF/");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $res = curl_exec($ch);
        curl_close($ch);   
        return $res;
    }

    public function ListaGensetEmpresa($id)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, urlapiMongo2."/Maersk/datos/empresa/".$id);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $res = curl_exec($ch);
        curl_close($ch);   
        return $res;
    }
    //DatosGraficaGenset
    public function DatosGraficaGenset($data)
    {
        //$ch = curl_init();
        //curl_setopt($ch, CURLOPT_URL, urlapiMongo2."/Maersk/DatosGrafica/".$id);
        //curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        //$res = curl_exec($ch);
        //curl_close($ch);   
        //return $res;

        $ch = curl_init();
        $data =json_encode($data);
        curl_setopt($ch, CURLOPT_URL, urlapiMongo2."/Maersk/DatosGrafica/");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $res = curl_exec($ch);
        curl_close($ch);   
        return $res;
    }

    public function DatosTablaGenset($data){
        $ch = curl_init();
        $data =json_encode($data);
        curl_setopt($ch, CURLOPT_URL, urlapiMongo2."/Maersk/DatosTabla/");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $res = curl_exec($ch);
        curl_close($ch);   
        return $res;
    }



}

?>