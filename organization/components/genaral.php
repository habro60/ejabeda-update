<div class="org">
    <div class="row">
      <div class="col-8">
        <div class="form__group">
          <input type="text" class="form__input" name="name" id="name" placeholder="Organization Name" autocomplete="off">
          <label for="name" class="form__label" autocomplete="off">Organization Name</label>
        </div>
        <div class="form__group">
          <input type="text" class="form__input" name="slogan" id="slogan" placeholder="Organization Slogan" autocomplete="off">
          <label for="name" class="form__label" autocomplete="off">Organization Slogan</label>
        </div>
      </div>
      <div class="col-4 ">
        <div class="form__profile">
          <img src="..images/profile-icon-9.png" id="profileImage" onclick="triggerClick()" class="form__logo"/>
          <input type="file" name="profiler" id="profile" onchange="displayImage(this)" style="display:none">
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-12">
        <div class="form__group">
          <input type="text" class="form__input" name="address1" id="address1" placeholder="Address-1" autocomplete="off" autocomplete="off">
          <label for="name" class="form__label">Address-1</label>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-12">
        <div class="form__group">
          <input type="text" class="form__input" name="address2" id="address2" placeholder="Address-2" autocomplete="off">
          <label for="name" class="form__label">Address-2</label>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-6">
        <div class="form__group">
          <input type="email" class="form__input" name="email" id="email" placeholder="Email Address" autocomplete="off">
          <label for="name" class="form__label">Email Address</label>
        </div>
      </div>
      <div class="col-6">
        <div class="form__group">
          <input type="text" class="form__input" name="telephone" id="telephone" pattern="[0-9]+"  placeholder="Telephone No" autocomplete="off">
          <label for="name" class="form__label">Telephone No</label>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-4">
          <div class="form__group">
            <input type="text" class="form__input" name="fax" id="fax" placeholder="Fax No" autocomplete="off">
            <label for="name" class="form__label">Fax No</label>
          </div>
        </div>
      <div class="col-4">
        <div class="form__group">
          <input type="text" class="form__input" name="website" id="website" placeholder="Website" autocomplete="off">
          <label for="name" class="form__label">Website</label>
        </div>
      </div>
      <div class="col-4">
        <div class="form__group">
          <input type="text" class="form__input" name="country" id="country" placeholder="Country" autocomplete="off">
          <label for="name" class="form__label">Country</label>
        </div>
      </div>
    </div>
</div>