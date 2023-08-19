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
        if (empty($news_data['file'])) {
            $news_data['file_path'] .= "/app/web/img/default.jpg";
        } else {
            $news_data['file_path'] = "/app/web/img/" . $news_data['file']['name'];
            file_put_contents(
                $_SERVER['DOCUMENT_ROOT'] . $news_data['file_path'],
                file_get_contents($news_data['file']['tmp_name'])
            );
        }

        if (empty($error_message)) {
            $result = $this->insert(
                "INSERT INTO product (title, short_description, description, date_create, user_id,price, file_path)
                        VALUES (:title, :short_description, :description, NOW(), :user_id, :price, :file_path)",
                [
                    'title' => $news_data['title'],
                    'short_description' => $news_data['short_description'],
                    'description' => $news_data['description'],
                    'user_id' => $_SESSION['user']['id'],
                    "price" => $news_data['price'],
                    "file_path" => $news_data['file_path'],
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
                    'id' => $news_id, 'price' => $news_data['price'],
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

    public function getProductsByID($product_ids)
    {
        $result = null;

        $product = $this->select("select * from product where id in ($product_ids)");
        if (!empty($product)) {
            $result = $product;
        }
        return $result;
    }

    public function createHistory($count, $price, $user_id)
    {
        return $this->insert("insert into history (count, price, user_id) values  (:count, :price, :user_id)", [
            'count' => $count,
            'price' => $price,
            'user_id' => $user_id
        ]);
    }

    public function getHistory($user_id = null)
    {
        $result = null;

        if (isset($user_id)) {
            $news = $this->select('select history.id, history.price, history.count, history.date_create, users.login 
                                        from history left join users on users.id = history.user_id
                                        where history.user_id = :user_id', [
                'user_id' => $user_id
            ]);

        } else {
            $news = $this->select('select history.id, history.price, history.count, history.date_create, users.login from history left join users on users.id = history.user_id');
        }
        if (!empty($news)) {
            $result = $news;
        }
        return $result;
    }
}