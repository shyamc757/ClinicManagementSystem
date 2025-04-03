function searchRequest() {
    console.log("Send_request_to_php");

    let requestData = {
      param1: 'value1', // use documet.getelement by ID stuff
      param2: 'value2',
      search_billing_id: document.getElementById("search_billing_id").value,
      search_patient_id: document.getElementById("search_patient_id").value,
      search_patient_name: document.getElementById("search_patient_name").value,
      search_appointment_id: document.getElementById("search_appointment_id").value,
      search_billing_date: document.getElementById("search_billing_date").value,
      search_bill_paid_date: document.getElementById("search_bill_paid_date").value,
      target_function: "searchBilling", 
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
    table = document.getElementById("BillingTable");
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
  fetch('./Billing_form.html')
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
      input_billing_id: document.getElementById("input_billing_id").value,
      input_bill_paid: document.getElementById("input_bill_paid").value,
      target_function: "EditBilling", 
      Password: "root",
      username: "root"
  };
  }
  else {
    requestData = {
      input_billing_id: document.getElementById("input_billing_id").value,
      input_patient_id: document.getElementById("input_patient_id").value,
      input_patient_name: document.getElementById("input_patient_name").value,
      input_billing_date: document.getElementById("input_billing_date").value,
      input_bill_paid: document.getElementById("input_bill_paid").value,
      input_bill_amount: document.getElementById("input_bill_amount").value,
      target_function: "", 
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
  fetch('./Billing_form.html')
        .then(response => response.text())
        .then(data => {
          document.getElementById('form-container').innerHTML = data;
          var clickedRow = event.target.closest('tr');
          const dataList = [];
          for (const cell of clickedRow.querySelectorAll('td')) {
            dataList.push(cell.textContent);
          }
        
          console.log(dataList);
          document.getElementById('input_billing_id').value = dataList[0];
          document.getElementById('input_patient_id').value = dataList[1];
          document.getElementById('input_patient_name').value = dataList[2];
          document.getElementById('input_billing_date').value = dataList[4];
          document.getElementById('input_bill_paid').checked = dataList[5];
          document.getElementById('input_bill_amount').value = dataList[6];
        })
        .catch(error => {
          console.error('Error:', error);
        });
}

function my_delete(event){
  // console.log("my_delete");
  const response = confirm("Are you sure you want to Delete this?");
  if (response) {
    // console.log("Delete here");
    var clickedRow = event.target.closest('tr');
          const dataList = [];
          for (const cell of clickedRow.querySelectorAll('td')) {
            dataList.push(cell.textContent);
          }
        
    console.log(dataList[0]);
    requestData = {
      billing_id: dataList[0],
      target_function: "deleteBilling", 
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