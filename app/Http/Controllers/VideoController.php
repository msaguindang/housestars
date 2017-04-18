<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Sentinel;
use App\Video;
use Session;
use DB;
use App\Services\PotentialCustomerService;

class VideoController extends Controller
{
	public function getAllVideos(Request $request)
	{
        $fromDate = $request->get('from', '');
        $toDate = $request->get('to', '');
        $query = $request->get('query', '');
        $field = $request->get('sort', 'id');
        $direction = $request->get('direction', 'asc');
        $searchCreatedAt = $request->get('created_at', '');
        $searchUrl = $request->get('url', '');
        $searchPage = $request->get('page', '');
        $filter = $request->get('filter', '');

		$videoModel = new Video;
		$videos = $videoModel
						->selectRaw('id, url, page, status, created_at')
						->search($query)
						->filter($filter, $searchUrl, $searchPage)
						->searchByDateCreated($searchCreatedAt)
						->searchByRangeDate($fromDate, $toDate)
						->orderBy($field, $direction)
						->get()
						->toArray();

		return response()->json([
            'videos'  => $videos,
            'length'  => count($videos)
        ], 200);			
	}

	public function deleteVideo(Request $request)
	{
		$id = $request->get('id', null);
		
		if (!is_null($id)) {
			Video::find($id)->delete();
		}

		$response['success'] = [
            'message' => "User successfully deleted."
        ];

        return response()->json($response, 200);
	}

	public function saveVideo(Request $request)
	{
		$id = $request->get('id', null);
		$status = $request->get('status', 0);
		$page = $request->get('page');
		$url = $request->get('url');

		if ($status && $page) {
			Video::where('page', $page)->update(['status' => 0]);
		}

		if (is_null($id)) {
			Video::create([
				'url' 		=> $url,
				'status' 	=> $status,
				'page'		=> $page
			]);
		} else {
			Video::find($id)->update(['url' => $url, 'page' => $page, 'status' => $status]);
		}

		return $this->getAllVideos($request);
	}
}
