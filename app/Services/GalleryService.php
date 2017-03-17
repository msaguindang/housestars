<?php

namespace App\Services;

use App\UserMeta;
use Sentinel;
use Exception;

class GalleryService
{
	public function delete($data = []) {
		try {
			$fileName = public_path() . '/' . $data['filename'];
			unlink($fileName);
			UserMeta::find($data['id'])->delete();
			$response = [
                'html' => view (
                    'dashboard.agency.partials.gallery_items', [
                        'data' => $this->getGalleryByUserId(Sentinel::getUser()->id)
                    ]
                )->render()
            ];
            return $response;
		} catch (Exception $e) {
			return [
				'error' => $e->getMessage()
			];
		}
	}

	public function getGalleryByUserId($id)
	{
		$meta = UserMeta::where('user_id', $id)->get();
        $data = [];
        $index = 0;

        foreach ($meta as $key) {
            if($key->meta_name == 'gallery') {
                $data[$key->meta_name][$index] = array('id' => $key->id, 'url'=> $key->meta_value);
                $index ++;
            }            
        }
        return $data;
	}
}