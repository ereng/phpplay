<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });

        // Create table for storing roles
        Schema::create('roles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->string('display_name')->nullable();
            $table->string('description')->nullable();
            $table->timestamps();
        });

        // Create table for associating roles to users (Many-to-Many)
        Schema::create('role_user', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('role_id')->unsigned();

            $table->foreign('user_id')->references('id')->on('users')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('role_id')->references('id')->on('roles')
                ->onUpdate('cascade')->onDelete('cascade');
        });

        // Create table for storing permissions
        Schema::create('permissions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->string('display_name')->nullable();
            $table->string('description')->nullable();
            $table->timestamps();
        });

        // Create table for associating permissions to roles (Many-to-Many)
        Schema::create('permission_role', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('permission_id')->unsigned();
            $table->integer('role_id')->unsigned();

            $table->foreign('permission_id')->references('id')->on('permissions')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('role_id')->references('id')->on('roles')
                ->onUpdate('cascade')->onDelete('cascade');
        });

        Eloquent::unguard();

        //Super Admin
        $superUser = \App\User::create([
            'name' => 'Super Admin',
            'email' => 'admin@ihsani.dev',
            'password' =>  bcrypt('password'),
        ]);

        $permissions = [
            // system configurations
            ['name' => 'manage_configurations', 'display_name' => 'Can manage configurations'],

            // user management
            ['name' => 'manage_users', 'display_name' => 'Can manage users'],

            // reporting
            ['name' => 'view_reports', 'display_name' => 'Can view reports'],
        ];

        foreach ($permissions as $permission) {
            \App\Models\Permission::create($permission);
        }

        /* Roles table */
        $superRole = \App\Models\Role::create(['name' => 'Superadmin']);

        \App\Models\Role::create(['name' => 'Web Master']);
        \App\Models\Role::create(['name' => 'Director']);

        $superUser = \App\User::find($superUser->id);
        $permissions = \App\Models\Permission::all();

        //Assign all permissions to role Superadmin
        foreach ($permissions as $permission) {
            $superRole->attachPermission($permission);
        }
        //Assign role Superadmin to user_id=1
        $superUser->attachRole($superRole);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
