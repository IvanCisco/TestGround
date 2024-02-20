// Function to get the current date in YYYY-MM-DD format
function getCurrentDate() {
   var oggi = new Date();
   a = oggi.getDate();
   /*
    const year = currentDate.getFullYear();
    const month = (currentDate.getMonth() + 1).toString().padStart(2, '0');
    const day = currentDate.getDate().toString().padStart(2, '0');
    return `${year}-${month}-${day}`;
    */
   return a;
}

// Function to get the current time in HH:MM:SS format
function getCurrentTime() {
    var oggi = new Date();
   a = oggi.getTime();
   /*
    const currentTime = new Date();
    const hours = currentTime.getHours().toString().padStart(2, '0');
    const minutes = currentTime.getMinutes().toString().padStart(2, '0');
    const seconds = currentTime.getSeconds().toString().padStart(2, '0');
    return `${hours}:${minutes}:${seconds}`;
    */
   return a 
}

function redirectdelay(delay, url) {
  setTimeout(function() {
    window.location.href = url;
  }, delay);
}

function openEditForm() {
    // Logic to open a modal for editing the menu item with ID = itemId
    //console.log("Opening edit modal for item ID:", id);
    // Implement your modal functionality here
  document.getElementById('editForm').style.display = 'block';
}


//BHO 
  function deleteItem(itemId) {
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "http://localhost/SITO_NOVEMBRE2023/backend/elimina_piatto.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                // Successful response, do something with the response
              console.log
                console.log("Item deleted successfully");
                // Perform any UI updates
            } else {
                // Error handling
                console.error("Error deleting item:", xhr.status);
            }
        }
    };
    
    var data = "id=" + itemId; // Data to be sent (item ID)
    xhr.send(data);
}

//
function confirmDelete(mail, nome, prezzo, descrizione) {
  const confirmed = confirm("Sei sicuro di volerlo eliminare dal menu?");
  if (confirmed) {
    // Use AJAX to send a request to your PHP file with the item details
    const xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
    if (xhr.readyState === XMLHttpRequest.DONE) {
      if (xhr.status === 200) {
        console.log("Item deleted successfully");
                  //document.getElementById("message").innerText = "Eliminazione avvenuta con successo, verrà ricaricato il menu";
                  openModal("Eliminzione avvenuta con successo, verrà ricaricato il menu con le modifiche");
                  /*redirectdelay(5000, 'ristorante.php');*/
        console.log(xhr.responseText);
                  let risultato = JSON.parse(xhr.responseText);
        let itemCancellato = document.getElementById(mail + nome.replace(/ /g, '') + prezzo.replace('.', ''));

        console.log(itemCancellato);
        if (risultato.successo) {
          
          
                      if (itemCancellato) {
                          /*itemCancellato.parentNode.removeChild(itemCancellato);*/
                          /*itemCancellato.style.display = 'none';*/
            console.log("sono dentro")
            itemCancellato.remove();
                      } 
        } else {
          openModal("Error deleting item");
          console.error("Errore durante l'eliminazione");
          // Handle error
          console.error("Errore nella cancellazione: " + risultato.errore);
        }
      }
          }
      };
      xhr.open("POST", "../backend/elimina_piatto.php", true);
      xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      xhr.send(`nome=${nome}&prezzo=${prezzo}&descrizione=${descrizione}`);
  }
}



  //POP UP finestra con errore
  function showError(errorMessage) {
    window.alert(errorMessage);
    window.location.href = "../login.php"; // Redirect to login page
}


function openModal(message) {
  document.getElementById("modalMessage").innerText = message;
  document.getElementById("myModal").style.display = "block";
}

function closeModal() {
  document.getElementById("myModal").style.display = "none";
}

function showHideCardFields() {
            var metodoPagamento = document.getElementById("metodoPagamento").value;
            var cardFieldsContainer = document.getElementById("cardFieldsContainer");

            if (metodoPagamento === "carta") {
                cardFieldsContainer.style.display = "block";
            } else {
                cardFieldsContainer.style.display = "none";
            }
        }
function updateHiddenFieldWithSelectedPlates() {
        // Assuming you have a way to get the selected plates, for example, using checkboxes
        var selectedPlatesArray = [];

        // ... logic to gather selected plates into selectedPlatesArray ...

        // Update the hidden input field with the selected plates
        document.getElementById('selectedPlates').value = selectedPlatesArray.join('|');

        // Return true to allow the form submission
        return true;
    }

function prepareSelectedPlates() {
  // Get the selected plates and update the value of the hidden input field
  var selectedPlates = document.querySelectorAll('input[name="selectedPlates[]"]:checked');
  var selectedPlatesArray = Array.from(selectedPlates).map(plate => plate.value);
  document.getElementById('selectedPlates').value = JSON.stringify(selectedPlatesArray);
}

function submitForm() {
    // Retrieve selected plates and update the hidden input field
    var selectedPlates = getSelectedPlates();  // Implement this function to get selected plates
    document.getElementById('selectedPlates').value = selectedPlates;

    // Submit the form
    document.getElementById('confirmform').submit();
}

