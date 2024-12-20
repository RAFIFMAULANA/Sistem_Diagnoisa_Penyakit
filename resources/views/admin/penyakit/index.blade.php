<x-app-layout>
	<x-slot name="title">Daftar Penyakit</x-slot>
	<x-alert-error></x-alert-error>
	@if(session()->has('success'))
	<x-alert type="success" message="{{ session()->get('success') }}" />
	@endif
	<x-card>
		<x-slot name="option">
			<button class="btn btn-success add">
				<i class="mr-1 fas fa-plus"></i> Tambahkan Penyakit
			</button>
		</x-slot>
		<table class="table table-striped table-bordered">
			<thead class="thead-dark">
				<tr>
					<th>Kode</th>
					<th>Nama Penyakit</th>
					<th>Penyebab</th>
					<th>Aksi</th>
				</tr>
			</thead>
			<tbody>
				@forelse($penyakit as $row)
				<tr>
					<td><b>{{ $row->kode }}</b></td>
					<td>{{ $row->nama }}</td>
					<td>{{ \Str::limit($row->penyebab, 180) }}</td>
					<td class="text-center">
						<div class="btn-group">
							<button class="btn btn-primary btn-sm edit" data-id="{{ $row->id }}">
								<i class="fas fa-edit"></i>
							</button>
							<form action="{{ route('admin.penyakit.destroy', $row->id) }}" method="post">
								@csrf
								<button type="submit" class="ml-1 btn btn-danger btn-sm delete">
									<i class="fas fa-trash"></i>
								</button>
							</form>
						</div>
					</td>
				</tr>
				@empty
				<tr>
					<td colspan="4" class="text-center">Tidak ada data tersedia</td>
				</tr>
				@endforelse
			</tbody>
		</table>
	</x-card>

	<x-modal title="Tambahkan Penyakit" id="penyakit">
		<form action="{{ route('admin.penyakit.store') }}" method="POST">
			@csrf
			<div class="form-row">
				<div class="form-group col-md-4">
					<label for="kode">Kode Penyakit</label>
					<input type="text" class="form-control" name="kode" id="kode">
				</div>
				<div class="form-group col-md-8">
					<label for="nama">Nama Penyakit</label>
					<input type="text" class="form-control" name="nama" id="nama">
				</div>
			</div>
			<div class="form-group">
				<label for="penyebab">Keterangan Penyebab</label>
				<textarea name="penyebab" id="penyebab" rows="4" class="form-control"></textarea>
			</div>
			<div class="text-right">
				<button type="submit" class="btn btn-primary">Simpan</button>
			</div>
		</form>
	</x-modal>

	<x-modal title="Edit Penyakit" id="edit-penyakit">
		<form action="{{ route('admin.penyakit.update') }}" method="POST">
			@csrf
			<input type="hidden" name="id">
			<div class="form-row">
				<div class="form-group col-md-4">
					<label for="edit-kode">Kode Penyakit</label>
					<input type="text" class="form-control" name="kode" id="edit-kode">
				</div>
				<div class="form-group col-md-8">
					<label for="edit-nama">Nama Penyakit</label>
					<input type="text" class="form-control" name="nama" id="edit-nama">
				</div>
			</div>
			<div class="form-group">
				<label for="edit-penyebab">Keterangan Penyebab</label>
				<textarea name="penyebab" id="edit-penyebab" rows="4" class="form-control"></textarea>
			</div>
			<div class="text-right">
				<button type="submit" class="btn btn-primary">Simpan</button>
			</div>
		</form>
	</x-modal>

	<x-slot name="script">
		<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
		<script>
			$('.add').click(function() {
				$('#penyakit').modal('show');
			});

			$('.delete').click(function(e) {
				e.preventDefault();
				Swal.fire({
					title: 'Hapus data penyakit?',
					text: "Kamu tidak akan bisa mengembalikannya kembali!",
					icon: 'warning',
					showCancelButton: true,
					confirmButtonColor: '#d33',
					cancelButtonColor: '#3085d6',
					cancelButtonText: 'Batal',
					confirmButtonText: 'Ya, hapus!'
				}).then((result) => {
					if (result.isConfirmed) {
						$(this).closest('form').submit();
					}
				});
			});

			$('.edit').click(function() {
				const id = $(this).data('id');

				$.get(`{{ route('admin.penyakit.json') }}?id=${id}`, function(res) {
					$('#edit-penyakit input[name="id"]').val(res.id);
					$('#edit-penyakit input[name="nama"]').val(res.nama);
					$('#edit-penyakit input[name="kode"]').val(res.kode);
					$('#edit-penyakit textarea[name="penyebab"]').val(res.penyebab);

					$('#edit-penyakit').modal('show');
				});
			});
		</script>
	</x-slot>
</x-app-layout>
