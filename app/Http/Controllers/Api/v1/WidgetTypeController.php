<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\WidgetType;
use Illuminate\Http\Request;

class WidgetTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return WidgetType::all()->load('widgets');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\WidgetType  $widgetType
     * @return \Illuminate\Http\Response
     */
    public function show(WidgetType $widgetType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\WidgetType  $widgetType
     * @return \Illuminate\Http\Response
     */
    public function edit(WidgetType $widgetType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\WidgetType  $widgetType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, WidgetType $widgetType)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\WidgetType  $widgetType
     * @return \Illuminate\Http\Response
     */
    public function destroy(WidgetType $widgetType)
    {
        //
    }
}
