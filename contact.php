<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'admin/vendor/autoload.php'; // Include PHPMailer autoloader

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $number = $_POST['number'];
    $message = $_POST['message'];

    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->SMTPDebug = SMTP::DEBUG_OFF; // Set to SMTP::DEBUG_SERVER for debugging
        $mail->isSMTP();
        $mail->Host = 'mail.venturecollege.co.ke'; // Replace with your SMTP server
        $mail->SMTPAuth = true;
        $mail->Username = 'info@venturecollege.co.ke'; // Your username
        $mail->Password = 'venture@2024'; // Your password
        $mail->Port = 587; // Use port 465 for SSL

        // Recipients
        $mail->setFrom($email, $name);
        $mail->addAddress('info@venturecollege.co.ke');

        // Content
        $mail->isHTML(false);
        $mail->Subject = 'Contact Form Submission';
        $mail->Body = "Name: $name\nNumber: $number\nEmail: $email\nMessage: $message";

        $mail->send();
        // You can redirect to a thank-you page or show a success message.
        $success_msg[] = 'message sent successfully!';

    } catch (Exception $e) {
        $warning_msg[] = 'Oops! Check Your Internet Connection!';

    }

}
?>




<!-- contact section starts  -->

<section class="contact">

   <div class="row">
      <div class="image">
            <iframe class="w-100 rounded"height="400px" width="500px"src="https://www.google.com/maps/embed?pb=!4v1708154939518!6m8!1m7!1svIo-jO9KM7gq9lvK9VdcZg!2m2!1d-1.285004271611399!2d36.8528459170707!3f99.93!4f2.6400000000000006!5f2.716690643075189"loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
         </div>
      <form action="" method="post">
         <h3>get in touch</h3>
         <input type="text" name="name" required maxlength="50" placeholder="enter your name" class="box">
         <input type="email" name="email" required maxlength="50" placeholder="enter your email" class="box">
         <input type="number" name="number" required maxlength="10" max="9999999999" min="0" placeholder="enter your number" class="box">
         <textarea name="message" placeholder="enter your message" required maxlength="1000" cols="30" rows="10" class="box"></textarea>
         <input type="submit" value="send message" name="send" class="btn">
      </form>
   </div>

</section>

<!-- contact section ends -->

<!-- faq section starts  -->

<section class="faq" id="faq">

   <h1 class="heading">FAQ</h1>

   <div class="box-container">

      <div class="box active">
         <h3><span>What is the right age to earn license in Kenya?</span><i class="fas fa-angle-down"></i></h3>
         <p> 18 Years & Above</p>
      </div>

      <div class="box">
         <h3><span>what are driving requirements?</span><i class="fas fa-angle-down"></i></h3>
         <p>You must be 18 years and above with national identity card (ID).</p>
      </div>

      

     

      

   </div>

</section>

<!-- faq section ends -->










<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>


<!-- custom js file link  -->
<script src="js/script.js"></script>

<?php include 'components/message.php'; ?>

</body>
</html>