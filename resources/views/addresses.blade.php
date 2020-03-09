@extends('layouts.app')

@section('content')
<!-- Button trigger modal -->

<div class="col-md-4">
    <div class="card card-user">
        <div class="image">
            <img src="{{asset('img/damir-bosnjak.jpg')}}" alt="...">
        </div>
        <div class="card-body">
            <div class="author">
                <img class="avatar border-gray" src="{{asset('img/logo-exemple.png')}}" alt="...">
                <h5 class="title" style="color: #fa5d21;">{{$addresses[0]->name}}</h5>
                <p class="description" style="color: #000000; font-weight: 500;">
                    CNPJ {{$addresses[0]->cnpj}}
                </p>
            </div>
            <p class="description text-center" style="color: #000000; font-weight: 500;">
                Tel.: {{$addresses[0]->phone}}<br>
                Resp.: {{$addresses[0]->accountable}}<br>
                E-mail.: {{$addresses[0]->email}}<br>
            </p>
        </div>
        <div class="card-footer">
            <hr>
            <div class="button-container">

            </div>
        </div>
    </div>
</div>

<div class="col-md-8">
    <div class="card card-user">
        <div class="card-header">
            <h5 class="card-title">Endereço principal</h5>
        </div>
        <div class="card-body">
            @foreach ($addresses as $address_principal)
            @if($address_principal->id == $address_principal->addresse_principal)
            <div class="row">
                <div class="col-md-12">
                    <h3>{{$address_principal->address}}, {{$address_principal->number}}</h3>
                </div>
                <div class="col-md-6">
                    Bairro: {{$address_principal->district}}
                </div>
                <div class="col-md-6">
                    Complemento: {{$address_principal->complement}}
                </div>
                <div class="col-md-6">
                    {{$address_principal->city}} - {{$address_principal->name_state}}
                </div>
            </div>
            @endif
            @endforeach
        </div>
    </div>
</div>
</div>

<div class="col-md-12">
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#enderecosModal">
        Novo Endereço
    </button>
    <div class="card ">
        <div class="card-header ">
            <h5 class="card-title">Endereços de {{$addresses[0]->name}}</h5>
        </div>
        <div class="card-sub">
            <table id="clientes" class="table">
                <thead class=" text-primary">
                    <tr>
                        <th>Rua</th>
                        <th>Bairro</th>
                        <th>Cidade/Estado</th>
                        <th>CEP</th>
                        <th>Complemento</th>
                        <th>Tipo</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($addresses as $address)
                    <tr>
                        <td>{{$address->address}}, {{$address->number}}</td>
                        <td>{{$address->district}}</td>
                        <td>{{$address->city}}/{{$address->name_state}}</td>
                        <td>{{$address->cep}}</td>
                        <td>{{$address->complement}}</td>
                        <td>
                            <button class="btn btn-sm btn-outline-success btn-round btn-icon">
                                <i class="fa fa-eye" style="font-size: 18px;"></i>
                            </button>
                            <button class="btn btn-sm btn-outline-primary btn-round btn-icon" data-toggle="modal"
                                data-target="#editar{{$address->id}}">
                                <i class="fa fa-pencil-square-o" style="font-size: 18px;"></i>
                            </button>
                            <a href="/deletaend/{{$address->id}}"
                                class="btn btn-sm btn-outline-danger btn-round btn-icon">
                                <i class="fa fa-trash" style="font-size: 18px;" data-toggle="modal"
                                    data-target="#confirme" data-title="Deseja mesmo deletar?" data-link="#">
                                </i>
                            </a>
                            @if($address->id == $address->addresse_principal)
                            <strong>Principal</strong>
                            @else
                            <a href="/tornaprincipal/{{$address->id}}/{{$addresses[0]->id_customer}}">
                                Tornar principal
                            </a>
                            @endif
                        </td>
                    </tr>
                    <!--modal edição-->
                    <div class="modal fade" id="editar{{$address->id}}" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <form action="/editarendereco" method="POST">
                                {!! csrf_field() !!}
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="enderecosModalLabel">Editar endereço</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label for="recipient-name" class="col-form-label">CEP:</label>
                                            <input type="text" id="cep" value="{{$address->cep}}" name="cep"
                                                class="form-control" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="recipient-name" class="col-form-label">Endereço:</label>
                                            <input type="text" value="{{$address->address}}" name="address" id="address"
                                                class="form-control" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="recipient-name" class="col-form-label">Numero:</label>
                                            <input type="text" name="number" value="{{$address->number}}" id="number"
                                                class="form-control" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="recipient-name" class="col-form-label">Bairro:</label>
                                            <input type="text" name="district" value="{{$address->district}}"
                                                id="district" class="form-control" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="recipient-name" class="col-form-label">Complemento:</label>
                                            <input type="text" name="complement" value="{{$address->complement}}"
                                                id="complement" class="form-control" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="recipient-name" class="col-form-label">Cidade:</label>
                                            <input type="text" name="city" value="{{$address->city}}" id="city"
                                                class="form-control" required>
                                            <input type="hidden" value="{{$id_customer}}" name="customer_id" required>
                                            <input type="hidden" value="{{$address->id}}" name="id" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="recipient-name" class="col-form-label">Estado:</label>
                                            <select name="state" id="state" required>
                                                @foreach ($states as $state)
                                                <option value="{{$state->uf}}">{{$state->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-dismiss="modal">Fechar</button>
                                        <button type="submit" class="btn btn-primary">Editar</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="enderecosModal" tabindex="-1" role="dialog" aria-labelledby="enderecosModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="/novoendereco" method="POST">
            {!! csrf_field() !!}
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="enderecosModalLabel">Novo enderecos</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">CEP:</label>
                        <input type="text" id="cep" name="cep" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Endereço:</label>
                        <input type="text" name="address" id="address" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Numero:</label>
                        <input type="text" name="number" id="number" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Bairro:</label>
                        <input type="text" name="district" id="district" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Complemento:</label>
                        <input type="text" name="complement" id="complement" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Cidade:</label>
                        <input type="text" name="city" id="city" class="form-control" required>
                        <input type="hidden" value="{{$id_customer}}" name="customer_id" required>
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Estado:</label>
                        <select name="state" id="state" required>
                            @foreach ($states as $state)
                            <option value="{{$state->uf}}">{{$state->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <li class="list-group-item" style="height: 58px;">
                        Tornar esse o endereço principal
                        <label class="switch ">
                            <input type="checkbox" name="principal" class="default">
                            <span class="slider round"></span>
                        </label>
                    </li>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                    <button type="submit" class="btn btn-primary">Criar enderecos</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection