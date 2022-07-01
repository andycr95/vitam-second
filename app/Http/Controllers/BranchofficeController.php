<?php

namespace App\Http\Controllers;

use App\branchoffice;
use App\city;
use App\employee;
use Illuminate\Http\Request;

class BranchofficeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(request $request)
    {
        if ($request->buscar != '') {
            $buscar = $request->buscar;
            $branchoffices = branchoffice::where('name', 'like', '%'.$buscar.'%')->where('status', '1')->paginate(10);

        } else {
            $branchoffices = branchoffice::where('status', '1')->OrderBy('created_at', 'DESC')->paginate(10);
        }

        $city = city::all();
        $employees = employee::where('state', '1')->where('branchoffice_id', null)->doesntHave('branch')->get();
        return view('pages.branchoffice.branchOffice', compact('branchoffices', 'city', 'employees'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getBranchs()
    {
        $branchoffices = branchoffice::where('status', '1')->get();
        return response()->json($branchoffices, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $employee = employee::find($request->employee_id);
        $branchoffice = branchoffice::create($request->all());
        $employee->branchoffice_id = $branchoffice->id;
        $employee->save();

        return redirect()->back()->with('success','Nueva sucursal creada');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\branchoffice  $branchoffice
     * @return \Illuminate\Http\Response
     */
    public function show(branchoffice $id)
    {
        $branchoffice = branchoffice::where("id", $id->id)->with(['vehicles','sales', 'city', 'employee', 'employees'])->get();
        $cities = city::all();
        $employees = employee::where('state', '1')->doesntHave('branch')->get();
        return view('pages.branchoffice.profile', compact('branchoffice', 'cities', 'employees'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\branchoffice  $branchoffice
     * @return \Illuminate\Http\Response
     */
    public function edit(branchoffice $branchoffice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\branchoffice  $branchoffice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $branchoffice = branchoffice::find($request->id);
        $branchoffice->name = $request->first_name;
        $branchoffice->employee_id = $request->encargado;
        $branchoffice->address = $request->address;
        $branchoffice->city_id = $request->city;
        $branchoffice->save();
        $encargado = employee::find($request->encargado);
        $encargado->branchoffice_id = $branchoffice->id;
        $encargado->save();
        if ($request->change) {
            $employee = employee::find($request->last_e);
            $employee->branchoffice_id = null;
            $employee->save();
        }
        return redirect()->back()->with('success','Sucursal actualizado');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\branchoffice  $branchoffice
     * @return \Illuminate\Http\Response
     */
    public function destroy(request $request)
    {
        $branchoffice = branchoffice::find($request->id);
        $branchoffice->status = '0';
        $employee = employee::find($branchoffice->employee_id);
        $employee->branchoffice_id = null;
        $branchoffice->employee_id = null;
        $branchoffice->save();
        $employee->save();
        return redirect()->back()->with('success','Sucursal eliminado');
    }
}
