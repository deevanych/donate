<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\WidgetType;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class WidgetTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
        return WidgetType::all()->load('widgets')->groupBy('slug');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
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
    }

    /**
     * Display the specified resource.
     *
     * @param WidgetType $widgetType
     * @return Response
     */
    public function show(WidgetType $widgetType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param WidgetType $widgetType
     * @return Response
     */
    public function edit(WidgetType $widgetType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param WidgetType $widgetType
     * @return Response
     */
    public function update(Request $request, WidgetType $widgetType)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param WidgetType $widgetType
     * @return Response
     */
    public function destroy(WidgetType $widgetType)
    {
        //
    }
}
