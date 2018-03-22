<?php

namespace App\Http\Controllers;

use App\Http\Resources\PayPeriodResource;
use App\PayPeriod;
use Illuminate\Http\Request;

class PayPeriodController extends Controller
{
    use Filterable;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return PayPeriodResource::collection($this->filter($request->all(), PayPeriod::class)->paginate());
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
     * @param  \App\PayPeriod  $payPeriod
     * @return \Illuminate\Http\Response
     */
    public function show(PayPeriod $payPeriod)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\PayPeriod  $payPeriod
     * @return \Illuminate\Http\Response
     */
    public function edit(PayPeriod $payPeriod)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PayPeriod  $payPeriod
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PayPeriod $payPeriod)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PayPeriod  $payPeriod
     * @return \Illuminate\Http\Response
     */
    public function destroy(PayPeriod $payPeriod)
    {
        //
    }
}
