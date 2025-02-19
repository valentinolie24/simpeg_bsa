@php
    $userRole = Auth::user()->role; // Ambil peran pengguna yang sedang masuk
    $sideMenu = \App\Main\SideMenu::menu(); // Ambil semua menu

    // Filter menu berdasarkan peran pengguna
    $filteredMenu = [];
    foreach ($sideMenu as $menuKey => $menu) {
        if ($userRole === 'calon_pegawai') {
            if (in_array($menuKey, ['rekrutmen', 'seleksi', 'pengumuman'])) {
                $filteredMenu[] = $menu;
            }
        } elseif ($userRole === 'pegawai') {
            if (
                in_array($menuKey, [
                    'pegawai',
                    'absensi',
                    'cuti',
                    'promosi',
                    'demosi',
                    'mutasi',
                    'phk',
                    'reward_punishment',
                ])
            ) {
                $filteredMenu[] = $menu;
            }
        } else {
            $filteredMenu[] = $menu;
        }
    }
@endphp

@extends('../layout/main')

@section('head')
    @yield('subhead')
@endsection

@section('content')
    @include('../layout/components/mobile-menu')
    @include('../layout/components/top-bar')
    <div class="flex overflow-hidden">
        <!-- BEGIN: Side Menu -->
        <nav class="side-nav">
            <ul>
                @isset($filteredMenu)
                    @foreach ($filteredMenu as $menuKey => $menu)
                        @if ($menu == 'devider')
                            <li class="side-nav__devider my-6"></li>
                        @else
                            <li>
                                <a href="{{ isset($menu['route_name']) ? route($menu['route_name'], $menu['params']) : 'javascript:;' }}"
                                    class="{{ $first_level_active_index == $menuKey ? 'side-menu side-menu--active' : 'side-menu' }}">
                                    <div class="side-menu__icon">
                                        <i data-lucide="{{ $menu['icon'] }}"></i>
                                    </div>
                                    <div class="side-menu__title">
                                        {{ $menu['title'] }}
                                        @if (isset($menu['sub_menu']))
                                            <div
                                                class="side-menu__sub-icon {{ $first_level_active_index == $menuKey ? 'transform rotate-180' : '' }}">
                                                <i data-lucide="chevron-down"></i>
                                            </div>
                                        @endif
                                    </div>
                                </a>
                                @if (isset($menu['sub_menu']))
                                    <ul class="{{ $first_level_active_index == $menuKey ? 'side-menu__sub-open' : '' }}">
                                        @foreach ($menu['sub_menu'] as $subMenuKey => $subMenu)
                                            <li>
                                                <a href="{{ isset($subMenu['route_name']) ? route($subMenu['route_name'], $subMenu['params']) : 'javascript:;' }}"
                                                    class="{{ $second_level_active_index == $subMenuKey ? 'side-menu side-menu--active' : 'side-menu' }}">
                                                    <div class="side-menu__icon">
                                                        <i data-lucide="{{ $subMenu['icon'] }}"></i>
                                                    </div>
                                                    <div class="side-menu__title">
                                                        {{ $subMenu['title'] }}
                                                        @if (isset($subMenu['sub_menu']))
                                                            <div
                                                                class="side-menu__sub-icon {{ $second_level_active_index == $subMenuKey ? 'transform rotate-180' : '' }}">
                                                                <i data-lucide="chevron-down"></i>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </a>
                                                @if (isset($subMenu['sub_menu']))
                                                    <ul
                                                        class="{{ $second_level_active_index == $subMenuKey ? 'side-menu__sub-open' : '' }}">
                                                        @foreach ($subMenu['sub_menu'] as $lastSubMenuKey => $lastSubMenu)
                                                            <li>
                                                                <a href="{{ isset($lastSubMenu['route_name']) ? route($lastSubMenu['route_name'], $lastSubMenu['params']) : 'javascript:;' }}"
                                                                    class="{{ $third_level_active_index == $lastSubMenuKey ? 'side-menu side-menu--active' : 'side-menu' }}">
                                                                    <div class="side-menu__icon">
                                                                        <i data-lucide="zap"></i>
                                                                    </div>
                                                                    <div class="side-menu__title">{{ $lastSubMenu['title'] }}
                                                                    </div>
                                                                </a>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                @endif
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                            </li>
                        @endif
                    @endforeach
                @endisset
            </ul>
        </nav>
        <!-- END: Side Menu -->
        <!-- BEGIN: Content -->
        <div class="content">
            @yield('subcontent')
        </div>
        <!-- END: Content -->
    </div>
@endsection
