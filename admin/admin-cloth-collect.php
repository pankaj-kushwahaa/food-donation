<?php
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

define('TITLE', "Cloth collection");
define('PAGE', "cloth collect");
include "header.php";

// Delete clothes
if(isset($_REQUEST['cloth_id'])){
  $cloth_id = $_REQUEST['cloth_id'];
  $sql = "DELETE FROM clothes WHERE cloth_id = ?";
  $values = array($cloth_id);
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
                <h3>All clothes Donated</h3>
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
                        <th>Cloth Detail</th>
                        <th>Collected By</th>
                        <th>Action</th>
                    </thead>
                    <tbody>
                    <?php 
                    if($state_id == 0){
                      $sql = "SELECT cloth_id, name, email, phone, state_name, collect, username, full_address, cloth_detail FROM clothes INNER JOIN state ON
                      state.state_id = clothes.state INNER JOIN user ON clothes.state = user.state WHERE clothes.collect = ?
                      ORDER BY cloth_id DESC LIMIT ?, ?";
                      $values = array(1 ,$offset, $limit);
                    } else {
                      $sql = "SELECT cloth_id, name, email, phone, state_name, collect, username, full_address, cloth_detail FROM clothes INNER JOIN state ON
                      state.state_id = clothes.state INNER JOIN user ON clothes.state = user.state WHERE clothes.state = ? AND clothes.collect = ?
                      ORDER BY cloth_id DESC LIMIT ?, ?";
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
                            <td class='id'><?php if(isset($row['cloth_id'])){ echo $serial; } ?></td>
                            <td><?php if(isset($row['name'])){ echo $row['name']; } ?></td>
                            <td><?php if(isset($row['phone'])){ echo $row['phone']; } ?></td>
                            <td><?php if(isset($row['email'])){ echo $row['email']; } ?></td>
                            <?php if($state_id == 0) echo "<td>".$row['state_name']."</td>"; ?>
                            <td><?php if(isset($row['full_address'])){ echo $row['full_address']; } ?></td>
                            <td><?php if(isset($row['cloth_detail'])){ echo $row['cloth_detail']; } ?></td>
                            <td><?php if(isset($row['username'])){ echo $row['username']; } ?></td>
                            <td ><a href='admin-cloth-collect.php?cloth_id=<?php if(isset($row['cloth_id'])){ echo $row['cloth_id']; } ?>' class="w3-button w3-small w3-red">Delete</a></td>
                        </tr>
                    <?php }} ?>
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
      // $sql2 = "SELECT food_id FROM food
      // INNER JOIN state ON food.state = state.state_id INNER JOIN user ON user.state = food.state WHERE food.collect = ?";
      $sql2 = "SELECT cloth_id FROM clothes
      INNER JOIN state ON clothes.state = state.state_id WHERE clothes.collect = ?";
      $result2 = $conn->prepare($sql2);
      $result2->execute(array(1));
    } else {
      // $sql2 = "SELECT food_id FROM food
      // INNER JOIN state ON food.state = state.state_id INNER JOIN user ON user.state = food.state  WHERE food.state = ? AND food.collect = ?";
      $sql2 = "SELECT cloth_id FROM clothes
      INNER JOIN state ON clothes.state = state.state_id WHERE clothes.state = ? AND clothes.collect = ?";
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
        echo '<li class="w3-button w3-green"><a href="admin-cloth-collect.php?state='.$state_id.'&page='.($page-1).'" class="w3-blue p-3">Previous</a></li>';
      }
      
      for($i = 1; $i <= $total_pages; $i++){
        
        if($i == $page){
          $active = 'w3-dark-grey';
        }else{
          $active = '';
        }

        echo '<li class="w3-button w3-green '.$active.'"><a href="admin-cloth-collect.php?state='.$state_id.'&page='.$i.'" class="w3-blue p-3" style="padding:100%;">'.$i.'</a></li>';
      }
      if($total_pages > $page){
        echo '<li class="w3-button w3-green"><a href="admin-cloth-collect.php?state='.$state_id.'&page='.($page + 1).'" class="w3-blue p-3">Next</a></li>';
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