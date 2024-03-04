<style>
  .user-img {
    position: absolute;
    height: 27px;
    width: 27px;
    object-fit: cover;
    left: -7%;
    top: -12%;
  }
  .btn-rounded {
    border-radius: 50px;
  }

  #login-nav {
    position: fixed !important;
    top: 0 !important;
    z-index: 1037;
    padding: 1em 1.5em !important;
  }
  #top-Nav {
    top: 4em;
  }

</style>

  <!-- header section starts  -->

  <header class="header">
  <nav class="navbar nav-2">
   <section class="flex">
       <div class="logo">
       <p style="color:#001f3f; "><span class="mr-2"><i class="fa fa-phone mr-1"></i> <?= $_settings->info('contact') ?>  |  <i class="fa fa-envelope mr-1"></i><?= $_settings->info('email') ?></span></p>
       </div>
       
       
   </section>
   
</nav>
<nav class="navbar nav-1">
   <section class="flex">
       <div class="logo">
         <div>
         
         <a href="" class="logo" style="color:#FDB813; ">
      <img src="<?php echo ($_settings->info('logo'))?>" alt="" style="margin-right:10px;" >

          <span><?= $_settings->info('short_name') ?></span>
         </a>
         </div>
       </div>
       
       
   </section>
   
</nav>

<nav class="navbar nav-2" >
  <section class="flex">
    <div id="menu-btn" class="fas fa-bars"></div>

    <div class="menu">
      <ul>
        <li><a href="./" class="nav-link <?= isset($page) && $page == 'home' ? "active" : "" ?>">Home</a></li>
        <li><a href="./?page=packages" class="nav-link <?= isset($page) && $page == 'packages' ? "active" : "" ?>">Driving Categories</a></li>
        <li><a href="./?page=enrollment" class="nav-link <?= isset($page) && $page == 'enrollment' ? "active" : "" ?>">Enrollment</a></li>
        <li><a href="./?page=about" class="nav-link <?= isset($page) && $page == 'about' ? "active" : "" ?>">About Us</a></li>
        <li><a href="./?page=contact" class="nav-link <?= isset($page) && $page == 'contact' ? "active" : "" ?>">Contact Us</a></li>
      </ul>
    </div>

    <div class="ml-auto">
      <ul>
        <li>
         
            <a href="./admin/login.php" class="mx-2">Account</a>
        </li>
      </ul>
    </div>
  </section>
</nav>



</header>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
  $(document).ready(function () {
    $('#mobile-menu-btn').click(function () {
      $('#top-Nav').toggleClass('show');
    });

    // Close the mobile menu when a navigation link is clicked
    $('#top-Nav a.nav-link').click(function () {
      $('#top-Nav').removeClass('show');
    });
  });
</script>