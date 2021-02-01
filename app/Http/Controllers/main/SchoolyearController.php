<?php

namespace App\Http\Controllers\main;

use App\Http\Controllers\Controller;
use App\School;
use App\Schoolyear;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SchoolyearController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */

  public function __construct()
  {
    // the authenitfication middleware for the app
    $this->middleware(['verified', 'auth', 'checkUserStatus', 'checkUserSchools']);
  }


  public function index($id)
  {
    //
    $school = School::find($id);
    $schoolyear = Schoolyear::where('school_id', $school->id);

    return view('main.schoolsyear.page-schoolyears')->with('schoolyear', $schoolyear);

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
   * @param  \App\Schoolyear  $schoolyear
   * @return \Illuminate\Http\Response
   */
  public function show(Schoolyear $schoolyear)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Schoolyear  $schoolyear
   * @return \Illuminate\Http\Response
   */
  public function edit(Schoolyear $schoolyear)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Schoolyear  $schoolyear
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, Schoolyear $schoolyear)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Schoolyear  $schoolyear
   * @return \Illuminate\Http\Response
   */
  public function destroy(Schoolyear $schoolyear)
  {
    //
  }
}
