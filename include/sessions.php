<?php
session_start();

function Message(){
    if(isset($_SESSION["ErrorMessage"])){
        $Output = "<div class = \"alert alert-danger\">";
        /**
         * it is good practice to include the function of htmlentities when
         * you want to show something so that your html doesn't break
         */
        $Output.=htmlentities($_SESSION["ErrorMessage"]);
        $Output.="</div>";
        /**when open for first time, session should not display any message*/
        $_SESSION["ErrorMessage"] = null;
        return $Output;
    }
}

function DeleteMessage(){
    if(isset($_SESSION["DeletesMessage"])){
        $Output = "<div class = \"alert alert-warning\">";
        $Output.=htmlentities($_SESSION["DeletesMessage"]);
        $Output.="</div>";

        $_SESSION["DeletesMessage"] = null;
        return $Output;
    }
}

function SuccessMessage(){
    if(isset($_SESSION["SuccessMessage"])){
        $Output = "<div class = \"alert alert-success\">";
        $Output.=htmlentities($_SESSION["SuccessMessage"]);
        $Output.="</div>";

        $_SESSION["SuccessMessage"] = null;
        return $Output;
    }
}