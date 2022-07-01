<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\employee;
use App\branchoffice;
use App\investor;
use App\client;
use App\payment;
use App\vehicle;
use App\User;
use App\sale;
use App\Notifications\PaymentsLates;

class ValidateFormsController extends Controller
{
    public function ValidateEmail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'unique:users'
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return response()->json("Ya existe un usuario con este correo.", 200);
        } else {
            return response()->json(true, 200);
        }
    }

    public function ValidateDocument(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'documento' => 'unique:users'
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return response()->json("Ya existe un usuario con este documento.", 200);
        } else {
            return response()->json(true, 200);
        }
    }

    public function ValidateEmployeeBranchs(Request $request)
    {
        $branchs = employee::where('id', $request->id)->with('branch')->get();
        return response()->json($branchs, 200);
    }

    public function ValidateBranchs(Request $request)
    {
        $branchs = branchoffice::where('id', $request->id)->with('employees', 'vehicles')->get();
        return response()->json($branchs, 200);
    }

    public function ValidateInvestorVehicles(Request $request)
    {
        $investor = investor::where('id', $request->id)->get();
        $vehicles = vehicle::where('investor_id',$request->id)->where('status','1');
        return response()->json($vehicles, 200);
    }

    public function ValidateClientEmail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'unique:clients'
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return response()->json("Ya existe un cliente con este correo.", 200);
        } else {
            return response()->json(true, 200);
        }
    }

    public function ValidateClientDocumento(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'documento' => 'unique:clients'
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return response()->json("Ya existe un cliente con este documento.", 200);
        } else {
            return response()->json(true, 200);
        }
    }

    public function ValidateVehicle(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'placa' => 'unique:vehicles',
            'chasis' => 'unique:vehicles',
            'motor' => 'unique:vehicles'
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return response()->json($errors, 200);
        } else {
            return response()->json(true, 200);
        }
    }

    public function ValidateClientSales(Request $request)
    {
        $client = client::where('clients.id', $request->id)->where('sales.state','1')->join('sales', 'sales.client_id', '=', 'clients.id')->select('sales.id as sale', 'sales.vehicle_id as vehicle')->get();
        return response()->json($client, 200);
    }
 
    public function ValidatePayment(Request $request)
    {
        $sale = sale::where('vehicle_id',$request->id)->where('state', '1')->orderBy('id', 'desc')->limit(1)->get();
        $last_pay = payment::where('payments.sale_id',$sale[0]->id)->join('sales', 'sales.id', 'payments.sale_id')
        ->join('vehicles', 'vehicles.id', 'payments.vehicle_id')
        ->select('payments.amount', 'payments.type','sales.fee', 'vehicles.placa')
        ->latest('payments.created_at')->first();
        return response()->json($last_pay, 200);
    }

    public function getLatePays()
    {
        define('SECONDS_PER_DAY', 86400);
        $payments = array();
        $days_ago = date('Y-m-d', time() - 3 * SECONDS_PER_DAY);
        $clients = client::where('state','1')->get();
        for ($i=0; $i < $clients->count(); $i++) {
            DB::statement('SET lc_time_names = "es_CO"');
            $pago = payment::where('sales.state','1')->where('payments.type','pago')->where('clients.id',$clients[$i]->id)->where('payments.created_at', '<',$days_ago)
            ->join('sales', 'sales.id','payments.sale_id')->join('vehicles', 'vehicles.id','payments.vehicle_id')
            ->join('clients', 'clients.id','sales.client_id')->orderBy('payments.created_at', 'desc')
            ->select('payments.created_at', 'vehicles.placa as placa', 'payments.id as payment','vehicles.id as vehicle', 'clients.id as client')->limit(1)->get();
            if (!empty($pago)) {
                foreach ($pago as $pago) {
                    $p = payment::find($pago['payment']);
                    $client = client::find($pago['client']);
                    $p->client = $client;
                    $p->placa = $pago['placa'];
                    array_push($payments, $p);
                }
            }
        }
        return response()->json($payments, 200);
    }


    public function inArrayField($needle, $needle_field, $haystack, $strict = true) {
        if ($strict) {
            foreach ($haystack as $item)
                if (isset($item->$needle_field) && $item->$needle_field === $needle)
                    return 'true';
        }
        else {
            foreach ($haystack as $item)
                if (isset($item->$needle_field) && $item->$needle_field == $needle)
                    return 'true';
        }
        return 'false';
    }
}
 