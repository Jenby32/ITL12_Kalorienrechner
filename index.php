<form>
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
    <input type="submit" class="btn btn-primary" name="button_send" value="Senden">
  </div><small>Felder markiert mit * sind Pflichtfelder.</small>
</form>