<div class="org">
  <div class="row">
    <div class="col-3">
      <div class="form__group">
        <input type="number" class="form__input" name="fmStart" max="12" min="1" id="fmStart" placeholder="Financial Month Start" autocomplete="off">
        <label for="name" class="form__label">Financial Month Start</label>
      </div>
    </div>
    <div class="col-3">
      <div class="form__group">
        <input type="text" class="form__input" name="fyStart" id="fyStart" placeholder="Financial Year Start" onfocus="(this.type='date')" onblur="dateFormatChanger(this)">
        <label for="name" class="form__label">Financial Year Start</label>
      </div>
    </div>
    <div class="col-3">
      <div class="form__group">
        <input type="text" class="form__input" name="locCurr" id="locCurr" placeholder="Local Currency Name" autocomplete="off">
        <label for="name" class="form__label">Local Currency Name</label>
      </div>
    </div>
    <div class="col-3">
      <div class="form__group">
        <input type="text" class="form__input" name="locCurrSym" id="locCurrSym" placeholder="Local Currency Symbol" autocomplete="off">
        <label for="name" class="form__label">Local Currency Symbol</label>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-6">
      <div class="form__group">
      <input type="number" class="form__input" name="fmEnd" max="12" min="1" id="fmEnd" placeholder="Financial Month End" autocomplete="off">
      <label for="name" class="form__label">Financial Month End</label>
      </div>
    </div>
    <!-- <div class="col-3">
      <div class="form__group">
        <input type="text" class="form__input" name="fyEnd" id="fyEnd" placeholder="Financial Year End" onfocus="(this.type='date')" onblur="(this.type='text')">
        <label for="name" class="form__label">Financial Year End</label>
      </div>
    </div> -->
    <div class="col-3">
      <div class="form__group">
        <input type="text" class="form__input" name="forCurr" id="forCurr" placeholder="Foreign Currency Name" autocomplete="off">
        <label for="name" class="form__label">Foreign Currency Name</label>
      </div>
    </div>
    <div class="col-3">
      <div class="form__group">
        <input type="text" class="form__input" name="forCurrSym" id="forCurrSym" placeholder="Foreign Currency Symbol" autocomplete="off">
        <label for="name" class="form__label">Foreign Currency Symbol</label>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-6">
      <div class="form__group">
        <input type="text" class="form__input" name="budget" id="budget" placeholder="Budget Year" autocomplete="off">
        <label for="name" class="form__label">Budget Year</label>
      </div>
    </div>
    <div class="col-6">
      <div class="form__group">
        <input type="text" class="form__input" name="noOfDec" id="noOfDec" placeholder="No Of Decimal" autocomplete="off">
        <label for="name" class="form__label">No Of Decimal</label>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-6">
      <div class="form__group">
        <div class="form__radio-group">
          <label class="form__radio-title">Inventory Maintenance</label>
          <input type="radio" class="form__radio-input" id="yesInventory" value="yes" name="inventory">
          <label for="yesInventory" class="form__radio-label">
            <span class="form__radio-btn"></span>
            Yes
          </label>
        </div>
        <div class="form__radio-group">
          <input type="radio" class="form__radio-input" id="noInventory" value="no" name="inventory">
          <label for="noInventory" class="form__radio-label">
            <span class="form__radio-btn"></span>
            No
          </label>
        </div>

      </div>
      <div class="form__group">
        <div class="form__radio-group">
          <label class="form__radio-title">Round Decimal</label>

          <input type="radio" class="form__radio-input" onchange="roundManipulationOn(this)" id="yesRound" value="yes" name="round">
          <label for="yesRound" class="form__radio-label">
            <span class="form__radio-btn"></span>
            Yes
          </label>
        </div>
        <div class="form__radio-group">
          <input type="radio" class="form__radio-input" onchange="roundManipulationOff(this)" id="noRound" value="no" name="round">
          <label for="noRound" class="form__radio-label">
            <span class="form__radio-btn"></span>
            No
          </label>
        </div>

      </div>
    </div>
    <div class="col-6">
      <div class="form__group" style="margin-bottom:30px">
        <select class="form__input" name="imgType" id="imgType">
          <option value="" disabled selected>Image Type</option>
          <option value=".jpg">.jpg</option>
          <option value=".jpeg">.jpeg</option>
          <option value=".png">.png</option>
          <option value=".svg">.svg</option>
        </select>
      </div>
      <div class="form__group">
        <input type="text" class="form__input" name="imgPath" id="imgPath" placeholder="Image Path" autocomplete="off">
        <label for="imgPath" class="form__label" autocomplete="off">Image Path</label>
      </div>
      <div class="form__group">
        <select class="form__input" name="roundType" id="roundType">
          <option value="" disabled selected>Rounding Type</option>
          <option value="Upper">Upper</option>
          <option value="Normal">Normal</option>
          <option value="Down">Down</option>
        </select>
      </div>
    </div>
  </div>
</div>