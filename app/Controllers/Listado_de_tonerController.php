<?php

namespace App\Controllers;

use App\core\SessionManager;
use App\core\Token;
use App\core\DB;
use App\core\Request;
use App\core\Redirect;
use App\core\ArtifyStencil;
use Docufy;

class Listado_de_tonerController {
    public $token;

    public function __construct()
    {
        SessionManager::startSession();
        $Sesusuario = SessionManager::get('usuario');
        if (!isset($Sesusuario)) {
            Redirect::to("login");
        }
        $this->token = Token::generateFormToken('send_message');   
    }

    public function Listado_de_Toner(){
        $autoSuggestion = false;
        
        Redirect::areaProtegida("Listado_de_Toner", "modulos");
        $settings["script_url"] = $_ENV['URL_ArtifyCrud'];
        $_ENV["url_artify"] = "artify/artifycrud.php";
        $settings["url_artify"] = $_ENV["url_artify"];
        $settings["downloadURL"] = $_ENV['DOWNLOAD_URL'];
        $settings["hostname"] = $_ENV['DB_HOST'];
        $settings["database"] = $_ENV['DB_NAME'];
        $settings["username"] = $_ENV['DB_USER'];
        $settings["password"] = $_ENV['DB_PASS'];
        $settings["dbtype"] = $_ENV['DB_TYPE'];
        $settings["characterset"] = $_ENV["CHARACTER_SET"];
        
        $artify = DB::ArtifyCrud(false, "", "", $autoSuggestion, $settings);
        $queryfy = $artify->getQueryfyObj();
            
        $artify->addCallback("before_insert", [$this, "before_insert_listado_de_toner"]);
        $artify->addCallback("after_insert", [$this, "after_insert_listado_de_toner"]);
        $artify->addCallback("before_update", [$this, "before_update_listado_de_toner"]);
        $artify->addCallback("after_update", [$this, "after_update_listado_de_toner"]);
        $artify->addCallback("before_delete", [$this, "before_delete_listado_de_toner"]);
        $artify->addCallback("after_delete", [$this, "after_delete_listado_de_toner"]);
        $artify->setSearchCols(array("id_listado_de_toner", "nombre", "cantidad", "fecha_ingreso"));
        $artify->crudTableCol(array("id_listado_de_toner", "nombre", "cantidad", "fecha_ingreso"));
        $artify->fieldTypes("nombre", "input");
        $artify->fieldTypes("cantidad", "input");
        $artify->fieldTypes("fecha_ingreso", "date");
        $artify->tableColFormatting("fecha_ingreso", "date", array("format" =>"d/m/Y"));
                        
        $artify->formFields(array("nombre", "cantidad", "fecha_ingreso"));
    
        $artify->editFormFields(array("id_listado_de_toner", "nombre", "cantidad", "fecha_ingreso"));
                
        $artify->addFilter('filterAddnombre', 'Filtrar por Nombre', 'nombre', 'dropdown');
        $artify->setFilterSource('filterAddnombre', 'listado_de_toner', 'nombre', 'nombre as pl', 'db');
    
        $artify->addFilter('filterAddfecha_ingreso', 'Filtrar por Fecha ingreso', 'fecha_ingreso', 'date');
        $artify->setFilterSource('filterAddfecha_ingreso', 'listado_de_toner', 'fecha_ingreso', 'fecha_ingreso as pl', 'db');
                            
        $artify->colRename("id_listado_de_toner", "ID");
        $artify->fieldRenameLable("id_listado_de_toner", "ID");
        $artify->tableHeading('Listado de Toner');
        $artify->setSettings("actionFilterPosition", "top");
        $artify->dbOrderBy("id_listado_de_toner", "ASC");
        $artify->currentPage(1);
        $artify->setSettings("actionBtnPosition", "right");
        $artify->setSettings('editbtn', true);
        $artify->setSettings('delbtn', true);
        $artify->buttonHide("submitBtnSaveBack");
        $artify->setSettings('pdfBtn', true);
        $artify->setSettings('csvBtn', true);
        $artify->setSettings('excelBtn', true);
        $artify->setSettings('inlineEditbtn', false);
        $artify->setSettings('hideAutoIncrement', false);
        $artify->setSettings('actionbtn', true);
        $artify->setSettings('function_filter_and_search', true);
        $artify->setSettings('searchbox', true);
        $artify->setSettings('clonebtn', true);
        $artify->setSettings('checkboxCol', true);
        $artify->setSettings('deleteMultipleBtn', true);
        $artify->setSettings('refresh', false);
        $artify->setSettings('addbtn', true);
        $artify->setSettings('encryption', true);
        $artify->setSettings('required', true);
        $artify->setSettings('pagination', true);
        $artify->setSettings('numberCol', true);
        $artify->setSettings('recordsPerPageDropdown', true);
        $artify->setSettings('totalRecordsInfo', true);
        $artify->setLangData('no_data', 'No hay Toner para mostrar');
        $artify->recordsPerPage(10);
        $artify->setSettings('template', 'template_listado_de_toner');
        $render = $artify->dbTable('listado_de_toner')->render();

        $stencil = new ArtifyStencil();
        echo $stencil->render('listado_de_toner', ['render' => $render]);
    }

    public function before_insert_listado_de_toner($data, $obj) {
        return $data;
    }


    public function after_insert_listado_de_toner($data, $obj) {
        return $data;
    }


    public function before_update_listado_de_toner($data, $obj) {
        return $data;
    }


    public function after_update_listado_de_toner($data, $obj) {
        return $data;
    }


    public function before_delete_listado_de_toner($data, $obj) {
        return $data;
    }


    public function after_delete_listado_de_toner($data, $obj) {
        return $data;
    }
}