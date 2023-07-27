<?php

namespace App\Http\Controllers;

class LocalizationController extends Controller
{
    public function switch($language = '')
    {
        try {
            request()->session()->put('locale', $language);

            return $this->respond('Success change language');
        } catch (\Exception $e) {
            return $this->exceptionError($e->getMessage());
        }
    }
}
