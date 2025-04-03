function searchRequest() {
    console.log("Send_request_to_php");

    let requestData = {
        param1: 'value1', // use documet.getelement by ID stuff
        param2: 'value2',
        search_employee_id: document.getElementById("search_employee_id").value,
        search_employee_name: document.getElementById("search_employee_name").value,
        search_department_code: document.getElementById("search_department_code").value,
        search_employee_email: document.getElementById("search_employee_email").value,
        target_function: "searchEmployee", 
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
    table = document.getElementById("EmployeeTable");
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
  fetch('./Employee_form.html')
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
        input_employee_id: document.getElementById("input_employee_id").value,
        input_employee_name: document.getElementById("input_employee_name").value,
        input_dep_code: document.getElementById("input_dep_code").value,
        input_employee_address: document.getElementById("input_employee_address").value,
        input_employee_email: document.getElementById("input_employee_email").value,
  
        input_employee_phone: document.getElementById("input_employee_phone").value,
        input_employee_designation: document.getElementById("input_employee_designation").value,
      target_function: "editEmployee", 
      Password: "root",
      username: "root"
    };

  }
  else {
    requestData = {
      input_employee_name: document.getElementById("input_employee_name").value,
      input_dep_code: document.getElementById("input_dep_code").value,
      input_employee_address: document.getElementById("input_employee_address").value,
      input_employee_email: document.getElementById("input_employee_email").value,

      input_employee_phone: document.getElementById("input_employee_phone").value,
      input_employee_designation: document.getElementById("input_employee_designation").value,
      target_function: "addEmployee", 
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
  fetch('./Employee_form.html')
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
          document.getElementById('input_employee_id').value = dataList[0];
          document.getElementById('input_employee_name').value = dataList[1];
          document.getElementById('input_dep_code').value = dataList[2];
          document.getElementById('input_employee_address').value = dataList[3];
          document.getElementById('input_employee_email').value = dataList[4];
          document.getElementById('input_employee_phone').value = dataList[5];
          document.getElementById('input_employee_designation').value = dataList[6];
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
      employee_id: dataList[0],
      target_function: "markAsDeletedEmployee", 
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