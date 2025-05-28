<?php
namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use PDO;

class InmuebleController
{
    private $db;

    public function __construct()
    {
        $this->db = new PDO(
            "mysql:host=".DB_HOST.";dbname=".DB_NAME,
            DB_USER,
            DB_PASS,
            DB_OPTIONS
        );
    }

    public function getAll(Request $request, Response $response): Response
    {
        $stmt = $this->db->query("SELECT * FROM Inmuebles");
        $inmuebles = $stmt->fetchAll();
        
        $response->getBody()->write(json_encode($inmuebles));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function add(Request $request, Response $response): Response
    {
        $data = $request->getParsedBody();
        
        $stmt = $this->db->prepare(
            "INSERT INTO Inmuebles 
            (departamento, municipio, residencia, calle, poligono, numerocasa, idPropietario) 
            VALUES (?, ?, ?, ?, ?, ?, ?)"
        );
        
        $stmt->execute([
            $data['departamento'],
            $data['municipio'],
            $data['residencia'],
            $data['calle'],
            $data['poligono'],
            $data['numerocasa'],
            $data['idPropietario']
        ]);

        $response->getBody()->write(json_encode([
            'id' => $this->db->lastInsertId(),
            'message' => 'Inmueble creado exitosamente'
        ]));
        
        return $response->withStatus(201);
    }
}