<?php

namespace App\Console\Commands;

use App\Models\Subscription;
use App\Models\User;
use Illuminate\Console\Command;
use Spatie\Permission\Models\Role;

class AssignUserRoleToExpiredSubscriptions extends Command
{
    protected $signature = 'subscriptions:check-expiry';

    protected $description = 'Assign "user" role to users with expired subscriptions and remove other roles.';

    public function handle()
    {
        $users = User::all();

        foreach ($users as $user) {
            $latestSubscription = $user->subscriptions()->latest()->first();

            if (!$latestSubscription) {
                // $this->info('No subscriptions found for user with ID: ' . $user->id);
                continue;
            }

            // Compare the subscription's expiration date with today
            if ($latestSubscription->expires_at < now()) {

                // Check if the user has the "user" role and remove it
                if ($user->hasRole('user')) {
                    $user->removeRole('user');
                    $this->info('Removed "user" role from user with ID: ' . $user->id);
                }
                
                // Assign the "new_user" role to the user
                $userRole = Role::firstOrCreate(['name' => 'new_user']);
                $user->assignRole($userRole);

                $this->info('Assigned "user" role to user with ID: ' . $user->id);
            }
        }
    }
}
