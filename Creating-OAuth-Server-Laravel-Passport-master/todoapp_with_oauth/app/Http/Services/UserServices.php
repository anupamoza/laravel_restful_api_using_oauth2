<?php
namespace App\Http\Services;

use App\Http\Repository\UserRepository;
use Illuminate\Http\Request;
use Sentinel;
use Validator;

class UserServices extends Services {

	function __construct(UserRepository $UserRepository, Sentinel $sentinel, Request $request) {
		$this->repository = $UserRepository;
		$this->auth = $sentinel;
		$this->request = $request;
	}

	public function getUsers() {

		$requestData = $this->request->all();

		$columns = array(
			0 => 'id',
			1 => 'first_name',
			2 => 'last_name',
			3 => 'email',
			4 => 'status',
		);

		$limit = $this->request->input('length');
		$start = $this->request->input('start');
		$dir = $this->request->input('order.0.dir');
		$order = $columns[$this->request->input('order.0.column')];

		$totalUsers = $this->repository->index($limit, $order, $dir, $start);
		$countUsers = count($totalUsers);
		$totalFilteredData = $countUsers;

		if (!empty($this->request['columns'][1]['search']['value'])) {

			$searchVal = $requestData['columns'][1]['search']['value'];
			$like = $columns[1];
			$totalUsers = $this->repository->getUsers($searchVal, $like, $limit, $order, $dir, $start);
			$totalFilteredData = count($totalUsers);

		} else if (!empty($this->request['columns'][2]['search']['value'])) {

			$searchVal = $requestData['columns'][2]['search']['value'];
			$like = $columns[2];
			$totalUsers = $this->repository->getUsers($searchVal, $like, $limit, $order, $dir, $start);
			$totalFilteredData = count($totalUsers);

		} else if (!empty($this->request['columns'][3]['search']['value'])) {

			$searchVal = $requestData['columns'][3]['search']['value'];
			$like = $columns[3];
			$totalUsers = $this->repository->getUsers($searchVal, $like, $limit, $order, $dir, $start);
			$totalFilteredData = count($totalUsers);

		} else if ($this->request['columns'][4]['search']['value'] == 'Select Status') {

			$totalUsers = $totalUsers;
			$totalFilteredData = count($totalUsers);

		} else if ($this->request['columns'][4]['search']['value'] != '') {

			$searchVal = $requestData['columns'][4]['search']['value'];
			$like = $columns[4];
			$totalUsers = $this->repository->getUsers($searchVal, $like, $limit, $order, $dir, $start);
			$totalFilteredData = count($totalUsers);

		} else {
			$totalUsers = $totalUsers;
		}

		$data = array();
		if (!empty($totalUsers)) {
			$count = 1;
			foreach ($totalUsers as $user) {
				$show = route('user.show', $user->id);
				$edit = route('user.edit', $user->id);

				$nestedData['id'] = $count;
				$nestedData['first_name'] = $user->first_name;
				$nestedData['last_name'] = $user->last_name;
				$nestedData['email'] = $user->email;
				$nestedData['status'] = ($user->completed == 1 ? "Active" : "Inactive");
				$nestedData['added'] = date("d-m-Y h:i:s", strtotime($user->created_at));
				$nestedData['action'] = '<a href="' . $edit . '" class="badge bg-primary"><i class="fa fa-pencil"></i></a>
										 <a href="' . $show . '" class="badge bg-primary"><i class="fa fa-eye"></i></a>
										 <a href="#" class="badge bg-primary"><i class="fa fa-trash-o"></i></a>';
				$data[] = $nestedData;
				$count++;
			}
		}

		$json_data = array(
			"draw" => intval($this->request->input('draw')),
			"recordsTotal" => intval($countUsers),
			"recordsFiltered" => intval($totalFilteredData),
			"data" => $data,
		);
		echo json_encode($json_data);
	}

	public function index() {
		return $this->repository->index();
	}

	public function create() {

		$id = $this->auth::getUser()->roles()->first()->id;
		return $this->repository->create($id);
	}

	public function show($id) {
		return $userShow = $this->repository->show($id);
	}

	public function edit($id) {
		return $userEdit = $this->repository->edit($id);
	}

	public function update($id) {
		try {
			$this->validate($this->request, [
				'first_name' => 'required|string',
				'last_name' => 'required|string',
				'email' => 'required|email|unique:users,email',
			]);
			$updateDetails = $this->request->all();

		} catch (Exception $e) {
			echo $e->getCode();
		}

		return $this->repository->update($updateDetails, $id);
	}

	public function changepassword() {
		try {
			$validator = Validator::make($this->request->all(), [
				'current_password' => 'required',
				'password' => 'confirmed|required|min:5',
				'password_confirmation' => 'required|min:5',
			]);

			if ($validator->fails()) {
				return redirect('changepassword')->withErrors($validator)->withInput();
			} else {

				$email = $this->auth::getUser()->email;
				$updatePassword = $this->request->all();
				$update = $this->repository->changepassword($updatePassword, $email);
				return $update;
			}

		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}
}