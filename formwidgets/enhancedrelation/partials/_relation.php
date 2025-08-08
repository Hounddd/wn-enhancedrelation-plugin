<div
    id="<?= $this->getId() ?>"
    data-control="relation"
    class="relation-widget"
>
    <?= $this->makePartial('$/hounddd/enhancedrelation/formwidgets/enhancedrelation/partials/_field_'.$field->type.'.php', ['field' => $field]) ?>
</div>
