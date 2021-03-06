<?php

namespace App\Http\Controllers\main;

use App\Http\Controllers\Controller;
use App\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\DB;

class UsersController extends Controller
{

  public function __construct()
  {
    // the authenitfication middleware for the app
    $this->middleware(['verified', 'auth', 'checkUserStatus', 'checkUserSchools', 'scolarSystem']);
  }

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {

    //code for root user or superuser
    $superuser = User::find(Auth::id());
    //code for root user or superuser

    //code for settings implementation
    $setting = Setting::where('user_id', Auth::id())->first();

    $user = User::all()->sortByDesc('created_at');

    return view('main.users.page-users-list')->with(
      [
        'superuser' => $superuser,
        'user' => $user,
        'setting' => $setting
      ]
    );
  }

  /* Display store form */
  public function storeDisplay()
  {


    //code for root user or superuser
    $superuser = User::find(Auth::id());
    //code for root user or superuser


    return view('main.users.page-users-add')->with(
      [
        'superuser' => $superuser
      ]
    );
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
    $request->validate([
      'familyname' => 'required',
      'givenname' => 'required',
      'familyname' => 'required',
      'email' => 'required',
      'password' => 'required',
      'gender' => 'required',
      'country' => 'required',
      'dialcode' => 'required',
      'phone' => 'required',
      'job' => 'required',
      'address' => 'required',
    ]);

    if (User::where('email', $request->email)->count() == 0) {


      if ($request->hasFile('photo')) {
        //code to store an resize the image
        $files = $request->file('photo');

        $picture = Storage::putFile('public/users', $files);
        $resize = Image::make($files)->resize(200, 200)->save('storage/users' . basename($picture), 80);
        $path = Storage::url($picture);
      }



      $user = new User;
      $current = User::find(Auth::id());
      if ($request->hasFile('photo')) {
        $user->photo = $path;
      }
      $user->familyname = $request->familyname;
      $user->givenname = $request->givenname;
      $user->email = $request->email;
      $user->password = bcrypt($request->password);
      $user->gender = $request->gender;
      $user->birthdate = $request->birthdate;
      $user->country = $request->country;
      $user->dialcode = $request->dialcode;
      $user->phone = $request->phone;
      $user->address = $request->address;
      $user->job = $request->job;
      $user->created_user = $current->id;
      $user->updated_user = $current->id;
      if (isset($request->root)) {
        $user->root = $request->root;
      }
      if (isset($request->status)) {
        $user->status = $request->status;
      }

      if ($current->root == false) {
        $user->school_id = $current->school_id;
      }


      $user->save();

      $setting = new Setting;
      $setting->theme = "semi-dark";
      $setting->language = 1;
      $setting->user_id = User::where('email', $request->email)->value('id');
      $setting->created_user = $current->id;
      $setting->updated_user = $current->id;

      $setting->save();


      session()->flash('user_add', 'user have been added successfully');


      return redirect()->route('users-list');
    } else {
      session()->flash('emailroradd', 1);
      return redirect()->route('users-list');
    }
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {


    //
    $superuser = User::find(Auth::id());
    $user = User::find($id);
    $setting = Setting::where('user_id', Auth::id())->first();


    // code to calculate age of hte users
    if ($user != NULL) {
      $age = floor((time() - strtotime($user->birthdate)) / 31556926);


      if ($setting->language == 1) {
        if (substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2) == ('fr' || 'en')) {
          $countries = DB::table('countries')->where(['code' => $user->country, 'language' => 1])->value('label');
        }
      } else {
        $countries = DB::table('countries')->where(['code' => $user->country, 'language' => 2])->value('label');
      }




      $write_user = User::find($user->created_user);
      $edit_user = User::find($user->updated_user);
    }


    if ($user != NULL && ($user->school_id == $superuser->school_id || $superuser->root == true)) {

      return view('main.users.page-users-view')->with([
        'user' => $user,
        'country' => $countries,
        'superuser' => $superuser,
        'age' => $age,
        'writeby' => $write_user,
        'editby' => $edit_user,
        'setting' => $setting
      ]);
    } else if ($user != NULL && ($user->school_id != $superuser->school_id && $superuser->root == false)) {
      return view('errors.not-authorized');
    } else {
      return view('errors.404');
    }
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit($id, Request $request)
  {


    //
    $superuser = User::find(Auth::id());
    $user = User::find($id);
    $setting = Setting::where('user_id', Auth::id())->first();

    if ($user != NULL && ($user->school_id == $superuser->school_id || $superuser->root == true)) {

      return view('main.users.page-users-edit')->with([
        'user' => $user,
        'superuser' => $superuser,
        'setting' => $setting
      ]);
    } else if ($user != NULL && ($user->school_id != $superuser->school_id && $superuser->root == false)) {
      return view('errors.not-authorized');
    } else {
      return view('errors.404');
    }
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id)
  {
    $request->validate([
      'familyname' => 'required',
      'givenname' => 'required',
      'familyname' => 'required',
      'email' => 'required',
      'password' => 'required',
      'gender' => 'required',
      'country' => 'required',
      'dialcode' => 'required',
      'phone' => 'required',
      'job' => 'required',
      'address' => 'required',
    ]);

    $user = User::find($id);
    $current = User::find(Auth::id());


    if ($request->hasFile('photo')) {
      //code to store an resize the image
      $files = $request->file('photo');

      $picture = Storage::putFile('public/users', $files);
      $resize = Image::make($files)->resize(200, 200)->save('storage/userss' . basename($picture), 80);
      $path = Storage::url($picture);
    }


    $user = User::find($id);

    if ($request->hasFile('photo')) {
      $user->photo = $path;
    }
    $user->familyname = $request->familyname;
    $user->givenname = $request->givenname;
    $user->email = $request->email;
    $user->password = bcrypt($request->password);
    $user->gender = $request->gender;
    $user->birthdate = $request->birthdate;
    $user->country = $request->country;
    $user->dialcode = $request->dialcode;
    $user->phone = $request->phone;
    $user->address = $request->address;
    $user->job = $request->job;
    $user->updated_user = $current->id;
    if (isset($request->status)) {
      $user->status = $request->status;
    }

    if ($current->root == false) {
      $user->school_id = $current->school_id;
    }

    $user->save();

    session()->flash('user_edit', 'user have been edited successfully');

    $user_set = User::where('email', '=', $request->email)->value('id');
    if (Setting::where('user_id', '=', $user_set)->count() == 0) {

      $setting = new Setting;
      $setting->theme = "semi-dark";
      $setting->language = 1;
      $setting->user_id = User::where('email', $request->email)->value('id');
      $setting->created_user = $current->id;
      $setting->updated_user = $current->id;
      $setting->save();
    }

    return redirect()->route('users-list');
  }


  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {

    $user = User::find($id);

    // code to archive deleted users
    $userCopy = $user;
    $current = User::find(Auth::id());




    if ($user != NULL && ($user->school_id == $current->school_id || $current->root == true)) {
      $userCopy->deleted_user = $current->id;
      $userCopy->save();
      $user->delete();

      session()->flash('user_delete', 'user have been deleted successfully');

      return redirect()->route('users-list');
    } else if ($user != NULL && ($user->school_id != $current->school_id && $current->root == false)) {
      return view('errors.not-authorized');
    } else {
      return view('errors.404');
    }
  }
}
