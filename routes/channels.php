<?php

use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('company.{companyId}', function ($user, $companyId) {
    return (int) $user->company_id === 0
        || (int) $user->company_id === (int) $companyId;
});


// Broadcast::channel('users.{id}', function ($user, $id) {
//     return (int) $user->id === (int) $id;
// });
