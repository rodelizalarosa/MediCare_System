# TODO: Integrate auth pages with database

- [x] Update app/Models/User.php: Remove the table override to use default 'users' table
- [x] Update app/Models/Patient.php: Remove the table override to use default 'patients' table
- [x] Update app/Http/Controllers/Auth/RegisterController.php: Change validation rule from 'unique:tbl_users,email' to 'unique:users,email'
- [x] Test the auth integration by running migrations and testing register/login functionality
