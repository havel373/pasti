<x-user-layout title="Checkout">
    <section id="content">
        <div class="content-wrap">
            <div class="container clearfix">
                <form id="form_checkout">
                    <div class="row col-mb-50 gutter-50">

                        <div id="order_content" class="col-lg-12">
                            <h4>Your Orders</h4>
                            @php
                            $total_harga = 0;
                            $berat = 0;
                            @endphp
                            <div class="table-responsive">
                                <table class="table cart">
                                    <thead>
                                        <tr>
                                            <th class="cart-product-thumbnail">&nbsp;</th>
                                            <th class="cart-product-name">Product</th>
                                            <th class="cart-product-quantity">Quantity</th>
                                            <th class="cart-product-subtotal">Total</th>
                                            <th class="cart-product-subtotal">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($collection as $key=> $item)
                                        {{-- @php
                                            $price = "price_".$item->type;
                                            $subtotal = $item->product->$price * $item->qty;
                                            $berat += $item->product->berat * $item->qty;
                                            $total_harga += $item->product->$price * $item->qty;
                                        @endphp --}}

                                        @php
                                            $connection = new \App\Http\Controllers\Connection;
                                            $collection = $connection->produks();
                                            // $collection = json_decode($arr,true);
                                            // dd(gettype($collection));
                                            // $result = $item->product_id;
                                            // $new = $collection->where('id',$result);
                                            // dd($item->product_id);
                                            // $total = $item->total * $new[0]->price;
                                            // dd($arr);
                                        @endphp

                                        <tr class="cart_item">
                                            <td class="cart-product-thumbnail">
                                                <a href="{{route('web.product.show',$item->id)}}">
                                                    <img width="64" height="64" src="{{asset('storage/' . $item->photo)}}" alt="{{$item->product_id}}">
                                                </a>
                                            </td>
                                            
                                            {{-- <td class="cart-product-name">
                                                <a href="{{route('web.product.show',$item->id)}}">{{$collection->where('id',$item->product_id)}}</a>
                                            </td> --}}

                                            <td class="cart-product-quantity">
                                                <div class="quantity clearfix">
                                                    {{number_format($item->total)}}
                                                </div>
                                            </td>

                                            <td class="cart-product-subtotal">
                                                <span class="amount">Rp. </span>
                                            </td>
                                            <td class="cart-product-subtotal">
                                                <span class="amount">{{$item->status}}</span>
                                            </td>
                                        </tr>
                                        @endforeach
                                        {{-- <input type="hidden" name="berat" id="berat" value="{{$berat}}"> --}}
                                    </tbody>
                                </table>
                                {{-- <button type="button" class="btn btn-primary" onclick="payment_content('address_content');">Bayar</button> --}}
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
    @section('custom_js')
    <script>
        payment_content('order_content');
    </script>
    @endsection
</x-user-layout>
