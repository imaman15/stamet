<div class="container">

  <!-- Outer Row -->
  <div class="row justify-content-center">

    <div class="col-lg-5">
      <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-0">
          <!-- Nested Row within Card Body -->
          <div class="row">
            <div class="col-lg">
              <div class="p-5">
                <div class="text-center mb-3">
                  <img src="<?= base_url('assets') ?>/img/bmkg.png" alt="BMKG" class="img-fluid" style="width: 6rem; height: 6rem; border-radius: 100%;">
                </div>
                <div class="text-center mb-4">
                  <h5><b><?= strtoupper($title) ?></b></h5>
                </div>
                <hr>
                <?= $this->session->flashdata('message');
                ?>
                <?=
                  form_open(UE_LOGIN, 'class="user"');
                ?>
                <div class="form-group">
                  <input type="text" class="form-control form-control-user" id="email" name="email" placeholder="Email" value="<?= set_value('email') ?>" autofocus>
                  <?= form_error('email') ?>
                </div>
                <div class="form-group">
                  <input type="password" class="form-control form-control-user" id="password" name="password" placeholder="Kata Sandi">
                  <?= form_error('password') ?>
                </div>
                <!-- <div class="form-group mt-3">
                  <?=
                    $captcha // tampilkan recaptcha
                  ?>
                  <?=
                    form_error('g-recaptcha-response')
                  ?>
                </div> -->
                <button type="submit" class="btn btn-info btn-user btn-block">
                  Masuk
                </button>
                </form>
                <hr>
                <div class="copyright text-center small">
                  <span>Copyright &copy; SIPJAMET <?= cr() ?> </span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>

  </div>

</div>