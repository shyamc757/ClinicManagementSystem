function searchRequest() {
    console.log("Send_request_to_php");

    let requestData = {
        param1: 'value1', // use documet.getelement by ID stuff
        param2: 'value2',
        search_medicine_id: document.getElementById("search_medicine_id").value,
        search_medicine_name: document.getElementById("search_medicine_name").value,
        search_inventory_count: document.getElementById("search_inventory_count").value,

        target_function: "searchInventory", 
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
    table = document.getElementById("InventoryTable");
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
  fetch('./Inventory_form.html')
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
      input_medicine_name: document.getElementById("input_medicine_name").value,
      input_medicine_count: document.getElementById("input_medicine_count").value,
      input_cost_per_dose: document.getElementById("input_cost_per_dose").value,
      input_expiration_date: document.getElementById("input_expiration_date").value,
      input_medicine_id:  document.getElementById("input_medicine_id").value,
      target_function: "editInventory", 
      Password: "root",
      username: "root"
    };

  }
  else {
    requestData = {
      input_medicine_name: document.getElementById("input_medicine_name").value,
      input_medicine_count: document.getElementById("input_medicine_count").value,
      input_cost_per_dose: document.getElementById("input_cost_per_dose").value,
      input_expiration_date: document.getElementById("input_expiration_date").value,
      target_function: "insertInventory", 
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
  fetch('./Inventory_form.html')
        .then(response => response.text())
        .then(data => {
          document.getElementById('form-container').innerHTML = data;
          var clickedRow = event.target.closest('tr');
          const dataList = [];
          for (const cell of clickedRow.querySelectorAll('td')) {
            dataList.push(cell.textContent);
          }
        
          console.log(dataList);
          document.getElementById('input_medicine_id').value = dataList[0];
          document.getElementById('input_medicine_name').value = dataList[1];
          document.getElementById('input_medicine_count').setAttribute('value', dataList[2].trim()) ;
          document.getElementById('input_cost_per_dose').setAttribute('value', dataList[3].trim()) ;
          document.getElementById('input_expiration_date').value = dataList[4];
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
      medicine_id: dataList[0],
      target_function: "deleteInventory", 
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