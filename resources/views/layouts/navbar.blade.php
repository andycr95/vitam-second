<nav class="navbar navbar-light navbar-expand bg-white shadow mb-4 topbar static-top">
        <div class="container-fluid">
            <button class="btn btn-link d-md-none rounded-circle mr-3" id="sidebarToggleTop" type="button">
                <i class="fas fa-bars"></i>
            </button>
            <ul class="nav navbar-nav flex-nowrap ml-auto">
                @hasanyrole('Empleado|Administrador|Inversionista')
                <notifications-component></notifications-component>
                <li class="nav-item dropdown no-arrow" role="presentation">
                    <div class="nav-item dropdown no-arrow">
                            <a class="dropdown-toggle nav-link" style="color:black" href="{{ route('user', Auth()->user()->id) }}">
                             {{ Auth()->user()->name }}
                         </a>
                    </div>
                </li>
                <div class="d-none d-sm-block topbar-divider"></div>
                <li class="nav-item dropdown no-arrow" role="presentation">
                    <div class="nav-item dropdown no-arrow">
                            <a class="dropdown-toggle nav-link" href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                                          document.getElementById('logout-form').submit();">
                             {{ __('Logout') }}
                         </a>

                         <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                             @csrf
                         </form>
                    </div>
                </li>
                @endhasanyrole
            </ul>
        </div>
    </nav>
