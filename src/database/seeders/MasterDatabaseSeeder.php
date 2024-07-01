<?php

namespace Database\Seeders;

use App\Models\Shop;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class MasterDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //ロール作成
        $adminRole = Role::create(['name' => 'admin']);
        $managerRole = Role::create(['name' => 'manager']);

        //権限作成
        $sendEmail = Permission::create(['name' => 'send email']);
        $manageManager = Permission::create(['name'=> 'manage manager']);
        $editShop = Permission::create(['name' => 'edit shop']);
        $createShop = Permission::create(['name' => 'create shop']);
        $checkReservations = Permission::create(['name' => 'check reservations']);

        //adminRoleに管理者がもつ権限を付与
        $adminRole->givePermissionTo($sendEmail, $manageManager);

        //managerRoleに店舗責任者がもつ権限を付与
        $managerRole->givePermissionTo($editShop, $createShop, $checkReservations);

        //管理者登録
        $administer = User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('admin-pass'),
            'email_verified_at' => now(),
        ]);

        //管理者にadminRoleを割り当て
        $administer->assignRole($adminRole);

        //店舗責任者ダミーデータ登録
        $shopManager1 = User::create([
            'name' => 'Manager1',
            'email' => 'manager1@example.com',
            'password' => bcrypt('manager-pass'),
            'email_verified_at' => now(),
        ]);

        //店舗責任者にmanagerRoleを割り当て
        $shopManager1->assignRole($managerRole);

        //shopManager1をShopsTableの店舗適任者に設定
        $shopManager1->shops()->attach(Shop::where('id', 1)->first()->id);

        //一般ユーザーダミーデータ登録
        User::factory()->count(48)->create();

    }
}
