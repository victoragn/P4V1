$('.btnModifComment').each(function() {
    $(this).click( function() {
        var comment=$(this).parent().parent().children('.contentComment');
        $('<textarea class="textareaModifComment" name="modifComment"></textarea><button>Envoyer la modif</button>').insertAfter(comment);
        $('.textareaModifComment').val(comment.text());
        console.log(comment.text());
        comment.remove();
        $('.btnModifComment').remove();
    });
});
//var btnsModifComment = document.getElementsByClassName('btnModifComment');



/*var myFunction = function() {
    alert("Vous m'avez cliqué !");
};

element.addEventListener('click', myFunction);*/
