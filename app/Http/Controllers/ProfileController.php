<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Users; 
use App\Models\Universities;
use App\Models\Countries;
use App\Models\Careers;
use App\Models\Faculties;
use App\Models\Subjects;
use App\Models\Scores;
use App\Models\SocialMedia;
use App\Models\SocialUser;
use App\Models\User as ModelsUser;
use App\User as AppUser;
use Illuminate\Foundation\Auth\User;

class ProfileController extends Controller
{
    //Login & Sing up
    public function loginUser(){
        
        return view('welcome_views.1login');
    }

    //Profile
    public function myProfile(Request $request){
        $countries = Countries::select('*')->orderBy('name', 'asc')->get();
        $scores = Scores::select('*')->where('student_id', '00083120')->get();
        $userMedia = SocialUser::select('user_id', 'socialmedia_id', 'link')
        ->where('user_id', 1)->with('socialMedia')
        ->get();
        $uvAll = 0;
        $sumAll = 0;
        foreach ($scores as $score) {
            if($score->score >= 6){
                $sumAll += ($score->score * $score->UV);
                $uvAll += $score->UV;
            }
        }
        //Progress of the career
        $done = 4.5;
        $missing = 100-$done;
        //CUM
        if($sumAll == 0 && $uvAll == 0){
            $sumAll = 0.01;
            $uvAll = 1;
        }else
        $achCum = round(($sumAll/$uvAll),2);
        $missCum = 10 - $achCum;
        $progress = [
            'done' => $done,
            'missing' => $missing,
            'CUM_ach' => $achCum,
            'CUM_miss' => $missCum
        ];
        
        $usersAll = Users::get('username', 'password');
            $users = Users::select('*')->where('id_student', '00083120'
            )->with('university','career'
            )->get();
            return view('Profile.profile',  compact('users', 'userMedia'), ['pro'=>$progress]);
        }

    
    public function myScores(Request $request){
        $users = Users::select('*')->where('id_student', '00083120')->get();
        $scores = Scores::select('*')->where('student_id', '00083120')->with('subject')->orderBy('cicle', 'asc')->get();
        $higher = DB::table('scores')->where('student_id', '00083120')->max('cicle');

        //$socialMedia = SocialMedia::select('id', 'socialName',)
        /* for ($i=0; $i < $higher; $i++) { 
            echo "Ciclo " . ($i+1) . "<br>";
            foreach($scores as $sco){
                    if($sco->cicle == $i+1){
                    echo $sco->subject->name . "---";
                    echo $sco->score . "<br>";} 
            }

        } */
 
        //dd($scores);
        return view('Profile.myScores', compact('users', 'scores'), ['higher'=>$higher]);
    }

    public function adding(Request $request){
        $subjects = Subjects::select('id', 'name')->orderBy('name', 'asc')->get();
        $nos = $request->nos;
        $cicle = $request->cicle;
        $users = Users::select('*')->where('id_student', '00083120')->get();
        
        return view('Profile.adding', compact('subjects', 'users'), ['nOfSub'=>$nos, 'cicle'=>$cicle]);
    }
    
    public function updateData(){
        $users = Users::select('*')->where('id_student', '00083120')->with('university','career'
        )->get();
        $countries = Countries::select('id', 'name')->get();
        $universities = Universities::select('id', 'name')->get();
        $careers = Careers::select('id', 'name')->get();
        $faculties = Faculties::select('id', 'name')->get();
        $socialmedia = SocialMedia::select('id', 'socialName')->get();
        return view('Profile.updateProfile', compact(
            'users', 'countries', 'universities', 'careers', 'faculties', 'socialmedia'
        ));
    }
    
    public function addSocialU(Request $request){
        $newLink = SocialUser::create([
            'user_id' => $request->user_id,
            'socialmedia_id' => $request->sm_id,
            'link' => $request->link
        ]);

        if($newLink){
            return redirect()->route('update');
        }
    }
}
