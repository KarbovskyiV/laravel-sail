<?php

namespace App\Livewire;

use App\Livewire\Forms\CompanyForm;
use App\Models\City;
use App\Models\Company;
use App\Models\Country;
use Illuminate\Support\Collection;
use Livewire\Component;

class CompanyEdit extends Component
{
    public CompanyForm $form;
    public Collection $countries;
    public Collection $cities;
    public Company $company;

    public string $savedName = '';

    public function mount(Company $company)
    {
        $this->form->name = $company->name;
        $this->form->country = $company->country_id;
        $this->cities = City::where('country_id', $this->form->country)->get();
        $this->form->city = $company->city_id;

        $this->countries = Country::all();
    }

    public function updated($property)
    {
        if ($property == 'country') {
            $this->cities = City::where('country_id', $this->form->country)->get();
            $this->form->city = $this->cities->first()->id;
        }
    }

    public function render()
    {
        return view('livewire.company-edit')
            ->title('Edit Company ' . $this->form->name);
    }

    public function save(): void
    {
        $this->validate();

        $this->company->update([
            'name' => $this->form->name,
            'country_id' => $this->form->country,
            'city_id' => $this->form->city
        ]);

        $this->savedName = $this->form->name;
    }
}
