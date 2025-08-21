<div class="card card-widget widget-user">
    <div class="widget-user-header bg-info">
        <h3 class="widget-user-username">{{ $name }}</h3>
        <h5 class="widget-user-desc">{{ $role }}</h5>
    </div>
    <div class="widget-user-image">
        @if ($photo)
        <img class="img-circle elevation-2" src="{{ asset('storage/'.$photo) }}" alt="User Avatar">
        @else
        <img class="img-circle elevation-2" src="{{ asset('dist/img/user1-128x128.jpg') }}" alt="User Avatar">
        @endif
    </div>
    <div class="card-footer">
        <div class="row">
            <div class="col-sm-4 border-right">
                <div class="description-block">
                    <h5 class="description-header">{{ $jmlSales }}</h5>
                    <span class="description-text">{{ strtoupper($sales) }}</span>
                </div>
            </div>
            <div class="col-sm-4 border-right">
                <div class="description-block">
                    <h5 class="description-header">{{ $jmlSales }}</h5>
                    <span class="description-text">{{ strtoupper($sales) }}</span>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="description-block">
                    <h5 class="description-header">{{ $jmlSales }}</h5>
                    <span class="description-text">{{ strtoupper($sales) }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
