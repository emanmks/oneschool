<?php

class DashboardController extends \BaseController {

	public function showDashboard()
	{
		$menu = '';
		$_301 = Issue::where('generation_id','=',1)
					->where('project_id','=',Auth::user()->curr_project_id)
					->where('location_id','=',Auth::user()->location_id)
					->count();
		$_201 = Issue::where('generation_id','=',2)
					->where('project_id','=',Auth::user()->curr_project_id)
					->where('location_id','=',Auth::user()->location_id)
					->count();
		$_101 = Issue::where('generation_id','=',3)
					->where('project_id','=',Auth::user()->curr_project_id)
					->where('location_id','=',Auth::user()->location_id)
					->count();
		$_302 = Issue::where('generation_id','=',4)
					->where('project_id','=',Auth::user()->curr_project_id)
					->where('location_id','=',Auth::user()->location_id)
					->count();
		$_202 = Issue::where('generation_id','=',5)
					->where('project_id','=',Auth::user()->curr_project_id)
					->where('location_id','=',Auth::user()->location_id)
					->count();
		$_102 = Issue::where('generation_id','=',6)
					->where('project_id','=',Auth::user()->curr_project_id)
					->where('location_id','=',Auth::user()->location_id)
					->count();
		$_603 = Issue::where('generation_id','=',7)
					->where('project_id','=',Auth::user()->curr_project_id)
					->where('location_id','=',Auth::user()->location_id)
					->count();
		$_503 = Issue::where('generation_id','=',8)
					->where('project_id','=',Auth::user()->curr_project_id)
					->where('location_id','=',Auth::user()->location_id)
					->count();
		$_403 = Issue::where('generation_id','=',9)
					->where('project_id','=',Auth::user()->curr_project_id)
					->where('location_id','=',Auth::user()->location_id)
					->count();

		$last_month_registrations = Registration::where('project_id','=',Auth::user()->curr_project_id)
												->where('location_id','=',Auth::user()->location_id)
												->where(DB::raw('month(registration_date)'),'<>',date('m'))
												->where(DB::raw('year(registration_date)'),'=',date('Y'))
												->count();

		$curr_month_registrations = Registration::where('project_id','=',Auth::user()->curr_project_id)
												->where('location_id','=',Auth::user()->location_id)
												->where(DB::raw('month(registration_date)'),'=',date('m'))
												->where(DB::raw('year(registration_date)'),'=',date('Y'))
												->count();

		$movement_registrations = Registration::where('project_id','=',Auth::user()->curr_project_id)
												->where('location_id','=',Auth::user()->location_id)
												->where('classification_id','=',10)->count();

		$curr_active_students = Placement::where('project_id','=',Auth::user()->curr_project_id)
										->where('location_id','=',Auth::user()->location_id)
										->where('active','=',1)->count();

		$curr_do_students = Resign::where('project_id','=',Auth::user()->curr_project_id)
										->where('location_id','=',Auth::user()->location_id)
										->where('classification_id','=',13)->count();

		$curr_resign_students = Resign::where('project_id','=',Auth::user()->curr_project_id)
										->where('location_id','=',Auth::user()->location_id)
										->where('classification_id','=',14)->count();

		$curr_relocate_students = Resign::where('project_id','=',Auth::user()->curr_project_id)
										->where('location_id','=',Auth::user()->location_id)
										->where('classification_id','=',15)->count();

		$courses = Course::where('project_id','=',Auth::user()->curr_project_id)
						->where('location_id','=',Auth::user()->location_id)
						->get();

		return View::make('dashboard.home', compact(
										'_301','_201','_101','_302','_202','_102','_603','_503','_403',
										'last_month_registrations','curr_month_registrations','movement_registrations',
										'curr_active_students','curr_do_students','curr_resign_students',
										'curr_relocate_students','courses',
										'menu'));
	}

	public function importData()
	{
		$siswas = Siswa::all();

		foreach($siswas as $siswa)
		{

			ini_set('max_execution_time', 300);

			$student = new Student;
			$student->name = $siswa->FullName;
			if($siswa->Sex == 'MALE')
			{
				$student->sex = 'L';
				$student->photo = 'boy.png';
			}
			else
			{
				$student->sex = 'P';
				$student->photo = 'girl.png';
			}
			$student->birthplace = $siswa->BirthPlace;
			$student->birthdate = $siswa->BirthDate;
			$student->religion = $siswa->Religion;
			$student->address = $siswa->FullAddress;
			$student->contact = $siswa->CellPhone;
			$student->father_name = $siswa->FatherName;
			$student->father_occupation = $siswa->FatherOccupation;
			$student->father_address = $siswa->FatherAddress;
			$student->father_contact = $siswa->FatherContact;
			$student->mother_name = $siswa->MotherName;
			$student->mother_occupation = $siswa->MotherOccupation;
			$student->mother_address = $siswa->MotherAddress;
			$student->mother_contact = $siswa->MotherContact;

			$student->save();
		}

		Session::flash('message','Sukses mengimport Data Siswa');

		return Redirect::to('/');
	}

	public function changeCase()
	{
		ini_set('max_execution_time', 300);
		
		$students = Student::all();

		foreach($students as $student)
		{
			$name = ucwords(strtolower($student->name));
			$birthplace = ucwords(strtolower($student->birthplace));
			$religion = ucwords(strtolower($student->religion));
			$address = ucwords(strtolower($student->address));
			$father_name = ucwords(strtolower($student->father_name));
			$father_occupation = ucwords(strtolower($student->father_occupation));
			$father_address = ucwords(strtolower($student->father_address));
			$mother_name = ucwords(strtolower($student->mother_name));
			$mother_occupation = ucwords(strtolower($student->mother_occupation));
			$mother_address = ucwords(strtolower($student->mother_address));

			$student->name = $name;
			$student->birthplace = $birthplace;
			$student->religion = $religion;
			$student->address = $address;
			$student->father_name = $father_name;
			$student->father_occupation = $father_occupation;
			$student->father_address = $father_address;
			$student->mother_name = $mother_name;
			$student->mother_occupation = $mother_occupation;
			$student->mother_address = $mother_address;
			$student->save();
		}

		Session::flash('message','Sukses mengimport Data Siswa');
	}
}