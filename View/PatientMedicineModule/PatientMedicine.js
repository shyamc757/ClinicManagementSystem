function searchRequest() {
    console.log("Send_request_to_php");

    let requestData = {
        param1: 'value1', // use documet.getelement by ID stuff
        param2: 'value2',
        search_patient_id: document.getElementById("search_patient_id").value,
        search_patient_name: document.getElementById("search_patient_name").value,
        search_medicine_id: document.getElementById("search_medicine_id").value,
        search_medicine_name: document.getElementById("search_medicine_name").value,
        target_function: "searchPatientMedicine", 
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

    console.log(document.getElementById("search_patient_id").value);
    console.log(document.getElementById("search_patient_name").value);
    console.log(document.getElementById("search_medicine_id").value);
    console.log(document.getElementById("search_medicine_name").value);

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
    console.log(data);
    table = document.getElementById("PatientMedicineTable");
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
  fetch('./PatientMedicine_form.html')
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
      input_medicine_id: document.getElementById("input_medicine_id").value,
      input_count: document.getElementById("input_count").value,
      input_date_of_acquiry: document.getElementById("input_date_of_acquiry").value,
      target_function: "editPatientMedicine", 
      Password: "root",
      username: "root"
    };

  }
  else {
    requestData = {
      input_patient_id: document.getElementById("input_patient_id").value,
      input_medicine_id: document.getElementById("input_medicine_id").value,
      input_count: document.getElementById("input_count").value,
      input_date_of_acquiry: document.getElementById("input_date_of_acquiry").value,
      target_function: "insertPatientMedicine", 
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

  console.log("Printind count 4th" + requestData.input_count);

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
  fetch('./PatientMedicine_form.html')
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
          document.getElementById('input_medicine_id').value = dataList[2];
          document.getElementById('input_medicine_name').value = dataList[3];
          document.getElementById('input_count').value = dataList[4];
          document.getElementById('input_date_of_acquiry').value = dataList[5];
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
      medicine_id: dataList[2],
      count: dataList[4],
      date_of_acquiry: dataList[5],
      target_function: "deletePatientMedicine", 
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