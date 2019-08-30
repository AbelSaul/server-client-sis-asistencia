<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Employee;
use App\Charge;
use Flash;
use DB;


class EmployeesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth');
    }
        public function index()
    {
        //
        $employees = Employee::where('state','=','1')->get();
        return view('employees.index',["employees"=>$employees]);
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
       $charges=Charge::pluck('name','id');
       return view('employees.create',compact('charges'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $employee= new Employee;
        $employee->name=$request->name;
        $employee->surname_paternal=$request->surname_paternal;
        $employee->surname_maternal=$request->surname_maternal;
        $employee->state=$request->state;
        $employee->dni=$request->dni;
        $employee->idcharge=(int)$request->idcharge;

      /*  var_dump($employee->idcharge);
        exit;*/
        if ($employee->save()) {
            Flash::success('Empleados registrado exitosamente.');
           return redirect(route('employees.index'));
        }else{
            return view("employees.create");
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       $employeeBD=DB::table('employees')
                    ->where('id','=',$id)
                    ->where('state','=','1')
                    ->get();



        foreach ($employeeBD as $emp) {
                $employee = new Employee();
                $employee->id=$emp->id;
                $employee->name=$emp->name;
                $employee->surname_paternal=$emp->surname_paternal;
                $employee->surname_maternal=$emp->surname_maternal;
                $employee->dni=$emp->dni;
                $employee->state=$emp->state;
                $employee->idcharge=$emp->idcharge;

        }

        if (empty($employee)) {
            Flash::error('Empleado no encontrado');

            return redirect(route('employees.index'));
        }

        return view('employees.show')->with('employee', $employee);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $employee = Employee::find($id);
        if (empty($employee)) {/*una variable se considera vacía si no existe o si su valor es igual a FALSE. empty() */
            Flash::error('Empleado no encontrado');
            return redirect(route('employees.index'));
        }
        $charges=Charge::pluck('name','id');
        return view('employees.edit',['employee'=>$employee],compact('charges'));
        // ->with('charge', $charge);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $employee= Employee::find($id);

        $employee->name=$request->name;
        $employee->surname_paternal=$request->surname_paternal;
        $employee->surname_maternal=$request->surname_maternal;
        $employee->state=$request->state;
        $employee->dni=$request->dni;
        $employee->idcharge=(int)$request->idcharge;

        if ($employee->save()) {
            Flash::success('Empleado editado exitosamente.');
           return redirect(route('employees.index'));
        }else{
            return view("employees.edit");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $employee= Employee::find($id);
        if (empty($employee)) {
            Flash::error('Empleado no encontrado');
            return redirect(route('employees.index'));
        }
        $employee->state="0";
        $employee->update();
        Flash::success('Empleado borrado exitosamente.');
        return redirect(route('employees.index'));
    }

    public function findPeople( Request $request ){
        $numero_documento = $request->numero_documento;

        $url = "https://api.reniec.cloud/dni/".$numero_documento;

        if(isset($url)){
            $people = $this->convert($this->options($url),$type);
        }
        return response()->json($people);
    }
    public function options($url){
        $options = array(
            CURLOPT_HEADER => false,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 20,
            CURLOPT_URL => $url,
            CURLOPT_CUSTOMREQUEST => "GET",
        );
        $handle = curl_init();
        curl_setopt_array($handle, ($options));
        $response = curl_exec($handle);
        $people=json_decode($response,true);
        return $people;
    }

    public function convert($people,$type){

         $numero_documento = $people["dni"];
         $primer_nombre = $people["nombres"];
         $segundo_nombre = $people["apellido_paterno"]." ".$people["apellido_materno"];
         $direccion = "";
         $telefono = "";
         $celular = "";
         $correo = "";

        $people_convert = array('numero_documento'=>$numero_documento, 'primer_nombre'=>$primer_nombre, 'segundo_nombre'=>$segundo_nombre, 'direccion' => $direccion, 'telefono' => $telefono, 'celular' => $celular, 'correo' => $correo);
         return $people_convert;
    }
}
