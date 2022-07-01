<?php

namespace App\Http\Controllers;

use App\vehicle;
use App\investor;
use App\type;
use App\sale;
use App\branchoffice;
use App\payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VehicleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (Auth::user()->employee == null) {
            if ($request->buscar != '') {
                $buscar = $request->buscar;
                $vehicles = vehicle::where('status', '1')->where('placa', 'like', '%'.$buscar.'%')->paginate(10);
            } else {
                $vehicles = vehicle::where('status', '1')->OrderBy('created_at', 'DESC')->paginate(10);
            }
        } else {
            $auth = Auth::user()->employee->branchoffice_id;
            if ($request->buscar != '') {
                $buscar = $request->buscar;
                $vehicles = vehicle::where('status', '1')->where('branchoffice_id',$auth)->where('placa', 'like', '%'.$buscar.'%')->paginate(10);
            } else {
                $vehicles = vehicle::where('status', '1')->where('branchoffice_id',$auth)->OrderBy('created_at', 'DESC')->paginate(10);
            }
        }

        $investors = investor::where('state', '1')->where('id', '!=', '1')->with(['vehicles', 'user'])->get();
        $types = type::all();
        $listVehicles = sale::where('state', '1')->with("vehicle")->get();
        $branchoffices = branchoffice::all();
        return  view('pages.vehicles.vehicles', compact('vehicles', 'investors', 'types', 'listVehicles', 'branchoffices'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getVehicles()
    {
        $vehicles = [];
        $vehicles = vehicle::where('vehicles.state', '1')->where('vehicles.status', '1')->join('branchoffices', 'branchoffices.id', '=', 'vehicles.branchoffice_id')->OrderBy('vehicles.created_at', 'DESC')->select('branchoffices.name', 'vehicles.id', 'vehicles.placa')->get();
        return response()->json($vehicles, 200);
    }

    public function getVehiclesGps()
    {
        $vehicles = [];
        $vehicles = vehicle::where('vehicles.state', '0')->where('vehicles.status', '1')->join('branchoffices', 'branchoffices.id', '=', 'vehicles.branchoffice_id')->OrderBy('vehicles.created_at', 'DESC')->select('branchoffices.name', 'vehicles.id', 'vehicles.placa')->get();
        return response()->json($vehicles, 200);
    }

    public function getVehicle($placa)
    {
        $vehicle = vehicle::where('vehicles.placa',$placa)->with(["sales.client","branchoffice"])->get();
        return response()->json($vehicle, 200);
    }

    public function getsalesVehicles()
    {
        $vehicles = [];
        $vehicles = sale::where('sales.state','1')->join('vehicles', 'vehicles.id', '=', 'sales.vehicle_id')->select('vehicles.id', 'vehicles.placa')->get();
        return response()->json($vehicles, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $vehicle = new vehicle();
        $vehicle->placa = $request->placa;
        $vehicle->model = $request->model;
        $vehicle->color = $request->color;
        $vehicle->chasis = $request->chasis;
        $vehicle->motor = $request->motor;
        $vehicle->fee = $request->fee;
        if ($request->investor_id == null) {
            $vehicle->investor_id = 1;
        } else {
            $vehicle->investor_id = $request->investor_id;
        }
        if ($request->investor_id == null) {
            $vehicle->branchoffice_id = 1;
        } else {
            $vehicle->branchoffice_id = $request->branchoffice_id;
        }
        $vehicle->type_id = $request->type_id;
        $vehicle->amount = $request->amount;
        $vehicle->save();
        return redirect()->back()->with('success','Vehiculo registrado');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\vehicle  $vehicle
     * @return \Illuminate\Http\Response
     */
    public function show(vehicle $id)
    {

        $photos = vehicle::where('id', $id->id)->select('photo1', 'photo2', 'photo3')->get();
        $photo = $this->nullableIf($photos);
        $vehicle = vehicle::where('id',$id->id)->with(['investor', 'type', 'payments', 'branchoffice'])->get();
        $sale = sale::where("vehicle_id", $id->id)->where('state', '1')->with(['vehicle', 'client', 'branchoffice', 'payments'])->get();
        $investors = investor::where('state','1')->where('id','!=',$vehicle[0]->investor_id)->get();
        $branchoffices = branchoffice::where('status','1')->where('id','!=',$vehicle[0]->branchoffice_id)->get();
        $payments = [];
        $allPayments = [];
        if (count($sale) > 0) {
            $okp = payment::where('sale_id',$sale[0]->id)->where('type', 'pago')->orderBy('created_at','DESC')->get();
            $okallp = payment::where('sale_id',$sale[0]->id)->orderBy('created_at','DESC')->get();
            $payments = $okp;
            $allPayments = $okallp;
        }
        return  view('pages.vehicles.profile', compact('vehicle', 'photos', 'photo', 'investors', 'branchoffices', 'payments', 'allPayments'));
    }

    public function nullableIf($photos)
    {
        for($i=0; $i < $photos->count(); $i++) {
            if ($photos[$i]->photo1 == null) {
                return false;
            } else {
                return true;
            }
        }
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\vehicle  $vehicle
     * @return \Illuminate\Http\Response
     */
    public function edit(vehicle $vehicle)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\vehicle  $vehicle
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, vehicle $vehicle)
    {
        $vehicle = vehicle::find($request->id);
        $vehicle->placa = $request->placa;
        $vehicle->model = $request->model;
        $vehicle->color = $request->color;
        $vehicle->chasis = $request->chasis;
        $vehicle->motor = $request->motor;
        $vehicle->amount = $request->amount;
        $vehicle->branchoffice_id = $request->branchoffice;
        $vehicle->investor_id = $request->investor;
        $vehicle->fee = $request->fee;
        $vehicle->save();
        return redirect()->back()->with('success','Vehiculo actualizado');
    }

    public function updatePhoto(request $request)
    {
        $vehicle = vehicle::find($request->id);
        if ($request->photo) {
            $photo = $request->file('photo')->store('public/avatars');
            $vehicle->photo = str_replace('public/' , '' , $photo);
        } else if ($request->photo1) {
            $photo = $request->file('photo1')->store('public/avatars');
            $vehicle->photo1 = str_replace('public/' , '' , $photo);
        } elseif ($request->photo2) {
            $photo = $request->file('photo2')->store('public/avatars');
            $vehicle->photo2 = str_replace('public/' , '' , $photo);
        } elseif ($request->photo3) {
            $photo = $request->file('photo3')->store('public/avatars');
            $vehicle->photo3 = str_replace('public/' , '' , $photo);
        }

        $vehicle->save();
        return redirect()->back()->with('success','Foto actualizada');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\vehicle  $vehicle
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $vehicle = vehicle::find($request->id);
        if ($vehicle->sales == null) {
            $vehicle->delete();
            return redirect()->back()->with('success','Vehiculo eliminado');
        }
        $vehicle->status = "0";
        $vehicle->save();
        return redirect()->back()->with('success','Vehiculo eliminado');
    }
}
