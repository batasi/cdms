<?php require_once('./config.php'); ?>
 <!DOCTYPE html>
<html lang="en" class="" style="height: auto;">
<style>
   #header{
    height:85vh;
    width:calc(100%);
    position:relative;
    top:-1em;
  }
  #header:before{
    content:"";
    position:absolute;
    height:calc(100%);
    width:calc(100%);
    background-image: url(<?php echo $_settings->info("cover"); ?>);
    background-size:cover;
    background-repeat:no-repeat;
    background-position: center bottom;
  }
  #header>div{
    position:absolute;
    height:calc(100%);
    width:calc(100%);
    z-index:2;
  }

  #top-Nav a.nav-link.active {
      color: #001f3f;
      font-weight: 900;
      position: relative;
  }
  #top-Nav a.nav-link.active:after {
    content: "";
    position: absolute;
    border-bottom: 2px solid #001f3f;
    width: 33.33%;
    left: 33.33%;
    bottom: 0;
  }
  .whatsapp-container {
    position: fixed;
    top: 85%;
    left: 0;
    transform: translateY(-50%);
    z-index: 1000;
}

.whatsapp-link {
    display: block;
    width: 80px; /* Adjust size as needed */
    height: 80px; /* Adjust size as needed */
    border-radius: 50%;
    background-color:green; /* Change color as needed */
    text-align: center;
    line-height: 80px; /* Adjust size as needed */
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.5); /* Optional: Add shadow */
    transition: transform 0.3s ease-in-out;
}

.whatsapp-link:hover {
    transform: scale(1.1); /* Optional: Add hover effect */
}

.whatsapp-icon {
    width: 60px; /* Adjust size as needed */
    height: auto; /* Maintain aspect ratio */
    border-radius:50%;
    animation: blink 4s infinite;
}
@keyframes blink {
  0% { opacity: 1; }
  50% { opacity: 0; }
  100% { opacity: 1; }
}
.whatsapp-icons {
    width: 85px; /* Adjust size as needed */
    height: auto; /* Maintain aspect ratio */
    border-radius:5%;
    margin-left:10px;
}
.static-txt {
   font-size: 30px;
   margin-top: 1%;
   font-weight: 400;
}

.dynamic-txts {
  overflow: hidden;
}

.dynamic-txts li {
  list-style: none;
  position: relative;
  font-weight: 400;
}

.dynamic-txts li span {
  display: inline-block;
  overflow: hidden;
  white-space: nowrap;
  animation: typing 10s steps(64,end) infinite;
}

@keyframes typing {
  from {
    width: 0;
  }
  to {
    width: 100%;
  }
}

/* Blinking cursor animation */
.dynamic-txts li span::after {
  content: "";
  animation: blink 1s infinite;
}

@keyframes blink {
  50% {
    opacity: 0;
  }
}



</style>

<?php require_once('inc/header.php') ?>
<body class="layout-top-nav layout-fixed layout-navbar-fixed" style="height: auto;">
   <div class="wrapper">
      <?php $page = isset($_GET['page']) ? $_GET['page'] : 'home';  ?>
      <?php require_once('inc/topBarNav.php') ?>
      <?php if($_settings->chk_flashdata('success')): ?>
      <script>
         alert_toast("<?php echo $_settings->flashdata('success') ?>",'success')
      </script>
   <?php endif;?>    
      <!-- Content Wrapper. Contains page content -->
   <div class="content-wrapper pt-5" style="">
      <?php if($page == "home" || $page == "about_us"): ?>
         <div id="header" class="shadow ">
            <div class="justify-content-center h-100 w-100 align-items-center ">
               <div class="hero-description">
      
                  <div class="hero-text">  
                  <h1 class="hero-header">
                        <span style="color:#FDB813;"><?= $_settings->info('short_name') ?></span><br>
                     </h1>
                     <h3><i>
                        <span style="color:white;"><span style="color:#FDB813;">T</span>eaching <span style="color:#FDB813;">Y</span>ou to <span style="color:#FDB813;">T</span>ake <span style="color:#FDB813;">C</span>ontrol</span></h3></i>  <br>     
                     <p><span style="color:white;">Approved By </span><img src="images/NTSA-2.jpeg"class="whatsapp-icons" alt=""></p>
                     <p><span style="color:#FDB813;"> <i class="fas fa-phone"></i></span><span style="color:white;"> <?= $_settings->info('contact') ?> </span></p><br>
                     <p><a href="mailto:pacedrivingschool1@gmail.com"><span style="color:#FDB813;"> <i class="fas fa-envelope"></i></span> <span style="color:white;"><?= $_settings->info('email') ?></span></a><br></p>
                     <br>
                     <p><span style="color:#FDB813;"> <i class="fa fa-map-marker fa-fw w3-margin-bottom "></i><span style="color:white;"><?= $_settings->info('address') ?></span></p>
                    
                    
                     <a href="./?page=enrollment" class="w3-btn w3-yellow w3-margin-top w3-round" id="enrollment"><b>Enroll Now</b></a>
                     <div class="tab-tittles">
                     <div class="static-txt"></div>
                           <ul class="dynamic-txts">
                              <li><span style="color:white;">Proffessional, reliable and reputable services to satisfaction</span></li>
                              
                           </ul> 
                     </div>
                  </div>
                 
               </div>
               
            </div>
         </div>
   <?php endif; ?>

  <!-- Main content -->
  <div class="whatsapp-container">
    <a href="https://wa.me/254728725559" target="_blank" class="whatsapp-link">
        <img src="images/Whatsapp--icon-in-circle-design-premium-vector-PNG.png" alt="WhatsApp Icon" class="whatsapp-icon">
    </a>
</div>

   <section class="content ">
   
      <div class="container">
         <?php 
            if(!file_exists($page.".php") && !is_dir($page)){
               include '404.html';
            }else{
               if(is_dir($page))
               include $page.'/index.php';
               else
               include $page.'.php';

            }
         ?>
      </div>
   </section>
   <!-- /.content -->
   
   <!-- Courses -->
 
   <?php if ($page == "home" || $page == "about_us"): ?>
      <h1 class="heading">Driving Categories</h1>
   <div style="margin-top: 2rem; text-align:center;">
   <a href="./?page=packages" class="inline-btn">Search Categories</a>
   </div>
<section class="listings" id="driving">

   <section>
         <div class="box-container">
            <form action="" method="POST">
               <div class="box">
                     <div class="thumb">
                        <img src="images/A1.jpg" alt="">
                        <img src="images/A2.jpg" alt="">
                     </div>
                     <div class="admin">
                        <p>Train with Us!</p>
                     </div>
               </div>
               <div class="box">
                     <h3 class="name">Category A</h3>
                     <div class="price">MotorCycle(Category A1-Moped) </div>
                     <div class="price">MotorCycle(Category A2-Light Motorcycle) </div>
                     <div class="price">MotorCycle(Category A3-Tuktuk) </div>
                     <p class="location">18 Years</p>
                     <div class="flex">
                        <p><i class="fa fa-print"></i>Theory & Test</p>
                        <p><i class="fas fa-clock"></i>Duration :3-5 weeks</p>
                     </div>
                     <div class="flex-btn">
                        <a href="./?page=enrollment" class="btn">ENROLL NOW</a>
                        <a href="./?page=packages" class="btn">MORE DETAILS</a>
                     </div>
               </div>
            </form>
         </div>
   </section>

   <section>
         <div class="box-container">
            <form action="" method="POST">
               <div class="box">
                     <div class="thumb">
                        <img src="images/B.jfif" alt="">
                        <img src="images/download.jpg" alt="">
                     </div>
                     <div class="admin">
                        <p>Train with Us!</p>
                     </div>
               </div>
               <div class="box">
                     <h3 class="name">Category B</h3>
                     <div class="price">Category B1(Light Vehicle Automatic)</div>
                     <div class="price">Category B2(Light Vehicle Manual)</div>
                     <div class="price">Category B3 (Professional)</div>
                     <p class="location">18 Years</p>
                     <div class="flex">
                        <p><i class="fa fa-print"></i>Theory & Practical</p>
                        <p><i class="fa fa-desktop"></i>Free Computer Training</p>
                        <p><i class="fas fa-clock"></i>Duration : 1 - 2 months</p>
                     </div>
                     <div class="flex-btn">
                        <a href="./?page=enrollment" class="btn">ENROLL NOW</a>
                        <a href="./?page=packages" class="btn">MORE DETAILS</a>
                     </div>
               </div>
            </form>
         </div>
   </section>

   <section>
         <div class="box-container">
            <form action="" method="POST">
               <div class="box">
                     <div class="thumb">
                        <img src="images/FUSO-CANTER-2023.jpg" alt="">
                     </div>
                     <div class="admin">
                        <p>Train with Us!</p>
                     </div>
               </div>
               <div class="box">
                     <h3 class="name">Category C</h3>
                     <div class="price">Category C (Medium Truck)</div>
                     <div class="price">Category CD (Heavy Goods Vehicle )</div>
                     <div class="price"> Category CE (Heavy Truck With Trailer)</div>
                     <p class="location">Endorsement DL</p>
                     <p class="location">22 Years</p>
                     <div class="flex">
                        <p><i class="fa fa-print"></i>Theory & Test</p>
                        <p><i class="fas fa-clock"></i>Duration : 3-5 Weeks</p>
                     </div>
                     <div class="flex-btn">
                        <a href="./?page=enrollment" class="btn">ENROLL NOW</a>
                        <a href="./?page=packages" class="btn">MORE DETAILS</a>
                     </div>
               </div>
            </form>
         </div>
   </section>

   <section>
         <div class="box-container">
            <form action="" method="POST">
               <div class="box">
                     <div class="thumb">
                        <img src="images/van-hire-srilanka.jpg" alt="">
                     </div>
                     <div class="admin">
                        <p>Train with Us!</p>
                     </div>
               </div>
               <div class="box">
                     <h3 class="name">Category D1</h3>
                     <div class="price">Category D1(PSV,TAXI,VAN)</div>
                     <div class="price">Category D2 (Mini-bus)</div>
                     <div class="price">Category D3 (Large Bus)</div>
                     <p class="location">Endorsement DL</p>
                     <p class="location">22 YEARS</p>
                     <div class="flex">
                        <p><i class="fa fa-print"></i>Theory & Test</p>
                        <p><i class="fas fa-clock"></i>Duration : 3-5 Weeks</p>
                     </div>
                     <div class="flex-btn">
                        <a href="./?page=enrollment" class="btn">ENROLL NOW</a>
                        <a href="./?page=packages" class="btn">MORE DETAILS</a>
                     </div>
               </div>
            </form>
         </div>
   </section>
   <div style="margin-top: 2rem; text-align:center;">
   <a href="./?page=packages" class="inline-btn">Search More</a>
   </div>
   <br>
</section>
      <h1 class="heading">Why Choose Us</h1>
   <section class="reviews">

      <div class="box-container">

         <div class="box">
            <div class="user">
               <img src="images/icon-6.png" alt="">
               <div>
               <h3>NTSA accredited Instructors</h3>
               </div>
            </div>
            <p>
               We offer unlimited theory lessons, highway driver training, city drive,
               defensive driving, and online classes.
            </p>

         </div>

         <div class="box">
            <div class="user">
               <img src="images/record.svg" alt="">
               <div>
                  <h3>Great Track Record</h3>
               </div>
            </div>
            <p>
               Pace has successfully trained thousands of competent students from all over
               Kenya. We remain the school of choice trusted by both individuals and corporations alike.
            </p>
         </div>

         <div class="box">
            <div class="user">
               <img src="images/afford.svg" alt="">
               <div>
               <h3>Affordable Rates</h3>
               </div>
            </div>
            <p>We offer all our courses at a value for your money.</p>
         </div>

      </div>

   </section>
   <h1 class="heading">Payment Methods</h1>
   <section class="services">

      <div class="box-container">

         <div class="box">
            <img src="images/cop.jpg" alt="">
            <h3>CO-OPERATIVE BANK</h3>
            <p>Acc Name:<b>Pace Driving Sch Ltd</b></p>
            <p>Acc NO: <b>01192733920700</b></p>
            <a class="btn" href="./?page=enrollment">Join us Today</a>
         </div>

         <div class="box">
            <img src="images/mpesa-1.png" alt="">
            <h3>M-PESA PAYBILL</h3>
            <p>B/S No:<b>400 200</b></p>
            <p>Acc NO: <b>400 520 79</b></p>
            <p>Name:<b>Pace Driving Sch Ltd</b></p>
            <a class="btn" href="./?page=enrollment">Join us Today</a>
         </div>

         <div class="box">
            <img src="images/note.jpg" alt="">
            <h3>NOTE</h3>
            <p><b>No cash payments</b></p>
            <p><b>Retain official receipts</b></p>
            <a class="btn" href="./?page=enrollment">Join us Today</a>
         </div> 
        
      </div>
  
   </section>
   <section class="listings" id="">

       


            
</div>

  
   </section>
   <?php endif; ?>
   
      <!-- /.content-wrapper -->
   <div class="modal fade" id="confirm_modal" style="display:none;" role='dialog' data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog modal-md modal-dialog-centered" role="document">
         <div class="modal-content">
               <div class="modal-header">
                  <h5 class="modal-title">Confirmation</h5>
               </div>
               <div class="modal-body">
                  <div id="delete_content"></div>
               </div>
               <div class="modal-footer">
                  <button type="button" class="btn btn-primary" id='confirm' onclick="">Continue</button>
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
               </div>
         </div>
      </div>
   </div>

   <div class="modal fade" id="uni_modal" style="display:none;" role='dialog'>
      <div class="modal-dialog modal-md modal-dialog-centered" role="document">
         <div class="modal-content">
               <div class="modal-header">
                  <h5 class="modal-title"></h5>
               </div>
               <div class="modal-body">
               </div>
               <div class="modal-footer">
                  <button type="button" class="btn btn-primary" id='submit' onclick="$('#uni_modal form').submit()">Save</button>
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
               </div>
         </div>
      </div>
   </div>

   <div class="modal fade" id="uni_modal_right" style="display:none;" role='dialog'>
      <div class="modal-dialog modal-full-height modal-md" role="document">
         <div class="modal-content">
               <div class="modal-header">
                  <h5 class="modal-title"></h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span class="fa fa-arrow-right"></span>
                  </button>
               </div>
               <div class="modal-body">
               </div>
         </div>
      </div>
   </div>

   <div class="modal fade" id="viewer_modal" style="display:none;" role='dialog'>
      <div class="modal-dialog modal-md" role="document">
         <div class="modal-content">
               <button type="button" class="btn-close" data-dismiss="modal"><span class="fa fa-times"></span></button>
               <img src="" alt="">
         </div>
      </div>
   </div>

   <?php require_once('inc/footer.php') ?>
   <script src="dist/js/script.js"></script>
   <script src="js/script.js"></script>

  </body>
</html>
