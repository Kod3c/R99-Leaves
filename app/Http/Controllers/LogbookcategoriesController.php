<?php

namespace App\Http\Controllers;

use App\logbookcategories;
use Illuminate\Http\Request;

class LogbookcategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('logbookcategories/index');
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
     * @param  \App\logbookcategories  $logbookcategories
     * @return \Illuminate\Http\Response
     */
    public function show(logbookcategories $logbookcategories)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\logbookcategories  $logbookcategories
     * @return \Illuminate\Http\Response
     */
    public function edit(logbookcategories $logbookcategories)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\logbookcategories  $logbookcategories
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, logbookcategories $logbookcategories)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\logbookcategories  $logbookcategories
     * @return \Illuminate\Http\Response
     */
    public function destroy(logbookcategories $logbookcategories)
    {
        //
    }
}
