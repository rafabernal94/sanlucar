<?php

namespace app\helpers;

use kartik\dialog\Dialog;

/**
 * Helper con métodos para utilizarlos en diferentes partes de la aplicación.
 */
class Utiles
{
    /**
     * Devuelve un modal de confirmación.
     * @param  string $titulo Título del modal
     * @return Dialog El modal
     */
    public static function modal($titulo)
    {
        return Dialog::widget([
            'overrideYiiConfirm' => true,
            'options' => [
                'size' => Dialog::SIZE_LARGE,
                'type' => Dialog::TYPE_DANGER,
                'title' => $titulo,
                'btnOKClass' => 'btn-danger',
                'btnOKLabel' => '<i class="glyphicon glyphicon-ok-sign"></i> Confirmar',
                'btnCancelLabel' => '<i class="glyphicon glyphicon-remove-sign"></i> Cancelar',
            ],
        ]);
    }
}
