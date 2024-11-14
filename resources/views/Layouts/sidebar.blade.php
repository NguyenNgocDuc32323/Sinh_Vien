<div class="sidebar-content mt-5">
    <div class="row">
        <div class="col-xl-12">
            <div class="filter-main-btn"><button class="filter-btn btn btn-theme"><i class="fa fa-filter"
                        aria-hidden="true"></i> Filter </button></div>
        </div>
        <div class="overlay"></div>
        <div class="collection-filter">
            <div class="collection-filter-block">
                <div class="collection-mobile-back">
                    <span class="filter-back"><i class="fa fa-angle-left" aria-hidden="true"></i> back </span>
                </div>
                <div class="collection-collapse-block">
                    <h3 class="collapse-block-title">Category</h3>
                    <div class="collection-collapse-block-content">
                        <div class="collection-brand-filter">
                            <ul class="category-list">
                                <li><a aria-current="page" href="{{ route('shop') }}" class="router-link-active router-link-exact-active">All products</a></li>
                                @foreach($categories as $category)
                                    <li><a href="{{ route('shop-filter-category', ['category' => $category->name]) }}">{{ $category->name }} Bottles</a></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="collection-filter-block">
                <div class="collection-collapse-block">
                    <h3 class="collapse-block-title">Colors</h3>
                    <div class="collection-collapse-block-content">
                        <form class="collection-brand-filter color-filter" method="get" action="{{ route('shop-filter-color') }}">
                            @csrf
                            @foreach($colors as $color)
                                <div class="custom-control custom-checkbox collection-filter-checkbox p-0">
                                    <input type="checkbox" class="custom-control-input form-check-input" id="{{ $color->name }}" name="colors[]" value="{{ $color->name }}"
                                        {{ in_array($color->name, old('colors', [])) ? 'checked' : '' }}>
                                    <span class="{{ $color->name }}" style="background-color: {{ $color->name }};"></span>
                                    <label class="custom-control-label p-0" for="{{ $color->name }}">{{ ucfirst($color->name) }}</label>
                                </div>
                            @endforeach
                            <div class="custom-control mt-4 text-end">
                                <button type="submit" class="filter">Filter</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="collection-filter-block">
                <div class="collection-collapse-block">
                    <h3 class="collapse-block-title">Sizes</h3>
                    <div class="collection-collapse-block-content">
                        <form class="collection-brand-filter size-filter" method="get" action="{{ route('shop-filter-size') }}">
                            @csrf
                            @foreach($sizes as $size)
                                <div class="custom-control custom-checkbox collection-filter-checkbox p-0">
                                    <input type="checkbox" class="custom-control-input form-check-input" id="{{ $size->name }}" name="sizes[]" value="{{ $size->name }}"
                                        {{ in_array($size->name, old('sizes', [])) ? 'checked' : '' }}>
                                    <label class="custom-control-label p-0" for="{{ $size->name }}">{{ ucfirst($size->name) }}</label>
                                </div>
                            @endforeach
                            <div class="custom-control mt-4 text-end">
                                <button type="submit" class="filter">Filter</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="collection-filter-block">
                <div class="collection-collapse-block border-0">
                    <h3 class="collapse-block-title">Price</h3>
                    <form class="collection-collapse-block-content" action="{{ route('shop-filter-price') }}"
                        method="get">
                        <div class="collection-brand-filter price-range-picker m-0 mt-3 position-relative">
                            <input type="range" min="0" max="200" class="range-slider w-100"
                                id="priceRangeSlider">
                            <input type="hidden" name="price" id="priceRangeValue">
                            <div class="slider-markers">
                                <div class="marker marker-0">0$</div>
                                <div class="marker marker-100">200$</div>
                            </div>
                        </div>
                        <div class="custom-control mt-4 text-end">
                            <button type="submit" class="filter">Filter</button>
                        </div>
                    </form>

                </div>
            </div>
            <div class="theme-card">
                <h5 class="title-border">New Products</h5>
                <div class="new-product">
                    @foreach ($newPrds as $newPrd)
                    <div class="media">
                        <a href="{{route('product-detail',$newPrd->id)}}">
                            <img src="{{asset($newPrd->image[0])}}" alt="Product Image">
                        </a>
                        <div class="media-body">
                            <a href="{{route('product-detail',$newPrd->id)}}">
                                <h6>{{$newPrd->name}}</h6>
                            </a>
                            <p>${{$newPrd->price}}</p>
                            <div class="rating">
                                @php
                                    $rating = round($newPrd->product_reviews, 2);
                                    $fullStars = floor($rating);
                                    $halfStar = $rating - $fullStars >= 0.5;
                                    $emptyStars = 5 - $fullStars - ($halfStar ? 1 : 0);
                                @endphp

                                @for ($i = 0; $i < $fullStars; $i++)
                                    <i class="fas fa-star"></i>
                                @endfor

                                @if ($halfStar)
                                    <i class="fas fa-star-half-alt"></i>
                                @endif

                                @for ($i = 0; $i < $emptyStars; $i++)
                                    <i class="far fa-star"></i>
                                @endfor
                            </div>
                        </div>
                    </div>
                    @endforeach

                </div>

            </div>
            <div class="collection-sidebar-banner mb-3"><a href="{{route('ads')}}">
                    <img src="{{ asset('images/Dashboard/collection_9.jpeg') }}" class="img-fluid"></a>
            </div>
        </div>
    </div>
</div>
@push('custom-scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const collapseBlockTitles = document.querySelectorAll('.collapse-block-title');
            collapseBlockTitles.forEach(title => {
                title.addEventListener('click', function() {
                    const collapseBlock = this.parentElement;
                    collapseBlock.classList.toggle('open');
                });
            })
            const rangeSliders = document.querySelectorAll('.range-slider');
            rangeSliders.forEach(slider => {
                slider.addEventListener('input', function() {
                    this.style.setProperty('--value',
                        `${(this.value - this.min) / (this.max - this.min) * 100}%`);
                });
            });
            const filterBtn = document.querySelector('.filter-main-btn');
            const collectionFilter = document.querySelector('.collection-filter');
            const filterBack = document.querySelector('.filter-back');
            const overlay = document.querySelector('.overlay');
            const body = document.querySelector('body');
            if (filterBtn && collectionFilter && overlay) {
                filterBtn.addEventListener('click', function() {
                    collectionFilter.classList.add('openFilter');
                    overlay.style.display = 'block';
                });

                filterBack.addEventListener('click', function() {
                    collectionFilter.classList.remove('openFilter');
                    overlay.style.display = 'none';
                });

                overlay.addEventListener('click', function() {
                    collectionFilter.classList.remove('openFilter');
                    overlay.style.display = 'none';
                });

                collectionFilter.addEventListener('click', function(event) {
                    event.stopPropagation();
                });
            }
            document.querySelector('.range-slider').addEventListener('input', function() {
                var priceInput = document.getElementById('priceRangeValue').value = this.value;
            });
        });
    </script>
@endpush
