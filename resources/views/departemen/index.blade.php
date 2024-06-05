@extends('layouts.admin.tabler')
@section('content')
    <!-- Page header -->
    <div class="page-header d-print-none">
        <div class="container-xl">
          <div class="row g-2 align-items-center">
            <div class="col">
              <!-- Page pre-title -->
              <h2 class="page-title">
                Data Departemen
              </h2>
            </div>

          </div>
        </div>
      </div>
<div class="page-body">
    <div class="container-xl">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                @if (Session::get('success'))
                                    <div class="alert alert-success">
                                       {{Session::get('success')}}
                                    </div>
                                @endif
                                @if (Session::get('warning'))
                                <div class="alert alert-warning">
                                    {{Session::get('warning')}}
                                </div>
                            @endif
                            </div>
                        </div>
                    <div class="col-12">

                        <a href="#" class="btn btn-primary" id="btnTambahDepartemen">
                            <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-plus"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14" /><path d="M5 12l14 0" /></svg>
                            Tambah Data</a>
                    </div>
                        <div class="row mt-2">
                            <div class="col-12">
                                <form action="/departemen" method="GET">
                                    <div class="row">
                                        <div class="col-10">
                                            <div class="form-group">
                                                <input type="text" name="nama_dept" id="nama_dept" class="form-control" placeholder="Nama Departemen" value="{{Request('nama_dept')}}">
                                            </div>
                                        </div>
                                        <div class="col-2">
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-primary">
                                                    <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-search"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" /><path d="M21 21l-6 -6" /></svg>
                                                    Search
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-12">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Kode Dept</th>
                                            <th>Nama Dept</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($departemen as $d )
                                            <tr>
                                                <td>{{ $loop->iteration}}</td>
                                                <td>{{ $d->kode_dept }}</td>
                                                <td>{{ $d->nama_dept }}</td>
                                                <td>
                                                    <div class="btn-group">
                                                        <button href="#" class="edit btn btn-info btn-sm" kode_dept="{{$d->kode_dept}}">
                                                            <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-pencil-cog"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 20h4l10.5 -10.5a2.828 2.828 0 1 0 -4 -4l-10.5 10.5v4" /><path d="M13.5 6.5l4 4" /><path d="M19.001 19m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" /><path d="M19.001 15.5v1.5" /><path d="M19.001 21v1.5" /><path d="M22.032 17.25l-1.299 .75" /><path d="M17.27 20l-1.3 .75" /><path d="M15.97 17.25l1.3 .75" /><path d="M20.733 20l1.3 .75" /></svg>
                                                        </button>

                                                        <form action="/departemen/{{ $d->kode_dept }}/delete" method="POST" style="margin-left: 5px">
                                                        @csrf

                                                        <button href="#" class="delete-confirm btn btn-danger btn-sm" >
                                                            <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-trash"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7l16 0" /><path d="M10 11l0 6" /><path d="M14 11l0 6" /><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" /><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" /></svg>
                                                        </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                            </div>
                            </div>
                        </div>

                </div>
                </div>
            </div>
                    </div>
                </div>

                <div class="modal modal-blur fade" id="modal-simple" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title">Modal title</h5>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                          Lorem ipsum dolor sit amet, consectetur adipisicing elit. Adipisci animi beatae delectus deleniti dolorem eveniet facere fuga iste nemo nesciunt nihil odio perspiciatis, quia quis reprehenderit sit tempora totam unde.
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn me-auto" data-bs-dismiss="modal">Close</button>
                          <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Save changes</button>
                        </div>
                      </div>
                    </div>
                  </div>
    <div class="modal modal-blur fade" id="modal-inputdepartemen" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Tambah Data Departemen</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form action="/departemen/store" method="post" id="frmDepartemen">
                @csrf
                <div class="row">
                    <div class="col-12">
                        <div class="mb-3">
                            <div class="input-icon mb-3">
                              <span class="input-icon-addon">
                                <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                                <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-credit-card"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 5m0 3a3 3 0 0 1 3 -3h12a3 3 0 0 1 3 3v8a3 3 0 0 1 -3 3h-12a3 3 0 0 1 -3 -3z" /><path d="M3 10l18 0" /><path d="M7 15l.01 0" /><path d="M11 15l2 0" /></svg>
                            </span>
                              <input type="text" value="" id="kode_dept" class="form-control" name="kode_dept" placeholder="Kode Departemen">
                            </div>
                          </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="mb-3">
                            <div class="input-icon mb-3">
                              <span class="input-icon-addon">
                                <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                                <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-writing"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M20 17v-12c0 -1.121 -.879 -2 -2 -2s-2 .879 -2 2v12l2 2l2 -2z" /><path d="M16 7h4" /><path d="M18 19h-13a2 2 0 1 1 0 -4h4a2 2 0 1 0 0 -4h-3" /></svg>
                            </span>
                              <input type="text" value="" class="form-control" id="nama_dept" name="nama_dept" placeholder="Nama Departemen">
                            </div>
                          </div>
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="col-12">
                        <div class="dorm-group">
                            <button class="btn btn-primary w-100">
                                <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-device-floppy"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M6 4h10l4 4v10a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2" /><path d="M12 14m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" /><path d="M14 4l0 4l-6 0l0 -4" /></svg>
                                Simpan</button>
                        </div>
                    </div>
                </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    {{-- Modal Edit --}}

    <div class="modal modal-blur fade" id="modal-editdepartemen" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Edit Departemen</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="loadeditform">

            </div>
          </div>
        </div>
      </div>
@endsection

@push('myscript')
<script>
    $(function(){
        $("#btnTambahDepartemen").click(function(){
            $("#modal-inputdepartemen").modal("show");
        });

        $(".edit").click(function(){
            var kode_dept=$(this).attr('kode_dept');
            $.ajax({
                type:'POST',
                url:'/departemen/edit',
                cache:false,
                data:{
                    _token:" {{ csrf_token(); }}",
                    kode_dept:kode_dept
                },
                success:function(respond){
                    $("#loadeditform").html(respond);
                }
            });
            $("#modal-editdepartemen").modal("show");
        });

        $(".delete-confirm").click(function(e){
            var form = $(this).closest('form');
            e.preventDefault();
            Swal.fire({
        title: "Apakah Anda Yakin Data Dihapus?",
         showCancelButton: true,
         confirmButtonText: "Hapus",
        }).then((result) => {
         if (result.isConfirmed) {
           form.submit();
           Swal.fire("Terhapus !", "", "success");
         }
        })
        });

        $("#frmDepartemen").submit(function(){
            var kode_dept = $("#kode_dept").val();
            var nama_dept = $("#nama_dept").val();
            if(kode_dept ==""){
                // alert('Nis harus diisi');
                Swal.fire({
                 title: 'Warning!',
                  text: 'Kode Departemen harus diisi',
                    icon: 'warning',
                 confirmButtonText: 'Ok'
                }).then((result)=>{
                    $("#kode_dept").focus();

                });
                return false;
            }else if(nama_dept ==""){
                // alert('Nis harus diisi');
                Swal.fire({
                 title: 'Warning!',
                  text: 'Nama Departemen harus diisi',
                    icon: 'warning',
                 confirmButtonText: 'Ok'
                }).then((result)=>{
                    $("#nama_dept").focus();

                });
                return false;
            }
        });
    });
</script>
@endpush
