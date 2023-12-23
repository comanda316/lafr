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
                    $caseID = $_GET['caseID'];
                    require_once '../config/connection.php';
                    $query = "SELECT * FROM arrestreports WHERE caseID = :caseID";
                    $statement = $conn->prepare($query);
                    $statement->execute([":caseID" => $caseID]);
                    $arrestreport = $statement->fetch(PDO::FETCH_ASSOC);
                ?>
            </div>
            <?php if ($arrestreport == true): ?>
                <div class="file-ui-text-top citation">
                    <div class="file-ui-data-top-left">
                        <i class="fa-solid fa-handcuffs"></i>
                        <code>#<?php echo $arrestreport['caseID'];?></code>
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
                            <h1>DATE AND TIME</h1>
                            <code><?php echo $arrestreport['date'] ?> <?php echo $arrestreport['time'] ?></code>
                        </div>
                        <div>
                            <h1>LOCATION</h1>
                            <code><?php echo $arrestreport['city'] ?></code>
                            <code><?php echo $arrestreport['zip'] ?></code>
                            <code><?php echo $arrestreport['city'] ?><?php echo $arrestreport['street'] ?></code>
                        </div>
                        <div>
                            <h1>ARRESTING OFFICER</h1>
                            <code><?php echo clean($arrestreport['arrestingOfficer']); ?></code>
                        </div>
                        <div>
                            <h1>SUSPECT</h1>
                            <code><?php echo $arrestreport['defendantName']; ?></code>
                        </div>
                        <div>
                            <h1>CHARGES</h1>
                            <code><?php echo clean(substr($arrestreport['charges'], 0, 54)); ?></code>
                        </div>
                    </div>
                    <div class="file-ui-text right">
                        <div>
                            <h1><i class="fa-solid fa-file-shield"></i> TRANSCRIPT</h1>
                            <p><?php echo $arrestreport['factsOfArrest'] ?></p>
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