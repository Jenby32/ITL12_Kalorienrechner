<?php
    include('index.html');
    function getPalAvg($factors, $sitting_only, $hardly_active, $bit_active, $mainly_standing, $working) {
        /*
          Bsp: 4 h sitzend, 6 h Büro, 2 h stehend/gehend = 12 h Gesamt dh. 12 h Schlaf bleiben übrig.
          Berechnung: 4*1,2 + 6*1,45+2*1,85+12*0,95 / 24 = 1,19 (Durchschnitt)
        */
        $activeHours = $sitting_only + $hardly_active + $bit_active + $mainly_standing + $working;

        if($activeHours > 24) {
          echo '<script>alert("Your active hours must be below 24h!");</script>';
          return NULL;
        } else {
          $activeHoursPAL = $sitting_only*$factors["only_sit"]+ $hardly_active*$factors["mainly_sit"]+$bit_active*$factors["mostly_sit"]+$mainly_standing*$factors["mainly_stand"]+$working*$factors["stressful_activity"];
          $sleepTime = (24 - $activeHours)*$factors["sleep"];
          return ($activeHoursPAL+$sleepTime) / 24;
        }
    }

    $activityPALFac = array(
      "only_sit"=> 1.2,
      "mainly_sit"=> 1.5,
      "mostly_sit"=> 1.7,
      "mainly_stand"=> 1.9,
      "stressful_activity"=> 2.4,
      "sleep"=>0.95
    );

/*
Frauen: 655,1 + (9,6 x Körpergewicht in kg) + (1,8 x Körpergröße in cm) – (4,7 x Alter in Jahren)
Männer: 66,47 + (13,7 x Körpergewicht in kg) + (5 x Körpergröße in cm) – (6,8 x Alter in Jahren)
*/
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $gender = $_POST["selectbox_gender"];
        $weight = $_POST["text_weight"];
        $height = $_POST["text_height"];
        $age = $_POST["text_age"];
        // $activity = $_POST["selectbox_activity"];

        $sitting_only = intval($_POST["text_sitting_only"]);
        $hardly_active = intval($_POST["text_sitting_hardly_active"]);
        $bit_active = intval($_POST["text_sitting_walking_standing"]);
        $mainly_standing = intval($_POST["text_mainly_standing_walking"]);
        $working = intval($_POST["text_working_training"]);

        
        $kalorienBedarf = 0;
        if($gender == "male") {
          $kalorienBedarf = 66.47 + (13.7*$weight) + (5*$height) - (6.8*$age);
        } else {
          $kalorienBedarf = 655.1 + (9.6*$weight) + (1.8*$height) - (4.7*$age);
        }

        $PALFac = getPalAvg($activityPALFac, $sitting_only, $hardly_active, $bit_active, $mainly_standing, $working);

        $outputPALStr = '<div class="container text-center">
                          <p class="font-weight-bold">'.'Der Durchschnitt für den PAL Wert beträgt: ' .$PALFac. '<br/>'.'</p>
                        </div>';

        if(isset($PALFac)) {
          // echo "<script>console.log('".$PALFac."')</script>";
          $outputCalStr = '<div class="container text-center">
          <p class="font-weight-bold">'.'Der Standardkalorienbedarf für dieses Alter, diese Größe und dieses Körpergewicht beträgt: ' .$kalorienBedarf*$PALFac. 'kcal'.'</p>
        </div>';
        }
        echo $outputPALStr;
        echo $outputCalStr;
    }
?>