<?php
require_once '../app/models/Reviews.php';

class ReviewsController
{
    public function all($car_id)
    {
        $reviews = Reviews::all($car_id);
        require_once '../app/views/reviews/list_reviews.php';
    }

    public function saveReview()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!isset($_POST['car_id'], $_SESSION['user']['id'])) {
                header("Location: /home");
                exit();
            }
    
            $user_id = $_SESSION['user']['id'];
            $car_id = $_POST['car_id'];
            $comment = isset($_POST['comment']) ? trim($_POST['comment']) : null;
            $rating = isset($_POST['rating']) ? (int)$_POST['rating'] : null;
    
            $existingReview = Reviews::find($user_id, $car_id);
    
            if ($existingReview) {
                // Cập nhật: giữ lại giá trị cũ nếu không gửi từ form
                $newRating = $rating !== null ? $rating : $existingReview['rating'];
                $newComment = $comment !== null ? $comment : $existingReview['comment'];
                Reviews::update($user_id, $car_id, $newRating, $newComment);
            } else {
                // Tạo mới
                Reviews::add($user_id, $car_id, $rating, $comment);
            }
    
            header("Location: /car_detail/$car_id");
            exit();
        }
    }
    
}
