<?php

namespace App\Http\Controllers;

use App\payment;
use App\sale;
use App\client;
use App\vehicle;
use App\employee;
use App\branchoffice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade as PDF;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->buscar != '') {
            $buscar = $request->buscar;
            $payments = payment::join('vehicles', function($join) use ($buscar){
               $join->on('vehicles.id', '=', 'payments.vehicle_id')
               ->where('vehicles.placa', 'like', '%'.$buscar.'%');
            })->select('vehicles.*', 'payments.*','vehicles.amount as vehicles_amount')->OrderBy('payments.created_at', 'DESC')->paginate(10);
        } else {
            $payments = payment::OrderBy('created_at', 'DESC')->paginate(10);
        }

        $sales = sale::where('state','1')->get();
        return  view('pages.payments.payments', compact('payments', 'sales'));
    }

    public function storeTicket(Request $request)
    {
        DB::statement('SET lc_time_names = "es_CO"');
        $payment = payment::find($request->id);
        $day = $payment->created_at->toDateString().' 00:00:00';
        $lday = $payment->created_at->toDateString().' 23:59:59';
        $sale = sale::find($payment->sale_id);
        $client = client::find($sale->client_id);
        $vehicle = vehicle::find($payment->vehicle_id);
        $branch = branchoffice::find($sale->branchoffice_id);
        $date = strftime("%d de %B del %Y - %I:%M %p", strtotime($payment->created_at));
        $name = "Tiquete-$vehicle->placa-$payment->id";
        $paymentsTotal = DB::select('select sales.id as sale_id, payments.amount,  payments.counter, payments.type from sales join payments on payments.sale_id=sales.id where sales.id=? and payments.type="pago" order by payments.id asc;', [$payment->sale_id, $day, $lday]);
        $payments = DB::select('select sales.id as sale_id, payments.amount,  payments.counter, payments.type from sales join payments on payments.sale_id=sales.id where sales.id=? and payments.type="pago" and payments.created_at BETWEEN ? AND ? order by payments.id asc;', [$payment->sale_id, $day, $lday]);
        $credit_total= 0;
        $subtotal= 0;
        $countX = 0;
        $l_credit = [];
        $credit = DB::select('select sales.id as sale_id, payments.amount,  payments.counter, payments.type from sales join payments on payments.sale_id=sales.id where sales.id=? and payments.type="abono" and payments.created_at BETWEEN ? AND ? order by payments.id asc;', [$payment->sale_id, $day, $lday]);
        for ($i=0; $i < count($payments); $i++) { 
            for ($j=0; $j < count($credit); $j++) { 
                if ($payments[$i]->counter == $credit[$j]->counter) {
                    array_splice($credit, $j, 1);
                }
            }
        }
        for ($i=0; $i < count($credit); $i++) { 
            for ($j=0; $j < count($payments); $j++) { 
                if ($payments[$j]->counter != $credit[$i]->counter) {
                    if ($payments[$j]->type != 'pago') {
                        array_push($payments, $credit[$i]);
                    }
                }
            }
        }
        $l_py = DB::select('select sale_id, amount,  counter, type from payments where sale_id= ? and created_at BETWEEN ? AND ? order by created_at desc limit 1;', [$payment->sale_id, $day, $lday]);
        if (count($l_py) > 0) {
            if ($l_py[0]->type == 'abono') {
                for ($j=0; $j < count($payments); $j++) { 
                    if ($payments[$j]->type == 'abono') {
                        $countX++;
                    }
                }
                if ($countX == 0) {
                    array_push($payments, $l_py[0]);
                } else if($countX > 0) {
                    for ($j=0; $j < count($payments); $j++) { 
                        if ($payments[$j]->counter != $l_py[0]->counter) {
                            if ($payments[$j]->type == 'abono') {
                                array_push($payments, $l_py[0]);
                            }
                        }
                    }
                }
            }
        }
        for ($i=0; $i < count($payments); $i++) { 
            $subtotal += $payments[$i]->amount;
        }
        $f_py = DB::select('select sale_id, amount,  counter, type from payments where type="pago" and sale_id= ? and created_at BETWEEN ? AND ? order by created_at asc limit 1;', [$payment->sale_id, $day, $lday]);
        if (count($f_py) > 0) {
            $f_py[0]->l_counter = ($f_py[0]->counter + 1);
            $a_py = DB::select('select * from payments where type="abono" and sale_id= ? and counter= ? and created_at < ?;', [$payment->sale_id, $f_py[0]->l_counter, $day]);
            if (count($a_py) > 0) {
                for ($i=0; $i < count($a_py); $i++) { 
                    array_push($l_credit, $a_py[$i]);
                    $credit_total += $a_py[$i]->amount;
                }
            }
        }
        $total = $subtotal - $credit_total;
        $t = "$ ".number_format($total);
        $pdf = PDF::loadView('pdf.ticket', compact('payments', 'date', 'vehicle', 'client', 'branch', 't', 'l_credit', 'payment', 'credit_total', 'subtotal', 'paymentsTotal', 'sale'))->setPaper(array(0,0,300,500))->setWarnings(false);
        return $pdf->download($name.'.pdf');
    }

    public function storeTest()
    {
        DB::statement('SET lc_time_names = "es_CO"');
        $day = '2020-07-17 00:00:00';
        $lday = '2020-07-17 23:59:59';
        $payment = payment::find(4417);
        $sale = sale::find($payment->sale_id);
        $client = client::find($sale->client_id);
        $vehicle = vehicle::find($payment->vehicle_id);
        $branch = branchoffice::find($sale->branchoffice_id);
        $date = strftime("%d de %B del %Y - %I:%M %p", strtotime($payment->created_at));
        $name = "Tiquete-$vehicle->placa-$payment->id";
        $payments = DB::select('select sales.id as sale_id, payments.amount,  payments.counter, payments.type from sales join payments on payments.sale_id=sales.id where sales.id=? and payments.type="pago" and payments.created_at BETWEEN ? AND ? order by payments.id asc;', [$payment->sale_id, $day, $lday]);
        $credit_total= 0;
        $subtotal= 0;
        $l_credit = [];
        $credit = DB::select('select sales.id as sale_id, payments.amount,  payments.counter, payments.type from sales join payments on payments.sale_id=sales.id where sales.id=? and payments.type="abono" and payments.created_at BETWEEN ? AND ? order by payments.id asc;', [$payment->sale_id, $day, $lday]);
        for ($i=0; $i < count($payments); $i++) { 
            for ($j=0; $j < count($credit); $j++) { 
                if ($payments[$i]->counter == $credit[$j]->counter) {
                    array_splice($credit, $j, 1);
                }
            }
        }
        for ($i=0; $i < count($credit); $i++) { 
            array_push($payments, $credit[$i]);
        }
        $l_py = DB::select('select sale_id, amount,  counter, type from payments where sale_id= ? and created_at BETWEEN ? AND ? order by created_at desc limit 1;', [$payment->sale_id, $day, $lday]);
        if (count($l_py) > 0) {
            if ($l_py[0]->type == 'abono') {
                array_push($payments, $l_py[0]);
            }
        }
        for ($i=0; $i < count($payments); $i++) { 
            $subtotal += $payments[$i]->amount;
        }
        $f_py = DB::select('select sale_id, amount,  counter, type from payments where type="pago" and sale_id= ? and created_at BETWEEN ? AND ? order by created_at asc limit 1;', [$payment->sale_id, $day, $lday]);
        if (count($f_py) > 0) {
            $f_py[0]->l_counter = ($f_py[0]->counter + 1);
            $a_py = DB::select('select * from payments where type="abono" and sale_id= ? and counter= ? and created_at < ?;', [$payment->sale_id, $f_py[0]->l_counter, $day]);
            if (count($a_py) > 0) {
                for ($i=0; $i < count($a_py); $i++) { 
                    array_push($l_credit, $a_py[$i]);
                    $credit_total += $a_py[$i]->amount;
                }
            }
        }
        $total = $subtotal - $credit_total;
        $t = "$ ".number_format($total);
        return view('pdf.ticket_test', compact('payments', 'date', 'vehicle', 'client', 'branch', 't', 'l_credit', 'payment', 'credit_total', 'subtotal'));
    }


    public function storeTicketTest(Request $request)
    {
        DB::statement('SET lc_time_names = "es_CO"');
        $payment = payment::find($request->id);
        $day = $payment->created_at->toDateString().' 00:00:00';
        $lday = $payment->created_at->toDateString().' 23:59:59';
        $sale = sale::find($payment->sale_id);
        $client = client::find($sale->client_id);
        $vehicle = vehicle::find($payment->vehicle_id);
        $branch = branchoffice::find($sale->branchoffice_id);
        $date = strftime("%d de %B del %Y - %I:%M %p", strtotime($payment->created_at));
        $name = "Tiquete-$vehicle->placa-$payment->id";
        $paymentsTotal = DB::select('select sales.id as sale_id, payments.amount,  payments.counter, payments.type from sales join payments on payments.sale_id=sales.id where sales.id=? and payments.type="pago" order by payments.id asc;', [$payment->sale_id, $day, $lday]);
        $payments = DB::select('select sales.id as sale_id, payments.amount,  payments.counter, payments.type from sales join payments on payments.sale_id=sales.id where sales.id=? and payments.type="pago" and payments.created_at BETWEEN ? AND ? order by payments.id asc;', [$payment->sale_id, $day, $lday]);
        $credit_total= 0;
        $subtotal= 0;
        $countX = 0;
        $l_credit = [];
        $credit = DB::select('select sales.id as sale_id, payments.amount,  payments.counter, payments.type from sales join payments on payments.sale_id=sales.id where sales.id=? and payments.type="abono" and payments.created_at BETWEEN ? AND ? order by payments.id asc;', [$payment->sale_id, $day, $lday]);
        for ($i=0; $i < count($payments); $i++) { 
            for ($j=0; $j < count($credit); $j++) { 
                if ($payments[$i]->counter == $credit[$j]->counter) {
                    array_splice($credit, $j, 1);
                }
            }
        }
        for ($i=0; $i < count($credit); $i++) { 
            for ($j=0; $j < count($payments); $j++) { 
                if ($payments[$j]->counter != $credit[$i]->counter) {
                    if ($payments[$j]->type != 'pago') {
                        array_push($payments, $credit[$i]);
                    }
                }
            }
        }
        $l_py = DB::select('select sale_id, amount,  counter, type from payments where sale_id= ? and created_at BETWEEN ? AND ? order by created_at desc limit 1;', [$payment->sale_id, $day, $lday]);
        if (count($l_py) > 0) {
            if ($l_py[0]->type == 'abono') {
                for ($j=0; $j < count($payments); $j++) { 
                    if ($payments[$j]->type == 'abono') {
                        $countX++;
                    }
                }
                if ($countX == 0) {
                    array_push($payments, $l_py[0]);
                } else if($countX > 0) {
                    for ($j=0; $j < count($payments); $j++) { 
                        if ($payments[$j]->counter != $l_py[0]->counter) {
                            if ($payments[$j]->type == 'abono') {
                                array_push($payments, $l_py[0]);
                            }
                        }
                    }
                }
            }
        }
        for ($i=0; $i < count($payments); $i++) { 
            $subtotal += $payments[$i]->amount;
        }
        $f_py = DB::select('select sale_id, amount,  counter, type from payments where type="pago" and sale_id= ? and created_at BETWEEN ? AND ? order by created_at asc limit 1;', [$payment->sale_id, $day, $lday]);
        if (count($f_py) > 0) {
            $f_py[0]->l_counter = ($f_py[0]->counter + 1);
            $a_py = DB::select('select * from payments where type="abono" and sale_id= ? and counter= ? and created_at < ?;', [$payment->sale_id, $f_py[0]->l_counter, $day]);
            if (count($a_py) > 0) {
                for ($i=0; $i < count($a_py); $i++) { 
                    array_push($l_credit, $a_py[$i]);
                    $credit_total += $a_py[$i]->amount;
                }
            }
        }
        $total = $subtotal - $credit_total;
        $t = "$ ".number_format($total);
        //$pdf = PDF::loadView('pdf.ticket', compact('payments', 'date', 'vehicle', 'client', 'branch', 't', 'l_credit', 'payment', 'credit_total', 'subtotal'))->setPaper(array(0,0,300,500))->setWarnings(false);
        return $payment->sale->payments;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index_late()
    {
        define('SECONDS_PER_DAY', 86400);
        $payments = array();
        $days_ago = date('Y-m-d', time() - 3 * SECONDS_PER_DAY);
        $clients = client::where('state','1')->get();
        for ($i=0; $i < $clients->count(); $i++) {
            $pago = payment::where('sales.state','1')->where('payments.type','pago')->where('clients.id',$clients[$i]->id)->where('payments.created_at', '<',$days_ago)
            ->join('sales', 'sales.id','payments.sale_id')->join('vehicles', 'vehicles.id','payments.vehicle_id')
            ->join('clients', 'clients.id','sales.client_id')->orderBy('payments.created_at', 'desc')->select('payments.created_at', 'payments.id as payment','vehicles.id as vehicle', 'clients.id as client')->limit(1)->get();
            if (!empty($pago)) {
                foreach ($pago as $pago) {
                    $p = payment::find($pago['payment']);
                    array_push($payments, $p);
                }
            }
        }

        return  view('pages.payments.late-payments', compact('payments'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        DB::statement('SET lc_time_names = "es_CO"');
        $sale = sale::where('vehicle_id', $request->vehicle_id)->orderBy('id','DESC')->limit(1)->get();
        for ($i=0; $i < $sale->count(); $i++) {
            $pays = payment::where('sale_id', $sale[0]->id)->count();
        }
        $payment = new payment();
        $payment->user_id = Auth::user()->id;
        if (!$request->amount) {
            for ($i=0; $i < $sale->count(); $i++) {
                $payment->amount = $sale[0]->fee;
            }
        }else {
            $payment->amount = $request->amount;
        }
        for ($i=0; $i < $sale->count(); $i++) {
            $payment->sale_id = $sale[0]->id;
        }
        if ($pays == 0) {
            for ($i=0; $i < $sale->count(); $i++) {
                $payment->counter = $sale[0]->amount - 1;
                $payment->type = $request->type;
                $payment->vehicle_id = $request->vehicle_id;
                $payment->save();
            }
        } else {
            for ($i=0; $i < $sale->count(); $i++) {
                $last_pay = payment::where('sale_id',$sale[0]->id)->latest()->first();
                if ($request->type == 'abono') {
                    if ($last_pay->type == 'abono') {
                        if (($last_pay->amount + $request->amount) == $sale[0]->fee) {
                            $payment->counter = $last_pay->counter - 1;
                            $payment->type = "pago";
                            $payment->amount = $sale[0]->fee;
                            $payment->vehicle_id = $request->vehicle_id;
                            $payment->save();
                        } else {
                            $payment->amount = $last_pay->amount + $request->amount;
                            $payment->counter = $last_pay->counter;
                            $payment->type = "abono";
                            $payment->vehicle_id = $request->vehicle_id;
                            $payment->save();
                        }
                    } else {
                        if ($request->amount > $sale[0]->fee) {
                            $loop = ($request->amount / $sale[0]->fee);
                            $whole = floor($loop);
                            $fraction = $loop - $whole;
                            $ok = 0;
                            for ($i=0; $i < $whole; $i++) { 
                                sleep(1);
                                $this->MakePay($request, $last_pay, $sale[0]->id);
                                $ok += 1;

                            }
                            if ($ok == $whole && $fraction > 0.01) {
                                sleep(1);
                                $last_pay2 = payment::where('sale_id',$sale[0]->id)->latest()->first();
                                $payment->counter = $last_pay2->counter;
                                $payment->amount = ($sale[0]->fee * $fraction);
                                $payment->type = $request->type;
                                $payment->vehicle_id = $request->vehicle_id;
                                $payment->save();
                            }
                        }  else {
                            $payment->counter = $last_pay->counter;
                            $payment->amount = $request->amount;
                            $payment->type = $request->type;
                            $payment->vehicle_id = $request->vehicle_id;
                            $payment->save();
                        }
                        
                    }
                } else {
                    $payment->counter = $last_pay->counter - 1;
                    $payment->vehicle_id = $request->vehicle_id;
                    $payment->save();
                }
            }
        }

        $payments = payment::where('sale_id',$sale[0]->id)->where('type', 'pago')->count();
        for ($i=0; $i < $sale->count(); $i++) {
            if ($payments == $sale[0]->amount) {
                $s = sale::find($sale[0]->id);
                $s->state = '0';
                $s->save();
            }
        }


        return redirect()->back()->with('success', $request->type.' registrado');
    }

    public function MakePay($pay, $last_pay, $sale_id)
    {
        $last_pay = payment::where('sale_id',$sale_id)->latest()->first();
        $payment = new payment();
        $payment->amount = $last_pay->amount;
        $payment->vehicle_id = $pay->vehicle_id;
        $payment->sale_id = $sale_id;
        $payment->counter = $last_pay->counter - 1;
        $payment->created_at = Carbon::now();
        $payment->updated_at = Carbon::now();
        $payment->type = 'pago';
        $payment->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function show(payment $payment)
    {
        //
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function edit(payment $payment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, payment $payment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {  
        payment::where('id', $request->id)->delete();
        return redirect()->back()->with('info', 'Pago eliminado');
    }
}

