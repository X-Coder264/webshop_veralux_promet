<ul id="menu" class="page-sidebar-menu">

    <li {!! (Request::is('admin') ? 'class="active"' : '') !!}>
        <a href="{{ route('admin.dashboard') }}">
            <i class="livicon" data-name="home" data-size="18" data-c="#418BCA" data-hc="#418BCA"
               data-loop="true"></i>
            <span class="title">Narudžbe <span class="badge">{{$unopened_order_count}}</span></span>
        </a>
    </li>

    <li {!! (Request::is('admin/users') || Request::is('admin/users/create') || Request::is('admin/user_profile') || Request::is('admin/users/*') || Request::is('admin/deleted_users') ? 'class="active"' : '') !!}>
        <a href="#">
            <i class="livicon" data-name="users" data-size="18" data-c="#6CC66C" data-hc="#6CC66C"
               data-loop="true"></i>
            <span class="title">Korisnici</span>
            <span class="fa arrow"></span>
        </a>
        <ul class="sub-menu">
            <li {!! (Request::is('admin/users') ? 'class="active" id="active"' : '') !!}>
                <a href="{{ URL::to('admin/users') }}">
                    <i class="fa fa-angle-double-right"></i>
                    Svi korisnici
                </a>
            </li>
            <li {!! (Request::is('admin/users/create') ? 'class="active" id="active"' : '') !!}>
                <a href="{{ URL::to('admin/users/create') }}">
                    <i class="fa fa-angle-double-right"></i>
                    Dodaj novog korisnika
                </a>
            </li>
        </ul>
    </li>

    <li {!! (Request::is('admin/categories') || Request::is('admin/categories/*')  ? 'class="active"' : '') !!}>
        <a href="#">
            <i class="livicon" data-name="list" data-size="18" data-c="#6CC66C" data-hc="#6CC66C"
               data-loop="true"></i>
            <span class="title">Kategorije</span>
            <span class="fa arrow"></span>
        </a>
        <ul class="sub-menu">
            <li {!! (Request::is('admin/categories/create') ? 'class="active" id="active"' : '') !!}>
                <a href="{{ route('admin.categories.create') }}">
                    <i class="fa fa-angle-double-right"></i>
                    Dodaj kategoriju
                </a>
            </li>
            <li {!! (Request::is('admin/categories/delete') ? 'class="active" id="active"' : '') !!}>
                <a href="{{ route('admin.categories.showCategoriesDeleteView') }}">
                    <i class="fa fa-angle-double-right"></i>
                    Ukloni kategoriju
                </a>
            </li>
        </ul>
    </li>

    <li {!! (Request::is('admin/manufacturers') || Request::is('admin/manufacturers/*')  ? 'class="active"' : '') !!}>
        <a href="#">
            <i class="livicon" data-name="truck" data-size="18" data-c="#6CC66C" data-hc="#6CC66C"
               data-loop="true"></i>
            <span class="title">Proizvođači</span>
            <span class="fa arrow"></span>
        </a>
        <ul class="sub-menu">
            <li {!! (Request::is('admin/manufacturers') ? 'class="active" id="active"' : '') !!}>
                <a href="{{ route('admin.manufacturers.index') }}">
                    <i class="fa fa-angle-double-right"></i>
                    Svi proizvođači
                </a>
            </li>
            <li {!! (Request::is('admin/manufacturers/create') ? 'class="active" id="active"' : '') !!}>
                <a href="{{ route('admin.manufacturers.create') }}">
                    <i class="fa fa-angle-double-right"></i>
                    Dodaj proizvođača
                </a>
            </li>
        </ul>
    </li>

    <li {!! (Request::is('admin/products') || Request::is('admin/products/*')  ? 'class="active"' : '') !!}>
        <a href="#">
            <i class="livicon" data-name="truck" data-size="18" data-c="#6CC66C" data-hc="#6CC66C"
               data-loop="true"></i>
            <span class="title">Proizvodi</span>
            <span class="fa arrow"></span>
        </a>
        <ul class="sub-menu">
            <li {!! (Request::is('admin/products') ? 'class="active" id="active"' : '') !!}>
                <a href="{{ route('admin.products.index') }}">
                    <i class="fa fa-angle-double-right"></i>
                    Svi proizvodi
                </a>
            </li>
            <li {!! (Request::is('admin/products/create') ? 'class="active" id="active"' : '') !!}>
                <a href="{{ route('admin.products.create') }}">
                    <i class="fa fa-angle-double-right"></i>
                    Dodaj proizvod
                </a>
            </li>
        </ul>
    </li>

</ul>
