@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h2>List Pegawai</h2>
                    <a href="{{ route('pegawai.create') }}" class="btn btn-success float-right">Tambah Pegawai</a>
                </div>

                <div class="card-body">
                    <form action="{{ route('pegawai.index') }}" method="GET" class="mb-3">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="search" placeholder="Cari pegawai..." value="{{ request('search') }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">Cari</button>
                                </div>
                            </div>
                        </div>
                    </form>

                    <table id="pegawai-table" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Posisi</th>
                                <th>Tanggal Lahir</th>
                                <th>Foto</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pegawais as $pegawai)
                            <tr>
                                <td>{{ $pegawai->nama }}</td>
                                <td>{{ $pegawai->posisi }}</td>
                                <td>{{ $pegawai->tanggal_lahir }}</td>
                                <td><img src="{{ asset('images/' . $pegawai->foto) }}" alt="Foto" style="max-width: 100px;"></td>
                                <td>
                                    <a href="{{ route('pegawai.edit', $pegawai->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                    <form action="{{ route('pegawai.destroy', $pegawai->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $pegawais->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#pegawai-table').DataTable({
            "ordering": true,
            "order": [[0, "asc"]], // Default sorting by the first column (index 0) in ascending order
            "columnDefs": [
                { "orderable": true, "targets": [0, 1, 2] }, // Enable sorting on these columns
                { "orderable": false, "targets": [3, 4] } // Disable sorting on these columns
            ],
            "language": {
                "search": "Cari:",
                "lengthMenu": "Tampilkan _MENU_ pegawai per halaman",
                "zeroRecords": "Tidak ada data yang ditemukan",
                "info": "Menampilkan halaman _PAGE_ dari _PAGES_",
                "infoEmpty": "Tidak ada data yang tersedia",
                "infoFiltered": "(difilter dari total _MAX_ data)",
                "paginate": {
                    "first": "Pertama",
                    "last": "Terakhir",
                    "next": "Berikutnya",
                    "previous": "Sebelumnya"
                }
            }
        });

        $('.select2').select2();

        $("#foto").fileinput({
            theme: 'fa',
            showUpload: false,
            showRemove: false,
            browseClass: "btn btn-primary",
            fileType: "any"
        });

        Dropzone.autoDiscover = false;
        var myDropzone = new Dropzone("div#dropzone", { 
            url: "{{ route('pegawai.store') }}",
            paramName: "foto",
            maxFilesize: 2, // MB
            acceptedFiles: ".jpeg,.jpg,.png,.gif",
            dictDefaultMessage: "Tarik dan lepas file foto di sini atau klik untuk memilih",
            addRemoveLinks: true,
            headers: {
                'X-CSRF-Token': "{{ csrf_token() }}"
            },
            init: function() {
                this.on("success", function(file, response) {
                    if (response.status == 'success') {
                        alert('Foto berhasil diunggah');
                    } else {
                        alert('Gagal mengunggah foto');
                    }
                });
            }
        });
    });
</script>
@endpush
