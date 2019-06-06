@extends('layouts.app')

@section('content')
<div class="container main-container headerOffset">

    <div class="row">
        <div class="col-lg-9 col-md-9 col-sm-7 col-xs-6 col-xxs-12 text-center-xs">
            <h1 class="section-title-inner"><span><i
                            class="glyphicon glyphicon-shopping-cart"></i> Košarica </span></h1>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-5 rightSidebar col-xs-6 col-xxs-12 text-center-xs">
            <h4 class="caps"><a href="{{route('shop')}}"><i class="fa fa-chevron-left"></i> Povratak u trgovinu </a></h4>
        </div>
    </div>
    <!--/.row-->
    @if(! $products->isEmpty())
        <div class="row">
            <div class="col-lg-9 col-md-9 col-sm-7">
                <div class="row userInfo">
                    <div class="col-xs-12 col-sm-12">
                        <div class="cartContent w100">
                            <table class="cartTable table-responsive" style="width:100%">
                                <tbody>

                                <tr class="CartProduct cartTableHeader">
                                    <td style="width:25%">&nbsp;</td>
                                    <td style="width:35%">Naziv proizvoda</td>
                                    <td style="width:10%" class="delete">&nbsp;</td>
                                    <td style="width:10%">Količina</td>
                                    <td style="width:20%">Mjerna jedinica</td>
                                </tr>

                                @foreach($products as $product)
                                    <tr class="CartProduct">
                                        <td class="CartProductThumb">
                                            <div><a href="{{route('product.show', $product->slug)}}"><img src="/product_images/{{ $product->slug }}/{{$product->mainImage->path}}" alt="img"></a>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="CartDescription">
                                                <h4><a href="{{route('product.show', $product->slug)}}">{{$product->name}}</a></h4>
                                            </div>
                                        </td>
                                        <td class="delete" id="{{ $product->id }}"><a title="Delete"> <i
                                                        class="glyphicon glyphicon-trash fa-2x"></i></a></td>
                                        <td><input type="text" name="quantity" value="{{ $product->quantity }}"></td>
                                        <td>{{ $product->unit }}</td>
                                    </tr>
                                @endforeach

                                </tbody>
                            </table>
                        </div>
                        <!--cartContent-->

                        <form action="{{route('order.store')}}" method="post">
                            {{csrf_field()}}
                        <div class="cartFooter w100">
                            <textarea style="resize:vertical;" class="form-control" name="remark" placeholder="Napomena..."></textarea> <br>
                            <div class="box-footer">
                                <div class="pull-left"><a href="{{route('shop.products')}}" class="btn btn-primary"> <i
                                                class="fa fa-arrow-left"></i> &nbsp; Nastavite kupovati</a></div>
                                <div class="pull-right">
                                    <button type="submit" class="btn btn-primary" id="update"><i class="fa fa-undo"></i> &nbsp; Promjenite količine u košarici</button>
                                </div>
                            </div>

                        </div>
                        <!--/ cartFooter -->

                    </div>
                </div>
                <!--/row end-->
            </div>
            <div class="col-lg-3 col-md-3 col-sm-5 rightSidebar">
                <div class="contentBox">
                    <div class="w100 costDetails">
                        <div class="table-block" id="order-detail-content"><button class="btn btn-primary btn-lg btn-block"
                                                                              title="checkout"
                                                                              style="margin-bottom:20px">Zatraži ponudu &nbsp; <i class="fa fa-arrow-right"></i> </button>
                        </div>
                    </div>
                </div>
                <!-- End popular -->
            </div>
            <!--/rightSidebar-->
            </form>
        </div>
        <!--/row-->
        <div style="clear:both"></div>
    @else
        <div class="alert alert-info" role="alert">
            <strong>Vaša košarica trenutno je prazna.</strong>
        </div>
    @endif
</div>
<!-- /.main-container -->

<div class="gap"></div>
@endsection

@section('scripts')
    <script>
        $("table td.delete").click(function () {
            var token = $('meta[name="csrf-token"]').attr('content');
            var product_id = $(this).attr('id');
            var row = $(this).closest('tr');
            $.ajax({
                type: 'DELETE',
                url: '/products/deleteFromCart',
                headers: {'X-CSRF-TOKEN': token},
                data: {product_id: product_id},
                error: function(){
                    console.log("error");
                    swal("Dogodila se greška.", "Molimo pokušajte kasnije!", "error");
                },
                success: function(data) {
                    /*console.log("success");
                    console.log(data);*/
                    if($.isNumeric(data)) {
                        row.fadeTo(400, 0, function () {
                            row.remove();
                        });
                        $(".cartRespons").empty().text("(" + data + ")");
                    }
                    else {
                        var failStart = "";
                        $.each(data.errors, function(index, value) {
                            $.each(value,function(i){
                                failStart += value[i]+"\n";
                            });

                        });
                        swal("Dogodila se greška.", failStart, "error");
                    }
                }
            });
        });
    </script>

<script>
    function getAllValues() {
        var inputValues = $('.cartTable :input').map(function() {
                return $(this).val();
        });
        return inputValues.get().join();
    }

    $("#update").click(function (e) {
        e.preventDefault();
        var token = $('meta[name="csrf-token"]').attr('content');
        var inputValues = getAllValues();
        $.ajax({
            type: 'POST',
            url: "{{route('cart.update')}}",
            headers: {'X-CSRF-TOKEN': token},
            data: {quantities: inputValues},
            error: function() {
                console.log("error");
                swal("Dogodila se greška.", "Molimo pokušajte kasnije!", "error");
            },
            success: function(data) {
                if(data === "success") {
                    swal("Uspjeh!", "Količine u košarici su uspješno promjenjene!", "success")
                } else {
                    var failStart = "";
                    $.each(data.errors, function(index, value) {
                        $.each(value,function(i){
                            failStart += value[i]+"\n";
                        });

                    });
                    swal("Dogodila se greška.", failStart, "error");
                }
            }
        });
    });
</script>
@endsection

