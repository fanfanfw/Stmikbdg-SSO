@extends('layout.main')
@section('content')
<div class="container d-flex gap-3 justify-content-center flex-wrap" id="selectRole">
    @foreach ($urls as $item)
        <div class="card card-role" data-site="{{ $item['url'] }}" style="width: 18em;">
            <div class="card-body text-center">
                <h5 class="fs-6">{{ $item['name'] }}</h5>
            </div>
        </div>
    @endforeach
</div>

{{-- Jarak dengan footer--}}
<div style="margin-top: 75px;"></div>

<script>
    $(document).ready(() => {
        $('.card-role').on('click', (e) => {
            e.preventDefault();

            const target = e.delegateTarget;
            const siteDst = $(target).data('site');
            const url = `/verify?site=${encodeURIComponent(siteDst)}`;

            window.location.href = url;
        })
    });
</script>
@endsection
