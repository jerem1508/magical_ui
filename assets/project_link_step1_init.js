$(function(){
// Gestion de coches (survol + click)

    // Caché par défaut
    $(".hover_new_file_src_target").css("display", "none");
    $(".hover_exist_file_src_target").css("display", "none");
    
    // Nouveau fichier source
    new_file_src = false;
    $(".hover_new_file_src")
        .mouseover(function(){
            $(".hover_new_file_src_target").css("display", "inherit");
            if(!new_file_src){
                $(".hover_new_file_src_target").css("color", "#aaa");
            }
        })
        .mouseout(function(){
            if(!new_file_src){
                $(".hover_new_file_src_target").css("display", "none");
            }
        })
        .click(function(){
            new_file_src = true;
            exist_file_src = false;
            $(".hover_exist_file_src_target").css("display", "none");
            $(".hover_new_file_src_target").css("color", "#000");
        })
    ;

    // Fichier source existant
    exist_file_src = false;
    $(".hover_exist_file_src")
        .mouseover(function(){
            $(".hover_exist_file_src_target").css("display", "inherit");
            if(!exist_file_src){
                $(".hover_exist_file_src_target").css("color", "#aaa");
            }
        })
        .mouseout(function(){
            if(!exist_file_src){
                $(".hover_exist_file_src_target").css("display", "none");
            }
        })
        .click(function(){
            exist_file_src = true;
            new_file_src = false;
            $(".hover_new_file_src_target").css("display", "none");
            $(".hover_exist_file_src_target").css("color", "#000");
        })
    ;
});