<div class="relation-widget" id="<?= $this->getId() ?>">
    <?= $this->makePartial('$/hounddd/enhancedrelation/formwidgets/enhancedrelation/partials/_field_'.$field->type.'.php', ['field' => $field]) ?>
</div>
