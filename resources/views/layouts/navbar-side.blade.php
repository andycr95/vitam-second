<nav class="navbar navbar-dark align-items-start sidebar sidebar-dark accordion bg-gradient-primary p-0">
        <div class="container-fluid d-flex flex-column p-0">
            <a class="navbar-brand d-flex justify-content-center align-items-center sidebar-brand m-0" href="#">
                <div class="sidebar-brand-icon rotate-n-15"></div>
                <div class="sidebar-brand-text mx-3"><span>Vitam venture</span></div>
            </a>
            <ul class="nav navbar-nav text-light" id="accordionSidebar">
                <li class="nav-item" role="presentation">
                    @if (strpos(url()->current(), "home"))
                        <a class="nav-link active" href="{{ route('home') }}">
                            <i class="fas fa-tachometer-alt"></i><span>Dashboard</span>
                        </a>
                    @else
                        <a class="nav-link" href="{{ route('home') }}">
                            <i class="fas fa-tachometer-alt"></i><span>Dashboard</span>
                        </a>
                    @endif
                    @hasanyrole('Administrador')
                    @if (strpos(url()->current(), "employees"))
                        <a class="nav-link active" href="{{ route('employees') }}">
                            <i class="fas fa-people-carry"></i><span>Empleados</span>
                        </a>
                    @else
                        <a class="nav-link" href="{{ route('employees') }}">
                            <i class="fas fa-people-carry"></i><span>Empleados</span>
                        </a>
                    @endif
                    @if (strpos(url()->current(), "branchoffices"))
                        <a class="nav-link active" href="{{ route('branchoffices') }}">
                            <i class="fas fa-briefcase"></i><span>Sucursales</span>
                        </a>
                    @else
                        <a class="nav-link" href="{{ route('branchoffices') }}">
                            <i class="fas fa-briefcase"></i><span>Sucursales</span>
                        </a>
                    @endif
                    @if (strpos(url()->current(), "investors"))
                        <a class="nav-link active" href="{{ route('investors') }}">
                            <i class="far fa-handshake"></i><span>Inversionistas</span>
                        </a>
                    @else
                        <a class="nav-link" href="{{ route('investors') }}">
                            <i class="far fa-handshake"></i><span>Inversionistas</span>
                        </a>
                    @endif
                    @endhasanyrole
                    @hasanyrole('Empleado|Administrador')
                    @if (strpos(url()->current(), "clients"))
                        <a class="nav-link active" href="{{ route('clients') }}">
                            <i class="far fa-handshake"></i><span>Clientes</span>
                        </a>
                    @else
                        <a class="nav-link" href="{{ route('clients') }}">
                            <i class="fas fa-users"></i><span>Clientes</span>
                        </a>
                    @endif
                    @endhasanyrole
                    @hasanyrole('Administrador|Empleado')
                    @if (strpos(url()->current(), "sales"))
                        <a class="nav-link active" href="{{ route('sales') }}">
                            <i class="fas fa-motorcycle"></i><span>Ventas</span>
                        </a>
                    @else
                        <a class="nav-link" href="{{ route('sales') }}">
                            <i class="fas fa-motorcycle"></i><span>Ventas</span>
                        </a>
                    @endif
                    @endhasanyrole
                    @hasanyrole('Empleado|Administrador|Inversionista')
                    @if (strpos(url()->current(), "vehicles"))
                        <a class="nav-link active" href="{{ route('vehicles') }}">
                            <i class="fas fa-motorcycle"></i><span>Vehículos</span>
                        </a>
                    @else
                        <a class="nav-link" href="{{ route('vehicles') }}">
                            <i class="fas fa-motorcycle"></i><span>Vehículos</span>
                        </a>
                    @endif
                    @endhasanyrole
                    @hasanyrole('Empleado|Administrador')
                    @if (strpos(url()->current(), "payments"))
                        <a class="nav-link active" href="{{ route('payments') }}">
                            <i class="fas fa-money-check"></i><span>Recaudos</span>
                        </a>
                    @else
                        <a class="nav-link" href="{{ route('payments') }}">
                            <i class="fas fa-money-check"></i><span>Recaudos</span>
                        </a>
                    @endif
                    @endhasanyrole
                    @hasanyrole('Administrador|Empleado')
                    @if (strpos(url()->current(), "reports"))
                        <a class="nav-link active" href="{{ route('reports') }}">
                            <i class="far fa-chart-bar"></i><span>Reportes</span>
                        </a>
                    @else
                    <a class="nav-link" href="{{ route('reports') }}">
                        <i class="far fa-chart-bar"></i><span>Reportes</span>
                    </a>
                    @endif
                    @if (strpos(url()->current(), "maps"))
                        <a class="nav-link active" href="{{ route('maps') }}">
                            <i class="far fa-chart-bar"></i><span>Mapas</span>
                        </a>
                    @else
                    <a class="nav-link" href="{{ route('maps') }}">
                        <i class="far fa-chart-bar"></i><span>Mapas</span>
                    </a>
                    @endif
                    @endhasanyrole
                </li>
            </ul>
            <hr class="sidebar-divider my-0">
            <div class="text-center d-none d-md-inline"><button class="btn rounded-circle border-0"
                    id="sidebarToggle" type="button"></button></div>
        </div>
    </nav>
