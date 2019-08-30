<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function report(){
        $urlCargos =  "127.0.0.1:8000/api/cargos";
        $urlEmpleados = "127.0.0.1:8000/api/empleados";
        $urlHorarios = "127.0.0.1:8000/api/horarios";
        $urlAsistencias = "127.0.0.1:8000/api/asistencias";

        $cargos = $this->getApi($urlCargos);
        $empleados = $this->getApi($urlEmpleados);
        $horarios = $this->getApi($urlHorarios);
        $asistencias = $this->getApi($urlAsistencias);





        return response()->json([
            'resultado' => $empleados
        ],200);
    }





    public function getApi($url){
        $client = new \GuzzleHttp\Client();
        $response = $client->request('GET',$url);
        $resultado = $response->getBody();
        $resultadoDecode = json_decode($resultado);

        return $resultadoDecode;
    }

    public function chartAsistencias()
    {

        $urlAsistencias = "127.0.0.1:8000/api/asistencias";
        $asistencias = $this->getApi($urlAsistencias);



        return response()->json($asistencias);
    }

    public function chartCargosEmpleados()
    {

        $urlCargosEmpleados = "127.0.0.1:8000/api/cargosEmpleados";
        $cargosEmpleados = $this->getApi($urlCargosEmpleados);

        return response()->json($cargosEmpleados);
    }
}
