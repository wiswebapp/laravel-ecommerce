## Process for Adding new module
Add your new module name in following file
- `$modules` array in *InitController.php*
- php artisan make:controller admin/ModuleController
- php artisan make:model ModuleTable
- in *admin_routes.php* add following line
  - `$routeResource(moduleUrl, moduleController, moduleSuffix);`
- Than you need to add permission in permissions table. you can do manually or migrate/refresh the table 
```
INSERT INTO `permissions` (`id`, `name`, `guard_name`) VALUES 
(NULL, 'Create YOUR_MODULE_NAME', 'admin'), 
(NULL, 'View YOUR_MODULE_NAME', 'admin'), 
(NULL, 'Edit YOUR_MODULE_NAME', 'admin'), 
(NULL, 'Delete YOUR_MODULE_NAME', 'admin')
```
- Than assign role to current admin group by Editing Admin Roles *(if face some error truncate the `role_has_permissions` table and perform `php artisan initialize:admin`)*
- Than add your module to admin sidebar in **sidebar.blade.php** file
- Create migration file for your module 
  - *php artisan make:migration ModuleTable*
- After filling appropriate fields in migration file run 
  - *php artisan migrate*
