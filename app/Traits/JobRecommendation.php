<?php
namespace App\Traits;
use App\Job;
use App\Recommendation;
use Carbon\Traits\Date;
use Illuminate\Support\Facades\Auth;

trait JobRecommendation{
    public function jobRecommendations($job){
       
        $data = [];

        $jobsBasedOnCategories = Job::latest()->where('category_id',$job->category_id)
            ->whereDate('last_date','>',date('Y-m-d'))
            ->where('id','!=',$job->id)
            ->where('status',1)
           ->get();
       array_push($data,$jobsBasedOnCategories);
       
        $jobBasedOnCompany = Job::latest()
            ->where('company_id',$job->company_id)
            ->whereDate('last_date','>',date('Y-m-d'))
            ->where('id','!=',$job->id)
            ->where('status',1)
            ->limit(6)
            ->get();
      
        $jobBasedOnPosition= Job::where('position','LIKE','%'.$job->position.'%')                 ->where('id','!=',$job->id)
            ->where('status',1)
            ->limit(6)
            ->get();
        array_push($data,$jobBasedOnPosition);
        
        $collection  = collect($data);

        $unique = $collection->unique("id");
        $jobRecommendations =  $unique->values()->first();
        if (Auth::check())
            $this->insertRecommendedJobs($jobRecommendations);
        return $jobRecommendations;
    }

    /**
     * @param $jobRecommendations
     * storing data into recommendation table.
     */
    public function insertRecommendedJobs($jobRecommendations){
       
        $arrRecommendations = [];
            $user = Auth()->user();
            foreach ((array)$jobRecommendations as $jobrecommendation) {
               foreach ($jobrecommendation  as $key=> $recommendation) {
                  //  echo ($recommendation['id'].' -- '.$recommendation['user_id'])."<br>";
                    $rjob_users = Recommendation::where('job_id',$recommendation['id'])
                                       ->where('user_id',$user->id)
                                       ->get();
                   if (count($rjob_users)<=0)
                   {
                       $arrRecommendations['job_id'] = $recommendation['id'];
                       $arrRecommendations['company_user_id'] = $recommendation['user_id'];
                       $arrRecommendations['user_id'] = $user->id;
                       $arrRecommendations['company_id'] = $recommendation['company_id'];
                       $arrRecommendations['title'] = $recommendation['title'];
                       $arrRecommendations['slug'] = $recommendation['slug'];
                       $arrRecommendations['description'] = $recommendation['description'];
                       $arrRecommendations['roles'] = $recommendation['roles'];
                       $arrRecommendations['category_id'] = $recommendation['category_id'];
                       $arrRecommendations['position'] = $recommendation['position'];
                       $arrRecommendations['address'] = $recommendation['address'];
                       $arrRecommendations['type'] = $recommendation['type'];
                       $arrRecommendations['status'] = $recommendation['status'];
                       $arrRecommendations['last_date'] = $recommendation['last_date'];
                       $arrRecommendations['created_at'] = now();
                       $arrRecommendations['updated_at'] = now();

                       Recommendation::insert($arrRecommendations);
                   }

            }
        }


    }

}
