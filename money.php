<?php 

define('TITLE', "Money");
define('PAGE', "donation");

include "header.php";
?>
 <section class="text-gray-600 body-font">
  <div class="container mx-auto flex flex-col px-5 py-2 justify-center items-center">
    <img class="lg:w-2/6 md:w-3/6 w-5/6 mb-10 object-cover object-center rounded" alt="hero" src="http://www.druckundbestell.de/img/products/vinylsticker/qr-code/qr-code-sticker_de.png">
    <div class="w-full md:w-2/3 flex flex-col mb-16 items-center text-center">
      <h1 class="title-font sm:text-4xl text-3xl mb-4 font-medium text-gray-900">Donate Money Here</h1>
      <p class="mb-8 leading-relaxed">You Can Use Scan The Above QR Code For The Donation Of Money Or You Can Use This Mobile Number 986***3243</p>
      <div class="p-2 w-full">
                    <div class="relative">
                      <label for="Address" class="leading-7 text-sm text-gray-600">Message</label>
                      <textarea id="Address" name="message" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 h-32 text-base outline-none text-gray-700 py-1 px-3 resize-none leading-6 transition-colors duration-200 ease-in-out"></textarea>
                    </div>
                  </div>
                  
                  <div class="p-2 w-full">
                    <a href="thanks.php" class="inline-flex text-white bg-indigo-500 border-0 py-2 px-6 focus:outline-none hover:bg-indigo-600 rounded text-lg">Submit</a></Submit>
                  </div>

</section>

<?php include "footer.php"; ?>