<footer class="footer-section mt-100">
    <!-- Section: Social media -->
    <section class="social-media d-flex justify-content-between p-4">
        <!-- Left -->
        <div class="me-5">
            <span>Get connected with us on social networks:</span>
        </div>
        <!-- Right -->
        <div>
            <a href="#"><i class="fab fa-facebook-f"></i></a>
            <a href="#"><i class="fab fa-twitter"></i></a>
            <a href="#"><i class="fab fa-google"></i></a>
            <a href="#"><i class="fab fa-instagram"></i></a>
            <a href="#"><i class="fab fa-linkedin"></i></a>
            <a href="#"><i class="fab fa-github"></i></a>
        </div>
    </section>
    <!-- Section: Links  -->
    <section>
        <div class="container text-center text-md-start mt-5">
            <div class="row mt-3">
                <!-- Grid column -->
                <div class="col-md-3 col-lg-4 col-xl-3 mx-auto footer-title mb-4">
                    <h6>Polysite Company</h6>
                    <hr class="mb-4"/>
                    <p>Polysite Bottle Company offers premium bottles and packaging for cosmetics, food, and pharmaceuticals, focusing on quality and sustainability.</p>
                </div>
                <!-- Grid column -->
                <div class="col-md-2 col-lg-2 col-xl-2 mx-auto footer-title mb-4">
                    <h6>Products</h6>
                    <hr class="mb-4"/>
                    <p><a href="{{route('shop')}}">Shop</a></p>
                    <p><a href="{{ route('shop-filter-category', ['category' => 'PET']) }}">PET Bottles</a></p>
                    <p><a href="{{ route('shop-filter-category', ['category' => 'PP']) }}">PP Bottles</a></p>
                    <p><a href="{{ route('shop-filter-category', ['category' => 'PC']) }}">PC Bottles</a></p>
                </div>
                <!-- Grid column -->
                <div class="col-md-3 col-lg-2 col-xl-2 mx-auto footer-title mb-4">
                    <h6>Pages Links</h6>
                    <hr class="mb-4"/>
                    <p><a href="{{route('home')}}">Home Page</a></p>
                    <p><a href="{{route('shop')}}">Shop</a></p>
                    <p><a href="{{route('blog')}}">Blog</a></p>
                    <p><a href="{{route('contact')}}">Contact Us</a></p>
                    <p><a href="{{route('ads')}}">Ads</a></p>
                </div>
                <!-- Grid column -->
                <div class="col-md-4 col-lg-3 col-xl-3 mx-auto footer-title mb-md-0 mb-4 contact">
                    <h6>Contact Information</h6>
                    <hr class="mb-4"/>
                    <p><i class="fas fa-home mr-3"></i> 185,Doi Can,Ba Dinh,Ha Noi,Viet Nam</p>
                    <p><i class="fas fa-envelope mr-3"></i> polysite@gmail.com</p>
                    <p><i class="fas fa-phone mr-3"></i> + 01 234 567 88</p>
                    <p><i class="fas fa-print mr-3"></i> + 01 234 567 89</p>
                </div>
            </div>
        </div>
    </section>
    <!-- Copyright -->
    <div class="copyright">
        © 2024 Copyright:
        <a href="{{route('contact')}}">polysite.com</a>
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
