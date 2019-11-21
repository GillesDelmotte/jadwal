<?php

namespace App\Http\Controllers;

use App\Modal;
use Illuminate\Http\Request;

class ModalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        //return $request;
        $session = $request->session()->get('session');

        $modal = new Modal();
        $modal->session_id = $session->id;
        $modal->teacher_id = $request->teacher_id;
        $modal->name = $request->name;
        $modal->type = $request->examType;
        $modal->group = $request->group;
        $modal->group_infos = $request->groupInfos;
        $modal->local = $request->local;
        $modal->supervisor = $request->supervisor;

        $modal->save();

        return Back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Modal  $modal
     * @return \Illuminate\Http\Response
     */
    public function show(Modal $modal)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Modal  $modal
     * @return \Illuminate\Http\Response
     */
    public function edit(Modal $modal)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Modal  $modal
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Modal $modal)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Modal  $modal
     * @return \Illuminate\Http\Response
     */
    public function destroy(Modal $modal)
    {
        //
    }
}
