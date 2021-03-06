<?php
  include('res/database.php');
  session_start();
  $db = $_SESSION['db'];

  $data = array();

  $result = $db->loadStats($_SESSION['user']);

  if($result)
    if ($result->num_rows > 0) {
    // output data of each row
      while($row = $result->fetch_assoc()) {
        $data[] = $row;
      }
  }
?>

  <!DOCTYPE html>
  <html lang="en">

  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">


    <link rel="apple-touch-icon" sizes="76x76" href="images/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="images/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="images/favicon-16x16.png">
    <link rel="manifest" href="images/site.webmanifest">
    <link rel="mask-icon" href="images/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">


    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="css/materialize.min.css" rel="stylesheet">
    <link href="css/stileProfilo.css" type="text/css" rel="stylesheet" media="screen,projection" />
    <title>Statistiche</title>
  </head>

  <body>
    <!-- Barra di navigazione -->
    <header id="header" class="page-topbar">
      <nav class="white">
        <div class="navbar-fixed">
          <div class="nav-wrapper">
            <a href="./index.php" class="brand-logo"><img src="images/logo.PNG" alt="Logo" class="image-logo" width="150px"></a>
            <a href="#" data-target="mobile-demo" class="sidenav-trigger"><i class="material-icons">menu</i></a>
            <ul class="right hide-on-med-and-down">
              <li>
                <form id="ricercaAz" method="get" action="index.php">
                  <div class="input-field">
                    <i class="black-text material-icons prefix">search</i>
                    <input id="ricercaAziende" type="text" placeholder="Cerca..." name="data" onkeydown="search(this)" ><!--onkeyup="ricerca()"-->
                  </div>
                </form>
              </li>
              <li><a href="index.php">Home</a></li>
              <li><a href="contatti.php">Team</a></li>
              <li><a href="login.php" class="waves-effect waves-teal"><i class="material-icons">add_circle</i></a></li>
              <li><a href="profile.php?find=true" class="dropdown-button waves-effect waves-teal" data-target='dropdownNav'><i class="medium material-icons">account_circle</i></a></li>
            </ul>
            <ul id='dropdownNav' class='dropdown-content'>
              <li><a href="profile.php?find=true">Profilo</a></li>
              <li><a href="info.php">Info Azienda</a></li>
              <li><a href="res/logout.php">Logout</a></li>
            </ul>
          </div>
        </div>
      </nav>

      <ul id="mobile-demo" class="sidenav">
        <li><a href="index.php">Home</a></li>
        <li><a href="contatti.php">Team</a></li>
        <li><a href="login.php">Accedi</a></li>
        <li><a href="profile.php?find=true">Profilo</a></li>
        <li><a href="info.php">Info Azienda</a></li>
        <li><a href="res/logout.php">Logout</a></li>
      </ul>
    </header>

    <main>
      <div class="container">
        <div class="row">
          <div id="chartContainer" class="col s12">
            <canvas id="mycanvas"></canvas>
          </div>

        </div>
      </div>
    </main>


    <!--  Scripts-->
    <script src="js/jquery.min.js"></script>
    <script src="js/materialize.min.js"></script>
    <script src="js/main.js"></script>
    <script type="text/javascript" src="js/Chart.min.js"></script>
    <script>
      $(document).ready(function() {
        var settimana = [];
        var visualizzazioni = [];

        data = JSON.parse('<?php echo json_encode($data); ?>');
        for (var i in data) {
          settimana.push("Settimana: " + data[i].settimana);
          visualizzazioni.push(data[i].visualizzazioni);
        }

        var chartdata = {
          labels: settimana,
          datasets: [{
            backgroundColor: 'rgba(200, 200, 200, 0.75)',
            borderColor: 'rgba(200, 200, 200, 0.75)',
            hoverBackgroundColor: 'rgba(200, 200, 200, 1)',
            hoverBorderColor: 'rgba(200, 200, 200, 1)',
            data: visualizzazioni
          }]
        };

        var option = {
          responsive: true,
          title: {
            display: true,
            position: "top",
            text: "Visualizzazioni settimanali",
            fontSize: 18,
            fontColor: "#111"
          },
          legend: {
            display: false,
            labels: {
                fontColor: 'rgb(255, 99, 132)'
            }
          },
          scales: {
            yAxes: [{
              ticks: {
                min: 0
              }
            }]
          }
        };
        var ctx = $("#mycanvas");

        var barGraph = new Chart(ctx, {
          type: 'bar',
          data: chartdata,
          options: option
        });
      });
    </script>
    <footer class="page-footer blue lighten-1">
      <div class="container">
        <div class="row center">
          <div class="col l4 s12">
            <h5 class="white-text">Locazione</h5>
            <p class="grey-text text-lighten-4">Lucca - Italia</p>
          </div>
          <div class="col l4 s12">
            <h5 class="white-text">Social</h5>
            <a href="https://facebook.com/aziende.expo" target="_blank"><img src="https://png.icons8.com/material/50/000000/facebook.png"></a>
            <a href="https://twitter.com/aziendeexpo" target="_blank"><img src="https://png.icons8.com/metro/50/000000/twitter.png"></a>
            <a href="https://instagram.com/aziendeexpo" target="_blank"><img src="https://png.icons8.com/ios-glyphs/50/000000/instagram-new.png"></a>
          </div>
          <div class="col l4 s12">
            <h5 class="white-text">Contatti</h5>
            <p class="grey-text text-lighten-4"><a href="mailto:leonard.drici@gmail.com" class="white-text">leonard.drici@gmail.com</a></p>
            <p class="grey-text text-lighten-4"><a href="mailto:help@aziendeexpo.it" class="white-text">help@aziendeexpo.it</a></p>
          </div>
        </div>
      </div>
      <div class="footer-copyright">
        <div class="container">
          © 2018 Copyright AziendeExpo
        </div>
      </div>
    </footer>
  </body>
  </html>
