<?php

use Illuminate\Http\Request;
use App\Notifications\Feedback;

Route::post('feedback', function (Request $request) {
    Notification::route('mail', config('feedback.email'))
        ->notify(new Feedback($request->input()));
});
