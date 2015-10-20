/* Fonction Hide / Show */
/* -------------------- */

// cache l'ensemble d'objet
function hideEns(objet)
{
	var ensemble = getElementsByClassName(objet); // récupère l'ensemble avec la class
	for( i=0; i < ensemble.length; i++)// parcours une boucle de la longueur de l'ensemble
	{ 
		ensemble[i].style.display = "none"; // attribut à chaque élément l'attribut pour le caché
	}
}

// cache un objet unique
function hideUni(objet)
{
	var unique = document.getElementById(objet);
	unique.style.display = "none";
}

// montre un objet unique
function showUni(objet)
{
	var unique = document.getElementById(objet);
	unique.style.display = "inline";
}

/* Fonction getElementsByClasName */
/* ----------------------------- */
function getElementsByClassName(Class)
{
	// récupère l'ensemble des balises et initialise resultat
	var tags = document.getElementsByTagName("*"),resultat=[];
	
		// parcours une boucle dépendant du nombre de balise
		for(var i=0, long=tags.length; i<long; i++)
		{
			// si l'attribut (class) d'une des balises correspond à la notre
			if(tags[i].className === Class)
			{
			// ajoute au résultat les balises récupéré
			resultat.push(tags[i]);
			}
		}
	// renvoie le résultat
	return resultat;
}

/* création de l'objet getXMLHttpRequest - Ajax */
/* -------------------------------------------- */
function getXMLHttpRequest() {
	var xhr = null;
	
	if (window.XMLHttpRequest || window.ActiveXObject) {
		if (window.ActiveXObject) {
			try {
				xhr = new ActiveXObject("Msxml2.XMLHTTP");
			} catch(e) {
				xhr = new ActiveXObject("Microsoft.XMLHTTP");
			}
		} else {
			xhr = new XMLHttpRequest(); 
		}
	} else {
		alert("Votre navigateur ne supporte pas l'objet XMLHTTPRequest...");
		return null;
	}
	
	return xhr;
}


/* Ajax - récupération catégorie */
/* ----------------------------- */
// oSelect = <select> ; level = niveau hierarchie
function request(oSelect, level) {
	var oS, vS, el, name, option, text;

	// delete old cate
	for(i=(level+1); i<=3; i++){
		element = document.getElementById("cate"+i);
		
		while (element.firstChild) {
			element.removeChild(element.firstChild);
		}
	}
	
	// get actual cate
	oS = oSelect.options[oSelect.selectedIndex];
	vS = oS.value;
	name = oS.firstChild.nodeValue;
	
	// create one option
	// *******
	oS = document.getElementById("cate"+parseInt(level+1));
	
	// create option
	option = document.createElement("option");
	option.setAttribute("id", vS);
	option.setAttribute("disabled", "disabled");
	
	// create and append text
	text  = document.createTextNode(name);
	option.appendChild(text);
	
	oS.appendChild(option);
	// ********
	

	// get data
	// ********
	var xhr   = getXMLHttpRequest(),
		loader = document.getElementById('loader');
	
	xhr.onreadystatechange = function() {
		if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) {
			readData(xhr.responseXML, level);
			loader.style.display = "none";
		} else{
			loader.style.display = "inline";
		}
	};
	
	xhr.open("POST", "refresh.php", true);
	xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xhr.send("id="+vS+"&level="+level);
	// *******
}

function readData(oData, level) {
	var nodes   = oData.getElementsByTagName("item"),
		oS = document.getElementById("cate"+parseInt(level+1)),
		oO, oI;
	
	for (var i=0, c=nodes.length; i<c; i++) {
		oO = document.createElement("option");
		oI  = document.createTextNode(nodes[i].getAttribute("name"));
		oO.value = nodes[i].getAttribute("id");
		
		oO.appendChild(oI);
		oS.appendChild(oO);
	}
}

/* Admin : ajout / del / edit / effacer */
/* ------------------------------------ */
// add
function add(type){
	effacer();
	
	// catégorie 0
	if(type==0){
		// affiche add/submit
		document.getElementById('add').style.display = "inline";
		document.getElementById('submit').style.display = "inline";
		
		// remplit les champs hide
		hideChamp(0, type);
	}
	
	// catégorie 1+
	else{
		// récupère enfant cate -1
		var element = document.getElementById("cate"+type);	
	
		// si un enfant existe
		if(element.firstChild){
			// affiche add/submit
			document.getElementById('add').style.display = "inline";
			document.getElementById('submit').style.display = "inline";
			
			hideChamp(type, type);
		}
	}
}

// del
function del(type){
	document.getElementById('add').value = "";
	document.getElementById('edit').value = "";

	// récupère enfant cate
	var element = document.getElementById("cate"+type);	
	
		// si un enfant existe
		if(element.firstChild){
			// met del à 1
			document.getElementById('delete').value=1;

			// remplit les champs hide
			hideChamp(element, type);	
			document.getElementById('formulaire').submit();
		}
}

// edit
// affiche champ et texte d'edit + remplit champ hide
function edit(type){
	effacer();
	
	var cate = "cate"+type;
	// récupère enfant cate
	var element = document.getElementById(cate);

	// si un enfant existe
	if(element.firstChild)
	{
		// s'il existe un "vrai" enfant
		if(element.childNodes.length!=1)
		{
			// vérifit qu'un index est sélectionné
			if(element.selectedIndex!=-1)
			{
				
			// affiche edit / submit
			var edit = document.getElementById('edit');
			edit.style.display = "inline";
			document.getElementById('submit').style.display = "inline";
			
			// pré-remplit le champ
			edit.lastChild.value = element.options[element.selectedIndex].firstChild.nodeValue;
			
			// remplit les champs hide
			hideChamp(element, type);
			
			}
		}
	}
}

// effacer
function effacer(){
	// récupère class "cache" pour les caché
	var element = getElementsByClassName("cache");
	// affecte la valeur null au champ edit et add
	document.getElementById('edit').lastChild.value = "";
	document.getElementById('add').lastChild.value = "";
	
	// cache l'ensemble des elements (de la class)
	for(i=0, c=element.length; i<c; i++)
	{
		element[i].style.display = "none";	
	}
}

// remplit les hideChamp
// element : select; cate : id select
function hideChamp(element, cate){
	// si un element existe
	if(element)
	{
		//récupère le champ idCate
		var idCate = document.getElementById('idCate');

		// si c'est ajout
		if(parseInt(element)>=1)
		{
			// ajoute la valeur de l'option grisé
			idCate.value = document.getElementById("cate"+cate).firstChild.getAttribute("id");
		}
		// sinon edit
		else
		{
			// ajoute la valeur sélectionné
			idCate.value = element.options[element.selectedIndex].value;
		}
	}
	
		// remplit typeCate hide
		var typeCate = document.getElementById('typeCate');
		typeCate.value = parseInt(cate);
}