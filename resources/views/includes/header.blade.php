<header>
    <div class="d-flex">
        <!-- Navbar principal -->
        <div class="p-2 flex-grow-1">
            <nav class="navbar navbar-expand-sm text-light" data-bs-theme="dark">
                <div class="container-fluid">
                    <!-- Logo -->
                    <a class="navbar-brand" href="{{ route('index') }}">
                        <img src="{{ asset('img/logo-hitss.jpg') }}" alt="Logo">
                    </a>
                    <!-- Botão de colapso para navegação em telas menores -->
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <!-- Itens do menu -->
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('index') }}">Inicio</a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Avaliações
                                </a>
                                <ul class="dropdown-menu w-25">
                                    <li><a class="dropdown-item" href="{{ route('avaliacao.nova') }}">Nova avaliação</a></li>
                                    <li><a class="dropdown-item" href="{{ route('avaliacao.painel') }}">Painel</a></li>
                                </ul>
                            </li>
                            <!-- Itens visíveis apenas para usuários com grupos_id diferente de 4 -->
                            @if (Auth::user()->grupos_id !== 4)
                                <li class="nav-item"><a class="nav-link" href="#">Atendentes</a></li>
                                <li class="nav-item"><a class="nav-link" href="{{ route('questionarios.index') }}">Questionarios</a></li>
                            @endif
                        </ul>
                    </div>
                </div>
            </nav>
        </div>
        <!-- Barra de ícones e dropdown de perfil -->
        <div class="mt-3 d-inline">
            <nav class="navbar sticky-top" data-bs-theme="dark">
                <ul class="list-inline mb-0">
                    <!-- Ícone de notificações -->
                    <li class="list-inline-item">
                        <a href="#">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="var(--secundary-color)" class="bi bi-bell" viewBox="0 0 16 16">
                                <path d="M8 16a2 2 0 0 0 2-2H6a2 2 0 0 0 2 2M8 1.918l-.797.161A4 4 0 0 0 4 6c0 .628-.134 2.197-.459 3.742-.16.767-.376 1.566-.663 2.258h10.244c-.287-.692-.502-1.49-.663-2.258C12.134 8.197 12 6.628 12 6a4 4 0 0 0-3.203-3.92zM14.22 12c.223.447.481.801.78 1H1c.299-.199.557-.553.78-1C2.68 10.2 3 6.88 3 6c0-2.42 1.72-4.44 4.005-4.901a1 1 0 1 1 1.99 0A5 5 0 0 1 13 6c0 .88.32 4.2 1.22 6" />
                            </svg>
                        </a>
                    </li>
                    <!-- Dropdown de perfil -->
                    <li class="list-inline-item dropstart">
                        <a href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="var(--secundary-color)" class="bi bi-person-circle" viewBox="0 0 16 16">
                                <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0" />
                                <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1" />
                            </svg>
                        </a>
                        <ul class="dropdown-menu text-center text-nowrap p-2">
                            <!-- Nome do usuário -->
                            <li>
                                {{ Auth::user()->name }}
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <!-- Itens do dropdown -->
                            <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Perfil</a></li>
                            <li><a class="dropdown-item" href="{{ route('register') }}">Meus Chamados</a></li>
                            <li><a class="dropdown-item" href="#">Notificações</a></li>
                            <li>
                                <!-- Botão de logout -->
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();">
                                    {{ __('Sair') }}
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</header>
