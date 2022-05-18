<x-user-layout title="About">
    <section id="content">
        <section id="about" class="about">
            <div class="container" data-aos="fade-up">
                @foreach ($collection as $item)
                <div class="row mb-5">
                    <div class="col-lg-6 order-1 order-lg-2" data-aos="fade-left" data-aos-delay="100">
                        <img src="{{asset('storage/' . $item->photo)}}" alt="" width="400" height="250" style="border:0;">
                    </div>
                    <div class="col-lg-6 pt-4 pt-lg-0 order-2 order-lg-1 content">
                        <h2>{{$item->nama}}</h2>
                        <br>
                        <h2><i>{{$item->nim}}</i> </h2>
                        <br>
                        <h3>{{$item->email}}</h3>
                    </div>
                </div> 
              @endforeach        
            </div>
          </section>
    </section>
</x-user-layout>