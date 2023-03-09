@extends('layouts.app')

@push('css')
    {{-- Inicio para datatable responsive  --}}
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap4.min.css">
{{-- Fin para datatable responsive  --}}
@endpush

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <div>
                            Listado de facturas @if(Auth::user()->rol == 'Administrador') general @else de {{Auth::user()->name}} @endif
                        </div>
                        <div>
                            <a type="button" class="btn btn-primary btn-sm" href="{{route('facturas.create')}}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-circle" viewBox="0 0 16 16">
                                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                    <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
                                </svg> Agregar
                            </a>
                        </div>
                    </div>
                </div>
                

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{-- {{ __('You are logged in!') }} --}}
                    <table id="facturas" class="table">
                        <thead>
                            <tr>
                                <th>Concepto</th>
                                <th>Factura</th>
                                <th>XML</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
<script>
    $(document).ready(function () {
        $('#facturas').DataTable({
            "serverSide": true,
            "ajax": "{{ url('facturas-datatables') }}",
            "columns": [
                {data: 'concepto'},
                {data: 'factura',
                    render: function( data, type, full, meta ) {
                            if(data){
                                let iconPDF = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-earmark-pdf" viewBox="0 0 16 16"><path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2zM9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5v2z"/><path d="M4.603 14.087a.81.81 0 0 1-.438-.42c-.195-.388-.13-.776.08-1.102.198-.307.526-.568.897-.787a7.68 7.68 0 0 1 1.482-.645 19.697 19.697 0 0 0 1.062-2.227 7.269 7.269 0 0 1-.43-1.295c-.086-.4-.119-.796-.046-1.136.075-.354.274-.672.65-.823.192-.077.4-.12.602-.077a.7.7 0 0 1 .477.365c.088.164.12.356.127.538.007.188-.012.396-.047.614-.084.51-.27 1.134-.52 1.794a10.954 10.954 0 0 0 .98 1.686 5.753 5.753 0 0 1 1.334.05c.364.066.734.195.96.465.12.144.193.32.2.518.007.192-.047.382-.138.563a1.04 1.04 0 0 1-.354.416.856.856 0 0 1-.51.138c-.331-.014-.654-.196-.933-.417a5.712 5.712 0 0 1-.911-.95 11.651 11.651 0 0 0-1.997.406 11.307 11.307 0 0 1-1.02 1.51c-.292.35-.609.656-.927.787a.793.793 0 0 1-.58.029zm1.379-1.901c-.166.076-.32.156-.459.238-.328.194-.541.383-.647.547-.094.145-.096.25-.04.361.01.022.02.036.026.044a.266.266 0 0 0 .035-.012c.137-.056.355-.235.635-.572a8.18 8.18 0 0 0 .45-.606zm1.64-1.33a12.71 12.71 0 0 1 1.01-.193 11.744 11.744 0 0 1-.51-.858 20.801 20.801 0 0 1-.5 1.05zm2.446.45c.15.163.296.3.435.41.24.19.407.253.498.256a.107.107 0 0 0 .07-.015.307.307 0 0 0 .094-.125.436.436 0 0 0 .059-.2.095.095 0 0 0-.026-.063c-.052-.062-.2-.152-.518-.209a3.876 3.876 0 0 0-.612-.053zM8.078 7.8a6.7 6.7 0 0 0 .2-.828c.031-.188.043-.343.038-.465a.613.613 0 0 0-.032-.198.517.517 0 0 0-.145.04c-.087.035-.158.106-.196.283-.04.192-.03.469.046.822.024.111.054.227.09.346z"/></svg>'
                                return "<a href=\"{{asset('storage').'/'}}" + data + "\" target=\"_blank\" title='ver imagen'>"+iconPDF+"</a>";
                            } else {
                                return "";
                            }
                        }
                },
                {data: 'xml',
                    render: function( data, type, full, meta ) {
                            if(data){
                                let iconXML = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-filetype-xml" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M14 4.5V14a2 2 0 0 1-2 2v-1a1 1 0 0 0 1-1V4.5h-2A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v9H2V2a2 2 0 0 1 2-2h5.5L14 4.5ZM3.527 11.85h-.893l-.823 1.439h-.036L.943 11.85H.012l1.227 1.983L0 15.85h.861l.853-1.415h.035l.85 1.415h.908l-1.254-1.992 1.274-2.007Zm.954 3.999v-2.66h.038l.952 2.159h.516l.946-2.16h.038v2.661h.715V11.85h-.8l-1.14 2.596h-.025L4.58 11.85h-.806v3.999h.706Zm4.71-.674h1.696v.674H8.4V11.85h.791v3.325Z"/></svg>'
                                return "<a href=\"{{asset('storage').'/'}}" + data + "\" target=\"_blank\" title='ver imagen'>"+iconXML+"</a>";
                            } else {
                                return "";
                            }
                        }
                },
                {data: 'estado',
                    // Cambiando el color deel estado dependiendo la opción
                    render: function (data, type, row) {
                                if (data === "Aprobado") {
                                    return '<i class="far fa-dot-circle" style="background-color:#008000; color:white;" /*aria-hidden="true"*/>Aprobado</i>';
                                }
                                if (data === 'Revision') {
                                    return '<i class="far fa-dot-circle" style="background-color:#EFF12D; color:black;" /*aria-hidden="true"*/>Revisión</i>';
                                }
                                if (data === 'Rechazado') {
                                    return '<i class="far fa-dot-circle" style="background-color:#F22424; color:white;" /*aria-hidden="true"*/>Rechazado</i>';
                                }
                                return '<i class="far fa-dot-circle" style="color:red" /*aria-hidden="true"*/></i>';
                            }
                },
                {data: 'btn'},
            ],
            responsive: true,
            autoWidth: false,
    
            "language": {
            "lengthMenu": "Mostrar " +
                `<select class="custom-select custom-select-sm form-control form-control-sm">
                                        <option value='10'>10</option>
                                        <option value='25'>25</option>
                                        <option value='50'>50</option>
                                        <option value='-1'>Todo</option>
                                        </select>` +
                " registros por página",
            "zeroRecords": "Sin registros",
            "info": "Mostrando la página _PAGE_ de _PAGES_",
            "infoEmpty": "",
            "infoFiltered": "(filtrado de _MAX_ registros totales)",
            'search': 'Buscar:',
            'paginate': {
                'next': 'Siguiente',
                'previous': 'Anterior'
                }
            },
            // Estas lineas de abajo 
            stateSave: true,
            stateSaveCallback: function(settings,data) {
                localStorage.setItem( 'DataTables_' + settings.sInstance, JSON.stringify(data) )
                },
            stateLoadCallback: function(settings) {
                return JSON.parse( localStorage.getItem( 'DataTables_' + settings.sInstance ) )
                }
        });
    });

</script>
@endpush
