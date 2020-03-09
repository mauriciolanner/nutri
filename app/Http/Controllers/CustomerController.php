<?php

namespace App\Http\Controllers;

use App\Customer;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CustomerController extends Controller
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
        $customers = Customer::where('deleted_at', '=', null)->get();
        return view('customer', compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $customer = new Customer;
        $customer->name = $request->name;
        $customer->cnpj = $request->cnpj;
        $customer->phone = $request->phone;
        $customer->accountable = $request->accountable;
        $customer->email = $request->email;

        $customer->save();

        return redirect('clientes')->with('success', 'Cliente criado com sucesso');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $customer = Customer::find($request->id);
        $customer->name = $request->name;
        $customer->cnpj = $request->cnpj;
        $customer->phone = $request->phone;
        $customer->accountable = $request->accountable;
        $customer->email = $request->email;

        $customer->save();

        return redirect('clientes')->with('success', 'Cliente editado com sucesso');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delet($id)
    {
        $now = Carbon::now();
        $customer = Customer::find($id);
        $customer->deleted_at = $now;

        $customer->save();

        return redirect('clientes')->with('success', 'Cliente deletado com sucesso');
    }

    public function destroy($id)
    {
        //
    }
}
