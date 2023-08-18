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
                    <h2>Корзина</h2>
                    <div class="news-block">
                        <div class="links_box text-end">
                            <a href="/product/add">Добавить</a>
                        </div>
                        <?php if (!empty($card)) : ?>
                        <div class="news-list">
                            <?php foreach ($card as $item) :?>
                                <div class="news-item">
                                    <h3>
                                        <?=$item['title']?><span> от <?= date('d.m.Y H:i:s',strtotime($item['date_create']))?></span>
                                    </h3>
                                    <div class="news-short_description"><?=$item['short_description']?></div>
                                    <div class="news-description"><?=$item['description']?></div>
                                    <div class="news-description"><?=$item['price']?></div>
                                    <div class="news-description"><?=$item['count']?></div>
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