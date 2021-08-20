<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmailChangeRequest;
use App\Http\Requests\PasswordChangeRequest;
use Illuminate\Http\Request;
use App\Profile;
use App\Job;
use App\Notifications\EmployerViewedProfile;
use App\Traits\ProfileUpdateSettings;
use App\User;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
  use ProfileUpdateSettings;
  public function __construct()
  {
    $this->middleware(['seeker', 'verified'])->except('index', 'userAppliedJobs', 'userProfile', 'settings', 'changePassword', 'changeEmail');
    // Artisan::call('storage:link');
  }

  public function users(Request $request)
  {
    $query = $request->get('query');
    $users = Job::where('title', 'like', '%' . $query . '%')
      ->orWhere('position', 'like', '%' . $query . '%')
      ->get();
    return response()->json($users);
  }

  public function index()
  {

    return view('profile.index');
  }

  public function store(Request $request)
  {
    $this->validate($request, [

      'address' => 'required',
      'bio' => 'required|min:20',
      'experience' => 'required|min:20',
      'phone_number' => 'required|min:10|numeric'
    ]);

    $user_id = auth()->user()->id;

    Profile::where('user_id', $user_id)->update([
      'address' => request('address'),
      'experience' => request('experience'),
      'bio' => request('bio'),
      'phone_number' => request('phone_number')
    ]);
    return redirect()->back()->with('message', 'Profile Sucessfully Updated!');
  }

  public function coverletter(Request $request)
  {
    $this->validate($request, [
      'cover_letter' => 'required|mimes:pdf,doc,docx|max:20000'
    ]);
    $user_id = auth()->user()->id;

    $file = $request->file('cover_letter');
    $ext =  $file->getClientOriginalExtension();
    $cover = $file->getClientOriginalName();
    $file->move('uploads/avatar/', $cover);

    Profile::where('user_id', $user_id)->update([
      'cover_letter' => $cover
    ]);
    return redirect()->back()->with('message', 'Cover letter Sucessfully Updated!');
  }

  public function resume(Request $request)
  {
    $this->validate($request, [
      'resume' => 'required|mimes:pdf,doc,docx|max:20000'
    ]);
    $user_id = auth()->user()->id;
    // $resume = $request->file('resume')->store('public/files');
    $file = $request->file('resume');
    $ext =  $file->getClientOriginalExtension();
    // $resume = time().'.'.$ext;
    $resume = $file->getClientOriginalName();
    $file->move('uploads/avatar/', $resume);
    Profile::where('user_id', $user_id)->update([
      'resume' => $resume
    ]);
    return redirect()->back()->with('message', 'Resume Sucessfully Updated!');
  }

  public function avatar(Request $request)
  {
    $this->validate($request, [
      'avatar' => 'required|mimes:png,jpeg,jpg|max:20000'
    ]);
    $user_id = auth()->user()->id;
    if ($request->hasfile('avatar')) {
      $file = $request->file('avatar');
      $ext =  $file->getClientOriginalExtension();
      $filename = time() . '.' . $ext;
      $file->move('uploads/avatar/', $filename);
      Profile::where('user_id', $user_id)->update([
        'avatar' => $filename
      ]);
      return redirect()->back()->with('message', 'Profile picture Sucessfully Updated!');
    }
  }

  public function jobsApplied(User $user)
  {

    return view('user.jobs.applied')->with('jobs', $user->jobs);
  }

  public function userAppliedJobs()
  {
    $user = Auth::user();
    $jobs = Job::where('user_id', $user->id)->get();
    return view('jobs.employer_jobs_user')->with('jobs', $jobs);
  }
  // to view the users profile and send a notification therafter.
  public function userProfile(User $user, Job $job)
  {

    $user->notify(new EmployerViewedProfile($job));
    return view('jobs.employer_jobs_user_profile')
      ->with('user', $user);
  }
  public function settings(User $user)
  {
    $user = $this->profileSettings($user);
    return $user;
  }

  /**
   * @param PasswordChangeRequest $request
   * @return string
   */
  public function changePassword(PasswordChangeRequest $request)
  {
    $user =  $this->changeProfilePassword($request);
    return $user;
  }

  /**
   * @param EmailChangeRequest $request
   * @return string
   */
  public function changeEmail(EmailChangeRequest $request)
  {
    $user = $this->changeProfileEmail($request);
    return $user;
  }
}
