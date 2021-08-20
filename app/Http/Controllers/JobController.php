<?php

namespace App\Http\Controllers;

use App\Recommendation;
use App\Traits\JobRecommendation;
use Illuminate\Http\Request;
use App\Job;
use App\Company;
use App\Http\Requests\JobPostRequest;
use Auth;
use App\User;
use App\Category;
use App\Post;
use App\Testimonial;
class JobController extends Controller
{
    use JobRecommendation;
    public function __construct(){
        $this->middleware(['employer','verified'],['except'=>array('index','show','apply','allJobs','searchJobs','category','searchJobsByVue','getRecommendedJobs')]);
    }
    
    
    public function index(){
    	$jobs = Job::latest()->limit(10)->where('status',1)->get();
        $categories = Category::with('jobs')->get();
        $posts = Post::where('status',1)->get();
        $testimonial = Testimonial::orderBy('id','DESC')->first();
        
        $companies = Company::get()->random(12);
       
    	return view('welcome',compact('jobs','companies','categories','posts','testimonial'));
    }
    public function show($id,Job $job){

        $jobRecommendations = $this->jobRecommendations($job);
        // echo "<pre>";
        // print_r($jobRecommendations);
        // echo"</pre>";
        return view('jobs.show',compact('job','jobRecommendations'));
    }

    public function company(){
    	return view('company.index');
    }

    public function myJobs(){
        $jobs = Job::where('user_id',auth()->user()->id)->get();
        return view('jobs.myjob',compact('jobs'));
    }

    public function edit($id){
        $job = Job::findOrFail($id);
        return view('jobs.edit',compact('job'));
    }

    public function update(JobPostRequest $request,$id){
        $job = Job::findOrFail($id);
        $job->update($request->all());
        return redirect()->back()->with('message','Job  Sucessfully Updated!');

    }
    public function applicant(){
        $applicants = Job::has('users')->where('user_id',auth()->user()->id)->get();
        return view('jobs.applicants',compact('applicants'));
    }
    

    public function  create(){
        return view('jobs.create');
    }
    public function  store(JobPostRequest $request){
        
        $user_id = auth()->user()->id;
        $company = Company::where('user_id',$user_id)->first();
        $company_id = $company->id;
       // dd(request('last_date'));
        Job::create([
            'user_id' => $user_id,
            'company_id' => $company_id,
            'title'=>request('title'),
            'slug' =>str_slug(request('title')),
            'description'=>request('description'),
            'roles'=>request('roles'),
            'category_id' =>request('category'),
            'position'=>request('position'),
            'address'=>request('address'),
            'type'=>request('type'),
            'status'=>request('status'),
            'last_date'=>request('last_date'),
            'number_of_vacancy'=>request('number_of_vacancy'),
            'gender'=>request('gender'),
            'experience'=>request('experience'),
            'salary'=>request('salary')
         


        ]);
        return redirect()->back()->with('message','Job posted successfully!');
     }
     
     public function apply(Request $request,$id){
        $jobId = Job::find($id);
        $jobId->users()->attach(Auth::user()->id);
        return redirect()->back()->with('message','Application sent!');

    }

    public function allJobs(Request $request){
       
     //front search
        $search = $request->get('search');
        $address = $request->get('address');
        if($search){
          
            $jobs = Job::where('position','LIKE','%'.$search.'%')
                     ->orWhere('title','LIKE','%'.$search.'%')
                     ->orWhere('type','LIKE','%'.$search.'%')
                     ->paginate(20);
                    return view('jobs.alljobs',compact('jobs'));
        }
        if ($address){
           
            $jobs = Job::where('address','LIKE','%'.$address.'%')
                    ->paginate(20);
                return view('jobs.alljobs',compact('jobs'));
        }
        if($search && $address){
           $jobs = Job::where('position','LIKE','%'.$search.'%')
                    ->orWhere('title','LIKE','%'.$search.'%')
                    ->orWhere('type','LIKE','%'.$search.'%')
                    ->orWhere('address','LIKE','%'.$address.'%')
                    ->paginate(20);

            return view('jobs.alljobs',compact('jobs'));

        }

       $keyword = $request->get('position');
       $type = $request->get('type');
       $category = $request->get('category_id');
       $address = $request->get('address');
       if($keyword||$type||$category||$address){
        $jobs = Job::where('position','LIKE','%'.$keyword.'%')
                ->orWhere('type',$type)
                ->orWhere('category_id',$category)
                ->orWhere('address',$address)
                ->paginate(20);
                return view('jobs.alljobs',compact('jobs'));
       }else{
            $jobs = Job::latest()->paginate(20);
            return view('jobs.alljobs',compact('jobs'));
    }


}
    
    public function searchJobsByVue(Request $request){
        
        $search = $request->get('search');
        
        $jobs = Job::where('title', 'LIKE', '%'.$search. '%')
                    ->orWhere('position','LIKE','%'.$search. '%')
                    ->limit(5)->get();
        
        return response()->json($jobs);

    }

    function getRecommendedJobs(){
        if (Auth::check()){
            $user = Auth()->user()->id;
            $jobs = Recommendation::where('user_id',$user)->get();
            return view('jobs.recommended')
                ->with('jobs',$jobs);
        }        
    }
    

}
