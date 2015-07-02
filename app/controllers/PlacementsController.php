<?php

class PlacementsController extends \BaseController {

	public function update($id)
	{
		$placement = Placement::findOrFail($id);

		$placement->course_id = Input::get('course_id');
		$placement->save();

		Session::flash('message','Penempatan Kelas telah dikoreksi!');
	}

	public function destroy($id)
	{
		Placement::destroy($id);

		Session::flash('message','Penempatan Kelas telah dihapus!!');
	}

}
