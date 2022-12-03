<?php  
// For pagination
$limit = 1;
if(isset($_REQUEST['page'])){
  $page = $_REQUEST['page'];
}else{
  $page = 1;
}
$offset = ($page - 1) * $limit;

define('TITLE', "Add Users");
define('PAGE', 'add users');
include "header.php";

$msg = '';

if(isset($_REQUEST['del_id'])){
  $del_id = $_REQUEST['del_id'];
  $sql = "DELETE FROM user WHERE id = ?";
  $values = array($del_id);
  $row = $db->insert($sql, $values);
  if($row){
    $msg = '<div class="alert alert-danger" id="add-success">Delete successfully</div>';
  }
}
// Add User Code
if(isset($_REQUEST['Submit'])){

  $username = $_REQUEST['username'];
  $phone = $_REQUEST['phone'];
  $state = $_REQUEST['state'];
  $password = $_REQUEST['password'];

  $em = preg_match("/^([A-Za-z0-9@.]{4,})$/", $_REQUEST['username']);
  $ph = preg_match("/^([0-9]{10,12})$/", $_REQUEST['phone']);
  $st = preg_match("/^([0-9]{1,})$/", $_REQUEST['state']);
  $pas = preg_match("/^([A-Za-z0-9@.-]{4,})$/", $_REQUEST['password']);

  if($em && $ph && $st && $pas){

    $sql = "SELECT username from user WHERE username = ?";
    $values = array($email);
    $row = $db->query($sql, $values);
    if($row){
      $msg = '<div class="alert alert-danger">User already registered</div>';
    }else{
      $sql = "INSERT INTO user (username, phone_number,state, password, user_type) VALUES (?, ?, ?, ?, ?)";
      $values = array($username, $phone, $state, md5($password), 1);
      $row = $db->query($sql, $values);
      if($row){ 
        $msg = '<div class="alert alert-success" id="add-success">User added successfully</div>'; 
      }
    } 
  } else {
  $msg = '<div class="alert alert-danger">Fill all fields with valid inputs</div>';
  }
}
// Update Code
if(isset($_REQUEST['Update'])){

  $username = $_REQUEST['username'];
  $phone = $_REQUEST['phone'];
  $state = $_REQUEST['state'];
  $password = $_REQUEST['password'];
  $id = $_REQUEST['user_id'];

  $em = preg_match("/^([A-Za-z0-9@.]{4,})$/", $_REQUEST['username']);
  $ph = preg_match("/^([0-9]{10,12})$/", $_REQUEST['phone']);
  $st = preg_match("/^([0-9]{1,})$/", $_REQUEST['state']);
  $pas = preg_match("/^([A-Za-z0-9@.-]{4,})$/", $_REQUEST['password']);

  if($em && $ph && $st && $pas){
    $sql = "UPDATE user SET email = ?,  phone_number = ?, state = ?, password = ? WHERE id = ?";
    $values = array($email, $phone, $state, md5($password), $id);
    $row = $db->query($sql, $values);
    // echo print_r($row);
    if($row == 1){ 
      $msg = '<div class="alert alert-success" id="add-success">Updated successfully</div>'; }
  } else {
    $msg = '<div class="alert alert-danger">Fill all fields with valid inputs</div>';
  }
}

$result = "";
if(isset($_REQUEST['id'])){
  $id = $_REQUEST['id'];
  $sql = "SELECT id, username, phone_number, state_name, state FROM user INNER JOIN state ON state.state_id = user.state WHERE user.id = ?";
  $values = array($id);
  $result = $db->query($sql, $values);
//   echo "<pre>";
// echo print_r($result);
// echo "</pre>";
}

?>
<div class="w3-container">
  <div class="row py-2 mx-3">
    <div class="col-md-4">
      <h3 class="w3-center">Add Volunteers</h3>
      <?php if($msg){echo $msg; } ?>
      <form id="form" action="add-users.php" method="post" enctype="multipart/form-data">
        <div class="py-2">
          <label for="username">Email </label>
          <input type="text" name="username" id="username" class="w3-input w3-border w3-round" value="<?php if(isset($result[0]['username'])){echo $result[0]['username']; } ?>">
        </div>
        <div class="py-2">
          <label for="phone">Phone</label>
          <input type="number" name="phone" id="phone" class="w3-input w3-border w3-round" value="<?php if(isset($result[0]['phone_number'])){echo $result[0]['phone_number']; } ?>">
        </div>
        <div class="py-2">
          <label for="state">State </label>
          <select name="state" id="state" class="w3-input w3-border w3-round">
            <option value="<?php if(isset($result[0]['state'])){echo $result[0]['state']; } ?>" selected><?php if(isset($result[0]['state_name'])){ echo $result[0]['state_name']; }else{echo "Select"; } ?></option>
            <?php
              $sql = "SELECT * FROM state";
              $values = array();
              $value = $db->query($sql, $values);
              if($value){
                foreach($value as $a){
                  echo "<option value=".$a['state_id'].">".$a['state_name']."</option>";
                }
              }
            ?>
          </select>
        </div>
        <div class="py-2">
          <label for="password">Password</label>
          <input type="password" name="password" id="password" class="w3-input w3-border">
          <input type="hidden" name="user_id" value="<?php if(isset($result[0]['id'])){ echo $result[0]['id']; } ?>">
        </div>
        <div class="py-2">
          <?php if(isset($id)){ ?>
            <input type="submit" value="Update" name="Update" class="w3-button w3-green w3-round">
          <?php }else { ?>
            <input type="submit" value="Add" name="Submit" id="btn" class="w3-button w3-green w3-round">
          <?php } ?>
        </div>
      </form>
    </div>

    <div class="col-md-8">
      <h3 class="admin-heading">All Volunteers</h3>
      <table class="w3-table w3-border w3-bordered w3-white">
        <thead>
          <th>S.No.</th>
          <th>Email</th>
          <th>Phone</th>
          <th>Location</th>
          <th>Edit</th>
          <th>Delete</th>
        </thead>
        <tbody>   
          <?php 
            $sql = "SELECT id, username, phone_number, state_name FROM user INNER JOIN state ON
            state.state_id = user.state ORDER BY id LIMIT ?, ?";
            $values = array($offset, $limit);
            $row = $db->query($sql, $values);
          //   echo "<pre>";
          // echo print_r($row);
          // echo "</pre>";
            if($row){
              $serial = 0;
              foreach($row as $value){
                $serial += 1;
          ?>
          <tr>
            <td class='id'><?php if(isset($value['id'])){ echo $serial; } ?></td>
            <td><?php if(isset($value['username'])){ echo $value['username']; } ?></td>
            <td><?php if(isset($value['phone_number'])){ echo $value['phone_number']; } ?></td>
            <td><?php if(isset($value['state_name'])){ echo $value['state_name']; } ?></td>
            <td class='edit'>
              <a href="add-users.php?id=<?php if(isset($value['id'])){ echo $value['id']; } ?>" class="w3-btn w3-round w3-green w3-small">Edit</a>
            </td>
            <td>
                <a href="add-users.php?del_id=<?php if(isset($value['id'])){ echo $value['id']; } ?>" class="w3-btn w3-round w3-red w3-small">Delete</a>
            </td>
          </tr>
          <?php }}  ?>
        </tbody>
      </table>     
      </div>
  </div>
</div>

    <!-- Pagination Start -->
    <div class="w3-row pagination">
  <?php
    $sql2 = "SELECT id FROM user
    INNER JOIN state ON user.state = state.state_id";
    
    $result2 = $conn->prepare($sql2);
    $result2->execute(array());
    $row2 = $result2->fetchAll(PDO::FETCH_ASSOC);

    if($result2->rowCount()){
      $total_records = $result2->rowCount();
      $total_pages = ceil($total_records/$limit);
      echo '<ul>';
      if($page > 1){
        echo '<li class="w3-button w3-green"><a href="add-users.php?page='.($page-1).'" class="p-3 ">Previous</a></li>';
      }
      
      for($i = 1; $i <= $total_pages; $i++){
        
        if($i == $page){
          $active = 'w3-dark-grey';
        }else{
          $active = '';
        }

        echo '<li class="w3-button w3-green '.$active.'"><a href="add-users.php?page='.$i.'" class="p-3">'.$i.'</a></li>';
      }
      if($total_pages > $page){
        echo '<li class="w3-button w3-green"><a href="add-users.php?page='.($page + 1).'" class="p-3">Next</a></li>';
      }
      echo '</ul>';
    }
  ?>

</div>
<!-- Pagination End -->


<script>
  // submitbtn = document.getElementById('btn');
  
  // submitbtn.addEventListener('click', (e)=>{
  //   e.preventDefault();
  //   console.log(document.getElementById("form"));


  //   const email = document.querySelector("#email").value;
  //   const phone = document.querySelector("#phone").value;
  //   const state = document.querySelector("#state").value;
  //   const password = document.querySelector("#password").value;
    
  //   // Validating values with regular expression
  //   let ema = /^([a-z0-9@.]{4,})$/.test(email);
  //   let pho = /^([a-z0-9]{10,12})$/.test(phone);
  //   let sta = /^([a-z0-9])$/.test(state);
  //   let pass = /^([a-z0-9]{4,})$/.test(password);
  //   let errors = new Array();

  //   let em = document.getElementById('error_email');
  //   if(em) em.remove();
  //   if(!ema){
  //     let em = document.getElementById('email');
  //     em.insertAdjacentHTML("afterend", 
  //     '<small style="color:red;" id="error_email">Invalid email</small>');
  //     errors.push("email");
  //   }

  //   let ph = document.getElementById('error_phone');
  //   if(ph) ph.remove();
  //   if(!pho){
  //     let em = document.getElementById('phone');
  //     em.insertAdjacentHTML("afterend", 
  //     '<small style="color:red;" id="error_phone">Invalid phone number</small>');
  //     errors.push("phone");
  //   }
    
  //   let st = document.getElementById('error_state');
  //   if(st) st.remove();
  //   if(!sta){
  //     let em = document.getElementById('state');
  //     em.insertAdjacentHTML("afterend", 
  //     '<small style="color:red;" id="error_state">Please select a state</small>');
  //     errors.push("state");
  //   }

  //   let pas = document.getElementById('error_password');
  //   if(pas) pas.remove();
  //   if(!pass){
  //     let em = document.getElementById('password');
  //     em.insertAdjacentHTML("afterend", 
  //     '<small style="color:red;" id="error_password">Enter five & more characters for password</small>');
  //     errors.push("password");
  //   }
  //   console.log(errors);
  //   console.log(errors.length);
  //   if(errors.length == 0){ 
  //     document.getElementById("form").submit();
  //   }
  // });

  let add_success = document.querySelector("#add-success");
  if(add_success){
    setTimeout(() => {
      add_success.remove();
    }, 3000);
  }
</script>

<?php
include "footer.php";
?>