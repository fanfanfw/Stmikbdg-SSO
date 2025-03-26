<nav class="navbar bg-primary">
    <div class="container-fluid px-3 py-2">
        <div class="navbar-brand">
            <img src="/images/stmikbdg_logo.png" alt="Logo" width="50" height="auto" class="d-inline-block align-text-top">
            <span class="text-white fw-bold">
                STMIK Bandung
            </span>
        </div>
        @php
            $segment1 = request()->segment(1);
        @endphp
        @if ($segment1 != 'logout' && $segment1 != 'login')
        <div class="button-wrapper d-inline">
            <button class="btn btn-sm btn-outline-light d-flex align-items-center gap-1" id="buttonLogout">
                <i data-feather="log-out" style="width: 1.3em"></i>
                <span>
                    Logout
                </span>
            </button>
        </div>
        @endif
    </div>
</nav>
