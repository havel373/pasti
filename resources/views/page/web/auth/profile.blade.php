<x-user-layout title="{{\Session::get('name')}}">
    <section id="content">
        <div class="content-wrap">
            <div class="container clearfix">
                <div id="content_list">
                    <div class="row clearfix">
                        <div class="col-md-12">
                            <img src="{{\Session::get('image')}}" class="alignleft img-circle img-thumbnail my-0" alt="Avatar" style="max-width: 84px;">
                            <div class="heading-block border-0">
                                <h3>{{\Session::get('name')}}</h3>
                                <a href="javascript:;" onclick="load_input('{{route('web.auth.edit',\Session::get('id'))}}');" style="float:right;" class="button button-3d button-rounded button-white button-light">
                                    Edit Profile
                                </a>
                                <span>Your Profile Bio</span>
                            </div>

                            <div class="clear"></div>

                            <div class="row clearfix">

                                <div class="col-lg-12">

                                    <div class="tabs tabs-alt clearfix" id="tabs-profile">

                                        <ul class="tab-nav clearfix">
                                            <li>
                                                <a href="#tab-orders">
                                                    <i class="icon-rss2"></i> My Order
                                                </a>
                                            </li>
                                        </ul>
                                        <div class="tab-container">
                                            <div class="tab-content clearfix" id="tab-orders">
                                                <div id="list_result"></div>
                                            </div>
                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>
                    </div>
                </div>
                <div id="content_input"></div>
            </div>
        </div>
    </section>
    @section('custom_js')
    <script type="text/javascript">
        load_list(1);
    </script>
    @endsection
</x-user-layout>