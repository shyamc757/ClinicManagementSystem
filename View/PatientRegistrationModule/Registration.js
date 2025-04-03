function searchRequest() {
  console.log("Send_request_to_php");

  let requestData = {
      search_patient_id: document.getElementById("search_patient_id").value,
      search_patient_name: document.getElementById("search_patient_name").value,
      search_patient_email: document.getElementById("search_patient_email").value,
      search_phone_number: document.getElementById("search_phone_number").value,
      target_function: "searchPatientRegistration", 
      Password: "root",
      username: "root"
  };

  let requestBody = {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json', 
      },
      body: JSON.stringify(requestData)
  }

  fetch('../../Controller/master_controller.php', requestBody)
  .then(response => response.text())
  .then(data => {
    do_something_with_data(data);
  })
  .catch(error => {
    console.error('Error:', error);
  });
}

function do_something_with_data(data) {
  // console.log(data);
  table = document.getElementById("PatientRegistrationTable");
  rows = table.querySelectorAll('tr');
  rows.forEach((row, index) => {
    if (index !== 0) {
      row.remove();
    }
  });
  table.innerHTML += data;
}

function openForm() {
window.isEdit = false;
fetch('./Registration_form.html')
      .then(response => response.text())
      .then(data => {
        // console.log(data);
        document.getElementById('form-container').innerHTML = data;
      })
      .catch(error => {
        console.error('Error:', error);
      });
}

function closeForm(){
document.getElementById("myPopup").classList.add("close");
window.isEdit = false;
}

function submitForm(){
let requestData = {}
if(window.isEdit) {
  requestData = {

    input_patient_id: document.getElementById("input_patient_id").value,
    input_patient_name: document.getElementById("input_patient_name").value,
    input_patient_email: document.getElementById("input_patient_email").value,
    input_medical_conditoin: document.getElementById("input_medical_conditoin").value,
    input_patient_phone: document.getElementById("input_patient_phone").value,
    input_patient_address: document.getElementById("input_patient_address").value,
    input_patient_DOB: document.getElementById("input_patient_DOB").value,
    target_function: "editPatientRegistration", 
    Password: "root",
    username: "root"
  };

}
else {
  requestData = {
    input_patient_name: document.getElementById("input_patient_name").value,
    input_patient_email: document.getElementById("input_patient_email").value,
    input_medical_conditoin: document.getElementById("input_medical_conditoin").value,
    input_patient_phone: document.getElementById("input_patient_phone").value,
    input_patient_address: document.getElementById("input_patient_address").value,
    input_patient_DOB: document.getElementById("input_patient_DOB").value,
    target_function: "insertPatientRegistration", 
    Password: "root",
    username: "root"
  };
}

let requestBody = {
  method: 'POST',
  headers: {
    'Content-Type': 'application/json', 
  },
  body: JSON.stringify(requestData)
}

fetch('../../Controller/master_controller.php', requestBody)
    .then(response => response.text())
    .then(data => {
      console.log(data);
      alert(data);
    })
    .catch(error => {
      console.log(error);
      alert(error);
    });
  document.getElementById("myPopup").classList.add("close");
  window.isEdit = false;
}

function openEditForm(event) {

window.isEdit = true;
fetch('./Registration_form.html')
      .then(response => response.text())
      .then(data => {
        document.getElementById('form-container').innerHTML = data;
        var clickedRow = event.target.closest('tr');
        const dataList = [];
        for (const cell of clickedRow.querySelectorAll('td')) {
          dataList.push(cell.textContent);
        }
      
        console.log(dataList);
        document.getElementById('input_patient_id').value = dataList[0];
        document.getElementById('input_patient_name').value = dataList[1];
        document.getElementById('input_patient_email').value = dataList[2];
        document.getElementById('input_medical_conditoin').value = dataList[3];

        document.getElementById('input_patient_phone').value = dataList[4];
        document.getElementById('input_patient_address').value = dataList[5];
        document.getElementById('input_patient_DOB').value = dataList[6];
      })
      .catch(error => {
        console.error('Error:', error);
      });
}

function my_delete(event) {
const response = confirm("Are you sure you want to Delete this?");
if (response) {
  console.log("Delete here");
  var clickedRow = event.target.closest('tr');
        const dataList = [];
        for (const cell of clickedRow.querySelectorAll('td')) {
          dataList.push(cell.textContent);
        }
      
  console.log(dataList[0]);
  requestData = {
    patient_id: dataList[0],
    target_function: "markAsDeletedPatient", 
    Password: "root",
    username: "root"
  };

  let requestBody = {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json', 
    },
    body: JSON.stringify(requestData)
  }

  fetch('../../Controller/master_controller.php', requestBody)
      .then(response => response.text())
      .then(data => {
        console.log(data);
        alert(data);
      })
      .catch(error => {
        console.log(error);
        alert(error);
      });
}
}