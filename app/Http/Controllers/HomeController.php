<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Auth;
use DB;
use View;

class HomeController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

	 public function GetUserInfo()
    {
        return  [
            'userid' => Auth::user()->id,
            'name' => Auth::user()->name,
            'email' => Auth::user()->email,
        ];
    }
    public function index()
    {	
		$adminModel = $this->GetUserInfo();		
		$searchnotes = $this->SearchNotes($adminModel['userid']);
		$deletednotes = $this->DeletedNotes($adminModel['userid']);
		$recievednotes = $this->RecievedNotes($adminModel['userid']);
		
		return View::make('home', compact('adminModel', 'searchnotes', 'deletednotes', 'recievednotes'));
    }
	
	public function SearchNotes($uid)
	{
		$searchnotes = DB::table('User_Notes')
		->where('userid', '=', $uid)
		->where('deleted', '=', '0000-00-00')
		->where('recieved', '=', '')
		->orderBy('last_updated', 'DESC')
		->get();

		return  $searchnotes;
	}
	
	public function DeletedNotes($uid)
	{
		$deletednotes = DB::table('User_Notes')
		->where('userid', '=', $uid)
		->where('deleted', '!=', '0000-00-00')
		->orderBy('last_updated', 'DESC')
		->get();

		return  $deletednotes;
	}
	
	public function RecievedNotes($uid)
	{
		$recievednotes = DB::table('User_Notes')
		->where('deleted', '=', '0000-00-00')
		->where('recieved', '=', $uid)
		->orderBy('last_updated', 'DESC')
		->get();

		return  $recievednotes;
	}

	public function SignOut()
	{
		return View::make('home');	
	}

	public function RequestSubmit()
    {
        //Get all the data and store it inside Store Variable
        $data = Input::only('title', 'description', 'created_date', 'last_updated');
        //Validation rules
        $rules = array(
            'title' => 'required',
			'description' => 'required'
        );
        //Validate data
        $validator = Validator::make($data, $rules);
        if ($validator->passes()) {
			$requestInfo = array( 'title' => Input::get('title'),
                                'description' => Input::get('description'),
                                'created_date' => Input::get('created_date'),
                                'last_updated' => Input::get('last_updated'));
			$id = Auth::id();
			$name = Auth::user()->name;
			$today = date("Y-m-d H:i:s"); 	
			DB::table('User_Notes')->insert(array(
			'userid' => $id,
			'name' => $name,
            'title' => Input::get('title'),
            'description' => Input::get('description'),
            'created_date' => Input::get('created_date'),
            'last_updated' => $today,
			'deleted' => '0000-00-00',
			'recieved' => ''
            ));
            //Redirect to page
            return redirect()->route('login');//return Redirect::route('/');//->with('message', 'Your message has been sent. Thank You!');
        } else {
            //return contact form with errors
            return Redirect::back()->withErrors($validator);
        }
    }
	
	public function NoteDetail($noteid)
    {
        $notes = DB::table('User_Notes')->where('id', $noteid)->take(1)->get();
		$users = DB::table('users')->where('id', '!=', Auth::user()->id)->get();
        $adminModel = $this->GetUserInfo();
        return View::make('noteDetail', compact('adminModel', 'notes', 'users'));
    }
	
	public function UpdateNote()
    {
        //Get all the data and store it inside Store Variable
        $data = Input::only('title', 'description', 'created_date');
        //Validation rules
        $rules = array(
            'title' => 'required',
			'description' => 'required'
        );
        //Validate data
        $validator = Validator::make($data, $rules);
        if ($validator->passes()) {
			$requestInfo = array( 'title' => Input::get('title'),
                                'description' => Input::get('description'),
                                'created_date' => Input::get('created_date'));
			$id = Auth::id();
			$name = Auth::user()->name;
			$today = date("Y-m-d H:i:s"); 	
			DB::table('User_Notes')->where('id', Input::get('id'))
			->update([
			'userid' => $id,
			'name' => $name,
            'title' => Input::get('title'),
            'description' => Input::get('description'),
            'created_date' => Input::get('created_date'),
            'last_updated' => $today,
			'deleted' => '0000-00-00'
            ]);
			 return redirect('home');
        }else {
            //return contact form with errors
            return Redirect::back()->withErrors($errors);
        }
    }
	
	public function GetNote($noteid)
	{
		$getnote = DB::table('User_Notes')
		->where('id', '=', $noteid)
		->get();
		
		return $getnote;	
	}
	
	public function GetAllUsers(){
		$getusers = DB::table('users')
		->where('id', '!=', Auth::id())
		->get();
		
		return $getusers;	
	}
	
	public function ShareNoteToAll($noteid)
	{
		$getnote = $this->GetNote($noteid);
		foreach($getnote as $getno){
			$theuserid = $getno->userid;
			$thename = $getno->name;
			$thetitle = $getno->title;
			$thedescription = $getno->description;
			$thecreated_date = $getno->created_date;
			$thelast_updated = $getno->last_updated;
		}
		
		$getusers = $this->GetAllUsers();
		foreach($getusers as $getuser){
				DB::table('User_Notes')
				->insert(array(
				'userid' => $theuserid,
				'name' => $thename,
				'title' => $thetitle,
				'description' => $thedescription,
				'created_date' => $thecreated_date,
				'last_updated' => $thelast_updated,
				'deleted' => '0000-00-00',
				'recieved' => $getuser->id
				));
		   /*print_r($friends_checked);*/
		   /*echo $value.'<br />';*/
		   /*print_r($note_id);*/
		}
			return redirect('home');	
	}
	
	public function ShareNote()
    {
        $friends_checked = Input::get('sharenote');
		$note_id = Input::get('id');
		$getnote = $this->GetNote($note_id);
		foreach($getnote as $getno){
			$theuserid = $getno->userid;
			$thename = $getno->name;
			$thetitle = $getno->title;
			$thedescription = $getno->description;
			$thecreated_date = $getno->created_date;
			$thelast_updated = $getno->last_updated;
		}
		if(is_array($friends_checked))
		{
			foreach($friends_checked as $key => $value){
				DB::table('User_Notes')
				->insert(array(
				'userid' => $theuserid,
				'name' => $thename,
				'title' => $thetitle,
				'description' => $thedescription,
				'created_date' => $thecreated_date,
				'last_updated' => $thelast_updated,
				'deleted' => '0000-00-00',
				'recieved' => $value
				));
		   /*print_r($friends_checked);*/
		   /*echo $value.'<br />';*/
		   /*print_r($note_id);*/
			}
			return redirect('home');
		}
    }
	
	public function DeleteNote($noteid)
    {
			$id = Auth::id();
			$name = Auth::user()->name;
			$today = date("Y-m-d H:i:s"); 	
			DB::table('User_Notes')->where('id', $noteid)
			->update([
            'deleted' => $today
            ]);

			 return redirect('home');
    }
	
	public function ActivateNote($noteid)
    {
			$id = Auth::id();
			$name = Auth::user()->name;
			$today = date("Y-m-d H:i:s"); 	
			DB::table('User_Notes')->where('id', $noteid)
			->update([
            'deleted' => '0000-00-00'
            ]);

			 return redirect('home');
    }
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
}

