## Introduction
This project is a Course and Instructor Management System built using Laravel, designed to manage courses, instructors, and student enrollments. The API provides full CRUD (Create, Read, Update, Delete) functionality for courses and instructors, with advanced features including role-based access control, custom query scopes, and enhanced pivot table capabilities. The system adheres to RESTful standards, ensuring accurate HTTP status codes, data validation, and error handling.

## Prerequisites
PHP >= 8.0
Composer
Laravel >= 9.0
MySQL or any other database supported by Laravel
Postman for testing API endpoints
## Setup
1. **Clone the project:**:

git clone https://github.com/SafaaNahhas/ManegmentCourses.git
## Install backend dependencies:
composer install
Create the .env file:

cp .env.example .env
## Modify the .env file to set up your database connection:


DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database
DB_USERNAME=your_username
DB_PASSWORD=your_password
## Generate the application key:


php artisan key:generate
## Run migrations:

php artisan migrate
## Start the local server:


php artisan serve
You can now access the project at http://localhost:8000.

## Project Structure
- `CourseController.php`: Handles API requests related to courses, such as creating, updating, deleting, and retrieving courses.retrieving projects.
- `InstructorController.php`: Handles API requests related to instructors, including CRUD operations and course assignments.
- `StudentController.php`: Manages API requests related to student enrollments, including adding students and assigning them to courses.
- `AuthController.php`: Manages API requests related to user authentication, including registration, login, and token management.
- `CourseService.php`: Contains business logic for managing courses.
- `InstructorService.php`: Contains business logic for managing instructors.
- `StudentService.php`: Contains business logic for managing Student.
- `AuthService.php`: Contains business logic for user authentication, including validating credentials and generating JWT tokens.
- `CourseRequest.php`: A Form Request class for validating data in Course.
- `InstructorRequest.php`: A Form Request class for validating data in Instructor.
- `StudentRequest.php`: A Form Request class for validating data in Student.

## Advanced Features
1. Filtering

Courses and instructors can be filtered using query parameters.

2. Course Management:

Users can create, view, update, and delete courses.
Each course has attributes like title, description, and start date.
Managers can assign instructors to courses.
3. Instructor  Management:

Users can create, view, update, and delete instructors.
Each instructor includes details like name, experience, and specialty.
Managers can assign multiple courses to instructors.
4. Student Management:

Users can add new students and enroll them in multiple courses.
View all students enrolled in a specific course.
View all courses a specific instructor is teaching.
Retrieve all students associated with an instructor using the hasManyThrough relationship.
5. Role-Based Access Control (RBAC):
Admins have full permissions for all courses, instructors, and student enrollments.

6. JWT Authentication:

JWT (JSON Web Tokens) is used for securing endpoints.
Only authenticated users can access and perform operations on courses, instructors, and student enrollments

8. Course  Assignment:

Managers can assign multiple instructors to courses.
Instructors can manage the courses they are assigned to.
9. Date Handling:

Course start dates are managed using Carbon, with custom formatting (e.g., d-m-Y).
Courses can be marked as "upcoming" or "ongoing" based on the start date.
10. Course Scopes:

Custom query scopes are provided to filter courses by start date and specialty.
11. Advanced Pivot Table Management:
The course_instructor pivot table includes additional fields like role and contribution_hours.
The course_student pivot table manages student enrollments with timestamps.
12. Using Eloquent Relationships:

1. hasManyThrough: Retrieve tasks associated with projects through user relationships.
whereRelation: Filter tasks based on status and priority using custom conditions.
2. latestOfMany and oldestOfMany: Retrieve the latest or oldest tasks based on dates.
3. ofMany: Retrieve the highest priority task with a specific condition.
Seeders
4. whereRelation: Filter courses based on start date and instructor specialties..
## Postman Collection
A Postman collection is provided to test the API endpoints. Import it into your Postman application to run the requests.

## Postman
https://documenter.getpostman.com/view/34501481/2sAXqy3zFz
