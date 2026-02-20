<?php
class ReportesModel extends Query
{
    public function __construct()
    {
        parent::__construct();
    }

    public function ListaGensetEmpresa($id)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, urlapiMongo2 . "/Maersk/datos/empresa/" . $id);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $res = curl_exec($ch);
        curl_close($ch);
        return $res;
    }

    public function obtenerDatosTabla($data)
    {
        $ch = curl_init();
        $data = json_encode($data);
        curl_setopt($ch, CURLOPT_URL, urlapiMongo2 . "/Maersk/DatosTabla/");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type:application/json']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $res = curl_exec($ch);
        curl_close($ch);
        return $res;
    }
}