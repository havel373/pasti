<x-user-layout title="Home">
    <section id="content">
        <div class="content-wrap">
            <div class="container clearfix">
                <h2>{!!$inspiring!!}</h2>
                <h2 class="text-align: center">New Product</h2>
                <hr>
                <br>
                <div class="row gutter-40 col-mb-80">
                    <!-- Post Content
                    ============================================= -->
                    <div class="postcontent col-lg-12 order-lg-last">

                        <!-- Shop
                        ============================================= -->
                        <div id="shop" class="shop row grid-container gutter-20" data-layout="fitRows">

                            @if($collection->count() > 0)

                            @foreach ($collection as $item)
                                <div class="product col-md-4 col-sm-6 ">
                                    <div class="grid-inner">
                                        <div class="product-image">
                                            <a href="#"><img src="{{asset('storage/' . $item->photo)}}" alt="{{$item->name}}"></a>
                                            <div class="bg-overlay">
                                                <div class="bg-overlay-content align-items-end justify-content-between" data-hover-animate="fadeIn" data-hover-speed="400">
                                                    <a href="{{route('web.product.show',$item->id)}}" class="btn btn-dark me-2"><i class="icon-shopping-cart"></i></a>
                                                </div>
                                                <div class="bg-overlay-bg bg-transparent"></div>
                                            </div>
                                            <div class="product-desc">
                                                <center>
                                                    <div class="product-title">
                                                        <h3><a href="{{route('web.product.show',$item->id)}}">{{$item->name}}</a></h3>
                                                    </div>
                                                </center>
                                                <center>
                                                    <div class="product-price">
                                                        <ins id="default_price">
                                                            Rp. {{number_format($item->price)}} 
                                                        </ins>
                                                    </div>
                                                </center>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                            @else
                                @include('errors.nodata')
                                {{-- @extends('errors.illustrated-layout')

                                @section('title', __('Server Error'))
                                @section('code', '500')
                                @section('message', __('Server Error')) --}}
                            @endif
                        </div><!-- #shop end -->

                    </div><!-- .postcontent end -->

                    <!-- Sidebar
                    ============================================= -->
                    <div class="d-none sidebar col-lg-3">
                        <div class="sidebar-widgets-wrap">

                            {{-- <div class="widget widget-filter-links">

                                <h4>Select Category</h4>
                                <ul class="custom-filter ps-2" data-container="#shop" data-active-class="active-filter">
                                    <li class="widget-filter-reset active-filter"><a href="#" data-filter="*">Clear</a></li>
                                    @php
                                    $kategori = \App\Models\Category::get();
                                    @endphp
                                    @foreach ($kategori as $item)
                                    <li><a href="#" data-filter=".{{$item->slug}}">{{$item->titles}}</a></li>
                                    @endforeach
                                </ul>

                            </div> --}}


                            <div class="widget widget-filter-links d-none">

                                <h4>Sort By</h4>
                                <ul class="shop-sorting ps-2">
                                    <li class="widget-filter-reset active-filter"><a href="#" data-sort-by="original-order">Clear</a></li>
                                    <li><a href="#" data-sort-by="name">Name</a></li>
                                    <li><a href="#" data-sort-by="price_lh">Price: Low to High</a></li>
                                    <li><a href="#" data-sort-by="price_hl">Price: High to Low</a></li>
                                </ul>

                            </div>

                        </div>
                    </div><!-- .sidebar end -->
                </div>

                {{-- <h2 class="text-align: center mt-5">Recomended Product</h2> --}}
                <div class="row gutter-40 col-mb-80">
                    <!-- Post Content
                    ============================================= -->
                    <div class="postcontent col-lg-12 order-lg-last">

                        <!-- Shop
                        ============================================= -->
                        <div id="shop" class="shop row grid-container gutter-20" data-layout="fitRows">
                            {{-- @php
                             $productRecomended = \App\Models\Product::where("recomend","=",'y')->limit(6)->get();
                            @endphp
                            @foreach ($productRecomended as $item)
                            <div class="product col-md-4 col-sm-6 {{$item->category->slug}}">
                                <div class="grid-inner">
                                    <div class="product-image">
                                        <a href="#"><img src="{{$item->image}}" alt="{{$item->titles}}"></a>
                                        <a href="#"><img src="{{$item->image}}" alt="{{$item->titles}}"></a>
                                        <div class="bg-overlay">
                                            <div class="bg-overlay-content align-items-end justify-content-between" data-hover-animate="fadeIn" data-hover-speed="400">
                                                <a href="{{route('web.product.show',$item->slug)}}" class="btn btn-dark me-2"><i class="icon-shopping-cart"></i></a>
                                            </div>
                                            <div class="bg-overlay-bg bg-transparent"></div>
                                        </div>
                                    </div>
                                    <div class="product-desc">
                                        <center>
                                            <div class="product-title">
                                                <h3><a href="#">{{$item->titles}}</a></h3>
                                            </div>
                                        </center>
                                        <center>
                                            <div class="product-price">
                                                <ins id="default_price">
                                                    @if($item->price_s == $item->price_xxl)
                                                    Rp. {{number_format($item->price_s)}}
                                                    @else
                                                    Rp. {{number_format($item->price_s)}} - Rp. {{number_format($item->price_xxl)}}
                                                    @endif
                                                </ins>
                                            </div>
                                        </center>
                                    </div>
                                </div>
                            </div>
                            @endforeach --}}
                        </div><!-- #shop end -->

                    </div><!-- .postcontent end -->
                </div>

                <hr>
                <div class="row align-items-stretch">

                    <div class="col-md-5 col-padding min-vh-75 " style="background: url('{{asset('img/logo.jpg')}}') center center no-repeat; background-size: cover;"></div>

                    <div class="col-md-7 col-padding">
                        <div>
                            <div class="heading-block">
                                <h3>{{config('app.name')}}</h3>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </section>
    @section('custom_js')
    <script>
        jQuery(document).ready(function($) {
            $(window).on('pluginIsotopeReady', function() {
                $('.custom-filter:not(.no-count)').children('li:not(.widget-filter-reset)').each(function() {
                    var element = $(this),
                        elementFilter = element.children('a').attr('data-filter'),
                        elementFilterContainer = element.parents('.custom-filter').attr('data-container');

                    elementFilterCount = Number(jQuery(elementFilterContainer).find(elementFilter).length);

                    element.append('<span>' + elementFilterCount + '</span>');

                });

                $('.shop-sorting li').click(function() {
                    $('.shop-sorting').find('li').removeClass('active-filter');
                    $(this).addClass('active-filter');
                    var sortByValue = $(this).find('a').attr('data-sort-by');
                    $('#shop').isotope({
                        sortBy: sortByValue
                    });
                    return false;
                });
            });
        });
    </script>
    @endsection
</x-user-layout>