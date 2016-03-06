<?php

namespace App\Http\Controllers;

use Storage;
use \BinCo\Scrapers\ScrapeAddress as LHAddress;

class AddressController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function getAddressesByPostcode($postcode)
    {
        try {
            $LHAddress = new LHAddress($postcode);
            $Addresses = $LHAddress->getAddresses();
            $ViewState = $Addresses['ViewState'];
            unset($Addresses['ViewState']);
            $EventValidation = $Addresses['EventValidation'];
            unset($Addresses['EventValidation']);
            $this->storeASPData($ViewState, $EventValidation);

            return Response()->json(array('data'=>$Addresses), 200);
        } catch(\Exception $e) {
            return Response()->json(array('data'=>$e->getMessage()), 404);
        }
    }

    private function storeASPData($ViewState, $EventValidation)
    {
        $disk = Storage::disk('local');
        $disk->put('ViewState', $ViewState);
        $disk->put('EventValidation', $EventValidation);
    }

    //
}
