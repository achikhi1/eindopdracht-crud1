<?php
// include 'conection.php';

$servername = "localhost";
$username = "root";
$password = null;

try {
  $conn = new PDO("mysql:host=$servername;dbname=portfolio1", $username, $password);
  // set the PDO error mode to exception
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  echo "Connected successfully";
} catch (PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}
if (isset($_GET["id"])) {
  $id = $_GET["id"];
} else {
  $id = 1;
}
try {
  $conn = new PDO("mysql:host=$servername;dbname=portfolio1", $username, $password);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $stmt = $conn->prepare("SELECT * FROM portfolio2 ");
  $stmt->execute();

  // set the resulting array to associative
  $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
  echo "Error: " . $e->getMessage();
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Portfolio Website - Overzichtspagina</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
</head>

<body>

  <div class="d-flex justify-content-center align-items-center m-4">
    <form method="get" action="">
      <input type="search" name="zoeken" placeholder="zoeken naar...">
      <input type="submit" value="zoeken">

    </form>
    <nav aria-label="search and filter">
    </nav>
  </div>
    <?php
    if (isset($_GET["zoeken"]))
    {
      $zoekenop = "%".$_GET["zoeken"]."%";
      $stmt = $conn->prepare("SELECT * FROM portfolio2 WHERE titel LIKE :zoeken ORDER BY id ASC");
      $stmt->bindParam(':zoeken', $zoekenop);
    }
    else{
      $stmt = $conn->prepare("SELECT * FROM portfolio2");
    }

    ?>
  <?php
  try {

    $stmt->execute();

    // set the resulting array to associative
    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
    foreach ($stmt->fetchall() as $k => $v) {

  ?>
      <main>
        <div class="container">
          <div class="row row-cols-1 row-cols-sm-1 row-cols-md-1 g-1 portfolio2">
            <div id="project1" class="project card shadow-sm card-body m-2">
              <div class="card-text">
                <h2><?php echo ($v['titel']); ?></h2>
                <div><?php echo ($v['omschrijving']); ?></div>
              </div>
              <div class="d-flex justify-content-between align-items-center mt-3">
                <div class="btn-group">
                  <a href="detail.php?id=<?php echo ($v['id']); ?>"><button type="button" class="btn btn-sm btn-outline-secondary">
                      View</a>
                  </button>
                  <button type="button" class="btn btn-sm btn-outline-secondary">
                    Edit
                  </button>
                  <button type="button" class="btn btn-sm btn-outline-secondary">
                    Delete
                  </button>
                </div>
              </div>
            </div>
      </main>
  <?php

    }
  } catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
  }
  ?>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>