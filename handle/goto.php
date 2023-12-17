<?php

require_once '../App.php';

if($request->hasGet("id") && $request->hasGet("name")){

    $id=$request->get("id");
    $name=$request->get("name");

    $stm=$conn->prepare("select *  from todo where `id`=:id");
    $stm->bindparam(":id",$id,PDO::PARAM_INT);
    $out = $stm->execute();


            if($out){
                $stm=$conn->prepare("update todo set `status`= (:status) where id=(:id)");
                $stm->bindparam(":id",$id,PDO::PARAM_INT);
                $stm->bindparam(":status",$name,PDO::PARAM_STR);
                $output=$stm->execute();
                    if($output){
                        $request->header("../index.php");
                    }else{
                        $request->header("../index.php"); 
                    }
       
            }else{
                $request->header("../index.php");
            }





}else{
    $request->header("../index.php");
}
