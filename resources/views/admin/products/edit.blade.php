@extends('admin/layouts/default')

{{-- page level styles --}}
@section('header_styles')
    <link rel="stylesheet" href="/css/themes/default.min.css" />
    <link type="text/css" href="/css/awesome-bootstrap-checkbox.css" rel="stylesheet" />
    <link href="/css/jquery.fileuploader.css" type="text/css" rel="stylesheet" />
    <link href="/css/jquery.fileuploader-theme-dragdrop.css" media="all" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="/css/sweetalert.css">
    <link href="/css/select2.min.css" type="text/css" rel="stylesheet" />
    <link href="/css/select2-bootstrap.min.css" type="text/css" rel="stylesheet" />
@stop

{{-- Page content --}}
@section('content')
    <section class="content-header">
        <!--section starts-->
        <h1>
            Uređivanje proizvoda
        </h1>
        <ol class="breadcrumb">
            <li>
                <a href="{{ route('admin.dashboard') }}">
                    <i class="livicon" data-name="home" data-size="14" data-loop="true"></i>
                    Admin Panel
                </a>
            </li>
            <li>
                <a href="#">Proizvodi</a>
            </li>
            <li class="active">
                Uredi proizvod
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
                            Uredi proizvod
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
                        @if (session('error'))
                            <div class="col-md-12 alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif
                        <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            {{method_field('PATCH')}}

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
                                       value="{{$product->name}}" required>
                            </div>

                            <div class="form-group">
                                <label for="manufacturer_id" class="control-label">
                                    Odaberite proizvođača:
                                    <select class="form-control" id="manufacturer_id" name="manufacturer_id" required></select>
                                </label>
                            </div>

                            <div class="form-group">
                                <label for="catalogNumber" class="control-label">Kataloški broj:</label>
                                <input id="catalogNumber" name="catalogNumber" type="text"
                                       placeholder="Kataloški broj" class="form-control required"
                                       value="{{$product->catalogNumber}}" required>
                            </div>

                            <div class="form-group">
                                <label for="price" class="control-label">Cijena:</label>
                                <input id="price" name="price" type="number"
                                       placeholder="Cijena" class="form-control required"
                                       value="{{ $product->getOriginal('price') }}" required>
                            </div>

                            <div class="form-group">
                                <label for="discount_price" class="control-label">Cijena na popustu:</label>
                                <input id="discount_price" name="discount_price" type="number"
                                       placeholder="Cijena na popustu" class="form-control required"
                                       value="{{ $product->getOriginal('discount_price') }}" required>
                            </div>

                            <div class="form-group">
                                <label for="unit" class="control-label">Mjerna jedinica proizvoda:</label>
                                <select id="unit" class="form-control" name="unit">
                                    <option value="kom" @if($product->unit == 'kom') selected @endif>kom</option>
                                    <option value="m" @if($product->unit == 'm') selected @endif>m</option>
                                    <option value="kg" @if($product->unit == 'kg') selected @endif>kg</option>
                                </select>
                            </div>
                            <div class="checkbox checkbox-primary">
                                <input id="checkbox1" type="checkbox" name="highlighted" @if($product->highlighted) checked @endif>
                                <label for="checkbox1">
                                    Istaknuti proizvod
                                </label>
                            </div>


                            <div class="form-group">
                                <label for="description" class="control-label">Opis proizvoda:</label>
                                <textarea id="description" name="description" class="form-control required" required>{{$product->description}}</textarea>
                            </div>

                            <div class="form-group">
                                <input type="file" name="images" data-fileuploader-files='{{$product_images}}'>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-block">Spremi izmjene</button>
                            </div>

                            <!--ends--> </form></div>
                </div>


                <!--select-->
            </div>
            <!--col-md-6 ends-->
            <!--col-md-6 ends-->

            <!--col-md-6 ends-->
            </div>
        </div>
        <!--main content ends-->
    </section>
    <!-- content -->

@stop

{{-- page level scripts --}}
@section('footer_scripts')
    <script src="/js/jquery.fileuploader.min.js"></script>
    <script src="/js/sweetalert.min.js"></script>
    <script type="text/javascript">
        $('input[name="images"]').fileuploader({
            addMore: true,
            theme: 'dragdrop',
            extensions: ["jpg", "jpeg", "png", "gif"],
            onRemove: function(item, listEl, parentEl, newInputEl, inputEl) {
                console.log(item.data);

                var removed = false;

                var token = $('meta[name="csrf-token"]').attr('content');

                if (item.data.hasOwnProperty('imageID')) {
                    $.ajax({
                        async: false,
                        type: 'DELETE',
                        url: "{{route('product_image.delete', $product->slug)}}",
                        headers: {'X-CSRF-TOKEN': token},
                        data: {imageID: item.data.imageID},
                        error: function() {
                            console.log("error");
                            swal("Dogodila se greška.", "Molimo pokušajte kasnije!", "error");
                        },
                        success: function(data) {
                            if(data === "success") {
                                removed = true;
                            } else {
                                removed = false;
                                swal("Dogodila se greška.", "Molimo pokušajte kasnije!", "error");
                            }
                        }
                    });
                } else {
                    return true;
                }

                return removed;
            }
        });
    </script>

    <script src="{{ asset('js/select2.min.js') }}"></script>
    <script type="text/javascript">
        $('#select21').select2(
            {
                theme: "bootstrap"
            }
        );

        var data = $.map({!! $manufacturers !!}, function (obj) {
            obj.text = obj.text || obj.name; // replace name with the property used for the text

            return obj;
        });
        $('#manufacturer_id').select2(
            {
                data: data,
                theme: "bootstrap"
            }
        );

        $('#manufacturer_id').val({{ $product->manufacturer->id }});
        $('#manufacturer_id').trigger('change');
    </script>

    <script src="/assets/vendors/unisharp/laravel-ckeditor/ckeditor.js"></script>
    <script>
        CKEDITOR.replace('description');
    </script>
@stop