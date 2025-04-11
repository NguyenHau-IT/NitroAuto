<?php
require_once '../app/models/Categories.php';

class CategoriesController
{
    public function addCate()
    {
        require_once '../app/views/categories/add_category.php';
    }

    public function createCate()
    {
        $name = $_POST['name'] ?? '';
        $description = $_POST['description'] ?? '';
        $data = [
            'name' => $name,
            'description' => $description
        ];

        if (Categories::create($data)) {
            header('Location: /admin#categories');
            exit;
        } else {
            header('Location: /admin#categories?status=error');
            exit;
        }
    }

    public function editCate($id)
    {
        if (!is_numeric($id)) {
            header('Location: /admin#categories?status=error');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? '';
            $description = $_POST['description'] ?? '';

            if (empty($name) || empty($description)) {
                header('Location: /admin#categories?status=error&msg=empty');
                exit;
            }

            $data = [
                'name' => $name,
                'description' => $description
            ];

            // Gọi model cập nhật
            if (Categories::update($id, $data)) {
                header('Location: /admin#categories?status=success');
                exit;
            } else {
                header('Location: /admin#categories?status=error');
                exit;
            }
        }

        // GET: Hiển thị form chỉnh sửa
        $category = Categories::find($id);
        require_once '../app/views/categories/edit_category.php';
    }
}
