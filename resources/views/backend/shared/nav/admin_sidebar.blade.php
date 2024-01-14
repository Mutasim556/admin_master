<ul class="sidebar-links" id="simple-bar">
    <li class="sidebar-list">
        <a class="sidebar-link sidebar-title link-nav" href="{{ route('admin.index') }}" aria-expanded="false"><i
                data-feather="home"></i><span>{{ __('admin_local.Dashboard') }}</span>
        </a>
    </li>
    @if (hasPermission(['user-index', 'user-create', 'user-update', 'user-delete']))
        <li class="sidebar-list">
            <a class="sidebar-link sidebar-title" href="javascript:void(0)" aria-expanded="false">
                <i data-feather="user-plus"></i>
                <span class="lan-3">{{ __('admin_local.Users') }}</span>
            </a>
            <ul class="sidebar-submenu">
                <li>
                    <a href="{{ route('admin.user.index') }}" class="sidebar-link">
                        <span> {{ __('admin_local.User List') }} </span>
                    </a>
                </li>
            </ul>
        </li>
    @endif
    <li class="sidebar-list">
        <a class="sidebar-link sidebar-title" href="javascript:void(0)"
            aria-expanded="false">
            <i data-feather="package"></i>
            <span class="lan-3">{{ __('Product') }}</span>
        </a>
        <ul class="sidebar-submenu">
            <li >
                <a href="{{ route('admin.product.unit.index') }}" class="sidebar-link">
                    
                    <span > {{ __('admin_local.Units') }} </span>
                </a>
            </li>
            {{-- <li>
                <a href="{{ route('product.brand.index') }}" class="sidebar-link">
                    
                    <span > {{ __('Brand') }} </span>
                </a>
            </li>
            <li>
                <a href="{{ route('product.size.index') }}" class="sidebar-link">
                    
                    <span > {{ __('Size') }} </span>
                </a>
            </li>
            <li>
                <a href="{{ route('product.parent-category.index') }}" class="sidebar-link">
                    
                    <span > {{ __('Parent Category') }} </span>
                </a>
            </li>
            <li>
                <a href="{{ route('product.category.index') }}" class="sidebar-link">
                    
                    <span > {{ __('Category') }} </span>
                </a>
            </li>
            <li>
                <a href="{{ route('product.product.create') }}" class="sidebar-link">
                    
                    <span > {{ __('Add Product') }} </span>
                </a>
            </li> --}}
            <li>
                <a href="index6.html" class="sidebar-link">
                    
                    <span > {{ __('Product List') }} </span>
                </a>
            </li>
            <li>
                <a href="index6.html" class="sidebar-link">
                    
                    <span > {{ __('Add Adjustment') }} </span>
                </a>
            </li>
            <li>
                <a href="index6.html" class="sidebar-link">
                    
                    <span > {{ __('Adjustment List') }} </span>
                </a>
            </li>
            <li>
                <a href="index6.html" class="sidebar-link">
                    
                    <span > {{ __('Stock Count') }} </span>
                </a>
            </li>

            <li>
                <a href="index6.html" class="sidebar-link">
                    
                    <span > {{ __('Add Promotion') }} </span>
                </a>
            </li>
            <li>
                <a href="index6.html" class="sidebar-link">
                    
                    <span > {{ __('Promotion List') }} </span>
                </a>
            </li>
            
        </ul>
    </li>
    @if (hasPermission([
            'role-permission-index',
            'role-permission-create',
            'role-permission-update',
            'role-permission-delete',
        ]))
        <li class="sidebar-list">
            <a class="sidebar-link sidebar-title link-nav" href="{{ route('admin.role.index') }}"
                aria-expanded="false"><i data-feather="unlock"></i><span>
                    {{ __('admin_local.Roles And Permissions') }}</span>
            </a>
        </li>
    @endif
    @if (hasPermission(['language-index', 'language-create', 'language-update', 'language-delete', 'backend-string-index']))
        <li class="sidebar-list">
            <a class="sidebar-link sidebar-title" href="javascript:void(0)" aria-expanded="false">
                <i data-feather="slack"></i>
                <span class="lan-3">{{ __('admin_local.Language') }}</span>
            </a>
            <ul class="sidebar-submenu">
                @if (hasPermission(['language-index', 'language-create', 'language-update', 'language-delete']))
                    <li>
                        <a href="{{ route('admin.language.index') }}" class="sidebar-link">
                            <span> {{ __('admin_local.Language List') }} </span>
                        </a>
                    </li>
                @endif

                @if (hasPermission(['backend-string-index']))
                    <li>
                        <a href="{{ route('admin.backend.language.index') }}" class="sidebar-link">
                            <span> {{ __('admin_local.Backed Language') }} </span>
                        </a>
                    </li>
                @endif
            </ul>
        </li>
    @endif
    @if (hasPermission(['maintenance-mode-index']))
    <li class="sidebar-list">
        <a class="sidebar-link sidebar-title" href="javascript:void(0)" aria-expanded="false">
            <i data-feather="settings"></i>
            <span class="lan-3">{{ __('admin_local.Settings') }}</span>
        </a>
        <ul class="sidebar-submenu">
            @if (hasPermission(['maintenance-mode-index']))
            <li>
                <a href="{{ route('admin.settings.server.maintenanceMode') }}" class="sidebar-link">
                    <span> {{ __('admin_local.Maintenance Mode') }} </span>
                </a>
            </li>
            @endif
        </ul>
    </li>
    @endif
</ul>
