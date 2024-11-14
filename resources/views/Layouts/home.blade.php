@extends('layouts.master')
@section('page_title')
Home
@endsection
@section('content')
<section id="myCarousel" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-indicators">
        @foreach ($slides as $index => $slide)
        <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="{{ $index }}"
            aria-label="Slide {{ $index + 1 }}"
            class="{{ $index === 0 ? 'active' : '' }}"
            aria-current="{{ $index === 0 ? 'true' : 'false' }}">
        </button>
        @endforeach
    </div>
    <div class="carousel-inner">
        @foreach ($slides as $index => $slide)
        <div class="carousel-item {{ $index === 0 ? 'active' : '' }}"
            style="background-image: url({{ asset($slide->images) }});">
            <div class="carousel-caption">
            </div>
        </div>
        @endforeach
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#myCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#myCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</section>
<div class="bg-wellcome">
    <div class="container pt-5 wellcome pb-3">
        <div class="row">
            <div class="col-md-6 col-xs-6">
                <iframe width="100%" height="315" src="https://www.youtube.com/embed/0wSjPqyHj6o?si=yHKGLsTcCUzpuGxB" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen=""></iframe>
            </div>
            <div class="col-md-6 col-xs-6">
                <h4>chào mừng bạn đến với d.a.u</h4>
                <div id="accordion">
                    <div class="card">
                        <div id="headingOne">
                            <button type="button" class="btn btn-link accordion-toggle active-btn" data-target="#collapseOne_1">
                                lịch sử hình thành
                                <i class="fa fa-chevron-right pull-right"></i>
                            </button>
                        </div>
                        <div id="collapseOne_1" class="collapse">
                            <div class="card-body">
                                <p class="tab1 p-2">
                                    Ngày 27 tháng 11 năm 2006, Thủ tướng Chính phủ Nước CHXHCN Việt Nam Nguyễn Tấn Dũng đã ký Quyết định số 270/2006/QĐ-TTg thành lập TRƯỜNG ĐẠI HỌC KIẾN TRÚC ĐÀ NẴNG.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div id="headingTwo">
                            <button type="button" class="btn btn-link accordion-toggle" data-target="#collapseOne_2">
                                Tầm nhìn đến năm 2030
                                <i class="fa fa-chevron-right pull-right"></i>
                            </button>
                        </div>
                        <div id="collapseOne_2" class="collapse">
                            <div class="card-body">
                                <p class="tab1 p-2">
                                    Phát triển thành trường đại học thông minh theo định hướng ứng dụng, là một trong những trường đại học hàng đầu về chuyển đổi số.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div id="headingThree">
                            <button type="button" class="btn btn-link accordion-toggle" data-target="#collapseOne_3">
                                Sứ mệnh
                                <i class="fa fa-chevron-right pull-right"></i>
                            </button>
                        </div>
                        <div id="collapseOne_3" class="collapse">
                            <div class="card-body">
                                <p class="tab1 p-2">
                                    Trường Đại học Kiến trúc Đà Nẵng phát triển thành trường đại học thông minh theo định hướng ứng dụng.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="bg-why">
    <div class="container">
        <h2 class="text-center pt-5">
            vì sao
            <span class="yellow-text">40000</span>
            sinh viên chọn đại học kiến trúc đà nẵng
        </h2>
        <div class="row">
            <div class="col-12 d-flex flex-wrap p-0 pb-2">
                <div class="tag flex-fill m-3 ml-0">
                    <h3><span class="count">5</span> <i class="fa fa-star yellow-text"></i></h3>
                    <p>Đạt chuẩn Quốc gia về kiểm định chất lượng giáo dục</p>
                </div>
                <div class="tag flex-fill m-3 ml-0">
                    <h3><span class="count">18</span> <i class="fa "></i></h3>
                    <p>Ngành đào tạo</p>
                </div>
                <div class="tag flex-fill m-3 ml-0">
                    <h3><span class="count">96</span> <i class="fa "></i>%</h3>
                    <p>Sinh viên có việc làm sau khi tốt nghiệp</p>
                </div>
                <div class="tag flex-fill m-3 ml-0">
                    <h3><span class="count">100</span> <i class="fa "></i>%</h3>
                    <p>Phòng học được trang bị hiện đại</p>
                </div>
                <div class="tag flex-fill m-3 ml-0">
                    <h3><span class="count">400</span> <i class="fa "></i></h3>
                    <p>Giáo sư, Tiến sĩ, Thạc sĩ, Giảng viên chuyên môn</p>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container link-company">
    <h4 class="pt-5 text-left">Đối tác của trường</h4>
    <p class="line text-left"></p>
    <div class="swiper-container">
        <div class="swiper-wrapper">
            <div class="swiper-slide">
                <a href="#">
                    <img src="https://media.dau.edu.vn/Media/1_TH1057/Images/202012/94443364-263302731374680-7434430858565517312-n-20201223024040-e.jpg" alt="Partner 1">
                </a>
            </div>
            <div class="swiper-slide">
                <a href="#">
                    <img src="https://media.dau.edu.vn/Media/1_TH1057/Images/202012/49938665-2157668101228808-8426025201031970816-n-20201223024101-e.png" alt="Partner 2">
                </a>
            </div>
            <div class="swiper-slide">
                <a href="#">
                    <img src="https://media.dau.edu.vn/Media/1_TH1057/Images/tmsgroup1-copy.png" alt="Partner 3">
                </a>
            </div>
            <div class="swiper-slide">
                <a href="#">
                    <img src="https://media.dau.edu.vn/Media/1_TH1057/Images/202012/94490895-567762390524805-7683993197474742272-n-20201223024126-e.jpg" alt="Partner 4">
                </a>
            </div>
            <div class="swiper-slide">
                <a href="#">
                    <img src="https://media.dau.edu.vn/Media/1_TH1057/Images/pic10.png" alt="Partner 5">
                </a>
            </div>
            <div class="swiper-slide">
                <a href="#">
                    <img src="https://media.dau.edu.vn/Media/1_TH1057/Images/202012/94104742-237149387488494-6569489041459249152-n-20201223024150-e.jpg" alt="Partner 6">
                </a>
            </div>
            <div class="swiper-slide">
                <a href="#">
                    <img src="https://media.dau.edu.vn/Media/1_TH1057/Images/94419326-2285527665089084-222480547178348544-n-158x170.jpg" alt="Partner 7">
                </a>
            </div>
            <div class="swiper-slide">
                <a href="#">
                    <img src="https://media.dau.edu.vn/Media/1_TH1057/Images/1200px-02msu-color-158x170.png" alt="Partner 8">
                </a>
            </div>
            <div class="swiper-slide">
                <a href="#">
                    <img src="https://media.dau.edu.vn/Media/1_TH1057/Images/202012/94579138-218327882802936-3205293595758166016-n-20201223024425-e.jpg" alt="Partner 9">
                </a>
            </div>
            <div class="swiper-slide">
                <a href="#">
                    <img src="https://media.dau.edu.vn/Media/1_TH1057/Images/202012/94603764-574984610079383-2406811634438766592-n-20201223024247-e.png" alt="Partner 10">
                </a>
            </div>
        </div>
        <div class="swiper-pagination"></div>
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
    </div>
</div>

@endsection
@push('custom-scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var swiper = new Swiper(".product-slider", {
            loop: true,
            autoplay: {
                delay: 20000,
                disableOnInteraction: false,
            },
            breakpoints: {
                0: {
                    slidesPerView: 1,
                    spaceBetween: 20,
                },
                768: {
                    slidesPerView: 2,
                    spaceBetween: 25,
                },
                1100: {
                    slidesPerView: 3,
                    spaceBetween: 30,
                },
                1400: {
                    slidesPerView: 4,
                    spaceBetween: 30,
                },
            },
        });
    });
    document.addEventListener('DOMContentLoaded', function() {
        var accordionButtons = document.querySelectorAll('.accordion-toggle');
        accordionButtons.forEach(function(button) {
            button.addEventListener('click', function() {
                accordionButtons.forEach(function(btn) {
                    btn.classList.remove('active-btn');
                });
                button.classList.add('active-btn');
                var targetCollapse = document.querySelector(button.getAttribute('data-target'));
                if (targetCollapse.classList.contains('show')) {
                    targetCollapse.classList.remove('show');
                } else {
                    document.querySelectorAll('.collapse').forEach(function(collapse) {
                        collapse.classList.remove('show');
                    });
                    targetCollapse.classList.add('show');
                }
            });
        });
    });
    const swiper = new Swiper('.swiper-container', {
        loop: true,
        slidesPerView: 6,
        spaceBetween: 50,
        centeredSlides: false,
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        breakpoints: {
            1024: {
                slidesPerView: 6, 
            },
            768: {
                slidesPerView: 4, 
            },
            480: {
                slidesPerView: 2,
            }
        }
    });
</script>
@endpush