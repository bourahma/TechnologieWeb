let lis,detail,card;

window.addEventListener('load',initForm);
function initForm(){
  fetchFromJson('services/getTerritoires.php')
  .then(processAnswer)
  .then(makeOptions);

  card   = document.getElementById("carte");
  lis    = document.getElementById("liste_communes");
  detail = document.getElementById("details");
  document.forms.form_communes.addEventListener("submit", sendForm);
  
  // décommenter pour le recentrage de la carte :
  document.forms.form_communes.territoire.addEventListener("change",function(){
    centerMapElt(this[this.selectedIndex]);
  });
}

/**
 *  vérifier si l'état JSON est OK
 */
function processAnswer(answer){
  if (answer.status == "ok")
    return answer.result;
  else
    throw new Error(answer.message);
}

/**
 *  produire l'attribut d'option et produire l'option de territoire
 *  et créez un ensemble de data personnalisé de 'min_lat', 'min_lon', 
 *  'max_lat', 'max_lon'
 */
function makeOptions(tab){
  for (let territoire of tab){  
    let option = document.createElement('option');
    option.textContent = territoire.nom;
    option.value = territoire.id;
    document.forms.form_communes.territoire.appendChild(option);
    for (let k of ['min_lat','min_lon','max_lat','max_lon']){
      option.dataset[k] = territoire[k];
    }
  }
}

/**
 *  envoyer la valeur du territoire pour obtenir la commune
 */
function sendForm(ev){ // form event listener
	ev.preventDefault();
    let args = new FormData(this); 
    let queryString = new URLSearchParams(args);
    
    let url = 'services/getCommunes.php?' + queryString;
    
    fetchFromJson(url).then(processAnswer).then(makeCommunesItems);
    lis.textContent = 'Please wait ...';
}

/**
 *  produire une liste des communes et changer la carte correspondante
 */
function makeCommunesItems(tab){
    lis.textContent = '';
	for (let territoire of tab){
		let liste = document.createElement('li');
            for (k in territoire){
              liste.dataset[k] = territoire[k];
            }
            liste.addEventListener('mouseover',function(){centerMapElt(liste);});

        liste.addEventListener("click",fetchCommune);
        
		liste.textContent = territoire.nom;
		lis.appendChild(liste);
	}
}

/**
 *  obtenir le détail de la commune
 */
function fetchCommune(){
    
    let url = 'services/getDetails.php?insee=' + this.dataset.insee;
    
    fetchFromJson(url).then(processAnswer).then(displayCommune);
    detail.textContent = 'Please wait ...';
}

/**
 *  afficher le détail des communes sous forme de tableau
 */
function displayCommune(commune){
    detail.textContent = '';
    let table = document.createElement('table');    
    detail.appendChild(table);
    
    let tr1 = document.createElement('tr');
    table.appendChild(tr1);
	for (i in commune){
        let th = document.createElement('th');
        
            if(i != "geo_shape"){
                th.textContent = i;
                tr1.appendChild(th);
            }
    }    
    
    let tr2 = document.createElement('tr');
    table.appendChild(tr2);
	for (n in commune){
        let td = document.createElement('td');
        
            if(n != "geo_shape"){
                td.textContent = commune[n];
                tr2.appendChild(td);
            }
    }
    
    createDetailMap(commune);
}

/**
 * Recentre la carte principale autour d'une zone rectangulaire
 * elt doit comporter les attributs dataset.min_lat, dataset.min_lon, dataset.max_lat, dataset.max_lon, 
 */
function centerMapElt(elt){
  let ds = elt.dataset;
  map.fitBounds([[ds.min_lat,ds.min_lon],[ds.max_lat,ds.max_lon]]);
}