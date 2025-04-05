<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;

class CompanyForm extends Form
{
    #[Validate('required|min:3', onUpdate: false)]
    public string $name = '';

    #[Validate('required', onUpdate: false)]
    public string $country = '';

    #[Validate('required', onUpdate: false)]
    public string $city = '';
}
