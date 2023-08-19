<?php

namespace app\controllers;

use app\core\InitController;
use app\lib\UserOperations;
use app\models\NewsModels;

class ProductController extends InitController
{
    public function behaviors()
    {
        return [
            'access' => [
                'rules' => [
                    [
                        'actions' => ['list', 'addcard', 'card', 'cash', 'history', 'img'],
                        'roles' => [UserOperations::RoleUser, UserOperations::RoleAdmin],
                        'matchCallback' => function () {
                            $this->redirect('/user/login');
                        }
                    ],
                    [
                        'actions' => ['add', 'edit'],
                        'roles' => [UserOperations::RoleAdmin],
                        'matchCallback' => function () {
                            $this->redirect('/product/list');
                        }
                    ],
                    [
                        'actions' => ['global'],
                        'roles' => [UserOperations::RoleAdmin],
                        'matchCallback' => function () {
                            $this->redirect('/product/history');
                        }
                    ],
                ]
            ]
        ];
    }

    public function actionList()
    {
        $this->view->title = 'Каталог';
        $news_model = new NewsModels();
        $news = $news_model->getListNews();

        $this->render('list', [
            'sidebar' => UserOperations::getMenuLinks(),
            'news' => $news,
            'role' => UserOperations::getRoleUser(),
        ]);
    }

    public function actionAdd()
    {
        $this->view->title = 'Добавление товара';
        $error_message = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['btn_news_add_form'])) {
            $news_data = !empty($_POST['news']) ? $_POST['news'] : null;
            $news_data['file'] = !empty($_FILES['file']) ? $_FILES['file'] : null;
            if (!empty($news_data)) {
                $userModel = new NewsModels();
                $result_add = $userModel->add($news_data);
                if ($result_add['result']) {
                    $this->redirect('/product/list');
                } else {
                    $error_message = $result_add['error_message'];
                }
            }
        }

        $this->render('add', [
            'sidebar' => UserOperations::getMenuLinks(),
            'error_message' => $error_message
        ]);
    }

    public function actionEdit()
    {
        $this->view->title = 'Редактирование товара';
        $news_id = !empty($_GET['product_id']) ? $_GET['product_id'] : null;
        $news = null;
        $error_message = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['btn_news_edit_form'])) {
            $news_data = !empty($_POST['news']) ? $_POST['news'] : null;

            if (!empty($news_data)) {
                $newsModel = new NewsModels();
                $result_edit = $newsModel->edit($news_id, $news_data);
                if ($result_edit['result']) {
                    $this->redirect('/product/list');
                } else {
                    $error_message = $result_edit['error_message'];
                }
            }
        }

        if (!empty($news_id)) {
            $news_model = new NewsModels();
            $news = $news_model->getNewsById($news_id);
            if (empty($news)) {
                $error_message = 'Товар не найден!';
            }
        } else {
            $error_message = 'Отсутствует идентификатор записи!';
        }

        $this->render('edit', [
            'sidebar' => UserOperations::getMenuLinks(),
            'news' => $news,
            'error_message' => $error_message
        ]);
    }

    public function actionDelete()
    {
        $this->view->title = 'Удаление товара';
        $news_id = !empty($_GET['product_id']) ? $_GET['product_id'] : null;
        $news = null;
        $error_message = '';

        if (!empty($news_id)) {
            $news_model = new NewsModels();
            $news = $news_model->getNewsById($news_id);
            if (!empty($news)) {
                $result_delete = $news_model->deleteById($news_id);
                if ($result_delete['result']) {
                    $this->redirect('/product/list');
                } else {
                    $error_message = $result_delete['error_message'];
                }
            } else {
                $error_message = 'Новость не найдена!';
            }
        } else {
            $error_message = 'Отсутствует идентификатор записи!';
        }

        $this->render('delete', [
            'sidebar' => UserOperations::getMenuLinks(),
            'news' => $news,
            'error_message' => $error_message
        ]);
    }

    public function actionAddcard()
    {
        $this->view->title = 'Добавление товара в корзину';
        $product_id = !empty($_GET['product_id']) ? $_GET['product_id'] : null;
        $error_message = '';
        if (!empty($product_id)) {
            $_SESSION["user"]['card'][] = $product_id;
            $this->redirect('/product/list');
        } else {
            $error_message = 'Отсутствует идентификатор записи!';
        }
        $this->render('delete', [
            'sidebar' => UserOperations::getMenuLinks(),
            'error_message' => $error_message

        ]);
    }

    public function actionCard()
    {
        $this->view->title = 'Корзина';
        $error_message = '';
        $product = null;
        if (!empty($_SESSION['user']['card'])) {
            $card = array_count_values($_SESSION['user']['card']);
            $productModel = new NewsModels();
            $product = $productModel->getProductsByID(implode(',', array_keys($card)));
            for ($i = 0; $i < count($product); $i++) {
                $product[$i]['count'] = $card[$product[$i]['id']];
            }

        } else {
            $error_message = 'Корзина пуста!';
        }
        $this->render('card', [
            'sidebar' => UserOperations::getMenuLinks(),
            'error_message' => $error_message,
            'card' => $product,

        ]);
    }

    public function actionCash()
    {
        $this->view->title = 'Оплата';
        $error_message = '';
        $product = null;
        if (!empty($_SESSION['user']['card'])) {
            $card = array_count_values($_SESSION['user']['card']);
            $productModel = new NewsModels();
            $product = $productModel->getProductsByID(implode(',', array_keys($card)));
            for ($i = 0; $i < count($product); $i++) {
                $product[$i]['count'] = $card[$product[$i]['id']];
            }
            $globalCount = 0;
            $globalPrice = 0;
            foreach ($product as $item) {
                $globalCount += $item['count'];
                $globalPrice += $item['price'] * $item['count'];
            }
            $productModel->createHistory($globalCount, $globalPrice, $_SESSION['user']['id']);
            $_SESSION['user']['card'] = [];
            $this->redirect('/product/card');
        } else {
            $error_message = 'Корзина пуста!';
        }
        $this->render('card', [
            'sidebar' => UserOperations::getMenuLinks(),
            'error_message' => $error_message,
            'card' => $product,

        ]);
    }

    public function actionGlobal()
    {
        $this->view->title = 'Глобальная история';
        $news_model = new NewsModels();
        $news = $news_model->getHistory();

        $this->render('history', [
            'sidebar' => UserOperations::getMenuLinks(),
            'news' => $news,
        ]);
    }

    public function actionHistory()
    {
        $this->view->title = 'История';
        $news_model = new NewsModels();
        $news = $news_model->getHistory($_SESSION['user']['id']);

        $this->render('history', [
            'sidebar' => UserOperations::getMenuLinks(),
            'news' => $news,
        ]);
    }

    public function actionImg()
    {
        $product_id = !empty($_GET['product_id']) ? $_GET['product_id'] : null;
        $news_model = new NewsModels();
        $news = $news_model->getNewsById($product_id);
        header('Content-Type: image/png');
        readfile($_SERVER['DOCUMENT_ROOT'] . $news['file_path']);
    }

}