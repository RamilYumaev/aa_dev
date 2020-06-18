<?php

namespace modules\kladr\widgets;

use yii\base\Widget;
use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

class KladrAddressWidget extends Widget
{
    const MODE_FULL = 1;
    const MODE_SINGLE_LINE = 2;

    /** @var string */
    public $url;

    /** @var string */
    public $attributesPrefix = '';

    /** @var \yii\base\Model */
    public $model;

    /** @var ActiveForm */
    public $form;

    /** @var integer */
    public $mode = self::MODE_FULL;

    /** @var boolean */
    public $readOnly = false;

    /** @var array */
    protected $attributes = [];

    public function init()
    {
        if ($this->mode == self::MODE_FULL) {
            $this->attributes = ['postcode', 'region', 'district', 'city', 'village',
                'street', 'house', 'housing', 'building', 'flat'];
        } elseif ($this->mode == self::MODE_SINGLE_LINE) {
            $this->attributes = ['line'];
        }
    }

    public function run()
    {
        $widgetId = $this->id;

        if (!$this->readOnly) {
            echo "<div id='{$widgetId}-kladr-view' class='kladr-view'>" . PHP_EOL . '<p>' . PHP_EOL;
            echo Html::a(
                'Справочник адресов РФ',
                "#{$widgetId}-modal",
                ['class' => 'btn btn-primary', 'data-toggle' => 'modal']
            );
            echo '</p>' . PHP_EOL;
        }

        $this->prepareTextWidgets();

        if (!$this->readOnly) {
            Modal::begin(['id' => "{$widgetId}-modal"]);
            Modal::end();
            echo '</div>' . PHP_EOL;

            $this->prepareJs();
        }
    }

    protected function prepareTextWidgets()
    {
        foreach ($this->attributes as $attribute) {
            echo $this->form
                ->field($this->model, "{$this->attributesPrefix}{$attribute}")
                ->textInput(['class' => "form-control kladr-{$attribute}"]);
        }
    }

    protected function prepareJs()
    {
        $widgetId = $this->id;
        $view = $this->getView();
        $kladrWidgetUrl = Url::toRoute([$this->url, 'widgetId' => $widgetId]);
        $getPostcodeUrl = Url::toRoute($this->url.'/get-postcode');
        $singleLineMode = (int)($this->mode == self::MODE_SINGLE_LINE);

        $view->registerJs(<<<JS
        $.fn.modal.Constructor.prototype.enforceFocus = function(){}; // fix select2 + modal
(function() {
    "use strict";
    var modalBody = $("#{$widgetId}-modal div.modal-body");
    modalBody.on("change", "#{$widgetId}-select2-kladr-houses", function() {
        var houseCode = $(this).val();
        if (houseCode) {
            $.ajax({
                url: "{$getPostcodeUrl}",
                dataType: "json",
                data: {house: houseCode},
                success: function(data) {
                    if (data.postcode) {
                        $("#{$widgetId}-postcode").val(data.postcode);
                    }
                },
                error: function() {
                    alert("Произошла непредвиденная ошибка. Пожалуйста, обратитесь к администратору.");
                }
            });
        }
    });

    var kladrView = $("#{$widgetId}-kladr-view");
    $("a[data-toggle='modal']", kladrView).on("click", function() {
        modalBody.load("{$kladrWidgetUrl}");
    });

    modalBody.on("click", "button.btn-success", function() {
        var lineAddress = "";

        var postCodeData = $("#{$widgetId}-postcode").val();
        if (postCodeData) {
            if ({$singleLineMode}) {
                lineAddress += postCodeData + ", ";
            } else {
                $("input.kladr-postcode", kladrView).val(postCodeData);
            }   
        }

        var regionData = $("#{$widgetId}-select2-kladr-regions").select2("data");
        if (regionData[0].id) {
            if ({$singleLineMode}) {
                lineAddress += regionData[0].text + ", ";
            } else {
                $("input.kladr-region", kladrView).val(regionData[0].text);
            }
        }

        var districtData = $("#{$widgetId}-select2-kladr-districts").select2("data");
        if (districtData[0].id) {
            if ({$singleLineMode}) {
                lineAddress += districtData[0].text + ", ";
            } else {
                $("input.kladr-district", kladrView).val(districtData[0].text);
            }
        }

        var cityData = $("#{$widgetId}-select2-kladr-cities").select2("data");
        if (cityData[0].id) {
            if ({$singleLineMode}) {
                lineAddress += cityData[0].text + ", ";
            } else {
                $("input.kladr-city", kladrView).val(cityData[0].text);
            }
        }

        var villageData = $("#{$widgetId}-select2-kladr-villages").select2("data");
        if (villageData[0].id) {
            if ({$singleLineMode}) {
                lineAddress += villageData[0].text + ", ";
            } else {
                $("input.kladr-village", kladrView).val(villageData[0].text);
            }
        }

        var streetData = $("#{$widgetId}-select2-kladr-streets").select2("data");
        if (streetData[0].id) {
            if ({$singleLineMode}) {
                lineAddress += streetData[0].text + ", ";
            } else {
                $("input.kladr-street", kladrView).val(streetData[0].text);
            }
        }

        var houseData = $("#{$widgetId}-select2-kladr-houses").select2("data");
        if (houseData[0].id) {
            if ({$singleLineMode}) {
                lineAddress += "д. " + houseData[0].text + ", ";
            } else {
                $("input.kladr-house", kladrView).val(houseData[0].text);
            }
        }

        if ({$singleLineMode}) {
            lineAddress = lineAddress.replace(/,\s$/, "");
            $("input.kladr-line", kladrView).val(lineAddress);
        }

        $("#{$widgetId}-modal").modal("hide");
        modalBody.empty();
    });
})();
JS
        );
    }
}
