@extends('layouts.admin.tabler')
@section('content')
    <!-- Page header -->
    <div class="page-header d-print-none">
        <div class="container-xl">
          <div class="row g-2 align-items-center">
            <div class="col">
              <!-- Page pre-title -->
              <h2 class="page-title">
                Data Siswa
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
                    @role('admin','user')
                    <div class="row">
                        <div class="col-12">
                            <a href="#" class="btn btn-primary" id="btnTambahsiswa">
                                <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-plus"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14" /><path d="M5 12l14 0" /></svg>
                                Tambah Data</a>
                        </div>
                    </div>
                    @endrole
                        <div class="row mt-2">
                            <div class="col-12">
                                <form action="/siswa" method="GET">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <input type="text" name="nama_siswa" id="nama_siswa" class="form-control" placeholder="Nama Siswa" value="{{Request('nama_siswa')}}">
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="form-group">
                                                <select name="kode_dept" id="kode_dept" class="form-select">
                                                    <option value="">Departemen</option>
                                                    @foreach ($departemen as $d )
                                                        <option {{Request('kode_dept')==$d->kode_dept ? 'selected' : ''}} value="{{ $d->kode_dept}}">{{$d->nama_dept}}</option>
                                                    @endforeach
                                                </select>
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
                                            <th>NIS</th>
                                            <th>Nama</th>
                                            <th>Jurusan</th>
                                            <th>No.Hp</th>
                                            <th>Foto</th>
                                            <th>Departemen</th>
                                            @role('admin','user')
                                            <th>Aksi</th>
                                            @endrole
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($siswa as $d )
                                        @php
                                            $path= Storage::url('uploads/siswa/'.$d->foto);
                                        @endphp
                                            <tr>
                                                <td>{{$loop->iteration + $siswa->firstItem()-1 }}</td>
                                                <td>{{$d->nis}}</td>
                                                <td>{{$d->nama_lengkap}}</td>
                                                <td>{{$d->jurusan}}</td>
                                                <td>{{$d->no_hp}}</td>
                                                <td>
                                                    @if (empty($d->foto))
                                                    <img src="{{asset('assets/img/nofoto.jpg')}}" class="avatar">
                                                    @else
                                                    <img src="{{url($path)}}" class="avatar">
                                                    @endif

                                                </td>
                                                <td>{{$d->nama_dept}}</td>
                                                @role('admin','user')
                                                <td>

                                                    <div class="btn-group">
                                                        <button href="#" class="edit btn btn-info btn-sm" nis="{{$d->nis}}">
                                                            <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-pencil-cog"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 20h4l10.5 -10.5a2.828 2.828 0 1 0 -4 -4l-10.5 10.5v4" /><path d="M13.5 6.5l4 4" /><path d="M19.001 19m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" /><path d="M19.001 15.5v1.5" /><path d="M19.001 21v1.5" /><path d="M22.032 17.25l-1.299 .75" /><path d="M17.27 20l-1.3 .75" /><path d="M15.97 17.25l1.3 .75" /><path d="M20.733 20l1.3 .75" /></svg>
                                                        </button>

                                                        <form action="/siswa/{{ $d->nis }}/delete" method="POST" style="margin-left: 5px">
                                                        @csrf

                                                        <button href="#" class="delete-confirm btn btn-danger btn-sm" >
                                                            <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-trash"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7l16 0" /><path d="M10 11l0 6" /><path d="M14 11l0 6" /><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" /><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" /></svg>
                                                        </button>
                                                        </form>
                                                    </div>
                                                    @endrole
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                {{$siswa->links('vendor\pagination\bootstrap-5')}}
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
    <div class="modal modal-blur fade" id="modal-inputsiswa" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Tambah Data Siswa</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form action="/siswa/store" method="post" id="frmSiswa" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-12">
                        <div class="mb-3">
                            <div class="input-icon mb-3">
                              <span class="input-icon-addon">
                                <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                                <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-credit-card"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 5m0 3a3 3 0 0 1 3 -3h12a3 3 0 0 1 3 3v8a3 3 0 0 1 -3 3h-12a3 3 0 0 1 -3 -3z" /><path d="M3 10l18 0" /><path d="M7 15l.01 0" /><path d="M11 15l2 0" /></svg>
                            </span>
                              <input type="text" value="" id="nis" class="form-control" name="nis" placeholder="NIS">
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
                              <input type="text" value="" class="form-control" id="nama_lengkap" name="nama_lengkap" placeholder="Nama Lengkap Siswa">
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
                                <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-school"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M22 9l-10 -4l-10 4l10 4l10 -4v6" /><path d="M6 10.6v5.4a6 3 0 0 0 12 0v-5.4" /></svg>
                            </span>
                              <input type="text" value="" class="form-control" id="jurusan" name="jurusan" placeholder="Jurusan Siswa">
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
                                <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-phone"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 4h4l2 5l-2.5 1.5a11 11 0 0 0 5 5l1.5 -2.5l5 2v4a2 2 0 0 1 -2 2a16 16 0 0 1 -15 -15a2 2 0 0 1 2 -2" /></svg>
                            </span>
                              <input type="text" value="" class="form-control" id="no_hp" name="no_hp" placeholder="Nomor Handphone">
                            </div>
                          </div>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-12">
                        <input type="file" name="foto" class="form-control" />
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-12">
                        <select name="kode_dept" id="kode_dept" class="form-select">
                            <option value="">Departemen</option>
                            @foreach ($departemen as $d )
                                <option {{Request('kode_dept')==$d->kode_dept ? 'selected' : ''}} value="{{ $d->kode_dept}}">{{$d->nama_dept}}</option>
                            @endforeach
                        </select>
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

    <div class="modal modal-blur fade" id="modal-editsiswa" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Edit Data Siswa</h5>
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
        $("#btnTambahsiswa").click(function(){
            $("#modal-inputsiswa").modal("show");
        });

        $(".edit").click(function(){
            var nis=$(this).attr('nis');
            $.ajax({
                type:'POST',
                url:'/siswa/edit',
                cache:false,
                data:{
                    _token:" {{ csrf_token(); }}",
                    nis:nis
                },
                success:function(respond){
                    $("#loadeditform").html(respond);
                }
            });
            $("#modal-editsiswa").modal("show");
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

        $("#frmSiswa").submit(function(){
            var nis = $("#nis").val();
            var nama_lengkap = $("#nama_lengkap").val();
            var jurusan = $("#jurusan").val();
            var no_hp = $("#no_hp").val();
            var kode_dept = $("frmSiswa").find$("#kode_dept").val();
            if(nis ==""){
                // alert('Nis harus diisi');
                Swal.fire({
                 title: 'Warning!',
                  text: 'Nis harus diisi',
                    icon: 'warning',
                 confirmButtonText: 'Ok'
                }).then((result)=>{
                    $("#nis").focus();

                });
                return false;
            }else if(nama_lengkap ==""){
                // alert('Nis harus diisi');
                Swal.fire({
                 title: 'Warning!',
                  text: 'Nama Lengkap harus diisi',
                    icon: 'warning',
                 confirmButtonText: 'Ok'
                }).then((result)=>{
                    $("#nama_lengkap").focus();

                });
                return false;
            }else if(jurusan ==""){
                // alert('Nis harus diisi');
                Swal.fire({
                 title: 'Warning!',
                  text: 'Jurusan harus diisi',
                    icon: 'warning',
                 confirmButtonText: 'Ok'
                }).then((result)=>{
                    $("#jurusan").focus();

                });
                return false;
            }else if(no_hp ==""){
                // alert('Nis harus diisi');
                Swal.fire({
                 title: 'Warning!',
                  text: 'Nomor Handphone harus diisi',
                    icon: 'warning',
                 confirmButtonText: 'Ok'
                }).then((result)=>{
                    $("#no_hp").focus();

                });
                return false;
            }else if(kode_dept ==""){
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
            }
        });
    });
</script>
@endpush
