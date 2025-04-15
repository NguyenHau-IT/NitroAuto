<?php
require_once './models/NewsModel.php';

class NewsController {

    public function index() {
        $model = new News();
        $newsList = $model->getNews();
        require './views/news/index.php';
    }
}
