$('.btnModifComment').each(function() {/*créer un bouton "modifier" à coté de chaque commentaire de l'utilisateur connecté*/
    $(this).click( function() {
        var comment=$(this).parent().parent().children('.contentComment');
        var idComment=$(this).parent().parent().attr('id').substr(10);/*récupère l'id de la div du commentaire pour récuperer l'id du commentaire en question*/
        $('<form action="index.php?action=updateComment&amp;commentId='+ idComment +'" method="post"><textarea class="textareaModifComment" name="modifComment"></textarea><button>Envoyer la modif</button></form>').insertAfter(comment);/*ajoute le commentaire en question dans une textarea avec un bouton pour envoyer la modif*/
        $('.textareaModifComment').val(comment.text());
        comment.remove();/*retire le commentaire*/
        $('.btnModifComment').remove();/*retire les autres boutons "modifier" pour ne pas pouvoir changer plusieurs comment en meme temps*/

    });
});
