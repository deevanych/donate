<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use App\Models\User;
use Illuminate\Http\Request;

class DonationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return 323;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
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
        } catch (\Exception $e) {

            return view('donations.error');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Donation  $donate
     * @return \Illuminate\Http\Response
     */
    public function show(Donation $donate)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Donation  $donate
     * @return \Illuminate\Http\Response
     */
    public function edit(Donation $donate)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Donation  $donate
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Donation $donate)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Donation  $donate
     * @return \Illuminate\Http\Response
     */
    public function destroy(Donation $donate)
    {
        //
    }
}
