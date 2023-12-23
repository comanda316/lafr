<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="keywords" content="FivePD, FiveM, Cops, LivePD">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="The ultimate virtual lore-friendly emergency services experience.">
    <meta name="theme-color" content="hsl(216, 42%, 17%)">
    <meta property="og:title" content="The Watch" />
    <meta property="og:url" content="https://www.thewatchrp.com/" />
    <meta property="og:image" content="assets/img/logo.png" />
    <title>The Watch</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="shortcut icon" href="assets/img/favicon.ico">
    <script src="config/essentials.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://kit.fontawesome.com/b1f24b50ab.js" crossorigin="anonymous"></script>
</head>
<body>
    <header>
            <div class="wrapper">
                <nav>
                    <div id="nl-logo">
                        <img src="assets/img/logo.png" alt="logo">
                    </div>
                    <h1>
                        <div class="nr-ct">
                            <i class="fa-solid fa-location-arrow" id="locationarrow"></i>
                            <div id="runningTime"></div>
                            <span>5g</span>
                            <i class="fa-solid fa-signal fa-fade" style="--fa-animation-duration: 6s; --fa-fade-opacity: 0.5; margin-right: 10px;" ></i>
                            <i class="fa-solid fa-battery-full"></i>
                        </div>
                    </h1>
                </nav>
            </div>
    </header>
    <script type="text/javascript">
        $(document).ready(function() {
        setInterval(runningTime, 1000);
        });
        function runningTime() {
        $.ajax({
            url: 'config/timescript.php',
            success: function(data) {
            $('#runningTime').html(data);
            },
        });
        }
    </script>
    <main>
        <div class="wrapper">
            <div class="section-top">
                <h1 id="tp-title"><i class="fa-solid fa-file-shield"></i> Filesystem</h1>
                <div class="hero">
                    <div class="hero-citations">
                        <h3 style="display: flex; justify-content: space-between;"><div><i class="fa-solid fa-folder-open"></i> Recent Citations</div><div><i class="fa-solid fa-compress"></i> <i class="fa-solid fa-expand"></i> <i class="fa-solid fa-xmark"></i></div></h3>
                        <div class="content-container">
                            <?php
                                require_once 'config/connection.php';
                                $query = "SELECT * FROM pedcitations ORDER BY created_at DESC LIMIT 6;";
                                $statement = $conn->prepare($query);
                                $statement->execute();
                                $citations = $statement->fetchAll(PDO::FETCH_ASSOC);
                            ?>
                            <?php foreach($citations as $citation): ?>
                            <a href="<?php echo $base_url; ?>filesystem/citations.php?citationID=<?php echo $citation['citationID']; ?>">
                            <div id="md-all">
                                <div class="md-all-data">
                                    <div class="md-all-data-top">
                                        <div>
                                            <p id="citations-title"><i class="fa-solid fa-hand-holding-dollar"></i> Citation</p>
                                        </div>
                                        <div>
                                            <p id="citations-time"><?php echo $citation['time']; ?></p>
                                        </div>
                                    </div>
                                    <div class="md-all-data-mid">
                                        <p><i class="fa-solid fa-id-card"></i> <?php echo substr($citation['name'], 0, 15); ?></p>
                                    </div>
                                    <div class="md-all-data-bottom">
                                        <div>
                                            <p id="citations-fine">$<?php echo $citation['amount']; ?></p>
                                        </div>
                                        <div>
                                            <p id="citations-id"><i class="fa-solid fa-link"></i> #<?php echo substr($citation['citationID'], 0, 5); ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </a>
                            <?php endforeach; ?>
                            <?php
                            if (count($citations) == 0){
                                echo('<h1 id="emptymap">no files found.</h1>');
                            }
                            ?>
                        </div>
                    </div>
                    <div class="hero-reports">
                        <h3 style="display: flex; justify-content: space-between;"><div><i class="fa-solid fa-folder-open"></i> Recent Reports</div><div><i class="fa-solid fa-compress"></i> <i class="fa-solid fa-expand"></i> <i class="fa-solid fa-xmark"></i></div></h3>
                        <div class="content-container">
                            <?php
                                $query = "SELECT * from defaultreports ORDER BY created_at DESC LIMIT 6;";
                                $statement = $conn->prepare($query);
                                $statement->execute();
                                $reports = $statement->fetchAll(PDO::FETCH_ASSOC);
                            ?>
                            <?php foreach($reports as $report): ?>
                            <a href="<?php echo $base_url; ?>filesystem/reports.php?caseID=<?php echo $report['caseID']; ?>">
                            <div id="md-all">
                                <div class="md-all-data">
                                    <div class="md-all-data-top">
                                        <div>
                                            <p id="reports-title"><i class="fa-solid fa-file-signature"></i> Report</p>
                                        </div>
                                        <div>
                                            <p id="reports-time"><?php echo $report['time']; ?></p>
                                        </div>
                                    </div>
                                    <div class="md-all-data-mid">
                                        <p id="reports-text"><i class="fa-solid fa-file-signature"></i> <?php echo substr($report['report'], 0, 15); ?>...</p>
                                    </div>
                                    <div class="md-all-data-bottom">
                                        <div>
                                            <p id="reports-id"><i class="fa-solid fa-link"></i> #<?php echo substr($report['caseID'], 0, 5); ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </a>
                            <?php endforeach; ?>
                            <?php
                            if (count($reports) == 0){
                                echo('<h1 id="emptymap">no files found.</h1>');
                            }
                            ?>
                        </div>
                    </div>
                    <div class="hero-arrestreports">
                        <h3 style="display: flex; justify-content: space-between;"><div><i class="fa-solid fa-folder-open"></i> Recent Arrest reports</div><div><i class="fa-solid fa-compress"></i> <i class="fa-solid fa-expand"></i> <i class="fa-solid fa-xmark"></i></div></h3>
                        <div class="content-container">
                            <?php
                                $query = "SELECT * FROM arrestreports ORDER BY created_at DESC LIMIT 6;";
                                $statement = $conn->prepare($query);
                                $statement->execute();
                                $arrestreports = $statement->fetchAll(PDO::FETCH_ASSOC);
                            ?>
                            <?php foreach($arrestreports as $arrestreport): ?>
                            <a href="<?php echo $base_url; ?>filesystem/arrestreports.php?caseID=<?php echo $arrestreport['caseID']; ?>">
                            <div id="md-all">
                                <div class="md-all-data">
                                    <div class="md-all-data-top">
                                        <div>
                                            <p id="arrests-title"><i class="fa-solid fa-handcuffs"></i> Arrest</p>
                                        </div>
                                        <div>
                                            <p id="arrests-time"><?php echo $arrestreport['time']; ?></p>
                                        </div>
                                    </div>
                                    <div class="md-all-data-mid">
                                        <p><i class="fa-solid fa-id-card"></i> <?php echo substr($arrestreport['defendantName'], 0, 15); ?></p>
                                    </div>
                                    <div class="md-all-data-bottom">
                                        <div>
                                            <p id="arrests-id"><i class="fa-solid fa-link"></i> #<?php echo substr($arrestreport['caseID'], 0, 5); ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </a>
                            <?php endforeach; ?>
                            <?php
                                if (count($arrestreports) == 0){
                                    echo('<h1 id="emptymap">no files found.</h1>');
                                }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <div class="section-bottom">
                <h1 id="db-title"><i class="fa-solid fa-server"></i> Database</h1>
                <div class="search-container">
                    <div class="search-user">
                        <div>
                            <i class="fa-solid fa-magnifying-glass" style="font-size: 12px;"></i>
                        </div>
                        <div class="user-input">
                            <form>
                                <input type="text" placeholder="Search for Emergency Services Personnel..." id="users" name="users" onkeyup="showUser(this.value)" minlength="3">
                            </form>
                        </div>
                    </div>
                    <div class="search-user-data">
                        <span id="userSuggestion"></span>
                    </div>
                </div>
                <hr>
                <h1 id="db-title"><i class="fa-solid fa-calendar-week"></i> Weekly Statistics</h1>
                <?php
                    require_once 'config/connection.php';
                    $newestofficerq = "SELECT * FROM users INNER JOIN department_members ON users.id = department_members.userID ORDER BY department_members.userid DESC LIMIT 1";
                    $topofficersq = "SELECT COUNT(*) AS `count` AND user FROM `arrestreports` `defaultreports` `pedcitations`  AND DATE(created_at) > (NOW() - INTERVAL 7 DAY)";
                    $officersq = "SELECT COUNT(*) AS `count` FROM `department_members` WHERE DATE(created_at) > (NOW() - INTERVAL 7 DAY)";
                    $arrestsq = "SELECT COUNT(*) AS `count` FROM `arrestreports` WHERE DATE(created_at) > (NOW() - INTERVAL 7 DAY)";
                    $reportsq = "SELECT COUNT(*) AS `count` FROM `defaultreports` WHERE DATE(created_at) > (NOW() - INTERVAL 7 DAY)";
                    $citationsq = "SELECT COUNT(*) AS `count` FROM `pedcitations` WHERE DATE(created_at) > (NOW() - INTERVAL 7 DAY)";
                    $nstatement = $conn->prepare($newestofficerq);
                    $ostatement = $conn->prepare($officersq);
                    $astatement = $conn->prepare($arrestsq);
                    $rstatement = $conn->prepare($reportsq);
                    $cstatement = $conn->prepare($citationsq);
                    $nstatement->execute();
                    $ostatement->execute();
                    $astatement->execute();
                    $rstatement->execute();
                    $cstatement->execute();
                    $newestofficerresult = $nstatement->fetch(PDO::FETCH_ASSOC);
                    $officerresult = $ostatement->fetch(PDO::FETCH_ASSOC);
                    $arrestresult = $astatement->fetch(PDO::FETCH_ASSOC);
                    $reportresult = $rstatement->fetch(PDO::FETCH_ASSOC);
                    $citationresult = $cstatement->fetch(PDO::FETCH_ASSOC);
                ?>
                <div class="stats-container">
                    <div>
                        <h1><i class="fa-solid fa-person-military-pointing"></i> New Hires</h1>
                        <p><i class="fa-solid fa-arrow-up-right-dots up"></i> <?php echo $officerresult['count']; ?></p>
                    </div>
                    <div>
                        <h1><i class="fa-solid fa-handcuffs"></i> Arrests Made</h1>
                        <p><i class="fa-solid fa-arrow-up-right-dots up"></i> <?php echo $arrestresult['count']; ?></p>
                    </div>
                    <div>
                        <h1><i class="fa-solid fa-file-signature"></i> Reports Completed</h1>
                        <p><i class="fa-solid fa-arrow-up-right-dots up"></i> <?php echo $reportresult['count']; ?></p>
                    </div>
                    <div>
                        <h1><i class="fa-solid fa-hand-holding-dollar"></i>  Citations Issued</h1>
                        <p><i class="fa-solid fa-arrow-up-right-dots up"></i> <?php echo $citationresult['count']; ?></p>
                    </div>
                </div>
            </div>
            <hr>
            <?php require_once 'layout/footer.php'; ?>
        </div>
    </main>
</body>
</html>