<?php
define('TITLE', "Food collection");
define('PAGE', "food collect");

// For pagination
$limit = 10;
if(isset($_REQUEST['page'])){
  $page = $_REQUEST['page'];
}else{
  $page = 1;
}
$offset = ($page - 1) * $limit;

// State details
if(isset($_REQUEST['state'])){
  $state_id = $_REQUEST['state'];
}else {
  $state_id = 0;
}

include "header.php";

// Delete food
if(isset($_REQUEST['food_id'])){
  $food_id = $_REQUEST['food_id'];
  $sql = "DELETE FROM food WHERE food_id = ?";
  $values = array($food_id);
  $row = $db->insert($sql, $values);
  if($row){
    $msg = '<div class="alert alert-success" id="add-success">Delete successfully</div>';
  }
  
}

?>

<div id="admin-content">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <h3>All Food Donated</h3>
            </div>
            <div class="col-md-4">
                <label for="state">Select State : </label>
                <form action="" class=""> 
                <select name="state" id="state" class="w3-input w3-border w3-round">
                <option value="0" selected>All States</option>
                <?php 
                    $sql = "SELECT * FROM state";
                    $values = array();
                    $row = $db->query($sql, $values);
                    if($row){
                        foreach($row as $value){
                          if($value['state_id'] == $state_id){$selected = "selected";}else{$selected = "";}
                         echo "<option value=".$value['state_id']." ".$selected.">".$value['state_name']."</option>";
                        }
                    }
                ?>
                </select>
            </div>
            <div class="col-md-2">
              <input type="submit" value="Search" class="w3-button w3-green my-2 mb-1">
            </div>
            </form>
        </div>
                    
        <div class="row">
        <?php if(isset($msg)){echo $msg; } ?>
            <div class="col-md-12">
                <table class="content-table">
                    <thead>
                        <th>S.No</th>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <?php if($state_id == 0){ ?>
                          <th>State</th>
                        <?php } ?>
                        <th>Address Line</th>
                        <th>Food Detail</th>
                        <th>Cooking Timing</th>
                        <th>Collected By</th>
                        <th>Action</th>
                    </thead>
                    <tbody>
                    <?php
                        if($state_id == 0){
                          $sql = "SELECT food_id, name, donor_name, email, cooking_timing, phone, state_name, collect, full_address, username FROM food INNER JOIN state ON
                          state.state_id = food.state INNER JOIN user ON food.state = user.state WHERE food.collect = ?
                          ORDER BY food_id DESC LIMIT ?, ?";
                          $values = array(1 ,$offset, $limit);
                        } else {
                          $sql = "SELECT food_id, name, donor_name, email , cooking_timing, phone, state_name, collect, full_address, username FROM food INNER JOIN state ON
                          state.state_id = food.state INNER JOIN user ON food.state = user.state WHERE food.state = ? AND food.collect = ?
                          ORDER BY food_id DESC LIMIT ?, ?";
                          $values = array($state_id, 1 ,$offset, $limit);
                        }
                        $rows = $db->query($sql, $values);
                        // echo "<pre>";
                        // echo print_r($rows);
                        // echo "</pre>";
                        if($rows){
                            $serial = 0;
                            foreach($rows as $row){
                            $serial += 1;
                            // here table data html
                     ?>
                        <tr>
                            <td class='id'><?php if(isset($row['food_id'])){ echo $serial; } ?></td>
                            <td><?php if(isset($row['donor_name'])){ echo $row['donor_name']; } ?></td>
                            <td><?php if(isset($row['phone'])){ echo $row['phone']; } ?></td>
                            <td><?php if(isset($row['email'])){ echo $row['email']; } ?></td>
                            <?php if($state_id == 0) echo "<td>".$row['state_name']."</td>"; ?>
                            <td><?php if(isset($row['full_address'])){ echo $row['full_address']; } ?></td>
                            <td><?php if(isset($row['name'])){ echo $row['name']; } ?></td>
                            <td><?php if(isset($row['cooking_timing'])){ echo $row['cooking_timing']; } ?></td>
                            <td><?php if(isset($row['username'])){ echo $row['username']; } ?></td>
                            <td ><a href='admin-food-collect.php?food_id=<?php if(isset($row['food_id'])){ echo $row['food_id']; } ?>' class="w3-button w3-small w3-red">Delete</a></td>
              
                        </tr>
                    <?php }}else{
                      echo "<tr><td>No records</td></tr>";
                    } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Pagination Start -->
<div class="w3-row pagination">
<?php
  if($state_id == 0){
    $sql2 = "SELECT food_id FROM food
    INNER JOIN state ON food.state = state.state_id INNER JOIN user ON user.state = food.state WHERE food.collect = ?";
    $result2 = $conn->prepare($sql2);
    $result2->execute(array(1));
  } else {
    $sql2 = "SELECT food_id FROM food
    INNER JOIN state ON food.state = state.state_id INNER JOIN user ON user.state = food.state  WHERE food.state = ? AND food.collect = ?";
    $result2 = $conn->prepare($sql2);
    $result2->execute(array($state_id, 1));    
  }
    
    $row2 = $result2->fetchAll(PDO::FETCH_ASSOC);
    /*echo '<pre>';
    echo print_r($row2);
    echo '</pre>';*/
    if($result2->rowCount()){

      $total_records = $result2->rowCount();
      $total_pages = ceil($total_records/$limit);

      echo '<ul>';
      if($page > 1){
        echo '<li class="w3-button w3-green"><a href="admin-food-collect.php?state='.$state_id.'&page='.($page-1).'" class="w3-blue p-3">Previous</a></li>';
      }
      
      for($i = 1; $i <= $total_pages; $i++){
        
        if($i == $page){
          $active = 'w3-dark-grey';
        }else{
          $active = '';
        }

        echo '<li class="w3-button w3-green '.$active.'"><a href="admin-food-collect.php?state='.$state_id.'&page='.$i.'" class="w3-blue p-3" style="padding:100%;">'.$i.'</a></li>';
      }
      if($total_pages > $page){
        echo '<li class="w3-button w3-green"><a href="admin-food-collect.php?state='.$state_id.'&page='.($page + 1).'" class="w3-blue p-3">Next</a></li>';
      }
      echo '</ul>';
    }
  ?>
</div>
<!-- Pagination End -->

<script>
    select = document.querySelector("select");
    console.log(select);
    select.addEventListener("change", (e)=>{
        let id = Number(e.target.value);
});

let add_success = document.querySelector("#add-success");
  if(add_success){
    setTimeout(() => {
      add_success.remove();
    }, 3000);
  }
</script>

<?php include "footer.php"; ?>
