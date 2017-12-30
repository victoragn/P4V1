$('.btnModifComment').each(function() {/*créer un bouton "modifier" à coté de chaque commentaire de l'utilisateur connecté*/
    $(this).click( function() {
        var comment=$(this).parents('.divComment').children('.contentComment');
        var idComment=$(this).parents('.divComment').attr('id').substr(10);/*récupère l'id de la div du commentaire pour récuperer l'id du commentaire en question*/
        $('<form action="index.php?action=updateComment&amp;commentId='+ idComment +'" method="post"><textarea class="textareaModifComment" name="modifComment"></textarea><button class="frontBtn">Envoyer la modif</button></form>').insertAfter(comment);/*ajoute le commentaire en question dans une textarea avec un bouton pour envoyer la modif*/
        $('.textareaModifComment').val(comment.text());
        comment.remove();/*retire le commentaire*/
        $('.btnModifComment').remove();/*retire les autres boutons "modifier" et "supprimer" pour ne pas pouvoir changer plusieurs comment en meme temps*/
        $('.btnDeleteComment').remove();
    });
});

$('.btnDeleteComment').each(function() {/*créer un bouton "modifier" à coté de chaque commentaire de l'utilisateur connecté*/
    $(this).click( function() {
        var idComment=$(this).parents('.divComment').attr('id').substr(10);/*récupère l'id de la div du commentaire pour récuperer l'id du commentaire en question*/
        $('<div>Etes-vous sur de vouloir supprimer ce commentaire ? <button class="frontBtn yesDelete">Oui</button><button class="frontBtn noDelete">Non</button></div>').insertAfter(this);/*ajoute le commentaire en question dans une textarea avec un bouton pour envoyer la modif*/
        $('.yesDelete').click(function(){
            document.location.href=$(location).attr('href').split('#')[0]+'&deleteComment='+idComment+'#comments';
        });
        $('.noDelete').click(function(){
            document.location.href=$(location).attr('href').split('#')[0]+'#comments';
            location.reload();
        });
        $('.btnModifComment').remove();/*retire les autres boutons "modifier" et "supprimer" pour ne pas pouvoir changer plusieurs comment en meme temps*/
        $('.btnDeleteComment').remove();
    });
});

$('.btnDeletePost').each(function() {
    $(this).click( function() {
        var lignePost=$(this).parents('tr');
        var idPost=lignePost.attr('id').substr(4);
        $('<tr><td colspan="4">Etes-vous sur de vouloir supprimer cet article ? (Cela supprimera aussi tous les commentaires associés)<button class="frontBtn yesDelete">Oui</button><button class="frontBtn noDelete">Non</button></td></tr>').insertAfter(lignePost);
        $('.yesDelete').click(function(){
            document.location.href='index.php?action=dashboard&deletePost=true&postId='+idPost;
        });
        $('.noDelete').click(function(){
            document.location.href=$(location).attr('href');
        });
        $('.btnModifPost').remove();
        $('.btnDeletePost').remove();
    });
});

$('.btnModifPost').each(function() {
    $(this).click( function() {
        var lignePost=$(this).parents('tr');
        var idPost=lignePost.attr('id').substr(4);
        document.location.href='index.php?action=dashboard&page=modifPost&postId='+idPost;
    });
});

$('.btnSupprSignComment').each(function() {
    $(this).click( function() {
        var ligneComment=$(this).parents('tr');
        var idComment=ligneComment.attr('id').substr(11);
        $('<div>Etes-vous sur de vouloir supprimer ce commentaire ? <button class="frontBtn yesDelete">Oui</button><button class="frontBtn noDelete">Non</button></div>').insertAfter(this);/*ajoute le commentaire en question dans une textarea avec un bouton pour envoyer la modif*/
        $('.yesDelete').click(function(){
            document.location.href=$(location).attr('href')+'&deleteComment='+idComment;
        });
        $('.noDelete').click(function(){
            document.location.href=$(location).attr('href');
        });
        $('.btnSupprSignComment').remove();
    });
});


