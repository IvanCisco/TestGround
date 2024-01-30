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
    return eta
}

function checkbox(zone, document) {
    if (!zone.has("zone[]")) {
        document.getElementById("checkErr").style.visibility = "visible";
        return false;
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

    if (!checkbox(zone, document)) {
        return false;
    }
    return true;
}