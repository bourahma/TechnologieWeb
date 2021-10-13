let txt;
window.addEventListener('load',initForm);
function initForm(){
  document.forms.form_register.addEventListener("submit",sendFormRegister);
  txt = document.getElementById("text");
}

/**
 *  vérifier si l'état JSON est OK
 */
function processAnswer(answer){
  if (answer.status == "ok"){
    txt.textContent = 'Utilisateurs de '+answer.result.prenom+' '+answer.result.nom+' ('+answer.result.login+') a créé avec succès !';
    return answer.result;
  }
  else{
    txt.textContent = answer.message;
    throw new Error(answer.message);
  }
}

/**
 *  envoyer les valeurs du utilisateur
 */
function sendFormRegister(ev){ 
	ev.preventDefault();
    let args = new FormData(this);
    let url = 'services/createUser.php';
    fetchFromJson(url,{method:'post',body:args}).then(processAnswer);
    txt.textContent = 'Attendez, S\'il Vous Plaît..';
}