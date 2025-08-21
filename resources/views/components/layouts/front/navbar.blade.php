<nav class="main-header navbar navbar-expand-md navbar-light navbar-white">
    <div class="container">
        <a href="{{ route('home') }}" class="navbar-brand">
            <img src="{{ asset('dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo"
                class="brand-image img-circle elevation-3" style="opacity: .8">
            <span class="brand-text font-weight-light">{{ config('app.name') }}</span>
        </a>

        <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse"
            aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse order-3" id="navbarCollapse">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a href="{{ route('home') }}" class="nav-link">Home</a>
                </li>
                <li class="nav-item dropdown">
                    <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false" class="nav-link dropdown-toggle">Kategori</a>
                    <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
                        @php
                            $listKategori = App\Models\KategoriProduk::where('isActive', 1)->get();
                        @endphp
                        @foreach ($listKategori as $item)
                            <a href="/kategori/{{ $item->id }}" class="dropdown-item">{{ $item->nama }} </a>
                        @endforeach
                    </ul>
                </li>
            </ul>

            <!-- SEARCH FORM -->
            <livewire:home-search/>
        </div>

        <!-- Right navbar links -->
        <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('login') }}">
                    <i class="fas fa-door-open"></i> Login
                </a>
            </li>
        </ul>
    </div>
</nav>
