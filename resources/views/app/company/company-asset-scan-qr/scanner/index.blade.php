@extends('app.layouts.panel')

@section('content')

<div class="row d-flex justify-content-center align-items-center h-100">
    <!--begin::Aside-->
    <div class="col-10 col-md-4 row d-flex justify-content-center">
        <h1 class="text-center">QR Code Scanner</h1>
    </div>
    <div class="col-12 d-flex justify-content-center">
        <livewire:company.company-asset-scan-qr.scanner />
    </div>
    <!--begin::Aside-->
</div>
@endsection


    

