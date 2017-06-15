@extends('admin/layouts/default')

{{-- page level styles --}}
@section('header_styles')
    <link rel="stylesheet" href="/css/themes/default.min.css" />
    <link type="text/css" href="/css/awesome-bootstrap-checkbox.css" rel="stylesheet" />
    <link href="/css/jquery.filer.css" type="text/css" rel="stylesheet" />
    <link href="/css/themes/jquery.filer-dragdropbox-theme.css" type="text/css" rel="stylesheet" />
@stop

{{-- Page content --}}
@section('content')
    <section class="content-header">
        <!--section starts-->
        <h1>
            Dodajte novi proizvod
        </h1>
        <ol class="breadcrumb">
            <li>
                <a href="{{ route('admin.dashboard') }}">
                    <i class="livicon" data-name="home" data-size="14" data-loop="true"></i>
                    Admin CP
                </a>
            </li>
            <li>
                <a href="#">Proizvodi</a>
            </li>
            <li class="active">
                Dodaj proizvod
            </li>
        </ol>
    </section>
    <!--section ends-->
    <section class="content">
        <!--main content-->
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            Dodaj novi proizvod
                        </h3>
                                <span class="pull-right clickable">
                                    <i class="glyphicon glyphicon-chevron-up"></i>
                                </span>
                    </div>
                    <div class="panel-body">
                        @if (count($errors) > 0)
                            <div class="col-md-12 alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        @if (session('success'))
                            <div class="col-md-12 alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                            {{ csrf_field() }}
                        <div class="form-group">
                            <label for="select21" class="control-label">
                                Odaberite kategoriju proizvoda:
                            </label>
                            {!! $selectHTML !!}
                        </div>

                        <div class="form-group">
                            <label for="name" class="control-label">Naziv proizvoda:</label>
                                <input id="name" name="name" type="text"
                                       placeholder="Naziv proizvoda" class="form-control required"
                                       value="{!! old('name') !!}" required>
                        </div>

                        <div class="form-group">
                            <label for="unit" class="control-label">Mjerna jedinica proizvoda:</label>
                            <select id="unit" class="form-control" name="unit">
                                <option value="kom">kom</option>
                                <option value="m">m</option>
                                <option value="kg">kg</option>
                            </select>
                        </div>
                        <div class="checkbox checkbox-primary">
                            <input id="checkbox1" type="checkbox" name="highlighted">
                            <label for="checkbox1">
                                Istaknuti proizvod
                            </label>
                        </div>
                        {{-- <div class="form-group">
                            <label for="price" class="col-sm-2 control-label">Price</label>
                                <input id="price" name="price" placeholder="Price" type="number" step="0.5"
                                       class="form-control required email" value="{!! old('price') !!}" required>
                        </div>

                        <div class="form-group">
                            <label for="currency" class="control-label">
                                Choose the currency
                            </label>
                            <select id="currency" class="form-control select2">
                                <option value="HRK">KN</option>
                                <option value="EUR">EUR</option>
                                <option value="USD">USD</option>
                            </select>
                        </div> --}}
                        <div class="form-group">
                            <label for="description" class="control-label">Opis proizvoda:</label>
                            <textarea id="description" name="description" class="form-control required" required></textarea>
                        </div>

                        <div class="form-group">
                            <div>Prva slika će biti glavna slika proizvoda, a ostale slike će se vidjeti u detaljima proizvoda u galeriji slika.</div>
                            <label class="control-label">Odaberite slike</label>
                            {{--<input id="images" name="images[]" type="file" class="file-loading" accept="image/*" multiple> --}}
                            <input type="file" name="images[]" id="filer_input" accept="image/*" multiple>
                        </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-block">Dodaj proizvod</button>
                            </div>

                        <!--ends--> </form></div>
                </div>


                <!--select-->
            </div>
            <!--col-md-6 ends-->
            <!--col-md-6 ends-->

            <!--col-md-6 ends-->
        </div>
        <!--main content ends-->
    </section>
    <!-- content -->

@stop

{{-- page level scripts --}}
@section('footer_scripts')
    <script src="/js/jquery.sceditor.bbcode.min.js"></script>
    <script src="/js/jquery.filer.min.js"></script>
    <script>
        $(function() {
            // Replace all textarea tags with SCEditor
            $('textarea').sceditor({
                height: 300,
                plugins: 'bbcode',
                style: '/css/jquery.sceditor.default.min.css',
                emoticonsRoot: '/',
                toolbar:"bold,italic,underline,strike|left,center,right,justify|size,color,removeformat|code,quote|image,email,link,unlink|emoticon,youtube,date,time|maximize,source"
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#filer_input').filer({
                limit: 10,
                maxSize: 8,
                extensions: ["jpg", "jpeg", "png", "gif"],
                showThumbs: true,
                addMore: true,
                changeInput: '<div class="jFiler-input-dragDrop"><div class="jFiler-input-inner"><div class="jFiler-input-icon"><i class="icon-jfi-folder"></i></div><div class="jFiler-input-text"><h3>Kliknite ovdje</h3> <span style="display:inline-block; margin: 15px 0">ili</span></div><a class="jFiler-input-choose-btn btn-custom blue-light">Birajte slike</a></div></div>',
                theme: "dragdropbox",
                templates: filer_default_opts.templates,
                captions: {
                    button: "Odaberi slike",
                    feedback: "Odaberi slike",
                    feedback2: "slike su odabrane",
                    removeConfirmation: "Jeste li sigurni da želite obrisati ovu sliku?",
                    errors: {
                        filesLimit: "Možete uploadati najviše 10 slika po proizvodu.",
                        filesType: "Samo .jpg, .jpeg, .png i .gif slike su dopuštene.",
                        filesSize: "Slika je prevelika. Najveća veličina pojedine slike je 5 MB.",
                        filesSizeAll: "Files you've choosed are too large! Please upload files up to 5 MB."
                    }
                }
            });
        });
    </script>
    {{--

        <script src="{{ asset('assets/vendors/bootstrap-multiselect/js/bootstrap-multiselect.js') }}" ></script>
        <script src="{{ asset('assets/vendors/select2/js/select2.js') }}"></script>
        <script src="{{ asset('assets/vendors/sifter/sifter.js') }}"></script>
        <script src="{{ asset('assets/vendors/microplugin/microplugin.js') }}"></script>
        <script src="{{ asset('assets/vendors/selectize/js/selectize.min.js') }}"></script>
        <script src="{{ asset('assets/vendors/iCheck/js/icheck.js') }}"></script>
        <script src="{{ asset('assets/vendors/bootstrap-switch/js/bootstrap-switch.js') }}"></script>
        <script src="{{ asset('assets/vendors/switchery/js/switchery.js') }}" ></script>
        <script src="{{ asset('assets/vendors/bootstrap-maxlength/js/bootstrap-maxlength.js') }}"></script>
        <script src="{{ asset('assets/vendors/card/lib/js/jquery.card.js') }}"></script>
        <script src="{{ asset('assets/js/pages/custom_elements.js') }}"></script>--}}

@stop