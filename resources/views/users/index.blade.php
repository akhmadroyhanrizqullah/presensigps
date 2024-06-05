@extends('layouts.admin.tabler')
@section('content')
    <!-- Page header -->
    <div class="page-header d-print-none">
        <div class="container-xl">
          <div class="row g-2 align-items-center">
            <div class="col">
              <!-- Page pre-title -->
              <h2 class="page-title">
                Data Users
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

                        <a href="#" class="btn btn-primary" id="btnTambahUser">
                            <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-plus"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14" /><path d="M5 12l14 0" /></svg>
                            Tambah Data</a>
                    </div>
                        <div class="row mt-2">
                            <div class="col-12">
                                <form action="/konfigurasi/users" method="GET">
                                    <div class="row">
                                        <div class="col-10">
                                            <div class="form-group">
                                                <input type="text" name="name" id="name" class="form-control" placeholder="Nama Users" value="{{Request('name')}}">
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
                                            <th>Nama</th>
                                            <th>Email</th>
                                            <th>Departemen</th>
                                            <th>Role</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($users as $d )
                                            <tr>
                                                <td>{{$loop->iteration}}</td>
                                                <td>{{$d->name}}</td>
                                                <td>{{$d->email}}</td>
                                                <td>{{$d->nama_dept}}</td>
                                                <td>{{$d->role}}</td>

                                                <td>
                                                    <div class="btn-group">
                                                        <button href="#" class="edit btn btn-info btn-sm" id_user="{{$d->id}}">
                                                            <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-pencil-cog"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 20h4l10.5 -10.5a2.828 2.828 0 1 0 -4 -4l-10.5 10.5v4" /><path d="M13.5 6.5l4 4" /><path d="M19.001 19m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" /><path d="M19.001 15.5v1.5" /><path d="M19.001 21v1.5" /><path d="M22.032 17.25l-1.299 .75" /><path d="M17.27 20l-1.3 .75" /><path d="M15.97 17.25l1.3 .75" /><path d="M20.733 20l1.3 .75" /></svg>
                                                        </button>

                                                        <form action="/konfigurasi/users/{{ $d->id }}/delete" method="POST" style="margin-left: 5px">
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
                {{-- modal input --}}
                <div class="modal modal-blur fade" id="modal-inputuser" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title">Tambah Data User</h5>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                          <form action="/konfigurasi/users/store" method="POST" id="frmUser">
                              @csrf
                              <div class="row">
                                  <div class="col-12">
                                      <div class="mb-3">
                                          <div class="input-icon mb-3">
                                            <span class="input-icon-addon">
                                              <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                                              <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-writing"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M20 17v-12c0 -1.121 -.879 -2 -2 -2s-2 .879 -2 2v12l2 2l2 -2z" /><path d="M16 7h4" /><path d="M18 19h-13a2 2 0 1 1 0 -4h4a2 2 0 1 0 0 -4h-3" /></svg>
                                          </span>
                                            <input type="text" value="" class="form-control" id="nama_user" name="nama_user" placeholder="Nama User">
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
                                            <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-mail"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 7a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v10a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-10z" /><path d="M3 7l9 6l9 -6" /></svg>
                                        </span>
                                          <input type="text" value="" class="form-control" id="email" name="email" placeholder="Email">
                                        </div>
                                      </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <select name="kode_dept" id="kode_dept" class="form-select">
                                            <option value="">Departemen</option>
                                            @foreach ($departemen as $d)
                                                <option value="{{$d->kode_dept}}">{{$d->nama_dept}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-1">
                                <div class="col-12">
                                    <div class="form-group">
                                        <select name="role" id="role" class="form-select">
                                            <option value="">Role</option>
                                            @foreach ($role as $d)
                                                <option value="{{$d->name}}">{{ucwords($d->name)}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-1">
                                <div class="col-12">
                                    <div class="mb-3">
                                        <div class="input-icon mb-3">
                                          <span class="input-icon-addon">
                                            <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                                            <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-key"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M16.555 3.843l3.602 3.602a2.877 2.877 0 0 1 0 4.069l-2.643 2.643a2.877 2.877 0 0 1 -4.069 0l-.301 -.301l-6.558 6.558a2 2 0 0 1 -1.239 .578l-.175 .008h-1.172a1 1 0 0 1 -.993 -.883l-.007 -.117v-1.172a2 2 0 0 1 .467 -1.284l.119 -.13l.414 -.414h2v-2h2v-2l2.144 -2.144l-.301 -.301a2.877 2.877 0 0 1 0 -4.069l2.643 -2.643a2.877 2.877 0 0 1 4.069 0z" /><path d="M15 9h.01" /></svg>
                                        </span>
                                          <input type="password" value="" class="form-control" id="password" name="password" placeholder="Password">
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
    <div class="modal modal-blur fade" id="modal-edituser" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Edit Data User</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="loadedituser">

            </div>
          </div>
        </div>
      </div>
@endsection
@push('myscript')
    <script>

    $(function(){
    $("#btnTambahUser").click(function(){
        $("#modal-inputuser").modal("show");
        });

        $(".edit").click(function(){
            var id_user=$(this).attr('id_user');
            $.ajax({
                type:'POST',
                url:'/konfigurasi/users/edit',
                cache:false,
                data:{
                    _token:" {{ csrf_token(); }}",
                    id_user:id_user
                },
                success:function(respond){
                    $("#loadedituser").html(respond);
                }
            });
            $("#modal-edituser").modal("show");
        });

        $("#frmUser").submit(function(){
        var nama_user = $("#nama_user").val();
        var email = $("#email").val();
        var kode_dept = $("#kode_dept").val();
        var role = $("#role").val();

        if(nama_user==""){
        Swal.fire({
                 title: 'Warning!',
                  text: 'Nama harus diisi',
                    icon: 'warning',
                 confirmButtonText: 'Ok'
                }).then((result)=>{
                    $("#nama_user").focus();

                });
                return false;
            }else if(email==""){
        Swal.fire({
                 title: 'Warning!',
                  text: 'Email harus diisi',
                    icon: 'warning',
                 confirmButtonText: 'Ok'
                }).then((result)=>{
                    $("#email").focus();

                });
                return false;
            }else if(kode_dept==""){
        Swal.fire({
                 title: 'Warning!',
                  text: 'Departemen harus diisi',
                    icon: 'warning',
                 confirmButtonText: 'Ok'
                }).then((result)=>{
                    $("#kode_dept").focus();

                });
                return false;
            }else if(role==""){
        Swal.fire({
                 title: 'Warning!',
                  text: 'Role harus diisi',
                    icon: 'warning',
                 confirmButtonText: 'Ok'
                }).then((result)=>{
                    $("#role").focus();

                });
                return false;
            }
        });
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
    </script>
@endpush
