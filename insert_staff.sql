-- Update the existing staff user with email rodeliza@gmail.com to set password to Pass!123
-- Note: Password is hashed using Laravel's bcrypt

UPDATE `users` SET `password` = '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi' WHERE `id` = 5;

INSERT INTO `staff` (`staff_id`, `user_id`, `first_name`, `middle_name`, `last_name`, `sex`, `birth_date`, `position`, `contact_number`, `address`, `created_at`) VALUES
(3, 5, 'Rodeliza', 'M', 'La Rosa', 'Female', '1990-05-15', 'Health Worker', '09917940262', 'Osmeña St., Purok Burbos', '2025-11-17 06:58:00');
