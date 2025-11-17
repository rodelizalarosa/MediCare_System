# TODO: Change Admin Sidebar Color to Gold Like Button

## Steps to Complete:
- [x] Change .admin-sidebar background from #FFD700 to #F4A700
- [x] Change .admin-sidebar .sidebar-link color from #000000 to #1B4D89
- [x] Change .admin-sidebar .sidebar-link i color from #000000 to #1B4D89
- [x] Change .admin-sidebar .logo-text color from #000000 to #1B4D89
- [x] Change .menu-title color from #000000 to #1B4D89 (add .admin-sidebar prefix for specificity)
- [x] Change .welcome-text color from #000000 to #1B4D89 (add .admin-sidebar prefix for specificity)
- [x] Change .separator background from #000000 to #1B4D89 (add .admin-sidebar prefix for specificity)

## Additional Tasks Completed:
- [x] Fixed route error in StaffController (changed redirect to admin.staff)
- [x] Added updated_at columns to staff, doctors, midwives tables via migrations
- [x] Created Admin ProfileController and view (adapted from patient profile)
- [x] Added admin profile routes
- [x] Updated User model with relationships to staff, doctor, midwife
- [x] Updated admin sidebar to link to profile page
- [x] Tested staff, doctor, midwife insertions (successful)
