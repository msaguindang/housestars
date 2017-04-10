<?php 

namespace App\Utilities;

use App\User;
use Carbon\Carbon;

class UserQueryBuilder
{
	public function searchQueryBuilder($query, $name, $email, $role, $createdAt, $isSearchCreatedAt, $fromDate, $toDate)
	{
		$name = "'%" . $name . "%'";
		$email  = "'%" . $email . "%'";
		$role = "'%" . $role . "%'";
		$createdAt = "'%" . $createdAt . "%'";
		$searchQuery = '';

		if (!empty($query)) {
			$query = "'%" . $query . "%'";
			$searchQuery = " AND (users.name LIKE {$query} OR users.email LIKE {$query} OR roles.name LIKE {$query}) ";
		}
		
		$searchQuery .= " AND (users.name LIKE {$name} AND users.email LIKE {$email} AND roles.name LIKE {$role} AND (DATE_FORMAT(users.created_at, '%b %e, %Y') LIKE $createdAt OR DATE_FORMAT(users.created_at, '%M %e, %Y') LIKE $createdAt) ) ";
		
		if(!empty($fromDate) && !empty($toDate) && $isSearchCreatedAt) {
            $fromDate = Carbon::createFromFormat('Y-m-d H:i:s', $fromDate .' 00:00:00')->toDateTimeString();
            $toDate = Carbon::createFromFormat('Y-m-d H:i:s', $toDate .' 00:00:00')->toDateTimeString();
            $searchQuery .= " AND (users.created_at BETWEEN '{$fromDate}' AND '{$toDate}') ";
        }
        
		return $searchQuery;
	}
}