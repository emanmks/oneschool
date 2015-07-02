<?php

class IssuesController extends \BaseController {

	public function update($id)
	{
		$issue = Issue::findOrFail($id);

		$issue->issue = Input::get('issue');
		$issue->save();
	}

	public function destroy($id)
	{
		Issue::destroy($id);
	}

}
