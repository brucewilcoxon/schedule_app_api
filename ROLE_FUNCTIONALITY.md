# User Role Functionality

This document describes the role functionality that has been added to the user system.

## Overview

The system now supports two user roles:
- **Manager**: Users with elevated permissions
- **Worker**: Standard users with basic permissions

## Database Changes

### New Migration
A new migration has been created to add the `role` field to the `users` table:
- Field: `role`
- Type: `enum('manager', 'worker')`
- Default: `worker`
- Position: After the `email` field

### Running the Migration
```bash
php artisan migrate
```

## Model Updates

### User Model
The `User` model has been updated with:
- `role` field added to `$fillable` array
- New methods for role checking:
  - `isManager()`: Returns true if user is a manager
  - `isWorker()`: Returns true if user is a worker
  - `hasRole(string $role)`: Returns true if user has the specified role
  - `getAvailableRoles()`: Returns array of available roles

## API Updates

### User Creation/Update
The role field is now required when creating or updating users:
- **POST** `/api/users` - Create user with role
- **PUT** `/api/users/{id}` - Update user with role

### Role Validation
- Role must be either `manager` or `worker`
- Role field is required
- Invalid roles will return 422 validation error

### New Endpoint
- **GET** `/api/roles` - Returns available roles (no authentication required)

## Middleware

### CheckRole Middleware
A new middleware has been created for role-based authorization:
```php
Route::middleware(['auth:sanctum', 'role:manager'])->group(function () {
    // Routes that require manager role
});
```

### Usage Examples
```php
// Require manager role
Route::middleware(['auth:sanctum', 'role:manager'])->get('/admin', function () {
    // Only managers can access
});

// Require worker role
Route::middleware(['auth:sanctum', 'role:worker'])->get('/worker', function () {
    // Only workers can access
});
```

## Testing

### Running Tests
```bash
php artisan test --filter=UserRoleTest
```

### Test Coverage
The tests cover:
- User creation with manager role
- User creation with worker role
- Validation of invalid roles
- Role checking methods
- Available roles endpoint

## Seeding

### UserRoleSeeder
A seeder has been created with sample users:
- **Manager**: `manager@example.com` / `password123`
- **Worker**: `worker@example.com` / `password123`

### Running Seeder
```bash
php artisan db:seed --class=UserRoleSeeder
```

## Frontend Integration

### Role Field in Forms
When creating or updating users, include the role field:
```json
{
  "email": "user@example.com",
  "role": "manager",
  "password": "password123",
  "name": "User Name",
  "gender": "male",
  "age": "30",
  "introduction": "User introduction"
}
```

### Role Display
The role field is now included in user responses:
```json
{
  "data": {
    "id": 1,
    "email": "user@example.com",
    "role": "manager",
    "user_profile": { ... }
  }
}
```

## Security Considerations

1. **Role Validation**: All role inputs are validated against allowed values
2. **Authorization**: Use the `CheckRole` middleware for role-based access control
3. **Default Role**: New users default to `worker` role for security
4. **Role Immutability**: Consider if roles should be changeable by users themselves

## Future Enhancements

Potential improvements for the role system:
1. **Permission System**: Add granular permissions for each role
2. **Role Hierarchy**: Implement role inheritance
3. **Audit Logging**: Track role changes
4. **Role-based UI**: Different interfaces for different roles
5. **Bulk Role Updates**: Admin interface for managing multiple users' roles 