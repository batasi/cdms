<script>
  $(document).ready(function(){
     window.viewer_modal = function($src = ''){
      start_loader()
      var t = $src.split('.')
      t = t[1]
      if(t =='mp4'){
        var view = $("<video src='"+$src+"' controls autoplay></video>")
      }else{
        var view = $("<img src='"+$src+"' />")
      }
      $('#viewer_modal .modal-content video,#viewer_modal .modal-content img').remove()
      $('#viewer_modal .modal-content').append(view)
      $('#viewer_modal').modal({
              show:true,
              backdrop:'static',
              keyboard:false,
              focus:true
            })
            end_loader()  

  }
    window.uni_modal = function($title = '' , $url='',$size=""){
        start_loader()
        $.ajax({
            url:$url,
            error:err=>{
                console.log()
                alert("An error occured")
            },
            success:function(resp){
                if(resp){
                    $('#uni_modal .modal-title').html($title)
                    $('#uni_modal .modal-body').html(resp)
                    if($size != ''){
                        $('#uni_modal .modal-dialog').addClass($size+'  modal-dialog-centered')
                    }else{
                        $('#uni_modal .modal-dialog').removeAttr("class").addClass("modal-dialog modal-md modal-dialog-centered")
                    }
                    $('#uni_modal').modal({
                      show:true,
                      backdrop:'static',
                      keyboard:false,
                      focus:true
                    })
                    end_loader()
                }
            }
        })
    }
    window._conf = function($msg='',$func='',$params = []){
       $('#confirm_modal #confirm').attr('onclick',$func+"("+$params.join(',')+")")
       $('#confirm_modal .modal-body').html($msg)
       $('#confirm_modal').modal('show')
    }
  })
</script>
<link rel="stylesheet" href="css/style.css">
<footer class="footer">

   <section class="flex">

      <div class="box">
         <p style="font-size:20px;color:#FDB813 ;">Useful Links</p>
         <a href="./" class="nav-link <?= isset($page) && $page == 'home' ? "active" : "" ?>"><i class="fas fa-arrow-right"></i><span>Home</span></a>
         <a href="./?page=packages" class="nav-link <?= isset($page) && $page == 'packages' ? "active" : "" ?>"><i class="fas fa-arrow-right"></i><span>Driving Categories</span></a>
         <a href="./?page=enrollment" class="nav-link <?= isset($page) && $page == 'enrollment' ? "active" : "" ?>"><i class="fas fa-arrow-right"></i><span>Enrollment</span></a>
         <a href="./?page=about" class="nav-link <?= isset($page) && $page == 'about' ? "active" : "" ?>"><i class="fas fa-arrow-right"></i><span>About Us</span></a>
         <a href="./?page=contact" class="nav-link <?= isset($page) && $page == 'contact' ? "active" : "" ?>"><i class="fas fa-arrow-right"></i><span>Contact Us</span></a>
      </div>
      
      <div class="box">
      <p style=" font-size:20px;color:#FDB813 ;">Reach Us</p>
         <a href="https://www.facebook.com/pacedrivingschoolnairobi/" target="_blank"><i class="fab fa-facebook-f"></i><span>  Facebook</span></a>
         <a href="https://www.instagram.com/" target="_blank"><i class="fab fa-instagram"></i><span> Instagram</span></a>
         <a href="tel:0720245905"><i class="fas fa-phone"></i><span> <?= $_settings->info('contact') ?></span></a>
         <a href="mailto:pacedrivingschool@gmail.com" target="_blank"><i class="fas fa-envelope"></i><span> <?= $_settings->info('email') ?></span></a>
         <a href="#"><i class="fas fa-map-marker-alt" target="_blank"></i><span> <?= $_settings->info('address') ?></span></a>     
      </div>
     
      
   </section>

   <div class="credit">&copy; copyright @ <?= date('Y'); ?> by <a href="https://batasi.000webhostapp.com" target="_blank"><span>BatasiSoloh</span> </a>| all rights reserved!</div>
   
</footer>
    </div>
