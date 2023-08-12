<?php

namespace app\models;

use app\core\BaseModel;

class NewsModels extends BaseModel
{
    public function add($news_data)
    {
        $result = false;
        $error_message = '';

        if (empty($news_data['title'])) {
            $error_message .= "Введите наименование!<br>";
        }
        if (empty($news_data['short_description'])) {
            $error_message .= "Введите краткое описание!<br>";
        }
        if (empty($news_data['description'])) {
            $error_message .= "Введите описание!<br>";
        }
        if (empty($news_data['price'])) {
            $error_message .= "Введите цену!<br>";
        }

        if (empty($error_message)) {
            $result = $this->insert(
                "INSERT INTO product (title, short_description, description, date_create, user_id,price)
                        VALUES (:title, :short_description, :description, NOW(), :user_id, :price)",
                [
                    'title' => $news_data['title'],
                    'short_description' => $news_data['short_description'],
                    'description' => $news_data['description'],
                    'user_id' => $_SESSION['user']['id'],
                    "price"=>$news_data['price'],
                ]
            );
        }

        return [
            'result' => $result,
            'error_message' => $error_message
        ];
    }

    public function edit($news_id, $news_data)
    {
        $result = false;
        $error_message = '';

        if (empty($news_id)) {
            $error_message .= "Отсутствует идентификатор записи!<br>";
        }
        if (empty($news_data['title'])) {
            $error_message .= "Введите наименование!<br>";
        }
        if (empty($news_data['short_description'])) {
            $error_message .= "Введите краткое описание!<br>";
        }
        if (empty($news_data['description'])) {
            $error_message .= "Введите описание!<br>";
        }
        if (empty($news_data['price'])) {
            $error_message .= "Введите цену!<br>";
        }

        if (empty($error_message)) {
            $result = $this->update(
                "UPDATE product SET title = :title, short_description = :short_description,
                        description = :description, price = :price where id = :id",
                [
                    'title' => $news_data['title'],
                    'short_description' => $news_data['short_description'],
                    'description' => $news_data['description'],
                    'id' => $news_id, 'price' =>$news_data['price'],
                ]
            );
        }

        return [
            'result' => $result,
            'error_message' => $error_message
        ];
    }

    public function deleteById($news_id)
    {
        $result = false;
        $error_message = '';

        if (empty($news_id)) {
            $error_message .= "Отсутствует идентификатор записи!<br>";
        }

        if (empty($error_message)) {
            $result = $this->update("DELETE FROM product WHERE id = :id",
                [
                    'id' => $news_id,
                ]
            );
        }

        return [
            'result' => $result,
            'error_message' => $error_message
        ];
    }

    public function getListNews()
    {
        $result = null;

        $news = $this->select('select * from product');
        if (!empty($news)) {
            $result = $news;
        }
        return $result;
    }

    public function getNewsById($news_id)
    {
        $result = null;

        $news = $this->select('select * from product where id = :id', [
            'id' => $news_id
        ]);
        if (!empty($news[0])) {
            $result = $news[0];
        }
        return $result;
    }
}