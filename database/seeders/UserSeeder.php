<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;
use App\Repositories\RoleRepository;
use App\Repositories\PermissionRepository;
use App\Repositories\UserRepository;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Permission\Guard;

class UserSeeder extends Seeder
{
    /** @var  PermissionRepository */
    private $permissionRepository;
    /** @var  RoleRepository */
    private $roleRepository;
    /** @var  UserRepository */
    private $userRepository;

    public function __construct(RoleRepository $roleRepo, PermissionRepository $permissionRepo, UserRepository $userRepo)
    {
        $this->roleRepository = $roleRepo;
        $this->permissionRepository = $permissionRepo;
        $this->userRepository = $userRepo;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Artisan::call('config:clear');
        // load permission from router name
        $exitCode = Artisan::call('router:permission');

        // Supper Admin
        $roleSupperAdmin = $this->roleRepository->create([
            'name' =>    Role::SUPPER_ADMIN,
            'title' => 'Supper Admin',
            'guard_name' => 'api'
        ]);

        $userSupperAdmin = $this->userRepository->create([
            'name' => 'Administrator',
            'email' => 'admin@hau.dev',
            'password' => '123@123',
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
        ]);
        $userSupperAdmin->assignRole($roleSupperAdmin);

        // Guest
        $roleGuest = $this->roleRepository->create([
            'name' =>    Role::GUEST,
            'title' => 'Guest',
            'guard_name' => 'api'
        ]);
        $userGuest = $this->userRepository->create([
            'name' => 'Guest',
            'email' => 'guest@hau.dev',
            'password' => '123@123',
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
        ]);
        $userGuest->assignRole($roleGuest);
        // Leader
        $roleLeader = $this->roleRepository->create([
            'name' =>    'leader',
            'title' => 'Leader',
            'guard_name' => 'api'
        ]);
        $usersPermissions = $this->permissionRepository->getListByName('users.%');
        $roleLeader->givePermissionTo($usersPermissions);
        $userLeader = $this->userRepository->create([
            'name' => 'Leader',
            'email' => 'leader@hau.dev',
            'password' => '123@123',
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
        ]);
        $userLeader->assignRole($roleLeader);
    }
}
