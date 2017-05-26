@extends('admin/layouts/default')

@section('header_styles')
    <link rel="stylesheet" href="/css/themes/default.min.css" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/datatables/css/dataTables.bootstrap.css') }}" />
    <link href="{{ asset('assets/css/tables.css') }}" rel="stylesheet" type="text/css" />
@stop

{{-- Page content --}}
@section('content')

    <section class="content-header">
        <h1>Popis svih proizovda</h1>
        <ol class="breadcrumb">
            <li class="active">
                <a href="#">
                    <i class="livicon" data-name="home" data-size="16" data-color="#333" data-hovercolor="#333"></i>
                    Admin Panel
                </a>
            </li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <span>Svi proizvodi</span>
                    </div>

                    <div class="panel-body flip-scroll">
                        <table class="table table-bordered table-hover flip-content" id="table">
                            <thead>
                            <tr class="filters">
                                <th>ID proizvoda</th>
                                <th>Naziv proizvoda</th>
                                <th>Stvoren</th>
                                <th>Zadnja izmjena</th>
                                <th>Opcije</th>
                            </tr>
                            </thead>
                            <tbody>


                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>

@stop

@section('footer_scripts')
    <script type="text/javascript" src="{{ asset('assets/vendors/datatables/js/jquery.dataTables.js') }}" ></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/datatables/js/dataTables.bootstrap.js') }}" ></script>

    <script>
        $(document).ready(function() {
            var table = $('#table').DataTable({
                "language": {
                    "lengthMenu": "Prikaz _MENU_ proizvoda po stranici",
                    "zeroRecords": "Ništa nije pronađeno.",
                    "info": "Stranica _PAGE_ od _PAGES_",
                    "infoEmpty": "Nema dostupnih podataka",
                    "infoFiltered": "(filtrirano od ukupno _MAX_ zapisa)",
                    "search": "Traži",
                    "processing": "Obrada...",
                    "paginate": {
                        "previous": "Prethodna",
                        "next": "Sljedeća"
                    }
                },
                processing: true,
                serverSide: true,
                ajax: '{!! route('admin.products.show') !!}',
                columns: [
                    { data: 'id', name: 'id'},
                    { data: 'name', name:'name'},
                    { data: 'created_at', name:'created_at', searchable: false},
                    { data: 'updated_at', name:'updated_at', searchable: false},
                    { data: 'actions', name: 'actions', orderable: false, searchable: false }
                ],
                "lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "Svi proizvodi"] ]
            });

            table.on( 'draw', function () {
                $('.livicon').each(function(){
                    $(this).updateLivicon();
                });
            } );
        });

    </script>

    <div class="modal fade" id="delete_confirm" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content"></div>
        </div>
    </div>
    <script>
        $(function () {
            $('body').on('hidden.bs.modal', '.modal', function () {
                $(this).removeData('bs.modal');
            });
        });
    </script>

@endsection