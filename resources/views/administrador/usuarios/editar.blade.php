<!-- editar.blade.php -->
<h1>Editar Usuário - {{ $usuario->nome }}</h1>



    <form action="{{ route('usuario.atualizar', ['id' => $usuario->id]) }}" method="POST">
    @csrf
    <!-- Outros campos do formulário -->
    <button type="submit">Atualizar</button>
</form>


    <label for="nome">Nome:</label>
    <input type="text" id="nome" name="nome" value="{{ $usuario->nome }}" required>

    <label for="email">Email:</label>
    <input type="email" id="email" name="email" value="{{ $usuario->email }}" required>

    <!-- Adicione mais campos conforme necessário -->

    <button type="submit">Atualizar</button>
</form>
