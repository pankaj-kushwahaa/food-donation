<?php 
define('TITLE', "Food Donation System");
define('PAGE', "index");
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


// Registration
if(isset($_POST['register'])){
  if(($_POST['Name'] !== '') && ($_POST['Email'] !== '') && ($_POST['Phone'] !== '') && ($_POST['Branch'] !== '') && ($_POST['Rollno'] !== '') && ($_POST['Password'] !== '')){
    
    $name = $_POST['Name'];
    $email = $_POST['Email'];
    $phone = $_POST['Phone'];
    $branch = $_POST['Branch'];
    $rollno = $_POST['Rollno'];
    $password = $_POST['Password'];
    $random = $_POST['random'];

    // Login
    $sql4 = "SELECT stu_email, stu_rollno FROM student WHERE stu_email = ?";
    $result4 = $conn->prepare($sql4);
    $result4->execute([$email]);
    if($result4->rowCount() > 0){
      unset($random);
      $msg3 = '<div class="alert alert-warning">User Already Registered</div>';
    } else{

       require('PHPMailer/Exception.php');
       require('PHPMailer/PHPMailer.php');
       require('PHPMailer/SMTP.php');
        
        //Create an instance; passing `true` enables exceptions
        $mail = new PHPMailer(true);
        
        try {
            //Server settings
            /*$mail->SMTPDebug = SMTP::DEBUG_SERVER;*/                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = $emailUsername;                  //SMTP username
            $mail->Password   = $emailPassword;                          //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
        
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

    }
  } else{
    $msg3 = '<div class="alert alert-danger">Fill all fields</div>';
  }
}


include "header.php";
?>

  <section class="text-gray-600 body-font">
    <div class="container mx-auto flex px-5 py-24 md:flex-row flex-col items-center">
      <div class="lg:max-w-lg lg:w-full md:w-1/2 w-5/6 mb-10 md:mb-0">
        <img class="object-cover object-center rounded" alt="hero" src="https://www.vmcdn.ca/f/files/shared/miscellaneous-stock-images/food-donation.jpeg;w=960">
      </div>
      <div class="lg:flex-grow md:w-1/2 lg:pl-24 md:pl-16 flex flex-col md:items-start md:text-left items-center text-center">
        <h1 class="title-font sm:text-4xl text-3xl mb-4 font-medium text-gray-900">
          <br class="hidden lg:inline-block">Alone We Can Do Little Together We Can Do So Much
        </h1>
        <p class="mb-8 leading-relaxed">Giving Is Not Only About Donation It Also About Making Change</p>
        <div class="flex justify-center">
          <a href="Donation.php" class="inline-flex text-white bg-indigo-500 border-0 py-2 px-6 focus:outline-none hover:bg-indigo-600 rounded text-lg">Donate Now</a>
        </div>
      </div>
    </div>
  </section>

  <section class="text-gray-600 body-font">
    <section style="background-color:#8db2ea;">

      <div class="container px-5 py-24 mx-auto">
        <div class="flex flex-wrap w-full mb-20 flex-col items-center text-center">
          <h1 class="sm:text-3xl text-2xl font-medium title-font mb-2 text-gray-900">We Manage Donation Like</h1>
          <p class="lg:w-1/2 w-full leading-relaxed text-white-700">Food, Cloth and Money</p>
        </div>
        
        <div class="flex flex-wrap -m-4">

          <div class="xl:w-1/3 md:w-1/2 p-4">
            <div class="border border-gray-200 p-6 rounded-lg">
              <div class="w-10 h-10 inline-flex items-center justify-center rounded-full bg-indigo-100 text-indigo-500 mb-4">
                <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-6 h-6" viewBox="0 0 24 24">
                <path d="M22 12h-4l-3 9L9 3l-3 9H2"></path>
                </svg>
              </div>
              <h2 class="text-lg text-gray-900 font-medium title-font mb-2">Food</h2>
              <p class="leading-relaxed text-base">Feed The Needy</p>
              <a href="Donation.php" class="inline-flex text-white bg-indigo-500 border-0 py-2 px-6 focus:outline-none hover:bg-indigo-600 rounded text-lg">Donate Now</a>
            </div>
          </div>

          <div class="xl:w-1/3 md:w-1/2 p-4">
            <div class="border border-gray-200 p-6 rounded-lg">
              <div class="w-10 h-10 inline-flex items-center justify-center rounded-full bg-indigo-100 text-indigo-500 mb-4">
                <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-6 h-6" viewBox="0 0 24 24">
                  <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"></path>
                  <circle cx="12" cy="7" r="4"></circle>
                </svg>
              </div>
              <h2 class="text-lg text-gray-900 font-medium title-font mb-2">Money</h2>
              <p class="leading-relaxed text-base">Help The Poor</p>
              <a href="money.php" class="inline-flex text-white bg-indigo-500 border-0 py-2 px-6 focus:outline-none hover:bg-indigo-600 rounded text-lg">Donate Now</a>
            </div>
          </div>

          <div class="xl:w-1/3 md:w-1/2 p-4">
            <div class="border border-gray-200 p-6 rounded-lg">
              <div class="w-10 h-10 inline-flex items-center justify-center rounded-full bg-indigo-100 text-indigo-500 mb-4">
                <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-6 h-6" viewBox="0 0 24 24">
                  <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"></path>
                  <circle cx="12" cy="7" r="4"></circle>
                </svg>
              </div>
              <h2 class="text-lg text-gray-900 font-medium title-font mb-2">Clothes</h2>
              <p class="leading-relaxed text-base">Someone Needs You</p>
              <a href="clothes.php" class="inline-flex text-white bg-indigo-500 border-0 py-2 px-6 focus:outline-none hover:bg-indigo-600 rounded text-lg">Donate Now</a>
            </div>
          </div>

        </div>

    </section>
  </section>

  <?php include "footer.php"; ?>
