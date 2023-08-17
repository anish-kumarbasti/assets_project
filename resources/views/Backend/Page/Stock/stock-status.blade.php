@extends('Backend.Layouts.panel')
@section('Style-Area')
    <style>
        .btn-view {
            background: #BB4F00 !important;
            border: 2px solid #BB4F00 !important;
        }

        .qr_btn {
            border-radius: 10px;
            padding: 10px;
        }

        .stock-item {
            border: 3px solid #55555533 !important;
            margin-top: 17px;
            border-radius: 28px;
            background-color: #F5F6FE;
            position: relative;
            left: 20px;
        }

        .border-right {
            border-right: 3px solid #55555533;
        }
    </style>
@endsection
@section('Content-Area')
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header pb-0">
                <div class="card">
                    <div class="row ">
                        <div class="col-md-9">
                            <div class="row d-flex justify-content-center py-4 stock-item mb-3">
                                <!-- Add the tab navigation links -->
                                <div class="col-md-2 border-right">
                                    <a class="nav-link active status-tab" href="#danger-instock" aria-selected="true"
                                        data-toggle="tab" data-status="in-stock">In Stock</a>
                                </div>
                                <div class="col-md-2 border-right">
                                    <a class="nav-link status-tab" href="#danger-allocated" aria-selected="true"
                                        data-toggle="tab" data-status="allocated">Allocated</a>
                                </div>
                                <div class="col-md-2 border-right">
                                    <a class="nav-link status-tab" href="#danger-underrepair" aria-selected="true"
                                        data-toggle="tab" data-status="underrepair">Under Repair</a>
                                </div>
                                <div class="col-md-2 border-right">
                                    <a class="nav-link status-tab" href="#danger-stolen" aria-selected="true"
                                        data-toggle="tab" data-status="stolen">Stolen
                                </div>
                                <div class="col-md-2 border-right">
                                    <a class="nav-link status-tab" href="#danger-scrapped" aria-selected="true"
                                        data-toggle="tab" data-status="scrapped">Scrapped</a>
                                </div>
                                <!-- Repeat the same structure for other tabs -->
                            </div>
                        </div>
                        <div class="col-md-3 text-end p-4">
                            <button class="btn btn-primary qr_btn"><img
                                    src="{{ asset('Backend/assets/images/It-Assets/Vector1.svg') }}"
                                    alt='...'></button>
                            <button class="btn btn-primary qr_btn"><img
                                    src="{{ asset('Backend/assets/images/It-Assets/veckor2.svg') }}"
                                    alt='...'></button>
                            <button class="btn btn-primary qr_btn"><img
                                    src="{{ asset('Backend/assets/images/It-Assets/Vector3.svg') }}"
                                    alt='...'></button>

                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <!-- Add the tab content container -->
                <div class="tab-content" id="danger-tabContent">
                    <!-- Add the tab content for each tab -->
                    <div class="tab-pane fade show active" id="danger-instock" role="tabpanel"
                        aria-labelledby="danger-home-tab">
                        <!-- Your table content for "In Stock" tab -->
                        <div class="table-responsive theme-scrollbar">
                            <table class="display" id="basic-1">
                                <thead>
                                    <tr>
                                        <th>SL</th>
                                        <th>Code</th>
                                        <th>Asset</th>
                                        <th>Model</th>
                                        <th>Brand</th>

                                        <th>Serial Number</th>
                                        <th>Configuration</th>

                                        <th>Price</th>
                                        <th>Timeline</th>


                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>a23</td>
                                        <td>Laptop</td>
                                        <td>Inspiron</td>
                                        <td>Dell</td>
                                        <td>0123456789</td>

                                        <td>Processor: Intel Core i5-1235U
                                            12th Generation
                                            (up to 4.40 GHz, 12MB 10 Cores)
                                            RAM & Storage: 8GB</td>
                                        <td> ₹62,443</td>

                                        <td>
                                            <button class="btn btn-primary btn-view" type="submit"
                                                data-bs-original-title="" title="">View</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>1</td>
                                        <td>a23</td>
                                        <td>Laptop</td>
                                        <td>Inspiron</td>
                                        <td>Dell</td>
                                        <td>0123456789</td>

                                        <td>Processor: Intel Core i5-1235U
                                            12th Generation
                                            (up to 4.40 GHz, 12MB 10 Cores)
                                            RAM & Storage: 8GB</td>
                                        <td> ₹62,443</td>

                                        <td>
                                            <button class="btn btn-primary btn-view" type="submit"
                                                data-bs-original-title="" title="">View</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>1</td>
                                        <td>a23</td>
                                        <td>Laptop</td>
                                        <td>Inspiron</td>
                                        <td>Dell</td>
                                        <td>0123456789</td>

                                        <td>Processor: Intel Core i5-1235U
                                            12th Generation
                                            (up to 4.40 GHz, 12MB 10 Cores)
                                            RAM & Storage: 8GB</td>
                                        <td> ₹62,443</td>

                                        <td>
                                            <button class="btn btn-primary btn-view" type="submit"
                                                data-bs-original-title="" title="">View</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        </div>
                        <div class="tab-pane fade" id="danger-allocated" role="tabpanel" aria-labelledby="danger-home-tab">
                            <!-- Your table content for "In Stock" tab -->
                            <div class="table-responsive theme-scrollbar">
                                <table class="display" id="basic-1">
                                    <thead>
                                        <tr>
                                            <th>SL</th>
                                            <th>Code</th>
                                            <th>Asset</th>
                                            <th>Model</th>
                                            <th>Brand</th>

                                            <th>Serial Number</th>
                                            <th>Configuration</th>

                                            <th>Price</th>
                                            <th>Timeline</th>


                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>a23</td>
                                            <td>Laptop</td>
                                            <td>Inspiron</td>
                                            <td>Dell</td>
                                            <td>0123456789</td>

                                            <td>Processor: Intel Core i5-1235U
                                                12th Generation
                                                (up to 4.40 GHz, 12MB 10 Cores)
                                                RAM & Storage: 8GB</td>
                                            <td> ₹62,443</td>

                                            <td>
                                                <button class="btn btn-primary btn-view" type="submit"
                                                    data-bs-original-title="" title="">View</button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>1</td>
                                            <td>a23</td>
                                            <td>Laptop</td>
                                            <td>Inspiron</td>
                                            <td>Dell</td>
                                            <td>0123456789</td>

                                            <td>Processor: Intel Core i5-1235U
                                                12th Generation
                                                (up to 4.40 GHz, 12MB 10 Cores)
                                                RAM & Storage: 8GB</td>
                                            <td> ₹62,443</td>

                                            <td>
                                                <button class="btn btn-primary btn-view" type="submit"
                                                    data-bs-original-title="" title="">View</button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>1</td>
                                            <td>a23</td>
                                            <td>Laptop</td>
                                            <td>Inspiron</td>
                                            <td>Dell</td>
                                            <td>0123456789</td>

                                            <td>Processor: Intel Core i5-1235U
                                                12th Generation
                                                (up to 4.40 GHz, 12MB 10 Cores)
                                                RAM & Storage: 8GB</td>
                                            <td> ₹62,443</td>

                                            <td>
                                                <button class="btn btn-primary btn-view" type="submit"
                                                    data-bs-original-title="" title="">View</button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="danger-underrepair" role="tabpanel"
                            aria-labelledby="danger-home-tab">
                            <div class="table-responsive theme-scrollbar">
                                <!-- Your table content for "In Stock" tab -->
                                <table class="display" id="basic-1">
                                    <thead>
                                        <tr>
                                            <th>SL</th>
                                            <th>Code</th>
                                            <th>Asset</th>
                                            <th>Model</th>
                                            <th>Brand</th>

                                            <th>Serial Number</th>
                                            <th>Configuration</th>
                                            <th>User ID</th>
                                            <th>User</th>
                                            <th>Deparment</th>
                                            <th>Designation</th>

                                            <th>Price</th>
                                            <th>Timeline</th>


                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>a23</td>
                                            <td>Laptop</td>
                                            <td>Inspiron</td>
                                            <td>Dell</td>
                                            <td>0123456789</td>

                                            <td>Processor: Intel Core i5-1235U
                                                12th Generation
                                                (up to 4.40 GHz, 12MB 10 Cores)
                                                RAM & Storage: 8GB</td>
                                            <td>125a5</td>
                                            <td>Anoop</td>
                                            <td>IT</td>
                                            <td>CEO</td>
                                            <td> ₹62,443</td>

                                            <td>
                                                <button class="btn btn-primary btn-view" type="submit"
                                                    data-bs-original-title="" title="">View</button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>1</td>
                                            <td>a23</td>
                                            <td>Laptop</td>
                                            <td>Inspiron</td>
                                            <td>Dell</td>
                                            <td>0123456789</td>

                                            <td>Processor: Intel Core i5-1235U
                                                12th Generation
                                                (up to 4.40 GHz, 12MB 10 Cores)
                                                RAM & Storage: 8GB</td>
                                            <td>125a5</td>
                                            <td>Anoop</td>
                                            <td>IT</td>
                                            <td>CEO</td>
                                            <td> ₹62,443</td>

                                            <td>
                                                <button class="btn btn-primary btn-view" type="submit"
                                                    data-bs-original-title="" title="">View</button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>1</td>
                                            <td>a23</td>
                                            <td>Laptop</td>
                                            <td>Inspiron</td>
                                            <td>Dell</td>
                                            <td>0123456789</td>

                                            <td>Processor: Intel Core i5-1235U
                                                12th Generation
                                                (up to 4.40 GHz, 12MB 10 Cores)
                                                RAM & Storage: 8GB</td>
                                            <td>125a5</td>
                                            <td>Anoop</td>
                                            <td>IT</td>
                                            <td>CEO</td>
                                            <td> ₹62,443</td>

                                            <td>
                                                <button class="btn btn-primary btn-view" type="submit"
                                                    data-bs-original-title="" title="">View</button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="danger-stolen" role="tabpanel" aria-labelledby="danger-home-tab">
                            <div class="table-responsive theme-scrollbar">
                                <!-- Your table content for "In Stock" tab -->
                                <table class="display" id="basic-1">
                                    <thead>
                                        <tr>
                                            <th>SL</th>
                                            <th>Code</th>
                                            <th>Asset</th>
                                            <th>Model</th>
                                            <th>Brand</th>

                                            <th>Serial Number</th>
                                            <th>Configuration</th>
                                            <th>User ID</th>
                                            <th>User</th>
                                            <th>Deparment</th>
                                            <th>Designation</th>

                                            <th>Price</th>
                                            <th>Timeline</th>


                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>a23</td>
                                            <td>Laptop</td>
                                            <td>Inspiron</td>
                                            <td>Dell</td>
                                            <td>0123456789</td>

                                            <td>Processor: Intel Core i5-1235U
                                                12th Generation
                                                (up to 4.40 GHz, 12MB 10 Cores)
                                                RAM & Storage: 8GB</td>
                                            <td>125a5</td>
                                            <td>Anoop</td>
                                            <td>IT</td>
                                            <td>CEO</td>
                                            <td> ₹62,443</td>

                                            <td>
                                                <button class="btn btn-primary btn-view" type="submit"
                                                    data-bs-original-title="" title="">View</button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>1</td>
                                            <td>a23</td>
                                            <td>Laptop</td>
                                            <td>Inspiron</td>
                                            <td>Dell</td>
                                            <td>0123456789</td>

                                            <td>Processor: Intel Core i5-1235U
                                                12th Generation
                                                (up to 4.40 GHz, 12MB 10 Cores)
                                                RAM & Storage: 8GB</td>
                                            <td>125a5</td>
                                            <td>Anoop</td>
                                            <td>IT</td>
                                            <td>CEO</td>
                                            <td> ₹62,443</td>

                                            <td>
                                                <button class="btn btn-primary btn-view" type="submit"
                                                    data-bs-original-title="" title="">View</button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>1</td>
                                            <td>a23</td>
                                            <td>Laptop</td>
                                            <td>Inspiron</td>
                                            <td>Dell</td>
                                            <td>0123456789</td>

                                            <td>Processor: Intel Core i5-1235U
                                                12th Generation
                                                (up to 4.40 GHz, 12MB 10 Cores)
                                                RAM & Storage: 8GB</td>
                                            <td>125a5</td>
                                            <td>Anoop</td>
                                            <td>IT</td>
                                            <td>CEO</td>
                                            <td> ₹62,443</td>

                                            <td>
                                                <button class="btn btn-primary btn-view" type="submit"
                                                    data-bs-original-title="" title="">View</button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- Your table content for "In Stock" tab -->
                        <div class="tab-pane fade" id="danger-scrapped" role="tabpanel"
                            aria-labelledby="profile-danger-tab">
                            <div class="table-responsive theme-scrollbar">
                                <table class="display" id="basic-1">
                                    <thead>
                                        <tr>
                                            <th>SL</th>
                                            <th>Code</th>
                                            <th>Asset</th>
                                            <th>Model</th>
                                            <th>Brand</th>

                                            <th>Serial Number</th>
                                            <th>Configuration</th>
                                            <th>User ID</th>
                                            <th>User</th>
                                            <th>Deparment</th>
                                            <th>Designation</th>

                                            <th>Price</th>
                                            <th>Timeline</th>


                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>a23</td>
                                            <td>Laptop</td>
                                            <td>Inspiron</td>
                                            <td>Dell</td>
                                            <td>0123456789</td>

                                            <td>Processor: Intel Core i5-1235U
                                                12th Generation
                                                (up to 4.40 GHz, 12MB 10 Cores)
                                                RAM & Storage: 8GB</td>
                                            <td>125a5</td>
                                            <td>Anoop</td>
                                            <td>IT</td>
                                            <td>CEO</td>
                                            <td> ₹62,443</td>

                                            <td>
                                                <button class="btn btn-primary btn-view" type="submit"
                                                    data-bs-original-title="" title="">View</button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>1</td>
                                            <td>a23</td>
                                            <td>Laptop</td>
                                            <td>Inspiron</td>
                                            <td>Dell</td>
                                            <td>0123456789</td>

                                            <td>Processor: Intel Core i5-1235U
                                                12th Generation
                                                (up to 4.40 GHz, 12MB 10 Cores)
                                                RAM & Storage: 8GB</td>
                                            <td>125a5</td>
                                            <td>Anoop</td>
                                            <td>IT</td>
                                            <td>CEO</td>
                                            <td> ₹62,443</td>

                                            <td>
                                                <button class="btn btn-primary btn-view" type="submit"
                                                    data-bs-original-title="" title="">View</button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>1</td>
                                            <td>a23</td>
                                            <td>Laptop</td>
                                            <td>Inspiron</td>
                                            <td>Dell</td>
                                            <td>0123456789</td>

                                            <td>Processor: Intel Core i5-1235U
                                                12th Generation
                                                (up to 4.40 GHz, 12MB 10 Cores)
                                                RAM & Storage: 8GB</td>
                                            <td>125a5</td>
                                            <td>Anoop</td>
                                            <td>IT</td>
                                            <td>CEO</td>
                                            <td> ₹62,443</td>

                                            <td>
                                                <button class="btn btn-primary btn-view" type="submit"
                                                    data-bs-original-title="" title="">View</button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- Repeat the same structure for other tabs -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- <div class="col-sm-12">
        <div class="card">
            <div class="card-header pb-0">
                <div class="card">
                    <div class="row ">
                        <div class="col-md-9">
                            <div class="row d-flex justify-content-center py-4 stock-item mb-3">
                                <div class="col-md-2 border-right">
                                    <a class="nav-link active status-tab" href="#danger-instock" aria-selected="true" data-bs-toggle="tab" data-status="in-stock">In Stock</a>
                                </div>
                                <div class="col-md-2 border-right">
                                    <a class="nav-link status-tab" href="#danger-allocated" aria-selected="false" data-bs-toggle="tab" data-status="allocated">Allocated</a>
                                </div>
                                <div class="col-md-2 border-right">
                                    <a class="nav-link status-tab" href="#danger-under_repair" data-bs-toggle="tab" aria-selected="false" data-status="repair">Under Repair</a>
                                </div>
                                <div class="col-md-2 border-right">
                                    <a class="nav-link status-tab" href="#danger-stolen" data-bs-toggle="tab" aria-selected="false" data-status="stolen">Stolen</a>
                                </div>
                                <div class="col-md-2">
                                    <a class="nav-link status-tab" data-bs-toggle="tab" href="#danger-scrapped" aria-selected="false" data-status="scrapped">Scrapped</a>
                                </div>
                            </div>

                        </div>
                        <div class="col-md-3 text-end p-4">
                            <button class="btn btn-primary qr_btn"><img
                                    src="{{ asset('Backend/assets/images/It-Assets/Vector1.svg') }}"
                                    alt='...'></button>
                            <button class="btn btn-primary qr_btn"><img
                                    src="{{ asset('Backend/assets/images/It-Assets/veckor2.svg') }}"
                                    alt='...'></button>
                            <button class="btn btn-primary qr_btn"><img
                                    src="{{ asset('Backend/assets/images/It-Assets/Vector3.svg') }}"
                                    alt='...'></button>

                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive theme-scrollbar">
                    <div class="tab-content" id="danger-tabContent">
                        <div class="tab-pane fade show active" id="danger-instock" role="tabpanel"
                            aria-labelledby="danger-home-tab">
                            <table class="display" id="basic-1">
                              <thead>
                                  <tr>
                                      <th>SL</th>
                                      <th>Code</th>
                                      <th>Asset</th>
                                      <th>Model</th>
                                      <th>Brand</th>
      
                                      <th>Serial Number</th>
                                      <th>Configuration</th>
      
                                      <th>Price</th>
                                      <th>Timeline</th>
      
      
                                  </tr>
                              </thead>
                              <tbody>
                                  <tr>
                                      <td>1</td>
                                      <td>a23</td>
                                      <td>Laptop</td>
                                      <td>Inspiron</td>
                                      <td>Dell</td>
                                      <td>0123456789</td>
      
                                      <td>Processor: Intel Core i5-1235U
                                          12th Generation
                                          (up to 4.40 GHz, 12MB 10 Cores)
                                          RAM & Storage: 8GB</td>
                                      <td> ₹62,443</td>
      
                                      <td>
                                          <button class="btn btn-primary btn-view" type="submit" data-bs-original-title=""
                                              title="">View</button>
                                      </td>
                                  </tr>
                                  <tr>
                                      <td>1</td>
                                      <td>a23</td>
                                      <td>Laptop</td>
                                      <td>Inspiron</td>
                                      <td>Dell</td>
                                      <td>0123456789</td>
      
                                      <td>Processor: Intel Core i5-1235U
                                          12th Generation
                                          (up to 4.40 GHz, 12MB 10 Cores)
                                          RAM & Storage: 8GB</td>
                                      <td> ₹62,443</td>
      
                                      <td>
                                          <button class="btn btn-primary btn-view" type="submit" data-bs-original-title=""
                                              title="">View</button>
                                      </td>
                                  </tr>
                                  <tr>
                                      <td>1</td>
                                      <td>a23</td>
                                      <td>Laptop</td>
                                      <td>Inspiron</td>
                                      <td>Dell</td>
                                      <td>0123456789</td>
      
                                      <td>Processor: Intel Core i5-1235U
                                          12th Generation
                                          (up to 4.40 GHz, 12MB 10 Cores)
                                          RAM & Storage: 8GB</td>
                                      <td> ₹62,443</td>
      
                                      <td>
                                          <button class="btn btn-primary btn-view" type="submit" data-bs-original-title=""
                                              title="">View</button>
                                      </td>
                                  </tr>
                              </tbody>
                          </table>
                        </div>
                        <div class="tab-pane fade" id="danger-allocated" role="tabpanel" aria-labelledby="profile-danger-tab">
                           <table class="display" id="basic-1">
                              <thead>
                                  <tr>
                                      <th>SL</th>
                                      <th>Code</th>
                                      <th>Asset</th>
                                      <th>Model</th>
                                      <th>Brand</th>
      
                                      <th>Serial Number</th>
                                      <th>Configuration</th>
                                      <th>User ID</th>
                                      <th>User</th>
                                      <th>Deparment</th>
                                      <th>Designation</th>
      
                                      <th>Price</th>
                                      <th>Timeline</th>
      
      
                                  </tr>
                              </thead>
                              <tbody>
                                  <tr>
                                      <td>1</td>
                                      <td>a23</td>
                                      <td>Laptop</td>
                                      <td>Inspiron</td>
                                      <td>Dell</td>
                                      <td>0123456789</td>
      
                                      <td>Processor: Intel Core i5-1235U
                                          12th Generation
                                          (up to 4.40 GHz, 12MB 10 Cores)
                                          RAM & Storage: 8GB</td>
                                      <td>125a5</td>
                                      <td>Anoop</td>
                                      <td>IT</td>
                                      <td>CEO</td>
                                      <td> ₹62,443</td>
      
                                      <td>
                                          <button class="btn btn-primary btn-view" type="submit" data-bs-original-title=""
                                              title="">View</button>
                                      </td>
                                  </tr>
                                  <tr>
                                      <td>1</td>
                                      <td>a23</td>
                                      <td>Laptop</td>
                                      <td>Inspiron</td>
                                      <td>Dell</td>
                                      <td>0123456789</td>
      
                                      <td>Processor: Intel Core i5-1235U
                                          12th Generation
                                          (up to 4.40 GHz, 12MB 10 Cores)
                                          RAM & Storage: 8GB</td>
                                      <td>125a5</td>
                                      <td>Anoop</td>
                                      <td>IT</td>
                                      <td>CEO</td>
                                      <td> ₹62,443</td>
      
                                      <td>
                                          <button class="btn btn-primary btn-view" type="submit" data-bs-original-title=""
                                              title="">View</button>
                                      </td>
                                  </tr>
                                  <tr>
                                      <td>1</td>
                                      <td>a23</td>
                                      <td>Laptop</td>
                                      <td>Inspiron</td>
                                      <td>Dell</td>
                                      <td>0123456789</td>
      
                                      <td>Processor: Intel Core i5-1235U
                                          12th Generation
                                          (up to 4.40 GHz, 12MB 10 Cores)
                                          RAM & Storage: 8GB</td>
                                      <td>125a5</td>
                                      <td>Anoop</td>
                                      <td>IT</td>
                                      <td>CEO</td>
                                      <td> ₹62,443</td>
      
                                      <td>
                                          <button class="btn btn-primary btn-view" type="submit" data-bs-original-title=""
                                              title="">View</button>
                                      </td>
                                  </tr>
                              </tbody>
                          </table>
                        </div>
                        <div class="tab-pane fade" id="danger-under_repair" role="tabpanel" aria-labelledby="contact-danger-tab">
                           <table class="display" id="basic-1">
                              <thead>
                                  <tr>
                                      <th>SL</th>
                                      <th>Code</th>
                                      <th>Asset</th>
                                      <th>Model</th>
                                      <th>Brand</th>
      
                                      <th>Serial Number</th>
                                      <th>Configuration</th>
                                      <th>User ID</th>
                                      <th>User</th>
                                      <th>Deparment</th>
                                      <th>Designation</th>
      
                                      <th>Price</th>
                                      <th>Timeline</th>
      
      
                                  </tr>
                              </thead>
                              <tbody>
                                  <tr>
                                      <td>1</td>
                                      <td>a23</td>
                                      <td>Laptop</td>
                                      <td>Inspiron</td>
                                      <td>Dell</td>
                                      <td>0123456789</td>
      
                                      <td>Processor: Intel Core i5-1235U
                                          12th Generation
                                          (up to 4.40 GHz, 12MB 10 Cores)
                                          RAM & Storage: 8GB</td>
                                      <td>125a5</td>
                                      <td>Anoop</td>
                                      <td>IT</td>
                                      <td>CEO</td>
                                      <td> ₹62,443</td>
      
                                      <td>
                                          <button class="btn btn-primary btn-view" type="submit" data-bs-original-title=""
                                              title="">View</button>
                                      </td>
                                  </tr>
                                  <tr>
                                      <td>1</td>
                                      <td>a23</td>
                                      <td>Laptop</td>
                                      <td>Inspiron</td>
                                      <td>Dell</td>
                                      <td>0123456789</td>
      
                                      <td>Processor: Intel Core i5-1235U
                                          12th Generation
                                          (up to 4.40 GHz, 12MB 10 Cores)
                                          RAM & Storage: 8GB</td>
                                      <td>125a5</td>
                                      <td>Anoop</td>
                                      <td>IT</td>
                                      <td>CEO</td>
                                      <td> ₹62,443</td>
      
                                      <td>
                                          <button class="btn btn-primary btn-view" type="submit" data-bs-original-title=""
                                              title="">View</button>
                                      </td>
                                  </tr>
                                  <tr>
                                      <td>1</td>
                                      <td>a23</td>
                                      <td>Laptop</td>
                                      <td>Inspiron</td>
                                      <td>Dell</td>
                                      <td>0123456789</td>
      
                                      <td>Processor: Intel Core i5-1235U
                                          12th Generation
                                          (up to 4.40 GHz, 12MB 10 Cores)
                                          RAM & Storage: 8GB</td>
                                      <td>125a5</td>
                                      <td>Anoop</td>
                                      <td>IT</td>
                                      <td>CEO</td>
                                      <td> ₹62,443</td>
      
                                      <td>
                                          <button class="btn btn-primary btn-view" type="submit" data-bs-original-title=""
                                              title="">View</button>
                                      </td>
                                  </tr>
                              </tbody>
                          </table>
                        </div>
                        <div class="tab-pane fade" id="danger-stolen" role="tabpanel"
                            aria-labelledby="danger-home-tab">
                            <table class="display" id="basic-1">
                              <thead>
                                  <tr>
                                      <th>SL</th>
                                      <th>Code</th>
                                      <th>Asset</th>
                                      <th>Model</th>
                                      <th>Brand</th>
      
                                      <th>Serial Number</th>
                                      <th>Configuration</th>
                                      <th>User ID</th>
                                      <th>User</th>
                                      <th>Deparment</th>
                                      <th>Designation</th>
      
                                      <th>Price</th>
                                      <th>Timeline</th>
      
      
                                  </tr>
                              </thead>
                              <tbody>
                                  <tr>
                                      <td>1</td>
                                      <td>a23</td>
                                      <td>Laptop</td>
                                      <td>Inspiron</td>
                                      <td>Dell</td>
                                      <td>0123456789</td>
      
                                      <td>Processor: Intel Core i5-1235U
                                          12th Generation
                                          (up to 4.40 GHz, 12MB 10 Cores)
                                          RAM & Storage: 8GB</td>
                                      <td>125a5</td>
                                      <td>Anoop</td>
                                      <td>IT</td>
                                      <td>CEO</td>
                                      <td> ₹62,443</td>
      
                                      <td>
                                          <button class="btn btn-primary btn-view" type="submit" data-bs-original-title=""
                                              title="">View</button>
                                      </td>
                                  </tr>
                                  <tr>
                                      <td>1</td>
                                      <td>a23</td>
                                      <td>Laptop</td>
                                      <td>Inspiron</td>
                                      <td>Dell</td>
                                      <td>0123456789</td>
      
                                      <td>Processor: Intel Core i5-1235U
                                          12th Generation
                                          (up to 4.40 GHz, 12MB 10 Cores)
                                          RAM & Storage: 8GB</td>
                                      <td>125a5</td>
                                      <td>Anoop</td>
                                      <td>IT</td>
                                      <td>CEO</td>
                                      <td> ₹62,443</td>
      
                                      <td>
                                          <button class="btn btn-primary btn-view" type="submit" data-bs-original-title=""
                                              title="">View</button>
                                      </td>
                                  </tr>
                                  <tr>
                                      <td>1</td>
                                      <td>a23</td>
                                      <td>Laptop</td>
                                      <td>Inspiron</td>
                                      <td>Dell</td>
                                      <td>0123456789</td>
      
                                      <td>Processor: Intel Core i5-1235U
                                          12th Generation
                                          (up to 4.40 GHz, 12MB 10 Cores)
                                          RAM & Storage: 8GB</td>
                                      <td>125a5</td>
                                      <td>Anoop</td>
                                      <td>IT</td>
                                      <td>CEO</td>
                                      <td> ₹62,443</td>
      
                                      <td>
                                          <button class="btn btn-primary btn-view" type="submit" data-bs-original-title=""
                                              title="">View</button>
                                      </td>
                                  </tr>
                              </tbody>
                          </table>
                        </div>
                        <div class="tab-pane fade" id="danger-scrapped" role="tabpanel" aria-labelledby="profile-danger-tab">
                           <table class="display" id="basic-1">
                              <thead>
                                  <tr>
                                      <th>SL</th>
                                      <th>Code</th>
                                      <th>Asset</th>
                                      <th>Model</th>
                                      <th>Brand</th>
      
                                      <th>Serial Number</th>
                                      <th>Configuration</th>
                                      <th>User ID</th>
                                      <th>User</th>
                                      <th>Deparment</th>
                                      <th>Designation</th>
      
                                      <th>Price</th>
                                      <th>Timeline</th>
      
      
                                  </tr>
                              </thead>
                              <tbody>
                                  <tr>
                                      <td>1</td>
                                      <td>a23</td>
                                      <td>Laptop</td>
                                      <td>Inspiron</td>
                                      <td>Dell</td>
                                      <td>0123456789</td>
      
                                      <td>Processor: Intel Core i5-1235U
                                          12th Generation
                                          (up to 4.40 GHz, 12MB 10 Cores)
                                          RAM & Storage: 8GB</td>
                                      <td>125a5</td>
                                      <td>Anoop</td>
                                      <td>IT</td>
                                      <td>CEO</td>
                                      <td> ₹62,443</td>
      
                                      <td>
                                          <button class="btn btn-primary btn-view" type="submit" data-bs-original-title=""
                                              title="">View</button>
                                      </td>
                                  </tr>
                                  <tr>
                                      <td>1</td>
                                      <td>a23</td>
                                      <td>Laptop</td>
                                      <td>Inspiron</td>
                                      <td>Dell</td>
                                      <td>0123456789</td>
      
                                      <td>Processor: Intel Core i5-1235U
                                          12th Generation
                                          (up to 4.40 GHz, 12MB 10 Cores)
                                          RAM & Storage: 8GB</td>
                                      <td>125a5</td>
                                      <td>Anoop</td>
                                      <td>IT</td>
                                      <td>CEO</td>
                                      <td> ₹62,443</td>
      
                                      <td>
                                          <button class="btn btn-primary btn-view" type="submit" data-bs-original-title=""
                                              title="">View</button>
                                      </td>
                                  </tr>
                                  <tr>
                                      <td>1</td>
                                      <td>a23</td>
                                      <td>Laptop</td>
                                      <td>Inspiron</td>
                                      <td>Dell</td>
                                      <td>0123456789</td>
      
                                      <td>Processor: Intel Core i5-1235U
                                          12th Generation
                                          (up to 4.40 GHz, 12MB 10 Cores)
                                          RAM & Storage: 8GB</td>
                                      <td>125a5</td>
                                      <td>Anoop</td>
                                      <td>IT</td>
                                      <td>CEO</td>
                                      <td> ₹62,443</td>
      
                                      <td>
                                          <button class="btn btn-primary btn-view" type="submit" data-bs-original-title=""
                                              title="">View</button>
                                      </td>
                                  </tr>
                              </tbody>
                          </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
@endsection
{{-- @section('Script-Area') --}}
{{-- <script>
        document.addEventListener("DOMContentLoaded", function() {
            const statusTabs = document.querySelectorAll(".status-tab");
            const statusRows = document.querySelectorAll(".status-row");

            statusTabs.forEach(tab => {
                tab.addEventListener("click", () => {
                    const status = tab.getAttribute("data-status");

                    // Hide all rows
                    statusRows.forEach(row => {
                        row.style.display = "none";
                    });

                    // Show rows with the selected status
                    statusRows.forEach(row => {
                        if (row.getAttribute("data-status") === status) {
                            row.style.display = "table-row";
                        }
                    });

                    // Update active tab
                    statusTabs.forEach(tab => {
                        tab.classList.remove("active");
                    });
                    tab.classList.add("active", "selected-tab"); // Add selected-tab class
                });
            });

            // Initially show the first tab's data
            statusTabs[0].click();
        });
    </script> --}}
@section('Script-Area')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const statusTabs = document.querySelectorAll(".status-tab");
            const statusRows = document.querySelectorAll(".tab-pane");

            statusTabs.forEach(tab => {
                tab.addEventListener("click", () => {
                    const status = tab.getAttribute("data-status");

                    statusRows.forEach(row => {
                        row.classList.remove("show", "active");
                    });

                    const tabContent = document.getElementById(`danger-${status}`);
                    tabContent.classList.add("show", "active");

                    // Initialize DataTable for the current tab's table
                    if (status === "in-stock") {
                        // Initialize DataTable for the "In Stock" table
                        if (!$.fn.dataTable.isDataTable('#instock-table')) {
                            $('#instock-table').DataTable();
                        }
                    }
                    if (status === "allocated") {
                        // Initialize DataTable for the "In Stock" table
                        if (!$.fn.dataTable.isDataTable('#allocated')) {
                            $('#allocated').DataTable();
                        }
                    }
                    if (status === "under-repair") {
                        // Initialize DataTable for the "In Stock" table
                        if (!$.fn.dataTable.isDataTable('#under-repair')) {
                            $('#under-repair').DataTable();
                        }
                    }
                    if (status === "stolen") {
                        // Initialize DataTable for the "In Stock" table
                        if (!$.fn.dataTable.isDataTable('#stolen')) {
                            $('#stolen').DataTable();
                        }
                    }
                    if (status === "scrapped") {
                        // Initialize DataTable for the "In Stock" table
                        if (!$.fn.dataTable.isDataTable('#scrapped')) {
                            $('#scrapped').DataTable();
                        }
                    }
                    // Initialize DataTable for other tables in the same way
                });
            });
        });
    </script>
@endsection


{{-- @endsection --}}
