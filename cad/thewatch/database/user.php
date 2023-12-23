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
    <meta property="og:url" content="https://www.safrrp.com/" />
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
                <!-- PHP -->
                <?php
                    $userID = $_GET['userID'];
                    require_once '../config/connection.php';
                    $query = "SELECT
                    dm.*,
                    r.name AS rank_name,
                    d.name AS department_name,
                    d.shortname as department_shortname,
                    u.gameName as user_name
                  
                  FROM department_members AS dm
                  
                  JOIN users AS u
                    ON u.id = dm.userID
                    AND u.gameName = u.gameName
                  
                  JOIN departments AS d
                    ON d.id = dm.departmentID
                    AND d.name = d.name
                    AND d.shortname = d.shortname
                    
                  JOIN ranks AS r
                    ON r.id = dm.rankID
                   AND r.name = r.name
                   
                   WHERE dm.userID = :userID;";
                    $statement = $conn->prepare($query);
                    $statement->execute([":userID" => $userID]);
                    $user = $statement->fetch(PDO::FETCH_ASSOC);
                ?>
                <!-- END -->
                <?php if ($user == true): ?>
                <div class="file-ui-text-top user">
                    <div class="file-ui-data-top-left user">
                        <i class="fa-solid fa-fingerprint"></i>
                        <code><?php echo $user['user_name'];?></code>
                    </div>
                    <div class="file-ui-data-top-right user">
                        <i class="fa-solid fa-compress"></i>
                        <i class="fa-solid fa-expand"></i>
                        <i class="fa-solid fa-xmark"></i>
                    </div>
                </div>
                <div class="file-ui-text">
                    <div class="file-ui-text user left">
                        <div>
                            <h1>DEPARTMENT</h1>
                            <code><?php echo $user['department_shortname'];?></code>
                        </div>
                        <div>
                            <h1>HIRE DATE</h1>
                            <code><?php echo $user['created_at'];?></code>
                        </div>
                        <div id="rank-name">
                            <h1>RANK</h1>
                            <code><?php echo $user['rank_name'];?></code>
                        </div>
                        <div>
                            <h1>CALLSIGN</h1>
                            <code><?php echo $user['callsign'];?></code>
                        </div>
                        <!-- PHP -->
                        <?php
                            $userID = $_GET['userID'];
                            require_once '../config/connection.php';
                            $arrestsq = "SELECT COUNT(*) AS `count` FROM `arrestreports` WHERE userID = :userID AND DATE(created_at) > (NOW() - INTERVAL 30 DAY)";
                            $reportsq = "SELECT COUNT(*) AS `count` FROM `defaultreports` WHERE userID = :userID AND DATE(created_at) > (NOW() - INTERVAL 30 DAY)";
                            $citationsq = "SELECT COUNT(*) AS `count` FROM `pedcitations` WHERE userID = :userID AND DATE(created_at) > (NOW() - INTERVAL 30 DAY)";
                            $astatement = $conn->prepare($arrestsq);
                            $rstatement = $conn->prepare($reportsq);
                            $cstatement = $conn->prepare($citationsq);
                            $astatement->execute([":userID" => $userID]);
                            $rstatement->execute([":userID" => $userID]);
                            $cstatement->execute([":userID" => $userID]);
                            $arrestresult = $astatement->fetch(PDO::FETCH_ASSOC);
                            $reportresult = $rstatement->fetch(PDO::FETCH_ASSOC);
                            $citationresult = $cstatement->fetch(PDO::FETCH_ASSOC);
                        ?>
                        <!-- END PHP -->
                        <div>
                            <h1>CITATIONS (30 Days)</h1>
                            <code><?php echo $citationresult['count'];?></code>
                        </div>
                        <div>
                            <h1>REPORTS (30 Days)</h1>
                            <code><?php echo $reportresult['count'];?></code>
                        </div>
                        <div>
                            <h1>ARRESTS (30 Days)</h1>
                            <code><?php echo $arrestresult['count'];?></code>
                        </div>
                        <!-- PHP -->
                        <?php
                        $userID = $_GET['userID'];
                        require_once '../config/connection.php';
                        $arrest_total = "SELECT COUNT(*) AS `count` FROM `arrestreports` WHERE userID = :userID;";
                        $reports_total = "SELECT COUNT(*) AS `count` FROM `defaultreports` WHERE userID = :userID;";
                        $citations_total = "SELECT COUNT(*) AS `count` FROM `pedcitations` WHERE userID = :userID;";
                        $arrests_statement = $conn->prepare($arrest_total);
                        $reports_statement = $conn->prepare($reports_total);
                        $citations_statement = $conn->prepare($citations_total);
                        $arrests_statement->execute([":userID" => $userID]);
                        $reports_statement->execute([":userID" => $userID]);
                        $citations_statement->execute([":userID" => $userID]);
                        $arrest_total_result = $arrests_statement->fetch(PDO::FETCH_ASSOC);
                        $reports_total_result = $reports_statement->fetch(PDO::FETCH_ASSOC);
                        $citations_total_result = $citations_statement->fetch(PDO::FETCH_ASSOC);
                        ?>
                        <!-- END PHP -->
                    </div>
                    <div class="file-ui-text call">
                        <?php
                            $userID = $_GET['userID'];
                            require_once '../config/connection.php';
                            $query = "SELECT * from defaultreports WHERE userID = :userID ORDER BY date DESC LIMIT 6;";
                            $statement = $conn->prepare($query);
                            $statement->execute([":userID" => $userID]);
                            $reports = $statement->fetchAll(PDO::FETCH_ASSOC);
                        ?>
                        <div class="file-ui-text-right-container">
                            <h1><i class="fa-solid fa-tower-broadcast"></i> DISPATCH HISTORY</h1>
                            <?php if ($reports == true): ?>
                                <?php foreach($reports as $report): ?>
                                    <div class="date-call-code">
                                        <span id="datetime-call"><?php echo $report['time'];?></span> 
                                        <code id="call-code">Officer <?php echo $report['officer'];?> Responded to <?php echo substr($report['callName'], 0, 18);?> call at <?php echo substr($report['location'], 0, 80);?></code>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                    <div class="date-call-code">
                                        <code id="call-code">No Dispatch History</code>
                                    </div>
                            <?php endif ?>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <div class="user-records">
                <div class="file-ui-text-top user">
                        <!-- PHP -->
                        <?php
                        $userID = $_GET['userID'];
                        require_once '../config/connection.php';
                        $arrest_total = "SELECT COUNT(*) AS `count` FROM `arrestreports` WHERE userID = :userID;";
                        $reports_total = "SELECT COUNT(*) AS `count` FROM `defaultreports` WHERE userID = :userID;";
                        $citations_total = "SELECT COUNT(*) AS `count` FROM `pedcitations` WHERE userID = :userID;";
                        $arrests_statement = $conn->prepare($arrest_total);
                        $reports_statement = $conn->prepare($reports_total);
                        $citations_statement = $conn->prepare($citations_total);
                        $arrests_statement->execute([":userID" => $userID]);
                        $reports_statement->execute([":userID" => $userID]);
                        $citations_statement->execute([":userID" => $userID]);
                        $arrest_total_result = $arrests_statement->fetch(PDO::FETCH_ASSOC);
                        $reports_total_result = $reports_statement->fetch(PDO::FETCH_ASSOC);
                        $citations_total_result = $citations_statement->fetch(PDO::FETCH_ASSOC);
                        ?>
                        <!-- END PHP -->
                    <div class="file-ui-data-top-left user records">
                        <i class="fa-solid fa-folder-tree"></i>
                        <code>CAREER COUNTS</code>
                        <code>ISSUED CITATIONS (<?php echo $citations_total_result['count'];?>)</code>
                        <code>REPORTS WRITTEN (<?php echo $reports_total_result['count'];?>)</code>
                        <code>ARRESTS MADE (<?php echo $arrest_total_result['count'];?>)</code>
                    </div>
                    <div class="file-ui-data-top-right user">
                        <i class="fa-solid fa-compress"></i>
                        <i class="fa-solid fa-expand"></i>
                        <i class="fa-solid fa-xmark"></i>
                    </div>
                </div>
                <!-- PHP -->
                <?php
                    $userID = $_GET['userID'];
                    require_once '../config/connection.php';
                    $arrest_record = "SELECT arrestreports.caseID, arrestreports.userID, arrestreports.defendantName, arrestreports.date FROM `arrestreports` WHERE userID = :userID ORDER BY created_at DESC LIMIT 20;";
                    $reports_record = "SELECT defaultreports.caseID, defaultreports.userID, defaultreports.callName, defaultreports.date FROM `defaultreports` WHERE userID = :userID ORDER BY created_at DESC LIMIT 20;";
                    $citations_record = "SELECT pedcitations.citationID, pedcitations.userID, pedcitations.name, pedcitations.date FROM `pedcitations` WHERE userID = :userID ORDER BY created_at DESC LIMIT 20;";
                    $arrests_record_statement = $conn->prepare($arrest_record);
                    $reports_record_statement = $conn->prepare($reports_record);
                    $citations_record_statement = $conn->prepare($citations_record);
                    $arrests_record_statement->execute([":userID" => $userID]);
                    $reports_record_statement->execute([":userID" => $userID]);
                    $citations_record_statement->execute([":userID" => $userID]);
                    $arrest_record_result = $arrests_record_statement->fetchAll(PDO::FETCH_ASSOC);
                    $reports_record_result = $reports_record_statement->fetchAll(PDO::FETCH_ASSOC);
                    $citations_record_result = $citations_record_statement->fetchAll(PDO::FETCH_ASSOC);
                ?>
                <!-- END PHP -->
                <div class="user-record-entries">
                    <div class="records-left">
                        <table>
                            <h1>Citations</h1>
                            <tr>
                                <th><code>Case #</code></th>
                                <th><code>Recipient</code></th>
                                <th><code>Date Issued</code></th>
                            </tr>
                            <?php foreach($citations_record_result as $citation_result): ?>
                            <tr>
                                <td><a style="color: white; text-decoration: none;" href="<?php echo $base_url; ?>/thewatch/filesystem/citations.php?citationID=<?php echo $citation_result['citationID']; ?>"><i class="fa-solid fa-link"></i> <?php echo substr($citation_result['citationID'], 0, 5);?></a></td>
                                <td><?php echo $citation_result['name'];?></td>
                                <td><?php echo $citation_result['date'];?></td>
                            </tr>
                            <?php endforeach; ?>
                        </table>
                    </div>
                    <div class="records-center">
                        <table>
                            <h1>Reports</h1>
                            <tr>
                                <th><code>Case #</code></th>
                                <th><code>Reported Call</code></th>
                                <th><code>Date Written</code></th>
                            </tr>
                            <?php foreach($reports_record_result as $report_result): ?>
                            <tr>
                                <td><a style="color: white; text-decoration: none;" href="<?php echo $base_url; ?>/thewatch/filesystem/reports.php?caseID=<?php echo $report_result['caseID']; ?>"><i class="fa-solid fa-link"></i> <?php echo substr($report_result['caseID'], 0, 5);?></a></td>
                                <td><?php echo substr($report_result['callName'], 0, 15);?></td>
                                <td><?php echo $report_result['date'];?></td>
                            </tr>
                            <?php endforeach; ?>
                        </table>
                    </div>
                    <div class="records-right">
                        <table>
                            <h1>Arrest Reports</h1>
                            <tr class="tr-top">
                                <th><code>Case #</code></th>
                                <th><code>Suspect</code></th>
                                <th><code>Date Written</code></th>
                            </tr>
                            <?php foreach($arrest_record_result as $arrest_result): ?>
                                <tr>
                                    <td><a style="color: white; text-decoration: none;" href="<?php echo $base_url; ?>/thewatch/filesystem/arrestreports.php?caseID=<?php echo $arrest_result['caseID']; ?>"><i class="fa-solid fa-link"></i> <?php echo substr($arrest_result['caseID'], 0, 5);?></a></td>
                                    <td><?php echo $arrest_result['defendantName'];?></td>
                                    <td><?php echo $arrest_result['date'];?></td>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                    </div>
                </div>
                <?php
                    if (count($citations_record_result) AND count($reports_record_result) AND count($arrest_record_result) == 0)
                    {
                        echo('<h1 id="emptymap">no files found.</h1>');
                    }
                ?>
            </div>
            <hr>
            <?php require_once '../layout/footer.php'; ?>
        </div>
        <?php else: ?>
                <?php require_once '../layout/error.php'; ?>
        <?php endif ?>
    </main>
</body>
</html>