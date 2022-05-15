<!--begin::Toolbar-->
<div class="toolbar" id="kt_toolbar">
    <!--begin::Container-->
    <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
        <!--begin::Page title-->
        <div data-kt-place="true" data-kt-place-mode="prepend" data-kt-place-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}" class="page-title d-flex align-items-center me-3">
            <!--begin::Title-->
            <h1 class="d-flex align-items-center text-dark fw-bolder my-1 fs-3">
                Master
                <!--begin::Separator-->
                <span class="h-20px border-gray-200 border-start ms-3 mx-2"></span>
                <!--end::Separator-->
                <!--begin::Description-->
                <small class="text-muted fs-7 fw-bold my-1 ms-1">Product</small>
                <!--end::Description-->
                <!--begin::Separator-->
                <span class="h-20px border-gray-200 border-start ms-3 mx-2"></span>
                <!--end::Separator-->
                <!--begin::Description-->
                {{-- @if ($product->id)
                <small class="text-muted fs-7 fw-bold my-1 ms-1">Update</small>
                <span class="h-20px border-gray-200 border-start ms-3 mx-2"></span>
                <small class="text-muted fs-7 fw-bold my-1 ms-1">{{$product->titles}}</small>
                @else
                <small class="text-muted fs-7 fw-bold my-1 ms-1">Create</small>
                @endif --}}
                <!--end::Description-->
            </h1>
            <!--end::Title-->
        </div>
        <!--end::Page title-->
        <!--begin::Actions-->
        <div class="d-flex align-items-center py-1">
            <!--begin::Button-->
            <a href="javascript:;" onclick="load_list(1);" class="btn btn-sm btn-primary">
                Back
            </a>
            <!--end::Button-->
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
        <!--begin::Layout-->
        <div class="d-flex flex-column flex-lg-row">
            <!--begin::Content-->
            <div class="flex-lg-row-fluid mb-10 mb-lg-0 me-lg-7 me-xl-10">
                <!--begin::Card-->
                <div class="card">
                    <!--begin::Card body-->
                    <div class="card-body p-12">
                        <!--begin::Form-->
                        <form id="form_input">
                            <!--begin::Wrapper-->
                            <div class="mb-0">
                                <!--begin::Row-->
                                <div class="row gx-12 mb-5">
                                    <!--begin::Col-->
                                    {{-- <div class="col-lg-12">
                                        <label class="form-label fs-6 fw-bolder text-gray-700 mb-3">Product Category</label>
                                        <div class="mb-5">
                                            <select id="categories_id" name="categories_id" class="form-control form-control-solid">
                                                <option SELECTED DISABLED>Choose Category</option>
                                                @foreach ($category as $item)
                                                <option value="{{$item->id}}" {{ ($product->categories_id == $item->id ? 'selected="selected"' : '') }}>{{$item->titles}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div> --}}
                                </div>
                                <div class="row gx-12 mb-5">
                                    <!--begin::Col-->
                                    <div class="col-lg-12">
                                        <label class="form-label fs-6 fw-bolder text-gray-700 mb-3">Product Name & Description</label>
                                        <!--begin::Input group-->
                                        <div class="mb-5">
                                            <input type="hidden" name="id" id="id" value="{{$product->id}}">
                                            <input type="text" id="name" name="name" class="form-control form-control-solid" placeholder="Name" value="{{$product->name}}"/>
                                        </div>
                                        <div class="mb-5">
                                            <input type="text" id="weight" name="weight" class="form-control form-control-solid" placeholder="berat" value="{{$product->weight}}"/>
                                        </div>
                                        <div class="mb-5">
                                            <textarea id="description" name="description" class="form-control form-control-solid" placeholder="Description">{{$product->description}}</textarea>
                                        </div>
                                        <!--end::Input group-->
                                    </div>
                                </div>
                                <div class="row gx-12 mb-5">
                                    <!--begin::Col-->
                                    <div class="col-lg-6">
                                        <label class="form-label fs-6 fw-bolder text-gray-700 mb-3">Price</label>
                                        <!--begin::Input group-->
                                        <div class="mb-5">
                                            <input type="tel" maxlength="19" id="price" name="price" class="form-control form-control-solid" placeholder="Price" value="{{number_format($product->price)}}" />
                                        </div>
                                        <!--end::Input group-->
                                    </div>
                                    <div class="col-lg-6">
                                        <label class="form-label fs-6 fw-bolder text-gray-700 mb-3">Stock</label>
                                        <!--begin::Input group-->
                                        <div class="mb-5">
                                            <input type="tel" maxlength="5" id="stock" name="stock" class="form-control form-control-solid" placeholder="Stock"  value="{{number_format($product->stock)}}"/>
                                        </div>
                                        <!--end::Input group-->
                                    </div>
                                    <div class="col-lg-12">
                                        <label class="form-label fs-6 fw-bolder text-gray-700 mb-3">Photo</label>
                                        <input type="hidden" name="photo2" value="{{$product->photo}}">
                                        <!--begin::Input group-->
                                        <div class="mb-5">
                                            <input type="file" name="photo" accept=".png, .jpg, .jpeg" class="form-control form-control-solid" placeholder="Photo" />
                                        </div>
                                        <!--end::Input group-->
                                    </div>
                                    <!--end::Col-->
                                </div>
                                <!--end::Row-->
                                <!--begin::Button-->
                                <div class="mb-0">
                                    <button id="tombol_simpan" onclick="handle_upload('#tombol_simpan','#form_input','{{route('office.product.update',$product->id)}}','PATCH');" class="btn btn-light-primary">Save</button>
                                </div>
                                <!--end::Button-->
                            </div>
                            <!--end::Wrapper-->
                        </form>
                        <!--end::Form-->
                    </div>
                    <!--end::Card body-->
                </div>
                <!--end::Card-->
            </div>
            <!--end::Content-->
        </div>
        <!--end::Layout-->
    </div>
    <!--end::Container-->
</div>
<!--end::Post-->
<script type="text/javascript">
    $(document).ready(function() {
        $('#description').summernote();
    });
    // summernote('description');
    number_only('price');
    ribuan('price');
    number_only('stock');
    ribuan('stock');
    number_only('weight');
</script>