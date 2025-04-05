<?php

namespace App\Livewire;

use App\Models\City;
use App\Models\Company;
use App\Models\Country;

use Illuminate\Support\Collection;
use Livewire\Attributes\Validate;
use Livewire\Component;

class CompanyCreate extends Component
{
    public Collection $countries;

    #[Validate('required|min:3', onUpdate: false)]
    public string $name = '';

    #[Validate('required', onUpdate: false)]
    public string $country = '';

    #[Validate('required', onUpdate: false)]
    public string $city = '';

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
            $this->cities = City::where('country_id', $this->country)->get();
            $this->city = $this->cities->first()->id;
        }
    }

    public function save(): void
    {
        $this->validate();

        Company::create([
            'name' => $this->name,
            'country_id' => $this->country,
            'city_id' => $this->city
        ]);

        $this->savedName = $this->name;

        $this->reset('name', 'country', 'city');
        $this->cities = collect([]);
    }

    public function render()
    {
        return view('livewire.company-create');
    }
}
