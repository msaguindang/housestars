<?php 

namespace App\Utilities;

use App\User;

class UserQueryBuilder
{
	public function searchQueryBuilder($query, $name, $email, $role)
	{
		$name = "'%" . $name . "%'";
		$email  = "'%" . $email . "%'";
		$role = "'%" . $role . "%'";
		$searchQuery = '';

		if (!empty($query)) {
			$query = "'%" . $query . "%'";
			$searchQuery = " AND (users.name LIKE {$query} OR users.email LIKE {$query} OR roles.name LIKE {$query}) ";
		}
		
		$searchQuery .= " AND (users.name LIKE {$name} AND users.email LIKE {$email} AND roles.name LIKE {$role}) ";
		
		return $searchQuery;
	}
}