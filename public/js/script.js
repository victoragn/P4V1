$('.btnModifComment').each(function() {/*créer un bouton "modifier" à coté de chaque commentaire de l'utilisateur connecté*/
    $(this).click( function() {
        var comment=$(this).parents('.divComment').children('.contentComment');
        var idComment=$(this).parents('.divComment').attr('id').substr(10);/*récupère l'id de la div du commentaire pour récuperer l'id du commentaire en question*/
        $('<form action="index.php?action=updateComment&amp;commentId='+ idComment +'" method="post"><textarea class="textareaModifComment" name="modifComment"></textarea><button>Envoyer la modif</button></form>').insertAfter(comment);/*ajoute le commentaire en question dans une textarea avec un bouton pour envoyer la modif*/
        $('.textareaModifComment').val(comment.text());
        comment.remove();/*retire le commentaire*/
        $('.btnModifComment').remove();/*retire les autres boutons "modifier" et "supprimer" pour ne pas pouvoir changer plusieurs comment en meme temps*/
        $('.btnDeleteComment').remove();
    });
});

$('.btnDeleteComment').each(function() {/*créer un bouton "modifier" à coté de chaque commentaire de l'utilisateur connecté*/
    $(this).click( function() {
        var idComment=$(this).parents('.divComment').attr('id').substr(10);/*récupère l'id de la div du commentaire pour récuperer l'id du commentaire en question*/
        $('<div>Etes-vous sur de vouloir supprimer ce commentaire ? <button class="yesDelete">Oui</button><button class="noDelete">Non</button></div>').insertAfter(this);/*ajoute le commentaire en question dans une textarea avec un bouton pour envoyer la modif*/
        $('.yesDelete').click(function(){
            document.location.href=$(location).attr('href')+'&deleteComment='+idComment;
        });
        $('.noDelete').click(function(){
            document.location.href=$(location).attr('href');
        });
        $('.btnModifComment').remove();/*retire les autres boutons "modifier" et "supprimer" pour ne pas pouvoir changer plusieurs comment en meme temps*/
        $('.btnDeleteComment').remove();
    });
});

$('.btnDeletePost').each(function() {
    $(this).click( function() {
        var lignePost=$(this).parents('tr');
        var idPost=lignePost.attr('id').substr(4);
        $('<tr><td colspan="4">Etes-vous sur de vouloir supprimer cet article ? (Cela supprimera aussi tous les commentaires associés)<button class="yesDelete">Oui</button><button class="noDelete">Non</button></td></tr>').insertAfter(lignePost);
        $('.yesDelete').click(function(){
            document.location.href='index.php?action=deletePost&postId='+idPost;
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
        console.log(idPost);
        document.location.href='index.php?action=dashboard&page=modifPost&postId='+idPost;
    });
});

$('.btnModifPassUser').each(function() {
    $(this).click( function() {
        var ligneUser=$(this).parents('tr');
        var idUser=ligneUser.attr('id').substr(4);
        /*$('<tr><td colspan="5"><label for="password1">Mot de passe</label><input id="password_input1" type="password" name="password1"/><br /><label for="password2">Retapez le mot de passe</label><input id="password_input2" type="password" name="password2"/><br /><button class="validPassword">Oui</button></td></tr>').insertAfter(ligneUser);
        $('.validPassword').click(function(){
            document.location.href='index.php?action=dashboard&dashAction=updatePassword&userId='+idPost;
        });
        $('.btnModifPassUser').remove();
        $('.btnDeletePost').remove();*/
    });
});
