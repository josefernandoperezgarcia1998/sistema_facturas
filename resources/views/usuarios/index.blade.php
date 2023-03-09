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
                <div class="card-header">{{ __('Listado de Usuarios') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{-- {{ __('You are logged in!') }} --}}
                    <table id="usuarios" class="table">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Email</th>
                                <th>Rol</th>
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
        $('#usuarios').DataTable({
            "serverSide": true,
            "ajax": "{{ url('usuarios-datatables') }}",
            "columns": [
                {data: 'name'},
                {data: 'email'},
                {data: 'rol'},
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