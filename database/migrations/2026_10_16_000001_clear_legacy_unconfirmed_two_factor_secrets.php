<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ClearLegacyUnconfirmedTwoFactorSecrets extends Migration
{
    /**
     * Remove legacy plaintext-password values written into Fortify's 2FA field.
     * Confirmed 2FA secrets are preserved when the standard confirmation column exists.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('users') || !Schema::hasColumn('users', 'two_factor_secret')) {
            return;
        }

        $users = DB::table('users')->whereNotNull('two_factor_secret');

        if (Schema::hasColumn('users', 'two_factor_confirmed_at')) {
            $users->whereNull('two_factor_confirmed_at');
        }

        $users->update(['two_factor_secret' => null]);
    }

    /**
     * Secret values cannot be restored after secure deletion.
     *
     * @return void
     */
    public function down()
    {
        // Intentionally irreversible; users can configure two-factor auth again.
    }
}
