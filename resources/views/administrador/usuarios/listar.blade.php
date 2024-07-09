<!-- listar.blade.php -->
<h1>Lista de Usuários</h1>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Email</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($usuarios as $usuario)
            <tr>
                <td>{{ $usuario->id }}</td>
                <td>{{ $usuario->nome }}</td>
                <td>{{ $usuario->email }}</td>
                <td>
                    <a href="{{ route('usuarios.editar', ['id' => $usuario->id]) }}">Editar</a>
                    <!-- Adicione aqui o link para deletar se necessário -->
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
