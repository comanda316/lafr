<?php require_once '../config/config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords" content="FivePD, FiveM, Cops, LivePD">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="The ultimate virtual lore-friendly emergency services experience.">
    <meta name="theme-color" content="hsl(216, 42%, 17%)">
    <meta property="og:title" content="The Watch" />
    <meta property="og:url" content="https://www.thewatchrp.com/" />
    <meta property="og:image" content="assets/img/logo.png" />
    <title>The Watch</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="shortcut icon" href="../assets/img/favicon.ico">
    <script src="https://kit.fontawesome.com/b1f24b50ab.js" crossorigin="anonymous"></script>
</head>
<body>
    <?php require_once '../layout/header.php'; ?>
    <main>
        <div class="wrapper">
            <a id="back-button" href="../index.php"><i class="fa-solid fa-caret-left"></i> BACK</a>
            <div class="file-ui">
                <?php
                    function clean($string) 
                    {
                        $string = str_replace(' ', ' ', $string); // Replaces all spaces with hyphens.
    
                        return preg_replace('/[^A-Za-z0-9\-]/', ' ', $string); // Removes special chars.
                    }
                    $citationID = $_GET['citationID'];
                    require_once '../config/connection.php';
                    $query = "SELECT * FROM pedcitations INNER JOIN users ON pedcitations.userID = users.id WHERE citationID = :citationID";
                    $statement = $conn->prepare($query);
                    $statement->execute([":citationID" => $citationID]);
                    $citation = $statement->fetch(PDO::FETCH_ASSOC);
                ?>
            </div>
            <?php if ($citation == true): ?>
                <div class="file-ui-text-top citation">
                    <div class="file-ui-data-top-left">
                        <i class="fa-solid fa-hand-holding-dollar"></i>
                        <code>#<?php echo $citation['citationID'];?></code>
                    </div>
                    <div class="file-ui-data-top-right">
                        <i class="fa-solid fa-compress"></i>
                        <i class="fa-solid fa-expand"></i>
                        <i class="fa-solid fa-xmark"></i>
                    </div>
                </div>
                <div class="file-ui-text">
                    <div class="file-ui-text left">
                        <div>
                            <h1>DATE & TIME</h1>
                            <code><?php echo $citation['date'] ?></code>
                            <code><?php echo $citation['time'] ?></code>
                        </div>
                        <div>
                            <h1>ISSUED BY</h1>
                            <code><?php echo $citation['gameName'] ?></code>
                        </div>
                        <div>
                            <h1>PERSON</h1>
                            <code><?php echo $citation['name'] ?></code>
                            <br>
                            <code><?php echo $citation['address'] ?></code>
                        </div>
                        <div>
                            <h1>FINE AMOUNT</h1>
                            <code>$<?php echo $citation['amount'] ?></code>
                        </div>
                        <div>
                            <h1>LOCATION</h1>
                            <code><?php echo $citation['location'] ?></code>
                        </div>
                    </div>
                    <div class="file-ui-text right">
                        <div>
                            <h1><i class="fa-solid fa-file-shield"></i> TRANSCRIPT</h1>
                            <p><?php echo clean($citation['reason']); ?></p>
                        </div>
                    </div>
                </div>
            <?php else: ?>
            <?php require_once '../layout/error.php'; ?>
            <?php endif ?>
        </div>
    </main>
</body>
</html>