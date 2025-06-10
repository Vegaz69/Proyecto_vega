<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function principal(): string
    {
        return view('front/principal');
    }

    public function quienesSomos(): string
    {
        return view('front/quienesSomos');
    }

    public function comercializacion(): string
    {
        return view('front/comercializacion');
    }

    public function contacto(): string
    {
        return view('front/contacto');
    }
    
    public function terminosyUsos(): string
    {
        return view('front/terminosyUsos');
    }

    public function construccion() {
    
        return view('front/construccion');
    }

}
