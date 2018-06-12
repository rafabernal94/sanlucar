<?php

class RegistrarFormCest
{

    public function _before(\FunctionalTester $I)
    {
        $I->amOnPage(['/usuarios/registrar']);
    }

    public function abrirPaginaRegistro(\FunctionalTester $I)
    {
        $I->see('Regístrate', 'h3');
    }

    public function enviarFormVacio(\FunctionalTester $I)
    {
        $I->submitForm('#form-registro', []);
        $I->expectTo('see validations errors');
        $I->see('Regístrate', 'h3');
        $I->see('Nombre no puede estar vacío.');
        $I->see('Apellido no puede estar vacío.');
        $I->see('Correo electrónico no puede estar vacío.');
        $I->see('Contraseña no puede estar vacío.');
        $I->see('Confirma tu contraseña no puede estar vacío.');
    }

    public function enviarFormConContraseñasDiferentes(\FunctionalTester $I)
    {
        $I->submitForm('#form-registro', [
            'Usuarios[nombre]' => 'Rafael',
            'Usuarios[apellido]' => 'Bernal',
            'Usuarios[email]' => 'rafabernalromero@gmail.com',
            'Usuarios[password]' => 'rafa12345',
            'Usuarios[passwordRepeat]' => 'rafa-12345',
        ]);
        $I->expectTo('ver las contraseñas deben ser iguales');
        $I->dontSee('Nombre no puede estar vacío.', '.help-inline');
        $I->dontSee('Apellido no puede esstar vacío.', '.help-inline');
        $I->dontSee('Correo electrónico no puede estar vacío.', '.help-inline');
        $I->dontSee('Correo electrónico no puede estar vacío.', '.help-inline');
        $I->see('Las contraseñas deben ser iguales');
    }

    public function enviarFormCorrecto(\FunctionalTester $I)
    {
        $I->submitForm('#form-registro', [
            'Usuarios[nombre]' => 'Rafael',
            'Usuarios[apellido]' => 'Bernal',
            'Usuarios[email]' => 'rafabernalromero@gmail.com',
            'Usuarios[password]' => 'rafa12345',
            'Usuarios[passwordRepeat]' => 'rafa12345',
        ]);
        $I->dontSeeElement('#form-registro');
        $I->see('Se ha enviado un email a su correo electrónico para confirmar la cuenta.');
        $I->see('Iniciar sesión', 'h3');
    }
}
