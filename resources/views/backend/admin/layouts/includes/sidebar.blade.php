<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="index.html">Stisla</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="index.html">St</a>
        </div>
        <ul class="sidebar-menu">
            <li class="{{ isActiveroute('admin.backend.dashboard') }}">
                <a class="nav-link" href="{{ route('admin.backend.dashboard') }}">
                    <i class="fa fa-fire"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="menu-header">Main</li>
            @can('products.manage')
                <li class="dropdown {{ isActiveRoute(['product.categories', 'product.brands', 'product.labels', 'product.attributes', 'product.collections', 'products']) }}">
                    <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
                        <i class="fas fa-box"></i>
                        <span>Manage Products</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="{{ isActiveRoute(['products']) }}">
                            <a class="nav-link" href="{{ route('admin.products.index') }}">Products</a>
                        </li>
                        <li class="{{ isActiveRoute(['product.categories']) }}">
                            <a class="nav-link" href="{{ route('admin.product.categories.index') }}">Categories</a>
                        </li>
                        <li class="{{ isActiveRoute(['product.brands']) }}">
                            <a class="nav-link" href="{{ route('admin.product.brands.index') }}">Brands</a>
                        </li>
                        <li class="{{ isActiveRoute(['product.labels']) }}">
                            <a class="nav-link" href="{{ route('admin.product.labels.index') }}">Labels</a>
                        </li>
                        <li class="{{ isActiveRoute(['product.collections']) }}">
                            <a class="nav-link" href="{{ route('admin.product.collections.index') }}">Collections</a>
                        </li>
                        <li class="{{ isActiveRoute(['product.attributes']) }}">
                            <a class="nav-link" href="{{ route('admin.product.attributes.index') }}">Attributes</a>
                        </li>
                    </ul>
                </li>
            @endcan
            @can('sellers.manage')
                <li class="dropdown {{ isActiveRoute(['sellers']) }}">
                    <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
                        <i class="fas fa-user-check"></i>
                        <span>Sellers</span>
                    </a>

                    <ul class="dropdown-menu">
                        <li class="{{ isActiveRoute(['sellers.index']) }}">
                            <a class="nav-link" href="{{ route('admin.sellers.index') }}">Approved Sellers</a>
                        </li>
                    </ul>
                    <ul class="dropdown-menu">
                        <li class="{{ isActiveRoute(['sellers.pending']) }}">
                            <a class="nav-link" href="{{ route('admin.sellers.pending') }}">Pending Sellers</a>
                        </li>
                    </ul>
                    <ul class="dropdown-menu">

                        <li class="{{ isActiveRoute(['sellers.profile']) }}">
                            <a class="nav-link" href="{{ route('admin.sellers.profile', encrypt(auth()->user()->id)) }}">Seller Profile</a>
                        </li>
                    </ul>
                </li>
            @endcan
{{--            @can('sellers.manage')--}}
                <li class="dropdown {{ isActiveRoute(['home-page-setting', 'pages']) }}">
                    <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
                        <i class="fas fa-cogs"></i>
                        <span>Manage Website</span>
                    </a>

                    <ul class="dropdown-menu">
                        <li class="{{ isActiveRoute(['home-page-setting']) }}">
                            <a class="nav-link" href="{{ route('admin.home-page-setting') }}">Home Page Setting</a>
                        </li>
                    </ul>

                    <ul class="dropdown-menu">
                        <li class="{{ isActiveRoute(['admin.pages']) }}">
                            <a class="nav-link" href="{{ route('admin.pages.index') }}">Pages</a>
                        </li>
                    </ul>
                </li>
{{--            @endcan--}}

            <li
                class="dropdown {{ isActiveRoute([
                    'admin.footer-info.index',
                    'admin.footer-socials',
                    'admin.footer-grid-two',
                    'admin.footer-grid-three',
                ]) }}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i
                        class="fas fa-th-large"></i><span>Footer</span></a>
                <ul class="dropdown-menu">
                    <li class="{{ isActiveRoute(['admin.footer-info.index']) }}"><a class="nav-link"
                                                                                href="{{ route('admin.footer-info.index') }}">Footer Info</a></li>

                    <li class="{{ isActiveRoute(['admin.footer-socials']) }}"><a class="nav-link"
                                                                               href="{{ route('admin.footer-socials.index') }}">Footer Socials</a></li>

                    <li class="{{ isActiveRoute(['admin.footer-grid-two']) }}"><a class="nav-link"
                                                                                href="{{ route('admin.footer-grid-two.index') }}">Footer Grid Two</a></li>

                    <li class="{{ isActiveRoute(['admin.footer-grid-three']) }}"><a class="nav-link"
                                                                                  href="{{ route('admin.footer-grid-three.index') }}">Footer Grid Three</a></li>

                </ul>
            </li>


            <li class="menu-header">Settings & More</li>
            @can('roles.manage')
                <li class="dropdown {{ isActiveRoute(['permissions', 'role']) }}">
                    <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
                        <i class="fab fa-critical-role"></i>
                        <span>Role & Permissions</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="{{ isActiveRoute(['roles']) }}">
                            <a class="nav-link" href="{{ route('admin.roles.index') }}">Roles</a>
                        </li>
                        <li class="{{ isActiveRoute(['permissions']) }}">
                            <a class="nav-link" href="{{ route('admin.permissions.index') }}">Permissions</a>
                        </li>
                    </ul>
                </li>
            @endcan
            @can('users.manage')
                <li class="dropdown {{ isActiveRoute(['users']) }}">
                    <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
                        <i class="fas fa-user"></i>
                        <span>Users</span>
                    </a>
                    @can('users.create')
                        <ul class="dropdown-menu">
                            <li class="{{ isActiveRoute(['users.create']) }}">
                                <a class="nav-link" href="{{ route('admin.users.create') }}">Create User</a>
                            </li>
                        </ul>
                    @endcan

                    <ul class="dropdown-menu">
                        <li class="{{ isActiveRoute(['users']) }}">
                            <a class="nav-link" href="{{ route('admin.users.index') }}">All Users</a>
                        </li>
                    </ul>
                </li>
            @endcan
            <li class="{{ isActiveRoute(['admin.settings.index']) }}">
                <a class="nav-link" href="{{ route('admin.settings.index') }}"><i class="fas fa-wrench"></i>
                    <span>Settings</span></a>
            </li>
        </ul>

        {{--        <div class="mt-4 mb-4 p-3 hide-sidebar-mini">--}}
        {{--            <a href="https://getstisla.com/docs" class="btn btn-primary btn-lg btn-block btn-icon-split">--}}
        {{--                <i class="fas fa-rocket"></i> Documentation--}}
        {{--            </a>--}}
        {{--        </div>--}}
    </aside>
</div>
