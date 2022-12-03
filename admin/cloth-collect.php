<?php
// For pagination
$limit = 10;
if(isset($_REQUEST['page'])){
  $page = $_REQUEST['page'];
}else{
  $page = 1;
}
$offset = ($page - 1) * $limit;

define('TITLE', "Cloth collection");
define('PAGE', "cloth collect");
include "header.php";

?>

<div id="admin-content">
  <div class="container">
    <h4 class="w3-center">All clothes donated</h4>       
    <div class="row">
      <div class="col-md-12">
        <table class="content-table">
          <thead>
            <th>S.No</th>
            <th>Name</th>
            <th>Phone</th>
            <th>Email</th>
            <th>Address Line</th>
            <th>Cloth Detail</th>
          </thead>
          <tbody>
          <?php 
            $sql = "SELECT cloth_id, name, email, phone, state_name, collect, full_address, cloth_detail FROM clothes INNER JOIN state ON
            state.state_id = clothes.state WHERE clothes.state = ? AND clothes.collect = ?
            ORDER BY cloth_id DESC LIMIT ?, ?";
            $values = array($login_state, 1 ,$offset, $limit);
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
                <td class='id'><?php if(isset($row['clothes_id'])){ echo $serial; } ?></td>
                <td><?php if(isset($row['name'])){ echo $row['name']; } ?></td>
                <td><?php if(isset($row['phone'])){ echo $row['phone']; } ?></td>
                <td><?php if(isset($row['email'])){ echo $row['email']; } ?></td>
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
    $sql2 = "SELECT cloth_id FROM clothes
    INNER JOIN state ON clothes.state = state.state_id WHERE clothes.state = ? AND clothes.collect = ?";
    
    $result2 = $conn->prepare($sql2);
    $result2->execute(array($login_state, 1));
    
    $row2 = $result2->fetchAll(PDO::FETCH_ASSOC);
    /*echo '<pre>';
    echo print_r($row2);
    echo '</pre>';*/

    if($result2->rowCount()){

      $total_records = $result2->rowCount();
      $total_pages = ceil($total_records/$limit);

      echo '<ul>';
      if($page > 1){
        echo '<li class="w3-button w3-green"><a href="cloth.php?page='.($page-1).'" class="w3-blue p-3">Previous</a></li>';
      }
      
      for($i = 1; $i <= $total_pages; $i++){
        
        if($i == $page){
          $active = 'w3-dark-grey';
        }else{
          $active = '';
        }

        echo '<li class="w3-button w3-green '.$active.'"><a href="cloth.php?page='.$i.'" class="w3-blue p-3" style="padding:100%;">'.$i.'</a></li>';
      }
      if($total_pages > $page){
        echo '<li class="w3-button w3-green"><a href="cloth.php?page='.($page + 1).'" class="w3-blue p-3">Next</a></li>';
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
</script>

<?php include "footer.php"; ?>