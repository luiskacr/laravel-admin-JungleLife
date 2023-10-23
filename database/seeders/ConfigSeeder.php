<?php

namespace Database\Seeders;

use App\Models\Configuration;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ConfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Configuration::create([
            'name'=> 'Clientes por Tour',
            'data'=> [
                'value' => 12
            ]
        ]);
        Configuration::create([
            'name'=> 'Creacion Automatica de Tours',
            'data'=> [
                'value' => true
            ]
        ]);
        Configuration::create([
            'name'=> 'Cierre automatico de Tours',
            'data'=> [
                'value' => true
            ]
        ]);
        Configuration::create([
            'name'=> 'Prefijo de Factura',
            'data'=> [
                'value' => 'JL000'
            ]
        ]);

        Configuration::create([
            'name'=> 'Mensaje de Inicio',
            'data'=> [
                'value' => 'Siempre parece imposible... hasta que se hace - Nelson Mandela'
            ]
        ]);

        Configuration::create([
            'name'=> 'Envio de Correo Automatico de Agradecimiento',
            'data'=> [
                'value' => true
            ]
        ]);

        Configuration::create([
            'name'=> 'Envio de Correo Automatico a ',
            'data'=> [
                'value' => [
                    1 => false,
                    2 => false,
                    3 => false,
                    4 => false,
                    5 => true,
                ]
            ]
        ]);

        Configuration::create([
            'name'=> 'Mensaje del Correo de Agradecimiento',
            'data'=> [
                'value' => 'Queremos expresar nuestro agradecimiento por confiar en nosotros para crear momentos memorables y ofrecerte un servicio excepcional. Valoramos tu apoyo y la oportunidad de servirte en tu viaje. Cada cliente es importante para nosotros, y nos complace haber tenido la oportunidad de acompañarte en esta aventura.'
            ]
        ]);

        Configuration::create([
            'name'=> 'Telefono para las Facturas',
            'data'=> [
                'value' => '+506 87123340'
            ]
        ]);

        Configuration::create([
            'name'=> 'Correo Electronico para las Facturas',
            'data'=> [
                'value' => 'admin@junglelife.com'
            ]
        ]);

        Configuration::create([
            'name'=> 'Sitio Web para facturas',
            'data'=> [
                'value' => 'https://www.junglelifecr.com'
            ]
        ]);

        Configuration::create([
            'name'=> 'Facebook para facturas',
            'data'=> [
                'value' => 'https://www.facebook.com/junglelifecroficial'
            ]
        ]);

        Configuration::create([
            'name'=> 'Instagram para facturas',
            'data'=> [
                'value' => 'https://www.instagram.com/junglelife_cr/'
            ]
        ]);


    }
}
