function checkAge(dataNascita) {
    let eta = getAge(dataNascita);
    if (eta < 18) {
        alert("Devi essere maggiorenne per fare il fattorino!");
        return false;
    }
    return true;
}

function getAge(dataNascita) {
    let oggi = new Date();
    let compleanno = new Date(dataNascita);
    let eta = oggi.getFullYear() - compleanno.getFullYear();
    let m = oggi.getMonth() - compleanno.getMonth();
    if (m < 0 || (m === 0  && oggi.getDate() < compleanno.getDate())) {
        eta--;
    }
    return eta;
}

function checkbox(zone) {
    if (!zone.has("zone[]")) {
        document.getElementById("checkErr").style.visibility = "visible";
        return false;
    } else {
        document.getElementById("checkErr").style.visibility = "hidden";
        return true;
    }
}

let indice = 1;
function aggiungiCampo() {
    let nuovoCampo = document.createElement("div");
    nuovoCampo.className = "dynamicField";
    nuovoCampo.innerHTML = `
        <label for="giorno${indice}">Giorno: </label>
        <select id="giorno${indice}" name="giorno[]" required>
            <option disabled selected value></option>
            <option value="Lunedi">Lunedì</option>
            <option value="Martedì">Martedì</option>
            <option value="Mercoledì">Mercoledì</option>
            <option value="Giovedì">Giovedì</option>
            <option value="Venerdì">Venerdì</option>
            <option value="Sabato">Sabato</option>
            <option value="Domenica">Domenica</option>
        </select>
        <label for="orainizio${indice}">Orario di apertura: </label>
        <input type="time" id="orainizio${indice}" name="orainizio[]" step="300" required>
        <label for="orafine${indice}">Orario di chiusura: </label>
        <input type="time" id="orafine${indice}" name="orafine[]" step="300" required>

        <button type="button" onclick="rimuoviCampo(this, ${indice})">-</button>
    `;
    document.getElementById("dynamicFieldContainer").appendChild(nuovoCampo);
    indice++;
}

function rimuoviCampo(bottone, indiceAttuale) {
    let dynamicField = bottone.parentNode;
    dynamicField.parentNode.removeChild(dynamicField);

    let dynamicFields = document.getElementsByClassName("dynamicField");
    for (let i = 0; i <dynamicFields.length; i++) {
        let inputs = dynamicFields[i].getElementsByTagName("select");
        for (let j = 0; j < inputs.length; j++) {
            let inputId = inputs[j].id;
            let matches = inputId.match(/\d+/);
            if (matches && matches.length > 0) {
                let vecchioIndice = parseInt(matches[0]);
                if (vecchioIndice > indiceAttuale) {
                    let nuovoIndice = vecchioIndice - 1;
                    inputs[j].id = inputs[j].id.replace(vecchioIndice, nuovoIndice);
                    inputs[j].name = inputs[j].name.replace(vecchioIndice, nuovoIndice);
                }
            }
        }
    }
    indice--;
}

function validazione() {
    let datanascita = document.getElementById("datanascita").value;
    let zone = new FormData(document.querySelector("form"));
    if (!checkAge(datanascita)) {
        return false;
    }

    if (!checkbox(zone)) {
        return false;
    }
    return true;
}

function mostraCampiCarta() {
    let metodoPagamento = document.getElementById("metodoPagamento").value;
    const dati = document.getElementsByClassName("daticarta");
    if (metodoPagamento == "carta") {
        document.getElementById("campiCarta").style.display = "block";
        document.getElementById("campiCarta").style.visibility = "visible";
        for (const dato of dati) {
            dato.setAttribute("required", "");
          }
    } else {
        document.getElementById("campiCarta").style.display = "none";
        document.getElementById("campiCarta").style.visibility = "hidden";
        for (const dato of dati) {
            dato.removeAttribute("required");
          }
    }
}

function eliminaOrari(giorno, orainizio, orafine, mail, tabella) {
    if (confirm("Sei sicuro di voler cancellare questo orario?")) {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.open("POST", "../backend/eliminaorario.php", true);
        xmlhttp.setRequestHeader("Content-Type", "application/json");
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == XMLHttpRequest.DONE) {
                if (xmlhttp.status == 200) {
                    console.log(xmlhttp.responseText);
                    let risultato = JSON.parse(xmlhttp.responseText);
                    if (risultato.successo) {
                        alert("Eliminazione avvenuta con successo");
                        console.log("Eliminazione avvenuta con successo!");
                        let itemCancellato = document.getElementById(giorno + orainizio + orafine);
						console.log(itemCancellato);
                        if (itemCancellato) {
							console.log("sono dentro")
							itemCancellato.remove();
                        } 
                    } else {
                        alert("Errore nella cancellazione: " + risultato.errore);
                        console.error("Errore nella cancellazione" + risultato.errore);
                        console.log(giorno + " " + orainizio + " " + orafine + " " + mail + " " + tabella);
                    }
                }
            }
        };
        xmlhttp.send(JSON.stringify({g: giorno, inizio: orainizio, fine: orafine, email: mail, tab: tabella}));
    }
}

function eliminaPiatto(mail, id, nome, prezzo, descrizione, tipo, elenco) {
    if (confirm("Sei sicuro di voler eliminare questo " + tipo + "?")) {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.open("POST", "../backend/elimina_piatto.php", true);
        xmlhttp.setRequestHeader("Content-Type", "application/json");
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == XMLHttpRequest.DONE) {
                if (xmlhttp.status == 200) {
                    console.log(xmlhttp.responseText);
                    let risultato = JSON.parse(xmlhttp.responseText);
                    if (risultato.successo) {
                        alert("Eliminazione avvenuta con successo. Risposta: " + risultato.errore);
                        console.log("Eliminazione avvenuta con successo");
                        let itemCancellato = document.getElementById(id);
                        console.log("Questo è l'ID dell'elemento che cancello: " + id);
                        if (itemCancellato) {
                            itemCancellato.remove();
                        }
                    } else {
                        alert("Errore nella cancellazione: " + risultato.errore);
                        console.error("Errore nella cancellazione: " + risultato.errore);
                        console.log("Parametri in arrivo: " + mail + " " + id + " " + nome + " " + prezzo + " " + descrizione + " " + tipo + " " + elenco);
                    }
                }
            }
        };
        xmlhttp.send(JSON.stringify({maill: mail, nomee: nome, prezzoo: prezzo, descrizionee: descrizione, tipoo: tipo, elencoo: elenco}));
    }
}

document.addEventListener("DOMContentLoaded", function() {
    document.getElementById('prezzo').addEventListener('input', function(event) {
        formattaPrezzo(event.target);
    });
});

function formattaPrezzo(input) {
    let inputVal = input.value;

    // Rimuovi tutto ciò che non è un numero
    inputVal = inputVal.replace(/\D/g, '');

    // Limita l'input a 4 numeri
    inputVal = inputVal.substring(0, 4);

    // Se l'input è più lungo di due numeri, inserisci un punto dopo il secondo numero
    if (inputVal.length > 2) {
        inputVal = inputVal.substring(0, 2) + '.' + inputVal.substring(2);
    }

    // Mostra la stringa formattata
    input.value = inputVal;
}