<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>
<header>
        <div class="wrapper">
            <nav>
                <div id="nl-logo">
                    <a href="../index.php"><img src="../assets/img/logo.png" alt="logo"></a>
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
                url: '../config/timescript.php',
                success: function(data) {
                $('#runningTime').html(data);
                },
            });
            }
</script>