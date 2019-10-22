<div class="container">

  <div class="card o-hidden border-0 shadow-lg my-5 col-lg-5 mx-auto">
    <div class="card-body p-0">
      <!-- Nested Row within Card Body -->
      <div class="row">
        <div class="col-lg">
          <div class="p-5">
            <div class="text-center">
              <h1 class="h4 text-gray-900 mb-2">Lupa kata sandi Anda?</h1>
              <p class="mb-4">Masukkan alamat email Anda di bawah ini dan kami akan mengirimkan Anda tautan untuk mengatur ulang kata sandi Anda!</p>
            </div>
            <form class="user">
              <div class="form-group">
                <input type="email" class="form-control form-control-user" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="Masukkan Alamat Email...">
              </div>
              <a href="login.html" class="btn btn-info btn-user btn-block">
                Atur ulang kata sandi
              </a>
            </form>
            <hr>
            <div class="text-center">
              <a class="small" href="<?= site_url(UE_FOLDER . "/masuk"); ?>">Batal</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

</div>