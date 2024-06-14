<?php

namespace Database\Factories;

use App\Models\Pegawai;
use Illuminate\Database\Eloquent\Factories\Factory;

class PegawaiFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Pegawai::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nama' => $this->faker->name,
            'posisi' => $this->faker->jobTitle,
            'tanggal_lahir' => $this->faker->date,
            'foto' => 'default.jpg' // Ubah nama file foto default sesuai kebutuhan
        ];
    }
}
