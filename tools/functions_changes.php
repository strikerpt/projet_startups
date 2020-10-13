<?php


echo '
//Initialiser les tableau pour afficher l\'avant et l\'après le clique sur le bouton
var arr_after = [];
var arr_before = [];

//Mettre le contenu dans le tableau (le contenu est dit dans les pages des changements)
arr_before = read(arr);

/*
Fonction "compare" qui sert à comparer les données d\'avant et d\'après sont 
différents, si c\'est le cas, un pop-up de confirmation va afficher les changements et 
demander si l\'utilisateur est d\'accord ou pas de poursuivre.

Cette fonction sert aussi à porter les paramètres "filename", "message" et "get".
"filename" est le nom du fichier php qui contient les requetes pour écrire dans la base de données
"message" est le message de fin qui est afficher sous forme de pop-up d\'alerte
"get" est la valeur qui est sur l\'url (normalement est un nom d\'entreprise ou d\'un titre template  
*/
function compare(arr_before, arr_after, filename, message, get)
{
    for (let i = 0; i < arr_before.length; i++) 
    {   
        
        if(arr_before[i][1] != arr_after[i][1])
        {
            //Supprimer les balises HTML pour l\'affichage des changements 
            var str_replaced_before = arr_before[i][1].replace(/<[^>]*>/g, "");
            var str_replaced_after = arr_after[i][1].replace(/<[^>]*>/g, "");

            //Pop-up de confirmation où sont affichés les changements
            var resultat = window.confirm(\'The changes are :\\n\\nBEFORE :\\n \\n\'+str_replaced_before+\'\\n\\nAFTER :\\n \\n\'+str_replaced_after+\'\\n\');
            
            //Si l\'utilisateur est d\'accord avec les changements (si oui = true)
            if (resultat == true)
            {
                //Ecriture des changements dans la base de données
                $.ajax
                ({  
                    //Chemin vers la page qui contient les requêtes SQL
                    url:"tools/"+filename,
                    method:"POST",
                    dataType:"text",
                    data: 
                    {
                        get : get,
                        name_field : arr_before[i][0],
                        changed_field : arr_after[i][1]
                    },

                    /*Si tout est bien se passé, il affiche un pop-up, en disant que les changements
                    ont été faits et il rafraîchit la page pour montrer à l\'utilisateur les changements*/
                    success:function(data)
                    {
                        alert(message);
                        setTimeout(function()
                        {
                            window.location.reload(1);
                        }, 0);
                    }
                });
                
            }          
        }
    }
}


//Permet de récupérer les données qui ont été écrit après le clique sur le bouton
function after_click()
{
    /*Mettre les données dans le tableau after et appeler la fonction compare en donnant
    les tableaux, le nom du fichier, le message de fin et le paramètre qui est dans l\'url*/
    arr_after = read(arr);
    compare(arr_before, arr_after, filename, message, get);
}


/*
Fonction qui permet de faire un tableau multi-dimension (plus d\'un paramètre par ligne), 
en allant chercher les valeurs par rapport aux id\'s qu\'on a initialiser sur la page des changements
*/
function read(arr) 
{
    //Initialiser un tableau vide pour mettre les valeurs des id\'s qu\'on a spécifier
    var arr_read =[];

    for (let i = 0; i < arr.length; i++) 
    {
        /*
        arr_read.push permet d\'ajouter au tableau vide, les id\'s et les valeurs des id\'s.
        Les valeurs des id\'s sont récupérés par le document.getElementByID().value
        */
        arr_read.push([arr[i], document.getElementById(arr[i]).value]);
        
    }
    //Faire un return du tableau pour l\'utiliser ailleurs de la fonction
    return arr_read; 
    
}';

?>