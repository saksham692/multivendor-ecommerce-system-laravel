@extends('frontend.layouts.main')
@section('page-title', 'Home')
@section('content')
    <!-- Slider -->
    <div id="carouselExampleIndicators" class="carousel slide overflow-hidden" data-ride="carousel"
         style="height:300px;">
        <ol class="carousel-indicators">
            <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
        </ol>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img class="d-block w-100 img-fit" src="{{ asset('assets/frontend/images/slide-01.jpg') }}"
                     alt="First slide">
            </div>
            <div class="carousel-item">
                <img class="d-block w-100 img-fit" src="{{ asset('assets/frontend/images/slide-02.jpg') }}"
                     alt="Second slide">
            </div>
            <div class="carousel-item">
                <img class="d-block w-100 img-fit" src="{{ asset('assets/frontend/images/slide-03.jpg') }}"
                     alt="Third slide">
            </div>
        </div>
        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>

    <!-- Banner Section one -->
    <section class="sec-banner bg0 p-t-80 p-b-50">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="overflow-hidden text-center">
                        <a href="test">
                            <img class="banner-img"
                                 src="https://sp.com/ecommerce-project/public/uploads/media_644ce7818d45e.png" alt="">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- featured categories section one -->
    <section class="container-fluid">
        <div class="pb-3">
            <h3 class="ltext-103 cl5">
                Featured Categories
            </h3>
        </div>
        <div class="row owl-carousel owl-theme mx-auto">
            <div class="">
                <div class="block1 wrap-pic-w">
                    <img src="{{ asset('assets/frontend/images/banner-01.jpg') }}" alt="IMG-BANNER">

                    <a href="product.html"
                       class="block1-txt ab-t-l s-full flex-col-l-sb p-lr-38 p-tb-34 trans-03 respon3">
                        <div class="block1-txt-child1 flex-col-l">
								<span class="block1-name ltext-102 trans-04 p-b-8">
									Women
								</span>

                            <span class="block1-info stext-102 trans-04">
									Spring 2018
								</span>
                        </div>

                        <div class="block1-txt-child2 p-b-4 trans-05">
                            <div class="block1-link stext-101 cl0 trans-09">
                                Shop Now
                            </div>
                        </div>
                    </a>
                </div>
            </div>

            <div class="">
                <div class="block1 wrap-pic-w">
                    <img src="{{ asset('assets/frontend/images/banner-02.jpg') }}" alt="IMG-BANNER">

                    <a href="product.html"
                       class="block1-txt ab-t-l s-full flex-col-l-sb p-lr-38 p-tb-34 trans-03 respon3">
                        <div class="block1-txt-child1 flex-col-l">
								<span class="block1-name ltext-102 trans-04 p-b-8">
									Men
								</span>

                            <span class="block1-info stext-102 trans-04">
									Spring 2018
								</span>
                        </div>

                        <div class="block1-txt-child2 p-b-4 trans-05">
                            <div class="block1-link stext-101 cl0 trans-09">
                                Shop Now
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="">
                <div class="block1 wrap-pic-w">
                    <img src="{{ asset('assets/frontend/images/banner-03.jpg') }}" alt="IMG-BANNER">

                    <a href="product.html"
                       class="block1-txt ab-t-l s-full flex-col-l-sb p-lr-38 p-tb-34 trans-03 respon3">
                        <div class="block1-txt-child1 flex-col-l">
								<span class="block1-name ltext-102 trans-04 p-b-8">
									Accessories
								</span>

                            <span class="block1-info stext-102 trans-04">
									New Trend
								</span>
                        </div>

                        <div class="block1-txt-child2 p-b-4 trans-05">
                            <div class="block1-link stext-101 cl0 trans-09">
                                Shop Now
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="">
                <div class="block1 wrap-pic-w">
                    <img src="{{ asset('assets/frontend/images/banner-03.jpg') }}" alt="IMG-BANNER">

                    <a href="product.html"
                       class="block1-txt ab-t-l s-full flex-col-l-sb p-lr-38 p-tb-34 trans-03 respon3">
                        <div class="block1-txt-child1 flex-col-l">
								<span class="block1-name ltext-102 trans-04 p-b-8">
									Accessories
								</span>

                            <span class="block1-info stext-102 trans-04">
									New Trend
								</span>
                        </div>

                        <div class="block1-txt-child2 p-b-4 trans-05">
                            <div class="block1-link stext-101 cl0 trans-09">
                                Shop Now
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="">
                <div class="block1 wrap-pic-w">
                    <img src="{{ asset('assets/frontend/images/banner-03.jpg') }}" alt="IMG-BANNER">

                    <a href="product.html"
                       class="block1-txt ab-t-l s-full flex-col-l-sb p-lr-38 p-tb-34 trans-03 respon3">
                        <div class="block1-txt-child1 flex-col-l">
								<span class="block1-name ltext-102 trans-04 p-b-8">
									Accessories
								</span>

                            <span class="block1-info stext-102 trans-04">
									New Trend
								</span>
                        </div>

                        <div class="block1-txt-child2 p-b-4 trans-05">
                            <div class="block1-link stext-101 cl0 trans-09">
                                Shop Now
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Banner Section Two -->
    <section class="sec-banner bg0 p-t-80 p-b-50">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-6 col-lg-6">
                    <div class="overflow-hidden text-center">
                        <a href="test">
                            <img class="banner-img"
                                 src="https://sp.com/ecommerce-project/public/uploads/media_644cf177be491.png" alt="">
                        </a>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6">
                    <div class="overflow-hidden text-center">
                        <a href="test">
                            <img class="banner-img"
                                 src="https://sp.com/ecommerce-project/public/uploads/media_644ce7818d45e.png" alt="">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Product -->
    <section class="bg0 p-t-23">
        <div class="container-fluid">
            <div class="p-b-10">
                <h3 class="ltext-103 cl5">
                    Featured Product
                </h3>
            </div>

            <div class="row owl-carousel owl-theme mx-auto">
                <div class="">
                    <div class="product-grid">
                        <div class="product-image">
                            <a href="#" class="image">
                                <img src="{{ asset('assets/frontend/images/product-01.jpg') }}">
                            </a>
                            <span class="product-discount-label">-23%</span>
                            <ul class="product-links">
                                <li><a href="#"><i class="fa fa-search"></i></a></li>
                                <li><a href="#"><i class="fa fa-heart"></i></a></li>
                                <li><a href="#"><i class="fa fa-random"></i></a></li>
                            </ul>
                            <a href="" class="add-to-cart">Add to Cart</a>
                        </div>
                        <div class="product-content">
                            <h3 class="title"><a href="#">Women's Blouse Top</a></h3>
                            <div class="price">$53.55 <span>$68.88</span></div>
                        </div>
                    </div>
                </div>
                <div class="">
                    <div class="product-grid">
                        <div class="product-image">
                            <a href="#" class="image">
                                <img src="{{ asset('assets/frontend/images/product-01.jpg') }}">
                            </a>
                            <ul class="product-links">
                                <li><a href="#"><i class="fa fa-search"></i></a></li>
                                <li><a href="#"><i class="fa fa-heart"></i></a></li>
                                <li><a href="#"><i class="fa fa-random"></i></a></li>
                            </ul>
                            <a href="" class="add-to-cart">Add to Cart</a>
                        </div>
                        <div class="product-content">
                            <h3 class="title"><a href="#">Men's Jacket</a></h3>
                            <div class="price">$75.55</div>
                        </div>
                    </div>
                </div>
                <div class="">
                    <div class="product-grid">
                        <div class="product-image">
                            <a href="#" class="image">
                                <img src="{{ asset('assets/frontend/images/product-01.jpg') }}">
                            </a>
                            <ul class="product-links">
                                <li><a href="#"><i class="fa fa-search"></i></a></li>
                                <li><a href="#"><i class="fa fa-heart"></i></a></li>
                                <li><a href="#"><i class="fa fa-random"></i></a></li>
                            </ul>
                            <a href="" class="add-to-cart">Add to Cart</a>
                        </div>
                        <div class="product-content">
                            <h3 class="title"><a href="#">Men's Jacket</a></h3>
                            <div class="price">$75.55</div>
                        </div>
                    </div>
                </div>
                <div class="">
                    <div class="product-grid">
                        <div class="product-image">
                            <a href="#" class="image">
                                <img src="{{ asset('assets/frontend/images/product-01.jpg') }}">
                            </a>
                            <ul class="product-links">
                                <li><a href="#"><i class="fa fa-search"></i></a></li>
                                <li><a href="#"><i class="fa fa-heart"></i></a></li>
                                <li><a href="#"><i class="fa fa-random"></i></a></li>
                            </ul>
                            <a href="" class="add-to-cart">Add to Cart</a>
                        </div>
                        <div class="product-content">
                            <h3 class="title"><a href="#">Men's Jacket</a></h3>
                            <div class="price">$75.55</div>
                        </div>
                    </div>
                </div>
                <div class="">
                    <div class="product-grid">
                        <div class="product-image">
                            <a href="#" class="image">
                                <img src="{{ asset('assets/frontend/images/product-01.jpg') }}">
                            </a>
                            <ul class="product-links">
                                <li><a href="#"><i class="fa fa-search"></i></a></li>
                                <li><a href="#"><i class="fa fa-heart"></i></a></li>
                                <li><a href="#"><i class="fa fa-random"></i></a></li>
                            </ul>
                            <a href="" class="add-to-cart">Add to Cart</a>
                        </div>
                        <div class="product-content">
                            <h3 class="title"><a href="#">Men's Jacket</a></h3>
                            <div class="price">$75.55</div>
                        </div>
                    </div>
                </div>
                <div class="">
                    <div class="product-grid">
                        <div class="product-image">
                            <a href="#" class="image">
                                <img src="{{ asset('assets/frontend/images/product-01.jpg') }}">
                            </a>
                            <ul class="product-links">
                                <li><a href="#"><i class="fa fa-search"></i></a></li>
                                <li><a href="#"><i class="fa fa-heart"></i></a></li>
                                <li><a href="#"><i class="fa fa-random"></i></a></li>
                            </ul>
                            <a href="" class="add-to-cart">Add to Cart</a>
                        </div>
                        <div class="product-content">
                            <h3 class="title"><a href="#">Men's Jacket</a></h3>
                            <div class="price">$75.55</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Banner Section three -->
    <section class="sec-banner bg0 p-t-80 p-b-50">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="overflow-hidden text-center">
                        <a href="test">
                            <img class="banner-img"
                                 src="https://sp.com/ecommerce-project/public/uploads/media_644ce7818d45e.png" alt="">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Best Selling Product -->
    <section class="bg0 p-t-23">
        <div class="container-fluid">
            <div class="p-b-10">
                <h3 class="ltext-103 cl5">
                    Best Selling
                </h3>
            </div>

            <div class="row owl-carousel owl-theme mx-auto">
                <div class="">
                    <div class="product-grid">
                        <div class="product-image">
                            <a href="#" class="image">
                                <img src="{{ asset('assets/frontend/images/product-01.jpg') }}">
                            </a>
                            <span class="product-discount-label">-23%</span>
                            <ul class="product-links">
                                <li><a href="#"><i class="fa fa-search"></i></a></li>
                                <li><a href="#"><i class="fa fa-heart"></i></a></li>
                                <li><a href="#"><i class="fa fa-random"></i></a></li>
                            </ul>
                            <a href="" class="add-to-cart">Add to Cart</a>
                        </div>
                        <div class="product-content">
                            <h3 class="title"><a href="#">Women's Blouse Top</a></h3>
                            <div class="price">$53.55 <span>$68.88</span></div>
                        </div>
                    </div>
                </div>
                <div class="">
                    <div class="product-grid">
                        <div class="product-image">
                            <a href="#" class="image">
                                <img src="{{ asset('assets/frontend/images/product-01.jpg') }}">
                            </a>
                            <ul class="product-links">
                                <li><a href="#"><i class="fa fa-search"></i></a></li>
                                <li><a href="#"><i class="fa fa-heart"></i></a></li>
                                <li><a href="#"><i class="fa fa-random"></i></a></li>
                            </ul>
                            <a href="" class="add-to-cart">Add to Cart</a>
                        </div>
                        <div class="product-content">
                            <h3 class="title"><a href="#">Men's Jacket</a></h3>
                            <div class="price">$75.55</div>
                        </div>
                    </div>
                </div>
                <div class="">
                    <div class="product-grid">
                        <div class="product-image">
                            <a href="#" class="image">
                                <img src="{{ asset('assets/frontend/images/product-01.jpg') }}">
                            </a>
                            <ul class="product-links">
                                <li><a href="#"><i class="fa fa-search"></i></a></li>
                                <li><a href="#"><i class="fa fa-heart"></i></a></li>
                                <li><a href="#"><i class="fa fa-random"></i></a></li>
                            </ul>
                            <a href="" class="add-to-cart">Add to Cart</a>
                        </div>
                        <div class="product-content">
                            <h3 class="title"><a href="#">Men's Jacket</a></h3>
                            <div class="price">$75.55</div>
                        </div>
                    </div>
                </div>
                <div class="">
                    <div class="product-grid">
                        <div class="product-image">
                            <a href="#" class="image">
                                <img src="{{ asset('assets/frontend/images/product-01.jpg') }}">
                            </a>
                            <ul class="product-links">
                                <li><a href="#"><i class="fa fa-search"></i></a></li>
                                <li><a href="#"><i class="fa fa-heart"></i></a></li>
                                <li><a href="#"><i class="fa fa-random"></i></a></li>
                            </ul>
                            <a href="" class="add-to-cart">Add to Cart</a>
                        </div>
                        <div class="product-content">
                            <h3 class="title"><a href="#">Men's Jacket</a></h3>
                            <div class="price">$75.55</div>
                        </div>
                    </div>
                </div>
                <div class="">
                    <div class="product-grid">
                        <div class="product-image">
                            <a href="#" class="image">
                                <img src="{{ asset('assets/frontend/images/product-01.jpg') }}">
                            </a>
                            <ul class="product-links">
                                <li><a href="#"><i class="fa fa-search"></i></a></li>
                                <li><a href="#"><i class="fa fa-heart"></i></a></li>
                                <li><a href="#"><i class="fa fa-random"></i></a></li>
                            </ul>
                            <a href="" class="add-to-cart">Add to Cart</a>
                        </div>
                        <div class="product-content">
                            <h3 class="title"><a href="#">Men's Jacket</a></h3>
                            <div class="price">$75.55</div>
                        </div>
                    </div>
                </div>
                <div class="">
                    <div class="product-grid">
                        <div class="product-image">
                            <a href="#" class="image">
                                <img src="{{ asset('assets/frontend/images/product-01.jpg') }}">
                            </a>
                            <ul class="product-links">
                                <li><a href="#"><i class="fa fa-search"></i></a></li>
                                <li><a href="#"><i class="fa fa-heart"></i></a></li>
                                <li><a href="#"><i class="fa fa-random"></i></a></li>
                            </ul>
                            <a href="" class="add-to-cart">Add to Cart</a>
                        </div>
                        <div class="product-content">
                            <h3 class="title"><a href="#">Men's Jacket</a></h3>
                            <div class="price">$75.55</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Banner Section Four -->
    <section class="sec-banner bg0 p-t-80 p-b-50">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-6 col-lg-6">
                    <div class="overflow-hidden text-center">
                        <a href="test">
                            <img class="banner-img"
                                 src="https://sp.com/ecommerce-project/public/uploads/media_644cf177be491.png" alt="">
                        </a>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6">
                    <div class="overflow-hidden text-center">
                        <a href="test">
                            <img class="banner-img"
                                 src="https://sp.com/ecommerce-project/public/uploads/media_644ce7818d45e.png" alt="">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Recently Viewed Selling Product -->
    <section class="bg0 p-t-23">
        <div class="container-fluid">
            <div class="p-b-10">
                <h3 class="ltext-103 cl5">
                    Best Selling
                </h3>
            </div>

            <div class="row owl-carousel owl-theme mx-auto">
                <div class="">
                    <div class="product-grid">
                        <div class="product-image">
                            <a href="#" class="image">
                                <img src="{{ asset('assets/frontend/images/product-01.jpg') }}">
                            </a>
                            <span class="product-discount-label">-23%</span>
                            <ul class="product-links">
                                <li><a href="#"><i class="fa fa-search"></i></a></li>
                                <li><a href="#"><i class="fa fa-heart"></i></a></li>
                                <li><a href="#"><i class="fa fa-random"></i></a></li>
                            </ul>
                            <a href="" class="add-to-cart">Add to Cart</a>
                        </div>
                        <div class="product-content">
                            <h3 class="title"><a href="#">Women's Blouse Top</a></h3>
                            <div class="price">$53.55 <span>$68.88</span></div>
                        </div>
                    </div>
                </div>
                <div class="">
                    <div class="product-grid">
                        <div class="product-image">
                            <a href="#" class="image">
                                <img src="{{ asset('assets/frontend/images/product-01.jpg') }}">
                            </a>
                            <ul class="product-links">
                                <li><a href="#"><i class="fa fa-search"></i></a></li>
                                <li><a href="#"><i class="fa fa-heart"></i></a></li>
                                <li><a href="#"><i class="fa fa-random"></i></a></li>
                            </ul>
                            <a href="" class="add-to-cart">Add to Cart</a>
                        </div>
                        <div class="product-content">
                            <h3 class="title"><a href="#">Men's Jacket</a></h3>
                            <div class="price">$75.55</div>
                        </div>
                    </div>
                </div>
                <div class="">
                    <div class="product-grid">
                        <div class="product-image">
                            <a href="#" class="image">
                                <img src="{{ asset('assets/frontend/images/product-01.jpg') }}">
                            </a>
                            <ul class="product-links">
                                <li><a href="#"><i class="fa fa-search"></i></a></li>
                                <li><a href="#"><i class="fa fa-heart"></i></a></li>
                                <li><a href="#"><i class="fa fa-random"></i></a></li>
                            </ul>
                            <a href="" class="add-to-cart">Add to Cart</a>
                        </div>
                        <div class="product-content">
                            <h3 class="title"><a href="#">Men's Jacket</a></h3>
                            <div class="price">$75.55</div>
                        </div>
                    </div>
                </div>
                <div class="">
                    <div class="product-grid">
                        <div class="product-image">
                            <a href="#" class="image">
                                <img src="{{ asset('assets/frontend/images/product-01.jpg') }}">
                            </a>
                            <ul class="product-links">
                                <li><a href="#"><i class="fa fa-search"></i></a></li>
                                <li><a href="#"><i class="fa fa-heart"></i></a></li>
                                <li><a href="#"><i class="fa fa-random"></i></a></li>
                            </ul>
                            <a href="" class="add-to-cart">Add to Cart</a>
                        </div>
                        <div class="product-content">
                            <h3 class="title"><a href="#">Men's Jacket</a></h3>
                            <div class="price">$75.55</div>
                        </div>
                    </div>
                </div>
                <div class="">
                    <div class="product-grid">
                        <div class="product-image">
                            <a href="#" class="image">
                                <img src="{{ asset('assets/frontend/images/product-01.jpg') }}">
                            </a>
                            <ul class="product-links">
                                <li><a href="#"><i class="fa fa-search"></i></a></li>
                                <li><a href="#"><i class="fa fa-heart"></i></a></li>
                                <li><a href="#"><i class="fa fa-random"></i></a></li>
                            </ul>
                            <a href="" class="add-to-cart">Add to Cart</a>
                        </div>
                        <div class="product-content">
                            <h3 class="title"><a href="#">Men's Jacket</a></h3>
                            <div class="price">$75.55</div>
                        </div>
                    </div>
                </div>
                <div class="">
                    <div class="product-grid">
                        <div class="product-image">
                            <a href="#" class="image">
                                <img src="{{ asset('assets/frontend/images/product-01.jpg') }}">
                            </a>
                            <ul class="product-links">
                                <li><a href="#"><i class="fa fa-search"></i></a></li>
                                <li><a href="#"><i class="fa fa-heart"></i></a></li>
                                <li><a href="#"><i class="fa fa-random"></i></a></li>
                            </ul>
                            <a href="" class="add-to-cart">Add to Cart</a>
                        </div>
                        <div class="product-content">
                            <h3 class="title"><a href="#">Men's Jacket</a></h3>
                            <div class="price">$75.55</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@section('modal')
    <!-- Modal1 -->
    <div class="wrap-modal1 js-modal1 p-t-60 p-b-20">
        <div class="overlay-modal1 js-hide-modal1"></div>

        <div class="container-fluid">
            <div class="bg0 p-t-60 p-b-30 p-lr-15-lg how-pos3-parent">
                <button class="how-pos3 hov3 trans-04 js-hide-modal1">
                    <img src="{{ asset('assets/frontend/images/icons/icon-close.png') }}" alt="CLOSE">
                </button>

                <div class="row">
                    <div class="col-md-6 col-lg-7 p-b-30">
                        <div class="p-l-25 p-r-30 p-lr-0-lg">
                            <div class="wrap-slick3 flex-sb flex-w">
                                <div class="wrap-slick3-dots"></div>
                                <div class="wrap-slick3-arrows flex-sb-m flex-w"></div>

                                <div class="slick3 gallery-lb">
                                    <div class="item-slick3"
                                         data-thumb="{{ asset('assets/frontend/images/product-detail-01.jpg') }}">
                                        <div class="wrap-pic-w pos-relative">
                                            <img
                                                src="{{ asset('assets/frontend/images/product-detail-01.jpg') }}"
                                                alt="IMG-PRODUCT">

                                            <a class="flex-c-m size-108 how-pos1 bor0 fs-16 cl10 bg0 hov-btn3 trans-04"
                                               href="{{ asset('assets/frontend/images/product-detail-01.jpg') }}">
                                                <i class="fa fa-expand"></i>
                                            </a>
                                        </div>
                                    </div>

                                    <div class="item-slick3"
                                         data-thumb="{{ asset('assets/frontend/images/product-detail-02.jpg') }}">
                                        <div class="wrap-pic-w pos-relative">
                                            <img
                                                src="{{ asset('assets/frontend/images/product-detail-02.jpg') }}"
                                                alt="IMG-PRODUCT">

                                            <a class="flex-c-m size-108 how-pos1 bor0 fs-16 cl10 bg0 hov-btn3 trans-04"
                                               href="{{ asset('assets/frontend/images/product-detail-02.jpg') }}">
                                                <i class="fa fa-expand"></i>
                                            </a>
                                        </div>
                                    </div>

                                    <div class="item-slick3"
                                         data-thumb="{{ asset('assets/frontend/images/product-detail-03.jpg') }}">
                                        <div class="wrap-pic-w pos-relative">
                                            <img
                                                src="{{ asset('assets/frontend/images/product-detail-03.jpg') }}"
                                                alt="IMG-PRODUCT">

                                            <a class="flex-c-m size-108 how-pos1 bor0 fs-16 cl10 bg0 hov-btn3 trans-04"
                                               href="{{ asset('assets/frontend/images/product-detail-03.jpg') }}">
                                                <i class="fa fa-expand"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-5 p-b-30">
                        <div class="p-r-50 p-t-5 p-lr-0-lg">
                            <h4 class="mtext-105 cl2 js-name-detail p-b-14">
                                Lightweight Jacket
                            </h4>

                            <span class="mtext-106 cl2">
								$58.79
							</span>

                            <p class="stext-102 cl3 p-t-23">
                                Nulla eget sem vitae eros pharetra viverra. Nam vitae luctus ligula. Mauris
                                consequat
                                ornare feugiat.
                            </p>

                            <!--  -->
                            <div class="p-t-33">
                                <div class="flex-w flex-r-m p-b-10">
                                    <div class="size-203 flex-c-m respon6">
                                        Size
                                    </div>

                                    <div class="size-204 respon6-next">
                                        <div class="rs1-select2 bor8 bg0">
                                            <select class="js-select2" name="time">
                                                <option>Choose an option</option>
                                                <option>Size S</option>
                                                <option>Size M</option>
                                                <option>Size L</option>
                                                <option>Size XL</option>
                                            </select>
                                            <div class="dropDownSelect2"></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="flex-w flex-r-m p-b-10">
                                    <div class="size-203 flex-c-m respon6">
                                        Color
                                    </div>

                                    <div class="size-204 respon6-next">
                                        <div class="rs1-select2 bor8 bg0">
                                            <select class="js-select2" name="time">
                                                <option>Choose an option</option>
                                                <option>Red</option>
                                                <option>Blue</option>
                                                <option>White</option>
                                                <option>Grey</option>
                                            </select>
                                            <div class="dropDownSelect2"></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="flex-w flex-r-m p-b-10">
                                    <div class="size-204 flex-w flex-m respon6-next">
                                        <div class="wrap-num-product flex-w m-r-20 m-tb-10">
                                            <div class="btn-num-product-down cl8 hov-btn3 trans-04 flex-c-m">
                                                <i class="fs-16 zmdi zmdi-minus"></i>
                                            </div>

                                            <input class="mtext-104 cl3 txt-center num-product" type="number"
                                                   name="num-product" value="1">

                                            <div class="btn-num-product-up cl8 hov-btn3 trans-04 flex-c-m">
                                                <i class="fs-16 zmdi zmdi-plus"></i>
                                            </div>
                                        </div>

                                        <button
                                            class="flex-c-m stext-101 cl0 size-101 bg1 bor1 hov-btn1 p-lr-15 trans-04 js-addcart-detail">
                                            Add to cart
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!--  -->
                            <div class="flex-w flex-m p-l-100 p-t-40 respon7">
                                <div class="flex-m bor9 p-r-10 m-r-11">
                                    <a href="#"
                                       class="fs-14 cl3 hov-cl1 trans-04 lh-10 p-lr-5 p-tb-2 js-addwish-detail tooltip100"
                                       data-tooltip="Add to Wishlist">
                                        <i class="zmdi zmdi-favorite"></i>
                                    </a>
                                </div>

                                <a href="#"
                                   class="fs-14 cl3 hov-cl1 trans-04 lh-10 p-lr-5 p-tb-2 m-r-8 tooltip100"
                                   data-tooltip="Facebook">
                                    <i class="fa fa-facebook"></i>
                                </a>

                                <a href="#"
                                   class="fs-14 cl3 hov-cl1 trans-04 lh-10 p-lr-5 p-tb-2 m-r-8 tooltip100"
                                   data-tooltip="Twitter">
                                    <i class="fa fa-twitter"></i>
                                </a>

                                <a href="#"
                                   class="fs-14 cl3 hov-cl1 trans-04 lh-10 p-lr-5 p-tb-2 m-r-8 tooltip100"
                                   data-tooltip="Google Plus">
                                    <i class="fa fa-google-plus"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
