<?php
require_once '../app/models/TestDriveRegistration.php';
require_once '../app/models/Cars.php';


class TestDriveController
{
    public function index()
    {
        $testDrives = TestDriveRegistration::findByUser();
        require_once '../app/views/test_drives//test_drive_user.php';
    }

    public function Test_Drive()
    {
        if (!isset($_SESSION["user"]["id"])) {
            header("Location: /home?status=error&message=" . urlencode("Vui lòng đăng nhập trước !"));
            exit();
        }

        $cars = Cars::all();
        require_once '../app/views/test_drives/test_drive_register.php';
    }

    public function create()
    {
        $user_id = $_SESSION["user"]["id"] ?? null;
        if (!$user_id) {
            header("Location: /home?status=error&message=" . urlencode("Vui lòng đăng nhập trước !"));
            exit();
        }
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $user_id = $_POST['user_id'] ?? null;
            $car_id = $_POST['car_id'] ?? null;
            $preferred_date = $_POST['preferred_date'] ?? null;
            $preferred_time = $_POST['preferred_time'] ?? null;
            $location = $_POST['location'] ?? null;

            if (!$user_id || !$car_id || !$preferred_date || !$preferred_time || !$location) {
                header("Location: /home?status=error&message=" . urlencode("Vui lòng điền đầy đủ thông tin!"));
                exit();
            }

            $result = TestDriveRegistration::create($user_id, $car_id, $preferred_date, $preferred_time, $location);
            if ($result) {
                header("Location: /home?status=success&message=" . urlencode("Đăng ký lái thử thành công!"));
            } else {
                header("Location: /home?status=error&message=" . urlencode("Đăng ký lái thử thất bại!"));
            }
            exit();
        }
    }

    public function edit($id)
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $id = $_POST['id'] ?? null;
            $user_id = $_POST['user_id'] ?? null;
            $car_id = $_POST['car_id'] ?? null;
            $preferred_date = $_POST['preferred_date'] ?? null;
            $preferred_time = $_POST['preferred_time'] ?? null;
            $location = $_POST['location'] ?? null;
            $status = $_POST['status'] ?? null;
            $data = [
                'user_id' => $user_id,
                'car_id' => $car_id,
                'preferred_date' => $preferred_date,
                'preferred_time' => $preferred_time,
                'location' => $location,
                'status' => $status
            ];

            if (TestDriveRegistration::update($id, $data)) {
                header("Location: /admin#test_drive?status=success");
            } else {
                header("Location: /admin#test_drive?status=error");
            }
            exit();
        }
        $cars = Cars::all();
        $testDrive = TestDriveRegistration::find($id);
        require_once '../app/views/test_drives/test_drive_edit.php';
    }

    public function delete($id)
    {
        if (TestDriveRegistration::delete($id)) {
            header("Location: /admin#test_drive");
            exit();
        } else {
            header("Location: /admin#test_drive?status=error");
            exit();
        }
    }
}
