@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header text-center">{{ __('Listagem  Atividades') }}</div>
                <!-- @dump(auth()->user()->tipo_id)
                @php
                    $id = auth()->user()->tipo_id;
                    echo $id;
                @endphp -->
                <div class="card-body">
                    <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Professor</th>
                                    <th>Atividade</th>
                                    <th>Data</th>
                                    <th>Hora</th>

                                    <th>Opções</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach($atividades as $atividades)
                                <tr>

                                    <td>{{$atividades->id_atividades}}</td>
                                    <td>{{$atividades->nome }} {{$atividades->sobrenome }}</td>
                                    <td>{{$atividades->materia}}</td>
                                    <td>{{$atividades->data}}</td>
                                    <td>{{$atividades->hora}}</td>
                                    <td>

                                    @can('vermenu',App\Models\Atividades::class)
                                        <a href="{{route('matricula.confirmar',$atividades->id_atividades)}}"class="btn btn-primary">Visualizar Alunos</a>
                                    @endcan
                                    @can('viewbtnMatricular',App\Models\Atividades::class)
                                        <a href="{{route('matricula.matricular',$atividades->id_atividades)}}"class="btn btn-success">Matricular</a>
                                    @endcan
                                    @can('update',App\Models\Atividades::class)
                                        <a href="{{route('atividades.editar',$atividades->id_atividades)}}"class="btn btn-warning">Editar</a>
                                    @endcan
                                    @can('delete',App\Models\Atividades::class)
                                        <a href="javascript: if(confirm('Realmente deseja deletar?')) { window.location.href = '{{ route ('atividades.deletar',$atividades->id_atividades)}}'}"class="btn btn-danger">Excluir</a>
                                        @endcan




                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @can('update',App\Models\Atividades::class)
                        <a href="{{route('atividades.adicionar')}}" class="btn btn-primary pull-left">Adicionar</a>
                        @endcan
                </div>

                @if(Session::has('flash_message'))
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12">
                                <div  class="alert {{Session::get('flash_message')['class']}} text-center">
                                {{Session::get('flash_message')['msg']}}
                                </div>
                            </div>
                        </div>
                    </div>
                @endif


            </div>
        </div>
    </div>
</div>
@endsection
