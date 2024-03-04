<div class="col-12">
    <div class="row my-5 ">
    <div class="col-md-7">
            <div class="card rounded-0 card-outline card-navy shadow" >
                <div class="card-body rounded-0">
                    <h2 class="text-center">About</h2>
                    <div>
                        <?= file_get_contents("about_us.html") ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-5">
            <div class="card card-outline card-navy rounded-0 shadow">
                <div class="card-header">
                    <h3 class="card-title">Contact Us</h3>
                </div>
                <div class="card-body rounded-0">
                    <dl>
                        <h4><dt class="text-muted"><i class="fa fa-envelope"></i> Email</dt></h4>
                        <dd class="pr-4"><?= $_settings->info('email') ?></dd>
                        <h4><dt class="text-muted"><i class="fa fa-phone"></i> Contact</dt></h4>
                        <dd class="pr-4"><?= $_settings->info('contact') ?></dd>
                        <h4><dt class="text-muted"><i class="fa fa-map-marked-alt"></i> Location</dt></h4>
                        <dd class="pr-4"><?= $_settings->info('address') ?></dd>
                    </dl>
                </div>
            </div>
        </div>
        
    </div>
</div>
<section class="reviews">

   <h1 class="heading">Opening Hours</h1>
<section class="background-image">
   <div class="box-container">

      <div class="box">
         <div class="user">
            <img src="    <?php echo $_settings->info('logo'); ?>" alt="">
            <div>
               <h3>Join Us!</h3>
               <div class="stars">
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star-half-alt"></i>
               </div>
            </div>
         </div>
         <p>
             
            Monday : 6:00AM - 6:00 PM <br>
            Tuesday : 6:00AM - 6:00 PM <br>
            Wednesday : 6:00AM - 6:00 PM <br>
            Thursday : 6:00AM - 6:00 PM <br>
            Friday : 6:00AM - 6:00 PM <br>
            Saturday : 7:00AM - 4:00 PM <br>
            Sunday : Closed <br>
            <b><li>Classes run either Part-time/Full time</li></b></br>
             <b><li>Practical,Theory & Online lessons</li></b></br>
             <b><li>Basic Mechanics</li></b>
         </p>
      </div>

    
   </div>
   </section>
</section>