@php
    $user = Auth::user();

    $menus = DB::table('users as u')
        ->join('user_access_menu as uam', function ($join) use ($user) {
            $join->on('u.id_role', '=', 'uam.id_role')->on('u.id_perusahaan', '=', 'uam.id_perusahaan');
        })
        ->join('user_menu as um', 'uam.id_menu', '=', 'um.id_menu')
        ->join('user_menu_sub as ums', 'um.id_menu', '=', 'ums.id_menu')
        ->where('u.username', $user->username)
        ->select(
            'um.id_menu',
            'um.nama_menu',
            'ums.nama_menu_sub',
            'ums.urutan_menu',
            DB::raw("CONCAT(um.url_menu, '/', ums.url_menu) AS url_menu"),
        )
        ->orderBy('um.id_menu', 'asc')
        ->orderBy('ums.urutan_menu', 'asc')
        ->get();

    $groupedMenus = $menus->groupBy('id_menu');
@endphp

@include('partials.head')

@include('partials.sidebar')

@include('partials.header')

@yield('content')

@include('partials.footer')
