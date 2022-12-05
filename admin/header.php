<?php
include("loginredirect.php");

?>
<!DOCTYPE lang="en">
  <head>
    
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width , initial-scale=1.0">
    <!-- <link href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css" rel="stylesheet"> -->
    <link rel="stylesheet" href="../css/tailwind.css">
    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="../css/w3css.css">
    <link rel="stylesheet" href="../css/style.css">


    <title>Donation</title>
  </head>
<body>
    
    <header class="text-white-600 body-font">
        <header style="background-color:#5658df;">
        <div class="container mx-auto flex flex-wrap p-5 flex-col md:flex-row items-center">
          <a class="flex title-font font-medium items-center text-gray-900 mb-4 md:mb-0">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-10 h-10 text-white p-2 bg-indigo-500 rounded-full" viewBox="0 0 24 24">
              <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"></path>
            </svg>
            <span class="ml-3 text-xl text-white">Donation Management</span>
          </a>
          <nav class="md:mr-auto md:ml-4 md:py-1 md:pl-4 md:border-l md:border-gray-400	flex flex-wrap items-center text-base justify-center">
            <?php if($user_type == 0){ ?>
            <a href="admin-food.php" class="mr-5 hover:text-white-900 text-white <?php if(PAGE == "food"){echo "w3-blue w3-round w3-padding";} ?>">Food</a>
            <a href="admin-cloth.php" class="mr-5 hover:text-white-900 text-white <?php if(PAGE == "cloth"){echo "w3-blue w3-round w3-padding";} ?>">Cloth</a>
            <a href="admin-food-collect.php" class="mr-5 hover:text-white-900 text-white <?php if(PAGE == "food collect"){echo "w3-blue w3-round w3-padding";} ?>">Food Collect</a>
            <a href="admin-cloth-collect.php" class="mr-5 hover:text-white-900 text-white <?php if(PAGE == "cloth collect"){echo "w3-blue w3-round w3-padding";} ?>">Cloth Collect</a>
            <a href="add-users.php" class="mr-5 hover:text-white-900 text-white <?php if(PAGE == "add users"){echo "w3-blue w3-round w3-padding";} ?>">Add Users</a>
            <a href="add-state.php" class="mr-5 hover:text-white-900 text-white <?php if(PAGE == "add state"){echo "w3-blue w3-round w3-padding";} ?>">Add State</a>
            <?php } else { ?>
            <a href="dashboard.php" class="mr-5 hover:text-white-900 text-white <?php if(PAGE == "food"){echo "w3-blue w3-round w3-padding";} ?>">Food</a>
            <a href="cloth.php" class="mr-5 hover:text-white-900 text-white <?php if(PAGE == "cloth"){echo "w3-blue w3-round w3-padding";} ?>">Cloth</a>
            <a href="food-collect.php" class="mr-5 hover:text-white-900 text-white <?php if(PAGE == "food collect"){echo "w3-blue w3-round w3-padding";} ?>">Food Collect</a>
            <a href="cloth-collect.php" class="mr-5 hover:text-white-900 text-white <?php if(PAGE == "cloth collect"){echo "w3-blue w3-round w3-padding";} ?>">Cloth Collect</a>
            <?php } ?>

            <a href="logout.php" class="mr-5 hover:text-white-900 text-white">Logout</a>
          </nav>
          <h4 class="text-white-500">
          <?php
           echo $login_username.", "; 
            $sql = "SELECT state_name FROM state WHERE state_id = ?";
            $values = array($login_state);
            $row = $db->query($sql, $values);
            if($row){
              echo $row[0]['state_name'];
            }
           ?></h4>
          <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-4 h-4 ml-1" viewBox="0 0 24 24">
            <path d="M5 12h14M12 5l7 7-7 7"></path>
          </svg>
        </div>
        
      </header>
    </header>
