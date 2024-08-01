<header class="sticky-top">
    <nav class="navbar navbar-expand-lg text-light" data-bs-theme="dark">
        <div class="container-fluid d-flex">
            <a class="navbar-brand" href="/"><img src="/img/logo-hitss.jpg" alt=""></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <div class="d-flex justify-content-center text-center">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="/">Inicio</a>
                        </li>
                        @if (Auth::user()->group_id === 2 || Auth::user()->group_id === 1)
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    Avaliações
                                </a>
                                <ul class="dropdown-menu w-25">
                                    <li><a class="dropdown-item" href="{{ route('evaluations.create') }}">Nova
                                            avaliação</a></li>
                                    <li><a class="dropdown-item" href="{{ route('evaluations.index') }}">Painel</a></li>
                                </ul>
                            </li>
                        @else
                            <li><a class="dropdown-item" href="{{ route('evaluations.index') }}">Painel</a></li>
                        @endif
                        <li class="nav-item"><a class="nav-link"
                                href="{{ route('procedures.service_itinerary') }}">Procedimentos</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('warnings.index') }}">Avisos</a></li>
                        @if (Auth::user()->group_id === 2 || Auth::user()->group_id === 1)
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    Configurações
                                </a>
                                <ul class="dropdown-menu w-25">
                                    <li><a class="dropdown-item" href="{{ route('users.index') }}">Usuários</a></li>
                                    <li><a class="dropdown-item" href="{{ route('clients.index') }}">Clientes</a></li>
                                    <li><a class="dropdown-item"
                                            href="{{ route('questionnaires.index') }}">Questionários</a></li>
                                    <li><a class="dropdown-item" href="{{ route('warnings.panel') }}">Avisos</a></li>

                                </ul>
                            </li>
                        @endif
                    </ul>
                </div>
                <div class="d-flex justify-content-center ms-auto mt-2 ">
                    <ul class="text-nowrap">
                        <li class="list-inline-item">
                            <a style="cursor: pointer" onclick="window.location.reload()">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                    fill="var(--secundary-color)" class="bi bi-arrow-clockwise" viewBox="0 0 14 14">
                                    <path fill-rule="evenodd"
                                        d="M8 3a5 5 0 1 0 4.546 2.914.5.5 0 0 1 .908-.417A6 6 0 1 1 8 2z" />
                                    <path
                                        d="M8 4.466V.534a.25.25 0 0 1 .41-.192l2.36 1.966c.12.1.12.284 0 .384L8.41 4.658A.25.25 0 0 1 8 4.466" />
                                </svg>
                            </a>
                        </li>
                        <li class="list-inline-item">
                            <a href="{{ route('notifications.index') }}" class="notification-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                    fill="var(--secundary-color)" class="bi bi-bell" viewBox="0 0 16 16">
                                    <path
                                        d="M8 16a2 2 0 0 0 2-2H6a2 2 0 0 0 2 2M8 1.918l-.797.161A4 4 0 0 0 4 6c0 .628-.134 2.197-.459 3.742-.16.767-.376 1.566-.663 2.258h10.244c-.287-.692-.502-1.49-.663-2.258C12.134 8.197 12 6.628 12 6a4 4 0 0 0-3.203-3.92zM14.22 12c.223.447.481.801.78 1H1c.299-.199.557-.553.78-1C2.68 10.2 3 6.88 3 6c0-2.42 1.72-4.44 4.005-4.901a1 1 0 1 1 1.99 0A5 5 0 0 1 13 6c0 .88.32 4.2 1.22 6" />
                                </svg>
                                @if (isset($sumUnread) && $sumUnread > 0)
                                    <span class="notification-bubble"
                                        id="notificationBubble">{{ $sumUnread }}</span>
                                @else
                                    <span></span>
                                @endif
                            </a>
                        </li>
                        <li class="list-inline-item dropstart">
                            <a href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                    fill="var(--secundary-color)" class="bi bi-person-circle" viewBox="0 0 16 16">
                                    <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0" />
                                    <path fill-rule="evenodd"
                                        d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1" />
                                </svg>
                            </a>
                            <ul class="dropdown-menu text-center text-nowrap p-2">
                                <li>
                                    {{ Auth::user()->name }}
                                </li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('users.user') }}">Perfil</a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('notifications.index') }}">Notificações</a>
                                </li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <x-dropdown-link :href="route('logout')"
                                            onclick="event.preventDefault();
                                                        this.closest('form').submit();"
                                            class="text-white" style="text-decoration: none">
                                            {{ __('Sair') }}
                                        </x-dropdown-link>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
</header>
