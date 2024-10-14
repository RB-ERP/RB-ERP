<?php

namespace Database\Factories;

use App\Models\Barang;
use Illuminate\Database\Eloquent\Factories\Factory;

class BarangFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Barang::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nama_barang' => $this->faker->word() . ' ' . $this->faker->company(),
            'kode_barang' => 'BR-' . strtoupper($this->faker->unique()->bothify('???###')),
            'serial_number' => strtoupper($this->faker->unique()->bothify('SN#########')),
            'tanggal_pembelian' => $this->faker->date('Y-m-d', 'now'),
            'spesifikasi' => $this->faker->sentence(6),
            'harga' => $this->faker->numberBetween(1000000, 20000000),
            'status' => $this->faker->randomElement(['Tersedia', 'Rusak', 'Diperbaiki']),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
