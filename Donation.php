<?php 
$name = ""; $email = ""; $number=""; $state = ""; $food=""; $timming=""; $random=""; $address=""; 
$msg3 = "";
define('TITLE', "Donation");
define('PAGE', "donation");
include "header.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


require('PHPMailer/Exception.php');
require('PHPMailer/PHPMailer.php');
require('PHPMailer/SMTP.php');

// Registration
if(isset($_POST['Submit'])){
    
  $name = trim($_POST['name']);
  $email = trim($_POST['email']);
  $number = trim($_POST['number']);
  $state = trim($_POST['state']);
  $food = trim($_POST['food']);
  $timming = trim($_POST['timming']);
  $address = trim($_POST['address']);
  $random = $_POST['random'];

  $nm = preg_match("/^([A-Za-z0-9 ]{4,})$/", $_REQUEST['name']);
  $em = preg_match("/^([A-Za-z0-9@.]{4,})$/", $_REQUEST['email']);
  $ph = preg_match("/^([0-9]{10,13})$/", $_REQUEST['number']);
  $st = preg_match("/^([0-9]{1,})$/", $_REQUEST['state']);
  // $fo = preg_match("/^([A-Za-z0-9, - . // : ]{4,})$/", $_REQUEST['food']);
  // $ti = preg_match("/^([A-Za-z0-9@.-:// -- :: ]{4,})$/", $_REQUEST['timming']);
  // $add = preg_match("/^([A-Za-z0-9@.-:-  , #]{4,})$/", $_REQUEST['address']);

  // echo "name ".$nm."<br>";
  // echo "email ".$em."<br>";  
  // echo "phone ".$ph."<br>";
  if($nm && $em && $ph && $st){
    //Create an instance; passing `true` enables exceptions
    $mail = new PHPMailer(true);
    
    try {
        //Server settings
        /*$mail->SMTPDebug = SMTP::DEBUG_SERVER;*/      //Enable verbose debug output
        $mail->isSMTP();                             //Send using SMTP
        $mail->Host       = 'smtp.gmail.com';     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                      //Enable SMTP authentication
        $mail->Username   = $emailUsername;            //SMTP username
        $mail->Password   = $emailPassword;             //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;  //Enable implicit TLS encryption
        $mail->Port       = 465;                         //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
    
        //Recipients
        $mail->setFrom($emailUsername, $emailName);
        $mail->addAddress($email);     //Add a recipient
        // $mail->addAddress('ellen@example.com');               //Name is optional
        // $mail->addReplyTo('info@example.com', 'Information');
        // $mail->addCC('cc@example.com');
        // $mail->addBCC('bcc@example.com');
    
        //Attachments
        // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
        // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name
    
        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = 'Email Verification';
        $mail->Body    = 'Code for verification is : <b>'.$random.'</b>';
        $mail->AltBody = 'Code for verification is : <b>'.$random.'</b>';
    
        $mail->send();

        $message2 =  '<script>
        document.addEventListener("DOMContentLoaded", () => {
        var rand_btn_toggle = document.getElementById("login2");
            rand_btn_toggle.click();
        });
        </script>';

    } catch (Exception $e) {
        $msg3 = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }


  } else{
    $msg3 = '<div class="w3-panel w3-pale-red w3-border">
    <h4>Fill all fields with valid inputs</h4>
    </div>';
  }
}

// Final Submit
if(isset($_POST['Submit1'])){
  
  $randomCode = $_POST['randomCode'];

  $name = trim($_POST['name']);
  $email = trim($_POST['email']);
  $number = trim($_POST['number']);
  $state = trim($_POST['state']);
  $food = trim($_POST['food']);
  $timming = trim($_POST['timming']);
  $address = trim($_POST['address']);
  $random = $_POST['random'];


  if($random == $randomCode){

    $sql3 = "INSERT INTO food (name, cooking_timing, email, phone, donor_name, state, full_address, confirm_by, collect) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
      $result3 = $conn->prepare($sql3);
      if($result3->execute(array($food, $timming, $email, $number, $name, $state, $address, 0, 0))){
         $sql4 = "SELECT username from user WHERE state = ?";
         $values4 = array($state);
         $row4 = $db->query($sql4, $values4);
         $user_email = $row4[0]['username'];

        $mail = new PHPMailer(true);
    
        try {
            //Server settings
            /*$mail->SMTPDebug = SMTP::DEBUG_SERVER;*/      //Enable verbose debug output
            $mail->isSMTP();                             //Send using SMTP
            $mail->Host       = 'smtp.gmail.com';     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                      //Enable SMTP authentication
            $mail->Username   = $emailUsername;            //SMTP username
            $mail->Password   = $emailPassword;             //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;  //Enable implicit TLS encryption
            $mail->Port       = 465;                         //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
        
            //Recipients
            $mail->setFrom($emailUsername, $emailName);
            $mail->addAddress($user_email);     //Add a recipient
            // $mail->addAddress('ellen@example.com');               //Name is optional
            // $mail->addReplyTo('info@example.com', 'Information');
            // $mail->addCC('cc@example.com');
            // $mail->addBCC('bcc@example.com');
        
            //Attachments
            // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
            // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name
        
            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = 'New food donation request';
            $mail->Body    = '<h4>New Food Request</h4><b>Name : </b>'.$name.'<br> <b>Email : </b>'.$email.'<br><b>Phone : </b>'.$number.'<br><b>Address : </b><br>'.$address.'<br>'.'<b>Food Detail : </b>'.$food.''.'<br><b>Time of cooking : </b>'.$timming.'<br><br>';
            $mail->AltBody = '<h4>New Food Request</h4><b>Name : </b>'.$name.'<br> <b>Email : </b>'.$email.'<br><b>Phone : </b>'.$number.'<br><b>Address : </b>'.$address.'<br><br>'.'<b>Food Detail : </b>'.$food.''.'<br><b>Time of cooking : </b>'.$timming.'<br><br>';
        
            $mail->send();
    
        } catch (Exception $e) {
           echo $mail->ErrorInfo; 
        }

          $msg3 = "<script>location.href = '".$hostname."/thanks.php';</script>";
        }else{
          unset($random);
            $msg3 = '<div class="w3-panel w3-pale-red w3-border"><h3>Unable to send request, some technical problem</h3></div>';       
        }  
  } else {
    $message3 = '<div class="w3-panel w3-pale-red w3-border">Wrong code, enter valid code</div>';
    $message2 =  '<script>
            var rand_btn_toggle = document.getElementById("login2");
              //setTimeout(() => {
                rand_btn_toggle.click();
            //  }, 1000); 
             
            </script>';
  }
}
?>
<section class="text-gray-600 body-font relative">
  <div class="container px-5 py-2 mx-auto">
    <div class="flex flex-col text-center w-full mb-2">
      <h1 class="sm:text-3xl text-2xl font-medium title-font mb-4 text-gray-900">Donate Food Here</h1>
      <p class="lg:w-2/3 mx-auto leading-relaxed text-base">Fill The Form And Our Team Will Connect You</p>
    </div>
    <?php if(isset($msg3)){ echo $msg3; } ?>
    <form action="" method="post">
      <div class="lg:w-1/2 md:w-2/3 mx-auto">
        <div class="flex flex-wrap -m-2">
          <div class="p-2 w-1/2">
            <div class="relative">
              <label for="name" class="leading-7 text-sm text-gray-600">Name</label>
              <input type="text" id="name" name="name" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out" placeholder="Full Name" required>
            </div>
          </div>

          <div class="p-2 w-1/2">
            <div class="relative">
              <label for="number" class="leading-7 text-sm text-gray-600">Number</label>
              <input type="number" id="number" name="number" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out" placeholder="9876543210" required>
            </div>
          </div> 

          <div class="p-2 w-1/2">
            <div class="relative">
              <label for="email" class="leading-7 text-sm text-gray-600">Email</label>
              <input type="email" id="email" name="email" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out" placeholder="abc@gmail.com" required>
            </div>
          </div> 

          <div class="p-2 w-1/2">
            <div class="relative">
              <label for="state" class="leading-7 text-sm text-gray-600">State</label>
              <select name="state" id="state" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out" required>
                <option value="" selected disabled>Select</option>
                <?php 
                $sql = "SELECT * FROM state INNER JOIN user ON state.state_id = user.state";
                $values = array();
                $rows = $db->query($sql, $values);
                if($rows){
                  foreach($rows as $row){
                  echo "<option value=".$row['state_id'].">".$row['state_name']."</option>";
                }}
                ?>
              </select>
            </div>
          </div>

          <div class="p-2 w-1/2">
            <div class="relative">
              <label for="food" class="leading-7 text-sm text-gray-600">Food</label>
              <input type="text" id="food" name="food" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out" placeholder="Food Name" required>
            </div>
          </div> 

          <div class="p-2 w-1/2">
            <div class="relative">
              <label for="timming" class="leading-7 text-sm text-gray-600">Time of cooking</label>
              <input type="text" id="timming" name="timming" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out" placeholder="Today or Yesterday 1:30 PM" required>
            </div>
          </div> 


          <div class="p-2 w-full">
            <div class="relative">
              <label for="Address" class="leading-7 text-sm text-gray-600">Full Address</label>
              <textarea id="Address" name="address" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 h-22 text-base outline-none text-gray-700 py-1 px-3 resize-none leading-6 transition-colors duration-200 ease-in-out" required></textarea>
              <input type="hidden" name="random" value="<?php echo mt_rand(100000,999999);  ?>">
            </div>
          </div>
          
          <div class="p-2 w-full">
            <input type="submit" value="Submit" name="Submit" class="inline-flex text-white bg-indigo-500 border-0 py-2 px-6 focus:outline-none hover:bg-indigo-600 rounded text-lg">
          </div>

          <div class="p-2 w-full pt-8 mt-8 border-t border-gray-200 text-center">
            <a class="text-indigo-500">example@email.com</a>
            <p class="leading-normal my-5">XYZ Ngo
              <br>Abc Block, Dera Bassi
            </p> 
          </div>

        </div>
      </div>
    </form>
  </div>
</section>

<!-- Modal box -->

<div id="id01" class="w3-modal">
  <div class="w3-modal-content">
    <header class="w3-container w3-teal"> 
      <span onclick="document.getElementById('id01').style.display='none'" 
      class="w3-button w3-display-topright">&times;</span>
      <h3>Verify E-mail</h3>
    </header>
    <div class="w3-container">
    <form action="" method="post">
      <div class="w3-section">
        <?php if(isset($message3)){ echo $message3; } ?>
        <label for="rand_num">Code sent on your E-mail</label>
        <input type="number" class="w3-input w3-border" id="rand_num" required name="randomCode" value="" placeholder="6-digit code" />
        <input type="hidden" name="name" value="<?php if(isset($name))echo $name; ?>">
        <input type="hidden" name="email" value="<?php if(isset($email)) echo $email; ?>">
        <input type="hidden" name="number" value="<?php if(isset($number)) echo $number; ?>">
        <input type="hidden" name="state" value="<?php if(isset($state)) echo $state; ?>">
        <input type="hidden" name="food" value="<?php if(isset($food)) echo $food; ?>">
        <input type="hidden" name="timming" value="<?php if(isset($timming)) echo $timming; ?>">
        <input type="hidden" name="address" value="<?php if(isset($address))echo $address; ?>">        
        <input type="hidden" name="random" value="<?php if(isset($random)) echo $random;  ?>">
      </div>
        <input type="submit" value="Confirm" name="Submit1" class="w3-btn w3-block w3-red modal-btn" id="confirmBTN" disabled="disabled" />
      </form>
    </div>
    <!-- <footer class="w3-container w3-teal">
      <p>Modal Footer</p>
    </footer> -->
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
<script>
// Get the modal
var modal = document.getElementById('id01');

// When the user clicks anywhere outside of the modal, close it
// window.onclick = function(event) {
// if (event.target == modal) {
//   modal.style.display = "none";
// }
// }

var rand_code = document.getElementById('rand_num');
rand_code.addEventListener('keyup', () => {
  rand_value = rand_code.value;
  var confirmBtn = document.getElementById('confirmBTN');
  if(rand_value.length >= 6){
    confirmBtn.removeAttribute('disabled');
  }
});


  $( function() {
    $( "#datepicker" ).datepicker({
      changeMonth: true,
      changeYear: true
    });
  } );
</script>
<?php if(isset($message2))echo $message2; ?>

<!-- Modal box end for confirmation -->
<?php include "footer.php"; ?>
   