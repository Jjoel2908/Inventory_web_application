<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Inventory</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">

        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
        <link href="../../css/main.min.css" rel="stylesheet" />


        <script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>

    </head>

    <body class="antialiased">
        <h1 class="text-danger text-center">SISTEMA DE INVENTARIO</h1>

        <!-- Aquí se mandan a traer todos los componentes que creamos con Vue -->
        <div class="container mt-5">
            <div class="row">
                <div class="col-md-12">
                    
                    <div id="empleado"></div>
                </div>
                <div class="col-md-12">
                    
                    <div id="equipo"></div>
                </div>
                <div class="col-md-12">
                    
                    <div id="asignacion"></div>
                </div>
            </div>
        </div>
        <!-- Mandamos a traer el archivo app.js para poder utilizar los componentes -->
        @vite('resources/js/app.js')
        
    </body> 
</html>
