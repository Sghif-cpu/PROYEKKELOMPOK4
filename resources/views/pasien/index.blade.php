<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pasien</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body { background: #f8f9fa; }
        .table thead { background: #0d6efd; color:white; }
        .foto-pasien {
            width: 50px; height: 50px;
            object-fit: cover;
            border-radius: 6px; border:1px solid #ccc;
        }
        .card { border-radius:14px; }
        .search-box { max-width: 320px; }
    </style>
</head>
<body>

@include('components.sidebar')

<div class="container py-4" style="margin-left:260px;">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="fw-bold text-primary">Manajemen Data Pasien</h3>
        <a href="{{ route('pasien.create') }}" class="btn btn-primary">+ Tambah Pasien Baru</a>
    </div>

    <!-- Search -->
    <form method="GET" action="{{ route('pasien.index') }}">
        <div class="input-group search-box mb-3">
            <input type="text" name="search" value="{{ request('search') }}"
                   class="form-control" placeholder="Cari nama / No RM / NIK...">
            <button class="btn btn-secondary">Cari</button>
        </div>
    </form>

    <!-- Table -->
    <div class="card shadow-sm">
        <div class="card-body p-0">

            <div class="table-responsive">
                <table class="table table-bordered table-striped mb-0">
                    <thead class="text-center">
                        <tr>
                            <th>Foto</th>
                            <th>No RM</th>
                            <th>Nama</th>
                            <th>NIK</th>
                            <th>Jenis Kelamin</th>
                            <th>Telepon</th>
                            <th width="150">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($pasien as $p)
                            <tr>
                                <td class="text-center">
                                    <img src="{{ $p->foto ? asset('storage/pasien/' . $p->foto) : 'https://via.placeholder.com/50' }}"
                                         class="foto-pasien">
                                </td>

                                <td class="text-center fw-bold">{{ $p->no_rm }}</td>
                                <td>{{ $p->nama }}</td>
                                <td>{{ $p->nik }}</td>
                                <td>{{ $p->jenis_kelamin }}</td>
                                <td>{{ $p->telepon ?? '-' }}</td>

                                <td class="text-center">
                                    <a href="{{ route('pasien.show', $p->id) }}" class="btn btn-info btn-sm">Detail</a>

                                    <a href="{{ route('pasien.edit', $p->id) }}" class="btn btn-warning btn-sm">
                                        Edit
                                    </a>

                                    <button class="btn btn-danger btn-sm" onclick="hapus({{ $p->id }})">
                                        Hapus
                                    </button>
                                </td>
                            </tr>

                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-3 text-muted">
                                    Tidak ada data pasien ditemukan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>

        </div>
    </div>

    <div class="mt-3">
        {{ $pasien->links() }}
    </div>

</div>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
function hapus(id) {
    Swal.fire({
        title: "Hapus Data?",
        text: "Data pasien akan dihapus permanen!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#6c757d",
        confirmButtonText: "Ya, hapus!"
    }).then((result) => {
        if (result.isConfirmed) {

            fetch(`/pasien/${id}`, {
                method: "DELETE",
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                }
            })
            .then(res => res.json())
            .then(data => {
                if (data.status === "success") {
                    Swal.fire("Berhasil!", "Data pasien telah dihapus.", "success")
                        .then(() => location.reload());
                }
            });
        }
    });
}
</script>

</body>
</html>
