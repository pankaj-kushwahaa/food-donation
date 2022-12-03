<?php
define('TITLE', "Add state");
define('PAGE', "add state");
include "header.php";

// if(isset($_REQUEST['del_id'])){
//   $state_id = $_REQUEST['del_id'];
//   $sql = "DELETE FROM state WHERE state_id = ?";
//   $values = array($state_id);
//   $rows = $db->insert($sql, $values);
//   if($rows) $msg = '<div class="alert alert-success" id="add-success">Deleted successfully</div>'; 
// }


if(isset($_REQUEST['state_id'])){
  $state_id = $_REQUEST['state_id'];
  $sql = "SELECT * FROM state WHERE state_id = ?";
  $values = array($state_id);
  $rows = $db->query($sql, $values);
}

// Add state
if(isset($_REQUEST['Submit'])){

  $state = $_REQUEST['state'];

  $st = preg_match("/^([A-Za-z]{4,})$/", $_REQUEST['state']);
  if($st){
    $sql = "INSERT INTO state (state_name) VALUES (?)";
    $values = array($state);
    $row = $db->insert($sql, $values);
    if($row){
      $msg = '<div class="alert alert-success" id="add-success">Added successfully</div>';
    }
  } else {
    $msg = '<div class="alert alert-danger">Fill all fields with valid inputs</div>';
  }
}

if(isset($_REQUEST['Update'])){

  $state = $_REQUEST['state'];
  $state_id = $_REQUEST['state_id'];

  $st = preg_match("/^([A-Za-z]{4,})$/", $_REQUEST['state']);
  if($st){
    $sql = "UPDATE state SET state_name = ? WHERE state_id = ?";
    $values = array($state, $state_id);
    $row = $db->insert($sql, $values);
    if($row){
      $msg = '<div class="alert alert-success" id="add-success">Updated successfully</div>';
    }
  } else {
    $msg = '<div class="alert alert-danger">Fill all fields with valid inputs</div>';
  }
}


?>
<div class="container">
  <div class="row">
    <div class="col-md-4">
      <h4 class="text-center">Add State</h4>
      <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="m-4">
        <label for="state">State</label>
        <input type="text" name="state" id="state" class="w3-input w3-border w3-round mb-3" value="<?php if(isset($rows[0])) echo $rows[0]['state_name']; ?>">
        <?php if(isset($state_id)){ ?>
          <input type="hidden" name="state_id" value="<?php if(isset($rows[0])) echo $rows[0]['state_id']; ?>">
          <input type="submit" value="Update" name="Update" class="w3-button w3-border w3-round w3-green" >
        <?php }else{ ?>
          <input type="submit" value="Submit" name="Submit" class="w3-button w3-border w3-round w3-green">
        <?php } ?>
        
      </form>
      <?php if(isset($msg)){echo $msg; } ?>
    </div>
    <div class="col-md-6">
      <h4 class="text-center">State Names</h4>
      <table class="w3-table w3-border w3-bordered w3-white m-4">
        <thead>
            <th>S.No</th>
            <th>State</th>
            <th>Edit</th>
        </thead>
        <tbody>
            <?php
              $sql = "SELECT * FROM state";
              $values = array();
              $rows = $db->query($sql, $values);
              if($rows){
                $serial = 0;
                foreach($rows as $row){
                  $serial++ ;
                  echo "<tr>";
                  echo "<td>".$serial."</td>";
                  echo "<td>".$row['state_name']."</td>";
                  echo "<td><a href='add-state.php?state_id=".$row['state_id']."' class='w3-button w3-round w3-green w3-small'>Edit</a></td>";
                  // echo "<td><a href='add-state.php?del_id=".$row['state_id']."' class='w3-button w3-round w3-red w3-small'>Delete</a></td>";
                  echo "</tr>";
                }
              }
            ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<script>
  let add_success = document.querySelector("#add-success");
  if(add_success){
    setTimeout(() => {
      add_success.remove();
    }, 3000);
  }
</script>
<?php include "footer.php"; ?>