<?php

class Conexion
{

	static public function conectar()
	{

		/* CONEXION CON EL HOSTING DIRIS LIMA SUR - MYSQL */

/*  		$link = new PDO(
			"mysql:host=localhost;dbname=dirislim_monitoreocovid19",
			"dirislim_7rhm9W9W",
			"VEDADWddlTECaEXj"
		);
		$link->exec("set names utf8");  */


/* CONEXION CON LA BASE DE DATOS LOCAL - MYSQL */

		$link = new PDO(
			"mysql:host=localhost;dbname=dirislim_visita",
			"root",
			"");
		$link->exec("set names utf8");

/* CONEXION CON LA BASE DE DATOS LOCAL - SQL SERVER*/

		/* $link = new PDO('sqlsrv:Server=SERV-APP-DIRISL;Database=dirislim_visita', 'sa', 'D3s4rr0ll0');
		$link->exec("set names utf8"); */

		return $link;
	}
}

// Uso de la clase para probar la conexión
try {
    $conexion = Conexion::conectar();
    echo "Conexión exitosa a la base de datos.";
    // Realiza operaciones en la base de datos aquí
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
    // Maneja el error de conexión aquí
}