<?php

namespace App\Http\Controllers;

use App\Address;
use App\Customer;
use App\State;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $addresses = Customer::where('customers.id', $id)
            ->leftJoin('addresses', 'customers.id', '=', 'addresses.customer_id')
            ->leftJoin('states', 'states.id', '=', 'addresses.state_id')
            ->where('addresses.deleted_at', null)
            ->select(
                'customers.name', 'customers.cnpj',
                'customers.id AS id_customer',
                'customers.phone', 'customers.accountable',
                'customers.email', 'customers.addresse_principal',
                'addresses.id', 'addresses.city', 'addresses.address',
                'addresses.customer_id', 'addresses.cep', 'addresses.number',
                'addresses.district', 'addresses.complement', 'states.name AS name_state'
            )
            ->get();

        $states = State::orderBy('id', 'asc')->get();
        $id_customer = $id;
        return view('addresses', compact('addresses', 'states', 'id_customer'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $state_id = State::where('uf', $request->state)->get();

        $address = new Address;

        $address->cep = $request->cep;
        $address->address = $request->address;
        $address->number = $request->number;
        $address->district = $request->district;
        $address->complement = $request->complement;
        $address->city = $request->city;
        $address->state_id = $state_id[0]->id;
        $address->customer_id = $request->customer_id;

        $address->save();

        //verifica de o cliente já tem um endereço principal
        $customer = Customer::where('customers.id', $request->customer_id)->get();

        //vai fazer a verificação se esse foi selecionado como endereço principal
        if (isset($request->principal) || $customer[0]->addresse_principal == null) {
            $customer_edit = Customer::find($request->customer_id);
            $customer_edit->addresse_principal = $address->id;
            $customer_edit->save();
        }

        return redirect('/perfil/' . $request->customer_id)->with('success', 'Endereço criado com sucesso');
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
        $state_id = State::where('uf', $request->state)->get();

        $addresses = Address::find($request->id);

        $addresses->cep = $request->cep;
        $addresses->address = $request->address;
        $addresses->number = $request->number;
        $addresses->district = $request->district;
        $addresses->complement = $request->complement;
        $addresses->city = $request->city;
        $addresses->state_id = $state_id[0]->id;

        $addresses->save();

        return redirect('/perfil/' . $request->customer_id)->with('success', 'Endereço editado com sucesso');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function delet($id)
    {
        //prepara o retono da página
        $cliente = Address::where('id', $id)->select('customer_id')->get();
        $id_cliente = $cliente[0]->customer_id;

        //faz a verificação se não é o endereço principal
        $testa = Customer::where('addresse_principal', $id)->get();

        if (count($testa) > 0) {
            return redirect('/perfil/' . $id_cliente)->with('error', 'Você não pode deletar um endereço principal, selecione outro endereço como principal antes de deletar esse');
        }

        $now = Carbon::now();
        $addresses = Address::find($id);
        $addresses->deleted_at = $now;
        $addresses->save();

        return redirect('/perfil/' . $id_cliente)->with('success', 'Endereço deletado com sucesso');
    }

    public function tornarPrincipal($id, $id_cliente)
    {
        //faz a verificação se não é o endereço principal
        $testa = Customer::where('addresse_principal', $id)->get();

        if (count($testa) > 0) {
            return redirect('/perfil/' . $id_cliente)->with('error', 'Esse já é o endereço principal');
        }

        $customer = Customer::find($id_cliente);
        $customer->addresse_principal = $id;
        $customer->save();

        return redirect('/perfil/' . $id_cliente)->with('success', 'Endereço deletado com sucesso');
    }

    public function destroy($id)
    {
        //
    }
}
