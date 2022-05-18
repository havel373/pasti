<table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4">
    <!--begin::Table head-->
    <thead>
        <tr class="fw-bolder text-muted">
            <th class="w-25px">
                No
            </th>
            <th class="min-w-100px">Customer</th>
            <th class="min-w-150px">Address</th>
            <th class="min-w-100px">Item</th>
            <th class="min-w-100px">Status</th>
            <th class="min-w-100px">Total</th>
            <th class="min-w-100px">Tanggal</th>
            <th class="min-w-150px text-end">Actions</th>
        </tr>
    </thead>
    <!--end::Table head-->
    <!--begin::Table body-->
    <tbody>
        @if ($collection->count() > 0)
            @foreach ($collection as $key => $item)
            <tr>
                <td>
                    {{$key+1}}
                </td>
                <td>
                    <div class="d-flex align-items-center">
                        <div class="d-flex justify-content-start flex-column">
                            <a href="javascript:;" class="text-dark fw-bolder text-hover-primary fs-6"></a>
                            <span class="text-muted fw-bold text-muted d-block fs-7">{{$item->user_id}}</span>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="d-flex align-items-center">
                        <div class="d-flex justify-content-start flex-column">
                            <a href="javascript:;" class="text-dark fw-bolder text-hover-primary fs-6"></a>
                            <span class="text-muted fw-bold text-muted d-block fs-7">{{$item->address}}</span>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="d-flex align-items-center">
                        <div class="d-flex justify-content-start flex-column">
                            <a href="javascript:;" class="text-dark fw-bolder text-hover-primary fs-6"></a>
                            <span class="text-muted fw-bold text-muted d-block fs-7">{{$item->product_id}}</span>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="d-flex align-items-center">
                        <div class="d-flex justify-content-start flex-column">
                            <a href="javascript:;" class="text-dark fw-bolder text-hover-primary fs-6"></a>
                            <span class="text-muted fw-bold text-muted d-block fs-7">{{$item->status}}</span>
                        </div>
                    </div>
                </td>
                <td class="text-end">
                    <div class="d-flex align-items-center">
                        <div class="d-flex justify-content-start flex-column">
                            <a href="javascript:;" class="text-dark fw-bolder text-hover-primary fs-6">Rp. {{number_format($item->total)}}</a>
                        </div>
                    </div>
                </td>
                <td class="text-end">
                    <div class="d-flex align-items-center">
                        <div class="d-flex justify-content-start flex-column">
                            <a href="javascript:;" class="text-dark fw-bolder text-hover-primary fs-6"> {{\Carbon\Carbon::parse($item->created_at)->diffForHumans()}}</a>
                        </div>
                    </div>
                </td>
                <td class="text-end">
                    @if ($item->status != "Wait for confirmation")
                        <a 
                        {{-- href="{{route('office.order.invoice', $item->id)}}" --}}
                        >Download Invoice</a>
                    @endif   
                    @if ($item->status == "Wait for confirmation")   
                    <a 
                    {{-- href="{{route('office.order.download',$item->id)}}" target="_blank" --}}
                     class="btn btn-icon btn-light btn-hover-primary btn-sm">
                        <span class="svg-icon svg-icon-md svg-icon-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <rect x="0" y="0" width="24" height="24"/>
                                    <path d="M2,13 C2,12.5 2.5,12 3,12 C3.5,12 4,12.5 4,13 C4,13.3333333 4,15 4,18 C4,19.1045695 4.8954305,20 6,20 L18,20 C19.1045695,20 20,19.1045695 20,18 L20,13 C20,12.4477153 20.4477153,12 21,12 C21.5522847,12 22,12.4477153 22,13 L22,18 C22,20.209139 20.209139,22 18,22 L6,22 C3.790861,22 2,20.209139 2,18 C2,15 2,13.3333333 2,13 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"/>
                                    <rect fill="#000000" opacity="0.3" transform="translate(12.000000, 8.000000) rotate(-180.000000) translate(-12.000000, -8.000000) " x="11" y="1" width="2" height="14" rx="1"/>
                                    <path d="M7.70710678,15.7071068 C7.31658249,16.0976311 6.68341751,16.0976311 6.29289322,15.7071068 C5.90236893,15.3165825 5.90236893,14.6834175 6.29289322,14.2928932 L11.2928932,9.29289322 C11.6689749,8.91681153 12.2736364,8.90091039 12.6689647,9.25670585 L17.6689647,13.7567059 C18.0794748,14.1261649 18.1127532,14.7584547 17.7432941,15.1689647 C17.3738351,15.5794748 16.7415453,15.6127532 16.3310353,15.2432941 L12.0362375,11.3779761 L7.70710678,15.7071068 Z" fill="#000000" fill-rule="nonzero" transform="translate(12.000004, 12.499999) rotate(-180.000000) translate(-12.000004, -12.499999) "/>
                                </g>
                            </svg>
                        </span>
                    </a> 
                    <a  href="javascript:;" onclick="handle_confirm('{{route('office.order.reject',$item->id)}}');"
                     class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm">
                        <span class="svg-icon svg-icon-3">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <g transform="translate(12.000000, 12.000000) rotate(-45.000000) translate(-12.000000, -12.000000) translate(4.000000, 4.000000)" fill="#000000">
                                        <rect x="0" y="7" width="16" height="2" rx="1"/>
                                        <rect opacity="0.3" transform="translate(8.000000, 8.000000) rotate(-270.000000) translate(-8.000000, -8.000000) " x="0" y="7" width="16" height="2" rx="1"/>
                                    </g>
                                </g>
                            </svg>
                        </span>
                    </a>
                    <a 
                    href="javascript:;" onclick="handle_confirm('{{route('office.order.acc',$item->id)}}');" 
                    class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm">
                        <span class="svg-icon svg-icon-3">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <polygon points="0 0 24 0 24 24 0 24"/>
                                    <path d="M6.26193932,17.6476484 C5.90425297,18.0684559 5.27315905,18.1196257 4.85235158,17.7619393 C4.43154411,17.404253 4.38037434,16.773159 4.73806068,16.3523516 L13.2380607,6.35235158 C13.6013618,5.92493855 14.2451015,5.87991302 14.6643638,6.25259068 L19.1643638,10.2525907 C19.5771466,10.6195087 19.6143273,11.2515811 19.2474093,11.6643638 C18.8804913,12.0771466 18.2484189,12.1143273 17.8356362,11.7474093 L14.0997854,8.42665306 L6.26193932,17.6476484 Z" fill="#000000" fill-rule="nonzero" transform="translate(11.999995, 12.000002) rotate(-180.000000) translate(-11.999995, -12.000002) "/>
                                </g>
                            </svg>
                        </span>
                    </a>
                    @elseif($item->status == "Order on process")
                    <a 
                    {{-- href="javascript:;" onclick="load_input('{{route('office.order.edit',$item->id)}}');"  --}}
                    class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
                        <span class="svg-icon svg-icon-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                <path d="M12.2674799,18.2323597 L12.0084872,5.45852451 C12.0004303,5.06114792 12.1504154,4.6768183 12.4255037,4.38993949 L15.0030167,1.70195304 L17.5910752,4.40093695 C17.8599071,4.6812911 18.0095067,5.05499603 18.0083938,5.44341307 L17.9718262,18.2062508 C17.9694575,19.0329966 17.2985816,19.701953 16.4718324,19.701953 L13.7671717,19.701953 C12.9505952,19.701953 12.2840328,19.0487684 12.2674799,18.2323597 Z" fill="#000000" fill-rule="nonzero" transform="translate(14.701953, 10.701953) rotate(-135.000000) translate(-14.701953, -10.701953)" />
                                <path d="M12.9,2 C13.4522847,2 13.9,2.44771525 13.9,3 C13.9,3.55228475 13.4522847,4 12.9,4 L6,4 C4.8954305,4 4,4.8954305 4,6 L4,18 C4,19.1045695 4.8954305,20 6,20 L18,20 C19.1045695,20 20,19.1045695 20,18 L20,13 C20,12.4477153 20.4477153,12 21,12 C21.5522847,12 22,12.4477153 22,13 L22,18 C22,20.209139 20.209139,22 18,22 L6,22 C3.790861,22 2,20.209139 2,18 L2,6 C2,3.790861 3.790861,2 6,2 L12.9,2 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" />
                            </svg>
                        </span>
                    </a>
                    {{-- @elseif($item->st == "Received")
                        @if ($item->order_rates->count() > 0)
                        Review : {{$item->order_rates->first()->rates}}<br>
                        {{$item->order_rates->first()->review}}
                        @endif --}}
                    @endif
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