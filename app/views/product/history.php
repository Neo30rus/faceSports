<?php
/** @var array $sidebar - Меню */
/** @var string $role - Список новостей */
/** @var array $news - Роль пользователя */

use app\lib\UserOperations;

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
                    <h2>История</h2>
                    <div class="news-block">
                        <?php if (!empty($news)) : ?>
                        <div class="news-list">
                            <?php foreach ($news as $item) :?>
                                <div class="news-item">
                                    <h3>
                                        <span>Покупка от <?= date('d.m.Y H:i:s',strtotime($item['date_create']))?></span>
                                    </h3>
                                    <div class="news-description"><?=$item['count']?></div>
                                    <div class="news-description"><?=$item['price']?></div>
                                    <div class="news-description"><?=$item['login']?></div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <?php endif; ?>
                    </div>
                </dib>
            </div>
        </div>
    </div>
</div>