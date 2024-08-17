@extends('layouts.app')

@section('title', 'Atividades Disponíveis')

@section('content')
<div class="container" id="app">
    <h2>{{ __('Atividades disponíveis') }}</h2>

    @if(Session::has('success'))
        <div class="alert alert-success">
            {{ Session::get('success') }}
        </div>
    @endif

    <div class="mb-3">
        <label for="atividade">{{ __('Escolha uma atividade:') }}</label>
        <select id="atividade" class="form-control" v-model="selectedAtividade" @change="fetchHorarios">
            <option value="">{{ __('Selecione uma atividade') }}</option>
            @foreach($atividades as $atividade)
                <option value="{{ $atividade->id }}">{{ $atividade->atividade }}</option>
            @endforeach
        </select>
    </div>

    <div v-if="selectedAtividade" class="mb-3">
        <label for="dia">{{ __('Escolha um dia:') }}</label>
        <select id="dia" class="form-control" v-model="selectedDia">
            <option value="">{{ __('Selecione um dia') }}</option>
            <option v-for="dia in diasDisponiveis" :key="dia" :value="dia">@{{ dia }}</option>
        </select>
    </div>

    <div v-if="selectedDia">
        <h4>{{ __('Horários disponíveis') }}</h4>
        <ul class="list-group">
            <li v-for="horario in horariosFiltrados" :key="horario.id" class="list-group-item">
                @{{ horario.hora }} - @{{ horario.instrutor }} (@{{ horario.local }})
                <button class="btn btn-primary btn-sm float-end" @click="matricular(horario.id)">
                    {{ __('Matricular') }}
                </button>
            </li>
        </ul>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/vue@2"></script>
<script>
new Vue({
    el: '#app',
    data: {
        selectedAtividade: '',
        selectedDia: '',
        horarios: [],
        diasDisponiveis: []
    },
    computed: {
        horariosFiltrados() {
    return this.horarios.filter(horario => horario.dia === this.selectedDia);
}

    },
    methods: {
        fetchHorarios() {
    if (this.selectedAtividade) {
        fetch(`/atividades/${this.selectedAtividade}/horarios`)
            .then(response => response.json())
            .then(data => {
                console.log('Dados recebidos:', data); // Verifique se os dados estão sendo retornados corretamente
                this.horarios = data;
                this.diasDisponiveis = [...new Set(data.map(horario => horario.dia))];
            })
            .catch(error => {
                console.error('Erro ao buscar horários:', error);
                alert('Ocorreu um erro ao buscar os horários. Por favor, tente novamente.');
            });
    }
}

},
        matricular(horarioId) {
            if (confirm('Deseja se matricular neste horário?')) {
                fetch(`/atividades/matricular/${horarioId}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Matrícula realizada com sucesso!');
                    } else {
                        alert('Erro ao realizar a matrícula: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Erro ao realizar a matrícula:', error);
                    alert('Ocorreu um erro ao realizar a matrícula. Por favor, tente novamente.');
                });
            }
        }
    }
});
</script>
@endsection
