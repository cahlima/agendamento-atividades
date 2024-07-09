<!-- adicionar.blade.php -->
<h1>Adicionar Novo Usuário</h1>

<form action="{{ route('usuarios.salvar') }}" method="POST">
    @csrf
    <label for="nome">Nome:</label>
    <input type="text" id="nome" name="nome" required>

    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required>

    <!-- Adicione mais campos conforme necessário -->

    <button type="submit">Salvar</button>
</form>
