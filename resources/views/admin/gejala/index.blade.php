<x-app-layout>
	<x-slot name="title">Daftar Gejala</x-slot>
	<x-alert-error></x-alert-error>
	@if(session()->has('success'))
	<x-alert type="success" message="{{ session()->get('success') }}" />
	@endif
	<x-card>
		<x-slot name="option">
			<div class="btn btn-success add">
				<i class="mr-1 fas fa-plus"></i> Tambahkan Gejala
			</div>
		</x-slot>
		<table class="table border table-hover">
			<thead class="text-white bg-primary">
				<th>Kode</th>
				<th>Nama Gejala</th>
				<th>Aksi</th>
			</thead>
			<tbody>
				@forelse($gejala as $row)
				<tr>
					<td><b>{{ $row->kode }}</b></td>
					<td>{{ $row->nama }}</td>
					<td>
						<div class="d-flex justify-content-between">
							<button class="btn btn-primary btn-sm edit" data-id="{{ $row->id }}">
								<i class="fas fa-edit"></i>
							</button>
							<form action="{{ route('admin.gejala.destroy', $row->id) }}" method="post">
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
					<td colspan="3" class="text-center">Tidak Ada Data</td>
				</tr>
				@endforelse
			</tbody>
		</table>
		<div class="mt-2">
			{{ $gejala->links() }}
		</div>
	</x-card>

	<x-modal title="Tambahkan Gejala" id="gejala">
		<form action="{{ route('admin.gejala.store') }}" method="POST">
			@csrf
			<div class="row">
				<div class="col-md-4">
					<div class="form-group">
						<label for="kode">Kode Gejala</label>
						<input type="text" class="form-control border-primary" name="kode">
					</div>
				</div>
				<div class="col-md-8">
					<div class="form-group">
						<label for="nama">Nama Gejala</label>
						<input type="text" class="form-control border-primary" name="nama">
					</div>
				</div>
			</div>
			<div class="mt-2">
				<button type="submit" class="btn btn-primary">Simpan</button>
			</div>
		</form>
	</x-modal>

	<x-modal title="Edit Gejala" id="edit-gejala">
		<form action="{{ route('admin.gejala.update') }}" method="POST">
			@csrf
			<input type="hidden" name="id">
			<div class="row">
				<div class="col-md-4">
					<div class="form-group">
						<label for="kode">Kode Gejala</label>
						<input type="text" class="form-control border-primary" name="kode">
					</div>
				</div>
				<div class="col-md-8">
					<div class="form-group">
						<label for="nama">Nama Gejala</label>
						<input type="text" class="form-control border-primary" name="nama">
					</div>
				</div>
			</div>
			<div class="mt-2">
				<button type="submit" class="btn btn-primary">Simpan</button>
			</div>
		</form>
	</x-modal>

	<x-slot name="script">
		<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
		<script>
			$('.add').click(function() {
				$('#gejala').modal('show')
			})

			$('.delete').click(function(e) {
				e.preventDefault()
				Swal.fire({
				  title: 'Hapus data gejala?',
				  text: "Data yang dihapus tidak dapat dikembalikan!",
				  icon: 'warning',
				  showCancelButton: true,
				  confirmButtonColor: '#d33',
				  cancelButtonColor: '#3085d6',
				  cancelButtonText: 'Batal',
				  confirmButtonText: 'Ya, hapus!'
				}).then((result) => {
				  if (result.isConfirmed) {
				    $(this).parent().submit()
				  }
				})
			})

			$('.edit').click(function() {
				const id = $(this).data('id')

				$.get(`{{ route('admin.gejala.json') }}?id=${id}`, function(res) {
					$('#edit-gejala input[name="id"]').val(res.id)
					$('#edit-gejala input[name="nama"]').val(res.nama)
					$('#edit-gejala input[name="kode"]').val(res.kode)

					$('#edit-gejala').modal('show')
				})
			})
		</script>
	</x-slot>
</x-app-layout>
