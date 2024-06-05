<form action="/konfigurasi/users/{{$user->id}}/update" method="POST" id="frmUser">
    @csrf
    <div class="row">
        <div class="col-12">
            <div class="mb-3">
                <div class="input-icon mb-3">
                  <span class="input-icon-addon">
                    <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                    <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-writing"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M20 17v-12c0 -1.121 -.879 -2 -2 -2s-2 .879 -2 2v12l2 2l2 -2z" /><path d="M16 7h4" /><path d="M18 19h-13a2 2 0 1 1 0 -4h4a2 2 0 1 0 0 -4h-3" /></svg>
                </span>
                  <input type="text" value="{{$user->name}}" class="form-control" id="nama_user" name="nama_user" placeholder="Nama User">
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
                <input type="text" value="{{$user->email}}" class="form-control" id="email" name="email" placeholder="Email">
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
                      <option {{ $user->kode_dept == $d->kode_dept ? 'selected' : ''}} value="{{$d->kode_dept}}">{{$d->nama_dept}}</option>
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
                      <option {{$user->role_id == $d->id ? 'selected':''}} value="{{$d->id}}">{{ucwords($d->name)}}</option>
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
                    Update</button>
            </div>
        </div>
    </div>
</form>
