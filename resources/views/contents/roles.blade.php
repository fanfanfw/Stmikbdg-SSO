@extends('layout.main')
@section('content')
<div class="container d-flex gap-3 justify-content-center flex-wrap" id="selectRole">
    @php
        $setRoles = [];

        foreach ($roles as $role) {
            switch ($role) {
                case 'is_mhs':
                    $setRoles['Mahasiswa'] = [
                        'role' => $role,
                        'img' => '/images/mahasiswa.jpeg'
                    ];
                    break;
                case 'is_dosen':
                    $setRoles['Dosen'] = [
                        'role' => $role,
                        'img' => '/images/dosen.jpeg'
                    ];
                    break;
                case 'is_doswal':
                    $setRoles['Dosen Wali'] = [
                        'role' => $role,
                        'img' => '/images/dosen.jpeg'
                    ];
                    break;
                case 'is_prodi':
                    $setRoles['Prodi'] = [
                        'role' => $role,
                        'img' => '/images/dosen.jpeg'
                    ];
                    break;
                case 'is_admin':
                    $setRoles['Admin'] = [
                        'role' => $role,
                        'img' => '/images/admin.jpeg'
                    ];
                    break;
                case 'is_dev':
                    $setRoles['Developer'] = [
                        'role' => $role,
                        'img' => '/images/developer.jpeg'
                    ];;
                    break;
                case 'is_staff':
                    $setRoles['Staf'] = [
                        'role' => $role,
                        'img' => '/images/staf2.jpeg'
                    ];
                    break;
                case 'is_wk':
                    $setRoles['Wakil Ketua'] = [
                        'role' => $role,
                        'img' => '/images/staf.jpeg'
                    ];
                    break;
                case 'is_pimpinan':
                    $setRoles['Pimpinan'] = [
                        'role' => $role,
                        'img' => '/images/leader.png'
                    ];
                    break;
		        case 'is_dospem':
		            $setRoles['Dosen Pembimbing']=[
			            'role' => $role,
			            'img' => '/images/dosen.jpeg'
		            ];
		            break;
                default:
                    break;
            }
        }
    @endphp

    @foreach ($setRoles as $key => $item)
        <div class="card card-role" style="width: 18rem;" data-role="{{ $item['role'] }}" data-site="{{ $site['url'] }}">
            <div class="image-wrapper">
                <img src="{{ $item['img'] }}" class="card-img-top" alt="Role {{ $key }}">
            </div>
            <div class="card-body text-center">
                <h5 class="card-title fs-6">{{ $key }}</h5>
            </div>
        </div>
    @endforeach
</div>

<script>
    $(document).ready(() => {
        $('.card-role').on('click', (e) => {
            e.preventDefault();

            const target = e.delegateTarget;
            const role = $(target).data('role');
            const siteDst = $(target).data('site');
            const url = `/verify?site=${siteDst}&role=${role}`;

            if (role == 'is_dev') {
                Swal.fire({
                    icon: 'info',
                    text: 'Oops. Maaf, role tersebut belum kami fungsikan.',
                    toast: true,
                    timerProgressBar: true,
                    timer: 3000, // 3 detik,
                    showConfirmButton: false,
                    position: 'top-right'
                });

                return;
            }

            window.location.href = url;
        })
    });
</script>
@endsection
