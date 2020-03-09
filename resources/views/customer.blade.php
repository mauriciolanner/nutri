@extends('layouts.app')

@section('content')
<!-- Button trigger modal -->


<div class="col-md-12">
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#clienteModal">
        Novo Cliente
    </button>
    <div class="card ">
        <div class="card-header ">
            <h5 class="card-title">Clientes</h5>
        </div>
        <div class="card-sub">
            <table id="clientes" class="table">
                <thead class=" text-primary">
                    <tr>
                        <th>Nome</th>
                        <th>CNPJ</th>
                        <th>Tel.:</th>
                        <th>Responsável</th>
                        <th>E-mail</th>
                        <th>Opções</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($customers as $customer)
                    <tr>
                        <td>{{$customer->name}}</td>
                        <td>{{$customer->cnpj}}</td>
                        <td>{{$customer->phone}}</td>
                        <td>{{$customer->accountable}}</td>
                        <td>{{$customer->email}}</td>
                        <td>
                            <a href="/perfil/{{$customer->id}}"
                                class="btn btn-sm btn-outline-success btn-round btn-icon">
                                <i class="fa fa-eye" style="font-size: 18px;"></i>
                            </a>
                            <button class="btn btn-sm btn-outline-primary btn-round btn-icon"
                                data-target="#editar{{$customer->id}}" data-toggle="modal">
                                <i class="fa fa-pencil-square-o" style="font-size: 18px;"></i>
                            </button>
                            <a href="/deletaclientes/{{$customer->id}}"
                                class="btn btn-sm btn-outline-danger btn-round btn-icon">
                                <i class="fa fa-trash" style="font-size: 18px;">
                                </i>
                            </a>
                        </td>
                    </tr>
                    <!-- edição -->
                    <div class="modal fade" id="editar{{$customer->id}}" tabindex="-1" role="dialog"
                        aria-labelledby="clienteModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <form action="{{ route('editacliente') }}" method="POST">
                                {!! csrf_field() !!}
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="clienteModalLabel">Editar {{$customer->name}}</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label for="recipient-name" class="col-form-label">Nome:</label>
                                            <input type="text" value="{{$customer->name}}" name="name"
                                                class="form-control" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="recipient-name" class="col-form-label">CNPJ:</label>
                                            <input type="text" value="{{$customer->cnpj}}" name="cnpj"
                                                class="form-control" required>
                                            <input type="hidden" value="{{$customer->id}}" name="id" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="recipient-name" class="col-form-label">Telefone:</label>
                                            <input type="text" value="{{$customer->phone}}" name="phone"
                                                class="form-control" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="recipient-name" class="col-form-label">Responsável:</label>
                                            <input type="text" value="{{$customer->accountable}}" name="accountable"
                                                class="form-control" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="recipient-name" class="col-form-label">E-mail:</label>
                                            <input type="text" value="{{$customer->email}}" name="email"
                                                class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-dismiss="modal">Fechar</button>
                                        <button type="submit" class="btn btn-primary">Editar cliente</button>
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
<div class="modal fade" id="clienteModal" tabindex="-1" role="dialog" aria-labelledby="clienteModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="{{ route('novocliente') }}" method="POST">
            {!! csrf_field() !!}
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="clienteModalLabel">Novo Cliente</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Nome:</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">CNPJ:</label>
                        <input type="text" name="cnpj" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Telefone:</label>
                        <input type="text" name="phone" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Responsável:</label>
                        <input type="text" name="accountable" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">E-mail:</label>
                        <input type="text" name="email" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                    <button type="submit" class="btn btn-primary">Criar cliente</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection