function sprawdzenie(){
    let mailformat = /^[a-z\d]+[\w\d.-]*@(?:[a-z\d]+[a-z\d-]+\.){1,5}[a-z]{2,6}$/i;
    let loginformat = /^[0-9a-zA-Z]*$/;
    let blad = false

  if(document.getElementById("rej-log").checked == false)
  { 
  if(document.getElementById("loginlog").value === ""){
    alert('Pole login nie może być puste!');
    document.getElementById("loginlog").style.border = "1px solid red";
    blad = true
}
else if(document.getElementById("loginlog").value.match(loginformat)){
}
else{
    alert("Niedozwolone znaki w polu login");
    document.getElementById("loginlog").style.border = "1px solid red";
    blad = true;
}
//  if(document.getElementById("haslolog").value === ""){
//     alert('Pole hasło nie może być puste!');
//     document.getElementById("haslolog").style.border = "1px solid red";
//     blad = true
// }
 if(blad === false){
  document.getElementById('formularz').submit();
}
// register validation
}
if(document.getElementById("rej-log").checked == true){
    if(document.getElementById("loginrej").value.length < 5 ){
  alert('Pole login nie może być krótsze niż 5 znaków!');
  document.getElementById("loginrej").style.border = "1px solid red";
  blad = true
} 
else if(document.getElementById("loginrej").value.match(loginformat)){
}
else{
    alert("Niedozwolone znaki w polu login");
    document.getElementById("loginrej").style.border = "1px solid red";
    blad = true;
}
if(document.getElementById("emailrej").value === ""){
  alert('Pole email nie może być puste!');
  document.getElementById("emailrej").style.border = "1px solid red";
  blad = true
}else if(document.getElementById("emailrej").value.match(mailformat)){
}
else{
    alert("Niedozwolone znaki w polu mail");
    document.getElementById("emailrej").style.border = "1px solid red";
    blad = true;
}

if(document.getElementById("haslorej").value.length < 5){
  alert('Pole haslo nie może być krótsze niż 5 znaków!');
  document.getElementById("haslorej").style.border = "1px solid red";
  blad = true
}
 if(blad === false){
  document.getElementById('formularz1').submit();
}
}
}

