function triggerClick(){
  document.querySelector('#profile').click();
}
function displayImage(e){
  if(e.files[0]){
    var reader = new FileReader();

    reader.onload = function(e) {
      document.querySelector("#profileImage").setAttribute('src',e.target.result);
    }
    reader.readAsDataURL(e.files[0]);
  }
}
var radio = document.querySelector("#noRound").checked;
var roundType = document.getElementById("roundType");

function roundManipulationOn(el){
  if(el.checked){
    roundType.disabled = false;
  } 
}
function roundManipulationOff(el){
  if(el.checked){
    roundType.disabled = true;
  }
}

function dateFormatChanger(el){
  el.type = "text";

  let date = el.value.split("-");
  console.log(date)
  let formattedDate = `${date[2]}-${date[1]}-${date[0]}`;

  el.value = formattedDate;

}