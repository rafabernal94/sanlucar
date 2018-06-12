<?php

class InicioCest
{

    public function abrirPaginaLogin(\FunctionalTester $I)
    {
        $I->amOnPage(['/site/index']);
        $I->see('Usuarios registrados', 'strong');
        $I->see('Trayectos publicados', 'strong');
        $I->seeLink('Iniciar sesión');
        $I->seeLink('Regístrate');
        $I->click('Iniciar sesión');
        $I->see('Iniciar sesión', 'h3');
    }
}
