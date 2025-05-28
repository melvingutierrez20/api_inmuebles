<?php
namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use PDO;

class PropietarioController
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
        $stmt = $this->db->query("SELECT * FROM Propietarios");
        $propietarios = $stmt->fetchAll();
        
        $response->getBody()->write(json_encode($propietarios));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function getById(Request $request, Response $response, array $args): Response
    {
        $stmt = $this->db->prepare("SELECT * FROM Propietarios WHERE idPropietario = ?");
        $stmt->execute([$args['id']]);
        $propietario = $stmt->fetch();
        
        if (!$propietario) {
            $response->getBody()->write(json_encode(['error' => 'Propietario no encontrado']));
            return $response->withStatus(404);
        }
        
        $response->getBody()->write(json_encode($propietario));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function create(Request $request, Response $response): Response
    {
        $data = $request->getParsedBody();
        
        $stmt = $this->db->prepare(
            "INSERT INTO Propietarios 
            (nombres, apellidos, fechaNacimiento, genero, telefono, email) 
            VALUES (?, ?, ?, ?, ?, ?)"
        );
        
        $stmt->execute([
            $data['nombres'],
            $data['apellidos'],
            $data['fechaNacimiento'],
            $data['genero'],
            $data['telefono'],
            $data['email']
        ]);

        $response->getBody()->write(json_encode([
            'id' => $this->db->lastInsertId(),
            'message' => 'Propietario creado exitosamente'
        ]));
        
        return $response->withStatus(201);
    }
}