function searchRequest() {
    console.log("Send_request_to_php");

    let requestData = {
        param1: 'value1', // use documet.getelement by ID stuff
        param2: 'value2',
        search_user_id: document.getElementById("search_user_id").value,
        search_user_name: document.getElementById("search_user_name").value,
        search_user_role: document.getElementById("search_user_role").value,
        search_is_deleted: document.getElementById("search_is_deleted").checked,

        target_function: "searchUser", 
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
    table = document.getElementById("UserTable");
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
  fetch('./User_form.html')
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
      input_user_id: document.getElementById("input_user_id").value,
      input_user_name: document.getElementById("input_user_name").value,
      input_user_pw: document.getElementById("input_user_pw").value,
      input_user_role: document.getElementById("input_user_role").value,
      input_is_deleted: document.getElementById("input_is_deleted").checked,
      target_function: "editUser", 
      Password: "root",
      username: "root"
    };

  }
  else {
    requestData = {
      input_user_id: document.getElementById("input_user_id").value,
      input_user_name: document.getElementById("input_user_name").value,
      input_user_pw: document.getElementById("input_user_pw").value,
      input_user_role: document.getElementById("input_user_role").value,
      input_is_deleted: document.getElementById("input_is_deleted").checked,
      target_function: "insertUser", 
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
  fetch('./User_form.html')
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
          document.getElementById('input_user_id').value = dataList[0];
          document.getElementById('input_user_name').value = dataList[1];
          document.getElementById('input_user_pw').value = dataList[2];
          document.getElementById('input_user_role').value = dataList[3];
          document.getElementById('input_is_deleted').checked = dataList[4] != "0";
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
      user_id: dataList[0],
      target_function: "deleteUser", 
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