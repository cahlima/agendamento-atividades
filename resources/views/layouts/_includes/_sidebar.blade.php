<!-- resources/views/layouts/_includes/sidebar.blade.php -->
<nav class="sidebar">
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.painel') }}">Início</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('atividades.index') }}">Gerenciar Atividades</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('usuarios.index') }}">Gerenciar Usuários</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.perfil.edit') }}">Meu Perfil</a>
        </li>
    </ul>
</nav>
