<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Donation;
use App\Models\User;
use App\Services\Yandex;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;

class DonationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Collection
     */
    public function index(Request $request)
    {
        //

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @param User $user
     * @return void
     */
    public function store(Request $request, User $user)
    {
        //
        try {
            $donation = new Donation($request->get('donation'));
            $donation->user_to = $user->id;

//            todo
            if (empty($donation->donation_sender)) {
                $donation->donation_sender = 'Аноним';
            }
            if (!empty($donation->text)) {
                $donation->speech_uri = Yandex::TTS($donation);
            }

            $donation->save();

            return [
                'status' => 'success',
                'message' => 'Донат отправлен',
                'donation' => $donation
            ];
        } catch (Exception $e) {
            return [
                'status' => 'error',
                'message' => $e->getMessage(),
                'code' => $e->getCode()
            ];
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
