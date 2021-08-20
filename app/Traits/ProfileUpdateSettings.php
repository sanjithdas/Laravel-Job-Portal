<?php
namespace App\Traits;
use App\Http\Requests\EmailChangeRequest;
use App\Http\Requests\PasswordChangeRequest;
use App\Job;
use App\Notifications\EmployerViewedProfile;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

trait ProfileUpdateSettings{

    public function profileSettings(User $user){
        $user = User::findOrFail($user->id);
        return view('user.settings')
            ->with('user',$user);
    }
    /**
     * @param PasswordChangeRequest $request
     * @return string
     */
    public function changeProfilePassword(PasswordChangeRequest $request){
        $user = User::find(Auth::id());

        $currentpass =  trim($request->currentpass);
        $newpassword = trim($request->newpassword);
        $confirmpass = trim($request->confirmpass);

        if (!Hash::check($currentpass, $user->password)){
           // dd('invalid');
            return response()->json(['errors' =>
                ['current' =>['Current password does not match']]],422);
        }
        $user->password = Hash::make($newpassword);
        $user->save();
        return $user;
        // return  $currentpass. "-" . $newpassword. "-". $confirmpass;
    }

    /**
     * @param EmailChangeRequest $request
     * @return string
     */
    public function changeProfileEmail(EmailChangeRequest $request){
        $user = User::find(Auth::id());

        $currentemail =  trim($request->currentemail);
        $email = trim($request->email);
        $password = trim($request->password);

        if (!Hash::check($password, $user->password)){

            return response()->json(['errors' =>
                ['cpassword' =>['Current password does not match']]],422);
        }
        if ($user->email===$currentemail){
            $user->email = $email;
            $user->save();
        }
        else{
            return response()->json(['errors' =>
                ['current' =>['Current email does not match']]],422);
        }

        return $user;
        // return response()->json($user);
    }



}
