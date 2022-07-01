<?php

namespace App\Http\Controllers;

use App\employee;
use App\User;
use App\branchoffice;
use App\city;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class EmployeeController extends Controller
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
            $employees = employee::where('state', '1')->join('users', function ($join) use ($buscar) {
                $join->on('users.id', '=', 'employees.user_id')
                    ->where('users.name', 'like', '%'.$buscar.'%');
            })->with(['branchoffice.vehicles'])->paginate(10);
        } else {
            $employees = employee::where('state', '1')->with(['branchoffice.vehicles', 'user'])->paginate(10);
        }
        $branchoffices = branchoffice::where('status', '1')->get();
        return view('pages.employees.employees', compact('employees', 'branchoffices'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = new User();
        $user->name = $request->name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->address = $request->address;
        $user->documento = $request->documento;
        $user->phone = $request->phone;
        $user->password = Hash::make($request->password);
        $user->last_name = $request->last_name;
        if ($request->file('photo')) {
            $photo = $request->file('photo')->store('public/avatars');
            $user->photo = str_replace('public/', '', $photo);
        } else {
            $user->photo = "avatars/user.png";
        }
        $user->save();
        $user->assignRole('Empleado');
        $employee = new employee();
        $employee->user_id = $user->id;
        $employee->salary = $request->salary;
        if ($request->branchoffice_id != '#') {
            $employee->branchoffice_id = $request->branchoffice_id;
        }
        $employee->save();
        return redirect()->back()->with('success', 'Empleado guardado');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function show(employee $id)
    {
        $branchoffices = branchoffice::all();
        $cities = city::all();
        $employee = employee::where('id', $id->id)->with(['user', 'branchoffice.vehicles', 'branchoffice.sales'])->get();
        return view('pages.employees.profile', compact('employee', 'cities', 'branchoffices'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function edit(employee $employee)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, employee $employee)
    {
        $user = User::find($request->id);
        $user->name = $request->first_name;
        $user->last_name = $request->last_name;
        if ($request->password != null) {
            $user->password = Hash::make($request->password);
        }
        $user->email = $request->email;
        $user->address = $request->address;
        $user->documento = $request->documento;
        $user->save();
        $employee = employee::find($request->idemployee);
        if ($request->branchoffice_id != '') {
            $employee->branchoffice_id = $request->branch;
        }
        $employee->save();
        return redirect()->back()->with('success', 'Empleado actualizado');
    }

    public function updatePhoto(request $request)
    {
        $user = User::find($request->id);
        $photo = $request->file('photo')->store('public/avatars');
        $user->photo = str_replace('public/', '', $photo);
        $user->save();
        return redirect()->back()->with('success', 'Foto actualizada');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function destroy(request $request)
    {
        $employee = employee::find($request->iddelete);
        $employee->state = '0';
        $employee->save();
        return redirect()->back()->with('success', 'Empleado eliminado');
    }

    public function asign(request $request)
    {
        $employee = employee::find($request->idasign);
        $employee->branchoffice_id = $request->branchoffice_id;
        $employee->save();
        return redirect()->back()->with('success', 'Sucursal asignada');
    }
}
