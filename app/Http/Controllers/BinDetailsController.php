<?php

namespace App\Http\Controllers;

use Storage;
use \BinCo\Scrapers\ScrapeBinDetails as LHBinDetails;

class BinDetailsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->ViewState = Storage::disk('local')->get('ViewState');
        $this->EventValidation = Storage::disk('local')->get('EventValidation');
    }

    public function getDetails($uprn)
    {
        try {
            $LHBin = new LHBinDetails($uprn, array(
                'ViewState'=>$this->ViewState,
                'EventValidation'=> $this->EventValidation
            ));
            $Details = $LHBin->getDetails();

            return Response()->json(array('data'=>$Details), 200);
        } catch(\Exception $e) {
            return Response()->json(array('data'=>$e->getMessage()), 404);
        }
    }

}
