@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Listagem  Matriculas Aula') }}</div>

                <div class="card-body">
                    <table class="table table-bordered">
                            <thead>
                                <tr class="text-center">
                                    <th>ID</th>
                                    <th>Matéria</th>
                                    <th>Aluno</th>
                                    <th>Status</th>

                                    <!-- @can('viewbtnConfirmAgend',App\Models\Matricula::class)
                                    <th>Opções</th>
                                    @endcan -->

                                </tr>
                            </thead>
                            <tbody>
                                @foreach($matriculas as $matricula)


                                <tr class="text-center">

                                    <td>{{$matricula->id_matricula}}</td>
                                    <td>{{$matricula->materia}}</td>
                                    <td>{{$matricula->nome}}</td>
                                    <td>{{($matricula->status == 1 ? 'Aguardando Aprovação' : '')}}
                                        {{($matricula->status == 2 ? 'Aprovado' : '')}}
                                        {{($matricula->status == 3 ? 'Cancelado Professor' : '')}}
                                        {{($matricula->status == 4 ? 'Cancelado Aluno' : '')}}
                                    </td>
                                    <!--
                                    @can('viewbtnConfirmAgend',App\Models\Matricula::class)
                                    @if($matricula->status != 4)
                                    <td>
                                        <a href="{{route('matricula.editar',$matricula->id_matricula)}}"class="btn btn-success">Confirmar Matriculamento</a>
                                        <a href="javascript: if(confirm('Realmente deseja deletar?')) { window.location.href = '{{ route ('matricula.deletar',$matricula->id_matricula)}}'}"class="btn btn-danger">Cancelar Matriculamento</a>
                                    </td>
                                    @endif
                                    @endcan  -->
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <!--
                        <a href="{{route('matricula.adicionar')}}" class="btn btn-primary pull-left">Adicionar</a> -->
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
