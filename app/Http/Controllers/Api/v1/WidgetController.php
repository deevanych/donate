<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Widget;
use App\Services\WidgetData;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class WidgetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
        return Auth::user()->getWidgets();
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
        try {
            $widget = new Widget;
            $widget->__set('user_id', Auth::id());
            $widget->__set('widget_type_id', $request->get('widget_type_id'));
            $widget->__set('title', $request->get('settings')['title']['text']);
            $widget->__set('uuid', Str::orderedUuid());
            $widget->save();

            $widget->setSettings($request->get('settings'));

            return response(['message' => 'Виджет создан', 'widget' => $widget]);
        } catch (Exception $e) {
            return response($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param Widget $widget
     * @return Response
     */
    public function show(Widget $widget)
    {
        //
        return $widget;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Widget $widget
     * @return Response
     */
    public function edit(Widget $widget)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Widget $widget
     * @return Response
     */
    public function update(Request $request, Widget $widget)
    {
        //
        try {
            $settings = $request->only('settings');
            if (isset($settings['settings'])) {
                $widget->setSettings($settings['settings']);
            }
            $request = $request->except(['embed_link', 'settings']);
            $widget->update($request);
            return response(['message' => 'Виджет обновлен', 'widget' => $widget]);
        } catch (Exception $e) {
            return response($e->getMessage())->setStatusCode(500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Widget $widget
     * @return Response
     */
    public function destroy(Widget $widget)
    {
        //
        try {
            $widget->delete();
            return $widget;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Return data from widget settings
     *
     * @param Widget $widget
     * @return Collection
     */
    public function getData(Widget $widget)
    {
        //
        $period = explode('_', $widget->settings('period'));
        return WidgetData::getData($period[0], $period[1], $widget->settings('elements_count'), $widget->settings('stats_type'), $widget->user->id);
    }
}
