function searchRequest() {
    console.log("Send_request_to_php");

    let requestData = {
        param1: 'value1', // use documet.getelement by ID stuff
        param2: 'value2',
        search_appointment_id: document.getElementById("search_appointment_id").value,
        search_patient_id: document.getElementById("search_patient_id").value,
        search_patient_name: document.getElementById("search_patient_name").value,
        search_doctor_id: document.getElementById("search_doctor_id").value,
        search_doctor_name: document.getElementById("search_doctor_name").value,
        search_dep_code: document.getElementById("search_dep_code").value,
        search_appointment_date: document.getElementById("search_appointment_date").value,
        search_appointment_time: document.getElementById("search_appointment_time").value,
        target_function: "searchAppointment", 
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
    table = document.getElementById("AppointmentTable");
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
  fetch('./Appointment_form.html')
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
      edit_appointment_id: window.edit_appointment_id,
      input_patient_id: document.getElementById("input_patient_id").value,
      input_patient_name: document.getElementById("input_patient_name").value,
      input_doctor_id: document.getElementById("input_doctor_id").value,
      input_appointment_date: document.getElementById("input_appointment_date").value,
      input_appointment_time: document.getElementById("input_appointment_time").value,
      input_arrived: document.getElementById("input_arrived").checked,
      target_function: "editAppointment", 
      Password: "root",
      username: "root"
    };

  }
  else {
    requestData = {
      input_patient_id: document.getElementById("input_patient_id").value,
      input_patient_name: document.getElementById("input_patient_name").value,
      input_doctor_id: document.getElementById("input_doctor_id").value,
      input_appointment_date: document.getElementById("input_appointment_date").value,
      input_appointment_time: document.getElementById("input_appointment_time").value,
      target_function: "insertAppointment", 
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
  fetch('./Appointment_form.html')
        .then(response => response.text())
        .then(data => {
          document.getElementById('form-container').innerHTML = data;
          var clickedRow = event.target.closest('tr');
          const dataList = [];
          for (const cell of clickedRow.querySelectorAll('td')) {
            dataList.push(cell.textContent);
          }
        
          console.log(dataList);
          window.edit_appointment_id = dataList[0];
          document.getElementById('input_patient_id').value = dataList[1];
          document.getElementById('input_patient_name').value = dataList[2];
          document.getElementById('input_doctor_id').value = dataList[3];
          document.getElementById('input_doctor_name').value = dataList[4];
          document.getElementById('input_appointment_date').value = dataList[6];
          document.getElementById('input_appointment_time').value = dataList[7];
          document.getElementById('input_arrived').checked = dataList[8] != "0";
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
      appointment_id: dataList[0],
      target_function: "deleteAppointment", 
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