<?php

/* @var $this yii\web\View */
/* @var $currencies array */

?>
<div class="container main-container xxx-main-container ">
    <div class="xxx-top-content xxx-top-content--bg-transparent xxx-top-content--p-b-20 ">
        <div class="xxx-container">
            <div class="xxx-top-content__inner">
                <div class="xxx-currency-grid xxx-currency-grid--alt-grid">
                    <div class="xxx-currency-grid__block xxx-currency-grid__block--separately">
                        <div class="xxx-line-h-1 xxx-mb-15"><a href="https://bankiros.ru/converter"
                                                               class="xxx-text-bold xxx-fs-18 xxx-g-link xxx-g-link--no-bd">Конвертер валют
                                ЦБ РФ</a></div>
                        <div class="xxx-tab-list-wrap xxx-tab-list-wrap--pt-0 xxx-tab-list-wrap--only-border-light xxx-mb-15">
                            <ul class="xxx-tab__list xxx-tab__list--fix-scrollbar xxx-tab__list--overflow-auto">
                                <li class="xxx-tab__item xxx-tab__item--p-b-5 active" data-tab="today"><span
                                            class="xxx-fs-14"> Сегодня </span></li>
                            </ul>
                        </div>
                        <div class="xxx-tab__content">
                            <div class="xxx-tab__body active">
                                <div class="blk-grid-content blk-grid-content--gap-10 ">
                                    <?php foreach ($currencies as $currency): ?>
                                        <div class="xxx-input-converter">
                                            <input type="number" name="currency-name-<?php echo $currency[ 'code' ] ?>"
                                                   class="xxx-input-converter__input xxx-full-width"
                                                   data-code="<?php echo $currency[ 'code' ] ?>"
                                                   value="<?php echo $currency[ 'amount' ] ?>">
                                            <span class="xxx-input-converter__before-text"><?php echo $currency[ 'code' ] ?></span>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
