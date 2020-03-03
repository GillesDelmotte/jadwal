<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreModal;
use App\Modal;
use App\Session;
use App\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDF;
use Illuminate\Support\Facades\Session as PHPSession;


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
    public function store(StoreModal $request)
    {
        $session = $request->session()->get('session');

        $modal = new Modal();
        $modal->session_id = $session->id;
        $modal->teacher_id = $request->teacher_id;
        $modal->name = $request->name;
        $modal->type = $request->examType;
        $modal->group = $request->group;
        $modal->group_infos = $request->groupInfos;
        $modal->more_infos = $request->moreInfos;
        $modal->local = $request->local;
        $modal->duration = $request->duration;
        $modal->supervisor = $request->supervisor;
        $modal->save = $request->save ? 1 : 0;

        $modal->save();

        PHPSession::flash('success', 'votre modalité a bien été enregisté');

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
    public function edit(Modal $modal, $token)
    {
        $participations = DB::table('session_teacher')->where('token', $token)->get();
        $teacher = Teacher::findOrFail($participations[0]->teacher_id);

        return view('sessions.editModal', ['modal' => $modal, 'token' => $token]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Modal  $modal
     * @return \Illuminate\Http\Response
     */
    public function update(StoreModal $request, Modal $modal)
    {
        $modal->name = $request->name;
        $modal->type = $request->examType;
        $modal->group = $request->group;
        $modal->group_infos = $request->groupInfos;
        $modal->more_infos = $request->moreInfos;
        $modal->local = $request->local;
        $modal->duration = $request->duration;
        $modal->supervisor = $request->supervisor;

        $modal->save();

        PHPSession::flash('success', 'votre modalité a bien été modifiée');

        return redirect('/sessions/fillModals/' . $request->token);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Modal  $modal
     * @return \Illuminate\Http\Response
     */
    public function destroy(Modal $modal)
    {
       $modal->delete();
        return Back();
    }

    public function downloadPDF(Teacher $teacher)
    {
        $teacher->load('modalsForTeacher');
        $session = Session::findOrFail($teacher->modals[0]->session_id);

        $pdf = PDF::loadView('sessions.pdf', ['teacher' => $teacher, 'session' => $session])->setPaper('a4', 'landscape');;

        $fileName =  str_replace(' ', '-', $session->title) . '_' . str_replace(' ', '-', $teacher->name);

        $fileName;

        return $pdf->stream($fileName . '' . '.pdf');
    }

    public function sendModals(Teacher $teacher, Session $session, Request $request ){
        $session = $request->session()->get('session');

        $session->load('teachers');

        foreach($session->teachers as $teacherSession){
            if($teacherSession->id == $teacher->id ){
                $teacherSession->pivot->send = true;
                $teacherSession->pivot->save();
            }
        }

        $modals = Modal::where('teacher_id', $teacher->id)->where('session_id', $session->id)->get();

        foreach($modals as $modal){
            $modal->send = 1;
            $modal->save();
        }
        return back();
    }
}
