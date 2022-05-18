<table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4">
    <!--begin::Table head-->
    <thead>
        <tr class="fw-bolder text-muted">
            <th class="w-25px">
                No
            </th>
            {{-- <th class="min-w-100px">Customer</th> --}}
            <th class="min-w-150px">Nama</th>
            <th class="min-w-100px">Email</th>
            <th class="min-w-100px">Role</th>
            <th class="min-w-100px">Phone</th>
        </tr>
    </thead>
    <!--end::Table head-->
    <!--begin::Table body-->
    <tbody>
        @if ($collection->count()>0)
            @foreach ($collection as $key => $item)
            <tr>
                <td>
                    {{$key+1}}
                </td>
                <td>
                    <div class="d-flex align-items-center">
                        <div class="d-flex justify-content-start flex-column">
                            <a href="javascript:;" class="text-dark fw-bolder text-hover-primary fs-6">{{$item->name}}</a>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="d-flex align-items-center">
                        <div class="d-flex justify-content-start flex-column">
                            <a href="javascript:;" class="text-dark fw-bolder text-hover-primary fs-6"></a>
                            <span class="text-muted fw-bold text-muted d-block fs-7">{{$item->email}}</span>
                        </div>
                    </div>
                </td>
                <td>
                <div class="d-flex align-items-center">
                        <div class="d-flex justify-content-start flex-column">
                            <span class="text-muted fw-bold text-muted d-block fs-7">{{$item->role}}</span>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="d-flex align-items-center">
                        <div class="d-flex justify-content-start flex-column">
                            <span class="text-muted fw-bold text-muted d-block fs-7">{{$item->phone}}</span>
                        </div>
                    </div>
                </td>
            </tr>
            @endforeach
        @else
        <tr>
            <td colspan="8" class="text-center">
                No Data
            </td>
        </tr>
        @endif
    </tbody>
    <!--end::Table body-->
</table>
{{-- {{$collection->links()}} --}}