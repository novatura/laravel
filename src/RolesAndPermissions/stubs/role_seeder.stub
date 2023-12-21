<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Role;
use App\Models\Permission;

use Illuminate\Database\QueryException;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //This system will create both roles and permissions and attach them all from the rolesData.
        //Start with the name of the role and all the names of the permissions associated with the role after. 
        //If you need to update the roles then update the array and run again.
        //This array allows you to:
        //  Create Roles
        //  Create Permissions
        //  Update what permissions each role has
        //This array does not allow you to:
        //  Delete Roles
        //  Delete Permissions completely, only remove them from a role
        //  Update the names of existing roles or permissions

        $rolesData = [
            'user' => [],
        ];
        
        // Create roles
        foreach ($rolesData as $roleName => $rolePermissions) {
            try {
                $role = Role::create(['name' => $roleName]);
            } catch (QueryException $e) {
                $role = self::handleRoleCreationException($e, $roleName);
            }
        
            // Attach permissions to role
            foreach ($rolePermissions as $permName) {
                try {
                    $permission = self::createOrRetrievePermission($permName);
                    $role->permissions()->attach($permission->id);
                } catch (\Exception $e) {
                    echo 'Error Attaching ' . $permName . ' to ' . $roleName . "\n";
                }
            }
        }

    }

    public static function handleRoleCreationException(QueryException $e, $roleName)
    {
        if ($e->getCode() == 23000) {
            echo $roleName . " Already Exists, finding {$roleName} and detaching all current permissions ... \n";
            $role = Role::where('name', $roleName)->first();
    
            if (!$role) {
                dd("$roleName Not Found");
            }
    
            $role->permissions()->detach();
            return $role;
        } else {
            dd($e);
        }
    }

    public static function createOrRetrievePermission($permName)
    {
        try {
            return Permission::create(['name' => $permName]);
        } catch (QueryException $e) {
            if ($e->getCode() == 23000) {
                echo 'Permission Already Exists: ' . $permName . "\n";
                $permission = Permission::where('name', $permName)->first();
    
                if (!$permission) {
                    echo 'Permission Not Found: ' . $permName . "\n";
                    throw new \Exception("Permission Not Found: $permName");
                }

                echo 'Attaching: ' . $permName . "\n";
    
                return $permission;
            } else {
                echo 'Database Error with ' . $permName . ': ' . $e->getMessage() . "\n";
                throw new \Exception("Database Error with $permName: " . $e->getMessage());
            }
        }
    }
}
