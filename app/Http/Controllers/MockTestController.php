<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMockTestRequest;
use App\Http\Requests\UpdateMockTestRequest;
use App\Models\MockTest;

class MockTestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return "success";
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreMockTestRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMockTestRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MockTest  $mockTest
     * @return \Illuminate\Http\Response
     */
    public function show(MockTest $mockTest)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateMockTestRequest  $request
     * @param  \App\Models\MockTest  $mockTest
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMockTestRequest $request, MockTest $mockTest)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MockTest  $mockTest
     * @return \Illuminate\Http\Response
     */
    public function destroy(MockTest $mockTest)
    {
        //
    }
}
