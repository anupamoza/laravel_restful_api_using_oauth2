<?php
namespace App\Http\Repository;

use Activation;
use App\Http\Repository\Repository;
use App\Models\Role;
use App\User;
use Hash;

class UserRepository extends Repository {

	public function index($limit, $order, $dir, $start) {

		($order == 'status' ? $order = 'activations.completed' : $order = $order);
		$data = User::join('activations', 'activations.user_id', '=', 'users.id')
			->join('role_users', 'role_users.user_id', '=', 'users.id')
			->select('activations.completed', 'role_users.role_id', 'users.*')
			->where('role_users.role_id', 1)
			->offset($start)
			->limit($limit)
			->orderBy($order, $dir)
			->get();
		return $data;
	}

	public function getUsers($searchVal = '', $like = '', $limit, $order, $dir, $start) {
		($order == 'status' ? $order = 'activations.completed' : $order = $order);
		($like == 'status' ? $li = 'activations.completed' : $li = "users." . $like);
		$data = User::join('activations', 'activations.user_id', '=', 'users.id')
			->join('role_users', 'role_users.user_id', '=', 'users.id')
			->select('activations.completed', 'role_users.role_id', 'users.*')
			->where('role_users.role_id', 1)
			->where($li, 'LIKE', "%" . $searchVal . "%")
			->offset($start)
			->limit($limit)
			->orderBy($order, $dir)
			->get();
		return $data;

	}

	public function create($id) {
		return $role = Role::select('id')->where('id', $id)->first();
	}

	public function show($id) {
		$data = User::join('activations', 'users.id', '=', 'activations.user_id')
			->select('activations.completed', 'users.*')
			->where('users.id', $id)
			->first();
		return $data;
	}

	public function edit($id) {
		$data = User::join('activations', 'users.id', '=', 'activations.user_id')
			->select('activations.completed', 'users.*')
			->where('users.id', $id)
			->first();
		return $data;
	}

	public function update($data, $id) {
		$emails = User::select('email')
			->where('email', $data['email'])
			->where('id', '!=', $id)
			->get();
		if (count($emails) > 0) {
			return 'email_exists';
		} else {
			$userUpdate = User::where('id', $id)
				->update([
					'first_name' => $data['first_name'],
					'last_name' => $data['last_name'],
					'email' => $data['email'],
				]);
			$updateStatus = Activation::where('user_id', $id)
				->update(['completed' => $data['completed']]);
		}
	}

	public function changepassword($data, $email) {
		//pr($data);die();
		$currentPw = User::where('email', $email)
			->select('password')
			->first();

		if (Hash::check($data['current_password'], $currentPw['password'])) {
			$update = User::where('email', $email)
				->update([
					'password' => Hash::make($data['password']),
					'flag' => 1,
				]);
			return $update;
		} else {
			return 'current_pw_err';
		}

	}
}