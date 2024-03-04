<?php require_once('../config.php') ?>
<!DOCTYPE html>
<html lang="en" class="" style="height: auto;">
 <?php require_once('inc/header.php') ?>
 
<body class="hold-transition ">
  <script>
    start_loader()
  </script>
  
  <style>
    html, body{
      height:calc(100%) !important;
      width:calc(100%) !important;
    }
    body{
      background-image: url("<?php echo validate_image($_settings->info('cover')) ?>");
      background-color: #001f3f;
      background-size:cover;
      background-repeat:no-repeat;
    }
    .login-title{
      text-shadow: 2px 2px black
    }
    #login{
      flex-direction:column !important
    }
    #logo-img{
        height:100px;
        width:100px;
        object-fit:scale-down;
        object-position:center center;
        border-radius:50%;
    }
    #login .col-7,#login .col-5{
      width: 100% !important;
      max-width:unset !important
    }
  </style>
 
  <div class="h-100 d-flex align-items-center w-100" id="login">
    <div class="col-7 h-100 d-flex align-items-center justify-content-center">
      <div class="w-100">
        <center><img src="<?= validate_image($_settings->info('logo')) ?>" alt="" id="logo-img"></center>
        <h1 class="text-center py-5 login-title"><b><?php echo $_settings->info('name') ?></b></h1>
      </div>
      
    </div>
    <div class="col-5 h-100 bg-gradient">
      <div class="d-flex w-100 h-100 justify-content-center align-items-center">
        <div class="card col-sm-12 col-md-6 col-lg-3 card-outline card-primary">
          <div class="card-header">
            <h4 class="text-purle text-center"><b>Login</b></h4>
          </div>
          <div class="card-body">
            <form id="login-frm" action="" method="post">
              <div class="input-group mb-3">
                <input type="text" class="form-control" autofocus name="username" placeholder="Username">
                <div class="input-group-append">
                  <div class="input-group-text">
                    <span class="fas fa-user"></span>
                  </div>
                </div>
              </div>
              <div class="input-group mb-3">
                <input type="password" class="form-control" name="password" placeholder="Password">
                <div class="input-group-append">
                  <div class="input-group-text">
                    <span class="fas fa-lock"></span>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-8">
                  <a href="../index.php">Go to Website</a>
                </div>
                <!-- /.col -->
                <div class="col-4">
                  <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                </div>
                <!-- /.col -->
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script>
   $('#login-frm').submit(function(e) {
        e.preventDefault()
        if ($('.err_msg').length > 0)
            $('.err_msg').remove()
        
        var formData = $(this).serialize();
        var url = '..//../classes/Login.php?f=';
        $.ajax({
            url: url,
            method: 'POST',
            data: formData,
            error: function(err) {
                console.log(err);
            },
            success: function(resp) {
                if (resp) {
                    resp = JSON.parse(resp);
                    if (resp.status == 'success') {
                        location.replace('..//../admin');
                    } else if (resp.status == 'incorrect') {
                        var _frm = $('#login-frm');
                        var _msg = "<div class='alert alert-danger text-white err_msg'><i class='fa fa-exclamation-triangle'></i> Incorrect username or password</div>";
                        _frm.prepend(_msg);
                        _frm.find('input').addClass('is-invalid');
                        $('[name="username"]').focus();
                    } else if (resp.status == 'notverified') {
                        var _frm = $('#login-frm');
                        var _msg = "<div class='alert alert-danger text-white err_msg'><i class='fa fa-exclamation-triangle'></i> Your Account is not yet verified.</div>";
                        _frm.prepend(_msg);
                        _frm.find('input').addClass('is-invalid');
                        $('[name="username"]').focus();
                    }
                }
            }
        });
    });
</script>

<!-- jQuery -->
<script src="../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../plugins/bootstrap/js/bootstrap.bundle.js"></script>
<!-- AdminLTE App -->
<script src="../dist/js/adminlte.min.js"></script>

<script>
  $(document).ready(function(){
    end_loader();
  })
</script>
</body>
</html>