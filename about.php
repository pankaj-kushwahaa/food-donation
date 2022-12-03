<?php  
define("TITLE", "About");
define("PAGE", "about");

include "header.php";

?>

    
<section class="text-gray-600 body-font">
  <div class="container px-5 py-24 mx-auto">
    <div class="flex flex-col text-center w-full mb-20">
      <h1 class="sm:text-3xl text-2xl font-medium title-font mb-4 text-gray-900">About</h1>
      <p class="lg:w-2/3 mx-auto leading-relaxed text-base">These Are The People Involved In The Project</p>
    </div>
    <div class="flex flex-wrap -m-2">
      <div class="p-2 lg:w-1/3 md:w-1/2 w-full">
        <div class="h-full flex items-center border-gray-200 border p-4 rounded-lg">
          <img alt="team" class="w-16 h-16 bg-gray-100 object-cover object-center flex-shrink-0 rounded-full mr-4" src="https://dummyimage.com/80x80">
          <div class="flex-grow">
            <h2 class="text-gray-900 title-font font-medium">Nitin Sharma</h2>
            <p class="text-gray-500">1908750</p>
          </div>
        </div>
      </div>
      <div class="p-2 lg:w-1/3 md:w-1/2 w-full">
        <div class="h-full flex items-center border-gray-200 border p-4 rounded-lg">
          <img alt="team" class="w-16 h-16 bg-gray-100 object-cover object-center flex-shrink-0 rounded-full mr-4" src="https://dummyimage.com/84x84">
          <div class="flex-grow">
            <h2 class="text-gray-900 title-font font-medium">Ankur Pal</h2>
            <p class="text-gray-500">1908***7</p>
          </div>
        </div>
      </div>
      <div class="p-2 lg:w-1/3 md:w-1/2 w-full">
        <div class="h-full flex items-center border-gray-200 border p-4 rounded-lg">
          <img alt="team" class="w-16 h-16 bg-gray-100 object-cover object-center flex-shrink-0 rounded-full mr-4" src="https://dummyimage.com/88x88">
          <div class="flex-grow">
            <h2 class="text-gray-900 title-font font-medium">Vipul Kumar</h2>
            <p class="text-gray-500">190***56</p>
          </div>
        </div>
      </div>
      <div class="p-2 w-full pt-8 mt-8 border-t border-gray-200 text-center">
                    <a class="text-indigo-500">example@email.com</a>
                    <p class="leading-normal my-5">XYZ Ngo
                      <br>Abc Block, Dera Bassi
                    </p>
                    <?php include "svg.php"; ?>
                  </div>
      </section>


    
<?php include "footer.php";  ?>
