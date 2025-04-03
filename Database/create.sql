DROP SCHEMA IF EXISTS clinic_db;
CREATE SCHEMA clinic_db;
USE clinic_db;

DROP USER IF EXISTS 'admin'@'localhost';
DROP USER IF EXISTS 'doctor'@'localhost';
DROP USER IF EXISTS 'patient'@'localhost';
DROP USER IF EXISTS 'receptionist'@'localhost';
DROP USER IF EXISTS 'inventory_manager'@'localhost';

DROP TABLE IF EXISTS user;
CREATE TABLE user(user_id VARCHAR(255),
                  user_name VARCHAR(255),
                  password VARCHAR(255),
                  user_role VARCHAR(255) DEFAULT 'patient',
                  is_deleted bool DEFAULT FALSE,
                  PRIMARY KEY(user_id),
                  UNIQUE KEY(user_name)
                 );

DROP TABLE IF EXISTS patient;
CREATE TABLE patient(patient_id VARCHAR(255),
                     patient_fname VARCHAR(255),
                     patient_lname VARCHAR(255),
                     patient_email VARCHAR(255),
                     patient_phone VARCHAR(255),
                     patient_address VARCHAR(511),
                     patient_dob DATE,
                     medical_data VARCHAR(1023),
                     PRIMARY KEY(patient_id)
                    );

DROP TABLE IF EXISTS department;
CREATE TABLE department(department_code VARCHAR(255),
                        department_name VARCHAR(255),
                        PRIMARY KEY(department_code)
                       );

DROP TABLE IF EXISTS employee;
CREATE TABLE employee(employee_id VARCHAR(255),
                      department_code VARCHAR(255),
                      employee_fname VARCHAR(255),
                      employee_lname VARCHAR(255),
                      employee_address VARCHAR(511),
                      employee_email VARCHAR(255),
                      employee_phone VARCHAR(255),
                      employee_designation VARCHAR(1023),
                      PRIMARY KEY(employee_id)
                     );

DROP TABLE IF EXISTS appointment;
CREATE TABLE appointment(appointment_id VARCHAR(255), 
                         patient_id VARCHAR(255), 
                         doctor_id VARCHAR(255), 
                         appointment_date DATE,
                         appointment_time TIME,
                         arrived bool DEFAULT FALSE,
                         PRIMARY KEY(appointment_id)
                        );

DROP TABLE IF EXISTS medical_inventory;
CREATE TABLE medical_inventory(medicine_id VARCHAR(255),
                               medicine_name VARCHAR(255),
                               count INT,
                               cost_per_dose DOUBLE,
                               expiry_date DATE,
                               PRIMARY KEY(medicine_id)
                              );

DROP TABLE IF EXISTS patient_medicine;
CREATE TABLE patient_medicine(patient_id VARCHAR(255),
                              medicine_id VARCHAR(255),
                              count INT,
                              date_of_acquiry DATETIME
                             );

DROP TABLE IF EXISTS billing;
CREATE TABLE billing(billing_id VARCHAR(255),
                     billing_amt DOUBLE,
                     billing_gen_date DATETIME,
                     billing_paid_date DATETIME,
                     appointment_id VARCHAR(255),
                     PRIMARY KEY(billing_id)
                    );

ALTER TABLE employee
ADD CONSTRAINT FK_employee_user
FOREIGN KEY(employee_id) REFERENCES user(user_id);

ALTER TABLE employee
ADD CONSTRAINT FK_employee_dept
FOREIGN KEY(department_code) REFERENCES department(department_code);

ALTER TABLE patient
ADD CONSTRAINT FK_patient_user
FOREIGN KEY(patient_id) REFERENCES user(user_id);

ALTER TABLE appointment
ADD CONSTRAINT FK_appoint_patient
FOREIGN KEY(patient_id) REFERENCES patient(patient_id);

ALTER TABLE appointment
ADD CONSTRAINT FK_appoint_employee
FOREIGN KEY(doctor_id) REFERENCES employee(employee_id);

ALTER TABLE patient_medicine
ADD CONSTRAINT FK_pat_med_patient
FOREIGN KEY(patient_id) REFERENCES patient(patient_id);

ALTER TABLE patient_medicine
ADD CONSTRAINT FK_pat_med_med_inventory
FOREIGN KEY(medicine_id) REFERENCES medical_inventory(medicine_id);

ALTER TABLE billing
ADD CONSTRAINT FK_bill_appoint
FOREIGN KEY(appointment_id) REFERENCES appointment(appointment_id);

CREATE USER 
'admin'@'localhost' IDENTIFIED BY 'admin1234',
'doctor'@'localhost' IDENTIFIED BY 'doctor1234',
'receptionist'@'localhost' IDENTIFIED BY 'receptionist1234',
'inventory_manager'@'localhost' IDENTIFIED BY 'inventory_manager1234',
'patient'@'localhost' IDENTIFIED BY 'patient1234';

GRANT ALL PRIVILEGES ON clinic_db.* TO 'admin'@'localhost';

GRANT SELECT ON clinic_db.patient TO 'doctor'@'localhost';
GRANT SELECT ON clinic_db.patient TO 'patient'@'localhost';
GRANT SELECT,UPDATE,INSERT ON clinic_db.patient TO 'receptionist'@'localhost';

GRANT SELECT ON clinic_db.employee TO 'doctor'@'localhost';
GRANT SELECT ON clinic_db.employee TO 'receptionist'@'localhost';
GRANT SELECT ON clinic_db.employee TO 'inventory_manager'@'localhost';

GRANT SELECT,UPDATE ON clinic_db.appointment TO 'doctor'@'localhost';
GRANT SELECT,UPDATE,INSERT,DELETE ON clinic_db.appointment TO 'receptionist'@'localhost';

GRANT SELECT,DELETE,INSERT,UPDATE ON clinic_db.medical_inventory TO 'inventory_manager'@'localhost';

GRANT SELECT,INSERT,UPDATE,DELETE ON clinic_db.patient_medicine TO 'doctor'@'localhost';
GRANT SELECT ON clinic_db.patient_medicine TO 'patient'@'localhost';
GRANT SELECT,UPDATE ON clinic_db.patient_medicine TO 'inventory_manager'@'localhost';

GRANT SELECT ON clinic_db.billing TO 'patient'@'localhost';
GRANT SELECT,UPDATE ON clinic_db.billing TO 'receptionist'@'localhost';

FLUSH PRIVILEGES;
COMMIT;