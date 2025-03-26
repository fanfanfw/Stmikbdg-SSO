<div class="hero-wrapper bg-primary bg-gradient w-100 pt-5 text-white" style="min-height: 300px">
    <div class="container mt-4 text-center">
        @if (isset($error))
            <h3>{{ $error }}</h3>
        @endif
        <p>
            {{ $message }}
        </p>
    </div>
</div>
