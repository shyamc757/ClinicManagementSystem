<?php
$data = json_decode(file_get_contents('php://input'), true);
require __DIR__ . '/user_select.php';
require __DIR__ . '/appointment_select.php';
require __DIR__ . '/billing_select.php';
require __DIR__ . '/department_select.php';
require __DIR__ . '/employee_select.php';
require __DIR__ . '/inventory_select.php';
require __DIR__ . '/patient_medicine_select.php';
require __DIR__ . '/patient_select.php';



if ($data) {
  // $param1 = $data['param1'];
  // $param2 = $data['param2'];
  // $search_appointment_id = $data['search_appointment_id'];
  $target_function = $data['target_function'];
  //do whatever
  // myfunction($search_appointment_id);
// } else {
//   echo "No data received";
 static $cali_app_id = null;
  if ($target_function == "searchUser") {
    $username = $data['username'] ?? null;
    $Password = $data['Password'] ?? null;
    $search_user_id = $data['search_user_id'] ?? null;
    $search_user_name = $data['search_user_name'] ?? null;
    $search_user_role = $data['search_user_role'] ?? null;
    $search_is_deleted = $data['search_is_deleted'] ?? null;
    select_user($username, $Password, $search_user_id, $search_user_name, $search_user_role, $search_is_deleted);
  }

  else if ($target_function == "insertUser") {
    $username = $data['username'] ?? null;
    $Password = $data['Password'] ?? null;
    $input_user_id = $data['input_user_id'] ?? null;
    $input_user_name = $data['input_user_name'] ?? null;
    $input_user_pw = $data['input_user_pw'] ?? null;
    $input_user_role = $data['input_user_role'] ?? null;
    $input_is_deleted = $data['input_is_deleted'] ?? null;
    insert_user_with_pw($username, $Password, $input_user_id, $input_user_name, $input_user_role, $input_is_deleted, $input_user_pw);
  }

  else if ($target_function == "editUser") {
    $username = $data['username'] ?? null;
    $Password = $data['Password'] ?? null;
    $input_user_id = $data['input_user_id'] ?? null;
    $input_user_name = $data['input_user_name'] ?? null;
    $input_user_pw = $data['input_user_pw'] ?? null;
    $input_user_role = $data['input_user_role'] ?? null;
    $input_is_deleted = $data['input_is_deleted'] ?? null;
    edit_user($username, $Password, $input_user_id, $input_user_name, $input_user_role, $input_is_deleted, $input_user_pw);
  }
  else if ($target_function == "deleteUser") {
    $username = $data['username'] ?? null;
    $Password = $data['Password'] ?? null;
    $user_id = $data['user_id'] ?? null;

    mark_user_deleted($username, $Password, $user_id);
  }
  else if ($target_function == "searchAppointment") {
    $username = $data['username'] ?? null;
    $Password = $data['Password'] ?? null;
    $search_appointment_id = $data['search_appointment_id'] ?? null;
    $search_patient_id = $data['search_patient_id'] ?? null;
    $search_doctor_id = $data['search_doctor_id'] ?? null;
    $search_appointment_date = $data['search_appointment_date'] ?? null;
    $search_appointment_time = $data['search_appointment_time'] ?? null;
    $arrived = $data['arrived'] ?? null;
    $search_patient_name = $data['search_patient_name'] ?? null; //f_name only
    $search_doctor_name = $data['search_doctor_name'] ?? null; //f_name only
    $search_dep_code = $data['search_dep_code'] ?? null;
    select_appointment($username, $Password, $search_appointment_id, $search_patient_id, $search_doctor_id, $search_appointment_date, $search_appointment_time, $arrived, $search_patient_name, $search_doctor_name, $search_dep_code);

  }
  else if ($target_function == "insertAppointment") {

    $username = $data['username'] ?? null;
    $Password = $data['Password'] ?? null;
    $input_patient_id = $data['input_patient_id'] ?? null;
    $input_doctor_id = $data['input_doctor_id'] ?? null;
    $input_appointment_date = $data['input_appointment_date'] ?? null;
    $input_appointment_time = $data['input_appointment_time'] ?? null;

    insert_appointment($username, $Password, $input_patient_id, $input_doctor_id, $input_appointment_date, $input_appointment_time);
  }

  else if ($target_function == "deleteAppointment") {
    $appointment_id = $data['appointment_id'] ?? null;
    $username = $data['username'] ?? null;
    $Password = $data['Password'] ?? null;
    delete_appointment($username, $Password, $appointment_id);
  }

  else if ($target_function == "editAppointment") {
    $username = $data['username'] ?? null;
    $Password = $data['Password'] ?? null;
    $input_patient_id = $data['input_patient_id'] ?? null;
    $edit_appointment_id = $data['edit_appointment_id'] ?? null;
    $input_doctor_id = $data['input_doctor_id'] ?? null;
    $input_appointment_date = $data['input_appointment_date'] ?? null;
    $input_appointment_time = $data['input_appointment_time'] ?? null;
    $input_arrived = $data['input_arrived'] ?? null;

    edit_appointment($username, $Password, $input_patient_id, $input_doctor_id, $input_appointment_date, $input_appointment_time, $edit_appointment_id, $input_arrived);
    if($input_arrived == "1") {
      billing_insert($username, $Password, "33",  $input_patient_id, $edit_appointment_id);
      $cali_app_id = $edit_appointment_id;
    }
  }
  
  else if($target_function == "searchInventory") {
    $username = $data['username'] ?? null;
    $Password = $data['Password'] ?? null;     
    $search_medicine_id = $data['search_medicine_id'] ?? null;
    $search_medicine_name = $data['search_medicine_name'] ?? null;
    $search_inventory_count = $data['search_inventory_count'] ?? null;

    select_inventory($username, $Password, $search_medicine_id, $search_medicine_name, $search_inventory_count);
  }
  else if($target_function == "insertInventory") {
    $username = $data['username'] ?? null;
    $Password = $data['Password'] ?? null;     
    $input_medicine_name = $data['input_medicine_name'] ?? null;
    $input_medicine_count = $data['input_medicine_count'] ?? null;
    $input_cost_per_dose = $data['input_cost_per_dose'] ?? null;
    $input_expiration_date = $data['input_expiration_date'] ?? null;
    
    insert_inventory($username, $Password, $input_medicine_name, $input_medicine_count, $input_expiration_date, $input_cost_per_dose);
  }

  else if($target_function == "editInventory") {
    $username = $data['username'] ?? null;
    $Password = $data['Password'] ?? null;
    $input_medicine_id = $data['input_medicine_id'] ?? null;
    $input_medicine_name = $data['input_medicine_name'] ?? null;
    $input_medicine_count = $data['input_medicine_count'] ?? null;
    $input_cost_per_dose = $data['input_cost_per_dose'] ?? null;
    $input_expiration_date = $data['input_expiration_date'] ?? null;
    
    edit_inventory($username, $Password, $input_medicine_name, $input_medicine_count, $input_expiration_date, $input_cost_per_dose, $input_medicine_id);
  }

  else if($target_function == "deleteInventory") {
    $username = $data['username'] ?? null;
    $Password = $data['Password'] ?? null;
    $medicine_id = $data['medicine_id'] ?? null;
    
    delete_inventory($username, $Password, $medicine_id);
  }


  else if ($target_function == "searchBilling") {
    $username = $data['username'] ?? null;
    $Password = $data['Password'] ?? null;     
    $search_billing_id = $data['search_billing_id'] ?? null;     
    $search_patient_id = $data['search_patient_id'] ?? null; 
    $search_patient_name = $data['search_patient_name'] ?? null; 
    $search_appointment_id = $data['search_appointment_id'] ?? null;
    $search_billing_date = $data['search_billing_date'] ?? null;
    $search_bill_paid_date = $data['search_bill_paid_date'] ?? null;
    
    billing_select($username, $Password, $search_billing_id, $search_patient_id, $search_patient_name, $search_appointment_id, $search_billing_date, $search_bill_paid_date);
  }
  
  else if ($target_function == "EditBilling") {
    $username = $data['username'] ?? null;
    $Password = $data['Password'] ?? null;
    $input_billing_id = $data['input_billing_id'] ?? null;     
    $input_bill_paid = $data['input_bill_paid'] ?? null; 
    
    billing_update($username, $Password, $input_billing_id, $input_bill_paid);
  }
  else if ($target_function == "deleteBilling") {
    $username = $data['username'] ?? null;
    $Password = $data['Password'] ?? null;
    $billing_id = $data['billing_id'] ?? null;
    
    billing_delete($username, $Password, $billing_id);
  } 

  else if ($target_function == "searchDepartment") {
    $username = $data['username'] ?? null;
    $Password = $data['Password'] ?? null;     
    $search_department_id = $data['search_department_id'] ?? null;
    $search_department_name = $data['search_department_name'] ?? null;
    depeartment_select($username, $Password, $search_department_id, $search_department_name);
  }

  else if ($target_function == "insertDepartment") {
    $username = $data['username'] ?? null;
    $Password = $data['Password'] ?? null;     
    $input_department_name = $data['input_department_name'] ?? null;
    depeartment_insert($username, $Password, $input_department_name);
  }

  else if ($target_function == "editDepartment") {
    $username = $data['username'] ?? null;
    $Password = $data['Password'] ?? null; 
    $input_department_id = $data['input_department_id'] ?? null;
    $input_department_name = $data['input_department_name'] ?? null;
    depeartment_update($username, $Password, $input_department_name, $input_department_id);
  }

  else if ($target_function == "deleteDepartment") {
    $username = $data['username'] ?? null;
    $Password = $data['Password'] ?? null; 
    $department_id = $data['department_id'] ?? null;
    depeartment_delete($username, $Password, $department_id);
  }


  else if ($target_function == "searchPatientRegistration") {
    $username = $data['username'] ?? null;
    $Password = $data['Password'] ?? null;      
    $search_patient_id = $data['search_patient_id'] ?? null;      
    $search_patient_name = $data['search_patient_name'] ?? null; 
    $search_patient_email = $data['search_patient_email'] ?? null; 
    $search_phone_number = $data['search_phone_number'] ?? null; 

    patient_select($username, $Password, $search_patient_id, $search_patient_name, $search_patient_email, $search_phone_number);
  }

  else if ($target_function == "insertPatientRegistration") {
    $username = $data['username'] ?? null;
    $Password = $data['Password'] ?? null;      
    $input_patient_name = $data['input_patient_name'] ?? null;      
    $input_patient_email = $data['input_patient_email'] ?? null; 
    $input_medical_conditoin = $data['input_medical_conditoin'] ?? null; 
    $input_patient_phone = $data['input_patient_phone'] ?? null; 
    $input_patient_address = $data['input_patient_address'] ?? null; 
    $input_patient_DOB = $data['input_patient_DOB'] ?? null; 

    $patient_id = user_insert($username, $Password, "patient", $input_patient_email);
    patient_insert($username, $Password, $input_patient_name, $input_patient_email, $input_medical_conditoin, $input_patient_phone, $input_patient_address, $input_patient_DOB, $patient_id);
  }

  else if ($target_function == "editPatientRegistration") {
    $username = $data['username'] ?? null;
    $Password = $data['Password'] ?? null;
    $input_patient_id = $data['input_patient_id'] ?? null;  
    $input_patient_name = $data['input_patient_name'] ?? null;      
    $input_patient_email = $data['input_patient_email'] ?? null; 
    $input_medical_conditoin = $data['input_medical_conditoin'] ?? null; 
    $input_patient_phone = $data['input_patient_phone'] ?? null; 
    $input_patient_address = $data['input_patient_address'] ?? null; 
    $input_patient_DOB = $data['input_patient_DOB'] ?? null; 

    patient_update($username, $Password, $input_patient_name, $input_patient_email, $input_medical_conditoin, $input_patient_phone, $input_patient_address, $input_patient_DOB, $input_patient_id);
  }
  
  else if ($target_function == "markAsDeletedPatient") {
    $username = $data['username'] ?? null;
    $Password = $data['Password'] ?? null;
    $patient_id = $data['patient_id'] ?? null;

    mark_user_deleted($username, $Password, $patient_id);
  }

  else if ($target_function == "searchPatientMedicine") {
    $username = $data['username'] ?? null;
    $Password = $data['Password'] ?? null;   
    $search_patient_id = $data['search_patient_id'] ?? null;
    $search_patient_name = $data['search_patient_name'] ?? null;
    $search_medicine_id = $data['search_medicine_id'] ?? null;
    $search_medicine_name = $data['search_medicine_name'] ?? null;
    patient_medicine_search($username, $Password, $search_patient_id, $search_patient_name, $search_medicine_id, $search_medicine_name);
  }
  
  else if ($target_function == "insertPatientMedicine") {
    $username = $data['username'] ?? null;
    $Password = $data['Password'] ?? null;   
    $input_patient_id = $data['input_patient_id'] ?? null;
    $input_medicine_id = $data['input_medicine_id'] ?? null;
    $input_count = $data['input_count'] ?? null;
    $input_date_of_acquiry = $data['input_date_of_acquiry'] ?? null;
    // echo "Count is 3rd" . $input_count;
    patient_medicine_insert($username, $Password, $input_patient_id, $input_medicine_id, $input_count, $input_date_of_acquiry);

    //reduce medicine count
    edit_inventory_count($username, $Password, $input_medicine_id);

    //update billing
    billing_update_cost($username, $Password, $input_patient_id);
  }

  else if ($target_function == "deletePatientMedicine") {
    $username = $data['username'] ?? null;
    $Password = $data['Password'] ?? null;   
    $patient_id = $data['patient_id'] ?? null;
    $medicine_id = $data['medicine_id'] ?? null;
    $count = $data['count'] ?? null;
    $date_of_acquiry = $data['date_of_acquiry'] ?? null;
    // echo "Count is 3rd" . $count;
    patient_medicine_delete($username, $Password, $patient_id, $medicine_id, $count, $date_of_acquiry);
  }

  else if ($target_function == "editPatientMedicine") {
    $username = $data['username'] ?? null;
    $Password = $data['Password'] ?? null;   
    $input_patient_id = $data['input_patient_id'] ?? null;
    $input_medicine_id = $data['input_medicine_id'] ?? null;
    $input_count = $data['input_count'] ?? null;
    $input_date_of_acquiry = $data['input_date_of_acquiry'] ?? null;
 //   patient_medicine_delete($username, $Password, $patient_id, $medicine_id, $count, $date_of_acquiry);
   // patient_medicine_insert($username, $Password, $input_patient_id, $input_medicine_id, $input_count, $input_date_of_acquiry);
  }

  else if ($target_function == "searchEmployee") {
    $username = $data['username'] ?? null;
    $Password = $data['Password'] ?? null;   
    $search_employee_id  = $data['search_employee_id'] ?? null;   
    $search_employee_name = $data['search_employee_name'] ?? null;   
    $search_department_code = $data['search_department_code'] ?? null;   
    $search_employee_email = $data['search_employee_email'] ?? null;   
    
    employee_select($username, $Password, $search_employee_id, $search_department_code, $search_employee_name, $search_employee_email);
  
  }  

  else if ($target_function == "addEmployee") {
    $username = $data['username'] ?? null;
    $Password = $data['Password'] ?? null;    

    $input_employee_name = $data['input_employee_name'] ?? null;   
    $input_dep_code = $data['input_dep_code'] ?? null;   
    $input_employee_address = $data['input_employee_address'] ?? null;
    $input_employee_email = $data['input_employee_email'] ?? null;

    $input_employee_phone = $data['input_employee_phone'] ?? null;
    $input_employee_designation = $data['input_employee_designation'] ?? null;

    $employee_id = user_insert($username, $Password, "employee", $input_employee_email);
    employee_insert($username, $Password, $employee_id, $input_employee_name, $input_dep_code, $input_employee_address, $input_employee_email, $input_employee_phone, $input_employee_designation);
  } 
  
  else if ($target_function == "editEmployee") {
    $username = $data['username'] ?? null;
    $Password = $data['Password'] ?? null;    

    $input_employee_id = $data['input_employee_id'] ?? null;   
    $input_employee_name = $data['input_employee_name'] ?? null;   
    $input_dep_code = $data['input_dep_code'] ?? null;   
    $input_employee_address = $data['input_employee_address'] ?? null;
    $input_employee_email = $data['input_employee_email'] ?? null;

    $input_employee_phone = $data['input_employee_phone'] ?? null;
    $input_employee_designation = $data['input_employee_designation'] ?? null;

    employee_edit($username, $Password, $input_employee_id, $input_employee_name, $input_dep_code, $input_employee_address, $input_employee_email, $input_employee_phone, $input_employee_designation);
  }

  else if ($target_function == "markAsDeletedEmployee") {
    $username = $data['username'] ?? null;
    $Password = $data['Password'] ?? null;
    $employee_id = $data['employee_id'] ?? null;

    mark_user_deleted($username, $Password, $employee_id);
  }


  }

?>