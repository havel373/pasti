<x-user-layout title="Checkout">
    <section id="content">
        <div class="content-wrap">
            <div class="container clearfix">
                <form id="form_checkout">
                    <div class="row col-mb-50 gutter-50">
                        <div id="address_content">
                            <div class="row col-mb-50 gutter-50">
                                <div class="col-lg-6">
                                    <h3>Billing Address</h3>
                                    <div class="row mb-0">
                                        <div class="col-md-6 form-group">
                                            <input type="hidden" name="product_id" value="{{$product->id}}">
                                            <input type="hidden" name="total" value="{{$quantity}}">
                                            <input type="hidden" name="user_id" value="{{Session::get('id')}}">
                                            <label for="billing-form-name">Nama:</label>
                                            <input type="text" name="name" value="{{Session::get('name')}}" class="sm-form-control" />
                                        </div>
                                        <div class="w-100"></div>
                                        <div class="col-md-6 form-group">
                                            <label for="billing-form-email">Email:</label>
                                            <input type="email" name="email" value="{{Session::get('email')}}" class="sm-form-control" />
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label for="billing-form-phone">Nomer Telphone:</label>
                                            <input type="text" name="phone" value="{{Session::get('phone')}}" class="sm-form-control" />
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <div class="product col-12 col-sm-6 col-lg-12">
                                                <div class="grid-inner row g-0">
                                                    <div class="product-image col-lg-12 col-xl-12">
                                                        <a href="#"><img src="{{asset('storage/' . $product->photo)}}" alt="{{$product->name}}"></a>
                                                        <a href="#"><img src="{{asset('storage/' . $product->photo)}}" alt="{{$product->name}}"></a>
                                                    </div>
                                                    <div class="product-desc col-lg-12 col-xl-12 px-lg-12 pt-lg-0">
                                                        <div class="product-title"><h3><a href="#">{{$product->name}}</a></h3></div>
                                                        <div class="product-price">Jumlah {{($quantity)}}</div>
                                                        <div class="product-price">Rp. {{number_format($product->price * $quantity)}}</div>
                                                        @php
                                                            $total = $product->price * $quantity;
                                                        @endphp
                                                        <ul class="iconlist d-none d-xl-block mt-md-3">
                                                            <li><i class="icon-caret-right"></i> {{$product->description}}</li>
                                                            <li><i class="icon-caret-right"></i> Weight : {{$product->weight}} grams</li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <h3>Alamat Pengiriman</h3>
                                    <div class="row mb-0">
                                        <div class="col-12 form-group">
                                            <label for="address">Alamat</label>
                                            <input type="text" id="address" name="address" value="" class="sm-form-control" />
                                        </div>

                                        <div class="col-6 form-group">
                                            <label for="postcode">Postcode</label>
                                            <input type="text" id="postcode" maxlength="6" name="postcode" value="" class="sm-form-control" />
                                        </div>
                                        <div class="col-6 form-group">
                                            <label for="postcode">Courier</label>
                                            <select class="form-control" name="ekspedisi" id="select_ekspedisi">
                                                <option value="">Pilih Courier</option>
                                                <option value="jne">JNE</option>
                                                <option value="lion">Lion Parcel</option>
                                            </select>
                                        </div>
                                        <div class="col-6 form-group">
                                            <label for="postcode">Cost Type</label>
                                            <select class="form-control" name="ongkir" id="select_service">
                                                <option value="">Pilih Subdistrict & Courier Terlebih Dahulu</option>
                                               <option value="20000">Rp. 20000</option>
                                            </select>
                                        </div>
                                        <div class="col-12 form-group">
                                            <label for="notes">Notes <small>*</small></label>
                                            <textarea id="notes" class="sm-form-control" name="notes" rows="6" cols="30"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <button type="button" class="btn btn-primary"onclick="history.back();">Kembali</button>
                                    <button type="button" class="btn btn-primary" onclick="validate_address();">Beli</button>   
                                </div>
                            </div>
                        </div>

                        <div class="w-100"></div>

                        <div class="col-lg-12" id="payment_content">
                            <h4>Cart Totals</h4>
                            <button type="button" class="btn btn-primary"onclick="payment_content('address_content')">Kembali</button>
                            <div class="table-responsive">
                                <table class="table cart">
                                    <tbody>
                                        <tr class="cart_item">
                                            <td class="cart-product-name">
                                                <strong>Shipping</strong>
                                            </td>
                                            <td class="cart-product-name">
                                                <span id="" class="amount">{{number_format(20000)}}</span>
                                            </td>
                                        </tr>
                                        <tr class="cart_item">
                                            <td class="cart-product-name">
                                                <strong>Subtotal</strong>
                                            </td>
                                            <td class="cart-product-name">
                                                <input type="hidden" id="subtotal_input" value="{{$total}}">
                                                <span id="subtotal" class="amount color lead">Rp. <strong>{{number_format($total)}}</strong></span>
                                            </td>
                                        </tr>
                                        <tr class="cart_item">
                                            <td class="cart-product-name">
                                                <strong>Grandtotal</strong>
                                            </td>
                                            <td class="cart-product-name">
                                                <span id="grandtotal" class="amount color lead">Rp. <strong>{{number_format($total + 20000)}}</strong></span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="accordion clearfix">
                                <div class="accordion-header">
                                    <div class="accordion-icon">
                                        <i class="accordion-closed icon-line-minus"></i>
                                        <i class="accordion-open icon-line-check"></i>
                                    </div>
                                    <div class="accordion-title">
                                        Direct Bank Transfer
                                    </div>
                                </div>
                                <div class="accordion-content clearfix">
                                    Harap transfer ke bank BCA<br>
                                    Transfer ke Rekening : xxx-xxx-xxx-xxx<br>
                                    Atas Nama : Nama<br>
                                    Selain no rek diatas, jangan pernah melakukan transfer<br>
                                    Bukti transfer maksimal 1x24 jam
                                </div>
                                <div class="w-100"></div>
                                <input name="photo" type="file" accept="image/*" class="form-control image_picker" data-allowed-file-extensions='[]'>
                            </div>
                            <button id="tombol_checkout" onclick="handle_upload('#tombol_checkout','#form_checkout','{{route('web.checkout.add')}}','POST','Place Order')" class="button button-3d float-end">Place Order</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
    @section('custom_js')
    <script>
        payment_content('address_content');
    </script>
    @endsection
</x-user-layout>
