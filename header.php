<?php require_once "connection.php"; ?>
<!DOCTYPE lang="en">
    <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width , initial-scale=1.0">
      <!-- <link href="https://unpkg.com/tailwindcss@^2.0/dist/tailwind.min.css" rel="stylesheet"> -->
      <link rel="stylesheet" href="css/tailwind.css">
      <link rel="stylesheet" href="css/w3css.css">
      
      <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
      <!-- <link rel="stylesheet" href="css/bootstrap.css"> -->
      <title>Donation</title>  
    </head>
<body>
  <header class="text-gray-600 body-font">
      <header style="background-color:#5658df;">
      <div class="container mx-auto flex flex-wrap p-5 flex-col md:flex-row items-center">
        <a class="flex title-font font-medium items-center text-gray-900 mb-4 md:mb-0">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-10 h-10 text-white p-2 bg-indigo-500 rounded-full" viewBox="0 0 24 24">
            <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"></path>
          </svg>
          <span class="ml-3 text-xl text-white">Donation Management</span>
        </a>
        <nav class="md:mr-auto md:ml-4 md:py-1 md:pl-4 md:border-l md:border-gray-400	flex flex-wrap items-center text-base justify-center">

          <a href="<?php echo $hostname; ?>" class="mr-5 hover:text-white-900 text-white <?php if(PAGE == 'index'){ echo 'w3-blue w3-round w3-padding'; } ?>">Home</a>
          <a href="Donation.php" class="mr-5 hover:text-white-900 text-white <?php if(PAGE == 'donation' || PAGE == 'clothes' || PAGE == 'money' || PAGE == 'food'){ echo 'w3-blue w3-round w3-padding'; } ?>">Donate</a>
          <a href="mission.php" class="mr-5 hover:text-white-900 text-white <?php if(PAGE == 'mission'){ echo 'w3-blue w3-round w3-padding'; } ?>">Mission</a>
          <a href="about.php" class="mr-5 hover:text-white-900 text-white <?php if(PAGE == 'about'){ echo 'w3-blue w3-round w3-padding'; } ?>">About</a>
          <a href="login.php" class="mr-5 hover:text-white-900 text-white">Login</a>
        </nav>
            <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-4 h-4 ml-1" viewBox="0 0 24 24">
            <path d="M5 12h14M12 5l7 7-7 7"></path>
          </svg>
      </div>
    </header>
  </header>