<div>
    <div class="navbar-content">
        <ul class="nxl-navbar">
            <li class="nxl-item nxl-caption">
                <label>{{ __('Products Management') }}</label>
            </li>
            <li class="nxl-item nxl-hasmenu">
                <a href="{{ route('dashboard') }}" class="nxl-link">
                    <span class="nxl-micon"><i class="feather-airplay"></i></span>
                    <span class="nxl-mtext">{{ __('Home') }}</span>
                </a>
            </li>

            <li class="nxl-item nxl-hasmenu">
                <a href="{{ route('categories.index') }}" class="nxl-link">
                    <span class="nxl-micon"><img src="{{ asset('assets/images/text.svg') }}" alt="" style="height: 20px;"></span>
                    <span class="nxl-mtext">{{ __('Categories') }}</span>
                </a>
            </li>

            <li class="nxl-item nxl-hasmenu">
                <a href="{{ route('products.index') }}" class="nxl-link">
                    <span class="nxl-micon"><img src="{{ asset('assets/images/product.png') }}" alt="" style="height: 20px;"></span>
                    <span class="nxl-mtext">{{ __('Products') }}</span>
                </a>
            </li>
        </ul>
    </div>
</div>
