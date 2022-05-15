<x-user-layout title="{{$product->name}}">
    <section id="page-title">
        <div class="container clearfix">
            <h1>{{$product->name}}</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{route('web.home')}}">Home</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">{{$product->name}}</li>
            </ol>
        </div>
    </section>
    <section id="content">
        <div class="content-wrap">
            <div class="container clearfix">
                <div class="single-product">
                    <div class="product">
                        <div class="row gutter-40">
                            <div class="col-md-5">
                                <!-- Product Single - Gallery ============================================= -->
                                <div class="product-image">
                                    <div class="fslider" data-pagi="false" data-arrows="false" data-thumbs="true">
                                        <div class="flexslider">
                                            <div class="slider-wrap" data-lightbox="gallery">
                                                <div class="slide" data-thumb="{{asset('storage/' . $product->photo)}}">
                                                    <a href="{{asset('storage/' . $product->photo)}}" title="{{$product->name}}" data-lightbox="gallery-item">
                                                        <img src="{{asset('storage/' . $product->photo)}}" alt="{{$product->name}}">
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <!-- Product Single - Gallery End -->
                        </div>
                        <div class="col-md-5 product-desc">
                            <div class="d-flex align-items-center justify-content-between">
                                <!-- Product Single - Price ============================================= -->
                                <div class="product-price">
                                    <ins id="default_price">
                                        Rp. {{number_format($product->price)}}
                                    </ins>
                                </div>
                                <!-- Product Single - Price End -->
                            </div>
                            <div class="line"></div>
                            @if (Session::has('message'))
                                <div class="alert alert-info">{{ Session::get('message') }}</div>
                            @endif
                            <!-- Product Single - Quantity & Cart Button ============================================= -->
                            <form id="form_cart" action="{{route('web.checkout.create', $product->id)}}">
                                @csrf
                                <div class="cart mb-0 d-flex justify-content-between align-items-center">
                                    <div class="quantity clearfix">
                                        <input type="button" value="-" class="minus">
                                        <input type="number" step="1" min="1" name="quantity" value="1" title="Qty" class="qty" />
                                        <input type="button" value="+" class="plus">
                                    </div>
                                    @if(\Session::get('token'))
                                        <button type="submit" id="tambah_keranjang" class="add-to-cart button m-0">Beli</button>
                                    @else
                                        <a href="{{route('web.auth.index')}}" class="add-to-cart button m-0">Beli</a>
                                    @endif
                                </div>
                                <!-- Product Single - Quantity & Cart Button End -->
                                <div class="line"></div>
                                <div class="row align-items-center">
                                    <div class="col-sm-6">
                                        <h5 class="fw-medium mb-3">Stok Tersisa:</h5>
                                    </div>
                                </div>
                                <ins id="stock" style="text-decoration:none; color:red;">Stok : {{number_format($product->stock)}}</ins>
                            </form>
                            <!-- Product Single - Short Description ============================================= -->
                            <!-- Product Single - Short Description End -->
                            <!-- Product Single - Meta ============================================= -->
                            {{-- <div class="card product-meta">
                                <div class="card-body">
                                    <span class="posted_in">Category: <a href="{{route('web.category.show',$product->category->slug)}}" rel="tag">{{$product->category->titles}}</a>.</span>
                                </div>
                            </div> --}}
                            <br>
                            <p>
                                Jika ingin menanyakan sesuatu pada produk atau ingin bertanya kepada pihak {{config('app.name')}} chat melalui about yang berada di atas.
                            </p>
                            <!-- Product Single - Meta End -->
                        </div>
                        {{-- <div class="col-md-2">
                            <a href="{{route('web.category.show',$product->category->slug)}}" title="Brand Logo" class="d-none d-md-block">
                                <img src="{{$product->category->image}}" alt="{{$product->category->titles}}">
                            </a>
                            <div class="divider divider-center"><i class="icon-circle-blank"></i></div>
                            <div class="feature-box fbox-plain fbox-dark fbox-sm">
                                <div class="fbox-icon">
                                    <i class="icon-thumbs-up2"></i>
                                </div>
                                <div class="fbox-content fbox-content-sm">
                                    <h3>100% Original</h3>
                                    <p class="mt-0">We guarantee you the sale of Original Brands.</p>
                                </div>
                            </div>
                        </div> --}}
                        <div class="w-100"></div>
                        {{-- <div class="col-12 mt-5">
                            <div class="tabs clearfix mb-0" id="tab-1">
                                <ul class="tab-nav clearfix">
                                    <li><a href="#tabs-1"><i class="icon-align-justify2"></i><span class="d-none d-md-inline-block"> Description</span></a></li>
                                    <li><a href="#tabs-3"><i class="icon-star3"></i><span class="d-none d-md-inline-block"> Reviews ({{$product->review->count()}})</span></a></li>
                                </ul>
                                <div class="tab-container">
                                    <div class="tab-content clearfix" id="tabs-1">
                                        {!!$product->description!!}
                                    </div>
                                    <div class="tab-content clearfix" id="tabs-2">
                                        <table class="table table-striped table-bordered">
                                            <tbody>
                                                <tr>
                                                    <td>Size</td>
                                                    <td>Small, Medium &amp; Large</td>
                                                </tr>
                                                <tr>
                                                    <td>Color</td>
                                                    <td>Pink &amp; White</td>
                                                </tr>
                                                <tr>
                                                    <td>Waist</td>
                                                    <td>26 cm</td>
                                                </tr>
                                                <tr>
                                                    <td>Length</td>
                                                    <td>40 cm</td>
                                                </tr>
                                                <tr>
                                                    <td>Chest</td>
                                                    <td>33 inches</td>
                                                </tr>
                                                <tr>
                                                    <td>Fabric</td>
                                                    <td>Cotton, Silk &amp; Synthetic</td>
                                                </tr>
                                                <tr>
                                                    <td>Warranty</td>
                                                    <td>3 Months</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="tab-content clearfix" id="tabs-3">
                                        <div id="reviews" class="clearfix">
                                            <ol class="commentlist clearfix">
                                                @foreach ($product->review as $item)
                                                <li class="comment even thread-even depth-1" id="li-comment-1">
                                                    <div class="comment-wrap clearfix">
                                                        <div class="comment-meta">
                                                            <div class="comment-author vcard">
                                                                <span class="comment-avatar clearfix">
                                                                    <img alt='Image' src='https://0.gravatar.com/avatar/ad516503a11cd5ca435acc9bb6523536?s=60' height='60' width='60' /></span>
                                                            </div>
                                                        </div>
                                                        <div class="comment-content clearfix">
                                                            <div class="comment-author">{{$item->user->name}}
                                                                <span>
                                                                    <a href="javascript:;" title="Permalink to this comment">
                                                                        {{$item->created_at->format('j F y')}}
                                                                    </a>
                                                                </span>
                                                            </div>
                                                            <p>
                                                                {{$item->review}}
                                                            </p>
                                                            <div class="review-comment-ratings">
                                                                @if ($item->rates == "1,00")
                                                                <i class="icon-star3"></i>
                                                                @elseif ($item->rates == "2,00")
                                                                <i class="icon-star3"></i>
                                                                <i class="icon-star3"></i>
                                                                @elseif ($item->rates == "3,00")
                                                                <i class="icon-star3"></i>
                                                                <i class="icon-star3"></i>
                                                                <i class="icon-star3"></i>
                                                                @elseif ($item->rates == "4,00")
                                                                <i class="icon-star3"></i>
                                                                <i class="icon-star3"></i>
                                                                <i class="icon-star3"></i>
                                                                <i class="icon-star3"></i>
                                                                @elseif ($item->rates == "5,00")
                                                                <i class="icon-star3"></i>
                                                                <i class="icon-star3"></i>
                                                                <i class="icon-star3"></i>
                                                                <i class="icon-star3"></i>
                                                                <i class="icon-star3"></i>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="clear"></div>
                                                    </div>
                                                </li>
                                                @endforeach
                                            </ol>
                                            <!-- Modal Reviews ============================================= -->
                                            <!-- /.modal -->
                                            <!-- Modal Reviews End -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> --}}
                    </div>
                </div>
            </div>
            <div class="line"></div>
            {{-- {{dd(count($collection))}} --}}
            @if (count($collection) > 0)
            <center>
                <h4>Mungkin anda suka</h4>
            </center>
            <div class="w-100">
                <div class="owl-carousel product-carousel carousel-widget" data-margin="30" data-pagi="false" data-autoplay="5000" data-items-xs="1" data-items-md="2" data-items-lg="3" data-items-xl="4">
                    @foreach ($collection as $item)
                    <div class="oc-item">
                        <div class="product">
                            <div class="product-image">
                                <a href="{{route('web.product.show',$item->id)}}">
                                    <img src="{{asset('storage/' . $item->photo)}}" alt="{{$item->name}}">
                                </a>
                                @if ($item->stock < 1 ) <div class="sale-flash badge bg-secondary p-2">Out of Stock
                            </div>
                            @endif
                            <div class="bg-overlay">
                                <div class="bg-overlay-content align-items-end justify-content-between" data-hover-animate="fadeIn" data-hover-speed="400">
                                    <a href="#" class="btn btn-dark me-2"><i class="icon-shopping-cart"></i></a>
                                </div>
                                <div class="bg-overlay-bg bg-transparent"></div>
                            </div>
                        </div>
                        <div class="product-desc center">
                            <div class="product-title">
                                <h3>
                                    <a href="{{route('web.product.show',$item->id)}}">
                                        {{$item->name}}
                                    </a>
                                </h3>
                            </div>
                            <div class="product-price">
                                <ins id="default_price">
                                    Rp. {{number_format($item->price)}}
                                </ins>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
            @endif
        </div>
        </div>
    </section>
    @section('custom_js')
    <script type="text/javascript">
        load_list(1);
    </script>
    @endsection
</x-user-layout>