<?php

use Illuminate\Support\Facades\DB;

class TestController extends Controller
{
    public function checkDbConnection()
    {
        try {
            DB::connection()->getPdo();
            return "Connected to the database successfully!";
        } catch (\Exception $e) {
            return "Could not connect to the database. Please check your configuration. Error: " . $e->getMessage();
        }
    }
}
