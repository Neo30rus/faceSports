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
                    <h2>Каталог</h2>
                    <div class="news-block">
                        <div class="links_box text-end">
                            <a href="/product/add">Добавить</a>
                        </div>
                        <?php if (!empty($news)) : ?>
                        <div class="news-list">
                            <?php foreach ($news as $item) :?>
                                <div class="news-item">
                                    <h3>
                                        <?=$item['title']?><span> от <?= date('d.m.Y H:i:s',strtotime($item['date_create']))?></span>
                                        <?php if ($role === UserOperations::RoleAdmin) :?>
                                        (<a href="/product/edit?product_id=<?=$item['id']?>">редактировать</a>
                                            <a href="/product/delete?product_id=<?=$item['id']?>">Удалить</a>)
                                        <?php endif ?>
                                        <a href="/product/addcard?product_id=<?=$item['id']?>">добавить корзину</a>
                                    </h3>
                                    <img src="/product/img?product_id=<?=$item['id']?>" width="300px" alt="">
                                    <div class="news-short_description"><?=$item['short_description']?></div>
                                    <div class="news-description"><?=$item['description']?></div>
                                    <div class="news-description"><?=$item['price']?></div>
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