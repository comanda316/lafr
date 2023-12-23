<?php
  $user = $_GET['user'];
  require_once '../config/connection.php';
  $query = "SELECT * FROM users WHERE LOWER(gameName) REGEXP LOWER(:user) LIMIT 3";
  $statement = $conn->prepare($query);
  $statement->execute([":user" => $user]);
  $results = $statement->fetchAll(PDO::FETCH_ASSOC);
?>

<?php if ($results == true): ?>
<?php foreach($results as $result): ?>
  <a id="userid" href="<?php echo $base_url; ?>database/user.php?userID=<?php echo $result['id']; ?>">
  <div class="user-result">
      <p><i class="fa-solid fa-fingerprint"></i> <?php echo $result['gameName'];?> (ID: <?php echo $result['id'];?>) 
      <?php
      if ($result['isAdmin'] == 1) {
        echo "<code id='isAdmin'>Administrator</code>";
      }
      ?>
      </p>
  </div>
</a>
<?php endforeach; ?>

<?php else: ?>
<a href="">
  <div class="user-result-error">
      <p><i class="fa-solid fa-triangle-exclamation"></i> User not found.</p>
</div>
</a>
<?php endif ?>