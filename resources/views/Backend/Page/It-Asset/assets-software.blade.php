@extends('Backend.Layouts.panel')
@section('Style-Area')
<style>
    .text-p {
        font-size: 15px !important;
    }
</style>
<link rel="stylesheet" type="text/css" href="{{ asset('Backend/assets/css/vendors/datatables.css')}}">
@endsection
@section('Content-Area')

<div class="col-sm-12">
    <div class="card">
        <div class="card-header pb-0">
            <div class="card">
                <div class="row ">
                    <div class="col-md-6">
                        <h4>IT Assets</h4>
                    </div>
                    <div class="col-md-6 text-end p-4">
                        <button class="btn btn-primary qr_btn"><img src="{{ asset('Backend/assets/images/It-Assets/Vector1.svg') }}" alt='...'></button>
                        <button class="btn btn-primary qr_btn"><img src="{{ asset('Backend/assets/images/It-Assets/Vector3.svg') }}" alt='...'></button>
                        <button class="btn btn-primary qr_btn"><img src="{{ asset('Backend/assets/images/It-Assets/veckor2.svg') }}" alt='...'></button>

                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive theme-scrollbar">
                <table class="display" id="basic-1">
                    <thead>
                        <tr>
                            <th>SL</th>
                            <th>Code</th>
                            <th>Asset</th>
                            <th>Product Key</th>
                            <th>Quantity</th>
                            <th>Allocated</th>
                            <th>Balance</th>
                            <th>Allocation</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>a23</td>
                            <td>Windows 10</td>
                            <td>xxxx xxxx xxxx</td>
                            <td>
                                <span class="badge rounded-pill badge-light-success">1,443</span>
                            </td>
                            <td>15 </td>
                            <td>5 </td>
                            <td>
                                <button class="btn btn-primary" type="submit" data-bs-original-title="" title="">View</button>
                            </td>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>a23</td>
                            <td>Windows 10</td>
                            <td>xxxx xxxx xxxx</td>
                            <td>
                                <span class="badge rounded-pill badge-light-success">1,443</span>
                            </td>
                            <td>15 </td>
                            <td>5 </td>
                            <td>
                                <button class="btn btn-primary" type="submit" data-bs-original-title="" title="">View</button>
                            </td>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>a23</td>
                            <td>Windows 10</td>
                            <td>xxxx xxxx xxxx</td>
                            <td>
                                <span class="badge rounded-pill badge-light-success">1,443</span>
                            </td>
                            <td>15 </td>
                            <td>5 </td>
                            <td>
                                <button class="btn btn-primary" type="submit" data-bs-original-title="" title="">View</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection