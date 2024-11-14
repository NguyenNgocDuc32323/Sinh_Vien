<footer class="footer-section mt-100">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-xs-12 text-center footer-logo">
                <img src="https://media.dau.edu.vn/Media/1_TH1057/Images/logo-dhktdn-copy.png" width="70px" height="70px"><br>
                <p class="tentruong">trường đại học kiến trúc đà nẵng</p>
                <p class="tentruong-eng">danang architecture university</p>
            </div>
            <div class="col-md-12 col-sm-12 school-infor">
                <p class="text-black">Địa Chỉ : 566 Núi Thành, P. Hòa Cường Nam, Q. Hải Châu, TP. Đà Nẵng</p>
                <p class="text-black">Đường Dây Nóng : 0816988288</p>
                <p>Copy Right : 2020 TRƯỜNG ĐẠI HỌC KIẾN TRÚC ĐÀ NẴNG</p>
            </div>
            <div class="col-12 footer-top">
                <div class="row contact">
                    <div class="col-md-3 col-6 text-center text-center-mobile p-3">
                        <div class="contact-border-left">
                            <img src="{{asset('images/Dashboard/map-marker-alt.png')}}">
                            <p>
                                <a href="{{route('home')}}">
                                    566 Núi Thành, P. Hòa Cường Nam, Q. Hải Châu, TP. Đà Nẵng
                                </a>
                            </p>
                        </div>
                    </div>
                    <div class="col-md-3 col-6 text-center text-center-mobile p-3">
                        <div class="contact-boder">
                            <img src="{{asset('images/Dashboard/mobile.png')}}">
                            <p>
                                <a href="{{route('home')}}" title="0816988288">
                                    0816988288
                                </a>
                            </p>
                        </div>
                    </div>
                    <div class="col-md-3 col-6 text-center text-center-mobile p-3">
                        <div class="contact-boder">
                            <img src="{{asset('images/Dashboard/envelope.png')}}">
                            <p>
                                <a href="{{route('home')}}" title="info@dau.edu.vn">
                                    info@dau.edu.vn
                                </a>
                            </p>
                        </div>
                    </div>
                    <div class="col-md-3 col-6 text-center text-center-mobile p-3">
                        <div class="contact-boder">
                            <img src="{{asset('images/Dashboard/facebook-f.png')}}">
                            <p>
                                <a href="{{route('home')}}" title="DaihocKientrucDanang">
                                    DaihocKientrucDanang
                                </a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
{{-- slide --}}
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
@vite(['resources/js/app.js'])
@stack('custom-scripts')
@yield('scripts')
{{-- loading --}}
<script>
    window.addEventListener('load', function() {
        const loading = document.querySelector('#loading');
        if (loading) {
            loading.classList.add('loading-hidden');
            loading.addEventListener('transitionend', function() {
                if (loading.parentNode === document.body) {
                    document.body.removeChild(loading);
                }
            });
        }
    });
</script>
</body>

</html>