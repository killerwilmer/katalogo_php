<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of imagen_controller
 *
 * @author cristhianlombana
 */
class ImagenController extends ApplicationController {

    //$bd=null;
    //put your code here
    function index($categoria = 1) {
        $bd = Conexion::devolverCon();
        $row = array();
        $this->result = $bd->query("
            select i.id,i.imagen,c.nombre,i.fechaactualizacion 
            from imagen i,categoria c
            where i.categoria_id=$categoria and i.categoria_id=c.id");


        $this->combocategoria = $bd->query("select id,nombre from categoria");

        if (Input::hasPost("categoria")) {
            $this->redirect("imagen/index/" . Input::post("categoria"));
        }
    }

    function nuevo() {
        $bd = Conexion::devolverCon();
        $this->combocategoria = $bd->query("select id,nombre from categoria");

        if (Input::hasPost("categoria")) {

            $archivo = Upload::factory("imagen", "image");
            $archivo->setExtensions(array('jpg', 'png', 'jpeg'));

            $nombre = $_FILES["imagen"]["name"];

            if ($archivo->isUploaded()) {

                $archivo->overwrite(true);

                if ($archivo->save()) {


                    Load::lib("WideImage/WideImage");


                    $ruta = APP_PATH . "../public/img/upload/" . $nombre;

                    //$img = getimagesize($ruta);
                    //$ancho = $img[0];
                    //$alto = $img[1];
                    
                    $tam_ideal =900;
                    $ban =0;
                    
                    while($ban==0){
                        $img = getimagesize($ruta);
                        $ancho = $img[0];
                        $alto = $img[1];
                        
                        if($ancho<=$tam_ideal && $alto<=$tam_ideal){
                            $ban=1;
                        }
                        else{
                            $nancho = $ancho - (($ancho*10)/100);
                            $nalto = $alto - (($alto*10)/100);
                            WideImage::load($ruta)->resize($nancho, $nalto, 'fill')->saveToFile($ruta);
                        }
                    }
                    

                    /*if ($ancho > $alto) {
                        WideImage::load($ruta)->resize(800, 600, 'fill')->saveToFile($ruta);
                    } else if ($alto > $ancho) {
                        WideImage::load($ruta)->resize(600, 800, 'fill')->saveToFile($ruta);
                    } else if ($alto == $ancho) {
                        WideImage::load($ruta)->resize(800, 800, 'fill')->saveToFile($ruta);
                    }*/


                    $cover = fopen($ruta, 'rb');

                    $sql = "select tabla,autoincremental from autoincremental where tabla='imagen'";
                    $con = Conexion::devolverCon();
                    $autoinc = $con->query($sql);

                    while ($auto = $autoinc->fetchArray(SQLITE3_ASSOC)) {
                        $ultimoid = $auto["autoincremental"] + 1;
                    }

                    $sql = "insert into imagen (id,categoria_id,imagen,fechaactualizacion) values(?,?,?,?)";
                    $db = Conexion::devolverPDO();
                    $q = $db->prepare($sql);
                    $cat = Input::post("categoria");
                    $q->bindParam(1, $ultimoid);
                    $q->bindParam(2, $cat);
                    $q->bindParam(3, $cover, PDO::PARAM_LOB);
                    $fecha = Timestamp::getTimeStamp();
                    $q->bindParam(4, $fecha);
                    $q->execute();
                    $ultimoid = $db->lastInsertId();


                    //actualizar el autoincremental
                    $sql = "insert into imagensync(id,fechaactualizacion) values($ultimoid,$fecha)";
                    $db->exec($sql);

                    $sql = "update autoincremental set autoincremental=$ultimoid where tabla='imagen'";
                    $db->exec($sql);

                    $sql = "update autoincremental set autoincremental=$ultimoid where tabla='imagensync'";
                    $db->exec($sql);


                    Flash::valid('Archivo subido correctamente...!!!');
                }
            } else {
                Flash::warning('No se ha Podido Subir el Archivo...!!!');
            }
        }
    }

    function modificar($id) {
        $bd = Conexion::devolverCon();
        $this->combocategoria = $bd->query("select id,nombre from categoria");

        if (Input::hasPost("categoria")) {

            $archivo = Upload::factory("imagen", "image");
            $archivo->setExtensions(array('jpg', 'png', 'jpeg'));

            $nombre = $_FILES["imagen"]["name"];

            if ($archivo->isUploaded()) {

                $archivo->overwrite(true);

                if ($archivo->save()) {


                    Load::lib("WideImage/WideImage");

                    $ruta = APP_PATH . "../public/img/upload/" . $nombre;

                    $img = getimagesize($ruta);
                    $ancho = $img[0];
                    $alto = $img[1];

                    if ($ancho > $alto) {
                        WideImage::load($ruta)->resize(800, 600, 'fill')->saveToFile($ruta);
                    } else if ($alto > $ancho) {
                        WideImage::load($ruta)->resize(600, 800, 'fill')->saveToFile($ruta);
                    } else if ($alto == $ancho) {
                        WideImage::load($ruta)->resize(800, 800, 'fill')->saveToFile($ruta);
                    }

                    $cover = fopen($ruta, 'rb');

                    $sql = "update imagen set categoria_id=?,imagen=?,fechaactualizacion=? where id=$id";
                    $db = Conexion::devolverPDO();
                    $q = $db->prepare($sql);
                    $cat = Input::post("categoria");
                    $q->bindParam(1, $cat);
                    $q->bindParam(2, $cover, PDO::PARAM_LOB);
                    $fecha = Timestamp::getTimeStamp();
                    $q->bindParam(3, $fecha);
                    $q->execute();
                    $sql = "update imagensync set fechaactualizacion=$fecha where id=$id";
                    $db->exec($sql);


                    Flash::valid('Archivo modificado correctamente...!!!');
                }
            } else {
                Flash::warning('No se ha Podido Subir el Archivo...!!!');
            }
        }
    }

    function eliminar($id) {
        $this->id = $id;
        if (Input::hasPost("id")) {
            $bd = Conexion::devolverCon();
            $bd->exec("delete from imagen where id=" . Input::post("id"));
            $bd->exec("delete from imagensync where id=" . Input::post("id"));
            $this->redirect("imagen/index");
        }
    }

    function relacionar($idimagen, $cat = 'NINGUNA') {
        $bd = Conexion::devolverCon();
        $this->result = $bd->query("select ip.id, p.idproducto,p.descripcion 
                                    from imagen i,imagenproducto ip,misproductos p
                                    where i.id = ip.imagen_id and
                                    p.idproducto=ip.producto_id
                                    and ip.imagen_id=$idimagen");

        $this->idimagen = $idimagen;
        $this->combocategoria = $bd->query("select distinct marca from misproductos");
        $this->productos = null;


        $this->resimagen = $bd->query("select imagen from imagen where id=$idimagen");

        if (Input::hasPost("marca")) {
            $this->idimagen = Input::post("idimagen");
            $marca = Input::post("marca");
            Flash::info("Se encontraron en la categoria:$marca");
            $this->productos = $bd->query("select idproducto,descripcion from misproductos where marca='$marca'
                                        and idproducto not in (select p.idproducto
                                    from imagen i,imagenproducto ip,misproductos p
                                    where i.id = ip.imagen_id and
                                    p.idproducto=ip.producto_id
                                    and ip.imagen_id=$this->idimagen)");
        }
        if (Input::hasPost("descripcion")) {
            $this->idimagen = Input::post("idimagen");
            $descripcion = Input::post("descripcion");
            Flash::info("Se encontraron con el nombre:$descripcion");
            $this->productos = $bd->query("select idproducto,descripcion from misproductos where descripcion like '%$descripcion%'
                                        and idproducto not in (select p.idproducto
                                    from imagen i,imagenproducto ip,misproductos p
                                    where i.id = ip.imagen_id and
                                    p.idproducto=ip.producto_id
                                    and ip.imagen_id=$this->idimagen)");
        }
    }

    function hacerrelacion($idimagen) {
        View::template(null);
        $bd = Conexion::devolverCon();
        $fecha = Timestamp::getTimeStamp();


        foreach (Input::post("idproducto") as $idprod) {

            $bd->exec("insert into imagenproducto (activo,imagen_id,producto_id,fechaactualizacion)
                    values('1',$idimagen,$idprod,$fecha)");
        }


        $this->redirect("imagen/relacionar/$idimagen");
        //Flash::info("Lo hizo");
    }

    function eliminarrelacion($idimagen, $idrelacion) {
        $bd = Conexion::devolverCon();
        $bd->exec("delete from imagenproducto where id=$idrelacion");
        $this->redirect("imagen/relacionar/$idimagen");
    }

}

?>
