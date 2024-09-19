CREATE DATABASE IF NOT EXISTS post_job_db;

USE post_job_db;

-- Table for job applications
CREATE TABLE job_applications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    post_applied_for VARCHAR(255) NOT NULL,
    post_reference VARCHAR(255) NOT NULL,
    first_name VARCHAR(255) NOT NULL,
    last_name VARCHAR(255) NOT NULL,
    home_address TEXT NOT NULL,
    next_of_kin VARCHAR(255) NOT NULL,
    date_of_birth DATE NOT NULL,
    post_code VARCHAR(20) NOT NULL,
    home_telephone VARCHAR(20),
    work_telephone VARCHAR(20),
    mobile_number VARCHAR(20),
    ring_at_work TINYINT(1) NOT NULL,
    related_to_employee TINYINT(1) NOT NULL,
    related_details TEXT,
    employer VARCHAR(255),
    employment_from DATE,
    employment_to DATE,
    job_title_duties TEXT,
    salary DECIMAL(10, 2),
    voluntary_work VARCHAR(255),
    reference_1 TEXT,
    reference_2 TEXT,
    health_absences TEXT,
    health_allergies TINYINT(1) NOT NULL,
    health_conditions TINYINT(1) NOT NULL,
    health_mental TINYINT(1) NOT NULL,
    health_back_problems TINYINT(1) NOT NULL,
    health_stomach TINYINT(1) NOT NULL,
    additional_info TEXT,
    driving_licence TINYINT(1) NOT NULL
);

-- Table for education details linked to job applications
CREATE TABLE education_details (
    id INT AUTO_INCREMENT PRIMARY KEY,
    application_id INT NOT NULL,
    education VARCHAR(255) NOT NULL,
    from_date DATE NOT NULL,
    to_date DATE NOT NULL,
    qualification VARCHAR(255) NOT NULL,
    FOREIGN KEY (application_id) REFERENCES job_applications(id) ON DELETE CASCADE
);