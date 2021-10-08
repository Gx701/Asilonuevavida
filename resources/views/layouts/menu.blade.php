<li class="side-menus {{ Request::is('*') ? 'active' : '' }}">
    <a class="nav-link" href="/home">
        <i class=" fas fa-building"></i><span>Dashboard</span>
    </a>

    @can('ver-usuario')
    <a class="nav-link" href="/usuarios">
        <i class=" fas fa-users"></i><span>Usuarios</span>
    </a>
    @endcan

    @can('ver-responsable')
    <a class="nav-link" href="/responsables">
        <i class=" fas fa-address-card"></i><span>Responsable de Paciente</span>
    </a>
    @endcan
    
    @can('ver-rol')
    <a class="nav-link" href="/roles">
        <i class=" fas fa-user-lock"></i><span>Roles</span>
    </a>
    @endcan

    @can('ver-empleado')
    <a class="nav-link" href="/empleados">
        <i class=" fas fa-user-nurse"></i><span>Empleados</span>
    </a>
    @endcan

    @can('ver-paciente')
    <a class="nav-link" href="/pacientes">
        <i class=" fas fa-temperature-high"></i><span>Pacientes</span>
    </a>
    @endcan

    @can('ver-habitacion')
    <a class="nav-link" href="/habitaciones">
        <i class="fas fa-bed"></i><span>Habitaciones</span>
    </a>
    @endcan

    @can('ver-ingreso')
    <a class="nav-link" href="/ingresos">
        <i class="far fa-plus-square"></i><span>Ingreso Asilo</span>
    </a>
    @endcan

    @can('ver-cuenta')
    <a class="nav-link" href="/cuentas">
        <i class="fas fa-money-check-alt"></i><span>Cuentas de Pacientes</span>
    </a>
    @endcan

    @can('ver-turno')
    <a class="nav-link" href="/turnos">
        <i class="fas fa-clock"></i><span>Turnos de trabajo</span>
    </a>
    @endcan

    @can('ver-horario')
    <a class="nav-link" href="/horarios">
        <i class="fas fa-chess"></i><span>Horarios de empleados</span>
    </a>
    @endcan

</li>
