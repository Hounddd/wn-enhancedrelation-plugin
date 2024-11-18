<?php
$fieldOptions = $field->options();
$checkedValues = (array) $field->value;
$readOnly = $this->previewMode || $field->readOnly || $field->disabled;
$displayTree = $field->getConfig('displayTree', false);
$quickTreeActions = $displayTree ? $field->getConfig('quickTreeActions', false) : false;
$isScrollable = count($fieldOptions) > 10 || $displayTree;
$quickselectEnabled = $field->getConfig('quickselect', $isScrollable);
?>
<!-- Checkbox List -->
<?php if ($readOnly && $field->value): ?>

    <div class="field-checkboxlist">
        <?php
        $index = 0;
        foreach ($fieldOptions as $value => $option):
            $index++;
            $checkboxId = 'checkbox_'.$field->getId().'_'.$index;
            if (!in_array($value, $checkedValues)) {
                continue;
            }
            if (!is_array($option)) {
                $option = [$option];
            }
            ?>

            <div class="checkbox custom-checkbox">
                <input
                    type="checkbox"
                    id="<?= $checkboxId ?>"
                    name="<?= $field->getName() ?>[]"
                    value="<?= e($value) ?>"
                    disabled="disabled"
                    checked="checked">

                <label for="<?= $checkboxId ?>">
                    <?= e(trans($option[0])) ?>
                </label>
                <?php if (isset($option[1])): ?>
                    <p class="help-block"><?= e(trans($option[1])) ?></p>
                <?php endif ?>
            </div>
        <?php endforeach ?>
    </div>

<?php elseif (count($fieldOptions)): ?>

    <div class="field-checkboxlist <?= $isScrollable ? 'is-scrollable' : '' ?>">
        <?php if ($quickselectEnabled || $quickTreeActions): ?>
            <div class="checkboxlist-controls">
                <?php if ($quickselectEnabled): ?>
                <!-- Quick selection -->
                <div>
                    <a href="javascript:;" data-field-checkboxlist-all>
                        <i class="icon-check-square"></i> <?= e(trans('backend::lang.form.select_all')) ?>
                    </a>
                </div>
                <div>
                    <a href="javascript:;" data-field-checkboxlist-none>
                        <i class="icon-eraser"></i> <?= e(trans('backend::lang.form.select_none')) ?>
                    </a>
                </div>
                <?php endif ?>
                <?php if ($quickTreeActions): ?>
                <!-- Quick tree actions -->
                <div>
                    <a href="javascript:;" data-field-checkboxlist-expand-all>
                        <i class="icon-plus-square-o"></i> <?= e(trans('hounddd.enhancedrelationformwidget::lang.form.expand_all')) ?>
                    </a>
                </div>
                <div>
                    <a href="javascript:;" data-field-checkboxlist-expand-checked>
                        <i class="icon-check-square-o"></i> <?= e(trans('hounddd.enhancedrelationformwidget::lang.form.expand_checked')) ?>
                    </a>
                </div>
                <div>
                    <a href="javascript:;" data-field-checkboxlist-collapse-all>
                        <i class="icon-minus-square-o"></i> <?= e(trans('hounddd.enhancedrelationformwidget::lang.form.collapse_all')) ?>
                    </a>
                </div>
                <?php endif ?>
            </div>
        <?php endif ?>

        <div class="field-checkboxlist-inner">

            <?php if ($isScrollable): ?>
                <!-- Scrollable Checkbox list -->
                <div class="field-checkboxlist-scrollable">
                    <div class="control-scrollbar" data-control="scrollbar">
            <?php endif ?>

            <input
                type="hidden"
                name="<?= $field->getName() ?>"
                value="0" />

            <?php
            if ($displayTree) :
                $index = 1;
                $level = -1;

                function renderCheckboxLine(
                    $field,
                    array $checkedValues,
                    array $fieldOptions,
                    bool $readOnly,
                    int &$index,
                    int $level = 0
                ) {
                    $level++;

                    foreach ($fieldOptions as $value => $option) :
                        $index++;
                        $checkboxId = 'checkbox_'. $field->getId() .'_'. $index;

                        if (!is_array($option)) {
                            $option = [$option];
                        }
                        ?>

                        <div class="checkboxlist-item">

                            <div class="checkbox custom-checkbox">

                                <input
                                    type="checkbox"
                                    id="<?= $checkboxId ?>"
                                    name="<?= $field->getName() ?>[]"
                                    value="<?= e($value) ?>"
                                    <?= $readOnly ? 'disabled="disabled"' : '' ?>
                                    <?= in_array($value, $checkedValues) ? 'checked="checked"' : '' ?>>

                                <label for="<?= $checkboxId ?>">
                                    <?= e(trans($option['name'])) ?>
                                </label>
                            </div>

                            <?php if (is_array($option['children']) && count($option['children']) > 0) : ?>
                                <a href="javascript:;" class="checkboxlist-item-expand-collapse">
                                    <i class="icon-chevron-right"></i>
                                </a>
                            <?php endif ?>

                            <?php if (is_array($option['children']) && count($option['children']) > 0) : ?>
                                <div class="checkboxlist-children">
                                    <div id="<?= $checkboxId ?>_children">
                                        <?php
                                            e(renderCheckboxLine($field, $checkedValues, $option['children'], $readOnly, $index, $level));
                                        ?>
                                    </div>
                                </div>
                            <?php endif ?>
                        </div>
                        <?php
                    endforeach;
                }

                renderCheckboxLine($field, $checkedValues, $fieldOptions, $readOnly, $index, $level);
            ?>

            <?php else :
                $index = 0;
                foreach ($fieldOptions as $value => $option):
                    $index++;
                    $checkboxId = 'checkbox_'.$field->getId().'_'.$index;
                    if (!is_array($option)) {
                        $option = [$option];
                    }
                    ?>

                    <div class="checkbox custom-checkbox">
                        <input
                            type="checkbox"
                            id="<?= $checkboxId ?>"
                            name="<?= $field->getName() ?>[]"
                            value="<?= e($value) ?>"
                            <?= $readOnly ? 'disabled="disabled"' : '' ?>
                            <?= in_array($value, $checkedValues) ? 'checked="checked"' : '' ?>>

                        <label for="<?= $checkboxId ?>">
                            <?= e(trans($option[0])) ?>
                        </label>
                        <?php if (isset($option[1])): ?>
                            <p class="help-block"><?= e(trans($option[1])) ?></p>
                        <?php endif ?>
                    </div>
                <?php endforeach ?>
            <?php endif ?>

            <?php if ($isScrollable): ?>
                    </div>
                </div>
            <?php endif ?>

        </div>

    </div>

<?php else: ?>

    <!-- No options specified -->
    <?php if ($field->placeholder): ?>
        <p><?= e(trans($field->placeholder)) ?></p>
    <?php endif ?>

<?php endif ?>