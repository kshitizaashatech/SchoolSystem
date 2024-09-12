@hasanyrole('Super Admin|District Admin|Municipality Admin')
<li class="nav-item">
    {{-- <hr class="my-4"> --}}
    <!-- label-->
    <div class="row navbar-vertical-label-wrapper mt-3 mb-2">
        <div class="col-auto navbar-vertical-label">{{__('Role Permission Management')}}</div>
        <div class="col ps-0">
            <hr class="mb-0 navbar-vertical-divider">
        </div>
    </div>
    <li class="nav-item">
        <a class="nav-link dropdown-indicator" href="#dashboard10" role="button" data-bs-toggle="collapse" aria-expanded="true"
            aria-controls="dashboard">
            <div class="d-flex align-items-center"><span class="nav-link-icon"><i class="fas fa-users"></i></span><span
                    class="nav-link-text ps-1">{{__('Role Permission')}}
                    </span></div>
        </a>
        <ul class="nav collapse  {{ Request::segment(2) == 'roles' || Request::segment(2) == 'permissions' ? 'show' : '' }}"
            id="dashboard10">
            @can('list_roles')
            <li class="nav-item"><a class="nav-link {{ Request::segment(2) == 'roles' ? 'active' : '' }}"
                    href="{{ route('admin.roles.index') }}">
                    <div class="d-flex align-items-center"><i class="fa fa-angle-double-right"></i>{{__('Roles') }}

                    </div>
                </a>
            </li>
            @endcan
            @can('list_permissions')
            <li class="nav-item"><a class="nav-link {{ Request::segment(2) == 'permissions' ? 'active' : '' }}"
                    href="{{ route('admin.permissions.index') }}">
                    <div class="d-flex align-items-center"><i class="fa fa-angle-double-right"></i>
                        {{ __('Permissions')}}
                    </div>
                </a>
            </li>
            @endcan
        </ul>
    </li>
</li>
@endhasanyrole
