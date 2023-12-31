<?php

require_once "conexion.php";

class ModeloRegistro
{
    /* =============================================
      MOSTRAR RANGOS DE FECHA
      ============================================= */
    static public function mdlRangoFechasRegistro($tabla, $fechaInicial, $fechaFinal)
    {

        if ($fechaInicial == null) {
            /* var_dump("NULL"); */
            $stmt = Conexion::conectar()->prepare("SELECT tap_registrovisita.id as id,
            (SELECT tipo_documento FROM tap_tipodocumento WHERE id=tap_funcionario.idtipo_documento) as TipoDocF,    
            tap_funcionario.num_documento as num_documento,
            tap_funcionario.nombre as nombre,
            tap_funcionario.cargo as cargo,
            (SELECT entidad FROM tap_entidad WHERE id=tap_funcionario.identidad) as ent_funcionario,
            tap_registrovisita.motivo as motivo,
            tap_registrovisita.servidor_publico as servidor_publico,
            tap_registrovisita.area_oficina_sp as area_oficina_sp,
            tap_registrovisita.cargo as cargo,
            /* FORMAT(CONVERT(date,tap_registrovisita.fecha_ingreso),'dd/MM/yyyy') as fecha_ingreso,
			CONVERT(varchar(25), CAST(tap_registrovisita.hora_ingreso as TIME),100) as hora_ingreso, */
            DATE_FORMAT(tap_registrovisita.fecha_ingreso, '%d/%m/%Y') as fecha_ingreso,
            TIME_FORMAT(tap_registrovisita.hora_ingreso, '%H:%i:%s') as hora_ingreso,
            DATE_FORMAT(tap_registrovisita.fecha_salida, '%d/%m/%Y') as fecha_salida,
            TIME_FORMAT(tap_registrovisita.hora_salida, '%H:%i:%s') as hora_salida,
            tap_registrovisita.usuario as usuario  
            FROM $tabla left join tap_funcionario  on 
            tap_registrovisita.idfuncionario=tap_funcionario.id 
            ORDER BY tap_registrovisita.id DESC");

            $stmt->execute();

            return $stmt->fetchAll();

        } else if ($fechaInicial == $fechaFinal) {
            /* var_dump("ELSE IF"); */
            $stmt = Conexion::conectar()->prepare("SELECT tap_registrovisita.id as id,
            (SELECT tipo_documento FROM tap_tipodocumento WHERE id=tap_funcionario.idtipo_documento) as TipoDocF,    
            tap_funcionario.num_documento as num_documento,
            tap_funcionario.nombre as nombre,
            tap_funcionario.cargo as cargo,
            (SELECT entidad FROM tap_entidad WHERE id=tap_funcionario.identidad) as ent_funcionario,
            tap_registrovisita.motivo as motivo,
            tap_registrovisita.servidor_publico as servidor_publico,
            tap_registrovisita.area_oficina_sp as area_oficina_sp,
            tap_registrovisita.cargo as cargo,
            DATE_FORMAT(tap_registrovisita.fecha_ingreso, '%d/%m/%Y') as fecha_ingreso,
            TIME_FORMAT(tap_registrovisita.hora_ingreso, '%H:%i:%s') as hora_ingreso,
            DATE_FORMAT(tap_registrovisita.fecha_salida, '%d/%m/%Y') as fecha_salida,
            TIME_FORMAT(tap_registrovisita.hora_salida, '%H:%i:%s') as hora_salida,
            tap_registrovisita.usuario as usuario  
            FROM $tabla left join tap_funcionario  on 
            tap_registrovisita.idfuncionario=tap_funcionario.id 
            WHERE DATE_FORMAT(tap_registrovisita.fecha_ingreso, '%d/%m/%Y') LIKE '%$fechaInicial%' ORDER BY tap_registrovisita.id DESC");



            $stmt->execute();

            return $stmt->fetchAll();


        } else {
            /* var_dump("ELSE"); */
            //NOTA: CUANDO UN VARCHAR ESTA CONVERTIDO A DATE PUEDE 
            //ACEPTAR FORMATOS COMO DD/MM/YYY O DD-MM-YYYY
            //SIN PROBLEMAS EN EL FILTRADO, ES RECOMENDABLE 
            //CONVERTIR UN STRING EN DATE PARA QUE SEA MAS OPTIMO EL FILTRADO

            $stmt = Conexion::conectar()->prepare("SELECT tap_registrovisita.id as id,
            (SELECT tipo_documento FROM tap_tipodocumento WHERE id=tap_funcionario.idtipo_documento) as TipoDocF,    
            tap_funcionario.num_documento as num_documento,
            tap_funcionario.nombre as nombre,
            tap_funcionario.cargo as cargo,
            (SELECT entidad FROM tap_entidad WHERE id=tap_funcionario.identidad) as ent_funcionario,
            tap_registrovisita.motivo as motivo,
            tap_registrovisita.servidor_publico as servidor_publico,
            tap_registrovisita.area_oficina_sp as area_oficina_sp,
            tap_registrovisita.cargo as cargo,
            DATE_FORMAT(tap_registrovisita.fecha_ingreso, '%d/%m/%Y') as fecha_ingreso,
            TIME_FORMAT(tap_registrovisita.hora_ingreso, '%H:%i:%s') as hora_ingreso,
            DATE_FORMAT(tap_registrovisita.fecha_salida, '%d/%m/%Y') as fecha_salida,
            TIME_FORMAT(tap_registrovisita.hora_salida, '%H:%i:%s') as hora_salida,
            tap_registrovisita.usuario as usuario  
            FROM $tabla left join tap_funcionario  on 
            tap_registrovisita.idfuncionario=tap_funcionario.id 
            WHERE DATE(fecha_ingreso) BETWEEN '$fechaInicial' AND '$fechaFinal'
            ORDER BY tap_registrovisita.id DESC");

            $stmt->execute();

            return $stmt->fetchAll();
        }
    }

    /* =============================================
      MOSTRAR REGISTRO
      ============================================= */

    static public function mdlMostrarRegistro($tabla, $item, $valor)
    {
        //CAPTURAR DATOS PARA EL EDIT EN EL FORMULARIO
        if ($item != null) {

            $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item ORDER BY id DESC");

            $stmt->bindParam(":" . $item, $valor, PDO::PARAM_STR);

            $stmt->execute();

            return $stmt->fetch();
        } else {

            $stmt = Conexion::conectar()->prepare("SELECT tap_registrovisita.id as id,
            (SELECT tipo_documento FROM tap_tipodocumento WHERE id=tap_funcionario.idtipo_documento) as TipoDocF,    
            tap_funcionario.num_documento as num_documento,
            tap_funcionario.nombre as nombre,
            tap_funcionario.cargo as cargo,
            (SELECT entidad FROM tap_entidad WHERE id=tap_funcionario.identidad) as ent_funcionario,
            tap_registrovisita.motivo as motivo,
            tap_registrovisita.servidor_publico as servidor_publico,
            tap_registrovisita.area_oficina_sp as area_oficina_sp,
            tap_registrovisita.cargo as cargo,
            FORMAT(CONVERT(date,tap_registrovisita.fecha_ingreso),'dd/MM/yyyy') as fecha_ingreso,
			CONVERT(varchar(25), CAST(tap_registrovisita.hora_ingreso as TIME),100) as hora_ingreso,
            FORMAT(tap_registrovisita.fecha_salida,'dd/MM/yyyy') as fecha_salida,
            tap_registrovisita.hora_salida as hora_salida,
            tap_registrovisita.usuario as usuario  
            FROM $tabla left join tap_funcionario  on 
            tap_registrovisita.idfuncionario=tap_funcionario.id 
            ORDER BY tap_registrovisita.id DESC");

            $stmt->execute();

            return $stmt->fetchAll();
        }

        $stmt->close();

        $stmt = null;
    }

    /* =============================================
      MOSTRAR CANTIDAD DE VISITAS
      ============================================= */

    static public function mdlCantidadRegistros($tabla, $item, $valor)
    {
        //CAPTURAR DATOS PARA EL EDIT EN EL FORMULARIO
        if ($item != null) {

        } else {

            $stmt = Conexion::conectar()->prepare("SELECT count(*) AS CANTIDAD FROM $tabla");

            $stmt->execute();

            return $stmt->fetchAll();
        }

        $stmt->close();

        $stmt = null;
    }







    /* =============================================
      REGISTRO DE TICKET
      ============================================= */

    static public function mdlIngresarRegistro($tabla, $datos)
    {

        $stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(idfuncionario,
        motivo,servidor_publico,area_oficina_sp,cargo,fecha_ingreso,hora_ingreso,usuario)
        VALUES (:idfuncionario,:motivo,:servidor_publico,:area_oficina_sp,:cargo,
        :fecha_ingreso,:hora_ingreso,:usuario)");

        $stmt->bindParam(":idfuncionario", $datos["idfuncionario"], PDO::PARAM_INT);
        $stmt->bindParam(":motivo", $datos["motivo"], PDO::PARAM_STR);
        $stmt->bindParam(":servidor_publico", $datos["servidor_publico"], PDO::PARAM_STR);
        $stmt->bindParam(":area_oficina_sp", $datos["area_oficina_sp"], PDO::PARAM_STR);
        $stmt->bindParam(":cargo", $datos["cargo"], PDO::PARAM_STR);
        $stmt->bindParam(":fecha_ingreso", $datos["fecha_ingreso"], PDO::PARAM_STR);
        $stmt->bindParam(":hora_ingreso", $datos["hora_ingreso"], PDO::PARAM_STR);
        $stmt->bindParam(":usuario", $datos["usuario"], PDO::PARAM_STR);



        if ($stmt->execute()) {

            return "ok";
        } else {

            return "error";
        }

        $stmt->close();
        $stmt = null;
    }


    /* =============================================
      REGISTRO DE VISITAS CUANDO EL USUARIO ES NUEVO
      ============================================= */

    static public function mdlIngresarRegistroIngresarFuncionario($tabla, $datos)
    {

        $stmt1 = Conexion::conectar()->prepare("INSERT INTO tap_funcionario
        (idtipo_documento,num_documento,nombre,identidad,
        cargo,fecha_registro) 
        VALUES (:idtipo_documento,:num_documento,:nombre,:identidad,
        :cargo,SYSDATETIME())");


        $stmt1->bindParam(":idtipo_documento", $datos["idtipo_documento"], PDO::PARAM_INT);
        $stmt1->bindParam(":num_documento", $datos["num_documento"], PDO::PARAM_STR);
        $stmt1->bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
        $stmt1->bindParam(":identidad", $datos["identidad"], PDO::PARAM_INT);
        $stmt1->bindParam(":cargo", $datos["cargo"], PDO::PARAM_STR);


        $stmt1->execute();

        //OBTENER EL ULTIMO REGISTRO INSERTADO EN LA TABLA FUNCINCIONARIO
        $item2 = null;
        $valor2 = null;

        $ultimoRegistroFuncionario = ControladorFuncionario::ctrMostrarUltimoRegistroFuncionario($item2, $valor2);

        /* $ultimoRegistroFuncionario["num_documento"]; */
        foreach ($ultimoRegistroFuncionario as $key => $va) {
            $idfuncionario = $va["id"]; //ULTIMO REGISTRO 
        }


        $stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(idfuncionario,
          motivo,servidor_publico,area_oficina_sp,cargo,fecha_ingreso,hora_ingreso,usuario)
          VALUES ($idfuncionario,:motivo,:servidor_publico,:area_oficina_sp,:cargo,
          :fecha_ingreso,:hora_ingreso,:usuario)");


        $stmt->bindParam(":motivo", $datos["motivo"], PDO::PARAM_STR);
        $stmt->bindParam(":servidor_publico", $datos["servidor_publico"], PDO::PARAM_STR);
        $stmt->bindParam(":area_oficina_sp", $datos["area_oficina_sp"], PDO::PARAM_STR);
        $stmt->bindParam(":cargo", $datos["cargo"], PDO::PARAM_STR);
        $stmt->bindParam(":fecha_ingreso", $datos["fecha_ingreso"], PDO::PARAM_STR);
        $stmt->bindParam(":hora_ingreso", $datos["hora_ingreso"], PDO::PARAM_STR);
        $stmt->bindParam(":usuario", $datos["usuario"], PDO::PARAM_STR);



        if ($stmt->execute()) {

            return "ok";
        } else {

            return "error";
        }

        $stmt->close();
        $stmt = null;
    }

    /* =============================================
      EDITAR TICKET
      ============================================= */

    static public function mdlEditarRegistro($tabla, $datos)
    {

        $stmt = Conexion::conectar()->prepare("UPDATE $tabla SET fecha_salida=:fecha_salida,hora_salida=:hora_salida WHERE id = :id");

        $stmt->bindParam(":id", $datos["id"], PDO::PARAM_INT);
        $stmt->bindParam(":fecha_salida", $datos["fecha_salida"], PDO::PARAM_STR);
        $stmt->bindParam(":hora_salida", $datos["hora_salida"], PDO::PARAM_STR);

        if ($stmt->execute()) {

            return "ok";
        } else {

            return "error";
        }

        $stmt->close();
        $stmt = null;
    }

    /* =============================================
      BORRAR TICKET
      ============================================= */

    static public function mdlEliminarRegistro($tabla, $datos)
    {

        $stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE id = :id");

        $stmt->bindParam(":id", $datos, PDO::PARAM_INT);

        if ($stmt->execute()) {

            return "ok";
        } else {

            return "error";
        }

        $stmt->close();

        $stmt = null;
    }

    /* =============================================
      ACTUALIZAR TICKET
      ============================================= */

    static public function mdlActualizarRegistro($tabla, $item1, $valor1, $valor)
    {

        $stmt = Conexion::conectar()->prepare("UPDATE $tabla SET $item1 = :$item1 WHERE id = :id");

        $stmt->bindParam(":" . $item1, $valor1, PDO::PARAM_STR);
        $stmt->bindParam(":id", $valor, PDO::PARAM_STR);

        if ($stmt->execute()) {

            return "ok";
        } else {

            return "error";
        }

        $stmt->close();

        $stmt = null;
    }
}
