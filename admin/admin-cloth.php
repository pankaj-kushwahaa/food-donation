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

define('TITLE', "Cloth");
define('PAGE', "cloth");
include "header.php"; 

?>

<div id="admin-content">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <h3>All Cloth Donation Requests</h3>
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
            <div class="col-md-12">
                <table class="content-table">
                    <thead>
                        <th>S.No</th>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>State</th>
                        <th>Address Line</th>
                        <th>Cloth Detail</th>
                    </thead>
                    <tbody>
                    <?php
                      if($state_id == 0){
                        $sql = "SELECT name, email, cloth_detail, phone, full_address, state_name, state_id FROM clothes INNER JOIN state ON
                        state.state_id = clothes.state WHERE clothes.collect = ?
                        ORDER BY cloth_id DESC LIMIT ?, ?";
                        $values = array(0 ,$offset, $limit);
                      } else {
                        $sql = "SELECT name, email, cloth_detail, phone, full_address, state_name, state_id FROM clothes INNER JOIN state ON
                        state.state_id = clothes.state WHERE clothes.state = ? AND clothes.collect = ?
                        ORDER BY cloth_id DESC LIMIT ?, ?";
                        $values = array($state_id, 0 ,$offset, $limit);
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
                            <td><?php if(isset($row['state_name'])){ echo $row['state_name']; } ?></td>
                            <td><?php if(isset($row['full_address'])){ echo $row['full_address']; } ?></td>
                            <td><?php if(isset($row['cloth_detail'])){ echo $row['cloth_detail']; } ?></td>
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
    $sql2 = "SELECT cloth_id FROM clothes
    INNER JOIN state ON clothes.state = state.state_id WHERE clothes.collect = ?";
    $result2 = $conn->prepare($sql2);
    $result2->execute(array(0));
  } else {
    $sql2 = "SELECT cloth_id FROM clothes
    INNER JOIN state ON clothes.state = state.state_id WHERE clothes.state = ? AND clothes.collect = ?";
    $result2 = $conn->prepare($sql2);
    $result2->execute(array($state_id, 0));    
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
        echo '<li class="w3-button w3-green"><a href="admin-cloth.php?state_id='.$state_id.'&page='.($page-1).'" class="w3-blue p-3">Previous</a></li>';
      }
      
      for($i = 1; $i <= $total_pages; $i++){
        
        if($i == $page){
          $active = 'w3-dark-grey';
        }else{
          $active = '';
        }

        echo '<li class="w3-button w3-green '.$active.'"><a href="admin-cloth.php?state_id='.$state_id.'&page='.$i.'" class="w3-blue p-3" style="padding:100%;">'.$i.'</a></li>';
      }
      if($total_pages > $page){
        echo '<li class="w3-button w3-green"><a href="admin-cloth.php?state_id='.$state_id.'&page='.($page + 1).'" class="w3-blue p-3">Next</a></li>';
      }
      echo '</ul>';
    }
  ?>

</div>
<!-- Pagination End -->

<?php include "footer.php"; ?>
