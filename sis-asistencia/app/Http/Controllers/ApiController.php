<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;/*Es como hacer un import*/
use App\Employee;
use App\Schedule;
use App\Charge;
use DB;


	class ApiController extends Controller{


		public function apiCargos(Request $request)
		{
			//
			$cargos=Charge::all();
			return response()->json($cargos);
		}

		public function apiEmpleados(Request $request)
		{
			//
			$employees = Employee::where('state','=','1')->get();
			return response()->json($employees);
		}

		public function apiHorarios()
		{
			$schedules = Schedule::where('state',1)
						->orderBy('created_at')
						->get();
			return response()->json($schedules);
		}

		public function apiAsistencias()
		{
			  $attendances = DB::table('attendances as att')
						 ->join('employees as emp','emp.id','=','att.idemployee')
						->select('att.idemployee', DB::raw('SEC_TO_TIME(SUM(TIME_TO_SEC(att.hour_not_worked))) as totalHours'),DB::raw('CONCAT(emp.surname_paternal," ",emp.surname_maternal," ",emp.name) as employee'),'emp.dni')
						->where('att.state','=','1')
						->groupBy('att.idemployee','emp.name','emp.dni','emp.surname_paternal','emp.surname_maternal')
						->get();

				return response()->json($attendances);
		}

		public function apiNumeroEmpleadosPorCargo()
		{
			  $attendances = DB::table('charges as ch')
						 ->join('employees as emp','emp.idcharge','=','ch.id')
						->select('ch.name', DB::raw('count(emp.idcharge) as count'))
						->groupBy('ch.name')
						->get();

				return response()->json($attendances);
		}
	}

 ?>
