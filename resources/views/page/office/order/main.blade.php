<x-office-layout title="Order">
    <div id="content_list">
        <!--begin::Toolbar-->
        <div class="toolbar" id="kt_toolbar">
            <!--begin::Container-->
            <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
                <!--begin::Page title-->
                <div data-kt-place="true" data-kt-place-mode="prepend" data-kt-place-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}" class="page-title d-flex align-items-center me-3">
                    <!--begin::Title-->
                    <h1 class="d-flex align-items-center text-dark fw-bolder my-1 fs-3">
                        Order
                    </h1>
                    <!--end::Title-->
                </div>
                <!--end::Page title-->
                <!--begin::Actions-->
                <div class="d-flex align-items-center py-1">
                    <!--begin::Wrapper-->
                    {{-- <form action="{{route('office.order.pdf')}}" method="post">
                        @csrf
                        <input type="hidden" name="sts" value="Wait for confirmation" id="sts">
                        <input type="hidden" name="starts" id="starts" value="{{date('Y-m-01')}}">
                        <input type="hidden" name="ends" id="ends" value="{{date('Y-m-d')}}">
                        <button type="submit" class="btn btn-sm btn-flex btn-primary btn-active-secondary fw-bolder">
                            Print Report On Proccess
                        </button>
                    </form> --}}
                    <div class="me-4">
                        <!--begin::Menu-->
                        <a href="javascript:void(0);" class="btn btn-sm btn-flex btn-light btn-active-primary fw-bolder" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end" data-kt-menu-flip="top-end">
                            <!--begin::Svg Icon | path: icons/duotone/Text/Filter.svg-->
                            <span class="svg-icon svg-icon-5 svg-icon-gray-500 me-1">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <rect x="0" y="0" width="24" height="24" />
                                        <path d="M5,4 L19,4 C19.2761424,4 19.5,4.22385763 19.5,4.5 C19.5,4.60818511 19.4649111,4.71345191 19.4,4.8 L14,12 L14,20.190983 C14,20.4671254 13.7761424,20.690983 13.5,20.690983 C13.4223775,20.690983 13.3458209,20.6729105 13.2763932,20.6381966 L10,19 L10,12 L4.6,4.8 C4.43431458,4.5790861 4.4790861,4.26568542 4.7,4.1 C4.78654809,4.03508894 4.89181489,4 5,4 Z" fill="#000000" />
                                    </g>
                                </svg>
                            </span>
                            <!--end::Svg Icon-->
                            Filter
                        </a>
                        <!--begin::Menu 1-->
                        <div class="menu menu-sub menu-sub-dropdown w-250px w-md-300px" data-kt-menu="true">
                            <!--begin::Header-->
                            <div class="px-7 py-5">
                                <div class="fs-5 text-dark fw-bolder">Filter Options</div>
                            </div>
                            <!--end::Header-->
                            <!--begin::Menu separator-->
                            <div class="separator border-gray-200"></div>
                            <!--end::Menu separator-->
                            <!--begin::Form-->
                            <form id="content_filter">
                                <div class="px-7 py-5">
                                    <!--begin::Input group-->
                                    <div class="mb-10">
                                        <!--begin::Label-->
                                        <label class="form-label fw-bold">Status:</label>
                                        <!--end::Label-->
                                        <select class="form-control" name="st" onchange="load_list(1);" id="st">
                                            <option value="Wait for confirmation">Wait for confirmation</option>
                                            <option value="Order on process">Order on process</option>
                                            <option value="On the way">On the way</option>
                                            <option value="Received">Received</option>
                                        </select>
                                    </div>
                                    <div class="mb-10">
                                        <!--begin::Label-->
                                        <label class="form-label fw-bold">Start:</label>
                                        <!--end::Label-->
                                        <input type="text" id="start" name="start" class="form-control form-control-solid" value="{{date('Y-m-01')}}">
                                    </div>
                                    <div class="mb-10">
                                        <!--begin::Label-->
                                        <label class="form-label fw-bold">End:</label>
                                        <!--end::Label-->
                                        <input type="text" id="end" name="end" class="form-control form-control-solid" value="{{date('Y-m-d')}}">
                                    </div>
                                    <!--end::Input group-->
                                    <!--begin::Actions-->
                                    <div class="d-flex justify-content-end">
                                        <button type="reset" class="btn btn-sm btn-white btn-active-light-primary me-2" data-kt-menu-dismiss="true">Reset</button>
                                        <button type="button" onclick="load_list(1);" class="btn btn-sm btn-primary" data-kt-menu-dismiss="true">Apply</button>
                                    </div>
                                    <!--end::Actions-->
                                </div>
                            </form>
                            <!--end::Form-->
                        </div>
                        <!--end::Menu 1-->

                        <!--end::Menu-->
                    </div>
                    <!--end::Wrapper-->
                </div>
                <!--end::Actions-->
            </div>
            <!--end::Container-->
        </div>
        <!--end::Toolbar-->
        <!--begin::Post-->
        <div class="post d-flex flex-column-fluid" id="kt_post">
            <!--begin::Container-->
            <div id="kt_content_container" class="container">
                <!--begin::Row-->
                <div class="row gy-5 g-xl-8">
                    <div class="card card-xxl-stretch">
                        <div class="card-body pt-5">
                            <div id="list_result"></div>
                        </div>
                    </div>
                </div>
                <!--end::Row-->
            </div>
            <!--end::Container-->
        </div>
        <!--end::Post-->
    </div>
    <div id="content_input"></div>
    @section('custom_js')
    <script type="text/javascript">
        load_list(1);
        date_end('start');
        date_end('end');
        $('#start').change(function() {
            $('#starts').val(this.value);
        });
        $('#end').change(function() {
            $('#ends').val(this.value);
        });
        $('#st').change(function() {
            $('#sts').val(this.value);
        });
    </script>
    @endsection
</x-office-layout>