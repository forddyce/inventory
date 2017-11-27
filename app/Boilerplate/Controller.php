<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\SampleRepository;

class SampleController extends Controller
{
    /**
     * The SampleRepository instance.
     *
     * @var \App\Repositories\SampleRepository
     */
    protected $SampleRepository;

    /**
     * Create a new SampleController instance.
     *
     * @param \App\Repositories\SampleRepository $SampleRepository
     * @return void
     */
    public function __construct(SampleRepository $SampleRepository) {
        $this->SampleRepository = $SampleRepository;
        // $this->middleware('');
    }
}
