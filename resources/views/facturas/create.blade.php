@extends('layouts.app')

@push('css')

@endpush

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        {{ __('Completa los siguientes campos de tu factura:') }}
                    </div>
                </div>
                

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form action="{{route('facturas.store')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="concepto" class="col-form-label fw-bold">Concepto:</label>
                            <input type="text" class="form-control" id="concepto" name="concepto" required>
                            @error('concepto')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="factura" class="col-form-label fw-bold">Factura:</label>
                            <input type="file" class="form-control" name="factura" id="factura" accept=".pdf" required>
                            @error('factura')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="xml" class="col-form-label fw-bold">XML:</label>
                            <input type="file" class="form-control" name="xml" id="xml" accept="text/xml" required>
                            @error('xml')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                        <a class="btn btn-secondary btn-sm" href="{{route('facturas.index')}}">Cancelar</a>
                        <button type="submit" class="btn btn-primary btn-sm">Guardar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')

@endpush
