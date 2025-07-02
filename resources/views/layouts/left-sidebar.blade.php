<!--! ================================================================ !-->
<!--! [Start] Navigation Menu !-->
<!--! ================================================================ !-->
<nav class="nxl-navigation">
    <div class="navbar-wrapper">
        <div class="m-header">
            <a href="#" class="b-brand">
                <!-- Logo -->
                <img src="{{ asset('assets/images/product2.png') }}" style="height:80px" alt="" class="logo logo-lg" />
                <img src="{{ asset('assets/images/product2.png') }}" alt="" class="logo logo-sm" />
            </a>
        </div>
        <div class="navbar-content">
            <ul class="nxl-navbar">
                <li class="nxl-item nxl-caption">
                    <label>Product Management</label>
                </li>
                <li class="nxl-item nxl-hasmenu">
                    <a href="{{ route('dashboard') }}" class="nxl-link">
                        <span class="nxl-micon"><i class="feather-airplay"></i></span>
                        <span class="nxl-mtext">Home</span>
                    </a>
                </li>

                <li class="nxl-item nxl-hasmenu">
                    <a href="{{ route('categories.index') }}" class="nxl-link">
                        <span class="nxl-micon"><img src="{{ asset('assets/images/text.svg') }}" alt="" style="height: 20px;"></span>
                        <span class="nxl-mtext">Categories</span>
                    </a>
                </li>

                <li class="nxl-item nxl-hasmenu">
                    <a href="{{ route('products.index') }}" class="nxl-link">
                        <span class="nxl-micon"><img src="{{ asset('assets/images/product.png') }}" alt="" style="height: 20px;"></span>
                        <span class="nxl-mtext">Products</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<!--! ================================================================ !-->
<!--! [End] Navigation Menu !-->
<!--! ================================================================ !-->