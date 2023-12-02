<?php

namespace App\Observers;

use Illuminate\Support\Facades\Log;

class TodoStatusChanged
{
    public function updated($model){
        if($model->wasChanged('status')){
            Log::ALERT('From Observer : Status Changed');
        }
    }
}
