<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>No</th>
            <th>Time</th>
            <th>Item</th>
            <th>Alamat</th>
            <th>Kode Post</th>
            <th>Resi</th>
            <th>Ongkir</th>
            <th>Total</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @php
            $i = 1;
        @endphp
        @foreach ($collection as $item)
        <tr>
            <td>{{$i++}}</td>
            <td>{{$item['created_at']}}</td>
            <td>{{$item['product_id']}}</td>
            <td>{{$item['address']}}</td>
            <td>{{$item['postcode']}}</td>
            <td>{{$item['resi']}}</td>
            <td>{{$item['ongkir']}}</td>
            <td>{{$item['total']}}</td>
            <td>{{$item['status']}}</td>
        </tr>
        {{-- <tr>
            <td>
                <code>{{$item->created_at->diffForHumans()}}</code>
            </td>
            <td>
            @foreach ($item->order_detail as $order_detail)
                <img style="width:10%;" src="{{asset($order_detail->product->image)}}" alt="">
                <span class="float-start;">
                    {{$order_detail->titles}} | {{$order_detail->type}}
                </span>
                <span class="float-end;">
                    Rp. {{number_format($order_detail->price)}} x {{number_format($order_detail->qty)}}
                </span>
                <br>
                @php
                $total += $order_detail->subtotal;
                @endphp
            @endforeach
            </td>
            <td>{{number_format($total)}}</td>
            <td>
                {{$item->st}}
                @if ($item->st == "On the way" || $item->st == "Received")
                <br>
                    Resi :{{$item->resi}}
                @endif
            </td>
            <td>
                @if ($item->st == "Wait for confirmation")
                    <a href="javascript:;" onclick="handle_confirm('{{route('user.order.cancel',$item->id)}}');">Cancel</a>
                @elseif($item->st == "On the way")
                    <a href="javascript:;" onclick="handle_confirm('{{route('user.order.receive',$item->id)}}');">Receive</a>
                @elseif($item->st == "Received")
                    @if ($item->order_rates->count() < 1)
                    <a href="javascript:;" onclick="handle_open_modal('{{route('user.order.review',$item->id)}}','#reviewFormModal','#contentReviewModal');" class="button button-3d m-0 float-end">Review</a>
                    @else
                    Review : {{$item->order_rates->first()->rates}}<br>
                    {{$item->order_rates->first()->review}}
                    @endif
                @endif
            </td>
        </tr> --}}
        @endforeach
        {{die;}}
    </tbody>
</table>
{{-- {{$collection->links()}} --}}