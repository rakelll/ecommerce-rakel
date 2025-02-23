<?php

namespace App\Livewire;

use Livewire\Component;

class ContactUsPage extends Component
{
    public $location = 'Your Location Here';
    public $address = 'Mar Takla, Baouchriyeh';
    public $phone1 = '76525715'; // First phone number
    public $phone2 = '76702514'; // Second phone number
    public $email = 'Tesec.tania@gmail.com';

    public function render()
    {
        return view('livewire.contact-us-page');
    }
}
