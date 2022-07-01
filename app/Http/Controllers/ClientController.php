<?php

namespace App\Http\Controllers;

use App\client;
use App\vehicle;
use App\branchoffice;
use App\sale;
use App\typeSale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 

class ClientController extends Controller
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
                $clients = client::where('name', 'like', '%'.$buscar.'%')->where('state', '1')->with('sales.vehicle')->paginate(10);
            } else {
                $clients = client::where('state', '1')->with('sales.vehicle')->paginate(10);
            }
            $branchoffices = branchoffice::all();
            return view('pages.clients.clients', compact('clients'));
        } else {
            $auth = Auth::user()->employee->branchoffice_id;
            if ($request->buscar != '') {
                $buscar = $request->buscar;
                $clients = client::where('name', 'like', '%'.$buscar.'%')->where('branchoffice_id',$auth)->where('state', '1')->with('sales.vehicle')->paginate(10);
            } else {
                $clients = client::where('state', '1')->where('branchoffice_id',$auth)->with('sales.vehicle')->paginate(10);
            }
            $branchoffices = branchoffice::all();
            return view('pages.clients.clients', compact('clients','branchoffices'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getClients()
    {
        $clients = client::where('state', '1')->get();
        return response()->json($clients, 200);
    }

    public function getClient($id)
    {
        $client = client::find($id);
        return response()->json($client, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $client = new client();
        $client->name = $request->name;
        $client->last_name = $request->last_name;
        $client->documento = $request->documento;
        $client->email = $request->email;
        $client->address = $request->address;
        $client->phone = $request->phone;
        $client->celphone = $request->celphone;
        $client->branchoffice_id = $request->branchoffice;
        if ($request->file('photo')) {
            $photo = $request->file('photo')->store('public/avatars');
            $client->photo = str_replace('public/' , '' , $photo);
        }
        $client->save();
        return redirect()->back()->with('success','Cliente guardado');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\client  $client
     * @return \Illuminate\Http\Response
     */
    public function show(client $id)
    {
        $client = client::where('id', $id->id)->with(['sales.vehicle.payments'])->get();
        $photos = client::where('id', $id->id)->select('photo1', 'photo2', 'photo3')->get();
        $photo = $this->nullableIf($photos);
        $branchoffices = branchoffice::where('status', '1')->get();
        $vehicles = vehicle::where('state', '1')->where('status', '1')->get();
        $typeSales = typeSale::all();
        return view('pages.clients.profile', compact('client', 'photos', 'photo', 'branchoffices', 'vehicles', 'typeSales'));
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
     * @param  \App\client  $client
     * @return \Illuminate\Http\Response
     */
    public function edit(client $client)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\client  $client
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, client $client)
    {
        $client = client::find($request->id);
        $client->name = $request->first_name;
        $client->last_name = $request->last_name;
        $client->documento = $request->documento;
        $client->phone = $request->phone;
        $client->celphone = $request->celphone;
        $client->email = $request->email;
        $client->address = $request->address;
        $client->branchoffice_id = $request->branchoffice;
        $client->save();
        return redirect()->back()->with('success','Cliente actualizado');
    }

    public function updatePhoto(request $request)
    {
        $client = client::find($request->id);
        if ($request->photo) {
            $photo = $request->file('photo')->store('public/avatars');
            $client->photo = str_replace('public/' , '' , $photo);
        } else if ($request->photo1) {
            $photo = $request->file('photo1')->store('public/avatars');
            $client->photo1 = str_replace('public/' , '' , $photo);
        } elseif ($request->photo2) {
            $photo = $request->file('photo2')->store('public/avatars');
            $client->photo2 = str_replace('public/' , '' , $photo);
        } elseif ($request->photo3) {
            $photo = $request->file('photo3')->store('public/avatars');
            $client->photo3 = str_replace('public/' , '' , $photo);
        }

        $client->save();
        return redirect()->back()->with('success','Foto actualizada');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\client  $client
     * @return \Illuminate\Http\Response
     */
    public function destroy(request $request)
    {
        if ($request->sale) {
            $sales = sale::find($request->sale);
            $vehicle = vehicle::find($request->vehicle);
            $vehicle->state = '1';
            $sales->state = '0';
            $sales->save();
            $vehicle->save();
        }
        $client = client::find($request->id);
        $client->state = '0';
        $client->save();
        return redirect()->back()->with('success','Cliente eliminado');
    }
}
