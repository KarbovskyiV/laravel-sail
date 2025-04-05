<?php

namespace App\Livewire;

use App\Livewire\Forms\CompanyForm;
use App\Models\City;
use App\Models\Company;
use App\Models\Country;
use Illuminate\Support\Collection;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Create Company')]
class CompanyCreate extends Component
{
    public CompanyForm $form;
    public Collection $countries;

    public Collection $cities;
    public string $savedName = '';

    public function mount()
    {
        $this->countries = Country::all();
        $this->cities = collect([]);
    }

    public function updated($property)
    {
        if ($property == 'country') {
            $this->cities = City::where('country_id', $this->form->country)->get();
            $this->form->city = $this->cities->first()->id;
        }
    }

    public function save(): void
    {
        $this->validate();

        // If your DB field names are the same as form properties
        Company::create(
            $this->form->all()
        );

        $this->savedName = $this->form->name;

        $this->reset('name', 'country', 'city');
        $this->cities = collect([]);
    }

    public function render()
    {
        return view('livewire.company-create');
    }
}
