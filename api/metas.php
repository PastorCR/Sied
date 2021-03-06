<?php

/**
 * This class is responsible for sign up, sign in and logout.
 *
 * @copyright Copyright (c) 2014, Felipe Lunardi Farias <ffarias.dev@gmail.com>
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
require '../database/metasData.php';
require '../database/usuarioData.php';

class metas extends Rest implements interfaceApi {

    /** @var string|null Should contain the name of this class. */
    public $class = null;

    /** @var string|null Should contain a method of this API (users). */
    public $method = null;

    public function __construct($class, $method) {

        parent::__construct();

        $this->class = $class;
        $this->method = $method;
    }

    /**
     * A simple response for this API
     * @param $status  status (error, success)
     * @param $message message/response
     * @param $code    HTTP status codes (200, 201, 204, 404, 406)
     * @param $data    
     * @return object array (for test) or json (for javascript response)
     */
    public function responseAPI($status, $message, $code, $data = array()) {

        $responseApi = json_encode(array(
            "status" => $status,
            "api" => "$this->class|$this->method",
            "message" => $message,
            "data" => $data
        ));

        if (!$this->is_test) {
            $this->response($responseApi, $code);
        } else {
            return $responseApi;
        }
    }

    public function all() {
        if ($this->get_request_method() != "POST" && $this->get_request_method() != "GET") {
            return $this->responseAPI("error", "Not allowed.", 406);
        }
        if ($this->get_request_method() == "POST") {
            $body = json_decode(file_get_contents("php://input"), true);
            $id = $body['id'];
            if (array_key_exists("periodo", $body)) {
                $periodo = $body['periodo'];
                $data = metasData::getAllFromUser($id,$periodo);
                return $this->responseAPI("success", "get success!", 200, $data);
            } else {
                $data = metasData::getAllFromUserActual($id);
                return $this->responseAPI("success", "get success!", 200, $data);
            }
        } else {
            $data = metasData::getAll();
            return $this->responseAPI("success", "get success!", 200, $data);
        }
    }

    public function allFrom() {

        if ($this->get_request_method() != "POST") {
            return $this->responseAPI("error", "Not allowed.", 406);
        }

        $body = json_decode(file_get_contents("php://input"), true);

        $data = metasData::getAllFrom($body);
        return $this->responseAPI("success", "get success!", 200, $data);
    }

    public function add() {

        if ($this->get_request_method() != "POST") {
            return $this->responseAPI("error", "Not allowed.", 406);
        }

        $body = json_decode(file_get_contents("php://input"), true);

        $data = metasData::insert($body['is_Evaluable'], $body['peso'], $body['titulo'], $body['descripcion'], $body['usuario']
        );

        if ($data === true) {
            // NOTIFICACION PARA JEFE DE QUE COLABORADOR AGREGÓ META.
            return $this->responseAPI("success", "Meta agregada con éxito", 200);
        }
        return $this->responseAPI("error", "", 200);
    }

    public function del() {

        if ($this->get_request_method() != "POST") {
            return $this->responseAPI("error", "Not allowed.", 406);
        }

        $body = json_decode(file_get_contents("php://input"), true);

        $data = metasData::delete($body['id']);
        if ($data === true) {
            return $this->responseAPI("success", "Meta eliminada con éxito", 200);
        }
        return $this->responseAPI("error", "", 200);
    }

    // modifica toda la meta.
    public function set() {

        if ($this->get_request_method() != "PUT") {
            return $this->responseAPI("error", "Not allowed.", 406);
        }

        $body = json_decode(file_get_contents("php://input"), true);

        $data = metasData::update($body['is_Evaluable'], $body['titulo'], $body['descripcion'], $body['id']);
        if ($data === true) {
            return $this->responseAPI("success", "Meta actualizada con éxito", 200);
        }
        return $this->responseAPI("error", "", 200);
    }

    // modifica solo la característica 'evaluable' de la meta.
    public function setEvaluable() {

        if ($this->get_request_method() != "PUT") {
            return $this->responseAPI("error", "Not allowed.", 406);
        }

        $body = json_decode(file_get_contents("php://input"), true);

        $data = metasData::updateEvaluableMeta($body['is_Evaluable'], $body['id']);
        if ($data === true) {
            return $this->responseAPI("success", "Meta actualizada con éxito", 200);
        }
        return $this->responseAPI("error", "", 200);
    }

// Aprobar/Desaprobar meta de Jefe
    public function aprobarMeta() {

        if ($this->get_request_method() != "PUT") {
            return $this->responseAPI("error", "Not allowed.", 406);
        }

        $body = json_decode(file_get_contents("php://input"), true);
        $mensaje = "";

        if ($body['comentario'] !== "") {
            $data = metasData::desaprobarMeta($body['id'], $body['comentario']);
            $mensaje = "Meta desaprobada con éxito";
            // NOTIFICACION PARA COLABORADOR DE DESAPROBACIÓN DE META POR JEFE...
        } else {
            $data = metasData::aprobarMeta($body['id'], $body['comentario']);
            $mensaje = "Meta aprobada con éxito";
            //$usuarioNotificado = usuarioData::getUserFromMeta($body['id']);
            // NOTIFICACION PARA COLABORADOR DE APROBACIÓN DE META POR JEFE...

        }

        if ($data === true) {
            return $this->responseAPI("success", $mensaje, 200);
        }
        return $this->responseAPI("error", "", 200);
    }

// Aprobar/Desaprobar meta de RH
    public function aprobarMetaRH() {

        if ($this->get_request_method() != "PUT") {
            return $this->responseAPI("error", "Not allowed.", 406);
        }

        $body = json_decode(file_get_contents("php://input"), true);
        $mensaje = "";

        if ($body['comentario'] !== "") {
            $data = metasData::desaprobarMetaRH($body['id'], $body['comentario']);
            $mensaje = "Meta desaprobada con éxito";
            // NOTIFICACION PARA COLABORADOR DE DESAPROBACIÓN DE META POR RH..
        } else {
            $data = metasData::aprobarMetaRH($body['id'], $body['comentario']);
            $mensaje = "Meta aprobada con éxito";
            // NOTIFICACION PARA COLABORADOR DE APROBACIÓN DE META POR RH..
        }

        if ($data === true) {
            return $this->responseAPI("success", $mensaje, 200);
        }
        return $this->responseAPI("error", "", 200);
    }

    public function setEvaluacion() {

        if ($this->get_request_method() != "PUT") {
            return $this->responseAPI("error", "Not allowed.", 406);
        }

        $body = json_decode(file_get_contents("php://input"), true);

        $data = metasData::updateEvaluacion($body);
        if ($data === true) {
            // NOTIFICACION PARA COLABORADOR DE EVALUACIONES DE METAS HECHAS POR JEFE.
            return $this->responseAPI("success", "Evaluaciones ingresadas", 200);
        }
        return $this->responseAPI("error", "", 200);
    }

    public function setAuto() {

        if ($this->get_request_method() != "PUT") {
            return $this->responseAPI("error", "Not allowed.", 406);
        }

        $body = json_decode(file_get_contents("php://input"), true);
        $data = metasData::updateAuto($body);
        if ($data === true) {
            // NOTIFICACION PARA JEFE DE AUTOEVALUACIONES DE METAS HECHAS POR COLABORADOR.
            return $this->responseAPI("success", "Autoevaluaciones ingresadas", 200);
        }
        return $this->responseAPI("error", "", 200);
    }

    public function setPeso() {

        if ($this->get_request_method() != "PUT") {
            return $this->responseAPI("error", "Not allowed.", 406);
        }

        $body = json_decode(file_get_contents("php://input"), true);

        $data = metasData::updatePeso($body);
        if ($data === true) {
            return $this->responseAPI("success", "Pesos actualizados con éxito", 200);
        }
        return $this->responseAPI("error", "", 200);
    }

    public function __destruct() {
        return true;
    }

}
