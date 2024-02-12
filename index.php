<form method="POST">
  <div class="form-group">
    <label>Geschlecht *</label> <select class="form-control" name="selectbox_gender" required="required">
      <option value="male">
        Männlich
      </option>

      <option value="female">
        Weiblich
      </option>
    </select>
  </div>

  <div class="form-group">
    <label>Alter *</label> <input type="text" class="form-control" name="text_age" placeholder="Alter" required="required">
  </div>

  <div class="form-group">
    <label>Gewicht *</label> <input type="text" class="form-control" name="text_weight" placeholder="Gewicht - kg" required="required">
  </div>

  <div class="form-group">
    <label>Größe *</label> <input type="text" class="form-control" name="text_height" placeholder="Größe - cm" required="required">
  </div>

  <div class="form-group">
    <label>Tägliche Aktivität</label> <select class="form-control" name="selectbox_activity">
      <option value="only_sit">
        ausschließlich sitzend
      </option>

      <option value="mainly_sit">
        vorwiegend sitzend
      </option>

      <option value="mostly_sit">
        überwiegend sitzend
      </option>

      <option value="mainly_stand">
        hauptsächlich stehend
      </option>

      <option value="stressful_activity">
        körperlich anstrengende Arbeiten
      </option>
    </select>
  </div>

  <div class="form-group">
    <label>Sitzend</label> <input type="text" class="form-control" name="text_sitting" placeholder="Sitzend - h">
  </div>

  <div class="form-group">
    <label>Stehend</label> <input type="text" class="form-control" name="text_standing" placeholder="Stehend - h">
  </div>

  <div class="form-group">
    <label>Büro</label> <input type="text" class="form-control" name="text_office" placeholder="Büro - h">
  </div>

  <div class="form-group">
    <input type="submit" class="btn btn-primary" name="button_send" value="Senden">
  </div><small>Felder markiert mit * sind Pflichtfelder.</small>
</form>

<?php

    function getPalAvg($factors, $sittingH, $officeH, $standingH) {
        /*
          Bsp: 4 h sitzend, 6 h Büro, 2 h stehend/gehend = 12 h Gesamt dh. 12 h Schlaf bleiben übrig.
          Berechnung: 4*1,2 + 6*1,45+2*1,85+12*0,95 / 24 = 1,19 (Durchschnitt)
        */
        $activeHours = $sittingH + $standingH + $officeH;
        $activeHoursPAL = $sittingH*$factors["only_sit"]+ $standingH*$factors["mainly_stand"]+$officeH*$factors["mainly_sit"];
        $sleepTime = (24 - $activeHours)*$factors["sleep"];
        return ($activeHoursPAL+$sleepTime) / 24;
    }

    $activityPALFac = array(
      "only_sit"=> 1.2,
      "mainly_sit"=> 1.45,
      "mostly_sit"=> 1.65,
      "mainly_stand"=> 1.85,
      "stressful_activity"=> 2.2,
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
        $activity = $_POST["selectbox_activity"];
        $sittingTime = $_POST["text_sitting"];
        $standingTime = $_POST["text_standing"];
        $officeTime = $_POST["text_office"];

        $kalorienBedarf = 0;
        if($gender == "male") {
          $kalorienBedarf = 66.47 + (13.7*$weight) + (5*$height) - (6.8*$age);
        } else {
          $kalorienBedarf = 655.1 + (9.6*$weight) + (1.8*$height) - (4.7*$age);
        }

        echo "Der Durchschnitt für den PAL Wert beträgt: " .getPalAvg($activityPALFac, $sittingTime, $officeTime, $standingTime) ."<br/>";


        // echo $gender. " " .$weight. " " .$height." ".$activity." ".$sittingTime." ".$standingTime."";
        echo "Der Standardkalorienbedarf für dieses Alter, diese Größe und dieses Körpergewicht beträgt: " .$kalorienBedarf. "kcal";
    }
?>