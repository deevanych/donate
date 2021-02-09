<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class DonationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        //
        return $request;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(Request $request, $user)
    {
        //
//        return $request->query('sort');
//        todo
        $user = User::whereName($user)->first();
        return view('donations.create', compact('user'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request, $user)
    {
        //

        try {
            $receiver = User::whereName($user)->first();
            $donation = new Donation($request->all());
            $donation->user_to = $receiver->id;
            $donation->user_from = 2;

            $donation->save();

            return view('donations.success');
        } catch (Exception $e) {

            return view('donations.error');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param Donation $donate
     * @return Response
     */
    public function show(Donation $donate)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Donation $donate
     * @return Response
     */
    public function edit(Donation $donate)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Donation $donate
     * @return Response
     */
    public function update(Request $request, Donation $donate)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Donation $donate
     * @return Response
     */
    public function destroy(Donation $donate)
    {
        //
    }
}
