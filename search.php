<?php 

require 'includes/db.php';
function searchUser($link, $query) {
  $query = trim($query);
  $sql = "SELECT id, first_name, last_name FROM users WHERE first_name LIKE '%$query%' OR last_name LIKE '%$query%'";
  $result = $link->query($sql);


  if ($result->num_rows > 0) {
 
    $output = "<p>По запросу <b>$query</b> найдено совпадений: $result->num_rows</p>";
    while ($row = $result->fetch_assoc()) {
    
        header("Location: friend?id=" . $row['id']); 
      exit();
    }
  } else {
    $output = "<div class='alert alert-danger'><p>По вашему запросу ничего не найдено.</p></div>";
  }

  return $output;
}


if (isset($_POST['query'])) {
  $searchQuery = $_POST['query'];
  echo searchUser($link, $searchQuery);
}


$page = [
  'title' => 'Поиск',
  'content' => $output
];

return $page;


$link->close();


?>