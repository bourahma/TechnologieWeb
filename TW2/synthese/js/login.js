let txt, head, out;
window.addEventListener('load', initForm);

function initForm() {
    document.forms.form_login.addEventListener("submit", sendFormLogin);
    head    = document.getElementById("head");
    txt     = document.getElementById("text");
    out     = document.getElementById("out");
    
    document.getElementById('logout').addEventListener("click", sendFormLogout);
}

/**
 *  vérifier si l'état JSON est OK
 */
function processAnswerLogin(answer) {
    if (answer.status == "ok") {
        txt.textContent = "Bienvenue "+answer.result.prenom+" "+answer.result.nom+" ("+answer.result.login+") !";
        
        head.style.display = "none";
        out.style.display = "block";
        
        return answer.result;
    } else {
        txt.textContent = answer.message;
        throw new Error(answer.message);
    }
}

/**
 *  envoyer les valeurs du utilisateur
 */
function sendFormLogin(ev) {
    ev.preventDefault();
    let args1 = new FormData(this);
    let url = 'services/login.php';
    fetchFromJson(url, {
        method: 'post',
        body: args1
    }).then(processAnswerLogin);
    txt.textContent = 'Attendez, S\'il vous plaît..';
}

/**
 *  vérifier si l'état JSON est OK
 */
function processAnswerLogout(answer) {
    if (answer.status == "ok") {
        head.style.display = "block";
        out.style.display = "none";
        return answer.result;
    } else {
        txt.textContent = answer.message;
        throw new Error(answer.message);
    }
}

/**
 *  envoyer les valeurs du utilisateur
 */
function sendFormLogout(ev) {
    ev.preventDefault();
    let url = 'services/logout.php';
    fetch(url).then(processAnswerLogout);
    txt.textContent = 'Attendez, S\'il vous plaît..';
}