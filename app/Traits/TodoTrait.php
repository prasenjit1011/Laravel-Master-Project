<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

trait TodoTrait {

    /**
     * @param Request $request
     * @return $this|false|string
     */
    public function verifyAndUpload(Request $request, $fieldname = 'image', $directory = 'images' ) {

        Log::info('Todo Traits');
        //return 'img.jpg';

        if($request->hasFile( $fieldname ) ) {
            if (!$request->file($fieldname)->isValid()) {
                Log::info('Invalid Image!');//->error()->important();
                return redirect()->back()->withInput();
            }
            return $request->file($fieldname)->store($directory, 'public');
        }
        return null;
    }
}