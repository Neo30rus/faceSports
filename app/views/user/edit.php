<?php
/** @var array $sidebar - Меню */
/** @var array $news - Новость */
?>
<div class="page">
    <div class="container">
        <div class="cabinet_wrapped">
            <div class="cabinet_sidebar">
                <?php if (!empty($sidebar)) : ?>
                    <div class="menu_box">
                        <ul>
                            <?php foreach ($sidebar as $link) : ?>
                                <li>
                                    <a href="<?= $link['link'] ?>"><?= $link['title'] ?></a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>
            </div>
            <div class="cabinet_content">
                <dib class="page-content-inner">
                    <h2>Редактирование пользователя</h2>
                    <form method="post" name="news_add_form">
                        <div class="news_add_form">
                            <div class="alert alert-danger <?= !empty($error_message) ? null : 'hidden' ?>">
                                <?= !empty($error_message) ? $error_message : null ?>
                            </div>
                            <?php if (!empty($user)): ?>
                                <div class="input_box">
                                    <label for="field_username">Имя</label>
                                    <input type="text"
                                           name="user[username]"
                                           id="field_username"
                                           class="form-control"
                                           maxlength="120"
                                           value="<?= !empty($_POST['user']['username'])
                                               ? $_POST['user']['username']
                                               : (!empty($user['username']) ? $user['username'] : '') ?>"
                                           placeholder="Введите имя"
                                    >
                                </div>

                                <div class="input_box">
                                    <label for="field_login">Логин</label>
                                    <input type="text"
                                           name="user[login]"
                                           id="field_login"
                                           class="form-control"
                                           maxlength="120"
                                           value="<?= !empty($_POST['user']['login'])
                                               ? $_POST['user']['login']
                                               : (!empty($user['login']) ? $user['login'] : '')
                                           ?>"
                                           placeholder="Введите логин"
                                    >
                                </div>


                                <div class="input_box">
                                    <label for="field_is_admin">Сделать админом</label>
                                    <input type="checkbox"
                                           name="user[is_admin]"
                                           id="field_is_admin"
                                        <?= !empty($_POST['user']['is_admin'])
                                            ? 'checked'
                                            : (!empty($user['is_admin']) ? 'checked' : '')
                                        ?>
                                           value="1"

                                    >
                                </div>
                                <div class="button_box">
                                    <button type="submit"
                                            name="btn_user_edit_form"
                                            id="btnNewsEditForm"
                                            class="btn btn-primary"
                                            value="1"
                                    >Редактировать
                                    </button>
                                </div>
                            <?php endif; ?>
                        </div>
                    </form>
                </dib>
            </div>
        </div>
    </div>
</div>