<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class UserSettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Collection
     */
    public function index(): Collection
    {
        //
        return Auth::user()->allSettings();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
        try {
            Auth::user()->setSettings($request->all());

            return [
                'status' => 'success',
                'message' => 'Настройки сохранены',
                'settings' => Auth::user()->allSettings(),
            ];
        } catch (Exception $e) {

            return [
                'status' => 'error',
                'message' => $e->getMessage(),
            ];
        }
    }
}
