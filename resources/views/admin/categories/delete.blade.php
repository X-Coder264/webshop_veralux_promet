@extends('admin.layouts.default')

{{-- page level styles --}}
@section('header_styles')
    <link href="{{ asset('assets/css/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
@stop

{{-- Page content --}}
@section('content')
    <section class="content-header">
        <!--section starts-->
        <h1>
            Obriši kategoriju
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
                Obriši kategoriju
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
                            Obriši kategoriju
                        </h3>
                                <span class="pull-right clickable">
                                    <i class="glyphicon glyphicon-chevron-up"></i>
                                </span>
                    </div>
                    <div class="panel-body">
                        @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        <div class="alert alert-danger">
                            Kategoriju je moguće obrisati jedino ukoliko ona sama te sve njezine podkategorije (ukoliko ih ima) ne sadrže niti jedan proizvod.
                        </div>

                        <form action="{{ route('admin.categories.delete') }}" method="POST" id="delete_category">
                            {{ csrf_field() }}

                            {!! $html !!}

                            </form></div>
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
    <script type="text/javascript" src="{{ asset('assets/js/sweetalert2.min.js') }}" ></script>


    <script type="text/javascript">
        $(document).ready(function () {
            $("button.category_button").click(function(event) {
                event.preventDefault();

                var formData = $(this).closest('form').serializeArray();
                formData.push({ name: this.name, value: this.value });

                $.ajax({
                    type: 'POST',
                    url: $("#delete_category").attr('action'),
                    async: false,
                    cache: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: formData,
                    error: function(){
                        console.log("error");
                    },
                    success: function(data) {
                        if(data === "success") {
                            swal({
                                type: 'success',
                                title: 'Uspjeh!',
                                text: 'Kategorija je uspješno obrisana!',
                                onClose: function(element)
                                {
                                    location.reload(true);
                                }
                            });
                        }
                        else
                        {
                            swal("Kategorija nije obrisana! Poruka:", data, "error");
                        }
                    }
                });
            });
        });
    </script>
@stop