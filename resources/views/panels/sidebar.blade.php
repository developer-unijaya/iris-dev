@php
$configData = Helper::applClasses();
@endphp
<div class="main-menu menu-fixed {{ $configData['theme'] === 'dark' || $configData['theme'] === 'semi-dark' ? 'menu-dark' : 'menu-light' }} menu-accordion menu-shadow" data-scroll-to-active="true">
    <div class="navbar-header mb-2">
        <ul class="nav navbar-nav flex-row">
            <li class="nav-item me-auto">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <span class="brand-logo">
                        <img src="{{ asset('images/iris-images/jata_negara.png') }}" class="brand-image img-circle elevation-3" style="opacity: .8">
                    </span>
                    <h2 class="brand-text text-uppercase">IRIS - SPA</h2>
                </a>
            </li>
            <li class="nav-item nav-toggle">
                <a class="nav-link modern-nav-toggle pe-0" data-toggle="collapse">
                    <i class="d-block d-xl-none text-primary toggle-icon font-medium-4" data-feather="x"></i>
                    <i class="d-none d-xl-block collapse-toggle-icon font-medium-4 text-primary" data-feather="disc" data-ticon="disc"></i>
                </a>
            </li>
        </ul>
    </div>

    <div class="shadow-bottom"></div>

    <div class="main-menu-content mt-2">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">

            <li class="nav-item {{ in_array(request()->route()->getName(), ['home']) ? 'active' : '' }}">
                <a href="{{ route('home') }}" class="d-flex align-items-center">
                    <i data-feather="home"></i>
                    <span class="menu-title text-truncate">{{__('msg.home')}} </span>
                </a>
            </li>

            {{-- FMF MODULE HERE: CLOSED FOR LOGIN MODULE REVIEW  --}}
            {{-- <li class="nav-item">
                <a href="#" class="nav-link">
                    <i data-feather="user"></i>
                    <span class="menu-title text-truncate"> {{__('msg.testForm')}} </span>
                </a>
                <ul class="menu-content">
                    <li class="{{ in_array(request()->route()->getName(), ['testForm.index']) ? 'active' : '' }}">
                        <a href="{{ route('testForm.index')}}" class="d-flex align-items-center">
                            <i data-feather="circle"></i> <span class="menu-title text-truncate"> {{__('msg.form')}} </span>
                        </a>
                    </li>
                    <li class="{{ in_array(request()->route()->getName(), ['testForm.list']) ? 'active' : '' }}">
                        <a href="{{ route('testForm.list')}}" class="d-flex align-items-center">
                            <i data-feather="circle"></i> <span class="menu-title text-truncate"> {{__('msg.list')}} </span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link" >
                    <i class="fa-regular fa-folder"></i>
                    <span class="menu-title text-truncate"> {{__('msg.testFormNoFMF') }}  </span>
                </a>
                <ul class="menu-content">
                    <li class="{{ in_array(request()->route()->getName(), ['testFormNoFMF.createForm','testFormNoFMF.viewForm']) ? 'active' : '' }} ">
                        <a href="{{ route('testFormNoFMF.createForm')}}" class="d-flex align-items-center">
                            <i class="fa-solid fa-file-circle-plus"></i>
                            <span class="menu-title text-truncate"> {{__('msg.customCreate',['item' => __('msg.form')])}} </span>
                        </a>
                    </li>
                    <li class="{{ in_array(request()->route()->getName(), ['testFormNoFMF.listTestForm']) ? 'active' : '' }}">
                        <a href="{{ route('testFormNoFMF.listTestForm')}}" class="d-flex align-items-center">
                            <i class="fa-solid fa-list"></i>
                            <span class="menu-title text-truncate"> {{__('msg.customList',['item' => __('msg.form')])}} </span>
                        </a>
                    </li>
                </ul>
            </li> --}}

            {{-- @hasanyrole('superadmin|admin')
                <li class="nav-item {{ in_array(request()->route()->getName(), ['statistics']) ? 'menu-open' : '' }}">
                    <a href="{{ route('statistics') }}" class="nav-link {{ in_array(request()->route()->getName(), ['statistics']) ? 'active' : '' }}">
                        <i data-feather="pie-chart"></i>
                        <span class="menu-title text-truncate"> {{__('msg.statistics')}} </span>
                    </a>
                </li>
            @endhasanyrole --}}

            {{-- @hasanyrole('superadmin|admin')
                <li class="navigation-header">
                    <span> Pengurusan </span>
                </li>
                <li class="nav-item {{ request()->is('admin/user*') || request()->is('admin/role*') || request()->is('admin/security*') || request()->is('admin/log*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link">
                        <i data-feather="settings"></i>
                        <span class="menu-title text-truncate">Pengurusan Sistem</span>
                    </a>
                    <ul class="menu-content">
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i data-feather="database"></i>
                                <span class="menu-title text-truncate">Pengurusan Data</span>
                            </a>
                            <ul class="menu-content">
                                <li class="">
                                    <a href="#" class="d-flex align-items-center">
                                        <i data-feather="circle"></i>
                                        <span class="menu-title text-truncate">
                                            Pelbagai
                                        </span>
                                    </a>
                                </li>
                                <li class="">
                                    <a href="#" class="d-flex align-items-center">
                                        <i data-feather="circle"></i>
                                        <span class="menu-title text-truncate">
                                            Calon
                                        </span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item {{ request()->is('admin/user*') || request()->is('admin/role*') ? 'menu-open' : '' }}">
                            <a href="#" class="nav-link">
                                <i data-feather="users"></i>
                                <span class="menu-title text-truncate">Pengurusan Pengguna</span>
                            </a>
                            <ul class="menu-content">
                                <li class="{{ in_array(request()->route()->getName(),['admin.internalUser'])? 'active': '' }}">
                                    <a href="{{ route('admin.internalUser') }}" class="d-flex align-items-center">
                                        <i data-feather="circle"></i>
                                        <span class="menu-title text-truncate">
                                            Pengguna
                                        </span>
                                    </a>
                                </li>
                                <li class="{{ in_array(request()->route()->getName(),['role.index'])? 'active': '' }}">
                                    <a href="{{ route('role.index') }}" class="d-flex align-items-center">
                                        <i data-feather="circle"></i>
                                        <span class="menu-title text-truncate">
                                            Role
                                        </span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item {{ request()->is('admin/security*') ? 'menu-open' : '' }}">
                            <a href="#" class="nav-link">
                                <i data-feather="shield"></i>
                                <span class="menu-title text-truncate">Pengurusan Keselamatan</span>
                            </a>
                            <ul class="menu-content">
                                <li class="{{ in_array(request()->route()->getName(), ['admin.security.menu']) ? 'active': '' }}">
                                    <a href="{{ route('admin.security.menu') }}" class="d-flex align-items-center">
                                        <i data-feather="circle"></i>
                                        <span class="menu-title text-truncate">
                                            Selenggara Menu
                                        </span>
                                    </a>
                                </li>
                                <li class="">
                                    <a href="#" class="d-flex align-items-center">
                                        <i data-feather="circle"></i>
                                        <span class="menu-title text-truncate">
                                            Selenggara Capaian
                                        </span>
                                    </a>
                                </li>
                                <li class="">
                                    <a href="#" class="d-flex align-items-center">
                                        <i data-feather="circle"></i>
                                        <span class="menu-title text-truncate">
                                            Selenggara Turutan
                                        </span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item {{ in_array(request()->route()->getName(),['admin.log']) ? 'active' : '' }}">
                            <a href="{{ route('admin.log') }}">
                                <i data-feather="file-text"></i>
                                <span class="menu-title text-truncate">Transaksi Pengguna</span>
                            </a>
                        </li>
                    </ul>
                </li>
            @endhasanyrole --}}

                <?php
                $securityMenu = App\Models\SecurityMenu::where('level', 1)->orderBy('sequence', 'asc')->get();
                $roles = auth()->user()->roles;
                $roles = $roles->pluck('id')->toArray();
                ?>
                @foreach($securityMenu as $menu)
                    <?php
                    $accessLevel1 = $menu->role()->whereIn('id', $roles)->get();
                    ?>
                    @if(count($accessLevel1) > 0)
                    <li class="navigation-header">
                        <span>{{ $menu->name }}</span>
                    </li>
                    <li class="nav_item {{ ($menu->type == 'Web') ? in_array(request()->route()->getName(), [$menu->module->code]) ? 'active' : '' : '#' }}">
                        <a href="{{ ($menu->type == 'Web') ? route($menu->module->code) : '#' }}" class="nav_link">
                            <!-- <i data-feather="circle"></i> -->
                             <span class="menu-title text-truncate">{{ $menu->name }}</span>
                        </a>
                        @if($menu->type == 'Menu')
                        <ul class="menu-content">
                            <?php
                            $level2 = App\Models\SecurityMenu::where('level', 2)->where('menu_link', $menu->id)->orderBy('sequence', 'asc')->get();
                            ?>
                            @foreach($level2 as $menu2)
                            <?php
                            $accessLevel2 = $menu2->role()->whereIn('id', $roles)->get();
                            ?>
                            @if(count($accessLevel2) > 0)
                            <li class="nav-item {{ ($menu2->type == 'Web') ? in_array(request()->route()->getName(), [$menu2->module->code]) ? 'active' : '' : '#' }}">
                                <a href="{{ ($menu2->type == 'Web') ? route($menu2->module->code) : '#' }}" class="nav-link">
                                    <!-- <i data-feather="shield"></i> -->
                                    <span class="menu-title text-truncate">{{ $menu2->name }}</span>
                                </a>
                                @if($menu2->type == 'Menu')
                                <ul class="menu-content">
                                    <?php
                                    $level3 = App\Models\SecurityMenu::where('level', 3)->where('menu_link', $menu2->id)->orderBy('sequence', 'asc')->get();
                                    ?>
                                    @foreach($level3 as $menu3)
                                    <?php
                                    $accessLevel3 = $menu3->role()->whereIn('id', $roles)->get();
                                    ?>
                                    @if(count($accessLevel3) > 0)
                                    <li class="nav-item {{ ($menu3->type == 'Web') ? in_array(request()->route()->getName(), [$menu3->module->code]) ? 'active' : '' : '#' }}">
                                        <a href="{{ ($menu3->type == 'Web') ? route($menu3->module->code) : '#' }}" class="d-flex align-items-center">
                                            <!-- <i data-feather="circle"></i> -->
                                            <span class="menu-title text-truncate">{{ $menu3->name }}</span>
                                        </a>
                                    </li>
                                    @endif
                                    @endforeach
                                </ul>
                                @endif
                            </li>
                            @endif
                            @endforeach
                        </ul>
                        @endif
                    </li>
                    @endif
                @endforeach

            @hasanyrole('superadmin|admin')
            <li class="navigation-header">
                <span> Calon Acronym </span>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <span class="menu-title text-truncate"> Calon Acronym </span>
                </a>
                <ul class="menu-content">
                    <li class="{{ in_array(request()->route()->getName(), ['acronym.index']) ? 'active' : '' }}">
                        <a href="{{ route('acronym.index') }}" class="d-flex align-items-center">
                            <span class="menu-title text-truncate">
                                Calon Acronym
                            </span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="navigation-header">
                <span> Pengurusan Integrasi </span>
            </li>
            <li class="nav-item {{ request()->is('pengurusan_integrasi*') ? 'menu-open' : '' }}">
                <a href="#" class="nav-link">
                    <span class="menu-title text-truncate"> Pengurusan Integrasi </span>
                </a>
                <ul class="menu-content">
                    <li class="{{ in_array(request()->route()->getName(), ['dashboard_integration']) ? 'active' : '' }}">
                        <a href="{{ route('dashboard_integration') }}" class="d-flex align-items-center">
                            <span class="menu-title text-truncate">
                                Pengurusan Integrasi
                            </span>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="navigation-header">
                <span> Tapisan Permohonan </span>
            </li>
            <li class="nav-item {{ request()->is('tapisan_permohonan*') ? 'menu-open' : '' }}">
                <a href="#" class="nav-link">
                    <span class="menu-title text-truncate"> Tapisan Permohonan </span>
                </a>
                <ul class="menu-content">
                    <li class="nav-item {{ request()->is('tapisan_permohonan*') ? 'menu-open' : '' }}">
                        <a href="#" class="d-flex align-items-center">
                            <span class="menu-title text-truncate">
                                Pengurusan Pemerolehan
                            </span>
                        </a>
                        <ul class="menu-content">
                            <li class="{{ in_array(request()->route()->getName(), ['senarai_skim']) ? 'active' : '' }}">
                                <a href="{{ route('senarai_skim') }}" class="d-flex align-items-center">
                                    <span class="menu-title text-truncate">
                                        PGSPA
                                    </span>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </li>
            @endhasanyrole

            {{-- @hasanyrole('superadmin')
                <li class="navigation-header">
                    <span> System Settings </span>
                </li>
                <li class="nav-item {{ request()->is('admin/settings*') || request()->is('admin/log*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link">
                        <i data-feather="settings"></i>
                        <span class="menu-title text-truncate"> {{__('msg.system_management')}} </span>
                    </a>
                    <ul class="menu-content">
                        @if(\Composer\InstalledVersions::isInstalled('developer-unijaya/flow-management-function'))
                        <li class="{{ in_array(request()->route()->getName(), ['module.index']) ? 'active' : '' }}">
                            <a href="{{ route('module.index') }}" class="d-flex align-items-center">
                                <i data-feather="circle"></i> <span class="menu-title text-truncate"> {{ __('msg.module_config') }} </span>
                            </a>
                        </li>
                        @endif
                        <li class="{{ in_array(request()->route()->getName(), ['settings.index']) ? 'active' : '' }}">
                            <a href="{{ route('settings.index') }}" class="d-flex align-items-center">
                                <i data-feather="circle"></i> <span class="menu-title text-truncate"> {{ __('msg.system_config') }} </span>
                            </a>
                        </li>
                        <li class="{{ in_array(request()->route()->getName(), ['admin.log']) ? 'active' : '' }}">
                            <a href="{{ route('admin.log') }}" class="d-flex align-items-center">
                                <i data-feather="circle"></i> <span class="menu-title text-truncate"> Jejak Audit / Log </span>
                            </a>
                        </li>
                    </ul>
                </li>
            @endhasanyrole --}}

            {{-- HELPDESK MODULE HERE  --}}
            @if(\Composer\InstalledVersions::isInstalled('developer-unijaya/quickstart-helpdesk'))
                <li class="navigation-header">
                    <span>Helpdesk</span>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="fa-solid fa-headset"></i>
                        <span class="menu-title text-truncate"> Helpdesk </span>
                    </a>
                    <ul class="menu-content">
                        <li class="{{ in_array(request()->route()->getName(), ['helpdesk.index','helpdesk.viewTicket']) ? 'active' : '' }}" >
                            <a href="{{ route('helpdesk.index') }}" class="nav-link">
                                <i class="fa-solid fa-list"></i>
                                <span class="menu-title text-truncate"> Senarai </span>
                            </a>
                        </li>
                        {{-- @hasanyrole('superadmin') --}}
                        <li class="{{ in_array(request()->route()->getName(), ['helpdesk.categoryList']) ? 'active' : '' }}" >
                            <a href="{{ route('helpdesk.categoryList') }}" class="nav-link">
                                <i class="fa-solid fa-gear"></i>
                                <span class="menu-title text-truncate"> Pengurusan </span>
                            </a>
                        </li>
                        {{-- @endhasanyrole --}}
                    </ul>
                </li>
            @endif

            {{-- IRIS MODULE PEMOHON --}}
            {{-- <li class="navigation-header">
                    <span> Maklumat Pemohon </span>
                </li>
                <li class="nav-item {{ request()->is('iris/maklumat-pemohon*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link">
                        <i class="fa-solid fa-users-line"></i>
                        <span class="menu-title text-truncate"> Pemohon </span>
                    </a>
                    <ul class="menu-content">
                        <li class="nav-user-internal {{ in_array(request()->route()->getName(),['carian_pemohon'])? 'active': '' }}">
                            <a href="{{ route('carian_pemohon') }}" class="d-flex align-items-center">
                                <i class="fa-solid fa-magnifying-glass"></i>
                                <span class="menu-title text-truncate">
                                    Carian Pemohon
                                </span>
                            </a>
                        </li>
                    </ul>
                </li> --}}

            {{-- Foreach documentation menu item starts --}}
            @hasanyrole('')
                @if (!in_array(env('APP_ENV'),['production','staging']))
                    <hr>
                    <li class="navigation-header">
                        <span>Documentation Side</span>
                        <i data-feather="more-horizontal"></i>
                    </li>
                    @if (isset($menuData[0]))
                        @foreach ($menuData[0]->menu as $menu)
                            @if (isset($menu->navheader))
                                <li class="navigation-header">
                                    <span>{{ __('locale.' . $menu->navheader) }}</span>
                                    <i data-feather="more-horizontal"></i>
                                </li>
                            @else
                                {{-- Add Custom Class with nav-item --}}
                                @php
                                $custom_classes = '';
                                if (isset($menu->classlist)) {
                                    $custom_classes = $menu->classlist;
                                }
                                @endphp
                                <li class="nav-item {{ $custom_classes }} {{ Route::currentRouteName() === $menu->slug ? 'active' : '' }}">
                                    <a href="{{ isset($menu->url) ? url($menu->url) : 'javascript:void(0)' }}" class="d-flex align-items-center" target="{{ isset($menu->newTab) ? '_blank' : '_self' }}">
                                        <i data-feather="{{ $menu->icon }}"></i>
                                        <span class="menu-title text-truncate">{{ __('locale.' . $menu->name) }}</span>
                                        @if (isset($menu->badge))
                                            <?php $badgeClasses = 'badge rounded-pill badge-light-primary ms-auto me-1'; ?>
                                            <span class="{{ isset($menu->badgeClass) ? $menu->badgeClass : $badgeClasses }}">{{ $menu->badge }}</span>
                                        @endif
                                    </a>
                                    @if (isset($menu->submenu))
                                        @include('panels/submenu', ['menu' => $menu->submenu])
                                    @endif
                                </li>
                            @endif
                        @endforeach
                    @endif
                @endif
            @endhasanyrole
        </ul>
    </div>
</div>
